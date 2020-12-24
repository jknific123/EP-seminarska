<!DOCTYPE html>
<!-- prodajalčev pogled na seznam strank -->
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Seznam uporabnikov</title>


<h1>Vsi uporabniki</h1>



<table style="width:100%" border="1">
    <tr>
        <th> Ime stranke</th>
        <th> Priimek stranke</th>
        <th> Email</th>
        <th> Naslov</th>
        <th> Vrsta uporabnika</th>
        <th> Aktiviranost stranke </th>
        <th> Podrobnosti stranke </th>
    </tr>
    <?php foreach($allUsers as $user): ?> <!--izpiši vsako stranko posebej-->
    <tr>
        <td style="text-align: center; vertical-align: middle;"><?= $user["uporabnik_ime"] ?></td>
        <td style="text-align: center; vertical-align: middle;"><?= $user["uporabnik_priimek"] ?> </td>
        <td style="text-align: center; vertical-align: middle;"><?= $user["uporabnik_email"] ?></td>
        <td style="text-align: center; vertical-align: middle;"><?= $user["uporabnik_naslov"] ?></td>
        <td style="text-align: center; vertical-align: middle;"><?= $user["uporabnik_vrsta"] ?></td>
        <?php if ($user["uporabnik_aktiviran"] == 1) : ?>
        <td style="text-align: center; vertical-align: middle;"> Aktivirana </td>
        <?php elseif ($user["uporabnik_aktiviran"] == 0) : ?>
        <td style="text-align: center; vertical-align: middle;"> Deaktivirana </td>
        <?php endif;?>
        <td style="text-align: center; vertical-align: middle;"><a href="<?= BASE_URL . "user/edit?id=" . $user["uporabnik_id"] ?>"><button>Upravljaj stranko</button> </a></td>
    </tr>
    <?php endforeach; ?>
</table>


<a href="<?= BASE_URL . "sign-in" ?>"><button> Dodaj novo stranko </button></a> <!--sign-in.php-->
<a href="<?= BASE_URL . "" ?>"><button> Nazaj </button></a>