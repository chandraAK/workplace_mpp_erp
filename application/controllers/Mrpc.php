<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Mrpc extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database(); 
		 $this->load->model('mrpm');
	}
	
	//Reports
	public function index(){ 
		$this->load->view('admin/header');
		$this->load->view('admin/modules/mrp/mrp_db'); 
		$this->load->view('admin/footer');
	}
}
