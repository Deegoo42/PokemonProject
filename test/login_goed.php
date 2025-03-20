<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<form>
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
        .hide {
            display: none;
        }
    </style>
<img src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/2fb2821a-1406-4a1d-9b04-6668f278e944/d843okx-eb13e8e4-0fa4-4fa9-968a-e0f36ff168de.png/v1/fit/w_800,h_480,q_70,strp/pokemon_x_and_y_battle_background_11_by_phoenixoflight92_d843okx-414w-2x.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9NDgwIiwicGF0aCI6IlwvZlwvMmZiMjgyMWEtMTQwNi00YTFkLTliMDQtNjY2OGYyNzhlOTQ0XC9kODQzb2t4LWViMTNlOGU0LTBmYTQtNGZhOS05NjhhLWUwZjM2ZmYxNjhkZS5wbmciLCJ3aWR0aCI6Ijw9ODAwIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmltYWdlLm9wZXJhdGlvbnMiXX0.m5eG5d4O5_xTOZAmNu5BcPF8rs01F7Pp4y2g2R14kOE" id="background" alt="achtergrond">

<img id="ds_yes" src="images/ds_onder1.png" alt="Afbeelding">
<form id="container" method="POST">
<label id="inloggen">
    <h2 id="inlogT">Inloggen</h2>
    <input id="inlogU" type="text" name="gebruikersnaam1" placeholder="gebruikersnaam"></input>
    <input id="inlogP" type="password" name="wachtwoord1" placeholder="wachtwoord"></input>
    <button id="inlogB" type="submit">inloggen</button>
</label>
<label class="hide" id="registreren">
    <h2 id="registreerT">Registreren</h2>
    <input id="registreerU" type="text" name="gebruikersnaam2" placeholder="gebruikersnaam"></input>
    <input id="registreerP" type="password" name="wachtwoord2" placeholder="wachtwoord"></input>
    <input id="registreerPA" type="password" name="wachtwoord2A" placeholder="wachtwoord opnieuw"></input>
    <button id="registreerB" type="submit">registreren</button>
</label>
</form>
<button id="registerP">registreren</button>
<button class="hide" id="inloggenP">inloggen</button>

<script src="js\login.js"></script>
</body>
</html>