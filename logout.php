<?php

include_once 'autoload.php';
$user = new User();
$user->logout();
session_destroy();
session_unset();
header("Location: ./login.php");