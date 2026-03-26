<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Logout extends CI_Controller {
 
 function __construct(){
	   parent::__construct();
	   $this->load->helper('url');
   	   $this->load->helper(array('form'));
       $this->load->model('user');
	   
	   //user_act();
 }
 
 function index(){
   //Inserting Login Information
   //$this->user->store_session_logout();
   
   $this->session->sess_destroy();
   
   $this->load->view('admin/login_view');
 }
 
}
