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
    $_SESSION["email"] = trim($_POST["email"]);
    $_SESSION["name"] = trim($_POST["name"]);
    $_SESSION["logged"] = true;

    $carpeta = "./usuarios/".$_POST["email"];
    mkdir($carpeta);
    $ruta ="./usuarios/".$_POST["email"];
    $dat = fopen($ruta."/user.dat", "w");
    $histf = fopen($ruta."/historial.xml","w");

    $contrasenna = md5($_POST["psw"]);
    $saldo = rand(0,100);
    $contenido = $contrasenna.PHP_EOL.$_POST["name"].PHP_EOL.$_POST["email"].PHP_EOL.$saldo.PHP_EOL.$_POST["card"];
    fwrite($dat, $contenido);

    $xmlstr = <<<XML
<?xml version='1.0' encoding='UTF-8'?>
<history>
</history>
XML;

    fwrite($histf, $xmlstr);


    fclose($dat);
    fclose($histf);
}
?>

<?php include('top-menu.php');
include('side-menu.php'); ?>



<div class="register-page">
    <form action="register.php" method="post">

        <h1> Registro de Usuario </h1>
        Nombre:<br>
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
