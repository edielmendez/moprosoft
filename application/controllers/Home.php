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

               $this->load->view('estudiante_page');
            }
         }





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

}
 ?>
