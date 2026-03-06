<?php
require_once 'db.php';
checkLogin();
 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answers'])) {
    $total_score = array_sum($_POST['answers']);
    $user_id = $_SESSION['user_id'];
 
    // Categorization Logic
    $level = '';
    if ($total_score <= 35) { $level = 'Low EQ'; }
    elseif ($total_score <= 55) { $level = 'Average EQ'; }
    else { $level = 'High EQ'; }
 
    $stmt = $conn->prepare("INSERT INTO results (user_id, total_score, eq_level) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $total_score, $level);
 
    if ($stmt->execute()) {
        $result_id = $stmt->insert_id;
        header("Location: result.php?id=" . $result_id);
    } else {
        die("Error saving result.");
    }
} else {
    header("Location: dashboard.php");
}
 
