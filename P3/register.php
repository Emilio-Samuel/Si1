<?php include_once('session.php'); ?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include_once('headers.html'); ?>
        <script type="text/javascript" src="scripts/validator.js"></script>
        <title>Registro de usuario</title>
    </head>
    <body>

<?php



if(isset($_POST["email"])) {
    $sql="insert into customers(username, email, password, creditcard) values('".$_POST["name"]."', '".$_POST["email"]."', '".md5($_POST["psw"])."', '".$_POST["card"]."')";
    $query_user = $db->exec($sql);
    $_SESSION["email"] = trim($_POST["email"]);
    $_SESSION["name"] = trim($_POST["name"]);
    $_SESSION["logged"] = true;
    $contrasenna = md5($_POST["psw"]);
}
?>

<?php include('top-menu.php');
include('side-menu.php'); ?>



<div class="register-page">
    <form action="register.php" method="post">

        <h1> Registro de Usuario </h1>
        Nombre:<br>
        <?php echo $sql;?>
        <input id="user" type="text" name="name"><br>
        <span id="disponible"></span><br>
        E-mail:<br>
        <input id="email" type="email" onkeyup="lifeValidator();" name="email"><br>
        Contraseña:<br>
        <input id="pass" type="password" name="psw"><br>
        Repita la contraseña:<br>
        <input id="pass2" type="password" name="pwd2"><br>
        Tarjeta de crédito o débito:<br>
        <input id="card" type="numeric" name="card" ><br>
        <input type= "submit" onclick="return validation();" value = "Enviar" >
    </form>

</div>

        <?php include('footer.html')?>
    </body>
</html>
