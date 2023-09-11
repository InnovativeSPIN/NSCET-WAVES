<?php 
include_once '../connect.php';

if(isset($_POST['importExcelFile'])){ 
    $csvFile = '../../database/studentData/Sports Boys A TEAM.csv';

    if (($handle = fopen($csvFile, 'r')) !== false) {
        $header = fgetcsv($handle, 1000, ',');
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $reg_no = $conn->real_escape_string($data[1]);
            $stu_name = $conn->real_escape_string($data[2]);
            $final_col = $conn->real_escape_string($data[3]);
            echo $reg_no;
            $parts = explode("/", $final_col);
            if (count($parts) === 2) {
                $year = $parts[0];
                $dept = $parts[1];
            }

            // $house_name = $conn->real_escape_string($_POST['house_name']);
            // $gender = $conn->real_escape_string($_POST['gender']);

            echo $reg_no;
            $sql = "INSERT INTO studentdb(name,reg_no,house,dept,gender,year) VALUES ('$stu_name', '$reg_no','heelo','$dept','BOYS','$year')";
            $result = $conn->query($sql);
    
            if (!$result) {
                die("Error: " . $conn->error);
            }
        }
        fclose($handle);
    }
    
    $conn->close();
}
 
?>