<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Naročilo</title>

<h1>Naročilo:</h1>

<div>

    <p> ID naročila: <?= $narocilo["narocilo_id"] ?></p>
    <p> ID uporabnika: <?= $narocilo["uporabnik_id"] ?></p>
    <p> Naziv uporabnika: <?= $uporabnik["uporabnik_ime"] ?> <?= $uporabnik["uporabnik_priimek"] ?></p>
    <p> Status naročila: <?= $narocilo["narocilo_status"] ?></p>

    <?php if ($narocilo["narocilo_postavka"] != 0) : //narocilo vsebuje artikle?>

    <div id="artikliNaNarocilu">
        <table style="width:100%" border="1">
            <tr>
                <th> ID artikla </th>
                <th> Ime artikla </th>
                <th> Količina </th>
                <th> Cena artikla </th>
            </tr>
            <?php
            //var_dump($artikli);
            foreach($artikelNarocilo as $artikel):
                //var_dump($artikel);
                ?> <!--izpiši vsako stranko posebej-->
                <tr>
                    <td style="text-align: center; vertical-align: middle;"><?= $artikel["artikel_id"] ?></td>
                    <td style="text-align: center; vertical-align: middle;"><?= $artikli[$artikel["artikel_id"]]["artikel_ime"]  ?> </td>
                    <td style="text-align: center; vertical-align: middle;"> <?= $artikel["artikelnarocilo_kolicina"] ?></td>
                    <td style="text-align: center; vertical-align: middle;"><?= number_format( $artikli[$artikel["artikel_id"]]["artikel_cena"] , 2) ?> EUR</td>


                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <p> Postavka: <?= number_format($narocilo["narocilo_postavka"], 2) ?> EUR </p>

    <?php endif; ?>

</div>

<?php if ($narocilo["narocilo_status"] == "v obdelavi" && $_SESSION["uporabnik"]["uporabnik_vrsta"] != "stranka") : //ga potrdi z pritiskom na gumb?>

    <form action="<?= BASE_URL . "order/approve" ?>" method="post" />
    <input type="hidden" name="narocilo_id" value="<?= $narocilo["narocilo_id"] ?>" />
    <button> Potrdi naročilo  </button>
    </form>

    <form action="<?= BASE_URL . "order/discard" ?>" method="post" />
    <input type="hidden" name="narocilo_id" value="<?= $narocilo["narocilo_id"] ?>" />
    <button> Prekliči naročilo </button>
    </form>


<?php endif; ?>

<?php if ($_SESSION["uporabnik"]["uporabnik_vrsta"] != "stranka") : ?>
    <br><a href="<?= BASE_URL . "order/listAllUnapproved" ?>"> <button> Nazaj </button></a>
<?php else : ?>
    <br><a href="<?= BASE_URL . "order/list" ?>"> <button> Nazaj </button></a>
<?php endif; ?>