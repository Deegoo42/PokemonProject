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

// Fetch Pokémon data from the PokeAPI and cache it
function fetchPokemonIdMapping($pokemonNames) {
    $cacheFile = 'pokemon_ids_cache.json';

    // Load the cache if it exists
    $cachedData = [];
    if (file_exists($cacheFile)) {
        $cachedData = json_decode(file_get_contents($cacheFile), true);
    }

    $pokemonIds = $cachedData; // Start with cached data
    $namesToFetch = array_diff($pokemonNames, array_keys($cachedData)); // Only fetch missing Pokémon

    foreach ($namesToFetch as $name) {
        $normalizedName = strtolower(str_replace([' ', '.'], ['-', ''], $name)); // Normalize the name
        $url = "https://pokeapi.co/api/v2/pokemon/{$normalizedName}";
        $data = @file_get_contents($url); // Suppress warnings if the request fails
        if ($data === false) {
            continue; // Skip this Pokémon if the request fails
        }
        $data = json_decode($data, true);
        if (isset($data['name']) && isset($data['id'])) {
            $pokemonIds[$name] = $data['id']; // Use the original name as the key
        }
    }

    // Save the updated mapping to the cache file
    file_put_contents($cacheFile, json_encode($pokemonIds));
    return $pokemonIds;
}

// Get the list of Pokémon names from the database
$pokemonNames = [];
while ($row = $result->fetch_assoc()) {
    $pokemonNames[] = htmlspecialchars($row['pokemon_name']);
}

// Generate the mapping of Pokémon names to IDs
$pokemonIds = fetchPokemonIdMapping($pokemonNames);

///echo "<pre>";
///print_r($pokemonIds);
///echo "</pre>";
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
        foreach ($pokemonNames as $pokemonName) {
            $pokemonId = $pokemonIds[$pokemonName] ?? null; // Get the ID from the mapping

            if ($pokemonId) {
                echo "<div class='pokemon'>";
                echo "<img src='https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{$pokemonId}.png' alt='{$pokemonName}'>";
                echo "<p><strong>{$pokemonName}</strong></p>"; // Display the Pokémon name
                echo "<p>ID: {$pokemonId}</p>"; // Display the Pokémon ID
                echo "</div>";
            } else {
                echo "<div class='pokemon'>";
                echo "<p>Image not available for {$pokemonName}</p>";
                echo "</div>";
            }
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
    <style>
        .pokemon {
    display: inline-block;
    margin: 10px; /* Reduce spacing between Pokémon */
    text-align: center;
    border: 2px solid #000; /* Add a black border */
    border-radius: 10px; /* Optional: Rounded corners */
    padding: 10px; /* Add padding inside the border */
    background-color: #fff; /* Optional: Background color */
    width: 180px; /* Set a fixed width for consistency */
}

.pokemon img {
    width: 150px;
    height: 150px;
}

.pokemon p {
    margin: 5px 0; /* Reduce spacing between text elements */
}

body {
    font-family: Arial, sans-serif;
    text-align: center;
    background-image: url('images/pokedex.jpg'); /* Set the background image */
    background-size: 200% 250%; /* Stretch the image to cover the entire screen */
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* Prevent the image from repeating */
    color: #000; /* Optional: Set text color for better contrast */
}


    </style>
    <a href="game.php">Back to Game</a>
</body>
</html>