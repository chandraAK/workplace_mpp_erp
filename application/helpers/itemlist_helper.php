<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('itemlist')){	
	function item_list(){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql="select * from item_mst where item_name != '' and item_name is not null";
		
		$query = $ci->db->query($sql);
        
        $data = '<option value="">--select--</option>';
		foreach ($query->result() as $row) {
		  $item_id = $row->item_id;
          $item_name = $row->item_name;
          $item_model = $row->item_model;
          $item_size = $row->item_size;
          
          $data .= '<option value="'.$item_id.'">'.$item_name." - ".$item_model." - ".$item_size.'</option>';

		}
		
		return $data;
	}
	
	function company_list(){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql="select * from company_mst where company_active = 1 and company_id in(1,2,3)";
		
		$query = $ci->db->query($sql);
        
        $data = '<option value="">--select--</option>';
		foreach ($query->result() as $row) {
		  $company_id = $row->company_id;
          $company_code = $row->company_code;
          $company_name = $row->company_name;
          $item_size = $row->item_size;
          
          $data .= '<option value="'.$company_id.'">'.$company_code.'</option>';

		}
		
		return $data;
    }
	
}