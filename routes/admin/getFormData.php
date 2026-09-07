<?php
header('Content-Type: application/json');
require_once('../connect.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'get_event') {
    $event_name = isset($_GET['name']) ? trim($_GET['name']) : '';
    if (empty($event_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Event name is required']);
        exit;
    }

    $stmt = mysqli_prepare($conn, "SELECT * FROM eventdb WHERE event_name = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $event_name);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($res)) {
            echo json_encode(['status' => 'success', 'data' => $row]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Event not found']);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
    exit;
}

if ($action === 'get_coordinator') {
    $event_name = isset($_GET['event']) ? trim($_GET['event']) : '';
    if (empty($event_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Event name is required']);
        exit;
    }

    $stmt = mysqli_prepare($conn, "SELECT id, name, dept, reg_no FROM admindb WHERE event_name = ? AND role = 'event coordinator' ORDER BY id ASC");
    $coordinators = [];
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $event_name);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($res)) {
            $coordinators[] = $row;
        }
        mysqli_stmt_close($stmt);
    }

    // Fallback to event_cordinators field in eventdb if admindb has no rows yet
    if (empty($coordinators)) {
        $ev_stmt = mysqli_prepare($conn, "SELECT event_cordinators FROM eventdb WHERE event_name = ? LIMIT 1");
        if ($ev_stmt) {
            mysqli_stmt_bind_param($ev_stmt, "s", $event_name);
            mysqli_stmt_execute($ev_stmt);
            $ev_res = mysqli_stmt_get_result($ev_stmt);
            if ($ev_row = mysqli_fetch_assoc($ev_res)) {
                $parts = explode('|', $ev_row['event_cordinators']);
                if (!empty($parts[0])) $coordinators[] = ['name' => trim($parts[0]), 'dept' => '', 'reg_no' => ''];
                if (!empty($parts[1])) $coordinators[] = ['name' => trim($parts[1]), 'dept' => '', 'reg_no' => ''];
            }
            mysqli_stmt_close($ev_stmt);
        }
    }

    echo json_encode([
        'status' => 'success',
        'coordinator_1' => isset($coordinators[0]) ? $coordinators[0] : null,
        'coordinator_2' => isset($coordinators[1]) ? $coordinators[1] : null
    ]);
    exit;
}

if ($action === 'filter_students') {
    $year   = isset($_GET['year']) ? trim($_GET['year']) : '';
    $dept   = isset($_GET['dept']) ? trim($_GET['dept']) : '';
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    $where  = [];
    $params = [];
    $types  = '';

    if (!empty($year)) {
        $where[] = "year = ?";
        $params[] = $year;
        $types .= 's';
    }
    if (!empty($dept)) {
        $where[] = "dept = ?";
        $params[] = $dept;
        $types .= 's';
    }
    if (!empty($search)) {
        $where[] = "(name LIKE ? OR reg_no LIKE ?)";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $types .= 'ss';
    }

    $sql = "SELECT id, name, reg_no, dept, year, house, gender FROM studentdb";
    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $sql .= " ORDER BY name ASC LIMIT 100";

    $stmt = mysqli_prepare($conn, $sql);
    $students = [];
    if ($stmt) {
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($res)) {
            $students[] = $row;
        }
        mysqli_stmt_close($stmt);
    }

    echo json_encode(['status' => 'success', 'students' => $students]);
    exit;
}

if ($action === 'get_house_leads') {
    $house_name = isset($_GET['house']) ? trim($_GET['house']) : '';
    if (empty($house_name)) {
        echo json_encode(['status' => 'error', 'message' => 'House name is required']);
        exit;
    }

    $stmt = mysqli_prepare($conn, "SELECT id, name, dept, reg_no, role FROM admindb WHERE house_name = ? AND role = 'team captain' ORDER BY id ASC");
    $captains = [];

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $house_name);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($res)) {
            $captains[] = $row;
        }
        mysqli_stmt_close($stmt);
    }

    echo json_encode([
        'status' => 'success',
        'captain' => isset($captains[0]) ? $captains[0] : null,
        'vice_captain' => isset($captains[1]) ? $captains[1] : null
    ]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>
