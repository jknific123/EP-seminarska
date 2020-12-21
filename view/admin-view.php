<!DOCTYPE html>
<!-- deaktivacija/aktivacija prodajalcev -->

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Seznam prodajalcev</title>


<h1>Vsi prodajalci</h1>


<table style="width:100%">
    <tr>
        <th> Ime prodajalca</th>
        <th> Priimek prodajalca</th>
        <th> Email</th>
        <th> Naslov</th>
        <th> Vrsta uporabnika</th>
        <th> Aktiviraj </th>
        <th> Deaktiviraj</th>
    </tr>
    <?php foreach($allUsers as $user): ?> <!--izpiši vsako stranko posebej-->
    <tr>
        <td><?= $user["uporabnik_ime"] ?></td>
        <td><?= $user["uporabnik_priimek"] ?> </td>
        <td><?= $user["uporabnik_email"] ?></td>
        <td><?= $user["uporabnik_naslov"] ?></td>
        <td><?= $user["uporabnik_vrsta"] ?></td>
        <td><button>Aktiviraj</button> </td><!-- TODO-->
        <td><button>Deaktiviraj</button> </td><!-- TODO-->
    </tr>
    <?php endforeach; ?>
</table>


<a href="<?= BASE_URL . "sign-in" ?>">Dodaj novega prodajalca</a>

<a href="<?= BASE_URL . "" ?>">Vrni se na prvo stran</a>