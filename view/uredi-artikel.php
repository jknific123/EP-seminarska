<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Artikel</title>

<h1>Artikel</h1>

<div>
    <p> Ime izdelka: <?php $name ?> </p>
    <p> Opis izdelka: <?php $opis ?> </p>
    <p> Cena izdelka: <?php $cena ?> </p>
    <!--tle dodaj še povezavo na slike izdelka -->
</div>

<?php if ($uporabnik == "stranka"): ?>
    <button> Dodaj artikel v košarico </button>
<?php elseif ($uporabnik == "prodajalec") : ?>
    <!-- TODO implementiraj možnost spreminjanja atributov -->
    
    
    
    
    
    
    <button> Izbriši artikel </button> <!--TODO artikel ni več na voljo v trgovini-->
<?php endif; ?>
<a href="index-trgovina.php"> 
    <button> Vrni se na prvo stran </button>
</a>