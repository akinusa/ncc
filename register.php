<?php
session_start();
include "config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize inputs
    $fullname = trim($_POST['fullname']);
    $dob      = trim($_POST['dob']);
    $gender   = trim($_POST['gender']);
    $course   = trim($_POST['course']);
    $phone    = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Validate empty fields
    if (empty($fullname) || empty($dob) || empty($gender) || empty($course) || empty($phone) || empty($password)) {
        die("All fields are required.");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if phone already exists
    $check = $conn->prepare("SELECT id FROM cadets WHERE phone = ?");
    $check->bind_param("s", $phone);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        die("Phone number already registered. <a href='login.php'>Login here</a>");
    }
    $check->close();

    // Insert new cadet
    $stmt = $conn->prepare("INSERT INTO cadets (fullname, dob, gender, course, phone, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullname, $dob, $gender, $course, $phone, $hashedPassword);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: login.php");
        exit();
    } else {
        echo "Registration Failed: " . $stmt->error;
    }

    $stmt->close();
}
?>