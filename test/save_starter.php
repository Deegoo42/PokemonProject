<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$username = $_SESSION['username'];
$data = json_decode(file_get_contents('php://input'), true);
$starter = $data['starter'] ?? null;

if (!$starter) {
    echo json_encode(['success' => false, 'message' => 'No starter selected.']);
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "pokemon_project");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Update the user's starter in the database
$sql = "UPDATE users SET starter = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $starter, $username);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Starter saved successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error saving starter: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>