<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('it')){	
	function case_count($status){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;

		if($role == "User"){
			$where_str = " and created_by ='".$username."' order by created_date desc";
		} else {
			$where_str = " order by created_date desc";
		}
			
        $sql_cnt = "select count(*) as cnt from ticket_reg_mst where ticket_status = '".$status."' $where_str";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
		
		return $cnt;
	}
	
	function case_det($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;

		if($role == "User"){
			$where_str = " and created_by ='".$username."' order by created_date desc";
		} else {
			$where_str = " order by created_date desc";
		}
			
		$sql_det = "select * from ticket_reg_mst where ticket_status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
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
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $ticket_id = $row->ticket_id;
            $ticket_type = $row->ticket_type;
            $ticket_severity = $row->ticket_severity;
            $ticket_module = $row->ticket_module;
            $ticket_issue_type = $row->ticket_issue_type;
            $ticket_issue_desc = $row->ticket_issue_desc;
            $ticket_remedy = $row->ticket_remedy;
			$ticket_comments = $row->ticket_comments;
			$ticket_assigned_to = $row->ticket_assigned_to;
            $ticket_status = $row->ticket_status;
            $created_by = $row->created_by;
            $created_date = $row->created_date;
            $created_date = $row->created_date;
            $curr_date = date("Y-m-d h:i:s");
            $date1=date_create($created_date);
            $date2=date_create($curr_date);
            $age = date_diff($date1,$date2);

            //Ticket Type Name
            $sql_ticket_tn = "select * from ticket_type_mst where ticket_type_id = '".$ticket_type."'";
            $qry_ticket_tn = $ci->db->query($sql_ticket_tn)->row();
            $ticket_type_name = $qry_ticket_tn->ticket_type_name;

            //Ticket Severity
            $sql_ticket_sev = "select * from ticket_sev_mst where ticket_sev_id = '".$ticket_severity."'";
            $qry_ticket_sev = $ci->db->query($sql_ticket_sev)->row();
            $ticket_sev_name = $qry_ticket_sev->ticket_sev_name;

            //Ticket Module Name
            $sql_ticket_mod = "select * from ticket_module_mst where ticket_module_id = '".$ticket_module."'";
            $qry_ticket_mod = $ci->db->query($sql_ticket_mod)->row();
            $ticket_module_name = $qry_ticket_mod->ticket_module_name;

            //Ticket Issue Type Name
            $sql_ticket_it = "select * from ticket_issue_mst where ticket_issue_id = '".$ticket_issue_type."'";
            $qry_ticket_it = $ci->db->query($sql_ticket_it)->row();
			$ticket_issue_name = $qry_ticket_it->ticket_issue_name;
			
			//Ticket Assigned To Name
			if($ticket_assigned_to != "" || $ticket_assigned_to != NULL){

				$sql_ticket_assign = "select * from login where id = '".$ticket_assigned_to."'";
				$qry_ticket_assign = $ci->db->query($sql_ticket_assign)->row();
				$ticket_assign_name = $qry_ticket_assign->name;

			} else {
				$ticket_assign_name = "";
			}

			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/itc/'.$url.$ticket_id.'">'.$ticket_id.'</td>
				<td>'.$ticket_type_name.'</td>
				<td>'.$ticket_sev_name.'</td>
				<td>'.$ticket_module_name.'</td>
				<td>'.$ticket_issue_name.'</td>
				<td>'.$ticket_issue_desc.'</td>
				<td>'.$ticket_remedy.'</td>
				<td>'.$ticket_comments.'</td>
				<td>'.$ticket_assign_name.'</td>
				<td>'.$ticket_status.'</td>
				<td>'.$created_by.'</td>
				<td>'.$created_date.'</td>
				<td>'.$age->format("%R%a").'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }
	
}