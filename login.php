<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM cadets WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {

            $_SESSION['cadet_id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Incorrect Password!";
        }

    } else {
        $error = "Phone number not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadet Login | NCC Portal</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
:root {
  --primary: #0b3d91;
  --secondary: #c8102e;
  --light: #f4f6f9;
  --white: #ffffff;
  --shadow: 0 10px 25px rgba(0,0,0,0.1);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Inter', sans-serif;
}

body {
  background: linear-gradient(135deg, #0b3d91, #1f5edc);
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.login-card {
  background: var(--white);
  padding: 2.5rem;
  width: 380px;
  border-radius: 15px;
  box-shadow: var(--shadow);
  text-align: center;
}

.login-card img {
  width: 80px;
  margin-bottom: 1rem;
}

.login-card h2 {
  margin-bottom: 1.5rem;
  color: var(--primary);
}

.login-card input {
  width: 100%;
  padding: 0.8rem;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 14px;
}

.login-card input:focus {
  border-color: var(--primary);
  outline: none;
}

.btn {
  width: 100%;
  padding: 0.9rem;
  background: var(--primary);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}

.btn:hover {
  background: #082c6c;
}

.error {
  color: red;
  margin-bottom: 1rem;
  font-size: 14px;
}

.register-link {
  margin-top: 1rem;
  font-size: 14px;
}

.register-link a {
  color: var(--secondary);
  text-decoration: none;
  font-weight: 600;
}
</style>

</head>
<body>

<div class="login-card">

  <!-- NCC Logo -->
  <img src="ncc-logo.png.png" alt="NCC Logo">

  <h2>Cadet Login</h2>

  <?php if ($error != ""): ?>
      <div class="error"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="POST">
      <input type="tel" name="phone" placeholder="Phone Number" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" class="btn">Login</button>
  </form>

  <div class="register-link">
      Don't have an account? <a href="register.php">Register</a>
  </div>

</div>

</body>
</html>