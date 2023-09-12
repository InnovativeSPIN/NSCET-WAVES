<?php
include('../connect.php');
?>

<?php
session_start();


// Team Captain login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_number']) && isset($_POST['password']) && isset($_POST['role']) && $_POST['role'] != 'student' &&  $_POST['role'] != 'event coordinator') {

    $reg_number = $_POST['reg_number'];
    $query = "SELECT dept,house_name, reg_no,role, name, password FROM admindb WHERE reg_no = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $reg_number);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $dept, $house_name, $reg_no, $role, $username, $hashed_password);
        mysqli_stmt_fetch($stmt);
        
        $password = $_POST['password'];
        
        if (password_verify($password, $hashed_password) && $_POST['role'] === $role) {
            // session_unset();
            $_SESSION['role'] = $role;
            $_SESSION['reg_no'] = $reg_no;
            $_SESSION['name'] = $username;
            $_SESSION['house_name'] = $house_name;
            $_SESSION['dept'] = $dept;

            header('Location: ../../pages/houseDashboard.php');
            exit();
        } else {
            echo "Incorrect username or password or role";
            $error = "Incorrect username or password or role";
        }
    } else {
        // echo "User not found";
        // $error = "User not found";
        header('Location: ../../index.php');
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
// student login
else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_number']) && isset($_POST['role']) && $_POST['role'] != 'event coordinator'){
    
    $reg_number = $_POST['reg_number'];
    $query = "SELECT name,reg_no,house,dept,gender,year FROM studentdb WHERE reg_no = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $reg_number);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $name, $reg_no, $house, $dept, $gender, $year);
        mysqli_stmt_fetch($stmt);

        if($_POST['reg_number'] === $reg_no){
            session_unset();
            $_SESSION['name'] = $name;
            $_SESSION['reg_no'] = $reg_no;
            $_SESSION['house'] = $house;
            $_SESSION['dept'] = $dept;
            $_SESSION['gender'] = $gender;
            $_SESSION['year'] = $year;

            header('Location: ../../pages/studentDashboard.php');
            exit();
        }else {
            echo "Incorrect register number";
        }
    }else {
        // echo "User not found";
        // $error = "User not found";
        header('Location: ../../index.php');
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
// event coordinator login
else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_name']) && isset($_POST['password']) && isset($_POST['role'])){
    
    $event_name = $_POST['event_name'];
    $query = "SELECT dept,event_name, reg_no,role, name, password FROM admindb WHERE event_name = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $event_name);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $dept, $event_name, $reg_no, $role, $username, $hashed_password);
        mysqli_stmt_fetch($stmt);
        
        $password = $_POST['password'];
        
        if (password_verify($password, $hashed_password) && $_POST['role'] === $role) {
            session_unset();
            $_SESSION['role'] = $role;
            $_SESSION['reg_no'] = $reg_no;
            $_SESSION['name'] = $username;
            $_SESSION['dept'] = $dept;
            $_SESSION['event_name'] = $event_name;
            
            header('Location: ../../pages/eventCoordinatorDashboard.php');
            exit();
        } else {
            echo "Incorrect username or password or role";
            $error = "Incorrect username or password or role";
        }
    } else {
        // echo "User not found";
        // $error = "User not found";
        header('Location: ../../index.php');
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>