<?php require_once "controllerUserData.php"; ?>
<?php 
include "database/sams_db.php"; // Correct the path to your database connection file
$con = OpenCon(); // Open the database connection

$email = $_SESSION['email'];
$password = $_SESSION['password'];
// Session Time out Code
$session_login = $_SESSION['keepLoggedIn'];

// Check if there is a timeout session already running
if(!isset($_SESSION['timeout'])){
	$_SESSION['timeout'] = time(); // Update last activity time
}

// Set timeout session 30 minutes if user did not check Keep me Logged In
if($session_login != "T"){
	if (isset($_SESSION['timeout']) && (time() - $_SESSION['timeout'] > 900)) {
		// If the last activity was more than 30 minutes ago, destroy the session
		session_destroy();
		session_unset();

		$expired = 'Session Timed out!';
		header('Location: login-user.php?msg=Session Expired!');
	}
}
$fetch_info = null; // Initialize $fetch_info outside the if block

if ($email != false && $password != false) {
	$sql = "SELECT * FROM employee_tbl WHERE Email = '$email'";
	$run_Sql = mysqli_query($con, $sql);
	if ($run_Sql) {
		$fetch_info = mysqli_fetch_assoc($run_Sql);
		$status = $fetch_info['Stat'];
		$code = $fetch_info['Code'];
		$role = $fetch_info['Roles'];
		if ($status == "verified") {
			if ($code != 0) {
				header('Location: reset-code.php');
			}else if($role === 'User'){
				$error = 'No Access!';
				header('Location: login-user.php?msg='.$error);
			}
		} else {
			header('Location: user-otp.php');
		}
	}
} else {
	header('Location: login-user.php?msg=Session Expired!');
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
	<link rel="stylesheet" href="admin-css/department.css" async>
	<link rel="stylesheet" href="admin-css/dashboard.css" async>
	<link rel="stylesheet" href="admin-css/modal.css" async>
	<link rel="stylesheet" href="admin-css/modal1.css"async>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" async>

	<!-- JQuery -->
	<script src="https://code.jquery.com/jquery-3.6.3.min.js" 
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous">
	</script>

	<!-- JavaScripts -->
	<script src="scripts/asset_inv.js"></script>
	<script src="scripts/dropdown.js"></script>

	<!-- Flat Pickr -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" async>
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
                <a href="costcenter.php">
                    <i class='bx bxs-building'></i>
                    <span class="text">Cost Center</span>
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
			<a href="#" class="nav-link">Admin</a>
			
			<!--Search-->
			<form action="#">
				<div class="form-input">
					<input type="search" id="asset-inv-sch" class="asset-search-bar" name="search_asset" placeholder="Search Asset">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>

			<!--Dark Mode-->			
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>

			<!--Fetching Name-->
			<a href="#">
				<span class="name">Hey,  <?php echo $fetch_info['Fname'] ?></span>
			</a>
			
			<!-- Dropdown -->
			<div class="dropdown">
				<i class='bx bx-chevron-down dropdown-icon' onclick="toggleDropdown()"></i>
				<div class="dropdown-content" id="dropdownContent">
					<!-- Your dropdown content goes here -->
					<?php
					$sql = "SELECT * FROM employee_tbl WHERE Email = '$email'";
					$run_Sql = mysqli_query($con, $sql);
					if ($run_Sql) {
						$fetch_info = mysqli_fetch_assoc($run_Sql);
						$role = $fetch_info['Roles'];
						if($role =="Admin"){
							?>
							<a href="user.php" class="dash">User Dashboard</a><?php
						}
					}
					?>
					<a href="settings.php" class="set">Settings</a>
				</div>
			</div>

			<!-- Theme Switcher -->
			<div class="theme-switcher" id="themeSwitcher">
				<i class="bx bx-paint"></i>
				<span class="text">Theme</span>
				<ul class="theme-options">
					<li data-theme="option1"></li>
					<li data-theme="option2"></li>
				<!-- add another option/color here if there is anything you want to add  -->
				</ul>
			</div>

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

			<button id="openModalBtn add-submit">+ Add Asset</button>
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
						<div class="filter">
							<span>Filter by: &nbsp;</span>
							<select name="filter-cat" id="filter-cat">
								<option value="" selected="">None</option>
								<option value="it_assets_tbl.Category">Category</option>
								<option value="it_assets_tbl.Descr">Description</option>
							</select>
							<select name="filter-table" id="filter-table">
								<option value="" selected="">None</option>
							</select>
						</div>
					</div>
					<!-- Loaded Table -->
					<div id="searchresult">

					</div>
				</div>

				<div id="myModal2" class="modal">
					<div class="modal-content">
					<span class="close" id="closeModalBtn">&times;</span>
					<form action="backend/add_asset.php" class="add-assetform" method="POST">
						<h3>Add Asset</h3><br>
						<div class="form-group">
						<input type="text" class="form-control" pattern="[0-9]+" placeholder="Asset Number" id="asset_no" name="asset_no" maxlength="15" required><br>
						</div>
						<div class="form-group">
						<select name="category" class="form-control" id="category" required>
							<option value="" disabled selected>--Category--</option>
							<option value="Laptop">Laptop</option>
							<option value="Cellphone">Cellphone</option>
							<option value="Printer">Printer</option>
							<option value="Television">Television</option>
							<option value="Monitor">Monitor</option>
						</select>
						</div>
						<div class="form-group">
						<input type="text" class="form-control" placeholder="Description" id="descr" name="descr" maxlength="25" required><br>
						</div>
						<div class="form-group">
						<input type="text" class="form-control" placeholder="Serial Number" id="serial_no" name="serial_no" maxlength="17" required>
						</div>
						<div class="form-group">
						<input type="date" class="form-control" placeholder="Date" id="issuedate" name="issued_date" required>
						</div>
						<div class="form-group">
						<input type="submit" class="form-control button" id="add_submit" value="Add" name="add_submit">
						</div>
					</form>
					</div>
				</div>
			</div>
		</main>
	</section>
	<!-- -------------------------------------------------------------- -->


	<script src="scripts/dashboardadmin.js"></script>
	<script async defer>
      applyStoredTheme();
    </script>
</body>
</html>