<?php
/**
 *
 */
class User extends CI_Model
{
  function login($username,$password){

     $this -> db -> select('*');
     $this-> db-> from('user');
     $this-> db-> where('username', $username);
     $this -> db -> where('password', MD5($password));
     $this -> db -> limit(1);

     $query = $this -> db -> get();

     if($query -> num_rows() == 1)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
  }

  public function getRol($rol_id){

      $this -> db -> select('*');
      $this-> db-> from('rol');
      $this-> db-> where('id', $rol_id);

      $this -> db -> limit(1);

      $query = $this -> db -> get();

      if($query -> num_rows() == 1)
      {
         return $query->result();
      }
      else
      {
         return false;
      }
  }

   public function getUsers(){
      $this->db->select('*');
      $this->db->from('user');

      $query = $this->db->get();

      if($query -> num_rows() >= 1){
         
         return $query->result();
      }
      else{
         return false;
      }

   }

   public function getByEquipo($team_id){
      $this->db->select('*');
      $this->db->from('user');
      $this->db->where('team_id',$team_id);
      $this->db->where('id != ',1);
      $query = $this->db->get();
      if($query->num_rows() >= 1){
         return $query->result();
      }
      else{
         return false;
      }
   }

   public function crearUsuario($username,$password,$email,$name,$grupo,$team_id){
      $data = array(
         'username' => $username,
         'password' => MD5($password),
         'email' => $email,
         'name' => $name,
         'rol_id' => 3,
         'grupo' => $grupo,
         'team_id' => $team_id,
      );
      

      $id_nuevo_usuario = $this->db->insert('user', $data);

      return $id_nuevo_usuario;

   }

   public function actualizar($username,$email,$name,$grupo,$id){
      $data = array(
         'username' => $username,
         'email' => $email,
         'name' => $name,
         'grupo' => $grupo,
      );
      $this->db->where('id', $id);
      $rowAfects  = $this->db->update('user', $data);
      return $rowAfects;


   }

   public function actualizarEquipo($team_id,$id){
      /*elimnados los datos de la tabla asignación*/
      $this->db->delete('assignment', array('user_id' => $id));
      //eliminados los datos de la tabla question_answer
      $this->db->delete('question_answer', array('user_id' => $id));
      
      $data = array('team_id' => $team_id,'rol_id' => 3 );
      $this->db->where('id', $id);
      $rowAfects  = $this->db->update('user', $data);
      //si se pudo
      return $rowAfects;
   }

   public function actualizarRol($id){
      $data = array('rol_id' => 2);
      $this->db->where('id', $id);
      $rowAfects  = $this->db->update('user', $data);
      return $rowAfects;
   }
   //eliminacion de un usuario
   public function eliminar($id){
      //se eliminan todos los datos de este usuario de la tabla asignación
      return $this->db->delete('user', array('id' => $id));
   }

   function delete($id){
      return $this->db->delete('user', array('id' => $id));
   }

   public function deleteAssignment($id){
      return $this->db->delete('assignment', array('user_id' => $id));
   }

   public function deleteHistorial($id){
      return $this->db->delete('historial_phase_answered', array('user_id' => $id));
   }

   public function deleteQuestionAnswer($id){
      return $this->db->delete('question_answer', array('user_id' => $id));
   }
   
   
   //////////////////////////

   public function getUsuarioByUsername($username){
      $this -> db -> select('*');
     	$this-> db-> from('user');
     	$this-> db-> where('username', $username);
     	
     	$this -> db -> limit(1);
     	$query = $this -> db -> get();
     	if($query -> num_rows() == 1){
      	return $query->result();
     	}
     	else{
      	return false;
     	}
   }

   public function getUsuarioById($id){
   	$this -> db -> select('*');
     	$this-> db-> from('user');
     	$this-> db-> where('id', $id);
     	
     	$this -> db -> limit(1);

     	$query = $this -> db -> get();

     	if($query -> num_rows() == 1){
      	return $query->result();
     	}
     	else{
      	return false;
     	}
   }

   

  	public function getRolUsuario($id){
  		$this -> db -> select('*');
     	$this-> db-> from('rol');
     	$this-> db-> where('id', $id);
     	
     	$this -> db -> limit(1);

     	$query = $this -> db -> get();

     	if($query -> num_rows() == 1){
      	return $query->result();
     	}
     	else{
      	return false;
     	}
  	}

  	public function getUsuarioEmpty(){
  		$this->db->select('*');
      $this->db->from('user');
      $this->db->where('team_id','');
      
      $query = $this->db->get();
      if($query->num_rows() >= 1){
         return $query->result();
      }
      else{
         return false;
      }
  	}

   public function quitarRolJefe($id){
      $data = array('rol_id' => 3 );
      $this->db->where('id', $id);
      $rowAfects  = $this->db->update('user', $data);
      return $rowAfects;
   }

   public function setRolJefe($id){
      $data = array('rol_id' => 2 );
      $this->db->where('id', $id);
      $rowAfects  = $this->db->update('user', $data);
      return $rowAfects;
   }

   public function actualizarPerfil($username,$password,$email,$id){
      $data = array(
         'username' => $username,
         'password' => MD5($password),
         'email' => $email
      );
      $this->db->where('id', $id);
      $rowAfects  = $this->db->update('user', $data);
      return $rowAfects;


   }

   public function actualizarPerfilSinPassword($username,$email,$id){
      $data = array(
         'username' => $username,
         'email' => $email
      );
      $this->db->where('id', $id);
      $rowAfects  = $this->db->update('user', $data);
      return $rowAfects;
   }

   


}

 ?>
