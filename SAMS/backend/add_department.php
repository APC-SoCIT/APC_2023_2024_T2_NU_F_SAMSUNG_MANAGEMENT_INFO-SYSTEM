<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    $dept_name = $_POST['dept'];
    $ccenter = $_POST['cost_center'];

    if($ccenter == ""){

    // ************************************************** //

        // Check if Department already exists
        $exist_dept = $conn->prepare("SELECT Department FROM department_tbl WHERE Department = ?");
        $exist_dept->bind_param("s", $dept_name);
        $exist_dept->execute();
        $exist_dept->store_result();
        $numrows = $exist_dept->num_rows();
        if($numrows > 0){
            header('Location: ../department.php?error-msg=Department Already Exists!');
            die();
        }

    // ************************************************** //

        $query_insertdept = $conn->prepare("INSERT INTO department_tbl(Department) VALUES (?)");

        if ($query_insertdept) {

            $query_insertdept->bind_param("s", $dept_name);
            if($query_insertdept->execute()) {

                header('Location: ../department.php?msg=Department Added');

            }else{

                header('Location: ../department.php?error-msg=Something went wrong.');

            }

            $query_insertdept->close();

        }else{

            header('Location: ../department.php?error-msg=Error preparing statement.');

        }


    }else{

    // ************************************************** //

        // Check if Department and Cost Center already exists
        $exist_dept = $conn->prepare("SELECT Department FROM department_tbl WHERE Department = ?");
        $exist_dept->bind_param("s", $dept_name);
        $exist_dept->execute();
        $exist_dept->store_result();
        $numrows = $exist_dept->num_rows();
        if($numrows > 0){
            header('Location: ../department.php?error-msg=Department Already Exists!');
            die();
        }

        $exist_ccenter = $conn->prepare("SELECT Cost_Center FROM cost_center_tbl WHERE Cost_Center = ?");
        $exist_ccenter->bind_param("s", $ccenter);
        $exist_ccenter->execute();
        $exist_ccenter->store_result();
        $numrows = $exist_ccenter->num_rows();
        if($numrows > 0){
            header('Location: ../department.php?error-msg=Cost Center Already Exists!');
            die();
        }

    // ************************************************** //

        $query_insertdept = $conn->prepare("INSERT INTO department_tbl(Department) VALUES (?)");
        $query_insertccenter = $conn->prepare("INSERT INTO cost_center_tbl(Cost_Center) VALUES(?)");

        if ($query_insertdept) {

            $query_insertdept->bind_param("s", $dept_name);
            $query_insertccenter->bind_param("s", $ccenter);
            if($query_insertdept->execute()) {

                $dept_id = $conn->insert_id;

                if($query_insertccenter->execute()){
                    $ccenter_id = $conn->insert_id;
                }else{
                    header('Location: ../department.php?error-msg=Cost Center not loaded');
                }

                $query_insertjtbl = $conn->prepare("INSERT INTO dept_ccenter_jtbl(Department_ID, Cost_Center_ID)
                                                VALUES(?, ?)");

                if($query_insertjtbl){

                    $query_insertjtbl->bind_param("ss", $dept_id, $ccenter_id);
                    if($query_insertjtbl->execute()){

                        header('Location: ../department.php?msg=Department Added');

                    }else{

                        header('Location: ../department.php?error-msg=Something went wrong.');

                    }

                }else{

                    header('Location: ../department.php?error-msg=Error preparing statement.');

                }

            }else{

                header('Location: ../department.php?error-msg=Something went wrong.');

            }

            $query_insertdept->close();

        }else{

            header('Location: ../department.php?error-msg=Error preparing statement.');

        }

    }
?>