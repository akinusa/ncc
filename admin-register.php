<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username already exists
    $check = $conn->prepare("SELECT id FROM admins WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Username already exists!";
    } else {

        // Insert admin securely
        $stmt = $conn->prepare("INSERT INTO admins (fullname, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullname, $username, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Admin Registered Successfully');window.location='admin-login.php';</script>";
            exit();
        } else {
            $error = "Database Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">

        <h2>Register Admin</h2>

        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">
            <input type="text" name="fullname" placeholder="Full Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-accent">Register</button>
        </form>

        <p class="register-link">
            Already Admin? <a href="admin-login.php">Login</a>
        </p>

    </div>
</div>

</body>
</html>