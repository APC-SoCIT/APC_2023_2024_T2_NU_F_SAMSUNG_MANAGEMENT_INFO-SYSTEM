<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    

    //For Sort and Filter
    if(isset($_POST['sort']) && $_POST['sort'] != "" && isset($_POST['filter']) && $_POST['filter'] != "" && $_POST['filter_cat'] !=""){

        $request = $_POST['sort'];
        $filter_cat = $_POST['filter_cat'];
        $filter = $_POST['filter'];
        $flag_stat = $_POST['flag'];
        $flag = "";
    
        if($flag_stat == 1){
            $flag = "ASC";
        }else if($flag_stat == 0){
            $flag = "DESC";
        }

        $q_filter = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                it_assets_tbl.Asset_No as 'Asset No',
                                it_assets_tbl.Category as 'Category',
                                it_assets_tbl.Descr as 'Description',
                                it_assets_tbl.Serial_No as 'Serial Number',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'Fname',
                                employee_tbl.Lname as 'Lname',
                                employee_tbl.Knox_ID as 'Knox ID',
                                cost_center_tbl.Cost_Center as 'Cost Center',
                                assigned_assets_tbl.Stat as 'Status',
                                assigned_assets_tbl.Issued_Date as 'Issued Date' 
                            FROM assigned_assets_tbl
                            INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                            INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                            INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                            WHERE $filter_cat = '$filter' AND assigned_assets_tbl.Stat != 'Disposed'
                            ORDER BY $request $flag";

        $row_asset = mysqli_query($conn, $q_filter);

        if(mysqli_num_rows($row_asset) > 0){?>

            <table class="collapsed">
                
                <thead class="tbl-header">
                    <th id="id-col">ID</th>
                    <th id="no-col">Asset Number</th>
                    <th id="catg-col">Category</th>
                    <th id="desc-col">Description</th>
                    <th id="serial-col">Serial Number</th>
                    <th id="emp-col">Employee ID</th>
                    <th id="assign-col">Assignee</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th id="stat-col">Status</th>
                    <th id="date-col">Issued Date</th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_asset)){
                        $asset_id = $row['Asset ID'];
                        $asset_no = $row['Asset No'];
                        $category = $row['Category'];
                        $descr = $row['Description'];
                        $serial_no = $row['Serial Number'];
                        $emp_id = $row['Employee ID'];
                        $assignee = $row['Fname']. " " .$row['Lname'];
                        $knox_id = $row['Knox ID'];
                        $ccenter = $row['Cost Center'];
                        $stat = $row['Status'];
                        $issue_date = $row['Issued Date'];

                        ?>

                        <tr id="assettr">
                            <td>
                                <input type="checkbox" id="<?php echo $descr ?>" name="it_asset" value="<?php echo $asset_id ?>">
                            </td>
                            <td><?php echo $asset_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_no ?: 'N/A'; ?></td>
                            <td><?php echo $category ?: 'N/A'; ?></td>
                            <td><?php echo $descr ?: 'N/A'; ?></td>
                            <td><?php echo $serial_no ?: 'N/A'; ?></td>
                            <td><?php echo ($emp_id !== '0' && !empty($emp_id)) ? $emp_id : 'SUB'; ?></td>
                            <td><?php echo $assignee ?: 'N/A'; ?></td>
                            <td><?php echo $knox_id ?: 'N/A'; ?></td>
                            <td><?php echo $ccenter ?: 'N/A'; ?></td>
                            <td><?php echo $stat ?: 'N/A'; ?></td>
                            <td><?php echo ($issue_date !== '0000-00-00' && !empty($issue_date)) ? $issue_date : 'N/A'; ?></td>
                        </tr>


                        <?php
                    }
                ?>
            </table>

            <?php

        }else{
            echo "<h5 class=\"error-txt\">Asset does not exist!</h5>";
        }


    
    }
    //For filter only
    else if(isset($_POST['filter']) && $_POST['filter'] != "" && $_POST['filter_cat'] !=""){

        $request = $_POST['sort'];
        $filter_cat = $_POST['filter_cat'];
        $filter = $_POST['filter'];
        $flag_stat = $_POST['flag'];
        $flag = "";

        if($flag_stat == 1){
            $flag = "ASC";
        }else if($flag_stat == 0){
            $flag = "DESC";
        }

        $q_filter = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                it_assets_tbl.Asset_No as 'Asset No',
                                it_assets_tbl.Category as 'Category',
                                it_assets_tbl.Descr as 'Description',
                                it_assets_tbl.Serial_No as 'Serial Number',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'Fname',
                                employee_tbl.Lname as 'Lname',
                                employee_tbl.Knox_ID as 'Knox ID',
                                cost_center_tbl.Cost_Center as 'Cost Center',
                                assigned_assets_tbl.Stat as 'Status',
                                assigned_assets_tbl.Issued_Date as 'Issued Date' 
                            FROM assigned_assets_tbl
                            INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                            INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                            INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                            WHERE $filter_cat = '$filter' AND assigned_assets_tbl.Stat != 'Disposed'";

        $row_asset = mysqli_query($conn, $q_filter);

        if(mysqli_num_rows($row_asset) > 0){?>

            <table class="collapsed">
                
                <thead class="tbl-header">
                    <th id="id-col">ID</th>
                    <th id="no-col">Asset Number</th>
                    <th id="catg-col">Category</th>
                    <th id="desc-col">Description</th>
                    <th id="serial-col">Serial Number</th>
                    <th id="emp-col">Employee ID</th>
                    <th id="assign-col">Assignee</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th id="stat-col">Status</th>
                    <th id="date-col">Issued Date</th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_asset)){
                        $asset_id = $row['Asset ID'];
                        $asset_no = $row['Asset No'];
                        $category = $row['Category'];
                        $descr = $row['Description'];
                        $serial_no = $row['Serial Number'];
                        $emp_id = $row['Employee ID'];
                        $assignee = $row['Fname']. " " .$row['Lname'];
                        $knox_id = $row['Knox ID'];
                        $ccenter = $row['Cost Center'];
                        $stat = $row['Status'];
                        $issue_date = $row['Issued Date'];

                        ?>

                        <tr id="assettr">
                            <td>
                                <input type="checkbox" id="<?php echo $descr ?>" name="it_asset" value="<?php echo $asset_id ?>">
                            </td>
                            <td><?php echo $asset_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_no ?: 'N/A'; ?></td>
                            <td><?php echo $category ?: 'N/A'; ?></td>
                            <td><?php echo $descr ?: 'N/A'; ?></td>
                            <td><?php echo $serial_no ?: 'N/A'; ?></td>
                            <td><?php echo ($emp_id !== '0' && !empty($emp_id)) ? $emp_id : 'SUB'; ?></td>
                            <td><?php echo $assignee ?: 'N/A'; ?></td>
                            <td><?php echo $knox_id ?: 'N/A'; ?></td>
                            <td><?php echo $ccenter ?: 'N/A'; ?></td>
                            <td><?php echo $stat ?: 'N/A'; ?></td>
                            <td><?php echo ($issue_date !== '0000-00-00' && !empty($issue_date)) ? $issue_date : 'N/A'; ?></td>
                        </tr>


                        <?php
                    }
                ?>
            </table>

            <?php

        }else{
            echo "<h5 class=\"error-txt\">Asset does not exist!</h5>";
        }
    }

    //For sort only
    elseif(isset($_POST['sort']) && $_POST['sort'] != ""){

        $request = $_POST['sort'];
        $flag_stat = $_POST['flag'];
        $flag = "";

        if($flag_stat == 1){
            $flag = "ASC";
        }else if($flag_stat == 0){
            $flag = "DESC";
        }

        $q_filter = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                it_assets_tbl.Asset_No as 'Asset No',
                                it_assets_tbl.Category as 'Category',
                                it_assets_tbl.Descr as 'Description',
                                it_assets_tbl.Serial_No as 'Serial Number',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'Fname',
                                employee_tbl.Lname as 'Lname',
                                employee_tbl.Knox_ID as 'Knox ID',
                                cost_center_tbl.Cost_Center as 'Cost Center',
                                assigned_assets_tbl.Stat as 'Status',
                                assigned_assets_tbl.Issued_Date as 'Issued Date' 
                            FROM assigned_assets_tbl
                            INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                            INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                            INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                            WHERE assigned_assets_tbl.Stat != 'Disposed'
                            ORDER BY $request $flag";

        $row_asset = mysqli_query($conn, $q_filter);

        if(mysqli_num_rows($row_asset) > 0){?>

            <table class=collapsed>
                
                <thead class="tbl-header">
                    <th id="id-col">ID</th>
                    <th id="no-col">Asset Number</th>
                    <th id="catg-col">Category</th>
                    <th id="desc-col">Description</th>
                    <th id="serial-col">Serial Number</th>
                    <th id="emp-col">Employee ID</th>
                    <th id="assign-col">Assignee</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th id="stat-col">Status</th>
                    <th id="date-col">Issued Date</th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_asset)){
                        $asset_id = $row['Asset ID'];
                        $asset_no = $row['Asset No'];
                        $category = $row['Category'];
                        $descr = $row['Description'];
                        $serial_no = $row['Serial Number'];
                        $emp_id = $row['Employee ID'];
                        $assignee = $row['Fname']. " " .$row['Lname'];
                        $knox_id = $row['Knox ID'];
                        $ccenter = $row['Cost Center'];
                        $stat = $row['Status'];
                        $issue_date = $row['Issued Date'];

                        ?>

                        <tr id="assettr">
                            <td>
                                <input type="checkbox" id="<?php echo $descr ?>" name="it_asset" value="<?php echo $asset_id ?>">
                            </td>
                            <td><?php echo $asset_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_no ?: 'N/A'; ?></td>
                            <td><?php echo $category ?: 'N/A'; ?></td>
                            <td><?php echo $descr ?: 'N/A'; ?></td>
                            <td><?php echo $serial_no ?: 'N/A'; ?></td>
                            <td><?php echo ($emp_id !== '0' && !empty($emp_id)) ? $emp_id : 'SUB'; ?></td>
                            <td><?php echo $assignee ?: 'N/A'; ?></td>
                            <td><?php echo $knox_id ?: 'N/A'; ?></td>
                            <td><?php echo $ccenter ?: 'N/A'; ?></td>
                            <td><?php echo $stat ?: 'N/A'; ?></td>
                            <td><?php echo ($issue_date !== '0000-00-00' && !empty($issue_date)) ? $issue_date : 'N/A'; ?></td>
                        </tr>


                        <?php
                    }
                ?>
            </table>

            <?php

        }else{
            echo "<h5 class=\"error-txt\">Asset does not exist!</h5>";
        }

    //No sort or filtering
    }else{
        $q_filter = "SELECT assigned_assets_tbl.Asset_ID as 'Asset ID',
                                it_assets_tbl.Asset_No as 'Asset No',
                                it_assets_tbl.Category as 'Category',
                                it_assets_tbl.Descr as 'Description',
                                it_assets_tbl.Serial_No as 'Serial Number',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'Fname',
                                employee_tbl.Lname as 'Lname',
                                employee_tbl.Knox_ID as 'Knox ID',
                                cost_center_tbl.Cost_Center as 'Cost Center',
                                assigned_assets_tbl.Stat as 'Status',
                                assigned_assets_tbl.Issued_Date as 'Issued Date' 
                            FROM assigned_assets_tbl
                            INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                            INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                            INNER JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                            WHERE assigned_assets_tbl.Stat != 'Disposed'";

        $row_asset = mysqli_query($conn, $q_filter);

        if(mysqli_num_rows($row_asset) > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th id="id-col">ID</th>
                    <th id="no-col">Asset Number</th>
                    <th id="catg-col">Category</th>
                    <th id="desc-col">Description</th>
                    <th id="serial-col">Serial Number</th>
                    <th id="emp-col">Employee ID</th>
                    <th id="assign-col">Assignee</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th id="stat-col">Status</th>
                    <th id="date-col">Issued Date</th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_asset)){
                        $asset_id = $row['Asset ID'];
                        $asset_no = $row['Asset No'];
                        $category = $row['Category'];
                        $descr = $row['Description'];
                        $serial_no = $row['Serial Number'];
                        $emp_id = $row['Employee ID'];
                        $assignee = $row['Fname']. " " .$row['Lname'];
                        $knox_id = $row['Knox ID'];
                        $ccenter = $row['Cost Center'];
                        $stat = $row['Status'];
                        $issue_date = $row['Issued Date'];

                        ?>

                        <tr id="assettr">
                            <td>
                                <input type="checkbox" id="<?php echo $descr ?>" name="it_asset" value="<?php echo $asset_id ?>">
                            </td>
                            <td><?php echo $asset_id ?: 'N/A'; ?></td>
                            <td><?php echo $asset_no ?: 'N/A'; ?></td>
                            <td><?php echo $category ?: 'N/A'; ?></td>
                            <td><?php echo $descr ?: 'N/A'; ?></td>
                            <td><?php echo $serial_no ?: 'N/A'; ?></td>
                            <td><?php echo ($emp_id !== '0' && !empty($emp_id)) ? $emp_id : 'SUB'; ?></td>
                            <td><?php echo $assignee ?: 'N/A'; ?></td>
                            <td><?php echo $knox_id ?: 'N/A'; ?></td>
                            <td><?php echo $ccenter ?: 'N/A'; ?></td>
                            <td><?php echo $stat ?: 'N/A'; ?></td>
                            <td><?php echo ($issue_date !== '0000-00-00' && !empty($issue_date)) ? $issue_date : 'N/A'; ?></td>
                        </tr>


                        <?php
                    }
                ?>
            </table>

            <?php

        }else{
            echo "<h5 class=\"error-txt\">Asset does not exist!</h5>";
        }
    }
        
?>