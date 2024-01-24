<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

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
                            LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl2.Cost_Center_ID = cost_center_tbl.Cost_Center_ID";

        $row_employee = mysqli_query($conn, $q_getEmployee);

        if(mysqli_num_rows($row_employee) > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th></th>
                    <th></th>
                    <th>Employee ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Knox ID</th>
                    <th>Department</th>
                    <th>Cost Center</th>
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
                            <td><?php echo $dept ?: 'Not Assigned';?></td>
                            <td><?php echo $ccenter ?: 'Not Assigned';?></td>
                            <td>
                                <a id="button-cell" href="emp_profile.php?emp_id=<?php echo $emp_id ?>">
                                    
                                    <div class="icon-circle">
                                        <i class="bi bi-person" style="font-weight:bold;"></i>
									</div>
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

    
?>