<?php
session_start();
include('../connect.php');

header('Content-Type: application/json');

if (!isset($_SESSION['ispin_admin_logged_in']) || $_SESSION['ispin_admin_logged_in'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = mysqli_real_escape_string($conn, $_POST['id'] ?? '');
        if (empty($id)) {
            echo json_encode(['status' => 'error', 'message' => 'Student ID is required']);
            exit();
        }

        $query = "DELETE FROM studentdb WHERE id='$id'";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['status' => 'success', 'message' => 'Student deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($conn)]);
        }
        exit();

    } elseif ($action === 'delete_all_in_house') {
        $house = mysqli_real_escape_string($conn, $_POST['house'] ?? '');
        if (empty($house)) {
            echo json_encode(['status' => 'error', 'message' => 'House name is required']);
            exit();
        }

        $query = "DELETE FROM studentdb WHERE house='$house'";
        if (mysqli_query($conn, $query)) {
            $affected = mysqli_affected_rows($conn);
            echo json_encode(['status' => 'success', 'message' => "Deleted $affected students from $house"]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($conn)]);
        }
        exit();

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
