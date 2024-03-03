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
		  $statusMsg = 'Employee has been Imported Successfully.';
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


// Fetch all data from the database
$sql_all_users = "SELECT * FROM employee_tbl";
$result_all_users = mysqli_query($con, $sql_all_users);

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
			<li class="active">
				<a href="#">
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
					<input class="emp-search-bar" type="search" id="emp-sch" name="search_employee" placeholder="Search Employee">
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
					<h1>Employee</h1>
				</div>
			</div>
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
			<button id="openModalBtn add-submit">+ Add Employee</button>
			<button id="openModalBtn edit-employee"><i class="bi bi-pencil-square"></i> Edit Employee</button>
			<button id="openModalBtn import_employee"><i class="bi bi-box-arrow-in-down"></i> Import Employee</button>
			<div id="myModal3" class="import-form">
				<div class="import-content">
					<form action="backend/import_data.php" method="post" enctype="multipart/form-data">
						<input class="form-control" type="file" name="file"/>
						<input class="form-control button" id="emp_import_button" type="submit" name="emp_import_submit" value="Import">
					</form>
				</div>
			</div>

			<!--------------------->
				</div>
			</div>

			
            <div class="table-data">
				<div class="order">
					<!-- Header before table -->
					<div class="head">
						<h3>Employee</h3>
						<button class="btnclear" id="clear-search">Clear</button>
						<div class="filter">
							<span>Filter by: &nbsp;</span>
							<select name="filter-cat" id="filter-cat">
								<option value="" selected="">None</option>
								<option value="employee_tbl.Employee_ID">Employee ID</option>
								<option value="employee_tbl.Fname">First Name</option>
								<option value="employee_tbl.Lname">Last Name</option>
								<option value="employee_tbl.Knox_ID">Knox ID</option>
								<option value="department_tbl.Department">Department</option>
								<option value="cost_center_tbl.Cost_Center">Cost Center</option>
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
				<div id="myModal" class="modal">
					<div class="modal-content">
						<span class="close" id="closeModalBtn">&times;</span>
						<form action="backend/add_employee.php" method="POST" autocomplete="off">
							<h3>Add Employee</h3>
							<div class="form-group">
								<input type="text" placeholder="Employee ID" class="form-control" id="employee_id" name="employee_id" maxlength="15" required="required">
							</div>
							<div class="form-group">
								<input type="text" placeholder="First Name" class="form-control" id="employee_fname" name="employee_fname" maxlength="30" required="required">
							</div>
							<div class="form-group">
								<input type="text" placeholder="Last Name" class="form-control" id="employee_lname" name="employee_lname" maxlength="30" required="required">
							</div>
							<div class="form-group">
								<input type="text" placeholder="Knox ID" class="form-control" id="knox_id" name="knox_id" maxlength="15" required="required">
							</div>
							<div class="form-group">
								<input type="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}" placeholder="Samsung Email" class="form-control" id="email" name="email" maxlength="100" required="required">
							</div>
							<h3>Department</h3>
							<div class="form-group">
								<select class="form-control" id="dept_add" name="dept" required>
									<option value="" selected disabled>Select Department</option>
									<?php
										$q_getDepartment = "SELECT Department_ID, Department
														FROM department_tbl;";

										$row_units = mysqli_query($con, $q_getDepartment);

										if ($row_units) {
											while ($row = mysqli_fetch_assoc($row_units)) {
											$get_dept_id = $row['Department_ID'];
											$getDepartment = $row['Department'];
							
											echo "<option value=\"$get_dept_id\">$getDepartment</option><br>";
											}
										} else {
											echo "Error executing the query: " . mysqli_error($conn);
										}
									?>
								</select>
							</div>
							<h3>Cost Center</h3>
							<div class="form-group">
								<select class="form-control" id="ccenter_add" name="cost_center" required>
								</select>
							</div>
							<div class="form-group">
							<input type="submit" id="add_submit" class="form-control button" value="Add" name="add_submit">
							</div>
						</form>
					</div>
				</div>
				<div id="myModal2" class="modal">
					<div class="modal-content">
						<span class="close" id="closeModalBtn">&times;</span>
						<form action="backend/edit_employee.php" class="edit_rowform" method="POST">
							<h3>Edit Employee Information</h3><br>
							<input type="hidden" id="sys_id" name="sys_id" required>
							<h3>Employee ID</h3>
							<div class="form-group">
								<input type="text" class="form-control" id="editEmployee_ID" name="employee_ID" placeholder="Employee ID" maxlength="15" required>
							</div>
							<h3>First Name</h3>
							<div class="form-group">
								<input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" maxlength="30" required>
							</div>
							<h3>Last Name</h3>
							<div class="form-group">
								<input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" maxlength="30" required>
							</div>
							<h3>Knox ID</h3>
							<div class="flex-group">
								<input type="text" class="form-control" id="knox_ID" name="knox_ID" placeholder="Knox ID" maxlength="15" required>
							</div>
							<h3>Department</h3>
							<div class="form-group">
								<select class="form-control" id="dept_edit" name="dept" required>
									<option value="" selected disabled>Select Department</option>
									<?php
										$q_editDepartment = "SELECT Department_ID, Department
													FROM department_tbl;";

										$row_units = mysqli_query($con, $q_editDepartment);

										if ($row_units) {
										while ($row = mysqli_fetch_assoc($row_units)) {
											$editdept_id = $row['Department_ID'];
											$editDepartment = $row['Department'];
							
											echo "<option value=\"$editdept_id\">$editDepartment</option><br>";
										}
										} else {
										echo "Error executing the query: " . mysqli_error($conn);
										}
									?>
								</select>
							</div>
							<h3>Cost Center</h3>
							<div class="form-group">
								<select id="ccenter_edit" class="form-control" name="cost_center" required>

								</select>	
							</div>
							<div class="form-group">
									<input type="submit" id="edit_submit" class="form-control" value="Edit" name="edit_submit">
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="console">
				<p id="console-header">Console:</p><br>
				<div>
				<?php
					if(isset($_SESSION['errlink'])){
						$msg = $_SESSION['errlink'];

						echo '<p>'. $msg. '</p>';

						unset($_SESSION['errlink']);
					}
				?>
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