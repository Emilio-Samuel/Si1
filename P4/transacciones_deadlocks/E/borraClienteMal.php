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

    <?php

        if(!isset($_REQUEST["customerid"]))
        
        {
    ?>
    <form action = "borraClienteMal.php" method = "GET">
        Id del cliente a eliminar:<input type = "numeric" name = "customerid">
        <input type = "submit" value = "Enviar">
    </form>
    
    <?php 
         } else {
            
            try {
                $db = new PDO(DSN,PGUSER,PGPASSWORD);
                $stmt = "delete from orderdetail where orderid in
                   (select orderid from orders where customerid =  ".$_REQUEST["customerid"].")";
                $stmt1 =  "delete from orders where customerid = ".$_REQUEST["customerid"];
                $stmt2 =  "delete from customers where customerid = ".$_REQUEST["customerid"];
                $num_customers = "select count(customers) as numc from customers where customerid = ".$_REQUEST["customerid"]. " group by customerid";
                $num_orders = "select count(orderid) as numor from orders where customerid = ".$_REQUEST["customerid"]." group by customerid";
                $num_orderdetails = "select count(orderid) as numod from orderdetail where orderid in 
					(select orderid from orders where customerid =  ".$_REQUEST["customerid"].")";





                $db->beginTransaction();
                
                /*Eliminacion de las orderdetail*/
               
                $salida = $db->exec($stmt);
                echo "Eliminando las orderdetail del cliente... <p>";
                if($salida === False){
					
                    echo "El borrado del detalle de las ordenes del usuario con id = ".$_REQUEST["customerid"]." no ha sido completado.  <p>";
                    $aux = $db->query($num_orderdetails);
                    if ($aux == null){
							echo "Hay 0 elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado de los detalles de sus ordenes.<p> ";
					}
                    else{
						foreach($aux as $line){
							echo "Hay ".$line["numod"]." elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado de los detalles de sus ordenes.<p> ";
						}
					}
                    $aux = $db->query($num_orders);
                    if ($aux == null){
							echo "Hay 0 pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado.<p>";
					}
                    else{
						foreach($aux as $line){
							echo "Hay ".$line["numor"]." pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado.<p>";
						}
					}
                    $aux = $db->query($num_customers);
                    if ($aux == null){
							echo "Hay 0 clientes con id = ".$_REQUEST["customerid"]."tras el intento de borrado. <p>";
					}
                    else{
						foreach($aux as $line){
							echo "Hay ".$line["numc"]." clientes con id = ".$_REQUEST["customerid"]."tras el intento de borrado. <p>";
						}
					}
                    $db->rollBack();
                    $aux = $db->query($num_orderdetails);
					if ($aux == null){
							echo "Hay 0 elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback.<p> ";
					}
					else{
						foreach($aux as $line){
							echo "Hay ".$line["numod"]." elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback. <p>";
						}
					}
					$aux = $db->query($num_orders);
					if ($aux == null){
							echo "Hay 0 pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback.<p>";
					}
					else{
						foreach($aux as $line){
							echo "Hay ".$line["numor"]." pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback.<p>";
						}
					}
					$aux = $db->query($num_customers);
					if ($aux == null){
							echo "Hay 0 clientes con id = ".$_REQUEST["customerid"]."tras el rollback. <p>";
					}
					else{
						foreach($aux as $line){
							echo "Hay ".$line["numc"]." clientes con id = ".$_REQUEST["customerid"]."tras el rollback. <p>";
						}
					}
                    die();

                }
                echo "Se han eliminado los orderdetail del cliente correctamente <p>";
				$aux = $db->query($num_orderdetails);
				if ($aux == null){
						echo "Hay 0 elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado de los elementos ordenados por el cliente.<p> ";
				}
				else{
					foreach($aux as $line){
						echo "Hay ".$line["numod"]." elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado de los elementos ordenados por el cliente. <p>";
					}
				}
				$aux = $db->query($num_orders);
				if ($aux == null){
						echo "Hay 0 pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado de los elementos ordenados por el cliente.<p>";
				}
				else{
					foreach($aux as $line){
						echo "Hay ".$line["numor"]." pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado de los elementos ordenados por el cliente.<p>";
					}
				}
				$aux = $db->query($num_customers);
				if ($aux == null){
						echo "Hay 0 clientes con id = ".$_REQUEST["customerid"]."tras el borrado de los elementos ordenados por el cliente. <p>";
				}
				else{
					foreach($aux as $line){
						echo "Hay ".$line["numc"]." clientes con id = ".$_REQUEST["customerid"]."tras el borrado de los elementos ordenados por el cliente. <p>";
					}
				}


				/*Eliminacion del cliente*/

				echo "Eliminando al cliente... <p>";
                $salida2 = $db->exec($stmt2);
                if($salida2 === False){
                    echo "El borrado del usuario con id = ".$_REQUEST["customerid"]." no ha sido completado.  <p>";
                    $aux = $db->query($num_orderdetails);
                    if ($aux == null){
							echo "Hay 0 elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado del cliente.<p> ";
					}
                    else{
						foreach($aux as $line){
							echo "Hay ".$line["numod"]." elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado del cliente.<p> ";
						}
					}
                    $aux = $db->query($num_orders);
                    if ($aux == null){
							echo "Hay 0 pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado del cliente.<p>";
					}
                    else{
						foreach($aux as $line){
							echo "Hay ".$line["numor"]." pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado del cliente.<p>";
						}
					}
                    $aux = $db->query($num_customers);
                    if ($aux == null){
							echo "Hay 0 clientes con id = ".$_REQUEST["customerid"]."tras el intento de borrado del cliente. <p>";
					}
                    else{
						foreach($aux as $line){
							echo "Hay ".$line["numc"]." clientes con id = ".$_REQUEST["customerid"]."tras el intento de borrado del cliente. <p>";
						}
					}
                    $db->rollBack();
                    $aux = $db->query($num_orderdetails);
					if ($aux == null){
							echo "Hay 0 elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback.<p> ";
					}
					else{
						foreach($aux as $line){
							echo "Hay ".$line["numod"]." elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback. <p>";
						}
					}
					$aux = $db->query($num_orders);
					if ($aux == null){
							echo "Hay 0 pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback.<p>";
					}
					else{
						foreach($aux as $line){
							echo "Hay ".$line["numor"]." pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback.<p>";
						}
					}
					$aux = $db->query($num_customers);
					if ($aux == null){
							echo "Hay 0 clientes con id = ".$_REQUEST["customerid"]."tras el rollback. <p>";
					}
					else{
						foreach($aux as $line){
							echo "Hay ".$line["numc"]." clientes con id = ".$_REQUEST["customerid"]."tras el rollback. <p>";
						}
					}
                    die();

                }
				echo "El cliente se ha eliminado correctamente <p>";
				$aux = $db->query($num_orderdetails);
				if ($aux == null){
						echo "Hay 0 elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado del cliente.<p> ";
				}
				else{
					foreach($aux as $line){
						echo "Hay ".$line["numod"]." elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado del cliente. <p>";
					}
				}
				$aux = $db->query($num_orders);
				if ($aux == null){
						echo "Hay 0 pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado del cliente.<p>";
				}
				else{
					foreach($aux as $line){
						echo "Hay ".$line["numor"]." pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado del cliente.<p>";
					}
				}
				$aux = $db->query($num_customers);
				if ($aux == null){
						echo "Hay 0 clientes con id = ".$_REQUEST["customerid"]."tras el borrado del cliente. <p>";
				}
				else{
					foreach($aux as $line){
						echo "Hay ".$line["numc"]." clientes con id = ".$_REQUEST["customerid"]."tras el borrado del cliente. <p>";
					}
				}

 
 
 
				/*Eliminacion de las order*/
				echo "Eliminando las ordenes del cliente... <p>";
                $salida1 = $db->exec($stmt1);
                print($salida1);
                if($salida1 === False){
                    echo "El borrado de las ordenes del usuario con id = ".$_REQUEST["customerid"]." no ha sido completado.  <p>";
                    $aux = $db->query($num_orderdetails);
                    if ($aux == null){
							echo "Hay 0 elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado de las ordenes del del cliente.<p> ";
					}
                    else{
						foreach($aux as $line){
							echo "Hay ".$line["numod"]." elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado de las ordenes del cliente.<p> ";
						}
					}
                    $aux = $db->query($num_orders);
                    if ($aux == null){
							echo "Hay 0 pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado de las ordenes del cliente.<p>";
					}
                    else{
						foreach($aux as $line){
							echo "Hay ".$line["numor"]." pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el intento de borrado de las ordenes del cliente.<p>";
						}
					}
                    $aux = $db->query($num_customers);
                    if ($aux == null){
							echo "Hay 0 clientes con id = ".$_REQUEST["customerid"]."tras el intento de borrado de las ordenes del cliente. <p>";
					}
                    else{
						foreach($aux as $line){
							echo "Hay ".$line["numc"]." clientes con id = ".$_REQUEST["customerid"]."tras el intento de borrado de las ordenes del cliente. <p>";
						}
					}
                    $db->rollBack();
                    $aux = $db->query($num_orderdetails);
					if ($aux == null){
							echo "Hay 0 elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback.<p> ";
					}
					else{
						foreach($aux as $line){
							echo "Hay ".$line["numod"]." elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback. <p>";
						}
					}
					$aux = $db->query($num_orders);
					if ($aux == null){
							echo "Hay 0 pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback.<p>";
					}
					else{
						foreach($aux as $line){
							echo "Hay ".$line["numor"]." pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el rollback.<p>";
						}
					}
					$aux = $db->query($num_customers);
					if ($aux == null){
							echo "Hay 0 clientes con id = ".$_REQUEST["customerid"]."tras el rollback. <p>";
					}
					else{
						foreach($aux as $line){
							echo "Hay ".$line["numc"]." clientes con id = ".$_REQUEST["customerid"]."tras el rollback. <p>";
						}
					}
                    die();

                }
				echo "Se han eliminado las ordenes del cliente correctamente <p>";
				$aux = $db->query($num_orderdetails);
				if ($aux == null){
						echo "Hay 0 elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado de las ordenes del cliente.<p> ";
				}
				else{
					foreach($aux as $line){
						echo "Hay ".$line["numod"]." elementos pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado de las ordenes del cliente. <p>";
					}
				}
				$aux = $db->query($num_orders);
				if ($aux == null){
						echo "Hay 0 pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado de las ordenes del cliente.<p>";
				}
				else{
					foreach($aux as $line){
						echo "Hay ".$line["numor"]." pedidos por el cliente con id = ".$_REQUEST["customerid"]."tras el borrado de las ordenes del cliente.<p>";
					}
				}
				$aux = $db->query($num_customers);
				if ($aux == null){
						echo "Hay 0 clientes con id = ".$_REQUEST["customerid"]."tras el borrado de las ordenes del cliente. <p>";
				}
				else{
					foreach($aux as $line){
						echo "Hay ".$line["numc"]." clientes con id = ".$_REQUEST["customerid"]."tras el borrado de las ordenes del cliente. <p>";
					}
				}
                $db->commit();
                print("Cliente eliminado correctamente");
            }
            catch(Exception $e){
                print("Error:".$e->getMessage());

            }
            $db=null;
        }
    ?> 
    </body>
</html>


