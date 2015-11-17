<?php


require_once(__DIR__."/../model/JuradoPopular.php");
require_once(__DIR__."/../model/JuradoPopularMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class JuradoPopularController extends BaseController {
  
  /**
   * Reference to the PostMapper to interact
   * with the database
   * 
   * @var PostMapper
   */
  private $juradoPopularMapper;  
  
  public function __construct() { 
    parent::__construct();
    
    $this->juradoPopularMapper = new JuradoPopularMapper();          
  }
  
  
  public function index() {
  
    // obtain the data from the database
    $juradoPopular = $this->juradoPopularMapper->findAll();    
    
    // put the array containing Post object to the view
    $this->view->setVariable("juradoPopular", $juradoPopular);    
    
    // render the view (/view/posts/index.php)
    $this->view->render("juradoPopular", "index");
  }
  
}
