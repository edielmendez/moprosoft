<?php
//Controlador Proceso
defined('BASEPATH') OR exit('No direct script access allowed');
class question_Controller extends CI_Controller {

	function __construct()
   {
      parent::__construct();
      $this->load->model('Process','',TRUE);
			$this->load->helper('url');
			$this->load->library('grocery_CRUD');
   }

   public function index(){
   	if($this->session->userdata('logged_in')){
				$this->load->view('questions/index');
			//Prueba de com_crud

			/*$crud = new grocery_CRUD();

			$crud->set_table('question');
			$crud->set_subject('Pregunta');
			$crud->unset_columns('questionDescription');
			$crud->callback_column('buyPrice',array($this,'valueToEuro'));

			$output = $crud->render();
   		$this->load->view('questions/index',$output);*/
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

}
?>
