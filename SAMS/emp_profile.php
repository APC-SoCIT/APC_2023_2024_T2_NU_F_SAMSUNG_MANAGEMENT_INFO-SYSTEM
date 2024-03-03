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

	<!-- JavaScripts -->
	<script src="scripts/employee.js"></script>
	<script src="scripts/modal.js"></script>
	<script src="scripts/dropdown.js"></script>

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
			<li class="#">
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
					<input type="text" id="emp-sch" class="emp-search-bar" name="search_employee" placeholder="Search Employee">
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
            <?php

                $employee_id = $_GET['emp_id'];

                $q_getProfile = "SELECT DISTINCT employee_tbl.System_ID as 'System ID',
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
                                WHERE Employee_ID = $employee_id";

                $row_profile = mysqli_query($con, $q_getProfile);

                if(mysqli_num_rows($row_profile) > 0){
                    while($row = mysqli_fetch_assoc($row_profile)){
                        $emp_id = $row['Employee ID'];
                        $fname = $row['Fname'];
                        $lname = $row['Lname'];
                        $knox_id = $row['Knox ID'];
                        $dept = $row['Department'];
                        $dept_regex = str_replace('_', ' ', $dept);
                        $ccenter = $row['Cost Center'];
                    }
                }

            ?>


		<!--Arrow back-->
		<div class="arrow">
			<a href="employee.php" >
				<i class='bx bx-arrow-back'></i>
			</a>
		</div>
 


		<!-- Account Info -->
        <div class="profile-container">
            <div id="pp-col">
                <h3>ID : <?php echo $emp_id;?></h3>
                <h3>Name : <?php echo $fname . " " . $lname;?></h3>
            </div>
            <div id="pp-col">
                <h3>Department : <?php echo $dept_regex ?: 'Not Assigned';?></h3>
                <h3>Cost Center : <?php echo $ccenter ?: 'Not Assigned';?></h3>
            </div>
            <div id="pp-col">
              <h3>Knox ID: <?php echo $knox_id;?></h3>
            </div>
        </div>
		<!----------------------------------------------------------- -->

    <!-- Table Display -->
	<div class="table-data">
		<div class="order">
		<div class="head">
			<h3>List of Assigned Assets</h3>
		</div>

            <?php
            
              $q_getAssets = "SELECT it_assets_tbl.Asset_ID,
                                     it_assets_tbl.Asset_No, 
                                     it_assets_tbl.Category, 
                                     it_assets_tbl.Descr, 
                                     it_assets_tbl.Serial_No, 
                                     assigned_assets_tbl.Issued_Date, 
                                     assigned_assets_tbl.Stat
                              FROM assigned_assets_tbl
                              INNER JOIN it_assets_tbl ON assigned_assets_tbl.Asset_ID = it_assets_tbl.Asset_ID
                              INNER JOIN employee_tbl ON assigned_assets_tbl.System_ID = employee_tbl.System_ID
                              WHERE employee_tbl.Employee_ID = $employee_id";

              $row_assets = mysqli_query($con, $q_getAssets);

              if(mysqli_num_rows($row_assets) > 0){?>


                <table class=collapsed>
                    <thead>
                        <th></th>
                        <th>Asset ID</th>
                        <th>Asset Number</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Serial Number</th>
                        <th>Issued Date</th>
                        <th>Status</th>
                    </thead>
                    
                    <?php
                        while($row = mysqli_fetch_assoc($row_assets)){
                            $asset_id = $row['Asset_ID'];
                            $asset_no = $row['Asset_No'];
                            $category = $row['Category'];
                            $descr = $row['Descr'];
                            $serial_no = $row['Serial_No'];
                            $acq_date = $row['Issued_Date'];
                            $stat = $row['Stat'];
    
                            ?>
    
                            <tr id="ownedtr">
                                <td></td>
                                <td><?php echo $asset_id ?: 'N/A'; ?></td>
                                <td><?php echo $asset_no ?: 'N/A'; ?></td>
                                <td><?php echo $category ?: 'N/A'; ?></td>
                                <td><?php echo $descr ?: 'N/A'; ?></td>
                                <td><?php echo $serial_no ?: 'N/A'; ?></td>
                                <td><?php echo $acq_date ?: 'N/A'; ?></td>
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
		</main>
	</section>
	<!-- -------------------------------------------------------------- -->


	<script src="scripts/dashboardadmin.js"></script>
	<script async defer>
		applyStoredTheme();
	</script>

</body>
</html>