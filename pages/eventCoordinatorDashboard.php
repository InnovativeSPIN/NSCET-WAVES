<?php
include('../routes/connect.php');
session_start();
$eventName = $_SESSION['event_name'] ?? ($_GET['event'] ?? '');
$role      = $_SESSION['role'] ?? '';

// ── Fetch full event details from DB ──────────────────────────────────────────
$stmt = mysqli_prepare($conn, "SELECT * FROM eventdb WHERE event_name = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 's', $eventName);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data   = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$eventGender    = $data['gender']          ?? 'COMMON'; // BOYS | GIRLS | COMMON
$isGroup        = (int)($data['is_group']  ?? 0);
$groupCounts    = (int)($data['group_counts'] ?? 1);
$eventDate      = $data['event_date']      ?? '';
$eventTime      = $data['event_time']      ?? '';
$eventVenue     = $data['event_venue']     ?? '';
$eventType      = $data['event_type']      ?? '';
$eventImage     = $data['image']           ?? '';

// ── Fetch houses filtered by event gender ────────────────────────────────────
if ($eventGender === 'COMMON') {
    $houseResult = mysqli_query($conn, "SELECT * FROM housedb ORDER BY gender, name");
} else {
    $stmt2 = mysqli_prepare($conn, "SELECT * FROM housedb WHERE gender = ? ORDER BY name");
    mysqli_stmt_bind_param($stmt2, 's', $eventGender);
    mysqli_stmt_execute($stmt2);
    $houseResult = mysqli_stmt_get_result($stmt2);
}
$houses = [];
while ($h = mysqli_fetch_assoc($houseResult)) {
    $houses[] = $h;
}

// ── Build participants data ───────────────────────────────────────────────────
$eventData = ['event' => ['is_group' => (string)$isGroup, 'group_counts' => (string)$groupCounts]];

if ($isGroup == 0) {
    $pStmt = mysqli_prepare($conn, "SELECT * FROM registerationdb WHERE event_name = ?");
    mysqli_stmt_bind_param($pStmt, 's', $eventName);
    mysqli_stmt_execute($pStmt);
    $pResult = mysqli_stmt_get_result($pStmt);
    $participants = [];
    while ($list = mysqli_fetch_assoc($pResult)) {
        $rn = $list['reg_no'];
        $sRes  = mysqli_prepare($conn, "SELECT slot FROM allotmentdb WHERE event = ? AND reg_no = ? LIMIT 1");
        mysqli_stmt_bind_param($sRes, 'ss', $eventName, $rn);
        mysqli_stmt_execute($sRes);
        $sRow  = mysqli_fetch_assoc(mysqli_stmt_get_result($sRes));
        $participants[] = [
            'reg_no'        => $list['reg_no'],
            'student_name'  => $list['student_name'],
            'student_dept'  => $list['student_dept'],
            'student_house' => $list['student_house'],
            'gender'        => $list['gender'] ?? '',
            'slot'          => $sRow ? $sRow['slot'] : '',
            'attendance'    => (int)($list['attendance'] ?? 0)
        ];
    }
    $eventData['participants'] = $participants;
} else {
    $eventData['groups'] = [];
    for ($i = 1; $i <= $groupCounts; $i++) {
        $pStmt = mysqli_prepare($conn, "SELECT * FROM registerationdb WHERE event_name = ? AND grouped = ?");
        mysqli_stmt_bind_param($pStmt, 'si', $eventName, $i);
        mysqli_stmt_execute($pStmt);
        $pResult = mysqli_stmt_get_result($pStmt);
        $participants = [];
        while ($list = mysqli_fetch_assoc($pResult)) {
            $participants[] = [
                'reg_no'        => $list['reg_no'],
                'student_name'  => $list['student_name'],
                'student_dept'  => $list['student_dept'],
                'student_house' => $list['student_house'],
                'gender'        => $list['gender'] ?? '',
                'attendance'    => (int)($list['attendance'] ?? 0)
            ];
        }
        // fetch allotment slots
        $aStmt = mysqli_prepare($conn, "SELECT house, slot FROM allotmentdb WHERE event = ? AND grouped = ?");
        mysqli_stmt_bind_param($aStmt, 'si', $eventName, $i);
        mysqli_stmt_execute($aStmt);
        $aResult = mysqli_stmt_get_result($aStmt);
        $slots = [];
        while ($ar = mysqli_fetch_assoc($aResult)) { $slots[$ar['house']] = $ar['slot']; }
        foreach ($participants as &$p) {
            $p['slot'] = $slots[$p['student_house']] ?? '';
        }
        unset($p);
        $eventData['groups'][] = ['group_number' => $i, 'participants' => $participants];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Coordinator | <?= htmlspecialchars($eventName) ?></title>
    <link rel="icon" type="image/png" href="../public/images/logos/waves-logo.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/premium-dashboard.css">
    <script src="https://kit.fontawesome.com/5fe2f4c2ef.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --bg-deep:    #0d0f1e;
            --bg-card:    #141629;
            --bg-glass:   rgba(255,255,255,0.04);
            --border:     rgba(255,255,255,0.08);
            --accent:     #00e5ff;
            --accent2:    #bf6bff;
            --accent-gold:#ffd166;
            --text-main:  #e8eaf6;
            --text-muted: #7986a8;
            --boys-color: #4fc3f7;
            --girls-color:#f48fb1;
            --common-color:#a5d6a7;
            --radius:     16px;
            --transition: 0.3s cubic-bezier(.4,0,.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            background: var(--bg-deep);
            font-family: 'Outfit', sans-serif;
            color: var(--text-main);
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .coord-navbar {
            background: rgba(13,15,30,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .coord-navbar .brand img { height: 42px; }
        .nav-actions { display: flex; gap: 10px; align-items: center; }
        .btn-nav {
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            color: var(--text-main);
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-nav:hover {
            background: rgba(0,229,255,0.12);
            border-color: var(--accent);
            color: var(--accent);
            text-decoration: none;
        }
        .btn-nav.danger:hover {
            background: rgba(255,82,82,0.12);
            border-color: #ff5252;
            color: #ff5252;
        }

        /* ── EVENT HERO BANNER ── */
        .event-hero {
            position: relative;
            margin: 24px 24px 0;
            border-radius: var(--radius);
            overflow: hidden;
            min-height: 160px;
            display: flex;
            align-items: flex-end;
            background: var(--bg-card);
            border: 1px solid var(--border);
        }
        .event-hero-bg {
            position: absolute; inset: 0;
            background-size: cover;
            background-position: center;
            filter: blur(2px) brightness(0.35);
        }
        .event-hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(0,229,255,0.12), rgba(191,107,255,0.08));
        }
        .event-hero-content {
            position: relative;
            z-index: 2;
            padding: 24px 32px;
            width: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }
        .event-title-area h1 {
            font-size: 1.7rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 6px;
            text-shadow: 0 2px 12px rgba(0,0,0,0.5);
        }
        .event-meta-chips { display: flex; gap: 8px; flex-wrap: wrap; }
        .meta-chip {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--text-main);
        }
        .meta-chip.boys   { border-color: var(--boys-color);   color: var(--boys-color); }
        .meta-chip.girls  { border-color: var(--girls-color);  color: var(--girls-color); }
        .meta-chip.common { border-color: var(--common-color); color: var(--common-color); }
        .meta-chip.stage  { border-color: var(--accent2); color: var(--accent2); }
        .meta-chip.gold   { border-color: var(--accent-gold); color: var(--accent-gold); }

        /* ── MAIN CONTENT ── */
        .coord-container { padding: 24px; }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .section-header h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-header h2 i { color: var(--accent); }
        .participant-count {
            background: rgba(0,229,255,0.1);
            border: 1px solid rgba(0,229,255,0.3);
            color: var(--accent);
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* ── HOUSES GRID (2 ROWS) ── */
        .houses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 14px;
            margin-bottom: 32px;
        }

        .house-card {
            background: var(--bg-glass);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            text-align: center;
            min-height: 110px;
            justify-content: center;
        }
        .house-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 60%, rgba(0,229,255,0.05));
            opacity: 0;
            transition: var(--transition);
        }
        .house-card:hover::before { opacity: 1; }
        .house-card:hover {
            border-color: var(--accent);
            transform: translateY(-3px);
            box-shadow: 0 8px 32px rgba(0,229,255,0.12);
        }
        .house-card.active {
            border-color: var(--accent);
            background: rgba(0,229,255,0.08);
            box-shadow: 0 0 0 1px var(--accent), 0 8px 32px rgba(0,229,255,0.15);
        }
        .house-card.active::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            border-radius: var(--radius) var(--radius) 0 0;
        }
        .house-card.girls-card:hover, .house-card.girls-card.active {
            border-color: var(--girls-color);
            background: rgba(244,143,177,0.08);
            box-shadow: 0 0 0 1px var(--girls-color), 0 8px 32px rgba(244,143,177,0.15);
        }
        .house-card.girls-card.active::after {
            background: linear-gradient(90deg, var(--girls-color), #ce93d8);
        }
        .house-img {
            width: 48px;
            height: 48px;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.4));
        }
        .house-name {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            color: var(--text-main);
            line-height: 1.2;
        }
        .house-count {
            font-size: 0.7rem;
            color: var(--text-muted);
            background: rgba(255,255,255,0.06);
            border-radius: 20px;
            padding: 2px 10px;
        }
        .house-gender-badge {
            position: absolute;
            top: 8px; right: 8px;
            font-size: 0.6rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 10px;
            letter-spacing: 0.05em;
        }
        .gender-boys  { background: rgba(79,195,247,0.2); color: var(--boys-color); }
        .gender-girls { background: rgba(244,143,177,0.2); color: var(--girls-color); }

        /* ── PARTICIPANTS PANEL ── */
        .participants-panel {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            animation: slideUp 0.3s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .panel-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255,255,255,0.02);
            flex-wrap: wrap;
            gap: 10px;
        }
        .panel-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .panel-house-img {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }
        .panel-title {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-main);
        }
        .panel-subtitle {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin: 0;
        }
        .panel-body { padding: 0; }

        /* Group header within panel */
        .group-header {
            padding: 12px 24px;
            background: rgba(191,107,255,0.06);
            border-bottom: 1px solid var(--border);
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--accent2);
            letter-spacing: 0.06em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── PREMIUM TABLE ── */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0;
            border: none;
        }
        .part-table { width: 100%; border-collapse: collapse; }
        .th-short { display: none; }
        .th-full  { display: inline; }
        .part-table thead tr {
            background: rgba(255,255,255,0.04);
        }
        .part-table thead th {
            padding: 12px 16px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            text-transform: uppercase;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .part-table tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.04);
            transition: background var(--transition);
        }
        .part-table tbody tr:hover { background: rgba(255,255,255,0.03); }
        .part-table tbody tr:last-child { border-bottom: none; }
        .part-table td {
            padding: 13px 16px;
            font-size: 0.85rem;
            color: var(--text-main);
            vertical-align: middle;
        }
        .reg-badge {
            font-family: 'Courier New', monospace;
            background: rgba(0,229,255,0.08);
            border: 1px solid rgba(0,229,255,0.2);
            color: var(--accent);
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 0.78rem;
            font-weight: 600;
        }
        .dept-badge {
            background: rgba(191,107,255,0.1);
            border: 1px solid rgba(191,107,255,0.2);
            color: var(--accent2);
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .slot-badge {
            background: rgba(255,209,102,0.1);
            border: 1px solid rgba(255,209,102,0.25);
            color: var(--accent-gold);
            border-radius: 6px;
            padding: 2px 10px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .slot-empty {
            color: var(--text-muted);
            font-size: 0.8rem;
        }
        .sno-cell {
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 600;
            width: 50px;
        }

        .empty-state {
            padding: 48px 24px;
            text-align: center;
            color: var(--text-muted);
        }
        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            opacity: 0.4;
            display: block;
        }
        .empty-state p { font-size: 0.9rem; margin: 0; }

        /* ── MODAL ── */
        .modal-content {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }
        .modal-header {
            border-bottom: 1px solid var(--border);
            padding: 20px 24px;
        }
        .modal-header h5 { font-weight: 700; color: var(--text-main); }
        .modal-body { padding: 24px; }
        .modal-footer {
            border-top: 1px solid var(--border);
            padding: 16px 24px;
        }
        .form-control {
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            color: var(--text-main);
            border-radius: 10px;
            padding: 10px 14px;
        }
        .form-control:focus {
            background: rgba(0,229,255,0.05);
            border-color: var(--accent);
            color: var(--text-main);
            box-shadow: 0 0 0 3px rgba(0,229,255,0.1);
            outline: none;
        }
        .form-label { font-size: 0.82rem; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; }
        .btn-accent {
            background: linear-gradient(135deg, var(--accent), #0099cc);
            color: #000;
            border: none;
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition);
        }
        .btn-accent:hover { opacity: 0.88; transform: translateY(-1px); }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.12); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(0,229,255,0.3); }

        /* ── TWO-COLUMN PAGE LAYOUT ── */
        .page-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 0;
            min-height: calc(100vh - 64px);
        }
        .left-col {
            flex: 1 1 0;
            min-width: 0;
        }
        .right-col {
            width: 340px;
            flex-shrink: 0;
            position: sticky;
            top: 64px;
            height: calc(100vh - 64px);
            overflow-y: auto;
            padding: 24px 20px 24px 4px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* ── QR SCANNER PANEL ── */
        .qr-panel {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }
        .qr-panel-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(0,229,255,0.04);
        }
        .qr-panel-header h3 {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
        }
        .qr-panel-header i { color: var(--accent); font-size: 1rem; }
        .qr-panel-body { padding: 16px; }

        #qr-reader {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--border);
            background: #000;
            width: 100% !important;
            max-width: 100% !important;
        }
        #qr-reader video {
            border-radius: 10px;
            max-width: 100% !important;
            height: auto !important;
        }
        #qr-reader canvas {
            max-width: 100% !important;
        }
        /* Override html5-qrcode default white box */
        #qr-reader__scan_region { background: transparent !important; }
        #qr-reader__dashboard { background: transparent !important; padding: 6px 0 0 !important; }
        #qr-reader__dashboard_section_csr button {
            background: rgba(0,229,255,0.15) !important;
            border: 1px solid var(--accent) !important;
            color: var(--accent) !important;
            border-radius: 8px !important;
            padding: 6px 14px !important;
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            cursor: pointer;
        }
        #qr-reader__dashboard_section_fsr span,
        #qr-reader__status_span {
            color: var(--text-muted) !important;
            font-size: 0.75rem !important;
            font-family: 'Outfit', sans-serif !important;
        }
        select#qr-reader__camera_selection {
            background: rgba(255,255,255,0.06) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-main) !important;
            border-radius: 8px !important;
            padding: 5px 10px !important;
            font-size: 0.8rem !important;
            width: 100% !important;
            margin-bottom: 6px !important;
        }
        .qr-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 14px 0;
            color: var(--text-muted);
            font-size: 0.75rem;
        }
        .qr-divider::before, .qr-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .manual-row {
            display: flex;
            gap: 8px;
        }
        .manual-row input {
            flex: 1;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            color: var(--text-main);
            border-radius: 10px;
            padding: 9px 12px;
            font-size: 0.82rem;
            font-family: 'Outfit', sans-serif;
            transition: var(--transition);
        }
        .manual-row input:focus {
            border-color: var(--accent);
            outline: none;
            background: rgba(0,229,255,0.05);
        }
        .btn-mark {
            background: linear-gradient(135deg, var(--accent), #0099cc);
            color: #000;
            border: none;
            border-radius: 10px;
            padding: 9px 16px;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: var(--transition);
            font-family: 'Outfit', sans-serif;
        }
        .btn-mark:hover { opacity: 0.85; transform: translateY(-1px); }
        .btn-mark:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

        /* Feedback */
        .qr-feedback {
            margin-top: 12px;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.83rem;
            font-weight: 600;
            display: none;
            align-items: center;
            gap: 10px;
            line-height: 1.4;
        }
        .qr-feedback.show { display: flex; animation: fadeIn 0.25s ease; }
        .qr-feedback.success { background: rgba(38,211,120,0.12); border: 1px solid rgba(38,211,120,0.3); color: #26d378; }
        .qr-feedback.warning { background: rgba(255,180,0,0.1);  border: 1px solid rgba(255,180,0,0.3);  color: #ffb400; }
        .qr-feedback.error   { background: rgba(255,82,82,0.1);  border: 1px solid rgba(255,82,82,0.3);  color: #ff5252; }
        .qr-feedback i { font-size: 1.1rem; flex-shrink: 0; }
        @keyframes fadeIn { from { opacity:0; transform: translateY(4px); } to { opacity:1; transform: translateY(0); } }

        /* Stats */
        .attend-stats {
            display: flex;
            gap: 10px;
        }
        .stat-box {
            flex: 1;
            background: var(--bg-glass);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px;
            text-align: center;
        }
        .stat-box .stat-num {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-box .stat-label { font-size: 0.7rem; color: var(--text-muted); font-weight: 500; letter-spacing: 0.04em; }
        .stat-present .stat-num { color: #26d378; }
        .stat-absent  .stat-num { color: var(--text-muted); }
        .stat-total   .stat-num { color: var(--accent); }

        /* Attendance badge in table */
        .att-present { background: rgba(38,211,120,0.12); border: 1px solid rgba(38,211,120,0.3); color: #26d378; border-radius: 6px; padding: 2px 10px; font-size: 0.72rem; font-weight: 700; }
        .att-absent  { background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: var(--text-muted); border-radius: 6px; padding: 2px 10px; font-size: 0.72rem; font-weight: 700; }

        /* ═══════════════════════════════════════════════════════════
           RESPONSIVE BREAKPOINTS
           ═══════════════════════════════════════════════════════════ */

        /* ── Large Tablet / Small Laptop (max 1100px) ── */
        @media (max-width: 1100px) {
            .right-col {
                width: 310px;
                padding: 20px 16px 20px 4px;
            }
            .houses-grid {
                grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
                gap: 12px;
            }
            .event-hero {
                margin: 20px 20px 0;
            }
            .coord-container {
                padding: 20px;
            }
        }

        /* ── Tablet Portrait / Medium Screens (max 900px) ── */
        @media (max-width: 900px) {
            .page-wrapper {
                flex-direction: column;
            }
            .left-col {
                width: 100%;
                min-width: 0;
            }
            .right-col {
                width: 100%;
                position: static;
                height: auto;
                padding: 0 20px 28px 20px;
                overflow-y: visible;
            }
            .event-hero {
                margin: 16px 16px 0;
            }
            .event-hero-content {
                padding: 20px 24px;
            }
            .coord-container {
                padding: 20px 16px;
            }
            .houses-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 12px;
                margin-bottom: 24px;
            }
        }

        /* ── Phablet / Mobile Landscape (max 768px) ── */
        @media (max-width: 768px) {
            .coord-navbar {
                padding: 8px 16px;
            }
            .coord-navbar .brand img {
                height: 36px;
            }
            .btn-nav {
                padding: 7px 12px;
                font-size: 0.8rem;
                gap: 5px;
            }
            .event-hero {
                margin: 14px 14px 0;
                min-height: 140px;
            }
            .event-hero-content {
                padding: 16px 18px;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .event-title-area h1 {
                font-size: 1.35rem;
                margin-bottom: 4px;
            }
            .coord-container {
                padding: 16px 14px;
            }
            .right-col {
                padding: 0 14px 24px 14px;
            }
            .houses-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 10px;
            }
            .house-card {
                padding: 12px 8px;
                min-height: 94px;
            }
            .house-img {
                width: 40px;
                height: 40px;
            }
            .house-name {
                font-size: 0.74rem;
            }
            .panel-header {
                padding: 14px 16px;
            }
            .panel-title {
                font-size: 0.95rem;
            }
            .th-full { display: none; }
            .th-short { display: inline; }
            .part-table thead th {
                padding: 8px 6px;
                font-size: 0.68rem;
            }
            .part-table td {
                padding: 8px 6px;
                font-size: 0.76rem;
            }
        }

        /* ── Standard Mobile (max 576px) ── */
        @media (max-width: 576px) {
            .coord-navbar {
                padding: 8px 12px;
            }
            .coord-navbar .brand img {
                height: 32px;
            }
            .nav-actions {
                gap: 6px;
            }
            .nav-btn-text {
                display: none;
            }
            .btn-nav {
                padding: 8px 11px;
                font-size: 0.85rem;
                border-radius: 8px;
            }
            .event-hero {
                margin: 10px 10px 0;
                border-radius: 12px;
                min-height: 120px;
            }
            .event-hero-content {
                padding: 14px;
                gap: 10px;
            }
            .event-title-area h1 {
                font-size: 1.2rem;
            }
            .meta-chip {
                font-size: 0.7rem;
                padding: 3px 8px;
                border-radius: 14px;
            }
            .coord-container {
                padding: 12px 6px;
            }
            .section-header {
                margin-bottom: 12px;
            }
            .section-header h2 {
                font-size: 0.98rem;
                gap: 8px;
            }
            .participant-count {
                font-size: 0.72rem;
                padding: 2px 10px;
            }
            .houses-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
                margin-bottom: 20px;
            }
            .house-card {
                padding: 10px 6px;
                min-height: 88px;
                gap: 6px;
                border-radius: 12px;
            }
            .house-img {
                width: 36px;
                height: 36px;
            }
            .house-name {
                font-size: 0.72rem;
                line-height: 1.15;
            }
            .house-count {
                font-size: 0.65rem;
                padding: 2px 8px;
            }
            .house-gender-badge {
                font-size: 0.54rem;
                padding: 1px 5px;
                top: 5px;
                right: 5px;
            }
            .participants-panel {
                border-radius: 12px;
            }
            .panel-header {
                padding: 12px 14px;
                gap: 8px;
            }
            .panel-header-left {
                gap: 8px;
            }
            .panel-house-img {
                width: 28px;
                height: 28px;
            }
            .panel-title {
                font-size: 0.9rem;
            }
            .panel-subtitle {
                font-size: 0.68rem;
            }
            .group-header {
                padding: 8px 14px;
                font-size: 0.74rem;
            }
            .th-full { display: none; }
            .th-short { display: inline; }
            .part-table {
                min-width: 0 !important;
                width: 100% !important;
                table-layout: auto;
            }
            .part-table thead th {
                padding: 6px 3px !important;
                font-size: 0.64rem !important;
                letter-spacing: 0.01em;
            }
            .part-table td {
                padding: 6px 3px !important;
                font-size: 0.72rem !important;
            }
            .col-sno, .sno-cell {
                width: 16px !important;
                padding: 6px 2px !important;
                text-align: center;
                font-size: 0.7rem !important;
            }
            .col-reg, .reg-cell {
                padding: 6px 2px !important;
            }
            .reg-badge {
                font-size: 0.65rem !important;
                padding: 2px 3px !important;
                letter-spacing: -0.3px;
                white-space: nowrap;
            }
            .col-name, .name-cell {
                padding: 6px 3px !important;
                font-size: 0.72rem !important;
                font-weight: 600;
                line-height: 1.15;
                word-break: break-word;
            }
            .col-dept, .dept-cell {
                padding: 6px 2px !important;
                text-align: center;
            }
            .dept-badge {
                font-size: 0.62rem !important;
                padding: 1px 3px !important;
            }
            .col-slot, .slot-cell {
                padding: 6px 2px !important;
                text-align: center;
            }
            .slot-badge {
                font-size: 0.62rem !important;
                padding: 1px 4px !important;
            }
            .col-att, .att-cell {
                padding: 6px 2px !important;
                text-align: center;
            }
            .att-present {
                font-size: 0.64rem !important;
                padding: 2px 5px !important;
                white-space: nowrap;
            }
            .att-absent {
                font-size: 0.64rem !important;
                padding: 2px 5px !important;
                white-space: nowrap;
            }
            .right-col {
                padding: 0 10px 20px 10px;
                gap: 12px;
            }
            .qr-panel {
                border-radius: 12px;
            }
            .qr-panel-header {
                padding: 12px 14px;
            }
            .qr-panel-header h3 {
                font-size: 0.85rem;
            }
            .qr-panel-body {
                padding: 12px;
            }
            .attend-stats {
                gap: 6px;
            }
            .stat-box {
                padding: 10px 4px;
                border-radius: 10px;
            }
            .stat-box .stat-num {
                font-size: 1.35rem;
            }
            .stat-box .stat-label {
                font-size: 0.65rem;
            }
            .manual-row {
                gap: 6px;
            }
            .manual-row input {
                padding: 8px 10px;
                font-size: 0.8rem;
                border-radius: 8px;
            }
            .btn-mark {
                padding: 8px 14px;
                font-size: 0.78rem;
                border-radius: 8px;
            }
            .modal-dialog {
                margin: 12px auto;
                width: calc(100% - 20px);
                max-width: 420px;
            }
            .modal-header, .modal-body, .modal-footer {
                padding: 14px 16px;
            }
        }

        /* ── Extra Narrow Mobile (max 360px) ── */
        @media (max-width: 360px) {
            .coord-container {
                padding: 8px 3px;
            }
            .part-table thead th {
                padding: 5px 1px !important;
                font-size: 0.58rem !important;
            }
            .part-table td {
                padding: 5px 1px !important;
                font-size: 0.66rem !important;
            }
            .reg-badge {
                font-size: 0.58rem !important;
                padding: 1px 2px !important;
                letter-spacing: -0.4px;
            }
            .name-cell {
                font-size: 0.66rem !important;
            }
            .dept-badge {
                font-size: 0.58rem !important;
                padding: 1px 2px !important;
            }
            .att-present, .att-absent {
                font-size: 0.58rem !important;
                padding: 1px 3px !important;
            }
            .houses-grid {
                grid-template-columns: 1fr;
            }
            .attend-stats {
                gap: 4px;
            }
            .stat-box {
                padding: 8px 2px;
            }
            .stat-box .stat-num {
                font-size: 1.2rem;
            }
            .stat-box .stat-label {
                font-size: 0.6rem;
            }
        }
    </style>
</head>
<body>

<!-- ── NAVBAR ─────────────────────────────────────────────── -->
<nav class="coord-navbar">
    <div class="brand">
        <a href="../index.php">
            <img src="../public/images/logos/waves-logo.png" alt="Waves Logo">
        </a>
    </div>
    <div class="nav-actions">
        <form action="../routes/pdf/EventCopdf.php" method="post" class="m-0">
            <input type="hidden" name="event" value="<?= htmlspecialchars($eventName) ?>">
            <button class="btn-nav" type="submit" title="Data Export">
                <i class="fas fa-file-export"></i> <span class="nav-btn-text">Data Export</span>
            </button>
        </form>
        <button class="btn-nav" data-toggle="modal" data-target="#resetModal" type="button" title="Password">
            <i class="fas fa-key"></i> <span class="nav-btn-text">Password</span>
        </button>
        <a href="../index.php" class="btn-nav danger" title="Logout">
            <i class="fas fa-sign-out-alt"></i> <span class="nav-btn-text">Logout</span>
        </a>
    </div>
</nav>

<!-- ── EVENT HERO BANNER ──────────────────────────────────── -->
<div class="page-wrapper">
<div class="left-col">

<div class="event-hero">
    <?php if ($eventImage): ?>
    <div class="event-hero-bg" style="background-image: url('../<?= htmlspecialchars($eventImage) ?>');"></div>
    <?php endif; ?>
    <div class="event-hero-overlay"></div>
    <div class="event-hero-content">
        <div class="event-title-area">
            <h1><?= htmlspecialchars($eventName) ?></h1>
            <div class="event-meta-chips">
                <?php if ($eventDate): ?>
                <span class="meta-chip gold"><i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($eventDate) ?></span>
                <?php endif; ?>
                <?php if ($eventTime): ?>
                <span class="meta-chip"><i class="fas fa-clock"></i> <?= htmlspecialchars($eventTime) ?></span>
                <?php endif; ?>
                <?php if ($eventVenue): ?>
                <span class="meta-chip"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($eventVenue) ?></span>
                <?php endif; ?>
                <?php if ($eventType): ?>
                <span class="meta-chip stage"><i class="fas fa-theater-masks"></i> <?= htmlspecialchars($eventType) ?></span>
                <?php endif; ?>
                <?php
                $gc = strtolower($eventGender);
                $gClass = $gc === 'boys' ? 'boys' : ($gc === 'girls' ? 'girls' : 'common');
                $gIcon  = $gc === 'boys' ? 'fa-mars' : ($gc === 'girls' ? 'fa-venus' : 'fa-venus-mars');
                ?>
                <span class="meta-chip <?= $gClass ?>">
                    <i class="fas <?= $gIcon ?>"></i> <?= htmlspecialchars($eventGender) ?>
                </span>
            </div>
        </div>
        <div>
            <span class="meta-chip" style="font-size:0.8rem; padding: 6px 16px;">
                <i class="fas fa-users"></i>
                <?= count($houses) ?> <?= strtolower($eventGender) === 'common' ? 'Houses' : ($eventGender . ' Houses') ?>
            </span>
        </div>
    </div>
</div>

<!-- ── MAIN CONTENT ───────────────────────────────────────── -->
<div class="coord-container">

    <!-- Houses Grid Section -->
    <div class="section-header mt-2">
        <h2><i class="fas fa-shield-alt"></i> Select House</h2>
        <span class="participant-count" id="total-count">
            <?= count($houses) ?> houses
        </span>
    </div>

    <div class="houses-grid" id="houses-grid">
        <?php foreach ($houses as $idx => $house):
            $hName   = $house['name'];
            $hGender = strtolower($house['gender']);
            $hImg    = $house['image'] ?? '';
            $gClass  = $hGender === 'girls' ? 'girls-card' : '';
            $gBadge  = $hGender === 'girls' ? 'gender-girls' : 'gender-boys';
            $gLabel  = strtoupper($house['gender']);

            // Count participants in this house for this event
            $cStmt = mysqli_prepare($conn, "SELECT COUNT(*) as cnt FROM registerationdb WHERE event_name = ? AND student_house = ?");
            mysqli_stmt_bind_param($cStmt, 'ss', $eventName, $hName);
            mysqli_stmt_execute($cStmt);
            $cRow = mysqli_fetch_assoc(mysqli_stmt_get_result($cStmt));
            $pCount = $cRow['cnt'] ?? 0;
        ?>
        <div class="house-card <?= $gClass ?> <?= $idx === 0 ? 'active' : '' ?>"
             id="card-<?= htmlspecialchars(str_replace(' ', '_', $hName)) ?>"
             onclick="selectHouse(this, '<?= htmlspecialchars(addslashes($hName)) ?>')">
            <span class="house-gender-badge <?= $gBadge ?>"><?= $gLabel ?></span>
            <?php if ($hImg): ?>
            <img src="../<?= htmlspecialchars($hImg) ?>" alt="<?= htmlspecialchars($hName) ?>" class="house-img"
                 onerror="this.style.display='none'">
            <?php endif; ?>
            <div class="house-name"><?= htmlspecialchars($hName) ?></div>
            <div class="house-count">
                <i class="fas fa-user-check" style="font-size:0.6rem;"></i>
                <?= $pCount ?> registered
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Participants Panel -->
    <div class="section-header">
        <h2><i class="fas fa-list-ul"></i> Participants</h2>
    </div>
    <div id="participants-panel">
        <!-- Populated by JS -->
    </div>

</div>

</div><!-- /left-col -->

<!-- ── RIGHT COL: QR ATTENDANCE ──────────────────────────── -->
<div class="right-col">

    <!-- Live Stats -->
    <div class="qr-panel">
        <div class="qr-panel-header">
            <i class="fas fa-chart-bar"></i>
            <h3>Attendance Stats</h3>
        </div>
        <div class="qr-panel-body">
            <div class="attend-stats">
                <div class="stat-box stat-present">
                    <div class="stat-num" id="stat-present">0</div>
                    <div class="stat-label">Present</div>
                </div>
                <div class="stat-box stat-absent">
                    <div class="stat-num" id="stat-absent">0</div>
                    <div class="stat-label">Absent</div>
                </div>
                <div class="stat-box stat-total">
                    <div class="stat-num" id="stat-total">0</div>
                    <div class="stat-label">Total</div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Scanner -->
    <div class="qr-panel">
        <div class="qr-panel-header">
            <i class="fas fa-qrcode"></i>
            <h3>Scan QR / ID</h3>
        </div>
        <div class="qr-panel-body">
            <div id="qr-reader"></div>

            <div class="qr-divider">or enter manually</div>

            <div class="manual-row">
                <input type="text" id="manual-reg" placeholder="Register number..." autocomplete="off"
                       onkeydown="if(event.key==='Enter') markAttendance(document.getElementById('manual-reg').value)">
                <button class="btn-mark" id="btn-mark"
                        onclick="markAttendance(document.getElementById('manual-reg').value)">
                    <i class="fas fa-check-circle"></i> Mark
                </button>
            </div>

            <div class="qr-feedback" id="qr-feedback">
                <i class="fas fa-circle" id="qr-feedback-icon"></i>
                <span id="qr-feedback-msg"></span>
            </div>
        </div>
    </div>

    <!-- Context info -->
    <div class="qr-panel">
        <div class="qr-panel-header">
            <i class="fas fa-info-circle"></i>
            <h3>Active Context</h3>
        </div>
        <div class="qr-panel-body" style="font-size:0.8rem; color:var(--text-muted); line-height:1.8;">
            <div><span style="color:var(--text-main);font-weight:600;">Event:</span>
                <?= htmlspecialchars($eventName) ?></div>
            <div><span style="color:var(--text-main);font-weight:600;">House:</span>
                <span id="ctx-house" style="color:var(--accent);">—</span></div>
        </div>
    </div>

</div><!-- /right-col -->
</div><!-- /page-wrapper -->

<!-- ── PASSWORD MODAL ─────────────────────────────────────── -->
<div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-key mr-2" style="color:var(--accent)"></i>Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" style="color:var(--text-muted)">
                    <span>&times;</span>
                </button>
            </div>
            <form action="../routes/admin/coordinatorEdit.php" method="post">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Event Name</label>
                        <input type="text" name="event_name" value="<?= htmlspecialchars($eventName) ?>"
                               readonly class="form-control">
                    </div>
                    <input type="hidden" name="whoUpdate" value="EVENT_CORDINATOR">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="update_password" placeholder="Enter new password"
                               class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn-accent">
                        <i class="fas fa-save mr-1"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="../public/js/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

<script>
const eventData    = <?= json_encode($eventData) ?>;
const housesData   = <?= json_encode($houses) ?>;
const eventGender  = '<?= addslashes($eventGender) ?>';

// ── House images map ───────────────────────────────────────
const houseImages = {};
housesData.forEach(h => { houseImages[h.name] = h.image || ''; });

// ── Select a house card — renders participants + syncs attendance panel ────
function selectHouse(el, houseName) {
    document.querySelectorAll('.house-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    selectedHouse = houseName;
    document.getElementById('ctx-house').textContent = houseName;
    renderParticipants(houseName);
    updateStats();
}

// ── Render participants table for selected house ───────────
function renderParticipants(houseName) {
    const panel = document.getElementById('participants-panel');
    const ev    = eventData.event;
    let html    = '';

    if (!ev) { panel.innerHTML = '<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>No event data.</p></div>'; return; }

    const hImg = houseImages[houseName] ? `../${houseImages[houseName]}` : '';

    // Build header
    const genderBadge = housesData.find(h => h.name === houseName);
    const gClass = genderBadge && genderBadge.gender === 'GIRLS' ? 'gender-girls' : 'gender-boys';

    html += `<div class="participants-panel">
        <div class="panel-header">
            <div class="panel-header-left">
                ${hImg ? `<img src="${hImg}" class="panel-house-img" onerror="this.style.display='none'" alt="">` : ''}
                <div>
                    <p class="panel-title">${houseName}</p>
                    <p class="panel-subtitle">Event participants</p>
                </div>
            </div>
            <span class="house-count"><span class="house-gender-badge ${gClass}" style="position:static;font-size:0.7rem;">${genderBadge ? genderBadge.gender : ''}</span></span>
        </div>
        <div class="panel-body">`;

    if (ev.is_group === '0') {
        const filtered = (eventData.participants || []).filter(p => p.student_house === houseName);
        html += buildTable(filtered, 'Participants');
    } else {
        const groups = eventData.groups || [];
        if (groups.length === 0) {
            html += '<div class="empty-state"><i class="fas fa-users-slash"></i><p>No groups found.</p></div>';
        } else {
            groups.forEach(g => {
                const filtered = (g.participants || []).filter(p => p.student_house === houseName);
                html += `<div class="group-header"><i class="fas fa-layer-group"></i> Group ${g.group_number}</div>`;
                html += buildTable(filtered, `Group ${g.group_number}`);
            });
        }
    }

    html += `</div></div>`;
    panel.innerHTML = html;
}

function buildTable(participants, label) {
    if (!participants || participants.length === 0) {
        return `<div class="empty-state">
            <i class="fas fa-user-slash"></i>
            <p>No participants registered from this house for ${label}.</p>
        </div>`;
    }
    let rows = participants.map((p, i) => `
        <tr id="row-${p.reg_no}">
            <td class="sno-cell">${i + 1}</td>
            <td class="reg-cell"><span class="reg-badge">${p.reg_no}</span></td>
            <td class="name-cell">${p.student_name || '-'}</td>
            <td class="dept-cell"><span class="dept-badge">${p.student_dept || '-'}</span></td>
            <td class="slot-cell">${p.slot ? `<span class="slot-badge">${p.slot}</span>` : '<span class="slot-empty">—</span>'}</td>
            <td class="att-cell"><span class="${p.attendance == 1 ? 'att-present' : 'att-absent'}" id="att-${p.reg_no}">${p.attendance == 1 ? '✓ Present' : 'Absent'}</span></td>
        </tr>`).join('');

    return `<div class="table-responsive">
        <table class="part-table">
            <thead>
                <tr>
                    <th class="col-sno">#</th>
                    <th class="col-reg"><span class="th-full">Reg. Number</span><span class="th-short">Reg No</span></th>
                    <th class="col-name"><span class="th-full">Student Name</span><span class="th-short">Name</span></th>
                    <th class="col-dept"><span class="th-full">Department</span><span class="th-short">Dept</span></th>
                    <th class="col-slot">Slot</th>
                    <th class="col-att"><span class="th-full">Attendance</span><span class="th-short">Attend</span></th>
                </tr>
            </thead>
            <tbody>${rows}</tbody>
        </table>
    </div>`;
}

// ── Attendance tracking (event-wide) ─────────────────────
let selectedHouse = '';
const EVENT_NAME  = <?= json_encode($eventName) ?>;

// Stats are event-wide (all registered participants across all houses)
function updateStats() {
    const allPart = getAllParticipants();
    const total   = allPart.length;
    const present = allPart.filter(p => p.attendance == 1).length;
    document.getElementById('stat-total').textContent   = total;
    document.getElementById('stat-present').textContent = present;
    document.getElementById('stat-absent').textContent  = total - present;
}

function getAllParticipants() {
    const ev = eventData.event;
    if (!ev) return [];
    if (ev.is_group === '0') {
        return eventData.participants || [];
    } else {
        let all = [];
        (eventData.groups || []).forEach(g => { all = all.concat(g.participants || []); });
        return all;
    }
}

// ── Attendance marking (event-wide — not filtered by house) ──────────────
function markAttendance(regNo) {
    regNo = (regNo || '').trim();
    if (!regNo) { showFeedback('error', 'fas fa-times-circle', 'Please enter a register number.'); return; }

    const btn = document.getElementById('btn-mark');
    btn.disabled = true;

    fetch('../routes/admin/markAttendance.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ reg_no: regNo, event_name: EVENT_NAME })
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        if (data.status === 'ok') {
            showFeedback('success', 'fas fa-check-circle',
                `✅ Marked: ${data.name}` + (data.house ? ` (${data.house})` : ''));
            updateAttBadge(regNo, true);
            markLocalAttendance(regNo);
            updateStats();
        } else if (data.status === 'already') {
            showFeedback('warning', 'fas fa-exclamation-circle',
                `⚠️ Already present: ${data.name}` + (data.house ? ` (${data.house})` : ''));
        } else if (data.status === 'not_found') {
            showFeedback('error', 'fas fa-times-circle', '❌ Not registered for this event.');
        } else {
            showFeedback('error', 'fas fa-times-circle', data.message || 'Unknown error.');
        }
        document.getElementById('manual-reg').value = '';
    })
    .catch(() => { btn.disabled = false; showFeedback('error', 'fas fa-wifi', 'Network error. Please retry.'); });
}

function markLocalAttendance(regNo) {
    const ev = eventData.event;
    if (!ev) return;
    if (ev.is_group === '0') {
        (eventData.participants || []).forEach(p => { if (p.reg_no === regNo) p.attendance = 1; });
    } else {
        (eventData.groups || []).forEach(g => {
            (g.participants || []).forEach(p => { if (p.reg_no === regNo) p.attendance = 1; });
        });
    }
}

function updateAttBadge(regNo, present) {
    const el = document.getElementById('att-' + regNo);
    if (el) {
        el.className = present ? 'att-present' : 'att-absent';
        el.textContent = present ? '✓ Present' : 'Absent';
    }
}

function showFeedback(type, icon, msg) {
    const fb = document.getElementById('qr-feedback');
    const ic = document.getElementById('qr-feedback-icon');
    const ms = document.getElementById('qr-feedback-msg');
    fb.className = `qr-feedback show ${type}`;
    ic.className = icon;
    ms.textContent = msg;
    clearTimeout(fb._timer);
    fb._timer = setTimeout(() => fb.classList.remove('show'), 5000);
}

// ── html5-qrcode Scanner ──────────────────────────────────
function startQrScanner() {
    if (typeof Html5QrcodeScanner === 'undefined') return;
    const scanner = new Html5QrcodeScanner('qr-reader', {
        fps: 10,
        qrbox: { width: 220, height: 220 },
        rememberLastUsedCamera: true,
        aspectRatio: 1.0
    }, false);
    scanner.render(
        (decodedText) => {
            // QR decoded — extract reg number (strip whitespace)
            const reg = decodedText.trim();
            markAttendance(reg);
        },
        (err) => { /* scan errors are normal, ignore */ }
    );
}

// ── Init ──────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const firstCard = document.querySelector('.house-card');
    if (firstCard) {
        const firstName = firstCard.querySelector('.house-name').textContent.trim();
        selectedHouse = firstName;
        document.getElementById('ctx-house').textContent = firstName;
        renderParticipants(firstName);
        updateStats();
    }
    startQrScanner();
});
</script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
</body>
</html>