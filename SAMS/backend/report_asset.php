<?php
include '../database/sams_db.php';
require '../vendor/autoload.php'; // Include the PhpSpreadsheet library

$conn = OpenCon();
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

if (isset($_POST["asset_report"])) {
    $searchbar = $_POST["searchbar"];

    if ($searchbar == "") {
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
                                WHERE assigned_assets_tbl.Asset_ID LIKE '{$searchbar}%' OR
                                it_assets_tbl.Asset_No LIKE '{$searchbar}%' OR
                                it_assets_tbl.Category LIKE '{$searchbar}%' OR
                                it_assets_tbl.Descr LIKE '{$searchbar}%' OR
                                it_assets_tbl.Serial_No LIKE '{$searchbar}%' OR
                                employee_tbl.Employee_ID LIKE '{$searchbar}%' OR
                                employee_tbl.Fname LIKE '{$searchbar}%' OR
                                employee_tbl.Lname LIKE '{$searchbar}%' OR
                                employee_tbl.Knox_ID LIKE '{$searchbar}%' OR
                                cost_center_tbl.Cost_Center LIKE '{$searchbar}%' OR
                                Stat LIKE '{$searchbar}%' OR
                                Issued_Date LIKE '{$searchbar}%'";

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
} else {
    header("Location: ../asset.php?Something Wrong!");
}
?>
