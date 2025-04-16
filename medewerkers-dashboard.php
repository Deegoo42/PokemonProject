<?php
// filepath: c:\Users\steph\Downloads\New Compressed (zipped) Folder (2) (1)\Spik_Span\medewerkers-dashboard.php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: medewerkerslogin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerkers Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="js/html5-qrcode/html5-qrcode.min.js"></script> <!-- Lokaal geladen bibliotheek -->
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        #reader {
            width: 300px;
            margin: 20px auto;
        }
        #result {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .success {
            background-color: green;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 50px;
        }
        .error {
            background-color: rgb(128, 0, 0);
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Medewerkers Dashboard</h1>
        <p>Scan een QR-code om deze te valideren.</p>
    </header>

    <main>
        <div id="reader"></div>
        <div id="result"></div>
    </main>

    <script>
        function onScanSuccess(decodedText) {
            // Stuur de QR-code naar de server voor validatie
            fetch('scan_ticket.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'qr_code=' + encodeURIComponent(decodedText)
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');
                if (data.status === 'success') {
                    resultDiv.innerHTML = `<p class="success">${data.message}</p>
                                           <p>Naam: ${data.data.naam}</p>
                                           <p>Achternaam: ${data.data.achternaam}</p>
                                           <p>E-mail: ${data.data.email}</p>`;
                    document.body.style.backgroundColor = 'green';
                } else {
                    resultDiv.innerHTML = `<p class="error">${data.message}</p>`;
                    document.body.style.backgroundColor = 'red';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function onScanFailure(error) {
            console.warn(`QR Code scan failed: ${error}`);
        }

        // Start de QR-code scanner
        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            { facingMode: "environment" }, // Gebruik de achtercamera
            {
                fps: 10, // Frames per seconde
                qrbox: { width: 250, height: 250 } // Grootte van de scanbox
            },
            onScanSuccess,
            onScanFailure
        );
    </script>
</body>
</html>