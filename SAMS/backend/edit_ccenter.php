<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    $ccenter_id = $_POST['ccenter_id'];
    $ccenter = $_POST['cost_center'];

    if(isset($ccenter)){

        $q_edit_ccenter = $conn->prepare("UPDATE cost_center_tbl
                                          SET Cost_Center = ?  
                                          WHERE Cost_Center_ID = ?");

        if($q_edit_ccenter){

            $q_edit_ccenter->bind_param("ss", $ccenter, $ccenter_id);

            if($q_edit_ccenter->execute()){

                header('Location: ../costcenter.php?msg=Successfully edited Cost Center');

            }else{

                header('Location: ../costcenter.php?error-msg=Something went wrong!');

            }

        }else{

            header('Location: ../costcenter.php?error-msg=Error Preparing Statement');

        }

    }else{
        
        header('Location: ../costcenter.php?error-msg=Error cannot pass empty value');

    }

?>