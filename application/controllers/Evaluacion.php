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
      $this->load->model('CuestionarioAdmin','',TRUE);
      $this->load->helper('url');
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
             * Se obtienen todos los cuestionarios disponibles
             */
            
            $result = $this->CuestionarioAdmin->get();
            $cuestionarios = array();
            if($result){
               foreach ($result as $row ) {

                  $datos = array(
                     'id' => $row->id,
                     'name' => $row->name,
                     'phase_objetive_id' => $row->phase_objetive_id
                  );
                  $cuestionario['datos'] = $datos;

                  $query = $this->CuestionarioAdmin->getTotalPreguntas($row->id);
                  $total_preguntas;
                  foreach ($query as $x) {
                     $total_preguntas = $x->total;
                  }

                  $aux = $this->CuestionarioAdmin->getFaseById($row->phase_objetive_id);
                  if($aux){
                     $fase;
                     foreach ($aux as $row2) {
                        $fase = array(
                           'id' => $row2->id,
                           'name' => $row2->name,
                           'process_id' => $row2->process_id
                        );

                     }
                     $cuestionario['fase'] = $fase;

                     $aux2 = $this->CuestionarioAdmin->getProcesoById($fase['process_id']);
                     if($aux2){
                        $proceso;
                        foreach ($aux2 as $row3) {
                           $proceso = array(
                              'id' => $row3->id,
                              'name' => $row3->name,
                              'model_id' => $row3->model_id
                           );

                        }
                        $cuestionario['proceso'] = $proceso;

                        $aux3 = $this->CuestionarioAdmin->getModeloById($proceso['model_id']);
                        if($aux3){
                           $modelo;
                           foreach ($aux3 as $row4) {
                              $modelo = array(
                                 'id' => $row4->id,
                                 'name' => $row4->name,
                                 'version' => $row4->version, 
                                 'phase_objetive' => $row4->phase_objetive,
                                 'team_id' => $row4->team_id
                              );

                           }
                           $cuestionario['modelo'] = $modelo;

                           $aux4 = $this->CuestionarioAdmin->getEquipoById($modelo['team_id']);
                           if($aux4){
                              $equipo;
                              foreach ($aux4 as $row5) {
                                 $equipo = array(
                                   'id' => $row5->id,
                                   'name' => $row5->name,
                                 );

                              }
                              $cuestionario['equipo'] = $equipo;

                              
                     
                           }
                     
                        }
                     
                     }
                        
                  }
                   
                  if($total_preguntas != 0){
                     array_push($cuestionarios,$cuestionario);
                  } 
                   
                  
                  
               }
            }

            /*se renderizan los datos a la vista*/

            
            $datos_vista['equipos'] = $equipos;
            $datos_vista['cuestionarios'] = $cuestionarios;

            $this->load->view('evaluacion/index',$datos_vista);

         }else{//
            redirect('Home', 'refresh');   
         }





      }else{
         //si no hay session se redirecciona la vista de login
         redirect('Home', 'refresh');
      }
   }


   public function getTeamsOnlyApplyForThisQuuestionary(){
      $id_cuestionario = $this->input->post('id_cuestionario');
      $id_equipo = $this->input->post('id_equipo');

      $result = $this->CuestionarioAdmin->getTeamsWithoutThisId($id_equipo);
      $equipos=array();
      if($result){

         foreach ($result as $row) {
            $data = $this->CuestionarioAdmin->getTeamsAssignment($row->id,$id_cuestionario);
            if(!$data){
               $equipo = array(
                  'id' => $row->id,
                  'name' => $row->name,
               );
               array_push($equipos,$equipo);
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
            $id_cuestionario = $this->input->post('id_cuestionario');
            /*echo "equipos <br>";
            print_r($teams);
            echo "<br>cuestionario : ".$id_cuestionario."<br>";
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
                        $this->CuestionarioAdmin->setAssignment($row->id,$id_cuestionario,$teams[$i]);
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
               
               



               /*obtenemos los cuestionarios a los que esta asignado este equipo*/
               $result = $this->CuestionarioAdmin->getCuestionariosInAssignment($id);
               $cuestionarios = array();
               foreach ($result as $row) {
                  $data_cuestionario = $this->Questionary->getQ($row->questionary_id);
                  $cuestionario;
                  foreach ($data_cuestionario as $row2) {
                     
                     
                     $cuestionario= array(
                        'id' => $row2->id,
                        'name' => $row2->name,
                        'phase_objetive_id' => $row2->phase_objetive_id,
                     );

                  }

                  

                  $num_preguntas = $this->CuestionarioAdmin->getTotalPreguntas($row->questionary_id);
                  
                 
                  foreach ($num_preguntas as $x) {
                     $num_preguntas = $x->total;
                  }


                  
                  
                 
                  /*obtenemos los integrantes de este equipo*/
                  $data_est = $this->user->getByEquipo($id);
                  $total_integrantes = count($data_est);
                  $estudiantes = array();
                  $cont=0;
                  foreach ($data_est as $rowx) {
                     $num_preguntas_contestadas = $this->CuestionarioAdmin->getTotalPreguntasContestadas($row->questionary_id,$rowx->id);
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
                  $cuestionario["integrantes"] = $estudiantes;
                  $cuestionario["total_preguntas"] = $num_preguntas;
                  $cuestionario["avance_por_equipo"] = round((($cont*100)/$total_integrantes));
                  
                  

                  array_push($cuestionarios,$cuestionario);
                  
                  
               }
               $datos['equipo'] = $equipo;
               $datos['cuestionarios'] = $cuestionarios;               
               //$datos['estudiantes'] = $estudiantes;
               $this->load->view('evaluacion/detalles',$datos);
            }else{
               redirect('Equipos/', 'refresh');
            }
         }else{
            redirect('Home/', 'refresh');
         }
      }else{
         redirect('Home', 'refresh');
      }
   }




   /**
    * ************************************************************************************************************************
    */


   function getEquipoById(){
      if($this->session->userdata('logged_in')){
         $id = $this->input->post('id');
         $result = $this->equipo->getEquipoById($id);

         if ($result) {
            # code...
            $equipo;
            foreach ($result as $row ) {
               $equipo = array(
                 'id' => $row->id,
                 'name' => $row->name,
               );
               
            }
         }

         echo json_encode($equipo);

      }
   }

   public function actualizar(){
      if($this->session->userdata('logged_in')){
         $id = $this->input->post('id');
         $nombre = $this->input->post('nombre');
         
         
         $result = $this->equipo->actualizar($nombre,$id);
      
         if($result){
            
            $mensaje.="<div class='alert alert-info'>";
               $mensaje.="<span><b>Equipo Actualizado</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }else{

            $mensaje.="<div class='alert alert-danger'>";
               $mensaje.="<span><b>No se pudo actualizar la información</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
            
         }
         redirect('Equipos/');
         
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

   public function nuevo(){
      if($this->session->userdata('logged_in')){
         /*$result = $this->equipo->getEquipos();
         $equipos = array();
         if($result){
            foreach ($result as $row ) {
               $equipo = array(
                 'id' => $row->id,
                 'name' => $row->name
               );
               array_push($equipos,$equipo);
            }
         }
         $datos['equipos'] = $equipos;*/
         $this->load->view('nuevo_equipo');

      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

   public function crear_equipo(){
      if($this->session->userdata('logged_in')){
         $nombre = $this->input->post('nombre');
       

         
         $result = $this->equipo->crearEquipo($nombre);
      
         if($result){
            
            $mensaje.="<div class='alert alert-info'>";
               $mensaje.="<span><b>Equipo creado</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }else{

            $mensaje.="<div class='alert alert-danger'>";
               $mensaje.="<span><b>Equipo No creado</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
            
         }
         redirect('Equipos/');
         
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }


   public function agregar_miembros($id){
      if($this->session->userdata('logged_in')){

         $result = $this->user->getUsuarioEmpty();

         print_r($result);
         return;
         if($result){
            $estudiante;
            foreach ($result as $row ) {
               $estudiante = array(
                 'id' => $row->id,
                 'username' => $row->username,
                 'password' => $row->password,
                 'email' => $row->email,
                 'name' => $row->name,
                 'rol_id' => $row->rol_id,
                 'grupo' => $row->grupo,
                 'team_id' => $row->team_id
               );
               
            }
            $result = $this->equipo->getEquipos();
            $equipos = array();
            if($result){
               foreach ($result as $row ) {
                  $equipo = array(
                    'id' => $row->id,
                    'name' => $row->name
                  );
                  array_push($equipos,$equipo);
               }
            }
            /*se obtiene los datos del estudiante a actualizar*/

            
            $datos['equipos'] = $equipos;
            $datos['estudiante'] = $estudiante;
            $this->load->view('edit_estudiante',$datos);

         }else{
            redirect('Equipos', 'refresh');
         }
         

         
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

   public function actualizar_jefe(){
      if($this->session->userdata('logged_in')){
         $id = $this->input->post('id_usuario');
         $jefe_ant = $this->input->post('id_jefe_ant'); 
         /*se cambia al alterior jefe*/
  
         $result = $this->user->quitarRolJefe($jefe_ant);
       
         $result = $this->user->actualizarRol($id);
      
         if($result){
            
            $mensaje.="<div class='alert alert-info'>";
               $mensaje.="<span><b>Cambio de jefe de equipo echo</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }else{

            $mensaje.="<div class='alert alert-danger'>";
               $mensaje.="<span><b>No se pudo cambiar de jefe de equipo</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
            
         }
         redirect('Equipos/');
         
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

   public function set_jefe(){
      if($this->session->userdata('logged_in')){
         $id = $this->input->post('id_usuario');
       
         $result = $this->user->setRolJefe($id);
      
         if($result){
            
            $mensaje.="<div class='alert alert-info'>";
               $mensaje.="<span><b>Se agrego jefe de equipo</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }else{

            $mensaje.="<div class='alert alert-danger'>";
               $mensaje.="<span><b>No se pudo agregar jefe de equipo</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
            
         }
         redirect('Equipos/');
         
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

   public function eliminar($id){
      if($this->session->userdata('logged_in')){
         $result = $this->equipo->delete($id); 

         if($result){
            $mensaje.="<div class='alert alert-info'>";
               $mensaje.="<span><b>Equipo eliminado</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }else{
            $mensaje.="<div class='alert alert-danger'>";
               $mensaje.="<span><b>No se pudo eliminar el equipo</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }

         redirect('Equipos/');
      }else{
         redirect('login', 'refresh');  
      }
   }
   

}
 ?>
