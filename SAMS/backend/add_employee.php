<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    $emp_id = $_POST['employee_id'];
    $fname = $_POST['employee_fname'];
    $lname = $_POST['employee_lname'];
    $knox_id = $_POST['knox_id'];
    $dept_id = $_POST['dept'];
    $ccenter = $_POST['cost_center'];
    $email = $_POST['email'];

    $q_GET_CCENTER_ID = "SELECT Cost_Center_ID
                         FROM cost_center_tbl
                         WHERE Cost_Center = '$ccenter'";

    $ccenter_id_rst = mysqli_query($conn, $q_GET_CCENTER_ID);

    if($ccenter_id_rst){
        $row = mysqli_fetch_assoc($ccenter_id_rst);
        $ccenter = (int) $row["Cost_Center_ID"];

        $q_insertEmployee = $conn->prepare("INSERT INTO employee_tbl (Employee_ID, Fname, Lname, Knox_ID, Department_ID, Cost_Center_ID, Email)
                                            VALUES (?, ?, ?, ?, ?, ?, ?)");

        if($q_insertEmployee){

            $q_insertEmployee->bind_param("sssssss", $emp_id, $fname, $lname, $knox_id, $dept_id, $ccenter, $email);

            if($q_insertEmployee->execute()){

                $successmsg = "Employee inserted successfully.";
                header("Location: ../employee.php?msg=$successmsg");

            }else{

                $errormsg = mysqli_error($conn);
                header("Location: ../employee.php?error_msg=$errormsg");

            }

        }else{

            header("Location: ../employee.php?error_msg=Something went wrong");

        }


    }else{
        $errormsg = mysqli_error($connection);
        header("Location: ../employee.php?error_msg=$errormsg");
    }

    mysqli_close($conn);
?>