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
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getEquipoById($id){
	   $this -> db -> select('*');
	 	$this-> db-> from('team');
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
   public function actualizar($nombre,$id){
   	$data = array(
         'name' => $nombre
      );
      $this->db->where('id', $id);
      $rowAfects  = $this->db->update('team', $data);
      return $rowAfects;
   }

   public function crearEquipo($name){
   	$data = array(
         'name' => $name,
      );
      

      $id_nuevo_equipo = $this->db->insert('team', $data);

      return $id_nuevo_equipo;
   }

   function delete($id){
   	return $this->db->delete('team', array('id' => $id));
  	}

  	public function getDataTeamInAssignment($id){
      $this->db->select('*');
      $this->db->from('assignment');
      $this->db->where('team_id',$id);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){
         
         return $query->result();
      }
      else{
         return false;
      }
   }

	


}
 ?>