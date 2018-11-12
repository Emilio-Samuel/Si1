<?php include_once('session.php'); ?>

<!DOCTYPE html>
<html>

<?php 

$flag = false;
$catalogo = simplexml_load_file("catalogo.xml") or die("Error: Cannot create object");

$requested_id = $_GET["id"];

// encontramos la película
foreach ($catalogo as $movie) {
    $id = $movie->id;
    if($id == $requested_id) {
        // una vez encontrada, guardamos los datos, no antes
        $flag = true;
        $title = $movie->title;
        $image = $movie->poster;
        $year = $movie->year;
        $description = $movie->description;
    }
}

?>

    <head>
        <?php include_once('headers.html'); ?>
        <title>
        <?php
            if($flag) {
                echo $title." (".$year.")";
            } else {
                echo "Película no encontrada";
            } ?>
        </title>
    </head>

    <body>

<?php

include('top-menu.php');
include('side-menu.php');

if($flag) {
?>

<div class = "description">
    <!-- antes era un link a sign in con un botón -->
    <form action="article.php" method="get">
        <input type="hidden" name="id" value="<?php echo $requested_id;?>">
        <input type="hidden" name="add" value=true>
        <input id="add-basket" type="submit" value="Añadir al carrito">
    </form>
    <h1>
        <?php echo $title; ?>
    </h1>
    <div id="film-description">
        <?php echo "<img src='".$image."' alt='Image not available'/>"; ?>
    </div>
    <div id="text-description">
        <?php echo $description; ?>
    </div>

<?php
}
else {
    echo "<h1>Houston, tenemos un problema</h1>";
}

if(isset($_GET["id"])
    && isset($_GET["add"])
    && $_GET["add"] == true){
    if(array_key_exists($_GET["id"],$_SESSION["cart"])==true){
        $_SESSION["cart"][$_GET["id"]]+=1;
    } else {
        $_SESSION["cart"][$_GET["id"]]=1;
    }
}

?>

</div>

<?php include('footer.html'); ?>

    </body>
</html>
