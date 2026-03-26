<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dbuserc extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database(); 
		 $this->load->model('dbuserm');
	}

	//Dashboard
	public function index(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'User DB' => 'dbuserc',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/user/user_db', $data);
		$this->load->view('admin/footer');
	}
	
	//View List User
	public function ViewList(){
		$tbl_nm = "login";
		$data = array();
		$data['list_title'] = "User List";
		$data['list_url'] = "dbuserc/ViewList";
		$data['tbl_nm'] = "login";
		$data['primary_col'] = "id";
		$data['edit_url'] = "dbuserc/add_user";
		$data['edit_enable'] = "yes";

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'User DB' => 'dbuserc',
			'User List' => 'dbuserc/ViewList',
		);

		$data['ViewHead'] = $this->dbuserm->ListHead($tbl_nm);
		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data);
		$this->load->view('admin/footer');
	}

	//Add User Form
	public function add_user(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			//'User DB' => 'dbuserc',
			'User List' => 'dbuserc/ViewList',
			'Add User' => 'dbuserc/add_user?id='
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/user/dbuserview', $data);
		$this->load->view('admin/footer');
	}

	//Add User Query
	public function RegisterUser(){
		$data = array();
		$data['UserReg'] = $this->dbuserm->UserReg($data);
		$data['message'] = '';
		$data['url'] = 'welcome/dashboard';
		$this->load->view('admin/QueryPage', $data);
	}

	//User Rights List
	public function UserRightList(){
		$tbl_nm = "rights_mst";
		$data = array();
		$data['list_title'] = "Manage Rights List";
		$data['list_url'] = "dbuserc/UserRightList";
		$data['tbl_nm'] = "rights_mst";
		$data['primary_col'] = "user_id";
		$data['edit_url'] = "dbuserc/UserRightAdd";
		$data['edit_enable'] = "yes";

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'User DB' => 'dbuserc',
			'Manage Rights' => 'dbuserc/UserRightList',
		);

		$data['ViewHead'] = $this->dbuserm->ListHead($tbl_nm);
		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data);
		$this->load->view('admin/footer');
	}

	//Add User Form
	public function UserRightAdd(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->dbuserm->get_by_id('rights_mst','user_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'User DB' => 'dbuserc',
			'User Rights List' => 'dbuserc/UserRightList',
			'User Rights Add' => 'dbuserc/UserRightAdd',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/user/UserRightAdd', $data);
		$this->load->view('admin/footer');
	}

	public function UserRightAjax(){
		$this->load->view('admin/modules/user/UserRightAjax');
	}

	//Add User Query
	public function UserRightEntry(){
		$data = array();
		$data['user_right_entry'] = $this->dbuserm->user_right_entry($data);
		$data['message'] = '';
		$data['url'] = 'dbuserc/UserRightList';
		$this->load->view('admin/QueryPage', $data);
	}

	//User Rights List
	public function module_list(){
		$tbl_nm = "menu_cat_mst";
		$data = array();
		$data['list_title'] = "User List";
		$data['list_url'] = "dbuserc/module_list";
		$data['tbl_nm'] = "menu_cat_mst";
		$data['primary_col'] = "id";
		$data['edit_url'] = "dbuserc/module_add";
		$data['edit_enable'] = "yes";

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'User DB' => 'dbuserc',
			'Module List' => 'dbuserc/module_list',
		);

		$data['ViewHead'] = $this->dbuserm->ListHead($tbl_nm);
		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data);
		$this->load->view('admin/footer');
	}

	//Add User Form
	public function module_add(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'User DB' => 'dbuserc',
			'Module List' => 'dbuserc/module_list',
			'Module Add' => 'dbuserc/module_add',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/user/module_add', $data);
		$this->load->view('admin/footer');
	}

	//Add User Query
	public function module_entry(){
		$data = array();
		$data['module_entry'] = $this->dbuserm->module_entry($data);
		$data['message'] = '';
		$data['url'] = 'dbuserc/module_list';
		$this->load->view('admin/QueryPage', $data);
	}

	/********* Masters Db */
	public function masters_db(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'User DB' => 'dbuserc',
			'Masters' => 'dbuserc/masters_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/user/masters_db', $data);
		$this->load->view('admin/footer');
	}

	//company List
	public function company_list(){
		$tbl_nm = "company_mst";
		$data = array();
		$data['list_title'] = "Company List";
		$data['list_url'] = "dbuserc/company_list";
		$data['tbl_nm'] = "company_mst";
		$data['primary_col'] = "comp_id";
		$data['edit_url'] = "dbuserc/company_add";
		$data['edit_enable'] = "yes";

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'User DB' => 'dbuserc',
			'Masters DB' => 'dbuserc/masters_db',
			'Company List' => 'dbuserc/company_list',
		);

		$data['ViewHead'] = $this->dbuserm->ListHead($tbl_nm);
		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data);
		$this->load->view('admin/footer');
	}

	//Company Add
	public function company_add(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'User DB' => 'dbuserc',
			'Company List' => 'dbuserc/company_list',
			'Company Add' => 'dbuserc/company_add',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/user/company_add', $data);
		$this->load->view('admin/footer');
	}

	//Company Entry
	public function company_entry(){
		$data = array();
		$data['company_entry'] = $this->dbuserm->company_entry($data);
		$data['message'] = '';
		$data['url'] = 'dbuserc/company_list';
		$this->load->view('admin/QueryPage', $data);
	}

	//Departments List
	public function dept_list(){
		$tbl_nm = "dept_mst";
		$data = array();
		$data['list_title'] = "Department List";
		$data['list_url'] = "dbuserc/dept_list";
		$data['tbl_nm'] = "dept_mst";
		$data['primary_col'] = "dept_id";
		$data['edit_url'] = "dbuserc/dept_add";
		$data['edit_enable'] = "yes";

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'User DB' => 'dbuserc',
			'Masters DB' => 'dbuserc/masters_db',
			'Department List' => 'dbuserc/Department_list',
		);

		$data['ViewHead'] = $this->dbuserm->ListHead($tbl_nm);
		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data);
		$this->load->view('admin/footer');
	}

	//Department Add
	public function dept_add(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'User DB' => 'dbuserc',
			'Department List' => 'dbuserc/dept_list',
			'Department Add' => 'dbuserc/dept_add',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/user/dept_add', $data);
		$this->load->view('admin/footer');
	}

	//Department Entry
	public function dept_entry(){
		$data = array();
		$data['dept_entry'] = $this->dbuserm->dept_entry($data);
		$data['message'] = '';
		$data['url'] = 'dbuserc/dept_list';
		$this->load->view('admin/QueryPage', $data);
	}


	
}
