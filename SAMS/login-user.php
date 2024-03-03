<?php require_once "controllerUserData.php"; 

    // Regenerate session ID to prevent session fixation attacks
    session_regenerate_id(true);

    if(isset($_SESSION['keepLoggedIn'])){
        if($_SESSION['keepLoggedIn'] == "T"){
            echo "session keeped";
            // Set session variables or other logic here
        }
    }else{
            // Normal session handling, possibly destroying the session
            session_unset();
            session_destroy();
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- CSS -->
	<link rel="stylesheet" href="login-css/style.css?<?php echo time();?>">
    <!-- Javascripts -->
    <script src="scripts/keeplogin.js"></script>
</head>

<body>
    <div class="container">
            <div class="login-image">
                <img src="logo/login-logo.png">
            </div>
            <div class="form login-form">
                <form action="login-user.php" method="POST" autocomplete="">
                    <img src="logo/logo1.png" alt="Logo" class="logo" >
                    <h4 class="text-center"><b>Welcome</b></h4>
                    <p class="text-center">Login to your account</p>
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
                        <i class="fas fa-envelope"></i>
                    </div>
                        <input class="form-control" type="email" name="email" placeholder="Email Address " required value="<?php echo $email ?>">
                    </div>
                    
                    <div class="form-group">
                        <div class="circle">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                        <span toggle="#password" class="fas fa-eye field-icon toggle-password"></span>
                    </div>



                    <div class="link forget-pass text-left">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="forgot-password.php">Forgot password?</a>
                            <div class="form-check">
                                <input class="form-check-input ml-2" type="checkbox" id="keepLoggedIn" name="keepLoggedIn" value="T">
                                <label class="form-check-label" for="keepLoggedIn">Keep me logged in</label>
                            </div>
                        </div>
                    </div>



                    <div class="form-group">
                        <input class="button" type="submit" name="login" value="LOGIN">
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

   

       
<!--EYE ICON JAVASCRIPT-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.toggle-password').on('click', function () {
                $(this).toggleClass('fa-eye fa-eye-slash');
                let input = $($(this).attr('toggle'));
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                } else {
                    input.attr('type', 'password');
                }
            });
        });
    </script>
<!------------------------------------------------------------>


    
</body>
</html>