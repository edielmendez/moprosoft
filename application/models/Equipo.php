<?php 
/**
* 
*/
class Equipo extends CI_Model
{

	function __construct()
	{
		# code...
	}

	public function getEquipos(){
		$this->db->select("*");
		$this->db->from("team");
		
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	


}
 ?>