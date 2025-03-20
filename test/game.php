<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Pokémon Game</title>
    <link rel="stylesheet" href="style.css">
    <style>

    </style>
</head>
<body>
    <h1>Vang de pokemon!</h1>

    <!-- Starter pokemon kiezen -->
    <div id="starterChoice">
        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png" onclick="chooseStarter('bulbasaur')" alt="Bulbasaur">
        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/4.png" onclick="chooseStarter('charmander')" alt="Charmander">
        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/7.png" onclick="chooseStarter('squirtle')" alt="Squirtle">
    </div>

    <!-- De containers voor de Pokemons, je eigen en de enemy -->
    <div id="pokemonContainer" style="display: none;">
        <h2>Jouw Pokémon:</h2>
        <img id="pokemonImage" src="" alt="Pokémon verschijnt hier">
        <h2 id="pokemonName"></h2>
        <div id="hpBarContainer">
            <div id="hpBar"></div>
        </div>
        <p id="hpText"></p>
    </div>

    <div id="enemyContainer" style="display: none;">
        <h2>Enemy Pokemon:</h2>
        <img id="enemyImage" src="" alt="Vijand verschijnt hier">
        <h2 id="enemyName"></h2>
        <div id="enemyHpBarContainer">
            <div id="enemyHpBar"></div>
        </div>
        <p id="enemyHpText"></p>
    </div>

    <div id="gameControls">
        <button onclick="fight()">Val aan</button>
        <button onclick="catchPokemon()">Vang Pokémon</button>
    </div>

    <!-- Gevangen Pokemon -->
    <h2>Gevangen Pokémon</h2>
    <ul id="caughtPokemons"></ul>

    <script src="js\java.js"></script>
</body>
</html>