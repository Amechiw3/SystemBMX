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
  <?php include_once("ref.html"); ?>
  <style>
    body{
      background-color: rgb(33, 33, 33);
    }
    </style>
</head>
<body>
  <?php include_once("menu.php"); ?>

  <section class="mbr-section mbr-section-md-padding" id="social-buttons3-4" style="background-color: rgb(33, 33, 33); padding-top: 15px; padding-bottom: 30px;">
    <div class="container">
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