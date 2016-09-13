<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Home extends CI_Controller {

   function __construct()
   {

      parent::__construct();

      $this->load->model('modelo','',TRUE);
      $this->load->model('user','',TRUE);
      $this->load->model('equipo','',TRUE);
      $this->load->model('Validate','',TRUE);
       $this->load->helper('url');
   }


   //funcion que cambiara los status de los seguiminetos segun sea el caso
   /*public function check_status_tracing(){
      if($this->session->userdata('logged_in')){

        $tracing = $this->Validate->getTracingValid();
        if ($tracing) {
          foreach ($tracing as $key) {
            //comparo si aun es vigente
            $bandera = $this->Validate->strcmp_date($key->date_end);
            if ($bandera) {
              //actualizo la vigencia de ¿l seguiminetos
              $this->Validate->update_tracing_status($key->id);
              //obtengo los seguimientos
              $tracing_calificacion=$this->Validate->getTracing_calification_questionary($key->id);
              //auxiliares para editar la diferencia de dias
              $ultima_fecha='';

              foreach ($tracing_calificacion as $key2) {

                $this->Validate->update_calification_questionary_bandera($key2->calificacion_questionary_id);
                $ultima_fecha=$key2->date_end;
              }
              //Se actualiza la diferencia de dias
              $this->Validate->update_tracing_diferencia_dias($key->id,$key->date_end,$ultima_fecha);
            }

          }
        }
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }*/

   public function check_status_historial()
   {
     $equipo=$this->session->userdata('logged_in')['team_id'];
     $historial = $this->Validate->get_historial_result();
     if ($historial) {
       foreach ($historial as $row) {
         $termino_phase = $this->Validate->check_finish_phase($row->phase,$equipo);
         if ($termino_phase==1) {
           $upate = $this->Validate->update_historial_result($row->id);
         }
       }
     }

   }

   public function check_status_tracing(){
      if($this->session->userdata('logged_in')){

        $tracing = $this->Validate->getTracingValid();
        if ($tracing) {
          foreach ($tracing as $key) {
            //obtengo los seguimientos
            $tracing_calificacion=$this->Validate->getTracing_calification_questionary($key->id);
            $ultima_fecha='';
            foreach ($tracing_calificacion as $key2) {
              $ultima_fecha=$key2->date_end;
            }
            //comparo si aun es vigente
            $bandera = $this->Validate->strcmp_date($ultima_fecha);
            if ($bandera) {
              //actualizo la vigencia del seguiminetos
              $this->Validate->update_tracing_status($key->id);

              //obtengo los seguimientos
              $tracing_calificacion2=$this->Validate->getTracing_calification_questionary($key->id);

              foreach ($tracing_calificacion2 as $key2) {
                $this->Validate->update_calification_questionary_bandera($key2->calificacion_questionary_id);
              }
              //Se actualiza la diferencia de dias
              $this->Validate->update_tracing_diferencia_dias($key->id,$key->date_end,$ultima_fecha);
            }

          }
        }
        //checar si ya se termino una fase y actualizarlo en el historial
        $this->check_status_historial();

      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }



   function index()
   {

      if($this->session->userdata('logged_in'))
      {
         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
            /*se obtienen todos los usuarios del sistema*/
            $result = $this->user->getUsers();
            $usuarios = array();
            if($result){

               foreach ($result as $row ) {

                  $usuario = array(
                    'id' => $row->id,
                    'username' => $row->username,
                    'password' => $row->password,
                    'email' => $row->email,
                    'name' => $row->name,
                    'rol_id' => $row->rol_id,
                    'grupo' => $row->grupo,
                    'team_id' => $row->team_id
                  );
                  array_push($usuarios,$usuario);
               }
            }
            /**/

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

                        $usuario = array(
                          'id' => $row2->id,
                          'username' => $row2->username,
                          'password' => $row2->password,
                          'email' => $row2->email,
                          'name' => $row->name,
                          'rol_id' => $row2->rol_id,
                          'grupo' => $row2->grupo,
                          'team_id' => $row2->team_id
                        );
                        array_push($integrantes,$usuario);
                     }
                  }
                  $equipo['integrantes'] = $integrantes;
                  array_push($equipos,$equipo);
               }
            }

            /*se renderizan los datos a la vista*/

            $datos_vista['usuarios'] = $usuarios;
            $datos_vista['equipos'] = $equipos;


            $this->load->view('admin_page',$datos_vista);

         }else{
            if(strcmp($data['rol'],"JEFE")==0){
               $result = $this->modelo->getModels($data['team_id']);
               $modelos = array();
               if($result){

                  foreach ($result as $row ) {

                     $modelo = array(
                       'id' => $row->id,
                       'name' => $row->name,
                       'version' => $row->version,
                       'level' => $row->level,
                       'phase_objetive' => $row->phase_objetive,
                       'team_id' => $row->team_id,
                     );
                     array_push($modelos,$modelo);
                  }
               }

               $datos_vista['modelos'] = $modelos;
               ///////////////////////////////////
               //Aqui se agrega la validación;
               $this->check_status_tracing();
               //////////////////////////////////
               $this->load->view('jefe_page',$datos_vista);

            }else{

              redirect('Student_Controller', 'refresh');
            }
         }





      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

   public function equipos(){
      if($this->session->userdata('logged_in')){

      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

   function logout()
   {
      $this->session->unset_userdata('logged_in');
      session_destroy();
      redirect('home', 'refresh');
   }

   public function perfil(){
      if($this->session->userdata('logged_in')){
         $this->load->view('users/perfil');
      }else{
         redirect('login', 'refresh');
      }
   }

   public function update_perfil(){
      if($this->session->userdata('logged_in')){
         $id = $this->input->post('id');
         $username = $this->input->post('username');
         $password = $this->input->post('password');
         $email = $this->input->post('email');

         if(trim($password," ") == ''){
            $result = $this->user->actualizarPerfilSinPassword($username,$email,$id);
         }else{
            $result = $this->user->actualizarPerfil($username,$password,$email,$id);
         }
         if($result){
            /*
            $mensaje.="<div class='alert alert-info'>";
               $mensaje.="<span><b>Perfil actualizado , inicie sesión otra vez</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
            $this->session->unset_userdata('logged_in');
            session_destroy();*/
            redirect('Home/logout');
         }else{

            $mensaje.="<div class='alert alert-danger'>";
            $mensaje.="<span><b>No se actualizo el perfil</b></span>";
            $mensaje.="</div>";
            $this->session->set_flashdata('message', $mensaje);
            redirect('Home/');
         }
      }else{
         redirect('login', 'refresh');
      }
   }

   public function email(){
      $this->load->library('email');

      $this->email->from('mendezediel@gmail.com', 'Ediel');
      $this->email->to('mendezjunior2015@gmail.com');


      $this->email->subject('Email Test');
      $this->email->message('Testing the email class.');

      $a = $this->email->send();
      echo $a;
   }

}
 ?>
