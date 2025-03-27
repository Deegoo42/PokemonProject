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

echo "<script>console.log('Starter: " . $starter . "');</script>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pokemon_name'])) {
    if (!isset($_SESSION['username'])) {
        echo "You must be logged in to catch Pokémon.";
        exit();
    }

    $username = $_SESSION['username'];
    $pokemonName = $_POST['pokemon_name'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "pokemon_project");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert caught Pokémon into the database
    $sql = "INSERT INTO caught_pokemon (username, pokemon_name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $pokemonName);
    if ($stmt->execute()) {
        echo "Pokémon caught successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
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
        <button onclick="window.location.href='pokedex.php'" style="margin-top: 10px;">Go to Pokedex</button>
    </div>

    <h1>Vang de pokemon!</h1>

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

    <!-- Game Controls -->
    <div id="gameControls">
        <button onclick="attack()">Attack</button>
        <button onclick="catchPokemon()">Vang Pokémon</button>
    </div>

    <!-- Gevangen Pokémon -->
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
    </ul>

    <form method="POST" action="game.php">
        <input type="text" name="pokemon_name" placeholder="Enter Pokémon name" required>
        <button type="submit">Catch Pokémon</button>
    </form>

    <script src="js\java.js"></script>
    <script>
    let currentEnemyPokemon = null;
    let playerPokemonHp = 100; // Player's Pokémon HP
    let enemyPokemonHp = 100; // Enemy Pokémon HP

    document.addEventListener("DOMContentLoaded", function () {
        let chosenStarter = "<?php echo htmlspecialchars($starter); ?>";
        console.log("Chosen Starter:", chosenStarter);

        if (chosenStarter) {
            const starterId = getPokemonId(chosenStarter);
            document.getElementById("pokemonImage").src = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${starterId}.png`;
            document.getElementById("pokemonName").textContent = chosenStarter;
            document.getElementById("pokemonContainer").style.display = 'block';
        }

        // Spawn a new enemy Pokémon
        spawnEnemyPokemon();
        updateHpBars();
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
        return pokemonIds[name] || 1; // Default to Bulbasaur if the name is not found
    }

    function spawnEnemyPokemon() {
        // Fetch a random Pokémon from the PokéAPI
        const randomId = Math.floor(Math.random() * 898) + 1; // PokéAPI has Pokémon IDs from 1 to 898
        fetch(`https://pokeapi.co/api/v2/pokemon/${randomId}`)
            .then(response => response.json())
            .then(data => {
                currentEnemyPokemon = data.name.charAt(0).toUpperCase() + data.name.slice(1); // Capitalize the name
                const enemyImage = data.sprites.front_default;

                // Update the enemy Pokémon container
                document.getElementById("enemyImage").src = enemyImage;
                document.getElementById("enemyName").textContent = currentEnemyPokemon;
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
            alert("Your Pokémon fainted! Respawning...");
            playerPokemonHp = 100; // Reset player's Pokémon HP
            updateHpBars();
        }
    }

    function catchPokemon() {
        if (!currentEnemyPokemon) {
            alert("No enemy Pokémon to catch!");
            return;
        }

        // Calculate the catch chance
        const catchChance = Math.max(10, 100 - enemyPokemonHp); // Minimum 10%, maximum 100%
        const randomChance = Math.random() * 100;

        if (randomChance <= catchChance) {
            // Successful catch
            fetch('catch_pokemon.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ pokemon_name: currentEnemyPokemon }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("You successfully caught " + currentEnemyPokemon + "!");
                    window.location.href = "pokedex.php"; // Redirect to Pokedex page
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
    </script>
</body>
</html>