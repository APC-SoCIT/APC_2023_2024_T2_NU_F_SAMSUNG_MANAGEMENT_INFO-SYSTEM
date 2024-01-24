<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    $dept_name = $_POST['dept'];
    $ccenter_id = $_POST['cost_center'];

    if($ccenter_id == ""){

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

        $query_insertdept = $conn->prepare("INSERT INTO department_tbl(Department) VALUES (?)");

        if ($query_insertdept) {

            $query_insertdept->bind_param("s", $dept_name);
            if($query_insertdept->execute()) {

                $dept_id = $conn->insert_id;

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