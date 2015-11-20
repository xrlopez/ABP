<?php


require_once(__DIR__."/../core/ValidationException.php");


class Codigo {

  private $establecimiento;
  private $id_codigo; 
  private $usado;
  
  public function __construct($establecimiento=NULL, $id_codigo=NULL, $usado=NULL) {
    $this->establecimiento = $establecimiento;
    $this->id_codigo = $id_codigo;
    $this->usado = $usado;    
  }

     
  public function getId() {
    return $this->id_codigo;
  }  
  public function setId($id_codigo) {
    $this->id_codigo=$id_codigo;
  }
  
  public function getEstablecimiento() {
    return $this->establecimiento;
  }   
  public function setEstablecimiento($establecimiento) {
    $this->establecimiento = $establecimiento;
  }

  public function getUsado() {
    return $this->usado;
  }   
  public function setUsado($usado) {
    $this->usado = $usado;
  }

}
