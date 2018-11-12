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
    $topventas_sql = "select id, agno, pelicula, ventas from getTopVentas();";
    $query_ventas = $db->query($topventas_sql);
    foreach($query_ventas as $record) {
?>
<li>
    <form id=<?php echo $record["id"]; ?> action="article.php" method="get">
        <input type="hidden" name="id" value="<?php echo $record["id"]; ?>">
        <a href="javascript:{}" onclick="document.getElementById(<?php echo $record["id"]?>).submit(); return false;">
            <h3><?php echo $record["pelicula"]; ?></h3>
            <img src="assets/img/ghostintheshell.jpg" alt = " ">
        </a>
    </form>
</li>

<?php
    }

} elseif(!empty($_GET["movie"])) {
    $title_sql = "select movieid, movietitle from imdb_movies where movietitle like '%".$_GET["movie"]."%' order by movietitle desc limit 10;";
    $query_title = $db->query($title_sql);
    foreach($query_title as $record) {
?>
<li>
    <form id=<?php echo $record["movieid"]; ?> action="article.php" method="get">
        <input type="hidden" name="id" value="<?php echo $record["movieid"]; ?>">
        <a href="javascript:{}" onclick="document.getElementById(<?php echo $record["movieid"]?>).submit(); return false;">
            <h3><?php echo $record["movietitle"]; ?></h3>
            <img src="assets/img/ghostintheshell.jpg" alt = " ">
        </a>
    </form>
</li>

<?php
    }
} else {
    $normal_sql = "select movieid, movietitle from imdb_movies order by movietitle desc, year desc limit 10;";
    $query_movies = $db->query($normal_sql);
    foreach($query_movies as $record) {
?>
<li>
    <form id=<?php echo $record["movieid"]; ?> action="article.php" method="get">
        <input type="hidden" name="id" value="<?php echo $record["movieid"]; ?>">
        <a href="javascript:{}" onclick="document.getElementById(<?php echo $record["movieid"]?>).submit(); return false;">
            <h3><?php echo $record["movietitle"]; ?></h3>
            <img src="assets/img/ghostintheshell.jpg" alt = " ">
        </a>
    </form>
</li>

<?php
    }
}
?>

            </ul>
        </div>

        <?php include_once('footer.html')?>

    </body>
</html>
