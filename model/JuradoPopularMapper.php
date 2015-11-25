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
    $stmt = $this->db->query("SELECT * FROM juradopopular, usuario WHERE usuario.id_usuario = juradopopular.id_usuario");    
    $jPop_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $jPops = array();
    
    foreach ($jPop_db as $jPop) {
      array_push($jPops, new JuradoPopular($jPop["id_usuario"], $jPop["nombre"], $jPop["password"], $jPop["email"], $jPop["residencia"], $jPop["tipo"]));
    }   
	
    return $jPops;
  }
  
  
  public function findById($jPopid){
    $stmt = $this->db->prepare("SELECT * FROM juradopopular, usuario WHERE usuario.id_usuario=? AND usuario.id_usuario = juradopopular.id_usuario");
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
    $stmt = $this->db->prepare("UPDATE juradopopular set residencia=? where id_usuario=?");
    $stmt->execute(array($jPop->getResidencia(), $jPop->getId()));    
  }
  
  public function delete(JuradoPopular $jPop) {
    $stmt = $this->db->query("SET FOREIGN_KEY_CHECKS=0");
    $stmt = $this->db->prepare("DELETE from juradopopular WHERE id_usuario=?");
    $stmt->execute(array($jPop->getId()));    
    $stmt = $this->db->query("SET FOREIGN_KEY_CHECKS=1");  
    $stmt = $this->db->prepare("DELETE from usuario WHERE id_usuario=?");
    $stmt->execute(array($jPop->getId()));  
  }
  
}
