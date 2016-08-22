<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Home extends CI_Controller {

   function __construct()
   {

      parent::__construct();

      $this->load->model('modelo','',TRUE);
      $this->load->model('user','',TRUE);
      $this->load->model('equipo','',TRUE);
       $this->load->helper('url');
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


               $this->load->view('jefe_page',$datos_vista);

            }else{
               /*$result = $this->modelo->getModels($data['team_id']);
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
               $this->load->view('students/index',$datos_vista);*/
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
