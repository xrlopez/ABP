<?php


require_once(__DIR__."/../core/ValidationException.php");


class Organizador {

  private $id_usuario; 
  private $nombre;   
  private $password;
  private $email;
  private $descripcionOrga;
  private $tipo;
  
  public function __construct($id_usuario=NULL, $nombre=NULL, $password=NULL, $email=NULL, $descripcionOrga=NULL, $tipo=NULL) {
    $this->id_usuario = $id_usuario;
    $this->nombre = $nombre;
    $this->password = $password;
    $this->email = $email;
    $this->descripcionOrga = $descripcionOrga;
    $this->tipo = $tipo;
    
  }

     
  public function getId() {
    return $this->id_usuario;
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
  
   public function getDescripcionOrga() {
    return $this->descripcionOrga;
  }   
  public function setDescripcionOrga($descripcionOrga) {
    $this->descripcionOrga = $descripcionOrga;
  }
  
   public function getTipo() {
    return $this->tipo;
  }   
  public function setTipo($tipo) {
    $this->tipo = $tipo;
  }
  
  /**
   * Checks if the current instance is valid
   * for being updated in the database.
   * 
   * @throws ValidationException if the instance is
   * not valid
   * 
   * @return void
   */    
  public function checkIsValidForCreate() {
      $errors = array();
      if (strlen(trim($this->nombre)) == 0 ) {
	$errors["nombre"] = "Nombre es obligatorio";
      }
	  if (strlen(trim($this->password)) == 0 ) {
	$errors["password"] = "Contraseña es obligatorio";
      }
	  if (strlen(trim($this->email)) == 0 ) {
	$errors["email"] = "Email es obligatorio";
      }
      
      if (sizeof($errors) > 0){
	throw new ValidationException($errors, "Organizador no valido");
      }
  }

  /**
   * Checks if the current instance is valid
   * for being updated in the database.
   * 
   * @throws ValidationException if the instance is
   * not valid
   * 
   * @return void
   */
  public function checkIsValidForUpdate() {
    $errors = array();
    
    if (!isset($this->id)) {      
      $errors["id"] = "id is mandatory";
    }
    
    try{
      $this->checkIsValidForCreate();
    }catch(ValidationException $ex) {
      foreach ($ex->getErrors() as $key=>$error) {
	$errors[$key] = $error;
      }
    }    
    if (sizeof($errors) > 0) {
      throw new ValidationException($errors, "Organizador no valido");
    }
  }
}
