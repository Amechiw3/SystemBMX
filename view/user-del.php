<?php
	include_once"../model/config.php";
  	$config = new Config();
  	$db = $config->get_Connection();

  	include_once '../controller/class.crud.php';
  	$crud = new crud($db);

	$id = isset($_GET['id']) ? $_GET['id'] : die('Necesito el ID');
	if ($crud->deleteUsuario($id)) {
		echo "<script>location.href='tabla.php?tabla=usuarios'</script>";
	}
	else {
		echo "<script>alert('Falla al borrar el registro');</script>";
	}
?>