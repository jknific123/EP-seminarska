<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Naročilo</title>

<h1>Naročilo:</h1>

<div>

    <p> ID naročila: <?= $narocilo["narocilo_id"] ?></p>
    <p> ID uporabnika: <?= $narocilo["uporabnik_id"] ?></p>
    <p> Status naročila: <?= $narocilo["narocilo_status"] ?></p>
    <p> Postavka: <?= number_format($narocilo["narocilo_postavka"], 2) ?> EUR </p>

</div>

<?php if ($narocilo["narocilo_status"] == "obdelano"): //ga preklice z pritiskom na gumb?>

    <form action="<?= BASE_URL . "order/storniraj" ?>" method="post" />
    <input type="hidden" name="narocilo_id" value="<?= $narocilo["narocilo_id"] ?>" />
    <button> Storniraj naročilo </button>
    </form>


<?php endif; ?>


<br><a href="<?= BASE_URL . "order/listAllApproved" ?>"> Nazaj </a>