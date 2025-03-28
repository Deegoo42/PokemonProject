<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the user's starter Pokémon from the database
$conn = new mysqli("localhost", "root", "", "pokemon_project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$sql = "SELECT starter FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$starter = null;

if ($row = $result->fetch_assoc()) {
    $starter = $row['starter'];
}

$stmt->close();
$conn->close();

// If no starter is found, redirect to index.php to choose one
if (empty($starter)) {
    header("Location: index.php");
    exit();
}

// Debugging: Log the starter Pokémon
echo "<script>console.log('Starter from PHP: " . htmlspecialchars($starter, ENT_QUOTES, 'UTF-8') . "');</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Pokémon Game</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Positioning for the enemy Pokémon */
        #enemyContainer {
            position: absolute;
            top: 20%;
            right: 10%;
            text-align: center;
        }

        #enemyHpBarContainer {
            width: 200px;
            height: 20px;
            background-color: lightgray;
            margin: 10px auto;
        }

        #enemyHpBar {
            width: 100%;
            height: 100%;
            background-color: red;
        }

        /* Positioning for the player's Pokémon */
        #pokemonContainer {
            position: absolute;
            bottom: 20%;
            left: 10%;
            text-align: center;
        }

        #hpBarContainer {
            width: 200px;
            height: 20px;
            background-color: lightgray;
            margin: 10px auto;
        }

        #hpBar {
            width: 100%;
            height: 100%;
            background-color: green;
        }

        /* Center the game controls */
        #gameControls {
            position: absolute;
            bottom: 10%;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }

        #accountInfo {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div id="accountInfo">
        Logged in as: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
        <form action="logout.php" method="POST" style="margin-top: 10px;">
            <button type="submit">Logout</button>
        </form>
    </div>

    <div id="title">
        <img src="images/Titel.png" alt="Vang De Pokemon" style="width: 300px; height: auto;">
    </div>

    <img src="https://pbs.twimg.com/media/FosWlLqXsAAYkIt.jpg:large" id="background" alt="achtergrond">

    <!-- Enemy Pokémon -->
    <div id="enemyContainer" style="display: none;">
        <h2>Enemy Pokémon:</h2>
        <img id="enemyImage" src="" alt="Enemy Pokémon">
        <h3 id="enemyName"></h3>
        <div id="enemyHpBarContainer">
            <div id="enemyHpBar"></div>
        </div>
        <p id="enemyHpText"></p>
    </div>

    <!-- Player's Pokémon -->
    <div id="pokemonContainer" style="display: none;">
        <h2>Your Pokémon:</h2>
        <img id="pokemonImage" src="" alt="Your Pokémon">
        <h3 id="pokemonName"></h3>
        <div id="hpBarContainer">
            <div id="hpBar"></div>
        </div>
        <p id="hpText"></p>
    </div>

   

    <div id="actions">
        <!-- Attack Button -->
        <img src="images/FIGHT.png" alt="Attack" id="attackButton" style="cursor: pointer; width: 150px; height: auto;">

        <!-- Vang Pokemon Button -->
        <img src="images/BALL.png" alt="Vang Pokemon" id="vangButton" style="cursor: pointer; width: 150px; height: auto;">
    </div>

    <!-- Gevangen Pokémon 
    <h2>Gevangen Pokémon</h2>
    <ul id="caughtPokemons">
        <?php
        // Retrieve caught Pokémon for the logged-in user
        $conn = new mysqli("localhost", "root", "", "pokemon_project");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT pokemon_name FROM caught_pokemon WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row['pokemon_name']) . "</li>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </ul>-->

    
    <a href="pokedex.php">
    <img src="images/POKEMON.png" alt="Go to Pokedex" style="cursor: pointer; width: 150px; height: auto; margin-top: 10px;">
</a>

    

    <script src="js\java.js"></script>
    <script>
    

    let currentEnemyPokemon = null;
    let playerPokemonHp = 100; // Player's Pokémon HP
    let enemyPokemonHp = 100; // Enemy Pokémon HP
    let caughtPokemons = []; // Store caught Pokémon

    document.addEventListener("DOMContentLoaded", function () {
        let chosenStarter = "<?php echo htmlspecialchars($starter); ?>";
        console.log("Chosen Starter:", chosenStarter);

        const starterId = getPokemonId(chosenStarter);
        document.getElementById("pokemonImage").src = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${starterId}.png`;
        document.getElementById("pokemonName").textContent = chosenStarter;
        document.getElementById("pokemonContainer").style.display = 'block';

        // Spawn a new enemy Pokémon
        spawnEnemyPokemon();
        updateHpBars();

        fetch('get_caught_pokemon.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    caughtPokemons = data.caughtPokemons;
                    console.log("Caught Pokémon:", caughtPokemons);
                } else {
                    console.error("Error fetching caught Pokémon:", data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });

    document.addEventListener("DOMContentLoaded", function () {
        fetch('get_caught_pokemon.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    caughtPokemons = data.caughtPokemons; // Store Pokémon IDs
                    console.log("Caught Pokémon IDs:", caughtPokemons);
                } else {
                    console.error("Error fetching caught Pokémon:", data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });

    function getPokemonId(name) {
        const pokemonIds = {
            "Bulbasaur": 1,
            "Charmander": 4,
            "Squirtle": 7,
            "Chikorita": 152,
            "Cyndaquil": 155,
            "Totodile": 158,
            "Treecko": 252,
            "Torchic": 255,
            "Mudkip": 258,
            "Turtwig": 387,
            "Piplup": 393,
            "Snivy": 495,
            "Tepig": 498,
            "Oshawott": 501,
            "Chespin": 650,
            "Fennekin": 653,
            "Froakie": 656,
            "Rowlet": 722,
            "Litten": 725,
            "Popplio": 728,
            "Grookey": 810,
            "Scorbunny": 813,
            "Sobble": 816,
            "Sprigatito": 906,
            "Fuecoco": 909,
            "Quaxly": 912
        };

        // Normalize the name (capitalize the first letter, lowercase the rest)
        const normalizedName = name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();

        if (pokemonIds[normalizedName]) {
            return pokemonIds[normalizedName];
        } else {
            console.error(`Pokémon "${name}" not found in pokemonIds.`);
            return null; // Return null if the Pokémon name is not found
        }
    }

    function spawnEnemyPokemon() {
        // Fetch a random Pokémon from the PokéAPI
        const randomId = Math.floor(Math.random() * 898) + 1; // PokéAPI has Pokémon IDs from 1 to 898
        fetch(`https://pokeapi.co/api/v2/pokemon/${randomId}`)
            .then(response => response.json())
            .then(data => {
                currentEnemyPokemon = {
                    name: data.name.charAt(0).toUpperCase() + data.name.slice(1), // Capitalize the name
                    id: randomId // Store the Pokémon ID
                };
                console.log("Spawned Enemy Pokémon:", currentEnemyPokemon); // Debugging
                const enemyImage = data.sprites.front_default;

                // Update the enemy Pokémon container
                document.getElementById("enemyImage").src = enemyImage;
                document.getElementById("enemyName").textContent = currentEnemyPokemon.name;
                document.getElementById("enemyContainer").style.display = 'block';

                // Reset enemy HP
                enemyPokemonHp = 100;
                updateHpBars();
            })
            .catch(error => {
                console.error("Error fetching Pokémon from PokéAPI:", error);
            });
    }

    function updateHpBars() {
        document.getElementById("hpBar").style.width = playerPokemonHp + "%";
        document.getElementById("enemyHpBar").style.width = enemyPokemonHp + "%";
        document.getElementById("hpText").textContent = `HP: ${playerPokemonHp}`;
        document.getElementById("enemyHpText").textContent = `HP: ${enemyPokemonHp}`;
    }

    function attack() {
        if (enemyPokemonHp <= 0 || playerPokemonHp <= 0) {
            alert("The battle is over!");
            return;
        }

        // Player attacks enemy
        const playerDamage = Math.floor(Math.random() * 20) + 10; // Random damage between 10 and 30
        enemyPokemonHp -= playerDamage;
        if (enemyPokemonHp < 0) enemyPokemonHp = 0;

        // Enemy attacks player
        const enemyDamage = Math.floor(Math.random() * 15) + 5; // Random damage between 5 and 20
        playerPokemonHp -= enemyDamage;
        if (playerPokemonHp < 0) playerPokemonHp = 0;

        updateHpBars();

        if (enemyPokemonHp === 0) {
            alert("You defeated the enemy Pokémon!");
            spawnEnemyPokemon(); // Spawn a new enemy Pokémon
        } else if (playerPokemonHp === 0) {
            console.log("Caught Pokémon before switching:", caughtPokemons); // Debugging

            if (caughtPokemons.length > 0) {
                // Switch to a new Pokémon
                const newPokemonId = caughtPokemons.shift(); // Take the first Pokémon ID from the list
                alert(`Your Pokémon fainted! Switching to Pokémon ID: ${newPokemonId}.`);

                if (newPokemonId) {
                    // Fetch Pokémon details from the PokéAPI
                    fetch(`https://pokeapi.co/api/v2/pokemon/${newPokemonId}`)
                        .then(response => response.json())
                        .then(data => {
                            const pokemonName = data.name.charAt(0).toUpperCase() + data.name.slice(1); // Capitalize the name
                            const pokemonImage = data.sprites.front_default;

                            // Update player's Pokémon details
                            document.getElementById("pokemonImage").src = pokemonImage;
                            document.getElementById("pokemonName").textContent = pokemonName; // Display the Pokémon name
                            playerPokemonHp = 100; // Reset HP for the new Pokémon
                            updateHpBars();
                        })
                        .catch(error => {
                            console.error("Error fetching Pokémon details:", error);
                            alert("Failed to switch Pokémon. Please try again.");
                        });
                } else {
                    alert(`Failed to switch to Pokémon ID: ${newPokemonId}.`);
                }
            } else {
                // No caught Pokémon available
                alert("Your Pokémon fainted, and you have no more Pokémon to fight!");
                playerPokemonHp = 100; // Reset HP for the current Pokémon
                updateHpBars();
            }
        }
    }

    function catchPokemon() {
        if (!currentEnemyPokemon) {
            alert("No enemy Pokémon to catch!");
            return;
        }

        console.log("Current Enemy Pokémon:", currentEnemyPokemon); // Debugging

        // Calculate the catch chance
        const catchChance = Math.max(10, 100 - enemyPokemonHp); // Minimum 10%, maximum 100%
        const randomChance = Math.random() * 100;

        if (randomChance <= catchChance) {
            // Successful catch
            const pokemonId = currentEnemyPokemon.id; // Use the stored Pokémon ID
            const pokemonName = currentEnemyPokemon.name; // Use the stored Pokémon name
            console.log("Attempting to catch Pokémon:", pokemonName, "with ID:", pokemonId);

            fetch('catch_pokemon.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ pokemon_name: pokemonName, pokemon_id: pokemonId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("You successfully caught " + pokemonName + "!");
                    caughtPokemons.push(pokemonId); // Add the Pokémon ID to the caughtPokemons array
                    console.log("Caught Pokémon IDs:", caughtPokemons);
                    spawnEnemyPokemon(); // Spawn a new enemy Pokémon
                } else {
                    alert("Error saving Pokémon: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        } else {
            // Failed catch
            alert("The Pokémon escaped!");
        }
    }
    

    let starter = localStorage.getItem("chosenStarter");

    if (starter) {
        console.log(`Starter found: ${starter}`);
        if (evolutionStages[starter]) {
            getPokemonData(evolutionStages[starter][0]); // Get the first evolution stage
        } else {
            console.error(`Starter "${starter}" not found in evolutionStages.`);
        }
    }
    </script>
    <script>
    const chosenStarter = "<?php echo htmlspecialchars($starter, ENT_QUOTES, 'UTF-8'); ?>";
    console.log("Starter from PHP:", chosenStarter);
</script>
<script src="js/java.js"></script>
</body>
</html>