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
        <th> Aktiviraj </th>
        <th> Deaktiviraj</th>
    </tr>
    <?php foreach($stranka as $key=>$value): ?> <!--izpiši vsako stranko posebej-->
    <tr>
        <td><?php $name?></td>
        <td><?php $priimek ?> </td>
        <td><?php $email ?> </td>
        <td><button>Aktiviraj</button> </td><!-- TODO-->
        <td><button>Deaktiviraj</button> </td><!-- TODO-->
    </tr>
    <?php endforeach; ?>
</table>

<a href="sign-in.php">
    <button>Dodaj novo stranko</button>
</a>
<a href="index-trgovina.php"> 
    <button> Vrni se na prvo stran </button>
</a>