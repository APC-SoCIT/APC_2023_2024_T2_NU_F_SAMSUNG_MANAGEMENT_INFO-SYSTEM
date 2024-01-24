<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    $ccenter = $_GET['ccenter'];

    if($ccenter){
        $query_insert_ccenter = $conn->prepare("INSERT INTO
                                                    cost_center_tbl(Cost_Center)
                                                VALUES(?)");

        if($query_insert_ccenter){

            $query_insert_ccenter->bind_param("s", $ccenter);
            if($query_insert_ccenter->execute()){

                header('Location: ../department.php?msg=Cost Center Added.');

            }else{

                header('Location: ../department.php?error-msg=Something went wrong.');

            }


        }else{
            header('Location: ../department.php?error-msg=Error preparing statement.');
        }

    }else{

            header('Location: ../department.php?error-msg=Something went wrong.');

    }


?>