<?php
//Controlador Proceso
defined('BASEPATH') OR exit('No direct script access allowed');
class student_Controller extends CI_Controller {

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
      

      $datos_vista['cuestionario'] = $Questionary;
      $this->load->view('students/contestar_preguntas',$datos_vista);
   }


}
?>
