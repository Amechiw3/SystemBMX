<?php
  class Config
  {
    // Especificar tus propias credenciales de base Datos
    private $host = "127.0.0.1"; 	
    private $db_name = "sistemabici";
    private $username = "root";
    private $password = "";
    public $conn;
    //public $crud;

    // Obtener La Conexion a la Base de Datos
    // get the database connection
    public function get_Connection()
    {	
    	$this->conn = null;  
        try 
        {
          $this->conn = new PDO("mysql:host=" . $this->host . ";charset=utf8mb4;dbname=" .$this->db_name, $this->username, $this->password);
  	      // error en config esta escrito esto era ";db_name=" y es: ";dbname="
  	    }
        catch (PDOException $exception) 
        {
     	    //echo "Error de Conexion: ". $exception->getMessage();
          ?>
          <section class="mbr-section" id="form2-m" style="background-color: rgb(33, 33, 33); padding-top: 120px; padding-bottom: 0px;">
            <div class="mbr-section mbr-section-nopadding">
              <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="alert-heading"><strong>Error!</strong></h4>
                  <p>Error al tratar de conectar con el servidor</p>  
                </div>
              </div>
            </div>
          </section>
          <?php
        }
        //get_CRUD();
        return $this->conn;
    }
    /*
    public function get_CRUD()
    {
      include '../controller/class.crud.php';
      //include_once '../controller/class.crud.php';
      $crud = new crud($conn);
    }*/
  }
?>