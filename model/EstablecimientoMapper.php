<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Establecimiento.php");

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
  
  
  public function findById($jPopid){
    $stmt = $this->db->prepare("SELECT * FROM establecimiento, usuario WHERE usuario.id_usuario=? AND usuario.id_usuario = establecimiento.id_usuario");
    $stmt->execute(array(jPopid));
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
  
  public function update(Organizador $esta) {
    $stmt = $this->db->prepare("UPDATE usuario set nombre=?, password=?, email=? where id_usuario=?");
    $stmt->execute(array($esta->getNombre(), $esta->getPassword(), $esta->getEmail(), $esta->getId())); 
    $stmt = $this->db->prepare("UPDATE establecimiento set localizacion=?, descripcion=? where id_usuario=?");
    $stmt->execute(array($esta->getLocalizacion(), $esta->getDescripcion(), $esta->getId()));    
  }
  
}
