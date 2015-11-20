<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/Organizador.php");
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
  
  public function update(Concurso $concurso) {
    $stmt = $this->db->prepare("UPDATE concurso set nombre=?, localizacion=?, descripcion=? where id_usuario=?");
    $stmt->execute(array($concurso->getNombre(), $concurso->getLocalizacion(), $concurso->getDescripcion(), $concurso->getId()));    
  }

  
}
