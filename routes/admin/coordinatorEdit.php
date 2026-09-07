<?php
ob_start();
require_once('../connect.php');

if (isset($_POST["submit"])) {
    $event_name          = mysqli_real_escape_string($conn, $_POST["event_name"] ?? '');
    $coordinator_name_1  = mysqli_real_escape_string($conn, $_POST["coordinator_name_1"] ?? '');
    $coordinator_reg_no_1= mysqli_real_escape_string($conn, $_POST["coordinator_reg_no_1"] ?? '-');
    $staff_dept_1        = mysqli_real_escape_string($conn, $_POST["staff_dept_1"] ?? '');

    $coordinator_name_2  = mysqli_real_escape_string($conn, $_POST["coordinator_name_2"] ?? '');
    $coordinator_reg_no_2= mysqli_real_escape_string($conn, $_POST["coordinator_reg_no_2"] ?? '-');
    $staff_dept_2        = mysqli_real_escape_string($conn, $_POST["staff_dept_2"] ?? '');
    $update_password     = trim($_POST["update_password"] ?? '');

    if (empty($event_name)) {
        echo "<script>alert('Event name is required!'); window.history.back();</script>";
        exit;
    }

    // 1. Update event_cordinators in eventdb
    $coordinators_combined = $coordinator_name_1 . '|' . $coordinator_name_2;
    mysqli_query($conn, "UPDATE eventdb SET event_cordinators = '$coordinators_combined' WHERE event_name = '$event_name'");

    // 2. Fetch existing coordinators from admindb
    $res = mysqli_query($conn, "SELECT id FROM admindb WHERE event_name = '$event_name' AND role = 'event coordinator' ORDER BY id ASC");
    $existing_ids = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $existing_ids[] = $row['id'];
    }

    $pw_hash = !empty($update_password) ? password_hash($update_password, PASSWORD_DEFAULT) : null;

    // Handle Coordinator 1
    if (isset($existing_ids[0])) {
        $id1 = $existing_ids[0];
        $pw_clause = $pw_hash ? ", password = '$pw_hash'" : "";
        mysqli_query($conn, "UPDATE admindb SET name = '$coordinator_name_1', reg_no = '$coordinator_reg_no_1', dept = '$staff_dept_1' $pw_clause WHERE id = $id1");
    } elseif (!empty($coordinator_name_1)) {
        $default_pw = $pw_hash ? $pw_hash : password_hash('waves123', PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO admindb (name, dept, reg_no, role, password, event_name, house_name) VALUES ('$coordinator_name_1', '$staff_dept_1', '$coordinator_reg_no_1', 'event coordinator', '$default_pw', '$event_name', '-')");
    }

    // Handle Coordinator 2
    if (isset($existing_ids[1])) {
        $id2 = $existing_ids[1];
        $pw_clause = $pw_hash ? ", password = '$pw_hash'" : "";
        mysqli_query($conn, "UPDATE admindb SET name = '$coordinator_name_2', reg_no = '$coordinator_reg_no_2', dept = '$staff_dept_2' $pw_clause WHERE id = $id2");
    } elseif (!empty($coordinator_name_2)) {
        $default_pw = $pw_hash ? $pw_hash : password_hash('waves123', PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO admindb (name, dept, reg_no, role, password, event_name, house_name) VALUES ('$coordinator_name_2', '$staff_dept_2', '$coordinator_reg_no_2', 'event coordinator', '$default_pw', '$event_name', '-')");
    }

    if (!empty($_POST['whoUpdate'])) {
        header('Location: ../../pages/eventCoordinatorDashboard.php?success=coordinator_updated');
    } else {
        header('Location: ../../pages/adminForm.php?success=coordinator_updated#edit-coordinator');
    }
    exit;
}

mysqli_close($conn);
ob_end_flush();
?>