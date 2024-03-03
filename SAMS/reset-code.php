<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   
     <!-- CSS -->
	<link rel="stylesheet" href="login-css/style.css?<?php echo time();?>">
    
</head>
<body>
<div class="container">
            <div class="login-image">
                <img src="logo/login-logo.png">
            </div>
            <div class="form login-form">
                <form action="reset-code.php" method="POST" autocomplete="off">
                    
                    <!--Arrow back-->
                    <a class="arrow-back" href="forgot-password.php">
                        <i class="fas fa-arrow-left"></i>
                    </a>

                    <img src="logo/logo1.png" alt="Logo" class="logo" >
                    <h3 class="text-center">Verification</h3>
                    <p class="text-center">Please enter your OTP code <br>
                    sent to your email address
                    </p>
                    <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                    <div class="circle">
                        <i class="fas fa-check-circle"></i>
                    </div>
                        <input class="form-control" type="number" name="otp" placeholder="Enter code" required>
                    </div>
                    <div class="form-group">
                        <input class="button" type="submit" name="check-reset-otp" value="Verify">
                    </div>
                </form>
                
                 <!-- Footer -->
                 <footer class="footer">
                        <ul>
                            <li><a href="#">Term and Conditions</a></li>
                            <li><a href="#">Samsung account Privacy</a></li>
                            <li><a href="#">Notice</a></li>
                            <li><a href="#">Contact us</a></li>
                        </ul>
                        <p>Copyright © 2023-2024. For internal use only.</p>
                    </footer>
            </div>
        </div>
    </div>
    
</body>
</html>