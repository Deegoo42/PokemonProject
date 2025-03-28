<?php
session_start();
header('Content-Type: application/json');

// Enable error logging
ini_set('display_errors', 1); // Temporarily enable error display for debugging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

// Debugging: Check if the session is set
if (!isset($_SESSION['username'])) {
    error_log("Error: User not logged in.");
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// Debugging: Log the username
$username = $_SESSION['username'];
error_log("Username: " . $username);

// Connect to the database
$conn = new mysqli("localhost", "root", "", "pokemon_project");
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Debugging: Log database connection success
error_log("Database connection successful.");

// Retrieve caught Pokémon for the logged-in user
$stmt = $conn->prepare("SELECT pokemon_id FROM caught_pokemon WHERE username = ?");
if (!$stmt) {
    error_log("Failed to prepare statement: " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error]);
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$caughtPokemons = [];
while ($row = $result->fetch_assoc()) {
    $caughtPokemons[] = $row['pokemon_id']; // Use the Pokémon ID
}

// Debugging: Log the caught Pokémon IDs
error_log("Caught Pokémon IDs: " . json_encode($caughtPokemons));

$stmt->close();
$conn->close();

// Return the caught Pokémon IDs as JSON
echo json_encode(['success' => true, 'caughtPokemons' => $caughtPokemons]);
?>

