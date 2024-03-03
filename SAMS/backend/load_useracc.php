<?php
    include '../database/sams_db.php';
    $con = OpenCon();

    $sql_all_users = "SELECT * FROM employee_tbl ORDER BY Stat DESC";
    $result_all_users = mysqli_query($con, $sql_all_users);

    if(mysqli_num_rows($result_all_users) > 0){?>
        <table class="collapsed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Knox ID</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
                while ($row = mysqli_fetch_assoc($result_all_users)) {?>
                    <tr>
                        <td><?php echo $row['Employee_ID']; ?></td>
                        <td><?php echo $row['Fname'] .' '. $row['Lname']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['Knox_ID']; ?></td>
                        <td><?php echo $row['Pword'] ? '******' : 'Not Set'; // Display a placeholder for password ?></td>
                        <td><?php echo $row['Stat'] ?: 'unverified'; ?></td>
                        <td><?php echo $row['Roles'] ?: 'No Account'; ?></td>
                        
                        <td>
                            <!-- Edit Icon -->
                            <a href="#" id="editModalBtn" class="edit-icon">
                                <div class="icon-circle">
                                    <i class='bx bxs-edit'></i>
                                </div>
                            </a>
            
                            <!-- Delete Icon -->
                            <a href="#" id="deleteModalBtn"class="delete-icon">
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
?>