<option value="" selected="">None</option>

<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    if(isset($_POST['filter_cat'])){

        $filter_cat = $_POST['filter_cat'];
        $q_filter = "SELECT DISTINCT $filter_cat as 'Value' FROM logs_tbl
                                LEFT JOIN it_assets_tbl ON logs_tbl.Asset_ID = it_assets_tbl.Asset_ID
                                LEFT JOIN employee_tbl ON logs_tbl.System_ID = employee_tbl.System_ID
                                LEFT JOIN cost_center_tbl ON employee_tbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID";
        $row_asset = mysqli_query($conn, $q_filter);

        if(mysqli_num_rows($row_asset) > 0){
                    while($row = mysqli_fetch_assoc($row_asset)){
                        $category = $row['Value'];
                        ?>
                        <option value="<?php echo $category ?: 'N/A' ?>"><?php echo $category ?: 'N/A'; ?></option>
                    <?php }}}?>