<?php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Ingrediente.php");
require_once(__DIR__."/../model/Pincho.php");

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
			$list[] = new Ingrediente($ingrediente['FK_pincho_ing'],$ingrediente['ingrediente']);
		}
		return $list;
	}

	public function insert(Pincho $pincho, $ingrediente){
		$stmt = $this->db->prepare("INSERT INTO ingrediente values (?,?)");
		$stmt->execute(array($pincho->getId(), $ingrediente));
	}

	public function delete(Pincho $pincho, $ingrediente){
	    $stmt = $this->db->prepare("DELETE from ingrediente WHERE FK_pincho_ing=? AND ingrediente=?");
	    $stmt->execute(array($pincho->getId(), $ingrediente)); 
	}

	public function update(Pincho $pincho, $ingredienteNew, $ingredienteOld){
		$stmt = $this->db->prepare("UPDATE ingrediente set ingrediente=? where FK_pincho_ing=? AND ingrediente=?");
		$stmt->execute(array($ingredienteNew, $pincho->getId(), $ingredienteOld));
	}


}
?>