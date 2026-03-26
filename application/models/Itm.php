<?php
class Itm extends CI_Model{  
	function __construct(){   
		parent::__construct();  
	}

	function ListHead($tbl_nm){
		$query = $this->db->query("SHOW columns FROM $tbl_nm where Field not in('password','admin_pass')");
		return $query;
	}

	//Id's Column
	public function get_by_id($tbl_nm, $id_col, $id){
		$query = $this->db->query("select * from $tbl_nm where $id_col = '".$id."'");
		return $query;
	}

	//Ticket Entry
	public function ticket_reg_entry($data){   
		$ticket_id = $this->input->post("ticket_id");
		$ticket_id1 = $this->input->post("ticket_id");

		if($ticket_id == ""){
			$sql_cnt = "select count(*) as count from ticket_reg_mst where substring(ticket_id,9,4) = '".date("Y")."'";
			$qry_cnt = $this->db->query($sql_cnt)->row();
			$count = $qry_cnt->count;

			if($count == 0){
				//PNI-ITT-2020-00001;
				$ticket_id = "PNI-ITT-".date("Y")."-".sprintf('%05d', 1);
			} else {
				$sql_max_id = "select max(substring(ticket_id,14,5)) as prev_no from ticket_reg_mst 
				where substring(ticket_id,9,4) = '".date("Y")."'";
				
				$qry_max_id = $this->db->query($sql_max_id)->row();
				$prev_no = $qry_max_id->prev_no;
				$new_no = $prev_no+1;
				
				$ticket_id = "PNI-ITT-".date("Y")."-".sprintf('%05d', $new_no);
			}
		}

		$created_by = $this->input->post("created_by");
		$ticket_type = $this->input->post("ticket_type");
		$ticket_severity = $this->input->post("ticket_severity");
		$ticket_module  = $this->input->post("ticket_module");
		$ticket_issue_type = $this->input->post("ticket_issue_type");
		$ticket_issue_desc = $this->input->post("ticket_issue_desc");
		$ticket_remedy  = $this->input->post("ticket_remedy");
		$ticket_comments = $this->input->post("ticket_comments");

		if($ticket_type == 1){
			$ticket_assigned_to = "45";
		} else if($ticket_type == 2){
			$ticket_assigned_to = "47";
		} else {
			$ticket_assigned_to = "47";
		}

		$ticket_status = "Pending For Assignment";

		//User Details
		$created_by = $this->input->post("created_by");
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $this->input->post("created_by");
		
		//Transaction Start
		$this->db->trans_start();

		if($ticket_id1 == ""){
			//Ticket Details Main
			$sql = $this->db->query("insert into ticket_reg_mst
			(ticket_id, ticket_type, ticket_severity, 
			ticket_module, ticket_issue_type, ticket_issue_desc, 
			ticket_remedy, ticket_comments, ticket_assigned_to, 
			created_by, created_date, modified_by, ticket_status) 
			values 
			('".$ticket_id."', '".$ticket_type."', '".$ticket_severity."', 
			'".$ticket_module."', '".$ticket_issue_type."', '".$ticket_issue_desc."', 
			'".$ticket_remedy."', '".$ticket_comments."', '".$ticket_assigned_to."',
			'".$created_by."', '".$created_date."', '".$modified_by."', '".$ticket_status."')");

		} else {

			$sql = $this->db->query("update ticket_reg_mst 
			set ticket_type = '".$ticket_type."', ticket_severity = '".$ticket_severity."', 
			ticket_module = '".$ticket_module."', ticket_issue_type = '".$ticket_issue_type."', 
			ticket_issue_desc = '".$ticket_issue_desc."', ticket_remedy = '".$ticket_remedy."', 
			ticket_comments = '".$ticket_comments."', ticket_assigned_to = '".$ticket_assigned_to."',
			created_by = '".$created_by."', created_date = '".$created_date."', 
			modified_by = '".$modified_by."', ticket_status = '".$ticket_status."',
			where ticket_id = '".$ticket_id."'");
		}

		$this->db->trans_complete();
		//Transanction Complete

		//Fetching Results
		$query = $this->db->query("select * from ticket_reg_mst where ticket_id = '".$ticket_id."'");
		return $query;

	}

	//Ticket Type Master
	function ticket_type_entry($data){
		$ticket_type_id = $this->input->post("ticket_type_id");
		$ticket_type_name = $this->input->post("ticket_type_name");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($ticket_type_id == ""){

            $sql = "insert into ticket_type_mst(ticket_type_name, created_by, created_date) 
            values('$ticket_type_name','$created_by','$created_date')";

        } else {

			$sql = "update ticket_type_mst set ticket_type_name = '$ticket_type_name', 
			created_by = '$created_by', created_date = '$created_date'
            where ticket_type_id = '$ticket_type_id'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Ticket Severity Type Master
	function ticket_severity_type_entry($data){
		$ticket_sev_id = $this->input->post("ticket_sev_id");
		$ticket_sev_name = $this->input->post("ticket_sev_name");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($ticket_type_id == ""){

            $sql = "insert into ticket_sev_mst(ticket_sev_name, created_by, created_date) 
            values('$ticket_sev_name','$created_by','$created_date')";

        } else {

			$sql = "update ticket_sev_mst set ticket_sev_name = '$ticket_sev_name', 
			created_by = '$created_by', created_date = '$created_date'
            where ticket_sev_id = '".$ticket_sev_id."'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Ticket Module Entry
	function ticket_module_entry($data){
		$ticket_module_id = $this->input->post("ticket_module_id");
		$ticket_module_name = $this->input->post("ticket_module_name");
		$ticket_type_id = $this->input->post("ticket_type_id");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($ticket_module_id == ""){

            $sql = "insert into ticket_module_mst(ticket_module_name, ticket_type_id, created_by, created_date) 
            values('$ticket_module_name','$ticket_type_id','$created_by','$created_date')";

        } else {

			$sql = "update ticket_module_mst set ticket_module_name = '$ticket_module_name', 
			ticket_type_id = '$ticket_type_id', 
			created_by = '$created_by', created_date = '$created_date'
            where ticket_module_id = '".$ticket_module_id."'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Ticket Issue Entry
	function ticket_issue_entry($data){
		$ticket_issue_id = $this->input->post("ticket_issue_id");
		$ticket_issue_name = $this->input->post("ticket_issue_name");
		$ticket_module_id = $this->input->post("ticket_module_id");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($ticket_issue_id == ""){

            $sql = "insert into ticket_issue_mst(ticket_issue_name, ticket_module_id, created_by, created_date) 
            values('".$ticket_issue_name."','".$ticket_module_id."','".$created_by."','".$created_date."')";

        } else {

			$sql = "update ticket_issue_mst set ticket_issue_name = '".$ticket_issue_name."', 
			ticket_module_id = '".$ticket_module_id."',
			created_by = '".$created_by."', created_date = '".$created_date."'
            where ticket_issue_id = '".$ticket_issue_id."'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Ticket Manager Entry
	function ticket_manager_entry($data){
		$ticket_manager_id = $this->input->post("ticket_manager_id");
		$ticket_manager_name = $this->input->post("ticket_manager_name");
		$ticket_manager_type_id = $this->input->post("ticket_manager_type_id");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($ticket_manager_id == ""){

            $sql = "insert into ticket_manager_mst(ticket_manager_name, ticket_manager_type_id, created_by, created_date) 
			values('".$ticket_manager_name."','".$ticket_manager_type_id."','".$created_by."','".$created_date."')";

        } else {

			$sql = "update ticket_manager_mst set ticket_manager_name = '".$ticket_manager_name."', 
			ticket_manager_type_id = '".$ticket_manager_type_id."',
			created_by = '".$created_by."', created_date = '".$created_date."'
			where ticket_manager_id = '".$ticket_manager_id."'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Ticket Manager Team Entry
	function ticket_manager_team_entry($data){
		$ticket_manager_team_id = $this->input->post("ticket_manager_team_id");
		$ticket_manager_team_name = $this->input->post("ticket_manager_team_name");
		$ticket_manager_type_id = $this->input->post("ticket_manager_type_id");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($ticket_manager_team_id == ""){

			$sql = "insert into ticket_manager_team_mst(ticket_manager_team_name, ticket_manager_type_id, 
			created_by, created_date) 
			values('".$ticket_manager_team_name."', '".$ticket_manager_type_id."', 
			'".$created_by."','".$created_date."')";

        } else {

			$sql = "update ticket_manager_team_mst set ticket_manager_team_name = '".$ticket_manager_team_name."', 
			ticket_manager_type_id = '".$ticket_manager_type_id."',
			created_by = '".$created_by."', created_date = '".$created_date."'
			where ticket_manager_team_id = '".$ticket_manager_team_id."'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Ticket Stages
	//Ticket Pending Assign Entry
	function ticket_pend_assign_entry($data){
		$ticket_id = $this->input->post("ticket_id");
		$ticket_assigned_to = $this->input->post("ticket_assigned_to");
		$ticket_rmks_assign = $this->input->post("ticket_rmks_assign");
		$ticket_status = "Open";
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

		$sql = "update ticket_reg_mst set ticket_assigned_to = '".$ticket_assigned_to."', 
		ticket_rmks_assign = '".$ticket_rmks_assign."',
		ticket_assigned_by = '".$created_by."', ticket_assigned_date = '".$created_date."', 
		ticket_status = '".$ticket_status."'
		where ticket_id = '".$ticket_id."'";
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Ticket Open Entry
	function ticket_open_entry($data){
		$ticket_id = $this->input->post("ticket_id");
		$ticket_assigned_to = $this->input->post("ticket_assigned_to");
		$ticket_open_rg = $this->input->post("ticket_open_rg");
		$ticket_open_rmks = $this->input->post("ticket_open_rmks");
		$ticket_open_act = $this->input->post("submit");
		if($ticket_open_act == "Re-Assign"){
			$ticket_status = "Open";
		} else {
			$ticket_status = "Pending For Clarification";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

		if($ticket_assigned_to != ""){

			$sql = "update ticket_reg_mst set ticket_assigned_to = '".$ticket_assigned_to."', 
			ticket_open_rg = '".$ticket_open_rg."', ticket_open_rmks = '".$ticket_open_rmks."',
			ticket_open_act = '".$ticket_open_act."',
			ticket_open_act_by = '".$created_by."', ticket_open_act_date = '".$created_date."', 
			ticket_status = '".$ticket_status."'
			where ticket_id = '".$ticket_id."'";

		} else {

			$sql = "update ticket_reg_mst set ticket_open_rg = '".$ticket_open_rg."', ticket_open_rmks = '".$ticket_open_rmks."',
			ticket_open_act = '".$ticket_open_act."',
			ticket_open_act_by = '".$created_by."', ticket_open_act_date = '".$created_date."', 
			ticket_status = '".$ticket_status."'
			where ticket_id = '".$ticket_id."'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Ticket PC Entry
	function ticket_pc_entry($data){
		$ticket_id = $this->input->post("ticket_id");
		$ticket_pc_rmks = $this->input->post("ticket_pc_rmks");
		$ticket_pc_act = $this->input->post("submit");
		if($ticket_pc_act == "Re-Open"){
			$ticket_status = "Open";
		} else {
			$ticket_status = "Closed";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

		$sql = "update ticket_reg_mst set ticket_pc_rmks = '".$ticket_pc_rmks."',
		ticket_pc_act = '".$ticket_pc_act."', ticket_pc_act_by = '".$created_by."', 
		ticket_pc_act_date = '".$created_date."', ticket_status = '".$ticket_status."'
		where ticket_id = '".$ticket_id."'";
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}
}  
?>