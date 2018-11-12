<?php include_once('session.php'); ?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once('headers.html'); ?>
        <title>Bluray Stuff</title>
    </head>
    <body>

        <?php include_once('top-menu.php'); ?>
        <?php include_once('side-menu.php'); ?>

        <div id="main">
            <ul id="movies">

<?php

if(empty($_GET["movie"]) && empty($_GET["categoria"])) {
    $i=1;
    $catalogo=simplexml_load_file("catalogo.xml") or die("Error: Cannot create object");
    foreach($catalogo as $movie){
?>
<li>
    <form id = <?php echo $i; ?> action = "article.php" method = "get">
        <input type = "hidden" name="id" value = <?php echo $movie->id; ?>>
        <a href="javascript:{}" onclick="document.getElementById(<?php echo $i?>).submit(); return false;">
            <h3><?php echo $movie->title; ?><h3>
                    <img src = <?php echo "'" .$movie->poster. "'"; ?> alt = " ">
        </a>
    </form>
</li>

<?php
        $i++;
    }

} elseif(!empty($_GET["movie"])) {
    $i=1;
    $catalogo=simplexml_load_file("catalogo.xml") or die("Error: Cannot create object");
    foreach($catalogo as $movie) {
        if(strpos(trim($movie->title),trim($_GET["movie"])) !== false) {
?>

<li>
    <form id = <?php echo $i; ?> action = "article.php" method = "get">
        <input type = "hidden" name="id" value = <?php echo $movie->id; ?>>
        <a href="javascript:{}" onclick="document.getElementById(<?php echo $i?>).submit(); return false;">
            <h3><?php echo $movie->title; ?><h3>
                    <img src = <?php echo "'" .$movie->poster. "'"; ?> alt = " ">
        </a>
    </form>
</li>

<?php
            $i++;
        }
    }
} else {
    $i=1;
    $catalogo=simplexml_load_file("catalogo.xml") or die("Error: Cannot create object");
    foreach($catalogo as $movie) {
        $genre = $movie->xpath('genres/genre');
        foreach($genre as $node) {
            if(strcmp(trim($_GET["categoria"]),trim($node))==0) {
?>

<li>
    <form id = <?php echo $i; ?> action = "article.php" method = "get">
        <input type = "hidden" name="id" value = <?php echo $movie->id; ?>>
        <a href="javascript:{}" onclick="document.getElementById(<?php echo $i?>).submit(); return false;">
            <h3><?php echo $movie->title; ?></h3>
            <img src = <?php echo "'" .$movie->poster. "'"; ?> alt = " ">
        </a>
    </form>
</li>
<?php
                $i++;
            }
        }
    }
}
?>

            </ul>
        </div>

        <?php include_once('footer.html')?>

    </body>
</html>
