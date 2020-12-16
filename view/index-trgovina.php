<!DOCTYPE html>
    <!-- seznam vseh izdelkov - prva stran za vse uporabnike - tudi anonimnega -->
    <!--TODO potrebujem spremenljivko $uporabnik, ki ima lahko vrednost: stranka, prodajalec, admin in drugo -->
    <!-- TODO: treba je popravit odjavo pri uporabnikih-->
    <!--TODO: treba je pripravit tabelo artiklov z atributi $name in $cena za posamezen artikel-->
    
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Spletna trgovina igrač</title>

<div> 
    <h1>Spletna trgovina igrač</h1>
    <h2> Dobrodošli v naši trgovini z igračami! </h2>
</div>

<div>
    <?php //if ($uporabnik == "stranka") : ?>
    <p> Stranka: </p>
    <a href="<?= BASE_URL . "my-data" ?>"><button> Uredi profil </button></a> <!--update-my-data.php-->
    <a href="<?= BASE_URL . "order/list" ?>"> <button> Vsa moja naročila </button></a> <!--narocilo-list.php-->
    <a href="<?= BASE_URL . "order" ?>"><button> Košarica </button></a> <!--narocilo-detail.php-->
    <a href="<?= BASE_URL . "" ?>">
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a>
    <br>

<!--<?php //elseif ($uporabnik == "prodajalec") : ?>-->
<p> Prodajalec </p>
    <a href="<?= BASE_URL . "my-data" ?>"><button> Uredi profil </button></a> <!--update-my-data.php-->
    <a href="<?= BASE_URL . "order/list" ?>"> <button> Vsa moja naročila </button></a> <!--narocilo-list.php-->
    <a href="<?= BASE_URL . "users" ?>"> <button> Vse stranke </button></a> <!--seznam-strank.php-->
    <a href="<?= BASE_URL . "toys/add" ?>"> <button> Dodaj nov artikel </button></a> <!--dodaj-artikel.php-->
    <a href="<?= BASE_URL . "" ?>"> 
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a> <br>
    <p> Admin </p>
<!--<?php //elseif ($uporabnik == "admin") : ?>-->
    <a href="<?= BASE_URL . "my-data" ?>"><button> Uredi profil </button></a> <!--update-my-data.php-->
    <a href="<?= BASE_URL . "admin" ?>"><button> Vsi prodajalci </button></a> <!--admin-view.php-->
    <a href="<?= BASE_URL . "" ?>">
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a>
    <br>
    <p> Anonimni </p>
<!--<?php //else: ?> anonimni user-->
    <a href="<?= BASE_URL . "log-in" ?>"><button> Prijava </button></a> <!--log-in.php-->
    <a href="<?= BASE_URL . "sign-in" ?>"><button> Registracija </button></a> <!--sign-in.php-->
<!--<?php //endif; ?>-->
</div>

<div id="main">
<?php foreach ($toys as $toy): ?><!--loop čez vse artikle -->
    <div class="toy">
        <p> Ime izdelka: <?= $toy["artikel_ime"] ?> </p>
        <p> Cena izdelka: <?= number_format($toy["artikel_cena"], 2) ?> EUR </p>
        <a href="<?= BASE_URL . "toys/edit" ?>"><button> Podrobnosti </button></a> <!--uredi-artikel.php-->
    </div>

<?php endforeach; ?>
</div>
