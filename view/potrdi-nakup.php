<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Order checkout</title>

<h1>Finish your order</h1>


<?php if (!empty($cart)): ?>

    <div id="order">
        <h3>Vaše naročilo:</h3>
        <?php foreach ($cart as $toy): ?>

            <form>
                <p> <?= $toy["artikel_ime"] ?> <?= $toy["artikel_cena"] ?> &times; <?= $toy["quantity"] ?></p>
            </form>

        <?php endforeach; ?>

        <p>Skupaj: <b><?= number_format($total, 2) ?> EUR</b></p>


        <form action="<?= BASE_URL . "store" ?>" method="post">
            <p><button> Zaključi nakup </button></p>
        </form>
        <form action="<?= BASE_URL . "store" ?>">
            <p><button> Nazaj </button></p>
        </form>
    </div>

<?php endif; ?>