<?php


require_once(__DIR__."/../model/Organizador.php");
require_once(__DIR__."/../model/OrganizadorMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class OrganizadorController extends BaseController {
  
  /**
   * Reference to the PostMapper to interact
   * with the database
   * 
   * @var PostMapper
   */
  private $organizadorMapper;  
  
  public function __construct() { 
    parent::__construct();
    
    $this->organizadorMapper = new OrganizadorMapper();          
  }
  
  
  public function index() {
  
    // obtain the data from the database
    $organizador = $this->organizadorMapper->findAll();    
    
    // put the array containing Post object to the view
    $this->view->setVariable("organizador", $organizador);    
    
    // render the view (/view/posts/index.php)
    $this->view->render("organizador", "index");
  }
  
}
