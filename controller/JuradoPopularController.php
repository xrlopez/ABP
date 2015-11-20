<?php


require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");
require_once(__DIR__."/../model/JuradoPopular.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/JuradoPopularMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");
require_once(__DIR__."/../controller/UsersController.php");

class JuradoPopularController extends BaseController {
  
  /**
   * Reference to the PostMapper to interact
   * with the database
   * 
   * @var PostMapper
   */
  private $juradoPopularMapper;
  private $concursoMapper; 
  private $userMapper;  
  
  public function __construct() { 
    parent::__construct();
    
    $this->juradoPopularMapper = new JuradoPopularMapper();  
    $this->concursoMapper = new ConcursoMapper();   
    $this->userMapper = new UserMapper(); 
  }
  
  
  public function index() {
  
    // obtain the data from the database
    $juradoPopular = $this->juradoPopularMapper->findAll(); 
    $concursos = $this->concursoMapper->findConcurso();   
    
    // put the array containing Post object to the view
    $this->view->setVariable("juradoPopular", $juradoPopular);
    $this->view->setVariable("concursos", $concursos);    
    
    $this->view->render("concursos", "index");
  }

  public function perfil(){
    $currentuser = $this->view->getVariable("currentusername");
    $juradoPopular = $this->juradoPopularMapper->findById($currentuser);
    $this->view->setVariable("juradoPop", $juradoPopular);
    $this->view->render("juradoPopular", "perfil");
  }

  public function modificar(){
    $currentuser = $this->view->getVariable("currentusername");
    $juradoPopular = $this->juradoPopularMapper->findById($currentuser);
    $this->view->setVariable("juradoPop", $juradoPopular);
    $this->view->render("juradoPopular", "modificar");
  }
  
  public function eliminar(){
    $currentuser = $this->view->getVariable("currentusername");
    $juradoPopular = $this->juradoPopularMapper->findById($currentuser);
    
        
    // Does the post exist?
    if ($juradoPopular == NULL) {
      throw new Exception("No existe el usuario ".$currentuser);
    }
    
    // Delete the Jurado Popular object from the database
    $this->juradoPopularMapper->delete($juradoPopular);
    
    $this->view->setFlash(sprintf(i18n("Usuario \"%s\" eliminado."),$juradoPopular ->getId()));
    session_unset();
    session_destroy();
    $this->view->redirect("concurso", "index");
  }

  public function update(){
    $jpopid = $_REQUEST["usuario"];
    $jpop = $this->juradoPopularMapper->findById($jpopid);
    $errors = array();
    if($this->userMapper->isValidUser($_POST["usuario"],$_POST["passActual"])){

        if (isset($_POST["submit"])) {  
        
          $jpop->setNombre($_POST["nombre"]);
          $jpop->setEmail($_POST["correo"]);
          $jpop->setResidencia($_POST["residencia"]);

          if(!(strlen(trim($_POST["passNew"])) == 0)){
            if ($_POST["passNew"]==$_POST["passNueva"]) {
              $jpop->setPassword($_POST["passNueva"]);
            }
            else{
              $errors["passActual"] = "<span>La contraseña es obligatoria</span>";
              $this->view->setVariable("errors", $errors);
              $this->view->redirect("juradoPopular", "modificar"); 
            }
          }
          
            try{
              $this->juradoPopularMapper->update($jpop);
              $this->view->setFlash(sprintf(i18n("Usuario \"%s\" modificado correctamente."),$jpop ->getNombre()));
              $this->view->redirect("juradoPopular", "index"); 
            }catch(ValidationException $ex) {
            $errors = $ex->getErrors();
            $this->view->setVariable("errors", $errors);
          } 
        }

    }
    else{
        $errors["passActual"] = "<span>La contraseña es obligatoria</span>";
        $this->view->setVariable("errors", $errors);
        $this->view->redirect("juradoPopular", "modificar"); 
      }
    $this->view->redirect("juradoPopular", "index"); 
  }
  
}
