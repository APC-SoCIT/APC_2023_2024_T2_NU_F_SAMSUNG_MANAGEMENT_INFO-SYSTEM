<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    if (isset($_POST["selected_assets"])) {
        $selectedAssetsString = $_POST["selected_assets"];
        $escapedSelectedAssets = implode(",", array_map(function($value) use ($conn) {
            return "'" . mysqli_real_escape_string($conn, $value) . "'";
        }, explode(",", $selectedAssetsString))); // Escape and prepare selected assets


        $selectedAssets = explode(',', $escapedSelectedAssets);
        $placeholders = str_repeat('?, ', count($selectedAssets) - 1) . '?';

        $employee_id = $_POST['employee_id'];
        $current_date = date("Y-m-d");
        
        $q_searchEmployeeID = "SELECT * FROM employee_tbl WHERE Employee_ID = '$employee_id'";
        $q_searchAsset_desc = "SELECT * FROM it_assets_tbl WHERE Asset_ID IN ($escapedSelectedAssets)";

        $row_asset_desc = mysqli_query($conn, $q_searchAsset_desc);
        $row_employeeIDs = mysqli_query($conn, $q_searchEmployeeID);

        if(mysqli_num_rows($row_asset_desc) == 0){
            header("Location: ../asset-assign.php?error-msg=Asset/s doesn't exist!");
        }else if(mysqli_num_rows($row_employeeIDs) == 0){
            header("Location: ../asset-assign.php?error-msg=Employee ID doesn't exist! Value: $employee_id");
        }else{

            $row = mysqli_fetch_assoc($row_employeeIDs);
            
            $sys_id = $row['System_ID'];
            
            if($sys_id == 1){
                $stat = 'Returned';

                $q_assignAsset = "UPDATE assigned_assets_tbl
                SET System_ID = '$sys_id',
                    Stat = '$stat',
                    Issued_Date = '$current_date'
                WHERE Asset_ID IN ($escapedSelectedAssets)";
            }else{
                $stat = 'Assigned';

                $q_assignAsset = "UPDATE assigned_assets_tbl
                SET System_ID = '$sys_id',
                    Stat = '$stat',
                    Issued_Date = '$current_date'
                WHERE Asset_ID IN ($escapedSelectedAssets)";
            }
            
            $rst_updateAssetTbl = mysqli_query($conn, $q_assignAsset);

            for ($i =  0; $i < count($selectedAssets); $i++) {
                $asset_id = $selectedAssets[$i];
                // Logs
                $q_insertLogs = "INSERT INTO logs_tbl(Asset_ID, System_ID, Stat, Issued_Date) 
                VALUES ($asset_id, $sys_id, '$stat', '$current_date')";

                mysqli_query($conn, $q_insertLogs);
            }
            
            header("Location: ../asset-assign.php?msg=Asset/s assigned successfully!");

        }
    }else{
        echo "Problem with getting assets";
    }

?>