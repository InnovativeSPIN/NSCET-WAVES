<?php
ob_start();
include_once '../connect.php';

if (isset($_POST['importExcelFile'])) {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        $csvFileTmpName = $_FILES['csvFile']['tmp_name'];

        if (($handle = fopen($csvFileTmpName, 'r')) !== false) {

            $rawHeader = fgetcsv($handle, 1000, ',');
            if ($rawHeader) {
                // Strip UTF-8 BOM if present on the first header
                $rawHeader[0] = preg_replace('/^\xEF\xBB\xBF/', '', $rawHeader[0]);
                $header = array_map(function($h) {
                    $cleaned = preg_replace('/[^a-zA-Z0-9_]/', '', str_replace([' ', '-'], '_', strtolower(trim($h))));
                    return $cleaned;
                }, $rawHeader);

                $insertedCount = 0;
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    if (count($data) < count($header)) {
                        $data = array_pad($data, count($header), '');
                    }
                    $row = array_combine($header, array_slice($data, 0, count($header)));

                    // Support column variations
                    $stu_name = '';
                    foreach (['name', 'student_name', 'studentname', 'student'] as $k) {
                        if (!empty($row[$k])) { $stu_name = trim($row[$k]); break; }
                    }

                    $inputRegNo = '';
                    foreach (['reg_no', 'regno', 'register_no', 'admission_no', 'admissionno', 'roll_no', 'rollno', 'id'] as $k) {
                        if (!empty($row[$k])) { $inputRegNo = trim($row[$k]); break; }
                    }

                    $dept = '';
                    foreach (['dept', 'department', 'branch'] as $k) {
                        if (!empty($row[$k])) { $dept = trim($row[$k]); break; }
                    }

                    $stu_batch = '';
                    foreach (['year', 'batch', 'class_year', 'academic_year'] as $k) {
                        if (!empty($row[$k])) { $stu_batch = trim($row[$k]); break; }
                    }

                    // Skip empty rows
                    if (empty($stu_name) && empty($inputRegNo)) {
                        continue;
                    }

                    $batch_year = [
                        "2022" => "IV",
                        "2023" => "III",
                        "2024" => "II",
                        "2025" => "I"
                    ];
                    $year = isset($batch_year[$stu_batch]) ? $batch_year[$stu_batch] : $stu_batch;

                    $stu_name_esc   = $conn->real_escape_string($stu_name);
                    $inputRegNo_esc = $conn->real_escape_string($inputRegNo);
                    $dept_esc       = $conn->real_escape_string($dept);
                    $year_esc       = $conn->real_escape_string($year);
                    $house_name     = $conn->real_escape_string($_POST['house_name'] ?? '');
                    $gender         = $conn->real_escape_string($_POST['gender'] ?? 'M');

                    $sql = "INSERT INTO studentdb (name, reg_no, house, dept, gender, year) 
                            VALUES ('$stu_name_esc', '$inputRegNo_esc', '$house_name', '$dept_esc', '$gender', '$year_esc')
                            ON DUPLICATE KEY UPDATE
                                name='$stu_name_esc',
                                house='$house_name',
                                dept='$dept_esc',
                                gender='$gender',
                                year='$year_esc'";

                    $result = $conn->query($sql);
                    if ($result) {
                        $insertedCount++;
                    }
                }
            }

            fclose($handle);
        }
    }

    $conn->close();
    header('Location: ../../pages/adminForm.php?success=students_imported');
}
ob_end_flush();
