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
              $reporte = isset($_GET['reporte']) ? $_GET['reporte'] : die("<h3 class='text-white text-xs-center'>Necesito el nombre del reporte</h3>");
            ?>
            <?php
              if ($reporte == "usuarios") 
              {?>
                <div class="col-xs-10">
                  <?php
                    if (isset($_POST['btnsearch'])) 
                    {
                      $idusuario = $_POST['idusuario'];
                    }
                    else
                    {
                      $idusuario = "";
                    }
                  ?>
                  <form method="POST">
                    <div class="form-group row">                      
                      <div class="col-md-2">
                        <label for="fechaini" class="text-white">Usuarios</label>
                      </div>
                      <div class="col-md-5">
                        <select name="idusuario" id="idusuario" class="form-control">
                          <?php
                            $crud->OptionUsuarios("SELECT * FROM usuarios")
                          ?>
                        </select> 
                      </div>
                      <div class="col-md-2">
                        <button class="btn btn-default" name="btnsearch" type="submit">Buscar</button>
                      </div>
                    </div>
                  </form>
                </div>
                <table class="table table-hover table-inverse">
                  <?php
                    $query = "SELECT
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
                    FROM
                    ventas
                    INNER JOIN usuarios ON ventas.idusuario = usuarios.idusuario
                    INNER JOIN detventas ON detventas.idventa = ventas.idventa
                    INNER JOIN productos ON detventas.idproducto = productos.idproducto
                    INNER JOIN catproductos ON productos.idcatproducto = catproductos.idcatproducto
                    WHERE usuarios.idusuario = {$idusuario}";
                    $crud->dataviewVentaReporteSumarios($query);
                  ?>
                </table>
                <?php
              }

              if ($reporte == "ventas") 
              {?>
                <div class="col-xs-10">
                  <?php
                    if (isset($_POST['btnsearch'])) 
                    {
                      $idventa = $_POST['idventa'];
                    }
                    else
                    {
                      $idventa = "";
                    }
                  ?>
                  <form method="POST">
                    <div class="form-group row">                      
                      <div class="col-md-2">
                        <label for="fechaini" class="text-white">Ventas</label>
                      </div>
                      <div class="col-md-6">
                        <select name="idventa" id="idventa" class="form-control">
                          <?php
                            $crud->OptionVenta("SELECT ve.idventa, CONCAT(us.nomusuario,' ',us.appusuario,' ', us.apmusuario)AS nombreusuario,
                            ve.fechaventa, ve.totalventa, ve.estado FROM ventas AS ve INNER JOIN usuarios as us on ve.idusuario = us.idusuario ORDER BY ve.idventa");
                          ?>
                        </select> 
                      </div>
                      <div class="col-md-2">
                        <button class="btn btn-default" name="btnsearch" type="submit">Buscar</button>
                      </div>
                    </div>
                  </form>
                </div>
                <table class="table table-hover table-inverse">
                  <?php
                    $query = "SELECT
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
                    WHERE ventas.idventa = {$idventa}";
                    $crud->dataviewVentaReporteSumarios($query);
                  ?>
                </table>
                <?php
              }

              if ($reporte == "categorias") 
              {?>
                <div class="col-xs-10">
                  <?php
                    if (isset($_POST['btnsearch'])) 
                    {
                      $idcatproducto = $_POST['idcatproducto'];
                    }
                    else
                    {
                      $idcatproducto = "";
                    }
                  ?>
                  <form method="POST">
                    <div class="form-group row">                      
                      <div class="col-md-2">
                        <label for="fechaini" class="text-white">Categoria</label>
                      </div>
                      <div class="col-md-6">
                        <select name="idcatproducto" id="idcatproducto" class="form-control">
                          <?php
                            $crud->OptionCategorias("SELECT * FROM catproductos");
                          ?>
                        </select> 
                      </div>
                      <div class="col-md-2">
                        <button class="btn btn-default" name="btnsearch" type="submit">Buscar</button>
                      </div>
                    </div>
                  </form>
                </div>
                <table class="table table-hover table-inverse">
                  <?php
                    $query = "SELECT
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
                    FROM
                    ventas
                    INNER JOIN usuarios ON ventas.idusuario = usuarios.idusuario
                    INNER JOIN detventas ON detventas.idventa = ventas.idventa
                    INNER JOIN productos ON detventas.idproducto = productos.idproducto
                    INNER JOIN catproductos ON productos.idcatproducto = catproductos.idcatproducto
                    WHERE catproductos.idcatproducto = {$idcatproducto}";
                    $crud->dataviewVentaReporteSumarios($query);
                  ?>
                </table>
                <?php
              }

              if ($reporte == "productos") 
              {?>
                <div class="col-xs-10">
                  <?php
                    if (isset($_POST['btnsearch'])) 
                    {
                      $idproducto = $_POST['idproducto'];
                    }
                    else
                    {
                      $idproducto = "";
                    }
                  ?>
                  <form method="POST">
                    <div class="form-group row">                      
                      <div class="col-md-2">
                        <label for="fechaini" class="text-white">Productos</label>
                      </div>
                      <div class="col-md-6">
                        <select name="idproducto" id="idproducto" class="form-control">
                          <?php
                            $crud->OptionProductos("SELECT * FROM productos");
                          ?>
                        </select> 
                      </div>
                      <div class="col-md-2">
                        <button class="btn btn-default" name="btnsearch" type="submit">Buscar</button>
                      </div>
                    </div>
                  </form>
                </div>
                <table class="table table-hover table-inverse">
                  <?php
                    $query = "SELECT
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
                    FROM
                    ventas
                    INNER JOIN usuarios ON ventas.idusuario = usuarios.idusuario
                    INNER JOIN detventas ON detventas.idventa = ventas.idventa
                    INNER JOIN productos ON detventas.idproducto = productos.idproducto
                    INNER JOIN catproductos ON productos.idcatproducto = catproductos.idcatproducto
                    WHERE productos.idproducto = {$idproducto}";
                    $crud->dataviewVentaReporteSumarios($query);
                  ?>
                </table>
                <?php
              }
            ?>
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