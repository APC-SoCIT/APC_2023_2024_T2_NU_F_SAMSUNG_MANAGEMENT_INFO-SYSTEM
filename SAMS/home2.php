<?php require_once "controllerUserData.php"; ?>
<?php 

include "database/sams_db.php"; // Correct the path to your database connection file
$con = OpenCon(); // Open the database connection

$email = $_SESSION['email'];
$password = $_SESSION['password'];

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
				header('Location: login-user.php?msg=No Access!');
			}
		} else {
			header('Location: user-otp.php');
		}
	}
} else {
	header('Location: login-user.php?msg=Session Expired!');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons for icons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet' async>
	
	<!-- CSS -->
	<link rel="stylesheet" href="admin-css/dashboard.css" async>

	<!-- JS -->
	<script src="scripts/dropdown.js"></script>
	
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
			<li class="active">
				<a href="#">
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
			<li>
				<a href="asset.php">
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
	<!-------------------------------------------------------- -->



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
					<input type="search" placeholder="Search">
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
					<a href="#" class="editpro">Edit Profile</a>
					<a href="#" class="dash">User Dashboard</a>
					<a href="#" class="set">Settings</a>
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

		<?php
		
			// Overall Number of Assets
			$q_totalAsset = "SELECT COUNT(*) AS 'Total' FROM it_assets_tbl";

			$row_total = mysqli_query($con, $q_totalAsset);
			if(mysqli_num_rows($row_total) > 0){
				while($row = mysqli_fetch_assoc($row_total)){

					$total = $row['Total'];

				}
			}

			// Overall Stored Assets
			$q_getStored = "SELECT
							COUNT(assigned_assets_tbl.System_ID) as 'Stored'
							FROM it_assets_tbl
							LEFT JOIN assigned_assets_tbl
							ON it_assets_tbl.Asset_ID = assigned_assets_tbl.Asset_ID
							WHERE assigned_assets_tbl.System_ID = 1";
			
			$row_stored = mysqli_query($con, $q_getStored);
			if(mysqli_num_rows($row_stored) > 0){
				while($row = mysqli_fetch_assoc($row_stored)){

					$stored = $row['Stored'];

				}
			}

			// Overall Assigned/Deployed Assets
			$assigned = $total - $stored;

			// Overall Dispsoed Assets
			$q_getDisposed = "SELECT COUNT(*) AS 'Disposed' FROM disposed_assets_tbl";

			$row_disposed = mysqli_query($con, $q_getDisposed);
			if(mysqli_num_rows($row_disposed) > 0){
				while($row = mysqli_fetch_assoc($row_disposed)){

					$disposed = $row['Disposed'];

				}
			}

			// Overall Departments
			$q_getDept = "SELECT COUNT(*) AS 'Dept' FROM department_tbl";

			$row_dept = mysqli_query($con, $q_getDept);
			if(mysqli_num_rows($row_dept)){
				while($row = mysqli_fetch_assoc($row_dept)){

					$dept = $row['Dept'];

				}
			}

			// Overall Employees
			$q_getEmp = "SELECT COUNT(*) AS 'Emp' FROM employee_tbl";

			$row_emp = mysqli_query($con, $q_getEmp);
			if(mysqli_num_rows($row_emp)){
				while($row = mysqli_fetch_assoc($row_emp)){

					$emp = $row['Emp'];

				}
			}
		
		?>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-cube' ></i>
					<span class="text">
						<h3><?php echo $total?></h3>
						<p>Asset</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-network-chart' ></i>
					<span class="text">
						<h3><?php echo $assigned?></h3>
						<p>Deployed</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-archive' ></i>
					<span class="text">
						<h3><?php echo $stored?></h3>
						<p>Stored</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-trash' ></i>
					<span class="text">
						<h3><?php echo $disposed?></h3>
						<p>Disposed</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-building' ></i>
					<span class="text">
						<h3><?php echo $dept?></h3>
						<p>Department</p>
					</span>
				</li>

				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3><?php echo $emp?></h3>
						<p>Employee</p>
					</span>
				</li>
			</ul>
		</main>
	</section>
	<!-- -------------------------------------------------------------- -->
	<script src="scripts/dashboardadmin.js"></script>
	
	<script async defer>
      applyStoredTheme();
    </script>

	</body>
</html>

