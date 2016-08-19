<?php
/**
 *
 */
class Question extends CI_Model
{
  public function getQuestions()
  {
   $Questionary=$_SESSION['Questionary_id'];
   $consulta=$this->db->query("SELECT * FROM question WHERE question.questionary_id=$Questionary ");
   if($consulta->num_rows() >= 1){
     return $consulta->result();
   }else{
     return false;
   }
  }

  public function getCountQuestion($id){
    $consulta=$this->db->query("SELECT * FROM question WHERE questionary_id=$id");
    return $consulta->num_rows();
  }

  public function add($nombre,$comentario){
    $Questionary=$_SESSION['Questionary_id'];
    if ($this->validate($nombre)) {
      $consulta=$this->db->query("INSERT INTO question VALUES(NULL,'$nombre','$comentario',0,'$Questionary');");
      if($consulta==true){
        return 0;
      }else{
        return 1;
      }
    }else {
      return 2;
    }
  }

  public function getQuestion($id){
    $consulta=$this->db->query("SELECT * FROM question WHERE id=$id");
    return $consulta->result();
  }

 public function update($id,$nombre,$comentario){
  if ( $this->validate($nombre) ) {
    $consulta=$this->db->query("
        UPDATE question SET question='$nombre',commentary='$comentario' WHERE id=$id;
        ");
    if($consulta==true){
        return 0;
    }else{
        return 1;
    }
  }else{
    return 2;
  }
}

public function delete($id){
    $consulta=$this->db->query("DELETE FROM question WHERE id=$id");
    if($consulta==true){
        return 0;
    }else{
        return 1;
    }
 }

 public function validate($nombre){
 if (empty($nombre)) {
   return false;
 }
 return true;
}




}
 ?>
