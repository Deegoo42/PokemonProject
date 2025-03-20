<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The PokÃ©mon Game</title>
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
<img src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/2fb2821a-1406-4a1d-9b04-6668f278e944/d843okx-eb13e8e4-0fa4-4fa9-968a-e0f36ff168de.png/v1/fit/w_800,h_480,q_70,strp/pokemon_x_and_y_battle_background_11_by_phoenixoflight92_d843okx-414w-2x.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9NDgwIiwicGF0aCI6IlwvZlwvMmZiMjgyMWEtMTQwNi00YTFkLTliMDQtNjY2OGYyNzhlOTQ0XC9kODQzb2t4LWViMTNlOGU0LTBmYTQtNGZhOS05NjhhLWUwZjM2ZmYxNjhkZS5wbmciLCJ3aWR0aCI6Ijw9ODAwIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmltYWdlLm9wZXJhdGlvbnMiXX0.m5eG5d4O5_xTOZAmNu5BcPF8rs01F7Pp4y2g2R14kOE" id="background" alt="achtergrond">

<img id="ds_yes" src="images/starter.png" alt="Afbeelding">

    <h1 id="title">Gen 1 Starters</h1>

    <div id="starterChoice">
        <div class="starter">
            <img id="starter1" src="" onclick="starter1">
            <p id="name1"></p>
        </div>
        <div class="starter">
            <img id="starter2" src="" onclick="starter2">
            <p id="name2"></p>
        </div>
        <div class="starter">
            <img id="starter3" src="" onclick="starter3">
            <p id="name3"></p>
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
</body>
</html>
