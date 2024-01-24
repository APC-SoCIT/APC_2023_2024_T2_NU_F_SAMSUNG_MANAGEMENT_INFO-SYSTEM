<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    if(isset($_POST['dept_id'])){

        $dept_id = $_POST['dept_id'];
        $q_delete_dept = $conn->prepare("DELETE FROM department_tbl WHERE Department_ID = ?");

        if($q_delete_dept){

            $q_delete_dept->bind_param("s", $dept_id);
            if($q_delete_dept->execute()){
                
                $msg = 'Successfully Removed Department!';
                header('Location: ../department.php?msg='. $msg);

            }else{

                $error = 'Something went Wrong!';
                header('Location: ../department.php?error-msg='. $error);

            }

        }else{

            $error = 'Error Preparing Statement';
            header('Location: ../department.php?error-msg='. $error);

        }

    }else if(isset($_POST['ccenter_id'])){

        $ccenter_id = $_POST['ccenter_id'];
        $ccenter = $_POST['ccenter'];
        $q_delete_ccenter = $conn->prepare("DELETE FROM cost_center_tbl WHERE Cost_Center_ID = ?");

        if($q_delete_ccenter){

            $q_delete_ccenter->bind_param("s", $ccenter_id);
            try{
                if($q_delete_ccenter->execute()){

                    $msg = 'Successfully Removed Cost Center!';
                    header('Location: ../department.php?msg='. $msg);
    
                }else{
    
                    $error = 'Something went Wrong!';
                    header('Location: ../department.php?error-msg='. $error);
    
                }
            }catch(Exception $e){

                $error = 'Cannot delete '. $ccenter .', currently assigned to a Department!';
                header('Location: ../department.php?error-msg='. $error);

            }
            

        }else{

            $error = 'Error Preparing Statement';
            header('Location: ../department.php?error-msg='. $error);

        }

    }else{

        $error = 'Something went Wrong!';
        header('Location: ../department.php?error-msg='. $error);

    }

    

?>