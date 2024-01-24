<?php

    include '../database/sams_db.php';

    global $ccenter_id;
    global $ccenter;
    global $line;
    global $conn;

    $conn = OpenCon();

    $ccenter = '';
    $dept = '';
    

    if(isset($_POST['emp_import_submit'])){
        $csvtypes = array('text/x-comma-separated-values', 'text/comma-separated-values',
        'application/octet-stream', 'text/csv', 'application/csv', 'application/excel',
        'application/vnd.msexcel', 'text/plain');

        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvtypes)){

            if(is_uploaded_file($_FILES['file']['tmp_name'])){
    
                    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
    
                    while(($line = fgetcsv($csvFile)) !== FALSE){
                        
                        // Rows
                        $emp_id = mysqli_real_escape_string($conn, $line[0]);
                        $fname = mysqli_real_escape_string($conn, $line[1]);
                        $lname = mysqli_real_escape_string($conn, $line[2]);
                        $knox_id = mysqli_real_escape_string($conn, $line[3]);
                        $dept = mysqli_real_escape_string($conn, $line[4]);
                        $ccenter = mysqli_real_escape_string($conn, $line[5]);
                        $email = mysqli_real_escape_string($conn, $line[6]);
    
                        // Check if there are duplicate employees in csv file
                        $prevQuery = "SELECT System_ID 
                                      FROM employee_tbl
                                      WHERE Employee_ID = '".$line[0]."'";
    
                        $prevRst = mysqli_query($conn, $prevQuery);
    
                        if(mysqli_num_rows($prevRst) > 0){
    
                            replace_dept();
                            replace_ccenter();
    
                            // Query to remove duplicate Employees
                            $rm_duped_names_Query = "UPDATE employee_tbl
                                                     SET Fname = '".$fname."',
                                                     Lname = '".$lname."',
                                                     Knox_ID = '".$knox_id."',
                                                     Department_ID = ".$dept_id.",
                                                     Cost_Center_ID = ".$ccenter_id.",
                                                     Email = '".$email."'
                                                     WHERE Employee_ID = '".$emp_id."'";
    
                            // Initiate INSERT Query to Database
                            mysqli_query($conn, $rm_duped_names_Query);
    
                        }else{
    
                            replace_dept();
                            replace_ccenter();
    
                            // INSERT TO Employee Table Query
                            $insert_CSVFile_Query = "INSERT INTO employee_tbl (Employee_ID, 
                                                                               Fname, 
                                                                               Lname, 
                                                                               Knox_ID,
                                                                               Department_ID,
                                                                               Cost_Center_ID, 
                                                                               Email)
                                                    VALUES ('".$emp_id."', 
                                                            '".$fname."', 
                                                            '".$lname."', 
                                                            '".$knox_id."',
                                                            ".$dept_id.",
                                                            ".$ccenter_id.", 
                                                            '".$email."')";
    
    
                            // Initiate INSERT Query to Database
                            mysqli_query($conn, $insert_CSVFile_Query);
    
                        }
    
                    }
    
                    fclose($csvFile);
                    $qstring = '?status=succ';
    
            }else{
    
                $qstring = '?status=err';
    
            }
    
        }else{
    
            $qstring = '?status=invalid_file';
    
        }

        // Redirect back to Employee PHP
        header("Location: ../employee.php$qstring");

    }else if(isset($_POST['asset_import_submit'])){

        $csvtypes = array('text/x-comma-separated-values', 'text/comma-separated-values',
        'application/octet-stream', 'text/csv', 'application/csv', 'application/excel',
        'application/vnd.msexcel', 'text/plain');

        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvtypes)){

            if(is_uploaded_file($_FILES['file']['tmp_name'])){
    
                    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
    
                    while(($line = fgetcsv($csvFile)) !== FALSE){
                        
                        // Rows
                        $asset_no = mysqli_real_escape_string($conn, $line[0]);
                        $catg = mysqli_real_escape_string($conn, $line[1]);
                        $descr = mysqli_real_escape_string($conn, $line[2]);
                        $serial_no = mysqli_real_escape_string($conn, $line[3]);
    
                        // Check if there are duplicate assets in csv file
                        $prevQuery = "SELECT Asset_ID
                                      FROM it_assets_tbl
                                      WHERE Serial_No = '".$line[3]."'";
    
                        $prevRst = mysqli_query($conn, $prevQuery);
    
                        if(mysqli_num_rows($prevRst) > 0){
    
                            // Query to remove duplicate assets
                            $rm_duped_asset_Query = "UPDATE it_assets_tbl
                                                     SET Asset_No = '".$asset_no."',
                                                     Category = '".$catg."',
                                                     Descr = '".$descr."'
                                                     WHERE Serial_No = '".$serial_no."'";
    
                            // Initiate INSERT Query to Database
                            mysqli_query($conn, $rm_duped_asset_Query);
    
                        }else{
    
                            // INSERT TO Asset Table Query
                            $insert_CSVFile_Query = "INSERT INTO it_assets_tbl (Asset_No,
                                                                               Category, 
                                                                               Descr, 
                                                                               Serial_No)
                                                    VALUES ('".$asset_no."', 
                                                            '".$catg."', 
                                                            '".$descr."',
                                                            '".$serial_no."')";
    
    
                            // Initiate INSERT Query to Database
                            if (mysqli_query($conn, $insert_CSVFile_Query)) {
        
                                $last_id = mysqli_insert_id($conn);
                        
                                    // Auto Assign new Assets to MIS Storage
                        
                                $q_insertAssignMIS = "INSERT INTO assigned_assets_tbl (Asset_ID, System_ID, Stat, Issued_Date)
                                VALUES ('$last_id', 5, 'New', now())";
                        
                                // Insert to Asset Logs Soon...
                                
                                if(mysqli_query($conn, $q_insertAssignMIS)){
                        
                                    $successmsg = "Asset inserted successfully.";
                                    header("Location: ../asset.php?msg=$successmsg");
                        
                                }else{
                                    $error_msg = mysqli_error($conn);
                                    header("Location: ../asset.php?error_msg=$error_msg");
                                }
                                    
                            } else {
                                $error_msg = mysqli_error($conn);
                                header("Location: ../asset.php?error_msg=$error_msg");
                            }
    
                        }
    
                    }
    
                    fclose($csvFile);
                    $qstring = '?status=succ';
    
            }else{
    
                $qstring = '?status=err';
    
            }
    
        }else{
    
            $qstring = '?status=invalid_file';
    
        }

        // Redirect back to Employee PHP
        header("Location: ../asset.php$qstring");

    }



    function replace_ccenter(){

        global $ccenter_id;
        global $ccenter;
        global $conn;
        global $line;

        // Get Cost Center ID FROM Cost Center Column
        $get_ccenter_query = "SELECT Cost_Center_ID
        FROM cost_center_tbl
        WHERE Cost_Center = '".$ccenter."'";

        $row_ccenter = mysqli_query($conn, $get_ccenter_query);

        if(mysqli_num_rows($row_ccenter) > 0){

            $row = mysqli_fetch_assoc($row_ccenter);
            $ccenter_id = $row['Cost_Center_ID'];
            $ccenter_id = (int)$ccenter_id;

        }else{

            echo 'Fail';
            echo 'Line 5: ' . $line[5];
            $qstring = '?status=err';

        }

        return $ccenter_id;

    }

    function replace_dept(){

        global $dept;
        global $dept_id;
        global $conn;
        global $line;

        // Get Department ID FROM Department Column
        $get_dept_query = "SELECT Department_ID
                              FROM department_tbl
                              WHERE Department = '".$dept."'";

        $row_dept = mysqli_query($conn, $get_dept_query);

        if(mysqli_num_rows($row_dept) > 0){

            $row = mysqli_fetch_assoc($row_dept);
            $dept_id = $row['Department_ID'];
            $dept_id = (int)$dept_id;

        }else{

            echo 'Fail';
            echo 'Line 4: ' . $line[4];
            $qstring = '?status=err';

        }

        return $dept_id;

    }
?>