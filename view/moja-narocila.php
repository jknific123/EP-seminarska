<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Moja naročila</title>

<h1>Moja naročila</h1>

<?php var_dump($narocila); ?>


<?php if (!empty($narocila)):
var_dump($_SESSION["uporabnik"]);
?>
<table style="width:100%" border="1" >
    <tr>
        <th> ID naročila</th>
        <th> ID uporabnika</th>
        <th> Status naročila</th>
        <th> Postavka naročila</th>
    </tr>
    <?php foreach ($narocila as $narocilo): ?>
        <tr>
            <td style="text-align: center; vertical-align: middle;"><?= $narocilo["narocilo_id"]?></td>
            <td style="text-align: center; vertical-align: middle;"><?= $narocilo["uporabnik_id"] ?> </td>
            <td style="text-align: center; vertical-align: middle;"><?= $narocilo["narocilo_status"] ?></td>
            <td style="text-align: center; vertical-align: middle;"><?= number_format($narocilo["narocilo_postavka"], 2) ?> EUR</td>
        </tr>
    <?php endforeach; ?>
</table>


<?php
else :
    echo "Niste še oddali naročil";
endif;
?>


<form action="<?= BASE_URL . "store" ?>">
    <p><button> Nazaj </button></p>
</form>
