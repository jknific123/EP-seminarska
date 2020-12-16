<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Toystore</title>

<h1>Toystore</h1>


<div id="main">
    <?php var_dump($toys);?>
    <?php foreach ($toys as $toy): ?>

        <div class="toy">
            <form action="<?= BASE_URL . "store/add-to-cart" ?>" method="post" />
            <input type="hidden" name="artikel_id" value="<?= $toy["artikel_id"] ?>" />
            <p><?= $toy["artikel_ime"] ?></p>
            <p><?= $toy["artikel_opis"] ?> </p>
            <p><?= number_format($toy["artikel_cena"], 2) ?> EUR<br/>
                <button>Add to cart</button>
                </form>
        </div>

    <?php endforeach; ?>

</div>

<?php if (!empty($cart)): ?>

    <div id="cart">
        <h3>Shopping cart</h3>
        <?php foreach ($cart as $toy): ?>

            <form action="<?= BASE_URL . "store/update-cart" ?>" method="post">
                <input type="hidden" name="id" value="<?= $toy["artikel_id"] ?>" />
                <input type="number" name="quantity" value="<?= $toy["quantity"] ?>" class="update-cart" />
                &times; <?= $toy["artikel_ime"] ?>
                <button>Update</button>
            </form>

        <?php endforeach; ?>

        <p>Total: <b><?= number_format($total, 2) ?> EUR</b></p>

        <form action="<?= BASE_URL . "store/purge-cart" ?>" method="post">
            <p><button>Purge cart</button></p>
        </form>
    </div>

<?php endif; ?>