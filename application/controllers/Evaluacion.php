<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Evaluacion extends CI_Controller {

   function __construct()
   {

      parent::__construct();

      $this->load->model('modelo','',TRUE);
      $this->load->model('user','',TRUE);
      $this->load->model('equipo','',TRUE);
      $this->load->model('Questionary','',TRUE);
      $this->load->model('Question','',TRUE);
      $this->load->model('Phase','',TRUE);
      $this->load->model('CuestionarioAdmin','',TRUE);
      $this->load->helper('url');
      $this->load->library('session');
   }

   function index()
   {

      if($this->session->userdata('logged_in'))
      {

         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
            

            /*se obtienen todos los equipos creados hasta el momento
            */

            $result = $this->equipo->getEquipos();
            $equipos = array();
            if($result){

               foreach ($result as $row ) {

                  $equipo = array(
                    'id' => $row->id,
                    'name' => $row->name
                  );
                  $integrantes =  array();
                  $result2 = $result = $this->user->getByEquipo($row->id);
                  if($result2){

                     foreach ($result2 as $row2 ) {
                        $rol;
                        $result3 = $this->user->getRolUsuario($row2->rol_id);
                        foreach ($result3 as $row3) {
                          $rol = array(
                            'id' => $row3->id,
                            'type' => $row3->type
                          );
                          
                        }
                        $usuario = array(

                          'id' => $row2->id,
                          'username' => $row2->username,
                          'password' => $row2->password,
                          'email' => $row2->email,
                          'name' => $row2->name,
                          'rol_id' => $row2->rol_id,
                          'grupo' => $row2->grupo,
                          'rol' => $rol,
                          'team_id' => $row2->team_id
                        );
                        array_push($integrantes,$usuario);
                     }
                  }
                  $equipo['integrantes'] = $integrantes;
                  array_push($equipos,$equipo);
               }
            }

            /**
             * Se obtienen todos los procesos disponibles para ser aplicados
             */
            
            $result = $this->CuestionarioAdmin->getProcesosDisponibles();
            $procesos = array();
            $proceso = array();
            if($result){
               foreach ($result as $row ) {

                  $datos = array(
                     'id' => $row->id,
                     'name' => $row->name,
                     'status' => $row->status,
                     'model_id' => $row->model_id
                  );
                  $proceso['datos'] = $datos;

                  //$query = $this->CuestionarioAdmin->getTotalPreguntas($row->id);
                  //$total_preguntas;
                  //foreach ($query as $x) {
                     //$total_preguntas = $x->total;
                  //}

                  $aux = $this->CuestionarioAdmin->getModeloById($proceso['datos']['model_id']);
                  if($aux){
                     $modelo;
                     foreach ($aux as $row2) {
                        $modelo = array(
                           'id' => $row2->id,
                           'name' => $row2->name,
                           'version' => $row2->version, 
                           'phase_objetive' => $row2->phase_objetive,
                           'team_id' => $row2->team_id
                        );

                     }
                     $proceso['modelo'] = $modelo;

                     $aux2 = $this->CuestionarioAdmin->getEquipoById($modelo['team_id']);
                     if($aux2){
                        $equipo;
                        foreach ($aux2 as $row3) {
                           $equipo = array(
                             'id' => $row3->id,
                             'name' => $row3->name,
                           );
                        }
                        $proceso['equipo'] = $equipo;

                     }
               
                  }
                  
                   
                  array_push($procesos,$proceso);
                  
               }
            }

            /*se renderizan los datos a la vista*/

            
            $datos_vista['equipos'] = $equipos;
            $datos_vista['procesos'] = $procesos;

            $this->load->view('evaluacion/index',$datos_vista);

         }else{//
            redirect('Home', 'refresh');   
         }





      }else{
         //si no hay session se redirecciona la vista de login
         redirect('Home', 'refresh');
      }
   }


   public function getTeamsOnlyApplyForThisQuestionary(){
      $id_proceso = $this->input->post('id_proceso');
      $id_equipo = $this->input->post('id_equipo');

      //obtenemos todas las fases del proceso
      $query_fases = $this->Phase->getPhase_ProcessId($id_proceso);
      $fases = array();
      

      $result = $this->CuestionarioAdmin->getTeamsWithoutThisId($id_equipo);


      $equipos=array();
      if($result){

         foreach ($result as $row) {
            $b=1;
            $val = $this->CuestionarioAdmin->getUsersByIdTeam($row->id);
          
            if($val){
               foreach ($query_fases as $key ) {
                  
                  $data = $this->CuestionarioAdmin->getTeamsAssignment($row->id,$key->id);
                  if($data){
                     $b=0;

                     break;
                  }
               }
               
               if($b == 1){
                  $equipo = array(
                     'id' => $row->id,
                     'name' => $row->name,
                  );
                  array_push($equipos,$equipo);
               }
            }
            
            
         }
      }



      echo json_encode($equipos);



   }

   public function setCuestionarios(){
      if($this->session->userdata('logged_in')){
         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
            $teams = $this->input->post('equipo_eva');
            $id_proceso = $this->input->post('id_proceso');
            /*echo "equipos <br>";
            print_r($teams);
            echo "<br>proceso : ".$id_proceso."<br>";
            return;*/
            $mensaje;
            if(count($teams)==0){
               $mensaje.="<div class='alert alert-danger'>";
               $mensaje.="<span><b>No se seleccionaron equipos</b></span>";
               $mensaje.="</div>";

               $this->session->set_flashdata('message', $mensaje);
            }else{
               for ($i=0; $i < count($teams); $i++) {
                  $result = $this->CuestionarioAdmin->getUsersByIdTeam($teams[$i]);
                  if ($result) {
                     foreach ($result as $row) {
                        $query_fases = $this->Phase->getPhase_ProcessId($id_proceso);
                        foreach ($query_fases as $key) {
                           $this->CuestionarioAdmin->setAssignment($row->id,$key->id,$teams[$i]);   
                        }
                        
                     }
                  }else{
                     $mensaje.="<div class='alert alert-info'>";
                     $mensaje.="<span><b>No se pudo hacer la asignación porque el equipo no tiene integrantes !!</b></span>";
                     $mensaje.="</div>";
                     $this->session->set_flashdata('message', $mensaje);
                     redirect('Evaluacion/');
                  }
                  
               }

               $mensaje.="<div class='alert alert-info'>";
               $mensaje.="<span><b>Asignación echa</b></span>";
               $mensaje.="</div>";
               $this->session->set_flashdata('message', $mensaje);
            }
            redirect('Evaluacion/');
         }else{
            //si no hay session se redirecciona la vista de login
            redirect('Home', 'refresh');
         }  
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('Home', 'refresh');
      }  
      
   }

   public function detalles($id){
      if($this->session->userdata('logged_in')){
         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
            $aux = $this->equipo->getDataTeamInAssignment($id);
            /*obtenemos los datos del equipo*/
            if($aux){
               $result = $this->equipo->getEquipoById($id);
               $equipo;
               foreach ($result as $row) {
                  $equipo = array(
                    'id' => $row->id,
                    'name' => $row->name
                  );
               }
               
               
               ///obtenemos las fases asignados y terminados de este equipo

               
               $records = $this->CuestionarioAdmin->getFasesInAssignmentComplete($id);

               //obtenemos los integrantes de este equipo
               /*$data_est = $this->user->getByEquipo($id);
               foreach ($data_est as $rowx) {
                  $data_fase_completa_por_integrante = $this->CuestionarioAdmin->getPorcentajeDeAvanceDeFasePorUsuario($rowx->id);
               }*/

               $fases_terminadas = array();
               foreach ($records as $row) {


                  $data_fase= $this->Phase->getPhase($row->phase_objetive_id);
                  $fase;
                  foreach ($data_fase as $row2) {
                     $proceso;
                     $data_procesos = $this->CuestionarioAdmin->getProcesoById($row2->process_id);
                     foreach ($data_procesos as $key) {
                        $proceso = $key->name;
                     }
                     $fase= array(
                        'id' => $row2->id,
                        'name' => $row2->name,
                        'status' => $row2->status,
                        'process_id' => $row2->process_id,
                        'nombre_proceso' => $proceso
                     );

                  }

                  //se obtiene todas las preguntas del fase que estan indeterminadas
                  /*echo "equipo : ".$id."<br>";
                  echo "cuestionario : ".$row->questionary_id."<br>";
                  return;*/
                  $data = $this->CuestionarioAdmin->getQuestionsIndeterminate($id,$row->phase_objetive_id);
                  if($data){
                     $fase['show_results'] = "FALSE";
                  }else{
                     $fase['show_results'] = "TRUE";
                  }

                  array_push($fases_terminadas,$fase);




               }
               

               ////fin del código para obtener datos de los cuestionarios completos
               ///
               //// Código para verificar si ya se terminaron todos las fases de dos procesos o mas para 
               ///poder mostrar la grafica kiviat en la vista
               ///
               $data_procesos_in_calificacion = $this->CuestionarioAdmin->getProcesosInTableCalificacion($id);
               //print_r($data_procesos_in_calificacion);
               $datos['mostrar_kiviat'] = "TRUE";
               if(count($data_procesos_in_calificacion) >1){
                  foreach ($data_procesos_in_calificacion as $key) {
                     //obtenemos todas las fases de este proceso
                     $data_fases = $this->CuestionarioAdmin->getAllFasesByProcessId($key->process_id);
                     $temp = array( );
                     foreach ($data_fases as $row) {
                        array_push($temp,array('id' => $row->id ));
                     }
                     //echo "<br>FASES_TOTALES<br>";
                     //print_r($temp);
                     $data_fases_calificadas = $this->CuestionarioAdmin->getAllFasesByProcessIdCalificadas($key->process_id);
                     $temp2 = array( );
                     foreach ($data_fases_calificadas as $row) {
                        array_push($temp2,array('id' => $row->phase_objetive_id ));
                     }
                     //echo "<br>FASES_CALIFICADAS<br>";
                     //print_r($temp2);
                     //echo "merge : <br>";
                     //$resultado = var_dump($temp === $temp2);
                     //echo $resultado;
                     //print_r($resultado);
                     //
                     if(!($temp === $temp2)){
                        $datos['mostrar_kiviat'] = "FALSE";
                        break;
                     }
                     
                  }
               }else{
                  $datos['mostrar_kiviat'] = "FALSE";
               }
               
        
                
               


               /*obtenemos los fases a los que esta asignado este equipo pero que no estan terminados*/
               $result = $this->CuestionarioAdmin->getFasesInAssignment($id);
               $fases = array();
               if($result){

                  foreach ($result as $row) {
                     $data_fase = $this->Phase->getPhase($row->phase_objetive_id);
                     $fase;
                     foreach ($data_fase as $row2) {
                        
                        
                        $fase= array(
                           'id' => $row2->id,
                           'name' => $row2->name,
                           'status' => $row2->status,
                           'process_id' => $row2->process_id,
                        );

                     }


                     /*obtenemos el total de preguntas que tiene este cuestionario**/
                     $num_preguntas = $this->CuestionarioAdmin->getTotalPreguntas($row->phase_objetive_id);
                     
                    
                     foreach ($num_preguntas as $x) {
                        $num_preguntas = $x->total;
                     }


                     
                     
                    
                     /*obtenemos los integrantes de este equipo*/
                     $data_est = $this->user->getByEquipo($id);
                     $total_integrantes = count($data_est);
                     $estudiantes = array();
                     $cont=0;
                     foreach ($data_est as $rowx) {
                        $num_preguntas_contestadas = $this->CuestionarioAdmin->getTotalPreguntasContestadas($row->phase_objetive_id,$rowx->id);
                        foreach ($num_preguntas_contestadas as $x) {
                           $num_preguntas_contestadas = $x->total;
                        }
                        if($num_preguntas == 0){
                           $porcentaje = 0;
                        }else{
                           
                           $porcentaje = ( (intval($num_preguntas_contestadas) * 100) / intval($num_preguntas));
                           $porcentaje = round($porcentaje, 2);
                        }

                        
                        $usuario = array(
                          'id' => $rowx->id,
                          'username' => $rowx->username,
                          'password' => $rowx->password,
                          'email' => $rowx->email,
                          'name' => $rowx->name,
                          'rol_id' => $rowx->rol_id,
                          'grupo' => $rowx->grupo,
                          'team_id' => $rowx->team_id,
                          'preguntas_contestadas' => intval($num_preguntas_contestadas),
                          'porcentaje' => $porcentaje
                        );
                        if( (intval($num_preguntas) == intval($num_preguntas_contestadas)) && ($num_preguntas!=0) ){ 
                           $cont++;
                        }
                        array_push($estudiantes,$usuario);
                     }
                     $fase["integrantes"] = $estudiantes;
                     $fase["total_preguntas"] = $num_preguntas;
                     $fase["avance_por_equipo"] = round((($cont*100)/$total_integrantes));
                     
                     

                     array_push($fases,$fase);
                     
                     
                  }
               }
               
               $datos['equipo'] = $equipo;
               $datos['fases'] = $fases;
               $datos['fases_terminadas'] = $fases_terminadas;
               //$datos['estudiantes'] = $estudiantes;
               $this->load->view('evaluacion/detalles',$datos);
              
            }else{
               redirect('Equipos/', 'refresh');
            }
         }else{
            redirect('Home/', 'refresh');
         }
      }else{
         redirect('Home/', 'refresh');
      }
   }


   public function getResultadosEvaluation(){
      if($this->session->userdata('logged_in')){
         $id_fase = $this->input->post('id_fase');
         $id_equipo = $this->input->post('id_equipo');
         ///obtenenos los datos de la fase
         $data_fase = $this->Phase->getPhase($id_fase);

         $fase;
         foreach ($data_fase as $row) {
            $fase= array(
               'id' => $row->id,
               'name' => $row->name,
               'process_id' => $row->process_id,
            );

         }

         //obtenenos el proceso de este cuestionario
         $aux = $this->CuestionarioAdmin->getProcesoById($fase['process_id']);

         if($aux){
            $proceso;
            foreach ($aux as $row2) {
               $proceso = array(
                  'id' => $row2->id,
                  'name' => $row2->name,
                  'model_id' => $row2->model_id
               );

            }
            $fase['proceso'] = $proceso;

            //obtenenos el modelo de este cuestionario
            
            $aux2 = $this->CuestionarioAdmin->getModeloById($proceso['model_id']);
            if($aux2){
               $modelo;
               foreach ($aux2 as $row3) {
                  $modelo = array(
                     'id' => $row3->id,
                     'name' => $row3->name,
                     'version' => $row3->version, 
                     'cp' => $row3->cp,
                     'phase_objetive' => $row3->phase_objetive,
                     'team_id' => $row3->team_id
                  );

               }
               $fase['modelo'] = $modelo;
               

            
               
            
            }
               
         }

         //obtenemos los resultado de la tabla calificacion_questionary de este cuestionario
         $records = $this->CuestionarioAdmin->getResultadosEvaluation($id_fase,$id_equipo);
         $resultados = array();

         foreach ($records as $row) {
            $result= array(
               'id' => $row->id,
               'phase_objetive_id' => $row->phase_objetive_id,
               'question_id' => $row->question_id,
               'team_id' => $row->team_id,
               'S' => $row->S,
               'U' => $row->U,
               'A' => $row->A,
               'R' => $row->R,
               'N' => $row->N,
               'nivel_cobertura' => $row->nivel_cobertura,
               'media' => $row->media,
               'desviacion' => $row->desviacion,
               'valor' => $row->valor
            );
            array_push($resultados,$result);
         }

         $fase['resultados'] = $resultados;

         //retornamos los datos en formato json
         
         echo json_encode($fase);
         
         

            




         

      }else{
         redirect('Home/', 'refresh');
      }

   }



   public function edit_question($id_fase,$id_equipo){
      if($this->session->userdata('logged_in')){
         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
            $datos = $this->CuestionarioAdmin->getQuestionsIndeterminate($id_equipo,$id_fase);
            $questions_intederminate = array();
            
            if($datos){
               foreach ($datos as $key) {
                  
                  $data_question = $this->Question->getQuestion($key->question_id);
                  $question;
                  foreach ($data_question as $row) {
                     $question = array (
                        'id' => $row->id, 
                        'question' => $row->question,
                        'phase_objetive_id' => $row->phase_objetive_id
                     );
                  }
                  
                  array_push($questions_intederminate,$question);
                  
                  
               }

               $datos_vista['questions'] = $questions_intederminate;
               $datos_vista['id_equipo'] = $id_equipo;
               $this->load->view('evaluacion/edit_question_indeterminate',$datos_vista);

            }else{

               $mensaje="<div class='alert alert-info fade in'>";
               $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
               $mensaje.="<strong>Todas las preguntas han sido corregidas</strong>";
               $mensaje.="</div>";

               $this->session->set_flashdata('message', $mensaje);
               redirect('Evaluacion/detalles/'.$id_equipo, 'refresh');
            }


         }else{
            redirect('Home/', 'refresh');
         }

      }else{
         redirect('Home/', 'refresh');
      }
   }

   public function change_valor_question(){
      if($this->session->userdata('logged_in')){
         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
            $id_equipo = $this->input->post('id_equipo');
            $id_fase = $this->input->post('id_fase');
            $id_pregunta = $this->input->post('id_pregunta');
            $valor = $this->input->post('pregunta');
            
            

            if ($this->CuestionarioAdmin->setValueQuestionIndeterminate($id_equipo,$id_fase,$id_pregunta,$valor)) {

               $mensaje="<div class='alert alert-info fade in'>";
               $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
               $mensaje.="<strong>Echo </strong> Pregunta actualizada.";
               $mensaje.="</div>";

               $this->session->set_flashdata('message', $mensaje);
            }else{
               $mensaje="<div class='alert alert-warning fade in'>";
               $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
               $mensaje.="<strong>Error </strong> Pregunta No actualizada.";
               $mensaje.="</div>";

               $this->session->set_flashdata('message', $mensaje);
              
            }

            redirect('Evaluacion/edit_question/'.$id_fase."/".$id_equipo, 'refresh');
            
         }else{
            redirect('Home/', 'refresh');
         }
      }else{
         redirect('Home/', 'refresh');
      }
   }

   public function getPorcentajePorProceso(){
      if($this->session->userdata('logged_in')){
         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
            $id = $this->input->post('id_equipo');
            $data_procesos_in_calificacion = $this->CuestionarioAdmin->getProcesosInTableCalificacion($id);
            //print_r($data_procesos_in_calificacion);
            $json = array( );
            if(count($data_procesos_in_calificacion) >1){
               foreach ($data_procesos_in_calificacion as $key) {
                  
                  $data_fases_calificadas = $this->CuestionarioAdmin->getAllDataFasesByProcessId($key->process_id);
                 
                  $suma = 0;
                  foreach ($data_fases_calificadas as $row) {
                     $suma+=intval($row->nivel_cobertura);
                  }
                  $data_proceso = $this->CuestionarioAdmin->getProcesoById($key->process_id);
                  $proceso;
                  foreach ($data_proceso as $value) {
                     $proceso = array(
                        'id' => $value->id,
                        'name' => $value->name,
                        'nivel_cobertura' => round(floatval($suma/count($data_fases_calificadas)))
                     ); 
                  }
                  
                  array_push($json,$proceso);
                 
                  
               }
              echo  json_encode($json);
            }else{
               echo "SIN PROCESOS";
            }
         }else{
            redirect('Home/', 'refresh');
         }
      }else{
         redirect('Home/', 'refresh');
      }
   }


   
   

}
 ?>
