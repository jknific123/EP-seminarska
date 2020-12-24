<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Prijava</title>


<!-- prijava že uporabnika, ki je že v bazi -->

<h1>Prijava</h1>

<?= $form ?>

<?= isset($errorMessage) ? $errorMessage : "" ?>

<form action="<?= BASE_URL . "" ?>">
    <button> Nazaj </button>
</form>