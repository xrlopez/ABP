<?php


require_once(__DIR__."/../model/Organizador.php");
require_once(__DIR__."/../model/OrganizadorMapper.php");

require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

require_once(__DIR__."/../model/JuradoProfesional.php");
require_once(__DIR__."/../model/JuradoProfesionalMapper.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../model/Pincho.php");

class OrganizadorController extends BaseController {
  
  private $organizadorMapper;
  private $juradoProfesionalMapper;
  private $concursoMapper;
  private $userMapper;
  private $pincho;
  
  public function __construct() { 
    parent::__construct();
    
    $this->organizadorMapper = new OrganizadorMapper();

    $this->juradoProfesionalMapper = new JuradoProfesionalMapper();

    $this->concursoMapper = new ConcursoMapper();
    
    $this->userMapper = new UserMapper(); 
    $this->pincho = new Pincho();
  }
  
  
  /*redirecciona a la página principal del sitio web*/
  public function index() {
  
    $organizador = $this->organizadorMapper->findAll(); 
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense"); 
    $this->view->setVariable("organizador", $organizador);
    $this->view->setVariable("concursos", $concursos);  
    $this->view->render("concursos", "index");
  }
  
  /*redirecciona a la vista para seleccionar el jurado profesional
  al que se le va asignar los pinchos*/
  public function asignar(){
    $juradosPro = $this->juradoProfesionalMapper->findAll();
    $this->view->setVariable("juradosProfesionales", $juradosPro);
    $this->view->render("organizador","asignar");
  }

  /*Recupera los pinchos disponibles para asignar a un jurado profesional*/
  public function asignarJurado(){
    $jpopid = $_REQUEST["usuario"];
    $jpop = $this->juradoProfesionalMapper->findById($jpopid);
    $this->view->setVariable("jurado",$jpop);
    $pinchos_no = $this->pincho->pinchosNoAsignados($jpopid);
    $numAsigMax = $this->juradoProfesionalMapper->numAsigMax();
    $pinchos=array();
    if($pinchos_no!=null){  
      foreach($pinchos_no as $pincho) {
        $numAsig = $this->juradoProfesionalMapper->getNumAsig($pincho->getId());
        if($numAsig < $numAsigMax){
            array_push($pinchos, $pincho);
        }
      }
    }
    $pinchosAsignados = $this->pincho->pinchosAsignados($jpopid);
    $this->view->setVariable("pinchosAsignados",$pinchosAsignados);
    $this->view->setVariable("pinchos", $pinchos);
    $this->view->render("organizador","asignarPinchos");

  }

   /*Recupera los pinchos seleccionados para asignar a un jurado profesional
    y se lo asigna*/
  public function asignarPinchos(){
    $jpopid = $_REQUEST["usuario"];
    $jpop = $this->juradoProfesionalMapper->findById($jpopid);
    $currentuser = $this->view->getVariable("currentusername");
    $organizador = $this->organizadorMapper->findById($currentuser);
    $this->view->setVariable("jurado",$jpop);
    $pincha=array();
    if(isset($_REQUEST["selectedPinchos"])){
      $pinchos = $_REQUEST["selectedPinchos"];
      for ($i=0; $i < count($pinchos) ; $i++) { 
          $pincha[$i] = Pincho::find($pinchos[$i]);
      }
      $this->organizadorMapper->asignar($jpop,$pincha,$organizador);
    }
    $this->view->setVariable("pinchos", $pincha);
    $this->view->render("organizador","asignados");
  }


  /*redirecciona a la vista del perfil del organizador*/
public function perfil(){
    $currentuser = $this->view->getVariable("currentusername");
    $organizador = $this->organizadorMapper->findById($currentuser);
    $this->view->setVariable("organizador", $organizador);
    $this->view->render("organizador", "perfil");
  }
  
  /*redirecciona al formulario de modificacion de los datos de un organizador*/
  public function modificar(){
    $currentuser = $this->view->getVariable("currentusername");
    $organizador = $this->organizadorMapper->findById($currentuser);
    $this->view->setVariable("organizador", $organizador);
    $this->view->render("organizador", "modificar");
  }

  /*Llama a delete() de OrganizadorMapper.php, donde se elimina un organizador indicado,
  se destruye la sesion de dicho organizador y se redirecciona a la página principal del sitio web.*/
  public function eliminar(){
    $currentuser = $this->view->getVariable("currentusername");
    $organizador = $this->organizadorMapper->findById($currentuser);
    
        
    // Does the post exist?
    if ($organizador == NULL) {
      throw new Exception("No existe el usuario ".$currentuser);
    }
    
    $this->organizadorMapper->delete($organizador);
    
    $this->view->setFlash(sprintf("Usuario \"%s\" eliminado.",$organizador ->getId()));
    session_unset();
    session_destroy();
    $this->view->redirect("concurso", "index");
  }

  /*Recupera los datos del formulario de modificacion de un organizador,
  comprueba que son correctos y llama a update() de OrganizadorMapper.php
  donde se realiza la actualizacion de los datos.*/
  public function update(){
    $jpopid = $_REQUEST["usuario"];
    $jpop = $this->organizadorMapper->findById($jpopid);
    $errors = array();
    if($this->userMapper->isValidUser($_POST["usuario"],$_POST["passActual"])){

        if (isset($_POST["submit"])) {  
        
          $jpop->setNombre($_POST["nombre"]);
          $jpop->setEmail($_POST["correo"]);
          $jpop->setDescripcionOrga($_POST["descripcion"]);

          if(!(strlen(trim($_POST["passNew"])) == 0)){
            if ($_POST["passNew"]==$_POST["passNueva"]) {
              $jpop->setPassword($_POST["passNueva"]);
            }
            else{
              $errors["pass"] = "Las contraseñas tienen que ser iguales";
              $this->view->setVariable("errors", $errors);
              $this->view->setVariable("organizador", $jpop);
              $this->view->render("organizador", "modificar"); 
              return false;
            }
          }
          
            try{
              $this->organizadorMapper->update($jpop);
              $this->view->setFlash(sprintf("Usuario \"%s\" modificado correctamente.",$jpop ->getNombre()));
              $this->view->redirect("organizador", "index"); 
            }catch(ValidationException $ex) {
            $errors = $ex->getErrors();
            $this->view->setVariable("errors", $errors);
          } 
        }

    }
    else{
        $errors["passActual"] = "Contraseña incorrecta";
        $this->view->setVariable("errors", $errors);
      }
        $this->view->setVariable("organizador", $jpop);
        $this->view->render("organizador", "modificar"); 
  }

  /*Redirecciona a la vista de validar pinchos*/
   public function validar(){
    $pinchos = Pincho::noValidados();
    $this->view->setVariable("pinchos", $pinchos);
    $this->view->render("organizador", "validarPincho");
  }

  //Redirecciona a la vista de los premios
  public function premios(){
    $this->view->render("organizador", "gestionarPremios");
  }

  
  /*Redirecciona a la vista de la gestion de los jurados profesionales*/
  public function gestionJurado(){
    $ronda = $this->organizadorMapper->getRonda();
    $this->view->setVariable("ronda",$ronda);
    $this->view->render("organizador", "gestionarJuradoProfesional");
  }

  /*recuper las votaciones de los jurados profesionales*/
  public function votacionPro(){
    $ronda = $_GET['ronda'];
    $pinchos = $this->organizadorMapper->votacionPro($ronda);
    $this->view->setVariable("pinchos", $pinchos);
    $this->view->setVariable("ronda", $ronda);
    $this->view->render("organizador", "votosPro");
  }
  
  /*-Si esta en la ronda uno, pide el numero de finalistas.
    -Si esta en la ronda dos, lista los pinchos finalistas.*/
  public function finalistas(){
	 $currentuser = $this->view->getVariable("currentusername");
	 $organizador = $this->organizadorMapper->findById($currentuser);
   $ronda = $this->organizadorMapper->getRonda();
   $pinchos = array();
   if($ronda==2){
     $pinchosId = $this->pincho->pinchosSegunda();
    foreach($pinchosId as $pinchoId) {
      array_push($pinchos,$this->pincho->find($pinchoId));
      
    }
     $this->view->setVariable("organizador", $organizador);
     $this->view->setVariable("pinchos", $pinchos);
     $this->view->render("organizador", "pinchosFinalistas"); 
   }else{
     $this->view->setVariable("organizador", $organizador);
     $this->view->render("organizador", "finalistas"); 
   }
  }
  
  /*En caso de que se haya terminado la ronda uno y que el numero de finalistas indicado sea valido,
  crea la segunda ronda.*/
  public function guardarFinalistas(){
	 $currentuser = $this->view->getVariable("currentusername");
	 $organizador = $this->organizadorMapper->findById($currentuser);
	 $pinchos = $this->organizadorMapper->numPinchos();
	 $numFinalistas = $_POST['quantity'];
	 if($numFinalistas <= $pinchos){
		 $votosNulos = $this->organizadorMapper->votosNulos(1);
		 $ronda = $this->organizadorMapper->getRonda();
     $numAsigMax = $this->juradoProfesionalMapper->numAsigMax();
     $pinchosSin =$this->pincho->all();
     $pin=array();
     foreach($pinchosSin as $pinchosSin) {
      $numAsig = $this->juradoProfesionalMapper->getNumAsig($pinchosSin->getId());
      if($numAsig < $numAsigMax){
          array_push($pin, $pinchosSin);
      }
    }
    if($pin==NULL){
       if($votosNulos == 0 && $ronda == 1){
         $finalistas = $this->organizadorMapper->getFinalistas($numFinalistas);
         $this->view->redirect("organizador", "index");
       } else{
        $this->view->setFlash(sprintf("No todos los pinchos estan votados"));
        $this->view->redirect("organizador", "finalistas");
       }
    }else{
        $this->view->setFlash(sprintf("Hay pinchos que no tienen el número de jurados totales, todos deben tener ".$numAsigMax." jurados."));
     $this->view->redirect("organizador", "finalistas");

    }
	 } else{
     		$this->view->setFlash(sprintf("Hay menos pinchos que finalistas quieres asignar"));
		 $this->view->redirect("organizador", "finalistas");
	 }
  }
  
}
