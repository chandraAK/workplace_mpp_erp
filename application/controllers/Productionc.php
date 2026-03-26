<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Productionc extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database(); 
		$this->load->model('productionm');
	}
	
	//Production Dashboard
	public function index(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/production_db', $data); 
		$this->load->view('admin/footer');
	}

	//SVIPL Unit 1 Dashboard
	public function svipl_unit1_db(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'SVIPL Unit 1' => 'productionc/svipl_unit1_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/svipl_unit1_db', $data); 
		$this->load->view('admin/footer');
	}

	//SVIPL Unit 2 Dashboard
	public function svipl_unit2_db(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'SVIPL Unit 2' => 'productionc/svipl_unit2_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/svipl_unit2_db', $data); 
		$this->load->view('admin/footer');
	}

	//BM Industries Dashboard
	public function bm_indust_db(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'BM Industries' => 'productionc/bm_indust_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/bm_indust_db', $data); 
		$this->load->view('admin/footer');
	}

	/************************************************* */
	/***************** Masters *********************** */
	/************************************************* */

	//Masters Dashboard
	public function masters_db(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/masters_db', $data); 
		$this->load->view('admin/footer');
	}

	//Labour List
	public function labour_list(){
		$tbl_nm = "labour_mst";
		$data = array();
		$data['list_title'] = "Labour List";
		$data['list_url'] = "productionc/labour_list";
		$data['tbl_nm'] = "labour_mst";
		$data['primary_col'] = "labour_id";
		$data['edit_url'] = "productionc/labour_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = " order by labour_createddate desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Labours' => 'productionc/labour_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Add Labour
	public function labour_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->productionm->get_by_id('labour_mst','labour_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Labours' => 'productionc/labour_list',
			'Labours Add' => 'productionc/labour_add'.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/labour_add', $data); 
		$this->load->view('admin/footer');
	}

	//Labour Entry
	public function labour_entry(){
		$data = array();
		$data['labour_entry'] = $this->productionm->labour_entry($data);
		$data['message'] = '';
		$data['url'] = 'productionc/labour_list';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Plate List
	public function plate_list(){
		$tbl_nm = "plate_mst";
		$data = array();
		$data['list_title'] = "Plate List";
		$data['list_url'] = "productionc/plate_list";
		$data['tbl_nm'] = "plate_mst";
		$data['primary_col'] = "plate_id";
		$data['edit_url'] = "productionc/plate_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = " order by plate_createddate desc";
		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Plates' => 'productionc/plate_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Plate Add
	public function plate_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->productionm->get_by_id('plate_mst','plate_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Plates' => 'productionc/plate_list',
			'Plates Add' => 'productionc/plate_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/plate_add', $data); 
		$this->load->view('admin/footer');
	}

	//Plate Entry
	public function plate_entry(){
		$data = array();
		$data['plate_entry'] = $this->productionm->plate_entry($data);
		$data['message'] = '';
		$data['url'] = 'productionc/plate_list';
		$this->load->view('admin/QueryPage', $data); 
	}

	//Company List
	public function company_list(){
		$tbl_nm = "company_mst";
		$data = array();
		$data['list_title'] = "Company List";
		$data['list_url'] = "productionc/company_list";
		$data['tbl_nm'] = "company_mst";
		$data['primary_col'] = "company_id";
		$data['edit_url'] = "productionc/company_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = " order by company_createddate desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Company' => 'productionc/company_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Company Add
	public function company_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->productionm->get_by_id('company_mst','company_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Company' => 'productionc/company_list',
			'Company Add' => 'productionc/company_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/company_add', $data); 
		$this->load->view('admin/footer');
	}

	//Company Entry
	public function company_entry(){
		$data = array();
		$data['company_entry'] = $this->productionm->company_entry($data);
		$data['message'] = '';
		$data['url'] = 'productionc/company_list';
		$this->load->view('admin/QueryPage', $data);
	}

	//Stone Size List
	public function stone_size_list(){
		$tbl_nm = "stone_size_mst";
		$data = array();
		$data['list_title'] = "Stone Size List";
		$data['list_url'] = "productionc/stone_size_list";
		$data['tbl_nm'] = "stone_size_mst";
		$data['primary_col'] = "size_id";
		$data['edit_url'] = "productionc/stone_size_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = " order by created_date desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Stone Size' => 'productionc/stone_size_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Stone Size Add
	public function stone_size_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->productionm->get_by_id('stone_size_mst','size_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Stone Size' => 'productionc/stone_size_list',
			'Stone Size Add' => 'productionc/stone_size_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/stone_size_add', $data); 
		$this->load->view('admin/footer');
	}

	//Stone Size Entry
	public function stone_size_entry(){
		$data = array();
		$data['stone_size_entry'] = $this->productionm->stone_size_entry($data);
		$data['message'] = '';
		$data['url'] = 'productionc/stone_size_list';
		$this->load->view('admin/QueryPage', $data);
	}

	//Stone Size List
	public function stone_task_list(){
		$tbl_nm = "stone_task_mst";
		$data = array();
		$data['list_title'] = "Stone Type";
		$data['list_url'] = "productionc/stone_task_list";
		$data['tbl_nm'] = "stone_task_mst";
		$data['primary_col'] = "task_id";
		$data['edit_url'] = "productionc/stone_task_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = " order by created_date desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Stone Task' => 'productionc/stone_task_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Stone Task Add
	public function stone_task_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->productionm->get_by_id('stone_task_mst','task_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Stone Task' => 'productionc/stone_task_list',
			'Stone Task Add' => 'productionc/stone_task_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/stone_task_add', $data); 
		$this->load->view('admin/footer');
	}

	//Stone Task Entry
	public function stone_task_entry(){
		$data = array();
		$data['stone_task_entry'] = $this->productionm->stone_task_entry($data);
		$data['message'] = '';
		$data['url'] = 'productionc/stone_task_list';
		$this->load->view('admin/QueryPage', $data);
	}

	//Production Process List
	public function prod_proc_list(){
		$tbl_nm = "prod_process_mst";
		$data = array();
		$data['list_title'] = "Production Process List";
		$data['list_url'] = "productionc/prod_proc_list";
		$data['tbl_nm'] = "prod_process_mst";
		$data['primary_col'] = "process_id";
		$data['edit_url'] = "productionc/prod_proc_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = " order by created_date desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Production Process' => 'productionc/prod_proc_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Production Process Add
	public function prod_proc_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->productionm->get_by_id('prod_process_mst','process_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Production Process' => 'productionc/prod_proc_list',
			'Production Process Add' => 'productionc/prod_proc_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/prod_proc_add', $data); 
		$this->load->view('admin/footer');
	}

	//Production Process Entry
	public function prod_proc_entry(){
		$data = array();
		$data['prod_proc_entry'] = $this->productionm->prod_proc_entry($data);
		$data['message'] = '';
		$data['url'] = 'productionc/prod_proc_list';
		$this->load->view('admin/QueryPage', $data);
	}

	//Production Process List
	public function lab_jw_list(){
		$tbl_nm = "lab_jw_mst";
		$data = array();
		$data['list_title'] = "Labour Jobwork List";
		$data['list_url'] = "productionc/lab_jw_list";
		$data['tbl_nm'] = "lab_jw_mst";
		$data['primary_col'] = "ljw_id";
		$data['edit_url'] = "productionc/lab_jw_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = " order by created_date desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Labour Job Work' => 'productionc/lab_jw_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Production Process Add
	public function lab_jw_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->productionm->get_by_id('lab_jw_mst','ljw_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'Masters' => 'productionc/masters_db',
			'Labour Job Work' => 'productionc/lab_jw_list',
			'Labour Job Work Add' => 'productionc/lab_jw_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/lab_jw_add', $data); 
		$this->load->view('admin/footer');
	}

	//Production Process Entry
	public function lab_jw_entry(){
		$data = array();
		$data['lab_jw_entry'] = $this->productionm->lab_jw_entry($data);
		$data['message'] = '';
		$data['url'] = 'productionc/lab_jw_list';
		$this->load->view('admin/QueryPage', $data);
	}

	/************************************************* */
	/***************** Masters *********************** */
	/************************************************* */

	//Production List
	public function prod_plates_list(){
		$tbl_nm = "prod_plates_mst";
		$data = array();
		$data['list_title'] = "Production Plates List";
		$data['list_url'] = "productionc/plates_prod_list";
		$data['tbl_nm'] = "prod_plates_mst";
		$data['primary_col'] = "prod_id";
		$data['edit_url'] = "productionc/prod_plates_add";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "where comp_id = 1 order by prod_date desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'SVIPL Unit 1' => 'productionc/svipl_unit1_db',
			'Production' => 'productionc/prod_plates_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Production Plates Form
	public function prod_plates_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->productionm->get_by_id('prod_plates_mst','prod_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'SVIPL Unit 1' => 'productionc/svipl_unit1_db',
			'Production' => 'productionc/prod_plates_list',
			'Production Plates Add' => 'productionc/prod_plates_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/prod_plates_add', $data); 
		$this->load->view('admin/footer');
	}

	//Production Plates Entry
	public function prod_plates_entry(){
		$data = array();
		$data['prod_plates_entry'] = $this->productionm->prod_plates_entry($data);
		$data['message'] = '';
		$data['url'] = 'productionc/prod_plates_list';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Production Daily Plates
	public function prod_daily_plates(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'SVIPL Unit 1' => 'productionc/svipl_unit1_db',
			'Production Daily Plates' => 'productionc/prod_daily_plates',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/prod_daily_plates', $data); 
		$this->load->view('admin/footer');
	}

	//Production Daily Plates
	public function prod_daily_plates_ajax(){
		$this->load->view('admin/modules/production/prod_daily_plates_ajax'); 
	}

	//Production Daily Plates Labour Wise
	public function prod_daily_plates_lw(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'SVIPL Unit 1' => 'productionc/svipl_unit1_db',
			'Daily Produce' => 'productionc/prod_daily_plates_lw',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/prod_daily_plates_lw', $data); 
		$this->load->view('admin/footer');
	}

	//Production Daily Plates Labour Wise
	public function prod_daily_plates_lw_ajax(){
		$this->load->view('admin/modules/production/prod_daily_plates_lw_ajax'); 
	}

	//Chhilai List U1
	public function chhilai_list_u1(){
		$tbl_nm = "chhilai_mst";
		$data = array();
		$data['list_title'] = "Chhilai List";
		$data['list_url'] = "productionc/chhilai_list_u1";
		$data['tbl_nm'] = "chhilai_mst";
		$data['primary_col'] = "chhilai_id";
		$data['edit_url'] = "productionc/chhilai_add_u1";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "where comp_id = 1 and process_type = 'CHHILAI' order by chhilai_date desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'SVIPL Unit 1' => 'productionc/svipl_unit1_db',
			'Chhilai' => 'productionc/chhilai_list_u1',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Chhilai Form
	public function chhilai_add_u1(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->productionm->get_by_id('chhilai_mst','chhilai_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'SVIPL Unit 1' => 'productionc/svipl_unit1_db',
			'Chhilai' => 'productionc/chhilai_list_u1',
			'Chhilai Add' => 'productionc/chhilai_add?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/chhilai_add_u1', $data); 
		$this->load->view('admin/footer');
	}

	//Chhalai Entry
	public function chhilai_entry_u1(){
		$data = array();
		$data['chhilai_entry'] = $this->productionm->chhilai_entry($data);
		$data['message'] = '';
		$data['url'] = 'productionc/chhilai_list_u1';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Chhalai Entry
	public function chhilai_entry_bm(){
		$data = array();
		$data['chhilai_entry'] = $this->productionm->chhilai_entry($data);
		$data['message'] = '';
		$data['url'] = 'productionc/chhilai_list_bm';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//color memo List U1
	public function color_memo_list_u1(){
		$tbl_nm = "chhilai_mst";
		$data = array();
		$data['list_title'] = "Color Memo List";
		$data['list_url'] = "productionc/color_memo_list_u1";
		$data['tbl_nm'] = "chhilai_mst";
		$data['primary_col'] = "chhilai_id";
		$data['edit_url'] = "productionc/chhilai_add_u1";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "where comp_id = 1 and process_type = 'COLOR MEMO' order by chhilai_date desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'SVIPL Unit 1' => 'productionc/svipl_unit1_db',
			'Colour Memo' => 'productionc/color_memo_list_u1',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//bore memo List U1
	public function bore_memo_list_u1(){
		$tbl_nm = "chhilai_mst";
		$data = array();
		$data['list_title'] = "Bore Memo List";
		$data['list_url'] = "productionc/bore_memo_list_u1";
		$data['tbl_nm'] = "chhilai_mst";
		$data['primary_col'] = "chhilai_id";
		$data['edit_url'] = "productionc/chhilai_add_u1";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "where comp_id = 1 and process_type = 'BORE MEMO' order by chhilai_date desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'SVIPL Unit 1' => 'productionc/svipl_unit1_db',
			'Bore Memo' => 'productionc/bore_memo_list_u1',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//Chhilai List BM
	public function chhilai_list_bm(){
		$tbl_nm = "chhilai_mst";
		$data = array();
		$data['list_title'] = "Chhilai List";
		$data['list_url'] = "productionc/chhilai_list_bm";
		$data['tbl_nm'] = "chhilai_mst";
		$data['primary_col'] = "chhilai_id";
		$data['edit_url'] = "productionc/chhilai_add_bm";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "where comp_id = 3  and process_type = 'CHHILAI' order by chhilai_date desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'BM Industries' => 'productionc/bm_indust_db',
			'Chhilai' => 'productionc/chhilai_list_bm',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//color memo List U1
	public function color_memo_list_bm(){
		$tbl_nm = "chhilai_mst";
		$data = array();
		$data['list_title'] = "Colour Memo List";
		$data['list_url'] = "productionc/color_memo_list_bm";
		$data['tbl_nm'] = "chhilai_mst";
		$data['primary_col'] = "chhilai_id";
		$data['edit_url'] = "productionc/chhilai_add_u1";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "where comp_id = 3 and process_type = 'COLOUR MEMO' order by chhilai_date desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'BM Industries' => 'productionc/bm_indust_db',
			'Colour Memo' => 'productionc/color_memo_list_bm',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	//bore memo List U1
	public function bore_memo_list_bm(){
		$tbl_nm = "chhilai_mst";
		$data = array();
		$data['list_title'] = "Bore Memo List";
		$data['list_url'] = "productionc/bore_memo_list_bm";
		$data['tbl_nm'] = "chhilai_mst";
		$data['primary_col'] = "chhilai_id";
		$data['edit_url'] = "productionc/chhilai_add_u1";
		$data['edit_enable'] = "yes";
		$data['where_str2'] = "where comp_id = 3 and process_type = 'BORE MEMO' order by chhilai_date desc";

		$data['ViewHead'] = $this->productionm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'BM Industries' => 'productionc/bm_indust_db',
			'Bore Memo' => 'productionc/bore_memo_list_bm',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}


	//Chhilai Form
	public function chhilai_add_bm(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->productionm->get_by_id('chhilai_mst','chhiali_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Production' => 'productionc',
			'BM Industries' => 'productionc/bm_indust_db',
			'Chhilai' => 'productionc/chhilai_list_u1',
			'Chhilai Add' => 'productionc/chhilai_add_bm?id='.$id,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/production/chhilai_add_bm', $data); 
		$this->load->view('admin/footer');
	}

}
