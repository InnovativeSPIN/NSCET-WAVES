<?php
include('../routes/connect.php');
require_once('../routes/pdf/fpdf.php'); // adjust path if needed

function getEvents($conn) {
    $events = [];
    $result = mysqli_query($conn, "SELECT DISTINCT event_name FROM eventdb ORDER BY event_name ASC");
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row['event_name'];
    }
    return $events;
}

function getGenders($conn, $event) {
    $genders = [];
    $result = mysqli_query($conn, "SELECT DISTINCT gender FROM allotmentdb WHERE event='".mysqli_real_escape_string($conn, $event)."'");
    while ($row = mysqli_fetch_assoc($result)) {
        $genders[] = $row['gender'];
    }
    return $genders;
}

// Download single report
if (isset($_GET['download']) && isset($_GET['event']) && isset($_GET['gender'])) {
    $event = $_GET['event'];
    $gender = $_GET['gender'];
    $slots = [];
    $result = mysqli_query($conn, "SELECT * FROM allotmentdb WHERE event='".mysqli_real_escape_string($conn, $event)."' AND gender='".mysqli_real_escape_string($conn, $gender)."' ORDER BY slot ASC");
    while ($row = mysqli_fetch_assoc($result)) {
        $slots[] = $row;
    }
    if (count($slots) === 0) {
        echo "<script>alert('Slot not allotted for this event/gender!');window.location='report.php';</script>";
        exit;
    }

    // House logo mapping (filename must match house name, fallback to blank if not found)
    function getHouseLogo($house) {
        $imgDir = '../public/images/house/';
        $file = $imgDir . strtoupper(str_replace(' ', '_', $house)) . '.png';
        if (file_exists($file)) return $file;
        return $imgDir . 'default.png'; // fallback image
    }

    class PDF extends FPDF {
        function Header() {
            // Banner at top
            $this->Image('../public/images/logos/banner_nscet.png', 0, 0, 210, 30, 'PNG');
            $this->Ln(25);
        }
        function WatermarkLogo() {
            // Centered logo watermark, larger and better aspect ratio
            $logo = '../public/images/logos/background-logo.png';
            $w = 140; $h = 140;
            $x = ($this->GetPageWidth() - $w) / 2;
            $y = 60;
            $this->Image($logo, $x, $y, $w, $h, 'PNG');
        }
    }

    $pdf = new PDF('P','mm','A4');
    $pdf->AddPage();

    // Watermark logo (centered, behind content)
    $pdf->SetY(0);
    $pdf->WatermarkLogo();

    // Headings
    $pdf->SetY(35);
    $pdf->SetFont('Arial','B',18);
    $pdf->Cell(0,12,'Event Slot Allotment',0,1,'C');
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,"$event - $gender",0,1,'C');
    $pdf->Ln(4);

    // 2-column table layout
    $colWidthLogo = 18; $colWidthName = 40; $colWidthSlot = 15;
    $tableWidth = 2 * ($colWidthLogo + $colWidthName + $colWidthSlot);
    $pageWidth = $pdf->GetPageWidth();
    $startX = ($pageWidth - $tableWidth) / 2;
    $pdf->SetX($startX);
    $pdf->SetFont('Arial','B',9);
    $pdf->SetFillColor(0,255,231);
    $pdf->SetTextColor(0,0,0);
    // Header row
    $pdf->Cell($colWidthLogo,8,'Logo',1,0,'C',true);
    $pdf->Cell($colWidthName,8,'Team Name',1,0,'C',true);
    $pdf->Cell($colWidthSlot,8,'Slot',1,0,'C',true);
    $pdf->Cell($colWidthLogo,8,'Logo',1,0,'C',true);
    $pdf->Cell($colWidthName,8,'Team Name',1,0,'C',true);
    $pdf->Cell($colWidthSlot,8,'Slot',1,1,'C',true);
    $pdf->SetFont('Arial','',9);
    $pdf->SetTextColor(0,0,0);

    // Vertical 2-column order: left = 1,3,5...; right = 2,4,6...
    $n = count($slots);
    $left = [];
    $right = [];
    for ($i = 0; $i < $n; $i++) {
        if ($i < ceil($n/2)) {
            $left[] = $slots[$i];
        } else {
            $right[] = $slots[$i];
        }
    }
    $rows = max(count($left), count($right));
    for ($i = 0; $i < $rows; $i++) {
        $pdf->SetX($startX);
        // Left column
        if (isset($left[$i])) {
            $row1 = $left[$i];
            $logo1 = getHouseLogo($row1['house']);
            $pdf->Cell($colWidthLogo,12,'',1,0,'C');
            $x1 = $pdf->GetX(); $y1 = $pdf->GetY();
            $pdf->Image($logo1, $pdf->GetX()-$colWidthLogo+4, $pdf->GetY()+2, 10, 10, 'PNG');
            $pdf->SetXY($x1, $y1);
            $pdf->Cell($colWidthName,12,$row1['house'],1,0,'C');
            $pdf->Cell($colWidthSlot,12,$row1['slot'],1,0,'C');
        } else {
            $pdf->Cell($colWidthLogo,12,'',1,0,'C');
            $pdf->Cell($colWidthName,12,'',1,0,'C');
            $pdf->Cell($colWidthSlot,12,'',1,0,'C');
        }
        // Right column
        if (isset($right[$i])) {
            $row2 = $right[$i];
            $logo2 = getHouseLogo($row2['house']);
            $pdf->Cell($colWidthLogo,12,'',1,0,'C');
            $x2 = $pdf->GetX(); $y2 = $pdf->GetY();
            $pdf->Image($logo2, $pdf->GetX()-$colWidthLogo+4, $pdf->GetY()+2, 10, 10, 'PNG');
            $pdf->SetXY($x2, $y2);
            $pdf->Cell($colWidthName,12,$row2['house'],1,0,'C');
            $pdf->Cell($colWidthSlot,12,$row2['slot'],1,0,'C');
        } else {
            $pdf->Cell($colWidthLogo,12,'',1,0,'C');
            $pdf->Cell($colWidthName,12,'',1,0,'C');
            $pdf->Cell($colWidthSlot,12,'',1,0,'C');
        }
        $pdf->Ln();
    }

    $pdf->Output('D', "{$event}_{$gender}_slot_report.pdf");
    exit;
}

// Download all reports as zip (stub, implement if needed)
if (isset($_GET['download_all'])) {
    echo "<script>alert('Download all as zip is not implemented in this demo.');window.location='report.php';</script>";
    exit;
}

// Day-wise filter logic (copied/adapted from index.php)
$dateResult = mysqli_query($conn, "SELECT DISTINCT event_date FROM eventdb WHERE event_date != '-' ORDER BY event_date ASC");
$dates = [];
while ($dateRow = mysqli_fetch_assoc($dateResult)) {
    $dates[] = $dateRow['event_date'];
}
$selectedDate = isset($_GET['date']) ? $_GET['date'] : (count($dates) > 0 ? $dates[0] : null);

// Only show events for the selected date
$events = [];
if ($selectedDate) {
    $result = mysqli_query($conn, "SELECT event_name FROM eventdb WHERE event_date = '" . mysqli_real_escape_string($conn, $selectedDate) . "' ORDER BY event_name ASC");
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row['event_name'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Slot Allotment Reports | NSCET WAVES</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .button-54 {
            font-family: "Poppins", "Open Sans", sans-serif;
            font-size: 16px;
            letter-spacing: 2px;
            text-decoration: none;
            text-transform: uppercase;
            color: #00bfff;
            background: #fff;
            cursor: pointer;
            border: 3px solid #00bfff;
            padding: 0.25em 0.5em;
            box-shadow: 1px 1px 0px 0px #00bfff, 2px 2px 0px 0px #00bfff, 3px 3px 0px 0px #00bfff, 4px 4px 0px 0px #00bfff, 5px 5px 0px 0px #00bfff;
            position: relative;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            border-radius: 10px;
            margin: 0 4px 8px 0;
            transition: box-shadow 0.2s, top 0.2s, left 0.2s, background 0.2s, color 0.2s;
        }
        .button-54:active, .button-54.active, .button-54:focus {
            box-shadow: 0px 0px 0px 0px #00bfff;
            top: 5px;
            left: 5px;
            background: #00bfff;
            color: #fff;
        }
        .button-54:hover {
            background: #00bfff;
            color: #fff;
        }
        @media (min-width: 768px) {
            .button-54 {
                padding: 0.25em 0.75em;
            }
        }
        .day-filter-bar {
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }
        .day-btn {
            background: #00bfff;
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 10px 28px;
            font-size: 1.1em;
            font-weight: 600;
            margin: 0 4px 8px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
            cursor: pointer;
            outline: none;
            position: relative;
        }
        .day-btn.active, .day-btn:focus {
            background: #fff;
            color: #00bfff;
            box-shadow: 0 4px 16px rgba(0,191,255,0.18);
            transform: translateY(-2px) scale(1.04);
            border: 2px solid #00bfff;
        }
        .day-btn:hover {
            background: #0090c7;
            color: #fff;
            box-shadow: 0 6px 18px rgba(0,191,255,0.22);
            transform: translateY(-2px) scale(1.04);
        }
        .day-btn .day-date {
            font-size: 0.85em;
            color: #e0e0e0;
            margin-left: 6px;
        }
        body { background: #000; color: #fff; font-family: 'Poppins', sans-serif; }
        .container {
            margin: 40px auto;
            max-width: 900px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .top-bar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .event-card {
            background: rgba(20,20,20,0.95);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            padding: 32px 24px;
            margin-bottom: 32px;
            width: 100%;
            max-width: 700px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .event-title {
            font-size: 1.5em;
            font-weight: 700;
            color: #00ffe7;
            margin-bottom: 10px;
        }
        .event-meta {
            font-size: 1.1em;
            color: #ccc;
            margin-bottom: 12px;
        }
        .download-btn {
            background: linear-gradient(135deg, #007bff, #00ffe7);
            border: none;
            color: #fff;
            padding: 10px 24px;
            font-size: 1em;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            margin-right: 10px;
            margin-bottom: 10px;
            transition: box-shadow 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px rgba(0,255,231,0.08);
        }
        .download-btn:last-child { margin-right: 0; }
        .download-btn:hover {
            background: linear-gradient(135deg, #00ffe7, #007bff);
            box-shadow: 0 4px 16px rgba(0,255,231,0.18);
            transform: translateY(-2px) scale(1.03);
        }
        .not-allotted { color: #ff4d4d; font-weight: 600; }
        .download-all-btn {
            margin-bottom: 0;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-bar">
            <a href="index.php" class="button-54">&larr; Back to Event List</a>
            <h1 class="event-title" style="margin:0;">Slot Allotment Reports</h1>
            <a href="?download_all=1" class="button-54 download-all-btn">Download All</a>
        </div>
        <div class="day-filter-bar">
            <?php $dayNum = 1; foreach ($dates as $i => $date): ?>
                <?php
                    $isActive = ($selectedDate == $date) || (!$selectedDate && $i === 0);
                ?>
                <a href="?date=<?php echo urlencode($date); ?>" class="button-54<?php echo $isActive ? ' active' : ''; ?>">
                    Day <?php echo $dayNum; ?> <span class="day-date">(<?php echo htmlspecialchars($date); ?>)</span>
                </a>
                <?php $dayNum++; ?>
            <?php endforeach; ?>
        </div>
        <?php if (count($events) === 0): ?>
            <div class="event-card text-center">No events found for this day.</div>
        <?php else: ?>
            <?php foreach ($events as $event): ?>
                <div class="event-card">
                    <div class="event-title"><?php echo htmlspecialchars($event); ?></div>
                    <div class="event-meta">Available Reports:</div>
                    <div style="display:flex;flex-wrap:wrap;gap:10px;">
                    <?php $genders = getGenders($conn, $event); if (count($genders) === 0): ?>
                        <span class="not-allotted">Slot not allotted</span>
                    <?php else: ?>
                        <?php foreach ($genders as $gender): ?>
                            <a href="?download=1&event=<?php echo urlencode($event); ?>&gender=<?php echo urlencode($gender); ?>&date=<?php echo urlencode($selectedDate); ?>" class="download-btn">Download Report (<?php echo htmlspecialchars($gender); ?>)</a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
