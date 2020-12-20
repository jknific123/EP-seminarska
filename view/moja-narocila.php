<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Moja naročila</title>

<h1>Moja naročila</h1>

<?php var_dump($narocila); ?>

<?php if (!empty($narocila)):
    var_dump($_SESSION["uporabnik"]);
    ?>

    <div id="myOrders">
        <h3>Vaša naročila:</h3>
        <?php foreach ($narocila as $narocilo): ?>

            <form>
                <p> narocilo_id: <?= $narocilo["narocilo_id"]  ?>, uporabnik_id: <?= $narocilo["uporabnik_id"]  ?>, narocilo_status: <?= $narocilo["narocilo_status"]  ?>, narocilo_postavka: <?= number_format($narocilo["narocilo_postavka"], 2) ?> EUR </p>
            </form>

        <?php endforeach; ?>

<?php
else :
    echo "Niste še oddali naročil";
endif;
?>


<form action="<?= BASE_URL . "store" ?>">
    <p><button> Nazaj </button></p>
</form>
