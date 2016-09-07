<?php 

defined('BASEPATH') OR exit('No direct script access allowed');


class Calendario extends CI_Controller {
	function __construct(){

      parent::__construct();

      $this->load->model('modelo','',TRUE);
      $this->load->model('user','',TRUE);
      $this->load->model('equipo','',TRUE);
       $this->load->helper('url');
   }

   public function modificar($id){
   	if($this->session->userdata('logged_in')){
   		$data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
         	$result = $this->equipo->getEquipoById($id);
         	if($result){
         		$equipo;
	            foreach ($result as $row) {
	               $equipo = array(
	                 'id' => $row->id,
	                 'name' => $row->name
	               );
	            }
	            $datos_vista['equipo'] = $equipo;
	            $this->load->view('evaluacion/modificar_calendario',$datos_vista);

         	}else{
         		redirect('Equipos', 'refresh');
         	}
            
         	
         	//$this->load->view('evaluacion/index',$datos_vista);
         }else{
         	redirect('Home', 'refresh');
         }
   	}else{
   		redirect('Home', 'refresh');
   	}
   }
}
 ?>