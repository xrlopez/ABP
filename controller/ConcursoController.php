<?php


require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");
require_once(__DIR__."/../model/Pincho.php");
require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/EstablecimientoMapper.php");
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class ConcursoController extends BaseController {
  private $concursoMapper;  
  private $establecimientoMapper;  
  private $pincho;  
  
  public function __construct() {

    parent::__construct();
    $this->concursoMapper = new ConcursoMapper();  
    $this->pincho = new Pincho();
    $this->establecimientoMapper = new EstablecimientoMapper();  
            
  }
  
  /*redirecciona a la página principal del sitio web*/
  public function index() {
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");    
    $this->view->setVariable("concursos", $concursos);    
    $this->view->render("concursos", "index");

  }

  /*recupera del formulario de busqueda, el valor a buscar y llama a findConcurso() de
  ConcursoMapper.php, que devuelve el resultado de la busqueda*/
  public function buscarInfo(){
    $busqueda = $_POST['busqueda'];
    $result = $this->concursoMapper->buscarInfo($busqueda);
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");    
    $this->view->setVariable("concursos", $concursos);  
    $this->view->setVariable("informacion",$result);
    $this->view->render("concursos","info");
  }

  public function folleto(){
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");    
    $establecimientos = $this->establecimientoMapper->findAllValidados();
    $pinchos = $this->pincho->all();
    $this->view->setVariable("concursos", $concursos); 
    $this->view->setVariable("establecimientos",$establecimientos);
    $this->view->setVariable("pinchos",$pinchos);
    $this->view->render("concursos","folleto");
  }

  public function generarFolleto(){
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");    
    $establecimientos = $this->establecimientoMapper->findAllValidados();
    $pinchos = $this->pincho->all();

    $pdf=new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',30);
    $pdf->SetTextColor(85, 53, 20); 
    $pos_y=10;
    $pdf->Cell(0,24,$concursos->getNombre(),0,0,"L");
      $pdf->Ln();

    $pdf->SetFont('Arial','',16);
    $pdf->SetTextColor(0, 0, 0); 
    $pdf->MultiCell(0,6,$concursos->getDescripcionConcurso(),0,"L");
    $pdf->SetTextColor(85, 53, 20); 
    $pdf->SetFont('Arial','B',13);
    $pdf->Cell(0,24,"Establecimientos participantes",0,0,"L");
    foreach ($establecimientos as $establecimiento){
      $pdf->Ln();
      $pdf->SetFont('Arial','B',13);
      $pdf->SetTextColor(85, 53, 20); 
      $pdf->SetFillColor(182, 145, 107);
      $pdf->Cell(0,10,utf8_decode($establecimiento->getNombre()),1,0,"C","false");
      $pdf->Ln();
      $pdf->SetFont('Arial','I',13);
      $pdf->SetTextColor(0, 0, 0); 
      $pdf->Cell(0,10,utf8_decode($establecimiento->getDescripcion()),0,0,"L");
      $pdf->Ln();
      $pdf->Cell(0,10,utf8_decode($establecimiento->getLocalizacion()),0,0,"L");
      $pdf->Ln();
      $pdf->Cell(0,10,utf8_decode("Pincho:"),0,0,"L"); 
      foreach ($pinchos as $pincho){
        if(($pincho->getEstablecimiento())==($establecimiento->getId())){
          $pdf->Ln();
          $pdf->Cell(5);
          $pdf->Cell(0,10,utf8_decode($pincho->getNombre()),0,0,"L");
          $pdf->Ln();
          $pdf->Cell(5);
          $pdf->Cell(0,10,utf8_decode($pincho->getDescripcion()),0,0,"L");
          $pdf->Ln();
          $pdf->Cell(5);
          if($pincho->isCeliaco()) {
            $pdf->Cell(0,10,utf8_decode("Apto para celiaco"),0,0,"L"); 
          }else{
            $pdf->Cell(0,10,utf8_decode("No apto para celiaco"),0,0,"L"); 
          } 
        }
      }
      $pdf->Ln(5);
    }
    $pdf->Output("folleto.pdf","D");
  }
  
}
