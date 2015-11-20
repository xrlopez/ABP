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

}
