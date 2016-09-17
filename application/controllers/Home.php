<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Home extends CI_Controller {

   function __construct()
   {

      parent::__construct();

      $this->load->model('modelo','',TRUE);
   }

   function index()
   {

      if($this->session->userdata('logged_in'))
      {

         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
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


            $this->load->view('admin_page',$datos_vista);
         }else{
            if(strcmp($data['rol'],"JEFE")==0){
               $this->load->view('jefe_page');
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
