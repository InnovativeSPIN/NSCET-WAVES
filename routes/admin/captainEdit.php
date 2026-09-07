<?php
ob_start();
require_once('../connect.php');

if (isset($_POST["submit"])) {
    if (!empty($_POST["assignedByIncharge"])) {
        $captainNumber = mysqli_real_escape_string($conn, $_POST['captain_number']);
        $captainName = mysqli_real_escape_string($conn, $_POST['captain_name']);
        $vicecaptainNumber = mysqli_real_escape_string($conn, $_POST['vice_captain_number']);
        $vicecaptainName = mysqli_real_escape_string($conn, $_POST['vice_captain_name']);
        $vicevicecaptainNumber = mysqli_real_escape_string($conn, $_POST['vice_vice_captain_number']);
        $vicevicecaptainName = mysqli_real_escape_string($conn, $_POST['vice_vice_captain_name']);

        $query1 = "UPDATE admindb SET name = '$captainName' WHERE id = '$captainNumber'";
        $query2 = "UPDATE admindb SET name = '$vicecaptainName' WHERE id = '$vicecaptainNumber'";
        $query3 = "UPDATE admindb SET name = '$vicevicecaptainName' WHERE id = '$vicevicecaptainNumber'";

        if (mysqli_query($conn, $query1) && mysqli_query($conn, $query2) && mysqli_query($conn, $query3)) {
            header('Location: ../../pages/houseDashboard.php');
            exit;
        } else {
            die("Error executing the query: " . mysqli_error($conn));
        }
    } else {
        $house_name          = mysqli_real_escape_string($conn, $_POST["house_name"] ?? '');
        $captain_name        = mysqli_real_escape_string($conn, $_POST["captain_name"] ?? '');
        $captain_reg_no      = mysqli_real_escape_string($conn, $_POST["captain_reg_no"] ?? '');
        $cap_dept            = mysqli_real_escape_string($conn, $_POST["cap_dept"] ?? '');

        $vice_captain_name   = mysqli_real_escape_string($conn, $_POST["vice_captain_name"] ?? '');
        $vice_captain_reg_no = mysqli_real_escape_string($conn, $_POST["vice_captain_reg_no"] ?? '');
        $vice_cap_dept       = mysqli_real_escape_string($conn, $_POST["vice_cap_dept"] ?? '');

        $update_password     = trim($_POST["update_password"] ?? '');
        $pw_hash             = !empty($update_password) ? password_hash($update_password, PASSWORD_DEFAULT) : null;
        $pw_clause           = $pw_hash ? ", password = '$pw_hash'" : "";

        if (empty($house_name)) {
            echo "<script>alert('House name is required!'); window.history.back();</script>";
            exit;
        }

        // Fetch existing captains for this house
        $cap_res = mysqli_query($conn, "SELECT id FROM admindb WHERE house_name = '$house_name' AND role = 'team captain' ORDER BY id ASC");
        $cap_ids = [];
        while ($r = mysqli_fetch_assoc($cap_res)) {
            $cap_ids[] = $r['id'];
        }

        $default_pw = $pw_hash ? $pw_hash : password_hash('waves123', PASSWORD_DEFAULT);

        // Update/Insert Captain
        if (isset($cap_ids[0])) {
            mysqli_query($conn, "UPDATE admindb SET name = '$captain_name', reg_no = '$captain_reg_no', dept = '$cap_dept' $pw_clause WHERE id = " . $cap_ids[0]);
        } elseif (!empty($captain_name)) {
            mysqli_query($conn, "INSERT INTO admindb (name, dept, reg_no, role, password, event_name, house_name) VALUES ('$captain_name', '$cap_dept', '$captain_reg_no', 'team captain', '$default_pw', '-', '$house_name')");
        }

        // Update/Insert Vice Captain
        if (isset($cap_ids[1])) {
            mysqli_query($conn, "UPDATE admindb SET name = '$vice_captain_name', reg_no = '$vice_captain_reg_no', dept = '$vice_cap_dept' $pw_clause WHERE id = " . $cap_ids[1]);
        } elseif (!empty($vice_captain_name)) {
            mysqli_query($conn, "INSERT INTO admindb (name, dept, reg_no, role, password, event_name, house_name) VALUES ('$vice_captain_name', '$vice_cap_dept', '$vice_captain_reg_no', 'team captain', '$default_pw', '-', '$house_name')");
        }

        header('Location: ../../pages/adminForm.php?success=house_leads_updated#edit-house');
        exit;
    }
}

mysqli_close($conn);
ob_end_flush();
?>