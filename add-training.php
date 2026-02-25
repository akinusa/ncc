<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $training_date = $_POST['training_date'];

    $stmt = $conn->prepare("INSERT INTO training (title, description, training_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $training_date);

    if ($stmt->execute()) {
        echo "<script>alert('Training Added Successfully');window.location='admin-dashboard.php';</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Training</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <h2>Add Training</h2>

        <form method="POST">
            <input type="text" name="title" placeholder="Training Title" required>
            
            <textarea name="description" placeholder="Training Description" required></textarea>
            
            <input type="date" name="training_date" required>

            <button type="submit" class="btn btn-accent">Add Training</button>
        </form>

        <br>
        <a href="admin-dashboard.php">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>