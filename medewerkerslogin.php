<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerkers Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .kaas {
            font-family: 'Comic Sans MS', 'Helvetica Neue', sans-serif;
        }
        #employee-login {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #employee-login h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        #employee-login label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        #employee-login input[type="text"],
        #employee-login input[type="password"] {
            width: 95%; /* Iets korter gemaakt */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        #employee-login button {
            width: 100%;
            padding: 10px;
            background-color: #39afe6;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #employee-login button:hover {
            background-color: #0056b3;
        }

        #employee-login .back-button {
            margin-top: 10px; 
            background-color: #39afe6;
        }

        #employee-login .back-button:hover {
            background-color: #0056b3;
        }

        #employee-login p {
            text-align: center;
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Spik en Span</div>
        </nav>
    </header>
    <main>
        <section id="employee-login">
            <h2>Medewerkers Login</h2>
            <form action="authenticate.php" method="POST">
                <label class="kaas" for="username">Gebruikersnaam:</label>
                <input type="text" id="username" name="username" required>
                <label class="kaas" for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" required>
                <button class="kaas" type="submit">Login</button>
            </form>
            <button class="back-button kaas" onclick="window.location.href='index.html'">Ga Terug</button>
            <?php
            if (isset($_GET['error'])) {
                echo '<p>Ongeldige inloggegevens. Probeer opnieuw.</p>';
            }
            ?>
        </section>
    </main>
</body>
</html>