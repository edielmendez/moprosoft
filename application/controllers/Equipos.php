<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Equipos extends CI_Controller {

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
                  $aux = $this->equipo->getDataTeamInAssignment($row->id);
                  if($aux){
                     $equipo['estadistica'] = "con";
                  }else{
                     $equipo['estadistica'] = "sin";
                  }
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

            /*se renderizan los datos a la vista*/

            
            $datos_vista['equipos'] = $equipos;


            $this->load->view('equipos_page',$datos_vista);

         }else{//
            
         }





      }else{
         //si no hay session se redirecciona la vista de login
         redirect('Home', 'refresh');
      }
   }


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
            $mensaje="<div class='alert alert-danger fade in'>";
            $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
            $mensaje.="<strong>No se pudo actualizar la información</strong>";
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
