<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Organizador.php");
require_once(__DIR__."/../model/JuradoProfesional.php");
require_once(__DIR__."/../model/Pincho.php");

class OrganizadorMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
  public function findAll(){  
    $stmt = $this->db->query("SELECT * FROM organizador, usuario WHERE usuario.id_usuario = organizador.id_usuario");    
    $organizador_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $orgas = array();
    
    foreach ($organizador_db as $orga) {
      array_push($orgas, new Organizador($orga["id_usuario"], $orga["nombre"], $orga["password"], $orga["email"], $orga["descripcionOrga"], $orga["tipo"]));
    }   
	
    return $orgas;
  }
  
  public function findById($orgaid){
    $stmt = $this->db->prepare("SELECT * FROM organizador, usuario WHERE usuario.id_usuario=? AND usuario.id_usuario = organizador.id_usuario");
    $stmt->execute(array($orgaid));
    $orga = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($orga != null) {
      return new Organizador(
		$orga["id_usuario"],
		$orga["nombre"],
		$orga["password"],
		$orga["email"],
		$orga["descripcionOrga"],
		$orga["tipo"]
	);}
  }
  
  public function update(Organizador $orga) {
    $stmt = $this->db->prepare("UPDATE usuario set nombre=?, password=?, email=? where id_usuario=?");
    $stmt->execute(array($orga->getNombre(), $orga->getPassword(), $orga->getEmail(), $orga->getId())); 
    $stmt = $this->db->prepare("UPDATE organizador set descripcionOrga=? where id_usuario=?");
    $stmt->execute(array($orga->getDescripcionOrga(), $orga->getId()));    
  }
  public function delete(Organizador $orga) {
    $stmt = $this->db->query("SET FOREIGN_KEY_CHECKS=0");
    $stmt = $this->db->prepare("DELETE from organizador WHERE id_usuario=?");
    $stmt->execute(array($orga->getId()));    
    $stmt = $this->db->query("SET FOREIGN_KEY_CHECKS=1");
    $stmt = $this->db->prepare("DELETE from usuario WHERE id_usuario=?");
    $stmt->execute(array($orga->getId()));    
  }

  public function asignar(JuradoProfesional $jpro,$pinchos,Organizador $orga){
    foreach ($pinchos as $pincho) {
      $stmt = $this->db->prepare("INSERT INTO asignar_jregistrado VALUES(?,?,?)");
      $stmt->execute(array($jpro->getId(), $pincho->getId(),$orga->getId()));
    }
  }

  public function votacionPro($ronda){
    
    $stmt = $this->db->prepare("SELECT *, SUM(votacion) as total FROM vota_pro WHERE ronda=?  GROUP BY FK_pincho_vota ORDER BY votacion DESC ");
    $stmt->execute(array($ronda));
    $list = [];
    foreach($stmt->fetchAll() as $info){
      $pincho = Pincho::find($info['FK_pincho_vota']);
      $pincho->setVotos($info['total']);
      $list[] = $pincho;
    }
    return $list;
  }
  
}
