<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Modelos extends CI_Controller {
	function __construct()
   {

      parent::__construct();

      $this->load->model('modelo','',TRUE);
			 $this->load->helper('url');
   }

   public function nuevo(){
   	if($this->session->userdata('logged_in')){

   		$this->load->view('nuevo_modelo');
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

	 //funcion para cargar la informacion de un modelo seleccionado por el usuario
	 public function abrir_modelo(){
   	if($this->session->userdata('logged_in')){

   		$this->load->view('jefe_home');
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

	 public function edit_modelo(){
   	if($this->session->userdata('logged_in')){

   		$this->load->view('edit_modelo');
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

	 /*public function save(){
		 $this->form_validation->set_rules('username', 'username', 'trim|required');
		 $this->form_validation->set_rules('password', 'password', 'trim|required|callback_check_database');

		 if($this->form_validation->run() == FALSE)
			{
				 //Field validation failed.  User redirected to login page
				 $this->load->view('login');
			}else{
				 redirect('Home', 'refresh');
			}

			$data = array(
				'nombre'	=>		$nombre,
				'email'		=>		$email,
				'registro'	=>		$fecha
			);
			//se inserta en la base de datos el nuevo modelo
			$this->db->insert('users',$data);
			redirect('Home', 'refresh');

   }*/

}
?>
