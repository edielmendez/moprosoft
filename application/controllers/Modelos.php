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
			$varx['NumProcess']= $this->modelo->getNumProcess($_SESSION['modelsessionid']);
   		$this->load->view('jefe_home',$varx);
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

	 public function cargar_modelo($id){
   	if($this->session->userdata('logged_in')){
			$modelSeleccionado=$this->modelo->getModel($id);

			$sess_array = array();
			foreach($modelSeleccionado as $row)
		 {
			 $sess_array = array(
				 'id' => $row->id,
				 'name' => $row->name
			 );
		 }

			if (!isset($_SESSION['modelsessionid'])) {
				$_SESSION['modelsessionid'] = $sess_array['id'];
			} else {
				$_SESSION['modelsessionid'] = $sess_array['id'];
			}

			if (!isset($_SESSION['modelsessioname'])) {
				$_SESSION['modelsessioname'] = $sess_array['name'];
			} else {
				$_SESSION['modelsessioname'] = $sess_array['name'];
			}

			//$this->session->set_usermodel('modelo',$modelSeleccionado);
			//$this->session->set_flashdata('correcto', 'El Modelo ha sido creado de forma satisfactoria');
			$varx['NumProcess']= $this->modelo->getNumProcess($_SESSION['modelsessionid']);
   		$this->load->view('jefe_home',$varx);
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

	 public function save(){

		 if($this->input->post("submit")){
			 //llamo al metodo add
			 $add=$this->modelo->add(
							 $this->input->post("nombre"),
							 $this->input->post("version"),
							 $this->input->post("nivel"),
							 $this->input->post("trabajara")
							 );
			 }

			if($add==0){
				$this->session->set_flashdata('correcto', 'El Modelo ha sido creado de forma satisfactoria');
			}elseif ($add==1) {
			 	$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
			}elseif ($add==2) {
				$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
			}
			 //redirecciono la pagina a la url por defecto
			redirect('Home', 'refresh');

   }


	 public function Actualizar($id){

   	$datos["mod"]=$this->modelo->getModel($id);
		$this->load->view('edit_modelo',$datos);

    if($this->input->post("submit")){
	    	$mod=$this->modelo->update(
	      	$id,
	        $this->input->post("nombre"),
	        $this->input->post("version"),
	        $this->input->post("nivel"),
	        $this->input->post("trabajara")
	        );

					if($mod==0){
						$this->session->set_flashdata('correcto', 'El Modelo se ha actualizado de forma satisfactoria');
					}elseif ($mod==1) {
						$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
					}elseif ($mod==2) {
						$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
					}
				redirect('Home', 'refresh');

      }

    }

		public function Eliminar($id){
			if(is_numeric($id)){
          $eliminar=$this->modelo->delete($id);
					if($eliminar==0){
						$this->session->set_flashdata('correcto', 'El Modelo se ha Eliminado de forma satisfactoria');
					}elseif ($mod==1) {
						$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
					}elseif ($mod==2) {
						$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
					}
				$jsondata['success'] = true;
				redirect('Home', 'refresh');
        }else{
					$jsondata['success'] = true;
          redirect('Home', 'refresh');
        }
  	}


}
?>
