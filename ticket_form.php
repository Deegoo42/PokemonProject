<?php
$ticketType = isset($_GET['ticket_type']) ? htmlspecialchars($_GET['ticket_type']) : 'Onbekend Ticket';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Formulier</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .hidden { display: none; }
        .textkaartje { color: black; }
        .ticket-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .ticket-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .ticket-card img {
            max-width: 100%;
            border-radius: 8px;
        }
        .ticket-card button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #39afe6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .ticket-card button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<main>
<h2 id="ticket-title">Kies je Ticket</h2>
    <div class="ticket-container">
        <div class="ticket-card" id="1">
            <img src="https://i.ytimg.com/vi/qGGkel-EhiQ/maxresdefault.jpg" alt="Kinder Ticket">
            <h3 class="textkaartje">Kinder Ticket</h3>
            <p class="textkaartje">Prijs: €9,50</p>
            <button onclick="toggleTicket('1', '2', 'Kinder Ticket', this)">Kies Ticket</button>
        </div>
        <div class="ticket-card" id="2">
            <img src="https://i.ytimg.com/vi/TiLlnFMdxUM/maxresdefault.jpg" alt="Volwassen Ticket">
            <h3 class="textkaartje">Volwassen Ticket</h3>
            <p class="textkaartje">Prijs: €17,50</p>
            <button onclick="toggleTicket('2', '1', 'Volwassen Ticket', this)">Kies Ticket</button>
        </div>
    </div>

    <section id="ticket-form" class="hidden">
        <h2 class="textkaartje">Vul je gegevens in</h2>
        <form action="generate_ticket.php" method="POST">
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" required>

            <label for="achternaam">Achternaam:</label>
            <input type="text" id="achternaam" name="achternaam" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="geboortedatum">Geboortedatum:</label>
            <input type="date" id="geboortedatum" name="geboortedatum" required>

            <input type="hidden" id="ticket-type" name="ticket_type" value="">

            <button type="submit">Bevestig en Koop Ticket</button>
            <button type="button" onclick="hideForm(); resetTickets();">Annuleer</button>
        </form>
    </section>
</main>

<script>
    function showForm(ticketType) {
        document.getElementById('ticket-form').classList.remove('hidden');
        document.getElementById('ticket-type').value = ticketType;
        document.getElementById('ticket-title').innerText = "Je Gekozen Ticket";
    }

    function hideForm() {
        document.getElementById('ticket-form').classList.add('hidden');
        document.getElementById('ticket-title').innerText = "Kies je Ticket";
    }

    function showhide(shown, hidden) {
        shown.forEach(id => {
            document.getElementById(id).classList.remove('hidden');
        });
        hidden.forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });
    }

    function toggleTicket(showId, hideId, ticketType, btn) {
        showhide([showId], [hideId]);
        showForm(ticketType);

        btn.innerText = "Andere Ticket";
        btn.onclick = function () {
            resetTickets();
        };
    }

    function resetTickets() {
        showhide(['1', '2'], []);
        hideForm();
        const buttons = document.querySelectorAll('.ticket-card button');
        buttons.forEach(btn => {
            btn.innerText = 'Kies Ticket';
            btn.onclick = function () {
                const card = btn.closest('.ticket-card');
                const id = card.id;
                const otherId = id === '1' ? '2' : '1';
                const ticketType = card.querySelector('h3').innerText;
                toggleTicket(id, otherId, ticketType, btn);
            };
        });
    }
</script>

</body>
</html>
