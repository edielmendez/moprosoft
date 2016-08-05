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
			//$fases["fases"]=
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
			$fases["fases"]= $processes;
   		$this->load->view('processes/index',$fases);
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

	 public function save(){

	 if($this->input->post("submit")){
		 //llamo al metodo add
		 $add=$this->Process->add(
						 $this->input->post("nombre")
						 );
		 }

		if($add==0){
			$this->session->set_flashdata('correcto', 'El Proceso ha sido creado de forma satisfactoria');
		}elseif ($add==1) {
			$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
		}elseif ($add==2) {
			$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
		}
		 //redirecciono la pagina a la url por defecto
		redirect('process_Controller/index', 'refresh');

 }

	 public function edit($id){
		 if($this->session->userdata('logged_in')){

		$process["processes"]=$this->Process->getpro($id);
		$this->load->view('processes/edit',$process);

    if($this->input->post("submit")){
	    	$mod=$this->Process->update(
	      	$id,
	        $this->input->post("nombre")
	        );

					if($mod==0){
						$this->session->set_flashdata('correcto', 'El Proceso se ha actualizado de forma satisfactoria');
					}elseif ($mod==1) {
						$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
					}elseif ($mod==2) {
						$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
					}
				redirect('process_Controller/index', 'refresh');

      }

			 $this->load->view('processes/edit');
		 }else{
			 //si no hay session se redirecciona la vista de login
				 redirect('login', 'refresh');
		 }
	 }


	 public function Eliminar($id){
			if(is_numeric($id)){
          $eliminar=$this->Process->delete($id);
					if($eliminar==0){
						$this->session->set_flashdata('correcto', 'El Proceso se ha Eliminado de forma satisfactoria');
					}elseif ($mod==1) {
						$this->session->set_flashdata('incorrecto', 'Ha ocurrido un error en la base de datos, porfavor contactar con el departamento de desarrollo');
					}elseif ($mod==2) {
						$this->session->set_flashdata('incorrecto', 'Ingrese los datos de manera correcta');
					}
					redirect('process_Controller/index', 'refresh');
        }else{
					redirect('process_Controller/index', 'refresh');
        }
  	}


}
?>
