<?php


require_once(__DIR__."/../core/ValidationException.php");

require_once(__DIR__."/../model/Pincho.php");

class Premio{
	private $id_premio;
	private $tipo;

	public function __construct($id_premio = NULL, $tipo = NULL){
		$this->id_premio = $id_premio;
		$this->tipo = $tipo;
	}

	public function getId(){
		return $this->id_premio;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function setId($id){
		$this->id_premio = $id;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}

	public function getPosiciones(){
		$list = array();
		$db = PDOConnection::getInstance();
		$req = $db->query('SELECT posicion as posicion, FK_pincho_prem as id_pincho FROM premiados WHERE FK_premio_prem='.$this->getId());
		foreach($req->fetchAll() as $posicion) {
			$list[] = array($posicion['posicion'],Pincho::find($posicion['id_pincho'])->getNombre());
		}
		return $list;
	}

	public function checkIsValidForCreate() {
      $errors = array();
      if (strlen(trim($this->id_premio)) == 0 ) {
	$errors["id_premio"] = "ID es obligatorio";
      }
	  if (strlen(trim($this->tipo)) == 0 ) {
	$errors["tipo"] = "Tipo es obligatorio";
      }
      
      if (sizeof($errors) > 0){
	throw new ValidationException($errors, "Premio no valido");
      }
  }
}
?>