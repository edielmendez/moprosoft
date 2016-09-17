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

	


}
 ?>