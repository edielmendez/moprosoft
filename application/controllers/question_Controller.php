<?php
//Controlador Proceso
defined('BASEPATH') OR exit('No direct script access allowed');
class question_Controller extends CI_Controller {

	function __construct()
   {
      parent::__construct();
      $this->load->model('Question','',TRUE);
			$this->load->model('Questionary','',TRUE);
			$this->load->helper('url');
   }

	 public function back(){
		  $Questionary=$_SESSION['Questionary_id'];
		 	$result=$this->Questionary->getQ($Questionary);
			$sess_array = array();
			foreach($result as $row)
		 {
			 $sess_array = array(
				 'id' => $row->id,
				 'name' => $row->name,
				 'phase_objetive_id' => $row->phase_objetive_id,
				 'status' => $row->status
			 );
		 }

		 	$result2=$this->Question->getCountQuestion($Questionary);

		 	$aux['cuestionario']=$sess_array;
			$aux['numPreguntas']=$result2;
			$this->load->view('questions/index',$aux);
	 }

   public function index(){
   	if($this->session->userdata('logged_in')){
			$result=$this->Question->getQuestions();
			$questions = array();
			if($result){
				 foreach ($result as $row ) {
						$question = array(
							'id' => $row->id,
							'question' => $row->question,
							'commentary' => $row->commentary,
							'answer_id' => $row->answer_id,
							'questionary_id' => $row->questionary_id
						);
						array_push($questions,$question);
				 }
			}
			echo json_encode($questions);
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

	 public function Liberar(){
		 $Questionary=$_SESSION['Questionary_id'];
		 $result=$this->Questionary->updateStatus($Questionary);

		 if($result==0){
			 $this->session->set_flashdata('correcto', 'Se ha liberado el cuestionario de forma satisfactoria');
		 }elseif ($result==1) {
			 $this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
		 }elseif ($result==2) {
			 $this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
		 }

		 	redirect('question_Controller/back', 'refresh');

	 }

	 public function Preguntas($id){
		 if($this->session->userdata('logged_in')){

				$result=$this->Questionary->getQ($id);
				$sess_array = array();
				foreach($result as $row)
			 {
				 $sess_array = array(
					 'id' => $row->id,
					 'name' => $row->name,
					 'phase_objetive_id' => $row->phase_objetive_id,
					 'status' => $row->status,
				 );
			 }

			 if (!isset($_SESSION['Questionary_id'])) {
				 $_SESSION['Questionary_id'] = $sess_array['id'];
			 } else {
				 $_SESSION['Questionary_id'] = $sess_array['id'];
			 }

			 if (!isset($_SESSION['Questionary_status'])) {
				 $_SESSION['Questionary_status'] = $sess_array['status'];
			 } else {
				 $_SESSION['Questionary_status'] = $sess_array['status'];
			 }

			 if (!isset($_SESSION['Questionary_name'])) {
				 $_SESSION['Questionary_name'] = $sess_array['name'];
			 } else {
				 $_SESSION['Questionary_name'] = $sess_array['name'];
			 }

			redirect('question_Controller/back', 'refresh');

		 }else{
			 //si no hay session se redirecciona la vista de login
				 redirect('login', 'refresh');
		 }
	 }


	 public function save(){

		 if($this->input->post("submit")){
			 //llamo al metodo add
			 $add=$this->Question->add(
							 $this->input->post("pregunta"),
							 $this->input->post("comentarioayuda")
							 );
			 }

			if($add==0){
				$this->session->set_flashdata('correcto', 'La Pregunta ha sido creado de forma satisfactoria');
			}elseif ($add==1) {
				$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
			}elseif ($add==2) {
				$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
			}

			redirect('question_Controller/back', 'refresh');
		}

	 public function edit($id){
		 if($this->session->userdata('logged_in')){
			 $aux["question"]=$this->Question->getQuestion($id);
			 $this->load->view('questions/edith',$aux);

				if($this->input->post("submit")){
					 $mod=$this->Question->update(
						 $id,
						 $this->input->post("pregunta"),
						 $this->input->post("comentarioayuda")
						 );

						 if($mod==0){
							 $this->session->set_flashdata('correcto', 'La Pregunta se ha actualizado de forma satisfactoria');
						 }elseif ($mod==1) {
							 $this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
						 }elseif ($mod==2) {
							 $this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
						 }
						 redirect('question_Controller/back', 'refresh');
					}
		 }else{
			 //si no hay session se redirecciona la vista de login
				 redirect('login', 'refresh');
		 }
	 }

	 public function Eliminar($id){
		 if(is_numeric($id)){
					$eliminar=$this->Question->delete($id);
				 if($eliminar==0){
					 $this->session->set_flashdata('correcto', 'La Pregunta se ha Eliminado de forma satisfactoria');
				 }elseif ($mod==1) {
					 $this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
				 }elseif ($mod==2) {
					 $this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
				 }
				 redirect('phase_Controller/back', 'refresh');
				}else{
				 redirect('phase_Controller/back', 'refresh');
				}
	 }


}
?>
