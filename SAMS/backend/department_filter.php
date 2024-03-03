<option value="" selected="">None</option>

<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    if(isset($_POST['filter_cat'])){

        $filter_cat = $_POST['filter_cat'];
        $q_filter = "SELECT DISTINCT $filter_cat as 'Value' FROM department_tbl
        LEFT JOIN dept_ccenter_jtbl ON department_tbl.Department_ID = dept_ccenter_jtbl.Department_ID
        LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl.Cost_Center_ID = cost_center_tbl.Cost_Center_ID";

        $row_asset = mysqli_query($conn, $q_filter);

        if(mysqli_num_rows($row_asset) > 0){
                    while($row = mysqli_fetch_assoc($row_asset)){
                        $category = $row['Value'];
                        ?>
                        <option value="<?php echo $category ?: 'N/A' ?>"><?php echo $category ?: 'N/A'; ?></option>
                    <?php }}}?>