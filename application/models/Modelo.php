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

	public function add($nombre,$version,$nivel,$cp,$trabajara){

		$equipo=$this->session->userdata('logged_in')['team_id'];

		if ($this->validate($nombre,$version,$nivel,$trabajara)) {
			$consulta=$this->db->query("INSERT INTO model VALUES(NULL,'$nombre','$version','$nivel','$cp','$trabajara','$equipo');");
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

		public function ExisteSeguimiento($phase){
	    $consulta=$this->db->query("SELECT * FROM tracing WHERE (phase_objetive_id=$phase) AND (status=0) ");
	    return $consulta->num_rows();
		}

		public function historial_seguimineto($phase){
			$consulta=$this->db->query("SELECT * FROM tracing WHERE (phase_objetive_id=$phase) AND (status=1) ");

			if($consulta->num_rows() >= 1){
				return $consulta->num_rows();
			}else{
				return false;
			}
		}

		public function get_historial_seguimiento($phase){
			$consulta=$this->db->query("SELECT * FROM tracing WHERE phase_objetive_id=$phase ");
			$c=$consulta->row();

			$consulta2=$this->db->query("SELECT * FROM calification_questionary_tracing WHERE tracing_id=$c->id ");
			if($consulta2->num_rows() >= 1){
				return $consulta2->result();
			}else{
				return false;
			}
		}

		public function getSeguimiento($phase)
		{
			$consulta=$this->db->query("SELECT * FROM tracing WHERE phase_objetive_id=$phase  ");
			$c=$consulta->row();
			return array($c->date_start,$c->date_end,$c->id);
		}

		public function getPreguntasPriorizadas($phase)
		{
			$consulta=$this->db->query("SELECT * FROM calification_questionary_tracing  WHERE tracing_id=$phase ");
			if($consulta->num_rows() >= 1){
				return $consulta->result();
			}else{
				return false;
			}
		}

		public function terminarSeguimiento($fase,$fi,$ff){
			$data = array(
	         'phase_objetive_id' => $fase,
					 'date_start' => $fi,
					 'date_end' => $ff,
					 'status' => 0,
					 'diferencia_dias' => 0
	      );
      $id_nuevo_equipo = $this->db->insert('tracing', $data);
			$this -> db -> select('*');
      $this-> db-> from('tracing');
      $this-> db-> where('phase_objetive_id', $fase);
			$this-> db-> where('date_start', $fi);
			$this-> db-> where('date_end', $ff);
      $this -> db -> limit(1);

      $query = $this -> db -> get();
			$c= $query->row();
      return $c->id;

    }

		public function getResultado($equipo){
 	    $consulta=$this->db->query("SELECT * FROM calificacion_questionary,phase_objetive WHERE (calificacion_questionary.team_id=$equipo) AND (calificacion_questionary.phase_objetive_id=phase_objetive.id)   ");
 	    return $consulta->result();
    }

		public function Calificacion($id,$equipo)
		{
			$consulta=$this->db->query("SELECT calificacion_questionary.id,calificacion_questionary.team_id,calificacion_questionary.phase_objetive_id,question.question,calificacion_questionary.question_id,calificacion_questionary.valor,calificacion_questionary.bandera FROM calificacion_questionary,question WHERE (calificacion_questionary.team_id=$equipo) AND (calificacion_questionary.phase_objetive_id=$id) AND (question.phase_objetive_id=calificacion_questionary.phase_objetive_id) AND (question.id=calificacion_questionary.question_id) ");
 	    return $consulta->result();
		}

		public function GuardarPriorizadas($tracing,$id,$activity,$orden,$date_start,$date_end)
		{
			$data = array(
					 'calificacion_questionary_id' => $id,
					 'tracing_id' => $tracing,
					 'activity' => $activity,
					 'orden' => $orden,
					 'date_start' => $date_start,
					 'date_end' => $date_end,
				);
			$id = $this->db->insert('calification_questionary_tracing', $data);
			return $id;
		}

		public function getNameProcessPorcentaje($n)
		{
			$consulta=$this->db->query("SELECT * FROM model WHERE name='$n' " );
			$c = $consulta->row();
 	    return $c->cp;
		}

		public function getNameProcess($phase)
		{
			$consulta=$this->db->query("SELECT process.* FROM process,phase_objetive WHERE (phase_objetive.id=$phase) AND (phase_objetive.process_id=process.id) ");
			$c = $consulta->row();
 	    return $c->name;
		}

		public function getNameModel($phase)
		{
			$consulta=$this->db->query("SELECT model.* FROM process,phase_objetive,model WHERE (phase_objetive.id=$phase) AND (phase_objetive.process_id=process.id) AND (process.model_id=model.id)");
			$c = $consulta->row();
 	    return $c->name;
		}

	public function update($id,$nombre,$version,$nivel,$cp,$trabajara){

		if ( $this->validate($nombre,$version,$nivel,$trabajara) ) {
			$consulta=$this->db->query("
					UPDATE model SET name='$nombre', version='$version',level='$nivel', cp='$cp' ,phase_objetive='$trabajara' WHERE id=$id;
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

	public function updateFollow($id,$fi,$ff){
		$consulta=$this->db->query("
				UPDATE calification_questionary_tracing SET date_start='$fi',date_end='$ff'  WHERE id=$id;
				");
		if($consulta==true){
				return 0;
		}else{
				return 1;
		}
	}

	public function updateFollow_id($id,$ff){
		$consulta=$this->db->query("
				UPDATE tracing SET date_end='$ff' WHERE id=$id;
				");
		if($consulta==true){
				return "OK";
		}else{
				return "Error";
		}
	}
	public function updateFollow_status($id,$status){
		$consulta=$this->db->query("
				UPDATE tracing SET status='$status' WHERE id=$id;
				");
		if($consulta==true){
				return 0;
		}else{
				return 1;
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
