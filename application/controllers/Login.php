<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   //user_act();
 }
 
 function index()
 {
   $this->load->helper('url');
   $this->load->helper(array('form'));
   $this->load->view('admin/login_view');
 }

 function welcome(){
  $this->load->helper('url');
  // $this->load->helper(array('form'));
  $this->load->view('admin/welcome_message');
 }
 
}
