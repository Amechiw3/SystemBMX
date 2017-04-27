<?php
  session_start();
  
  //session_start();
  /*
  if (!isset($_SESSION['idusuario'])) 
  {
    echo "<script>alert('Necesitas logearte para acceder');</script>";
    echo "<script>location.href='../index.php'</script>";
  }
  if ($_SESSION['estado'] != "Activado") 
  {
    echo "<script>alert('Cuenta desactivada');</script>";
    echo "<script>location.href='../index.php'</script>";
  }*/

  include_once"../model/config.php";
  $config = new Config();
  $db = $config->get_Connection();

  include_once '../controller/class.crud.php';
  $crud = new crud($db);

  $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
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
        <button class="btn btn-primary pull-md-right" type="button" data-toggle="collapse" data-target="#Carrito">
          <span class="fa fa-shopping-cart"></span>&nbsp;Carrito <?php echo count($_SESSION["cart_products"]); ?>
        </button>
        <div class="collapse" id="Carrito">
          <div class="card card-block card-inverse" style="background-color: #333; border-color: #444;">
            <?php 
            if(isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"]) > 0)
            {
              ?>
              <h3>Carrito de Compras</h3>
              <!-- inicia form tercero cart_update.php   -->
              <form method="post" action="cart_update.php">
                <table width="100%" class="table table-hover">
                  <tbody><?php
                    $total = 0;
                    $b = 0;
                    foreach ($_SESSION["cart_products"] as $cart_itm)
                    {
                      $idproducto = $cart_itm['idproducto'];                
                      $producto = $cart_itm['producto'];
                      $imagen = $cart_itm['imagen'];
                      $precio = $cart_itm['precio'];
                      $product_qty = $cart_itm['product_qty'];
                      ?>
                      <tr>
                        <td><?php
                        echo '<label class="form-label 
                                    text-white" 
                                    for="product_qty">Cantidad: </label>
                              <input type="text" 
                                    class="form-control form-sm" 
                                    size="2"
                                    maxlength="2" 
                                    name="product_qty['.$idproducto.']" 
                                    value="'.$product_qty.'" />
                              </td>'; ?>
                        <td>
                          <img class="card-img-top img-thumbnail rounded img-fluid" src="../model/productos/<?php echo $imagen; ?>" style="width: 80px; height: 80px;" alt="Card image cap">
                        </td>
                        <td>
                          <label class="form-label text-white" for="producto">
                            <?php echo $producto ?><br>
                            Precio: <?php echo $precio; ?></label>
                        </td>
                        <td>
                            <label class="form-label text-white" for="remove_code[]">Eliminar</label>
                            <input type="checkbox" class="form-control" name="remove_code[]" value="<?php echo $idproducto ?>" />
                          </td>
                      </tr>
                      <?php
                      $subtotal = ($precio * $product_qty);
                      $total = ($total + $subtotal);
                    }?>
                  </tbody>
                  
                  
                </table>
                <div class="text-xs-right">
                  <button class="btn btn-primary" type="submit" name="tercero">Actualizar</button>
                  <a href="view_cart.php" class="btn btn-success">Pagar $<?php echo number_format($total, 2); ?></a>
                </div>
                <?php 
                  $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                  echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
                  echo '</form>';
            } 
            ?>
          </div>
        </div>
        <form method="POST">
          <label for="id_catf" class="form-label text-white">Categoria</label>
          <select class="form-control" id="id_catf" name="id_catf" selected="selected" onchange='this.form.submit()'>
            <?php
              $products_item = '<ul class="products">';                  
              echo "<option value=''>Seleccione categoria</option>";
              echo "<option value=''>Todos los productos</option>";
              $sql = "SELECT * FROM catproductos";
              $crud->OptionCategorias($sql);
            ?>
          </select>
          <?php if (isset($_POST['id_catf'])) 
            {
              $id_cat = $_POST['id_catf'];
            }
            else
            {
              $id_cat = "";
            }
          ?>

      </form><hr>
      </div>
    </div>
  </section>

  <script>
    function soloNumeros(e) 
    {
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toString();
      letras = "1234567890";
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

        return false;
      }
    }
  </script>

  <section class="mbr-section mbr-section-md-padding" id="social-buttons3-4" style="background-color: rgb(33, 33, 33); padding-top: 15px; padding-bottom: 30px;">
    <div class="container">
      <?php
        if ($id_cat != "") 
        {
          $sql = "select * from productos where idcatproducto=". $id_cat." order by idproducto asc";
          $crud->dataviewCart($sql);
        }
        else
        {
          $sql = "select * from productos order by idproducto asc";
          $crud->dataviewCart($sql);
        }
      ?>
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