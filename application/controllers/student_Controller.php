<?php
//Controlador Proceso
defined('BASEPATH') OR exit('No direct script access allowed');
class Student_Controller extends CI_Controller {

	function __construct()
   {
      parent::__construct();
      $this->load->model('modelo','',TRUE);
      $this->load->model('Process','',TRUE);
			$this->load->model('Phase','',TRUE);
			$this->load->model('Questionary','',TRUE);
      $this->load->model('Student','',TRUE);
			$this->load->helper('url');
   }

	 public function historial()
	 {
			 $data = $this->session->userdata('logged_in');
			 $result = $this->Student->Questionary_Historial($data['id'],$data['team_id']);

			 $Questionary = array();
				if($result){
					 foreach ($result as $row ) {
							$questionary = array(
								'name' => $row->name
							);
							array_push($Questionary,$questionary);
					 }
				}
			   $datos_vista['cuestionarios'] = $Questionary;
	 		 $this->load->view('students/historial',$datos_vista);
	 }

   public function index()
   {

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

     $datos_vista['cuestionarios'] = $Questionary;
     $datos_vista['nuevo'] = $nuevos;
     $datos_vista['pendientes'] = $pendientes;
     $this->load->view('students/index',$datos_vista);
   }

   public function Contestar($id)
   {
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
      $this->load->view('students/contestar_preguntas',$datos_vista);
   }


	 public function getQuestions($id)
	 {

		 $user=$this->session->userdata('logged_in')['id'];
		 $result2 = $this->Student->getQuestions($id);
		 $result3 = $this->Student->getQuestions_Answer($id,$user);

		 $Question= array();
		 if($result2){
				foreach ($result2 as $row ) {
					 $aux=0;
					 if($result3){
						 foreach ($result3 as $row2 ) {
		 					 if($row->id==$row2->question_id){
								 $aux=$row2->answer_id;
							 }
		 				 }
					 }
					 $question = array(
						 'id' => $row->id,
						 'question' => $row->question,
						 'res'=>$aux
					 );
					 array_push($Question,$question);
				}
		 }

		 echo json_encode($Question);
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


	 public function save()
	 {
			$json = file_get_contents("php://input");
			$objeto=json_encode($json, true);

			$cad = str_replace(array('"','{','}','\\','A-Za-z'),array(''), $objeto);
			$cad=preg_replace('/[A-Z-a-z]/', '', $cad);
			$cad=preg_replace('/_[\d ]:/', '', $cad);
			$datos =  preg_split("/[,]/",$cad);

			$user=$this->session->userdata('logged_in')['id'];
			//Se inserta la primer pregunta
			$add1=$this->Student->add(
							$user,
							$datos[0],
							$datos[1],
							$datos[2]
						);
			//Se inserta la segunda pregunta
			$add2=$this->Student->add(
							$user,
							$datos[0],
							$datos[3],
							$datos[4]
						);

			$NumRespuestas = $this->Student->getAvance($datos[0],$user);
			$NumPreguntas =$this->Student->getQuestionsCount($datos[0]);
			$avanze=($NumRespuestas*100)/$NumPreguntas;

			$AvanzeActualizado = $this->Student->updateAvanze($datos[0],$user,$avanze);

			if ($add1==0 && $add2==0 && $AvanzeActualizado==0) {
				echo "Datos insertados con exito";
			}else {
				echo "Ocurrio un error al gurdar los datos";
			}
	 }

	 public function terminar()
	 {
		 $json = file_get_contents("php://input");
		 $objeto=json_encode($json, true);

		 $cad = str_replace(array('"','{','}','\\','A-Za-z'),array(''), $objeto);
		 $cad=preg_replace('/[A-Z-a-z]/', '', $cad);
		 $cad=preg_replace('/_[\d ]:/', '', $cad);
		 $datos =  preg_split("/[,]/",$cad);

		 $longitud = sizeof($datos);
		 $user=$this->session->userdata('logged_in')['id'];
		 $equipo=$this->session->userdata('logged_in')['team_id'];

		 $add1=$this->Student->add(
						 $user,
						 $datos[0],
						 $datos[1],
						 $datos[2]
					 );

		if ($longitud>3) {
			$add2=$this->Student->add(
							$user,
							$datos[0],
							$datos[3],
							$datos[4]
						);
		}
		//print_r($datos);
		$result = $this->Student->finalizarCuestionario($user,$datos[0],$equipo);
		if ($result==0) {
			echo "La consulta se realizo exitosamente";
		}else {
			echo "Ocurrio un problema al guardar los datos en la Base de Datos";
		}

	 }

}
?>
