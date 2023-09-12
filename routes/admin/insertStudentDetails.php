<?php
ob_start();
include_once '../connect.php';

if (isset($_POST['importExcelFile'])) {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        $csvFileTmpName = $_FILES['csvFile']['tmp_name'];

        if (($handle = fopen($csvFileTmpName, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');
            function convert1stYearRegNo($inputRegNo) {
                $deptCode = [
                    "AI" => "243",
                    "CE" => "103",
                    "CS" => "104",
                    "EE" => "105",
                    "EC" => "106",
                    "ME" => "114",
                    "IT" => "205",
                ];
                $year = substr($inputRegNo, 0, 2);
                $inputDeptCode = substr($inputRegNo, 2, 2);
                $departmentCode="";
                if (array_key_exists($inputDeptCode, $deptCode)) {
                    global $departmentCode;
                    $departmentCode = $deptCode[$inputDeptCode];
                }
                
                $studentCode = str_pad(substr($inputRegNo, 4), 3, '0', STR_PAD_LEFT);
                $originalRegNo = "9210" . $year . $departmentCode . $studentCode;
            
                return $originalRegNo;
            }
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $inputRegNo = $conn->real_escape_string($data[1]);
                $stu_name = $conn->real_escape_string($data[2]);
                $final_col = $conn->real_escape_string($data[3]);
                $parts = explode("/", $final_col);
                if (count($parts) === 2) {
                    $year = $parts[0];
                    $dept = $parts[1];
                }

                if ($year === 'IV') {
                    continue;
                }

                $yearMapping = [
                    "I" => "II",
                    "II" => "III",
                    "III" => "IV",
                ];

                if (array_key_exists($year, $yearMapping)) {
                    $year = $yearMapping[$year];
                }              
                if (strlen($inputRegNo) === 6) {
                    $reg_no = convert1stYearRegNo($inputRegNo);
                }else{
                    $reg_no = $inputRegNo;
                }

                $house_name = $conn->real_escape_string($_POST['house_name']);
                $gender = $conn->real_escape_string($_POST['gender']);

                $sql = "INSERT INTO studentdb(name,reg_no,house,dept,gender,year) VALUES ('$stu_name', '$reg_no','$house_name','$dept','$gender','$year')";
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
?>