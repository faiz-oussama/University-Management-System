<?php
$servername = "localhost";
$username = "faiz";
$password = "faiz1234";
$dbname = "ensahify_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

