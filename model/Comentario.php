<?php


require_once(__DIR__."/../core/ValidationException.php");


class Comentario {

  private $jpop;
  private $id_pincho; 
  private $comentario;
  
  public function __construct($jpop=NULL, $id_pincho=NULL, $comentario=NULL) {
    $this->jpop = $jpop;
    $this->id_pincho = $id_pincho;
    $this->comentario = $comentario;    
  }

     
  public function getJpop() {
    return $this->jpop;
  }  
  public function setJpop($jpop) {
    $this->jpop=$jpop;
  }

  public function getIdPincho() {
    return $this->id_pincho;
  }  
  public function setIdPincho($id_pincho) {
    $this->id_pincho=$id_pincho;
  }

  public function getComentario() {
    return $this->comentario;
  }  
  public function setComentario($comentario) {
    $this->comentario=$comentario;
  }
  

}
