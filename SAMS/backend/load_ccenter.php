<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    if(isset($_POST['rm_ccenter'])){

        $dept_id = $_POST['dept_id'];
        // Cost Centers assigned to Department

        $q_getCcenter = $conn->prepare("SELECT dept_ccenter_jtbl.Cost_Center_ID,
                                cost_center_tbl.Cost_Center
                        FROM dept_ccenter_jtbl
                        INNER JOIN cost_center_tbl 
                            ON cost_center_tbl.Cost_Center_ID = dept_ccenter_jtbl.Cost_Center_ID
                        WHERE Department_ID = ?");

        if($q_getCcenter){

            $q_getCcenter->bind_param("s", $dept_id);
            if($q_getCcenter->execute()){

                $q_getCcenter->store_result();
                $num_rows = $q_getCcenter->num_rows();
                if($num_rows > 0){
                ?> <option value="" selected>None</option> 
                <?php
                $q_getCcenter->bind_result($ccenter_id, $ccenter);
                while($q_getCcenter->fetch()){
                    $ccenter_id_rst = $ccenter_id;
                    $ccenter_rst = $ccenter;

                    ?>

                    <option value="<?php echo $ccenter_id_rst?>"><?php echo $ccenter_rst?></option>

                    <?php

                }

                }else{
                echo "None Found";
                }
            }

        }

    }else{

        $q_load_ccenter = "SELECT Cost_Center_ID, Cost_Center
                       FROM cost_center_tbl";

        $row_ccenter = $conn->prepare($q_load_ccenter);

        if($row_ccenter->execute()){

            $row_ccenter->store_result();
            $num_rows = $row_ccenter->num_rows;

            if($num_rows > 0){?>

                <table class=collapsed>
                    <thead class="tbl-header">
                        <th>Cost Center ID</th>
                        <th>Cost Center</th>
                        <th>Action</th>
                    </thead>
                    
                    <?php

                        $row_ccenter->bind_result($ccenter_id, $ccenter);
                        while($row_ccenter->fetch()){
                            $ccenter_id_rst = $ccenter_id;
                            $ccenter_rst = $ccenter;

                            ?>
                            <tr id="depttr">
                                <td><?php echo $ccenter_id_rst;?></td>
                                <td><?php echo $ccenter_rst;?></td>
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
                echo "<h5 class=\"error-txt\">User does not exist!</h5>";
            }

        }else{
            
            echo "<h5 class=\"error-txt\">Error!</h5>";

        }

    }


?>