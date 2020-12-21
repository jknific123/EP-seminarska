<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Vsa neobdelana naročila</title>

<h1>Vsa neobdelana naročila</h1>

<?php //var_dump($narocila); ?>

<?php if (!empty($narocila)):
var_dump($_SESSION["uporabnik"]);
?>

<div id="allApprovedOrders">
    <table style="width:100%">
        <tr>
            <th> ID naročila </th>
            <th> ID uporabnika </th>
            <th> Status naročila </th>
            <th> Postavka </th>
        </tr>
        <?php foreach($narocila as $narocilo): ?> <!--izpiši vsako stranko posebej-->
            <tr>
                <td><?= $narocilo["narocilo_id"] ?></td>
                <td><?= $narocilo["uporabnik_id"] ?> </td>
                <td><?= $narocilo["narocilo_status"] ?></td>
                <td><?= number_format($narocilo["narocilo_postavka"], 2) ?> EUR</td>
                <td><a href="<?= BASE_URL . "order/orderEdit?id=" . $narocilo["narocilo_id"] ?>"> <button> Upravljaj z naročilom </button></a></td>

            </tr>
        <?php endforeach; ?>
    </table>

    <?php
    else :
        echo "Ni oddanih naročil";
    endif;
    ?>
</div>




    <form action="<?= BASE_URL . "store" ?>">
        <p><button> Nazaj </button></p>
    </form>
