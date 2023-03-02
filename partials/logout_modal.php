<!--
* @file logout_modal.php
* @author KUSHAGRA JAISWAL 
* @date 2022-06-28
* @copyright Copyright (c) 2022
-->

<!-- This is the logout modal. -->

<?php
session_start();
echo "Looging you out. Please wait...";

session_destroy();
header("Location: /learnPHP/projects/forum/index.php");

?>