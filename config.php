<?php
// connect to mysql
$mysqli = new mysqli("localhost","root","","test");

//check connection
if ($mysqli->connect_errno) {
	die("Failed to connect to database:" . $mysqli->connect_errno);
}

// set unicode
$mysqli->query("set character set 'utf-8'");
$mysqli->query("set names 'utf-8'");

?>