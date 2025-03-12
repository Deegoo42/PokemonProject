let currentHP = 0;
let maxHP = 0;
let currentPokemon = {};
let enemyPokemon = {};
let enemyHP = 0;
let enemyMaxHP = 0;

// Kies je starter pokemon
function chooseStarter(starter) {
    let pokemonData = {
        bulbasaur: { name: 'bulbasaur', id: 1 },
        charmander: { name: 'charmander', id: 4 },
        squirtle: { name: 'squirtle', id: 7 }
    };

    // Haal de data van de pokemons op
    currentPokemon = pokemonData[starter];
    getPokemonData(currentPokemon.id);
    document.getElementById("starterChoice").style.display = 'none'; // Verberg starter keuze
    document.getElementById("pokemonContainer").style.display = 'block'; // Toon Pokémon container
    document.getElementById("enemyContainer").style.display = 'block'; // Toon vijand container
    document.getElementById("gameControls").style.display = 'block'; // Toon de controleknoppen
}

// haal de gegevens van de pokemon uit de pokeapi
async function getPokemonData(id) {
    let response = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
    let data = await response.json();

    // Start de game
    currentPokemon = data;
    document.getElementById("pokemonImage").src = data.sprites.front_default;
    document.getElementById("pokemonImage").alt = data.name;
    document.getElementById("pokemonName").innerText = data.name;

    document.getElementById("pokemonImage").classList.add('flipped');

    maxHP = Math.floor(Math.random() * 100) + 50; // Randomize HP
    currentHP = maxHP;
    updateHPBar();

    // Spawn een enemy
    getEnemyPokemon();
}

// Haal de data van de enemy pokemon op ui de pokeapi
async function getEnemyPokemon() {
    let id = Math.floor(Math.random() * 1025) + 1; // Kiest een willekeurige pokemon van de 1025
    let response = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
    let data = await response.json();

    // Assign alle data naar de enemy pokemon
    enemyPokemon = data;
    document.getElementById("enemyImage").src = enemyPokemon.sprites.front_default;
    document.getElementById("enemyImage").alt = enemyPokemon.name;
    document.getElementById("enemyName").innerText = enemyPokemon.name;

    enemyMaxHP = Math.floor(Math.random() * 100) + 50; // Randomize de HP
    enemyHP = enemyMaxHP;
    updateEnemyHPBar();
}

function fight() {
  if (currentHP > 0 && enemyHP > 0) {
      let playerDamage = Math.floor(Math.random() * 20) + 5;
      let enemyDamage = Math.floor(Math.random() * 20) + 5;

      // Voeg animatie toe voor het aanvallen van de vijand
      document.getElementById("pokemonImage").classList.add('jumpToEnemy');
      setTimeout(() => {
          document.getElementById("pokemonImage").classList.remove('jumpToEnemy'); // Verwijder de animatie na afloop
      }, 400);

      // Voeg animatie toe voor de vijand die wordt geraakt
      document.getElementById("enemyImage").classList.add('shake', 'flashRed');
      setTimeout(() => {
          document.getElementById("enemyImage").classList.remove('shake', 'flashRed');
      }, 600); // Schud en flashRed duren respectievelijk 0.2s en 0.2s

      // Verminder HP na de aanval
      enemyHP -= playerDamage;
      if (enemyHP < 0) enemyHP = 0;

      // De vijand valt aan
      currentHP -= enemyDamage;
      if (currentHP < 0) currentHP = 0;

      updateHPBar();
      updateEnemyHPBar();

      alert(`${currentPokemon.name} doet ${playerDamage} schade aan ${enemyPokemon.name}!\n${enemyPokemon.name} doet ${enemyDamage} schade aan jou!`);

      // Controleer of een van de Pokémon verslagen is
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
    if (currentHP > 0) {
        let catchChance = Math.random();
        if (catchChance > 0.5) {
            alert(`Je hebt ${enemyPokemon.name} gevangen! 🎉`);
            
            // Voeg gevangen pokemon toe aan de lijst
            let caughtList = document.getElementById("caughtPokemons");
            let newItem = document.createElement("li");

            // Plak de sprite naast de pokemon naam in de lijst
            let pokemonImage = document.createElement("img");
            pokemonImage.src = enemyPokemon.sprites.front_default;
            pokemonImage.alt = enemyPokemon.name;

            // Voeg de afbeelding en de naam van de Pokémon toe aan het lijstitem
            newItem.appendChild(pokemonImage);
            newItem.appendChild(document.createTextNode(enemyPokemon.name));
            caughtList.appendChild(newItem);

            getEnemyPokemon(); // Spawn een nieuwe enemy
        } else {
            alert(`${enemyPokemon.name} is ontsnapt uit de pokebal, probeer het nog eens`);
        }
    } else {
        alert("Je hebt deze pokemon al verslagen, Krijg een nieuwe pokemon.");
    }
}

function updateHPBar() {
    let hpPercentage = (currentHP / maxHP) * 100;
    document.getElementById("hpBar").style.width = hpPercentage + "%";
    document.getElementById("hpText").innerText = `HP: ${currentHP} / ${maxHP}`;
}

function updateEnemyHPBar() {
    let enemyHpPercentage = (enemyHP / enemyMaxHP) * 100;
    document.getElementById("enemyHpBar").style.width = enemyHpPercentage + "%";
    document.getElementById("enemyHpText").innerText = `HP: ${enemyHP} / ${enemyMaxHP}`;
}