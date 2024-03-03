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

	<!-- JavaScripts haha get it -->
	<script src="scripts/settings.js"></script>
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
		<?php
					$sql = "SELECT * FROM employee_tbl WHERE Email = '$email'";
					$run_Sql = mysqli_query($con, $sql);
					if ($run_Sql) {
						$fetch_info = mysqli_fetch_assoc($run_Sql);
						$role = $fetch_info['Roles'];
						if($role =="Admin"){
							$link = "home.php" ;
						}
						else{
							$link = "user.php";
						}
					}
					?>
        <a class="brand">
			<img src="logo/logo.png" alt="">
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Settings</span>
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
			<a href="#" class="nav-link">Settings</a>
			
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
					<li data-theme="option3"></li>
				</ul>
			</div>


		</nav>
		<!-- ------------------------------------------------- -->


		<!-- MAIN CONTENT -->
		<main>
			<!--Arrow back-->
			<div class="arrow">
				<a href="<?php echo $link ?>" >
					<i class='bx bx-arrow-back'></i>
				</a>
			</div>
			<div class="head-title">
				<div class="left">
					<h1>Settings</h1>
				</div>
			</div>
			

			<button id="openModalBtn change-pass">Change Password</button>
			<div>
				<?php
                if(isset($_POST['setpwordfail'])){
                        ?>
                        <div class="alert alert-danger text-center">
                        <?php echo $_POST['setpwordfail']; ?>
                    </div>
            		<?php
                    }else if(isset($_POST['setpwordsuccess'])){
						?>
						<div class="alert alert-success text-center">
						<?php echo $_POST['setpwordsuccess']; ?>
						</div>
						<?php
					}
                    ?>
			</div>
			
			<!-- MODAL -->
			<div id="myModal8" class="modal">
				<div class="modal-content">

				
					<span class="close" id="closeModalBtn">&times;</span>
					<form action="" method="POST" autocomplete="off">
						<h3>Change Password</h3>
						<div class="form-group">
						<input class="form-control" type="password" name="setting_pass" id="setting_pass" placeholder="Create new password" required>
                        <span toggle="#password1" class="fas fa-eye field-icon toggle-password"></span>
						</div>
						<h3>Re-enter Password</h3>
						<div class="form-group">
						<input class="form-control" type="password" name="csetting_pass" id="csetting_pass" placeholder="Confirm your password" required>
                        <span toggle="#password2" class="fas fa-eye field-icon toggle-password"></span>
						</div>
						<h3>Submit new password</h3>
						<div class="form-group">
							<input type="submit" class="form-control button" name="settingspword" value="Submit" id="settingspword">
						</div>
			</div>
			
		</main>
	</section>
	<!-- -------------------------------------------------------------- -->
	<script src="scripts/dashboardadmin.js"></script>
	
	<script async defer>
      applyStoredTheme();
   </script>
<!------------------------------------------------------------>
	
</body>
</html>

