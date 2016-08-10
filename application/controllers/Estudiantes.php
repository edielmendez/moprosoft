<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Estudiantes extends CI_Controller {
	function __construct()
   {

      parent::__construct();

  
      $this->load->model('user','',TRUE);
      $this->load->model('equipo','',TRUE);
      $this->load->model('modelo','',TRUE);
			
   }

   public function nuevo(){
   	if($this->session->userdata('logged_in')){
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
         $datos['equipos'] = $equipos;
   		$this->load->view('nuevo_estudiante',$datos);

   	}else{
   		//si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
   	}
   }

   public function crear_usuario(){
      if($this->session->userdata('logged_in')){
         $username = $this->input->post('username');
         $password = $this->input->post('password');
         $email = $this->input->post('email');
         $name = $this->input->post('nombre');
         $grupo = $this->input->post('grupo');
         $team_id = $this->input->post('equipo');

       

         
         $result = $this->user->crearUsuario($username,$password,$email,$name,$grupo,$team_id);
      
         if($result){
            
            $mensaje.="<div class='alert alert-info'>";
               $mensaje.="<span><b>Estudiante guardado</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }else{

            $mensaje.="<div class='alert alert-danger'>";
               $mensaje.="<span><b>Estudiante No guardado</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
            
         }
         redirect('Home/');
         
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

   /**
    * [validarUsername funcion que valida el username de un nuevo usuario para que no se repita]
    * @return [boolen] [description]
    */
   public function validarUsername(){
      $username = $this->input->post('username');

      $result = $this->user->getUsuarioByUsername($username);

      if($result){
         echo "FALSE";
      }else{
         echo "TRUE";
      }
   }

   public function validarUsernameActualizar(){
      $username = $this->input->post('username');
      $id = $this->input->post('id');
      $result = $this->user->getUsuarioByUsername($username);

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
         if ($estudiante['id'] != $id) {
            echo "FALSE";
         }else{
            echo "TRUE";   
         }
         
      }else{
         echo "TRUE";
      }
   }

   

   public function edit($id){
      if($this->session->userdata('logged_in')){

         $result = $this->user->getUsuarioById($id);
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
            redirect('Home', 'refresh');
         }
         

         
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }


   public function actualizar(){
      if($this->session->userdata('logged_in')){
         $id = $this->input->post('id');
         $username = $this->input->post('username');
         //$password = $this->input->post('password');
         $email = $this->input->post('email');
         $name = $this->input->post('nombre');
         $grupo = $this->input->post('grupo');
         //$team_id = $this->input->post('equipo');

       

         
         $result = $this->user->actualizar($username,$email,$name,$grupo,$id);
      
         if($result){
            
            $mensaje.="<div class='alert alert-info'>";
               $mensaje.="<span><b>Estudiante Actualizado</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }else{

            $mensaje.="<div class='alert alert-danger'>";
               $mensaje.="<span><b>No se pudo actualizar la información</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
            
         }
         redirect('Home/');
         
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

   public function eliminar($id){
      $result = $this->user->delete($id); 

      if($result){
         $mensaje.="<div class='alert alert-info'>";
            $mensaje.="<span><b>Usuario eliminado</b></span>";
         $mensaje.="</div>";

         $this->session->set_flashdata('message', $mensaje);
      }else{
         $mensaje.="<div class='alert alert-danger'>";
            $mensaje.="<span><b>Usuario no eliminado</b></span>";
         $mensaje.="</div>";

         $this->session->set_flashdata('message', $mensaje);
      }
      redirect('Home/');
   }


   public function cambiarEquipo($id){
      if($this->session->userdata('logged_in')){
         $result = $this->user->getUsuarioById($id);
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
            $datos['equipos'] = $equipos;
            $datos['estudiante'] = $estudiante;
            $this->load->view('cambiar_equipo',$datos);
         }else{
            redirect('Equipos/');
         }
         

      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

   public function cambiar_equipo(){
      if($this->session->userdata('logged_in')){
         $id_usuario = $this->input->post('id_usuario');
         $id_equipo = $this->input->post('id_equipo');
         
         $result = $this->user->actualizarEquipo($id_equipo,$id_usuario);
      
         if($result){
            
            $mensaje.="<div class='alert alert-info'>";
               $mensaje.="<span><b>Cambio de eqiupo exitoso</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }else{

            $mensaje.="<div class='alert alert-danger'>";
               $mensaje.="<span><b>No se pudo cambiar de equipo</b></span>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
            
         }
         redirect('Equipos/');
         
      }else{
         //si no hay session se redirecciona la vista de login
         redirect('login', 'refresh');
      }
   }

   function getEstudiantesByEquipo(){
      if($this->session->userdata('logged_in')){
         $id = $this->input->post('id');
         $result = $this->user->getByEquipo($id);
         $usuarios=array();
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

         echo json_encode($usuarios);

      }
   }

   

}
?>
