<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Dodaj artikel</title>

<h1>Dodaj artikel</h1>
<!-- TODO: prodajalec doda artikel v trgovino -->

<?= $form ?>

<?= isset($errorMessage) ? $errorMessage : "" ?>


<a href="<?= BASE_URL . "" ?>">Vrni se na prvo stran</a>