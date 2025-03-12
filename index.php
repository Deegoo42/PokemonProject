<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Pokémon Game</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { text-align: center; font-family: Arial, sans-serif; }
        img { width: 200px; height: 200px; transition: transform 0.2s ease-in-out; }
        #hpBarContainer {
            width: 200px;
            height: 20px;
            border: 2px solid black;
            background: lightgray;
            margin: auto;
        }
        #hpBar {
            height: 100%;
            background: red;
            width: 100%;
        }
        #hpText { font-weight: bold; }
        #caughtPokemons {
            margin-top: 20px;
        }
        .shake {
            animation: shake 0.2s ease-in-out;
        }
        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <h1>Vang een Pokémon!</h1>
    
    
    <div id="pokemonContainer">
        <img id="pokemonImage" src="" alt="Pokémon verschijnt hier">
        <h2 id="pokemonName"></h2>
        <div id="hpBarContainer">
            <div id="hpBar"></div>
        </div>
        <p id="hpText"></p>
    </div>

    
    <button onclick="fight()">Val aan</button>
    <button onclick="catchPokemon()">Vang Pokemon</button>
    
    <!-- Lijst met gevangen Pokémon -->
    <h2>Gevangen Pokémon</h2>
    <ul id="caughtPokemons"></ul>

    <script>
        let currentHP = 0;
        let maxHP = 0;
        let currentPokemon = {};

        async function getRandomPokemon() {
            let id = Math.floor(Math.random() * 1025) + 1;
            let response = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
            let data = await response.json();

            // Update Pokémon-informatie
            currentPokemon = data;
            document.getElementById("pokemonImage").src = data.sprites.front_default;
            document.getElementById("pokemonImage").alt = data.name;
            document.getElementById("pokemonName").innerText = data.name;

            // HP instellen
            maxHP = Math.floor(Math.random() * 100) + 50;
            currentHP = maxHP;
            updateHPBar();
        }

        function fight() {
            if (currentHP > 0) {
                document.getElementById("pokemonImage").classList.add("shake");

                // Pokémon schade laten krijgen (5-20 damage)
                setTimeout(() => {
                    currentHP -= Math.floor(Math.random() * 20) + 5;
                    if (currentHP < 0) currentHP = 0;
                    updateHPBar();

                    document.getElementById("pokemonImage").classList.remove("shake");

                    // Pokémon sterft, spawn een nieuwe
                    if (currentHP === 0) {
                        setTimeout(() => {
                            alert(`${currentPokemon.name} is knock-out! Een nieuwe Pokémon verschijnt.`);
                            getRandomPokemon();
                        }, 500);
                    }
                }, 200);
            }
        }

        function catchPokemon() {
            if (currentHP > 0) {
                let catchChance = Math.random();
                if (catchChance > 0.5) {
                    alert(`Je hebt ${currentPokemon.name} gevangen! 🎉`);
                    
                    // Voeg Pokémon toe aan de gevangen lijst
                    let caughtList = document.getElementById("caughtPokemons");
                    let newItem = document.createElement("li");
                    newItem.textContent = currentPokemon.name;
                    caughtList.appendChild(newItem);

                    getRandomPokemon();
                } else {
                    alert(`${currentPokemon.name} is ontsnapt... 😢`);
                }
            } else {
                alert("Deze Pokémon is al knock-out! Roep een nieuwe op.");
            }
        }

        function updateHPBar() {
            let hpPercentage = (currentHP / maxHP) * 100;
            document.getElementById("hpBar").style.width = hpPercentage + "%";
            document.getElementById("hpText").innerText = `HP: ${currentHP} / ${maxHP}`;
        }

        // Start met een willekeurige Pokémon
        getRandomPokemon();
    </script>
</body>
</html>
