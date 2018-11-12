<?php include_once('session.php'); ?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once('headers.html'); ?>
        <title>Iniciar sesión</title>
    </head>
    <body>
<?php

if(isset($_POST["logoff"])) {
    include_once('log-off.php');
}

$flag = 0;
if(isset($_POST["email"])) {
    $sql="select username,email, password from customers where email = '".$_POST["email"]."' and password= '".md5($_POST["password"])."'";
    $query_user = $db->query($sql);
    if(isset($query_user)) {
        
        foreach($query_user as $aux){
            $name = trim($aux["username"]);
            $email = trim($aux["email"]);
            $pwd = trim($aux["password"]);
        }
        $pw = md5($_POST["password"]);
        if($pw === $pwd) {
            $flag = 1;
            $_SESSION["logged"] = true;
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email;
            $_SESSION["cart"] = array();

        } else {
            $flag = 2;
        }
        fclose($user_dat);
    } else {
        $flag = 2;
    }
}
?>

<?php include_once('top-menu.php'); ?>
<?php include_once('side-menu.php'); ?>

<?php 
if($flag == 0 || $flag == 2) {
?>

<div class="register-page">
    <form action="signin.php" method="post">
        <h1>Identificación</h1>
        <?php if($flag == 2) { echo "<p>El email o la contraseña es incorrecto.</p>"; } ?>
        <p>E-mail</p>
        <input type="text" name="email" required>
        <p>Contraseña</p>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name="submitted_login" value="Iniciar sesión">
    </form>
</div>

<?php 
} else { // $flag == 1
?>

<div class="register-page">
    <form action="index.php" method="get">
        <h1>!Bienvenido/a, <?php echo $_SESSION["name"]; ?>!</h1>
        <input type="submit" value="Menú principal">
    </form>
</div>

<?php
}
?>

<?php include_once('footer.html'); ?>

    </body>
</html>
