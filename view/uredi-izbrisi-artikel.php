<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Uredi artikel</title>

<h1>Uredi artikel <?= $toy["artikel_ime"] ?></h1>

<div>
    <p> Trenutni parametri: </p>
    <p>Ime: <?= $toy["artikel_ime"] ?></p>
    <p>Cena: <?= $toy["artikel_cena"] ?> EUR</p>
    <p>Opis: <?= $toy["artikel_opis"] ?></p>
    <!--tle dodaj še povezavo na slike izdelka -->
</div>
<br> <h3> Spremeni želene parametre </h3>
   <?= $form ?>

<?= isset($errorMessage) ? $errorMessage : "" ?>

<br><a href="<?= BASE_URL . "" ?>"> Vrni se na prvo stran </a>