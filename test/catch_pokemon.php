<?php
session_start();
header('Content-Type: application/json');

// Enable error logging
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// Get the Pokémon name and ID from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);
$pokemonName = $data['pokemon_name'] ?? null;
$pokemonId = $data['pokemon_id'] ?? null;

if (!$pokemonName || !$pokemonId) {
    echo json_encode(['success' => false, 'message' => 'Invalid Pokémon data provided.']);
    exit();
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "pokemon_project");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Insert the caught Pokémon into the database
$username = $_SESSION['username'];
$stmt = $conn->prepare("INSERT INTO caught_pokemon (username, pokemon_name, pokemon_id) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $username, $pokemonName, $pokemonId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Pokémon caught successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save Pokémon: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>