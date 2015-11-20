<?php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Pincho.php");

class PinchoMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
  
  public function getNumPinchos(){
    $query = $this->db->query('SELECT count(*) as num FROM pincho');
    $num_pinchos = $query->fetch(PDO::FETCH_ASSOC);
    return $num_pinchos;
  }
  
  public function getPinchos($inicio = 0, $limite = 5){
    $list = [];
    $req = $this->db->query('SELECT * FROM pincho limit '.$inicio.', '.$limite.'');
    foreach($req->fetchAll() as $pincho) {
      $list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho['id_pincho']);
    }
    return $list;
  }
  
  
  public function all() {
    $list = [];
    $req = $this->db->query('SELECT * FROM pincho');
    
    // we create a list of Post objects from the database results
    foreach($req->fetchAll() as $pincho) {
      $list[] = new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho['id_pincho']);
    }
    return $list;
  }
  
  public function find($id) {
    // we make sure $id is an integer
    $id = intval($id);
    $req = $this->db->prepare('SELECT * FROM pincho WHERE id_pincho = '.$id);
    $req->execute(array());
    $pincho = $req->fetch();
    return new Pincho($pincho['nombre'], $pincho['celiaco'], $pincho['descripcion'], $pincho['num_votos'], $pincho['id_pincho']);
  }
  
}
?>
