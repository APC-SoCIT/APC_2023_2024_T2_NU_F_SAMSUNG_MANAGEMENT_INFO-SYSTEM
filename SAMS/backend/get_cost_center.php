<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    $deptnotclean = $_GET['dept'];
    $ccenter = $_GET['ccenter'];

    $dept = str_replace("_", ' ', $deptnotclean);

    $dept = mysqli_real_escape_string($conn, $dept);
    $ccenter = mysqli_real_escape_string($conn, $ccenter);

    $q_getCostCenter = "SELECT Cost_Center 
                        FROM cost_center_tbl
                        INNER JOIN dept_ccenter_jtbl ON cost_center_tbl.Cost_Center_ID = dept_ccenter_jtbl.Cost_Center_ID
                        INNER JOIN department_tbl ON department_tbl.Department_ID = dept_ccenter_jtbl.Department_ID
                        WHERE department_tbl.Department_ID = '$dept' IS NOT NULL AND department_tbl.Department_ID = '$dept' <> ''";

    $q_getDeptName = "SELECT Department
                      FROM department_tbl
                      WHERE Department_ID = '$dept'";

    $row_costcenter = mysqli_query($conn, $q_getCostCenter);
    $row_deptname = mysqli_query($conn, $q_getDeptName);

    $row_dept = mysqli_fetch_assoc($row_deptname);
    $dept_name = $row_dept["Department"];

    echo "<option value=\"\" selected disabled> Select Cost Center </option>";

    if(mysqli_num_rows($row_costcenter) > 0){

        while($row = mysqli_fetch_assoc($row_costcenter)){
            $cost_center_col = $row["Cost_Center"];
            $selected = $cost_center_col === $ccenter ? 'selected' : '';
            echo "<option value=\"$cost_center_col\" $selected>$dept_name - $cost_center_col</option>";
        }
    }else{
        echo "<option value=\"\" selected disabled>No Cost Center Available</option>";
    }
?>
