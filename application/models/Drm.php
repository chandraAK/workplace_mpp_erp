<?php
class Drm extends CI_Model{  
	function __construct(){   
		parent::__construct();  
		
	}
	

	function ListHead($tbl_nm){
		$query = $this->db->query("SHOW columns FROM $tbl_nm");

		return $query;
	}
	public function get_dr_by_id($dr_id){
		$query = $this->db->query("select * from dr_mst where dr_id = '".$dr_id."'");
		return $query;
	}
	
	public function get_by_id($tbl_nm,$id_col,$id){
		$query = $this->db->query("select * from $tbl_nm where $id_col = '".$id."'");
		return $query;
	}
	
	//DR SALES TARGET

	public function dr_salestarget_entry($data){
		$dr_sales_created_by = $_SESSION['username'];
		$dr_sales_target_id = $this->input->post("dr_sales_target_id");
		$dr_sales_target_id1 = $this->input->post("dr_sales_target_id");
		

		if($dr_sales_target_id == ""){
			$sql_dr_cnt = "select count(*) as count from dr_sales_target where substring(dr_sales_target_id,8,4) = '".date("Y")."'";
			$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
			$count = $qry_dr_cnt->count;
		
			//echo $count;

		if($count == 0){
			//PNI-ST-2020-000001;
		$dr_sales_target_id = "PNI-ST-".date("Y")."-".sprintf('%06d', 1);
		}

		 else {
			
			$sql_dr_max = "select max(substring(dr_sales_target_id,13,6)) as prev_id from dr_sales_target";
			$qry_dr_max = $this->db->query($sql_dr_max)->row();
			$prev_id = $qry_dr_max->prev_id;
			$prev_id = number_format($prev_id,0,".","");
			$new_id = $prev_id+1;
			$dr_sales_target_id = "PNI-ST-".date("Y")."-".sprintf('%06d', $new_id);
	
			
		}
	}

		//$dr_sales_created_by = $this->input->post("dr_sales_created_by");
		$dr_sales_pr_name = $this->input->post("dr_sales_pr_name");
		$dr_sales_dispch_amt = $this->input->post("dr_sales_dispch_amt");
		$dr_sales_mach_amt  = $this->input->post("dr_sales_mach_amt");
		$dr_sales_pur_amt  = $this->input->post("dr_sales_pur_amt");
		$dr_sales_ord_amt  = $this->input->post("dr_sales_ord_amt");
		$dr_sales_modified_by = $this->input->post("dr_sales_modified_by");
		$dr_sales_created_date  = $this->input->post("dr_sales_created_date");
		$dr_sales_modified_date = date("Y-m-d h:i:s");
		$dr_sales_modified_by = $_SESSION['username'];

		$this->db->trans_start();

		if($dr_sales_target_id1 == ""){
			$sql_target = $this->db->query("insert into dr_sales_target (dr_sales_target_id,dr_sales_pr_name,dr_sales_dispch_amt,dr_sales_mach_amt,
			dr_sales_pur_amt,dr_sales_ord_amt,dr_sales_created_by,dr_sales_created_date,dr_sales_modified_by,dr_sales_modified_date )
			values('".$dr_sales_target_id."','".$dr_sales_pr_name."','".$dr_sales_dispch_amt."','".$dr_sales_mach_amt."',
			'".$dr_sales_pur_amt."','".$dr_sales_ord_amt."','".$dr_sales_created_by."','".$dr_sales_created_date."',
			'".$dr_sales_modified_by."','".$dr_sales_modified_date."')");
		}
	 else {

		$sql_target = $this->db->query("update dr_sales_target 
		set dr_sales_pr_name = '".$dr_sales_pr_name."' , dr_sales_dispch_amt = '".$dr_sales_dispch_amt."' , 
		dr_sales_mach_amt = '".$dr_sales_mach_amt."' , dr_sales_pur_amt = '".$dr_sales_pur_amt."', 
		dr_sales_ord_amt= '".$dr_sales_ord_amt."', dr_sales_created_by = '".$dr_sales_created_by."', 
		dr_sales_created_date = '".$dr_sales_created_date."',  dr_sales_modified_by = '".$dr_sales_modified_by."',
		dr_sales_modified_date = '".$dr_sales_modified_date."'
		 where dr_sales_target_id = '".$dr_sales_target_id."'");
	}

		$this->db->trans_complete();
}
	
	
	//Dr Entry
	public function dr_entry($data){    
		$username = $_SESSION['username'];
		$modified_by = $_SESSION['username'];
		$dr_id = $this->input->post("dr_id");
		$dr_id1 = $this->input->post("dr_id");
		$dr_date = $this->input->post("dr_date");
		//$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', 1);

		$leads_work_on = $this->input->post("leads_work_on");
		$leads_close = $this->input->post("leads_close");
		$leads_assign = $this->input->post("leads_assign");
		$sales_pr_nm = $this->input->post("sales_pr_nm");
		$leads_no = $this->input->post("leads_no");
		$meet_name = $this->input->post("meet_name");
		$frm_tim = $this->input->post("frm_tim");
		$to_tim = $this->input->post("to_tim");
		$agenda = $this->input->post("agenda");
		$total_hrs=$this->input->post("total_hrs");
		$party_nm = $this->input->post("party_nm");
		$cont_per = $this->input->post("cont_per");
		$cont_no= $this->input->post("cont_no");
		$email= $this->input->post("email");
		$remarks = $this->input->post("remarks");
		$dr_details = $this->input->post("dr_details");

		//Counts
		$arr_cnt = count($dr_details);
		$arr_cnt_la = count($sales_pr_nm);
		$arr_cnt_meet = count($meet_name);
		$arr_cnt_cust = count($party_nm);
		
		//Transaction Start
		$this->db->trans_start();
		$query = $this->db->query("select * from dept_mst where dept_name='CRM'");
		$id=$query->row();
		$id_crm=$id->dept_id;
		
		$sql_dr_cnt = "select count(*) as count from dr_mst";
		$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
		$count = $qry_dr_cnt->count;

		if($count == 0){
			//PNIDR-2020-000001;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', 1);
		} else {
			$sql_dr_max = "select max(substring(dr_id,12,6)) as prev_id from dr_mst";
			$qry_dr_max = $this->db->query($sql_dr_max)->row();
			$prev_id = $qry_dr_max->prev_id;
			$prev_id = number_format($prev_id,0,".","");
			$new_id = $prev_id+1;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', $new_id);
			
	}
		if($dr_id1 == ""){
			//Insert Code
			$sql = "insert into dr_mst(dr_id,dr_date, dr_created_by, 
			leads_work_on, leads_close, leads_assign,modified_by,dept) 
			values ('".$dr_id."','".$dr_date."', '".$username."', 
			'".$leads_work_on."', '".$leads_close."', '".$leads_assign."','".$modified_by."','$id_crm')";

			$this->db->query($sql);


			$sql_max_drid = "select max(dr_id) as dr_id from dr_mst 
			where dr_created_by = '".$username."'";
			$qry_max_drid = $this->db->query($sql_max_drid)->row();
			$dr_id = $qry_max_drid->dr_id;

			for($i=0; $i<$arr_cnt; $i++){

				$sql_itm_ins = "insert into dr_details(dr_id, dr_details) 
				values ('".$dr_id."', '".$dr_details[$i]."')";

				$qry_itm_ins = $this->db->query($sql_itm_ins);
			}
			
			for($j=0; $j<$arr_cnt_la; $j++){

				$sql2 = "insert into dr_lead_assign(dr_id, name , leads_no) 
				values ('".$dr_id."','".$sales_pr_nm[$j]."', '".$leads_no[$j]."')";

				$qry2 = $this->db->query($sql2);
			}
			for($k=0; $k<$arr_cnt_meet; $k++){

				$sql3 = "insert into dr_meet(dr_id, name, from_time, to_time, 
				agenda,total_hrs) 
				values ('".$dr_id."','".$meet_name[$k]."','".$frm_tim[$k]."','".$to_tim[$k]."',
				'".$agenda[$k]."','".$total_hrs[$k]."')";

				$qry3 = $this->db->query($sql3);
				
				
			}
			for($l=0; $l<$arr_cnt_cust; $l++){

				$sql4 = "insert into dr_cust_int(dr_id, party_name , cont_person , 
				cont_no , email ,remarks) 
				values ('".$dr_id."', '".$party_nm[$l]."','".$cont_per[$l]."',
				'".$cont_no[$l]."','".$email[$l]."','".$remarks[$l]."')";

				$qry4 = $this->db->query($sql4);
			}
			

		} else {
			//Update Code
			
			$sql = "update dr_mst set dr_date = '".$dr_date."', dr_created_by = '".$username."',
			leads_work_on = '".$leads_work_on."', leads_close = '".$leads_close."', 
			leads_assign = '".$leads_assign."'
			where dr_id = '".$dr_id1."'";

			$this->db->query($sql);

			//Count Leads
			$sql_lead_cnt = "select count(*) as ld_cnt from dr_lead_assign where dr_id = '".$dr_id1."'";
			$qry_lead_cnt = $this->db->query($sql_lead_cnt)->row();
			$ld_cnt = $qry_lead_cnt->ld_cnt;
		
			
			if($ld_cnt > 0){
				$sql_ld_del = "delete from dr_lead_assign where dr_id = '".$dr_id1."'";
				$qry_ld_del = $this->db->query($sql_ld_del);
				

				for($i=0; $i<$arr_cnt_la; $i++){

					$sql_ld_ins = "insert into dr_lead_assign(dr_id,name,leads_no) 
					values ('".$dr_id1."', '".$sales_pr_nm[$i]."','".$leads_no[$i]."')";

                    $qry_ld_ins = $this->db->query($sql_ld_ins);

				}
			} else {
				for($i=0; $i<$arr_cnt_la; $i++){

					$sql_ld_ins = "insert into dr_lead_assign(dr_id,name, leads_no) 
                    values ('".$dr_id1."', '".$sales_pr_nm[$i]."','".$leads_no[$i]."')";

					$qry_ld_ins = $this->db->query($sql_ld_ins);

				}
			}

			//count meets
			$sql_meet_cnt = "select count(*) as meet_cnt from dr_meet where dr_id = '".$dr_id1."'";
			$qry_meet_cnt = $this->db->query($sql_meet_cnt)->row();
			$meet_cnt = $qry_meet_cnt->meet_cnt;

			if($meet_cnt > 0){
				$sql_meet_del = "delete from dr_meet where dr_id = '".$dr_id1."'";
				$qry_meet_del = $this->db->query($sql_meet_del);

				for($i=0; $i<$arr_cnt_meet; $i++){

					$sql_meet_ins = "insert into dr_meet(dr_id,name ,from_time ,to_time, 
					agenda,total_hrs) 
					values ('".$dr_id1."', '".$meet_name[$i]."','".$frm_tim[$i]."','".$to_tim[$i]."',
					'".$agenda[$i]."','".$total_hrs[$i]."')";

                    $qry_meet_ins = $this->db->query($sql_meet_ins);

				}
			} else {
				for($i=0; $i<$arr_cnt_la; $i++){

					$sql_meet_ins = "insert into dr_meet(dr_id,name ,from_time ,to_time, 
					agenda,total_hrs) 
					values ('".$dr_id1."', '".$meet_name[$i]."','".$frm_tim[$i]."','".$to_tim[$i]."',
					'".$agenda[$i]."','".$total_hrs[$i]."')";

                    $qry_meet_ins = $this->db->query($sql_meet_ins);
				}
			}

			//count cust_int
			$sql_cust_cnt = "select count(*) as cust_cnt from dr_cust_int where dr_id = '".$dr_id1."'";
			$qry_cust_cnt = $this->db->query($sql_cust_cnt)->row();
			$cust_cnt = $qry_cust_cnt->cust_cnt;

			if($cust_cnt > 0){
				$sql_cust_del = "delete from dr_cust_int where dr_id = '".$dr_id1."'";
				$qry_cust_del = $this->db->query($sql_cust_del);

				for($l=0; $l<$arr_cnt_cust; $l++){

					$sql4 = "insert into dr_cust_int(dr_id, party_name , cont_person , 
					cont_no , email ,remarks) 
					values ('".$dr_id1."', '".$party_nm[$l]."','".$cont_per[$l]."',
					'".$cont_no[$l]."','".$email[$l]."','".$remarks[$l]."')";
	
					$qry4 = $this->db->query($sql4);
				}
			} else {
				for($l=0; $l<$arr_cnt_cust; $l++){

					$sql4 = "insert into dr_cust_int(dr_id, party_name , cont_person , 
					cont_no , email ,remarks) 
					values ('".$dr_id1."', '".$party_nm[$l]."','".$cont_per[$l]."',
					'".$cont_no[$l]."','".$email[$l]."','".$remarks[$l]."')";
	
					$qry4 = $this->db->query($sql4);
				}
			}
			

			//count dr_details
			$sql_dr_cnt = "select count(*) as cnt from dr_details where dr_id = '".$dr_id1."'";
			$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
			$cnt = $qry_dr_cnt->cnt;

			if($cnt > 0){
				$sql_itm_del = "delete from dr_details where dr_id = '".$dr_id1."'";
				$qry_itm_del = $this->db->query($sql_itm_del);

				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into dr_details(dr_id, dr_details) 
					values ('".$dr_id1."', '".$dr_details[$i]."')";
	
					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			} else {
				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into dr_details(dr_id, dr_details) 
					values ('".$dr_id1."', '".$dr_details[$i]."')";
	
					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			}
		}
		
		
		$this->db->trans_complete();
	}
	
		//Transanction Complete
	 
		//Dr Entry IT
		public function dr_entry_it($data){    
		$username = $_SESSION['username'];
		$dr_id = $this->input->post("dr_id");
		$dr_id1 = $this->input->post("dr_id");
		$dr_date = $this->input->post("dr_date");
		$dr_created_date = date("Y-m-d h:i:s");
		//echo $dr_created_date;die;
		$modified_by = $_SESSION['username'];
		//$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', 1);

		$dr_details = $this->input->post("dr_details");

		//Counts
		$arr_cnt = count($dr_details);

		//Transaction Start
		$this->db->trans_start();
		$query = $this->db->query("select * from dept_mst where dept_name='IT'");
		$id=$query->row();
		$id_it=$id->dept_id;
	
		$sql_dr_cnt = "select count(*) as count from dr_mst";
		$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
		$count = $qry_dr_cnt->count;

		if($count == 0){
			//PNIDR-2020-000001;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', 1);
		} else {
			$sql_dr_max = "select max(substring(dr_id,12,6)) as prev_id from dr_mst";
			$qry_dr_max = $this->db->query($sql_dr_max)->row();
			$prev_id = $qry_dr_max->prev_id;
			$prev_id = number_format($prev_id,0,".","");
			$new_id = $prev_id+1;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', $new_id);
		}
		
		if($dr_id1 == ""){
			//Insert Code
			$sql = "insert into dr_mst(dr_id,dr_date, dr_created_by, dr_created_date, modified_by,dept) 
			values ('".$dr_id."','".$dr_date."', '".$username."','".$dr_created_date."','".$modified_by."','$id_it')";
			//echo $dr_created_date; die;

			$this->db->query($sql);

			for($i=0; $i<$arr_cnt; $i++){

				$sql_itm_ins = "insert into dr_details(dr_id, dr_details) 
				values ('".$dr_id."', '".$dr_details[$i]."')";

				$qry_itm_ins = $this->db->query($sql_itm_ins);
			}

		} else {
			//Update Code
			
			$sql = "update dr_mst set dr_date = '".$dr_date."', dr_created_by = '".$username."'
			where dr_id = '".$dr_id1."'";

			$this->db->query($sql);
			//count dr_details
			$sql_dr_cnt = "select count(*) as cnt from dr_details where dr_id = '".$dr_id1."'";
			$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
			$cnt = $qry_dr_cnt->cnt;

			if($cnt > 0){
				$sql_itm_del = "delete from dr_details where dr_id = '".$dr_id1."'";
				$qry_itm_del = $this->db->query($sql_itm_del);

				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into dr_details(dr_id, dr_details) 
					values ('".$dr_id1."', '".$dr_details[$i]."')";
	
					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			} else {
				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into dr_details(dr_id, dr_details) 
					values ('".$dr_id1."', '".$dr_details[$i]."')";
	
					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			}

		}
		
		$this->db->trans_complete();
		//Transanction Complete
	 }

	 //Dr Entry design
	 public function dr_entry_design($data){    
		$username = $_SESSION['username'];
		$dr_id = $this->input->post("dr_id");
		$dr_id1 = $this->input->post("dr_id");
		$dr_date = $this->input->post("dr_date");
		$dr_created_date = date("Y-m-d h:i:s");
		//echo $dr_created_date;die;
		$modified_by = $_SESSION['username'];
		//$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', 1);

		$dr_details = $this->input->post("dr_details");

		//Counts
		$arr_cnt = count($dr_details);

		//Transaction Start
		$this->db->trans_start();
		$query = $this->db->query("select * from dept_mst where dept_name='DESIGN'");
		$id=$query->row();
		$id_design=$id->dept_id;
	
		$sql_dr_cnt = "select count(*) as count from dr_mst";
		$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
		$count = $qry_dr_cnt->count;

		if($count == 0){
			//PNIDR-2020-000001;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', 1);
		} else {
			$sql_dr_max = "select max(substring(dr_id,12,6)) as prev_id from dr_mst";
			$qry_dr_max = $this->db->query($sql_dr_max)->row();
			$prev_id = $qry_dr_max->prev_id;
			$prev_id = number_format($prev_id,0,".","");
			$new_id = $prev_id+1;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', $new_id);
		}
		
		if($dr_id1 == ""){
			//Insert Code
			$sql = "insert into dr_mst(dr_id,dr_date, dr_created_by, dr_created_date, modified_by, dept) 
			values ('".$dr_id."','".$dr_date."', '".$username."','".$dr_created_date."','".$modified_by."','$id_design')";
			//echo $dr_created_date; die;

			$this->db->query($sql);

			for($i=0; $i<$arr_cnt; $i++){

				$sql_itm_ins = "insert into dr_details(dr_id, dr_details) 
				values ('".$dr_id."', '".$dr_details[$i]."')";

				$qry_itm_ins = $this->db->query($sql_itm_ins);
			}

		} else {
			//Update Code
			
			$sql = "update dr_mst set dr_date = '".$dr_date."', dr_created_by = '".$username."'
			where dr_id = '".$dr_id1."'";

			$this->db->query($sql);
			//count dr_details
			$sql_dr_cnt = "select count(*) as cnt from dr_details where dr_id = '".$dr_id1."'";
			$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
			$cnt = $qry_dr_cnt->cnt;

			if($cnt > 0){
				$sql_itm_del = "delete from dr_details where dr_id = '".$dr_id1."'";
				$qry_itm_del = $this->db->query($sql_itm_del);

				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into dr_details(dr_id, dr_details) 
					values ('".$dr_id1."', '".$dr_details[$i]."')";
	
					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			} else {
				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into dr_details(dr_id, dr_details) 
					values ('".$dr_id1."', '".$dr_details[$i]."')";
	
					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			}

		}
		
		$this->db->trans_complete();
		//Transanction Complete
	 }
	 //Dr Entry SALES 
	 public function dr_entry_sales($data){    
		$username = $_SESSION['username'];
		$dr_id = $this->input->post("dr_id");
		$dr_id1 = $this->input->post("dr_id");
		$dr_date = $this->input->post("dr_date");
		$dr_created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];
		$dr_sales_details = $this->input->post("dr_sales_details");
		$dr_disp_party = $this->input->post("dr_disp_party");
		$dr_disp_product = $this->input->post("dr_disp_product");
		$dr_quantity = $this->input->post("dr_quantity");
		$dr_disp_amount = $this->input->post("dr_disp_amount");
		$dr_foll_up_party = $this->input->post("dr_foll_up_party");
		$dr_foll_up_invoice_no = $this->input->post("dr_foll_up_invoice");
		$dr_foll_up_amount = $this->input->post("dr_foll_up_amount");
		$dr_foll_up_invoice_no = $this->input->post("dr_foll_up_invoice_no");
		$dr_pay_invoice_no = $this->input->post("dr_pay_invoice_no");
		$dr_amt_pend = $this->input->post("dr_amt_pend");
		$dr_amt_recv = $this->input->post("dr_amt_recv");
		$dr_next_foll_up_date = $this->input->post("dr_next_foll_up_date");
		$dr_part_name = $this->input->post("dr_part_name");
		$dr_part_product = $this->input->post("dr_part_product");
		$dr_part_lead_src = $this->input->post("dr_part_lead_src");
		$dr_part_remarks = $this->input->post("dr_part_remarks");
		$dr_cust_product = $this->input->post("dr_cust_product");
		$dr_cust_lead_src = $this->input->post("dr_cust_lead_src");
		$dr_cust_name = $this->input->post("dr_cust_name");
		$dr_cust_type= $this->input->post("dr_cust_type");
		$dr_cust_remarks = $this->input->post("dr_cust_remarks");
		$dr_meet_name = $this->input->post("dr_meet_name");
		$dr_frm_time = $this->input->post("dr_frm_time");
		$dr_to_time = $this->input->post("dr_to_time");
		$dr_meet_agenda = $this->input->post("dr_meet_agenda");
		$dr_part_int_name = $this->input->post("dr_part_int_name");
		$dr_cont_person= $this->input->post("dr_cont_person");
		$dr_cont_no = $this->input->post("dr_cont_no");
		$dr_email = $this->input->post("dr_email");
		$dr_cust_int_agenda= $this->input->post("dr_cust_int_agenda");
		$dr_cust_int_remarks = $this->input->post("dr_cust_int_remarks");
		$modified_date = $this->input->post("dr_modified_date");

		if($dr_id == ""){
			$sql_dr_cnt = "select count(*) as count from dr_mst where substring(dr_id,7,4) = '".date("Y")."'";
			$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
			$count = $qry_dr_cnt->count;
			//echo $count;die;

		if($count == 0){
			//PNIDR-2020-000001;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', 1);
		} else {
			$sql_dr_max = "select max(substring(dr_id,12,6)) as prev_id from dr_mst";
			$qry_dr_max = $this->db->query($sql_dr_max)->row();
			$prev_id = $qry_dr_max->prev_id;
			$prev_id = number_format($prev_id,0,".","");
			$new_id = $prev_id+1;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', $new_id);
		}
	}
	//echo $dr_id;die;
		//Counts
		$det_cnt = count($dr_sales_details);
		$cust_cnt = count($dr_cust_name);
		$disp_cnt = count($dr_disp_party);
		$meet_cnt = count($dr_meet_agenda);
		//echo $meet_cnt;die;
		$part_cnt = count($dr_part_product);
		$foll_up_cnt = count($dr_foll_up_party);
		$pay_cnt = count($dr_pay_invoice_no);
		$cust_int_cnt = count($dr_part_int_name);

		//Transaction Start
		$this->db->trans_start();
		$query = $this->db->query("select * from dept_mst where dept_name='SALES'");
		$id = $query->row();
		$id_sales=$id->dept_id;
	
		
		if($dr_id1 == ""){
			//Insert Code
			$sql = "insert into dr_mst(dr_id,dr_date, dr_created_by, dr_created_date, modified_by,dept) 
			values ('".$dr_id."','".$dr_date."', '".$username."','".$dr_created_date."','".$modified_by."','$id_sales')";

			$this->db->query($sql);

			for($i=0; $i<$disp_cnt; $i++){

				$sql_disp_ins = "insert into dr_disp_sum(dr_id, dr_disp_party,dr_disp_product,dr_quantity,dr_disp_amount) 
				values ('".$dr_id."', '".$dr_disp_party[$i]."','".$dr_disp_product[$i]."','".$dr_quantity[$i]."',
				'".$dr_disp_amount[$i]."')";

				$qry_disp_ins = $this->db->query($sql_disp_ins);
			}
			for($j=0; $j<$foll_up_cnt; $j++){

				$sql_foll_ins = "insert into dr_pay_foll_up(dr_id, dr_foll_up_party,dr_foll_up_invoice_no,dr_foll_up_amount) 
				values ('".$dr_id."','".$dr_foll_up_party[$j]."','".$dr_foll_up_invoice_no[$j]."',
				'".$dr_foll_up_amount[$j]."')";

				$qry_foll_ins = $this->db->query($sql_foll_ins);
			}
			for($k=0; $k<$pay_cnt; $k++){

				$sql_pay_ins = "insert into dr_pay_recv(dr_id, dr_pay_invoice_no,dr_amt_recv,dr_amt_pend,dr_next_foll_up_date) 
				values ('".$dr_id."','".$dr_pay_invoice_no[$k]."','".$dr_amt_recv[$k]."','".$dr_amt_pend[$k]."','".$dr_next_foll_up_date[$k]."')";

				$qry_pay_ins = $this->db->query($sql_pay_ins);
			}
			for($l=0; $l<$part_cnt; $l++){

				$sql_part_ins = "insert into dr_part_visit(dr_id,dr_part_name, dr_part_product,dr_part_lead_src,dr_part_remarks) 
				values ('".$dr_id."','".$dr_part_name[$l]."','".$dr_part_product[$l]."','".$dr_part_lead_src[$l]."',
				'".$dr_part_remarks[$l]."')";

				$qry_part_ins = $this->db->query($sql_part_ins);
			}

			for($m=0; $m<$cust_cnt; $m++){

				$sql_cus_ins = "insert into dr_cust_visit(dr_id, dr_cust_name,dr_cust_product,dr_cust_lead_src,dr_cust_type,dr_cust_remarks) 
				values ('".$dr_id."','". $dr_cust_name[$m]."','".$dr_cust_product[$m]."','".$dr_cust_lead_src[$m]."',
				'".$dr_cust_type[$m]."','".$dr_cust_remarks[$m]."')";

				$qry_cus_ins = $this->db->query($sql_cus_ins);
			}
			
			for($n=0; $n<$meet_cnt; $n++){

				$sql_meet_ins = "insert into dr_off_meet(dr_id, dr_meet_name,dr_from_time,dr_to_time,dr_meet_agenda) 
				values ('".$dr_id."', '".$dr_meet_name[$n]."','".$dr_frm_time[$n]."','".$dr_to_time[$n]."','".$dr_meet_agenda[$n]."')";
				$qry_meet_ins = $this->db->query($sql_meet_ins);

			}
			
			for($o=0; $o<$cust_int_cnt; $o++){

				$sql_int_ins = "insert into dr_sales_cust_int(dr_id, dr_part_int_name,dr_cont_no,dr_cont_person,dr_email,dr_cust_int_agenda,dr_cust_int_remarks) 
				values ('".$dr_id."','".$dr_part_int_name[$o]."','".$dr_cont_no[$o]."','".$dr_cont_person[$o]."',
				'".$dr_email[$o]."','".$dr_cust_int_agenda[$o]."','".$dr_cust_int_remarks[$o]."')";
				$qry_int_ins = $this->db->query($sql_int_ins);
			}
			for($p=0; $p<$det_cnt; $p++){

				$sql_det_ins = "insert into dr_sales_details(dr_id, dr_sales_details) 
				values ('".$dr_id."', '".$dr_sales_details[$p]."')";

				$qry_det_ins = $this->db->query($sql_det_ins);
			}

		} else {
			//Update Code
			
			$sql = "update dr_mst set dr_date = '".$dr_date."', dr_created_by = '".$username."'
			where dr_id = '".$dr_id."'";

			$this->db->query($sql);
			//sales details
			$sql_dr_cnt = "select count(*) as cnt from dr_sales_details where dr_id = '".$dr_id."'";
			$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
			$cnt = $qry_dr_cnt->cnt;

			if($cnt > 0){
				$sql_itm_del = "delete from dr_sales_details where dr_id = '".$dr_id."'";
				$qry_itm_del = $this->db->query($sql_itm_del);

				for($i=0; $i<$det_cnt; $i++){

					$sql_itm_ins = "insert into dr_sales_details(dr_id, dr_sales_details) 
					values ('".$dr_id1."', '".$dr_sales_details[$i]."')";
	
					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			} else {
				for($i=0; $i<$det_cnt; $i++){

					$sql_itm_ins = "insert into dr_sales_details(dr_id, dr_sales_details) 
					values ('".$dr_id1."', '".$dr_sales_details[$i]."')";
	
					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			}
			//dispatch
			$sql_dis_cnt = "select count(*) as cnt from dr_disp_sum where dr_id = '".$dr_id."'";
			$qry_dis_cnt = $this->db->query($sql_dis_cnt)->row();
			$cnt = $qry_dis_cnt->cnt;

			if($cnt > 0){
				$sql_dis_del = "delete from dr_disp_sum where dr_id = '".$dr_id."'";
				$qry_dis_del = $this->db->query($sql_dis_del);

				for($i=0; $i<$disp_cnt; $i++){

					$sql_dis_ins = "insert into dr_disp_sum(dr_id, dr_disp_party,dr_disp_product,
					dr_quantity,dr_disp_amount) values ('".$dr_id."', '".$dr_disp_party[$i]."',
					'".$dr_disp_product[$i]."','".$dr_quantity[$i]."',
					'".$dr_disp_amount[$i]."')";
	
					$qry_dis_ins = $this->db->query($sql_dis_ins);
				}
			} else {
				for($i=0; $i<$disp_cnt; $i++){

					$sql_dis_ins = "insert into dr_disp_sum(dr_id, dr_disp_party,dr_disp_product,
					dr_quantity,dr_disp_amount) values ('".$dr_id."', '".$dr_disp_party[$i]."',
					'".$dr_disp_product[$i]."','".$dr_quantity[$i]."','".$dr_disp_amount[$i]."')";
	
					$qry_dis_ins = $this->db->query($sql_dis_ins);
				}
			}
			//payment follow up
			$sql_foll_cnt = "select count(*) as cnt from dr_pay_foll_up where dr_id = '".$dr_id."'";
			$qry_foll_cnt = $this->db->query($sql_foll_cnt)->row();
			$cnt = $qry_foll_cnt->cnt;

			if($cnt > 0){
				$sql_foll_del = "delete from dr_pay_foll_up where dr_id = '".$dr_id."'";
				$qry_foll_del = $this->db->query($sql_foll_del);

				for($i=0; $i<$foll_up_cnt; $i++){

					$sql_foll_ins = "insert into dr_pay_foll_up(dr_id, dr_foll_up_party,
					dr_foll_up_invoice_no,dr_foll_up_amount) values ('".$dr_id."','".$dr_foll_up_party[$i]."',
					'".$dr_foll_up_invoice_no[$i]."','".$dr_foll_up_amount[$i]."')";
	
					$qry_foll_ins = $this->db->query($sql_foll_ins);
				}
			} else {
				for($i=0; $i<$foll_up_cnt; $i++){

					$sql_foll_up_ins ="insert into dr_pay_foll_up(dr_id, dr_foll_up_party,
					dr_foll_up_invoice_no,dr_foll_up_amount) values ('".$dr_id."','".$dr_foll_up_party[$i]."',
					'".$dr_foll_up_invoice_no[$i]."','".$dr_foll_up_amount[$i]."')";
					$qry_foll_up_ins = $this->db->query($sql_foll_up_ins);
				}
			}
			//payment recieved
			$sql_pay_cnt = "select count(*) as cnt from dr_pay_recv where dr_id = '".$dr_id."'";
			$qry_pay_cnt = $this->db->query($sql_pay_cnt)->row();
			$cnt = $qry_pay_cnt->cnt;

			if($cnt > 0){
				$sql_pay_del = "delete from dr_pay_recv where dr_id = '".$dr_id."'";
				$qry_pay_del = $this->db->query($sql_pay_del);

				for($i=0; $i<$pay_cnt; $i++){

					$sql_pay_ins = "insert into dr_pay_recv(dr_id, dr_pay_invoice_no,dr_amt_recv,dr_amt_pend,
					dr_next_foll_up_date) values ('".$dr_id."','".$dr_pay_invoice_no[$i]."','".$dr_amt_recv[$i]."',
					'".$dr_amt_pend[$i]."','".$dr_next_foll_up_date[$i]."')";
					$qry_pay_ins = $this->db->query($sql_pay_ins);
				}
			} else {
				for($i=0; $i<$pay_cnt; $i++){

					$sql_pay_ins = "insert into dr_pay_recv(dr_id, dr_pay_invoice_no,dr_amt_recv,
					dr_amt_pend,dr_next_foll_up_date) values ('".$dr_id."','".$dr_pay_invoice_no[$i]."',
					'".$dr_amt_recv[$i]."','".$dr_amt_pend[$i]."','".$dr_next_foll_up_date[$i]."')";
	
					$qry_pay_ins = $this->db->query($sql_pay_ins);
				}
			}
			//party visit
			$sql_part_cnt = "select count(*) as cnt from dr_part_visit where dr_id = '".$dr_id."'";
			$qry_part_cnt = $this->db->query($sql_part_cnt)->row();
			$cnt = $qry_dr_cnt->cnt;

			if($cnt > 0){
				$sql_part_del = "delete from dr_part_visit where dr_id = '".$dr_id."'";
				$qry_part_del = $this->db->query($sql_part_del);

				for($i=0; $i<$part_cnt; $i++){

					$sql_part_ins = "insert into dr_part_visit(dr_id,dr_part_name, dr_part_product,
					dr_part_lead_src,dr_part_remarks) values ('".$dr_id."','".$dr_part_name[$i]."',
					'".$dr_part_product[$i]."','".$dr_part_lead_src[$i]."','".$dr_part_remarks[$i]."')";
	
						$qry_part_ins = $this->db->query($sql_part_ins);
				}
			} else {
				for($i=0; $i<$part_cnt; $i++){

					$sql_itm_ins = "insert into dr_part_visit(dr_id,dr_part_name, dr_part_product,
					dr_part_lead_src,dr_part_remarks) values ('".$dr_id."','".$dr_part_name[$i]."',
					'".$dr_part_product[$i]."','".$dr_part_lead_src[$i]."','".$dr_part_remarks[$i]."')";
	
					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			}
				//customer visit
			$sql_cust_cnt = "select count(*) as cnt from dr_cust_visit where dr_id = '".$dr_id."'";
			$qry_cust_cnt = $this->db->query($sql_cust_cnt)->row();
			$cnt = $qry_cust_cnt->cnt;

			if($cnt > 0){
				$sql_cust_del = "delete from dr_cust_visit where dr_id = '".$dr_id."'";
				$qry_cust_del = $this->db->query($sql_cust_del);

				for($i=0; $i<$cust_cnt; $i++){

					$sql_cust_ins = "insert into dr_cust_visit(dr_id, dr_cust_name,dr_cust_product,
					dr_cust_lead_src,dr_cust_type,dr_cust_remarks) values ('".$dr_id."','". $dr_cust_name[$i]."',
					'".$dr_cust_product[$i]."','".$dr_cust_lead_src[$i]."','".$dr_cust_type[$i]."','".$dr_cust_remarks[$i]."')";
	
					$qry_cust_ins = $this->db->query($sql_cust_ins);
				}
			} else {
				for($i=0; $i<$cust_cnt; $i++){

					$sql_cust_ins = "insert into dr_cust_visit(dr_id, dr_cust_name,dr_cust_product,dr_cust_lead_src,
					dr_cust_type,dr_cust_remarks) values ('".$dr_id."','". $dr_cust_name[$i]."','".$dr_cust_product[$i]."',
					'".$dr_cust_lead_src[$i]."','".$dr_cust_type[$i]."','".$dr_cust_remarks[$i]."')";
	
					$qry_cust_ins = $this->db->query($sql_cust_ins);
				}
			}
			//meetings
			$sql_meet_cnt = "select count(*) as cnt from dr_off_meet where dr_id = '".$dr_id."'";
			$qry_meet_cnt = $this->db->query($sql_meet_cnt)->row();
			$cnt = $qry_meet_cnt->cnt;

			if($cnt > 0){
				$sql_meet_del = "delete from dr_off_meet where dr_id = '".$dr_id."'";
				$qry_meet_del = $this->db->query($sql_meet_del);

				for($i=0; $i<$meet_cnt; $i++){

					$sql_meet_ins = "insert into dr_off_meet(dr_id, dr_meet_name,dr_from_time,dr_to_time,dr_meet_agenda) 
					values ('".$dr_id."', '".$dr_meet_name[$i]."','".$dr_frm_time[$i]."','".$dr_to_time[$i]."','".$dr_meet_agenda[$i]."')";
	
					$qry_meet_ins = $this->db->query($sql_meet_ins);
				}
			} else {
				for($i=0; $i<$meet_cnt; $i++){

					$sql_meet_ins = "insert into dr_off_meet(dr_id, dr_meet_name,dr_from_time,dr_to_time,dr_meet_agenda) 
					values ('".$dr_id."', '".$dr_meet_name[$i]."','".$dr_frm_time[$i]."','".$dr_to_time[$i]."','".$dr_meet_agenda[$i]."')";
	
					$qry_meet_ins = $this->db->query($sql_meet_ins);
				}
			}
			//cust interaction
			$sql_int_cnt = "select count(*) as cnt from dr_sales_cust_int where dr_id = '".$dr_id."'";
			$qry_int_cnt = $this->db->query($sql_int_cnt)->row();
			$cnt = $qry_int_cnt->cnt;

			if($cnt > 0){
				$sql_int_del = "delete from dr_sales_cust_int where dr_id = '".$dr_id."'";
				$qry_int_del = $this->db->query($sql_int_del);

				for($i=0; $i<$cust_int_cnt; $i++){

					$sql_int_ins = "insert into dr_sales_cust_int(dr_id, dr_part_int_name,dr_cont_no,
					dr_cont_person,dr_email,dr_cust_int_agenda,dr_cust_int_remarks) 
					values ('".$dr_id."','".$dr_part_int_name[$i]."','".$dr_cont_no[$i]."',
					'".$dr_cont_person[$i]."','".$dr_email[$i]."','".$dr_cust_int_agenda[$i]."','".$dr_cust_int_remarks[$i]."')";
					$qry_int_ins = $this->db->query($sql_int_ins);
				}
			} else {
				for($i=0; $i<$cust_int_cnt; $i++){

					$sql_int_ins ="insert into dr_sales_cust_int(dr_id, dr_part_int_name,dr_cont_no,dr_cont_person,dr_email,dr_cust_int_agenda,dr_cust_int_remarks) 
					values ('".$dr_id."','".$dr_part_int_name[$i]."','".$dr_cont_no[$i]."','".$dr_cont_person[$i]."',
					'".$dr_email[$i]."','".$dr_cust_int_agenda[$i]."','".$dr_cust_int_remarks[$i]."')";
	
					$qry_int_ins = $this->db->query($sql_int_ins);
				}
			}


			
		}
		
		$this->db->trans_complete();
		//Transanction Complete
	 }
	 
	 //Dr Entry IT

	 public function dr_entry_report($data){ 
		//Transaction Start
		
		$name=$this->input->post("name");
		$type=$this->input->post("type");
		$month=$this->input->post("month");
		$year=$this->input->post("year");  
		
		$sql="select * from dr_mst";
		$query=$this->db-query($sql);
		foreach($query->result() as $row){
		$dr_date = $row->dr_date;
		$dr_created_by = $row->dr_created_by;
		}
	}
		
	public function dr_entry_report1($data)
	{
		$sql="select * from login";
		$query=$this->db->query($sql);
		foreach($query->result() as $row){
		$username = $row->username;
		$name = $row->name;
		$dept = $row->dept;
		}
			
	}
	public function get_records(){
		$sql="select d.dr_created_date,d.dr_id,l.username,l.name from dr_mst d inner join login l on d.dr_created_by =l.username ";
		$query=$this->db-query($sql);
		 return $query;
		
	}
}

		
	 

	

	 	 
		

?>