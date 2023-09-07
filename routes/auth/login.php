<?php
include('../connect.php');
?>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_number']) && isset($_POST['password']) && isset($_POST['role']) && $_POST['role'] != 'student') {

    $reg_number = $_POST['reg_number'];
    $query = "SELECT reg_no,role, name, password FROM admindb WHERE reg_no = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $reg_number);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $reg_no, $role, $username, $hashed_password);
        mysqli_stmt_fetch($stmt);
        
        $password = $_POST['password'];
        
        if (password_verify($password, $hashed_password) && $_POST['role'] === $role) {
            $_SESSION['role'] = $role;
            $_SESSION['reg_no'] = $reg_no;
            $_SESSION['name'] = $username;

            header('Location: ../../dashboard.php');
            exit();
        } else {
            echo "Incorrect username or password or role";
            $error = "Incorrect username or password or role";
        }
    } else {
        echo "User not found";
        $error = "User not found";
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}else{
    echo 'neet to connect studb';
}

?>