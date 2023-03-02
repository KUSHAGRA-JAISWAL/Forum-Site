<!--
* @file handle_login.php
* @author KUSHAGRA JAISWAL 
* @date 2022-06-26
* @copyright Copyright (c) 2022
-->

<?php

$showError = "false";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include '_dbconnect.php';
    $login_email = $_POST['loginEmail'];
    $login_password = $_POST['login_password'];

    // Check if the email is already in use.
    $sql = "SELECT * FROM `users` WHERE `user_email` = '$login_email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($login_password, $row['user_pass'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno'];
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['useremail'] = $login_email;
            // echo "logged in".$login_email ;
            header("Location: /learnPHP/projects/forum/index.php?loginsuccess=true");
            exit();
        } else {
            $showError = "badNameOrPass";
        }
    }
    header("Location: /learnPHP/projects/forum/index.php?faillogin=$showError");
}
?>