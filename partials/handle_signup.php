<!--
* @file handle_signup.php
* @author KUSHAGRA JAISWAL 
* @date 2022-06-26
* @copyright Copyright (c) 2022
-->

<?php
$showError = "false";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include '_dbconnect.php';
    $user_name = $_POST['signupName'];
    $user_email = $_POST['signupEmail'];
    $user_password = $_POST['signupPassword'];
    $user_cpassword = $_POST['signupcPassword'];

    // Check if the email is already in use.
    $existSql = "SELECT * FROM `users` WHERE `user_email` = '$user_email'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        $showError = "existEmail";
    } else {
        if ($user_password == $user_cpassword) {
            $hash = password_hash($user_password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_name`, `user_email`, `user_pass`, `timestamp`) VALUES ('$user_name', '$user_email', '$hash', current_timestamp()) ";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
                header("Location: /learnPHP/projects/forum/index.php?signupsuccess=true");
                exit();
            }
        } else {
            $showError = "badPassword";
        }
    }
    header("Location: /learnPHP/projects/forum/index.php?signupfail=$showError");
}
?>