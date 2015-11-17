<?php


require_once(__DIR__."/../core/ValidationException.php");


class Concurso {

  private $id_concurso; 
  private $nombre;   
  private $localizacion;
  private $descripcion;
  private $organizador;
  
  public function __construct($id_concurso=NULL, $nombre=NULL, $localizacion=NULL, $descripcion=NULL, Organizador $organizador=NULL) {
    $this->id_concurso = $id_concurso;
    $this->nombre = $nombre;
    $this->localizacion = $localizacion;
    $this->descripcion = $descripcion;
    $this->organizador = $organizador;
    
  }

     
  public function getId() {
    return $this->id_concurso;
  }  
  
  public function getNombre() {
    return $this->nombre;
  }   
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }

  public function getLocalizacion() {
    return $this->localizacion;
  }   
  public function setLocalizacion($localizacion) {
    $this->localizacion = $localizacion;
  }
  
  public function getDescripcionConcurso() {
    return $this->descripcion;
  }   
  public function setDescripcion($descripcion) {
    $this->descripcion = $descripcion;
  }
  
  public function getOrganizador() {
    return $this->organizador;
  }   
  public function setOrganizador($organizador) {
    $this->organizador = $organizador;
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
	  if (strlen(trim($this->localizacion)) == 0 ) {
	$errors["localizacion"] = "Localizacion es obligatorio";
      }
	  if (strlen(trim($this->organizador)) == 0 ) {
	$errors["organizador"] = "Organizador es obligatorio";
      }
      
      if (sizeof($errors) > 0){
	throw new ValidationException($errors, "concurso no valido");
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
      throw new ValidationException($errors, "concurso no valido");
    }
  }
}
