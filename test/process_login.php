<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "pokemon_project"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user = $_POST['username'];
$pass = $_POST['password'];

// Check if user exists
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($pass, $row['password'])) {
        session_start();
        $_SESSION['username'] = $user;

        // Retrieve the user's starter Pokémon
        $starterSql = "SELECT starter FROM users WHERE username = ?";
        $starterStmt = $conn->prepare($starterSql);
        $starterStmt->bind_param("s", $user);
        $starterStmt->execute();
        $starterResult = $starterStmt->get_result();
        if ($starterRow = $starterResult->fetch_assoc()) {
            $_SESSION['starter'] = $starterRow['starter'];
        }

        header("Location: index.php");
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "Invalid username.";
}

$stmt->close();
$conn->close();
?>