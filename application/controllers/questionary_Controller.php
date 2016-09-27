<?php
//Controlador Proceso
defined('BASEPATH') OR exit('No direct script access allowed');
class questionary_Controller extends CI_Controller {

	function __construct()
   {
      parent::__construct();
      $this->load->model('Process','',TRUE);
			$this->load->model('Phase','',TRUE);
			$this->load->model('Questionary','',TRUE);
			$this->load->helper('url');
   }

   public function index(){
   	if($this->session->userdata('logged_in')){
			$result=$this->Phase->getPhases();
			$phases = array();
			if($result){
				 foreach ($result as $row ) {

						$phase = array(
							'id' => $row->id,
							'name' => $row->name,
							'process_id' => $row->process_id
						);
						array_push($phases,$phase);
				 }
			}
			$aux['phases']=$phases;
   		$this->load->view('questionnaires/index',$aux);
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

	 public function getQuestionary(){
		 if($this->session->userdata('logged_in')){
			 $result=$this->Questionary->getQuestionary();
			 $questionnaires = array();
			 if($result){
					foreach ($result as $row ) {

						 $questionary = array(
							 'id' => $row->id,
							 'name' => $row->name,
							 'phase_objetive_id' => $row->phase_objetive_id,
							 'status' => $row->status
						 );
						 array_push($questionnaires,$questionary);
					}
			 }
			 echo json_encode($questionnaires);
		 }else{
			 //si no hay session se redirecciona la vista de login
				 redirect('login', 'refresh');
		 }
	 }


	 public function save(){
	 if($this->input->post("submit")){
		 //llamo al metodo add
		 $add=$this->Questionary->add(
						 $this->input->post("new_nombre"),
						 $this->input->post("new_fase")
						 );
		 }
		if($add==0){
			$this->session->set_flashdata('correcto', 'El Cuestionario ha sido creado de forma satisfactoria');
		}elseif ($add==1) {
			$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
		}elseif ($add==2) {
			$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
		}
		 //redirecciono la pagina a la url por defecto
		redirect('questionary_Controller/index', 'refresh');

	}

	 public function getProcess(){
	 if($this->session->userdata('logged_in')){
		 $result=$this->Process->getProcess();
		 $processes = array();
		 if($result){
				foreach ($result as $row ) {

					 $process = array(
						 'id' => $row->id,
						 'name' => $row->name,
						 'model_id' => $row->model_id
					 );
					 array_push($processes,$process);
				}
		 }
		 echo json_encode($processes);
	 }else {
		 redirect('login', 'refresh');
	 }
 }

 public function getPhases($id){
	 if($this->session->userdata('logged_in')){
	 			$result=$this->Phase->getPhase_ProcessId($id);
	 			$phases = array();
	 			if($result){
	 				 foreach ($result as $row ) {

	 						$phase = array(
	 							'id' => $row->id,
	 							'name' => $row->name,
	 							'process_id' => $row->process_id
	 						);
	 						array_push($phases,$phase);
	 				 }
	 			}
	 			echo json_encode($phases);
	 		}else {
	 			redirect('login', 'refresh');
	 		}
}

public function getCuestionary_PhaseId($id){
	if($this->session->userdata('logged_in')){
			 $result=$this->Questionary->getQuestionary_id($id);
			 $questionnaires = array();
			 if($result){
					foreach ($result as $row ) {

						 $questionary = array(
							 'id' => $row->id,
							 'name' => $row->name,
							 'phase_objetive_id' => $row->phase_objetive_id
						 );
						 array_push($questionnaires,$questionary);
					}
			 }
			 echo json_encode($questionnaires);
		 }else {
			 redirect('login', 'refresh');
		 }
	 }

	 public function edith($id){
		 if($this->session->userdata('logged_in')){

			$questionary["cuestionario"]=$this->Questionary->getQ($id);
			$questionary["numPreguntas"]=$this->Questionary->getCountQuestion($id);
			$this->load->view('questionnaires/edith',$questionary);

			 if($this->input->post("submit")){
					$mod=$this->Questionary->update(
						$id,
						$this->input->post("nombre"),
						$this->input->post("liberacion")
						);

						if($mod==0){
							$this->session->set_flashdata('correcto', 'El Cuestionario se ha actualizado de forma satisfactoria');
						}elseif ($mod==1) {
							$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
						}elseif ($mod==2) {
							$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
						}
					redirect('questionary_Controller/index', 'refresh');

				 }
			 }else{
				 //si no hay session se redirecciona la vista de login
					 redirect('login', 'refresh');
			 }

	 }


	 public function Eliminar($id){
		if(is_numeric($id)){
				 $eliminar=$this->Questionary->delete($id);
				if($eliminar==0){
					$this->session->set_flashdata('correcto', 'El Cuestionario se ha Eliminado de forma satisfactoria');
				}elseif ($mod==1) {
					$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
				}elseif ($mod==2) {
					$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
				}
				echo "{json:bien}";
				redirect('phase_Controller/index', 'refresh');
			 }else{
				redirect('phase_Controller/index', 'refresh');
			 }
	}

}
?>
