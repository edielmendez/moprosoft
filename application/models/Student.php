<?php
/**
 *
 */
class Student extends CI_Model
{

  public function getPhases($id,$team)
  {
    $consulta=$this->db->query("SELECT phase_objetive.id,phase_objetive.name,assignment.user_id,assignment.phase_objetive_id,assignment.status,assignment.team_id  FROM phase_objetive,assignment WHERE (assignment.user_id=$id) AND (assignment.team_id=$team) AND (assignment.status!=100) AND (assignment.phase_objetive_id=phase_objetive.id)  ");
    if($consulta->num_rows() >= 1){
      return $consulta->result();
    }else{
      return false;
    }
  }
  public function finalizarCuestionario($user,$cuestionario,$equipo)
  {
    $consulta=$this->db->query("SELECT * FROM assignment WHERE (user_id=$user) AND (phase_objetive_id=$cuestionario) AND (team_id=$equipo)  ");
    $c= $consulta->row();
    $consulta=$this->db->query("
        UPDATE assignment SET status='100' WHERE id=$c->id;
        ");
    if($consulta==true){
        return 0;
    }else{
        return 1;
    }
  }

  public function getAvance($questionary,$user)
  {
    $consulta=$this->db->query("SELECT * FROM question_answer WHERE (phase_objetive_id=$questionary) AND (user_id=$user)");
    return $consulta->num_rows();
  }

  public function addCalificacion($team_id,$questionary_id,$question_id,$siempre,$usualmente,$aveces,$rara,$nunca,$nivel,$media,$desviacion,$valor)
  {
    $consulta=$this->db->query("SELECT * FROM phase_objetive WHERE id=$questionary_id ");
    $c= $consulta->row();

    $result=$this->db->query("INSERT INTO calificacion_questionary VALUES(NULL,'$team_id','$c->process_id','$questionary_id','$question_id','$siempre','$usualmente','$aveces','$rara','$nunca','$nivel','$media','$desviacion','$valor');");
    if($result==true){
      return 0;
    }else{
      return 1;
    }
  }

  public function getCP($user,$equipo,$cuestionario)
  {
    $consulta=$this->db->query("SELECT model.cp FROM model,process,phase_objetive WHERE (phase_objetive.id=$cuestionario) AND (phase_objetive.process_id=process.id) AND (process.model_id=model.id) ");
    $c= $consulta->row();
    return $c->cp;
  }

  public function updateAvanze($questionary,$user,$avanze)
  {
    $consulta=$this->db->query("SELECT * FROM assignment WHERE (phase_objetive_id=$questionary) AND (user_id=$user)");
    $c= $consulta->row();
    $consulta=$this->db->query("
        UPDATE assignment SET status='$avanze' WHERE id=$c->id;
        ");
    if($consulta==true){
        return 0;
    }else{
        return 1;
    }

  }

  public function Phase_Historial($id,$team)
  {
    $consulta=$this->db->query("SELECT phase_objetive.name as phase,process.name as process,model.name as model FROM phase_objetive,assignment,process,model WHERE (assignment.status=100) AND (assignment.user_id=$id) AND (assignment.team_id=$team) AND (assignment.phase_objetive_id=phase_objetive.id) AND (phase_objetive.process_id=process.id) AND (process.model_id=model.id)  ");
    return $consulta->result();
  }

  public function Phase($id)
  {
    $consulta=$this->db->query("SELECT * FROM phase_objetive WHERE id=$id");
    return $consulta->result();
  }

  public function getQuestions($id)
  {
    $consulta=$this->db->query("SELECT * FROM question WHERE phase_objetive_id=$id");
    return $consulta->result();
  }

  public function getQuestions_Answer($questionary,$user)
  {
    $consulta=$this->db->query("SELECT * FROM question_answer WHERE (phase_objetive_id=$questionary) AND (user_id=$user)  ");
    return $consulta->result();
  }

  public function getQuestionsCount($id)
  {
    $consulta=$this->db->query("SELECT * FROM question WHERE phase_objetive_id=$id");
    return $consulta->num_rows();
  }

  public function NumCuestionarioEquipo($questionary,$team)
  {
    $consulta=$this->db->query("SELECT * FROM assignment WHERE (phase_objetive_id=$questionary) AND (team_id=$team) ");
    return $consulta->num_rows();
  }

  public function NumCuestionarioEquipoContestados($questionary,$team)
  {
    $consulta=$this->db->query("SELECT * FROM assignment WHERE (phase_objetive_id=$questionary) AND (team_id=$team) AND (status=100) ");
    return $consulta->num_rows();
  }

  public function getUsersPorTeam($team)
  {
    $consulta=$this->db->query("SELECT * FROM user WHERE (team_id=$team) AND (rol_id!=1) ");
    return $consulta->result();
  }

  public function getPreguntas($cuestionario)
  {
    $consulta=$this->db->query("SELECT * FROM question WHERE (phase_objetive_id=$cuestionario)  ");
    return $consulta->result();
  }

  public function getRespuestas($cuestionario,$pregunta)
  {
    $consulta=$this->db->query("SELECT question_answer.answer_id FROM question_answer WHERE (phase_objetive_id=$cuestionario) AND (question_id=$pregunta) ");
    return $consulta->result();
  }

  public function add($user,$id_cuestionary,$question_id1,$answer_id1)
  {
    $consulta=$this->db->query("SELECT * FROM question_answer WHERE (phase_objetive_id=$id_cuestionary) AND (question_id=$question_id1) AND (user_id=$user)");
    //return $consulta->num_rows();
    if($consulta->num_rows() >= 1){
      $c= $consulta->row();
      //Se actualiza
      $consulta=$this->db->query("
          UPDATE question_answer SET answer_id='$answer_id1' WHERE id=$c->id;
          ");
      if($consulta==true){
          return 0;
      }else{
          return 1;
      }
    }else{
      //Se agrega
      $result=$this->db->query("INSERT INTO question_answer VALUES(NULL,'$id_cuestionary','$question_id1','$answer_id1','$user');");
      if($result==true){
        return 0;
      }else{
        return 1;
      }
    }

  }

}
 ?>
