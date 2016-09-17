<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('User');
	}
	public function index()
	{
		if($this->session->userdata('logged_in')){
			redirect('Home', 'refresh');
		}else{
			$this->form_validation->set_rules('username', 'username', 'trim|required');
   
   		$this->form_validation->set_rules('password', 'password', 'trim|required|callback_check_database');

			if($this->form_validation->run() == FALSE)
		   {
		     	//Field validation failed.  User redirected to login page
		     	$this->load->view('login');
		   }
		   else{

		   		redirect('Home', 'refresh');
		   }
		}
		
		
		/*
		$this->form_validation->set_rules('username', 'username', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required|callback_check_database');
		//print_r( $this->session->userdata['logged_in']);
		
		if ($this->form_validation->run() == FALSE) {
			if(isset($this->session->userdata['logged_in'])){
				$this->load->view('admin_page');
			}else{
				$this->load->view('login');
			}
		} else {
			
			$data = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password')
			);
			$result = $this->Usuario->login($data);
			if ($result == TRUE) {

				$username = $this->input->post('username');
				$result = $this->Usuario->read_user_information($username);
				if ($result != false) {
					$session_data = array(
					'username' => $result[0]->username
					);
					// Add user data in session
					$this->session->set_userdata('logged_in', $session_data);
					$this->load->view('admin_page',$session_data);
				}
			} else {
				$data = array(
				'error_message' => 'Invalid Username or Password'
				);
				$this->load->view('login', $data);
			}
		}
		*/

	}

	function check_database($password)
 	{

	   //Field validation succeeded.  Validate against database
	   $username = $this->input->post('username');

	   //query the database
	   $result = $this->User->login($username, $password);

	   if($result)
	   {

	     	$sess_array = array();
	     	foreach($result as $row)
	     {
	       $sess_array = array(
	         'id' => $row->id,
	         'username' => $row->username,
	         'password' => $row->password,
	         'email' => $row->email,
	         'name' => $row->name,
	         'rol_id' => $row->rol_id,
	         'grupo' => $row->grupo,
	         'team_id' => $row->team_id
	       );
	       //$this->session->set_userdata('logged_in', $sess_array);
	     }

	     	$datos_rol = $this->User->getRol($sess_array['rol_id']);

	     	foreach($datos_rol as $row)
	     {
	       $sess_array["rol"] = $row->type;
	       
	     }

	     	$this->session->set_userdata('logged_in', $sess_array);

	     return TRUE;
	   }
	   else
	   {
	     $this->form_validation->set_message('check_database', 'usuario o contraseña no validos');
	     return false;
	   }
 	}

	public function logout(){
		
	}

	
}
