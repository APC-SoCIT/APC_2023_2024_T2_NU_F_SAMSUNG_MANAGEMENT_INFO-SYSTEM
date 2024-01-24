<?php
    include '../database/sams_db.php';
    $conn = OpenCon();

    $q_getAssets = "SELECT
                        it_assets_tbl.Category as 'Category',
                        it_assets_tbl.Descr as 'Descr',
                        COUNT(Category) as 'Quantity'
                    FROM it_assets_tbl
                    GROUP BY Descr";

    $q_getStored = "SELECT
                        it_assets_tbl.Descr as 'Descr',
                        COUNT(assigned_assets_tbl.System_ID) as 'Stored'
                        FROM it_assets_tbl
                        LEFT JOIN assigned_assets_tbl
                        ON it_assets_tbl.Asset_ID = assigned_assets_tbl.Asset_ID
                        WHERE assigned_assets_tbl.System_ID = 5
                        GROUP BY Descr";

    $row_asset = mysqli_query($conn, $q_getAssets);
    $row_stored = mysqli_query($conn, $q_getStored);

    $stored_rows = [];
    while($row = mysqli_fetch_assoc($row_stored)){
        $stored_rows[$row['Descr']] = $row['Stored'];
    }

    if(mysqli_num_rows($row_asset) > 0 && mysqli_num_rows($row_stored) >= 0){
        echo "<table class=collapsed>
                <thead class='tbl-header'>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Stored</th>
                    <th>Assigned</th>
                </thead>";

        while($row = mysqli_fetch_assoc($row_asset)){
            $category = $row['Category'];
            $descr = $row['Descr'];
            $qty = $row['Quantity'];
            $store = $stored_rows[$descr] ?? 0;
            $assigned = $qty - $store;

            echo "<tr id='asset-invtr'>
                    <td>" . ($category ?? 'N/A') . "</td>
                    <td>" . ($descr ?? 'N/A') . "</td>
                    <td>" . ($qty ?? '0') . "</td>
                    <td>" . ($store ?? '0') . "</td>
                    <td>" . ($assigned ?? '0') . "</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<h5 class=\"error-txt\">Asset does not exist!</h5>";
    }
?>
