<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Crmc extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database(); 
		 $this->load->model('crmm');
	}
	
	/****************************** */
	/********Dashboards************ */
	/****************************** */
	public function index(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/crm_db',$data); 
		$this->load->view('admin/footer');
	}

	public function crm_flow(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/crm_flow',$data); 
		$this->load->view('admin/footer');
	}

	public function crm_flow_app(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Approval' => 'crmc/crm_flow_app',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/crm_flow_app',$data); 
		$this->load->view('admin/footer');
	}

	/****************************** */
	/********Dashboards************ */
	/****************************** */

	//Inquiry
	public function inquiry_list(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'Inquiry List' => 'crmc/inquiry_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/inquiry_list', $data); 
		$this->load->view('admin/footer');
	}

	public function inquiry_list_ajax(){
		$this->load->view('admin/modules/crm/inquiry_list_ajax');
	}

	public function inquiry_form(){
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'Inquiry List' => 'crmc/inquiry_list',
			'Inquiry Form' => 'crmc/inquiry_form?id="'.$inq_no.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/inquiry_form', $data); 
		$this->load->view('admin/footer');	
	}

	public function inquiry_entry(){
		$inq_no = $this->input->post('inq_no');
		//Attachment Pan Card
		$filename = strtolower($_FILES["inq_file_att"]["name"]);
		
		//file Attachment
		if( $filename !== ""){
			$config['upload_path']   = './uploads/'; 
			$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|txt|';		
			$RandNumber = rand(0, 9999999999); //Random number to make each filename unique.
			$fileExe  = substr($filename, strrpos($filename,'.'));
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$file = basename($filename, ".".$ext);		
			$NewFileName = preg_replace(array('/s/', '/.[.]+/', '/[^w_.-]/'), array('_', '.', ''), strtolower($file));
			$NewFileName2 = $NewFileName.'_'.$RandNumber.".".$ext;
			$config['file_name'] = $NewFileName2;
			$config['log_threshold'] = 1;
			$config['overwrite'] = false;
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);			
		   
			if (!$this->upload->do_upload('inq_file_att')){
			   $error = array('error' => $this->upload->display_errors());
			}else { 
			   $data = array('upload_data' => $this->upload->data());
			   $file_name = $data['upload_data']['file_name'];
			   rename("./uploads/$file_name","./uploads/$NewFileName2");
			}
		}

		$data = array();
		$data['inquiry_entry'] = $this->crmm->inquiry_entry($data, $NewFileName2);
		$data['message'] = 'Inquiry Submiited Successfully...';
		if($inq_no == ""){
			$data['url'] = 'crmc/inquiry_list';
		} else {
			$data['url'] = 'crmc/inquiry_form?id='.$inq_no;
		}
		
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Inquiry View
	public function inq_view(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Inquiry View' => 'crmc/inq_view',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/inquiry_view',$data); 
		$this->load->view('admin/footer');
	}

	//View All Inquiry Stage Wise
	public function crm_view_all_inq(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'View All Inquires' => 'crmc/crm_view_all_inq',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/crm_view_all_inq',$data); 
		$this->load->view('admin/footer');
	}

	//First lvl Quotation
	public function first_lvl_quote(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'First Level Quotation' => 'crmc/first_lvl_quote?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/first_lvl_quote',$data); 
		$this->load->view('admin/footer');
	}

	//First Lvl Quotation Entry
	public function fst_lvl_entry(){
		//Attachment Pan Card
		$filename = strtolower($_FILES["att_quote"]["name"]);
		
		//file Attachment
		if( $filename !== ""){
			$config['upload_path']   = './uploads/'; 
			$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|txt|';		
			$RandNumber = rand(0, 9999999999); //Random number to make each filename unique.
			$fileExe  = substr($filename, strrpos($filename,'.'));
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$file = basename($filename, ".".$ext);		
			$NewFileName = preg_replace(array('/s/', '/.[.]+/', '/[^w_.-]/'), array('_', '.', ''), strtolower($file));
			$NewFileName2 = $NewFileName.'_'.$RandNumber.".".$ext;
			$config['file_name'] = $NewFileName2;
			$config['log_threshold'] = 1;
			$config['overwrite'] = false;
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);			
		   
			if (!$this->upload->do_upload('att_quote')) {
			   $error = array('error' => $this->upload->display_errors());
			}else { 
			   $data = array('upload_data' => $this->upload->data());
			   $file_name = $data['upload_data']['file_name'];
			   rename("./uploads/$file_name","./uploads/$NewFileName2");
			}
		}

		$data = array();
		$data['fst_lvl_entry'] = $this->crmm->fst_lvl_entry($data, $NewFileName2);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Quotation Approval L1
	public function quote_app_l1(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Quotation App L1' => 'crmc/quote_app_l1?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/quote_app_l1',$data); 
		$this->load->view('admin/footer');
	}

	//Quotation Approval L1 Entry
	public function quote_app_l1_entry(){
		$data = array();
		$data['quote_app_l1_entry'] = $this->crmm->quote_app_l1_entry($data);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Quotation Approval L2
	public function quote_app_l2(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Quotation App L2' => 'crmc/quote_app_l2?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/quote_app_l2',$data); 
		$this->load->view('admin/footer');
	}

	//Quotation Approval L2 Entry
	public function quote_app_l2_entry(){
		$data = array();
		$data['quote_app_l2_entry'] = $this->crmm->quote_app_l2_entry($data);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Technical Discussion
	public function quote_tech_dis(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Technical Discussion' => 'crmc/quote_tech_dis?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/quote_tech_dis',$data); 
		$this->load->view('admin/footer');
	}

	//Technical Discussion Entry
	public function quote_tech_dis_entry(){
		$data = array();
		$data['quote_tech_dis_entry'] = $this->crmm->quote_tech_dis_entry($data);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Initiation Facility Visit
	public function quote_iffv(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Initiation Facility Visit' => 'crmc/quote_iffv?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/quote_iffv',$data); 
		$this->load->view('admin/footer');
	}

	//Initiation Facility Visit Entry
	public function quote_iffv_entry(){
		$data = array();
		$data['quote_iffv_entry'] = $this->crmm->quote_iffv_entry($data);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Visit Awaited
	public function visit_awaited(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Visit Awaited' => 'crmc/visit_awaited?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/visit_awaited',$data); 
		$this->load->view('admin/footer');
	}

	//Visit Awaited Entry
	public function visit_awaited_entry(){
		$data = array();
		$data['visit_awaited_entry'] = $this->crmm->visit_awaited_entry($data);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Second lvl Quotation
	public function second_lvl_quote(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Second Level Quotation' => 'crmc/second_lvl_quote?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/second_lvl_quote',$data); 
		$this->load->view('admin/footer');
	}

	//Second Lvl Quotation Entry
	public function second_lvl_entry(){
		//Attachment Pan Card
		$filename = strtolower($_FILES["att_quote"]["name"]);
		
		//file Attachment
		if( $filename !== ""){
			$config['upload_path']   = './uploads/'; 
			$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|txt|';		
			$RandNumber = rand(0, 9999999999); //Random number to make each filename unique.
			$fileExe  = substr($filename, strrpos($filename,'.'));
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$file = basename($filename, ".".$ext);		
			$NewFileName = preg_replace(array('/s/', '/.[.]+/', '/[^w_.-]/'), array('_', '.', ''), strtolower($file));
			$NewFileName2 = $NewFileName.'_'.$RandNumber.".".$ext;
			$config['file_name'] = $NewFileName2;
			$config['log_threshold'] = 1;
			$config['overwrite'] = false;
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);			
		   
			if (!$this->upload->do_upload('att_quote')) {
			   $error = array('error' => $this->upload->display_errors());
			}else { 
			   $data = array('upload_data' => $this->upload->data());
			   $file_name = $data['upload_data']['file_name'];
			   rename("./uploads/$file_name","./uploads/$NewFileName2");
			}
		}

		$data = array();
		$data['second_lvl_entry'] = $this->crmm->second_lvl_entry($data, $NewFileName2);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Third lvl Quotation
	public function third_lvl_quote(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Third Level Quotation' => 'crmc/third_lvl_quote?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/third_lvl_quote',$data); 
		$this->load->view('admin/footer');
	}

	//Third Lvl Quotation Entry
	public function third_lvl_entry(){
		//Attachment Pan Card
		$filename = strtolower($_FILES["att_quote"]["name"]);
		
		//file Attachment
		if( $filename !== ""){
			$config['upload_path']   = './uploads/'; 
			$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|txt|';		
			$RandNumber = rand(0, 9999999999); //Random number to make each filename unique.
			$fileExe  = substr($filename, strrpos($filename,'.'));
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$file = basename($filename, ".".$ext);		
			$NewFileName = preg_replace(array('/s/', '/.[.]+/', '/[^w_.-]/'), array('_', '.', ''), strtolower($file));
			$NewFileName2 = $NewFileName.'_'.$RandNumber.".".$ext;
			$config['file_name'] = $NewFileName2;
			$config['log_threshold'] = 1;
			$config['overwrite'] = false;
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);			
		   
			if (!$this->upload->do_upload('att_quote')) {
			   $error = array('error' => $this->upload->display_errors());
			}else { 
			   $data = array('upload_data' => $this->upload->data());
			   $file_name = $data['upload_data']['file_name'];
			   rename("./uploads/$file_name","./uploads/$NewFileName2");
			}
		}

		$data = array();
		$data['third_lvl_entry'] = $this->crmm->third_lvl_entry($data, $NewFileName2);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//PO Received
	public function po_received(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'PO Received' => 'crmc/po_received?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/po_received',$data); 
		$this->load->view('admin/footer');
	}

	//PO Received Entry
	public function po_received_entry(){
		//Attachment Pan Card
		$filename = strtolower($_FILES["att_po"]["name"]);
		
		//file Attachment
		if( $filename !== ""){
			$config['upload_path']   = './uploads/'; 
			$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|txt|';		
			$RandNumber = rand(0, 9999999999); //Random number to make each filename unique.
			$fileExe  = substr($filename, strrpos($filename,'.'));
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$file = basename($filename, ".".$ext);		
			$NewFileName = preg_replace(array('/s/', '/.[.]+/', '/[^w_.-]/'), array('_', '.', ''), strtolower($file));
			$NewFileName2 = $NewFileName.'_'.$RandNumber.".".$ext;
			$config['file_name'] = $NewFileName2;
			$config['log_threshold'] = 1;
			$config['overwrite'] = false;
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);			
		   
			if (!$this->upload->do_upload('att_po')) {
			   $error = array('error' => $this->upload->display_errors());
			}else { 
			   $data = array('upload_data' => $this->upload->data());
			   $file_name = $data['upload_data']['file_name'];
			   rename("./uploads/$file_name","./uploads/$NewFileName2");
			}
		}

		$data = array();
		$data['po_received_entry'] = $this->crmm->po_received_entry($data, $NewFileName2);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Lead On Hold
	public function lead_on_hold(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Lead On Hold' => 'crmc/lead_onhold?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/lead_on_hold',$data); 
		$this->load->view('admin/footer');
	}

	//Lead On Hold Entry
	public function lead_on_hold_entry(){
		$data = array();
		$data['lead_on_hold_entry'] = $this->crmm->lead_on_hold_entry($data);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Closed Lost
	public function closed_lost(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Closed Lost' => 'crmc/closed_lost?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/closed_lost',$data); 
		$this->load->view('admin/footer');
	}

	//Closed Lost Entry
	public function closed_lost_entry(){
		$data = array();
		$data['closed_lost_entry'] = $this->crmm->closed_lost_entry($data);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Lead Recycled
	public function lead_recycled(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Lead Recycled' => 'crmc/lead_recycled?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/lead_recycled',$data); 
		$this->load->view('admin/footer');
	}

	//Lead Recycled Entry
	public function lead_recycled_entry(){
		$data = array();
		$data['lead_recycled_entry'] = $this->crmm->lead_recycled_entry($data);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Lead Dropped
	public function lead_dropped(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Lead Dropped' => 'crmc/lead_dropped?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/lead_dropped',$data); 
		$this->load->view('admin/footer');
	}

	//Lead Dropped Entry
	public function lead_dropped_entry(){
		$data = array();
		$data['lead_dropped_entry'] = $this->crmm->lead_dropped_entry($data);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Refer To Dealer
	public function ref_to_dealer(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Reffered To Dealer' => 'crmc/ref_to_dealer?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/ref_to_dealer',$data); 
		$this->load->view('admin/footer');
	}

	//Lead Dropped Entry
	public function ref_to_dealer_entry(){
		$data = array();
		$data['ref_to_dealer_entry'] = $this->crmm->ref_to_dealer_entry($data);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Refer To Dealer
	public function inst_dealership(){ 
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->crmm->get_inq_by_id($inq_no);
		}
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'CRM' => 'crmc',
			'CRM Stages' => 'crmc/crm_flow',
			'Interested In Dealership' => 'crmc/inst_dealership?id='.$inq_no,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/crm/inst_dealership',$data); 
		$this->load->view('admin/footer');
	}

	//Lead Dropped Entry
	public function inst_dealership_entry(){
		$data = array();
		$data['inst_dealership_entry'] = $this->crmm->inst_dealership_entry($data);
		$data['message'] = 'Data Inserted Successfully';
		$data['url'] = 'crmc/crm_flow';
		$this->load->view('admin/QueryPage', $data); 	
	}

	/***************************** */
	/***********API*************** */
	/***************************** */

	//Indiamart API Integration
	public function imart_api(){
		$date = "13-JUN-2020";

		//Api Fetch Data Datewise
		$api_url = "https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9166116677/GLUSR_MOBILE_KEY/MTU5MjAzOTIzMy4wMTI0IzE4MzQzNjQy/Start_Time/".$date."/End_Time/".$date."/";
		//$api_url = "https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9166116677/GLUSR_MOBILE_KEY/MTU5MjAzOTIzMy4wMTI0IzE4MzQzNjQy/";

		$response = file_get_contents($api_url);

		//Replacing Single Quote
		$response = str_replace("'", "", $response);
		$response = str_replace("''", " Inch", $response);

		$json_string = json_decode($response, JSON_PRETTY_PRINT);
		$error_msg = $json_string[0]['Error_Message'];

		if($error_msg == ""){
			$data['api_det_entry'] = $this->crmm->api_det_entry($json_string);
		} else {
			echo $error_msg;
		}
		
	}

	//Trade India API Integration
	public function tindia_api(){
		$date = date("Y-m-d");

		//Api Fetch Data Datewise
		$api_url = "https://www.tradeindia.com/utils/my_inquiry.html?userid=1095725&profile_id=1030814&key=a77b7312225aa15d1d6561c7821777fd&from_date=".$date."&to_date=".$date;

		//echo $api_url; die;

		$response = file_get_contents($api_url);

		//Replacing Single Quote
		$response = str_replace("'", "", $response);

		$response = str_replace("''", " Inch", $response);

		$json_string = json_decode($response, JSON_PRETTY_PRINT);
			
		$data['ti_api_entry'] = $this->crmm->ti_api_entry($json_string);

		$data['msg'] = "Api Executed Sucessfully";

		echo $data['msg'];
		
	}

	/***************************** */
	/***********API*************** */
	/***************************** */

	//Mail Test Function
	public function test_mail(){
		$this->load->library('email');
		$this->email->set_mailtype("html");

		//Email Code
		$this->email->to('chandra.sharmadb@gmail.com,notifications@mahaveergroup.net,taiyab.khan@mahaveergroup.net');
		//$this->email->from($from_email, $username);
		$this->email->from('notifications@mahaveergroup.net');
		$cc_email = "chandra.sharmadb@gmail.com, notifications@mahaveergroup.net";
		$this->email->cc($cc_email);
		$this->email->bcc('chandra.sharmadb@gmail.com');
		$subject = "test-mail";
		$this->email->subject($subject);

		$message = "test msg";
			
		$this->email->message($message);
		
		if(!$this->email->send()){
			echo $this->email->print_debugger();
			die;
		} else {
			echo "mail sent successfully";
		}
	}
	//Mail Test Function
	public function test_mail(){
		$this->load->library('email');
		$this->email->set_mailtype("html");

		//Email Code
		$this->email->to('sharma.char22@gmail.com,notifications@mahaveergroup.net,taiyab.khan@mahaveergroup.net');
		//$this->email->from($from_email, $username);
		$this->email->from('notifications@mahaveergroup.net');
		$cc_email = "chandra.sharmadb@gmail.com, notifications@mahaveergroup.net";
		$this->email->cc($cc_email);
		$this->email->bcc('chandra.sharmadb@gmail.com');
		$subject = "test-mail";
		$this->email->subject($subject);

		$message = "test msg";
			
		$this->email->message($message);
		
		if(!$this->email->send()){
			echo $this->email->print_debugger();
			die;
		} else {
			echo "mail sent successfully";
		}
	}

	//Followup Email
	public function followup_email(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$date = date("Y-m-d");

		$subject = "Inquires Pending For Follow Up ".$date;
		
		$data['follow_up_inq'] = $this->crmm->follow_up_inq($date);

		$msg .="<b>Greetings,</b><br><br>Inquires Pending For Followup are as follows,<br>";

		$msg .="
		<table border='1' cellpadding='2' cellspacing='0'>
			<tr style='background-color:#CFF'>
				<td>Inquiry No</td>
				<td>Customer Name</td>
				<td>Email</td>
				<td>Mobile</td>
				<td>Lead Remark</td>
			</tr>
		";

		$cnt = 0;
		foreach($data['follow_up_inq']->result_array() AS $row){
			$cnt++;
			$inq_no = $row['inq_no'];
			$inq_cust_nm = $row['inq_cust_nm'];
			$inq_email1 = $row['inq_email1'];
			$inq_mob1 = $row['inq_mob1'];
			$inq_lead_rmk = $row['inq_lead_rmk'];

			$msg .='
			<tr>
				<td><a href="'.base_url().'index.php/crmc/inquiry_form?id='.$inq_no.'">'.$inq_no.'</td>
				<td>'.$inq_cust_nm.'</td>
				<td>'.$inq_email1.'</td>
				<td>'.$inq_mob1.'</td>
				<td>'.$inq_lead_rmk.'</td>
			</tr>';
		}

		$msg .="</table><br><br>";

		$msg .="<b>Thanks & Regards,<br>IT Administrator | SVIPL</b>";

		//Email Code
		$this->email->to('chandra.sharmadb@gmail.com');
		$this->email->from('no-reply@choyal.info');
		$this->email->cc('chandra.sharmadb@gmail.com');
		$this->email->bcc('chandra.sharmadb@gmail.com');

		$this->email->subject($subject);	
		$this->email->message($msg);
		
		if($cnt > 0){
			if(!$this->email->send()){
				echo $this->email->print_debugger();
				die;
			} else {
				echo "mail sent successfully";
			}
		}
	}
}
