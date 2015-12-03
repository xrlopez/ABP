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
  

}
