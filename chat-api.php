<?php
session_start();
include "config.php";
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$message = strtolower(trim($data['message'] ?? ""));

$response = "🤖 I'm your NCC AI Assistant. Ask me anything about NCC.";

/* ==========================
   SMART INTENT DETECTION
   ========================== */

function contains($msg, $keywords) {
    foreach ($keywords as $word) {
        if (strpos($msg, $word) !== false) return true;
    }
    return false;
}

/* ==========================
   1️⃣ Attendance Detection
   ========================== */

if (contains($message, ["my attendance", "attendance percentage", "मेरी उपस्थिति", "attendance status"])) {

    if (!isset($_SESSION['cadet_id'])) {
        $response = "Please login first to check your attendance.";
    } else {

        $cadet_id = $_SESSION['cadet_id'];

        $totalQ = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE cadet_id = $cadet_id");
        $presentQ = $conn->query("SELECT COUNT(*) as present FROM attendance WHERE cadet_id = $cadet_id AND status='Present'");

        $total = $totalQ->fetch_assoc()['total'] ?? 0;
        $present = $presentQ->fetch_assoc()['present'] ?? 0;

        $percentage = ($total > 0) ? round(($present / $total) * 100) : 0;

        $response = "Your attendance is $percentage%. You attended $present out of $total trainings.";
    }
}

/* ==========================
   2️⃣ Next Training
   ========================== */

elseif (contains($message, ["next training", "upcoming training", "अगली ट्रेनिंग"])) {

    $query = $conn->query("
        SELECT * FROM training 
        WHERE training_date >= CURDATE()
        ORDER BY training_date ASC 
        LIMIT 1
    ");

    if ($query && $query->num_rows > 0) {
        $training = $query->fetch_assoc();
        $date = date("d M Y", strtotime($training['training_date']));
        $response = "📅 Next training: '{$training['title']}' on $date.";
    } else {
        $response = "No upcoming trainings scheduled.";
    }
}

/* ==========================
   3️⃣ NCC Knowledge Base
   ========================== */

elseif (contains($message, ["full form", "ncc ka full form"])) {
    $response = "NCC stands for National Cadet Corps.";
}

elseif (contains($message, ["what is ncc", "ncc kya hai"])) {
    $response = "NCC is a youth development movement that builds discipline, leadership and patriotism.";
}

elseif (contains($message, ["ano"])) {
    $response = "ANO means Associate NCC Officer. A trained teacher who manages NCC cadets.";
}

elseif (contains($message, ["cto"])) {
    $response = "CTO means Caretaker Training Officer who assists in NCC supervision.";
}

elseif (contains($message, ["certificate"])) {
    $response = "NCC provides A, B and C Certificates. C Certificate is the highest.";
}

elseif (contains($message, ["rdc"])) {
    $response = "RDC (Republic Day Camp) is the most prestigious NCC camp held in Delhi.";
}

elseif (contains($message, ["rank"])) {
    $response = "NCC ranks include Cadet, LCpl, Cpl, Sgt, UO and SUO.";
}

elseif (contains($message, ["join ncc", "eligibility"])) {
    $response = "To join NCC, you must be 16-24 years old, medically fit, and a student of recognized institution.";
}

echo json_encode(["reply" => $response]);
?>