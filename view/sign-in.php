<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Registracija</title>

<h1>Registracija</h1>

<a href="<?= BASE_URL . "" ?>">Vrni se na prvo stran</a>

<!-- tukaj se uporabnik registrira -->


<?= $form ?>

<?= isset($errorMessage) ? $errorMessage : "" ?>


