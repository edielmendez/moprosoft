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

  public function getQuestionsCount($id)
  {
    $consulta=$this->db->query("SELECT * FROM question WHERE questionary_id=$id");
    return $consulta->num_rows();
  }

}
 ?>
