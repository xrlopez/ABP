<?php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Establecimiento.php");
	class Pincho {
		public $id_pincho;
		public $nombre;
		public $descripcion;
		public $celiaco;
		//public $validado;
		public $num_votos;
		public $establecimiento;
		public $ingredientes;

		public function __construct($nombre=NULL, $celiaco=NULL, $descripcion=NULL, $num_votos=NULL, $establecimiento=NULL, $id_pincho=NULL) {
			$this->nombre= $nombre;
			$this->celiaco  = $celiaco;
			$this->descripcion = $descripcion;
			$this->num_votos = $num_votos;
			$this->establecimiento = $establecimiento;
			$this->id_pincho = $id_pincho;
			}

		public function getNombre(){
			return $this->nombre;
		}
		
		public function isCeliaco(){
			return $this->celiaco;
		}
		/*
		public function getValidado(){
			return $this->validado;
		}
		public function setValidado($validado){
			$this->validado = $validado;
		}
		*/
		public function getDescripcion(){
			return $this->descripcion;
		}
		
		public function getVotos(){
			return $this->num_votos;
		}
		
		public function getId(){
			return $this->id_pincho;
		}
		
		public function getEstablecimiento(){
			return $this->establecimiento;
		}

		public function setNombre($nombre){
			$this->nombre = $nombre;
		}
		
		public function setCeliaco($celiaco){
			$this->celiaco = $celiaco;
		}
		
		public function setDescripcion($descripcion){
			$this->descripcion = $descripcion;
		}
		
		public function setVotos($num_Votos){
			$this->num_votos = $num_Votos;
		}
		
		public function setId($id_pincho){
			$this->id_pincho = $id_pincho;
		}
		
		public function setEstablecimiento($establecimiento){
			$this->establecimiento = $establecimiento;
		}



		public static function getNumPinchos()
		{
			$db = PDOConnection::getInstance();
			$query = $db->query('SELECT count(*) as num FROM pincho');
			$num_pinchos = $query->fetch(PDO::FETCH_ASSOC);
			return $num_pinchos;
		}

		public static function getPinchos($inicio = 0, $limite = 5)
		{
			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->query('SELECT * FROM pincho limit '.$inicio.', '.$limite.'');
			foreach($req->fetchAll() as $pincho) {
				$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
			}
			return $list;
		}

		public static function all() {
			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->query('SELECT * FROM pincho');
			
			// we create a list of Post objects from the database results
			foreach($req->fetchAll() as $pincho) {
				$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
			}

			return $list;
		}

		public static function find($id) {
			$db = PDOConnection::getInstance();
			// we make sure $id is an integer
			$id = intval($id);
			$req = $db->prepare('SELECT * FROM pincho WHERE id_pincho = '.$id);
			$req->execute(array());
			$pincho = $req->fetch();
			return new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
		}

		public static function findByEstablecimiento(Establecimiento $esta){
			$db = PDOConnection::getInstance();
			// we make sure $id is an integer
			$req = $db->prepare("SELECT * FROM pincho WHERE FK_establecimiento_pinc =?");
			$req->execute(array($esta->getId()));
			$pincho = $req->fetch();
			return new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
		}

	}




?>
