<?php


require_once(__DIR__."/../model/JuradoProfesional.php");
require_once(__DIR__."/../model/JuradoProfesionalMapper.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");
require_once(__DIR__."/../controller/UsersController.php");

class JuradoProfesionalController extends BaseController {
  
  /**
   * Reference to the PostMapper to interact
   * with the database
   * 
   * @var PostMapper
   */
  private $juradoProfesionalMapper;  
  private $userMapper;
  private $concursoMapper;
  
  public function __construct() { 
    parent::__construct();
    
    $this->juradoProfesionalMapper = new JuradoProfesionalMapper();
    $this->concursoMapper = new ConcursoMapper();   
    $this->userMapper = new UserMapper(); 
  }
  
  
  public function index() {
  
    // obtain the data from the database
    $juradoProfesional = $this->juradoProfesionalMapper->findAll();
	   $concursos = $this->concursoMapper->findConcurso();     
    
    // put the array containing Post object to the view
    $this->view->setVariable("juradoProfesional", $juradoProfesional);    
    $this->view->setVariable("concursos", $concursos); 
	
    // render the view (/view/posts/index.php)
    $this->view->render("concursos", "index");
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
	
  public function update(){
    $jproid = $_REQUEST["usuario"];
    $jpro = $this->juradoProfesionalMapper->findById($jproid);

    $errors = array();
    if($this->userMapper->isValidUser($_POST["usuario"],$_POST["passActual"])){
        if (isset($_POST["submit"])) {  
        
          $jpro->setNombre($_POST["nombre"]);
          $jpro->setEmail($_POST["correo"]);
          $jpro->setProfesion($_POST["profesion"]);

          if(!(strlen(trim($_POST["passNew"])) == 0)){
            if ($_POST["passNew"]==$_POST["passNueva"]) {
              $jpro->setPassword($_POST["passNueva"]);
            }
            else{
              $errors["passActual"] = "<span>La contraseña es obligatoria</span>";
              $this->view->setVariable("errors", $errors);
              $this->view->redirect("juradoProfesional", "modificar"); 
            }
          }
          
            try{
              $this->juradoProfesionalMapper->update($jpro);
              $this->view->setFlash(sprintf("Usuario \"%s\" modificado correctamente.",$jpro ->getNombre()));
              $this->view->redirect("juradoProfesional", "index"); 
            }catch(ValidationException $ex) {
            $errors = $ex->getErrors();
            $this->view->setVariable("errors", $errors);
          } 
        }

    }
    else{
        $errors["passActual"] = "<span>La contraseña es obligatoria</span>";
        $this->view->setVariable("errors", $errors);
        $this->view->redirect("juradoProfesional", "modificar"); 
      }
    $this->view->redirect("juradoProfesional", "index"); 
  }
}
