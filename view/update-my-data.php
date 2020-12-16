<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Uredi moje podatke</title>

<h1>Uredi moje podatke</h1>

<!-- tle lahko admin/prodajalec/user spreminja svoje podatke (ime, priimek, mail ... -->

<?= $form ?>

<?= isset($errorMessage) ? $errorMessage : "" ?>

<a href="<?= BASE_URL . "" ?>">Vrni se na prvo stran</a>