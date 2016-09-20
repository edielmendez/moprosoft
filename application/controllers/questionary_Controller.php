<?php
//Controlador Proceso
defined('BASEPATH') OR exit('No direct script access allowed');
class questionary_Controller extends CI_Controller {

	function __construct()
   {
      parent::__construct();
      $this->load->model('Process','',TRUE);
			$this->load->helper('url');
   }

   public function index(){
   	if($this->session->userdata('logged_in')){
   		$this->load->view('questionnaires/index');
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

	 public function edith(){
		 if($this->session->userdata('logged_in')){
			 $this->load->view('questionnaires/edith');
		 }else{
			 //si no hay session se redirecciona la vista de login
				 redirect('login', 'refresh');
		 }
	 }

}
?>
