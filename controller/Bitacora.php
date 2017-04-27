<?php
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
			// 
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
?>