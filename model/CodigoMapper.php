<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Codigo.php");
require_once(__DIR__."/../model/JuradoPopular.php");

class CodigoMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
  public function findById($codigo){
    $stmt = $this->db->prepare("SELECT * FROM codigo WHERE id_codigo=?");
    $stmt->execute(array($codigo));
    $cod = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($cod != null) {
      return new Codigo(
		$cod["FK_establecimiento_cod"],
		$cod["id_codigo"],
		$cod["usado"]
	);}
  }
  
  public function update(Codigo $cod) {
    $stmt = $this->db->prepare("UPDATE codigo set usado=? where id_codigo=?");
    $stmt->execute(array($cod->getUsado(), $cod->getId()));
  
  }
  public function votar(Codigo $cod,JuradoPopular $jpop){
    $stmt = $this->db->prepare("INSERT INTO vota_pop values(?,?)");
    $stmt->execute(array($jpop->getId(), $cod->getId()));
    $stmt2 = $this->db->prepare("UPDATE pincho set num_votos=(num_votos + 1) where FK_establecimiento_pinc=?");
    $stmt2->execute(array($cod->getEstablecimiento()));

  }
}