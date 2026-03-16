<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "it9-webportfolio";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->select_db($dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}