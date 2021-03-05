<?php

include_once 'autoload.php';
$user = new User();
$user->logout();
session_destroy();
header("Location: ./login.php");