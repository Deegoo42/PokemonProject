<?php
// filepath: c:\Users\steph\Downloads\New Compressed (zipped) Folder (2) (1)\Spik_Span\logout.php
session_start();
session_destroy();
header('Location: medewerkerslogin.php');
exit();
?>