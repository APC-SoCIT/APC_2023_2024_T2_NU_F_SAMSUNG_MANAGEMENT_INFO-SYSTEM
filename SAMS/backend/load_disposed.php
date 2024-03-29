<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    $q_get_disposed = $conn->prepare("SELECT disposed_assets_tbl.Disposed_ID,
                                             it_assets_tbl.Asset_No,
                                             it_assets_tbl.Category,
                                             it_assets_tbl.Descr,
                                             it_assets_tbl.Serial_No,
                                             disposed_assets_tbl.Stat,
                                             disposed_assets_tbl.Disposal_Date
                                      FROM disposed_assets_tbl
                                      LEFT JOIN it_assets_tbl ON disposed_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID");

    if($q_get_disposed->execute()){
        
        $q_get_disposed->store_result();
        $num_rows = $q_get_disposed->num_rows();

        if($num_rows > 0){?>
            <table class="collapsed">
                <thead class="tbl-header">
                    <th>Disposed ID</th>
                    <th>Asset No</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Serial No</th>
                    <th>Status</th>
                    <th>Date</th>
                </thead>
            <?php
                $q_get_disposed->bind_result($dis_id, $asset_no, $catg, $descr, $serial_no, $stat, $date);
                while($q_get_disposed->fetch()){

                    $dis_id_rst = $dis_id;
                    $asset_no_rst = $asset_no;
                    $catg_rst = $catg;
                    $descr_rst = $descr;
                    $serial_no_rst = $serial_no;
                    $stat_rst = $stat;
                    $date_rst = $date;
                    
                    ?>

                    <tr id="disposedtr">
                        <td>
                            <input type="checkbox" id="<?php echo $dis_id_rst ?>" name="sams_employee" value="<?php echo $dis_id_rst ?>">
                        </td>
                        <td><?php echo $dis_id_rst;?></td>
                        <td><?php echo $asset_no_rst;?></td>
                        <td><?php echo $catg_rst;?></td>
                        <td><?php echo $descr_rst;?></td>
                        <td><?php echo $serial_no_rst;?></td>
                        <td><?php echo $stat_rst;?></td>
                        <td><?php echo $date_rst;?></td>
                    </tr>

                    <?php

                }
            ?>
        </table>

        <?php

        }else{
            echo "<h5 class=\"error-txt\">Asset does not exist!</h5>";
        }

    }else{
    }



?>