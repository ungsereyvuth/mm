<?php

//ss

ob_start();

ini_set('display_errors',1);

ini_set('display_startup_errors',1);

error_reporting(-1);
set_include_path('../');
include_once("app/controller/controller.php");  

$app = new application;

$app->run();

ob_flush();

?>