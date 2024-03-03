<option value="" selected="">None</option>

<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    if(isset($_POST['filter_cat'])){

        $filter_cat = $_POST['filter_cat'];
        $q_filter = "SELECT DISTINCT $filter_cat as 'Value' FROM cost_center_tbl";

        $row_asset = mysqli_query($conn, $q_filter);

        if(mysqli_num_rows($row_asset) > 0){
                    while($row = mysqli_fetch_assoc($row_asset)){
                        $category = $row['Value'];
                        ?>
                        <option value="<?php echo $category ?: 'N/A' ?>"><?php echo $category ?: 'N/A'; ?></option>
                    <?php }}}?>