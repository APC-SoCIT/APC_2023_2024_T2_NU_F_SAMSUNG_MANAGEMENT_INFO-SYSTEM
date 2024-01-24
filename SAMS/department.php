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
	<script src="scripts/department.js"></script>
	<script src="scripts/modal.js"></script>

	<!-- Flat Pickr -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

	<!-- Title -->
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
			<li class="active">
				<a href="#">
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
			<a href="#" class="nav-link">Categories</a>
			
			<!--Search-->
			<form action="#">
				<div class="form-input">
				<input class="dept-search" type="search" id="dept-sch" name="search_department" placeholder="Search Department" >
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
					<h1>Department</h1>
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
				?>
			</div>

			<button id="openModalBtn add-submit">+ Add</button>
			<button id="openModalBtn switch-table">Cost Center</button>
			
            <div class="table-data">
				<div class="order">
					<!-- Header Before Table -->
					<div class="head">
						<h3 id="modal-header2">Department</h3>
						<button class="btnclear" id="clear-search">Clear</button>
						<i class='bx bx-filter' ></i>
					</div>

					<!-- Loaded Table -->
					<div id="searchresult">
					</div>
				</div>
			</div>
			<!-- MODALS -->
			<div id="myModal" class="modal">
				<div class="modal-content">
					<span class="close" id="closeModalBtn">&times;</span>
					<div class="form-group">
						<button id="add-department">+ Department</button>
					</div>
					<div class="form-group">
						<button id="add-ccenter">+ Add Cost Center</button>
					</div>
				</div>
			</div>	
			<div id="myModal2" class="modal">
				<div class="modal-content">
					<span class="close" id="closeModalBtn">&times;</span>
					<form action="backend/add_department.php" method="POST" autocomplete="off">
						<h3>Add Department</h3>
						<div class="form-group">
							<input type="text" id="dept_name" class="form-control" name="dept" placeholder="Department Name" required>
						</div>
						<h3>Assign Cost Center</h3>
						<div class="form-group">
							<select class="form-control" id="ccenter_add" name="cost_center">
								<option value="" selected>None</option>
								<?php

									$q_getCcenter = "SELECT Cost_Center_ID,
															Cost_Center
													FROM cost_center_tbl";

									$row_ccenter = mysqli_query($con, $q_getCcenter);
									if(mysqli_num_rows($row_ccenter) > 0){

										while($row = mysqli_fetch_assoc($row_ccenter)){

											$ccenter_id = $row['Cost_Center_ID'];
											$ccenter = $row['Cost_Center'];

											?>

											<option value="<?php echo $ccenter_id?>"><?php echo $ccenter?></option>

											<?php

										}

									}
									
								?>

							</select>
						</div>
						<div class="form-group">
							<input type="submit" class="form-control button" name="signup" value="Submit" id="signupForm">
						</div>
					</form>
				</div>
			</div>
			<div id="myModal3" class="modal">
				<div class="modal-content">
					<span class="close" id="closeModalBtn">&times;</span>
					<form action="backend/edit_dept.php" class="edit_rowform" method="POST">
						<h3>Edit Department</h3><br>
						<div class="form-group">
							<input type="hidden" id="dept_id" name="dept_id" required>
						</div>
						<h3>Department</h3>
						<div class="form-group">
							<input type="text" class="form-control" id="editDepartment" name="dept" placeholder="Department Name" required>
						</div>
						<h3>Assign Cost Center</h3>
						<div class="form-group">
							<select class="form-control" id="ccenter_add" name="cost_center">
								<option value="" selected>None</option>
								<?php

								$q_getCcenter = "SELECT Cost_Center_ID,
														Cost_Center
													FROM cost_center_tbl";

								$row_ccenter = mysqli_query($con, $q_getCcenter);

								if(mysqli_num_rows($row_ccenter) > 0){

									while($row = mysqli_fetch_assoc($row_ccenter)){

									$ccenter_id = $row['Cost_Center_ID'];
									$ccenter = $row['Cost_Center'];

									?>

										<option value="<?php echo $ccenter_id?>"><?php echo $ccenter?></option>

									<?php

									}

								}
								?>
							</select>
						</div>
						<h3>Remove Cost Center</h3>
						<div class="form-group">
							<select class="form-control" name="rm_cost_center" id="rm_ccenter">
							
							</select>
						</div>
						<div class="form-group">
							<input type="submit" class="form-control button" id="edit_submit" value="Edit" name="edit_submit">
						</div>
					</form>
				</div>
			</div>
			<div id="myModal4" class="modal">
				<div class="modal-content">
					<span class="close" id="closeModalBtn">&times;</span>
					<form action="backend/delete_deptccenter.php" class="edit_rowform" method="POST">
						<input type="hidden" id="del_dept_id" name="dept_id" required>
						<h3>Delete Department?</h3>
						<p class="caution">Click confirm to delete <span id="span_dept"></span> Department! This action cannot be undone.</p>
						<div class="form-group">
							<input type="submit" class="form-control button" id="edit_submit" value="Confirm" name="edit_submit">
						</div>
					</form>
				</div>
			</div>
			<div id="myModal5" class="modal">
				<div class="modal-content">
					<span class="close" id="closeModalBtn">&times;</span>
					<form action="backend/add_ccenter.php" class="add-deptform">
						<h3>Add Cost Center</h3><br>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Cost Center" id="ccenter" name="ccenter" required="required">
						</div>
						<div class="form-group">
							<input type="submit" class="form-control button" id="add_submit" value="Add" name="add_submit">
						</div>
					</form>
				</div>
			</div>
			<div id="myModal6" class="modal">
				<div class="modal-content">
					<span class="close" id="closeModalBtn">&times;</span>
					<form action="backend/edit_ccenter.php" class="edit_rowform" method="POST">
						<h3>Edit Cost Center</h3><br>
						<input type="hidden" id="ccenter_id" name="ccenter_id" required>
						<div class="form-group">
							<input type="text" class="form-control" id="editCcenter" name="cost_center" placeholder="Cost Center" required>
						</div>
						<h3>Cost Center</h3>
						<div class="form-group">
							<input type="submit" class="form-control button" id="edit_submit" value="Edit" name="edit_submit">
						</div>
					</form>
				</div>
			</div>
			<div id="myModal7" class="modal">
				<div class="modal-content">
					<span class="close" id="closeModalBtn">&times;</span>
					<form action="backend/delete_deptccenter.php" class="edit_rowform" method="POST">
						<input type="hidden" id="del_ccenter_id" name="ccenter_id" required>
						<input type="hidden" id="del_ccenter" name="ccenter" required>
						<h3>Delete Cost Center?</h3>
						<p class="caution">Click confirm to delete <span id="span_ccenter"></span>! This action cannot be undone.</p>
						<div class="form-group">
							<input type="submit" class="form-control button" id="edit_submit" value="Confirm" name="edit_submit">
						</div>
					</form>
				</div>
			</div>
		</main>
	</section>

	
	<?php 
		// Close the database connection
		CloseCon($con);
	?>
	<!-- -------------------------------------------------------------- -->
	<script src="scripts/dashboardadmin.js"></script>
</body>
</html>