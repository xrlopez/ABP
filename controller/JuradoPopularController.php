<?php


require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");
require_once(__DIR__."/../model/Codigo.php");
require_once(__DIR__."/../model/CodigoMapper.php");
require_once(__DIR__."/../model/JuradoPopular.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/JuradoPopularMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");
require_once(__DIR__."/../controller/UsersController.php");

class JuradoPopularController extends BaseController {
  
 
  private $juradoPopularMapper;
  private $concursoMapper; 
  private $userMapper;  
  private $codigoMapper;  
  
  public function __construct() { 
    parent::__construct();
    
    $this->juradoPopularMapper = new JuradoPopularMapper();  
    $this->concursoMapper = new ConcursoMapper();   
    $this->userMapper = new UserMapper(); 
    $this->codigoMapper = new CodigoMapper();
  }
  
  
  public function index() {
  
    $juradoPopular = $this->juradoPopularMapper->findAll(); 
    $concursos = $this->concursoMapper->findConcurso();   
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
    
    $this->view->setFlash(sprintf("Usuario \"%s\" eliminado.",$juradoPopular ->getId()));
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
              $errors["pass"] = "Las contraseñas tienen que ser iguales";
              $this->view->setVariable("errors", $errors);
              $this->view->setVariable("juradoPop", $jpop);
              $this->view->render("juradoPopular", "modificar"); 
              return false;
            }
          }
          
            try{
              $this->juradoPopularMapper->update($jpop);
              $this->view->setFlash(sprintf("Usuario \"%s\" modificado correctamente.",$jpop ->getNombre()));
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
      }
        $this->view->setVariable("juradoPop", $jpop);
        $this->view->render("juradoPopular", "modificar"); 
  }

  public function introCodigos(){
    $currentuser = $this->view->getVariable("currentusername");
    $juradoPopular = $this->juradoPopularMapper->findById($currentuser);
    $this->view->setVariable("juradoPop", $juradoPopular);
    $this->view->render("juradoPopular", "introCodigos");
  }

  public function addCodigos(){
    $jpopid = $_POST["usuario"];
    $jpop = $this->juradoPopularMapper->findById($jpopid);
    $this->view->setVariable("juradoPop",$jpop);
    $errors = array();
    if ($jpop == NULL) {
      throw new Exception("No existe el usuario ".$jpopid);
    }
    $pincho1 = $_POST["pincho1"];
    $pincho2 = $_POST["pincho2"];
    $pincho3 = $_POST["pincho3"];

    if(($pincho1!=$pincho2) && ($pincho1!=$pincho3) && ($pincho2!=$pincho3)){
      $idPincho1 = $this->codigoMapper->findById($pincho1);
      $idPincho2 = $this->codigoMapper->findById($pincho2);
      $idPincho3 = $this->codigoMapper->findById($pincho3);
      if(($idPincho1!=NULL) && ($idPincho1->getUsado()==0)){
        if(($idPincho2!=NULL) && ($idPincho2->getUsado()==0)){
          if(($idPincho3!=NULL) && ($idPincho3->getUsado()==0)){
              
            $idPincho1->setUsado(1);
            $idPincho2->setUsado(1);
            $idPincho3->setUsado(1);
             try{
              $this->codigoMapper->update($idPincho1);
              $this->codigoMapper->update($idPincho2);
              $this->codigoMapper->update($idPincho3);
                $this->view->setVariable("codigo1",$idPincho1);
                $this->view->setVariable("codigo2",$idPincho2);
                $this->view->setVariable("codigo3",$idPincho3);
                $this->view->setVariable("jPop",$jpop);
              $this->view->setFlash("Codigos introducidos correctamente");
              $this->view->render("juradoPopular", "votaPopular"); 
            }catch(ValidationException $ex) {
              $errors = $ex->getErrors();
              $this->view->setVariable("errors", $errors);
            } 
          }else{
            $errors["pincho3"] = "El pincho 3 o no existe o esta usado";
            $this->view->setVariable("errors", $errors);
            $this->view->render("juradoPopular", "introCodigos");
          }

        }else{
          $errors["pincho2"] = "El pincho 2 o no existe o esta usado";
          $this->view->setVariable("errors", $errors);
          $this->view->render("juradoPopular", "introCodigos");
        }

      }else{
        $errors["pincho1"] = "El pincho 1 o no existe o esta usado";
        $this->view->setVariable("errors", $errors);
        $this->view->render("juradoPopular", "introCodigos");
      }
    }else{
        $errors["pincho"] = "Los pinchos tienen que ser distintos";
        $this->view->setVariable("errors", $errors);
        $this->view->render("juradoPopular", "introCodigos"); 
    }

  }

  public function votar(){

    $jpopid = $_POST["usuario"];
    $jpop = $this->juradoPopularMapper->findById($jpopid);
    $errors = array();
    if ($jpop == NULL) {
      throw new Exception("No existe el usuario ".$jpopid);
    }
    $idpincho = $_POST["pincho"];
    $pincho = $this->codigoMapper->findById($idpincho);

    $this->codigoMapper->votar($pincho,$jpop);
    
    $this->view->setFlash(sprintf("Voto a \"%s\" sumado.",$idpincho));

    $this->view->redirect("concurso", "index");

  }

    
}
