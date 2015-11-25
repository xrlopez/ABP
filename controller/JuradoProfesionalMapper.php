<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/JuradoProfesional.php");
require_once(__DIR__."/../model/Organizador.php");

class JuradoProfesionalMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  private $organizador;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
   public function findAll(){  
    $stmt = $this->db->query("SELECT * FROM juradoprofesional, usuario WHERE usuario.id_usuario = juradoprofesional.id_usuario");    
    $jPro_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $jPros = array();
    
    foreach ($jPro_db as $jPro) {
	  $this->organizador = new Organizador($jPro["FK_organizador_jPro"]);
      array_push($jPros, new JuradoProfesional($jPro["id_usuario"], $jPro["nombre"], $jPro["password"], $jPro["email"], $jPro["profesion"], $jPro["FK_organizador_jPro"], $jPro["tipo"]));
    }   
	
    return $jPros;
  }
  
  
  public function findById($jProid){
    $stmt = $this->db->prepare("SELECT * FROM juradoprofesional, usuario WHERE usuario.id_usuario=? AND usuario.id_usuario = juradoprofesional.id_usuario");
    $stmt->execute(array($jProid));
    $jPro = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($jPro != null) {
      return new JuradoProfesional(
		$jPro["id_usuario"],
		$jPro["nombre"],
		$jPro["password"],
		$jPro["email"],
		$jPro["profesion"],
		$jPro["FK_organizador_jPro"],
		$jPro["tipo"]
	);}
  }
  
  public function update(JuradoProfesional $jPro) {
    $stmt = $this->db->prepare("UPDATE usuario set nombre=?, password=?, email=? where id_usuario=?");
    $stmt->execute(array($jPro->getNombre(), $jPro->getPassword(), $jPro->getEmail(), $jPro->getId())); 
    $stmt = $this->db->prepare("UPDATE juradoprofesional set profesion=? where id_usuario=?");
    $stmt->execute(array($jPro->getProfesion(), $jPro->getId()));    
  }
  
  public function delete(JuradoProfesional $jPro) {
    $stmt = $this->db->prepare("DELETE from juradoprofesional WHERE id_usuario=?");
    $stmt->execute(array($jPro->getId()));    
    $stmt = $this->db->prepare("DELETE from usuario WHERE id_usuario=?");
    $stmt->execute(array($jPro->getId()));    
  }
  
  public function votos($jProid){
	  /*
	  $stmt = $this->db->prepare("SELECT * FROM vota_pro, pincho WHERE FK_juradoProfesional_vota = ? 
									AND ronda = 2 AND pincho.id_pincho = vota_pro.FK_pincho_vota");
	  $stmt->execute(array($jProid));
	  */
	  $stmt= $this->db->query("SELECT * FROM vota_pro, pincho 
						WHERE FK_juradoProfesional_vota = '$jProid' AND ronda = 2 AND pincho.id_pincho = vota_pro.FK_pincho_vota");
	  $jProPinchos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
	  $pinchosVotos = array();
	  
	  if($jProPinchos_db == null){
	
		  $stmt = $this->db->query("SELECT * FROM vota_pro, pincho 
									WHERE FK_juradoProfesional_vota = '$jProid' AND ronda = 1 AND pincho.id_pincho = vota_pro.FK_pincho_vota");
		  //$stmt->execute(array($jProid));
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
