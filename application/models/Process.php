<?php
/**
 *
 */
class Process extends CI_Model
{
  public function getProcess(){
    $this->db->select("*");
		$this->db->from("process");
		$this->db->where("model_id",$_SESSION['modelsessionid']);
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
  }

  /*public function getFaseObjetivo(){
    $this->db->select("*");
		$this->db->from("model");
		$this->db->where("team_id",$this->session->userdata('logged_in')['team_id']);
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
  }*/

  public function getpro($id){
    $consulta=$this->db->query("SELECT * FROM process WHERE id=$id");
	  return $consulta->result();
  }

  public function add($nombre,$descripcion){
    $model=$_SESSION['modelsessionid'];
		if ($this->validate($nombre)) {
			$consulta=$this->db->query("INSERT INTO process VALUES(NULL,'$nombre','$descripcion',0,'$model');");
			if($consulta==true){
				return 0;
			}else{
				return 1;
			}
		}else {
			return 2;
		}

	 }


   public function update($id,$nombre,$descripcion){

   if ( $this->validate($nombre) ) {
     $consulta=$this->db->query("
         UPDATE process SET name='$nombre',description='$descripcion' WHERE id=$id;
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
      UPDATE process SET status='1' WHERE id=$id;
      ");

    if($consulta==true){
      return 0;
    }else{
      return 1;
    }

    return 2;
  }

 public function delete($id){
       $consulta=$this->db->query("DELETE FROM process WHERE id=$id");
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
