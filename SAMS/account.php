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
	<link rel="stylesheet" href="admin-css/modal1.css" async>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" async>

	<!-- JQuery -->
	<script src="https://code.jquery.com/jquery-3.6.3.min.js" 
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous">
	</script>

	<!-- JavaScripts -->
	<script src="scripts/useracc.js"></script>
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
			<li class="active">
				<a href="#">
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
					<input class="emp-search-bar" type="search" id="usr-sch" name="search_employee" placeholder="Search Employee">
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
					<h1>User Account</h1>
					<div name="msg">
						<?php
						if(isset($_GET['msg'])){
							$msg = $_GET['msg'];

							echo '<p class="good-txt" style="background-color: #d4edda; color: #155724; padding: 10px; display: inline-block;">' . $msg . '</p>';
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

					<!--MODAL-->

					<div id="myModal" class="modal">
						<div class="modal-content">
							<span class="close" id="closeModalBtn">&times;</span>
							<form action="" method="POST" autocomplete="">
								<h2 class="text-center">Create Account</h2>
								<p class="text-center">It's quick and easy.</p>

								<?php
									if(count($errors) == 1){
										?>
										<div class="alert alert-danger text-center">
											<?php
											foreach($errors as $showerror){
												echo $showerror;
											}
											?>
										</div>
										<?php
									}elseif(count($errors) > 1){
										?>
										<div class="alert alert-danger">
											<?php
											foreach($errors as $showerror){
												?>
												<li><?php echo $showerror; ?></li>
												<?php
											}
											?>
										</div>
										<?php
									}
								?>

								<div class="form-group">
									<input class="form-control" id="hidden-id" type="hidden" name="emp_id" placeholder="Employee ID" required>
								</div>
								<div class="form-group">
									<input class="form-control" id="hidden-pass" type="hidden" name="password" placeholder="Password" required>
								</div>
								<div class="form-group">
									<input class="form-control" id="hidden-cpass" type="hidden" name="cpassword" placeholder="Confirm password" required>
								</div>

								<p class="text-center">Do you want to create an account for <span id="full-name"></span>?</p>

								<div class="form-group">
									<label for="role">Select Role:</label>
									<select class="form-control" name="role" id="role">
										<option value="User">User</option>
										<option value="Admin">Admin</option>
									</select>
								</div>
								<div class="form-group">
									<input class="form-control button" type="submit" name="signup" value="Submit" id="signupForm">
								</div>
								
						</form>
						</div>
					</div>
					<div id="myModal2" class="modal">
						<div class="modal-content">
							<span class="close" id="closeModalBtn">&times;</span>
							<form action="" method="POST" autocomplete="">
								<h2 class="text-center">Delete Account</h2>

								<?php
									if(count($errors) == 1){
										?>
										<div class="alert alert-danger text-center">
											<?php
											foreach($errors as $showerror){
												echo $showerror;
											}
											?>
										</div>
										<?php
									}elseif(count($errors) > 1){
										?>
										<div class="alert alert-danger">
											<?php
											foreach($errors as $showerror){
												?>
												<li><?php echo $showerror; ?></li>
												<?php
											}
											?>
										</div>
										<?php
									}
								?>

								<div class="form-group">
									<input class="form-control" id="del-hidden-id" type="hidden" name="emp_id" placeholder="Employee ID" required>
								</div>

								<p class="text-center">Do you want to delete account for <span id="del-full-name"></span>?</p>
								<div class="form-group">
									<input class="form-control button" type="submit" name="remove-acc" value="Submit" id="signupForm">
								</div>
								
						</form>
						</div>
					</div>
					<div id="myModal3" class="modal">
						<div class="modal-content">
							<span class="close" id="closeModalBtn">&times;</span>
							<form action="" method="POST" autocomplete="">
								<h2 class="text-center">Edit Role</h2>

								<?php
									if(count($errors) == 1){
										?>
										<div class="alert alert-danger text-center">
											<?php
											foreach($errors as $showerror){
												echo $showerror;
											}
											?>
										</div>
										<?php
									}elseif(count($errors) > 1){
										?>
										<div class="alert alert-danger">
											<?php
											foreach($errors as $showerror){
												?>
												<li><?php echo $showerror; ?></li>
												<?php
											}
											?>
										</div>
										<?php
									}
								?>

								<div class="form-group">
									<input class="form-control" id="up-hidden-id" type="hidden" name="emp_id" placeholder="Employee ID" required>
								</div>

								<p class="text-center">Edit Role for <span id="up-full-name"></span>?</p>

								<div class="form-group">
									<label for="role">Select Role:</label>
									<select class="form-control" name="role" id="role">
										<option value="User">User</option>
										<option value="Admin">Admin</option>
									</select>
								</div>
								<div class="form-group">
									<input class="form-control button" type="submit" name="update-acc" value="Submit" id="signupForm">
								</div>
								
						</form>
						</div>
					</div>

				</div>
			</div>

			
            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>User Account</h3>
						<button class="btnclear" id="clear-search">Clear</button>
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
    <script defer aync>
		applyStoredTheme();
	</script>

</body>
</html>