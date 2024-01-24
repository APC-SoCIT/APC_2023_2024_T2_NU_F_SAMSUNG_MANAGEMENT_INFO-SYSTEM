<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    $asset_id = $_POST['asset_id'];
    $asset_no = $_POST['asset_no'];
    $catg = $_POST['category'];
    $desc = $_POST['desc'];
    $serial_no = $_POST['serialno'];
    $stat = $_POST['stat'];
    $issuedate = $_POST['issuedate'];

    $q_UPDATE_ASSET_INFO = "UPDATE it_assets_tbl
                            SET Asset_No = '$asset_no',
                                Category = '$catg',
                                Descr = '$desc',
                                Serial_No = '$serial_no'
                            WHERE Asset_ID = '$asset_id';";

    $q_UPDATE_STATUS_DATE = "UPDATE assigned_assets_tbl
                            SET Stat = '$stat',
                                Issued_Date = '$issuedate'
                            WHERE Asset_ID = '$asset_id';";

if (mysqli_query($conn, $q_UPDATE_ASSET_INFO) && mysqli_query($conn, $q_UPDATE_STATUS_DATE)) {
    $successmsg = "Update successful!";
    header("Location: ../asset-assign.php?msg=$successmsg");
} else {
    $errormsg = mysqli_error($connection);
    header("Location: ../asset-assign.php?error_msg=$errormsg");
}

?>