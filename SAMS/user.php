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

if($email != false && $password != false){
    $sql = "SELECT * FROM employee_tbl WHERE Email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['Stat'];
        $code = $fetch_info['Code'];
        if($status == "verified"){
            if($code != 0){
                header('Location: reset-code.php');
            }
        }else{
            header('Location: user-otp.php');
        }
    }
}else{
    header('Location: login-user.php');
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
	<link rel="stylesheet" href="user-css/user-dashboard.css" async>
	<link rel="stylesheet" href="user-css/user1.css" async>
	<link rel="stylesheet" href="admin-css/modal.css" async>
	<link rel="stylesheet" href="admin-css/dashboard.css" async>
	<link rel="stylesheet" href="user-css/modal1.css" async>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" async>

	<!-- JQuery -->
	<script src="https://code.jquery.com/jquery-3.6.3.min.js" 
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous">
	</script>

	<!-- JavaScripts haha get it -->
	<script src="scripts/employee.js"></script>
	<script src="scripts/modal.js"></script>
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
			<li class="active">
				<a href="#">
					<i class='bx bxs-home' ></i>
					<span class="sidebartxt">Dashboard</span>
				</a>
			</li>

		
		<ul class="side-menu">
            <li>
                <a href="logout-user.php" class="logout">
                    <i class='bx bxs-log-out'></i>
                    <span class="sidebartxt">Logout</span>
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
			<a href="#" class="nav-link">
				<span class="text">User</span>
			</a>
			
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
					<?php
					$sql = "SELECT * FROM employee_tbl WHERE Email = '$email'";
					$run_Sql = mysqli_query($con, $sql);
					if ($run_Sql) {
						$fetch_info = mysqli_fetch_assoc($run_Sql);
						$role = $fetch_info['Roles'];
						if($role =="Admin"){
							?>
							<a href="home.php" class="dash">Admin Dashboard</a><?php
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

  <!-- ======================= Cards ================== -->
<?php

	$q_getProfile = $con->prepare("SELECT DISTINCT employee_tbl.System_ID as 'System ID',
						employee_tbl.Employee_ID as 'Employee ID',
						employee_tbl.Fname as 'Fname',
						employee_tbl.Lname as 'Lname',
						employee_tbl.Knox_ID as 'Knox ID',
						department_tbl.Department as 'Department',
						cost_center_tbl.Cost_Center as 'Cost Center'
					FROM employee_tbl
					LEFT JOIN dept_ccenter_jtbl AS dept_ccenter_jtbl1 ON employee_tbl.Department_ID = dept_ccenter_jtbl1.Department_ID
					LEFT JOIN department_tbl ON dept_ccenter_jtbl1.Department_ID = department_tbl.Department_ID
					LEFT JOIN dept_ccenter_jtbl AS dept_ccenter_jtbl2 ON employee_tbl.Cost_Center_ID = dept_ccenter_jtbl2.Cost_Center_ID
					LEFT JOIN cost_center_tbl ON dept_ccenter_jtbl2.Cost_Center_ID = cost_center_tbl.Cost_Center_ID
					WHERE Email = ?");

	// Escape Email and Password if there are special characters
	$email = $con->real_escape_string($email);

	// Execute MySQL Statement
	$q_getProfile->bind_param("s", $email);
	$q_getProfile->execute();
	$q_getProfile->store_result();
	$q_getProfile->bind_result($sys_id, $emp_id, $fname, $lname, $knox_id, $dept, $ccenter);
	$numrows = $q_getProfile->num_rows;

	if($numrows > 0){
		while($q_getProfile->fetch()){
			$emp_id = $emp_id;
			$fname = $fname;
			$lname = $lname;
			$knox_id = $knox_id;
			$dept = $dept;
			$ccenter = $ccenter;
		}
	}else{
			$emp_id = 'N/A';
			$fname = 'N/A';
			$lname = 'N/A';
			$knox_id = 'N/A';
			$dept = 'N/A';
			$ccenter = 'N/A';
	}

	$q_getCount = $con->prepare("SELECT COUNT(assigned_assets_tbl.Asset_ID) as 'Count'
									FROM assigned_assets_tbl
									INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
									INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
									WHERE employee_tbl.Email = ?");

	$q_getCount->bind_param("s", $email);
	$q_getCount->execute();
	$q_getCount->store_result();
	$q_getCount->bind_result($count);
	while($q_getCount->fetch()){
		$count = $count;
	}
?>
<div class="userdata">
	<div class="card">
		<div>
			<p id="userinfo">Name : <?php echo $fname .' '. $lname?></p>
			<p id="userinfo">Employee ID: <?php echo $emp_id?></p>
			<p id="userinfo">Knox ID : <?php echo $knox_id?></p>
			<p id="userinfo">Department : <?php echo $dept?></p>
			<p id="userinfo">Cost Center : <?php echo $ccenter?></p>
		</div>

	</div>

	<div class="card">
		<div>
			<p id="numbers">Assigned Asset</p>
			<p id="userinfo"><?php echo $count ?: 0;?></p>
			<p id="userinfo">Total Assigned Asset</p>
		</div>

		<div class="iconBx">
			<i class='bx bxs-dollar-circle'></i>
		</div>
	</div>
</div>

<!-- ================  User Asset Table List ================= -->
<div class="details">
	<div class="user-asset">
		<?php
	
			// Get Assets Query
			$q_getAssets = $con->prepare("SELECT it_assets_tbl.Asset_ID,
								it_assets_tbl.Asset_No, 
								it_assets_tbl.Category, 
								it_assets_tbl.Descr, 
								it_assets_tbl.Serial_No, 
								assigned_assets_tbl.Issued_Date, 
								assigned_assets_tbl.Stat
							FROM assigned_assets_tbl
							INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
							INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
							WHERE employee_tbl.Email = ?");

			// Bind parameters, execute the statement, store then bind the results to variables
			$q_getAssets->bind_param("s", $email);
			$q_getAssets->execute();
			$q_getAssets->store_result();
			$q_getAssets->bind_result($asset_id, $asset_no, $catg, $descr, $serial_no, $issue_date, $stat);
			$numrows_asset = $q_getAssets->num_rows();

			// Check whether the are existing results else return No assets
			if($numrows_asset > 0){?>
				<table class="collapsed">
					<thead class="tbl-header">
						<th>Asset ID</th>
						<th>Asset Number</th>
						<th>Category</th>
						<th>Description</th>
						<th>Serial Number</th>
						<th>Issued Date</th>
						<th>Status</th>
					</thead>
					<?php
						while($q_getAssets->fetch()){
							$asset_id = $asset_id;
							$asset_no = $asset_no;
							$catg = $catg;
							$descr = $descr;
							$serial_no = $serial_no;
							$issue_date = $issue_date;
							$stat = $stat;

							?>

							<tr id="assettr">
								<td><?php echo $asset_id ?: 'N/A'; ?></td>
								<td><?php echo $asset_no ?: 'N/A'; ?></td>
								<td><?php echo $catg ?: 'N/A'; ?></td>
								<td><?php echo $descr ?: 'N/A'; ?></td>
								<td><?php echo $serial_no ?: 'N/A'; ?></td>
								<td><?php echo $issue_date ?: 'N/A'; ?></td>
								<td><?php echo $stat ?: 'N/A'; ?></td>
							</tr>

							<?php
						}
					?>
				</table>
			<?php

			}else{
				echo "<h5 class=\"error-txt\">No assets assigned!</h5>";
			}
		?>
    </div>
</div>

	<script src="scripts/dashboardadmin.js"></script>
	<script async defer>
		applyStoredTheme();
	</script>
</body>
</html>


