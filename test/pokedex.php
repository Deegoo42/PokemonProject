<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve caught Pokémon for the logged-in user
$conn = new mysqli("localhost", "root", "", "pokemon_project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$sql = "SELECT pokemon_name FROM caught_pokemon WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f8ff;
        }

        .pokemon {
            display: inline-block;
            margin: 20px;
            text-align: center;
        }

        .pokemon img {
            width: 150px;
            height: 150px;
        }
    </style>
</head>
<body>
    <h1>Your Pokedex</h1>
    <div id="pokedex">
        <?php
        while ($row = $result->fetch_assoc()) {
            $pokemonName = htmlspecialchars($row['pokemon_name']);
            $pokemonId = strtolower($pokemonName); // Convert name to lowercase for sprite URL
            echo "<div class='pokemon'>";
            echo "<img src='https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{$pokemonId}.png' alt='{$pokemonName}'>";
            echo "<p>{$pokemonName}</p>";
            echo "</div>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
    <a href="game.php">Back to Game</a>
</body>
</html>