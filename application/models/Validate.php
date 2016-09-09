<?php
/**
 *
 */
class Validate extends CI_Model
{

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
    $query=$this->db->query("SELECT * FROM calification_questionary_tracing WHERE tracing_id=$id ");
    if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
  }

  //funcion que obtiene los seguimientos que aun siguen vigentes
  public function getTracingValid(){
    $query=$this->db->query("SELECT * FROM tracing WHERE status=0 ");
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



}

 ?>
