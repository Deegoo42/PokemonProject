<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Pokémon Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Vang een Pokémon!</h1>
    
    
    <div id="pokemonContainer">
        <img id="pokemonImage" src="" alt="Pokémon verschijnt hier">
        <h2 id="pokemonName">You Encounterd a</h2>
    </div>

  


    <?php
    $gifUrl = "https://images.gamebanana.com/img/ico/sprays/64d88e78875d8.gif";
    echo '<img src="' . $gifUrl . '" alt="Pokémon GIF">';
    ?>
    <button onclick="getRandomPokemon()">Nieuwe Pokémon</button>

    <script>
        async function getRandomPokemon() {
            let id = Math.floor(Math.random() * 1025) + 1;
            let response = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
            let data = await response.json();

            
            document.getElementById("pokemonImage").src = data.sprites.front_default;
            document.getElementById("pokemonImage").alt = data.name;
            document.getElementById("pokemonName").innerText = data.name;
        }

       
        getRandomPokemon();
    </script>
</body>
</html>
