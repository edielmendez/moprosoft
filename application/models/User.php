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
      $query = $this->db->get();
      if($query->num_rows() >= 1){
         return $query->result();
      }
      else{
         return false;
      }
   }


}

 ?>
