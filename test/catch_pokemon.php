<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$username = $_SESSION['username'];
$data = json_decode(file_get_contents('php://input'), true);
$pokemonName = $data['pokemon_name'] ?? null;

if (!$pokemonName) {
    echo json_encode(['success' => false, 'message' => 'No Pokémon name provided.']);
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "pokemon_project");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Insert caught Pokémon into the database
$sql = "INSERT INTO caught_pokemon (username, pokemon_name) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $pokemonName);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error saving Pokémon: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>