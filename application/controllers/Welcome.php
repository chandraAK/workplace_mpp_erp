<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index(){
		$this->load->helper('url');
		$this->load->library('user_agent');
		
		$data['browser'] = $this->agent->browser();
		
		$user_nik_agent = $_SERVER['HTTP_USER_AGENT'];

    	$browser_array  =   array(
							'/FxiOS/i'      =>  'Firefox'
                        );
						
		foreach ($browser_array as $regex => $value) {
			if (preg_match($regex, $user_nik_agent)) {
				$data['browser']    =   $value;
			}
		}
		
		$this->load->view('index');
	}
	
	public function about(){
		$this->load->helper('url');
		$this->load->view('about');
	}
	
	public function service(){
		$this->load->helper('url');
		$this->load->view('service');
	}
	
	public function portfolio(){
		$this->load->helper('url');
		$this->load->view('portfolio');
	}
	
	public function blog(){
		$this->load->helper('url');
		$this->load->view('blog');
	}
	
	public function contact(){
		$this->load->helper('url');
		$this->load->view('contact');
	}
	
	public function error(){
		$this->load->helper('url');
		$this->load->view('admin/404');
	}
	
	public function basic_table(){
		$this->load->helper('url');
		$this->load->view('admin/basic_table');
	}
	
	public function blank(){
		$this->load->helper('url');
		$this->load->view('admin/blank');
	}
	
	public function buttons(){
		$this->load->helper('url');
		$this->load->view('admin/buttons');
	}
	
	public function chartjs(){
		$this->load->helper('url');
		$this->load->view('admin/chart');
	}
	
	public function form_component(){
		$this->load->helper('url');
		$this->load->view('admin/form_component');
	}
	
	public function form_validation(){
		$this->load->helper('url');
		$this->load->view('admin/form_validation');
	}
	
	public function genral(){
		$this->load->helper('url');
		$this->load->view('admin/genral');
	}
	
	public function grids(){
		$this->load->helper('url');
		$this->load->view('admin/grids');
	}
	
	public function home_view(){
		$this->load->helper('url');
		$this->load->view('admin/home_view');
	}
	
	public function dashboard(){
		$this->load->helper('url');
		$this->load->database(); 
		$this->load->model('user');
		$this->load->view('admin/index', $data);
	}
	
	public function login(){
		$this->load->helper('url');
		$this->load->view('admin/login');
	}
	
	public function login_view(){
		$this->load->helper('url');
		$this->load->view('admin/login_view');
	}
	
	public function profile(){
		$this->load->helper('url');
		$this->load->view('admin/profile');
	}
	
	public function widgets(){
		$this->load->helper('url');
		$this->load->view('admin/widgets');
	}
	
	public function welcome_message(){
	  $this->load->library('pdf');
	  $this->pdf->load_view('welcome_message');
	  $this->pdf->render();
	  $this->pdf->stream("welcome.pdf");
    }
}
