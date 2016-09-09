<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Estudiantes extends CI_Controller {
	function __construct()
   {

      parent::__construct();

  
      $this->load->model('user','',TRUE);
      $this->load->model('equipo','',TRUE);
      $this->load->model('modelo','',TRUE);
      $this->load->model('CuestionarioAdmin','',TRUE);
      $this->load->library('email','','correo');
			
   }

   public function nuevo(){
   	if($this->session->userdata('logged_in')){
         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
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
            redirect('Home', 'refresh');
         }
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
            $mensaje="<div class='alert alert-info fade in'>";
            $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
            $mensaje.="<strong>Estudiante guardado</strong>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }else{
            $mensaje="<div class='alert alert-danger fade in'>";
            $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
            $mensaje.="<strong>Estudiante No guardado</strong>";
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
         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
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
            $mensaje="<div class='alert alert-info fade in'>";
            $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
            $mensaje.="<strong>Estudiante Actualizado</strong>";
            $mensaje.="</div>";
            

            $this->session->set_flashdata('message', $mensaje);
         }else{
            $mensaje="<div class='alert alert-danger fade in'>";
            $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
            $mensaje.="<strong>No se pudo actualizar la información</strong>";
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
         $mensaje="<div class='alert alert-info fade in'>";
         $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
         $mensaje.="<strong>Usuario eliminado</strong>";
         $mensaje.="</div>";

         $this->session->set_flashdata('message', $mensaje);
      }else{
         $mensaje="<div class='alert alert-danger fade in'>";
         $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
         $mensaje.="<strong>Usuario no eliminado</strong>";
         $mensaje.="</div>";


         $this->session->set_flashdata('message', $mensaje);
      }
      redirect('Home/');
   }


   public function cambiarEquipo($id){
      if($this->session->userdata('logged_in')){
         $data = $this->session->userdata('logged_in');
         if(strcmp($data['rol'],"ADMINISTRADOR")==0){
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
            redirect('Home', 'refresh');   
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
         /*echo "id_usuario : ".$id_usuario."<br>";
         echo "id_equipo : ".$id_equipo."<br>";
         return;*/
         
         $result = $this->user->actualizarEquipo($id_equipo,$id_usuario);
         /*codigo para cambiar de equipo a un integrante y asignarle los cuationarios de su nuevo equipo*/
         //$cuestionarios_asignados = $this->CuestionarioAdmin->getCuestionariosInAssignment($id_equipo);
         //print_r($cuestionarios_asignados);
         //return;
         //foreach ($cuestionarios_asignados as $row) {
           //$this->CuestionarioAdmin->setAssignment($id_usuario,$row->questionary_id,$id_equipo);
         //}
      
         if($result){
            $mensaje="<div class='alert alert-info fade in'>";
            $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
            $mensaje.="<strong>Cambio de eqiupo exitoso</strong>";
            $mensaje.="</div>";


            $this->session->set_flashdata('message', $mensaje);
         }else{
            $mensaje="<div class='alert alert-danger fade in'>";
            $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
            $mensaje.="<strong>No se pudo cambiar de equipo</strong>";
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

   public function getEstudiantesById(){
      $id = $this->input->post('id');
      $data_estudiante = $this->user->getUsuarioById($id);
      $estudiante;
      foreach ($data_estudiante as $value) {
         $estudiante = array(
           'id' => $value->id,
           'username' => $value->username,
           'password' => $value->password,
           'email' => $value->email,
           'name' => $value->name,
           'rol_id' => $value->rol_id,
           'grupo' => $value->grupo,
           'team_id' => $value->team_id
         );
      }

      echo json_encode($estudiante);
   }

   public function sendMail(){
      if($this->session->userdata('logged_in')){
         $email = $this->input->post('email');
         $mensaje = $this->input->post('mensaje');

         $this->correo->from('mendezjunior2015@gmail.com', 'Ediel');
         $this->correo->to('mendezediel@gmail.com'); 
         $this->correo->subject('Esto es una prueba');
         $this->correo->message('Aqui va el cuerpo del mensaje');
         if($this->correo->send())
         {
            $mensaje="<div class='alert alert-warning fade in'>";
            $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
            $mensaje.="<strong>Mensaje Enviado</strong>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }
         else
         {
            //show_error($this->correo->print_debugger());
            $mensaje="<div class='alert alert-danger fade in'>";
            $mensaje.="<a href='#' class='close' data-dismiss='alert'>&times;</a>";
            $mensaje.="<strong>Mensaje No Enviado</strong>";
            $mensaje.="</div>";

            $this->session->set_flashdata('message', $mensaje);
         }
         redirect('Equipos/', 'refresh');
      }else{
         redirect('login', 'refresh');
      }
   }

   

}
?>
