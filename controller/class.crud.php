<?php

class crud
{
	private $db;

	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}

//////------	  USUARIOS		------\\\\\\
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

	public function getIdUsuario($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM usuarios WHERE IdUsuario=:id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

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

	public function deleteUsuario($id)
	{
		$stmt = $this->db->prepare("UPDATE usuarios SET estado = 'Desactivado' WHERE idusuario=:id");
		$stmt->bindparam(":id",$id);
		$stmt->execute();

		return true;
	}

	public function dataviewUsuarios($query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			?>
      		<table id="testTable" class="table table-hover table-inverse table-sm">
			<thead class='thead-default'>
			<tr>
				<th>ID</th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Full Name";} else {echo "Nombre";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "User";} else {echo "Usuario";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Email";} else {echo "Correo";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Level";} else {echo "Nivel";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Idiom";} else {echo "Idioma";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "State";} else {echo "Estado";} ?></th>
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
						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo $row['idusuario']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row['idusuario']; ?>">
							<i class="fa fa-pencil"></i>
						</button>&nbsp;
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

	public function dataviewUsuariosReporte($query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
			<tr>
				<th>ID</th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Full Name";} else {echo "Nombre";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "User";} else {echo "Usuario";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Email";} else {echo "Correo";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Level";} else {echo "Nivel";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Language";} else {echo "Idioma";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "State";} else {echo "Estado";} ?></th>
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
//////------	END USUARIOS	------\\\\\\

//////------	  VENTAS 		------\\\\\\
	public function createVenta($usuario, $total)
	{
		try
		{
			$SQL ="INSERT INTO ventas VALUES (NULL, :usuario, (SELECT CURRENT_DATE()), :total, 'Activado')";
			$stmt = $this->db->prepare($SQL);
			$stmt->bindparam(":usuario", $usuario);
			$stmt->bindparam(":total", $total);
			$stmt->execute();

			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public function getIdVenta($id)
	{
		//$stmt = $this->db->prepare("SELECT * FROM operaciones WHERE IdOperacion=:id");
		$stmt = $this->db->prepare("SELECT * FROM ventas WHERE idventa=:id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function updateVenta($idventa, $idusuario, $totalventa, $fechaventa)
	{
		try
		{	
			$sql = "UPDATE ventas SET idusuario = :idusuario, fechaventa = :fechaventa, totalventa=:totalventa WHERE idventa=:idventa";
			$stmt=$this->db->prepare($sql);
			$stmt->bindparam(":idusuario",$idusuario);
			$stmt->bindparam(":totalventa",$totalventa);
			$stmt->bindparam(":fechaventa",$fechaventa);
			$stmt->bindparam(":idventa",$idventa);
			$stmt->execute();

			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public function updateVentaBitacora($idventa, $idusuario, $totalventa, $fechaventa, $totalAnterior, $valorbool)
	{
		try
		{	
			$SQLBitacora1 = "INSERT INTO bitacora VALUES(23, {$idventa}, {$totalAnterior}, {$totalventa}, 1)";
			$stmt=$this->db->prepare($SQLBitacora1);
			$stmt->execute();
			// 7
			$SQLBitacora2 = "UPDATE bitacora SET estado = 2 WHERE idbitacora = 23";
			$stmt=$this->db->prepare($SQLBitacora2);
			$stmt->execute();
			// 8<script language="javascript">
			if(!$valorbool)
			{			
				$sql = "UPDATE ventas SET idusuario = :idusuario, fechaventa = :fechaventa, totalventa=:totalventa WHERE idventa=:idventa";
				$stmt=$this->db->prepare($sql);
				$stmt->bindparam(":idusuario",$idusuario);
				$stmt->bindparam(":totalventa",$totalventa);
				$stmt->bindparam(":fechaventa",$fechaventa);
				$stmt->bindparam(":idventa",$idventa);
				$stmt->execute();
				// 9
				$SQLBitacora3 = "UPDATE bitacora SET estado = 3 WHERE idbitacora = 23";
				$stmt=$this->db->prepare($SQLBitacora3);
				$stmt->execute();
				// 10
				$SQLBitacora4 = "DELETE FROM bitacora  WHERE idbitacora = 23";
				$stmt=$this->db->prepare($SQLBitacora4);
				$stmt->execute();
			}
			else
			{
				echo "<script>alert('Se genero un problema');</script>";
			}
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public function updateVentaBitacoraReload()
	{
		try
		{	
			$query="SELECT * FROM bitacora;";
			$stmt = $this->db->prepare($query);
			$stmt->execute();

			if($stmt->rowCount() > 0)
			{
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					$idbitacora = $row['idbitacora'];
					$venta = $row['idventa'];
					$total = $row['nuevo'];
					$estado = $row['estado'];
					if($estado = "2")
					{
						$sql = "UPDATE ventas SET totalventa={$total} WHERE idventa={$venta}";
						$stmt=$this->db->prepare($sql);
						$stmt->execute();
					}
					$SQLBitacora4 = "DELETE FROM bitacora  WHERE idbitacora = {$idbitacora}";
					$stmt=$this->db->prepare($SQLBitacora4);
					$stmt->execute();
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public function deleteVenta($idventa)
	{
		$stmt = $this->db->prepare("UPDATE ventas SET estado='Desactivado' WHERE idventa=:idventa");
		$stmt->bindparam(":idventa",$idventa);
		$stmt->execute();

		return true;
	}

	public function reloadVenta($idventa)
	{
		$sql = "UPDATE ventas SET totalventa=(SELECT SUM(dt.cantidad*pr.precio)AS total
				FROM detventas as dt INNER JOIN productos AS pr 
				ON dt.idproducto = pr.idproducto WHERE dt.estado = 'Activado' AND 
				dt.idventa = {$idventa}) WHERE idventa=:idventa";
		$stmt = $this->db->prepare($sql);
		$stmt->bindparam(":idventa",$idventa);
		$stmt->execute();

		return true;
	}

	public function dataviewDetallesOnly($id)
	{
		$query="SELECT iddetventa, idventa, dv.idproducto, 
            pr.producto, pr.imagen, pr.precio, dv.cantidad
            FROM detventas AS dv INNER JOIN productos AS pr
            ON dv.idproducto = pr.idproducto WHERE idventa = {$id}";
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		if($stmt->rowCount() > 0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				?>
				<div class="col-sm-3">
                    <div class="card  text-center card-inverse" style="background-color: #222; border-color: #444;">
                    	<p class="text-xs-center"><br>
                        <img class="card-img-top img-thumbnail rounded img-fluid" src="../model/productos/<?php echo $row['imagen']; ?>" style="width: 100px;" alt="Card image cap">
                      	</p>
                      <div class="card-block">
                        <h6 class="card-title">
                        	<?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?>
                        	<br><?php echo $row['producto']; ?>
                        </h6>
                        <p class="card-text">
                        	<?php if($_SESSION['idioma'] == "English") {echo "Price:";} else {echo "Precio";} ?><?php echo number_format($row['precio'], 2); ?><br>
                        	<?php if($_SESSION['idioma'] == "English") {echo "Quantity:";} else {echo "Cantidad:";} ?><?php echo $row['cantidad']; ?><br>
                        	Total: <?php echo number_format($row['precio']*$row['cantidad'], 2); ?><br>
                        </p>
                      </div>
                    </div>
                  </div>
				<?php
			}
		}
	}

	public function dataviewVentas($query)
	{
		/*$query = "SELECT ve.idventa, CONCAT(us.nomusuario,' ',us.appusuario,' ', us.apmusuario)AS nombreusuario,
			ve.fechaventa, ve.totalventa, ve.estado FROM ventas AS ve INNER JOIN usuarios as us
			on ve.idusuario = us.idusuario";*/
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		if($stmt->rowCount()>0)
		{
			?>
      		<table class="table table-hover table-inverse table-sm">
				<thead class='thead-default'>
					<tr>
						<th>ID</th>
						<th><?php if($_SESSION['idioma'] == "English") {echo "User";} else {echo "Usuario";} ?></th>
						<th><?php if($_SESSION['idioma'] == "English") {echo "Date";} else {echo "Fecha";} ?></th>
						<th>Total</th>
						<th><?php if($_SESSION['idioma'] == "English") {echo "State";} else {echo "Estado";} ?></th>
						<th align='center'></th>
						<th align='center'></th>
					</tr>
				</thead>
			<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				if($row['estado'] == "Desactivado")
				{echo "<tr class='bg-danger'>";}
				else{echo "<tr>";}
				?>
					<td><?php echo $row['idventa']; ?></td>
					<td><?php echo $row['nombreusuario']; ?></td>
					<td><?php echo $row['fechaventa']; ?></td>
					<td><?php echo number_format($row['totalventa'], 2); ?></td>
					<td><?php echo $row['estado']; ?></td>
					<td align="center">
							
						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#edit<?php echo $row['idventa']; ?>" aria-expanded="false" aria-controls="edit<?php echo $row['idventa']; ?>">
							<i class="fa fa-pencil"></i>
						</button>
						</a>
						<!-- <a href="ventas-del.php?id=<?php echo $row['idventa']; ?>">
							<i class="fa fa-trash"></i>
						</a> -->
						<button class="btn btn-outline-primary" onclick="ConfirmDemo<?php echo $row['idventa']; ?>()">
							<i class="fa fa-trash"></i>							
						</button>
						<a href="ventas-upd.php?id=<?php echo $row['idventa']; ?>" class="btn btn-outline-primary">
							<i class="fa fa-refresh"></i>
						</a>
					</td>
					<td align="center">
						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#det<?php echo $row['idventa']; ?>" aria-expanded="false" aria-controls="det<?php echo $row['idventa']; ?>">Detalles <i class="fa fa-caret-square-o-down" aria-hidden="true"></i></button>
					</td>
				</tr>
				<tr>
					<td colspan="7">
						<div class="collapse" id="det<?php echo $row['idventa']; ?>">
						  <div class="card card-block card-inverse" style="background-color: #333; border-color: #333;">
						  	<div class="row">
						    <?php 
								$this->dataviewDetallesOnly($row['idventa']);
						    ?>
						    </div>
						  </div>
						</div>
						<div class="collapse" id="edit<?php echo $row['idventa']; ?>">
						  <div class="card card-block card-inverse" style="background-color: #333; border-color: #333;">
						  	<?php
						  		$id = $row['idventa'];
			            if (isset($_POST["btnGuardar{$id}"])) 
			            {
			              $idusuario = $_POST['idusuario'];
			              $total = $_POST['total'];
			              $idventa = $row['idventa'];
			              if ($_POST['fechaventa'] != "") {
			              	$fechaventa = $_POST['fechaventa'];
			              }
			              else{
			              	$fechaventa = $row['fechaventa'];
			              }
			              /*
				              if ($this->updateVenta($idventa, $idusuario, $total, $fechaventa)) 
				              {
				                echo "<script>location.href='ventas.php'</script>";
				              }
				              else
				              {
				                echo "<script>alert('Hubo un error al guardar la venta');</script>";			                
				              }
			              */
			              if ($_POST["optionerror"]) {
			              	$valorbool = True;
			              }
			              else{
			              	$valorbool = False;
			              }
			              if ($this->updateVentaBitacora($idventa, $idusuario, $total, $fechaventa, $_POST['totalant'], $valorbool)) 
			              {
			                echo "<script>location.href='ventas.php'</script>";
			              }
			              else
			              {
			                echo "<script>alert('Hubo un error al guardar la venta');</script>";			                
			              }
			            }
			          ?>
						  	<form method="POST">
		              <div class="form-group row"><!-- usuario -->
		                <label for="" class="col-2 col-form-label text-white">Usuario</label>
		                <div class="col-10">
		                  <select class="form-control" id="idusuario" name="idusuario" required>
		                    <?php
		                      $sql = "SELECT * FROM usuarios WHERE idusuario in 
		                      (SELECT idusuario FROM ventas WHERE idventa = {$row['idventa']})";
		                      $this->OptionUsuarios($sql);

		                      $sql = "SELECT * FROM usuarios WHERE idusuario not in 
		                      (SELECT idusuario FROM ventas WHERE idventa = {$row['idventa']})";
		                      $this->OptionUsuarios($sql);		                    
		                    ?>
		                  </select>
		                </div>                
		              </div>

		              <div class="form-group row"><!-- total -->
		                <label for="" class="col-2 col-form-label text-white">Total</label>
		                <div class="col-10">
		                	<input class="form-control" type="hidden" value="<?php echo $row['totalventa']; ?>" id="total" name="totalant" >
		                  	<input class="form-control" onkeypress="return soloNumeros(event);" type="text" value="<?php echo $row['totalventa']; ?>" id="total" name="total" required>
		                </div>
		              </div>
		              <div class="form-group row"><!-- fecha -->
		                <label for="" class="col-2 col-form-label text-white">Fecha de venta: <br><?php echo $row['fechaventa']; ?></label>
		                <div class="col-10">
		                  <div class="input-group date form_date ">
		                    <input class="form-control" size="16" type="text" value="" readonly name="fechaventa" data-link-format="yyyy-mm-dd" data-date="<?php echo $row['fechaventa']; ?>" >
		                    <!-- <span class="input-group-addon"><span class="fa fa-remove"></span></span> -->
		                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
		                  </div>
		                </div>
		              </div>
		              
		              <div class="form-group row"><!-- Pregunta	 -->
		              	<input type="checkbox" checked autocomplete="off" name="optionerror"> ¿ Quiere generar un error ?
		              </div>

		              <hr>
		              <div class="form-group row">
		                <div class="col-md-6 col-md-offset-6 text-xs-right">
		                  <button type="submit" name="btnGuardar<?php echo $id; ?>"	class="btn btn-outline-success">Guardar</button>
		                  <a href="ventas.php" class="btn btn-outline-danger">Cancelar</a>
		                </div>
		              </div>
		            </form>
						  </div>
						</div>
						<script type="text/javascript">
							function ConfirmDemo<?php echo $id; ?>() {
								//Ingresamos un mensaje a mostrar
								var mensaje = confirm("¿Esta seguro que quiere eliminar el registro?");
								//Detectamos si el usuario acepto el mensaje
								if (mensaje) {
									location.href='ventas-del.php?id=<?php echo $row['idventa']; ?>';
								}
							}
						</script>
					</td>
				</tr>
				<?php
			}
			?>
			</table>
			<?php
		}
		else
		{
			?>
      <table class="table table-hover table-inverse">

			<tr>
			<td colspan="7">No hay registros...</td>
			</tr>
			</table>
			<?php
		}
	}

	public function OptionUsuarios($query )
	{

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) 
            {?>
                <option value="<?php echo $row['idusuario'] ?>">
                    <?php echo $row['nomusuario'].' '.$row['appusuario'].' '.$row['apmusuario']; ?>
                </option>
            <?php
            }
        }
	}

	public function dataviewVentaReporteCompuesto($query)
	{
		// $query = "SELECT ve.idventa, CONCAT(us.nomusuario,' ',us.appusuario,' ', us.apmusuario)AS nombreusuario,
		// 	ve.fechaventa, ve.totalventa, ve.estado FROM ventas AS ve INNER JOIN usuarios as us
		// 	on ve.idusuario = us.idusuario";
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
			<tr>
				<th>ID</th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "User";} else {echo "Usuario";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Date";} else {echo "Fecha";} ?></th>
				<th>Total</th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "State";} else {echo "Estado";} ?></th>
			</tr></thead>
			<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				if($row['estado'] == "Desactivado")
				{echo "<tr class='bg-danger'>";}
				else{echo "<tr>";}
				?>
					<td><?php echo $row['idventa']; ?></td>
					<td><?php echo $row['nombreusuario']; ?></td>
					<td><?php echo $row['fechaventa']; ?></td>
					<td><?php echo number_format($row['totalventa'], 2); ?></td>
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

	public function dataviewVentaReporteSumarios($query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$total = "";
		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
			<tr>
				<th>ID</th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "User";} else {echo "Usuario";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Date";} else {echo "Fecha";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Image";} else {echo "Imagen";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Category";} else {echo "Categoria";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Quantity";} else {echo "Cantidad";} ?></th>
				<th>Total</th>				
			</tr></thead><tbody>
			<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$total += $row['total'];
				if($row['estado'] == "Desactivado")
				{echo "<tr class='bg-danger'>";}
				else{echo "<tr>";}
				?>				
					<th scope="row"><?php echo $row['idventa']; ?></th>
					<td><?php echo $row['usuarionom']; ?></td>
					<td><?php echo $row['fechaventa'] ?></td>
					<td><img class="img-thumbnail img-fluid" src="../model/productos/<?php echo $row['imagen']; ?>" alt="" style="width: 200px;"></td>
					<td><?php echo $row['producto']; ?></td>
					<td><?php echo $row['categoria']; ?></td>
					<td><?php echo $row['cantidad']; ?></td>
					<td><?php echo "$ ".number_format($row['total'], 2); ?></td>
				</tr>

				<?php
			}
			?>
			<tr class="bg-primary">
				<td colspan="7">Total				
				</td>
				<td><?php echo "$ ".number_format($total, 2); ?></td>
			</tr>
			</tbody>
			<?php

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

	public function dataviewVentaReporteSumariosUsuarios($query)
	{
		$query ="SELECT
			usuarios.idusuario,
			usuarios.nomusuario,
			usuarios.appusuario,
			usuarios.apmusuario,
			CONCAT(usuarios.nomusuario, ' ',
			usuarios.appusuario, ' ',
			usuarios.apmusuario) AS nombre
			FROM usuarios";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$totalrow=0;
		$total = 0;
		$totals = 0;
		$totalUsuario = 0;
		$totalventasx = 0;
		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
				<tr>
					<th>ID</th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "User";} else {echo "Usuario";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Date";} else {echo "Fecha";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Image";} else {echo "Imagen";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Category";} else {echo "Categoria";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Quantity";} else {echo "Cantidad";} ?></th>
					<th>Total</th>
				</tr>
			</thead>
			<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$totalUsuario += 1;	
				$query2 = "SELECT
                    ventas.idventa, usuarios.idusuario,
                    CONCAT(usuarios.nomusuario, ' ',
                    usuarios.appusuario, ' ',
                    usuarios.apmusuario) AS usuarionom,
                    ventas.fechaventa, detventas.iddetventa,
                    detventas.idventa, detventas.cantidad,
                    productos.idproducto, productos.producto,
                    productos.precio, (detventas.cantidad * productos.precio) AS total,
                    productos.imagen, catproductos.idcatproducto,
                    catproductos.categoria,ventas.estado
                    FROM ventas
                    INNER JOIN usuarios ON ventas.idusuario = usuarios.idusuario
                    INNER JOIN detventas ON detventas.idventa = ventas.idventa
                    INNER JOIN productos ON detventas.idproducto = productos.idproducto
                    INNER JOIN catproductos ON productos.idcatproducto = catproductos.idcatproducto
					WHERE usuarios.idusuario = {$row['idusuario']}";
				$stmt2 = $this->db->prepare($query2);
				$stmt2->execute();
				?>
				<tr>
					<th scope="row"><?php echo $row['idusuario']; ?></th>
					<td><?php echo $row['nombre'] ?></td>
					<td colspan="6"></td>
				</tr>
				<?php
				if($stmt2->rowCount()>0)
				{
					$totalrow = 0;
					$totalCant = 0;
					while($row2=$stmt2->fetch(PDO::FETCH_ASSOC))
					{
						$totalrow += $row2['total'];
						$totalCant +=$row2['cantidad'];
						$totals += $row2['total'];
						$totalventasx += 1;
						?>
						<tr>
							<th scope="row"><?php echo $row2['idventa']; ?> </th>
							<td></td>
							<td><?php echo $row2['fechaventa']; ?></td>
							<td><img class="img-thumbnail img-fluid" src="../model/productos/<?php echo $row2['imagen']; ?>" alt="" style="width: 100px;"></td>
							<td><?php echo $row2['producto']; ?></td>
							<td><?php echo $row2['categoria']; ?></td>
							<td><?php echo $row2['cantidad']; ?></td>
							<td><?php echo "$ ".number_format($row2['total'], 2); ?></td>
						</tr>
						<?php
					}
					?>
					<tr class="bg-primary">
						<td colspan="5">Total</td>
						<td colspan="2">Articulos Comprados: <?php echo $totalCant;?></td>
						<td><?php echo "$ ".number_format($totalrow, 2); ?></td>
					</tr>
					<?php
				}
				else
				{
					$totalrow = 0;
					?>
					<tr><td colspan="8"></td></tr>
					<tr class="bg-primary">
						<td colspan="7">Total				
						</td>
						<td><?php echo "$ ".number_format($totalrow, 2); ?></td>
					</tr>
					<?php
				}
			}
			?>
				<tr><td colspan="8"></td></tr>
					<tr class="bg-danger">
						<td colspan="1">Grand Total</td>
						<td colspan="6" align="right">Total de usuarios: <?php echo $totalUsuario; ?>,&nbsp; Total de ventas: <?php echo $totalventasx; ?></td>
						<td><?php echo "$ ".number_format($totals, 2); ?></td>
					</tr>
					<?php
		}
	}

	public function dataviewVentaReporteSumariosProductos($query)
	{
		$query ="select * from productos;";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$totalrow=0;
		$total = 0;
		$totals = 0;
		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
				<tr>
					<th>ID</th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Date";} else {echo "Fecha";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Image";} else {echo "Imagen";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Category";} else {echo "Categoria";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Quantity";} else {echo "Cantidad";} ?></th>
					<th>Total</th>
				</tr>
			</thead>
			<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$query2 = "SELECT
                    ventas.idventa, usuarios.idusuario,
                    CONCAT(usuarios.nomusuario, ' ',
                    usuarios.appusuario, ' ',
                    usuarios.apmusuario) AS usuarionom,
                    ventas.fechaventa, detventas.iddetventa,
                    detventas.idventa, detventas.cantidad,
                    productos.idproducto, productos.producto,
                    productos.precio, (detventas.cantidad * productos.precio) AS total,
                    productos.imagen, catproductos.idcatproducto,
                    catproductos.categoria,ventas.estado
                    FROM ventas
                    INNER JOIN usuarios ON ventas.idusuario = usuarios.idusuario
                    INNER JOIN detventas ON detventas.idventa = ventas.idventa
                    INNER JOIN productos ON detventas.idproducto = productos.idproducto
                    INNER JOIN catproductos ON productos.idcatproducto = catproductos.idcatproducto
					WHERE productos.idproducto = {$row['idproducto']}";
				$stmt2 = $this->db->prepare($query2);
				$stmt2->execute();
				?>
				<tr>
					<th scope="row"><?php echo $row['idproducto']; ?></th>
					<td><?php echo $row['producto'] ?></td>
					<td colspan="6"></td>
				</tr>
						<?php
				if($stmt2->rowCount()>0)
				{
					$totalrow = 0;
					while($row2=$stmt2->fetch(PDO::FETCH_ASSOC))
					{
						$totalrow += $row2['total'];
						$totals += $row2['total'];
						?>
						<tr>
							<th scope="row"><?php echo $row2['idventa'] ?></th>
							<td><?php echo $row2['usuarionom'] ?></td>
							<td><?php echo $row2['fechaventa']; ?></td>
							<td><img class="img-thumbnail img-fluid" src="../model/productos/<?php echo $row2['imagen']; ?>" alt="" style="width: 100px;"></td>
							<td><?php echo $row2['producto']; ?></td>
							<td><?php echo $row2['categoria']; ?></td>
							<td><?php echo $row2['cantidad']; ?></td>
							<td><?php echo "$ ".number_format($row2['total'], 2); ?></td>
						</tr>
						<?php
					}
					?>
					<tr class="bg-primary">
						<td colspan="7">Total				
						</td>
						<td><?php echo "$ ".number_format($totalrow, 2); ?></td>
					</tr>
					<?php
				}
				else
				{
					$totalrow = 0;
					?>
					<tr class="bg-primary">
						<td colspan="7">Total				
						</td>
						<td><?php echo "$ ".number_format($totalrow, 2); ?></td>
					</tr>
					<?php
				}
			}
			?>
					<tr class="bg-danger">
						<td colspan="7">Grand Total				
						</td>
						<td><?php echo "$ ".number_format($totals, 2); ?></td>
					</tr>
					<?php
		}
	}

	public function dataviewVentaReporteSumariosCategoria($query)
	{
		$query ="select * from catproductos;";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$totalrow=0;
		$total = 0;
		$totals = 0;
		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
				<tr>
					<th>ID</th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Category";} else {echo "Categoria";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Date";} else {echo "Fecha";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Image";} else {echo "Imagen";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Category";} else {echo "Categoria";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Quantity";} else {echo "Cantidad";} ?></th>
					<th>Total</th>
				</tr>
			</thead>
			<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$query2 = "SELECT
                    ventas.idventa, usuarios.idusuario,
                    CONCAT(usuarios.nomusuario, ' ',
                    usuarios.appusuario, ' ',
                    usuarios.apmusuario) AS usuarionom,
                    ventas.fechaventa, detventas.iddetventa,
                    detventas.idventa, detventas.cantidad,
                    productos.idproducto, productos.producto,
                    productos.precio, (detventas.cantidad * productos.precio) AS total,
                    productos.imagen, catproductos.idcatproducto,
                    catproductos.categoria,ventas.estado
                    FROM ventas
                    INNER JOIN usuarios ON ventas.idusuario = usuarios.idusuario
                    INNER JOIN detventas ON detventas.idventa = ventas.idventa
                    INNER JOIN productos ON detventas.idproducto = productos.idproducto
                    INNER JOIN catproductos ON productos.idcatproducto = catproductos.idcatproducto
					WHERE catproductos.idcatproducto = {$row['idcatproducto']}";
				$stmt2 = $this->db->prepare($query2);
				$stmt2->execute();
				?>
				<tr>
					<th scope="row"><?php echo $row['idcatproducto']; ?></th>
					<td><?php echo $row['categoria'] ?></td>
					<td colspan="6"></td>
				</tr>
						<?php
				if($stmt2->rowCount()>0)
				{
					$totalrow = 0;
					while($row2=$stmt2->fetch(PDO::FETCH_ASSOC))
					{
						$totalrow += $row2['total'];
						$totals += $row2['total'];
						?>
						<tr>
							<th scope="row"><?php echo $row2['idventa'] ?></th>
							<td><?php echo $row2['usuarionom'] ?></td>
							<td><?php echo $row2['fechaventa']; ?></td>
							<td><img class="img-thumbnail img-fluid" src="../model/productos/<?php echo $row2['imagen']; ?>" alt="" style="width: 100px;"></td>
							<td><?php echo $row2['producto']; ?></td>
							<td><?php echo $row2['categoria']; ?></td>
							<td><?php echo $row2['cantidad']; ?></td>
							<td><?php echo "$ ".number_format($row2['total'], 2); ?></td>
						</tr>
						<?php
					}
					?>
					<tr class="bg-primary">
						<td colspan="7">Total				
						</td>
						<td><?php echo "$ ".number_format($totalrow, 2); ?></td>
					</tr>
					<?php
				}
				else
				{
					$totalrow = 0;
					?>
					<tr class="bg-primary">
						<td colspan="7">Total				
						</td>
						<td><?php echo "$ ".number_format($totalrow, 2); ?></td>
					</tr>
					<?php
				}
			}
			?>
					<tr class="bg-danger">
						<td colspan="7">Grand Total				
						</td>
						<td><?php echo "$ ".number_format($totals, 2); ?></td>
					</tr>
					<?php
		}
	}

	public function dataviewVentaReporteSumariosVentas($query)
	{
		$query ="select * from ventas;";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$totalrow=0;
		$total = 0;
		$totals = 0;
		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
				<tr>
					<th>ID</th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Sale";} else {echo "Venta";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Date";} else {echo "Fecha";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Image";} else {echo "Imagen";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Category";} else {echo "Cantidad";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Quantity";} else {echo "Cantidad";} ?></th>
					<th>Total</th>
				</tr>
			</thead>
			<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$query2 = "SELECT
                    ventas.idventa, usuarios.idusuario,
                    CONCAT(usuarios.nomusuario, ' ',
                    usuarios.appusuario, ' ',
                    usuarios.apmusuario) AS usuarionom,
                    ventas.fechaventa, detventas.iddetventa,
                    detventas.idventa, detventas.cantidad,
                    productos.idproducto, productos.producto,
                    productos.precio, (detventas.cantidad * productos.precio) AS total,
                    productos.imagen, catproductos.idcatproducto,
                    catproductos.categoria,ventas.estado
                    FROM ventas
                    INNER JOIN usuarios ON ventas.idusuario = usuarios.idusuario
                    INNER JOIN detventas ON detventas.idventa = ventas.idventa
                    INNER JOIN productos ON detventas.idproducto = productos.idproducto
                    INNER JOIN catproductos ON productos.idcatproducto = catproductos.idcatproducto
					WHERE ventas.idventa = {$row['idventa']}";
				$stmt2 = $this->db->prepare($query2);
				$stmt2->execute();
				?>
				<tr>
					<th scope="row"><?php echo $row['idventa']; ?></th>
					<td><?php echo $row['fechaventa'] ?></td>
					<td colspan="6"></td>
				</tr>
						<?php
				if($stmt2->rowCount()>0)
				{
					$totalrow = 0;
					while($row2=$stmt2->fetch(PDO::FETCH_ASSOC))
					{
						$totalrow += $row2['total'];
						$totals += $row2['total'];
						?>
						<tr>
							<th scope="row"><?php echo $row2['idventa'] ?></th>
							<td><?php echo $row2['usuarionom'] ?></td>
							<td><?php echo $row2['fechaventa']; ?></td>
							<td><img class="img-thumbnail img-fluid" src="../model/productos/<?php echo $row2['imagen']; ?>" alt="" style="width: 100px;"></td>
							<td><?php echo $row2['producto']; ?></td>
							<td><?php echo $row2['categoria']; ?></td>
							<td><?php echo $row2['cantidad']; ?></td>
							<td align="right"><?php echo "$ ".number_format($row2['total'], 2); ?></td>
						</tr>
						<?php
					}
					?>
					<tr class="bg-primary">
						<td colspan="7">Total				
						</td>
						<td align="right"><?php echo "$ ".number_format($totalrow, 2); ?></td>
					</tr>
					<?php
				}
				else
				{
					$totalrow = 0;
					?>
					<tr class="bg-primary">
						<td colspan="7">Total				
						</td>
						<td><?php echo "$ ".number_format($totalrow, 2); ?></td>
					</tr>
					<?php
				}
			}
			?>
			<tr><td colspan="8"></td></tr>
				<tr class="bg-danger">
					<td colspan="7">Grand Total</td>
					<td align="right"><?php echo "$ ".number_format($totals, 2); ?></td>
				</tr>
			<?php
		}
	}	
//////------	END VENTA 	    ------\\\\\\

//////------	  DETALLES 		------\\\\\\
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

	public function getIdDetalles($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM detventas WHERE iddetventa=:id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

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

		public function updateDetallesConcurrencia($iddetventa, $idventa, $idproducto, $cantidad, $can)
		{
			try
			{
				//echo "<script>alert('".$datos['cantidad']."');</script>";
				//$diferencia = $cantidad - $can;

				$SQL = "UPDATE detventas SET 
						idventa = :idventa, 
						idproducto = :idproducto, 
						cantidad = :cantidad 
						WHERE 
						iddetventa = :iddetventa 
						AND
						cantidad = " .$can;

				$stmt = $this->db->prepare($SQL);
				$stmt->bindparam(":idventa", $idventa);
				$stmt->bindparam(":idproducto", $idproducto);
				$stmt->bindparam(":cantidad", $cantidad);
				$stmt->bindparam(":iddetventa", $iddetventa);
				$stmt->execute();
				$count = $stmt->rowCount();
				if ($count == 0) 
				{
					$datos = $this->getIdDetalles($iddetventa);
					echo "<script>alert('El registro se actualizo recientementes, Se intentara de nuevo');</script>";
					/*$this->updateDetallesConcurrencia($iddetventa, $idventa, $idproducto, $cantidad, $datos['cantidad']);*/
					$cantidadtotal = ($cantidad-$can) + $datos['cantidad'];
					$SQL = "UPDATE detventas SET 
						idventa = :idventa, 
						idproducto = :idproducto, 
						cantidad = :cantidad 
						WHERE 
						iddetventa = :iddetventa";

					$stmt = $this->db->prepare($SQL);
					$stmt->bindparam(":idventa", $idventa);
					$stmt->bindparam(":idproducto", $idproducto);
					$stmt->bindparam(":cantidad", $cantidadtotal);
					$stmt->bindparam(":iddetventa", $iddetventa);
					$stmt->execute();
				}
				else
				{
					echo "<script>alert('El registro se actualizo exitosamente');</script>";
					
				}
				//$stmt->close();
				return true;	
			}
			catch(PDOException $e)
			{

				echo $e->getMessage();	
				return false;
			}
		}

	public function deleteDetalles($id)
	{
		$stmt = $this->db->prepare("UPDATE detventas SET estado='Desactivado' WHERE iddetventa=:id");
		$stmt->bindparam(":id",$id);
		$stmt->execute();

		return true;
	}

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
					<th><?php if($_SESSION['idioma'] == "English") {echo "Sale";} else {echo "Venta";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Image";} else {echo "Imagen";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Quantity";} else {echo "Cantidad";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Price";} else {echo "Precio";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "State";} else {echo "Estado";} ?></th>
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
						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo $row['iddetventa']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row['iddetventa']; ?>">
							<i class="fa fa-pencil"></i>
						</button>
						</a>&nbsp;
						<button class="btn btn-outline-primary" onclick="ConfirmDemo<?php echo $row['iddetventa']; ?>()">
							<i class="fa fa-trash"></i>							
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
				            $can = $_POST['can'];
						        // if ($this->updateDetalles($iddetventa, $idventa, $idproducto, $cantidad)) 
						        // {
						        //  	echo "<script>location.href='detalles.php'</script>";
						        // }
						        // else
						        // {
						        //  	echo "<script>alert('Hubo un error al guardar el detalle de la venta');</script>";
						        // }
				            	if ($this->updateDetallesConcurrencia($iddetventa, $idventa, $idproducto, $cantidad, $can)) 
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
				              	<input class="form-control" name="can" type="hidden" value="<?php echo $row['cantidad']; ?>">
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

	public function dataviewDetallesReporte($query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
			<tr>
				<th>ID</th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Sale";} else {echo "Venta";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Quantity";} else {echo "Cantidad";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "State";} else {echo "Estado";} ?></th>
			</tr></thead><tbody>
			<?php
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

	public function dataviewDetallesReporteCompuesto($query)
	{
		$query = "SELECT iddetventa, idventa, producto, cantidad, detventas.estado
		FROM detventas INNER JOIN productos ON detventas.idproducto = productos.idproducto";
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
			<tr>
				<th>ID</th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Sale";} else {echo "Venta";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Quantity";} else {echo "Cantidad";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "State";} else {echo "Estado";} ?></th>
			</tr></thead><tbody>
			<?php
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
//////------	END DETALLES 	------\\\\\\

//////------	  CATEGORIAS    ------\\\\\\
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

	public function getIdCategorias($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM catproductos WHERE idcatproducto=:id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

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

	public function deleteCategorias($idcatproducto)
	{
		$stmt = $this->db->prepare("UPDATE catproductos SET estado='Desactivado' WHERE idcatproducto=:idcatproducto");
		$stmt->bindparam(":idcatproducto",$idcatproducto);
		$stmt->execute();

		return true;
	}

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
						<th><?php if($_SESSION['idioma'] == "English") {echo "Name category";} else {echo "Categoria";} ?></th>
						<th><?php if($_SESSION['idioma'] == "English") {echo "State";} else {echo "Estado";} ?></th>
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
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo $row['idcatproducto']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row['idcatproducto']; ?>"><i class="fa fa-pencil"></i></button>

							<button class="btn btn-outline-primary" onclick="ConfirmDemo<?php echo $row['idcatproducto']; ?>()">
							<i class="fa fa-trash"></i>							
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
						            <label for="" class="col-2 col-form-label text-white">
						            	<?php if($_SESSION['idioma'] == "English") {echo "Category name";} else {echo "Nombre de categoria";} ?>
						            </label>
							            <div class="col-10">
							              <input class="form-control" onKeyPress="return soloLetras(event);" type="text" value="<?php echo $row['categoria']; ?>" id="categoria" name="categoria" required>
							            </div>
						              	</div>
						              	<hr>
						              	<div class="form-group row">
						                	<div class="col-md-6 col-md-offset-6 text-xs-right">
						                  		<button type="submit" name="btnGuardar<?php echo $id; ?>" class="btn btn-outline-success">
						                  			<?php if($_SESSION['idioma'] == "English") {echo "Save";} else {echo "Guardar";} ?>
						                  		</button>
						                  		<a href="#" class="btn btn-outline-danger">
						                  			<?php if($_SESSION['idioma'] == "English") {echo "Cancel";} else {echo "Cancelar";} ?>
						                  		</a>
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

	public function dataviewCategoriaReporte($query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
			<tr>
				<th>ID</th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Full Name";} else {echo "Nombre";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "State";} else {echo "Estado";} ?></th>
			</tr></thead><tbody>
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
//////------	END CATEGORIAS	------\\\\\\

//////------	  PRODUCTOS		------\\\\\\
	public function createProductos($producto, $descripcion, $imagen, $precio, $catproduto)
	{
		try
		{
			$sql = "INSERT INTO productos VALUES (NULL, :producto, :descripcion, :imagen, :precio, :catproduto, 'Activo')";
			$stmt = $this->db->prepare($sql);
			$stmt->bindparam(":producto", $producto);
			$stmt->bindparam(":descripcion", $descripcion);
			$stmt->bindparam(":imagen", $imagen);
			$stmt->bindparam(":precio", $precio);
			$stmt->bindparam(":catproduto", $catproduto);
			$stmt->execute();

			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public function getIdProductos($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM productos WHERE idproducto=:id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function updateProductos($idproducto, $producto, $descripcion, $imagen, $precio, $idcatproducto)
	{
		try
		{
			//SELECT CONCAT(CURRENT_DATE(),' ',CURRENT_TIME()))
			$sql="UPDATE productos SET 
				producto = :producto, 
				descripcion= :descripcion, 
				imagen = :imagen, 
				precio = :precio, 
				idcatproducto = :idcatproducto 
				WHERE idproducto = :idproducto";
			$stmt=$this->db->prepare($sql);
			$stmt->bindparam(":producto",$producto);
			$stmt->bindparam(":descripcion",$descripcion);
			$stmt->bindparam(":imagen",$imagen);
			$stmt->bindparam(":precio",$precio);
			$stmt->bindparam(":idcatproducto",$idcatproducto);
			$stmt->bindparam(":idproducto",$idproducto);
			$stmt->execute();

			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public function deleteProductos($idproducto)
	{
		$stmt = $this->db->prepare("UPDATE productos SET estado = 'Desactivado' WHERE idproducto=:idproducto");
		$stmt->bindparam(":idproducto",$idproducto);
		$stmt->execute();

		return true;
	}

	public function dataviewProductos($query)
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
					<th><?php if($_SESSION['idioma'] == "English") {echo "Image";} else {echo "Imagen";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Description";} else {echo "Descripcion";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Price";} else {echo "Precio";} ?></th>
					<th><?php if($_SESSION['idioma'] == "English") {echo "Category";} else {echo "Categoria";} ?></th>
					<th width="150px"></th>
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
						<th scope="row"><?php echo $row['idproducto']; ?></th>
						<td><img class="img-thumbnail img-fluid" src="../model/productos/<?php echo $row['imagen']; ?>" alt="" style="width: 200px;"></td>
						<td><?php echo $row['producto']; ?></td>
						<td><?php echo $row['descripcion']; ?></td>
						<td><?php echo number_format($row['precio'], 2); ?></td>
						<td><?php echo $row['categoria']; ?></td>
						<td>
							<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo $row['idproducto']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row['idproducto']; ?>">
								 <i class="fa fa-pencil"></i>
							</button>&nbsp;
							<button class="btn btn-outline-primary" onclick="ConfirmDemo<?php echo $row['idproducto']; ?>()">
								 <i class="fa fa-trash"></i>							
							</button>
						</td>
					</tr>
					<tr>
						<td colspan="7">
							<div class="collapse" id="collapse<?php echo $row['idproducto']; ?>">
								<div class="card card-block card-inverse" style="background-color: #333; border-color: #333;">
								  <?php
								  	$id = $row['idproducto'];
									  if (isset($_POST["btnGuardar{$id}"])) 
									  {
									  	$producto = $_POST['producto'];
					            $descripcion = $_POST['descripcion'];
					            $idcatproducto = $_POST['idcatproducto'];
					            $precio = $_POST['precio'];     

					            $imgFile = $_FILES['user_image']['name'];
					            $tmp_dir = $_FILES['user_image']['tmp_name'];
					            $imgSize = $_FILES['user_image']['size'];

					            if ($imgFile)
				              {
				                $upload_dir = '../model/productos/';
				                $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension        
				                // valid image extensions
				                $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'jpe'); // valid extensions
				                // rename uploading image
				                //$userpic = rand(1000,1000000).".".$imgExt;
				                $userpic = rand(1000,1000000).".png";
				                unlink($upload_dir."//".$row['imagen']);
				                $imgprod = $userpic;
				                if(in_array($imgExt, $valid_extensions))
				                {
				                  // Check file size '5MB'
				                  if($imgSize < 5000000)
				                  {
				                    move_uploaded_file($tmp_dir, $upload_dir.$userpic);
				                    $idproducto = $row['idproducto'];
				                    if ($this->updateProductos($idproducto, $producto, $descripcion, $imgprod, $precio, $idcatproducto)) 
				                    {
				                      echo "<script>location.href='productos.php'</script>";
				                    }
				                    else
				                    {
				                      echo "<script>alert('Hubo un error al guardar el producto');</script>";
				                    }
				                  }
				                  else
				                  {
				                    ?>
				                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
				                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				                        <span aria-hidden="true">&times;</span>
				                      </button>
				                      <p><strong>La imagen excede el tamaño permitido</strong></p>
				                    </div>
				                    <?php
				                  }
				                }
				                else
				                {
				                  ?>
				                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
				                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				                      <span aria-hidden="true">&times;</span>
				                    </button>
				                    <p><strong>Formato incorrecto.</strong></p>
				                  </div>
				                  <?php
				                }
				              }
				              else
				              {
				                $imgprod = $row['imagen'];
				                $idproducto = $row['idproducto'];
				                if ($this->updateProductos($idproducto, $producto, $descripcion, $imgprod, $precio, $idcatproducto)) 
				                {
				                  echo "<script>location.href='productos.php'</script>";
				                }
				                else
				                {
				                  echo "<script>alert('Hubo un error al guardar la venta');</script>";
				                }
				              }
				            }
							    ?>
								  <form method="POST" enctype="multipart/form-data" >
							      <div class="form-group row"><!-- Producto -->
							        <label for="" class="col-2 col-form-label text-white">Producto</label>
							        <div class="col-10">
							          <input type="text" class="form-control" value="<?php echo $row['producto']; ?>" id="producto" name="producto" placeholder="Nombre del producto">
							        </div>
							      </div>
							      <div class="form-group row"><!-- Descripcion -->
							        <label for="" class="col-2 col-form-label text-white">Descripcion</label>
							        <div class="col-10">
							        	<textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $row['descripcion']; ?></textarea>
							        </div>
							      </div>
							      <div class="form-group row"><!-- Imagen -->
							        <label for="" class="col-2 col-form-label text-white">Imagen</label>
							        <div class="col-10">
							          <img src="../model/productos/<?php echo $row['imagen']; ?>" alt="Seleccione una imagen" style="color: #FFF; width: 100px;">
							            <input type="file" class="form-control-file" id="user_image" name="user_image" style="color: #FFF;" accept="image/*">
							        </div>
							      </div>
							      <div class="form-group row"><!-- Categoria -->
							        <label for="" class="col-2 col-form-label text-white">Categoria</label>
							        <div class="col-10">
							          <select class="form-control" id="idcatproducto" name="idcatproducto" required>
							            <?php
							              $sql = "SELECT * FROM catproductos WHERE idcatproducto IN
							                (SELECT idcatproducto FROM productos WHERE idproducto = {$row['idproducto']})";
							                $this->OptionCategorias($sql);
							              $sql = "SELECT * FROM catproductos WHERE idcatproducto NOT IN
							                (SELECT idcatproducto FROM productos WHERE idproducto = {$row['idproducto']})";
							                $this->OptionCategorias($sql);						                    
							            ?>
							          </select>
							        </div>
							      </div>    
							      <div class="form-group row"><!-- Precio -->
							        <label for="" class="col-2 col-form-label text-white">Precio</label>
							        <div class="col-10">
							          <input class="form-control" onkeypress="return soloNumeros(event);" type="text" value="<?php echo $row['precio']; ?>" id="precio" name="precio" required>
							        </div>
							      </div>
							      <hr>
							      <div class="form-group row">
							        <div class="col-md-6 col-md-offset-6 text-xs-right">
							          <button type="submit" name="btnGuardar<?php echo $id; ?>" class="btn btn-outline-success">Guardar</button>
							          <a href="productos.php" class="btn btn-outline-danger">Cancelar</a>
							        </div>
							      </div>
							    </form>
							    <script type="text/javascript">
										function ConfirmDemo<?php echo $row['idproducto']; ?>() {
											//Ingresamos un mensaje a mostrar
											var mensaje = confirm("¿Esta seguro que quiere eliminar el registro?");
											//Detectamos si el usuario acepto el mensaje
											if (mensaje) {
												location.href='productos-del.php?id=<?php echo $row['idproducto']; ?>';
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

	public function OptionCategorias($query )
	{
		$stmt = $this->db->prepare($query);
	    $stmt->execute();
	    if($stmt->rowCount() > 0)
	    {
	    	while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) 
	      {?>
	    		<option value="<?php echo $row['idcatproducto'] ?>">
	      		<?php echo $row['categoria']; ?>
	        </option>
	        <?php
	      }
	    }
	}

	public function dataviewProductoReporte($query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
			<tr>
				<th>ID</th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Image";} else {echo "Imagen";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Description";} else {echo "Descripcion";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Price";} else {echo "Precio";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Category";} else {echo "Categoria";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "State";} else {echo "Estado";} ?></th>
			</tr></thead><tbody>
			<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				if($row['estado'] == "Desactivado")
				{echo "<tr class='bg-danger'>";}
				else{echo "<tr>";}
				?>
				<th scope="row"><?php echo $row['idproducto']; ?></th>
				<td><img class="img-thumbnail img-fluid" src="../model/productos/<?php echo $row['imagen']; ?>" alt="" style="width: 200px;"></td>
				<td><?php echo $row['producto']; ?></td>
				<td><?php echo $row['descripcion']; ?></td>
				<td><?php echo number_format($row['precio'], 2); ?></td>
				<td><?php echo $row['idcatproducto']; ?></td>
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

	public function dataviewProductoReporteCompuesto($query)
	{
		$query="SELECT idproducto, producto, descripcion, imagen, precio,
		productos.estado, categoria FROM productos
		INNER JOIN catproductos ON productos.idcatproducto = catproductos.idcatproducto";
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			?>
			<thead class='thead-default'>
			<tr>
				<th>ID</th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Image";} else {echo "Imagen";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Product";} else {echo "Producto";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Description";} else {echo "Descripcion";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Price";} else {echo "Precio";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "Category";} else {echo "Categoria";} ?></th>
				<th><?php if($_SESSION['idioma'] == "English") {echo "State";} else {echo "Estado";} ?></th>
			</tr></thead><tbody>
			<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				if($row['estado'] == "Desactivado")
				{echo "<tr class='bg-danger'>";}
				else{echo "<tr>";}
				?>
				<th scope="row"><?php echo $row['idproducto']; ?></th>
				<td><img class="img-thumbnail img-fluid" src="../model/productos/<?php echo $row['imagen']; ?>" alt="" style="width: 200px;"></td>
				<td><?php echo $row['producto']; ?></td>
				<td><?php echo $row['descripcion']; ?></td>
				<td><?php echo number_format($row['precio'], 2); ?></td>
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
//////------	END PRODUCTOS   ------\\\\\\

//////------  	  CART          ------\\\\\\ 
	public function dataviewCart($query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		if($stmt->rowCount()>0)
		{?>
			<div class="row">
			<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				?>
				<div class="col-md-4">
				<form name="segundo" method="post" action="cart_update.php">
					<div class="col-md-12" method="post" action="cart_update.php">
                    <div class="card text-center card-inverse" style="background-color: #222; border-color: #444;">
                    	<div class="card-header"><?php echo $row['producto']; ?></div>
                    	<p class="text-xs-center"><br>	
                        <img class="card-img-top img-thumbnail rounded img-fluid" src="../model/productos/<?php echo $row['imagen']; ?>" style="width: 100px; height: 100px;" alt="Card image cap">
                      	</p>
                      <div class="card-block">
                        <p class="card-text">
                        	Precio: <?php echo number_format($row['precio'], 2); ?>
                        </p>
                        <label for="product_qty">Cantidad: </label>
						<input type="text" class="form-control text-black form-sm" size="2" maxlength="2" onkeypress="return soloNumeros(event);" name="product_qty" value="1">
                        <input type="hidden" name="idproducto" value="<?php echo $row['idproducto']; ?>" />
                        <input type="hidden" name="imagen" value="<?php echo $row['imagen']; ?>" />
						<input type="hidden" name="type" value="add" />
						<input type="hidden" name="return_url" value="<?php echo $current_url; ?>" /><br>
						<div class="card-footer text-muted">
						<button type="submit" class="btn btn-sm btn-primary form-control" name="segundo">Agregar</button>
						</div>
                      </div>
                    </div>
                  </div>
				</form>
				</div>
				<?php
			}
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

	public function carrito()
	{

	}
//////------  	END CART        ------\\\\\\ 

//////------	PAGINATION		------\\\\\\
	public function paging($query,$records_per_page)
	{
		$starting_position=0;
		if(isset($_GET["page"]))
		{
			$starting_position = ($_GET["page"]-1)*$records_per_page;
		}
		$query2=$query." limit $starting_position, $records_per_page";
		return $query2;
	}

	public function paginglink($query, $records_per_page)
	{
		$self = $_SERVER['PHP_SELF'];
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$total_no_of_records = $stmt->rowCount();
		if($total_no_of_records > 0)
		{
			?>
			<nav aria-label="Page navigation example">
  				<ul class="pagination justify-content-center">
			<?php
			$total_no_of_pages=ceil($total_no_of_records/$records_per_page);
			$current_page=1;
			if(isset($_GET["page"]))
			{
				$current_page=$_GET["page"];
			}
			if($current_page != 1)
			{
				$previous =$current_page-1;
				echo "<li class='page-item'>
				<a class='page-link' href='".$self."?page=1'>Primera</a></li>";
				//echo "<li><a style=color:black; href='".$self."&page_no=1'>Primera</a></li>";	

				echo "<li class='page-item'>
				<a class='page-link' href='".$self."?page=".$previous."'>Anterior</a></li>";
				//echo "<li><a style=color:black; href='".$self."&page_no=".$previous."'>Anterior</a></li>";
			}
			for($i=1; $i<=$total_no_of_pages; $i++)
			{
				if($i==$current_page)
				{
					echo "<li class='page-item active'>
					<a class='page-link' href='".$self."?page=".$i."'>".$i."</a></li>";
					//echo "<li><a href='".$self."&page_no=".$i."' style='color:yellow; text-shadow: 0px 2px 2px black; background-color: black;'>".$i."</a></li>";
				}
				else
				{
					echo "<li class='page-item'>
					<a class='page-link' href='".$self."?page=".$i."'>".$i."</a></li>";

					//echo "<li><a style=color:black; href='".$self."&page_no=".$i."'>".$i."</a></li>";
				}
			}
			if($current_page!=$total_no_of_pages)
			{
				$next=$current_page+1;
				echo "
				<li class='page-item'>
					<a class='page-link' href='".$self."?page=".$next."'>Siguiente</a>
				</li>";
				//echo "<li><a href='".$self."&page_no=".$next."' style='color:black;'>Siguiente</a></li>";

				echo "
				<li class='page-item'>
					<a class='page-link' href='".$self."?page=".$total_no_of_pages."'>Última</a>
				</li>";
				//echo "<li><a href='".$self."&page_no=".$total_no_of_pages."' style='color:black;>Última</a></li>";
			}
			?>
				</ul>
			</nav>
			<?php
		}
	}
}