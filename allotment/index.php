<?php
include('../routes/connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Allotment Events | NSCET WAVES</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/swiper.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            background: #000;
            color: #fff;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 40px;
        }
        .event-card {
            background: rgba(20,20,20,0.95);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3), 0 0 0 2px rgba(0,255,231,0.2);
            padding: 32px 24px;
            margin-bottom: 32px;
            transition: box-shadow 0.3s;
            min-height: 320px;
            max-height: 320px;
            min-width: 320px;
            max-width: 320px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
        }
        .event-card:hover {
            box-shadow: 0 12px 32px rgba(0,255,231,0.2);
        }
        .event-title {
            font-size: 2em;
            font-weight: 700;
            color: #00ffe7;
        }
        .event-meta {
            font-size: 1.1em;
            color: #ccc;
            margin-bottom: 12px;
        }
        .allot-btn {
            background: linear-gradient(135deg, #007bff, #00ffe7);
            border: none;
            color: #fff;
            padding: 12px 28px;
            font-size: 1.1em;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,255,231,0.2);
            transition: all 0.3s ease;
            letter-spacing: 0.05em;
        }
        .allot-btn:hover {
            background: linear-gradient(135deg, #00ffe7, #007bff);
            box-shadow: 0 6px 16px rgba(0,255,231,0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-5 text-center event-title">Allotment Events</h1>
        <div class="row">
        <?php
        $result = mysqli_query($conn, "SELECT event_name, event_type, event_date, event_time, event_venue FROM eventdb ORDER BY event_name ASC");
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $eventName = htmlspecialchars($row['event_name']);
                $eventType = htmlspecialchars($row['event_type']);
                $eventDate = htmlspecialchars($row['event_date']);
                $eventTime = htmlspecialchars($row['event_time']);
                $eventVenue = htmlspecialchars($row['event_venue']);
                echo '<div class="col-md-6 col-lg-4">';
                echo '<div class="event-card">';
                echo '<div class="event-title">' . $eventName . '</div>';
                echo '<div class="event-meta">Type: ' . $eventType . '</div>';
                echo '<div class="event-meta">Date: ' . $eventDate . ' | Time: ' . $eventTime . '</div>';
                echo '<div class="event-meta">Venue: ' . $eventVenue . '</div>';
                echo '<a href="grouped.php?eventName=' . urlencode($eventName) . '" class="allot-btn mt-3">Allot Slot</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="col-12"><div class="event-card text-center">No events found.</div></div>';
        }
        ?>
        </div>
    </div>
</body>
</html>
