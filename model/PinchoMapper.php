<?php

require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Pincho.php");

class PinchoMapper{

	private $db;
	  
	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	public function getNumPinchos()
	{

		$query = $this->db->query('SELECT count(*) as num FROM pincho');
		$num_pinchos = $query->fetch(PDO::FETCH_ASSOC);
		return $num_pinchos;
	}

	public function getPinchos($inicio = 0, $limite = 5)
	{
		$list = [];
		$req = $this->db->query('SELECT * FROM pincho WHERE validado = 1 limit '.$inicio.', '.$limite.'');
		foreach($req->fetchAll() as $pincho) {
			$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
		}
		return $list;
	}

	public function all() {
		$list = [];
		$req = $this->db->query('SELECT * FROM pincho WHERE validado = 1');
		
		// we create a list of Post objects from the database results
		foreach($req->fetchAll() as $pincho) {
			$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
		}
		return $list;
	}

	public function allOrdenados() {
		$list = [];
		$req = $this->db->query('SELECT * FROM pincho WHERE validado = 1 ORDER BY num_votos DESC');
		
		// we create a list of Post objects from the database results
		foreach($req->fetchAll() as $pincho) {
			$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
		}
		return $list;
	}

	public function find($id) {
		// we make sure $id is an integer
		$id = intval($id);
		$req = $this->db->prepare('SELECT * FROM pincho WHERE id_pincho = '.$id);
		$req->execute(array());
		$pincho = $req->fetch();
		return new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
	}

	public function findByEstablecimiento(Establecimiento $esta){
		// we make sure $id is an integer
		$req = $this->db->prepare("SELECT * FROM pincho WHERE FK_establecimiento_pinc =?");
		$req->execute(array($esta->getId()));
		$pincho = $req->fetch();
		if($pincho!=NULL){
				return new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
		}else{
			return NULL;
		}
	}

	public function noValidados(){
		$list = [];
		$req = $this->db->query('SELECT * FROM pincho WHERE validado = 0');
		foreach($req->fetchAll() as $pincho) {
			$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
		}
		 	return $list;
	}

	public function validar($id){
		// we make sure $id is an integer
		$id = intval($id);
		$stmt = $this->db->prepare('UPDATE pincho set validado = 1  WHERE id_pincho = '.$id);
		$stmt->execute(array());
	}

	public function eliminar($id){
	    $pincho = Pincho::find($id);   
	    if ($pincho == NULL) {
	      throw new Exception("No existe el pincho ".$id);
	    }
	    
	    // Delete the Jurado Popular object from the database
	    $stmt = $this->db->prepare("DELETE from pincho WHERE id_pincho=?");
		$stmt->execute(array($pincho->getId())); 
	}

//TERMINAR!!
	public function save($pincho){
		$stmt = $this->db->prepare("INSERT INTO pincho values (?,?,?,?,?,?,?,?,?)");
		$stmt->execute(array(IDPINCHO,$pincho->getNombre(), $pincho->getDescripcion(), $pincho->isCeliaco(), 0, 0, FK_ORGANIZAD, FK_CONCURSO, $pincho->getEstablecimiento()));
	}



}
?>