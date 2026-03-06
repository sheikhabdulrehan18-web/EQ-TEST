<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "PHP is working. Current directory: " . getcwd() . "<br>";
echo "PHP Version: " . phpversion() . "<br>";
 
$host = 'localhost';
$user = 'rsk9_8';
$pass = '123456';
$dbname = 'rsk9_8';
 
echo "Testing connection to $dbname...<br>";
 
$conn = new mysqli($host, $user, $pass, $dbname);
 
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
} else {
    echo "Connection successful!";
}
?>
 
