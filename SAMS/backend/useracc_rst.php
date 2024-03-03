<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    if(isset($_POST['input'])){
        
        $input = $_POST['input'];

        $q_getEmployee = "SELECT DISTINCT employee_tbl.System_ID as 'System ID',
                                employee_tbl.Employee_ID as 'Employee ID',
                                employee_tbl.Fname as 'First Name',
                                employee_tbl.Lname as 'Last Name',
                                employee_tbl.Knox_ID as 'Knox ID',
                                employee_tbl.Email as 'Email',
                                employee_tbl.Stat as 'Stat',
                                employee_tbl.Roles as 'Role',
                                employee_tbl.Pword as 'Pword',
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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Knox ID</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Action</th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_employee)){
                        $emp_id = $row['Employee ID'];
                        $fname = $row['First Name'];
                        $lname = $row['Last Name'];
                        $email = $row['Email'];
                        $knox_id = $row['Knox ID'];
                        $pass = $row['Pword'];
                        $stat = $row['Stat'];
                        $role = $row['Role'];


                        ?>
                            <tr id="useracctr">
                                <td><?php echo $emp_id;?></td>
                                <td><?php echo $fname .' '.  $lname;?></td>
                                <td><?php echo $email;?></td>
                                <td><?php echo $knox_id;?></td>
                                <td><?php echo $pass ? '******' : 'Not Set' ;?></td>
                                <td><?php echo $stat ?: 'unverified';?></td>
                                <td><?php echo $role ?: 'No Account';?></td>
                                <td>
                                    <a href="#" id="editModalBtn" class="edit-icon">
                                        <div class="icon-circle">
                                            <i class='bx bxs-edit'></i>
                                        </div>
                                    </a>
                    
                                    <!-- Delete Icon -->
                                    <a href="#" id="deleteModalBtn" class="delete-icon">
                                        <div class="icon-circle">
                                            <i class='bx bxs-trash'></i>
                                        </div>
                                    </a>
                    
                                    <!-- Add Icon -->
                                    <a href="#" id="openModalBtn" class="add-icon">
                                        <div class="icon-circle">
                                            <i class='bi bi-plus'></i>
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

    }
?>