<?php 
session_start();

// Import PHPMailer classes
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

// Include libary and db
    require_once "database/sams_db.php";
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';


$email = "";
$name = "";
$errors = array();

    //user account submit button
    if(isset($_POST['signup'])){
        $con = OpenCon(); // Get the database connection
        $employee_id = mysqli_real_escape_string($con, $_POST['emp_id']);

        // Check if account is already made

        $q_ifAccExist = "SELECT System_ID FROM employee_tbl WHERE Employee_ID = $employee_id AND Stat = 'verified'";
        $exist_rst = mysqli_query($con, $q_ifAccExist);

        if(mysqli_num_rows($exist_rst) > 0){

            header('Location: account.php?error-msg=User already has an Account!');

        }else{

            $password = mysqli_real_escape_string($con, $_POST['password']);
            $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
            
            if($password !== $cpassword){
                $errors['password'] = "Confirm password not matched!";
            }
            
            if(count($errors) === 0){
                $encpass = password_hash($password, PASSWORD_BCRYPT);
                $status = "verified";
                $role = mysqli_real_escape_string($con, $_POST['role']);
        
                $create_acc = $con->prepare("UPDATE employee_tbl
                                            SET Pword = ?,
                                                Stat = ?,
                                                Roles = ?
                                            WHERE Employee_ID = ?");
        
                $create_acc->bind_param("ssss", $encpass, $status, $role, $employee_id);
                if($create_acc->execute()){
        
                    // Confirm that Account Creation is Successful
                    header('Location: account.php?msg=User Account Creation Successful!');

        
                }else{
        
                    // Confirm that there is an error in Account Creation
                    echo "Error account creation";
        
                }
            }
        }
    }

    // user account deletion
    if(isset($_POST['remove-acc'])){

        $con = OpenCon(); // Get the database connection
        $employee_id = mysqli_real_escape_string($con, $_POST['emp_id']);

        // Check if account is already made

        $q_ifAccExist = "SELECT System_ID FROM employee_tbl WHERE Employee_ID = $employee_id AND Stat = 'verified'";
        $exist_rst = mysqli_query($con, $q_ifAccExist);

        if(mysqli_num_rows($exist_rst) > 0){

            // UPDATE statement to unset account
            $q_removeAcc = $con->prepare("UPDATE employee_tbl
                                          SET Pword = NULL,
                                              Stat = NULL,
                                              Roles = ''
                                          WHERE Employee_ID = ?");

            $q_removeAcc->bind_param("s", $employee_id);
            header('Location: account.php?msg=User Account Deletion Successful!');

            // Execute statement
            $q_removeAcc->execute();

        }else{

            header('Location: account.php?error-msg=User does not have an Account!');

        }
    }

    // user account update
    if(isset($_POST['update-acc'])){

        $con = OpenCon(); // Get the database connection
        $employee_id = mysqli_real_escape_string($con, $_POST['emp_id']);

        // Check if account is already made

        $q_ifAccExist = "SELECT System_ID FROM employee_tbl WHERE Employee_ID = $employee_id AND Stat = 'verified'";
        $exist_rst = mysqli_query($con, $q_ifAccExist);

        if(mysqli_num_rows($exist_rst) > 0){

            // UPDATE statement to unset account
            $q_updateAcc = $con->prepare("UPDATE employee_tbl
                                            SET Roles = ?
                                            WHERE Employee_ID = ?");

            // Set Role
            $role = mysqli_real_escape_string($con, $_POST['role']);
            
            $q_updateAcc->bind_param("ss", $role, $employee_id);
            header('Location: account.php?msg=User Account role Successfully updated!');

            // Execute statement
            $q_updateAcc->execute();

        }else{

            header('Location: account.php?error-msg=User does not have an Account!');

        }
    }

    //if user click verification code submit button
    if(isset($_POST['check'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM employee_tbl WHERE Code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $fetch_code = $fetch_data['Code'];
            $email = $fetch_data['Email'];
            $code = 0;
            $status = 'verified';
            $update_otp = "UPDATE employee_tbl SET Code = $code, Stat = '$status' WHERE Code = $fetch_code";
            $update_res = mysqli_query($con, $update_otp);
            if($update_res){
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                header('location: home.php');
                exit();
            }else{
                $errors['otp-error'] = "Failed while updating code!";
            }
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }

    // If user clicks login button
    if(isset($_POST['login'])){
        $con = OpenCon(); // Get the database connection

        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $keeplogin = mysqli_real_escape_string($con, $_POST['keepLoggedIn']);
        
        $check_email = "SELECT * FROM employee_tbl WHERE Email = '$email'";
        $res = mysqli_query($con, $check_email);

        if(mysqli_num_rows($res) > 0){
            $fetch = mysqli_fetch_assoc($res);
            $fetch_pass = $fetch['Pword'];

            if(password_verify($password, $fetch_pass)){
                $_SESSION['email'] = $email;
                $status = $fetch['Stat'];

                if($status == 'verified'){
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
                    $_SESSION['keepLoggedIn'] = $keeplogin;

                    // Fetch the user role from the database
                    $userRole = $fetch['Roles'];

                    // Redirect based on user role
                    if ($userRole == 'Admin') {
                        header('location: home.php');
                    } elseif ($userRole == 'User') {
                        header('location: user.php');
                    } else {
                        // Handle unknown role or other cases
                        echo "Unknown user role";
                    }
                    exit();
                } else {
                    $info = "It's look like you haven't still verify your email - $email";
                    $_SESSION['info'] = $info;
                    header('location: user-otp.php');
                }
            } else {
                $errors['email'] = "Incorrect email or password!";
            }
        } else {
            $errors['email'] = "It's look like you're not yet a member!";
        }

        CloseCon($con); // Close the database connection
    }

    //if user click continue button in forgot password form
    if(isset($_POST['check-email'])){
        $con = OpenCon(); // Get the database connection

        $email = mysqli_real_escape_string($con, $_POST['email']);
        $check_email = "SELECT * FROM employee_tbl WHERE Email='$email' AND Stat = 'verified'";
        $run_sql = mysqli_query($con, $check_email);
        if(mysqli_num_rows($run_sql) > 0){

            // Code for Emailing OTP

            $code = rand(999999, 111111);
            $insert_code = "UPDATE employee_tbl SET Code = $code WHERE Email = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if($run_query){

                // Set mail object from PHPMailer
                $mail = new PHPMailer;

                // SMTP Server Settings
                
                $mail->isSMTP();
                $mail->SMTPDebug = 2; //Debugging error message
                $mail->Host = 'smtp.gmail.com'; //SMTP Host
                $mail->SMTPAuth = true; // Enable Authentication

                $cfg_path = __DIR__ . '\PHPMailer\config.ini'; // Path find config.ini
                $cfg = parse_ini_file($cfg_path); // Parse the config.ini file

                $mail->Username = $cfg['username']; // Set Username
                $mail->Password = $cfg['password']; // Set Password
                $mail->SMTPSecure = 'tls'; // Secure transfer enables REQUIRED for Gmail
                $mail->Port = 587; // Default port for tls

                // Sender Info
                $mail->setFrom('test1@gmail.com', 'SAMS');

                // Recipient    
                $mail->addAddress($email);

                // set Email to HTML Format
                $mail->Subject = "Password Reset Code";

                // Email Content
                $bodyContent = "Your password reset code is $code";
                $mail->Body = $bodyContent;
                if($mail->send()){
                    $info = "We've sent a password reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code! Error:". $mail->ErrorInfo;
                }
            }else{
                $errors['db-error'] = "Something went wrong!";
            }
        }else{
            $errors['email'] = "This email address does not exist!";
        }
        CloseCon($con); // Close the database connection
    }

    //if user click check reset otp button
    if(isset($_POST['check-reset-otp'])){
        $con = OpenCon(); // Get the database connection

        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM employee_tbl WHERE Code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['Email'];
            $_SESSION['email'] = $email;
            $info = "Please create a new password that you don't use on any other site.";
            $_SESSION['info'] = $info;
            header('location: new-password.php');
            exit();
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
        CloseCon($con); // Close the database connection
    }

    //if user click change password button
    if(isset($_POST['change-password'])){
        $con = OpenCon(); // Get the database connection

        $_SESSION['info'] = "";
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
        if($password !== $cpassword){
            $errors['password'] = "Confirm password not matched!";
        }else{
            $code = 0;
            $email = $_SESSION['email']; //getting this email using session
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            $update_pass = "UPDATE employee_tbl SET Code = $code, Pword = '$encpass' WHERE Email = '$email'";
            $run_query = mysqli_query($con, $update_pass);
            if($run_query){
                $info = "Your password changed. Now you can login with your new password.";
                $_SESSION['info'] = $info;
                header('Location: password-changed.php');
            }else{
                $errors['db-error'] = "Failed to change your password!";
            }
        }
        CloseCon($con); // Close the database connection
    }
    
   //if login now button click
    if(isset($_POST['login-now'])){
        header('Location: login-user.php');
    }

    //For settings change password
    if(isset($_POST['settingspword'])){
        $con = OpenCon(); // Get the database connection

        $setting_pass = mysqli_real_escape_string($con,$_POST['setting_pass']);
        $csetting_pass = mysqli_real_escape_string($con,$_POST['csetting_pass']);
        
            if($setting_pass == $csetting_pass){
                $email = $_SESSION['email']; //getting this email using session
                $encpass = password_hash($setting_pass, PASSWORD_BCRYPT);
                $update_pass = "UPDATE employee_tbl SET Pword = '$encpass' WHERE Email = '$email'";
                $run_query = mysqli_query($con, $update_pass);
                if($run_query){
                    $_POST['setpwordsuccess'] = "Password Changed!";
                }else{
                    $errors['db-error'] = "Failed to change your password!";
                }
            }else{
                $_POST['setpwordfail'] = "Confirm password not matched!";
            }
        CloseCon($con); // Close the database connection
    }
?>