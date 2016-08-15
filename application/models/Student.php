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

  public function add($user,$id_cuestionary,$question_id1,$answer_id1)
  {
    $consulta=$this->db->query("SELECT question_answer.id FROM question_answer WHERE (questionary_id=$id_cuestionary) AND (question_id=$question_id1) AND (answer_id=$answer_id1) AND (user_id=$user)");
    if($consulta->num_rows() >= 1){
      //Se actualiza
      /*$consulta=$this->db->query("
          UPDATE question_answer SET name='$nombre', version='$version',level='$nivel', phase_objetive='$trabajara' WHERE id=$id;
          ");
      if($consulta==true){
          return 0;
      }else{
          return 1;
      }*/
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
