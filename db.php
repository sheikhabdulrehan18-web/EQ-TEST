<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
 
$host = 'localhost';
$user = 'rsk9_8';
$pass = '123456';
$dbname = 'rsk9_8';
 
try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
 
    // Check if tables exist
    $tableCheck = $conn->query("SHOW TABLES LIKE 'users'");
    if ($tableCheck->num_rows == 0) {
        die("<b>Setup Error:</b> Database tables not found. Please import 'eq_tables.sql' into your database.");
    }
 
} catch (Exception $e) {
    die("<b>Database Connection Error:</b> " . $e->getMessage() . "<br>Please check your credentials in db.php.");
}
 
if (!session_id()) session_start();
 
function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags($data)));
}
 
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}
 
