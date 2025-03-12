fetch('https://pokeapi.co/api/v2/pokemon?limit=1025')
    .then(response => response.json())
    .then(data => console.log(data.results));

    const getRandomPokemon = async () => {
      let id = Math.floor(Math.random() * 151) + 1; // Kanto-regio (Gen 1)
      let response = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
      let pokemon = await response.json();
      console.log(pokemon.name, pokemon.sprites.front_default);
  };
  
  getRandomPokemon();