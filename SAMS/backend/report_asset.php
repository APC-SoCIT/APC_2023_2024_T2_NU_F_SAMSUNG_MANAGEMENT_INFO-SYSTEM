<?php
include '../database/sams_db.php';
require '../vendor/autoload.php'; // Include the PhpSpreadsheet library

$conn = OpenCon();
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

if (isset($_POST["asset_report"])) {
    $searchbar = $_POST["searchbar"];


    //Without searchbar
    if ($searchbar == "") {

        //For Sort and Filter
        if(isset($_POST['sort']) && $_POST['sort'] != "" && isset($_POST['filter']) && $_POST['filter'] != "" && $_POST['filter_cat'] !=""){

            $request = $_POST['sort'];
            $filter_cat = $_POST['filter_cat'];
            $filter = $_POST['filter'];
            $flag_stat = $_POST['flag'];
            $flag = "";
        
            if($flag_stat == 1){
                $flag = "ASC";
            }else if($flag_stat == 0){
                $flag = "DESC";
            }

            $q_getAssets = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                it_assets_tbl.Asset_No as 'Asset No',
                                it_assets_tbl.Category as 'Category',
                                it_assets_tbl.Descr as 'Description',
                                it_assets_tbl.Serial_No as 'Serial Number',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'Fname',
                                employee_tbl.Lname as 'Lname',
                                employee_tbl.Knox_ID as 'Knox ID',
                                cost_center_tbl.Cost_Center as 'Cost Center',
                                assigned_assets_tbl.Stat as 'Status',
                                assigned_assets_tbl.Issued_Date as 'Issued Date' 
                            FROM assigned_assets_tbl
                            INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                            INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                            INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                            WHERE $filter_cat = '$filter' AND assigned_assets_tbl.Stat != 'Disposed'
                            ORDER BY $request $flag";

            $row_asset = mysqli_query($conn, $q_getAssets);

            if (mysqli_num_rows($row_asset) > 0) {
                // Set column headers
                $columnHeaders = [
                    'Asset ID',
                    'Asset Number',
                    'Category',
                    'Description',
                    'Serial Number',
                    'Employee ID',
                    'Assignee',
                    'Knox ID',
                    'Cost Center',
                    'Status',
                    'Issued Date',
                ];

                $colIndex = 1;
                foreach ($columnHeaders as $header) {
                    $sheet->setCellValueByColumnAndRow($colIndex, 1, $header);
                    $colIndex++;
                }

                // Populate data
                $rowIndex = 2;
                while ($row = mysqli_fetch_assoc($row_asset)) {
                    $rowData = [
                        $row['Asset ID'],
                        $row['Asset No'],
                        $row['Category'],
                        $row['Description'],
                        $row['Serial Number'],
                        $row['Employee ID'],
                        $row['Fname'] . " " . $row['Lname'],
                        $row['Knox ID'],
                        $row['Cost Center'],
                        $row['Status'],
                        $row['Issued Date'],
                    ];

                    $colIndex = 1;
                    foreach ($rowData as $cellData) {
                        $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $cellData);
                        $colIndex++;
                    }

                    $rowIndex++;
                }

                // Create Excel file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $file_name = "asset-report_" . date('Y-m-d') . " .xlsx";

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $file_name . '"');
                $writer->save('php://output');
                exit();
            }else{
                header("Location: ../asset.php?error_msg=Table is Empty!");
            }
        
        }
        //For filter only
        else if(isset($_POST['filter']) && $_POST['filter'] != "" && $_POST['filter_cat'] !=""){

            $filter_cat = $_POST['filter_cat'];
            $filter = $_POST['filter'];

            $q_getAssets = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                it_assets_tbl.Asset_No as 'Asset No',
                                it_assets_tbl.Category as 'Category',
                                it_assets_tbl.Descr as 'Description',
                                it_assets_tbl.Serial_No as 'Serial Number',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'Fname',
                                employee_tbl.Lname as 'Lname',
                                employee_tbl.Knox_ID as 'Knox ID',
                                cost_center_tbl.Cost_Center as 'Cost Center',
                                assigned_assets_tbl.Stat as 'Status',
                                assigned_assets_tbl.Issued_Date as 'Issued Date' 
                            FROM assigned_assets_tbl
                            INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                            INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                            INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                            WHERE $filter_cat = '$filter' AND assigned_assets_tbl.Stat != 'Disposed'";

            $row_asset = mysqli_query($conn, $q_getAssets);

            if (mysqli_num_rows($row_asset) > 0) {
                // Set column headers
                $columnHeaders = [
                    'Asset ID',
                    'Asset Number',
                    'Category',
                    'Description',
                    'Serial Number',
                    'Employee ID',
                    'Assignee',
                    'Knox ID',
                    'Cost Center',
                    'Status',
                    'Issued Date',
                ];

                $colIndex = 1;
                foreach ($columnHeaders as $header) {
                    $sheet->setCellValueByColumnAndRow($colIndex, 1, $header);
                    $colIndex++;
                }

                // Populate data
                $rowIndex = 2;
                while ($row = mysqli_fetch_assoc($row_asset)) {
                    $rowData = [
                        $row['Asset ID'],
                        $row['Asset No'],
                        $row['Category'],
                        $row['Description'],
                        $row['Serial Number'],
                        $row['Employee ID'],
                        $row['Fname'] . " " . $row['Lname'],
                        $row['Knox ID'],
                        $row['Cost Center'],
                        $row['Status'],
                        $row['Issued Date'],
                    ];

                    $colIndex = 1;
                    foreach ($rowData as $cellData) {
                        $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $cellData);
                        $colIndex++;
                    }

                    $rowIndex++;
                }

                // Create Excel file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $file_name = "asset-report_" . date('Y-m-d') . " .xlsx";

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $file_name . '"');
                $writer->save('php://output');
                exit();
            }else{
                header("Location: ../asset.php?error_msg=Table is Empty!");
            }

        }

        //For sort only
        elseif(isset($_POST['sort']) && $_POST['sort'] != ""){

            $request = $_POST['sort'];
            $flag_stat = $_POST['flag'];
            $flag = "";

            if($flag_stat == 1){
                $flag = "ASC";
            }else if($flag_stat == 0){
                $flag = "DESC";
            }

            $q_getAssets = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                it_assets_tbl.Asset_No as 'Asset No',
                                it_assets_tbl.Category as 'Category',
                                it_assets_tbl.Descr as 'Description',
                                it_assets_tbl.Serial_No as 'Serial Number',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'Fname',
                                employee_tbl.Lname as 'Lname',
                                employee_tbl.Knox_ID as 'Knox ID',
                                cost_center_tbl.Cost_Center as 'Cost Center',
                                assigned_assets_tbl.Stat as 'Status',
                                assigned_assets_tbl.Issued_Date as 'Issued Date' 
                            FROM assigned_assets_tbl
                            INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                            INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                            INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                            WHERE assigned_assets_tbl.Stat != 'Disposed'
                            ORDER BY $request $flag";

            $row_asset = mysqli_query($conn, $q_getAssets);

            if (mysqli_num_rows($row_asset) > 0) {
                // Set column headers
                $columnHeaders = [
                    'Asset ID',
                    'Asset Number',
                    'Category',
                    'Description',
                    'Serial Number',
                    'Employee ID',
                    'Assignee',
                    'Knox ID',
                    'Cost Center',
                    'Status',
                    'Issued Date',
                ];

                $colIndex = 1;
                foreach ($columnHeaders as $header) {
                    $sheet->setCellValueByColumnAndRow($colIndex, 1, $header);
                    $colIndex++;
                }

                // Populate data
                $rowIndex = 2;
                while ($row = mysqli_fetch_assoc($row_asset)) {
                    $rowData = [
                        $row['Asset ID'],
                        $row['Asset No'],
                        $row['Category'],
                        $row['Description'],
                        $row['Serial Number'],
                        $row['Employee ID'],
                        $row['Fname'] . " " . $row['Lname'],
                        $row['Knox ID'],
                        $row['Cost Center'],
                        $row['Status'],
                        $row['Issued Date'],
                    ];

                    $colIndex = 1;
                    foreach ($rowData as $cellData) {
                        $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $cellData);
                        $colIndex++;
                    }

                    $rowIndex++;
                }

                // Create Excel file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $file_name = "asset-report_" . date('Y-m-d') . " (FULL).xlsx";

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $file_name . '"');
                $writer->save('php://output');
                exit();
            }else{
                header("Location: ../asset.php?error_msg=Table is Empty!");
            }

        //No sort or filtering
        }else{
            $q_getAssets = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                it_assets_tbl.Asset_No as 'Asset No',
                                it_assets_tbl.Category as 'Category',
                                it_assets_tbl.Descr as 'Description',
                                it_assets_tbl.Serial_No as 'Serial Number',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'Fname',
                                employee_tbl.Lname as 'Lname',
                                employee_tbl.Knox_ID as 'Knox ID',
                                cost_center_tbl.Cost_Center as 'Cost Center',
                                assigned_assets_tbl.Stat as 'Status',
                                assigned_assets_tbl.Issued_Date as 'Issued Date' 
                            FROM assigned_assets_tbl
                            INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                            INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                            INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID;";

            $row_asset = mysqli_query($conn, $q_getAssets);

            if (mysqli_num_rows($row_asset) > 0) {
                // Set column headers
                $columnHeaders = [
                    'Asset ID',
                    'Asset Number',
                    'Category',
                    'Description',
                    'Serial Number',
                    'Employee ID',
                    'Assignee',
                    'Knox ID',
                    'Cost Center',
                    'Status',
                    'Issued Date',
                ];

                $colIndex = 1;
                foreach ($columnHeaders as $header) {
                    $sheet->setCellValueByColumnAndRow($colIndex, 1, $header);
                    $colIndex++;
                }

                // Populate data
                $rowIndex = 2;
                while ($row = mysqli_fetch_assoc($row_asset)) {
                    $rowData = [
                        $row['Asset ID'],
                        $row['Asset No'],
                        $row['Category'],
                        $row['Description'],
                        $row['Serial Number'],
                        $row['Employee ID'],
                        $row['Fname'] . " " . $row['Lname'],
                        $row['Knox ID'],
                        $row['Cost Center'],
                        $row['Status'],
                        $row['Issued Date'],
                    ];

                    $colIndex = 1;
                    foreach ($rowData as $cellData) {
                        $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $cellData);
                        $colIndex++;
                    }

                    $rowIndex++;
                }

                // Create Excel file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $file_name = "asset-report_" . date('Y-m-d') . " (FULL).xlsx";

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $file_name . '"');
                $writer->save('php://output');
                exit();
            }else{
                header("Location: ../asset.php?error_msg=Table is Empty!");
            }

        }

    //Searchbar is set
    }else{
        //For Sort and Filter
        if(isset($_POST['sort']) && $_POST['sort'] != "" && isset($_POST['filter']) && $_POST['filter'] != "" && $_POST['filter_cat'] !=""){

            $request = $_POST['sort'];
            $input = $_POST['input'];
            $filter_cat = $_POST['filter_cat'];
            $filter = $_POST['filter'];
            $flag_stat = $_POST['flag'];
            $flag ="";

            if($flag_stat == 1){
                $flag = "ASC";
            }else if($flag_stat == 0){
                $flag = "DESC";
            }

            $q_getAssets = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                    it_assets_tbl.Asset_No as 'Asset No',
                                    it_assets_tbl.Category as 'Category',
                                    it_assets_tbl.Descr as 'Description',
                                    it_assets_tbl.Serial_No as 'Serial Number',
                                    employee_tbl.Employee_ID as 'Employee ID',
                                    employee_tbl.Fname as 'Fname',
                                    employee_tbl.Lname as 'Lname',
                                    employee_tbl.Knox_ID as 'Knox ID',
                                    cost_center_tbl.Cost_Center as 'Cost Center',
                                    assigned_assets_tbl.Stat as 'Status',
                                    assigned_assets_tbl.Issued_Date as 'Issued Date' 
                                    FROM assigned_assets_tbl
                                    INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                                    INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                                    INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                                    WHERE (assigned_assets_tbl.Asset_ID LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Asset_No LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Category LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Descr LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Serial_No LIKE '{$searchbar}%' OR
                                    employee_tbl.Employee_ID LIKE '{$searchbar}%' OR
                                    employee_tbl.Fname LIKE '{$searchbar}%' OR
                                    employee_tbl.Lname LIKE '{$searchbar}%' OR
                                    employee_tbl.Knox_ID LIKE '{$searchbar}%' OR
                                    cost_center_tbl.Cost_Center LIKE '{$searchbar}%' OR
                                    assigned_assets_tbl.Stat LIKE '{$searchbar}%' OR
                                    assigned_assets_tbl.Issued_Date LIKE '{$searchbar}%') AND
                                    $filter_cat = '$filter' AND assigned_assets_tbl.Stat != 'Disposed'
                                    ORDER BY $request $flag";

            $row_asset = mysqli_query($conn, $q_getAssets);

            if (mysqli_num_rows($row_asset) > 0) {
                // Set column headers
                $columnHeaders = [
                    'Asset ID',
                    'Asset Number',
                    'Category',
                    'Description',
                    'Serial Number',
                    'Employee ID',
                    'Assignee',
                    'Knox ID',
                    'Cost Center',
                    'Status',
                    'Issued Date',
                ];

                $colIndex = 1;
                foreach ($columnHeaders as $header) {
                    $sheet->setCellValueByColumnAndRow($colIndex, 1, $header);
                    $colIndex++;
                }

                // Populate data
                $rowIndex = 2;
                while ($row = mysqli_fetch_assoc($row_asset)) {
                    $rowData = [
                        $row['Asset ID'],
                        $row['Asset No'],
                        $row['Category'],
                        $row['Description'],
                        $row['Serial Number'],
                        $row['Employee ID'],
                        $row['Fname'] . " ". $row['Lname'],
                        $row['Knox ID'],
                        $row['Cost Center'],
                        $row['Status'],
                        $row['Issued Date'],
                    ];

                    $colIndex = 1;
                    foreach ($rowData as $cellData) {
                        $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $cellData);
                        $colIndex++;
                    }

                    $rowIndex++;
                }

                // Create Excel file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $file_name = "asset-report_" . date('Y-m-d') . ".xlsx";

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $file_name . '"');
                $writer->save('php://output');
                exit();
            }else{
                header("Location: ../asset.php?error_msg=Table is Empty!");
            }


        }
        //For filter
        else if(isset($_POST['filter']) && $_POST['filter'] != "" && $_POST['sort'] == "" && $_POST['filter_cat'] != ""){

            $filter_cat = $_POST['filter_cat'];
            $filter = $_POST['filter'];


            $q_getAssets = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                    it_assets_tbl.Asset_No as 'Asset No',
                                    it_assets_tbl.Category as 'Category',
                                    it_assets_tbl.Descr as 'Description',
                                    it_assets_tbl.Serial_No as 'Serial Number',
                                    employee_tbl.Employee_ID as 'Employee ID',
                                    employee_tbl.Fname as 'Fname',
                                    employee_tbl.Lname as 'Lname',
                                    employee_tbl.Knox_ID as 'Knox ID',
                                    cost_center_tbl.Cost_Center as 'Cost Center',
                                    assigned_assets_tbl.Stat as 'Status',
                                    assigned_assets_tbl.Issued_Date as 'Issued Date' 
                                    FROM assigned_assets_tbl
                                    INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                                    INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                                    INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                                    WHERE (assigned_assets_tbl.Asset_ID LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Asset_No LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Category LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Descr LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Serial_No LIKE '{$searchbar}%' OR
                                    employee_tbl.Employee_ID LIKE '{$searchbar}%' OR
                                    employee_tbl.Fname LIKE '{$searchbar}%' OR
                                    employee_tbl.Lname LIKE '{$searchbar}%' OR
                                    employee_tbl.Knox_ID LIKE '{$searchbar}%' OR
                                    cost_center_tbl.Cost_Center LIKE '{$searchbar}%' OR
                                    assigned_assets_tbl.Stat LIKE '{$searchbar}%' OR
                                    assigned_assets_tbl.Issued_Date LIKE '{$searchbar}%') AND
                                    $filter_cat = '$filter' AND assigned_assets_tbl.Stat != 'Disposed'";

            $row_asset = mysqli_query($conn, $q_getAssets);

            if (mysqli_num_rows($row_asset) > 0) {
                // Set column headers
                $columnHeaders = [
                    'Asset ID',
                    'Asset Number',
                    'Category',
                    'Description',
                    'Serial Number',
                    'Employee ID',
                    'Assignee',
                    'Knox ID',
                    'Cost Center',
                    'Status',
                    'Issued Date',
                ];

                $colIndex = 1;
                foreach ($columnHeaders as $header) {
                    $sheet->setCellValueByColumnAndRow($colIndex, 1, $header);
                    $colIndex++;
                }

                // Populate data
                $rowIndex = 2;
                while ($row = mysqli_fetch_assoc($row_asset)) {
                    $rowData = [
                        $row['Asset ID'],
                        $row['Asset No'],
                        $row['Category'],
                        $row['Description'],
                        $row['Serial Number'],
                        $row['Employee ID'],
                        $row['Fname'] . " ". $row['Lname'],
                        $row['Knox ID'],
                        $row['Cost Center'],
                        $row['Status'],
                        $row['Issued Date'],
                    ];

                    $colIndex = 1;
                    foreach ($rowData as $cellData) {
                        $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $cellData);
                        $colIndex++;
                    }

                    $rowIndex++;
                }

                // Create Excel file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $file_name = "asset-report_" . date('Y-m-d') . ".xlsx";

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $file_name . '"');
                $writer->save('php://output');
                exit();
            }else{
                header("Location: ../asset.php?error_msg=Table is Empty!");
            }

        }
        //For sort only
        else if(isset($_POST['sort']) && $_POST['sort'] != ""){

            $request = $_POST['sort'];
            $flag_stat = $_POST['flag'];
            $flag ="";

            if($flag_stat == 1){
                $flag = "ASC";
            }else if($flag_stat == 0){
                $flag = "DESC";
            }

            $q_getAssets = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                        it_assets_tbl.Asset_No as 'Asset No',
                                        it_assets_tbl.Category as 'Category',
                                        it_assets_tbl.Descr as 'Description',
                                        it_assets_tbl.Serial_No as 'Serial Number',
                                        employee_tbl.Employee_ID as 'Employee ID',
                                        employee_tbl.Fname as 'Fname',
                                        employee_tbl.Lname as 'Lname',
                                        employee_tbl.Knox_ID as 'Knox ID',
                                        cost_center_tbl.Cost_Center as 'Cost Center',
                                        assigned_assets_tbl.Stat as 'Status',
                                        assigned_assets_tbl.Issued_Date as 'Issued Date' 
                                        FROM assigned_assets_tbl
                                        INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                                        INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                                        INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                                        WHERE (assigned_assets_tbl.Asset_ID LIKE '{$searchbar}%' OR
                                        it_assets_tbl.Asset_No LIKE '{$searchbar}%' OR
                                        it_assets_tbl.Category LIKE '{$searchbar}%' OR
                                        it_assets_tbl.Descr LIKE '{$searchbar}%' OR
                                        it_assets_tbl.Serial_No LIKE '{$searchbar}%' OR
                                        employee_tbl.Employee_ID LIKE '{$searchbar}%' OR
                                        employee_tbl.Fname LIKE '{$searchbar}%' OR
                                        employee_tbl.Lname LIKE '{$searchbar}%' OR
                                        employee_tbl.Knox_ID LIKE '{$searchbar}%' OR
                                        cost_center_tbl.Cost_Center LIKE '{$searchbar}%' OR
                                        assigned_assets_tbl.Stat LIKE '{$searchbar}%' OR
                                        assigned_assets_tbl.Issued_Date LIKE '{$searchbar}%')
                                        AND assigned_assets_tbl.Stat != 'Disposed'
                                        ORDER BY $request $flag";

                $row_asset = mysqli_query($conn, $q_getAssets);

                if (mysqli_num_rows($row_asset) > 0) {
                    // Set column headers
                    $columnHeaders = [
                        'Asset ID',
                        'Asset Number',
                        'Category',
                        'Description',
                        'Serial Number',
                        'Employee ID',
                        'Assignee',
                        'Knox ID',
                        'Cost Center',
                        'Status',
                        'Issued Date',
                    ];

                    $colIndex = 1;
                    foreach ($columnHeaders as $header) {
                        $sheet->setCellValueByColumnAndRow($colIndex, 1, $header);
                        $colIndex++;
                    }

                    // Populate data
                    $rowIndex = 2;
                    while ($row = mysqli_fetch_assoc($row_asset)) {
                        $rowData = [
                            $row['Asset ID'],
                            $row['Asset No'],
                            $row['Category'],
                            $row['Description'],
                            $row['Serial Number'],
                            $row['Employee ID'],
                            $row['Fname'] . " ". $row['Lname'],
                            $row['Knox ID'],
                            $row['Cost Center'],
                            $row['Status'],
                            $row['Issued Date'],
                        ];

                        $colIndex = 1;
                        foreach ($rowData as $cellData) {
                            $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $cellData);
                            $colIndex++;
                        }

                        $rowIndex++;
                    }

                    // Create Excel file
                    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                    $file_name = "asset-report_" . date('Y-m-d') . ".xlsx";

                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment; filename="' . $file_name . '"');
                    $writer->save('php://output');
                    exit();
                }else{
                    header("Location: ../asset.php?error_msg=Table is Empty!");
                }
        //No sort or filter
        }else{

            $q_getAssets = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                    it_assets_tbl.Asset_No as 'Asset No',
                                    it_assets_tbl.Category as 'Category',
                                    it_assets_tbl.Descr as 'Description',
                                    it_assets_tbl.Serial_No as 'Serial Number',
                                    employee_tbl.Employee_ID as 'Employee ID',
                                    employee_tbl.Fname as 'Fname',
                                    employee_tbl.Lname as 'Lname',
                                    employee_tbl.Knox_ID as 'Knox ID',
                                    cost_center_tbl.Cost_Center as 'Cost Center',
                                    assigned_assets_tbl.Stat as 'Status',
                                    assigned_assets_tbl.Issued_Date as 'Issued Date' 
                                    FROM assigned_assets_tbl
                                    INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                                    INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                                    INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                                    WHERE (assigned_assets_tbl.Asset_ID LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Asset_No LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Category LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Descr LIKE '{$searchbar}%' OR
                                    it_assets_tbl.Serial_No LIKE '{$searchbar}%' OR
                                    employee_tbl.Employee_ID LIKE '{$searchbar}%' OR
                                    employee_tbl.Fname LIKE '{$searchbar}%' OR
                                    employee_tbl.Lname LIKE '{$searchbar}%' OR
                                    employee_tbl.Knox_ID LIKE '{$searchbar}%' OR
                                    cost_center_tbl.Cost_Center LIKE '{$searchbar}%' OR
                                    assigned_assets_tbl.Stat LIKE '{$searchbar}%' OR
                                    assigned_assets_tbl.Issued_Date LIKE '{$searchbar}%')
                                    AND assigned_assets_tbl.Stat != 'Disposed'";

            $row_asset = mysqli_query($conn, $q_getAssets);

            if (mysqli_num_rows($row_asset) > 0) {
                // Set column headers
                $columnHeaders = [
                    'Asset ID',
                    'Asset Number',
                    'Category',
                    'Description',
                    'Serial Number',
                    'Employee ID',
                    'Assignee',
                    'Knox ID',
                    'Cost Center',
                    'Status',
                    'Issued Date',
                ];

                $colIndex = 1;
                foreach ($columnHeaders as $header) {
                    $sheet->setCellValueByColumnAndRow($colIndex, 1, $header);
                    $colIndex++;
                }

                // Populate data
                $rowIndex = 2;
                while ($row = mysqli_fetch_assoc($row_asset)) {
                    $rowData = [
                        $row['Asset ID'],
                        $row['Asset No'],
                        $row['Category'],
                        $row['Description'],
                        $row['Serial Number'],
                        $row['Employee ID'],
                        $row['Fname'] . " ". $row['Lname'],
                        $row['Knox ID'],
                        $row['Cost Center'],
                        $row['Status'],
                        $row['Issued Date'],
                    ];

                    $colIndex = 1;
                    foreach ($rowData as $cellData) {
                        $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $cellData);
                        $colIndex++;
                    }

                    $rowIndex++;
                }

                // Create Excel file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $file_name = "asset-report_" . date('Y-m-d') . ".xlsx";

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $file_name . '"');
                $writer->save('php://output');
                exit();
            }else{
                header("Location: ../asset.php?error_msg=Table is Empty!");
            }

        }
            
    }
} else {
    header("Location: ../asset.php?Something Wrong!");
}
?>
