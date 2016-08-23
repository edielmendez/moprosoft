<?php
/**
*
*/
class CuestionarioAdmin extends CI_Model
{

	function __construct()
	{
		# code...
	}

	public function get(){
      $this->db->select('*');
      $this->db->from('questionary');
      $this->db->where('status',1);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }

   }



	public function getById($id){
	   $consulta=$this->db->query("SELECT * FROM questionary WHERE id=$id");
	   if($query -> num_rows() == 1){

         return $query->result();
      }
      else{
         return false;
      }
	}

   public function getFaseById($id){
      $this->db->select('*');
      $this->db->from('phase_objetive');
      $this->db->where('id',$id);
      $query = $this->db->get();

      if($query -> num_rows() == 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getProcesoById($id){
      $this->db->select('*');
      $this->db->from('process');
      $this->db->where('id',$id);
      $query = $this->db->get();

      if($query -> num_rows() == 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getModeloById($id){
      $this->db->select('*');
      $this->db->from('model');
      $this->db->where('id',$id);
      $query = $this->db->get();

      if($query -> num_rows() == 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getEquipoById($id){
      $this->db->select('*');
      $this->db->from('team');
      $this->db->where('id',$id);
      $query = $this->db->get();

      if($query -> num_rows() == 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getTeamsWithoutThisId($id){
      $this->db->select('*');
      $this->db->from('team');
      $this->db->where('id !=',$id);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getTeamsAssignment($id_equipo,$id_cuestionario){
      $this->db->select('*');
      $this->db->from('assignment');
      $this->db->where('team_id =',$id_equipo);
      $this->db->where('questionary_id =',$id_cuestionario);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getUsersByIdTeam($id){
      $this->db->select('*');
      $this->db->from('user');
      $this->db->where('team_id',$id);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function setAssignment($id_user,$id_cuestionario,$id_equipo){
		 if ($id_user!=1) {
			 $data = array(
					'user_id' => $id_user,
					'questionary_id' => $id_cuestionario,
					'status' => 0,
					'team_id' => $id_equipo
			 );

			 $id_nuevo_asignacion = $this->db->insert('assignment', $data);
			 return $id_nuevo_asignacion;
		 }else {
		 	return -1;
		 }
		 return -1;
   }


   public function getCuestionariosInAssignment($id){
      $this->db->select('DISTINCT(questionary_id)');
      $this->db->from('assignment');
      $this->db->where('team_id =',$id);
      $this->db->where('status !=',100);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getCuestionariosInAssignmentComplete($id){
      $this->db->select('DISTINCT(questionary_id)');
      $this->db->from('assignment');
      $this->db->where('team_id =',$id);
      $this->db->where('status =',100);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }
   //select count(id) from 'question' where questionary_id = 4
   public function getTotalPreguntas($id){
      $this->db->select("count('id') as total");
      $this->db->from('question');
      $this->db->where('questionary_id',$id);
      $query = $this->db->get();
      //print_r($query);

      //$this->output->enable_profiler(TRUE);
      //return;
      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getTotalPreguntasContestadas($id_cuestionario,$id_user){
      $this->db->select('COUNT(question_id) as total');
      $this->db->from('question_answer');
      $this->db->where('questionary_id',$id_cuestionario);
      $this->db->where('user_id',$id_user);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }
   /*
   public function getTotalPreguntasContestadasOpc1($id_cuestionario){
      $this->db->select('COUNT(question_id) as total');
      $this->db->from('question_answer');
      $this->db->where('questionary_id',$id_cuestionario);
      $this->db->where('answer_id',1);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getTotalPreguntasContestadasOpc2($id_cuestionario){
      $this->db->select('COUNT(question_id) as total');
      $this->db->from('question_answer');
      $this->db->where('questionary_id',$id_cuestionario);
      $this->db->where('answer_id',2);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getTotalPreguntasContestadasOpc3($id_cuestionario){
      $this->db->select('COUNT(question_id) as total');
      $this->db->from('question_answer');
      $this->db->where('questionary_id',$id_cuestionario);
      $this->db->where('answer_id',3);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getTotalPreguntasContestadasOpc4($id_cuestionario){
      $this->db->select('COUNT(question_id) as total');
      $this->db->from('question_answer');
      $this->db->where('questionary_id',$id_cuestionario);
      $this->db->where('answer_id',4);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }*/


   public function getResultadosEvaluation($id_cuestionario,$id_equipo){
      $this->db->select('*');
      $this->db->from('calificacion_questionary');
      $this->db->where('team_id',$id_equipo);
      $this->db->where('questionary_id',$id_cuestionario);
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
