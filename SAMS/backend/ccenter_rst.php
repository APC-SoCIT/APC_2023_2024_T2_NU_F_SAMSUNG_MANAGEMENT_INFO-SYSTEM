<?php
    include '../database/sams_db.php';
    $conn = OpenCon();


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
    
        $q_getCcenter = "SELECT 
                                cost_center_tbl.Cost_Center_ID AS 'Cost Center ID',
                                cost_center_tbl.Cost_Center AS 'Cost Center'
                            FROM cost_center_tbl
                            WHERE (cost_center_tbl.Cost_Center_ID LIKE '{$input}%' OR
                                  cost_center_tbl.Cost_Center LIKE '{$input}%')
                                  AND $filter_cat = '$filter'
                            ORDER BY $request $flag";

        $row_Ccenter = mysqli_query($conn, $q_getCcenter);

        if(mysqli_num_rows($row_Ccenter) > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th id="id-col">Cost Center ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th>Action</th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_Ccenter)){
                        $ccenter_id = $row['Cost Center ID'];
                        $ccenter = $row['Cost Center'];

                        ?>
                        <tr id="depttr">
                            <td><?php echo $ccenter_id;?></td>
                            <td><?php echo $ccenter;?></td>
                            <td>
                                    <button id="button-cell" class="edit-ccenter" value="<?php echo $ccenter_id?>">
                                        <div class="icon-circle">
                                        <i class='bx bxs-edit'></i>
                                        </div>
                                    </button>
                                    <button id="button-cell" class="delete-ccenter" value="<?php echo $ccenter_id?>">
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
            echo "<h5 class=\"error-txt\">Cost Center does not exist!</h5>";
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
    
        $q_getCcenter = "SELECT 
                                cost_center_tbl.Cost_Center_ID AS 'Cost Center ID',
                                cost_center_tbl.Cost_Center AS 'Cost Center'
                            FROM cost_center_tbl
                            WHERE (cost_center_tbl.Cost_Center_ID LIKE '{$input}%' OR
                                  cost_center_tbl.Cost_Center LIKE '{$input}%')
                                  AND $filter_cat = '$filter'";

        $row_Ccenter = mysqli_query($conn, $q_getCcenter);

        if(mysqli_num_rows($row_Ccenter) > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th id="id-col">Cost Center ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th>Action</th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_Ccenter)){
                        $ccenter_id = $row['Cost Center ID'];
                        $ccenter = $row['Cost Center'];

                        ?>
                        <tr id="depttr">
                            <td><?php echo $ccenter_id;?></td>
                            <td><?php echo $ccenter;?></td>
                            <td>
                                    <button id="button-cell" class="edit-ccenter" value="<?php echo $ccenter_id?>">
                                        <div class="icon-circle">
                                        <i class='bx bxs-edit'></i>
                                        </div>
                                    </button>
                                    <button id="button-cell" class="delete-ccenter" value="<?php echo $ccenter_id?>">
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
            echo "<h5 class=\"error-txt\">Cost Center does not exist!</h5>";
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
    
        $q_getCcenter = "SELECT 
                                cost_center_tbl.Cost_Center_ID AS 'Cost Center ID',
                                cost_center_tbl.Cost_Center AS 'Cost Center'
                            FROM cost_center_tbl
                            WHERE cost_center_tbl.Cost_Center_ID LIKE '{$input}%' OR
                                  cost_center_tbl.Cost_Center LIKE '{$input}%'
                            ORDER BY $request $flag";

        $row_Ccenter = mysqli_query($conn, $q_getCcenter);

        if(mysqli_num_rows($row_Ccenter) > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th id="id-col">Cost Center ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th>Action</th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_Ccenter)){
                        $ccenter_id = $row['Cost Center ID'];
                        $ccenter = $row['Cost Center'];

                        ?>
                        <tr id="depttr">
                            <td><?php echo $ccenter_id;?></td>
                            <td><?php echo $ccenter;?></td>
                            <td>
                                    <button id="button-cell" class="edit-ccenter" value="<?php echo $ccenter_id?>">
                                        <div class="icon-circle">
                                        <i class='bx bxs-edit'></i>
                                        </div>
                                    </button>
                                    <button id="button-cell" class="delete-ccenter" value="<?php echo $ccenter_id?>">
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
            echo "<h5 class=\"error-txt\">Cost Center does not exist!</h5>";
        }
    
    // Search query result for asset inventory
    }else{
    
            $input = $_POST['input'];

        $q_getCcenter = "SELECT 
                                cost_center_tbl.Cost_Center_ID AS 'Cost Center ID',
                                cost_center_tbl.Cost_Center AS 'Cost Center'
                            FROM cost_center_tbl
                            WHERE cost_center_tbl.Cost_Center_ID LIKE '{$input}%' OR
                                  cost_center_tbl.Cost_Center LIKE '{$input}%'
                            ORDER BY 'Cost Center ID'";

        $row_Ccenter = mysqli_query($conn, $q_getCcenter);

        if(mysqli_num_rows($row_Ccenter) > 0){?>

            <table class=collapsed>
                <thead class="tbl-header">
                    <th id="id-col">Cost Center ID</th>
                    <th id="ccenter-col">Cost Center</th>
                    <th>Action</th>
                </thead>
                
                <?php
                    while($row = mysqli_fetch_assoc($row_Ccenter)){
                        $ccenter_id = $row['Cost Center ID'];
                        $ccenter = $row['Cost Center'];

                        ?>
                        <tr id="depttr">
                            <td><?php echo $ccenter_id;?></td>
                            <td><?php echo $ccenter;?></td>
                            <td>
                                    <button id="button-cell" class="edit-ccenter" value="<?php echo $ccenter_id?>">
                                        <div class="icon-circle">
                                        <i class='bx bxs-edit'></i>
                                        </div>
                                    </button>
                                    <button id="button-cell" class="delete-ccenter" value="<?php echo $ccenter_id?>">
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
            echo "<h5 class=\"error-txt\">Cost Center does not exist!</h5>";
        }
    }

?>