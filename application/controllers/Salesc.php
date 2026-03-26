<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Salesc extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database(); 
		 $this->load->model('salesm');
	}
	
	/****************************** */
	/********Dashboards************ */
	/****************************** */
	public function index(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Sales' => 'salesc',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/sales/sales_db',$data); 
		$this->load->view('admin/footer');
	}

	public function pt_summary(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Sales' => 'salesc',
			'Payment Tracker Summary' => 'salesc/pt_summary',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/sales/pt_summary',$data); 
		$this->load->view('admin/footer');
	}

	public function pt_summary_ajax(){ 
		$this->load->view('admin/modules/sales/pt_summary_ajax');
	}

	//Management Approval
	public function mm_app(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Sales' => 'salesc',
			'Management Approval' => 'salesc/mm_app',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/sales/mm_app',$data); 
		$this->load->view('admin/footer');
	}

	public function dr_pend_pay_filter(){
		$id = $_REQUEST['id'];
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'DR Dashboard' => 'salesc',
		); 

		$this->load->view('admin/header');
		$this->load->view('admin/modules/sales/dr_pend_pay_filter', $data); 
		$this->load->view('admin/footer');
	}

	public function dr_pend_pay_filter_ajax(){ 
		$this->load->view('admin/modules/sales/dr_pend_pay_filter_ajax');
	}
	public function category_wise_pend(){ 
		$this->load->view('admin/modules/sales/dr_pend_pay_filter_ajax');
	}
	public function dr_pending_pay(){
		$id = $_REQUEST['id'];

		/* if($id != ""){
			$data['get_by_id'] = $this->drm->get_by_id('dr_sales_target','dr_sales_target_id',$id);
		}*/
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Sales Dashboard' => 'salesc',
			
		); 
		
		$this->load->view('admin/header');
		$this->load->view('admin/modules/sales/dr_pending_pay', $data); 
		$this->load->view('admin/footer');	
	}

		public function pend_pay_list(){
		$tbl_nm = "tab_sales_ord_item";
		$data = array();
		$data['list_title'] = "Product List";
		$data['list_url'] = "salesc/pend_pay_list";
		$data['tbl_nm'] = "tab_sales_ord_item";
		$data['primary_col'] = "id";
		//$data['edit_url'] = "drc/proj_res_mac_add";
		//$data['edit_enable'] = "yes";

		$data['ViewHead'] = $this->drm->ListHead($tbl_nm);
		

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'drc',
			'Project Resources' => 'salesc/dr_db',
			'Machines' => 'projectsc/proj_res_mac_db',
			'Machines List' => 'projectsc/proj_res_mac_list',
		);
	}
		public function inv_amount(){
			$id = $_REQUEST['id'];
		//BreadCrumb
			$data['breadcrumb'] = 
			array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Sales Dashboard' => 'salesc',
			'Pending Reports' => 'salesc/dr_pend_pay_filter',
			);

			$this->load->view('admin/header');
			$this->load->view('admin/modules/sales/inv_amount', $data); 
			$this->load->view('admin/footer');
	}
			public function inv_item_details(){
				$id = $_REQUEST['id'];
				//BreadCrumb
				$data['breadcrumb'] = 
				array(
				'Master Dashboard' => 'welcome/dashboard', 
				'Sales Dashboard' => 'salesc',
				'Customer Invoice Details' => 'salesc/inv_amount',
				'Pending Reports' => 'salesc/dr_pend_pay_filter',
				);

				$this->load->view('admin/header');
				$this->load->view('admin/modules/sales/inv_item_details', $data); 	
				$this->load->view('admin/footer');
			}

			public function sales_overdue(){
				//BreadCrumb
				$data['breadcrumb'] = 
				array(
				'Master Dashboard' => 'welcome/dashboard', 
				'Sales Dashboard' => 'salesc',
				'Customer Invoice Details' => 'salesc/inv_amount',
				'Pending Reports' => 'salesc/dr_pend_pay_filter',
				); 

				$this->load->view('admin/header');
				$this->load->view('admin/modules/sales/sales_overdue', $data); 	
				$this->load->view('admin/footer');
			}

			public function overdue(){
			$id = $_REQUEST['id'];
			//BreadCrumb
			 $data['breadcrumb'] = 
			array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Sales Dashboard' => 'salesc',
			'Customer Invoice Details' => 'salesc/inv_amount',
			'Pending Reports' => 'salesc/dr_pend_pay_filter',
			); 
 
			$this->load->view('admin/header');
			$this->load->view('admin/modules/sales/overdue', $data); 	
			$this->load->view('admin/footer');
			}

			public function product_overdue_list(){
			$id = $_REQUEST['id'];
			//BreadCrumb
			$data['breadcrumb'] = 
			array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Sales Dashboard' => 'salesc',
			'Customer Invoice Details' => 'salesc/inv_amount',
			'Pending Reports' => 'salesc/dr_pend_pay_filter',
			); 

			$this->load->view('admin/header');
			$this->load->view('admin/modules/sales/product_overdue_list', $data); 	
			$this->load->view('admin/footer');
			}

			


}