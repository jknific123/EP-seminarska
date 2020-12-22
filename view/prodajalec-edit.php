<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Uredi prodajalca</title>

<h1>Uredi prodajalca</h1>


<br> <h3> Spremeni želene atribute </h3>

   <?php //$form TUKI JE TREBA TO FORMO ?>

<?= isset($errorMessage) ? $errorMessage : "" ?>


<?php if ($uporabnik["uporabnik_aktiviran"] == 1) : //je aktiviran? -> ga lahko samo deaktivira cene pa obratno ?>

    <form action="<?= BASE_URL . "admin/deactivate" ?>" method="post" />
    <input type="hidden" name="uporabnik_id" value="<?= $uporabnik["uporabnik_id"] ?>" />
    <button> Deaktiviraj prodajalca </button>
    </form>

<?php elseif ($uporabnik["uporabnik_aktiviran"] != 1) : ?>

    <form action="<?= BASE_URL . "admin/activate" ?>" method="post" />
    <input type="hidden" name="uporabnik_id" value="<?= $uporabnik["uporabnik_id"] ?>" />
    <button> Aktiviraj prodajalca </button>
    </form>

<?php endif; ?>

<br><a href="<?= BASE_URL . "admin" ?>"> Nazaj </a>