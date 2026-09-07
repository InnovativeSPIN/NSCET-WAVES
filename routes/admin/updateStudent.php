<?php
session_start();
include('../connect.php');

header('Content-Type: application/json');

if (!isset($_SESSION['admin_user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id'] ?? '');
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $reg_no = mysqli_real_escape_string($conn, $_POST['reg_no'] ?? '');
    $dept = mysqli_real_escape_string($conn, $_POST['dept'] ?? '');
    $year = mysqli_real_escape_string($conn, $_POST['year'] ?? '');
    $house = mysqli_real_escape_string($conn, $_POST['house'] ?? '');
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');

    if (empty($id) || empty($name) || empty($reg_no) || empty($house)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit();
    }

    $query = "UPDATE studentdb SET name='$name', reg_no='$reg_no', dept='$dept', year='$year', house='$house', gender='$gender' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Student updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database update failed: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
