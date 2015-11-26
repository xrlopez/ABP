<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/JuradoPopular.php");

class JuradoPopularMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
   public function findAll(){  
    $stmt = $this->db->query("SELECT * FROM juradoPopular, usuario WHERE usuario.id_usuario = juradoPopular.id_usuario");    
    $jPop_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $jPops = array();
    
    foreach ($jPop_db as $jPop) {
      array_push($jPops, new JuradoPopular($jPop["id_usuario"], $jPop["nombre"], $jPop["password"], $jPop["email"], $jPop["residencia"], $jPop["tipo"]));
    }   
	
    return $jPops;
  }
  
  
  public function findById($jPopid){
    $stmt = $this->db->prepare("SELECT * FROM juradoPopular, usuario WHERE usuario.id_usuario=? AND usuario.id_usuario = juradoPopular.id_usuario");
    $stmt->execute(array($jPopid));
    $jPop = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($jPop != null) {
      return new JuradoPopular(
		$jPop["id_usuario"],
		$jPop["nombre"],
		$jPop["password"],
		$jPop["email"],
		$jPop["residencia"],
		$jPop["tipo"]
	);}
  }
  
  public function update(JuradoPopular $jPop) {
    $stmt = $this->db->prepare("UPDATE usuario set nombre=?, password=?, email=? where id_usuario=?");
    $stmt->execute(array($jPop->getNombre(), $jPop->getPassword(), $jPop->getEmail(), $jPop->getId())); 
    $stmt = $this->db->prepare("UPDATE juradoPopular set residencia=? where id_usuario=?");
    $stmt->execute(array($jPop->getResidencia(), $jPop->getId()));    
  }
  
  public function delete(JuradoPopular $jPop) {
    $stmt = $this->db->query("SET FOREIGN_KEY_CHECKS=0");
    $stmt = $this->db->prepare("DELETE from juradoPopular WHERE id_usuario=?");
    $stmt->execute(array($jPop->getId()));    
    $stmt = $this->db->query("SET FOREIGN_KEY_CHECKS=1");  
    $stmt = $this->db->prepare("DELETE from usuario WHERE id_usuario=?");
    $stmt->execute(array($jPop->getId()));  
  }
  
  public function votos($jProid){
	  $stmt= $this->db->query("SELECT * FROM vota_pro, pincho 
						WHERE FK_juradoProfesional_vota = '$jProid' AND ronda = 2 AND pincho.id_pincho = vota_pro.FK_pincho_vota");
	  $jProPinchos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
	  $pinchosVotos = array();
	  
	  if($jProPinchos_db == null){
	
		  $stmt = $this->db->query("SELECT * FROM vota_pro, pincho 
									WHERE FK_juradoProfesional_vota = '$jProid' AND ronda = 1 AND pincho.id_pincho = vota_pro.FK_pincho_vota");
		  $jProPinchos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
	  }
	 
	  foreach($jProPinchos_db as $jProPinchos){
			  array_push($pinchosVotos, $jProPinchos);
	  }
	  return $pinchosVotos;
  }
  
  public function votar($jProid, $idPincho, $votacion){
	  $stmt= $this->db->query("SELECT * FROM vota_pro 
						WHERE FK_juradoProfesional_vota = '$jProid' AND ronda = 2");
	  $jProPinchos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
	  
	  if($jProPinchos_db == null){
	
		  $stmt = $this->db->prepare("UPDATE vota_pro SET votacion = ? 
									WHERE FK_juradoProfesional_vota = ? AND ronda = ? AND FK_pincho_vota = ?");
		  $stmt->execute(array($votacion, $jProid, 1, $idPincho));
	  } else{
		  $stmt = $this->db->prepare("UPDATE vota_pro SET votacion = ? 
									WHERE FK_juradoProfesional_vota = ? AND ronda = ? AND FK_pincho_vota = ?");
		  $stmt->execute(array($votacion, $jProid, 2, $idPincho));
	  }
  }
  
  public function getRonda($jProid){
	  $stmt= $this->db->query("SELECT MAX(ronda) AS rondaActual FROM vota_pro");
	  $jProPinchos_db = $stmt->fetch(PDO::FETCH_ASSOC);
	  return $jProPinchos_db['rondaActual'];
  }
  
}
