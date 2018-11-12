<aside id="side-menu">

    <!-- Caja de búsqueda -->
    <form action = "index.php" method="get" >
	<input type="text" name="movie" placeholder="Busca tu película">
        <input type = "submit" value = "enviar">
    </form>

    <a href="index.php"><h3>Novedades</h3></a>

    <!-- Filtrar por categoría -->
    <div class="dropdown">
	<h3>Categorías</h3>
	<ul>
	    <li>
		<form id = "accion" action ="index.php" method = "get">
			<input type ="hidden" name = "categoria" value = "Acción">
			<a href="javascript:{}" onclick="document.getElementById('accion').submit(); return false;">
				Acción
			</a>
		</form>
	    </li>
	    <li>
		<form id = "aventura" action ="index.php" method = "get">
			<input type ="hidden" name = "categoria" value = "Aventura">
			<a href="javascript:{}" onclick="document.getElementById('aventura').submit(); return false;">
				Aventura
			</a>
		</form>
	    </li>

	    <li>
		<form id = "CF" action ="index.php" method = "get">
			<input type ="hidden" name = "categoria" value = "Ciencia Ficción">
			<a href="javascript:{}" onclick="document.getElementById('CF').submit(); return false;">
				Ciencia Ficción
			</a>
		</form>
	    </li>

	   <li>
		<form id = "drama" action ="index.php" method = "get">
			<input type ="hidden" name = "categoria" value = "Drama">
			<a href="javascript:{}" onclick="document.getElementById('drama').submit(); return false;">
				Drama
			</a>
		</form>
	    </li>

	</ul>
    </div>

</aside>
