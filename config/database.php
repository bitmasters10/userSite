<?php
// $servername = "fleet.lindatours.in";
// $username = "u820563802_Linda_fleet";
// $password = "Fleet@1234";
// $dbname = "u820563802_Linda_fleet";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "u820563802_Linda_fleet";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>      