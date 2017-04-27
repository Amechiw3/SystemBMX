<?php
	public function getIdDetalles($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM detventas WHERE iddetventa=:id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	
		public function updateDetallesConcurrencia($iddetventa, $idventa, $idproducto, $cantidad, $cantidadActual)
		{
			try
			{
				$SQL = "UPDATE detventas SET 
						idventa = :idventa, 
						idproducto = :idproducto, 
						cantidad = :cantidad 
						WHERE 
						iddetventa = :iddetventa 
						AND
						cantidad = " .$cantidadActual;

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
					$cantidadtotal = ($cantidad-$cantidadActual) + $datos['cantidad'];
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