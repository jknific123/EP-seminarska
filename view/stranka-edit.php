<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Uredi stranko</title>

<h1>Uredi stranko</h1>


<br> <h3> Spremeni želene atribute </h3>

   <?= $form ?>

<?= isset($errorMessage) ? $errorMessage : "" ?>

<br><a href="<?= BASE_URL . "" ?>"> Vrni se na prvo stran </a>