<?php
  session_start();
  if (!isset($_SESSION['idusuario'])) 
  {
    echo "<script>alert('Necesitas logearte para acceder');</script>";
    echo "<script>location.href='../index.php'</script>";
  }
  if ($_SESSION['estado'] != "Activado") 
  {
    echo "<script>alert('Cuenta desactivada');</script>";
    echo "<script>location.href='../index.php'</script>";
  }

  include_once"../model/config.php";
  $config = new Config();
  $db = $config->get_Connection();

  include_once '../controller/class.crud.php';
  $crud = new crud($db);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v3.11.1, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../model/bmx.png" type="image/x-icon">
  <meta name="description" content=""> 
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/fonts/Lora.css">
  <link rel="stylesheet" href="../assets/fonts/Montserrat.css">
  <link rel="stylesheet" href="../assets/fonts/Raleway.css">
  <link rel="stylesheet" href="../assets/bootstrap-material-design-font/css/material.css">
  <link rel="stylesheet" href="../assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="../assets/tether/tether.min.css">
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/dropdown/css/style.css">
  <link rel="stylesheet" href="../assets/animate.css/animate.min.css">
  <link rel="stylesheet" href="../assets/socicon/css/styles.css">
  <link rel="stylesheet" href="../assets/theme/css/style.css">
  <link rel="stylesheet" href="../assets/mobirise/css/mbr-additional.css" type="text/css">
  <link href="../libs/bootstrap4/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body{
      background-color: rgb(33, 33, 33);
    }
  </style>
</head>
<body>
  <?php include_once("menu.php"); ?>

  <section class="mbr-section" id="form2-m" style="background-color: rgb(33, 33, 33); padding-top: 120px; padding-bottom: 0px;">
    <div class="mbr-section mbr-section-nopadding">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-lg-12" data-form-type="formoid">
            <script>
              function soloLetras(e) {
                key = e.keyCode || e.which;
                tecla = String.fromCharCode(key).toString();
                letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
                //Se define todo el abecedario que se quiere que se muestre.
                especiales = [8,6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.
                    
                tecla_especial = false
                for(var i in especiales) {
                  if(key == especiales[i]) {
                    tecla_especial = true;
                    break;
                  }
                }
                if(letras.indexOf(tecla) == -1 && !tecla_especial){
                  alert('Solo se Acepta Letras');
                  return false;
                }
              }
            </script>
            <?php
              $accion = isset($_GET['accion']) ? $_GET['accion'] : die("<h3 class='text-white text-xs-center'>Necesito la accion</h3>");
              if ($accion == 'edicion') 
              {
                $id = isset($_GET['id']) ? $_GET['id'] : die("<h3 class='text-white text-xs-center'>Necesito el ID</h3>");
                $datos = $crud->getIdUsuario($id);
              }
              else
              {
                $datos = null;
              }

              if (isset($_POST['btnGuardar'])) 
              {
                if ($accion == 'edicion') 
                {
                  $idusuario = $datos['idusuario'];
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
                  if ($crud->updateUsuario($idusuario, $nomusuario, $appusuario, $apmusuario, $usuario, $password, $email, $catusuario, $idioma)) 
                  {
                    echo "<script>location.href='tabla.php?tabla=usuarios'</script>";
                  }
                  else
                  {
                    echo "<script>alert('Hubo un error al guardar al usuario');</script>";
                  }
                }
                else //Nuevo Registro
                {
                  $nomusuario = $_POST['nomusuario'];
                  $appusuario = $_POST['appusuario'];
                  $apmusuario = $_POST['apmusuario'];
                  $usuario = $_POST['usuario'];
                  $password = md5($_POST['password']);
                  $email = $_POST['email'];
                  $catusuario = $_POST['catusuario'];
                  $idioma = $_POST['idioma'];
                  if ($crud->createUsuario($nomusuario, $appusuario, $apmusuario, $usuario, $password, $email, $catusuario, $idioma)) 
                  {
                    echo "<script>alert('Usuario Guardado');</script>";
                  }
                  else
                  {
                    echo "<script>alert('Hubo un error al guardar al usuario');</script>";
                  }
                }  
              }
              if (isset($_POST['btnsearch'])) 
              {
                $nams = $_POST['nomUsu'];
                $fec = "WHERE fechaventa > '{$nams}'";
              }
              else
              {
                $nams = "";
              }
            ?>
            <div class="row">
              <div class="col-xs-6">
                <form method="POST">
                  <div class="form-group row">
                    <div class="col-10">
                      <input type="text" class="form-control" onKeyPress="return soloLetras(event);" name="nomUsu" placeholder="Buscar por nombre">
                    </div>
                    <div class="col-2">
                      <button class="btn btn-default" name="btnsearch" type="submit">Buscar</button>
                    </div>
                  </div>
                </form>        
              </div>
              <div class="col-xs-6">
                <div class="text-xs-right">
                  <a class="btn btn-primary" href="user-add.php?accion=nuevo#add">
                    <span class="mbri-plus mbr-iconfont mbr-iconfont-btn"></span>
                    Agregar Usuarios
                  </a>
                </div>
              </div>
            </div><br>
          <table class="table table-hover table-inverse">
            <?php
              $records_per_page = 5;
              $query = "SELECT * FROM usuarios where CONCAT(nomusuario,' ',appusuario,' ',apmusuario) LIKE'%{$nams}%' ";          
              $tab = "?tabla=usuarios";
              $newquery = $crud->paging($query, $records_per_page);
              $crud->dataviewUsuarios($newquery);
            ?>
          </table>
          <div class="text-xs-center"><?php $crud->paginglink($tab,$query,$records_per_page); ?></div>
          <br>
            <div class="container-fluid" id="add" style="background-color: rgb(33, 33, 33); padding-top: 120px; padding-bottom: 0px;">
              <form method="POST">
                <div class="form-group row"><!-- nomusuario -->
                  <label for="" class="col-2 col-form-label text-white">Nombre</label>
                  <div class="col-10">
                    <input class="form-control" onKeyPress="return soloLetras(event);" type="text" value="<?php echo $datos['nomusuario']; ?>" id="nomusuario" name="nomusuario" required>
                  </div>
                </div>
                <div class="form-group row"><!-- appusuario -->
                  <label for="" class="col-2 col-form-label text-white">Apellido Paterno</label>
                  <div class="col-10">
                    <input class="form-control" onKeyPress="return soloLetras(event);" type="text" value="<?php echo $datos['appusuario']; ?>" id="appusuario" name="appusuario" required>
                  </div>
                </div>
                <div class="form-group row"><!-- apmusuario -->
                  <label for="" class="col-2 col-form-label text-white">Apellido Materno</label>
                  <div class="col-10">
                    <input class="form-control" onKeyPress="return soloLetras(event);" type="text" value="<?php echo $datos['apmusuario']; ?>" id="apmusuario" name="apmusuario" required>
                  </div>
                </div>
                <div class="form-group row"><!-- usuario -->
                  <label for="" class="col-2 col-form-label text-white">Usuario</label>
                  <div class="col-10">
                    <input class="form-control" onKeyPress="return soloLetras(event);" type="text" value="<?php echo $datos['usuario']; ?>" id="usuario" name="usuario" required>
                  </div>
                </div>
                <div class="form-group row"><!-- password -->
                  <label for="" class="col-2 col-form-label text-white">Password</label>
                  <div class="col-10">
                    <input class="form-control" onKeyPress="return soloLetras(event);" type="password" value="" id="password" name="password" <?php if ($accion != 'edicion') {echo "required";}?> >
                  </div>
                </div>
                <div class="form-group row"><!-- email -->
                  <label for="" class="col-2 col-form-label text-white">Email</label>
                  <div class="col-10">
                    <input class="form-control" type="email" value="<?php echo $datos['email']; ?>" id="email" name="email" required>
                  </div>
                </div>
                <div class="form-group row"><!-- catusuario -->
                  <label for="" class="col-2 col-form-label text-white">Categoria</label>
                  <div class="col-10">
                    <select class="form-control" id="catusuario" name="catusuario" required>
                      <option value="<?php echo $datos['catusuario']; ?>"><?php echo $datos['catusuario']; ?></option>
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
                      <option value="<?php echo $datos['idioma']; ?>"><?php echo $datos['idioma']; ?></option>
                      <option value="Espanol">Español</option>
                      <option value="English">English</option>
                    </select>
                  </div>
                </div>
                <hr>
                <div class="form-group row">
                  <div class="col-md-6 col-md-offset-6 text-xs-right">
                    <button type="submit" name="btnGuardar" class="btn btn-outline-success">Guardar</button>
                    <a href="tabla?tabla=usuarios" class="btn btn-outline-danger">Cancelar</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <footer class="mbr-small-footer mbr-section mbr-section-nopadding" id="footer1-g" style="background-color: rgb(33, 33, 33); padding-top: 1.75rem; padding-bottom: 1.75rem;">  
    <div class="container">
      <p class="text-xs-center">Copyright &copy; 2017 Martin Fierro Robles.</p>
    </div>
  </footer>

  <script src="../assets/web/assets/jquery/jquery.min.js"></script>
  <script src="../assets/tether/tether.min.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/smooth-scroll/SmoothScroll.js"></script>
  <script src="../assets/dropdown/js/script.min.js"></script>
  <script src="../assets/touchSwipe/jquery.touchSwipe.min.js"></script>
  <script src="../assets/viewportChecker/jquery.viewportchecker.js"></script>
  <script src="../assets/jarallax/jarallax.js"></script>
  <script src="../assets/social-likes/social-likes.js"></script>
  <script src="../assets/theme/js/script.js"></script>
  <input name="animation" type="hidden">
  </body>
</html>