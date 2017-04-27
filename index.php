<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- CORE CSS-->
  <!-- <link rel="stylesheet" href="libs/materialize/css/materialize.min.css"> -->
  <link href="libs/bootstrap4/css/bootstrap.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/css/materialize.min.css">

  <style type="text/css">
    html, body {
        height: 100%;
    }
    html {
        display: table;
        margin: auto;
        font-family: GillSans, Calibri, Trebuchet, sans-serif;
    }
    body {
        display: table-cell;
        vertical-align: middle;
        background: #212121;
        /*#1976d2*/
    }
    .margin {
      margin: 0 !important;
    }
  </style>
  <?php
    include_once"model/config.php";
    $config = new Config();
    $db = $config->get_Connection();
    if ($db == null) {
      die();
    }
    include_once 'controller/login.php';
    $loginAcc = new Login($db);

    //INICIO DE SESION
    //session_name('controlarintentos');
    session_start();
    
    //NUMERO DE INTENTOS PERMITIDOS
    $permitidos = 3;

    //TIEMPO POR EL QUE NO PODRA LOGUEARSE SI HA SOBREPASADO EL NUMERO PERMITIDO DE INTENTOS (en segundos)
    $tiempo = 200; //20 segundos

    // PRIMERO VERIFICAMOS SI PUEDE SEGUIR LOGUEANDOSE O DEBE ESPERAR ALGUN TIEMPO
    if(isset($_SESSION['tiempo_fuera']))
    {
      // Comprobamos cuanto tiempo ha pasado:
      $tiempo_ahora = time() - $_SESSION['tiempo_fuera'];
      if($tiempo_ahora < $tiempo) 
      {
        $tiempo_restante = $tiempo-$tiempo_ahora;
        // ESTO SI NO PUEDE LOGUEARSE
        die('<div class="col s12 z-depth-6 card-panel indigo darken-2">
              <div class="row">
                <div class="col s12 m12">
                  <div class="card grey darken-3">
                    <div class="card-content white-text center">
                      Debes esperar '.$tiempo_restante.' segundos para poder intentar el login de nuevo.<br/><br/>
                      <a class="waves-effect waves-light btn" href="index.php">Recargar página</a>
                    </div>
                  </div>
                </div>
              </div>
             </div>
          ');
      } 
      else 
      {
        unset($_SESSION['tiempo_fuera']);
      }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST") 
    {
      // ESTO ES TODO LO QUE SE HARA AL ENVIAR EL FORMULARIO
      // LUEGO VEMOS CUANTOS INTENTOS VA
      if(!isset($_SESSION['intentos'])) 
      {
        $intento = 0; 
        $_SESSION['intentos'] = $intento;
      } 
      else 
      {
        $intento = $_SESSION['intentos'];
      }
      // LUEGO COMPARAMOS CON EL NUMERO DE INTENTOS PERMITIDOS
      if($intento >= $permitidos)
      {
        // LO QUE PASARA SI HA SOBREPASADO EL NUMERO DE INTENTOS VALIDOS
        unset($_SESSION['intentos']); 
        $_SESSION['tiempo_fuera'] = time();
        die('<div class="col s12 z-depth-6 card-panel indigo darken-2">
              <div class="row">
                <div class="col s12 m12">
                  <div class="card grey darken-3">
                    <div class="card-content white-text center">
                      Ha sobrepasado el numero permitido de intentos de login. No podra loguearse por '.$tiempo.' segundos.<br/><br/>
                      <a class="waves-effect waves-light btn" href="index.php">Recargar página</a>
                    </div>
                  </div>
                </div>
              </div>
             </div>');

      } 
      else 
      {
        // CONTABILIZAMOS EL INTENTO
        $intento++;
        /*
          AQUI VERIFICAS SI LOS DATOS SON CORRECTOS Y TODO ESO....
          SI NO LO SON CREAS UNA VARIABLE $acceso = 0;
          SI LO SON, CREAS LA VARIABLE $acceso = 1;
        */
        // ALGO ASI PARA ESTE CASO... ESTO TU DEBES CAMBIAR POR TUS CONSULTAS A LA BD Y TODO ESO
        $loginAcc->usuario = $_POST['usuario']; 
        $loginAcc->password = md5($_POST['password']);
        
        if($loginAcc->login()) 
        {
          $acceso = 1; 
        } 
        else 
        {
          $acceso = 0;
        }
        // FIN VERIFICACION DE DATOS
        if($acceso == 1) 
        {
          // BORRAMOS LAS VARIABLES DE SESION
          unset($_SESSION['tiempo_fuera'],$_SESSION['intentos']);
          // AQUI REDIRIGES O LO QUE SEA Q HAYA Q HACER SI EL LOGIN ES CORECTO
          //die('Login correcto');
          echo "<script>location.href='view/index.php'</script>";
        } 
        else 
        {
          // GUARDAMOS EL INTENTO Y REGRESAMOS AL LOGIN
          $_SESSION['intentos'] = $intento;
          echo '<div class="card grey darken-3">
                  <div class="card-content white-text center">
                    Datos incorrectos, van '.$intento.' intentos <br />
                  </div>
            </div>';
        }
      }
    }
  ?> 
</head>

<body class="grey darken-4">
  <div id="login-page" class="row">
    <div class="col s12 z-depth-6 card-panel">
      <form class="login-form" method="POST">
        <div class="row">
          <div class="input-field col s12 center">
            <!-- <img src="http://w3lessons.info/logo.png" alt="" class="responsive-img valign profile-image-login">
            <p class="center login-form-text">W3lessons - Material Design Login Form</p> -->
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input class="validate" id="text" name="usuario" type="text" >
            <label for="text" class="center-align">Usuario</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input id="password" name="password" type="password">
            <label for="password">Password</label>
          </div>
        </div>
        <!-- <div class="row">          
          <div class="input-field col s12 m12 l12  login-text">
              <input type="checkbox" id="remember-me" />
              <label for="remember-me">Remember me</label>
          </div>
        </div> -->
        <div class="row">
          <div class="input-field col s12">
            <button class="btn waves-effect col s12" type="submit" name="btnLogin">LOGIN
            </button>
            <div class="progress">
              <div class="indeterminate"></div>
            </div>  
        
          </div>
        </div>
        <!-- <div class="row">
          <div class="input-field col s6 m6 l6">
            <p class="margin medium-small"><a href="register.html">Register Now!</a></p>
          </div>
          <div class="input-field col s6 m6 l6">
              <p class="margin right-align medium-small"><a href="forgot-password.html">Forgot password?</a></p>
          </div>          
        </div> -->
      </form>
      <footer class="page-footer #616161 grey darken-1  ">
        <div class="footer-copyright">
          <div class="container">&copy; 2017 Martin Fierro Robles
            <a class="grey-text text-lighten-4 right" href="">Martin Fierro</a>
          </div>
        </div>
      </footer>
    </div>

  </div>
  
  <!-- === Scripts === -->

  <!-- jQuery Library -->
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <!--materialize js-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      Materialize.updateTextFields();
    });
  </script>
  <script src="libs/materialize/login/materialize.min.js"></script>
  <script src="libs/materialize/login/jQuery.js"></script>
</body>
</html>