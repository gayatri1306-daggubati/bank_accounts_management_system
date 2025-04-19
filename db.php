<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default password for XAMPP
$dbname = "bank_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
// Optional: Uncomment to verify connection
// echo "✅ Database connected successfully";
?>
