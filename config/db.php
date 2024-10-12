<?php
// config/db.php

$host = 'localhost';
$user = 'root';  // default xampp user
$pass = '';      // default xampp password
$db_name = 'perpustakaan';

$conn = new mysqli($host, $user, $pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
