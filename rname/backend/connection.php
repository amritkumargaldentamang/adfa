<?php
$host="localhost";
$user="root";
$pass="";
$db="eversales";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
	die("connection_failed:".$conn->connection_error);
}
?>