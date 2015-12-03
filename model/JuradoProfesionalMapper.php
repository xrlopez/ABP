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
  
  //recupera todos los jurados profesionales
   public function findAll(){  
    $stmt = $this->db->query("SELECT * FROM juradoProfesional, usuario WHERE usuario.id_usuario = juradoProfesional.id_usuario");    
    $jPro_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $jPros = array();
    
    foreach ($jPro_db as $jPro) {
	  $this->organizador = new Organizador($jPro["FK_organizador_jPro"]);
      array_push($jPros, new JuradoProfesional($jPro["id_usuario"], $jPro["nombre"], $jPro["password"], $jPro["email"], $jPro["profesion"], $jPro["FK_organizador_jPro"], $jPro["tipo"]));
    }   
	
    return $jPros;
  }
  
  //recupera un jurado profesional por su identificador
  public function findById($jProid){
    $stmt = $this->db->prepare("SELECT * FROM juradoProfesional, usuario WHERE usuario.id_usuario=? AND usuario.id_usuario = juradoProfesional.id_usuario");
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
  
  //modifica un jurado profesional
  public function update(JuradoProfesional $jPro) {
    $stmt = $this->db->prepare("UPDATE usuario set nombre=?, password=?, email=? where id_usuario=?");
    $stmt->execute(array($jPro->getNombre(), $jPro->getPassword(), $jPro->getEmail(), $jPro->getId())); 
    $stmt = $this->db->prepare("UPDATE juradoProfesional set profesion=? where id_usuario=?");
    $stmt->execute(array($jPro->getProfesion(), $jPro->getId()));    
  }
  
  //elimina un jurado profesional
  public function delete(JuradoProfesional $jPro) {
    $stmt = $this->db->prepare("DELETE from juradoProfesional WHERE id_usuario=?");
    $stmt->execute(array($jPro->getId()));    
    $stmt = $this->db->prepare("DELETE from usuario WHERE id_usuario=?");
    $stmt->execute(array($jPro->getId()));    
  }
  
  /*recupera los votos(de la ronda actual) de un jurado profesional*/
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
  
  //guarda la votacion de la ronda correspondiente
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
  
  //devuelve la ronda actual de un jurado profesional
  public function getRonda($jProid){
	  $stmt= $this->db->query("SELECT MAX(ronda) AS rondaActual FROM vota_pro");
	  $jProPinchos_db = $stmt->fetch(PDO::FETCH_ASSOC);
	  return $jProPinchos_db['rondaActual'];
  }

  //devuelve el numero de jurados profesionales asignados a un pincho indicado
  public function getNumAsig($pincho){
	  $stmt= $this->db->prepare("SELECT count(FK_juradoProfesional_vota) AS numJpro FROM vota_pro where FK_pincho_vota=?");
	  $stmt->execute(array($pincho));
	  $numJpro_db = $stmt->fetch(PDO::FETCH_ASSOC);
	  return $numJpro_db['numJpro'];
  }

  //devuelve el numero maximo de jurados profesionales que se puede asignar a un pincho
  public function numAsigMax(){
	  $stmt= $this->db->query("SELECT count(id_usuario) AS numAsig FROM juradoProfesional");
	  $jProPinchos_db = $stmt->fetch(PDO::FETCH_ASSOC);
	  $num = ceil($jProPinchos_db['numAsig']/2);
	  return $num;
  }
}