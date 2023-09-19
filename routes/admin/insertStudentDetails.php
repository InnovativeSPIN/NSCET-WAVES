<?php
ob_start();
include_once '../connect.php';

if (isset($_POST['importExcelFile'])) {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        $csvFileTmpName = $_FILES['csvFile']['tmp_name'];

        if (($handle = fopen($csvFileTmpName, 'r')) !== false) {
            
            $header = fgetcsv($handle, 1000, ',');
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $dept = $conn->real_escape_string($data[1]);
                $inputRegNo = $conn->real_escape_string($data[2]);
                $inputAdmissionNo = $conn->real_escape_string($data[3]);
                $stu_name = $conn->real_escape_string($data[4]);

                $stu_batch = $conn->real_escape_string($data[5]);

                $batch_year = [
                    "2020" => "IV",
                    "2021" => "III",
                    "2022" => "II",
                    "2023" => "I"
                ];

                $year = $batch_year[$stu_batch];

                if($inputRegNo == ''){
                    $inputRegNo = $inputAdmissionNo;
                }

                $house_name = $conn->real_escape_string($_POST['house_name']);
                $gender = $conn->real_escape_string($_POST['gender']);

                $sql = "INSERT INTO studentdb(name,reg_no,house,dept,gender,year) VALUES ('$stu_name', '$inputRegNo','$house_name','$dept','$gender','$year')";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Error: " . $conn->error);
                }
            }
            fclose($handle);
        }
    }
    $conn->close();
    header('Location: ../../pages/adminForm.php');

}
ob_end_flush();
