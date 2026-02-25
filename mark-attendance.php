<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$date = date("Y-m-d");

/* HANDLE FORM SUBMIT */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['status'])) {

        foreach ($_POST['status'] as $cadet_id => $status) {

            // Check if attendance already marked for today
            $check = $conn->prepare("
                SELECT id FROM attendance 
                WHERE cadet_id = ? AND training_date = ?
            ");
            $check->bind_param("is", $cadet_id, $date);
            $check->execute();
            $check->store_result();

            if ($check->num_rows == 0) {

                $stmt = $conn->prepare("
                    INSERT INTO attendance (cadet_id, training_date, status) 
                    VALUES (?, ?, ?)
                ");
                $stmt->bind_param("iss", $cadet_id, $date, $status);
                $stmt->execute();
                $stmt->close();
            }

            $check->close();
        }

        echo "<script>alert('Attendance Marked Successfully'); window.location='admin-dashboard.php';</script>";
        exit();

    } else {
        $error = "Please mark attendance for all cadets.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Mark Attendance</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Inter', sans-serif;
    background: #f4f6f9;
    margin: 0;
    padding: 0;
}

.container {
    width: 90%;
    max-width: 900px;
    margin: 40px auto;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

h2 {
    margin-bottom: 20px;
    color: #0b3d91;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #0b3d91;
    color: white;
    padding: 12px;
}

td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

.btn {
    background: #c8102e;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}

.btn:hover {
    opacity: 0.9;
}

.back-link {
    display: inline-block;
    margin-top: 15px;
    text-decoration: none;
    color: #0b3d91;
    font-weight: 600;
}

.error {
    color: red;
    margin-bottom: 10px;
}
</style>
</head>

<body>

<div class="container">
    <div class="card">

        <h2>Mark Attendance (<?php echo $date; ?>)</h2>

        <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

        <form method="POST">

            <table>
                <tr>
                    <th>Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                </tr>

                <?php
                $result = $conn->query("SELECT * FROM cadets");

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['fullname']}</td>
                            <td>
                                <input type='radio' name='status[{$row['id']}]' value='Present' required>
                            </td>
                            <td>
                                <input type='radio' name='status[{$row['id']}]' value='Absent'>
                            </td>
                          </tr>";
                }
                ?>
            </table>

            <br>
            <button type="submit" class="btn">Submit Attendance</button>

        </form>

        <a class="back-link" href="admin-dashboard.php">← Back to Dashboard</a>

    </div>
</div>

</body>
</html>