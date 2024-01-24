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
CloseCon($con); // Close the database connection
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons for icons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	
	<!-- CSS -->
	<link rel="stylesheet" href="admin-css/department.css">

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
			<li class="active">
				<a href="#">
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
					<input type="search" placeholder="Search">
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
					<h1>Logs</h1>
				</div>
			</div>
			
            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Logs</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table class=collapsed>
                <thead class="tbl-header">
							<tr>
								<th>ID</th>
								<th>Asset No.</th>
								<th>Category</th>
								<th>Description</th>
								<th>Serial No.</th>
								<th>Employee ID</th>
								<th>Assignee / Owner</th>
								<th>Knox ID</th>
								<th>Cost Center</th>
								<th>Status</th>
								<th>Issued Date</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<p>1</p>
								</td>
								<td>example</td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
							</tr>
							<tr>
								<td>
									<p>2</p>
								</td>
								<td>example</td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
							</tr>
							<tr>
								<td>
									<p>3</p>
								</td>
								<td>example</td>
								<td><span >example</span></td>	
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
							</tr>
							<tr>
								<td>
									<p>4</p>
								</td>
								<td>example</td>
								<td><span >example</span></td>	
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
							</tr>
							<tr>
								<td>
									<p>5</p>
								</td>
								<td>example</td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
								<td><span >example</span></td>
							</tr>
						</tbody>
					</table>

					
				</div>
				
		</main>
	</section>
	<!-- -------------------------------------------------------------- -->


	<script src="scripts/dashboardadmin.js"></script>
</body>
</html>