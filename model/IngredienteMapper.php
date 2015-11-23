<?php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Ingrediente.php");

class IngredienteMapper {


	private $db;
  
	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}
	
	public function getIngredientes($id) {
		$list = [];
		// we make sure $id is an integer
		$id = intval($id);
		$req = $this->db->prepare('SELECT * FROM ingrediente WHERE FK_pincho_ing = '.$id);
		$req->execute(array());
		foreach($req->fetchAll() as $ingrediente){
			$list[] = new Ingrediente($ingrediente['ingrediente'],$ingrediente['FK_pincho_ing']);
		}
		return $list;
	}

	public function insert($ingrediente){
		$stmt = $this->db->prepare("INSERT INTO ingrediente values (?,?)");
		$stmt->execute(array($ingrediente->getId(), $ingrediente->getIngrediente()));
	}

	public function delete($ingrediente){
	    $stmt = $this->db->prepare("DELETE from ingrediente WHERE FK_pincho_ing=? AND ingrediente=?");
	    $stmt->execute(array($ingrediente->getId(), $ingrediente->getIngrediente())); 
	}


}
?>