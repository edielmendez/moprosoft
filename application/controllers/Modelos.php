<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Modelos extends CI_Controller {
	function __construct()
   {

      parent::__construct();

      $this->load->model('modelo','',TRUE);
			$this->load->model('Student','',TRUE);
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

	 public function actividad(){
			if($this->session->userdata('logged_in')){

				$data = $this->session->userdata('logged_in');
				$result = $this->Student->getQuestionary($data['id'],$data['team_id']);

				$Questionary = array();
				$nuevos=0;
				$pendientes=0;
				 if($result){
						foreach ($result as $row ) {
							if ($row->status==0) {
								$nuevos=$nuevos+1;
							}else {
								$pendientes=$pendientes+1;
							}
							 $questionary = array(
								 'id' => $row->id,
								 'name' => $row->name,
								 'user_id' => $row->user_id,
								 'questionary_id' => $row->questionary_id,
								 'status' => $row->status,
								 'team_id' => $row->status
							 );
							 array_push($Questionary,$questionary);
						}
				 }

				 //historial
				 
	 			 $result2 = $this->Student->Questionary_Historial($data['id'],$data['team_id']);

	 			 $Questionary2 = array();
	 				if($result2){
	 					 foreach ($result2 as $row2 ) {
	 							$questionary2 = array(
	 								'name' => $row2->name
	 							);
	 							array_push($Questionary2,$questionary2);
	 					 }
	 				}

	 			 $datos_vista['historial'] = $Questionary2;
				 $datos_vista['cuestionarios'] = $Questionary;
				 $datos_vista['nuevo'] = $nuevos;
				 $datos_vista['pendientes'] = $pendientes;

				 $this->load->view('questionnaires_jefe/index',$datos_vista);
			}else{
				//si no hay session se redirecciona la vista de login
					redirect('login', 'refresh');
			}
		}


	 public function Contestar($id)
	 {
		 if($this->session->userdata('logged_in')){
			 $result = $this->Student->Questionary($id);
			 $Questionary= array();
			 if($result){
					foreach ($result as $row ) {

						 $questionary = array(
							 'id' => $row->id,
							 'name' => $row->name,
							 'phase_objetive_id' => $row->phase_objetive_id,
							 'status' => $row->status
						 );
						 array_push($Questionary,$questionary);
					}
			 }

			 $result2 = $this->Student->getQuestions($id);
			 $Question= array();
			 if($result2){
				 $contador=0;
					foreach ($result2 as $row ) {
						if ($contador<2) {
							$question = array(
								'id' => $row->id,
								'question' => $row->question,
								'answer_id' => $row->answer_id,
								'questionary_id' => $row->questionary_id,
								'res' => $row->answer_id
							);
							array_push($Question,$question);
						}
						$contador=$contador+1;
					}
			 }

			 $result3 = $this->Student->getQuestionsCount($id);
			 $resultado = $this->numTabs($result3);

			 $datos_vista['cuestionario'] = $Questionary;
			 $datos_vista['preguntas'] = $Question;
			 $datos_vista['numpreguntas'] = $resultado;
			 $this->load->view('questionnaires_jefe/contestar_preguntas',$datos_vista);
		 }else{
			 //si no hay session se redirecciona la vista de login
					redirect('login', 'refresh');
		 }
	 }

	 public function numTabs($num)
	 {
		 if ($num<=10) {
		 	return 1;
		 }

		 if ($num<=20) {
		 	return 2;
		 }

		 if ($num<=30) {
		 	return 3;
		 }

		 if ($num<=40) {
		 	return 4;
		 }

		 if ($num<=50) {
			return 5;
		 }

		 if ($num<=60) {
			return 6;
		 }

		 if ($num<=70) {
			return 7;
		 }

		 if ($num<=80) {
			return 8;
		 }

		 if ($num<=90) {
			return 9;
		 }

		 if ($num<=100) {
			return 10;
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
				 'name' => $row->name,
				 'version' => $row->version,
				 'level' => $row->level,
				 'trabajara' =>$row->phase_objetive
			 );
		 }

		 //Id
			if (!isset($_SESSION['modelsessionid'])) {
				$_SESSION['modelsessionid'] = $sess_array['id'];
			} else {
				$_SESSION['modelsessionid'] = $sess_array['id'];
			}

			//Nombre
			if (!isset($_SESSION['modelsessioname'])) {
				$_SESSION['modelsessioname'] = $sess_array['name'];
			} else {
				$_SESSION['modelsessioname'] = $sess_array['name'];
			}

			//Version
			if (!isset($_SESSION['modelsessionversion'])) {
				$_SESSION['modelsessionversion'] = $sess_array['version'];
			} else {
				$_SESSION['modelsessionversion'] = $sess_array['version'];
			}

			//Nivel
			if (!isset($_SESSION['modelsessionivel'])) {
				$_SESSION['modelsessionivel'] = $sess_array['level'];
			} else {
				$_SESSION['modelsessionivel'] = $sess_array['level'];
			}

			//trabajara
			if (!isset($_SESSION['modelsessiontrabajar'])) {
				$_SESSION['modelsessiontrabajar'] = $sess_array['trabajara'];
			} else {
				$_SESSION['modelsessiontrabajar'] = $sess_array['trabajara'];
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
