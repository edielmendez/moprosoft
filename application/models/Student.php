<?php
/**
 *
 */
class Student extends CI_Model
{

  public function getQuestionary($id,$team)
  {
    $consulta=$this->db->query("SELECT questionary.id,questionary.name,assignment.user_id,assignment.questionary_id,assignment.status,assignment.team_id  FROM questionary,assignment WHERE (assignment.user_id=$id) AND (assignment.team_id=$team) AND (assignment.questionary_id=questionary.id) AND (assignment.status!=100)  ");
    if($consulta->num_rows() >= 1){
      return $consulta->result();
    }else{
      return false;
    }
  }
  public function finalizarCuestionario($user,$cuestionario,$equipo)
  {
    $consulta=$this->db->query("SELECT * FROM assignment WHERE (user_id=$user) AND (questionary_id=$cuestionario) AND (team_id=$equipo)  ");
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
    $consulta=$this->db->query("SELECT * FROM question_answer WHERE (questionary_id=$questionary) AND (user_id=$user)");
    return $consulta->num_rows();
  }

  public function updateAvanze($questionary,$user,$avanze)
  {
    $consulta=$this->db->query("SELECT * FROM assignment WHERE (questionary_id=$questionary) AND (user_id=$user)");
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

  public function Questionary_Historial($id,$team)
  {
    $consulta=$this->db->query("SELECT questionary.name FROM questionary,assignment WHERE (assignment.status=100) AND (assignment.user_id=$id) AND (assignment.team_id=$team)");
    return $consulta->result();
  }

  public function Questionary($id)
  {
    $consulta=$this->db->query("SELECT * FROM questionary WHERE id=$id");
    return $consulta->result();
  }

  public function getQuestions($id)
  {
    $consulta=$this->db->query("SELECT * FROM question WHERE questionary_id=$id");
    return $consulta->result();
  }

  public function getQuestions_Answer($questionary,$user)
  {
    $consulta=$this->db->query("SELECT * FROM question_answer WHERE (questionary_id=$questionary) AND (user_id=$user)  ");
    return $consulta->result();
  }

  public function getQuestionsCount($id)
  {
    $consulta=$this->db->query("SELECT * FROM question WHERE questionary_id=$id");
    return $consulta->num_rows();
  }

  public function add($user,$id_cuestionary,$question_id1,$answer_id1)
  {
    $consulta=$this->db->query("SELECT * FROM question_answer WHERE (questionary_id=$id_cuestionary) AND (question_id=$question_id1) AND (user_id=$user)");
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
