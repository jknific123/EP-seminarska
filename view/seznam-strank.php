<!DOCTYPE html>
<!-- prodajalčev pogled na seznam strank -->
<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Seznam uporabnikov</title>


<h1>Vsi uporabniki</h1>



<table style="width:100%">
    <tr>
        <th> Ime stranke</th>
        <th> Priimek stranke</th>
        <th> Email</th>
        <th> Naslov</th>
        <th> Vrsta uporabnika</th>
        <th> Upravljaj stranko </th>
    </tr>
    <?php foreach($allUsers as $user): ?> <!--izpiši vsako stranko posebej-->
    <tr>
        <td><?= $user["uporabnik_ime"] ?></td>
        <td><?= $user["uporabnik_priimek"] ?> </td>
        <td><?= $user["uporabnik_email"] ?></td>
        <td><?= $user["uporabnik_naslov"] ?></td>
        <td><?= $user["uporabnik_vrsta"] ?></td>
        <td><a href="<?= BASE_URL . "stranka/edit?id=" . $user["uporabnik_id"] ?>"><button>Upravljaj stranko</button> </a></td>
    </tr>
    <?php endforeach; ?>
</table>


<a href="<?= BASE_URL . "sign-in" ?>"><button> Dodaj novo stranko </button></a> <!--sign-in.php-->
<a href="<?= BASE_URL . "" ?>"><button> Vrni se na prvo stran </button></a>