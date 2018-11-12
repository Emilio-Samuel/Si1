<?php
define("PGUSER", "alumnodb");
define("PGPASSWORD", "alumnodb");
define("DSN","pgsql:host=localhost;dbname=si1;options='--client_encoding=UTF8'");
?>

<html>
  <head>
    <title>Lista clientes por mes</title>
      <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
      <style type="text/css">
        table {
                border-style: none;
                border-collapse: collapse;
        }
        table th {
                border-width: 1px;
                padding: 1px;
                border-style: solid;
                border-color: gray;
                background-color: rgb(230, 230, 220);
        }
        table td {
                border-width: 1px;
                padding: 1px;
                border-style: solid;
                border-color: gray;
                background-color: rgb(255, 255, 240);
        }
      </style>
  </head>
  <body>
    <h2>Lista de clientes por mes</h2>

    <?php 
      if (!isset($_REQUEST['fecha'])) { 
    ?>
    <form action="listaClientesMes.php">
      Mes y año: 
      <select name="mes">
        <option value="01">Enero</option>
        <option value="02">Febrero</option>
        <option value="03">Marzo</option>
        <option value="04" selected="selected">Abril</option>
        <option value="05">Mayo</option>
        <option value="06">Junio</option>
        <option value="07">Julio</option>
        <option value="08">Agosto</option>
        <option value="09">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
      </select>
      <select name="anio" value="2009">
        <option value="2017">2017</option>
        <option value="2016">2016</option>
        <option value="2015">2015</option>
        <option value="2014" selected="selected">2014</option>
        <option value="2013">2013</option>
        <option value="2012">2012</option>
        <option value="2011">2011</option>
      </select>
      <h4>Parámetros del listado:</h4>
      <table>
        <tr><td>Umbral mínimo:</td><td><input type="text" name="minimo" value="300"></td></tr>
        <tr><td>Intervalo:</td><td><input type="text" name="intervalo" value="5"></td></tr>
        <tr><td>Número máximo de entradas:</td><td><input type=text name="iter" value="1000"></td></tr>
      </table>
      <br>
      <input type="checkbox" name="prepare">Usar prepare<br>
      <input type="checkbox" name="break0"  checked>Parar si no hay clientes<br>
      <br>
      <input type="submit" name="fecha" value="Enviar">
    </form>

    <?php 
      } else {
        try {
          $db = new PDO(DSN,PGUSER,PGPASSWORD);

          /* consulta 
           */
           
                                   
                    
          // Impresion de resultados en HTML
          echo '<p>Número de clientes distintos con pedidos ';
          echo ' por encima del valor indicado en el mes ';
          echo $_REQUEST['mes'].'/'.$_REQUEST['anio'].'</p>';
          
          $umbral = $_REQUEST['minimo'];
          $use_prepare = isset($_REQUEST['prepare']) ? true : false;
          $break0      = isset($_REQUEST['break0']) ? true : false;
          if ($use_prepare) { 
              /* Preparamos la consulta*/
              $stmt = "select count(distinct customerid) as cc
                        from orders
                        where date_part('year', orderdate)::integer = ".$_REQUEST['anio']."
                        and date_part('month', orderdate)::integer =".$_REQUEST['mes']."
                        and totalamount > :umbral";
              $sth = $db->prepare($stmt);
              $sth->bindParam(':umbral', $umbral, PDO::PARAM_STR);
                           
          }
          
          // Impresion de resultados en HTML
          echo '<table><tr><th>Mayor que (euros)</th><th>Número de clientes</th></tr>';
          $niter = 0;
          $intervalo=$_REQUEST['intervalo'];
          $t0 = microtime(true);
          while($niter < $_REQUEST['iter']) {
            if ($use_prepare) {
              /* ejecución de consulta preparada */
                $sth->execute();
                $linea = $sth->fetch(); 
            }
            else {

                /* ejecución de consulta no preparada*/
                $consulta = "select count(distinct customerid) as cc
                        from orders
                        where date_part('year', orderdate)::integer = ".$_REQUEST['anio']."
                        and date_part('month', orderdate)::integer =".$_REQUEST['mes']."
                        and totalamount > ".$umbral;

                $aux = $db->query($consulta);
                
                $linea = $aux->fetch();
                

            }
            echo '<tr><td>'.$umbral.'</td><td>'.$linea['cc'].'</td></tr>';
            if ($break0 && $linea['cc']==0) break;
            $umbral = $umbral + $intervalo;
            $niter = $niter + 1;
          }
          echo '</table>';
          echo '<p>Tiempo: '.round(1000*(microtime(true)-$t0),2).' ms</p>';
          if ($use_prepare) {
            echo '<p><b>Usando prepare</b></p>';
          }
          
          echo '<p><a href="listaClientesMes.php">Nueva consulta</a></p>';
        } catch (PDOException $e) {
          print "Error!: " . $e->getMessage() . "<br/>";
        }
         
        $db = null;
      }
    ?>
  </body>
</html>

