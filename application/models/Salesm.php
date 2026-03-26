<?php
class Salesm extends CI_Model{  
	function __construct(){   
		parent::__construct();  
	}

	function ListHead($tbl_nm){
		$query = $this->db->query("SHOW columns FROM $tbl_nm where Field not in('password','admin_pass')");
		return $query;
	}

	public function get_inq_by_id($inq_no){
		$query = $this->db->query("select * from crm_inq_mst where inq_no = '".$inq_no."'");
		return $query;
	}
}  
?>