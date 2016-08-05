<?php
/**
*
*/
class Modelo extends CI_Model
{

	function __construct()
	{
		# code...
	}

	public function getModels($team_id){
		$this->db->select("*");
		$this->db->from("model");
		$this->db->where("team_id",$team_id);
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getNumProcess($id){
    $consulta=$this->db->query("SELECT * FROM process WHERE model_id=$id");
	  return $consulta->num_rows() ;
  }

	public function add($nombre,$version,$nivel,$trabajara){

		$equipo=$this->session->userdata('logged_in')['team_id'];

		if ($this->validate($nombre,$version,$nivel,$trabajara)) {
			$consulta=$this->db->query("INSERT INTO model VALUES(NULL,'$nombre','$version','$nivel','$trabajara','$equipo');");
			if($consulta==true){
				return 0;
			}else{
				return 1;
			}
		}else {
			return 2;
		}

	 }

	 public function getModel($id_usuario){
	    $consulta=$this->db->query("SELECT * FROM model WHERE id=$id_usuario");
	    return $consulta->result();
    }

	public function update($id,$nombre,$version,$nivel,$trabajara){

		if ( $this->validate($nombre,$version,$nivel,$trabajara) ) {
			$consulta=$this->db->query("
					UPDATE model SET name='$nombre', version='$version',level='$nivel', phase_objetive='$trabajara' WHERE id=$id;
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
       $consulta=$this->db->query("DELETE FROM model WHERE id=$id");
			 if($consulta==true){
					 return 0;
			 }else{
					 return 1;
			 }
    }

	 public function validate($nombre,$version,$nivel,$trabajara){

		 if (empty($nombre)) {
			 return false;
		 }
		 if (empty($version)) {
			 return false;
		 }
		 return true;

		}


}
 ?>
