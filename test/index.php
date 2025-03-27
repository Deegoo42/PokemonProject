<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the user already has a starter Pokémon
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

if ($row = $result->fetch_assoc()) {
    if (!empty($row['starter'])) {
        // Redirect to game.php if the user already has a starter
        header("Location: game.php");
        exit();
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Starter</title>
    <style> 
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: lightblue;
        }

        #ds_yes {
            position: fixed; 
            top: 0;
            left: 0;
            width: 100vw;  
            height: 100vh;
            object-fit: cover;
            z-index: -1;
        }


        #background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        #backgroundcolor {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: blue;
            width: 80vw;
            max-width: 1015px;
            height: 70vh; 
            max-height: 610px;
            z-index: -1;
            position: absolute;
            top: 54.2%;
            transform: translateY(-50%);
            border-radius: 10px;
        }

        h1 {
            position: relative;
            color: white;
            font-size: 28px;
            margin-bottom: 10px;
        }

        #starterChoice {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            position: relative;
            top: -30px;
        }

        .starter {
            text-align: center;
        }

        .starter img {
            width: 150px; 
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .starter img:hover {
            transform: scale(1.5);
        }

        .starter p {
            font-size: 18px;
            font-weight: bold;
            color: white;
            margin-top: 5px;
        }

        #starterChoice {
            position:relative;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 155px;
            top: -80px;
        }

        #starter2{
            position:relative;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 160px;
            top: -30px;
        }

        #buttons {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .btn {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: darkgray;
            color: white;
            transition: background 0.3s ease;
            position: relative;
            bottom: -150px;
        }

        .btn:hover {
            background-color: gray;
        }

        #name3,
        #name2,
        #name1 {
            position: relative;
            bottom: -70px;
            font-style: bold;
        }

    </style>
</head>
<img src="https://pbs.twimg.com/media/FosWlLqXsAAYkIt.jpg:large" id="background" alt="achtergrond">

<img id="ds_yes" src="images/starter.png" alt="Afbeelding">

    <h1 id="title">Gen 1 Starters</h1>

    <div id="starterChoice">
        <div class="starter">
            <img id="starter1" src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png" onclick="chooseStarter('Bulbasaur')" alt="Bulbasaur">
            <p id="name1">Bulbasaur</p>
        </div>
        <div class="starter">
            <img id="starter2" src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/4.png" onclick="chooseStarter('Charmander')" alt="Charmander">
            <p id="name2">Charmander</p>
        </div>
        <div class="starter">
            <img id="starter3" src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/7.png" onclick="chooseStarter('Squirtle')" alt="Squirtle">
            <p id="name3">Squirtle</p>
        </div>
    </div>

    <div id="buttons">
        <button class="btn" onclick="showGen(1)">Gen 1</button>
        <button class="btn" onclick="showGen(2)">Gen 2</button>
        <button class="btn" onclick="showGen(3)">Gen 3</button>
        <button class="btn" onclick="showGen(4)">Gen 4</button>
        <button class="btn" onclick="showGen(5)">Gen 5</button>
        <button class="btn" onclick="showGen(6)">Gen 6</button>
        <button class="btn" onclick="showGen(7)">Gen 7</button>
        <button class="btn" onclick="showGen(8)">Gen 8</button>
        <button class="btn" onclick="showGen(9)">Gen 9</button>
    </div>
    <script src="js\java.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        showGen(1); // Of een andere manier om je functie aan te roepen
    });

    function chooseStarter(pokemon) {
        // Save the chosen starter in localStorage
        localStorage.setItem("chosenStarter", pokemon);

        // Debugging: Log the chosen starter
        console.log(`Chosen starter saved to localStorage: ${pokemon}`);

        // Redirect to game.php
        window.location.href = "game.php";
    }
</script>
</body>
</html>
