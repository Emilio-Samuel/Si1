<?php include_once('session.php'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('headers.html'); ?>
        <title>Historial de compras</title>
    </head>
    <body>

<?php
include("top-menu.php");
include("side-menu.php");
?>

<div class="shopping-history">

<?php
if($_SESSION["logged"]) {
?>

<h1>Bienvenido a su historial de compras</h1>
<table id = "history-table">
    <tr>
        <th>Articulo</th>
        <th>Fecha de compra</th>
        <th>Precio</th>
    </tr>
<?php
    $path = "usuarios/".trim($_SESSION["email"])."/historial.xml";
    $hist = simplexml_load_file($path) or die("Error: Cannot create object: ".$path);
    foreach($hist as $purchase) {
?>

<tr>
    <td>
        <a href="article.php?id=<?php echo $purchase->id; ?>">
            <?php echo $purchase->title; ?>
        </a>
    </td>
    <td><?php echo $purchase->date; ?></td>
    <td><?php echo $purchase->amount; ?></td>
</tr>
<?php
    }
?>
</table>

<?php
} else {
?>
<h1>Inicie sesión para ver su historial.</h1>
<button onclick="window.location='signin.php'">Iniciar sesión</button>
<?php
}
?>
</div>


<?php include("footer.html"); ?>
    </body>
</html>
