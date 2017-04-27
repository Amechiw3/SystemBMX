<section id="ext_menu-0">
  <nav class="navbar navbar-dropdown navbar-fixed-top">
    <div class="container">
      <div class="mbr-table">
        <div class="mbr-table-cell">
          <div class="navbar-brand">
            <a href="index.php" class="navbar-logo"><img src="../model/bmx.png" alt="Sistema BMX"></a>
            <a class="navbar-caption" href="index.php">Sistema Bicicletas</a>
          </div>
        </div>
        <div class="mbr-table-cell">
          <button class="navbar-toggler pull-xs-right" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
            <div class="hamburger-icon"></div>
          </button>
          <ul class="nav-dropdown collapse pull-xs-right nav navbar-nav navbar-toggleable-xl" id="exCollapsingNavbar">
            <li class="nav-item dropdown open">
              <a class="nav-link link dropdown-toggle" href="https://mobirise.com/" data-toggle="dropdown-submenu" aria-expanded="true"><?php if($_SESSION['idioma'] == "English") {echo "REPORTS";} else {echo "REPORTES";} ?>
              </a>
              <div class="dropdown-menu">
                <div class="dropdown">  <!-- Basicos -->
                  <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
                    <?php if($_SESSION['idioma'] == "English") {echo "Basic";} else {echo "Basicos";} ?>
                  </a>
                  <div class="dropdown-menu dropdown-submenu">
                    <a class="dropdown-item" href="reportes.php?reporte=ventas">
                      <?php if($_SESSION['idioma'] == "English") {echo "Sales";} else {echo "Ventas";} ?>
                    </a>
                    <a class="dropdown-item" href="reportes.php?reporte=detalles">
                      <?php if($_SESSION['idioma'] == "English") {echo "Details";} else {echo "Detalles";} ?>
                    </a>
                    <a class="dropdown-item" href="reportes.php?reporte=productos">
                      <?php if($_SESSION['idioma'] == "English") {echo "Products";} else {echo "Productos";} ?>
                    </a>
                    <a class="dropdown-item" href="reportes.php?reporte=usuarios">
                      <?php if($_SESSION['idioma'] == "English") {echo "Users";} else {echo "Usuarios";} ?>
                    </a>
                    <a class="dropdown-item" href="reportes.php?reporte=categorias">
                      <?php if($_SESSION['idioma'] == "English") {echo "Categories";} else {echo "Categorias";} ?>
                    </a>
                  </div>
                </div>
                <!--  -->
                <div class="dropdown"> <!-- Compuestos -->
                  <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
                    <?php if($_SESSION['idioma'] == "English") {echo "Compounds";} else {echo "Compuestos";} ?>
                  </a>
                  <div class="dropdown-menu dropdown-submenu">
                    <a class="dropdown-item" href="compuestos.php?reporte=ventas">
                      <?php if($_SESSION['idioma'] == "English") {echo "Sales";} else {echo "Ventas";} ?>
                    </a>
                    <a class="dropdown-item" href="compuestos.php?reporte=productos">
                      <?php if($_SESSION['idioma'] == "English") {echo "Products";} else {echo "Productos";} ?>
                    </a>
                    <a class="dropdown-item" href="compuestos.php?reporte=usuarios">
                      <?php if($_SESSION['idioma'] == "English") {echo "Users";} else {echo "Usuarios";} ?>
                    </a>
                    <a class="dropdown-item" href="compuestos.php?reporte=categorias">
                      <?php if($_SESSION['idioma'] == "English") {echo "Categories";} else {echo "Categorias";} ?>
                    </a>
                  </div>
                </div>
                <!--  -->
                <div class="dropdown"> <!-- Periodo -->
                  <a class="dropdown-item" href="periodo.php">
                    <?php if($_SESSION['idioma'] == "English") {echo "Period";} else {echo "Periodo";} ?>
                  </a>
                </div>
                <!--  -->
                <div class="dropdown"> <!-- Sumarios -->
                  <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
                    <?php if($_SESSION['idioma'] == "English") {echo "Summary";} else {echo "Sumarios";} ?>
                  </a>
                  <div class="dropdown-menu dropdown-submenu">
                    <a class="dropdown-item" href="sumarios.php?reporte=ventas">
                      <?php if($_SESSION['idioma'] == "English") {echo "Sales";} else {echo "Ventas";} ?>
                    </a>
                    <a class="dropdown-item" href="sumarios.php?reporte=productos">
                      <?php if($_SESSION['idioma'] == "English") {echo "Products";} else {echo "Productos";} ?>
                    </a>
                    <a class="dropdown-item" href="sumarios.php?reporte=usuarios">
                      <?php if($_SESSION['idioma'] == "English") {echo "Users";} else {echo "Usuarios";} ?>
                    </a>
                  </div>
                </div>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link link" href="usuarios.php">
                <?php if($_SESSION['idioma'] == "English") {echo "USERS";} else {echo "USUARIOS";} ?>
              </a>
              </li>
            <li class="nav-item">
              <a class="nav-link link" href="ventas.php">
                <?php if($_SESSION['idioma'] == "English") {echo "SALES";} else {echo "VENTAS";} ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link link" href="detalles.php">
                <?php if($_SESSION['idioma'] == "English") {echo "DETAILS";} else {echo "DETALLES";} ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link link" href="productos.php">
                <?php if($_SESSION['idioma'] == "English") {echo "PRODUCTS";} else {echo "PRODUCTOS";} ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link link" href="categorias.php">
                <?php if($_SESSION['idioma'] == "English") {echo "CATEGORIES";} else {echo "CATEGORIAS";} ?>
              </a>
            </li>
            <!-- <li class="nav-item nav-btn"><a class="nav-link btn btn-success" href="#" onClick="window.print();">Imprimir</a></li> -->
            <li class="nav-item nav-btn">
              <a class="nav-link btn btn-danger" href="../logout.php">
                <?php if($_SESSION['idioma'] == "English") {echo "LOG OUT";} else {echo "SALIR";} ?>
              </a>
            </li>
          </ul>
          <button hidden="" class="navbar-toggler navbar-close" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
            <div class="close-icon"></div>
          </button>
        </div>
      </div>
    </div>
  </nav>
</section>
<?php
  if ($db == null) {
    die();
  }
?>