<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    if (isset($_GET["selected_assets"])) {
        $selectedAssetsString = $_GET["selected_assets"];
        $escapedSelectedAssets = implode(",", array_map(function($value) use ($conn) {
            return "'" . mysqli_real_escape_string($conn, $value) . "'";
        }, explode(",", $selectedAssetsString))); // Escape and prepare selected assets


        $selectedAssets = explode(',', $escapedSelectedAssets);
        $placeholders = str_repeat('?, ', count($selectedAssets) - 1) . '?';

        $employee_id = $_GET['employee_id'];
        $current_date = date("Y-m-d");
        
        $q_searchEmployeeID = "SELECT * FROM employee_tbl WHERE Employee_ID = '$employee_id'";
        $q_searchAsset_desc = "SELECT * FROM it_assets_tbl WHERE Asset_ID IN ($escapedSelectedAssets)";

        $row_asset_desc = mysqli_query($conn, $q_searchAsset_desc);
        $row_employeeIDs = mysqli_query($conn, $q_searchEmployeeID);

        if(mysqli_num_rows($row_asset_desc) == 0){
            header("Location: ../asset.php?error_msg=Asset/s doesn't exist!");
        }else if(mysqli_num_rows($row_employeeIDs) == 0){
            header("Location: ../asset.php?error_msg=Employee ID doesn't exist!");
        }else{

            $row = mysqli_fetch_assoc($row_employeeIDs);
            
            $sys_id = $row['System_ID'];
            
            // Concatenate Full Employee Name
            $employee_name = $fname . ' ' . $lname;
            
            $q_assignAsset = "UPDATE assigned_assets_tbl
            SET System_ID = '$sys_id'
            WHERE Asset_ID IN ($escapedSelectedAssets)";
            
            $rst_updateAssetTbl = mysqli_query($conn, $q_assignAsset);
            
            header("Location: ../asset-assign.php?msg=Asset/s assigned successfully!");

        }
    }

?>