<?php


require_once(__DIR__."/../model/Organizador.php");
require_once(__DIR__."/../model/OrganizadorMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

require_once(__DIR__."/../model/JuradoProfesional.php");
require_once(__DIR__."/../model/JuradoProfesionalMapper.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../model/Pincho.php");
require_once(__DIR__."/../model/PinchoMapper.php");

class OrganizadorController extends BaseController {
  
  /**
   * Reference to the PostMapper to interact
   * with the database
   * 
   * @var PostMapper
   */
  private $organizadorMapper;
  private $juradoProfesionalMapper;
  
  public function __construct() { 
    parent::__construct();
    
    $this->organizadorMapper = new OrganizadorMapper();

    $this->juradoProfesionalMapper = new JuradoProfesionalMapper();            
  }
  
  
  public function index() {
  
    // obtain the data from the database
    $organizador = $this->organizadorMapper->findAll();    
    
    // put the array containing Post object to the view
    $this->view->setVariable("organizador", $organizador);    
    
    // render the view (/view/posts/index.php)
    $this->view->render("organizador", "index");
  }
  
  public function asignar(){
    $juradosPro = $this->juradoProfesionalMapper->findAll();
    $this->view->setVariable("juradosProfesionales", $juradosPro);
    $this->view->render("organizador","asignar");
  }

  public function asignarJurado(){
    $jpopid = $_REQUEST["usuario"];
    $jpop = $this->juradoProfesionalMapper->findById($jpopid);
    $this->view->setVariable("jurado",$jpop);
    $pinchos = Pincho::getPinchos();
    $this->view->setVariable("pinchos", $pinchos);
    $this->view->render("organizador","asignarPinchos");

  }

  public function asignarPinchos(){
    $jpopid = $_REQUEST["usuario"];
    $jpop = $this->juradoProfesionalMapper->findById($jpopid);
    $this->view->setVariable("jurado",$jpop);
    $pinchos = $_REQUEST["selectedPinchos"];
    $pincha = array();
    for ($i=0; $i < count($pinchos) ; $i++) { 
        $pincha[$i] = Pincho::find($pinchos[$i]);
    }
    $this->view->setVariable("pinchos", $pincha);
    $this->view->render("organizador","asignados");
  }
}
