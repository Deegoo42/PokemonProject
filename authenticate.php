<?php
// filepath: c:\Users\steph\Downloads\New Compressed (zipped) Folder (2) (1)\Spik_Span\authenticate.php
session_start();

// Replace with actual credentials
$validUsername = 'SpikEnSpan';
$validPassword = 'Vrunj tot de allerbeste runj';

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];

// Validate credentials
if ($username === $validUsername && $password === $validPassword) {
    $_SESSION['loggedin'] = true;
    header('Location: medewerkers-dashboard.php');
    exit();
} else {
    header('Location: medewerkerslogin.php?error=1');
    exit();
}
?>