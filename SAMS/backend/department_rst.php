<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    if(isset($_POST['input'])){

        $input = $_POST['input'];

        $q_getDepartment = "SELECT 
                                department_tbl.Department_ID AS 'Department ID',
                                department_tbl.Department AS 'Department',
                                GROUP_CONCAT(cost_center_tbl.Cost_Center SEPARATOR ', ') AS 'Cost Centers' 
                            FROM department_tbl
                            LEFT JOIN dept_ccenter_jtbl ON department_tbl.Department_ID = dept_ccenter_jtbl.Department_ID
                            LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                            WHERE department_tbl.Department_ID LIKE '{$input}%' OR
                                  department_tbl.Department LIKE '{$input}%' OR
                                  cost_center_tbl.Cost_Center LIKE '{$input}%'
                            GROUP BY department_tbl.Department_ID, department_tbl.Department
                            ORDER BY 'Department ID'";

        $row_Department = mysqli_query($conn, $q_getDepartment);

        if(mysqli_num_rows($row_Department) > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th>Department ID</th>
                    <th>Department</th>
                    <th>Cost Center</th>
                    <th></th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_Department)){
                        $dept_id = $row['Department ID'];
                        $dept = $row['Department'];
                        $ccenter = $row['Cost Centers'];

                        ?>
                        <tr id="depttr">
                            <td><?php echo $dept_id;?></td>
                            <td><?php echo $dept;?></td>
                            <td><?php echo $ccenter;?></td>
                            <td>
                                    <button id="button-cell" class="edit-dept" value="<?php echo $dept_id?>">
                                        <div class="icon-circle">
                                        <i class='bx bxs-edit'></i>
                                        </div>
                                    </button>
                                    <button id="button-cell" class="delete-dept" value="<?php echo $dept_id?>">
                                        <div class="icon-circle">
                                            <i class='bx bxs-trash'></i>
                                        </div>
                                    </button>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </table>

          <?php

        }else{
            echo "<h5 class=\"error-txt\">Department does not exist!</h5>";
        }

    }else{

    }

?>