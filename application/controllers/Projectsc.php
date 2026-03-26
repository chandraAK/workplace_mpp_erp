<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Projectsc extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database(); 
		 $this->load->model('projectsm');
	}
	
	//Projects Master Dashboard
	public function index(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc'
		);
		
		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/projects_db', $data); 
		$this->load->view('admin/footer');
	}

	//Inquiry
	public function inquiry_form(){
		$inq_no = $_REQUEST['id'];
		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->projectsm->get_inq_by_id($inq_no);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Inquiry List' => 'projectsc/inquiry_list',
			'Inquiry Form' => 'projectsc/inquiry_form?id="'.$inq_no.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/inquiry_form', $data); 
		$this->load->view('admin/footer');	
	}

	public function inquiry_entry(){
		$data = array();
		$data['inquiry_entry'] = $this->projectsm->inquiry_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/inquiry_list';
		$this->load->view('admin/QueryPage', $data); 	
	}

	public function inquiry_list(){
		$tbl_nm = "inq_mst";
		$data = array();
		$data['list_title'] = "Inquiry List";
		$data['list_url'] = "projectsc/inquiry_list";
		$data['tbl_nm'] = "inq_mst";
		$data['primary_col'] = "inq_no";
		$data['edit_url'] = "projectsc/inquiry_form";
		$data['edit_enable'] = "yes";
		$data['another_link'] = "projectsc/inquiry_add_contacts";
		$data['another_link_name'] = "Add Contacts";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Inquiry List' => 'projectsc/inquiry_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function inquiry_add_contacts(){
		$inq_no = $_REQUEST['id'];

		if($inq_no != ""){
			$data['get_inq_by_id'] = $this->projectsm->get_inq_by_id($inq_no);
			$data['get_inq_conby_id'] = $this->projectsm->get_inq_conby_id($inq_no);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Inquiry List' => 'projectsc/inquiry_list',
			'Inquiry Add Contacts' => 'projectsc/inquiry_add_contacts?id="'.$inq_no.'"',
		);
		
		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/inquiry_add_contacts', $data); 
		$this->load->view('admin/footer');
	}

	public function inquiry_contact_entry(){
		$data = array();
		$data['inquiry_contact_entry'] = $this->projectsm->inquiry_contact_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/inquiry_list';
		$this->load->view('admin/QueryPage', $data); 
	}

	//Project Resources
	public function proj_res_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Resources' => 'projectsc/proj_res_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_res_db', $data); 
		$this->load->view('admin/footer');
	}

	//Project Resources Machines
	public function proj_res_mac_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Resources' => 'projectsc/proj_res_db',
			'Machines' => 'projectsc/proj_res_mac_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_res_mac_db', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_res_mac_list(){
		$tbl_nm = "machine_mst";
		$data = array();
		$data['list_title'] = "Machines List";
		$data['list_url'] = "projectsc/proj_res_mac_list";
		$data['tbl_nm'] = "machine_mst";
		$data['primary_col'] = "machine_id";
		$data['edit_url'] = "projectsc/proj_res_mac_add";
		$data['edit_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Resources' => 'projectsc/proj_res_db',
			'Machines' => 'projectsc/proj_res_mac_db',
			'Machines List' => 'projectsc/proj_res_mac_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_res_mac_add(){
		$mac_id = $_REQUEST['id'];
		if($mac_id != ""){
			$data['get_mac_by_id'] = $this->projectsm->get_mac_by_id($mac_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Resources' => 'projectsc/proj_res_db',
			'Machines' => 'projectsc/proj_res_mac_db',
			'Machines List' => 'projectsc/proj_res_mac_list',
			'Machines Add' => 'projectsc/proj_res_mac_add?id="'.$mac_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_res_mac_add', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_res_mac_entry(){
		$data = array();
		$data['mac_entry'] = $this->projectsm->mac_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_res_mac_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	//Project Resources Manpower
	public function proj_res_mp_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Resources' => 'projectsc/proj_res_db',
			'Manpower' => 'projectsc/proj_res_mp_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_res_mp_db', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_res_mp_list(){
		$tbl_nm = "manpower_mst";
		$data = array();
		$data['list_title'] = "Manpower List";
		$data['list_url'] = "projectsc/proj_res_mp_list";
		$data['tbl_nm'] = "manpower_mst";
		$data['primary_col'] = "mp_id";
		$data['edit_url'] = "projectsc/proj_res_mp_add";
		$data['edit_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Resources' => 'projectsc/proj_res_db',
			'Manpower' => 'projectsc/proj_res_mp_db',
			'Manpower List' => 'projectsc/proj_res_mp_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_res_mp_add(){
		$mp_id = $_REQUEST['id'];
		if($mp_id != ""){
			$data['get_mp_by_id'] = $this->projectsm->get_mp_by_id($mp_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Resources' => 'projectsc/proj_res_db',
			'Manpower' => 'projectsc/proj_res_mp_db',
			'Manpower List' => 'projectsc/proj_res_mp_list',
			'Manpower Add' => 'projectsc/proj_res_mac_add?id="'.$mp_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_res_mp_add', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_res_mp_entry(){
		//Attachment Pan Card
		$filename = strtolower($_FILES["pr_mp_pan"]["name"]);
		
		//file Attachment
		if( $filename !== ""){
			//echo "cha=="; die;
			$config['upload_path']   = './uploads/'; 
			$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|txt|';		
			$RandNumber = rand(0, 9999999999); //Random number to make each filename unique.
			$fileExe  = substr($filename, strrpos($filename,'.'));
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$file = basename($filename, ".".$ext);		
			$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($file));
			$NewFileName2 = $NewFileName.'_'.$RandNumber.".".$ext;
			$config['file_name'] = $NewFileName2;
			$config['log_threshold'] = 1;
			$config['overwrite'] = false;
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);			
		   
			if (!$this->upload->do_upload('pr_mp_pan')) {
			   $error = array('error' => $this->upload->display_errors());
			}else { 
			   $data = array('upload_data' => $this->upload->data());
			   $file_name = $data['upload_data']['file_name'];
			   rename("./uploads/$file_name","./uploads/$NewFileName2");
			}
		}

		//Attachment Pan Card
		$filename2 = strtolower($_FILES["pr_mp_adhar"]["name"]);
		
		//file Attachment
		if( $filename2 !== ""){
			//echo "cha=="; die;
			$config['upload_path']   = './uploads/'; 
			$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|txt|';		
			$RandNumber = rand(0, 9999999999); //Random number to make each filename unique.
			$fileExe  = substr($filename2, strrpos($filename2,'.'));
			$ext = pathinfo($filename2, PATHINFO_EXTENSION);
			$file = basename($filename2, ".".$ext);		
			$NewFileName21 = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($file));
			$NewFileName22 = $NewFileName21.'_'.$RandNumber.".".$ext;
			$config['file_name'] = $NewFileName22;
			$config['log_threshold'] = 1;
			$config['overwrite'] = false;
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);			
		   
			if (!$this->upload->do_upload('pr_mp_adhar')) {
			   $error = array('error' => $this->upload->display_errors());
			}else { 
			   $data = array('upload_data' => $this->upload->data());
			   $file_name = $data['upload_data']['file_name'];
			   rename("./uploads/$file_name","./uploads/$NewFileName22");
			}
		}



		$data = array();
		$data['mp_entry'] = $this->projectsm->mp_entry($data, $NewFileName2, $NewFileName22);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_res_mp_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	//Project Resources Quotation Master
	public function proj_res_pqm_list(){
		$tbl_nm = "pqm_mst";
		$data = array();
		$data['list_title'] = "Quotation Master List";
		$data['list_url'] = "projectsc/proj_res_pqm_list";
		$data['tbl_nm'] = "pqm_mst";
		$data['primary_col'] = "pqm_id";
		$data['edit_url'] = "projectsc/proj_res_pqm";
		$data['edit_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Resources' => 'projectsc/proj_res_db',
			'Previous Quotation List' => 'projectsc/proj_res_pqm_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_res_pqm(){
		$pqm_id = $_REQUEST['id'];
		if($pqm_id != ""){
			$data['get_pqm_by_id'] = $this->projectsm->get_pqm_by_id($pqm_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Resources' => 'projectsc/proj_res_db',
			'Previous Quotation List' => 'projectsc/proj_res_pqm_list',
			'Manpower Add' => 'projectsc/proj_res_pqm?id="'.$mp_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_res_pqm', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_res_pqm_entry(){
		//Attachment Pan Card
		$filename = strtolower($_FILES["pqm_attachment"]["name"]);
		
		//file Attachment
		if( $filename !== ""){
			//echo "cha=="; die;
			$config['upload_path']   = './uploads/'; 
			$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|txt|';		
			$RandNumber = rand(0, 9999999999); //Random number to make each filename unique.
			$fileExe  = substr($filename, strrpos($filename,'.'));
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$file = basename($filename, ".".$ext);		
			$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($file));
			$NewFileName2 = $NewFileName.'_'.$RandNumber.".".$ext;
			$config['file_name'] = $NewFileName2;
			$config['log_threshold'] = 1;
			$config['overwrite'] = false;
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);			
		   
			if (!$this->upload->do_upload('pqm_attachment')) {
			   $error = array('error' => $this->upload->display_errors());
			}else { 
			   $data = array('upload_data' => $this->upload->data());
			   $file_name = $data['upload_data']['file_name'];
			   rename("./uploads/$file_name","./uploads/$NewFileName2");
			}
		}

		$data = array();
		$data['pqm_entry'] = $this->projectsm->pqm_entry($data, $NewFileName2);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_res_pqm_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	//Items
	public function proj_item_list(){
		$tbl_nm = "item_mst";
		$data = array();
		$data['list_title'] = "Item List";
		$data['list_url'] = "projectsc/proj_item_list";
		$data['tbl_nm'] = "item_mst";
		$data['primary_col'] = "item_id";
		$data['edit_url'] = "projectsc/proj_item_add";
		$data['edit_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Item Master' => 'projectsc/proj_item_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_item_add(){
		$item_id = $_REQUEST['id'];
		if($item_id != ""){
			$data['get_item_by_id'] = $this->projectsm->get_item_by_id($item_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Item Master' => 'projectsc/proj_item_list',
			'Item Add' => 'projectsc/proj_item_add?id="'.$item_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_item_add', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_item_entry(){
		$data = array();
		$data['item_entry'] = $this->projectsm->item_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_item_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	//Site Visit Requirement
	public function proj_svr_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Site Visit Requirement' => 'projectsc/proj_svr_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_svr_db', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_svr_list(){
		$tbl_nm = "site_visit_mst";
		$data = array();
		$data['list_title'] = "Site Visit List";
		$data['list_url'] = "projectsc/proj_svr_list";
		$data['tbl_nm'] = "site_visit_mst";
		$data['primary_col'] = "visit_id";
		$data['edit_url'] = "projectsc/proj_svr_add";
		$data['edit_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Site Visit Requirement' => 'projectsc/proj_svr_db',
			'Site Visit List' => 'projectsc/proj_svr_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_svr_add(){
		$visit_id = $_REQUEST['id'];
		if($visit_id != ""){
			$data['get_svr_by_id'] = $this->projectsm->get_svr_by_id($visit_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Site Visit Requirement' => 'projectsc/proj_svr_db',
			'Schedule Visit' => 'projectsc/proj_svr_add?id="'.$visit_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_svr_add', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_svr_entry(){
		$data = array();
		$data['svr_entry'] = $this->projectsm->svr_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_svr_list';
		$this->load->view('admin/QueryPage', $data);
	}

	public function proj_svr_asg_list(){
		$tbl_nm = "site_visit_mst";
		$data = array();
		$data['list_title'] = "Site Visit Assign List";
		$data['list_url'] = "projectsc/proj_svr_list";
		$data['tbl_nm'] = "site_visit_mst";
		$data['primary_col'] = "visit_id";
		$data['edit_url'] = "projectsc/proj_svr_add";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_svr_asg";
		$data['another_link_name'] = "Assign Visit";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Site Visit Requirement' => 'projectsc/proj_svr_db',
			'Site Visit Assign List' => 'projectsc/proj_svr_asg_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_svr_asg(){
		$visit_id = $_REQUEST['id'];
		if($visit_id != ""){
			$data['get_svr_by_id'] = $this->projectsm->get_svr_by_id($visit_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Site Visit Requirement' => 'projectsc/proj_svr_db',
			'Site Visit Assign List' => 'projectsc/proj_svr_asg_list',
			'Schedule Visit Assign Form' => 'projectsc/proj_svr_asg?id="'.$visit_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_svr_asg', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_svr_asg_entry(){
		$data = array();
		$data['svr_asg_entry'] = $this->projectsm->svr_asg_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_svr_asg_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_svr_subrpt_list(){
		$tbl_nm = "site_visit_mst";
		$data = array();
		$data['list_title'] = "Site Visit Assign List";
		$data['list_url'] = "projectsc/proj_svr_subrpt_list";
		$data['tbl_nm'] = "site_visit_mst";
		$data['primary_col'] = "visit_id";
		$data['edit_url'] = "projectsc/proj_svr_add";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_svr_subrpt";
		$data['another_link_name'] = "Submit Visit Report";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Site Visit Requirement' => 'projectsc/proj_svr_db',
			'Site Visit Submit Report List' => 'projectsc/proj_svr_subrpt_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_svr_subrpt(){
		$visit_id = $_REQUEST['id'];
		if($visit_id != ""){
			$data['get_svr_by_id'] = $this->projectsm->get_svr_by_id($visit_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Site Visit Requirement' => 'projectsc/proj_svr_db',
			'Site Visit Submit Report List' => 'projectsc/proj_svr_subrpt_list',
			'Schedule Visit Submit Report Form' => 'projectsc/proj_svr_subrpt?id="'.$visit_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_svr_subrpt', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_svr_subrpt_entry(){
		$data = array();
		$data['svr_subrpt_entry'] = $this->projectsm->svr_subrpt_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_svr_subrpt_list';
		$this->load->view('admin/QueryPage', $data);
	}

	//Quotation Creation
	public function proj_quote_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote' => 'projectsc/proj_quote_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_db', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_list(){
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_add";
		$data['edit_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote' => 'projectsc/proj_quote_db',
			'Quote List' => 'projectsc/proj_quote_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_add(){
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote' => 'projectsc/proj_quote_db',
			'Quote List' => 'projectsc/proj_quote_list',
			'Quote Add' => 'projectsc/proj_quote_add?id="'.$quote_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_add', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_entry(){
		$data = array();
		$data['quote_entry'] = $this->projectsm->quote_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_list';
		$this->load->view('admin/QueryPage', $data);
	}

	//Quote PDF Generation
	public function proj_quote_pdf(){
		$this->load->library('mypdf');
		$this->load->view('admin/modules/projects/proj_quote_pdf');
	}

	public function proj_quote_app_l1_list(){
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_app_l1_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_add";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_quote_app_l1";
		$data['another_link_name'] = "L1 Approval";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote' => 'projectsc/proj_quote_db',
			'Quote Approval L1' => 'projectsc/proj_quote_app_l1_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_app_l1(){
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote' => 'projectsc/proj_quote_db',
			'Quote Approval L1 List' => 'projectsc/proj_quote_app_l1_list',
			'Quote Approval L1' => 'projectsc/proj_quote_app_l1?id="'.$quote_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_app_l1', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_app_l1_entry(){
		$data = array();
		$data['quote_app_l1_entry'] = $this->projectsm->quote_app_l1_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_app_l1_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_quote_app_l2_list(){
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_app_l2_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_add";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_quote_app_l2";
		$data['another_link_name'] = "L2 Approval";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote' => 'projectsc/proj_quote_db',
			'Quote Approval L1' => 'projectsc/proj_quote_app_l2_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_app_l2(){
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote' => 'projectsc/proj_quote_db',
			'Quote Approval L2 List' => 'projectsc/proj_quote_app_l2_list',
			'Quote Approval L2' => 'projectsc/proj_quote_app_l2?id="'.$quote_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_app_l2', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_app_l2_entry(){
		$data = array();
		$data['quote_app_l2_entry'] = $this->projectsm->quote_app_l2_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_app_l2_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_quote_stp_list(){
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_app_l2_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_add";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_quote_stp";
		$data['another_link_name'] = "Quote Send To Party";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote' => 'projectsc/proj_quote_db',
			'Quote Send To Party List' => 'projectsc/proj_quote_stp_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_stp(){
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote' => 'projectsc/proj_quote_db',
			'Quote Send To Party List' => 'projectsc/proj_quote_stp_list',
			'Quote Send To Party Form' => 'projectsc/proj_quote_stp?id="'.$quote_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_stp', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_stp_entry(){
		$data = array();
		$data['quote_stp_entry'] = $this->projectsm->quote_stp_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_stp_list';
		$this->load->view('admin/QueryPage', $data);
	}

	//Quotation Followup
	public function proj_quote_folup_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Followup' => 'projectsc/proj_quote_folup_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_folup_db', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_folup_list(){
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_folup_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_folup_add";
		$data['edit_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Follow Up' => 'projectsc/proj_quote_folup_db',
			'Quote Followup List' => 'projectsc/proj_quote_folup_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_folup_add(){
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Follow Up' => 'projectsc/proj_quote_folup_db',
			'Quote Followup List' => 'projectsc/proj_quote_folup_list',
			'Quote Followup Add' => 'projectsc/proj_quote_folup_add?id="'.$quote_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_folup_add', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_folup_entry(){
		$data = array();
		$data['quote_folup_entry'] = $this->projectsm->quote_folup_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_folup_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_quote_folup_app_l1_list(){
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_folup_app_l1_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_folup_add";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_quote_folup_app_l1";
		$data['another_link_name'] = "L1 Approval";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Follow up' => 'projectsc/proj_quote_folup_db',
			'Quote Follow up Approval L1' => 'projectsc/proj_quote_folup_app_l1_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_folup_app_l1(){
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Follow Up' => 'projectsc/proj_quote_folup_db',
			'Quote Follow Up Approval L1 List' => 'projectsc/proj_quote_folup_app_l1_list',
			'Quote Follow Up Approval L1' => 'projectsc/proj_quote_folup_app_l1?id="'.$quote_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_folup_app_l1', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_folup_app_l1_entry(){
		$data = array();
		$data['quote_folup_app_l1_entry'] = $this->projectsm->quote_folup_app_l1_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_folup_app_l1_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_quote_folup_app_l2_list(){
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_folup_app_l2_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_folup_add";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_quote_folup_app_l2";
		$data['another_link_name'] = "L2 Approval";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Followup' => 'projectsc/proj_quote_folup_db',
			'Quote Followup Approval L1' => 'projectsc/proj_quote_folup_app_l2_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_folup_app_l2(){
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Follow Up' => 'projectsc/proj_quote_folup_db',
			'Quote Follow Up Approval L2 List' => 'projectsc/proj_quote_folup_app_l2_list',
			'Quote Follow Up Approval L2' => 'projectsc/proj_quote_folup_app_l2?id="'.$quote_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_folup_app_l2', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_folup_app_l2_entry(){
		$data = array();
		$data['quote_app_l2_entry'] = $this->projectsm->quote_app_l2_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_folup_app_l2_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_quote_folup_stp_list(){
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_folup_stp_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_folup_add";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_quote_folup_stp";
		$data['another_link_name'] = "Quote Send To Party";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Follow Up' => 'projectsc/proj_quote_folup_db',
			'Quote Follow Up Send To Party List' => 'projectsc/proj_quote_folup_stp_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_folup_stp(){
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Follow Up' => 'projectsc/proj_quote_folup_db',
			'Quote Follow Up Send To Party List' => 'projectsc/proj_quote_folup_stp_list',
			'Quote Follow Up Send To Party Form' => 'projectsc/proj_quote_folup_stp?id="'.$quote_id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_folup_stp', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_folup_stp_entry(){
		$data = array();
		$data['quote_stp_entry'] = $this->projectsm->quote_stp_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_folup_stp_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	//Quotation Reject
	public function proj_quote_rej_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Reject' => 'projectsc/proj_quote_rej_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_rej_db', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_rej_list(){
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_rej_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_rej_edit";
		$data['edit_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Reject' => 'projectsc/proj_quote_rej_db',
			'Quote Revise' => 'projectsc/proj_quote_rej_list',
			'Quote Edit' => 'projectsc/proj_quote_rej_edit',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_rej_edit(){
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Reject' => 'projectsc/proj_quote_rej_db',
			'Quote Revise' => 'projectsc/proj_quote_rej_list',
			'Quote Edit' => 'projectsc/proj_quote_rej_edit?id=',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_add', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_rej_entry(){
		$data = array();
		$data['quote_rej_entry'] = $this->projectsm->quote_rej_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_rej_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_quote_rej_di_list(){
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_rej_di_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_rej_di_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_quote_rej_di";
		$data['another_link_name'] = "Drop Inquiry";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Reject' => 'projectsc/proj_quote_rej_db',
			'Quote List' => 'projectsc/proj_quote_rej_di_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_rej_di(){
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Reject' => 'projectsc/proj_quote_rej_db',
			'Quote List' => 'projectsc/proj_quote_rej_di_list',
			'Drop Inquiry' => 'projectsc/proj_quote_rej_di',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_rej_di', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_rej_di_entry(){
		$data = array();
		$data['proj_quote_rej_di_entry'] = $this->projectsm->proj_quote_rej_di_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_rej_di_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	//Quotation Accept
	public function proj_quote_acc_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Accept' => 'projectsc/proj_quote_acc_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_acc_db', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_acc_rftm_list(){ 
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_acc_rftm_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_acc_rftm_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_quote_acc_rftm";
		$data['another_link_name'] = "Request For Money";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Accept' => 'projectsc/proj_quote_acc_db',
			'Quote List' => 'projectsc/proj_quote_acc_rftm_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_acc_rftm(){ 
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Accept' => 'projectsc/proj_quote_acc_db',
			'Quote List' => 'projectsc/proj_quote_acc_rftm_list',
			'Quote Request For Money' => 'projectsc/proj_quote_acc_rftm',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_acc_rftm', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_acc_rftm_entry(){
		$data = array();
		$data['quote_acc_rftm_entry'] = $this->projectsm->quote_acc_rftm_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_acc_rftm_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_quote_acc_sfq_list(){ 
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Quote List";
		$data['list_url'] = "projectsc/proj_quote_acc_sfq_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_acc_sfq_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_quote_acc_sfq";
		$data['another_link_name'] = "Submit Final Quote";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Accept' => 'projectsc/proj_quote_acc_db',
			'Submit Final Quotation' => 'projectsc/proj_quote_acc_sfq_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_acc_sfq(){ 
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Accept' => 'projectsc/proj_quote_acc_db',
			'Submit Final Quotation List' => 'projectsc/proj_quote_acc_sfq_list',
			'Submit Final Quotation' => 'projectsc/proj_quote_acc_sfq',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_acc_sfq', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_acc_sfq_entry(){
		$data = array();
		$data['quote_acc_sfq_entry'] = $this->projectsm->quote_acc_sfq_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_acc_sfq_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_quote_acc_gpi_list(){ 
		$tbl_nm = "quote_mst";
		$data = array();
		$data['list_title'] = "Create Project From Quotation";
		$data['list_url'] = "projectsc/proj_quote_acc_gpi_list";
		$data['tbl_nm'] = "quote_mst";
		$data['primary_col'] = "quote_id";
		$data['edit_url'] = "projectsc/proj_quote_acc_gpi_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_quote_acc_gpi";
		$data['another_link_name'] = "Create Project";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Accept' => 'projectsc/proj_quote_acc_db',
			'Create Project List' => 'projectsc/proj_quote_acc_gpi_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_acc_gpi(){ 
		$quote_id = $_REQUEST['id'];
		if($quote_id != ""){
			$data['get_quote_by_id'] = $this->projectsm->get_quote_by_id($quote_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Accept' => 'projectsc/proj_quote_acc_db',
			'Create Project List' => 'projectsc/proj_quote_acc_gpi_list',
			'Create Project' => 'projectsc/proj_quote_acc_gpi',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_acc_gpi', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_acc_gpi_entry(){
		$data = array();
		$data['quote_acc_gpi_entry'] = $this->projectsm->quote_acc_gpi_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_acc_gpi_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_quote_acc_mr_list(){ 
		$tbl_nm = "proj_mst";
		$data = array();
		$data['list_title'] = "Media Requirements List";
		$data['list_url'] = "projectsc/proj_quote_acc_mr_list";
		$data['tbl_nm'] = "proj_mst";
		$data['primary_col'] = "proj_id";
		$data['edit_url'] = "projectsc/proj_quote_acc_mr_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_quote_acc_mr";
		$data['another_link_name'] = "Add Media Requirement";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Accept' => 'projectsc/proj_quote_acc_db',
			'Media Requirement List' => 'projectsc/proj_quote_acc_mr_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_quote_acc_mr(){ 
		$proj_id = $_REQUEST['id'];
		if($proj_id != ""){
			$data['get_proj_by_id'] = $this->projectsm->get_proj_by_id($proj_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Quote Accept' => 'projectsc/proj_quote_acc_db',
			'Media Requirement List' => 'projectsc/proj_quote_acc_mr_list',
			'Media Requirement' => 'projectsc/proj_quote_acc_mr',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_quote_acc_mr', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_quote_acc_mr_entry(){
		$data = array();
		$data['quote_acc_mr_entry'] = $this->projectsm->quote_acc_mr_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_quote_acc_mr_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	//Drawing Creation
	public function proj_draw_cr_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Drawing Creation' => 'projectsc/proj_draw_cr_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_draw_cr_db', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_draw_cr_list(){ 
		$tbl_nm = "proj_mst";
		$data = array();
		$data['list_title'] = "Drawing Creation List";
		$data['list_url'] = "projectsc/proj_draw_cr_list";
		$data['tbl_nm'] = "proj_mst";
		$data['primary_col'] = "proj_id";
		$data['edit_url'] = "projectsc/proj_draw_cr_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_draw_cr";
		$data['another_link_name'] = "Drawing Creation";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Drawing Creation' => 'projectsc/proj_draw_cr_db',
			'Drawing Creation List' => 'projectsc/proj_draw_cr_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_draw_cr(){ 
		$proj_id = $_REQUEST['id'];
		if($proj_id != ""){
			$data['get_proj_by_id'] = $this->projectsm->get_proj_by_id($proj_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Drawing Creation' => 'projectsc/proj_draw_cr_db',
			'Drawing Creation List' => 'projectsc/proj_draw_cr_list',
			'Drawing Creation Form' => 'projectsc/proj_draw_cr',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_draw_cr', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_draw_cr_entry(){
		$data = array();
		$data['draw_cr_entry'] = $this->projectsm->draw_cr_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_draw_cr_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_draw_appl1_list(){ 
		$tbl_nm = "proj_mst";
		$data = array();
		$data['list_title'] = "Drawing Approval List";
		$data['list_url'] = "projectsc/proj_draw_appl1_list";
		$data['tbl_nm'] = "proj_mst";
		$data['primary_col'] = "proj_id";
		$data['edit_url'] = "projectsc/proj_draw_appl1_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_draw_appl1";
		$data['another_link_name'] = "Drawing Approval L1";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Drawing Creation' => 'projectsc/proj_draw_cr_db',
			'Drawing Approval L1 List' => 'projectsc/proj_draw_appl1_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_draw_appl1(){ 
		$proj_id = $_REQUEST['id'];
		if($proj_id != ""){
			$data['get_proj_by_id'] = $this->projectsm->get_proj_by_id($proj_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Drawing Creation' => 'projectsc/proj_draw_cr_db',
			'Drawing Approval L1 List' => 'projectsc/proj_draw_appl1_list',
			'Drawing Approval L1' => 'projectsc/proj_draw_appl1',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_draw_appl1', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_draw_appl1_entry(){
		$data = array();
		$data['draw_appl1_entry'] = $this->projectsm->draw_appl1_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_draw_appl1_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_draw_appl2_list(){ 
		$tbl_nm = "proj_mst";
		$data = array();
		$data['list_title'] = "Drawing Approval List";
		$data['list_url'] = "projectsc/proj_draw_appl2_list";
		$data['tbl_nm'] = "proj_mst";
		$data['primary_col'] = "proj_id";
		$data['edit_url'] = "projectsc/proj_draw_appl2_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_draw_appl2";
		$data['another_link_name'] = "Drawing Approval L2";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Drawing Creation' => 'projectsc/proj_draw_cr_db',
			'Drawing Approval L2 List' => 'projectsc/proj_draw_appl2_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_draw_appl2(){ 
		$proj_id = $_REQUEST['id'];
		if($proj_id != ""){
			$data['get_proj_by_id'] = $this->projectsm->get_proj_by_id($proj_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Drawing Creation' => 'projectsc/proj_draw_cr_db',
			'Drawing Approval L2 List' => 'projectsc/proj_draw_appl2_list',
			'Drawing Approval L2' => 'projectsc/proj_draw_appl2',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_draw_appl2', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_draw_appl2_entry(){
		$data = array();
		$data['draw_appl2_entry'] = $this->projectsm->draw_appl2_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_draw_appl2_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	//Drawing Revision
	public function proj_draw_rev_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Drawing Revision' => 'projectsc/proj_draw_rev_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_draw_rev_db', $data); 
		$this->load->view('admin/footer');
	}

	//Material Request Dashboard
	public function proj_mr_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Material Request' => 'projectsc/proj_mr_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_mr_db', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_mr_list(){ 
		$tbl_nm = "mr_mst";
		$data = array();
		$data['list_title'] = "Material Request List";
		$data['list_url'] = "projectsc/proj_mr_list";
		$data['tbl_nm'] = "mr_mst";
		$data['primary_col'] = "mr_id";
		$data['edit_url'] = "projectsc/proj_mr";
		$data['edit_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Material Request Creation' => 'projectsc/proj_mr_db',
			'Material Request List' => 'projectsc/proj_mr_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_mr(){ 
		$mr_id = $_REQUEST['id'];
		if($mr_id != ""){
			$data['get_mr_by_id'] = $this->projectsm->get_mr_by_id($mr_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Material Request Creation' => 'projectsc/proj_mr_db',
			'Material Request List' => 'projectsc/proj_mr_list',
			'Material Request Form' => 'projectsc/proj_mr',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_mr', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_mr_entry(){
		$data = array();
		$data['mr_entry'] = $this->projectsm->mr_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_mr_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_mr_appl1_list(){ 
		$tbl_nm = "mr_mst";
		$data = array();
		$data['list_title'] = "Material Request L1 Approval List";
		$data['list_url'] = "projectsc/proj_mr_appl1_list";
		$data['tbl_nm'] = "mr_mst";
		$data['primary_col'] = "mr_id";
		$data['edit_url'] = "projectsc/proj_mr_appl1_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_mr_appl1";
		$data['another_link_name'] = "MR Approval L1";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Material Request' => 'projectsc/proj_mr_db',
			'MR Approval L1 List' => 'projectsc/proj_mr_appl1_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_mr_appl1(){ 
		$mr_id = $_REQUEST['id'];
		if($mr_id != ""){
			$data['get_mr_by_id'] = $this->projectsm->get_mr_by_id($mr_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Material Request' => 'projectsc/proj_mr_db',
			'MR Approval L1 List' => 'projectsc/proj_mr_appl1_list',
			'MR Approval L1' => 'projectsc/proj_mr_appl1',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_mr_appl1', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_mr_appl1_entry(){
		$data = array();
		$data['mr_appl1_entry'] = $this->projectsm->mr_appl1_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_mr_appl1_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_mr_appl2_list(){ 
		$tbl_nm = "mr_mst";
		$data = array();
		$data['list_title'] = "Material Request L2 Approval List";
		$data['list_url'] = "projectsc/proj_mr_appl2_list";
		$data['tbl_nm'] = "mr_mst";
		$data['primary_col'] = "mr_id";
		$data['edit_url'] = "projectsc/proj_mr_appl2_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_mr_appl2";
		$data['another_link_name'] = "MR Approval L2";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Material Request' => 'projectsc/proj_mr_db',
			'MR Approval L2 List' => 'projectsc/proj_mr_appl2_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_mr_appl2(){ 
		$mr_id = $_REQUEST['id'];
		if($mr_id != ""){
			$data['get_mr_by_id'] = $this->projectsm->get_mr_by_id($mr_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Material Request' => 'projectsc/proj_mr_db',
			'MR Approval L2 List' => 'projectsc/proj_mr_appl2_list',
			'MR Approval L2' => 'projectsc/proj_mr_appl2',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_mr_appl2', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_mr_appl2_entry(){
		$data = array();
		$data['mr_appl2_entry'] = $this->projectsm->mr_appl2_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_mr_appl2_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	//Submit Requirement From Party
	public function proj_srp_list(){ 
		$tbl_nm = "mr_mst";
		$data = array();
		$data['list_title'] = "Submit Requirement From Party";
		$data['list_url'] = "projectsc/proj_srp_list";
		$data['tbl_nm'] = "mr_mst";
		$data['primary_col'] = "mr_id";
		$data['edit_url'] = "projectsc/proj_srp_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_srp";
		$data['another_link_name'] = "Submit Requirement From Party";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Submit Requirement From Party List' => 'projectsc/proj_srp_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_srp(){ 
		$mr_id = $_REQUEST['id'];
		if($mr_id != ""){
			$data['get_mr_by_id'] = $this->projectsm->get_mr_by_id($mr_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Submit Requirement From Party List' => 'projectsc/proj_srp_list',
			'Submit Requirement From Party' => 'projectsc/proj_srp',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_srp', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_srp_entry(){
		$data = array();
		$data['srp_entry'] = $this->projectsm->srp_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_srp_list';
		$this->load->view('admin/QueryPage', $data);	
	}


	//Project Planning Dashboard
	public function proj_plan_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Planning' => 'projectsc/proj_plan_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_plan_db', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_plan_ds_list(){ 
		$tbl_nm = "mr_mst";
		$data = array();
		$data['list_title'] = "Delivery Scheduling List";
		$data['list_url'] = "projectsc/proj_plan_ds_list";
		$data['tbl_nm'] = "mr_mst";
		$data['primary_col'] = "mr_id";
		$data['edit_url'] = "projectsc/proj_plan_ds_list";
		$data['edit_enable'] = "no";
		$data['another_link'] = "projectsc/proj_plan_ds";
		$data['another_link_name'] = "Delivery Scheduling";
		$data['another_link_enable'] = "yes";

		$data['ViewHead'] = $this->projectsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Delivery Scheduling List' => 'projectsc/proj_plan_ds_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_plan_ds(){ 
		$mr_id = $_REQUEST['id'];
		if($mr_id != ""){
			$data['get_mr_by_id'] = $this->projectsm->get_mr_by_id($mr_id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Delivery Scheduling List' => 'projectsc/proj_plan_ds_list',
			'Delivery Scheduling' => 'projectsc/proj_plan_ds',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_plan_ds', $data); 
		$this->load->view('admin/footer');	
	}

	public function proj_plan_ds_entry(){
		$data = array();
		$data['srp_entry'] = $this->projectsm->srp_entry($data);
		$data['message'] = '';
		$data['url'] = 'projectsc/proj_srp_list';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function proj_pur_plan_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Planning' => 'projectsc/proj_plan_db',
			'Purchase Planning' => 'projectsc/proj_pur_plan_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_pur_plan_db', $data); 
		$this->load->view('admin/footer');
	}

	public function proj_pro_plan_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Planning' => 'projectsc/proj_plan_db',
			'Production Planning' => 'projectsc/proj_pro_plan_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_pro_plan_db', $data); 
		$this->load->view('admin/footer');
	}

	//Project FG
	public function proj_fg_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project FG' => 'projectsc/proj_fg_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_fg_db', $data); 
		$this->load->view('admin/footer');
	}

	//Project Payment
	public function proj_pay_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Payment' => 'projectsc/proj_pay_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_pay_db', $data); 
		$this->load->view('admin/footer');
	}

	//Project Dispatch
	public function proj_dspt_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Projects' => 'projectsc',
			'Project Dispatch' => 'projectsc/proj_dspt_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/projects/proj_dspt_db', $data); 
		$this->load->view('admin/footer');
	}
		
}
