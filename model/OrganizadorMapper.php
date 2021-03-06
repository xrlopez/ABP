<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Organizador.php");
require_once(__DIR__."/../model/JuradoProfesional.php");
require_once(__DIR__."/../model/Pincho.php");

class OrganizadorMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
  //devuelve todos los organizadores
  public function findAll(){  
    $stmt = $this->db->query("SELECT * FROM organizador, usuario WHERE usuario.id_usuario = organizador.id_usuario");    
    $organizador_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $orgas = array();
    
    foreach ($organizador_db as $orga) {
      array_push($orgas, new Organizador($orga["id_usuario"], $orga["nombre"], $orga["password"], $orga["email"], $orga["descripcionOrga"], $orga["tipo"]));
    }   
	
    return $orgas;
  }
  
  //devuelve un organizador indicado
  public function findById($orgaid){
    $stmt = $this->db->prepare("SELECT * FROM organizador, usuario WHERE usuario.id_usuario=? AND usuario.id_usuario = organizador.id_usuario");
    $stmt->execute(array($orgaid));
    $orga = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($orga != null) {
      return new Organizador(
		$orga["id_usuario"],
		$orga["nombre"],
		$orga["password"],
		$orga["email"],
		$orga["descripcionOrga"],
		$orga["tipo"]
	);}
  }
  
  //modifica un organizador
  public function update(Organizador $orga) {
    $stmt = $this->db->prepare("UPDATE usuario set nombre=?, password=?, email=? where id_usuario=?");
    $stmt->execute(array($orga->getNombre(), $orga->getPassword(), $orga->getEmail(), $orga->getId())); 
    $stmt = $this->db->prepare("UPDATE organizador set descripcionOrga=? where id_usuario=?");
    $stmt->execute(array($orga->getDescripcionOrga(), $orga->getId()));    
  }

  //borra un organizador
  public function delete(Organizador $orga) {
    $stmt = $this->db->query("SET FOREIGN_KEY_CHECKS=0");
    $stmt = $this->db->prepare("DELETE from organizador WHERE id_usuario=?");
    $stmt->execute(array($orga->getId()));    
    $stmt = $this->db->query("SET FOREIGN_KEY_CHECKS=1");
    $stmt = $this->db->prepare("DELETE from usuario WHERE id_usuario=?");
    $stmt->execute(array($orga->getId()));    
  }

  //asigna los pinchos indicados a un jurado profesional
  public function asignar(JuradoProfesional $jpro,$pinchos,Organizador $orga){
    foreach ($pinchos as $pincho) {
      $stmt = $this->db->prepare("INSERT INTO vota_pro VALUES(?,?,?,?)");
      $stmt->execute(array($jpro->getId(), $pincho->getId(),1,0));
    }
  }

  /*devuelve los votos de los jurados profesionales, de cada pincho en la ronda indicada*/
  public function votacionPro($ronda){

    $stmt = $this->db->prepare("SELECT *, SUM(votacion) as total FROM vota_pro WHERE ronda=?  GROUP BY FK_pincho_vota ORDER BY votacion ASC ");
    $stmt->execute(array($ronda));
    $list = [];
    foreach($stmt->fetchAll() as $info){
      $pincho = Pincho::find($info['FK_pincho_vota']);
      $pincho->setVotos($info['total']);
      $list[] = $pincho;
    }
    return $list;
  }
  
  //indicando el numero de finalistas, crea la segunda ronda con los de mayor numero de votos
  public function getFinalistas($numFinalistas){
    
		$stmt = $this->db->prepare("SELECT FK_pincho_vota, SUM(votacion) FROM vota_pro WHERE ronda=1 GROUP BY FK_pincho_vota DESC LIMIT ?");
		$stmt->execute(array($numFinalistas));
		$votos = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = $this->db->query("SELECT * FROM juradoProfesional");
		$jPros = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($votos as $voto){
			foreach($jPros as $jPro){
				$stmt = $this->db->prepare("INSERT INTO vota_pro VALUES(?,?,?,?)");
				$stmt->execute(array($jPro['id_usuario'],$voto['FK_pincho_vota'],2,0));
			}
		}
		
   }
   
   //comprueba si hay pinchos sin votar en la ronda indicada
   public function votosNulos($ronda){
	   $stmt = $this->db->query("SELECT * FROM vota_pro WHERE votacion = 0 AND ronda = $ronda");
	   $num = $stmt->fetchAll(PDO::FETCH_ASSOC);
	   if($num == null){
		   return 0;
	   } else{
	    return 1;
	   }
   }
   
   //devuelve la ronda actual
   public function getRonda(){
	  $stmt= $this->db->query("SELECT MAX(ronda) AS rondaActual FROM vota_pro");
	  $jProPinchos_db = $stmt->fetch(PDO::FETCH_ASSOC);
	  return $jProPinchos_db['rondaActual'];
   }
   
   //devuelve el numero de pinchos que los jurados profesionales tienen que votar
   public function numPinchos(){
	  $stmt= $this->db->query("SELECT COUNT(DISTINCT FK_pincho_vota ) AS numPinchos FROM vota_pro");
	  $jProPinchos_db = $stmt->fetch(PDO::FETCH_ASSOC);
	  return $jProPinchos_db['numPinchos'];
   }
  public function getPinchosPremios(){
    $stmt= $this->db->query("SELECT DISTINCT FK_pincho_vota AS pinchos FROM vota_pro WHERE ronda=2 AND votacion>0");
    $jProPinchos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pinchos = array();
    
      foreach ($jProPinchos_db as $jPop) {
        array_push($pinchos,$jPop['pinchos']);
      } 
  return $pinchos;
   }
}
