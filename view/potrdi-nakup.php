<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Zaključi nakup</title>

<h1>Dokončajte vaš nakup</h1>


<?php if (!empty($cart)):
    var_dump($_SESSION["uporabnik"]);
    ?>

    <div id="order">
        <h3>Vaše naročilo:</h3>
        <?php foreach ($cart as $toy): ?>

            <form>
                <p> <?= $toy["artikel_ime"] ?>, <?= number_format($toy["artikel_cena"], 2) ?> EUR  &times; <?= $toy["quantity"] ?></p>
            </form>

        <?php endforeach; ?>

        <p>Skupaj: <b><?= number_format($total, 2) ?> EUR</b></p>


        <form action="<?= BASE_URL . "order/ustvari-narocilo" ?>" method="post">
            <p><button> Zaključi nakup </button></p>
        </form>
        <form action="<?= BASE_URL . "store" ?>">
            <p><button> Nazaj </button></p>
        </form>
    </div>

<?php
    else :
        echo "Košarica je prazna";
    endif;
?>