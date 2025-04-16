<?php
// filepath: c:\Users\steph\Downloads\New Compressed (zipped) Folder (2) (1)\Spik_Span\generate_ticket.php
session_start();
require __DIR__ . '/vendor/autoload.php'; // Voor QR-code generatie
require __DIR__ . '/vendor/setasign/fpdf/fpdf.php'; // Voor PDF-generatie
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Databaseverbinding
$host = 'localhost:8001';
$dbname = 'spik_span';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Databaseverbinding mislukt: " . $e->getMessage());
}

// Gegevens van het formulier ophalen
$naam = $_POST['naam'];
$achternaam = $_POST['achternaam'];
$email = $_POST['email'];
$geboortedatum = $_POST['geboortedatum'];
$ticketType = $_POST['ticket_type'];

// Unieke QR-code genereren
$qrCodeData = $naam . ' ' . $achternaam . ' - ' . uniqid();
$qrCode = new QrCode($qrCodeData);
$writer = new PngWriter();
$qrCodePath = 'qrcodes/' . uniqid() . '.png';
$writer->write($qrCode)->saveToFile($qrCodePath);

// Gegevens opslaan in de database
$stmt = $pdo->prepare("INSERT INTO tickets (naam, achternaam, email, geboortedatum, qr_code, ticket_type) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$naam, $achternaam, $email, $geboortedatum, $qrCodeData, $ticketType]);

// PDF genereren
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Ticket Bevestiging');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, "Naam: $naam $achternaam");
$pdf->Ln(10);
$pdf->Cell(40, 10, "E-mail: $email");
$pdf->Ln(10);
$pdf->Cell(40, 10, "Ticket Type: $ticketType");
$pdf->Ln(10);
$pdf->Cell(40, 10, "Geboortedatum: $geboortedatum");
$pdf->Ln(20);
$pdf->Cell(40, 10, 'QR Code:');
$pdf->Image($qrCodePath, 10, 60, 50, 50); // Voeg QR-code toe aan PDF
$pdfPath = 'tickets/' . uniqid() . '.pdf';
$pdf->Output('F', $pdfPath);

// E-mail verzenden
$mail = new PHPMailer(true);

try {
    // Serverinstellingen
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // SMTP-server van Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'diegoreif2007@gmail.com'; // Jouw Gmail-adres
    $mail->Password = 'cjmw roqd ksyx sobk'; // Jouw Gmail-wachtwoord of app-specifiek wachtwoord
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Ontvanger
    $mail->setFrom('your_email@example.com', 'Spik en Span');
    $mail->addAddress($email, "$naam $achternaam");

    // Bijlage
    $mail->addAttachment($pdfPath);

    // Inhoud
    $mail->isHTML(true);
    $mail->Subject = 'Bevestiging van je Ticket';
    $mail->Body = "<h1>Bedankt voor je aankoop!</h1><p>Hierbij je ticket voor het evenement. De QR-code is toegevoegd als bijlage.</p>";

    $mail->send();
    echo 'E-mail is verzonden!';
} catch (Exception $e) {
    echo "E-mail kon niet worden verzonden. Mailer Error: {$mail->ErrorInfo}";
}
?>

<style>
/* Navbar styling */
header {
    background-color: #007bff;
    color: white;
    padding: 10px 20px; /* Zorgt voor voldoende ruimte */
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

header .logo {
    font-size: 24px;
    font-weight: bold;
}

header ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    gap: 15px;
}

header ul li {
    margin: 0;
}

header ul li a {
    color: white;
    text-decoration: none;
    font-size: 16px;
    padding: 5px 10px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

header ul li a:hover {
    background-color: #0056b3;
}
</style>
