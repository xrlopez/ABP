<?php


require_once(__DIR__."/../core/ValidationException.php");


class JuradoPopular {

  private $id_usuario; 
  private $nombre;   
  private $password;
  private $email;
  private $residencia;
  private $tipo;
  
  public function __construct($id_usuario=NULL, $nombre=NULL, $password=NULL, $email=NULL, $residencia=NULL, $tipo=NULL) {
    $this->id_usuario = $id_usuario;
    $this->nombre = $nombre;
    $this->password = $password;
    $this->email = $email;
    $this->residencia = $residencia;
    $this->tipo = $tipo;
    
  }

     
  public function getId() {
    return $this->id_usuario;
  }  
  public function setId($id_usuario) {
    $this->id_usuario=$id_usuario;
  }
  
  public function getNombre() {
    return $this->nombre;
  }   
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }

  public function getPassword() {
    return $this->password;
  }   
  public function setPassword($password) {
    $this->password = $password;
  }
  
  public function getEmail() {
    return $this->email;
  }   
  public function setEmail($email) {
    $this->email = $email;
  }
  
   public function getResidencia() {
    return $this->residencia;
  }   
  public function setResidencia($residencia) {
    $this->residencia = $residencia;
  }
  
   public function getTipo() {
    return $this->tipo;
  }   
  public function setTipo($tipo) {
    $this->tipo = $tipo;
  }

  
  public function checkIsValidForCreate() {
      $errors = array();
      if (strlen(trim($this->id_usuario)) == 0 ) {
  $errors["usuario"] = "usuario es obligatorio";
      }
      if (strlen(trim($this->nombre)) == 0 ) {
	$errors["nombre"] = "Nombre es obligatorio";
      }
	  if (strlen(trim($this->password)) == 0 ) {
	$errors["password"] = "Contraseña es obligatorio";
      }
	  if (strlen(trim($this->email)) == 0 ) {
	$errors["email"] = "Email es obligatorio";
      }
	  if (strlen(trim($this->residencia)) == 0 ) {
	$errors["residencia"] = "Residencia es obligatorio";
      }
      
      if (sizeof($errors) > 0){
	throw new ValidationException($errors, "Jurado Popular no valido");
      }
  }

}
