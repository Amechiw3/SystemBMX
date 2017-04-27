<?php
	class crud
	{
		private $db;

		function __construct($DB_con)
		{
			$this->db = $DB_con;
		}

		/**
		 * Modulo Detalles Para el sistema SistemaBici
		 * Administrador, Usuario
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 *
		 * @Param $idventa llave foranea de la tabla de ventas
		 * @Param $idproducto llave foranea de la tabla de productos
		 * @Param $cantidad cantidad de articulos comprados
		 *
		 * Este metodo recibe tres parametro para que pueda realizar
		 * la insercion de un detalle a la base de datos del sistema
		 * 
		 */
		public function createDetalles($idventa, $idproducto, $cantidad)
		{
			try
			{
				$sql = "INSERT INTO detventas VALUES (NULL, :idventa, :idproducto, :cantidad, 'Activado')";
				$stmt = $this->db->prepare($sql);
				$stmt->bindparam(":idventa", $idventa);
				$stmt->bindparam(":idproducto", $idproducto);
				$stmt->bindparam(":cantidad", $cantidad);
				$stmt->execute();

				return true;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();	
				return false;
			}
		}

		/**
		  *	Modulo Detalles Para el sistema SistemaBici
		  * Administrador, Usuario
		  * @Version 0.00.00
		  * 04.03.2017
		  * @Autor: Martin Fierro Robles
		  *
		  * @Param $id llave primaria de detalles
		  *
		  * Este metodo recibe como parametro la llave primaria de detalles
		  * para que te pueda traer todos los datos de un detalles
		  *	correspondiente al id
		  *
		  * @Return arreglo con todos los datos de un detalle
		  */
		public function getIdDetalles($id)
		{
			$stmt = $this->db->prepare("SELECT * FROM detventas WHERE iddetventa=:id");
			$stmt->execute(array(":id"=>$id));
			$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
			return $editRow;
		}

		/**
		 * Modulo Detalles Para el sistema SistemaBici
		 * Administrador, Usuario
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 *
		 * @Param $iddetventa llave primaria de detalles
		 * @Param $idventa llave foranea de la tabla de ventas
		 * @Param $idproducto llave foranea de la tabla de productos
		 * @Param $cantidad cantidad de articulos comprados
		 *
		 * Este metodo recibe cuatro parametro para que pueda realizar
		 * la actualizacion de un detalle a la base de datos del sistema
		 *
		 */
		public function updateDetalles($iddetventa, $idventa, $idproducto, $cantidad)
		{
			try
			{
				$stmt=$this->db->prepare("UPDATE detventas SET idventa=:idventa, idproducto=:idproducto, cantidad=:cantidad WHERE iddetventa=:iddetventa ");
				$stmt->bindparam(":idventa",$idventa);
				$stmt->bindparam(":idproducto",$idproducto);
				$stmt->bindparam(":cantidad",$cantidad);
				$stmt->bindparam(":iddetventa",$iddetventa);
				$stmt->execute();

				return true;	
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();	
				return false;
			}
		}

		/**
		  * Modulo Detalles Para el sistema SistemaBici
		  * Administrador, Usuario
		  * @Version 0.00.00
		  * 04.03.2017
		  * @Autor: Martin Fierro Robles
		  *
		  * @Param $id llave primaria de detalles
		  *
		  * Este metodo recibe como parametro la llave primaria de detalles
		  * para que pueda realizar la eliminacion de un detalle en 
		  * la base de datos del sistema
		  *
		 */
		public function deleteDetalles($id)
		{
			$stmt = $this->db->prepare("UPDATE detventas SET estado='Desactivado' WHERE iddetventa=:id");
			$stmt->bindparam(":id",$id);
			$stmt->execute();

			return true;
		}

		/**
		  * Modulo Detalles Para el sistema SistemaBici
		  * Administrador, Usuario
		  * @Version 0.00.00
		  * 04.03.2017
		  * @Autor: Martin Fierro Robles
		  *
		  * @Param $query Consulta SQL para poder visualizar los detalles 
		  *
		  * Este metodo nos permite visualizar en forma de tabla a 
		  *	todos los detalles
		  * que se encuentran en el sistema
		  *
		 */
		public function dataviewDetalles($query)
		{
			$stmt = $this->db->prepare($query);
			$stmt->execute();

			if($stmt->rowCount()>0)
			{
				?>
				<table class="table table-hover table-inverse table-sm">
				<thead class='thead-default'>
					<tr>
						<th>ID</th>
						<th>Venta</th>
						<th>Imagen</th>
						<th>Producto</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>estado</th>
						<th align='center'></th>
					</tr>
				</thead>
				<tbody>
				<?php
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					if($row['estado'] == "Desactivado")
					{echo "<tr class='bg-danger'>";}
					else{echo "<tr>";}
					?>
						<th scope="row"><?php echo $row['iddetventa']; ?></th>
						<td><?php echo $row['idventa']; ?></td>
						<td><img class="img-thumbnail img-fluid" src="../model/productos/<?php echo $row['imagen']; ?>" alt="" style="width: 200px;"></td>
						<td><?php echo $row['producto']; ?></td>
						<td><?php echo $row['cantidad']; ?></td>
						<td><?php echo number_format($row['precio'], 2);; ?></td>
						<th><?php echo $row['estado']; ?></th>
						<td align="center">
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo $row['iddetventa']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row['iddetventa']; ?>">Editar <i class="fa fa-pencil"></i></button>
							</a>&nbsp;
							<button class="btn btn-outline-primary" onclick="ConfirmDemo<?php echo $row['iddetventa']; ?>()">
								Eliminar <i class="fa fa-trash"></i>							
								</button>
						</td>
					</tr>
					<tr>
						<td colspan="8">
							<div class="collapse" id="collapse<?php echo $row['iddetventa']; ?>">
								<div class="card card-block card-inverse" style="background-color: #333; border-color: #333;">
								  <?php
								  	$id = $row['iddetventa'];
								  	if (isset($_POST["btnGuardar{$id}"])) 
								  	{
							        $iddetventa = $id;
							        $idventa = $_POST['idventa'];
					            $idproducto = $_POST['idproducto'];
					            $cantidad = $_POST['cantidad'];
							        if ($this->updateDetalles($iddetventa, $idventa, $idproducto, $cantidad)) 
							        {
							         	echo "<script>location.href='detalles.php'</script>";
							        }
							        else
							        {
							         	echo "<script>alert('Hubo un error al guardar el detalle de la venta');</script>";
							        }
							      }
							    ?>
								  <form method="POST">
					            <div class="form-group row"><!-- Venta -->
					              <label for="" class="col-2 col-form-label text-white">Venta</label>
					              <div class="col-10">
					                <select class="form-control" id="idventa" name="idventa" required>
					                  <?php
					                    $sql = "SELECT ve.idventa, CONCAT(us.nomusuario,' ',us.appusuario,' ', us.apmusuario)AS nombreusuario,
					                      ve.fechaventa, ve.totalventa, ve.estado FROM ventas AS ve INNER JOIN usuarios as us
					                      on ve.idusuario = us.idusuario WHERE ve.idventa IN 
					                      (SELECT idventa FROM detventas WHERE iddetventa = {$row['iddetventa']})";
					                      $this->OptionVenta($sql);

					                    $sql = "SELECT ve.idventa, CONCAT(us.nomusuario,' ',us.appusuario,' ', us.apmusuario)AS nombreusuario,
					                      ve.fechaventa, ve.totalventa, ve.estado FROM ventas AS ve INNER JOIN usuarios as us
					                      on ve.idusuario = us.idusuario WHERE ve.idventa NOT IN 
					                      (SELECT idventa FROM detventas WHERE iddetventa = {$row['iddetventa']})";
					                      $this->OptionVenta($sql);                    
					                  ?>
					                </select>
					              </div>
					            </div>
					            <div class="form-group row"><!-- Producto -->
					              <label for="" class="col-2 col-form-label text-white">Producto</label>
					              <div class="col-10">
					                <select class="form-control" id="idproducto " name="idproducto" required>
					                 	<?php
					                    $sql = "SELECT * FROM productos WHERE idproducto in 
					                    (SELECT idproducto FROM detventas WHERE iddetventa = {$row['iddetventa']})";
					                    $this->OptionProductos($sql);

					                    $sql = "SELECT * FROM productos WHERE idproducto NOT IN
					                    (SELECT idproducto FROM detventas WHERE iddetventa = {$row['iddetventa']})";
					                    $this->OptionProductos($sql);                    
					                  ?>
					                </select>
					              </div>
					            </div>
					            <div class="form-group row"><!-- Cantidad -->
					              <label for="" class="col-2 col-form-label text-white">Cantidad</label>
					              <div class="col-10">
					                <input class="form-control" onkeypress="return soloNumeros(event);" type="text" value="<?php echo $row['cantidad']; ?>" id="cantidad" name="cantidad" required>
					              </div>
					            </div>
					            <hr>
					            <div class="form-group row">
					              <div class="col-md-6 col-md-offset-6 text-xs-right">
					                <button type="submit" name="btnGuardar<?php echo $id; ?>" class="btn btn-outline-success">Guardar</button>
					                <a href="tabla?tabla=detalles" class="btn btn-outline-danger">Cancelar</a>
					              </div>
					            </div>
	            		</form>
							    <script type="text/javascript">
										function ConfirmDemo<?php echo $id; ?>() {
											//Ingresamos un mensaje a mostrar
											var mensaje = confirm("¿Esta seguro que quiere eliminar el registro?");
											//Detectamos si el usuario acepto el mensaje
											if (mensaje) {
												location.href='detalles-del.php?id=<?php echo $row['iddetventa']; ?>';
											}
										}
										</script>
								</div>
							</div>
						</td>
					</tr>
					<?php
				}
				?>
				</tbody>
				</table>
				<?php
			}
			else
			{
				?>
				<tr>
				<td>No hay registros...</td>
				</tr>
				<?php
			}
		}

		/**
		  * Modulo Detalles Para el sistema SistemaBici
		  * Administrador, Usuario
		  * @Version 0.00.00
		  * 04.03.2017
		  * @Autor: Martin Fierro Robles
		  *
		  * @Param $query Consulta SQL para poder visualizar los productos 
		  *
		  * Este metodo nos permite visualizar en forma de dropdownlist
		  *	todos los productos que se encuentran en el sistema
		  *
		 */
		public function OptionProductos($query )
		{

	        $stmt = $this->db->prepare($query);
	        $stmt->execute();
	        if($stmt->rowCount() > 0)
	        {
	            while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) 
	            {?>
	                <option value="<?php echo $row['idproducto']; ?>">
	                    <?php echo $row['producto']; ?>
	                </option>
	            <?php
	            }
	        }
		}

		/**
		  * Modulo Detalles Para el sistema SistemaBici
		  * Administrador, Usuario
		  * @Version 0.00.00
		  * 04.03.2017
		  * @Autor: Martin Fierro Robles
		  *
		  * @Param $query Consulta SQL para poder visualizar las ventas
		  *
		  * Este metodo nos permite visualizar en forma de dropdownlist
		  *	todas las ventas que se encuentran en el sistema
		  *
		 */
		public function OptionVenta($query )
		{

	        $stmt = $this->db->prepare($query);
	        $stmt->execute();
	        if($stmt->rowCount() > 0)
	        {
	            while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) 
	            {?>
	                <option value="<?php echo $row['idventa']; ?>">
	                    <?php echo 'Usuario: '.$row['nombreusuario'].' Fecha: '.$row['fechaventa']; ?>
	                </option>
	            <?php
	            }
	        }
		}

		/**
		  * Modulo Detalles Para el sistema SistemaBici
		  * Administrador, Usuario
		  * @Version 0.00.00
		  * 04.03.2017
		  * @Autor: Martin Fierro Robles
		  *
		  * @Param $query Consulta SQL para poder visualizar los detalles
		  *
		  * Este metodo nos permite visualizar en forma de tabla todos
		  * que se encuentran en el sistema
		  *
		 */
		public function dataviewDetallesReporte($query)
		{
			$stmt = $this->db->prepare($query);
			$stmt->execute();

			if($stmt->rowCount()>0)
			{
				echo "<thead class='thead-default'>
				<tr>
					<th>ID</th>
					<th>Venta</th>
					<th>Producto</th>
					<th>Cantidad</th>
					<th>estado</th>
				</tr></thead><tbody>";
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					if($row['estado'] == "Desactivado")
					{echo "<tr class='bg-danger'>";}
					else{echo "<tr>";}
					?>
						<th scope="row"><?php echo $row['iddetventa']; ?></th>
						<td><?php echo $row['idventa']; ?></td>
						<td><?php echo $row['idproducto']; ?></td>
						<td><?php echo $row['cantidad']; ?></td>
						<td><?php echo $row['estado']; ?></td>
					</tr>
					<?php
				}
				echo "</tbody>";
			}
			else
			{
				?>
				<tr>
					<td colspan="9">No hay registros...</td>
				</tr>
				<?php
			}
		}

		/**
		  * Modulo Detalles Para el sistema SistemaBici
		  * Administrador, Usuario
		  * @Version 0.00.00
		  * 04.03.2017
		  * @Autor: Martin Fierro Robles
		  *
		  * @Param $query Consulta SQL para poder visualizar los detalles
		  *
		  * Este metodo nos permite visualizar en forma de tabla para realizar
		  * un reporte 
		  *
		 */
		public function dataviewDetallesReporteCompuesto($query)
		{
			$query = "SELECT iddetventa, idventa, producto, cantidad, detventas.estado
			FROM detventas INNER JOIN productos ON detventas.idproducto = productos.idproducto";
			$stmt = $this->db->prepare($query);
			$stmt->execute();

			if($stmt->rowCount()>0)
			{
				echo "<thead class='thead-default'>
				<tr>
					<th>ID</th>
					<th>Venta</th>
					<th>Producto</th>
					<th>Cantidad</th>
					<th>estado</th>
				</tr></thead><tbody>";
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					if($row['estado'] == "Desactivado")
					{echo "<tr class='bg-danger'>";}
					else{echo "<tr>";}
					?>
						<th scope="row"><?php echo $row['iddetventa']; ?></th>
						<td><?php echo $row['idventa']; ?></td>
						<td><?php echo $row['producto']; ?></td>
						<td><?php echo $row['cantidad']; ?></td>
						<td><?php echo $row['estado']; ?></td>
					</tr>
					<?php
				}
				echo "</tbody>";
			}
			else
			{
				?>
				<tr>
					<td colspan="9">No hay registros...</td>
				</tr>
				<?php
			}
		}


		public function updateDetallesConcurrencia($iddetventa, $idventa, $idproducto, $cantidad)
		{
			try
			{
				$datos = $this->getIdDetalles($iddetventa);
				$SQL = "UPDATE detventas SET 
						idventa 	= :idventa, 
						idproducto 	= :idproducto, 
						cantidad 	= :cantidad 
						WHERE 
						iddetventa 	= :iddetventa 
						AND
						cantidad	= :cantidad";

				$stmt = $this->db->prepare($SQL);
				$stmt->bindparam(":idventa",$idventa);
				$stmt->bindparam(":idproducto",$idproducto);
				$stmt->bindparam(":cantidad",$cantidad);
				$stmt->bindparam(":iddetventa",$iddetventa);
				
				if (!$stmt->execute()) 
				{
					$this->updateDetallesConcurrencia($iddetventa, $idventa, $idproducto, $datos['cantidad']);
				}

				return true;	
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();	
				return false;
			}
		}
	}
?>