<?php
include('../connect.php');
?>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_number']) && isset($_POST['password']) && isset($_POST['role']) && $_POST['role'] != 'student') {

    $reg_number = $_POST['reg_number'];
    $query = "SELECT dept,event_name,house_name, reg_no,role, name, password FROM admindb WHERE reg_no = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $reg_number);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $dept, $event_name, $house_name, $reg_no, $role, $username, $hashed_password);
        mysqli_stmt_fetch($stmt);
        
        $password = $_POST['password'];
        
        if (password_verify($password, $hashed_password) && $_POST['role'] === $role) {
            $_SESSION['role'] = $role;
            $_SESSION['reg_no'] = $reg_no;
            $_SESSION['name'] = $username;
            if($role === 'team captain'){

                $vice_cap_query = mysqli_query($conn, "SELECT name FROM admindb WHERE role = 'vice captain' AND house_name = '$house_name'");                
                $vice_cap_name_array = mysqli_fetch_array($vice_cap_query);

                $_SESSION['sub_role_name'] = $vice_cap_name_array['name'];
                $_SESSION['house_name'] = $house_name;
                $_SESSION['dept'] = $dept;
                mysqli_free_result($vice_cap_query);
                header('Location: ../../pages/houseDashboard.php');
            exit();
            }
            elseif($role === 'team captain'){

                $cap_query = mysqli_query($conn, "SELECT name FROM admindb WHERE role = 'team captain' AND house_name = '$house_name'");            
                $cap_name_array = mysqli_fetch_array($cap_query);
    
                $_SESSION['sub_role_name'] = $cap_name_array['name'];
                $_SESSION['house_name'] = $house_name;
                $_SESSION['dept'] = $dept;
                mysqli_free_result($cap_query);
                header('Location: ../../pages/houseDashboard.php');
                exit();
            }
            
            elseif($role === 'event coordinator'){
                $_SESSION['dept'] = 'dept';
                $_SESSION['event_name'] = $event_name;
                header('Location: ../../dashboard.php');
            exit();
           }
        } else {
            echo "Incorrect username or password or role";
            $error = "Incorrect username or password or role";
        }
    } else {
        echo "User not found";
        $error = "User not found";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}else{
    echo 'neet to connect studb';
    header('Location: ../../pages/studentDashboard.php');
    exit();
}

?>