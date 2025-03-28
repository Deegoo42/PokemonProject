// Haal de gegevens van de gekozen Pokémon op
async function getPokemonData(id) {
    try {
        let response = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
        if (!response.ok) {
            throw new Error("Failed to fetch Pokémon data.");
        }

        let data = await response.json();

        // Set the current Pokémon
        document.getElementById("pokemonImage").src = data.sprites.front_default;
        document.getElementById("pokemonImage").alt = data.name;
        document.getElementById("pokemonName").innerText = data.name;

        console.log(`Loaded Pokémon: ${data.name}`);
    } catch (error) {
        console.error("Error loading Pokémon data:", error);
    }
}
// Haal de gegevens van de vijandelijke Pokémon op
async function getEnemyPokemon() {
    let id = Math.floor(Math.random() * 1025) + 1;
    let response = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
    
    if (!response.ok) {
        console.error("Fout bij het ophalen van de vijandelijke Pokémon");
        return;
    }

    let data = await response.json();
    enemyPokemon = data;
    
    let enemyImage = document.getElementById("enemyImage");
    if (data.sprites && data.sprites.front_default) {
        enemyImage.src = data.sprites.front_default;
    } else {
        enemyImage.src = "fallback-image.png"; // Voeg een fallback afbeelding toe
    }
    
    document.getElementById("enemyName").innerText = data.name;
    enemyMaxHP = Math.floor(Math.random() * 100) + 50;
    enemyHP = enemyMaxHP;
    updateEnemyHPBar();
}

function fight() {
    if (currentHP > 0 && enemyHP > 0) {
        let playerDamage = Math.floor(Math.random() * 20) + 5;
        let enemyDamage = Math.floor(Math.random() * 20) + 5;

        // Animatie voor aanval
        document.getElementById("pokemonImage").classList.add('jumpToEnemy');
        setTimeout(() => {
            document.getElementById("pokemonImage").classList.remove('jumpToEnemy');
        }, 400);

        document.getElementById("enemyImage").classList.add('shake', 'flashRed');
        setTimeout(() => {
            document.getElementById("enemyImage").classList.remove('shake', 'flashRed');
        }, 600);

        // HP updaten
        enemyHP -= playerDamage;
        if (enemyHP < 0) enemyHP = 0;
        currentHP -= enemyDamage;
        if (currentHP < 0) currentHP = 0;

        updateHPBar();
        updateEnemyHPBar();

        alert(`${currentPokemon.name} doet ${playerDamage} schade aan ${enemyPokemon.name}!\n${enemyPokemon.name} doet ${enemyDamage} schade aan jou!`);

        // Check of een Pokémon is verslagen
        if (currentHP === 0) {
            alert(`${currentPokemon.name} is verslagen! Je hebt verloren!`);
            getPokemonData(currentPokemon.id);
        } else if (enemyHP === 0) {
            alert(`${enemyPokemon.name} is verslagen! Je hebt gewonnen!`);
            getEnemyPokemon();
        }
    }
}

function catchPokemon() {
    if (enemyHP > 0) {
        let catchChance = Math.random();
        if (catchChance > 0.5) {
            alert(`Je hebt ${enemyPokemon.name} gevangen! 🎉`);
            let caughtList = document.getElementById("caughtPokemons");
            let newItem = document.createElement("li");

            let pokemonImage = document.createElement("img");
            pokemonImage.src = enemyPokemon.sprites.front_default;
            pokemonImage.alt = enemyPokemon.name;
            
            newItem.appendChild(pokemonImage);
            newItem.appendChild(document.createTextNode(enemyPokemon.name));
            caughtList.appendChild(newItem);

            getEnemyPokemon();
        } else {
            alert(`${enemyPokemon.name} is ontsnapt uit de Pokébal, probeer het nog eens!`);
        }
    } else {
        alert("Je hebt deze Pokémon al verslagen, krijg een nieuwe Pokémon.");
    }
}

function updateHPBar() {
    let hpBar = document.getElementById("hpBar");
    if (hpBar) {
        let hpPercentage = (currentHP / maxHP) * 100;
        hpBar.style.width = hpPercentage + "%";
        document.getElementById("hpText").innerText = `HP: ${currentHP} / ${maxHP}`;
    }
}

function updateEnemyHPBar() {
    let enemyHpBar = document.getElementById("enemyHpBar");
    if (enemyHpBar) {
        let enemyHpPercentage = (enemyHP / enemyMaxHP) * 100;
        enemyHpBar.style.width = enemyHpPercentage + "%";
        document.getElementById("enemyHpText").innerText = `HP: ${enemyHP} / ${enemyMaxHP}`;
    }
}

function chooseStarter(pokemon) {
    // Create a form dynamically
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "index.php";

    // Add the starter as a hidden input
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = "starter";
    input.value = pokemon;
    form.appendChild(input);

    // Append the form to the body and submit it
    document.body.appendChild(form);
    form.submit();
}

const starters = {
    1: { names: ["Bulbasaur", "Charmander", "Squirtle"], ids: ["1", "4", "7"] },
    2: { names: ["Chikorita", "Cyndaquil", "Totodile"], ids: ["152", "155", "158"] },
    3: { names: ["Treecko", "Torchic", "Mudkip"], ids: ["252", "255", "258"] },
    4: { names: ["Turtwig", "Chimchar", "Piplup"], ids: ["387", "390", "393"] },
    5: { names: ["Snivy", "Tepig", "Oshawott"], ids: ["495", "498", "501"] },
    6: { names: ["Chespin", "Fennekin", "Froakie"], ids: ["650", "653", "656"] },
    7: { names: ["Rowlet", "Litten", "Popplio"], ids: ["722", "725", "728"] },
    8: { names: ["Grookey", "Scorbunny", "Sobble"], ids: ["810", "813", "816"] },
    9: { names: ["Sprigatito", "Fuecoco", "Quaxly"], ids: ["906", "909", "912"] }
};

function showGen(gen) {
    document.getElementById("title").innerText = `Gen ${gen} Starters`;
    
    for (let i = 1; i <= 3; i++) {
        document.getElementById(`starter${i}`).src = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${starters[gen].ids[i - 1]}.png`;
        document.getElementById(`starter${i}`).onclick = function() { chooseStarter(starters[gen].names[i - 1]); };
        document.getElementById(`name${i}`).innerText = starters[gen].names[i - 1];
    }
}

window.onload = function() {
    let starter = localStorage.getItem("chosenStarter");

    if (starter) {
        // Load the chosen starter Pokémon
        getPokemonData(evolutionStages[starter.toLowerCase()][0]);
    } else {
        // If no starter is found, provide a default Pokémon or allow the game to proceed
        alert("Geen starter gevonden. Een standaard Pokémon wordt geladen.");
        getPokemonData(1); // Default to Bulbasaur (ID: 1)
    }
};

let currentHP = 0;
let maxHP = 0;
let currentPokemon = {};
let enemyPokemon = {};
let enemyHP = 0;
let enemyMaxHP = 0;
let battlesFought = 0;

const evolutionStages = {
    "Bulbasaur": [1, 2, 3],
    "Charmander": [4, 5, 6],
    "Squirtle": [7, 8, 9],
    "Chikorita": [152, 153, 154],
    "Cyndaquil": [155, 156, 157],
    "Totodile": [158, 159, 160],
    "Treecko": [252, 253, 254],
    "Torchic": [255, 256, 257],
    "Mudkip": [258, 259, 260],
    "Turtwig": [387, 388, 389],
    "Chimchar": [390, 391, 392],
    "Piplup": [393, 394, 395],
    "Snivy": [495, 496, 497],
    "Tepig": [498, 499, 500],
    "Oshawott": [501, 502, 503],
    "Chespin": [650, 651, 652],
    "Fennekin": [653, 654, 655],
    "Froakie": [656, 657, 658],
    "Rowlet": [722, 723, 724],
    "Litten": [725, 726, 727],
    "Popplio": [728, 729, 730],
    "Grookey": [810, 811, 812],
    "Scorbunny": [813, 814, 815],
    "Sobble": [816, 817, 818],
    "Sprigatito": [906, 907, 908],
    "Fuecoco": [909, 910, 911],
    "Quaxly": [912, 913, 914]
};

async function getPokemonData(id) {
    let response = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
    let data = await response.json();

    currentPokemon = data;
    document.getElementById("pokemonImage").src = data.sprites.front_default;
    document.getElementById("pokemonImage").alt = data.name;
    document.getElementById("pokemonName").innerText = data.name;
    document.getElementById("pokemonImage").classList.add('flipped');

    maxHP = Math.floor(Math.random() * 100) + 50;
    currentHP = maxHP;
    updateHPBar();

    getEnemyPokemon();
}

async function getEnemyPokemon() {
    let id = Math.floor(Math.random() * 1025) + 1;
    let response = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
    if (!response.ok) return;

    let data = await response.json();
    enemyPokemon = data;
    document.getElementById("enemyImage").src = data.sprites.front_default || "fallback-image.png";
    document.getElementById("enemyName").innerText = data.name;
    enemyMaxHP = Math.floor(Math.random() * 100) + 50;
    enemyHP = enemyMaxHP;
    updateEnemyHPBar();
}

function fight() {
    if (currentHP > 0 && enemyHP > 0) {
        let playerDamage = Math.floor(Math.random() * 20) + 5;
        let enemyDamage = Math.floor(Math.random() * 20) + 5;

        document.getElementById("pokemonImage").classList.add('jumpToEnemy');
        setTimeout(() => document.getElementById("pokemonImage").classList.remove('jumpToEnemy'), 400);

        document.getElementById("enemyImage").classList.add('shake', 'flashRed');
        setTimeout(() => document.getElementById("enemyImage").classList.remove('shake', 'flashRed'), 600);

        enemyHP -= playerDamage;
        if (enemyHP < 0) enemyHP = 0;
        currentHP -= enemyDamage;
        if (currentHP < 0) currentHP = 0;

        updateHPBar();
        updateEnemyHPBar();

        alert(`${currentPokemon.name} doet ${playerDamage} schade aan ${enemyPokemon.name}!
${enemyPokemon.name} doet ${enemyDamage} schade aan jou!`);

        if (currentHP === 0) {
            alert(`${currentPokemon.name} is verslagen! Je hebt verloren!`);
            getPokemonData(currentPokemon.id);
        } else if (enemyHP === 0) {
            alert(`${enemyPokemon.name} is verslagen! Je hebt gewonnen!`);
            battlesFought++;
            checkEvolution();
            getEnemyPokemon();
        }
    }
}

function checkEvolution() {
    let starter = localStorage.getItem("chosenStarter").toLowerCase();
    if (evolutionStages[starter]) {
        let evolutionStage = evolutionStages[starter];
        let newStage = null;
        if (battlesFought === 3) newStage = evolutionStage[1];
        if (battlesFought === 6) newStage = evolutionStage[2];
        if (newStage) {
            alert(`${currentPokemon.name} evolueert!`);
            getPokemonData(newStage);
        }
    }
}

function catchPokemon() {
    if (enemyHP > 0) {
        let catchChance = Math.random();
        if (catchChance > 0.5) {
            alert(`Je hebt ${enemyPokemon.name} gevangen! 🎉`);
            let caughtList = document.getElementById("caughtPokemons");
            let newItem = document.createElement("li");

            let pokemonImage = document.createElement("img");
            pokemonImage.src = enemyPokemon.sprites.front_default;
            pokemonImage.alt = enemyPokemon.name;

            newItem.appendChild(pokemonImage);
            newItem.appendChild(document.createTextNode(enemyPokemon.name));
            caughtList.appendChild(newItem);

            battlesFought++;
            checkEvolution();
            getEnemyPokemon();
        } else {
            alert(`${enemyPokemon.name} is ontsnapt!`);
        }
    } else {
        alert("Je hebt deze Pokémon al verslagen, krijg een nieuwe Pokémon.");
    }
}

function logout() {
    localStorage.removeItem("chosenStarter");
    window.location.href = "login.php";
}
window.onload = function () {
    console.log("Starter Pokémon is being handled by PHP.");
};

document.addEventListener("DOMContentLoaded", function () {
    console.log("Chosen Starter from PHP:", chosenStarter);

    if (!chosenStarter) {
        console.error("No starter Pokémon found. Please check the PHP logic.");
        return;
    }

    if (chosenStarter) {
        const starterId = getPokemonId(chosenStarter);
        if (starterId) {
            document.getElementById("pokemonImage").src = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${starterId}.png`;
            document.getElementById("pokemonName").textContent = chosenStarter;
            document.getElementById("pokemonContainer").style.display = 'block';

            // Spawn a new enemy Pokémon
            spawnEnemyPokemon();
            updateHpBars();
        } else {
            console.error("Starter ID not found for:", chosenStarter);
        }
    } else {
        console.error("No starter Pokémon found. Please check the PHP logic.");
    }
});

document.getElementById("attackButton").addEventListener("click", function () {
    attack(); // Call the attack function
});

document.getElementById("vangButton").addEventListener("click", function () {
    catchPokemon(); // Call the catchPokemon function
});
