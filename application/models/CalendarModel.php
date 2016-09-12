<?php 
class CalendarModel extends CI_Model
{

	function __construct(){
		# code...
	}

	public function getAllActividadesInTableCalificacion($id_equipo){
		$this->db->select('*');
      $this->db->from('calificacion_questionary');
      $this->db->where('team_id',$id_equipo);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

        return $query->result();
      }
      else{
         return false;
      }
	}

	public function getAllActividadesInTracing(){
		$this->db->select('*');
      $this->db->from('calification_questionary_tracing');
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

        return $query->result();
      }
      else{
         return false;
      }
	}

	public function getDataActividad($id_actividad){
		$this->db->select('*');
      $this->db->from('calificacion_questionary');
      $this->db->where('id',$id_actividad);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

        return $query->result();
      }
      else{
         return false;
      }
	}

	public function getTracingId($id){
		$this->db->select('tracing_id');
      $this->db->from('calification_questionary_tracing');
      $this->db->where('calificacion_questionary_id',$id);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

        return $query->result();
      }
      else{
         return false;
      }
	}

	public function getDataTableTracingById($id){
		$this->db->select('*');
      $this->db->from('tracing');
      $this->db->where('id',$id);
      $this->db->where('status',0);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

        return $query->result();
      }
      else{
         return false;
      }
	}

	public function updateFecha($id_tracing,$nuevaFecha){
		$data = array(
         'date_end' => $nuevaFecha
      );
      $this->db->where('id', $id_tracing);
      $rowAfects  = $this->db->update('tracing', $data);
      return $rowAfects;
	}
}
 ?>