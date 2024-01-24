<?php require_once "controllerUserData.php"; ?>
<?php 
include "database/sams_db.php"; // Correct the path to your database connection file
$con = OpenCon(); // Open the database connection

$email = $_SESSION['email'];
$password = $_SESSION['password'];
$fetch_info = null; // Initialize $fetch_info outside the if block

if ($email != false && $password != false) {
    $sql = "SELECT * FROM employee_tbl WHERE Email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if ($run_Sql) {
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['Stat'];
        $code = $fetch_info['Code'];
        if ($status == "verified") {
            if ($code != 0) {
                header('Location: reset-code.php');
            }
        } else {
            header('Location: user-otp.php');
        }
    }
} else {
    header('Location: login-user.php');
}

if(!empty($_GET['status'])){
	switch($_GET['status']){
		case 'succ':
		  $statusType = 'alert-success';
		  $statusMsg = 'Asset has been Imported Successfully.';
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


<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Tags -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons for icons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	
	<!-- CSS -->
	<link rel="stylesheet" href="admin-css/department.css">
	<link rel="stylesheet" href="admin-css/modal.css">
	<link rel="stylesheet" href="admin-css/modal1.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

	<!-- JQuery -->
	<script src="https://code.jquery.com/jquery-3.6.3.min.js" 
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous">
	</script>

	<!-- JavaScripts haha get it -->
	<script src="scripts/asset_inv.js"></script>
	<script src="scripts/modal.js"></script>

	<!-- Flat Pickr -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

	<title>SAMS</title>
</head>
<body>

	<!--LEFT SIDE CONTENT -->
	<section id="sidebar">
		<!--Logo and Brand Name-->
        <a href="#" class="brand">
			<img src="logo/logo.png" alt="">
		</a>
		<ul class="side-menu top">
			<li>
				<a href="home.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="department.php">
					<i class='bx bxs-building' ></i>
					<span class="text">Department</span>
				</a>
			</li>
			<li>
				<a href="employee.php">
					<i class='bx bxs-user' ></i>
					<span class="text">Employee</span>
				</a>
			</li>
			<li class="active">
				<a href="#">
					<i class='bx bxs-cube' ></i>
					<span class="text">Asset</span>
				</a>
			</li>
			<li>
				<a href="asset-assign.php">
					<i class='bx bxs-check-shield' ></i>
					<span class="text">Asset Assignment</span>
				</a>
			</li>
			<li>
				<a href="logs.php">
					<i class='bx bxs-archive-in' ></i>
					<span class="text">Logs</span>
				</a>
			</li>
			<li>
				<a href="disposed.php">
					<i class='bx bxs-trash' ></i>
					<span class="text">Disposed Asset</span>
				</a>
			</li>
			<li>
				<a href="account.php">
					<i class='bx bxs-group' ></i>
					<span class="text">User Account</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
            <li>
                <a href="logout-user.php" class="logout">
                    <i class='bx bxs-log-out'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
		</ul>
	</section>

	<!-- TOP SIDE CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>

			<!--menu 3 lines icon-->
			<i class='bx bx-menu' ></i>

			<!--Text for category-->
			<a href="#" class="nav-link">Categories</a>
			
			<!--Search-->
			<form action="#">
				<div class="form-input">
					<input type="search" id="asset-inv-sch" class="asset-search-bar" name="search_asset" placeholder="Search Asset">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>

			<!--Messages-->
			<a href="#" class="notification">
				<i class='bx bxs-message' ></i>
				<span class="num">8</span>
			</a>

			<!--Dark Mode-->			
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>

			<!--Fetching Name-->
			<a href="#">
				<span class="text">Hey,  <?php echo $fetch_info['Fname'] ?></span>
			</a>


			<!--Profile image ixample-->
			<a href="#" class="profile">
				<img src="logo/profile.avif">
			</a>

		</nav>
		<!-- ------------------------------------------------- -->


		<!-- MAIN CONTENT -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Asset Inventory</h1>
				</div>
			</div>
			<div name="msg">
				<?php
				if(isset($_GET['msg'])){
					$msg = $_GET['msg'];

					echo '<p class="good-txt">' . $msg . '</p>';
				}else if(isset($_GET['error-msg'])){
					$msg = $_GET['error-msg'];

					echo '<p class="error-txt">' . $msg . '</p>';
				}

				if(!empty($statusMsg)){ ?>

					<div class="col-xs-12">
					  <div class="alert <?php echo $statusType; ?> "><?php echo $statusMsg; ?></div>
					</div>
		
				  <?php }
				?>
			</div>
			<button id="openModalBtn import_asset"><i class="bi bi-box-arrow-in-down"></i> Import Asset</button>
			<div id="myModal" class="import-form">
				<div class="import-content">
					<form action="backend/import_data.php" method="post" enctype="multipart/form-data">
						<input class="form-control" type="file" name="file"/>
						<input class="form-control button" id="emp_import_button" type="submit" name="asset_import_submit" value="Import">
					</form>
				</div>
			</div>
			
            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Asset Inventory</h3>
						<button class="btnclear" id="clear-search">Clear</button>
						<i class='bx bx-filter'></i>
					</div>
					<!-- Loaded Table -->
					<div id="searchresult">

					</div>
				</div>
			</div>
		</main>
	</section>
	<!-- -------------------------------------------------------------- -->


	<script src="scripts/dashboardadmin.js"></script>
</body>
</html>