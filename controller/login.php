<?php 
class Login
{
 private $conn;
 private $table_name = "usuarios";
  
    public $user;

    public $idusuario;
    public $nomusuario;
    public $appusuario;
    public $apmusuario;
    public $usuario;
    public $password;
    public $email;
    public $catusuario;
    public $idioma;
    public $estado;
	
 
    public function __construct($db)
    {
  		$this->conn = $db;
 	}
 
    public function login()
    {
        $user = $this->checkCredentials();
        if ($user) 
        {
            $this->user = $user;
   			//session_start();
			$_SESSION['idusuario'] 	= $user['idusuario'];
			$_SESSION['nomusuario'] = $user['nomusuario'];
			$_SESSION['appusuario'] = $user['appusuario'];
			$_SESSION['apmusuario'] = $user['apmusuario'];
			$_SESSION['usuario'] 	= $user['usuario'];
			$_SESSION['password'] 	= $user['password'];
			$_SESSION['email'] 		= $user['email'];
			$_SESSION['catusuario'] = $user['catusuario'];
			$_SESSION['idioma'] 	= $user['idioma'];
			$_SESSION['estado'] 	= $user['estado'];

		    return $user['idusuario'];
			return $user['nomusuario'];
			return $user['appusuario'];
			return $user['apmusuario'];
			return $user['usuario'];
			return $user['password'];
			return $user['email'];
			return $user['catusuario'];
			return $user['idioma'];
			return $user['estado'];
        }
        return false;
    }
 
    protected function checkCredentials()
    {
        $stmt = $this->conn->prepare('select * from '.$this->table_name.' where usuario=? and password=?');
  		$stmt->bindParam(1, $this->usuario);
  		$stmt->bindParam(2, $this->password);
        $stmt->execute();
        if ($stmt->rowCount() > 0) 
        {
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
            $submitted_pass = $this->password;
            if ($submitted_pass == $data['password']) 
            {
                return $data;
            }
        }
        return false;
    }
 
    public function getUser()
    {
        return $this->user;
    }
}
?>