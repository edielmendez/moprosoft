<?php
//Controlador Proceso
defined('BASEPATH') OR exit('No direct script access allowed');
class process_Controller extends CI_Controller {

	function __construct()
   {
      parent::__construct();
      $this->load->model('Process','',TRUE);
			$this->load->helper('url');
   }

   public function index(){
   	if($this->session->userdata('logged_in')){
   		$this->load->view('processes/index');
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

	 public function edit(){
		 if($this->session->userdata('logged_in')){
			 $this->load->view('processes/edit');
		 }else{
			 //si no hay session se redirecciona la vista de login
				 redirect('login', 'refresh');
		 }
	 }

}
?>
