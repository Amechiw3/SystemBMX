<?php
	class crud
	{
		private $db;

		function __construct($DB_con)
		{
			$this->db = $DB_con;
		}

		/**
		  * Modulo Categorias Para el sistema SistemaBici
		  * Administrador
		  * @Version 0.00.00
		  * 04.03.2017
		  * @Autor: Martin Fierro Robles
		  *
		  * @Param $nombre Nombre de la categoria a crear
		  *
		  * Este metodo recibe un parametro para que pueda realizar
		  * la insercion de categorias a la base de datos del sistema
		  * 
		  */
		public function createCategorias($nombre)
		{
			try
			{
				$stmt = $this->db->prepare("INSERT INTO catproductos VALUES(NULL, :categoria, 'Activado')");
				$stmt->bindparam(":categoria", $nombre);
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
		 * Modulo Categorias Para el sistema SistemaBici
		 * Administrador
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 *
		 * @Param $id llave primaria de la categoria
		 *
		 * Este metodo recibe el id de una categoria como 
		 * parametro para que te regrese todos sus datos 
		 * en forma de arreglo
		 * 
		 * @Return Arreglo con todos los datos de una categoria
		 */
		public function getIdCategorias($id)
		{
			$stmt = $this->db->prepare("SELECT * FROM catproductos WHERE idcatproducto=:id");
			$stmt->execute(array(":id"=>$id));
			$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
			return $editRow;
		}

		/**
		 * Modulo Categorias Para el sistema SistemaBici
		 * Administrador
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 *
		 * @Param $idcatproducto llave primaria de la categoria
		 * @Param $nombre nombre de la categoria
		 *
		 * Este metodo recibe dos parametro para que se pueda
		 * actualizar alguna categoria del sistema
		 *
		 */
		public function updateCategorias($idcatproducto, $nombre)
		{
			try
			{
				//SELECT CONCAT(CURRENT_DATE(),' ',CURRENT_TIME()))
				$sql="UPDATE catproductos SET categoria=:categoria WHERE idcatproducto=:idcatproducto";
				$stmt=$this->db->prepare($sql);
				$stmt->bindparam(":categoria",$nombre);
				$stmt->bindparam(":idcatproducto",$idcatproducto);
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
		 * Modulo Categorias Para el sistema SistemaBici
		 * Administrador
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 *
		 * @Param $idcatproducto llave primaria de la categoria
		 *
		 * Este metodo recibe la llave primaria de una categoria
		 * como parametro para que pueda eliminar una categoria 
		 * del sistema
		 *
		 */
		public function deleteCategorias($idcatproducto)
		{
			$stmt = $this->db->prepare("UPDATE catproductos SET estado='Desactivado' WHERE idcatproducto=:idcatproducto");
			$stmt->bindparam(":idcatproducto",$idcatproducto);
			$stmt->execute();

			return true;
		}

		/**
		 * Modulo Categorias Para el sistema SistemaBici
		 * Administrador
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 *
		 * @Param $query Consulta SQL para mostrar todas las ategorias de sistema
		 *
		 * Este metodo recibe una consulta SQL para mostrar todas 
		 * las categoria del sistema de forma de tabla
		 *
		 */
		public function dataviewCategorias($query)
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
							<th>Nombre</th>
							<th>Estado</th>
							<th></th>
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
							<th scope="row"><?php echo $row['idcatproducto']; ?></th>
							<td><?php echo $row['categoria']; ?></td>
							<td><?php echo $row['estado']; ?></td>
							<td align="right">
								<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo $row['idcatproducto']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row['idcatproducto']; ?>">Editar <i class="fa fa-pencil"></i></button>

								<button class="btn btn-outline-primary" onclick="ConfirmDemo<?php echo $row['idcatproducto']; ?>()">
								Eliminar <i class="fa fa-trash"></i>							
								</button>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<div class="collapse" id="collapse<?php echo $row['idcatproducto']; ?>">
								  <div class="card card-block card-inverse" style="background-color: #333; border-color: #333;">
								  	<?php
								  		$id = $row['idcatproducto'];
								  		if (isset($_POST["btnGuardar{$id}"])) 
								  		{
							          $idcatproducto = $id;
							          $categoria = $_POST['categoria'];
							          if ($this->updateCategorias($idcatproducto, $categoria)) 
							          {
							          	echo "<script>location.href='categorias.php'</script>";
							          }
							          else
							          {
							          	echo "<script>alert('Hubo un error al guardar al usuario');</script>";
							          }
							        }
							      ?>
								  		<form method="POST">
							          <div class="form-group row"><!-- categoria -->
							            <label for="" class="col-2 col-form-label text-white">Nombre</label>
								            <div class="col-10">
								              <input class="form-control" onKeyPress="return soloLetras(event);" type="text" value="<?php echo $row['categoria']; ?>" id="categoria" name="categoria" required>
								            </div>
							              	</div>
							              	<hr>
							              	<div class="form-group row">
							                	<div class="col-md-6 col-md-offset-6 text-xs-right">
							                  		<button type="submit" name="btnGuardar<?php echo $id; ?>" class="btn btn-outline-success">Guardar</button>
							                  		<a href="#" class="btn btn-outline-danger">Cancelar</a>
							                	</div>
							              	</div>
							        </form>
							        <script type="text/javascript">
												function ConfirmDemo<?php echo $row['idcatproducto']; ?>() {
												//Ingresamos un mensaje a mostrar
												var mensaje = confirm("¿Esta seguro que quiere eliminar el registro?");
												//Detectamos si el usuario acepto el mensaje
												if (mensaje) {
													location.href='catprod-del.php?id=<?php echo $row['idcatproducto']; ?>';
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
				<table class="table table-hover table-inverse">				
				<tr>
				<td>No hay registros...</td>
				</tr>
				</table>

				<?php
			}
		}

		/**
		 * Modulo Categorias Para el sistema SistemaBici
		 * Administrador
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 *
		 * @Param $query Consulta SQL para mostrar todas las ategorias de sistema
		 *
		 * Este metodo recibe una consulta SQL para mostrar todas 
		 * las categoria del sistema de forma de tabla de reportes
		 *
		 */
		public function dataviewCategoriaReporte($query)
		{
			$stmt = $this->db->prepare($query);
			$stmt->execute();

			if($stmt->rowCount()>0)
			{
				echo "<thead class='thead-default'>
				<tr>
					<th>ID</th>
					<th>Nombre</th>
					<th>Estado</th>
				</tr></thead><tbody>";
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					if($row['estado'] == "Desactivado")
					{echo "<tr class='bg-danger'>";}
					else{echo "<tr>";}
					?>
					<th scope="row"><?php echo $row['idcatproducto']; ?></th>
					<td><?php echo $row['categoria']; ?></td>
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
	}
?>