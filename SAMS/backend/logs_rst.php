<?php
    include '../database/sams_db.php';
    $conn = OpenCon();


    //For Sort and Filter
if(isset($_POST['sort']) && $_POST['sort'] != "" && isset($_POST['filter']) && $_POST['filter'] != "" && $_POST['filter_cat'] !=""){

    $request = $_POST['sort'];
    $input = $_POST['input'];
    $filter_cat = $_POST['filter_cat'];
    $filter = $_POST['filter'];
    $flag_stat = $_POST['flag'];
    $flag ="";

    if($flag_stat == 1){
        $flag = "ASC";
    }else if($flag_stat == 0){
        $flag = "DESC";
    }

    $q_getLogs = $conn->prepare("SELECT logs_tbl.Logs_ID,
                                        logs_tbl.Asset_ID as 'Asset ID',
                                        it_assets_tbl.Asset_No as 'Asset No',
                                        it_assets_tbl.Category as 'Category',
                                        it_assets_tbl.Descr as 'Description',
                                        it_assets_tbl.Serial_No as 'Serial Number',
                                        employee_tbl.Employee_ID as 'Employee ID',
                                        employee_tbl.Fname as 'Fname',
                                        employee_tbl.Lname as 'Lname',
                                        employee_tbl.Knox_ID as 'Knox ID',
                                        cost_center_tbl.Cost_Center as 'Cost Center',
                                        logs_tbl.Stat as 'Status',
                                        logs_tbl.Remarks,
                                        logs_tbl.Issued_Date as 'Issued Date' 
                                FROM logs_tbl
                                LEFT JOIN it_assets_tbl ON logs_tbl.Asset_ID = it_assets_tbl.Asset_ID
                                LEFT JOIN employee_tbl ON logs_tbl.System_ID = employee_tbl.System_ID
                                LEFT JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                                WHERE (logs_tbl.Asset_ID LIKE '%{$input}%' OR
                                      it_assets_tbl.Asset_No LIKE '%{$input}%' OR
                                      it_assets_tbl.Category LIKE '%{$input}%' OR
                                      it_assets_tbl.Descr LIKE '%{$input}%' OR
                                      it_assets_tbl.Serial_No LIKE '%{$input}%' OR
                                      employee_tbl.Employee_ID LIKE '%{$input}%' OR
                                      employee_tbl.Fname LIKE '%{$input}%' OR
                                      employee_tbl.Lname LIKE '%{$input}%' OR
                                      employee_tbl.Knox_ID LIKE '%{$input}%' OR
                                      cost_center_tbl.Cost_Center LIKE '%{$input}%' OR
                                      logs_tbl.Stat LIKE '%{$input}%' OR
                                      logs_tbl.Remarks LIKE '%{$input}%' OR
                                      logs_tbl.Issued_Date LIKE '%{$input}%') AND
                                      $filter_cat = '$filter'
                                      ORDER BY $request $flag");
        
            // Execute query
        $q_getLogs->execute();
        $q_getLogs->store_result();
        $q_getLogs->bind_result($logs_id, $asset_id, $asset_no, $catg, $descr, 
                                $serial_no, $emp_id, $fname,
                                $lname, $knox_id, $ccenter,
                                $status, $remarks, $issue_date);
        $numrows = $q_getLogs->num_rows();

        if($numrows > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th id="log-id">Logs ID</th>
                    <th id="id-col">Asset ID</th>
                    <th id="no-col">Asset Number</th>
                    <th id="catg-col">Category</th>
                    <th id="desc-col">Description</th>
                    <th id="serial-col">Serial Number</th>
                    <th id="emp-col">Employee ID</th>
                    <th id="assign-col">Assignee</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th id="stat-col">Status</th>
                    <th id="remarks-col">Remarks</th>
                    <th id="date-col">Issued Date</th>
                </thead>
                
                <?php
                    while($q_getLogs->fetch()){

                        // Set variables from fetching results
                        $asset_id = $asset_id;
                        $asset_no = $asset_no;
                        $catg = $catg;
                        $descr = $descr;
                        $serial_no = $serial_no;
                        $emp_id = $emp_id;
                        $assignee = $fname. " " .$lname;
                        $knox_id = $knox_id;
                        $ccenter = $ccenter;
                        $status = $status;
                        $remarks = $remarks;
                        $issue_date = $issue_date;
    
                        ?>
    
                        <tr id="logstr">
                            <td><?php echo $logs_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_no ?: 'N/A'; ?></td>
                            <td><?php echo $catg ?: 'N/A'; ?></td>
                            <td><?php echo $descr ?: 'N/A'; ?></td>
                            <td><?php echo $serial_no ?: 'N/A'; ?></td>
                            <td><?php echo ($emp_id !== '0' && !empty($emp_id)) ? $emp_id : 'SUB'; ?></td>
                            <td><?php echo $assignee ?: 'N/A'; ?></td>
                            <td><?php echo $knox_id ?: 'N/A'; ?></td>
                            <td><?php echo $ccenter ?: 'N/A'; ?></td>
                            <td><?php echo $status ?: 'N/A'; ?></td>
                            <td><?php echo $remarks; ?></td>
                            <td><?php echo ($issue_date !== '0000-00-00' && !empty($issue_date)) ? $issue_date : 'N/A'; ?></td>
                        </tr>
    
    
                        <?php
                    }
                ?>
            </table>

          <?php

        }else{
            echo "<h5 class=\"error-txt\">User does not exist!</h5>";
        }

}
//For filter
else if(isset($_POST['filter']) && $_POST['filter'] != "" && $_POST['sort'] == "" && $_POST['filter_cat'] != ""){

    $request = $_POST['sort'];
    $input = $_POST['input'];
    $filter_cat = $_POST['filter_cat'];
    $filter = $_POST['filter'];
    $flag_stat = $_POST['flag'];
    $flag ="";

    if($flag_stat == 1){
        $flag = "ASC";
    }else if($flag_stat == 0){
        $flag = "DESC";
    }

    $q_getLogs = $conn->prepare("SELECT logs_tbl.Logs_ID,
                                        logs_tbl.Asset_ID as 'Asset ID',
                                        it_assets_tbl.Asset_No as 'Asset No',
                                        it_assets_tbl.Category as 'Category',
                                        it_assets_tbl.Descr as 'Description',
                                        it_assets_tbl.Serial_No as 'Serial Number',
                                        employee_tbl.Employee_ID as 'Employee ID',
                                        employee_tbl.Fname as 'Fname',
                                        employee_tbl.Lname as 'Lname',
                                        employee_tbl.Knox_ID as 'Knox ID',
                                        cost_center_tbl.Cost_Center as 'Cost Center',
                                        logs_tbl.Stat as 'Status',
                                        logs_tbl.Remarks,
                                        logs_tbl.Issued_Date as 'Issued Date' 
                                FROM logs_tbl
                                LEFT JOIN it_assets_tbl ON logs_tbl.Asset_ID = it_assets_tbl.Asset_ID
                                LEFT JOIN employee_tbl ON logs_tbl.System_ID = employee_tbl.System_ID
                                LEFT JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                                WHERE (logs_tbl.Asset_ID LIKE '%{$input}%' OR
                                      it_assets_tbl.Asset_No LIKE '%{$input}%' OR
                                      it_assets_tbl.Category LIKE '%{$input}%' OR
                                      it_assets_tbl.Descr LIKE '%{$input}%' OR
                                      it_assets_tbl.Serial_No LIKE '%{$input}%' OR
                                      employee_tbl.Employee_ID LIKE '%{$input}%' OR
                                      employee_tbl.Fname LIKE '%{$input}%' OR
                                      employee_tbl.Lname LIKE '%{$input}%' OR
                                      employee_tbl.Knox_ID LIKE '%{$input}%' OR
                                      cost_center_tbl.Cost_Center LIKE '%{$input}%' OR
                                      logs_tbl.Stat LIKE '%{$input}%' OR
                                      logs_tbl.Remarks LIKE '%{$input}%' OR
                                      logs_tbl.Issued_Date LIKE '%{$input}%') AND
                                      $filter_cat = '$filter'");
        
            // Execute query
        $q_getLogs->execute();
        $q_getLogs->store_result();
        $q_getLogs->bind_result($logs_id, $asset_id, $asset_no, $catg, $descr, 
                                $serial_no, $emp_id, $fname,
                                $lname, $knox_id, $ccenter,
                                $status, $remarks, $issue_date);
        $numrows = $q_getLogs->num_rows();

        if($numrows > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th id="log-id">Logs ID</th>
                    <th id="id-col">Asset ID</th>
                    <th id="no-col">Asset Number</th>
                    <th id="catg-col">Category</th>
                    <th id="desc-col">Description</th>
                    <th id="serial-col">Serial Number</th>
                    <th id="emp-col">Employee ID</th>
                    <th id="assign-col">Assignee</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th id="stat-col">Status</th>
                    <th id="remarks-col">Remarks</th>
                    <th id="date-col">Issued Date</th>
                </thead>
                
                <?php
                    while($q_getLogs->fetch()){

                        // Set variables from fetching results
                        $asset_id = $asset_id;
                        $asset_no = $asset_no;
                        $catg = $catg;
                        $descr = $descr;
                        $serial_no = $serial_no;
                        $emp_id = $emp_id;
                        $assignee = $fname. " " .$lname;
                        $knox_id = $knox_id;
                        $ccenter = $ccenter;
                        $status = $status;
                        $remarks = $remarks;
                        $issue_date = $issue_date;
    
                        ?>
    
                        <tr id="logstr">
                            <td><?php echo $logs_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_no ?: 'N/A'; ?></td>
                            <td><?php echo $catg ?: 'N/A'; ?></td>
                            <td><?php echo $descr ?: 'N/A'; ?></td>
                            <td><?php echo $serial_no ?: 'N/A'; ?></td>
                            <td><?php echo ($emp_id !== '0' && !empty($emp_id)) ? $emp_id : 'SUB'; ?></td>
                            <td><?php echo $assignee ?: 'N/A'; ?></td>
                            <td><?php echo $knox_id ?: 'N/A'; ?></td>
                            <td><?php echo $ccenter ?: 'N/A'; ?></td>
                            <td><?php echo $status ?: 'N/A'; ?></td>
                            <td><?php echo $remarks; ?></td>
                            <td><?php echo ($issue_date !== '0000-00-00' && !empty($issue_date)) ? $issue_date : 'N/A'; ?></td>
                        </tr>
    
    
                        <?php
                    }
                ?>
            </table>

          <?php

        }else{
            echo "<h5 class=\"error-txt\">User does not exist!</h5>";
        }

}


//For sort only
else if(isset($_POST['sort']) && $_POST['sort'] != ""){

    $request = $_POST['sort'];
    $input = $_POST['input'];
    $flag_stat = $_POST['flag'];
    $flag ="";

    if($flag_stat == 1){
        $flag = "ASC";
    }else if($flag_stat == 0){
        $flag = "DESC";
    }

    $q_getLogs = $conn->prepare("SELECT logs_tbl.Logs_ID,
                                        logs_tbl.Asset_ID as 'Asset ID',
                                        it_assets_tbl.Asset_No as 'Asset No',
                                        it_assets_tbl.Category as 'Category',
                                        it_assets_tbl.Descr as 'Description',
                                        it_assets_tbl.Serial_No as 'Serial Number',
                                        employee_tbl.Employee_ID as 'Employee ID',
                                        employee_tbl.Fname as 'Fname',
                                        employee_tbl.Lname as 'Lname',
                                        employee_tbl.Knox_ID as 'Knox ID',
                                        cost_center_tbl.Cost_Center as 'Cost Center',
                                        logs_tbl.Stat as 'Status',
                                        logs_tbl.Remarks,
                                        logs_tbl.Issued_Date as 'Issued Date' 
                                FROM logs_tbl
                                LEFT JOIN it_assets_tbl ON logs_tbl.Asset_ID = it_assets_tbl.Asset_ID
                                LEFT JOIN employee_tbl ON logs_tbl.System_ID = employee_tbl.System_ID
                                LEFT JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                                WHERE logs_tbl.Asset_ID LIKE '%{$input}%' OR
                                      it_assets_tbl.Asset_No LIKE '%{$input}%' OR
                                      it_assets_tbl.Category LIKE '%{$input}%' OR
                                      it_assets_tbl.Descr LIKE '%{$input}%' OR
                                      it_assets_tbl.Serial_No LIKE '%{$input}%' OR
                                      employee_tbl.Employee_ID LIKE '%{$input}%' OR
                                      employee_tbl.Fname LIKE '%{$input}%' OR
                                      employee_tbl.Lname LIKE '%{$input}%' OR
                                      employee_tbl.Knox_ID LIKE '%{$input}%' OR
                                      cost_center_tbl.Cost_Center LIKE '%{$input}%' OR
                                      logs_tbl.Stat LIKE '%{$input}%' OR
                                      logs_tbl.Remarks LIKE '%{$input}%' OR
                                      logs_tbl.Issued_Date LIKE '%{$input}%'
                                ORDER BY $request $flag");
        
            // Execute query
        $q_getLogs->execute();
        $q_getLogs->store_result();
        $q_getLogs->bind_result($logs_id, $asset_id, $asset_no, $catg, $descr, 
                                $serial_no, $emp_id, $fname,
                                $lname, $knox_id, $ccenter,
                                $status, $remarks, $issue_date);
        $numrows = $q_getLogs->num_rows();

        if($numrows > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th id="log-id">Logs ID</th>
                    <th id="id-col">Asset ID</th>
                    <th id="no-col">Asset Number</th>
                    <th id="catg-col">Category</th>
                    <th id="desc-col">Description</th>
                    <th id="serial-col">Serial Number</th>
                    <th id="emp-col">Employee ID</th>
                    <th id="assign-col">Assignee</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th id="stat-col">Status</th>
                    <th id="remarks-col">Remarks</th>
                    <th id="date-col">Issued Date</th>
                </thead>
                
                <?php
                    while($q_getLogs->fetch()){

                        // Set variables from fetching results
                        $asset_id = $asset_id;
                        $asset_no = $asset_no;
                        $catg = $catg;
                        $descr = $descr;
                        $serial_no = $serial_no;
                        $emp_id = $emp_id;
                        $assignee = $fname. " " .$lname;
                        $knox_id = $knox_id;
                        $ccenter = $ccenter;
                        $status = $status;
                        $remarks = $remarks;
                        $issue_date = $issue_date;
    
                        ?>
    
                        <tr id="logstr">
                            <td><?php echo $logs_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_no ?: 'N/A'; ?></td>
                            <td><?php echo $catg ?: 'N/A'; ?></td>
                            <td><?php echo $descr ?: 'N/A'; ?></td>
                            <td><?php echo $serial_no ?: 'N/A'; ?></td>
                            <td><?php echo ($emp_id !== '0' && !empty($emp_id)) ? $emp_id : 'SUB'; ?></td>
                            <td><?php echo $assignee ?: 'N/A'; ?></td>
                            <td><?php echo $knox_id ?: 'N/A'; ?></td>
                            <td><?php echo $ccenter ?: 'N/A'; ?></td>
                            <td><?php echo $status ?: 'N/A'; ?></td>
                            <td><?php echo $remarks; ?></td>
                            <td><?php echo ($issue_date !== '0000-00-00' && !empty($issue_date)) ? $issue_date : 'N/A'; ?></td>
                        </tr>
    
    
                        <?php
                    }
                ?>
            </table>

          <?php

        }else{
            echo "<h5 class=\"error-txt\">User does not exist!</h5>";
        }

}else{

        $input = $_POST['input'];

        $q_getLogs = $conn->prepare("SELECT logs_tbl.Logs_ID,
                                        logs_tbl.Asset_ID as 'Asset ID',
                                        it_assets_tbl.Asset_No as 'Asset No',
                                        it_assets_tbl.Category as 'Category',
                                        it_assets_tbl.Descr as 'Description',
                                        it_assets_tbl.Serial_No as 'Serial Number',
                                        employee_tbl.Employee_ID as 'Employee ID',
                                        employee_tbl.Fname as 'Fname',
                                        employee_tbl.Lname as 'Lname',
                                        employee_tbl.Knox_ID as 'Knox ID',
                                        cost_center_tbl.Cost_Center as 'Cost Center',
                                        logs_tbl.Stat as 'Status',
                                        logs_tbl.Remarks,
                                        logs_tbl.Issued_Date as 'Issued Date' 
                                FROM logs_tbl
                                LEFT JOIN it_assets_tbl ON logs_tbl.Asset_ID = it_assets_tbl.Asset_ID
                                LEFT JOIN employee_tbl ON logs_tbl.System_ID = employee_tbl.System_ID
                                LEFT JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                                WHERE logs_tbl.Asset_ID LIKE '%{$input}%' OR
                                      it_assets_tbl.Asset_No LIKE '%{$input}%' OR
                                      it_assets_tbl.Category LIKE '%{$input}%' OR
                                      it_assets_tbl.Descr LIKE '%{$input}%' OR
                                      it_assets_tbl.Serial_No LIKE '%{$input}%' OR
                                      employee_tbl.Employee_ID LIKE '%{$input}%' OR
                                      employee_tbl.Fname LIKE '%{$input}%' OR
                                      employee_tbl.Lname LIKE '%{$input}%' OR
                                      employee_tbl.Knox_ID LIKE '%{$input}%' OR
                                      cost_center_tbl.Cost_Center LIKE '%{$input}%' OR
                                      logs_tbl.Stat LIKE '%{$input}%' OR
                                      logs_tbl.Remarks LIKE '%{$input}%' OR
                                      logs_tbl.Issued_Date LIKE '%{$input}%'
                                ORDER BY logs_tbl.Issued_Date ASC");
        
            // Execute query
        $q_getLogs->execute();
        $q_getLogs->store_result();
        $q_getLogs->bind_result($logs_id, $asset_id, $asset_no, $catg, $descr, 
                                $serial_no, $emp_id, $fname,
                                $lname, $knox_id, $ccenter,
                                $status, $remarks, $issue_date);
        $numrows = $q_getLogs->num_rows();

        if($numrows > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th id="log-id">Logs ID</th>
                    <th id="id-col">Asset ID</th>
                    <th id="no-col">Asset Number</th>
                    <th id="catg-col">Category</th>
                    <th id="desc-col">Description</th>
                    <th id="serial-col">Serial Number</th>
                    <th id="emp-col">Employee ID</th>
                    <th id="assign-col">Assignee</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th id="stat-col">Status</th>
                    <th id="remarks-col">Remarks</th>
                    <th id="date-col">Issued Date</th>
                </thead>
                
                <?php
                    while($q_getLogs->fetch()){

                        // Set variables from fetching results
                        $asset_id = $asset_id;
                        $asset_no = $asset_no;
                        $catg = $catg;
                        $descr = $descr;
                        $serial_no = $serial_no;
                        $emp_id = $emp_id;
                        $assignee = $fname. " " .$lname;
                        $knox_id = $knox_id;
                        $ccenter = $ccenter;
                        $status = $status;
                        $remarks = $remarks;
                        $issue_date = $issue_date;
    
                        ?>
    
                        <tr id="logstr">
                            <td><?php echo $logs_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_no ?: 'N/A'; ?></td>
                            <td><?php echo $catg ?: 'N/A'; ?></td>
                            <td><?php echo $descr ?: 'N/A'; ?></td>
                            <td><?php echo $serial_no ?: 'N/A'; ?></td>
                            <td><?php echo ($emp_id !== '0' && !empty($emp_id)) ? $emp_id : 'SUB'; ?></td>
                            <td><?php echo $assignee ?: 'N/A'; ?></td>
                            <td><?php echo $knox_id ?: 'N/A'; ?></td>
                            <td><?php echo $ccenter ?: 'N/A'; ?></td>
                            <td><?php echo $status ?: 'N/A'; ?></td>
                            <td><?php echo $remarks; ?></td>
                            <td><?php echo ($issue_date !== '0000-00-00' && !empty($issue_date)) ? $issue_date : 'N/A'; ?></td>
                        </tr>
    
    
                        <?php
                    }
                ?>
            </table>

          <?php

        }else{
            echo "<h5 class=\"error-txt\">User does not exist!</h5>";
        }
    }
?>