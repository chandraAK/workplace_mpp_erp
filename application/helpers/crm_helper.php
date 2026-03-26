<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('crm')){	
	function case_count($status){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql_cnt = "select count(*) as cnt from crm_inq_mst where inq_status = '".$status."'";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
		
		return $cnt;
	}
	
	function case_det($status, $url){
		$ci =& get_instance();
		$ci->load->database();
			
		$sql_det = "select * from crm_inq_mst where inq_status = '".$status."' order by inq_rec_on desc";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
				<td>Inquiry No.</td>
				<td>Customer Name</td>
				<td>Customer Type</td>
				<td>Status</td>
				<td>Received Date</td>
				<td>Follow-Up Date</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
			$sno++;
			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/crmc/'.$url.$row->inq_no.'">'.$row->inq_no.'</td>
				<td>'.$row->inq_cust_nm.'</td>
				<td>'.$row->inq_cust_type.'</td>
				<td>'.$row->inq_status.'</td>
				<td>'.$row->inq_rec_on.'</td>
				<td>'.substr($row->inq_folup_date,0,11).'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    function get_max_inqno(){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql_enq_cnt = "select count(*) as count from crm_inq_mst where substring(inq_no,11,4) = '".date("Y")."'";
		$qry_enq_cnt = $ci->db->query($sql_enq_cnt)->row();
		$count = $qry_enq_cnt->count;

		if($count == 0){
			//SVIPL-INQ-2020-00001;
			$inq_no = "SVIPL-INQ-".date("Y")."-".sprintf('%05d', 1);
		} else {
			$sql_enq_max = "select max(substring(inq_no,16,5)) as prev_no from crm_inq_mst 
			where substring(inq_no,11,4) = '".date("Y")."'";
			
			$qry_enq_max = $ci->db->query($sql_enq_max)->row();
			$prev_no = $qry_enq_max->prev_no;
			$new_no = $prev_no+1;
			
			$inq_no = "SVIPL-INQ-".date("Y")."-".sprintf('%05d', $new_no);
        }
        
        return $inq_no;
    }
	
}