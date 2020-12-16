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
<?php if ($uporabnik == "stranka") : ?>
    <a href="<?= BASE_URL . "my-data" ?>"><button> Uredi profil </button></a> <!--update-my-data.php-->
    <a href="<?= BASE_URL . "order/list" ?>"> <button> Vsa moja naročila </button></a> <!--narocilo-list.php-->
    <a href="<?= BASE_URL . "order" ?>"><button> Košarica </button></a> <!--narocilo-detail.php-->
    <a href="<?= BASE_URL . "" ?>">
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a>


<?php elseif ($uporabnik == "prodajalec") : ?>
    <a href="<?= BASE_URL . "my-data" ?>"><button> Uredi profil </button></a> <!--update-my-data.php-->
    <a href="<?= BASE_URL . "order/list" ?>"> <button> Vsa moja naročila </button></a> <!--narocilo-list.php-->
    <a href="<?= BASE_URL . "users" ?>"> <button> Vse stranke </button></a> <!--seznam-strank.php-->
    <a href="<?= BASE_URL . "toys/add" ?>"> <button> Dodaj nov artikel </button></a> <!--dodaj-artikel.php-->
    <a href="<?= BASE_URL . "" ?>"> 
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a>

<?php elseif ($uporabnik == "admin") : ?>
    <a href="<?= BASE_URL . "my-data" ?>"><button> Uredi profil </button></a> <!--update-my-data.php-->
    <a href="<?= BASE_URL . "admin" ?>"><button> Vsi prodajalci </button></a> <!--admin-view.php-->
    <a href="<?= BASE_URL . "" ?>">
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a>


<?php else: ?> <!--anonimni user-->
    <a href="<?= BASE_URL . "log-in" ?>"><button> Prijava </button></a> <!--log-in.php-->
    <a href="<?= BASE_URL . "sign-in" ?>"><button> Registracija </button></a> <!--sign-in.php-->
<?php endif; ?>
</div>

<div>
<?php foreach($array as $key=>$value):?> <!--loop čez vse artikle - array je tabela vseh artiklov, key je števec -->
    <div>
        <p> Ime izdelka: <?php $name ?> </p>
        <p> Cena izdelka: <?php $cena ?> </p>
        <a href="uredi-artikel.php"> 
            <button> Podrobnosti </button>
        </a>
    </div>

<?php endforeach; ?>
</div>