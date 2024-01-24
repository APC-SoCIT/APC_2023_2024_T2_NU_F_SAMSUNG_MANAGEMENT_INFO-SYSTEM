<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    $sys_id = $_POST['sys_id'];
    $employee_id = $_POST['employee_ID'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $knox_id = $_POST['knox_ID'];
    $dept_id = $_POST['dept'];
    $ccenter = $_POST['cost_center'];   

    if($ccenter == ""){
        header("Location: ../employee.php?error_msg=Please Enter Cost Center!");
    }

    if($dept == ""){
        header("Location: ../employee.php?error_msg=Please Enter Department!");
    }

    $q_GET_CCENTER_ID = "SELECT Cost_Center_ID
                         FROM cost_center_tbl
                         WHERE Cost_Center = '$ccenter'";

    $ccenter_id_rst = mysqli_query($conn, $q_GET_CCENTER_ID);

    if($ccenter_id_rst){
        $row = mysqli_fetch_assoc($ccenter_id_rst);
        $ccenter = $row["Cost_Center_ID"];
        echo "Cost_Center_ID before update: $ccenter\n";
    }else{
        $errormsg = mysqli_error($connection);
        header("Location: ../employee.php?error_msg=$errormsg");
    }

    $q_UPDATE_EMPLOYEE_INFO = $conn->prepare("UPDATE employee_tbl
                                              SET Employee_ID = ?,
                                                  Fname = ?,
                                                  Lname = ?,
                                                  Knox_ID = ?,
                                                  Department_ID = ?,
                                                  Cost_Center_ID = ?
                                              WHERE System_ID = ?");

    if($q_UPDATE_EMPLOYEE_INFO){

        $q_UPDATE_EMPLOYEE_INFO->bind_param("sssssss", 
                                                    $employee_id,
                                                    $fname,
                                                    $lname,
                                                    $knox_id,
                                                    $dept_id,
                                                    $ccenter,
                                                    $sys_id);

        if($q_UPDATE_EMPLOYEE_INFO->execute()){

            $successmsg = "Update successful!";
            header("Location: ../employee.php?msg=$successmsg");

        }else{
            $errormsg = mysqli_error($conn);
            header("Location: ../employee.php?error_msg=$errormsg");
        }

    }else{

        header("Location: ../employee.php?error_msg=Error Preparing Statement.");

    }

?>