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

        $q_getDepartment = "SELECT 
                            department_tbl.Department_ID AS 'Department ID',
                            department_tbl.Department AS 'Department',
                            GROUP_CONCAT(cost_center_tbl.Cost_Center SEPARATOR ', ') AS 'Cost Centers' 
                        FROM department_tbl
                        LEFT JOIN dept_ccenter_jtbl ON department_tbl.Department_ID = dept_ccenter_jtbl.Department_ID
                        LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                        WHERE $filter_cat = '$filter'
                        GROUP BY department_tbl.Department_ID, department_tbl.Department
                        ORDER BY $request $flag";

        $row_Department = mysqli_query($conn, $q_getDepartment);

        if(mysqli_num_rows($row_Department) > 0){?>

            <table class="collapsed">
                <thead class="tbl-header">
                    <th id="id-col">Department ID</th>
                    <th id="dept-col">Department</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th>Action</th>
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
            echo "<h5 class=\"error-txt\">User does not exist!</h5>";
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

        $q_getDepartment = "SELECT 
                            department_tbl.Department_ID AS 'Department ID',
                            department_tbl.Department AS 'Department',
                            GROUP_CONCAT(cost_center_tbl.Cost_Center SEPARATOR ', ') AS 'Cost Centers' 
                        FROM department_tbl
                        LEFT JOIN dept_ccenter_jtbl ON department_tbl.Department_ID = dept_ccenter_jtbl.Department_ID
                        LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                        WHERE $filter_cat = '$filter'
                        GROUP BY department_tbl.Department_ID, department_tbl.Department";

        $row_Department = mysqli_query($conn, $q_getDepartment);

        if(mysqli_num_rows($row_Department) > 0){?>

            <table class="collapsed">
                <thead class="tbl-header">
                    <th id="id-col">Department ID</th>
                    <th id="dept-col">Department</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th>Action</th>
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
            echo "<h5 class=\"error-txt\">User does not exist!</h5>";
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

        $q_getDepartment = "SELECT 
                            department_tbl.Department_ID AS 'Department ID',
                            department_tbl.Department AS 'Department',
                            GROUP_CONCAT(cost_center_tbl.Cost_Center SEPARATOR ', ') AS 'Cost Centers' 
                        FROM department_tbl
                        LEFT JOIN dept_ccenter_jtbl ON department_tbl.Department_ID = dept_ccenter_jtbl.Department_ID
                        LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                        GROUP BY department_tbl.Department_ID, department_tbl.Department
                        ORDER BY $request $flag";

        $row_Department = mysqli_query($conn, $q_getDepartment);

        if(mysqli_num_rows($row_Department) > 0){?>

            <table class="collapsed">
                <thead class="tbl-header">
                    <th id="id-col">Department ID</th>
                    <th id="dept-col">Department</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th>Action</th>
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
            echo "<h5 class=\"error-txt\">User does not exist!</h5>";
        }
    //No sort or filtering
    }else{
    $q_getDepartment = "SELECT 
                            department_tbl.Department_ID AS 'Department ID',
                            department_tbl.Department AS 'Department',
                            GROUP_CONCAT(cost_center_tbl.Cost_Center SEPARATOR ', ') AS 'Cost Centers' 
                        FROM department_tbl
                        LEFT JOIN dept_ccenter_jtbl ON department_tbl.Department_ID = dept_ccenter_jtbl.Department_ID
                        LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
                        GROUP BY department_tbl.Department_ID, department_tbl.Department
                        ORDER BY 'Department ID'";


        $row_Department = mysqli_query($conn, $q_getDepartment);

        if(mysqli_num_rows($row_Department) > 0){?>

            <table class="collapsed">
                <thead class="tbl-header">
                    <th id="id-col">Department ID</th>
                    <th id="dept-col">Department</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th>Action</th>
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
            echo "<h5 class=\"error-txt\">User does not exist!</h5>";
        }

    }
?>