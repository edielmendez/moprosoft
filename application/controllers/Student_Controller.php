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
			 $result = $this->Student->Phase_Historial($data['id']);

			 $Questionary = array();
				if($result){
					 foreach ($result as $row ) {
							$questionary = array(
								'phase' => $row->phase,
								'process' => $row->process,
								'model' => $row->model,
                'f' => $row->f,
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

     $datos_vista['cuestionarios'] = $Questionary;
     $datos_vista['nuevo'] = $nuevos;
     $datos_vista['pendientes'] = $pendientes;
     $this->load->view('students/index',$datos_vista);
   }

   public function Contestar($id)
   {
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
							 'answer_id' => $row->answer_id,
							 'commentary' => $row->commentary,
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
					$cp=$res=$this->Student->getCP($user,$equipo,$cuestionario);
					echo "Esto es el CP:$cp";
					foreach ($Preguntas as $row) {
						$calificar = $this->calificarPregunta(sizeof($Usuarios),$equipo,$cuestionario,$row['id'],$row['siempre'],$row['usualmente'],$row['aveces'],$row['rara'],$row['nunca'],$cp);
					}
          //Se añade codigo para sacar resultados de la calificación

    			$result = $this->modelo->getResultado_phase($this->session->userdata('logged_in')['team_id'],$cuestionario);

          $suma=0;
          $contador=0;
          if ($result) {
            foreach ($result as $row) {
              	$suma=$suma+$row->nivel_cobertura;
                $contador++;
            }
            //$namePhase = $this->modelo->getNamePhase($cuestionario);
            $nameModel = $this->modelo->getNameModel($cuestionario);
            //$nameProcess = $this->modelo->getNameProcess($cuestionario);
						$IDProcess = $this->modelo->getIdProcess($cuestionario);
						$IDModel = $this->modelo->getIdModel($cuestionario);
            $cp = $this->modelo->getNameProcessPorcentaje($nameModel);
						$bandera=0;
						if (round($suma/$contador,0)==100) {
							$bandera=1;
						}
            $guardar = $this->modelo->save_result_team($IDModel,$IDProcess,$cuestionario,round($suma/$contador,0),$cp,$this->session->userdata('logged_in')['team_id'],$bandera);
          }

          			/*$Resultado = array();

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
          								$Seguimiento = $this->modelo->ExisteSeguimiento($questionary);
          								$historial = $this->modelo->historial_seguimineto($questionary);
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
          					$Seguimiento = $this->modelo->ExisteSeguimiento($questionary);
          					$historial = $this->modelo->historial_seguimineto($questionary);
          					$nameModel = $this->modelo->getNameModel($questionary);
          					$nameProcess = $this->modelo->getNameProcess($questionary);
          					$cp = $this->modelo->getNameProcessPorcentaje($nameModel);
          					array_push($Resultado,array($name,$questionary,round($suma/$contador,0),$nameModel,$nameProcess,$cp,$Seguimiento,$historial,$termino_phase) );
          			 }*/

          			//$datos['cuestionarios']=$Resultado;
          			//$datos['equipos']=$Equipos;
             		//$this->load->view('questionnaires_jefe/resultado',$datos);
			 }
	 }

	 public function calificarPregunta($tpe,$equipo,$cuestionario,$question_id,$siempre,$usualmente,$aveces,$rara,$nunca,$cp)
	 {
		 $cobertura=( ($siempre*1)+($usualmente*0.75)+($aveces*0.5)+($rara*0.25)+($nunca*0) )/$tpe;
		 $media=( ($siempre*4)+($usualmente*3)+($aveces*2)+($rara*1)+($nunca*0) )/$tpe;
		 $desviacion=sqrt(  ($tpe*( (pow(4,2)*$siempre)+(pow(3,2)*$usualmente)+(pow(2,2)*$aveces)+(pow(1,2)*$rara)  )-pow($tpe,2)*pow($media,2) )/ pow($tpe,2) );

		 //Se redondean para que solo tengan un decimal. ejemplo 2.8 no 2.8354
		 $cobertura=$cobertura*100;
		 $cobertura=intval($cobertura);
		 $media=$this->truncateFloat($media,1);
		 $desviacion=$this->truncateFloat($desviacion,1);
		 $PuntoDebilFuerte="ninguno";

		 if ($cobertura<$cp) {
		 	$PuntoDebilFuerte='debil';
		 }

		 if ($cobertura>50) {
				if ($desviacion<0.8) {
					$PuntoDebilFuerte='fuerte';
				}elseif ($desviacion>=0.8) {
					$PuntoDebilFuerte='indeterminado';
				}
		 }
		 echo "Punto es : $PuntoDebilFuerte";
		 $add=$this->Student->addCalificacion($equipo,$cuestionario,$question_id,$siempre,$usualmente,$aveces,$rara,$nunca,$cobertura,$media,$desviacion,$PuntoDebilFuerte);
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
      $datos_historial=$this->Student->get_model_process($datos[0]);
      $res = $this->Student->save_historial($user,$datos_historial[0],$datos_historial[1],$datos_historial[2]);
			echo "La consulta se realizo exitosamente";
		}else {
			echo "Ocurrio un problema al guardar los datos en la Base de Datos";
		}

	 }


}
?>
