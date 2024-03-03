<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    $descr = $_POST['descr'];
    $serial_no = $_POST['serial_no'];
    $asset_no = $_POST['asset_no'];
    $catg = $_POST['category'];
    $issue_date = $_POST['issued_date'];

    // Add Asset to it_assets_tbl
    $q_insertAsset = $conn->prepare("INSERT INTO it_assets_tbl (Asset_No, Category, Descr, Serial_No)
                     VALUES (?, ?, ?, ?)");

    $q_insertAsset->bind_param("ssss", $asset_no, $catg, $descr, $serial_no);
    if ($q_insertAsset->execute()) {
        
        $last_id = $conn->insert_id;

            // Auto Assign new Assets to MIS Storage

        $sys_id = 1;
        $stat = 'New';

        $q_insertAssignMIS = $conn->prepare("INSERT INTO assigned_assets_tbl (Asset_ID, System_ID, Stat, Issued_Date)
        VALUES (?, ?, ?, ?)");

        // Logs
        $q_insertAssignMISLogs = $conn->prepare("INSERT INTO logs_tbl (Asset_ID, System_ID, Stat, Issued_Date)
        VALUES (?, ?, ?, ?)");

        $q_insertAssignMIS->bind_param("ssss", $last_id, $sys_id, $stat, $issue_date);
        $q_insertAssignMISLogs->bind_param("ssss", $last_id, $sys_id, $stat, $issue_date);

        // Insert to Asset Logs Soon...
        
        if($q_insertAssignMIS->execute()){

            $q_insertAssignMISLogs->execute();
            $successmsg = "Asset inserted successfully.";
            header("Location: ../asset-assign.php?msg=$successmsg");

        }else{
            $error_msg = mysqli_error($conn);
            header("Location: ../asset-assign.php?error-msg=$error_msg");
        }
            
    } else {
        $error_msg = mysqli_error($conn);
        header("Location: ../asset-assign.php?error-msg=$error_msg");
    }

    mysqli_close($conn);
?>