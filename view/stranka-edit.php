<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Uredi stranko</title>

<h1>Uredi stranko</h1>


<br> <h3> Spremeni želene atribute </h3>

   <?php //$form TUKI JE TRAB TO FORMO ?>

<?= isset($errorMessage) ? $errorMessage : "" ?>


<?php if ($uporabnik["uporabnik_aktiviran"] == 1) : //je aktiviran? -> ga lahko samo deaktivira cene pa obratno ?>

    <form action="<?= BASE_URL . "user/deactivate" ?>" method="post" />
    <input type="hidden" name="uporabnik_id" value="<?= $uporabnik["uporabnik_id"] ?>" />
    <button> Deaktiviraj stranko </button>
    </form>

<?php elseif ($uporabnik["uporabnik_aktiviran"] != 1) : ?>

    <form action="<?= BASE_URL . "user/activate" ?>" method="post" />
    <input type="hidden" name="uporabnik_id" value="<?= $uporabnik["uporabnik_id"] ?>" />
    <button> Aktiviraj stranko </button>
    </form>

<?php endif; ?>

<br><a href="<?= BASE_URL . "users" ?>"> Nazaj </a>