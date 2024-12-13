<?php
header("Content-Type: application/json");

// Connect to the database
include 'db_connection.php';
$data = json_decode(file_get_contents("php://input"), true);

// Check if the user has already voted using cookies
if (isset($_COOKIE['voted'])) {
    echo json_encode(["message" => "Vec si glasao/la"]);
    exit;
}

// Insert the vote into the database
$vote = $data['vote'];
$stmt = $conn->prepare("INSERT INTO votes (vote_option) VALUES (?)");
$stmt->bind_param("s", $vote);

if ($stmt->execute()) {
    // Set a cookie to prevent re-voting
    setcookie("voted", "true", time() + (86400 * 1), "/"); // 1 day expiration
    echo json_encode(["message" => "Uspesno glasao"]);
} else {
    echo json_encode(["message" => "Greska!"]);
}
?>
