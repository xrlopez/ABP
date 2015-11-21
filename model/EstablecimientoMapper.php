<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/Codigo.php");

class EstablecimientoMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
   public function findAll(){  
    $stmt = $this->db->query("SELECT * FROM establecimiento, usuario WHERE usuario.id_usuario = establecimiento.id_usuario");    
    $esta_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $estas = array();
    
    foreach ($esta_db as $esta) {
      array_push($estas, new Establecimiento($esta["id_usuario"], $esta["nombre"], $esta["password"], $esta["email"], $esta["localizacion"], $esta["descripcion"], $esta["tipo"]));
    }   
	
    return $estas;
  }
  
  
  public function findById($establecimiento){
    $stmt = $this->db->prepare("SELECT * FROM establecimiento, usuario WHERE usuario.id_usuario=? AND usuario.id_usuario = establecimiento.id_usuario");
    $stmt->execute(array($establecimiento));
    $esta = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($esta != null) {
      return new Establecimiento(
		$esta["id_usuario"],
		$esta["nombre"],
		$esta["password"],
		$esta["email"],
		$esta["localizacion"],
		$esta["descripcion"],
		$esta["tipo"]
	);}
  }


  
  public function update(Establecimiento $esta) {
    $stmt = $this->db->prepare("UPDATE usuario set nombre=?, password=?, email=? where id_usuario=?");
    $stmt->execute(array($esta->getNombre(), $esta->getPassword(), $esta->getEmail(), $esta->getId())); 
    $stmt = $this->db->prepare("UPDATE establecimiento set localizacion=?, descripcion=? where id_usuario=?");
    $stmt->execute(array($esta->getLocalizacion(), $esta->getDescripcion(), $esta->getId()));    
  }
  
  public function generarCodigos(Establecimiento $esta){
    $pr=1;
    $stmt = $this->db->prepare("SELECT * FROM codigo WHERE ?"); 
          $stmt->execute(array($pr));   
    $cods = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $num=0;
    foreach ($cods as $cod) {
      if($num<$cod["id_codigo"]){
          $num = $cod["id_codigo"];
      }
    }
    for ($i = 1; $i <= 100; $i++) {
          $stmt = $this->db->prepare("INSERT INTO codigo(FK_establecimiento_cod, id_codigo, usado) VALUES (?,NULL,0)");
          $stmt->execute(array($esta->getId()));
    }
    $stmt2 = $this->db->prepare("SELECT * FROM codigo WHERE id_codigo>?");
          $stmt2->execute(array($num));
    $cod_bd = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $cods = array();
    
    foreach ($cod_bd as $cod) {
      array_push($cods, new Codigo($cod["FK_establecimiento_cod"], $cod["id_codigo"], $cod["usado"]));
    }   
  
    return $cods;

  }
}