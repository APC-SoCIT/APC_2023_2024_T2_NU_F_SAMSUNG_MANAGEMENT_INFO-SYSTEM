<?php

    include '../database/sams_db.php';
    $conn = OpenCon();

    if(isset($_POST['input'])){
        
        $input = $_POST['input'];

        $q_getDisposed = $conn->prepare("SELECT 
                            disposed_assets_tbl.Disposed_ID as 'Dispose ID',
                            disposed_assets_tbl.Asset_No as 'Asset No',
                            disposed_assets_tbl.Category as 'Category',
                            disposed_assets_tbl.Descr as 'Descr',
                            disposed_assets_tbl.Serial_No as 'Serial No',
                            disposed_assets_tbl.Stat as 'Status',
                            disposed_assets_tbl.Disposal_Date as 'Disposal Date'
                        FROM disposed_assets_tbl
                        WHERE Disposed_ID LIKE CONCAT('%', ?, '%') OR
                            Asset_No LIKE CONCAT('%', ?, '%') OR
                            Category LIKE CONCAT('%', ?, '%') OR
                            Descr LIKE CONCAT('%', ?, '%') OR
                            Serial_No LIKE CONCAT('%', ?, '%') OR
                            Stat LIKE CONCAT('%', ?, '%') OR
                            Disposal_Date LIKE CONCAT('%', ?, '%')");

        $q_getDisposed->bind_param("sssssss", $input, $input, $input, $input, $input, $input, $input);
        if($q_getDisposed->execute()){

            $q_getDisposed->store_result();
            $num_rows = $q_getDisposed->num_rows();

            if($num_rows > 0){?>
                <table class=collapsed>
                <thead class="tbl-header">
                    <th></th>
                    <th>Disposed ID</th>
                    <th>Asset No</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Serial No</th>
                    <th>Status</th>
                    <th>Date</th>
                </thead>
                
                <?php
                    $q_getDisposed->bind_result($id, $asset_no, $catg, $descr, $serial_no, $stat, $date);
                    while($q_getDisposed->fetch()){
                        $id_rst = $id;
                        $asset_no_rst = $asset_no;
                        $catg_rst = $catg;
                        $descr_rst = $descr;
                        $serial_no_rst = $serial_no;
                        $stat_rst = $stat;
                        $date_rst = $date;

                        ?>
                            <tr id="disposedtr">
                                <td>
                                    <input type="checkbox" id="<?php echo $id_rst ?>" name="dispose_asset" value="<?php echo $id_rst ?>">
                                </td>
                                <td><?php echo $id_rst;?></td>
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

            echo "<h5 class=\"error-txt\">Error Preparing Statement!</h5>";

        }

    }

?>