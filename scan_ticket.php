<?php
// filepath: c:\Users\steph\Downloads\New Compressed (zipped) Folder (2) (1)\Spik_Span\scan_ticket.php
session_start();

// Databaseverbinding
$host = 'localhost';
$dbname = 'spik_span';
$username = 'localhost';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Databaseverbinding mislukt: " . $e->getMessage());
}

// Controleer of een QR-code is ingevoerd via AJAX
if (isset($_POST['qr_code'])) {
    $qrCode = $_POST['qr_code'];
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE qr_code = ?");
    $stmt->execute([$qrCode]);
    $ticket = $stmt->fetch();

    if ($ticket) {
        // QR-code is geldig
        echo json_encode([
            'status' => 'success',
            'message' => 'Ticket is geldig!',
            'data' => [
                'naam' => $ticket['naam'],
                'achternaam' => $ticket['achternaam'],
                'email' => $ticket['email']
            ]
        ]);
    } else {
        // QR-code is ongeldig
        echo json_encode([
            'status' => 'error',
            'message' => 'Ongeldige ticket!'
        ]);
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        #result {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>QR Code Scanner</h1>
    <div id="reader" style="width: 300px; margin: auto;"></div>
    <div id="result"></div>

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
