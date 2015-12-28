<?php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/Comentario.php");
require_once(__DIR__."/../model/IngredienteMapper.php");

	class Pincho {
		public $id_pincho;
		public $nombre;
		public $descripcion;
		public $celiaco;
		public $validado;
		public $concurso;
		public $num_votos;
		public $establecimiento;
		private $ingredientes;
		public $votPro=0;
		public $imagen;

		public function __construct($nombre=NULL, $celiaco=NULL, $descripcion=NULL, $num_votos=NULL, $establecimiento=NULL, $id_pincho=NULL,$validado=NULL,$concurso=NULL,$imagen=NULL) {
			$this->nombre= $nombre;
			$this->celiaco  = $celiaco;
			$this->descripcion = $descripcion;
			$this->num_votos = $num_votos;
			$this->establecimiento = $establecimiento;
			$this->id_pincho = $id_pincho;
			$this->validado = $validado;
			$this->concurso = $concurso;
			$this->ingredientes = new IngredienteMapper();
			$this->imagen = $imagen;
		}

		public function getNombre(){
			return $this->nombre;
		}

		public function getVotPro(){
			return $this->votPro;
		}

		public function setVotPro(){
			$this->votPro = $this->recuentoVotacionProfesional($this->id_pincho);
		}
		
		public function isCeliaco(){
			return $this->celiaco;
		}
		
		public function getValidado(){
			return $this->validado;
		}

		public function getNumComentarios(){
			$list = [];
			$db = PDOConnection::getInstance();
			$query = $db->prepare('SELECT COUNT(FK_cod) AS num FROM comentarios where FK_cod=? AND comentario IS NOT NULL');
			$query->execute(array($this->id_pincho));
			$num_comentarios = $query->fetch(PDO::FETCH_ASSOC);
			return $num_comentarios["num"];
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

		public function getConcurso(){
			return $this->concurso;
		}
		public function setConcurso($concurso){
			$this->concurso=$concurso;
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

		public function getComentario($pincho){
			$list = [];
			$db = PDOConnection::getInstance();
			$query = $db->prepare('SELECT * FROM comentarios where FK_cod=? AND comentario IS NOT NULL');
			$query->execute(array($pincho));
			foreach($query->fetchAll() as $comentario) {
				$list[] = new Comentario($comentario['FK_juradoPopular_vot'], $comentario['FK_cod'], $comentario['comentario']);
    		}
   		 	return $list;
		}
		
		public function getImagen(){
			return $this->imagen;
		}
		public function setImagen($imagen){
			$this->imagen=$imagen;
		}

		//devuelve el numero de pinchos validados
		public static function getNumPinchos()
		{
			$db = PDOConnection::getInstance();
			$query = $db->query('SELECT count(*) as num FROM pincho WHERE validado = 1');
			$num_pinchos = $query->fetch(PDO::FETCH_ASSOC);
			return $num_pinchos;
		}

		//devuelve un numero de pinchos indicados
		public static function getPinchos($inicio = 0, $limite = 5)
		{
			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->query('SELECT * FROM pincho WHERE validado = 1 limit '.$inicio.', '.$limite.'');
			foreach($req->fetchAll() as $pincho) {
				$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho'],$pincho['validado'],$pincho['FK_concurso_pinc'], $pincho['imagen']);
			}
			return $list;
		}

		//devuelve todos los pinchos validados
		public static function all() {
			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->query('SELECT * FROM pincho WHERE validado = 1');
			
			// we create a list of Post objects from the database results
			foreach($req->fetchAll() as $pincho) {
				$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho'],$pincho['validado'],$pincho['FK_concurso_pinc']);
			}
			return $list;
		}

		//devuelve todos los pinchos validados ordenados por numero de votos
		public static function allOrdenados() {
			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->query('SELECT * FROM pincho WHERE validado = 1 ORDER BY num_votos DESC');
			
			// we create a list of Post objects from the database results
			foreach($req->fetchAll() as $pincho) {
				$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho'],$pincho['validado'],$pincho['FK_concurso_pinc']);
			}
			return $list;
		}

		//devuelve un pincho especifico
		public static function find($id) {
			$db = PDOConnection::getInstance();
			// we make sure $id is an integer
			$id = intval($id);
			$req = $db->prepare('SELECT * FROM pincho WHERE id_pincho = '.$id);
			$req->execute(array());
			$pincho = $req->fetch();
			return new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho'],$pincho['validado'],$pincho['FK_concurso_pinc'],$pincho['imagen']);
		}

		//devuelve un pincho de un determinado establecimiento
		public static function findByEstablecimiento(Establecimiento $esta){
			$db = PDOConnection::getInstance();
			$req = $db->prepare("SELECT * FROM pincho WHERE FK_establecimiento_pinc =?");
			$req->execute(array($esta->getId()));
			$pincho = $req->fetch();
			if($pincho!=NULL){
					return new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho'],$pincho['validado'],$pincho['FK_concurso_pinc'],$pincho['imagen']);
			}else{
				return NULL;
			}
		}

		//devuelve el pincho valido de un establecimiento
		public static function pinchoValido(Establecimiento $esta){
			$db = PDOConnection::getInstance();
			$req = $db->prepare("SELECT * FROM pincho WHERE validado=1 AND FK_establecimiento_pinc =?");
			$req->execute(array($esta->getId()));
			$pincho = $req->fetch();
			if($pincho!=NULL){
				return new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho'],$pincho['validado'],$pincho['FK_concurso_pinc']);
			}else{
				return NULL;
			}
		}

		//devuelve los pinchos no validados
		public static function noValidados(){
			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->query('SELECT * FROM pincho WHERE validado = 0');
			foreach($req->fetchAll() as $pincho) {
				$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho'],$pincho['validado'],$pincho['FK_concurso_pinc']);
    		}
   		 	return $list;
		}

		//valida un pincho
		public static function validar($id){
			$db = PDOConnection::getInstance();
			// we make sure $id is an integer
			$id = intval($id);
			$stmt = $db->prepare('UPDATE pincho set validado = 1  WHERE id_pincho = '.$id);
    		$stmt->execute(array());
		}

		//elimina un pincho
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

 		//devuelve los pinchos no asignados de un determinado jurado profesional
 		public function pinchosNoAsignados($idJPro){
 			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->prepare("SELECT * FROM pincho WHERE pincho.validado=1 AND pincho.id_pincho NOT IN (SELECT vota_pro.FK_pincho_vota FROM vota_pro WHERE vota_pro.FK_juradoProfesional_vota=?)");
			$req->execute(array($idJPro));
			$pinchos =$req->fetchAll(PDO::FETCH_ASSOC);
			if($pinchos!=null){
				foreach($pinchos as $pincho) {
					$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho'],$pincho['validado'],$pincho['FK_concurso_pinc']);
	    		}
   		 		return $list;
			}else{
				return NULL;
			}
 		}

 		//devuelve los pinchos asignados de un determinado jurado profesional
 		public function pinchosAsignados($idJPro){
 			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->prepare("SELECT * FROM pincho WHERE pincho.validado=1 AND pincho.id_pincho IN (SELECT vota_pro.FK_pincho_vota FROM vota_pro WHERE vota_pro.FK_juradoProfesional_vota=?)");
			$req->execute(array($idJPro));
			$pinchos =$req->fetchAll(PDO::FETCH_ASSOC);
			if($pinchos!=null){
				foreach($pinchos as $pincho) {
					$list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho'],$pincho['validado'],$pincho['FK_concurso_pinc']);
	    		}
   		 		return $list;
			}else{
				return NULL;
			}
 		}

 		//devuelve los pinchos de la segunda ronda
 		public function pinchosSegunda(){
 			
			$db = PDOConnection::getInstance();
			$req = $db->query("SELECT DISTINCT FK_pincho_vota AS pinchos FROM vota_pro WHERE ronda=2");
			$pinchos_db = $req->fetchAll(PDO::FETCH_ASSOC);
			$pinchos = array();
    
			foreach ($pinchos_db as $pincho) {
	      		array_push($pinchos,$pincho['pinchos']);
	    	} 

			return $pinchos;
 		}
		
		//devuelve la suma de los votos de un determinado pincho, de la votacion profesional
		public function recuentoVotacionProfesional($pincho){
 			$list = [];
			$db = PDOConnection::getInstance();
			$req = $db->prepare("SELECT SUM(votacion) AS voto FROM vota_pro WHERE ronda=2 AND FK_pincho_vota=? ");
			$req->execute(array($pincho));
			$votos = $req->fetch(PDO::FETCH_ASSOC);
			   
			 
			return $votos['voto'];   
		}

	}
?>
