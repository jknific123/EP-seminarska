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
    <?php if (isset($_SESSION["uporabnik"]) && $_SESSION["uporabnik"]["uporabnik_vrsta"] == "stranka") :
    var_dump($_SESSION["uporabnik"]);
    ?>
    <p> Stranka: </p>
    <a href="<?= BASE_URL . "my-data" ?>"><button> Uredi profil </button></a> <!--update-my-data.php-->
    <a href="<?= BASE_URL . "order/list" ?>"> <button> Vsa moja naročila </button></a> <!--narocilo-list.php-->
    <a href="<?= BASE_URL . "order" ?>"><button> Košarica </button></a> <!--narocilo-detail.php-->
    <a href="<?= BASE_URL . "log-out" ?>">
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a>
    <br>

    <?php elseif (isset($_SESSION["uporabnik"]) && $_SESSION["uporabnik"]["uporabnik_vrsta"] == "prodajalec") : ?>
    <p> Prodajalec </p>
    <a href="<?= BASE_URL . "my-data" ?>"><button> Uredi profil </button></a> <!--update-my-data.php-->
    <a href="<?= BASE_URL . "order/list" ?>"> <button> Vsa moja naročila </button></a> <!--narocilo-list.php-->
    <a href="<?= BASE_URL . "users" ?>"> <button> Vse stranke </button></a> <!--seznam-strank.php-->
    <a href="<?= BASE_URL . "toy/add" ?>"> <button> Dodaj nov artikel </button></a> <!--dodaj-artikel.php-->
    <a href="<?= BASE_URL . "" ?>"> 
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a> <br>
<!--
    <?php elseif (isset($_SESSION["uporabnik"]) && $_SESSION["uporabnik"]["uporabnik_vrsta"] == "admin") : ?>-->
    <p> Admin </p>
    <a href="<?= BASE_URL . "my-data" ?>"><button> Uredi profil </button></a> <!--update-my-data.php-->
    <a href="<?= BASE_URL . "admin" ?>"><button> Vsi prodajalci </button></a> <!--admin-view.php-->
    <a href="<?= BASE_URL . "" ?>">
        <button> Odjava </button> <!--treba spremenit uporabnika nazaj na anonimnega userja -->
    </a>
    <br>
    <?php else: ?>
    <p> Anonimni uporabnik </p>
    <a href="<?= BASE_URL . "log-in" ?>"><button> Prijava </button></a> <!--log-in.php-->
    <a href="<?= BASE_URL . "sign-in" ?>"><button> Registracija </button></a> <!--sign-in.php-->
<!--<?php endif; ?>-->
</div>

<div id="main">
<?php foreach ($toys as $toy): ?><!--loop čez vse artikle -->
    <div class="toy">
        <form action="<?= BASE_URL . "store/add-to-cart" ?>" method="post" />
        <input type="hidden" name="artikel_id" value="<?= $toy["artikel_id"] ?>" />
        <p> Ime izdelka: <?= $toy["artikel_ime"] ?> </p>
        <p> Cena izdelka: <?= number_format($toy["artikel_cena"], 2) ?> EUR </p>
        <button> Dodaj v košarico </button>
        </form>
        <a href="<?= BASE_URL . "toy?id=" . $toy["artikel_id"] ?>"><button> Podrobnosti </button></a> <!--uredi-artikel.php-->
    </div>

<?php endforeach; ?>
</div>


<!--koda za vozicek-->
<?php //var_dump($cart); ?>
<?php if (!empty($cart)): ?>

    <div id="cart">
        <h3>Košarica</h3>
        <?php foreach ($cart as $toy): ?>

            <form action="<?= BASE_URL . "store/update-cart" ?>" method="post">
                <input type="hidden" name="artikel_id" value="<?= $toy["artikel_id"] ?>" />
                <input type="number" name="quantity" value="<?= $toy["quantity"] ?>" class="update-cart" />
                &times; <?= $toy["artikel_ime"] ?>
                <button>Posodobi</button>
            </form>

        <?php endforeach; ?>

        <p>Skupaj: <b><?= number_format($total, 2) ?> EUR</b></p>

        <form action="<?= BASE_URL . "store/purge-cart" ?>" method="post">
            <p><button>Izprazni košarico</button></p>
        </form>
        <form action="<?= BASE_URL . "store/potrdi-nakup" ?>" method="post">
            <p><button> Potrdi nakup </button></p>
        </form>
    </div>

<?php endif; ?>
