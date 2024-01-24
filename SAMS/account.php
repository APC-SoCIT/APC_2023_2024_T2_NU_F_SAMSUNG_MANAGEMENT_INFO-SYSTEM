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
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons for icons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	
	<!-- CSS -->
	<link rel="stylesheet" href="admin-css/department.css">
	<link rel="stylesheet" href="admin-css/modal.css">
	<link rel="stylesheet" href="admin-css/modal1.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

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
			<li  class="active">
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
					<h1>User Account</h1>

					<!--MODAL-->
					<!-- <button id="openModalBtn">+ User Account</button> -->

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
										<option value="user">User</option>
										<option value="admin">Admin</option>
									</select>
								</div>
								<div class="form-group">
									<input class="form-control button" type="submit" name="signup" value="Submit"  id="signupForm">
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
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table class="collapsed">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Knox ID</th>
								<th>Password</th>
								<th>Status</th>
								<th>Role</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// Fetch all data from the database
								$sql_all_users = "SELECT * FROM employee_tbl ORDER BY Stat DESC";
								$result_all_users = mysqli_query($con, $sql_all_users);

								// Loop through each row of the result set
								while ($row = mysqli_fetch_assoc($result_all_users)) {
							?>
							<tr>
								<td><?php echo $row['Employee_ID']; ?></td>
                                <td><?php echo $row['Fname'] .' '. $row['Lname']; ?></td>
                                <td><?php echo $row['Email']; ?></td>
                                <td><?php echo $row['Knox_ID']; ?></td>
								<td><?php echo $row['Pword'] ? '******' : 'Not Set'; // Display a placeholder for password ?></td>
                                <td><?php echo $row['Stat'] ?: 'Unverified'; ?></td>
                                <td><?php echo $row['Roles'] ?: 'No Account'; ?></td>
								
								<td>
									<!-- Edit Icon -->
									<a href="#" class="edit-icon">
										<div class="icon-circle">
											<i class='bx bxs-edit'></i>
										</div>
									</a>

									<!-- Delete Icon -->
									<a href="#" class="delete-icon">
										<div class="icon-circle">
											<i class='bx bxs-trash'></i>
										</div>
									</a>

									<!-- Add Icon -->
									<a href="#" id="openModalBtn" class="add-icon">
										<div class="icon-circle">
											<i class='bi bi-plus'></i>
										</div>
									</a>
								</td>
							</tr>

							<?php
                            }
                            ?>
						</tbody>
					</table>
				</div>
			</div>
		</main>
	</section>
	<!-- -------------------------------------------------------------- -->
	<script src="scripts/dashboardadmin.js"></script>
	<script src="scripts/modal.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

	<script>
$(document).ready(function() {
    // Attach a click event handler to all elements with class "delete-icon"
    $(".delete-icon").click(function(e) {
        e.preventDefault(); // Prevent the default link behavior

        // Get the parent row's ID (assuming it's in the same row as the delete icon)
        var rowId = $(this).closest("tr").find("td:first-child").text();

        // Send an AJAX request to delete.php with the row ID
        $.ajax({
            type: "POST",
            url: "delete.php", // Replace with your server-side script
            data: { id: rowId }, // Send the row ID to the server
            success: function(response) {
                // Handle the success response (if needed)
                console.log(response);
            },
            error: function(error) {
                // Handle the error (if needed)
                console.error(error);
            }
        });
    });
});
</script>

</body>
</html>