<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Modelos extends CI_Controller {
	function __construct()
   {

      parent::__construct();

      $this->load->model('modelo','',TRUE);
			$this->load->model('Student','',TRUE);
			$this->load->model('User','',TRUE);
      $this->load->model('Validate','',TRUE);
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

	 public function truncateFloat($number, $digitos)
	{
		$raiz = 10;
		$multiplicador = pow ($raiz,$digitos);
		$resultado = ((int)($number * $multiplicador)) / $multiplicador;
		return number_format($resultado, $digitos);
 }

	public function VerSeguimiento($phase)
	{
		if($this->session->userdata('logged_in')){

      $equipo=$this->session->userdata('logged_in')['team_id'];
			$fechas = $this->modelo->getSeguimiento($phase,$equipo);

			$datos['fi']=$fechas[0];
			$datos['ff']=$fechas[1];
			$datos['tracing']=$fechas[2];
			$datos['phase']=$phase;
			$this->load->view('questionnaires_jefe/verSeguimiento',$datos);
		}else{
			//si no hay session se redirecciona la vista de login
				redirect('login', 'refresh');
		}
	}

	public function getActividades($tracing_id)
	{
		$result = $this->modelo->getPreguntasPriorizadas($tracing_id);
		$Preguntas=array();
		if ($result) {
			foreach ($result as $row) {
				$pre = array(
					'id'=> $row->id,
					'activity' => $row->activity,
					'orden' => $row->orden,
					'fi' => $row->date_start,
					'ff' => $row->date_end,
				);
				array_push($Preguntas,$pre);
			}
		}

		echo json_encode($Preguntas);
	}

	public function updateFollow()
	{
		if($this->session->userdata('logged_in')){
			$equipo = $this->session->userdata('logged_in')['team_id'];
			$objDatos = json_decode(file_get_contents("php://input"));
			$fecha_final="";

			foreach ($objDatos->follow as $row) {
				$result2 = $this->modelo->updateFollow($row->id,$row->fi,$row->ff,$equipo);
				$fecha_final=$row->ff;
			}
			echo $result2;
		}else{
			redirect('login', 'refresh');
		}
	}

	 public function resultado(){
   	if($this->session->userdata('logged_in')){
			//Se obtiene el hisyorial
			$historial = $this->modelo->get_historial_result( $this->session->userdata('logged_in')['team_id'] );
			$Historial = array();
			if ($historial) {
				foreach ($historial as $row) {
					$namePhase = $this->modelo->getNamePhase($row->phase);
					$nameModel = $this->modelo->getNameModel($row->phase);
					$nameProcess = $this->modelo->getNameProcess($row->phase);

					$his = array(
						'model'=> $nameModel,
						'process' => $nameProcess,
						'phase' => $namePhase,
						'nco' => $row->nco,
						'ncr' => $row->ncr,
						'f' => $row->f
					);
					array_push($Historial,$his);
				}
			}
			//////////////////////////////////////////
			//Se obtiene los cuestionarios en seguimiento o los que estan por dar seguimientos
			$data = $this->session->userdata('logged_in');
			$resultado = $this->modelo->getResultado_historial($data['team_id']);
			$Resultado_phase = array();

			if ($resultado) {
				foreach ($resultado as $row) {
					$namePhase = $this->modelo->getNamePhase($row->phase);
					$nameModel = $this->modelo->getNameModel($row->phase);
					$nameProcess = $this->modelo->getNameProcess($row->phase);

					$Seguimiento = $this->modelo->ExisteSeguimiento($row->phase,$data['team_id']);
					$historial = $this->modelo->historial_seguimineto($row->phase,$data['team_id']);

					$res = array(
						'model'=> $nameModel,
						'process' => $nameProcess,
						'phase' => $namePhase,
						'phase_id' => $row->phase,
						'nco' => $row->nco,
						'ncr' => $row->ncr,
						'seguimiento' => $Seguimiento,
						'historial' => $historial
					);
					array_push($Resultado_phase,$res);
				}
			}
			///////////////////////////////////////////////////////////////////////

			/*$result = $this->modelo->getResultado($data['team_id']);
			$Resultado = array();

			$suma=0;
			$contador=0;
			$questionary=-1;
			$name="Sin nombre";
      $equipo_usuario=$this->session->userdata('logged_in')['team_id'];


			 if($result){
					foreach ($result as $row ) {

						if ($questionary!=$row->phase_objetive_id) {

							if ($contador!=0) {
                $termino_phase = $this->Validate->check_finish_phase($questionary,$equipo_usuario);
								$Seguimiento = $this->modelo->ExisteSeguimiento($questionary,$equipo_usuario);
								$historial = $this->modelo->historial_seguimineto($questionary,$equipo_usuario);
								$nameModel = $this->modelo->getNameModel($questionary);
								$nameProcess = $this->modelo->getNameProcess($questionary);
								$cp = $this->modelo->getNameProcessPorcentaje($nameModel);
								array_push($Resultado,array($name,$questionary,round($suma/$contador,0),$nameModel,$nameProcess,$cp,$Seguimiento,$historial,$termino_phase) );
								$questionary=$row->phase_objetive_id;
								$name=$row->name;
								$suma=$row->nivel_cobertura;
								$contador=1;
							}elseif ($contador==0) {
								$questionary=$row->phase_objetive_id;
								$suma=$suma+$row->nivel_cobertura;
								$contador++;
							}
						}else {
							$name=$row->name;
							$suma=$suma+$row->nivel_cobertura;
							$contador++;
						}
					}
          $termino_phase = $this->Validate->check_finish_phase($questionary,$equipo_usuario);
					$Seguimiento = $this->modelo->ExisteSeguimiento($questionary,$equipo_usuario);
					$historial = $this->modelo->historial_seguimineto($questionary,$equipo_usuario);
					$nameModel = $this->modelo->getNameModel($questionary);
					$nameProcess = $this->modelo->getNameProcess($questionary);
					$cp = $this->modelo->getNameProcessPorcentaje($nameModel);
					array_push($Resultado,array($name,$questionary,round($suma/$contador,0),$nameModel,$nameProcess,$cp,$Seguimiento,$historial,$termino_phase) );
			 }*/

			//$datos['cuestionarios']=$Resultado;
			$datos['resultado']=$Resultado_phase;
			$datos['historial']=$Historial;
   		$this->load->view('questionnaires_jefe/resultado',$datos);
   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }


	 public function historial($id)
	 {
		 if($this->session->userdata('logged_in')){

     $equipo=$this->session->userdata('logged_in')['team_id'];
		 $result=$this->modelo->get_historial_seguimiento($id,$equipo);
		 $tracing=$this->modelo->getSeguimiento($id,$equipo);

		 $Calificacion = array();
		 if($result){
				foreach ($result->result() as $row ) {
						 $cal = array(
							'activity' => $row->activity,
							'orden' => $row->orden,
							'date_start' => $row->date_start,
							'date_end' => $row->date_end,
						);
						array_push($Calificacion,$cal);
				}
		 }

		 $datos['activity']=$Calificacion;
		 $datos['fi']=$tracing[0];
		 $datos['ff']=$tracing[1];
		 $this->load->view('questionnaires_jefe/historial',$datos);
	 }else{
		 redirect('login', 'refresh');
	 }
	 }

	 public function Seguimiento($id)
	 {
		 if($this->session->userdata('logged_in')){
			 $data = $this->session->userdata('logged_in');

			 $result=$this->modelo->Calificacion($id,$data['team_id']);
			 $Calificacion = array();
			 $Phase=0;
			 $terminado_proceso=0;
	 		 if($result){
	 				foreach ($result as $row ) {
						 $Phase=$row->phase_objetive_id;
						 if ($row->valor=='indeterminado') {
						 	$terminado_proceso=1;
						 }
						 if ($row->valor=='debil') {
							 $cal = array(
								'id' => $row->id,
								'team_id' => $row->team_id,
								'phase_objetive_id' => $row->phase_objetive_id,
								'question' => $row->question,
								'question_id' => $row->question_id,
								'valor' => $row->valor,
								'bandera' => $row->bandera
							);
							array_push($Calificacion,$cal);
						 }
	 				}
	 		 }
			 $datos['actividades']=$Calificacion;
			 $datos['Equipo']=$data['team_id'];
			 $datos['Phase']=$Phase;
			 $datos['valor']=$terminado_proceso;
			 $this->load->view('questionnaires_jefe/seguimiento',$datos);
		 }else{
			 redirect('login', 'refresh');
		 }
	 }


   public function getSeguimiento($id)
	 {
		 if($this->session->userdata('logged_in')){
			 $data = $this->session->userdata('logged_in');

			 $result=$this->modelo->Calificacion($id,$data['team_id']);
			 $Calificacion = array();
	 		 if($result){
	 				foreach ($result as $row ) {
						 if ($row->valor=='debil') {
							 $cal = array(
								'id' => $row->id,
								'team_id' => $row->team_id,
								'phase_objetive_id' => $row->phase_objetive_id,
								'question' => $row->question,
								'question_id' => $row->question_id,
								'valor' => $row->valor,
								'bandera'=>$row->bandera
							);
							array_push($Calificacion,$cal);
						 }
	 				}
	 		 }
       echo json_encode($Calificacion);

		 }else{
			 redirect('login', 'refresh');
		 }
	 }

	 public function terminarSeguimiento()
	 {
		 if($this->session->userdata('logged_in')){
			 $equipo = $this->session->userdata('logged_in')['team_id'];

			 $objDatos = json_decode(file_get_contents("php://input"));
			 $result=$this->modelo->terminarSeguimiento($objDatos->phase,$objDatos->fi,$objDatos->ff,$equipo);
			 echo $result;

		 }else{
			 redirect('login', 'refresh');
		 }
	 }

	 public function SeguimientoPreguntasPriorizadas()
	 {
		 if($this->session->userdata('logged_in')){
			$equipo = $this->session->userdata('logged_in')['team_id'];
			$objDatos = json_decode(file_get_contents("php://input"));

			foreach ($objDatos->preguntas as $value) {
				$result=$this->modelo->GuardarPriorizadas($objDatos->id,$value->id,$value->activity,$value->orden,$value->fi,$value->ff,$equipo);
			}
			echo "ok";
		 }else{
			 redirect('login', 'refresh');
		 }
	 }


	 public function perfil(){
      if($this->session->userdata('logged_in')){
         $this->load->view('questionnaires_jefe/perfil');
      }else{
         redirect('login', 'refresh');
      }
   }

	 public function perfil2(){
      if($this->session->userdata('logged_in')){
         $this->load->view('questionnaires_jefe/perfil2');
      }else{
         redirect('login', 'refresh');
      }
   }

	 public function actividad(){
			if($this->session->userdata('logged_in')){
				$data = $this->session->userdata('logged_in');
				$result = $this->Student->getPhases($data['id'],$data['team_id']);

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
								 'phase_objetive_id' => $row->phase_objetive_id,
								 'status' => $row->status,
								 'team_id' => $row->status
							 );
							 array_push($Questionary,$questionary);
						}
				 }

				 //historial

	 			 $result2 = $this->Student->Phase_Historial($data['id']);
				 //print_r($result2);
	 			 $Questionary2 = array();
	 				if($result2){
	 					 foreach ($result2 as $row2 ) {
	 							$questionary2 = array(
	 								'model' => $row2->model,
									'process' => $row2->process,
									'phase' => $row2->phase,
                  'f' => $row2->f
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
			 $result = $this->Student->Phase($id);
			 $Questionary= array();
			 if($result){
					foreach ($result as $row ) {

						 $questionary = array(
							 'id' => $row->id,
							 'name' => $row->name,
							 'status' => $row->status,
							 'process_id' => $row->process_id
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
								'commentary' => $row->commentary,
								'answer_id' => $row->answer_id,
								'phase_objetive_id' => $row->phase_objetive_id,
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
							 $this->input->post("cp"),
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
					$this->input->post("cp"),
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
