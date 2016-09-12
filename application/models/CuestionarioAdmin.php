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

	public function getProcesosDisponibles(){
      $this->db->select('*');
      $this->db->from('process');
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

   public function getFaseByIdProcess($id){
      $this->db->select('*');
      $this->db->from('phase_objetive');
      $this->db->where('process_id',$id);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

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
   public function getProcesoByIdModel($id){
      $this->db->select('*');
      $this->db->from('process');
      $this->db->where('model_id',$id);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

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

   public function getTeamsAssignment($id_equipo,$id_fase){
      $this->db->select('*');
      $this->db->from('assignment');
      $this->db->where('team_id =',$id_equipo);
      $this->db->where('phase_objetive_id =',$id_fase);
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


   public function setAssignment($id_user,$id_fase,$id_equipo){
      $data = array(
         'user_id' => $id_user,
         'phase_objetive_id' => $id_fase,
         'status' => 0,
         'team_id' => $id_equipo
        
      );
      

      $id_nuevo_asignacion = $this->db->insert('assignment', $data);

      return $id_nuevo_asignacion;

   }


   public function getFasesInAssignment($id){
      $this->db->select('DISTINCT(phase_objetive_id)');
      $this->db->from('assignment');
      $this->db->where('team_id =',$id);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getFasesInAssignmentComplete($id){
      $this->db->select('DISTINCT(phase_objetive_id)');
      $this->db->from('calificacion_questionary');
      $this->db->where('team_id =',$id);
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
      $this->db->where('phase_objetive_id',$id);
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

   public function getTotalPreguntasContestadas($id_fase,$id_user){
      $this->db->select('COUNT(question_id) as total');
      $this->db->from('question_answer');
      $this->db->where('phase_objetive_id',$id_fase);
      $this->db->where('user_id',$id_user);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }
   }
   


   
   public function getResultadosEvaluation($id_fase,$id_equipo){

      $this->db->select('*');
      $this->db->from('calificacion_questionary');
      $this->db->where('team_id',$id_equipo);
      $this->db->where('phase_objetive_id',$id_fase);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){
         
         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getQuestionsIndeterminate($id_equipo,$id_fase){
      $this->db->select('question_id');
      $this->db->from('calificacion_questionary');
      $this->db->where('team_id',$id_equipo);
      $this->db->where('phase_objetive_id',$id_fase);
      $this->db->where('valor','indeterminado');
      
                                 
      $query = $this->db->get();

      if($query -> num_rows() >= 1){
         
         return $query->result();
      }
      else{
         return false;
      }
   }

   public function setValueQuestionIndeterminate($id_equipo,$id_fase,$id_pregunta,$valor){
      $data = array(
         'valor' => $valor
      );
      $this->db->where('team_id', $id_equipo);
      $this->db->where('phase_objetive_id', $id_fase);
      $this->db->where('question_id', $id_pregunta);
      $rowAfects  = $this->db->update('calificacion_questionary', $data);
      return $rowAfects;
   }


   public function getPorcentajeDeAvanceDeFasePorUsuario($id_user,$id_fase){
      $this->db->select('status');
      $this->db->from('assignment');
      $this->db->where('user_id',$id_user);
      $this->db->where('phase_objetive_id',$id_fase);
      
                                 
      $query = $this->db->get();

      if($query -> num_rows() >= 1){
         
         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getProcesosInTableCalificacion($id_equipo){
      $this->db->select('DISTINCT(process_id)');
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

   public function getAllFasesByProcessId($id_proceso){
      $this->db->select('*');
      $this->db->from('phase_objetive');
      $this->db->where('process_id',$id_proceso);
      $this->db->where('status',1);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){
         
         return $query->result();
      }
      else{
         return false;
      }
   }

   public function getAllFasesByProcessIdCalificadas($id_proceso){

      $this->db->select('DISTINCT(phase_objetive_id)');
      $this->db->from('calificacion_questionary');
      $this->db->where('process_id',$id_proceso);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){
         
         return $query->result();
      }
      else{
         return false;
      }

   }


   public function getAllDataFasesByProcessId($id_proceso){
      
      $this->db->select('*');
      $this->db->from('calificacion_questionary');
      $this->db->where('process_id',$id_proceso);
      $query = $this->db->get();

      if($query -> num_rows() >= 1){

         return $query->result();
      }
      else{
         return false;
      }

   }


   public function getAllPhaseAvailableByProcess($id_proceso){
      $this->db->select('*');
      $this->db->from('phase_objetive');
      $this->db->where('process_id',$id_proceso);
      $this->db->where('status',1);
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
