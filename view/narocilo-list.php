<!DOCTYPE html>
<!-- vsa pretekla in obstoječa naročila-->

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Vsa naročila</title>

<h1>Vsa naročila</h1>

<table style="width:100%">
    <tr>
        <th> Stranka </th>
        <th> Datum </th>
        <th> Skupna cena</th>
        <th> Potrdi </th>
        <th> Prekliči </th>
        <th> Storniraj </th>
    </tr>
    <?php if ($uporabnik == "stranka"):?>
        <?php foreach($narocilo as $key=> $value):?>
        <?php if ($stranka == $uporabnik): ?> <!--izpisi narocilo le če je od stranke, ki je prijavljena (lahko čekiraš po idju stranke-->
        <tr>
            <td><?php $stranka ?></td>
            <td><?php $datum ?> </td>
            <td><?php $skupnaCena ?> </td>
            <td>Ni na voljo </td><!-- gumb onemogočen -->
            <td>Ni na voljo </td><!-- gumb onemogočen -->
            <td>Ni na voljo </td><!-- gumb onemogočen -->
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
    <?php else : ?> <!--Če je uporabnik prodajalec potem izpiši vsa naročila-->
        <tr>
            <td><?php $stranka ?></td>
            <td><?php $datum ?> </td>
            <td><?php $skupnaCena ?> </td>
            <td><button>Potrdi</button> </td><!-- TODO-->
            <td><button>Prekliči</button> </td><!-- TODO-->
            <td><button>Storniraj</button> </td><!-- TODO-->
        </tr>
    <?php endif; ?>
</table>

<a href="index-trgovina.php"> 
    <button> Vrni se na prvo stran </button>
</a>