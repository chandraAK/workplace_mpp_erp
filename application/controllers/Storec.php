<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Storec extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database(); 
		 $this->load->model('storem');
	}
	
	//Dashboard
	public function index(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Store' => 'storec',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/store/store_db', $data); 
		$this->load->view('admin/footer');
	}

	//Good Load Memo List
	public function good_load_memo_list(){
		$tbl_nm = "goods_load_memo_mst";
		$data = array();
		$data['list_title'] = "Goods Load Memo Report";
		$data['list_url'] = "storec/good_load_memo_list";
		$data['tbl_nm'] = "goods_load_memo_mst";
		$data['primary_col'] = "glm_id";
		$data['edit_url'] = "storec/good_load_memo";
		$data['edit_enable'] = "no";
		$data['where_str2'] = " order by glm_id desc";

		$data['ViewHead'] = $this->storem->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Store' => 'storec',
			'Goods Load Memo List' => 'storec/good_load_memo_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function good_load_memo(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Store' => 'storec',
			'Goods Load Memo List' => 'storec/good_load_memo_list',
			'Goods Loading Memo' => 'storec/good_load_memo',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/store/good_load_memo', $data); 
		$this->load->view('admin/footer');

	}

	public function good_load_memo_ajax(){
		$this->load->view('admin/modules/store/good_load_memo_ajax'); 
	}

	public function good_load_memo_entry(){
		$data = array();
		$data['good_load_memo_entry'] = $this->storem->good_load_memo_entry($data);
		$data['message'] = '';
		$data['url'] = 'storec/good_load_memo_list';
		$this->load->view('admin/QueryPage', $data); 	

	}

	//Item FG Stock
	//Good Load Memo List
	public function item_fg_stock_list(){
		$tbl_nm = "item_fg_stock_det";
		$data = array();
		$data['list_title'] = "Item FG Stock Report";
		$data['list_url'] = "storec/item_fg_stock_list";
		$data['tbl_nm'] = "item_fg_stock_det";
		$data['primary_col'] = "ifs_det_id";
		$data['edit_url'] = "storec/item_fg_stock";
		$data['edit_enable'] = "no";
		$data['where_str2'] = " order by ifs_det_id desc";

		$data['ViewHead'] = $this->storem->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Store' => 'storec',
			'Item List' => 'storec/item_fg_stock_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');
	}

	public function item_fg_stock(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Store' => 'storec',
			'Item List' => 'storec/item_fg_stock_list',
			'Item FG Stock' => 'storec/item_fg_stock',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/store/item_fg_stock', $data); 
		$this->load->view('admin/footer');
	}

	public function item_fg_stock_entry(){
		$data = array();
		$data['item_fg_stock_entry'] = $this->storem->item_fg_stock_entry($data);
		$data['message'] = '';
		$data['url'] = 'storec/item_fg_stock_list';
		$this->load->view('admin/QueryPage', $data); 
	}


}
