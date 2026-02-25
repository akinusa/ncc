<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "config.php";

if (!isset($_SESSION['cadet_id'])) {
    header("Location: login.php");
    exit();
}

$cadet_id = $_SESSION['cadet_id'];

/* Fetch Cadet Info */
$stmt = $conn->prepare("SELECT * FROM cadets WHERE id = ?");
$stmt->bind_param("i", $cadet_id);
$stmt->execute();
$cadet = $stmt->get_result()->fetch_assoc();

/* Attendance Data */
$totalQuery = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE cadet_id = $cadet_id");
$total = $totalQuery->fetch_assoc()['total'] ?? 0;

$presentQuery = $conn->query("SELECT COUNT(*) as present FROM attendance WHERE cadet_id = $cadet_id AND status='Present'");
$present = $presentQuery->fetch_assoc()['present'] ?? 0;

$percentage = ($total > 0) ? round(($present / $total) * 100) : 0;

/* Attendance History */
$history = $conn->query("
    SELECT * FROM attendance 
    WHERE cadet_id = $cadet_id 
    ORDER BY training_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Cadet Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
:root {
  --primary:#0b3d91;
  --secondary:#c8102e;
  --light:#f4f6f9;
  --white:#ffffff;
  --shadow:0 10px 25px rgba(0,0,0,0.08);
}

*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Inter',sans-serif;
}

body{
  background:var(--light);
}

/* Top Bar */
.topbar{
  background:var(--primary);
  color:white;
  padding:1rem 2rem;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.topbar h2{
  font-weight:600;
}

.logout{
  color:white;
  text-decoration:none;
  background:var(--secondary);
  padding:0.5rem 1rem;
  border-radius:6px;
}

/* Dashboard Layout */
.container{
  padding:2rem;
}

.grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:2rem;
}

.card{
  background:var(--white);
  padding:1.8rem;
  border-radius:12px;
  box-shadow:var(--shadow);
}

.card h3{
  margin-bottom:1rem;
  color:var(--primary);
}

.progress-bar{
  background:#ddd;
  border-radius:20px;
  overflow:hidden;
  height:18px;
}

.chat-container {
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}

.chat-box {
    height: 300px;
    overflow-y: auto;
    padding: 15px;
    background: #f9f9f9;
}

.message {
    margin-bottom: 12px;
    padding: 8px 12px;
    border-radius: 8px;
    max-width: 75%;
}

.user {
    background: #0b3d91;
    color: white;
    margin-left: auto;
    text-align: right;
}

.bot {
    background: #e4e6eb;
    color: #000;
}

.chat-input-area {
    display: flex;
    border-top: 1px solid #ddd;
}

.chat-input-area input {
    flex: 1;
    padding: 10px;
    border: none;
    outline: none;
}

.chat-input-area button {
    background: #c8102e;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
}
.progress{
  height:100%;
  background:var(--primary);
  text-align:center;
  color:white;
  font-size:12px;
  line-height:18px;
}

/* Table */
table{
  width:100%;
  border-collapse:collapse;
  margin-top:1rem;
}

table th{
  background:var(--primary);
  color:white;
  padding:0.8rem;
}

table td{
  padding:0.8rem;
  text-align:center;
  border-bottom:1px solid #eee;
}

.present{
  color:green;
  font-weight:600;
}

.absent{
  color:red;
  font-weight:600;
}
.present {
    color: green;
    font-weight: 600;
}

.absent {
    color: red;
    font-weight: 600;
}
</style>
</head>

<body>

<div class="topbar">
  <h2>Welcome, <?php echo $cadet['fullname']; ?></h2>
  <a class="logout" href="logout.php">Logout</a>
</div>

<div class="container">

  <div class="grid">

    <div class="card">
      <h3>Rank</h3>
      <p><?php echo $cadet['rank'] ?? "Cadet"; ?></p>
    </div>

    <div class="card">
      <h3>Total Trainings</h3>
      <p><?php echo $total; ?></p>
    </div>

    <div class="card">
      <h3>Attendance</h3>
      <div class="progress-bar">
        <div class="progress" style="width: <?php echo $percentage; ?>%">
          <?php echo $percentage; ?>%
        </div>
      </div>
    </div>

  </div>

  <div class="card" style="margin-top:2rem;">
   <div class="card" style="margin-top:2rem;">
    <h3>Attendance History</h3>

    <table>
        <tr>
            <th>Date</th>
            <th>Status</th>
        </tr>

        <?php
        $history = $conn->query("
            SELECT training_date, status 
            FROM attendance 
            WHERE cadet_id = $cadet_id 
            ORDER BY training_date DESC
        ");

        if ($history && $history->num_rows > 0):
            while ($row = $history->fetch_assoc()):
        ?>
            <tr>
                <td><?php echo date("d M Y", strtotime($row['training_date'])); ?></td>
                <td class="<?php echo strtolower($row['status']); ?>">
                    <?php echo $row['status']; ?>
                </td>
            </tr>
        <?php
            endwhile;
        else:
        ?>
            <tr>
                <td colspan="2">No attendance records found.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
    
<div class="card" style="margin-top:2rem;">
  <h3>Upcoming Trainings</h3>

  <table>
    <tr>
      <th>Title</th>
      <th>Date</th>
      <th>Description</th>
    </tr>

    <?php
    $trainings = $conn->query("SELECT * FROM training ORDER BY training_date DESC");

    if ($trainings && $trainings->num_rows > 0):
        while($t = $trainings->fetch_assoc()):
    ?>
      <tr>
        <td><?php echo $t['title']; ?></td>
        <td><?php echo $t['training_date']; ?></td>
        <td><?php echo $t['description']; ?></td>
      </tr>
    <?php
        endwhile;
    else:
    ?>
      <tr>
        <td colspan="3">No trainings available.</td>
      </tr>
    <?php endif; ?>
  </table>
</div>
      <?php if ($history && $history->num_rows > 0): ?>
        <?php while($row = $history->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['training_date']; ?></td>
            <td class="<?php echo strtolower($row['status']); ?>">
              <?php echo $row['status']; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="2">No attendance records found.</td>
        </tr>
      <?php endif; ?>

    </table>
  </div>

  <div class="card" style="margin-top:2rem;">
    <h3>NCC Assistant 🤖</h3>

    <div class="chat-container">
        <div id="chat-box" class="chat-box"></div>

        <div class="chat-input-area">
            <input type="text" id="user-input" placeholder="Ask about NCC trainings, camps, certificates..." />
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
</div>
</div>
<script>
function sendMessage() {

    const input = document.getElementById("user-input");
    const message = input.value.trim();
    if (message === "") return;

    const chatBox = document.getElementById("chat-box");

    chatBox.innerHTML += `<div class="message user">${message}</div>`;
    input.value = "";
    chatBox.scrollTop = chatBox.scrollHeight;

    // Typing animation
    const typingDiv = document.createElement("div");
    typingDiv.className = "message bot";
    typingDiv.innerHTML = "Typing...";
    chatBox.appendChild(typingDiv);

    fetch("chat-api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: message })
    })
    .then(response => response.json())
    .then(data => {
        typingDiv.innerHTML = data.reply;
        chatBox.scrollTop = chatBox.scrollHeight;
    });
}
</script>
</body>
</html>