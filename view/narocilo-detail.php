<!DOCTYPE html>

<!-- Tukaj lahko stranka pregleda in potrdi svojo košarico -->

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Moja košarica</title>

<h1>Moja košarica</h1>

<?php foreach ($array as $key => $value): ?> <!-- isto kot v index-trgovina se strankini artikli izpišejo na enak način-->
    <div>
        <p> Ime izdelka: <?php $name ?> </p>
        <p> Cena izdelka: <?php $cena ?> </p>
        <a href="uredi-artikel.php"> 
            <button> Podrobnosti </button>
        </a> 
        <button>Odstrani artikel iz košarice</button> <!-- TODO: tle je treba zbrisat artikel iz tabele-->
    </div>

<?php endforeach; ?>

<button> Potrdi nakup </button> <!--TODO: naročilo postane vidno prodajalcu-->
<a href="index-trgovina.php"> 
    <button> Vrni se na prvo stran </button>
</a>