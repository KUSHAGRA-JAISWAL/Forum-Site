<!--
* @file header.php
* @author KUSHAGRA JAISWAL 
* @date 2022-06-23
* @copyright Copyright (c) 2022
-->

<!-- This is the header component. -->

<?php

session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand" href="/learnPHP/projects/forum/">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/learnPHP/projects/forum/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/learnPHP/projects/forum/about.php">About</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Top Categories
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

                $sql = "SELECT `category_name`, `category_id` FROM `categories` LIMIT 3";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                 echo ' <li><a class="dropdown-item" href="thread_list.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
                }
              echo '  </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/learnPHP/projects/forum/contact.php">Contact</a>
            </li>
        </ul>
        <div class="d-flex mx-2">';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo '
            <form class="d-flex" method ="get" action="search.php">
                <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
               <p class="text-success mx-2 my-auto"> Welcome_' . $_SESSION['useremail'] . '</p>
               <a href="partials/logout_modal.php" class="btn btn-outline-success mx-2">Logout</a>
                </form>
            ';
} else {


    echo ' <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
                </form>
            <button class="btn btn-outline-success mx-2"  data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button class="btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
}
echo ' </div>
    </div>
</div>
</nav>';

include 'partials/login_modal.php';
include 'partials/signup_modal.php';
if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
    echo '
        <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Congratulations! </strong> You can now Login
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
}
if (isset($_GET['signupfail']) && $_GET['signupfail'] == "existEmail") {
    echo '
    <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
    <strong>Sorry! </strong> Username has been taken
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-la bel="Close"></button>
    </div>
    ';
}
if (isset($_GET['signupfail']) && $_GET['signupfail'] == "badPassword") {
    echo '
    <div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
    <strong>Warning! </strong> Password do not match
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
}
if (isset($_GET['faillogin']) && $_GET['faillogin'] == "badNameOrPass") {
    echo '
    <div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
    <strong>Warning! </strong> Bad ID or Password
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
}
?>