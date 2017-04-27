<?php
	class crud
	{
		private $db;

		function __construct($DB_con)
		{
			$this->db = $DB_con;
		}

		/**
		 * Modulo Usuarios Para el sistema SistemaBici
		 * Administrador
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 *
		 * @Param $nomusuario Nombre del usuario
		 * @Param $appusuario Apellido Paterno del usuario
		 * @Param $usuario usuario para acceder
		 * @Param $password contraseña para acceder
		 * @Param $email correo electronico del usuario
		 * @Param $catusuario Nivel de acceso del usuario
		 * @Param $idioma idioma del usuario
		 *
		 * Este metodo recibe 8 parametros para que pueda realizar
		 * la insercion de usuarios a la base de datos del sistema
		 * 
		 */
		public function createUsuario($nomusuario, $appusuario ,$apmusuario, $usuario, $password, $email, $catusuario, $idioma)
		{
			try
			{
				$sql = "INSERT INTO usuarios VALUES(NULL, :nomusuario, :appusuario, :apmusuario, :usuario, :password, :email, :catusuario, :idioma, 'Activado')";
				$stmt = $this->db->prepare($sql);
				$stmt->bindparam(":nomusuario", $nomusuario);
				$stmt->bindparam(":appusuario",  $appusuario);
				$stmt->bindparam(":apmusuario",$apmusuario);
				$stmt->bindparam(":usuario",$usuario);
				$stmt->bindparam(":password", $password);
				$stmt->bindparam(":email", $email);
				$stmt->bindparam(":catusuario",$catusuario);
				$stmt->bindparam(":idioma",$idioma);
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
		 * Modulo Usuarios Para el sistema SistemaBici
		 * Administrador
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 *
		 * @Param $id llave primaria del usuario
		 *
		 * Este metodo recibe el id de un usuario como parametro para que 
		 * te regrese todos sus datos en forma de arreglo
		 * 
		 * @Return Arreglo con todos los datos de un usuario
		 */
		public function getIdUsuario($id)
		{
			$stmt = $this->db->prepare("SELECT * FROM usuarios WHERE IdUsuario=:id");
			$stmt->execute(array(":id"=>$id));
			$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
			return $editRow;
		}

		/**
		 * Modulo Usuarios Para el sistema SistemaBici
		 * Administrador
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 *
		 * @Param $idusuario Llave primaria del usuario
		 * @Param $nomusuario Nombre del usuario
		 * @Param $appusuario Apellido Paterno del usuario
		 * @Param $usuario usuario para acceder
		 * @Param $password contraseña para acceder
		 * @Param $email correo electronico del usuario
		 * @Param $catusuario Nivel de acceso del usuario
		 * @Param $idioma idioma del usuario
		 *
		 * Este metodo recibe 9 parametros para que pueda realizar
		 * la actualizacion de usuarios a la base de datos del sistema
		 * 
		 */
		public function updateUsuario($idusuario, $nomusuario, $appusuario ,$apmusuario, $usuario, $password, $email, $catusuario, $idioma)
		{
			try
			{
				if($password != ""){
					$sql="UPDATE usuarios SET nomusuario=:nomusuario, appusuario=:appusuario, apmusuario=:apmusuario,
					usuario=:usuario, password=:password, email=:email, catusuario=:catusuario, 
					idioma=:idioma WHERE idusuario=:idusuario";
					$stmt=$this->db->prepare($sql);
					$stmt->bindparam(":password", $password);
				}else{
					$sql="UPDATE usuarios SET nomusuario=:nomusuario, appusuario=:appusuario, apmusuario=:apmusuario,
					usuario=:usuario, email=:email, catusuario=:catusuario, idioma=:idioma WHERE idusuario=:idusuario";
					$stmt=$this->db->prepare($sql);
				}			
				
				$stmt->bindparam(":nomusuario", $nomusuario);
				$stmt->bindparam(":appusuario",  $appusuario);
				$stmt->bindparam(":apmusuario",$apmusuario);
				$stmt->bindparam(":usuario",$usuario);			
				$stmt->bindparam(":email",  $email);
				$stmt->bindparam(":catusuario",$catusuario);
				$stmt->bindparam(":idioma",$idioma);
				$stmt->bindparam(":idusuario",$idusuario);
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
		 * Modulo Usuarios Para el sistema SistemaBici
		 * Administrador
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 * 
		 * @Param $id Llave primaria del usuario
		 *
		 * Este metodo recibe como parametro la llave primaria del usuario
		 * para que pueda realizar alguna eliminacion de un usuarios a la 
		 * base de datos del sistema
		 * 
		 */
		public function deleteUsuario($id)
		{
			$stmt = $this->db->prepare("UPDATE usuarios SET estado = 'Desactivado' WHERE idusuario=:id");
			$stmt->bindparam(":id",$id);
			$stmt->execute();

			return true;
		}

		/**
		 * Modulo Usuarios Para el sistema SistemaBici
		 * Administrador
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 * 
		 * @Param $query consulta SQL para mostrar todos los usuarios
		 *
		 * Este metodo genera una tabla para poder visualizar
		 * a todos los usuarios del sistema
		 * 
		 */
		public function dataviewUsuarios($query)
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
					<th>Usuario</th>
					<th>Email</th>
					<th>Categoria</th>
					<th>Idioma</th>
					<th>Estado</th>
					<th align='center'></th>
				</tr></thead><tbody>
				<?php
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					if($row['estado'] == "Desactivado")
					{echo "<tr class='bg-danger'>";}
					else{echo "<tr>";}
					?>			
						<th scope="row"><?php echo $row['idusuario']; ?></th>
						<td><?php echo $row['nomusuario'].' '.$row['appusuario'].' '.$row['apmusuario']; ?></td>
						<td><?php echo $row['usuario'] ?></td>
						<td><?php echo $row['email']; ?></td>
						<td><?php echo $row['catusuario']; ?></td>
						<td><?php echo $row['idioma']; ?></td>
						<td><?php echo $row['estado']; ?></td>

						<td align="center">
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo $row['idusuario']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row['idusuario']; ?>">Editar <i class="fa fa-pencil"></i></button>&nbsp;
							<!--<a href="user-del.php?id=<?php print($row['idusuario']); ?>">
								<i class="fa fa-trash"></i>
							</a>-->
							<button class="btn btn-outline-primary" onclick="ConfirmDemo<?php echo $row['idusuario']; ?>()">
								<i class="fa fa-trash"></i>							
							</button>
						</td>
					</tr>
					<tr>
						<td colspan="8">
							<div class="collapse" id="collapse<?php echo $row['idusuario']; ?>">
								<div class="card card-block card-inverse" style="background-color: #333; border-color: #333;">
								  <?php
								  	$id = $row['idusuario'];
								  	if (isset($_POST["btnGuardar{$id}"])) 
								  	{
							        $idusuario = $row['idusuario'];
		                  $nomusuario = $_POST['nomusuario'];
		                  $appusuario = $_POST['appusuario'];
		                  $apmusuario = $_POST['apmusuario'];
		                  $usuario = $_POST['usuario'];
		                  if($_POST['password'] != "")
		                  {
		                    $password = md5($_POST['password']);
		                  }
		                  else
		                  {
		                    $password = "";
		                  }
		                  $email = $_POST['email'];
		                  $catusuario = $_POST['catusuario'];
		                  $idioma = $_POST['idioma'];
							        if ($this->updateUsuario($idusuario, $nomusuario, $appusuario, $apmusuario, $usuario, $password, $email, $catusuario, $idioma)) 
		                  {
		                    echo "<script>location.href='usuarios.php'</script>";
		                  }
		                  else
		                  {
		                    echo "<script>alert('Hubo un error al guardar al usuario');</script>";
		                  }
							      }
							    ?>
								  <form method="POST">
		                <div class="form-group row"><!-- nomusuario -->
		                  <label for="" class="col-2 col-form-label text-white">Nombre</label>
		                  <div class="col-10">
		                    <input class="form-control" onKeyPress="return soloLetras(event);" type="text" value="<?php echo $row['nomusuario']; ?>" id="nomusuario" name="nomusuario" required>
		                  </div>
		                </div>

		                <div class="form-group row"><!-- appusuario -->
		                  <label for="" class="col-2 col-form-label text-white">Apellido Paterno</label>
		                  <div class="col-10">
		                    <input class="form-control" onKeyPress="return soloLetras(event);" type="text" value="<?php echo $row['appusuario']; ?>" id="appusuario" name="appusuario" required>
		                  </div>
		                </div>

		                <div class="form-group row"><!-- apmusuario -->
		                  <label for="" class="col-2 col-form-label text-white">Apellido Materno</label>
		                  <div class="col-10">
		                    <input class="form-control" onKeyPress="return soloLetras(event);" type="text" value="<?php echo $row['apmusuario']; ?>" id="apmusuario" name="apmusuario" required>
		                  </div>
		                </div>

		                <div class="form-group row"><!-- usuario -->
		                  <label for="" class="col-2 col-form-label text-white">Usuario</label>
		                  <div class="col-10">
		                    <input class="form-control" onKeyPress="return soloLetras(event);" type="text" value="<?php echo $row['usuario']; ?>" id="usuario" name="usuario" required>
		                  </div>
		                </div>

		                <div class="form-group row"><!-- password -->
		                  <label for="" class="col-2 col-form-label text-white">Password</label>
		                  <div class="col-10">
		                    <input class="form-control" onKeyPress="return soloLetras(event);" type="password" value="" id="password" name="password">
		                  </div>
		                </div>

		                <div class="form-group row"><!-- email -->
		                  <label for="" class="col-2 col-form-label text-white">Email</label>
		                  <div class="col-10">
		                    <input class="form-control" type="email" value="<?php echo $row['email']; ?>" id="email" name="email" required>
		                  </div>
		                </div>

		                <div class="form-group row"><!-- catusuario -->
		                  <label for="" class="col-2 col-form-label text-white">Categoria</label>
		                  <div class="col-10">
		                    <select class="form-control" id="catusuario" name="catusuario" required>
		                      <option value="<?php echo $row['catusuario']; ?>"><?php echo $row['catusuario']; ?></option>
		                      <option value="Administrador">Administrador</option>
		                      <option value="Empleado">Empleado</option>
		                      <option value="Cliente">Cliente</option>
		                    </select>
		                  </div>
		                </div>

		                <div class="form-group row"><!-- idioma -->
		                  <label for="" class="col-2 col-form-label text-white">Idioma</label>
		                  <div class="col-10">
		                    <select class="form-control" id="idioma" name="idioma" required>
		                      <option value="<?php echo $row['idioma']; ?>"><?php echo $row['idioma']; ?></option>
		                      <option value="Espanol">Español</option>
		                      <option value="English">English</option>
		                    </select>
		                  </div>
		                </div>

		                <hr>

		                <div class="form-group row">
		                  <div class="col-md-6 col-md-offset-6 text-xs-right">
		                    <button type="submit" name="btnGuardar<?php echo $id; ?>" class="btn btn-outline-success">Guardar</button>
		                    <a href="usuarios.php" class="btn btn-outline-danger">Cancelar</a>
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
					<script type="text/javascript">
						function ConfirmDemo<?php echo $row['idusuario']; ?>() {
							//Ingresamos un mensaje a mostrar
							var mensaje = confirm("¿Esta seguro que quiere eliminar a <?php echo $row['nomusuario'].' '.$row['appusuario'].' '.$row['apmusuario']; ?>?");
							//Detectamos si el usuario acepto el mensaje
							if (mensaje) {
								location.href='user-del.php?id=<?php print($row['idusuario']); ?>';
							}
							//Detectamos si el usuario denegó el mensaje
						}
					</script>
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
					<td colspan="9">No hay registros...</td>
				</tr>
				</table>
				<?php
			}
		}

		/**
		 * Modulo Usuarios Para el sistema SistemaBici
		 * Administrador
		 * @Version 0.00.00
		 * 04.03.2017
		 * @Autor: Martin Fierro Robles
		 * 
		 * @Param $query consulta SQL para mostrar todos los usuarios
		 *
		 * Este metodo genera una tabla para poder visualizar
		 * en forma de reporte a todos los usuarios que estan
		 * en registrados en el sistema
		 * 
		 */
		public function dataviewUsuariosReporte($query)
		{
			$stmt = $this->db->prepare($query);
			$stmt->execute();

			if($stmt->rowCount()>0)
			{
				echo "<thead class='thead-default'>
				<tr>
					<th>ID</th>
					<th>Nombre</th>
					<th>Usuario</th>
					<th>Email</th>
					<th>Categoria</th>
					<th>Idioma</th>
					<th>Estado</th>
				</tr></thead><tbody>";
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					if($row['estado'] == "Desactivado")
					{echo "<tr class='bg-danger'>";}
					else{echo "<tr>";}
					?>				
						<th scope="row"><?php echo $row['idusuario']; ?></th>
						<td><?php echo $row['nomusuario'].' '.$row['appusuario'].' '.$row['apmusuario']; ?></td>
						<td><?php echo $row['usuario'] ?></td>
						<td><?php echo $row['email']; ?></td>
						<td><?php echo $row['catusuario']; ?></td>
						<td><?php echo $row['idioma']; ?></td>
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