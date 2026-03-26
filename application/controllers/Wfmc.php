<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Wfmc extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database(); 
		 $this->load->model('wfmm');
	}
	
	//Reports
	public function index(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'WFM' => 'wfmc',
		);
		$this->load->view('admin/header');
		$this->load->view('admin/modules/wfm/wfm_db', $data); 
		$this->load->view('admin/footer');
	}
}
