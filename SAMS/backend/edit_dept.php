<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    $dept_id = $_POST['dept_id'];
    $dept = $_POST['dept'];
    $ccenter_id = $_POST['cost_center'];
    $rm_ccenter_id = $_POST['rm_cost_center'];

    if($ccenter_id == "" && $rm_ccenter_id == ""){

        $update_dept_query = $conn->prepare("UPDATE department_tbl
                                             SET Department = ?
                                             WHERE Department_ID = ?");

        if($update_dept_query){

            $update_dept_query->execute([$dept, $dept_id]);
            header('Location: ../department.php?msg=Edited Department Successfully.');

        }else{

            header('Location: ../department.php?error-msg=Error preparing statement.');

        }

    }else if($rm_ccenter_id != "" && $ccenter_id == ""){

        $rm_ccenter_query = $conn->prepare("DELETE FROM dept_ccenter_jtbl
                                            WHERE Department_ID = ? AND
                                                  Cost_Center_ID = ?");

        $rm_ccenter_query->bind_param("ss", $dept_id, $rm_ccenter_id);
        if($rm_ccenter_query->execute()){

            header('Location: ../department.php?msg=Unassigned Cost Center Successfully.');

        }else{

            header('Location: ../department.php?error-msg=Error preparing statement.');

        }

    }else if($ccenter_id != "" && $rm_ccenter_id == ""){

        assign_ccenter();

    }else{

        $error = 'You can only assign and remove one at a time!';
        header('Location: ../department.php?error-msg='. $error);

    }

    function assign_ccenter(){

        //Assigning a Cost Center to the Department

        global $dept_id;
        global $ccenter_id;
        global $conn;

        $q_existing_ccenter = "SELECT Department_ID, Cost_Center_ID
                               FROM dept_ccenter_jtbl
                               WHERE Department_ID = ? AND
                                     Cost_Center_ID = ?";

        $exist_ccenter = $conn->prepare($q_existing_ccenter);
        $exist_ccenter->bind_param("ss", $dept_id, $ccenter_id);
        
        if($exist_ccenter->execute()){

            $exist_ccenter->store_result();
            $num_rows = $exist_ccenter->num_rows;

            if($num_rows == 0){

                // Assign Ccenter
                $q_assign_ccenter = $conn->prepare("INSERT INTO dept_ccenter_jtbl(Department_ID, 
                                                                                  Cost_Center_ID)
                                                    VALUES(?, ?)");

                if($q_assign_ccenter){

                    $q_assign_ccenter->bind_param("ss", $dept_id, $ccenter_id);
                    if($q_assign_ccenter->execute()){

                        header('Location: ../department.php?msg=Successfully Assigned Cost Center');

                    }else{

                        header('Location: ../department.php?error-msg=Something Went Wrong!');

                    }

                }else{

                    header('Location: ../department.php?msg=Error Preparing Statement');

                }


            }else{

                // Go back! already assigned.
                $msg = "This Cost Center is already assigned to this Department!";
                header('Location: ../department.php?error-msg='. $msg);

            }

        }
    }

?>