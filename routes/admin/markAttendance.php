<?php
/**
 * markAttendance.php
 * POST endpoint for QR / manual attendance marking.
 *
 * Expects JSON body: { "reg_no": "...", "event_name": "..." }
 * Returns JSON: { "status": "ok|already|not_found", "name": "...", "house": "..." }
 *
 * Attendance is event-wide — the student's house is returned for display only.
 */
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

// ── Only accept POST ──────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

// ── Parse JSON body ───────────────────────────────────────────────────────────
$body       = json_decode(file_get_contents('php://input'), true);
$reg_no     = trim($body['reg_no']     ?? '');
$event_name = trim($body['event_name'] ?? '');

if (!$reg_no || !$event_name) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing reg_no or event_name']);
    exit;
}

// ── DB connection ─────────────────────────────────────────────────────────────
include('../connect.php');

// ── Look up by reg_no + event_name only (house is view-only on the frontend) ──
$stmt = mysqli_prepare($conn,
    "SELECT id, student_name, student_house, attendance
     FROM registerationdb
     WHERE reg_no = ? AND event_name = ?
     LIMIT 1"
);
mysqli_stmt_bind_param($stmt, 'ss', $reg_no, $event_name);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$row) {
    echo json_encode(['status' => 'not_found', 'message' => 'Not registered for this event']);
    exit;
}

$name  = $row['student_name']  ?? $reg_no;
$house = $row['student_house'] ?? '';

if ((int)$row['attendance'] === 1) {
    echo json_encode([
        'status'  => 'already',
        'message' => 'Already marked present',
        'name'    => $name,
        'house'   => $house
    ]);
    exit;
}

// ── Mark attendance ───────────────────────────────────────────────────────────
$upd = mysqli_prepare($conn, "UPDATE registerationdb SET attendance = 1 WHERE id = ?");
mysqli_stmt_bind_param($upd, 'i', $row['id']);
mysqli_stmt_execute($upd);
$affected = mysqli_stmt_affected_rows($upd);
mysqli_stmt_close($upd);

mysqli_close($conn);

if ($affected > 0) {
    echo json_encode([
        'status'  => 'ok',
        'message' => 'Attendance marked',
        'name'    => $name,
        'house'   => $house
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'DB update failed']);
}
