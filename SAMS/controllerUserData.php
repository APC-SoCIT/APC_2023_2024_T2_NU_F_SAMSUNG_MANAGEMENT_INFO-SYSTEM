<?php 
session_start();
require_once "database/sams_db.php";
$email = "";
$name = "";
$errors = array();

//user account submit button
if(isset($_POST['signup'])){
    $con = OpenCon(); // Get the database connection

    $employee_id = mysqli_real_escape_string($con, $_POST['emp_id']);
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

        }else{

            // Confirm that there is an error in Account Creation

        }
        
    }

    // user account submit button
    if (isset($_POST['signup'])) {
        // ... your existing code for user account creation ...

    } elseif (isset($_POST['delete_user'])) {
        // Delete user logic
        $user_id_to_delete = mysqli_real_escape_string($con, $_POST['user_id_to_delete']);

        $delete_query = "DELETE FROM usertable WHERE id = '$user_id_to_delete'";
        $delete_result = mysqli_query($con, $delete_query);

        if ($delete_result) {
            // Deletion successful
            echo 'User deleted successfully.';
        } else {
            // Deletion failed
            echo 'Error deleting user.';
        }
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
                    header('location: home.php');
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
        $check_email = "SELECT * FROM employee_tbl WHERE Email='$email'";
        $run_sql = mysqli_query($con, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(999999, 111111);
            $insert_code = "UPDATE employee_tbl SET Code = $code WHERE Email = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if($run_query){
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From: test1@gmail.com";
                if(mail($email, $subject, $message, $sender)){
                    $info = "We've sent a password reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
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
?>