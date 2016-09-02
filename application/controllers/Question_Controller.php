<?php
//Controlador Proceso
defined('BASEPATH') OR exit('No direct script access allowed');
class question_Controller extends CI_Controller {

	function __construct()
   {
      parent::__construct();
      $this->load->model('Question','',TRUE);
			$this->load->model('Phase','',TRUE);
			$this->load->model('Question','',TRUE);
			$this->load->model('Process','',TRUE);
			//$this->load->model('Questionary','',TRUE);
			$this->load->helper('url');
   }

	 public function back(){
		  $Phase=$_SESSION['phase_objetive_id'];
		 	$result=$this->Phase->getPhase($Phase);
			$sess_array = array();
			foreach($result as $row)
		  {
				 $sess_array = array(
					 'id' => $row->id,
					 'name' => $row->name,
					 'status' => $row->status,
					 'process_id' => $row->process_id
				 );
		  }

		 	$result2=$this->Question->getCountQuestion($Phase);

		 	$aux['cuestionario']=$sess_array;
			$aux['numPreguntas']=$result2;
			$this->load->view('questions/index',$aux);
			//$this->load->view('questions/index');
	 }

   public function index(){
   	if($this->session->userdata('logged_in')){
			$result=$this->Question->getQuestions();
			$questions = array();
			$contador=1;
			if($result){
				 foreach ($result as $row ) {
						$question = array(
							'id' => $row->id,
							'n' => $contador,
							'question' => $row->question,
							'commentary' => $row->commentary,
							'answer_id' => $row->answer_id,
							'phase_objetive_id' => $row->phase_objetive_id
						);
						array_push($questions,$question);
						$contador++;
				 }
			}
			echo json_encode($questions);
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
	}

	 public function Liberar(){
		 $Phase=$_SESSION['phase_objetive_id'];
		 $result=$this->Phase->updateStatus($Phase);

		 //Liberer el proceso
		 $Process=$_SESSION['phase_objetive_process'];
		 $NumCuestionarios=$this->Phase->getCountPhases($Process);
		 $CuestionariosLiberados=0;
		 $CuestionariosLiberados=$this->Phase->getCountPhasesBreakFree($Process);
		 if ($NumCuestionarios==$CuestionariosLiberados) {
       $this->Process->updateStatus($Process);
		 }

		 if($result==0){
			 $this->session->set_flashdata('correcto', 'Se ha liberado el cuestionario de forma satisfactoria');
		 }elseif ($result==1) {
			 $this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
		 }elseif ($result==2) {
			 $this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
		 }

		 	redirect('questionary_Controller/index', 'refresh');

	 }

	 public function Preguntas($id){
		 if($this->session->userdata('logged_in')){

				$result=$this->Phase->getPhase($id);
				$sess_array = array();
				foreach($result as $row)
			 {
				 $sess_array = array(
					 'id' => $row->id,
					 'name' => $row->name,
					 'status' => $row->status,
					 'process_id' => $row->process_id
				 );
			 }

			 if (!isset($_SESSION['phase_objetive_process'])) {
				 $_SESSION['phase_objetive_process'] = $sess_array['process_id'];
			 } else {
				 $_SESSION['phase_objetive_process'] = $sess_array['process_id'];
			 }

			 if (!isset($_SESSION['phase_objetive_id'])) {
				 $_SESSION['phase_objetive_id'] = $sess_array['id'];
			 } else {
				 $_SESSION['phase_objetive_id'] = $sess_array['id'];
			 }

			 if (!isset($_SESSION['phase_objetive_status'])) {
				 $_SESSION['phase_objetive_status'] = $sess_array['status'];
			 } else {
				 $_SESSION['phase_objetive_status'] = $sess_array['status'];
			 }

			 if (!isset($_SESSION['phase_objetive_name'])) {
				 $_SESSION['phase_objetive_name'] = $sess_array['name'];
			 } else {
				 $_SESSION['phase_objetive_name'] = $sess_array['name'];
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
