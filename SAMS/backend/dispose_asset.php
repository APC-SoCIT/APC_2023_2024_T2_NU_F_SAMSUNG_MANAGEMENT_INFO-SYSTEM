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

            $row = mysqli_fetch_assoc($row_asset);

            $asset_no = $row['Asset_No'];
            $catg = $row['Category'];
            $descr = $row['Descr'];
            $serial_no = $row['Serial_No'];

                $q_insert_disposed = "INSERT INTO disposed_assets_tbl(
                                                                    Asset_No,
                                                                    Category,
                                                                    Descr,
                                                                    Serial_No,
                                                                    Stat,
                                                                    Disposal_Date)
                                    VALUES($asset_no, '$catg', '$descr', '$serial_no', '$status', now())";

                if(mysqli_query($conn, $q_insert_disposed)){

                    $q_del_asset = "DELETE FROM it_assets_tbl
                                    WHERE Asset_ID IN ($escapedSelectedAssets)";

                    mysqli_query($conn, $q_del_asset);

                    $success = "Successfully Disposed Asset/s";
                    header('Location: ../disposed.php?msg='.$success);

                }

        }

    }

?>