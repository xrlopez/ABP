<?php


require_once(__DIR__."/../core/ValidationException.php");


class JuradoProfesional {

  private $id_usuario; 
  private $nombre;   
  private $password;
  private $email;
  private $profesion;
  private $organizador;
  private $tipo;
  
  public function __construct($id_usuario=NULL, $nombre=NULL, $password=NULL, $email=NULL, $profesion=NULL, /*Organizador*/ $organizador=NULL, $tipo=NULL) {
    $this->id_usuario = $id_usuario;
    $this->nombre = $nombre;
    $this->password = $password;
    $this->email = $email;
    $this->profesion = $profesion;
    $this->organizador = $organizador;
    $this->tipo = $tipo;
    
  }

     
  public function getId() {
    return $this->id_usuario;
  }  
  
  public function setId($id_usuario) {
    $this->id_usuario = $id_usuario;
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
  
   public function getProfesion() {
    return $this->profesion;
  }   
  public function setProfesion($profesion) {
    $this->profesion = $profesion;
  }
  
   public function getTipo() {
    return $this->tipo;
  }   
  public function setTipo($tipo) {
    $this->tipo = $tipo;
  }
  
  public function getOrganizador() {
    return $this->organizador;
  }   
  public function setOrganizador($organizador) {
    $this->organizador = $organizador;
  }

  public function checkIsValidForCreate() {
      $errors = array();
      if (strlen(trim($this->nombre)) == 0 ) {
	$errors["nombre"] = "Nombre es obligatorio";
      }
	  if (strlen(trim($this->password)) == 0 ) {
	$errors["password"] = "Contraseña es obligatorio";
      }
	  if (strlen(trim($this->email)) == 0 ) {
	$errors["profesion"] = "Profesion es obligatorio";
      }
	  if (strlen(trim($this->profesion)) == 0 ) {
	$errors["profesion"] = "Profesion es obligatorio";
      }
	  if (strlen(trim($this->organizador)) == 0 ) {
	$errors["organizador"] = "Organizador es obligatorio";
      }

      if (sizeof($errors) > 0){
	throw new ValidationException($errors, "Jurado Profesional no valido");
      }
  }
}
