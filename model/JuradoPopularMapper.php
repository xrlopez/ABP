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
  
  //recupera todo los jurados populares
   public function findAll(){  
    $stmt = $this->db->query("SELECT * FROM juradoPopular, usuario WHERE usuario.id_usuario = juradoPopular.id_usuario");    
    $jPop_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $jPops = array();
    
    foreach ($jPop_db as $jPop) {
      array_push($jPops, new JuradoPopular($jPop["id_usuario"], $jPop["nombre"], $jPop["password"], $jPop["email"], $jPop["residencia"], $jPop["tipo"]));
    }   
	
    return $jPops;
  }
  
  //recupera un jurado popular por su identificador
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
  
  //modifica un jurado popular
  public function update(JuradoPopular $jPop) {
    $stmt = $this->db->prepare("UPDATE usuario set nombre=?, password=?, email=? where id_usuario=?");
    $stmt->execute(array($jPop->getNombre(), $jPop->getPassword(), $jPop->getEmail(), $jPop->getId())); 
    $stmt = $this->db->prepare("UPDATE juradoPopular set residencia=? where id_usuario=?");
    $stmt->execute(array($jPop->getResidencia(), $jPop->getId()));    
  }
  
  //elimina un jurado popular
  public function delete(JuradoPopular $jPop) {
    $stmt = $this->db->query("SET FOREIGN_KEY_CHECKS=0");
    $stmt = $this->db->prepare("DELETE from juradoPopular WHERE id_usuario=?");
    $stmt->execute(array($jPop->getId()));    
    $stmt = $this->db->query("SET FOREIGN_KEY_CHECKS=1");  
    $stmt = $this->db->prepare("DELETE from usuario WHERE id_usuario=?");
    $stmt->execute(array($jPop->getId()));  
  }
  
}
