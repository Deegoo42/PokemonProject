function showhide(shown, hidden) {
    shown.forEach(id => {
        document.getElementById(id).classList.remove('hidden');
    });
    hidden.forEach(id => {
        document.getElementById(id).classList.add('hidden');
    })
}

const vertaling = {
    header: {
        nl: ['Home', 'Tickets', 'About', 'Privacy', 'Contact'],

        en: ['thoeës', 'Kaartjes', 'Euver', 'Privaasie', 'Kontak']
    },
    home: {
        nl: [
            'Welkom bij Spik en Span',
            'Koop je tickets hier!!'
        ],

        en: ['Welkom bij Spik en Span',
            'Koop eure kaartjes hier!!'
        ]
    },

    about: {
        nl: ['Over ons',
            'Gegarandeerd feest met Spik en Span op je evenement!',
            'Jo Huijnen en Niek Dirkx, oftewel Spik en Span, zijn de Kampioene van de Nach. Met hun vier LVK-overwinningen zijn zij het meest succesvolle vastelaoves-duo van het afgelopen decennium in Limburg.',
            'Spik en Span is als vastelaoves-duo actief sinds 2010 en vanaf het prille begin vaste finalist van het Limburgs Vastelaoves Leedjes Konkoer.',
            'Hun optredens zijn vol energie , met nummers die bekend zijn van Noord tot Zuid in de provincie. Een optreden van Spik en Span staat garant voor entertainment, samen zingen en samen beleven. “Gewuen jonges”, met prachtig repertoire en vlammende optredens.',
            'In 2020 won het duo wederom het LVK met het nummer ‘Vrunj tot de allerbeste runj’.'
        ],
        en: ['Euver us',
            'Gegarandeerd feest mit Spik en Span op eur evenemint!',
            'Jo Huijnen en Niek Dirkx, ouch waal Spik en Span geneump, zien de Kampioene vaan de Nach. Mit hun veer LVK-euverwinninge zien ze ‘t succesvolste carnavalduo vaan ‘t aafgeloupe decennium in Limburg.',
            'Spik en Span is sinds 2010 actief es carnavalduo en is vaanaof ‘t begin ‘n permanente finalis vaan de Limburgs Vastelaoves Leedjes Konkoer.',
            'Hun optrejjes zien vol energie, mit leedsjes die bekind zien vaan Noord tot Zuid in de provincie. ‘N optrejje vaan Spik en Span garandeert entertainment, same zinge en same dinger ervare. “Gewuen jonges”, mit un prachtig repertoire en vurige optrejje.',
            'In 2020 wón ‘t duo weer de LVK mit ‘t leedsje ‘Vrunj tot de beste runj’.'
        ]
    },

    tickets: {
        nl: [
            'koop je tickets',
            'Spik en Span Live in Venlo',
            'Een onvergetelijke vastelaovesavond met Spik en Span – energie, humor en muziek!',
            'kinder ticket 9 tm 15',
            '€ 9,50',
            'koop ticket',
            'Spik en Span Live in Venlo',
            'Een onvergetelijke vastelaovesavond met Spik en Span – energie, humor en muziek!',
            'volwassen ticket',
            '€ 17,50',
            'koop ticket',
        ],
    
        en: [
            'koep dien kaartsje',
            'Spik en Span Live in Venlo',
            'Eine onvergeteleke vastelaovesaovend mit Spik en Span – energie, lol en good muziek!',
            'kinderkaartsje (9 t/m 15 jaor)',
            '€ 9,50',
            'koep dien kaartsje',
            'Spik en Span Live in Venlo',
            'Eine onvergeteleke vastelaovesaovend mit Spik en Span – energie, lol en good muziek!',
            'volwasse kaartsje',
            '€ 17,50',
            'koep kaartsje',
        ]
    },
    
    
    privacy: {
        nl: ['Privacyverklaring Spik en Span',
            'Wie zijn wij?',
            'Privacyverklaring Spik en Span',
            'Deze website dient als een systeem voor onze klanten om tickets te kopen voor de concerten die wij geven.',
            'Wie zijn wij?',
            'Wij verzamelen alleen de persoonlijke gegevens die wij nodig hebben om onze dienst goed uit te voeren. Dit kan onder anderen gaan om:.',
            '• naam- en achternaam<br>• e-mailadres<br>• Telefoonnummer<br>• Geboortedatum',
            'Waarvoor gebruiken wij jouw gegevens?',
            'Wij gebruiken jouw gegevens voor de bijstaande acties:',
            '• Verwerken en lever van bestelling<br>• Verzenden van orderbevestiging<br>• Het verbeteren van onze site',
            'Hoe beveiligen wij jouw gegevens?',
            'Wij hebben een database die heel erg beveiligd is met allemaal sterke firewalls. Alleen admins/bevoegde medewerkers hebben toegang tot onze database/systeem',
            'Hoelang behouden wij deze gegevens?',
            'Wij behouden uw gegevens tot na de show waar u ticket toe behoort. Hierna verwijderen we dit uit de database van gegevens. In geval van tickets die vaker dan één keer meegaan verwijderen we uw ticket uit de database 3 dagen nadat het ticket is uitgewerkt, dit om de klant de kans te geven om nog contact op te nemen in geval er is iets mis is met het ticket na het scannen.',
            'Rechten als klant van Spik en Span',
            'Je hebt het recht om:',
            '• Jouw informatie te zien<br>• Jouw gegevens te laten verwijderen/verranderen<br>• Toestemming om klachten indienen'
        ],
        en: ['Privacyverklaring Spik en Span',
            'Wie zeen veer?',
            'Privacyverklaring Spik en Span',
            'Deze website is eine systeem veur os klanten om kaartjes te kópe veur de concerten die veer geve.',
            'Wie zien veer?',
            'Veer verzamele allein de persoonsgegevens die veer nodig höbbe om ós dienst goed te kónne uitvoere. Dit kin ónger aander gaon euver:',
            '• Voor- en achternaam<br>• E-mailadres<br>• Telefoonnummer<br>• Geboortedatum',
            'Waat doone veer mit dien gegeavens?',
            'Veer gebruuke dien gegeavens veur de volgende dinge:',
            '• Verwerke en leve van bestellings<br>• Versture van bevestiging van de bestelling<br>• Ut verbeteren van ós website',
            'Hoe bewaare veer dien gegeavens?',
            'Veer höbbe eine database die heel good beveilig is mit stevige firewalls. Allein admins en bevoegde medewerkers kinne erbij.',
            'Hoelang bewaare veer deze gegeavens?',
            'Veer bewaare dien gegeavens tot nao de show waor dien kaartje veur is. Dao nao wisse veer alles oet de database. In geval van kaartjes die meermals gebruuk kómme wisse veer alles drie daag nao de geldigheid van ut kaartje. Dit doon veer zoadat de klant nog kontakt kin opneme as d’r noeëts mis is gegaej mit ut scanne.',
            'Rechte es klant van Spik en Span',
            'Doe höbs ut recht om:',
            '• Dien info te bekieke<br>• Dien gegeavens te laote wisse/verander<br>• Klachte in te dienen'
        ],
    },
    contact: {
        nl: ['Contact',
            'Neem contact met ons op via e-mail of telefoon.',
            'Email: spikenspan@gmail.com<br>Tel: +31 6 12345678'
        ],

        en: ['us nummer ',
            'Neem contact op mit us via e-mail of telefoon.',
            'Emeel: spikenspan@gmail.com<br>Tel: +31 6 12345678'
        ]
    }

}

let taal = 'nl';

function vertaal() {
    taal = (taal === 'nl') ? 'en' : 'nl';

    document.querySelectorAll('.thuis').forEach((el, i) => {
        el.innerHTML = vertaling.home[taal][i];
    });
    document.querySelectorAll('.about').forEach((el, i) => {
        el.innerHTML = vertaling.about[taal][i];
    });
    document.querySelectorAll('.tickets').forEach((el, i) => {
        el.innerHTML = vertaling.tickets[taal][i];
    });
    document.querySelectorAll('.privacy').forEach((el, i) => {
        el.innerHTML = vertaling.privacy[taal][i];
    });
    document.querySelectorAll('.contact').forEach((el, i) => {
        el.innerHTML = vertaling.contact[taal][i];
    });
    document.querySelectorAll('.header').forEach((el, i) => {
        el.innerHTML = vertaling.header[taal][i];
    });
}

function employeeLogin() {
    document.getElementById('loginModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('loginModal').classList.add('hidden');
}

function validateLogin() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Replace with your actual credentials
    const validUsername = "employee";
    const validPassword = "secure";
}