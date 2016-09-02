<?php
//Controlador Proceso
defined('BASEPATH') OR exit('No direct script access allowed');
class phase_Controller extends CI_Controller {

	function __construct()
   {
      parent::__construct();
      $this->load->model('Phase','',TRUE);
			$this->load->model('Process','',TRUE);
			$this->load->helper('url');
   }

	//Peticiones ajax
	public function getindex(){
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
			echo json_encode($phases);
		}else {
			redirect('login', 'refresh');
		}
	}

	//funcion para obtener las fases/onjetivos de un proceso en especifico
	public function getPhase_ProcessId($id){
		if($this->session->userdata('logged_in')){
			$result=$this->Phase->getPhase_ProcessId($id);
			$phases = array();
			if($result){
				 foreach ($result as $row ) {

						$phase = array(
							'id' => $row->id,
							'name' => $row->name,
							'status' => $row->status,
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

	public function getProcess(){
		if($this->session->userdata('logged_in')){
			$result=$this->Process->getProcess();
			$phases = array();
			if($result){
				 foreach ($result as $row ) {

						$phase = array(
							'id' => $row->id,
							'name' => $row->name,
							'model_id' => $row->model_id
						);
						array_push($phases,$phase);
				 }
			}
			echo json_encode($phases);
		}else {
			redirect('login', 'refresh');
		}
	}

   public function index(){
   	if($this->session->userdata('logged_in')){

			$result=$this->Phase->getPhases();
			//Se obtuvo las fases
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
			//Se obtuvo los procesos
			$result2=$this->Process->getProcess();
			$processes = array();
			if($result2){
				 foreach ($result2 as $row ) {

						$process = array(
							'id' => $row->id,
							'name' => $row->name,
							'model_id' => $row->model_id
						);
						array_push($processes,$process);
				 }
			}
			//////////////////////////////////

			$fases["fases"]= $phases;
			$fases["procesos"]= $processes;
   		$this->load->view('phases/index',$fases);
   	}else{
         redirect('login', 'refresh');
   	}
   }

	 public function save(){

	 if($this->input->post("submit")){
		 //llamo al metodo add
		 $add=$this->Phase->add(
						 $this->input->post("nombre"),
						 $this->input->post("procesomodal")
						 );
		 }

		if($add==0){
			$this->session->set_flashdata('correcto', 'La Fase/Objetivo ha sido creado de forma satisfactoria');
		}elseif ($add==1) {
			$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
		}elseif ($add==2) {
			$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
		}
		 //redirecciono la pagina a la url por defecto
		redirect('phase_Controller/index', 'refresh');

	}

	 public function edit($id){
		 if($this->session->userdata('logged_in')){

		$phase["phase"]=$this->Phase->getPhase($id);
		$this->load->view('phases/edit',$phase);

		 if($this->input->post("submit")){
				$mod=$this->Phase->update(
					$id,
					$this->input->post("nombre"),
					$this->input->post("id_phase")
					);

					if($mod==0){
						$this->session->set_flashdata('correcto', 'La Fase/Objetivo se ha actualizado de forma satisfactoria');
					}elseif ($mod==1) {
						$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
					}elseif ($mod==2) {
						$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
					}
				redirect('phase_Controller/index', 'refresh');

			 }

			 $this->load->view('phases/edit');
		 }else{
			 //si no hay session se redirecciona la vista de login
				 redirect('login', 'refresh');
		 }
	 }


	 public function Eliminar($id){
		if(is_numeric($id)){
				 $eliminar=$this->Phase->delete($id);
				if($eliminar==0){
					$this->session->set_flashdata('correcto', 'La Fase/Objetivo se ha Eliminado de forma satisfactoria');
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
