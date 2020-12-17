<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Artikel</title>

<h1>Artikel <?= $toy["ime"] ?></h1>

<div>
    <p>Ime: <?= $toy["ime"] ?></p>
    <p>Cena: <?= $toy["cena"] ?> EUR</p>
    <p>Opis: <?= $toy["opis"] ?></p>
    <!--tle dodaj še povezavo na slike izdelka -->
</div>

<?php // else ($uporabnik == "prodajalec") : ?>
    
    <a href="<?= BASE_URL . "toy/edit" ?>"> <button>Uredi artikel </button></a>
    <a href="<?= BASE_URL . "toy/delete" ?>"> <button> Izbriši artikel </button></a> <br>
    
<?php //endif; ?>
    
<a href="<?= BASE_URL . "" ?>"> Vrni se na prvo stran </a>