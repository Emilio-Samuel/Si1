<?php include_once('session.php'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('headers.html'); ?>
        <title>Carrito de la compra</title>
    </head>
    <body>

<?php
include('top-menu.php');
include('side-menu.php');

if(isset($_POST["finalizar"])) {
    if(isset($_SESSION["email"])) {
        $path = "usuarios/".trim($_SESSION["email"])."/user.dat";
        $userdat = fopen($path, "r");
        // this HORRIBLE THING we have to do without databases
        $saldo = fgets($userdat);
        $saldo = fgets($userdat);
        $saldo = fgets($userdat);
        $saldo = fgets($userdat);
        if($_POST["total"] > $saldo) {
            echo "<h1>No tienes suficiente saldo para finalizar la compra:".$saldo."</h1>";
        } else {
            //TODO: leer los items y meter en el historial
            $_SESSION["cart"] = array();
        }
    }
}

if(isset($_POST["BorrarUd"])) {
    if($_SESSION["cart"][$_POST["id"]]==1) {
        unset($_SESSION["cart"][$_POST["id"]]);
    }
    else {
        $_SESSION["cart"][$_POST["id"]]-=1;
    }
}

?>

<div class = "shopping-history">
    <h1> Carrito de la compra: </h1>
    <table id = "history-table">
        <tr><th>Articulo</th><th>Precio</th><th>Unidades</th><th>Eliminar</th></tr>
<?php
$catalogo = simplexml_load_file("catalogo.xml");
foreach($_SESSION["cart"] as $item=>$amount) {
    foreach($catalogo as $movie) {
        if($movie->id==$item) {
?>

        <tr>
            <td><img src=<?php echo "'".$movie->poster."'"; ?>></td>
            <td><?php echo $movie->price;?></td>
            <td><?php echo $amount; ?></td>
            <td>
                <form action="shopping-cart.php" method="post">
                    <input type="hidden" name="id" value=<?php echo "'".$movie->id."'";?>>
                    <input type="submit" name="BorrarUd" value="Eliminar">
                </form>
            </td>
        </tr>

<?php
            $total += $movie->price;
        }
    }
}
?>

    </table>
    <form action="shopping-cart.php" method="post">
        <input type="hidden" name="total" value="<?php echo $total; ?>">
        <input type="submit" name="finalizar" value="Finalizar la compra">
    </form>

</div>

<?php include('footer.html'); ?>

    </body>
</html>
