<?php


require_once(__DIR__."/../model/JuradoProfesional.php");
require_once(__DIR__."/../model/JuradoProfesionalMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class JuradoProfesionalController extends BaseController {
  
  /**
   * Reference to the PostMapper to interact
   * with the database
   * 
   * @var PostMapper
   */
  private $juradoProfesionalMapper;  
  
  public function __construct() { 
    parent::__construct();
    
    $this->juradoProfesionalMapper = new JuradoProfesionalMapper();          
  }
  
  
  public function index() {
  
    // obtain the data from the database
    $juradoProfesional = $this->juradoProfesionalMapper->findAll();    
    
    // put the array containing Post object to the view
    $this->view->setVariable("juradoProfesional", $juradoProfesional);    
    
    // render the view (/view/posts/index.php)
    $this->view->render("juradoProfesional", "index");
  }
  
  public function perfil(){
    $currentuser = $this->view->getVariable("currentusername");
    $juradoProfesional = $this->juradoProfesionalMapper->findById($currentuser);
    $this->view->setVariable("juradoPro", $juradoProfesional);
    $this->view->render("juradoProfesional", "perfil");
  }

  public function modificar(){
    $currentuser = $this->view->getVariable("currentusername");
    $juradoProfesional = $this->juradoProfesionalMapper->findById($currentuser);
    $this->view->setVariable("juradoPro", $juradoProfesional);
    $this->view->render("juradoProfesional", "modificar");
  }
  
}
