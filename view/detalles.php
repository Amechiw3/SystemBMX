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
    function soloNumeros(e)
    {
      // capturamos la tecla pulsada
      var teclaPulsada=window.event ? window.event.keyCode:e.which;   
      // capturamos el contenido del input
      var valor=document.getElementById("cantidad").value;
      // 13 = tecla enter
      // 46 = tecla punto (.)
      // Si el usuario pulsa la tecla enter o el punto y no hay ningun otro
      /*/ punto
      if(teclaPulsada==13 || (teclaPulsada==46 && valor.indexOf(".")==-1))
      {
        return true;
      }*/
      // devolvemos true o false dependiendo de si es numerico o no
      return /\d/.test(String.fromCharCode(teclaPulsada));
    }
  </script>

  <section class="mbr-section mbr-section-md-padding" id="social-buttons3-4" style="background-color: rgb(33, 33, 33); padding-top: 15px; padding-bottom: 30px;">
    <div class="container">
      <?php
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
      ?>
      <div class="row">
        <div class="col-xs-6">
          <form method="POST">
            <div class="form-group row">
              <div class="col-10">
                <input type="text" class="form-control" onKeyPress="return soloLetras(event);" name="nomUsu" placeholder="<?php if($_SESSION['idioma'] == "English") {echo "Search product";} else {echo "Buscar producto";} ?>">
              </div>
              <div class="col-2">
                <button class="btn btn-default" name="btnsearch" type="submit">
                  <?php if($_SESSION['idioma'] == "English") {echo "Search";} else {echo "Buscar";} ?>
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-xs-6">
          <div class="text-xs-right">
            <div class="text-xs-right">
              <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">
                <?php if($_SESSION['idioma'] == "English") {echo "Add Details";} else {echo "Agregar Detalles";} ?> 
                <i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
        </div>
      </div><br>
          <div class="row">
            <div class="col-md-12">
              <div class="collapse" id="collapseNuevo">
                <div class="card card-block card-inverse" style="background-color: #333; border-color: #333;">
                  <?php
                    if (isset($_POST["btnGuardarNuevo"])) 
                    {
                      $idventa = $_POST['idventa'];
                      $idproducto = $_POST['idproducto'];
                      $cantidad = $_POST['cantidad'];
                      if ($crud->createDetalles($idventa, $idproducto, $cantidad)) 
                      {
                        echo "<script>location.href='detalles.php'</script>";
                      }
                      else
                      {
                        echo "<script>alert('Hubo un error al guardar al usuario');</script>";
                      }
                    }
                  ?>
                  <form method="POST">
                    <div class="form-group row"><!-- Venta -->
                      <label for="" class="col-2 col-form-label text-white">Venta</label>
                      <div class="col-10">
                        <select class="form-control" id="idventa" name="idventa" required>
                          <?php                        
                            echo "<option value=''>Seleccione una venta</option>";
                            $sql = "SELECT ve.idventa, CONCAT(us.nomusuario,' ',us.appusuario,' ', us.apmusuario)AS nombreusuario,
                            ve.fechaventa, ve.totalventa, ve.estado FROM ventas AS ve INNER JOIN usuarios as us on ve.idusuario = us.idusuario ORDER BY ve.idventa";
                            $crud->OptionVenta($sql);
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row"><!-- Producto -->
                      <label for="" class="col-2 col-form-label text-white">Producto</label>
                      <div class="col-10">
                        <select class="form-control" id="idproducto " name="idproducto" required>
                          <?php                        
                            echo "<option value=''>Seleccione un producto</option>";
                            $sql = "SELECT * FROM productos";
                            $crud->OptionProductos($sql);
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row"><!-- Cantidad -->
                      <label for="" class="col-2 col-form-label text-white">Cantidad</label>
                      <div class="col-10">
                        <input class="form-control" onkeypress="return soloNumeros(event);" type="text" value="1" id="cantidad" name="cantidad" required>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <div class="col-md-6 col-md-offset-6 text-xs-right">
                        <button type="submit" name="btnGuardarNuevo" class="btn btn-outline-success">Guardar</button>
                        <a href="tabla?tabla=detalles" class="btn btn-outline-danger">Cancelar</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
            <?php 
              $query = "SELECT iddetventa, idventa, dv.idproducto, 
              pr.producto, pr.imagen, pr.precio, dv.cantidad, dv.estado
              FROM detventas AS dv INNER JOIN productos AS pr
              ON dv.idproducto = pr.idproducto where pr.producto LIKE'%{$nams}%' ORDER BY idventa DESC ";
              $newquery = $crud->paging($query,$records_per_page);
              $crud->dataviewDetalles($newquery);
            ?>
          <div class="pagination-wrap"><?php $crud->paginglink($query, $records_per_page); ?></div>
      
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