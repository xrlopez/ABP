<?php


require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/EstablecimientoMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class EstablecimientoController extends BaseController {
  
  /**
   * Reference to the PostMapper to interact
   * with the database
   * 
   * @var PostMapper
   */
  private $juradoPopularMapper;  
  
  public function __construct() { 
    parent::__construct();
    
    $this->establecimientoMapper = new EstablecimientoMapper();          
  }
  
  
  public function index() {
  
    // obtain the data from the database
    $establecimiento = $this->establecimientoMapper->findAll();    
    
    // put the array containing Post object to the view
    $this->view->setVariable("establecimiento", $establecimiento);    
    
    // render the view (/view/posts/index.php)
    $this->view->render("establecimiento", "index");
  }
  
}
