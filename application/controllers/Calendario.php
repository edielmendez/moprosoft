<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Calendario extends CI_Controller {
	function __construct(){

      parent::__construct();

      $this->load->model('modelo','',TRUE);
      $this->load->model('user','',TRUE);
      $this->load->model('equipo','',TRUE);
      $this->load->model('CalendarModel','',TRUE);
      $this->load->model('CuestionarioAdmin','',TRUE);
      $this->load->helper('url');
   }

   public function modificar($id){
   	if($this->session->userdata('logged_in')){
   		$data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
         	$result = $this->equipo->getEquipoById($id);
         	if($result){
         		$equipo;
	            foreach ($result as $row) {
	               $equipo = array(
	                 'id' => $row->id,
	                 'name' => $row->name
	               );
	            }

               //obtenemos las actividades que estan en la tabla calificacion_questionary de este equipo
               $data_actividades = $this->CalendarModel->getAllActividadesInTableCalificacion($id);
               $AllActividades = array();
               if($data_actividades){
                  foreach ($data_actividades as $row) {
                     array_push($AllActividades, $row->id);
                  }
               }
               //obtenemos todas las actividades en seguimiento
               $data_actividades = $this->CalendarModel->getAllActividadesInTracing();
               $actividades_seguimiento = array();
               if($data_actividades){
                  foreach ($data_actividades as $row) {
                     
                     array_push($actividades_seguimiento, $row->calificacion_questionary_id);
                  }
               }

               //echo "<br>FASES TOTALES DE ESTE EQUIPO : <br>";
               //print_r($AllActividades);
               //echo "<br>FASES EN SEGUIMIENTO : <br>";
               //print_r($actividades_seguimiento);
               //echo "<br>OPERACIÓN : <br>";
               $ids_actividades_seguimiento = array_intersect($AllActividades, $actividades_seguimiento);
               //print_r($ids_actividades_seguimiento);
               //return;
               $array_fases = array();
               //obtenmos los ids de la tabla tracing
               $ids = array( );
               if($ids_actividades_seguimiento){
                  foreach ($ids_actividades_seguimiento as $value) {
                     $data = $this->CalendarModel->getTracingId($value);
                     foreach ($data as $key) {
                        array_push($ids,$key->tracing_id);
                     }
                  }
               }

               //echo "PRUEBA<br><br>";
               //print_r($ids);
               //echo "<br>SIN REPETIR<br><br>";
               $ids = array_unique($ids);
               //print_r($ids);

               foreach ($ids as $id) {
                  $data = $this->CalendarModel->getDataTableTracingById($id);
									if($data){
										foreach ($data as $key) {
	                     $data_fase = $this->CuestionarioAdmin->getFaseById($key->phase_objetive_id);
	                     $fase;
	                     $id_proceso;
	                     foreach ($data_fase as $value) {
	                        $fase = $value->name;
	                        $id_proceso = $value->process_id;
	                     }
	                     //obtenemos el nombre del proceso
	                     $data_proceso = $this->CuestionarioAdmin->getProcesoById($id_proceso);
	                     $proceso;
	                     foreach ($data_proceso as $value) {
	                        $proceso = $value->name;
	                     }
	                     $fase = array(
	                        'id' => $key->id,
	                        'phase_objetive_id' => $key->phase_objetive_id,
	                        'fase_objetivo' => $fase,
	                        'proceso' => $proceso,
	                        'fecha_inicio' => $key->date_start,
	                        'fecha_final' => $key->date_end,
	                     );
	                     array_push($array_fases,$fase);
	                  }
									}

               }

               //return;
               /*if($ids_actividades_seguimiento){
                  foreach ($ids_actividades_seguimiento as $id) {
                     $data = $this->CalendarModel->getDataActividad($id);
                     foreach ($data as $key) {
                        //obtenemos el nombre de la fase
                        $data_fase = $this->CuestionarioAdmin->getFaseById($key->phase_objetive_id);
                        $fase;
                        foreach ($data_fase as $value) {
                           $fase = $value->name;
                        }
                        //obtenemos el nombre del proceso
                        $data_proceso = $this->CuestionarioAdmin->getProcesoById($key->process_id);
                        $proceso;
                        foreach ($data_proceso as $value) {
                           $proceso = $value->name;
                        }
                        $actividad = array(
                           'id' => $key->id,
                           'process_id' => $key->process_id,
                           'phase_objetive_id' => $key->phase_objetive_id,
                           'process_id' => $key->process_id,
                           'question_id' => $key->question_id,
                           'fase_objetivo' => $fase,
                           'proceso' => $proceso
                        );
                        array_push($array_fases,$actividad);
                     }
                  }

               }*/

               //se renderizan los datos a la vista

	            $datos_vista['equipo'] = $equipo;
               $datos_vista['fases'] = $array_fases;
	            $this->load->view('evaluacion/modificar_calendario',$datos_vista);

         	}else{
         		redirect('Equipos', 'refresh');
         	}


         	//$this->load->view('evaluacion/index',$datos_vista);
         }else{
         	redirect('Home', 'refresh');
         }
   	}else{
   		redirect('Home', 'refresh');
   	}
   }


   public function getDataFaseInTableTracingById(){

      if($this->session->userdata('logged_in')){
         $id = $this->input->post('id');

         $data = $this->CalendarModel->getDataTableTracingById($id);
         $fase;
         foreach ($data as $row) {
            $fase = array(
               'id' => $row->id, 
               'phase_objetive_id' => $row->phase_objetive_id,
               'date_start' => $row->date_start,
               'date_end' => $row->date_end
            );
         }


         echo json_encode($fase);
      }else{
         redirect('Home', 'refresh');
      }
      
   }

   public function changeFechaFinal(){
      if($this->session->userdata('logged_in')){
         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){

            $id_tracing = $this->input->post('id_tracing');
            $fecha_final = $this->input->post('fecha_final');
            $id_equipo_hidden = $this->input->post('id_equipo_hidden');

            if($this->CalendarModel->updateFecha($id_tracing,$fecha_final)){
               $mensaje="<div class='alert alert-info fade in'>";
               $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
               $mensaje.="<strong>Fecha Actualizada</strong>";
               $mensaje.="</div>";

               $this->session->set_flashdata('message', $mensaje);

            }else{
               $mensaje="<div class='alert alert-danger fade in'>";
               $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
               $mensaje.="<strong>No Se Pudo Actualizar La Fecha/strong>";
               $mensaje.="</div>";

               $this->session->set_flashdata('message', $mensaje);
            }

            redirect('Calendario/modificar/'.$id_equipo_hidden, 'refresh');

            
         }else{
            redirect('Home', 'refresh');
         }
      }else{
         redirect('Home', 'refresh');
      }

   }
}
 ?>
