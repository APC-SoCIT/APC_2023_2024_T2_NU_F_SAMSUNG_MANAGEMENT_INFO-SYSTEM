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
    <title>Create a New Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">   
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="new-password.php" method="POST" autocomplete="off">
                    <img src="logo/logo1.png" alt="Logo" class="logo" >
                    <h3 class="text-center">New Credential</h3>
                    <p class="text-center">Your identity has been verified <br>
                    set your new password</p>

                    <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center">
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
                        <i class="fas fa-lock"></i>
                    </div>
                        <input class="form-control" type="password" name="password" id="password1" placeholder="Create new password" required>
                        <span toggle="#password1" class="fas fa-eye field-icon toggle-password"></span>

                    </div>
                    <div class="form-group">
                    <div class="circle">
                        <i class="fas fa-lock"></i>
                    </div>
                        <input class="form-control" type="password" name="cpassword" id="password2" placeholder="Confirm your password" required>
                        <span toggle="#password2" class="fas fa-eye field-icon toggle-password"></span>
                    </div>
                    <div class="form-group">
                        <input class="button" type="submit" name="change-password" value="Change">
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
            let inputField = $($(this).attr('toggle'));
            let fieldType = inputField.attr('type');
            
            // Toggle password visibility
            if (fieldType === 'password') {
                inputField.attr('type', 'text');
            } else {
                inputField.attr('type', 'password');
            }
        });
    });
</script>
<!------------------------------------------------------------>

</body>
</html>