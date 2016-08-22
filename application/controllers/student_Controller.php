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

	 public function perfil(){
      if($this->session->userdata('logged_in')){
         $this->load->view('students/perfil');
      }else{
         redirect('login', 'refresh');
      }
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
							 'commentary' => $row->commentary,
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
						 'commentary' => $row->commentary,
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

	 public function calificar($user,$equipo,$cuestionario)
	 {
	 		 $NumCuestionarios = $this->Student->NumCuestionarioEquipo($cuestionario,$equipo);
			 $Contestados=$this->Student->NumCuestionarioEquipoContestados($cuestionario,$equipo);

			 echo "Numero de cuestionarios:".$NumCuestionarios;
			 echo "Numero de cuestionarios resueltos:".$Contestados;

			 if ($NumCuestionarios==$Contestados) {
				 echo "entro";
			 	//se obtienen los usuarios de ese equipo
					$result=$this->Student->getUsersPorTeam($equipo);
					$Usuarios=array();
					foreach ($result as $row ) {
						$user = array(
							'id' => $row->id
						);
						array_push($Usuarios,$user);
					}
					//se obtienen las preguntas
					$result2=$this->Student->getPreguntas($cuestionario);
					$Preguntas=array();
					foreach ($result2 as $row ) {
						$pregunta = array(
							'id' => $row->id,
							'siempre'	=> 0,
							'usualmente'	=> 0,
							'aveces'	=> 0,
							'rara'	=> 0,
							'nunca'	=> 0
						);
						array_push($Preguntas,$pregunta);
					}
					//Obtener respuestas y guardarlas

					$indice=0;
					foreach ($Preguntas as $row ) {
						//obtencion de las respuestas segun la pregunta
						$res=$this->Student->getRespuestas($cuestionario,$row['id']);

						foreach ($res as $row2) {
							switch ($row2->answer_id) {
							    case 1:
							        $Preguntas[$indice]['siempre']=$Preguntas[$indice]['siempre']+1;
							        break;
							    case 2:
											$Preguntas[$indice]['usualmente']=$Preguntas[$indice]['usualmente']+1;
							        break;
							    case 3:
											$Preguntas[$indice]['aveces']=$Preguntas[$indice]['aveces']+1;
							        break;
									case 4:
									  	$Preguntas[$indice]['rara']=$Preguntas[$indice]['rara']+1;
											break;
									case 5:
									  	$Preguntas[$indice]['nunca']=$Preguntas[$indice]['nunca']+1;
											break;
							}
						}
						$indice++;
					}
					//Se calculan su calificacion
					echo "usuarios";
					print_r( $Usuarios);
					foreach ($Preguntas as $row) {
						$calificar = $this->calificarPregunta(sizeof($Usuarios),$equipo,$cuestionario,$row['id'],$row['siempre'],$row['usualmente'],$row['aveces'],$row['rara'],$row['nunca']);
					}
			 }
	 }


	 public function calificarPregunta($tpe,$equipo,$cuestionario,$question_id,$siempre,$usualmente,$aveces,$rara,$nunca)
	 {
		 $cobertura=( ($siempre*1)+($usualmente*0.75)+($aveces*0.5)+($rara*0.25)+($nunca*0) )/$tpe;
		 $media=( ($siempre*4)+($usualmente*3)+($aveces*2)+($rara*1)+($nunca*0) )/$tpe;
		 $desviacion=sqrt(  ($tpe*( (pow(4,2)*$siempre)+(pow(3,2)*$usualmente)+(pow(2,2)*$aveces)+(pow(1,2)*$rara)  )-pow($tpe,2)*pow($media,2) )/ pow($tpe,2) );

		 //Se redondean para que solo tengan un decimal. ejemplo 2.8 no 2.8354
		 $cobertura=$cobertura*100;
		 $cobertura=intval($cobertura);
		 $media=$this->truncateFloat($media,1);
		 $desviacion=$this->truncateFloat($desviacion,1);

		 $add=$this->Student->addCalificacion($equipo,$cuestionario,$question_id,$siempre,$usualmente,$aveces,$rara,$nunca,$cobertura,$media,$desviacion);
		 if ($add==0) {
		 	echo "Se inserto; numPersonas:$tpe equipo:$equipo S:$siempre U:$usualmente A:$aveces R:$rara N:$nunca cobertura:$cobertura  media:$media desviacion:$desviacion";
		}else {
			echo "No se inserto la calificacion";
		}
	 }


	 public function truncateFloat($number, $digitos)
	 {
    $raiz = 10;
    $multiplicador = pow ($raiz,$digitos);
    $resultado = ((int)($number * $multiplicador)) / $multiplicador;
    return number_format($resultado, $digitos);
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

		$result = $this->Student->finalizarCuestionario($user,$datos[0],$equipo);
		if ($result==0) {
			$calificar = $this->calificar($user,$equipo,$datos[0]);
			echo "La consulta se realizo exitosamente";
		}else {
			echo "Ocurrio un problema al guardar los datos en la Base de Datos";
		}

	 }


}
?>
