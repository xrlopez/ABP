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

  //devuelve un codigo especifico
  public function findConcurso($id_concurso) {   
    $stmt = $this->db->prepare("SELECT * FROM concurso WHERE id_concurso=?");  
    $stmt->execute(array($id_concurso)); 
    $concurso_db = $stmt->fetch(PDO::FETCH_ASSOC);    
    if($concurso_db!=NULL) {
      return new Concurso($concurso_db["id_concurso"], $concurso_db["nombre"], $concurso_db["localizacion"], $concurso_db["descripcion"], $concurso_db["FK_organizador_conc"]);
    }
  }
  
  //devuelve el resultado del formulario de busqueda
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
