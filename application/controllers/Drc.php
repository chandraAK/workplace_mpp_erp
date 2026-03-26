<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Drc extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		//$this->load->database('db2',TRUE);
		 $this->load->model('drm');
		 //echo "charu";die;
	}


	/****************************** */
	/********Dashboards************ */
	/****************************** */
	public function index(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
 			'DR Dashboard' => 'drc',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/dr/dr_db',$data); 
		$this->load->view('admin/footer');
	}
	
	public function lead(){
		$data=array();
		$data['h'] = $this->drm->lead_insert($data);
	}


	//DR CRM
	public function dr_list(){
		$dept = '2';
		$tbl_nm = "dr_mst";
		$data = array();
		$data['list_title'] = "Daily Report List";
		$data['list_url'] = "drc/dr_list";
		$data['tbl_nm'] = "dr_mst";
		$data['primary_col'] = "dr_id";
		$data['edit_url'] = "drc/dr_form";
		$data['edit_enable'] = "yes";
		
		$data['ViewHead'] = $this->drm->ListHead($tbl_nm);

		$where_str = "where dept = $dept";
		
		$data['where_str'] = $where_str;

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'DR Dashboard' => 'drc', 
			'Daily Report List CRM' => 'drc/dr_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function dr_form(){
		$dr_id = $_REQUEST['id'];
		if($dr_id != ""){
			$data['get_dr_by_id'] = $this->drm->get_dr_by_id($dr_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'DR Dashboard' => 'drc',
			'Daily Report List CRM' => 'drc/dr_list',
			'DR Form CRM' => 'drc/dr_form?id="'.$dr_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/dr/dr_form1', $data); 
		$this->load->view('admin/footer');	
	}

	public function dr_entry(){
		$data = array();
		$data['dr_entry'] = $this->drm->dr_entry($data);
		$data['message'] = '';
		$data['url'] = 'drc/dr_list';
		$this->load->view('admin/QueryPage', $data); 	
	}
		
	
	//DR IT
	public function dr_list_it(){
		$dept = '4';
		$tbl_nm = "dr_mst";
		$data = array();
		$data['list_title'] = "Daily Report List";
		$data['list_url'] = "drc/dr_list_it";
		$data['tbl_nm'] = "dr_mst";
		$data['primary_col'] = "dr_id";
		$data['edit_url'] = "drc/dr_form_it";
		$data['edit_enable'] = "yes";
		
		$data['ViewHead'] = $this->drm->ListHead($tbl_nm);

		$where_str = "where dept = $dept";

		$data['where_str'] = $where_str;

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'DR Dashboard' => 'drc', 
			'Daily Report List IT' => 'drc/dr_list_it',
		);
		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function dr_form_it(){
		$dr_id = $_REQUEST['id'];
		if($dr_id != ""){
			$data['get_dr_by_id'] = $this->drm->get_dr_by_id($dr_id);
		}
		
		
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'DR Dashboard' => 'drc',
			'Daily Report List IT' => 'drc/dr_list_it',
			'DR Form IT' => 'drc/dr_form_it?id="'.$dr_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/dr/dr_form_it', $data); 
		$this->load->view('admin/footer');	
	}


	public function dr_entry_it(){
		$data = array();
		$data['dr_entry_it'] = $this->drm->dr_entry_it($data);
		$data['message'] = '';
		$data['url'] = 'drc/dr_list_it';
		$this->load->view('admin/QueryPage', $data); 	
	}
	//DR design
	public function dr_list_design(){
		$dept = '7';
		$tbl_nm = "dr_mst";
		$data = array();
		$data['list_title'] = "Daily Report List";
		$data['list_url'] = "drc/dr_list_design";
		$data['tbl_nm'] = "dr_mst";
		$data['primary_col'] = "dr_id";
		$data['edit_url'] = "drc/dr_form_design";
		$data['edit_enable'] = "yes";
		
		$data['ViewHead'] = $this->drm->ListHead($tbl_nm);

		$where_str = "where dept = $dept";

		$data['where_str'] = $where_str;

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'DR Dashboard' => 'drc', 
			'Daily Report List Design' => 'drc/dr_list_design',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}



	public function dr_form_design(){
		$dr_id = $_REQUEST['id'];
		if($dr_id != ""){
			$data['get_dr_by_id'] = $this->drm->get_dr_by_id($dr_id);
			//$data['get_dept'] = $this->drm->get_dept($dept);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'DR Dashboard' => 'drc',
			'Daily Report List Design' => 'drc/dr_list_design',
			'DR Form Design' => 'drc/dr_form_design?id="'.$dr_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/dr/dr_form_design', $data); 
		$this->load->view('admin/footer');	
	}

	
	public function dr_entry_design(){
		$data = array();
		$data['dr_entry_design'] = $this->drm->dr_entry_design($data);
		$data['message'] = '';
		$data['url'] = 'drc/dr_list_design';
		$this->load->view('admin/QueryPage', $data); 	
	}
	
	//DR SALES
	public function masters_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'DR' => 'drc',
			'Masters' => 'drc/masters_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/dr/masters_db',$data); 
		$this->load->view('admin/footer');
	}
	public function dr_list_sales(){
		$dept= '3';
		$tbl_nm = "dr_mst";
		$data = array();
		$data['list_title'] = "Daily Report List";
		$data['list_url'] = "drc/dr_list_sales";
		$data['tbl_nm'] = "dr_mst";
		$data['primary_col'] = "dr_id";
		$data['edit_url'] = "drc/dr_sales";
		$data['edit_enable'] = "yes";
		
		$data['ViewHead'] = $this->drm->ListHead($tbl_nm);

		$where_str = "where dept = $dept";

		$data['where_str'] = $where_str;

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'DR Dashboard' => 'drc', 
			'Daily Report List Sales' => 'drc/dr_list_sales',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}



	public function dr_sales(){
		$dr_id = $_REQUEST['id'];
		if($dr_id != ""){
			$data['get_dr_by_id'] = $this->drm->get_dr_by_id($dr_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'DR Dashboard' => 'drc',
			'Daily Report List Sales' => 'drc/dr_list_sales',
			'DR Form Sales' => 'drc/dr_sales?id="'.$dr_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/dr/dr_sales', $data); 
		$this->load->view('admin/footer');	
	}

	
	public function dr_entry_sales(){
		$data = array();
		$data['dr_entry_sales'] = $this->drm->dr_entry_sales($data);
		$data['message'] = '';
		$data['url'] = 'drc/dr_list_sales';
		$this->load->view('admin/QueryPage', $data); 	
	}
	
	
	//Cumulative DR 
	
	public function dr_rpt_summary(){
		$dr_id = $_REQUEST['id'];
		if($dr_id != ""){
			$data['get_dr_by_id'] = $this->drm->get_dr_by_id($dr_id);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'DR Dashboard' => 'drc',
			'Daily Report Summary' => 'drc/dr_rpt_summary',
			'DR Form IT' => 'drc/dr_rpt_summary?id="'.$dr_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/dr/dr_rpt_summary', $data); 
		$this->load->view('admin/footer');	
	}
	public function dr_rpt_summary_ajax(){
		$this->load->view('admin/modules/dr/dr_rpt_summary_ajax'); 
	}


	public function dr_entry_report(){
		$data = array();
		 $get_details= $this->drm->dr_entry_report();
		$get_all_details= $this->drm->dr_records();
		print_r ($get_all_details);
		exit();
		$data['message'] = '';
		$data['url'] = 'drc/dr_list_it';
		$this->load->view('admin/QueryPage', $data); 	
	}
	
	// DR Sales Target
	// added by charu sharma 202011171222
	public function dr_sales_target_list(){
		$tbl_nm = "dr_sales_target";
		$data = array();
		$data['list_title'] = "Daily Sales Target";
		$data['list_url'] = "drc/dr_sales_target_list";
		$data['tbl_nm'] = "dr_sales_target";
		$data['primary_col'] = "dr_sales_target_id";
		$data['edit_url'] = "drc/dr_sales_target";
		$data['edit_enable'] = "yes";
		
		$data['ViewHead'] = $this->drm->ListHead($tbl_nm);

		$data['where_str'] = $where_str;

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'DR Dashboard' => 'drc', 
			'Daily Sales Target List' => 'drc/dr_sales_target_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

		public function dr_sales_target(){
		$id = $_REQUEST['id'];

		if($id != ""){
			$data['get_by_id'] = $this->drm->get_by_id('dr_sales_target','dr_sales_target_id',$id);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'DR Dashboard' => 'drc',
			'Daily Report List Sales' => 'drc/dr_sales_target_list',
			'DR Form Sales Target' => 'drc/dr_sales_target?id="'.$dr_sales_target_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/dr/dr_sales_target', $data); 
		$this->load->view('admin/footer');	
	}

	public function dr_sales_ajax(){
		$this->load->view('admin/modules/dr/dr_sales_target_ajax'); 
	}
	//DR Sales Target

	
	public function dr_salestarget_entry(){
		$data = array();
		$data['dr_sales_target_entry'] = $this->drm->dr_salestarget_entry($data);
		$data['url'] = 'drc/dr_sales_target_list';
		$this->load->view('admin/QueryPage', $data);	
	}
	//pending payments
	public function dr_pending_pay_entry(){
		$data = array();
		$data['dr_entry_it'] = $this->drm->dr_entry_it($data);
		$data['message'] = '';
		$data['url'] = 'drc/dr_list_it';
		$this->load->view('admin/QueryPage', $data); 	
	}
	
	public function dr_pend_pay_filter(){
		$id = $_REQUEST['id'];

		/* if($id != ""){
			$data['get_by_id'] = $this->drm->get_by_id('dr_sales_target','dr_sales_target_id',$id);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'DR Dashboard' => 'drc',
			'Daily Report List Sales' => 'drc/dr_sales_target_list',
			'DR Form Sales Target' => 'drc/dr_sales_target?id="'.$dr_sales_target_id.'"',
		); */

		$this->load->view('admin/header');
		$this->load->view('admin/modules/dr/dr_pend_pay_filter', $data); 
		$this->load->view('admin/footer');
	}

		public function queries(){
		$this->load->view('admin/modules/dr/queries');	
	}
	
}