<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Historial extends CI_Controller {

   function __construct(){

      parent::__construct();

      $this->load->model('modelo','',TRUE);
      $this->load->model('user','',TRUE);
      $this->load->model('equipo','',TRUE);
      $this->load->model('Validate','',TRUE);
      $this->load->model('CuestionarioAdmin','',TRUE);
      $this->load->helper('url');
   }

   function index($id){

   	if($this->session->userdata('logged_in')){

         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
         	//obtenemos todos los datos de la tabla historial_result
		   	$data_historial = $this->CuestionarioAdmin->getHistorial($id);
		   	$datos = array();
		   	if($data_historial){

		   		foreach ($data_historial as $value) {
		   			$fase;
		   			$modelo;
		   			$proceso;
		   			//fase
		   			$data_fase = $this->CuestionarioAdmin->getFaseById($value->phase);
		   			foreach ($data_fase as $key => $aux) {
		   				$fase = $aux->name;	
		   			}
		   			//proceso
		   			$data_proceso = $this->CuestionarioAdmin->getProcesoById($value->process);
		   			foreach ($data_proceso as $key => $aux) {
		   				$proceso = $aux->name;	
		   			}
		   			//modelo
		   			$data_modelo = $this->CuestionarioAdmin->getModeloById($value->model);
		   			foreach ($data_modelo as $key => $aux) {
		   				$modelo = $aux->name;	
		   			}

		   			$claves = preg_split("[ ]", $value->f);
						
						
		   			$item = array(
		   				'id' =>$value->id,
		   				'model' =>$modelo,
		   				'process' =>$proceso,
		   				'phase' =>$fase,
		   				'nco' =>$value->nco,
		   				'ncr' =>$value->ncr,
		   				'fecha' =>$claves[0],
		   			);
		   			array_push($datos,$item);
		   		}
		   		$datos_vista['datos'] = $datos;
		   		$this->load->view('evaluacion/historial_page',$datos_vista);
		   	}else{
		   		$mensaje="<div class='alert alert-info fade in'>";
               $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
               $mensaje.="<strong>No hay historial de este equipo</strong>";
               $mensaje.="</div>";
               $this->session->set_flashdata('message', $mensaje);
		   		redirect('Equipos/', 'refresh');
		   	}

		   	
         }else{
         	redirect('Home', 'refresh');
         }
      }else{
      	redirect('Login', 'refresh');
      }

   	
   }
}
 ?>