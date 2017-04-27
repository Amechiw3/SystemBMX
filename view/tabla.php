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

  <!-- DATETIMEPICKER -->
    <link rel="stylesheet" href="../libs/datetimepicker/css/bootstrap-datetimepicker.css">
   <!-- DATETIMEPICKER -->
 
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
          <!-- <div class="col-xs-12 col-lg-10 col-lg-offset-1" data-form-type="formoid">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
              </span>
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </section>

  <script>
    function soloLetras(e) 
    {
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

  <script>
    function impre(num) {
      document.getElementById(num).className="ver";
      print();
      document.getElementById(num).className="nover";
    }
  </script>

  <section class="mbr-section mbr-section-md-padding" id="social-buttons3-4" style="background-color: rgb(33, 33, 33); padding-top: 15px; padding-bottom: 30px;">
    <div class="container">

      <?php
        $tabla = isset($_GET['tabla']) ? $_GET['tabla'] : die("<h3 class='text-white text-xs-center'>Necesito el nombre de la tabla</h3>");

        if (isset($_POST['btnsearch'])) 
        {
          $nams = $_POST['nomUsu'];
          $fec = "WHERE fechaventa > '{$nams}'";
        }
        else
        {
          $nams = "";
        }

        $records_per_page = 5;
      if ($tabla == "usuarios") { ?>
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
            $query = "SELECT * FROM usuarios where CONCAT(nomusuario,' ',appusuario,' ',apmusuario) LIKE'%{$nams}%' ";          
            $tab= "?tabla=usuarios";
            $newquery = $crud->paging($query,$records_per_page);
            $crud->dataviewUsuarios($newquery);
          ?>
        </table>
        <div class="text-xs-center"><?php $crud->paginglink($tab,$query,$records_per_page); ?></div>
        <?php
      }

      if ($tabla == "ventas") { ?>
        <div class="row">
          <div class="col-xs-6">
            <form method="POST">
              <div class="form-group row">
                <div class="col-md-11">
                  <!-- <div class="col-md-7">
                    <input type="text" class="form-control" onKeyPress="return soloLetras(event);" name="nomUsu" placeholder="Buscar por nombre">
                  </div> -->
                  <div class="input-group date form_date ">
                    <input class="form-control" size="16" type="text" value="" readonly name="nomUsu">
                    <!-- <span class="input-group-addon"><span class="fa fa-remove"></span></span> -->
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  </div>    
                </div>
                <div class="col-md-1">
                  <button class="btn btn-default" name="btnsearch" type="submit">Buscar</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-xs-6">
            <div class="text-xs-right">
              <a class="btn btn-primary" href="ventas.php?accion=nuevo#add">
                <span class="mbri-plus mbr-iconfont mbr-iconfont-btn"></span>
                Agregar Ventas
              </a>
            </div>
          </div>
        </div><br>
        <table class="table table-hover table-inverse">
          <?php 
            $query = "SELECT ve.idventa, CONCAT(us.nomusuario,' ',us.appusuario,' ', us.apmusuario)AS nombreusuario,ve.fechaventa, ve.totalventa, ve.estado FROM ventas AS ve INNER JOIN usuarios as us
              on ve.idusuario = us.idusuario ORDER BY ve.idventa ";
            $tab= "?tabla=ventas";
            $newquery = $crud->paging($query,$records_per_page);
            $crud->dataviewVentas($newquery);
          ?>
        </table>
        <div class="pagination-wrap"><?php $crud->paginglink($tab, $query, $records_per_page); ?></div>
        <?php
      }

      if ($tabla == "productos") { ?>
        <div class="row">
          <div class="col-xs-6">
            <form method="POST">
              <div class="form-group row">
                <div class="col-10">
                  <input type="text" class="form-control" onKeyPress="return soloLetras(event);" name="nomUsu" placeholder="Buscar por producto">
                </div>
                <div class="col-2">
                  <button class="btn btn-default" name="btnsearch" type="submit">Buscar</button>
                </div>
              </div>
            </form>        
          </div>
          <div class="col-xs-6">
            <div class="text-xs-right">
              <a class="btn btn-primary btn" href="productos?accion=nuevo#add">
                <span class="mbri-plus mbr-iconfont mbr-iconfont-btn"></span>
                Agregar Productos
              </a>
            </div>
          </div>
        </div><br>
        <table class="table table-hover table-inverse">
          <?php 
            $query = "SELECT pr.idproducto, pr.producto, pr.descripcion, pr.imagen, pr.precio, cp.categoria, pr.estado
              FROM productos AS pr INNER JOIN catproductos AS cp
              ON pr.idcatproducto = cp.idcatproducto  WHERE pr.producto LIKE'%{$nams}%' ";
            $tab= "?tabla=productos";
            $newquery = $crud->paging($query,$records_per_page);
            $crud->dataviewProductos($newquery);
          ?>
        </table>
        <div class="pagination-wrap"><?php $crud->paginglink($tab, $query, $records_per_page); ?></div>
        <?php
      }
      
      if ($tabla == "detalles") { ?>
        <div class="row">
          <div class="col-xs-6">
            <form method="POST">
              <div class="form-group row">
                <div class="col-10">
                  <input type="text" class="form-control" onKeyPress="return soloLetras(event);" name="nomUsu" placeholder="Buscar por producto">
                </div>
                <div class="col-2">
                  <button class="btn btn-default" name="btnsearch" type="submit">Buscar</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-xs-6">
            <div class="text-xs-right">
              <a class="btn btn-primary" href="detalles.php?accion=nuevo#add">
                <span class="mbri-plus mbr-iconfont mbr-iconfont-btn"></span>
                Agregar Detalles
              </a>
            </div>
          </div>
        </div><br>
        <table class="table table-hover table-inverse">
          <?php 
            $query = "SELECT iddetventa, idventa, dv.idproducto, 
            pr.producto, pr.imagen, pr.precio, dv.cantidad, dv.estado
            FROM detventas AS dv INNER JOIN productos AS pr
            ON dv.idproducto = pr.idproducto where pr.producto LIKE'%{$nams}%' ";
            $tab= "?tabla=detalles";
            $newquery = $crud->paging($query,$records_per_page);
            $crud->dataviewDetalles($newquery);
          ?>
        </table>
        <div class="pagination-wrap"><?php $crud->paginglink($tab, $query, $records_per_page); ?></div>
        <?php
      }

      if ($tabla == "categorias") { ?>
        <div class="row">
          <div class="col-xs-6">
            <form method="POST">
              <div class="form-group row">
                <div class="col-10">
                  <input type="text" class="form-control" onKeyPress="return soloLetras(event);" name="nomUsu" placeholder="Buscar por categoria">
                </div>
                <div class="col-2">
                  <button class="btn btn-default" name="btnsearch" type="submit">Buscar</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-xs-6">
            <div class="text-xs-right">
              <a class="btn btn-primary" href="catprod.php?accion=nuevo#add">
                <span class="mbri-plus mbr-iconfont mbr-iconfont-btn"></span>
                Agregar Categorias
              </a>
            </div>
          </div>    
        </div><br>
        <table class="table table-hover table-inverse">
          <?php
            $query = "SELECT * FROM catproductos Where categoria LIKE'%{$nams}%' ";
            $tab= "?tabla=categorias";
            $newquery = $crud->paging($query,$records_per_page);
            $crud->dataviewCategorias($newquery);
          ?>
        </table>
        <div class="pagination-wrap"><?php $crud->paginglink($tab, $query, $records_per_page); ?></div>
        <?php
      }
      ?>
      
    </div>
  </section>

  <footer class="mbr-small-footer mbr-section mbr-section-nopadding" id="footer1-g" style="background-color: rgb(33, 33, 33); padding-top: 1.75rem; padding-bottom: 1.75rem;">  
    <div class="container">
      <p class="text-xs-center">Copyright &copy; 2017 Martin Fierro Robles.</p>
    </div>
  </footer>
  <script type="text/javascript" src="../libs/datetimepicker/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
  <script type="text/javascript" src="../libs/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  <script type="text/javascript" src="../libs/datetimepicker/idioma/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
  <script type="text/javascript">
      $('.form_date').datetimepicker({
        language: 'es',
        format: 'yyyy/mm/dd',        
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
        });
  </script>

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