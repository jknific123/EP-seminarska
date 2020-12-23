<!DOCTYPE html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registracija </title>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <script src="https://www.google.com/recaptcha/api.js?render=6LdXaRIaAAAAACoE4F4PNxD5kAoJJfrGI0DCle92"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('6LdXaRIaAAAAACoE4F4PNxD5kAoJJfrGI0DCle92', { action: 'contact' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>
</head>




<h1>Registracija</h1>


<!-- tukaj se uporabnik registrira -->

<form  method="post">
    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
    <?= $form ?>
</form>


<?= isset($errorMessage) ? $errorMessage : "" ?>

<a href="<?= BASE_URL . "" ?>"> <button> Vrni se na prvo stran </button></a>
