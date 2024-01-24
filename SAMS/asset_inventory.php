<?php

    include 'database/sams_db.php';
    $conn = OpenCon();

    if(!empty($_GET['status'])){
      switch($_GET['status']){
          case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'Assets has been Imported Successfully.';
            break;
          case 'err';
            $statusType = 'alert-danger';
            $statusMsg = 'An error occured.';
            break;
          case 'invalid_file';
            $statusType = 'alert-danger';
            $statusMsg = 'Upload a CSV File!';
            break;
          default:
            $statusType = '';
            $statusMsg = '';
      }
  }
?>

<!doctype html>
<html lang="en">

<head>
  <title>Samsung Asset Management</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/style.css?<?php echo time();?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" 
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous">
  </script>
  <script src="js/asset_inv.js" defer></script>

</head>

<body>
  <header>
    <nav class="nav-bar">
      <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">SAMS</a>
      </div>
    </nav>
  </header>
  <main>
    <!--Sidebar-->
    <div class="sidebar">
      <a href="department.php">
        <div class="sidebar-item">
          <h2>
            Department
          </h2>
        </div>
      </a>
      <a href="employee.php">
        <div class="sidebar-item">
          <h2>
            Employee
          </h2>
        </div>
      </a>
      <a href="asset_inventory.php">
        <div class="sidebar-item">
          <h2>
            Asset Inventory
          </h2>
        </div>
      </a>
      <a href="asset.php">
        <div class="sidebar-item">
          <h2>
            Asset Assignment
          </h2>
        </div>
      </a>
      <a href="asset_logs.php">
        <div class="sidebar-item">
          <h2>
            Logs
          </h2>
        </div>
      </a>
      <a href="disposed.php">
        <div class="sidebar-item">
          <h2>
            Disposed Assets
          </h2>
        </div>
      </a>
      <a href="user_accounts.php">
        <div class="sidebar-item">
          <h2>
            User Accounts
          </h2>
        </div>
      </a>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        
      <!-- Search Bar -->
      <div class="asset-search-bar-container">
        <input type="text" id="asset-sch" class="asset-search-bar" name="search_asset" placeholder="Search Asset">
        <button id="clear-search">Clear</button>
        <button id="add-submit"><i class="bi bi-plus"></i></button>
        <button id="import-asset"><i class="bi bi-box-arrow-in-down"></i></button>
      </div><br>
      <!-- Messages/Status -->
      <div name="msg">
        <?php
          if(isset($_GET['msg'])){
            $msg = $_GET['msg'];

            echo '<p class="good-txt">' . $msg . '</p>';
          }else if(isset($_GET['error_msg'])){
            $msg = $_GET['error_msg'];

            echo '<p class="error-txt">' . $msg . '</p>';
          }

          if(!empty($statusMsg)){ ?>

            <div class="col-xs-12">
              <div class="alert <?php echo $statusType; ?> "><?php echo $statusMsg; ?></div>
            </div>

          <?php } ?>
      </div>
      <!-- Import Assets CSV File GUI -->
      <div class="import-assetGUI">
          <form action="backend/import_data.php" method="post" enctype="multipart/form-data">
              <input type="file" name="file"/>
              <input id="asset_import_button" type="submit" name="asset_import_submit" value="Import">
          </form>
      </div>
      <!-- Table -->
      <div id="searchresult" class="asset-table-container">

      </div>

    </div>
  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>