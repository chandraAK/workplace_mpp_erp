<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Itc extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database(); 
		 $this->load->model('itm');
	}
	
	/****************************** */
	/********Dashboards************ */
	/****************************** */
	public function index(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/it_db',$data); 
		$this->load->view('admin/footer');
	}

	/****************************** */
	/********Dashboards************ */
	/****************************** */

	//Ticket List
	public function ticket_reg_list(){
		$tbl_nm = "ticket_reg_mst";
		$data = array();
		$data['list_title'] = "Ticket Register List";
		$data['list_url'] = "itc/ticket_reg_list";
		$data['tbl_nm'] = "ticket_reg_mst";
		$data['primary_col'] = "ticket_id";
		$data['edit_url'] = "itc/ticket_reg_form";
		$data['edit_enable'] = "no";
		$data['where_str'] = " order by created_date desc";

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Ticket Register List' => 'itc/ticket_reg_list',
		);

		$data['ViewHead'] = $this->itm->ListHead($tbl_nm);
		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data);
		$this->load->view('admin/footer');
	}

	public function ticket_reg_form(){
		$id = $_REQUEST['id'];

		if($id != ""){
			$data['get_by_id'] = $this->itm->get_by_id('ticket_reg_mst','ticket_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Ticket Register List' => 'itc/ticket_reg_list',
			'Ticket Register Form' => 'itc/ticket_reg_form?id="'.$id.'"',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_reg_form', $data); 
		$this->load->view('admin/footer');	
	}

	public function ticket_reg_entry(){
		//$this->load->library('email');
		//$this->email->set_mailtype("html");
		//$this->email->set_newline("\r\n");
		$data = array();
		$data['ticket_reg_entry'] = $this->itm->ticket_reg_entry($data);

		//Mail Function Starts
		/*
		$msg .="<b>Ticket Details are as follows</b><br><br>";

		$msg .="
		<table border='1' cellpadding='2' cellspacing='0'>
			<tr style='background-color:#CFF; font-weight:bold'>
				<td>Ticket ID</td>
				<td>Type</td>
				<td>Severity</td>
				<td>Module</td>
				<td>Issue Type</td>
				<td>Issue Desc</td>
				<td>Remedy</td>
				<td>Comments</td>
				<td>Assigned To</td>
				<td>Status</td>
				<td>Created By</td>
				<td>Created Date</td>
				<td>Age(Days)</td>
			</tr>
		";

		foreach($data['ticket_reg_entry']->result_array() AS $row){
			$ticket_id = $row['ticket_id'];
			$ticket_type = $row['ticket_type'];
			$ticket_severity = $row['ticket_severity'];
			$ticket_module = $row['ticket_module'];
			$ticket_issue_type = $row['ticket_issue_type'];
			$ticket_issue_desc = $row['ticket_issue_desc'];
			$ticket_remedy = $row['ticket_remedy'];
			$ticket_comments = $row['ticket_comments'];
			$ticket_assigned_to = $row['ticket_assigned_to'];
			$ticket_status = $row['ticket_status'];
			$created_by = $row['created_by'];
			$created_date = $row['created_date'];
			// Age Calculation
			$curr_date = date("Y-m-d h:i:s");
            $date1=date_create($created_date);
            $date2=date_create($curr_date);
            $age = date_diff($date1,$date2);

			$msg .='
			<tr>
				<td>'.$ticket_id.'</td>
				<td>'.$ticket_type.'</td>
				<td>'.$ticket_severity.'</td>
				<td>'.$ticket_module.'</td>
				<td>'.$ticket_issue_type.'</td>
				<td>'.$ticket_issue_desc.'</td>
				<td>'.$ticket_remedy.'</td>
				<td>'.$ticket_comments.'</td>
				<td>'.$ticket_assigned_to.'</td>
				<td>'.$ticket_status.'</td>
				<td>'.$created_by.'</td>
				<td>'.$created_date.'</td>
				<td>'.$age->format("%R%a").'</td>
			</tr>';
		}

		$msg .="</table><br><br>";

		$msg .="<b>Thanks & Regards,<br>WORKPLACE | MAHAVEER GROUP</b>";

		$subject = "New IT Ticket Ticket ID->".$ticket_id;


		//Email Code
		$this->email->to('chandra.sharmadb@gmail.com');
		$this->email->from('notifications@mahaveergroup.net');
		$this->email->cc('chandra.sharmadb@gmail.com');
		$this->email->bcc('chandra.sharmadb@gmail.com');

		$this->email->subject($subject);	
		$this->email->message($msg);
		
		if(!$this->email->send()){
			echo $this->email->print_debugger();
			die;
		} else {
			echo "mail sent successfully";
		}*/

		$data['url'] = 'itc/ticket_stages';
		$this->load->view('admin/QueryPage', $data);	
	}

	public function ticket_stages(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Ticket Stages' => 'itc/ticket_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_stages', $data); 
		$this->load->view('admin/footer');	
	}

	public function ticket_review_rpt(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Ticket Review Report' => 'itc/ticket_review_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_review_rpt', $data); 
		$this->load->view('admin/footer');	
	}

	//Ticket Assignment
	public function ticket_pend_assign(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->itm->get_by_id('ticket_reg_mst','ticket_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Ticket Stages' => 'itc/ticket_stages',
			'Ticket Pending For Assign' => 'itc/ticket_pend_assign?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_pend_assign', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Assignment Entry
	public function ticket_pend_assign_entry(){
		$data = array();
		$data['ticket_pend_assign_entry'] = $this->itm->ticket_pend_assign_entry($data);
		$data['message'] = '';
		$data['url'] = 'itc/ticket_stages';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Ticket Open
	public function ticket_open(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->itm->get_by_id('ticket_reg_mst','ticket_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Ticket Stages' => 'itc/ticket_stages',
			'Ticket Open' => 'itc/ticket_open?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_open', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Open Entry
	public function ticket_open_entry(){
		$data = array();
		$data['ticket_open_entry'] = $this->itm->ticket_open_entry($data);
		$data['message'] = '';
		$data['url'] = 'itc/ticket_stages';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Ticket Pending For Clarification
	public function ticket_pc(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->itm->get_by_id('ticket_reg_mst','ticket_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Ticket Stages' => 'itc/ticket_stages',
			'Ticket Pending For Clarification' => 'itc/ticket_pc?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_pc', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Pending For Clarification Entry
	public function ticket_pc_entry(){
		$data = array();
		$data['ticket_pc_entry'] = $this->itm->ticket_pc_entry($data);
		$data['message'] = '';
		$data['url'] = 'itc/ticket_stages';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Ticket Closed
	public function ticket_closed(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->itm->get_by_id('ticket_reg_mst','ticket_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Ticket Stages' => 'itc/ticket_stages',
			'Ticket Closed' => 'itc/ticket_closed?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_closed', $data); 
		$this->load->view('admin/footer');
	}

	/****************************** */
	/***********Masters************ */
	/****************************** */

	public function masters_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Masters' => 'itc/masters_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/masters_db',$data); 
		$this->load->view('admin/footer');
	}

	//Ticket Type List
	public function ticket_type_list(){
		$tbl_nm = "ticket_type_mst";
		$data = array();
		$data['list_title'] = "Ticket Type List";
		$data['list_url'] = "itc/ticket_type_list";
		$data['tbl_nm'] = "ticket_type_mst";
		$data['primary_col'] = "ticket_type_id";
		$data['edit_url'] = "itc/ticket_type_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "";

		$data['ViewHead'] = $this->itm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'IT' => 'itc/masters_db',
			'Ticket Types' => 'itc/ticket_type_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Add Ticket Type
	public function ticket_type_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->itm->get_by_id('ticket_type_mst','ticket_type_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Masters' => 'itc/masters_db',
			'Ticket Types' => 'itc/ticket_type_list',
			'Ticket Type Add' => 'itc/ticket_type_add'.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_type_add', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Module List Ajax
	public function ticket_module_list_ajax(){
		$this->load->view('admin/modules/it/ticket_module_list_ajax'); 
	}

	//Ticket Issue List Ajax
	public function ticket_issue_list_ajax(){
		$this->load->view('admin/modules/it/ticket_issue_list_ajax'); 
	}

	//Ticket Type Entry
	public function ticket_type_entry(){
		$data = array();
		$data['ticket_type_entry'] = $this->itm->ticket_type_entry($data);
		$data['message'] = '';
		$data['url'] = 'itc/ticket_type_list';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Ticket Severity Type List
	public function ticket_severity_list(){
		$tbl_nm = "ticket_sev_mst";
		$data = array();
		$data['list_title'] = "Ticket Type List";
		$data['list_url'] = "itc/ticket_sev_mst";
		$data['tbl_nm'] = "ticket_sev_mst";
		$data['primary_col'] = "ticket_sev_id";
		$data['edit_url'] = "itc/ticket_severity_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "";

		$data['ViewHead'] = $this->itm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Masters' => 'itc/masters_db',
			'Ticket Severity List' => 'itc/ticket_severity_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Add Ticket Severity Type
	public function ticket_severity_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->itm->get_by_id('ticket_sev_mst','ticket_sev_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Masters' => 'itc/masters_db',
			'Ticket Severity List' => 'itc/ticket_severity_list',
			'Ticket Severity Add' => 'itc/ticket_severity_add'.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_severity_add', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Severity Type Entry
	public function ticket_severity_type_entry(){
		$data = array();
		$data['ticket_severity_type_entry'] = $this->itm->ticket_severity_type_entry($data);
		$data['message'] = '';
		$data['url'] = 'itc/ticket_severity_list';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Ticket Module List
	public function ticket_module_list(){
		$tbl_nm = "ticket_module_mst";
		$data = array();
		$data['list_title'] = "Ticket Type List";
		$data['list_url'] = "itc/ticket_sev_mst";
		$data['tbl_nm'] = "ticket_module_mst";
		$data['primary_col'] = "ticket_module_id";
		$data['edit_url'] = "itc/ticket_module_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "";

		$data['ViewHead'] = $this->itm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Masters' => 'itc/masters_db',
			'Ticket Module List' => 'itc/ticket_module_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Module Add
	public function ticket_module_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->itm->get_by_id('ticket_module_mst','ticket_module_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Masters' => 'itc/masters_db',
			'Ticket Module List' => 'itc/ticket_module_list',
			'Ticket Module Add' => 'itc/ticket_module_add'.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_module_add', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Module Entry
	public function ticket_module_entry(){
		$data = array();
		$data['ticket_module_entry'] = $this->itm->ticket_module_entry($data);
		$data['message'] = '';
		$data['url'] = 'itc/ticket_module_list';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Ticket Issue List
	public function ticket_issue_list(){
		$tbl_nm = "ticket_issue_mst";
		$data = array();
		$data['list_title'] = "Ticket Issue List";
		$data['list_url'] = "itc/ticket_issue_list";
		$data['tbl_nm'] = "ticket_issue_mst";
		$data['primary_col'] = "ticket_issue_id";
		$data['edit_url'] = "itc/ticket_issue_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "";

		$data['ViewHead'] = $this->itm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Masters' => 'itc/masters_db',
			'Ticket Issue List' => 'itc/ticket_issue_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Issue Add
	public function ticket_issue_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->itm->get_by_id('ticket_issue_mst','ticket_issue_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Masters' => 'itc/masters_db',
			'Ticket Issue List' => 'itc/ticket_issue_list',
			'Ticket Issue Add' => 'itc/ticket_issue_add'.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_issue_add', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Issue Entry
	public function ticket_issue_entry(){
		$data = array();
		$data['ticket_issue_entry'] = $this->itm->ticket_issue_entry($data);
		$data['message'] = '';
		$data['url'] = 'itc/ticket_issue_list';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Ticket Manager List
	public function ticket_manager_list(){
		$tbl_nm = "ticket_manager_mst";
		$data = array();
		$data['list_title'] = "Ticket Manager List";
		$data['list_url'] = "itc/ticket_manager_list";
		$data['tbl_nm'] = "ticket_manager_mst";
		$data['primary_col'] = "ticket_manager_id";
		$data['edit_url'] = "itc/ticket_manager_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "";

		$data['ViewHead'] = $this->itm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Masters' => 'itc/masters_db',
			'Ticket Manager List' => 'itc/ticket_manager_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Manager Add
	public function ticket_manager_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->itm->get_by_id('ticket_manager_mst','ticket_manager_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Masters' => 'itc/masters_db',
			'Ticket Manager List' => 'itc/ticket_manager_list',
			'Ticket Manager Add' => 'itc/ticket_manager_add'.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_manager_add', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Manager Entry
	public function ticket_manager_entry(){
		$data = array();
		$data['ticket_manager_entry'] = $this->itm->ticket_manager_entry($data);
		$data['message'] = '';
		$data['url'] = 'itc/ticket_manager_list';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Ticket Manager List
	public function ticket_manager_team_list(){
		$tbl_nm = "ticket_manager_team_mst";
		$data = array();
		$data['list_title'] = "Ticket Manager Team List";
		$data['list_url'] = "itc/ticket_manager_team_list";
		$data['tbl_nm'] = "ticket_manager_team_mst";
		$data['primary_col'] = "ticket_manager_team_id";
		$data['edit_url'] = "itc/ticket_manager_team_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "";

		$data['ViewHead'] = $this->itm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Masters' => 'itc/masters_db',
			'Ticket Manager Team List' => 'itc/ticket_manager_team_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Manager Add
	public function ticket_manager_team_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->itm->get_by_id('ticket_manager_team_mst','ticket_manager_team_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Masters' => 'itc/masters_db',
			'Ticket Manager Team List' => 'itc/ticket_manager_team_list',
			'Ticket Manager Add' => 'itc/ticket_manage_team_add'.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/it/ticket_manager_team_add', $data); 
		$this->load->view('admin/footer');
	}

	//Ticket Manager Entry
	public function ticket_manager_team_entry(){
		$data = array();
		$data['ticket_manager_team_entry'] = $this->itm->ticket_manager_team_entry($data);
		$data['message'] = '';
		$data['url'] = 'itc/ticket_manager_team_list';
		$this->load->view('admin/QueryPage', $data); 	
	}

	/*********************************** */
	/***********Masters Ends************ */
	/*********************************** */

	//Mail Test Function
	public function test_mail(){
		$this->load->library('email');
		$this->email->set_mailtype("html");

		//Email Code
		$this->email->to('chandra.sharmadb@gmail.com');
		//$this->email->from($from_email, $username);
		$this->email->from('notifications@mahaveergroup.net');
		$cc_email = "chandra.sharmadb@gmail.com";
		$this->email->cc($cc_email);
		$this->email->bcc('chandra.sharmadb@gmail.com');
		$subject = "Charu Madam";
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
}
