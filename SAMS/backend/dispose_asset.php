<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    if(isset($_GET['selected_assets'])){

        $status = $_GET['status'];
        $selectedAssetsString = $_GET["selected_assets"];
        $escapedSelectedAssets = implode(",", array_map(function($value) use ($conn) {
            return "'" . mysqli_real_escape_string($conn, $value) . "'";
        }, explode(",", $selectedAssetsString))); // Escape and prepare selected assets

        $selectedAssets = explode(',', $escapedSelectedAssets);
        $placeholders = str_repeat('?, ', count($selectedAssets) - 1) . '?';

        $q_searchAsset_desc = "SELECT * FROM it_assets_tbl WHERE Asset_ID IN ($escapedSelectedAssets)";
        $row_asset = mysqli_query($conn, $q_searchAsset_desc);

        if(mysqli_num_rows($row_asset) == 0){

            header("Location: ../disposed.php?error-msg=Asset/s doesn't exist!");

        }else{

            while($row = mysqli_fetch_assoc($row_asset)){

                $asset_id = $row['Asset_ID'];

                $q_insert_disposed = "INSERT INTO disposed_assets_tbl(
                                                                    Asset_ID,
                                                                    Stat,
                                                                    Disposal_Date)
                                    VALUES($asset_id, '$status', now())";

                if(mysqli_query($conn, $q_insert_disposed)){

                    $q_del_asset = "UPDATE it_assets_tbl
                                    SET Dispose = 'T'
                                    WHERE Asset_ID = $asset_id";

                    mysqli_query($conn, $q_del_asset);
                }

            }

            $stat = 'Disposed';
            $current_date = date("Y-m-d");

            for ($i =  0; $i < count($selectedAssets); $i++) {
                $asset_id = $selectedAssets[$i];
                $sys_id = 1;
                
                // Logs
                $q_insertLogs = "INSERT INTO logs_tbl(Asset_ID, System_ID, Stat, Issued_Date) 
                VALUES ($asset_id, $sys_id, '$stat', '$current_date')";

                // Update Owner, if asset is disposed return to MIS storage and status = Disposed
                $q_assignAsset = "UPDATE assigned_assets_tbl
                SET System_ID = '$sys_id',
                    Stat = '$stat',
                    Issued_Date = '$current_date'
                WHERE Asset_ID IN ($escapedSelectedAssets)";

                mysqli_query($conn, $q_insertLogs);
                mysqli_query($conn, $q_assignAsset);
            }

            $success = "Successfully Disposed Asset/s";
            header('Location: ../disposed.php?msg='.$success);
            
        }

    }

?>