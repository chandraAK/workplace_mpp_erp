<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Financec extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database(); 
		 $this->load->model('financem');
	}
	
	//Dashboard
	public function index(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/finance/finance_db', $data); 
		$this->load->view('admin/footer');
	}

	/***************************** */
	/***********Masters*********** */
	/***************************** */

	public function masters_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Masters' => 'financec/masters_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/finance/masters_db', $data); 
		$this->load->view('admin/footer');
	}

	//Company List
	public function company_list(){
		$tbl_nm = "company_mst";
		$data = array();
		$data['list_title'] = "Company List";
		$data['list_url'] = "financec/company_list";
		$data['tbl_nm'] = "company_mst";
		$data['primary_col'] = "company_id";
		$data['edit_url'] = "financec/company_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = " order by company_createddate desc";

		$data['ViewHead'] = $this->financem->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Masters' => 'financec/masters_db',
			'Company' => 'financec/company_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Company Add
	public function company_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->financem->get_by_id('company_mst','company_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Masters' => 'financec/masters_db',
			'Company' => 'financec/company_list',
			'Company Add' => 'financec/company_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/finance/company_add', $data); 
		$this->load->view('admin/footer');
	}

	//Company Entry
	public function company_entry(){
		$data = array();
		$data['company_entry'] = $this->financem->company_entry($data);
		$data['message'] = '';
		$data['url'] = 'financec/company_list';
		$this->load->view('admin/QueryPage', $data);
	}

	//Dinominations List
	public function dino_list(){
		$tbl_nm = "curr_unit_mst";
		$data = array();
		$data['list_title'] = "Dinominations";
		$data['list_url'] = "financec/dino_list";
		$data['tbl_nm'] = "curr_unit_mst";
		$data['primary_col'] = "curr_id";
		$data['edit_url'] = "financec/dino_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = " order by created_date desc";

		$data['ViewHead'] = $this->financem->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Masters' => 'financec/masters_db',
			'Dinominations' => 'financec/dino_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Dinominations Add
	public function dino_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->financem->get_by_id('curr_unit_mst','curr_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Masters' => 'financec/masters_db',
			'Dinominations' => 'financec/dino_list',
			'Dinominations Add' => 'financec/dino_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/finance/dino_add', $data); 
		$this->load->view('admin/footer');
	}

	//Dinominations Entry
	public function dino_entry(){
		$data = array();
		$data['dino_entry'] = $this->financem->dino_entry($data);
		$data['message'] = '';
		$data['url'] = 'financec/dino_list';
		$this->load->view('admin/QueryPage', $data);
	}

	/***************************** */
	/***********Masters*********** */
	/***************************** */

	//Add Cash Dinomination
	public function cash_dino_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->financem->get_by_id('labour_mst','labour_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Add' => 'financec/cash_dino_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/finance/cash_dino_add', $data); 
		$this->load->view('admin/footer');
	}

	//Cash Dinominations Entry
	public function cash_dino_entry(){
		$data = array();
		$data['cash_dino_entry'] = $this->financem->cash_dino_entry($data);
		$data['message'] = '';
		$data['url'] = 'financec';
		$this->load->view('admin/QueryPage', $data);
	}

	//check duplicate entry
	public function cash_dino_dup_chk(){
		$this->load->view("admin/modules/finance/cash_dino_dup_chk");
	}

	//Cash Dinomination Report Main
	public function cash_dino_rpt(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Report' => 'financec/cash_dino_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view("admin/modules/finance/cd_rpt", $data);
		$this->load->view('admin/footer');
	}

	//Date Wise Report Cash Dinomination
	public function cd_daterange_rpt(){
		$this->load->view("admin/modules/finance/cd_daterange_rpt");
	}

	public function cd_currdate_rpt(){
		$this->load->view("admin/modules/finance/cd_currdate_rpt");
	}

	public function cd_currdate_ajax(){
		$this->load->view("admin/modules/finance/cd_currdate_ajax");
	}

	public function cd_currdate_pdf(){
		$this->load->view("admin/modules/finance/cd_currdate_pdf");
	}
	

	public function cash_dino_rpt_ajax(){
		$this->load->view("admin/modules/finance/cd_rpt_ajax");
	}

	/**************************** */
	/********Petty Cash********** */
	/**************************** */

	//Advance
	public function pc_adv_list(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Petty Cash Advance List' => 'financec/pc_adv_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/finance/pc_adv_list', $data); 
		$this->load->view('admin/footer');
	}

	public function pc_adv_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->financem->get_by_id('petty_cash_adv','pc_adv_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Petty Cash Advance List' => 'financec/pc_adv_list',
			'Petty Cash Advance Form' => 'financec/pc_adv_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/finance/pc_adv_add', $data); 
		$this->load->view('admin/footer');
	}

	public function pc_adv_balamt(){
		$this->load->view('admin/modules/finance/pc_adv_balamt');
	}

	public function pc_adv_entry(){
		$pc_adv_id = $this->input->post("pc_adv_id");
		$data = array();
		$data['pc_adv_entry'] = $this->financem->pc_adv_entry($data);

		$data['message'] = '';
		$data['url'] = 'financec/pc_adv_list';
		$this->load->view('admin/QueryPage', $data);
	}

	public function pc_adv_app(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->financem->get_by_id('petty_cash_adv','pc_adv_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Petty Cash Advance List' => 'financec/pc_adv_list',
			'Petty Cash Advance Approval' => 'financec/pc_adv_app?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/finance/pc_adv_app', $data); 
		$this->load->view('admin/footer');
	}

	public function pc_adv_app_entry(){
		$pc_adv_id = $this->input->post("pc_adv_id");
		$data = array();
		$data['pc_adv_app_entry'] = $this->financem->pc_adv_app_entry($data);

		$data['message'] = '';
		$data['url'] = 'financec/pc_adv_list';
		
		$this->load->view('admin/QueryPage', $data);
	}

	//Expense
	public function pc_exp_list(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Petty Cash Expense List' => 'financec/pc_exp_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/finance/pc_exp_list',$data); 
		$this->load->view('admin/footer');
	}

	public function pc_exp_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->financem->get_by_id('petty_cash_exp_mst','pcexp_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Petty Cash Expense List' => 'financec/pc_exp_list',
			'Petty Cash Expense Form' => 'financec/pc_exp_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/finance/pc_exp_add', $data); 
		$this->load->view('admin/footer');
	}

	public function pc_exp_entry(){
		$pc_exp_id = $this->input->post("pc_exp_id");

		$file_name_arr = array();
		//File Attachment Code
		$number_of_files = sizeof($_FILES['pcexp_dtl_bill']['tmp_name']);
		$files = $_FILES['pcexp_dtl_bill'];
		$this->load->library('upload');
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|txt|bmp';
		
		for($i = 0; $i < $number_of_files; $i++){
			$_FILES['pcexp_dtl_bill']['name'] = $files['name'][$i];
			$_FILES['pcexp_dtl_bill']['type'] = $files['type'][$i];
			$_FILES['pcexp_dtl_bill']['tmp_name'] = $files['tmp_name'][$i];
			$_FILES['pcexp_dtl_bill']['error'] = $files['error'][$i];
			$_FILES['pcexp_dtl_bill']['size'] = $files['size'][$i];
			$RandNumber = rand(0, 9999999999); //Random number to make each filename unique.
			$filename = $_FILES['pcexp_dtl_bill']['name'];
			$fileExe  = substr($filename, strrpos($filename,'.'));
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$file = basename($filename, ".".$ext);
			$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($file));
			$NewFileName2 = $NewFileName.'_'.$RandNumber.".".$ext;
			$config['file_name'] = $NewFileName2;
			$config['remove_spaces'] = true;
			
			//now we initialize the upload library
			$this->upload->initialize($config);
			
			if ($this->upload->do_upload('pcexp_dtl_bill')){
				//$this->upload->data();
				$data = array('upload_data' => $this->upload->data());
				$file_name = $data['upload_data']['file_name'];
				rename("./uploads/$file_name","./uploads/$NewFileName2");
			} 

			array_push($file_name_arr,$NewFileName2);
		}
		
		//File Upload Code End

		//File Attachment Code Ends
		$data = array();
		$data['pc_exp_entry'] = $this->financem->pc_exp_entry($data, $file_name_arr);

		$data['message'] = '';
		$data['url'] = 'financec/pc_exp_list';
		
		$this->load->view('admin/QueryPage', $data);
	}

	public function pc_exp_app(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->financem->get_by_id('petty_cash_exp_mst','pcexp_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Finance' => 'financec',
			'Petty Cash Expense List' => 'financec/pc_exp_list',
			'Petty Cash Expense Approval' => 'financec/pc_exp_app?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/finance/pc_exp_app', $data); 
		$this->load->view('admin/footer');
	}

	public function pc_exp_app_entry(){
		$pcexp_id = $this->input->post("pcexp_id");
		$data = array();
		$data['pc_exp_app_entry'] = $this->financem->pc_exp_app_entry($data);

		$data['message'] = '';
		$data['url'] = 'financec/pc_exp_list';
		
		$this->load->view('admin/QueryPage', $data);
	}

}
