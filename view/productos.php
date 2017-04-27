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
                <input type="text" class="form-control" onKeyPress="return soloLetras(event);" name="nomUsu" placeholder="<?php if($_SESSION['idioma'] == "English") {echo "Search Product";} else {echo "Buscar Producto";} ?>">
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
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">
            <?php if($_SESSION['idioma'] == "English") {echo "Add Products";} else {echo "Agregar Productos";} ?> <i class="fa fa-plus"></i></button>
          </div>
        </div>
      </div><br>
      <div class="row">
        <div class="col-md-12">
          <div class="collapse" id="collapseNuevo">
            <div class="card card-block card-inverse" style="background-color: #333; border-color: #333;">
              <?php
                if (isset($_POST['btnGuardar'])) 
                {
                  $producto = $_POST['producto'];
                  $descripcion = $_POST['descripcion'];
                  $idcatproducto = $_POST['idcatproducto'];
                  $precio = $_POST['precio'];     

                  $imgFile = $_FILES['user_image']['name'];
                  $tmp_dir = $_FILES['user_image']['tmp_name'];
                  $imgSize = $_FILES['user_image']['size'];
                  $upload_dir = '../model/productos/';
                  $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
                  // valid image extensions
                  $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'jpe'); // valid extensions
                  // rename uploading image
                  //$userpic = rand(1000,1000000).".".$imgExt;
                  $userpic = rand(1000,1000000).".png";
                  if(in_array($imgExt, $valid_extensions))
                  {
                    // Check file size '5MB'
                    if($imgSize < 5000000)
                    {
                      move_uploaded_file($tmp_dir, $upload_dir.$userpic);
                      $imgprod = $userpic;
                      if ($crud->createProductos($producto, $descripcion, $imgprod, $precio, $idcatproducto)) 
                      {
                        echo "<script>alert('Producto guardado');</script>";
                      }
                      else
                      {
                        echo "<script>alert('Hubo un error al guardar la venta');</script>";
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
              ?>
              <form method="POST" enctype="multipart/form-data">
                <script>
                  function soloNumeros(e)
                  {
                    // capturamos la tecla pulsada
                    var teclaPulsada=window.event ? window.event.keyCode:e.which;
                    // capturamos el contenido del input
                    var valor=document.getElementById("precio").value;
                    // 13 = tecla enter
                    // 46 = tecla punto (.)
                    // Si el usuario pulsa la tecla enter o el punto y no hay ningun otro
                    // punto
                    if(teclaPulsada==13 || (teclaPulsada==46 && valor.indexOf(".")==-1))
                    {
                      return true;
                    }        
                    // devolvemos true o false dependiendo de si es numerico o no
                    return /\d/.test(String.fromCharCode(teclaPulsada));
                  }
                </script>
                <div class="form-group row"><!-- Producto -->
                  <label for="" class="col-2 col-form-label text-white">Producto</label>
                  <div class="col-10">
                    <input type="text" class="form-control form-sm" value="" id="producto" name="producto" placeholder="Nombre del producto">
                  </div>
                </div>
                <div class="form-group row"><!-- Descripcion -->
                  <label for="" class="col-2 col-form-label text-white">Descripcion</label>
                  <div class="col-10">
                    <textarea class="form-control form-sm" id="descripcion" name="descripcion" rows="3"></textarea>
                  </div>
                </div>
                <div class="form-group row"><!-- Imagen -->
                  <label for="" class="col-2 col-form-label text-white">Imagen</label>
                    <div class="col-4">
                      <input type="file" class="form-control-file" id="user_image" name="user_image" style="color: #FFF;" accept="image/*" required>
                    </div>
                    <label for="" style="text-align: right;" class="col-2 col-form-label text-white">Categoria</label>
                  <div class="col-4">
                    <select class="form-control form-sm" id="idcatproducto" name="idcatproducto" required>
                      <?php
                        echo "<option value=''>Seleccione categoria</option>";
                        $sql = "SELECT * FROM catproductos";
                        $crud->OptionCategorias($sql);
                      ?>
                    </select>
                  </div>
                </div>
                <!-- <div class="form-group row">Categoria 
                  
                </div>     -->
                <div class="form-group row"><!-- Precio -->
                  <label for="" class="col-2 col-form-label text-white">Precio</label>
                  <div class="col-10">
                    <input class="form-control form-xs" onkeypress="return soloNumeros(event);" type="text" id="precio" name="precio" required>
                  </div>
                </div>
                <hr>
                <div class="form-group row"><!-- BOTONES -->
                  <div class="col-md-6 col-md-offset-6 text-xs-right">
                    <button type="submit" name="btnGuardar" class="btn btn-outline-success">Guardar</button>
                    <a href="tabla?tabla=productos" class="btn btn-outline-danger">Cancelar</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>        
      <?php 
        $query = "SELECT pr.idproducto, pr.producto, pr.descripcion, pr.imagen, pr.precio, cp.categoria, pr.estado
          FROM productos AS pr INNER JOIN catproductos AS cp
          ON pr.idcatproducto = cp.idcatproducto  WHERE pr.producto LIKE'%{$nams}%' ";
        $newquery = $crud->paging($query,$records_per_page);
        $crud->dataviewProductos($newquery);
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