<?php 

defined('BASEPATH') OR exit('No direct script access allowed');


class Estudiantes extends CI_Controller {
	function __construct()
   {

      parent::__construct();

      $this->load->model('modelo','',TRUE);
   }

   public function nuevo(){
   	if($this->session->userdata('logged_in')){
   		
   		$this->load->view('nuevo_estudiante');
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }
}
?>