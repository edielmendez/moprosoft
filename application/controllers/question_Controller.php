<?php
//Controlador Proceso
defined('BASEPATH') OR exit('No direct script access allowed');
class question_Controller extends CI_Controller {

	function __construct()
   {
      parent::__construct();
      $this->load->model('Question','',TRUE);
			$this->load->helper('url');
   }

   public function index(){
   	if($this->session->userdata('logged_in')){
				$this->load->view('questions/index');
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

	 public function edith(){
		 if($this->session->userdata('logged_in')){
			 $this->load->view('questions/edith');
		 }else{
			 //si no hay session se redirecciona la vista de login
				 redirect('login', 'refresh');
		 }
	 }

	 public function save(){
		 if($this->session->userdata('logged_in')){



		 }else{
			 //si no hay session se redirecciona la vista de login
				 redirect('login', 'refresh');
		 }
	 }

}
?>
