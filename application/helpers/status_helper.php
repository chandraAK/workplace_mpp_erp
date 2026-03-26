<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('status'))
{
	//Fresh PR count
	function status($erp_status){
		
		$ci =& get_instance();
		$ci->load->database();
			
		$sql="select * from tipldb..erp_live_status where erp_status = '$erp_status'";
		
		$query = $ci->db->query($sql);
		
		foreach ($query->result() as $row) {
			$live_status = $row->live_status;
		}
		
		echo $live_status;
		
    }
			
}