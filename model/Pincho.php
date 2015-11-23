<?php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/IngredienteMapper.php");

	class Pincho {
		public $id_pincho;
		public $nombre;
		public $descripcion;
		public $celiaco;
		public $validado;
		public $num_votos;
		public $establecimiento;
		private $ingredientes;


		public function __construct($nombre=NULL, $celiaco=NULL, $descripcion=NULL, $num_votos=NULL, $establecimiento=NULL, $id_pincho=NULL) {
			$this->nombre= $nombre;
			$this->celiaco  = $celiaco;
			$this->descripcion = $descripcion;
			$this->num_votos = $num_votos;
			$this->establecimiento = $establecimiento;
			$this->id_pincho = $id_pincho;
			$this->validado = 0;
			$this->ingredientes = new IngredienteMapper();
		}

		public function getNombre(){
			return $this->nombre;
		}
		
		public function isCeliaco(){
			return $this->celiaco;
		}
		
		public function getValidado(){
			return $this->validado;
		}
		public function setValidado($validado){
			$this->validado = $validado;
		}
		
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

		public function getNombreEstablecimiento(){
			$db = PDOConnection::getInstance();
			$query = $db->prepare('SELECT nombre as name FROM usuario WHERE id_usuario=?');
			$query->execute(array($this->establecimiento));
			$nombre = $query->fetch();
			return $nombre['name'];
		}

		public function getIngredientes(){
			return $this->ingredientes->getIngredientes($this->id_pincho);
		}

		public function checkIsValidForCreate() {
			$errors = array();
			if (strlen(trim($this->nombre)) == 0 ) {
				$errors["nombre"] = "Nombre es obligatorio";
			}
			if (strlen(trim($this->celiaco)) == 0 ) {
				$errors["celiaco"] = "Celiaco es obligatorio";
			}
			if (strlen(trim($this->descripcion)) == 0 ) {
				$errors["descripcion"] = "Descripcion es obligatorio";
			}
			if (sizeof($errors) > 0){
			throw new ValidationException($errors, "Pincho no valido");
			}
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
			$req = $db->query('SELECT * FROM pincho WHERE validado = 1 limit '.$inicio.', '.$limite.'');
			foreach($req->fetchAll() as $pincho) {
				$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
			}
			return $list;
		}

		public static function all() {
			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->query('SELECT * FROM pincho WHERE validado = 1');
			
			// we create a list of Post objects from the database results
			foreach($req->fetchAll() as $pincho) {
				$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
			}
			return $list;
		}

		public static function allOrdenados() {
			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->query('SELECT * FROM pincho WHERE validado = 1 ORDER BY num_votos DESC');
			
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
			if($pincho!=NULL){
					return new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
			}else{
				return NULL;
			}
		}

		public static function noValidados(){
			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->query('SELECT * FROM pincho WHERE validado = 0');
			foreach($req->fetchAll() as $pincho) {
				$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']);
    		}
   		 	return $list;
		}

		public static function validar($id){
			$db = PDOConnection::getInstance();
			// we make sure $id is an integer
			$id = intval($id);
			$stmt = $db->prepare('UPDATE pincho set validado = 1  WHERE id_pincho = '.$id);
    		$stmt->execute(array());
		}

		public function eliminar($id){
		    $pincho = Pincho::find($id);   
		    if ($pincho == NULL) {
		      throw new Exception("No existe el pincho ".$id);
		    }
		    
		    // Delete the Jurado Popular object from the database
		    $db = PDOConnection::getInstance();
		    $stmt = $db->prepare("DELETE from pincho WHERE id_pincho=?");
    		$stmt->execute(array($pincho->getId())); 
 		}

	}




?>
