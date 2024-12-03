<?php 

require "config.php";

session_start();
session_unset();
session_destroy();

// Redirect al login
header("Location: " . APP_ROOT . "login.php");