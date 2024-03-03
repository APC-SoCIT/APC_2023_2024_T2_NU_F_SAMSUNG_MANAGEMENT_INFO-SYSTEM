<?php
    session_start();

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

                    $url_errline = array();
    
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

                            $result_dept = replace_dept();
                            $result_ccenter = replace_ccenter();

                            if(isset($result_dept->id) && isset($result_ccenter->id)){

                                // Query to remove duplicate Employees
                                $rm_duped_names_Query = "UPDATE employee_tbl
                                                            SET Fname = '".$fname."',
                                                            Lname = '".$lname."',
                                                            Knox_ID = '".$knox_id."',
                                                            Department_ID = ".$result_dept->id.",
                                                            Cost_Center_ID = ".$result_ccenter->id.",
                                                            Email = '".$email."'
                                                            WHERE Employee_ID = '".$emp_id."'";
        
                                // Initiate INSERT Query to Database
                                try{
                                    mysqli_query($conn, $rm_duped_names_Query);
                                }catch(mysqli_sql_exception $e){

                                    $qstring = '?status=err';
                                    $url_errline[] = "SQL Error: Constraints violation!br>"
                                                                   . " Department: ["
                                                                   . $result_dept->id.']'.$dept.' & '
                                                                   . " Cost Center: ["
                                                                   . $result_ccenter->id.']'.$ccenter
                                                                   ." does not exist in the dept_ccenter junction table! 
                                                                   Please check if the corresponding Department and Cost Center pairs are correct.
                                                                   If this error persists, check for duplicate values in Department and Cost Center sections!<br><br>";
                                    $url_combined_errline = implode("", $url_errline);
                                    $_SESSION['errlink'] = $url_combined_errline;

                                }

                            }
    
                        }else{
    
                            $result_dept = replace_dept();
                            $result_ccenter = replace_ccenter();

                            if(isset($result_dept->id) && isset($result_ccenter->id)){
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
                                                                ".$result_dept->id.",
                                                                ".$result_ccenter->id.", 
                                                                '".$email."')";

                                // Initiate INSERT Query to Database
                                try{
                                    mysqli_query($conn, $insert_CSVFile_Query);

                                }catch(mysqli_sql_exception $e){

                                    $qstring = '?status=err';
                                    $url_errline[] = "SQL Error: Constraints violation<br>"
                                                                   . " Department["
                                                                   . $result_dept->id.']'.$dept.'<br>'
                                                                   . " Cost Center["
                                                                   . $result_ccenter->id.']'.$ccenter
                                                                   ." does not exist in the dept_ccenter junction table! 
                                                                   Please check if the corresponding Department and Cost Center pairs are correct.
                                                                   If this error persists, check for duplicate values in Department and Cost Center sections!";
                                    $url_combined_errline = implode("", $url_errline);
                                    $_SESSION['errlink'] = $url_combined_errline;

                                }
                                

                            }else{

                                $qstring = '?status=err';
                                $url_errline[] = $result_dept->line.' '.$result_ccenter->line;
                                $url_combined_errline = implode("", $url_errline);
                                $_SESSION['errlink'] = $url_combined_errline;

                            }
    
                        }
    
                    }
    
                    fclose($csvFile);
    
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
                                VALUES ('$last_id', 1, 'New', now())";

                                // Logs
                                $q_insertAssignMISLogs = $conn->prepare("INSERT INTO logs_tbl (Asset_ID, System_ID, Stat, Issued_Date)
                                VALUES (?, ?, ?, ?)");

                                $MIS_deptID = 1;
                                $stat = 'New';
                                $curr_date = date("Y-m-d");

                                $q_insertAssignMISLogs->bind_param("ssss", $last_id, $MIS_deptID, $stat, $curr_date);
                        
                                // Insert to Asset Logs Soon...
                                
                                if(mysqli_query($conn, $q_insertAssignMIS)){
                                    $q_insertAssignMISLogs->execute();
                        
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
    
            }else{
    
                $qstring = '?status=err';
    
            }
    
        }else{
    
            $qstring = '?status=invalid_file';
    
        }

        $qstring = '?status=succ';
        // Redirect back to Asset PHP
        header("Location: ../asset.php$qstring");

    }

    function replace_dept() {
        global $dept;
        global $dept_id;
        global $conn;
        global $line;
    
        $result_dept = new stdClass();
    
        // Define a custom error handler
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            // Custom error handling code here
            echo "Error: [$errno] $errstr in $errfile on line $errline\n";
        });
    
        // Your existing code...
        $get_dept_query = "SELECT Department_ID
                              FROM department_tbl
                              WHERE Department = '".$dept."'";
    
        try {
            $row_dept = mysqli_query($conn, $get_dept_query);
            if(mysqli_num_rows($row_dept) > 0){
                $row = mysqli_fetch_assoc($row_dept);
                $dept_id = $row['Department_ID'];
                $dept_id = (int)$dept_id;
                $result_dept->id = $dept_id;
            } else {
                $console_msg4 = 'Employee: ['.$line[0].']'.$line[1].' '.$line[2].'<br>Missing Department: '.$line[4].'<br>';
                $result_dept->line = $console_msg4;
            }
        } catch (Exception $e) {
            // Catch any exceptions thrown during the execution of the code
            echo "Exception: " . $e->getMessage();
        }
    
        // Restore the default error handler
        restore_error_handler();
    
        return $result_dept;
    }

    function replace_ccenter() {
        global $ccenter;
        global $ccenter_id;
        global $conn;
        global $line;
    
        $result_ccenter = new stdClass();
    
        // Define a custom error handler
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            // Custom error handling code here
            echo "Error: [$errno] $errstr in $errfile on line $errline\n";
        });
    
        // Your existing code...
        $get_ccenter_query = "SELECT Cost_Center_ID
                                 FROM cost_center_tbl
                                 WHERE Cost_Center = '".$ccenter."'";
    
        try {
            $row_ccenter = mysqli_query($conn, $get_ccenter_query);
            if(mysqli_num_rows($row_ccenter) > 0){
                $row = mysqli_fetch_assoc($row_ccenter);
                $ccenter_id = $row['Cost_Center_ID'];
                $ccenter_id = (int)$ccenter_id;
                $result_ccenter->id = $ccenter_id;
            } else {
                $console_msg5 = 'Missing Cost Center: '.$line[5].'<br><br>';
                $result_ccenter->line = $console_msg5;
            }
        } catch (Exception $e) {
            // Catch any exceptions thrown during the execution of the code
            echo "Exception: " . $e->getMessage(); 
        }
    
        // Restore the default error handler
        restore_error_handler();
    
        return $result_ccenter;
    }
    
?>