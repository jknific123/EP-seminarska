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
    <h2> Dobrodošli v naši trgovini z igračami! </h3>
</div>

<div>
<?php if ($uporabnik == "stranka") : ?>
    <a href="update-my-data.php"> 
        <button> Uredi profil </button>
    </a>
    <a href="narocilo-list.php"> 
        <button> Vsa moja naročila </button>
    </a>
    <a href="narocilo-detail.php"> 
        <button> Košarica </button>
    </a>
    <a href="index-trgovina.php"> 
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a>


<?php elseif ($uporabnik == "prodajalec") : ?>
    <a href="update-my-data.php"> 
        <button> Uredi profil </button>
    </a>
    <a href="narocilo-list.php"> 
        <button> Vsa naročila </button>
    </a>
    <a href="seznam-strank.php"> 
        <button> Vse stranke </button>
    </a>
    <a href="dodaj-artikel.php"> 
        <button> Dodaj nov artikel </button>
    </a>
    <a href="index-trgovina.php"> 
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a>

<?php elseif ($uporabnik == "admin") : ?>
    <a href="update-my-data.php"> 
        <button> Uredi profil </button>
    </a>
    <a href="admin-view.php"> 
        <button> Vsi prodajalci </button>
    </a>
    <a href="index-trgovina.php"> 
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a>


<?php else: ?> <!--anonimni user-->
    <a href="log-in.php"> 
        <button> Prijava </button>
    </a>
    <a href="sign-in.php"> 
        <button> Registracija </button>
    </a>
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