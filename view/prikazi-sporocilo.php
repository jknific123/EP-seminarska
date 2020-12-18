<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Sporočilo</title>

<h1>Sporočilo</h1>

<?php var_dump($message);
echo $message ?>

<?php

//$testPass = "geslo12345";
//$hashanPass = password_hash($testPass, PASSWORD_BCRYPT);
//echo $testPass;  <p> Zgoraj geslo spodaj hash gesla</p>
?>

<?php
//echo $hashanPass;

?>

<form action="<?= BASE_URL . "store" ?>">
    <p><button> Nazaj </button></p>
</form>
