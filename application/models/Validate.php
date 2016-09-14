<?php
/**
 *
 */
class Validate extends CI_Model
{

  //funcion que retorna 1 si la fase se ha depurado con "n" seguimientos a terminado tanto sus seguimientos como sus actividades
  //en caso de que aun no termina su seguimiento o aun no termina de depurar todas las actividades de la fase
  //se retornada 0
  public function check_finish_phase($phase_id,$team_id)
  {

    $query=$this->db->query("SELECT * FROM tracing WHERE (status=0) AND (phase_objetive_id=$phase_id) ");
    if ($query->num_rows()>0) {
      return 0;
    }else {
      $num_questions_sin_responder=$this->db->query("SELECT * FROM calificacion_questionary WHERE  (phase_objetive_id=$phase_id) AND (team_id=$team_id) AND (valor='debil') AND (bandera=0) ");
      if ($num_questions_sin_responder->num_rows()>0) {
        return 0;
      }
      $num_questions=$this->db->query("SELECT * FROM calificacion_questionary WHERE  (phase_objetive_id=$phase_id) AND (team_id=$team_id) AND (valor='debil') AND (bandera=1) ");
      foreach ($num_questions->result() as $key) {
          $exist=$this->db->query("SELECT * FROM calification_questionary_tracing WHERE (team_id=$team_id) AND (calificacion_questionary_id=$key->id) ");
          if ($exist->num_rows()==0) {
            return 0;
          }
      }
      return 1;
    }
  }

  //funcion que compara 2 fechas y retorna true si la fecha de hoy es mayor a la recibida
  public function strcmp_date($fecha){
    //formato de fecha yyyy-mm-dd
    //$fechActual = date("Y")."-".date("m")."-".date("d");
    $hoy = new DateTime(date("Y")."-".date("m")."-".date("d"));
    $almacenada = new DateTime($fecha);

    if ($hoy>$almacenada) {
      return true;
    }else {
      return false;
    }
  }

  //funcion que obtiene los seguimientos que aun siguen vigentes
  public function getTracing_calification_questionary($id){
    $equipo=$this->session->userdata('logged_in')['team_id'];
    $query=$this->db->query("SELECT * FROM calification_questionary_tracing WHERE (tracing_id=$id) AND (team_id=$equipo) ");
    if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
  }

  //funcion que obtiene los seguimientos que aun siguen vigentes
  public function getTracingValid(){
    $equipo=$this->session->userdata('logged_in')['team_id'];
    $query=$this->db->query("SELECT * FROM tracing WHERE (status=0) AND  (team_id=$equipo) ");
    if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
  }

  //funcion que actualiza el status de un seguimiento, para ponerlo en vencido
  public function update_tracing_status($id){
    $consulta=$this->db->query("
        UPDATE tracing SET status='1' WHERE id=$id;
        ");
    if($consulta==true){
        return 0;
    }else{
        return 1;
    }
  }

  //funcion que determina el numero de dias de atraso o adelantados
  //una vez que el plazo haya vencido
  public function update_tracing_diferencia_dias($id,$fecha_establecida,$fecha_final)
  {
    $tracing_date = new DateTime($fecha_establecida);
    $ultimo_tracing = new DateTime($fecha_final);

    $diferencia=0;
    $dif=$tracing_date->diff($ultimo_tracing);

    if ($tracing_date>$ultimo_tracing) {
      //dias adelantados
      $diferencia=$dif->format('%a')*(-1);
    }

    if ($tracing_date<$ultimo_tracing) {
      //dias atrasados
      $diferencia=$dif->format('%a');
    }

    $consulta=$this->db->query("
        UPDATE tracing SET diferencia_dias='$diferencia' WHERE id=$id;
        ");
    if($consulta==true){
        return 0;
    }else{
        return 1;
    }

  }

  //funcion que actualiza a una actividad a 1, para no mostrarla como opcion en el proximo seguimiento
  public function update_calification_questionary_bandera($id)
  {
    $consulta=$this->db->query("
        UPDATE calificacion_questionary SET bandera='1' WHERE id=$id;
        ");
    if($consulta==true){
        return 0;
    }else{
        return 1;
    }
  }

  public function get_historial_result()
  {
    $equipo=$this->session->userdata('logged_in')['team_id'];
    $query=$this->db->query("SELECT * FROM historial_result WHERE (status=0) AND (team_id=$equipo) ");
    if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
  }

  public function update_historial_result($id)
  {
    $consulta=$this->db->query("
        UPDATE historial_result SET status='1' WHERE id=$id;
        ");
    if($consulta==true){
        return 0;
    }else{
        return 1;
    }
  }

  public function get_historial_result_teamid_phase($phase,$equipo)
  {
    $query=$this->db->query("SELECT * FROM historial_result WHERE (phase=$phase) AND (team_id=$equipo) AND (status=0) ");
    if($query->num_rows() >= 1){
      $c=$query->row();
      return $c->id;
		}else{
			return false;
		}
  }



}

 ?>
