<?php
/**
 *
 */
class Phase extends CI_Model
{
  public function getPhases(){
    $modelo=$_SESSION['modelsessionid'];
    $consulta=$this->db->query("SELECT phase_objetive.* FROM phase_objetive,process WHERE (process.model_id=$modelo) AND (process.id=phase_objetive.process_id) ");
		if($consulta->num_rows() >= 1){
			return $consulta->result();
		}else{
			return false;
		}

  }

  public function getCountPhases($id){
    $consulta=$this->db->query("SELECT * FROM phase_objetive WHERE process_id=$id");
    return $consulta->num_rows();
  }

  public function getCountPhasesBreakFree(){
    $consulta=$this->db->query("SELECT * FROM phase_objetive WHERE status=1");
    return $consulta->num_rows();
  }

  public function getPhase($id){
    $consulta=$this->db->query("SELECT * FROM phase_objetive WHERE id=$id");
	  return $consulta->result();
  }

  public function getPhase_ProcessId($id){
    $consulta=$this->db->query("SELECT * FROM phase_objetive WHERE process_id=$id");
    return $consulta->result();
  }

  public function add($nombre,$process_id){
		if ($this->validate($nombre,$process_id)) {
			$consulta=$this->db->query("INSERT INTO phase_objetive VALUES(NULL,'$nombre',0,'$process_id');");
			if($consulta==true){
				return 0;
			}else{
				return 1;
			}
		}else {
			return 2;
		}

	 }

   public function updateStatus($id){
       $consulta=$this->db->query("
        UPDATE phase_objetive SET status='1' WHERE id=$id;
        ");

      if($consulta==true){
        return 0;
      }else{
        return 1;
      }

      return 2;
    }


   public function update($id,$nombre,$process_id){

   if ( $this->validate($nombre,$process_id) ) {
     $consulta=$this->db->query("
         UPDATE phase_objetive SET name='$nombre' WHERE id=$id;
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
       $consulta=$this->db->query("DELETE FROM phase_objetive WHERE id=$id");
			 if($consulta==true){
					 return 0;
			 }else{
					 return 1;
			 }
    }


public function validate($nombre,$process_id){

   if (empty($nombre)) {
     return false;
   }
   if (empty($process_id)) {
     return false;
   }
   return true;

  }


}

 ?>
