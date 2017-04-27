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
  <script type="text/javascript">
    var tableToExcel = (function() {
      var uri = 'data:application/vnd.ms-excel;base64,'
      , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
      , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
      , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
      return function(table, name) {
      if (!table.nodeType) table = document.getElementById(table)
      var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
      window.location.href = uri + base64(format(template, ctx))
      }
    })()
  </script>

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
                  <input type="text" class="form-control" onKeyPress="return soloLetras(event);" name="nomUsu" placeholder="<?php if($_SESSION['idioma'] == "English") {echo "Search for Name";} else {echo "Buscar por Nombre";} ?>">
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
              <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#regNew" aria-expanded="false" aria-controls="regNew"><?php if($_SESSION['idioma'] == "English") {echo "Add Users";} else {echo "Agregar Usuarios";} ?></button>
            </div>
          </div>
        </div><br>

          <div class="collapse" id="regNew">
              <div class="card card-block card-inverse" style="background-color: #333; border-color: #333;">
                <?php
                  if (isset($_POST["btnGuardar"])) 
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
                ?>
                <form method="POST">
                  <div class="form-group row"><!-- nomusuario -->
                    <label for="" class="col-1 col-form-label text-white">Nombre</label>
                    <div class="col-3">
                      <input class="form-control form-sm" onKeyPress="return soloLetras(event);" type="text" value="" id="nomusuario" name="nomusuario" required>
                    </div>

                    <label for="" class="col-1 col-form-label text-white">Apellido Paterno</label>
                    <div class="col-3">
                      <input class="form-control form-sm" onKeyPress="return soloLetras(event);" type="text" value="" id="appusuario" name="appusuario" required>
                    </div>

                    <label for="" class="col-1 col-form-label text-white">Apellido Materno</label>
                    <div class="col-3">
                      <input class="form-control form-sm" onKeyPress="return soloLetras(event);" type="text" value="" id="apmusuario" name="apmusuario" required>
                    </div>
                  </div>

                  <!-- <div class="form-group row">appusuario
                  </div> -->
                  <!-- <div class="form-group row">apmusuario
                  </div> -->

                  <div class="form-group row"><!-- usuario -->
                    <label for="" class="col-1 col-form-label text-white">Usuario</label>
                    <div class="col-3">
                      <input class="form-sm form-control" onKeyPress="return soloLetras(event);" type="text" value="" id="usuario" name="usuario" required>
                    </div>

                    <label for="" class="col-1 col-form-label text-white">Password</label>
                    <div class="col-3">
                      <input class="form-sm form-control" onKeyPress="return soloLetras(event);" type="password" value="" id="password" name="password">
                    </div>

                    <label for="" class="col-1 col-form-label text-white">Email</label>
                    <div class="col-3">
                      <input class="form-control form-sm" type="email" value="" id="email" name="email" required>
                    </div>
                  </div>

                  <!-- <div class="form-group row">password
                  </div> -->

                  <!-- <div class="form-group row">email
                    
                  </div> -->

                  <div class="form-group row"><!-- catusuario -->
                    <label for="" class="col-1 col-form-label text-white">Categoria</label>
                    <div class="col-3">
                      <select class="form-control" id="catusuario" name="catusuario" required>
                        <option value="Administrador">Administrador</option>
                        <option value="Empleado">Empleado</option>
                        <option value="Cliente">Cliente</option>
                      </select>
                    </div>

                    <label for="" class="col-1 col-form-label text-white">Idioma</label>
                    <div class="col-7">
                      <select class="form-control" id="idioma" name="idioma" required>
                        <option value="Espanol">Español</option>
                        <option value="English">English</option>
                      </select>
                    </div>
                  </div>

                  <!-- <div class="form-group row">idioma
                  </div> -->

                  <hr>

                  <div class="form-group row">
                    <div class="col-md-6 col-md-offset-6 text-xs-right">
                      <button type="submit" name="btnGuardar" class="btn btn-outline-success">Guardar</button>
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
        <!-- <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" > -->
          <?php
            $query = "SELECT * FROM usuarios where CONCAT(nomusuario,' ',appusuario,' ',apmusuario) LIKE'%{$nams}%' ";
            $newquery = $crud->paging($query,$records_per_page);
            $crud->dataviewUsuarios($newquery);
          ?>
        <div class="text-xs-center"><?php $crud->paginglink($query,$records_per_page); ?></div>
        <?php
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