<!DOCTYPE html>
<!-- deaktivacija/aktivacija prodajalcev -->

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Seznam prodajalcev</title>


<h1>Vsi prodajalci</h1>


<table style="width:100%" border="1">
    <tr>
        <th> Ime prodajalca</th>
        <th> Priimek prodajalca</th>
        <th> Email</th>
        <th> Naslov</th>
        <th> Vrsta uporabnika</th>
        <th> Aktiviranost prodajalca </th>
        <th> Podrobnosti prodajalca </th>
    </tr>
    <?php foreach($allUsers as $user): ?> <!--izpiši vsako stranko posebej-->
    <tr>
        <td style="text-align: center; vertical-align: middle;"><?= $user["uporabnik_ime"] ?></td>
        <td style="text-align: center; vertical-align: middle;"><?= $user["uporabnik_priimek"] ?> </td>
        <td style="text-align: center; vertical-align: middle;"><?= $user["uporabnik_email"] ?></td>
        <td style="text-align: center; vertical-align: middle;"><?= $user["uporabnik_naslov"] ?></td>
        <td style="text-align: center; vertical-align: middle;"><?= $user["uporabnik_vrsta"] ?></td>
        <?php if ($user["uporabnik_aktiviran"] == 1) : ?>
        <td style="text-align: center; vertical-align: middle;"> Aktiviran </td>
        <?php elseif ($user["uporabnik_aktiviran"] == 0) : ?>
        <td style="text-align: center; vertical-align: middle;"> Deaktiviran </td>
        <?php endif;?>
        <td style="text-align: center; vertical-align: middle;"><a href="<?= BASE_URL . "admin/edit?id=" . $user["uporabnik_id"] ?>"><button>Upravljaj prodajalca</button> </a></td>
    </tr>
    <?php endforeach; ?>
</table>


<a href="<?= BASE_URL . "sign-in" ?>"><button> Dodaj novega prodajalca </button></a>
<a href="<?= BASE_URL . "" ?>"><button> Nazaj </button></a>