<?php

require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Premio.php");

class PremioMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }

  public function findAll(){
  	$stmt = $this->db->query("SELECT * FROM premio");    
    $premio_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $premios = array();    
    foreach ($premio_db as $premio) {
      array_push($premios, new Premio($premio["id_premio"], $premio["tipo"]));
    }
    return $premios;
  }

  public function findById($id){
  	$req = $this->db->prepare('SELECT * FROM premio WHERE id_premio =?');
		$req->execute(array($id));
		$premio = $req->fetch();
		return new Premio($premio['id_premio'], $premio['tipo']);

  }

  public function save($premio){
    $stmt = $this->db->prepare("INSERT INTO premio values (?,?)");
    $stmt->execute(array($premio->getId(), $premio->getTipo()));
  }

  public function asignar($id_premio, $id_pincho, $posicion){
  	$stmt = $this->db->prepare("INSERT INTO premiados values (?,?,?)");
    $stmt->execute(array($id_pincho, $id_premio, $posicion));
  }




}

?>