<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    $asset_id = $_POST['dispose_ID'];
    $asset_no = $_POST['asset_no'];
    $catg = $_POST['category'];
    $descr = $_POST['desc'];
    $serial = $_POST['serialno'];
    $status = $_POST['stat'];
    $date = $_POST['issuedate'];

    $q_update_disposed = $conn->prepare("UPDATE disposed_assets_tbl
                                         SET Asset_No = ?,
                                             Category = ?,
                                             Descr = ?,
                                             Serial_No = ?,
                                             Stat = ?,
                                             Disposal_Date = ?
                                         WHERE Disposed_ID = ?");

    if($q_update_disposed){

        $q_update_disposed->bind_param("sssssss", $asset_no, $catg, $descr, $serial, $status, $date, $asset_id);
        if($q_update_disposed->execute()){

            $success = 'Successfully Edited Asset Information!';
            header('Location: ../disposed.php?msg='. $success);

        }else{

            $error = 'Something Went Wrong!';
            header('Location: ../disposed.php?msg='. $error);

        }

    }else{

        $error = 'Error Preparing Statement';
        header('Location: ../disposed.php?msg='. $error);

    }

?>  