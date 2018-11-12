<div class="top-menu">
    <a href="index.php">
        <img src="assets/img/bluray-stuff.png" alt="">
        <h1>Bluray-Stuff</h1>
    </a>

<?php
if($_SESSION["logged"] == true){
?>
    <button onclick="window.location='history.php'"><?php echo $_SESSION['name']; ?></button>
    <button onclick="window.location='shopping-cart.php'">Carrito de la compra</button>
    <form action="signin.php" method="post">
        <input type="submit" id="logoff" name="logoff" value="Cerrar sesión">
    </form>

<?php
} else {
?>

    <button onclick="window.location='shopping-cart.php'">Carrito de la compra</button>
    <button onclick="window.location='register.php'">Registro</button>
    <button onclick="window.location='signin.php'">Iniciar Sesión</button>

<?php
}
?>
</div>
