<!--
* @file _dbconnect.php
* @author KUSHAGRA JAISWAL 
* @date 2022-06-24
* @copyright Copyright (c) 2022
-->

<!-- Program to connect the database to our codein php. -->

<?php
// connecting to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "idiscuss";

// Create a Connection Object
$conn = mysqli_connect($servername, $username, $password, $database);

//Die if connection was not successfull
if (!$conn) {
    die("Sorry we failed to connect : " . mysqli_connect_error());
}
?>