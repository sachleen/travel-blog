<?php 
// The header information which will be verified
$agent=$_SERVER['HTTP_USER_AGENT'];
$signature=$_SERVER['HTTP_X_HUB_SIGNATURE'];
$body=@file_get_contents('php://input');

print_r($_SERVER);
echo $agent;
echo $signature;
echo $body;

// `git pull`
?>