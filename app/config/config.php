<?php

$user_agent = getenv("HTTP_USER_AGENT");

if(strpos($user_agent, "Win") !== FALSE)
$os = "Windows";
elseif(strpos($user_agent, "Mac") !== FALSE)
$os = "Mac";


$dbhost = "localhost";
$dbuser = "root";
$dbpass = $os === "Mac"?"root":""; //for mac
$dbname = "mm";
?>