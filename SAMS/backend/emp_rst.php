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

    $q_getEmployee = "SELECT DISTINCT employee_tbl.System_ID as 'System ID',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'First Name',
                                employee_tbl.Lname as 'Last Name',
                                employee_tbl.Knox_ID as 'Knox ID',
                                department_tbl.Department as 'Department',
                                cost_center_tbl.Cost_Center as 'Cost Center'
                          FROM employee_tbl
                          LEFT JOIN dept_ccenter_jtbl ON employee_tbl.Department_ID = dept_ccenter_jtbl.Department_ID
                          LEFT JOIN department_tbl ON dept_ccenter_jtbl.Department_ID = department_tbl.Department_ID
                          LEFT JOIN dept_ccenter_jtbl AS dept_ccenter_jtbl2 ON employee_tbl.Cost_Center_ID = dept_ccenter_jtbl2.Cost_Center_ID
                          LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl2.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                          WHERE (Employee_ID LIKE '%{$input}%' OR
                            Fname LIKE '%{$input}%' OR
                            Lname LIKE '%{$input}%' OR
                            Knox_ID LIKE '%{$input}%' OR
                            Cost_Center LIKE '%{$input}%') AND
                        $filter_cat = '$filter'
                        ORDER BY $request $flag";

    $row_employee = mysqli_query($conn, $q_getEmployee);

        if(mysqli_num_rows($row_employee) > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th></th>
                    <th id="id-col">Employee ID</th>
                    <th id="fname-col">First Name</th>
                    <th id="lname-col">Last Name</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="dept-col">Department</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th></th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_employee)){
                        $sys_id = $row['System ID'];
                        $emp_id = $row['Employee ID'];
                        $fname = $row['First Name'];
                        $lname = $row['Last Name'];
                        $knox_id = $row['Knox ID'];
                        $dept = $row['Department'];
                        $ccenter = $row['Cost Center'];

                        ?>
                            <tr id="employeetr">
                                <td>
                                    <input type="checkbox" id="<?php echo $emp_id ?>" name="sams_employee" value="<?php echo $emp_id ?>">
                                </td>
                                <td><?php echo $sys_id;?></td>
                                <td><?php echo $emp_id;?></td>
                                <td><?php echo $fname;?></td>
                                <td><?php echo $lname;?></td>
                                <td><?php echo $knox_id;?></td>
                                <td><?php echo $dept;?></td>
                                <td><?php echo $ccenter;?></td>
                                <td>
                                    <a id="button-cell" href="emp_profile.php?emp_id=<?php echo $emp_id ?>">
                                        <i class="bi bi-person"></i>
                                    </a>
                                </td>
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
else if(isset($_POST['filter']) && $_POST['filter'] != "" && $_POST['sort'] ="" && $_POST['filter_cat'] !=""){

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

    $q_getEmployee = "SELECT DISTINCT employee_tbl.System_ID as 'System ID',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'First Name',
                                employee_tbl.Lname as 'Last Name',
                                employee_tbl.Knox_ID as 'Knox ID',
                                department_tbl.Department as 'Department',
                                cost_center_tbl.Cost_Center as 'Cost Center'
                          FROM employee_tbl
                          LEFT JOIN dept_ccenter_jtbl ON employee_tbl.Department_ID = dept_ccenter_jtbl.Department_ID
                          LEFT JOIN department_tbl ON dept_ccenter_jtbl.Department_ID = department_tbl.Department_ID
                          LEFT JOIN dept_ccenter_jtbl AS dept_ccenter_jtbl2 ON employee_tbl.Cost_Center_ID = dept_ccenter_jtbl2.Cost_Center_ID
                          LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl2.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                          WHERE (Employee_ID LIKE '%{$input}%' OR
                            Fname LIKE '%{$input}%' OR
                            Lname LIKE '%{$input}%' OR
                            Knox_ID LIKE '%{$input}%' OR
                            Cost_Center LIKE '%{$input}%') AND
                        $filter_cat = '$filter'";

    $row_employee = mysqli_query($conn, $q_getEmployee);

        if(mysqli_num_rows($row_employee) > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th></th>
                    <th id="id-col">Employee ID</th>
                    <th id="fname-col">First Name</th>
                    <th id="lname-col">Last Name</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="dept-col">Department</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th></th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_employee)){
                        $sys_id = $row['System ID'];
                        $emp_id = $row['Employee ID'];
                        $fname = $row['First Name'];
                        $lname = $row['Last Name'];
                        $knox_id = $row['Knox ID'];
                        $dept = $row['Department'];
                        $ccenter = $row['Cost Center'];

                        ?>
                            <tr id="employeetr">
                                <td>
                                    <input type="checkbox" id="<?php echo $emp_id ?>" name="sams_employee" value="<?php echo $emp_id ?>">
                                </td>
                                <td><?php echo $sys_id;?></td>
                                <td><?php echo $emp_id;?></td>
                                <td><?php echo $fname;?></td>
                                <td><?php echo $lname;?></td>
                                <td><?php echo $knox_id;?></td>
                                <td><?php echo $dept;?></td>
                                <td><?php echo $ccenter;?></td>
                                <td>
                                    <a id="button-cell" href="emp_profile.php?emp_id=<?php echo $emp_id ?>">
                                        <i class="bi bi-person"></i>
                                    </a>
                                </td>
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
    $filter_cat = $_POST['filter_cat'];
    $filter = $_POST['filter'];
    $flag_stat = $_POST['flag'];
    $flag ="";

    if($flag_stat == 1){
        $flag = "ASC";
    }else if($flag_stat == 0){
        $flag = "DESC";
    }

    $q_getEmployee = "SELECT DISTINCT employee_tbl.System_ID as 'System ID',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'First Name',
                                employee_tbl.Lname as 'Last Name',
                                employee_tbl.Knox_ID as 'Knox ID',
                                department_tbl.Department as 'Department',
                                cost_center_tbl.Cost_Center as 'Cost Center'
                          FROM employee_tbl
                          LEFT JOIN dept_ccenter_jtbl ON employee_tbl.Department_ID = dept_ccenter_jtbl.Department_ID
                          LEFT JOIN department_tbl ON dept_ccenter_jtbl.Department_ID = department_tbl.Department_ID
                          LEFT JOIN dept_ccenter_jtbl AS dept_ccenter_jtbl2 ON employee_tbl.Cost_Center_ID = dept_ccenter_jtbl2.Cost_Center_ID
                          LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl2.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                          WHERE Employee_ID LIKE '%{$input}%' OR
                            Fname LIKE '%{$input}%' OR
                            Lname LIKE '%{$input}%' OR
                            Knox_ID LIKE '%{$input}%' OR
                            Cost_Center LIKE '%{$input}%'
                        ORDER BY $request $flag";

    $row_employee = mysqli_query($conn, $q_getEmployee);

        if(mysqli_num_rows($row_employee) > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th></th>
                    <th id="id-col">Employee ID</th>
                    <th id="fname-col">First Name</th>
                    <th id="lname-col">Last Name</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="dept-col">Department</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th></th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_employee)){
                        $sys_id = $row['System ID'];
                        $emp_id = $row['Employee ID'];
                        $fname = $row['First Name'];
                        $lname = $row['Last Name'];
                        $knox_id = $row['Knox ID'];
                        $dept = $row['Department'];
                        $ccenter = $row['Cost Center'];

                        ?>
                            <tr id="employeetr">
                                <td>
                                    <input type="checkbox" id="<?php echo $emp_id ?>" name="sams_employee" value="<?php echo $emp_id ?>">
                                </td>
                                <td><?php echo $sys_id;?></td>
                                <td><?php echo $emp_id;?></td>
                                <td><?php echo $fname;?></td>
                                <td><?php echo $lname;?></td>
                                <td><?php echo $knox_id;?></td>
                                <td><?php echo $dept;?></td>
                                <td><?php echo $ccenter;?></td>
                                <td>
                                    <a id="button-cell" href="emp_profile.php?emp_id=<?php echo $emp_id ?>">
                                        <i class="bi bi-person"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                    }
                ?>
            </table>

          <?php

        }else{
            echo "<h5 class=\"error-txt\">User does not exist!</h5>";
        }

}else if(isset($_POST['input'])){
        
        $input = $_POST['input'];

        $q_getEmployee = "SELECT DISTINCT employee_tbl.System_ID as 'System ID',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'First Name',
                                employee_tbl.Lname as 'Last Name',
                                employee_tbl.Knox_ID as 'Knox ID',
                                department_tbl.Department as 'Department',
                                cost_center_tbl.Cost_Center as 'Cost Center'
                          FROM employee_tbl
                          LEFT JOIN dept_ccenter_jtbl ON employee_tbl.Department_ID = dept_ccenter_jtbl.Department_ID
                          LEFT JOIN department_tbl ON dept_ccenter_jtbl.Department_ID = department_tbl.Department_ID
                          LEFT JOIN dept_ccenter_jtbl AS dept_ccenter_jtbl2 ON employee_tbl.Cost_Center_ID = dept_ccenter_jtbl2.Cost_Center_ID
                          LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl2.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                          WHERE Employee_ID LIKE '%{$input}%' OR
                            Fname LIKE '%{$input}%' OR
                            Lname LIKE '%{$input}%' OR
                            Knox_ID LIKE '%{$input}%' OR
                            Cost_Center LIKE '%{$input}%'";

        $row_employee = mysqli_query($conn, $q_getEmployee);

        if(mysqli_num_rows($row_employee) > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th></th>
                    <th id="id-col">Employee ID</th>
                    <th id="fname-col">First Name</th>
                    <th id="lname-col">Last Name</th>
                    <th id="knox-col">Knox ID</th>
                    <th id="dept-col">Department</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th></th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_employee)){
                        $sys_id = $row['System ID'];
                        $emp_id = $row['Employee ID'];
                        $fname = $row['First Name'];
                        $lname = $row['Last Name'];
                        $knox_id = $row['Knox ID'];
                        $dept = $row['Department'];
                        $ccenter = $row['Cost Center'];

                        ?>
                            <tr id="employeetr">
                                <td>
                                    <input type="checkbox" id="<?php echo $emp_id ?>" name="sams_employee" value="<?php echo $emp_id ?>">
                                </td>
                                <td><?php echo $sys_id;?></td>
                                <td><?php echo $emp_id;?></td>
                                <td><?php echo $fname;?></td>
                                <td><?php echo $lname;?></td>
                                <td><?php echo $knox_id;?></td>
                                <td><?php echo $dept;?></td>
                                <td><?php echo $ccenter;?></td>
                                <td>
                                    <a id="button-cell" href="emp_profile.php?emp_id=<?php echo $emp_id ?>">
                                        <i class="bi bi-person"></i>
                                    </a>
                                </td>
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