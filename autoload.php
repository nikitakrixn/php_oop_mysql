<?php

spl_autoload_register('my_autoload');

function my_autoload($classname)
{
    $path = "class/";

    $get_path = $path . $classname . ".php";

    include_once $get_path;
}

if(!isset($_SESSION)) {
    session_start();
}