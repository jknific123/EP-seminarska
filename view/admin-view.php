<!DOCTYPE html>
<!-- deaktivacija/aktivacija prodajalcev -->

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Seznam prodajalcev</title>


<h1>Vsi prodajalci</h1>


<table style="width:100%">
    <tr>
        <th> Ime prodajalca</th>
        <th> Priimek prodajalca </th>
        <th> Email</th>
        <th> Aktiviraj </th>
        <th> Deaktiviraj</th>
    </tr>
    <?php foreach($prodajalec as $key=>$value): ?> <!--izpiši vsakega prodajalca posebej-->
    <tr>
        <td><?php $name?></td>
        <td><?php $priimek ?> </td>
        <td><?php $email ?> </td>
        <td><button>Aktiviraj</button> </td><!-- TODO-->
        <td><button>Deaktiviraj</button> </td><!-- TODO-->
    </tr>
    <?php endforeach; ?>
</table>


<a href="<?= BASE_URL . "sign-in" ?>">Dodaj novega prodajalca</a>

<a href="<?= BASE_URL . "" ?>">Vrni se na prvo stran</a>