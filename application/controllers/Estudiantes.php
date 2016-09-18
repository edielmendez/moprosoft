<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Estudiantes extends CI_Controller {
	function __construct()
   {

      parent::__construct();

<<<<<<< HEAD
      $this->load->model('user','',TRUE);
=======
      $this->load->model('modelo','',TRUE);
			 $this->load->helper('url'); 
>>>>>>> ca67a11b71beb72fb4cce43dcfb44d61ff03dee9
   }

   public function nuevo(){
   	if($this->session->userdata('logged_in')){

   		$this->load->view('nuevo_estudiante');

   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

   public function crear_usuario(){
      if($this->session->userdata('logged_in')){
         $username = $this->input->post('username');
         $password = $this->input->post('password');
         $email = $this->input->post('email');
         $name = $this->input->post('name');
         $grupo = $this->input->post('grupo');
         
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

}
?>
