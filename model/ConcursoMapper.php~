<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/Organizador.php");
require_once(__DIR__."/../model/Pincho.php");
require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/EstablecimientoMapper.php");
require_once(__DIR__."/../model/OrganizadorMapper.php");

class ConcursoMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }

  
  public function findConcurso() {   
    $stmt = $this->db->query("SELECT * FROM concurso, organizador WHERE organizador.id_usuario = concurso.FK_organizador_conc");    
    $concurso_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $descripcion = array();
    
    foreach ($concurso_db as $concur) {
      $orga = new Organizador($concur["id_usuario"]);
      array_push($descripcion, new Concurso($concur["id_concurso"], $concur["nombre"], $concur["localizacion"], $concur["descripcion"], $orga));
    }   

    return $descripcion;
  }

  public function findConcursoUn(){
    $concursos = $this->findConcurso();
    foreach ($concursos as $concurso):
        return $concurso;
    endforeach; 
  }
  
  public function buscarInfo($busqueda){
    
    $stmt = $this->db->prepare("SELECT * FROM establecimiento, usuario WHERE (usuario.nombre LIKE ? OR establecimiento.descripcion LIKE ?) AND establecimiento.id_usuario=usuario.id_usuario");
    $stmt->execute(array("%$busqueda%","%$busqueda%"));  
    $estas = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $bus = array();
    
    foreach ($estas as $esta) {
      array_push($bus, new Establecimiento($esta["id_usuario"], $esta["nombre"], $esta["password"], $esta["email"], $esta["localizacion"], $esta["descripcion"], $esta["tipo"]));
    }    


    $stmt2 = $this->db->prepare("SELECT * FROM pincho WHERE (pincho.nombre LIKE ? OR pincho.descripcion LIKE ?)");
    $stmt2->execute(array("%$busqueda%","%$busqueda%"));  
    $pinchos = $stmt2->fetchAll(PDO::FETCH_ASSOC);   
    
    array_push($bus, "cambiar");
    foreach ($pinchos as $pincho) {
      array_push($bus, new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho["FK_establecimiento_pinc"], $pincho['id_pincho']));
    }

    return $bus;
  }

  
}
