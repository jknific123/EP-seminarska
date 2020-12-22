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
        <th> Aktiviranost prodajalca </th>
    </tr>
    <?php foreach($allUsers as $user): ?> <!--izpiši vsako stranko posebej-->
    <tr>
        <td><?= $user["uporabnik_ime"] ?></td>
        <td><?= $user["uporabnik_priimek"] ?> </td>
        <td><?= $user["uporabnik_email"] ?></td>
        <td><?= $user["uporabnik_naslov"] ?></td>
        <td><?= $user["uporabnik_vrsta"] ?></td>
        <?php if ($user["uporabnik_aktiviran"] == 1) : ?>
        <td> Aktiviran </td>
        <?php elseif ($user["uporabnik_aktiviran"] == 0) : ?>
        <td> Deaktiviran </td>
        <?php endif;?>
        <td><a href="<?= BASE_URL . "admin/edit?id=" . $user["uporabnik_id"] ?>"><button>Upravljaj prodajalca</button> </a></td>
    </tr>
    <?php endforeach; ?>
</table>


<a href="<?= BASE_URL . "sign-in" ?>"><button> Dodaj novega prodajalca </button></a>
<a href="<?= BASE_URL . "" ?>"><button> Vrni se na prvo stran </button></a>