<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - NCC Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="dashboard-container">
    <h1>Welcome, <?php echo $_SESSION['admin_name']; ?> 👋</h1>

    <div class="dashboard-menu">
        <a href="add-training.php" class="btn">Add Training</a>
        <a href="mark-attendance.php" class="btn">Mark Attendance</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <hr>

    <h2>Registered Cadets</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Course</th>
            <th>Phone</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM cadets");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['fullname']}</td>
                    <td>{$row['course']}</td>
                    <td>{$row['phone']}</td>
                  </tr>";
        }
        ?>
    </table>

</div>

</body>
</html>