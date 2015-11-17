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
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
   public function findAll(){  
    $stmt = $this->db->query("SELECT * FROM juradoprofesional, usuario WHERE usuario.id_usuario = juradoprofesional.id_usuario");    
    $jPop_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $jPops = array();
    
    foreach ($jPop_db as $jPop) {
      $organizador = new Organizador($jPop["FK_organizador_jPro"]);
      array_push($jPops, new JuradoProfesional($jPop["id_usuario"], $jPop["nombre"], $jPop["password"], $jPop["email"], $jPop["profesion"], $organizador, $jPop["tipo"]));
    }   
	
    return $jPops;
  }
  
  
  public function findById($jPopid){
    $stmt = $this->db->prepare("SELECT * FROM juradoprofesional, usuario WHERE usuario.id_usuario=? AND usuario.id_usuario = juradoprofesional.id_usuario");
    $stmt->execute(array(jPopid));
    $jPop = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($jPop != null) {
      return new JuradoProfesional(
		$jPop["id_usuario"],
		$jPop["nombre"],
		$jPop["password"],
		$jPop["email"],
		$jPop["profesion"],
		new Organizador($jPop["organizador"]),
		$jPop["tipo"]
	);}
  }
  
  public function update(Organizador $jPop) {
    $stmt = $this->db->prepare("UPDATE usuario set nombre=?, password=?, email=? where id_usuario=?");
    $stmt->execute(array($jPop->getNombre(), $jPop->getPassword(), $jPop->getEmail(), $jPop->getId())); 
    $stmt = $this->db->prepare("UPDATE juradoprofesional set profesion=? where id_usuario=?");
    $stmt->execute(array($jPop->getRrofesion(), $jPop->getId()));    
  }
  
}
