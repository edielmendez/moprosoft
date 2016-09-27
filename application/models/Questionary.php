<?php
/**
 *
 */
class Questionary extends CI_Model
{

  public function getQ($id){
    $consulta=$this->db->query("SELECT * FROM questionary WHERE id=$id");
    return $consulta->result();
  }

  public function getQuestionary(){
    $modelo=$_SESSION['modelsessionid'];
    $consulta=$this->db->query("SELECT questionary.* FROM phase_objetive,process,questionary WHERE (process.model_id=$modelo) AND (process.id=phase_objetive.process_id) AND (phase_objetive.id=questionary.phase_objetive_id)");
    if($consulta->num_rows() >= 1){
			return $consulta->result();
		}else{
			return false;
		}
  }

  public function getQuestionary_id($id){
  $modelo=$_SESSION['modelsessionid'];
  $consulta=$this->db->query("SELECT questionary.* FROM questionary WHERE questionary.phase_objetive_id=$id ");
  if($consulta->num_rows() >= 1){
    return $consulta->result();
  }else{
    return false;
  }

  }

  public function liberar(){
  $modelo=$_SESSION['modelsessionid'];
  $consulta=$this->db->query("SELECT questionary.* FROM questionary WHERE questionary.phase_objetive_id=$id ");
  if($consulta->num_rows() >= 1){
    return $consulta->result();
  }else{
    return false;
  }

  }

  public function add($nombre,$phase_objetive_id){
    if ($this->validate($nombre,$phase_objetive_id)) {
      $consulta=$this->db->query("INSERT INTO questionary VALUES(NULL,'$nombre','$phase_objetive_id');");
      if($consulta==true){
        return 0;
      }else{
        return 1;
      }
    }else {
      return 2;
    }

   }

   public function getCountQuestion($id){
     $consulta=$this->db->query("SELECT * FROM question WHERE questionary_id=$id");
     return $consulta->num_rows();
   }

  public function update($id,$nombre,$liberacion){
    if ( !empty($nombre) ) {
       $consulta=$this->db->query("
           UPDATE questionary SET name='$nombre',status='$liberacion' WHERE id=$id;
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

   public function updateStatus($id){
       $consulta=$this->db->query("
        UPDATE questionary SET status='1' WHERE id=$id;
        ");

      if($consulta==true){
        return 0;
      }else{
        return 1;
      }

      return 2;
    }

  public function delete($id){
    $consulta=$this->db->query("DELETE FROM questionary WHERE id=$id");
  	if($consulta==true){
  	   return 0;
  	}else{
  	   return 1;
  	}
  }

  public function validate($nombre,$phases_id){

     if (empty($nombre)) {
       return false;
     }
     if (empty($phases_id)) {
       return false;
     }
     return true;

    }

}

 ?>
