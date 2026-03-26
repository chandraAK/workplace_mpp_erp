<?php
class Storem extends CI_Model{  
	function __construct(){   
		parent::__construct();  
	}

	function ListHead($tbl_nm){
		$query = $this->db->query("SHOW columns FROM $tbl_nm");
		return $query;
	}

	//Goods Load Memo Entry
	public function good_load_memo_entry($data){  
		$glm_vehicle_no  = $this->input->post("glm_vehicle_no");
		$glm_party_name = $this->input->post("glm_party_name");
		$glm_date = $this->input->post("glm_date");
		$tot_runner = $this->input->post("tot_runner");
		$tot_fix = $this->input->post("tot_fix");

		//Details
		$glm_itm_id  = $this->input->post("glm_itm_id");
		$glm_svipl1_runner  = $this->input->post("glm_svipl1_runner");
		$glm_svipl1_fix  = $this->input->post("glm_svipl1_fix");
		$glm_sbmi_runner  = $this->input->post("glm_sbmi_runner");
		$glm_sbmi_fix  = $this->input->post("glm_sbmi_fix");
		$glm_tot_runner  = $this->input->post("glm_tot_runner");
		$glm_tot_fix  = $this->input->post("glm_tot_fix");

		$count = count($glm_itm_id);

		//Session Details
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];

		//Transaction Start
		$this->db->trans_start();

		$sql = $this->db->query("insert into goods_load_memo_mst(glm_vehicle_no, glm_party_name, glm_date, 
		tot_runner, tot_fix, created_by, 
		created_date, modified_by) 
		values 
		('".$glm_vehicle_no."', '".$glm_party_name."', '".$glm_date."', 
		'".$tot_runner."', '".$tot_fix."', '".$created_by."', 
		'".$created_date."', '".$modified_by."')");

		//Getting Max_id
		$sql_max_id = "select max(glm_id) as max_id from goods_load_memo_mst";
		$qry_max_id = $this->db->query($sql_max_id)->row();
		$glm_id = $qry_max_id->max_id;

		//Initialize Values
		$ifs_svipl1_runner_tot = 0;
		$ifs_svipl1_fix_tot = 0;
		$ifs_sbmi_runner_tot = 0;
		$ifs_sbmi_fix_tot = 0;
		$ifs_tot_runner = 0;
		$ifs_tot_fix = 0;

		for($i=0;$i<$count;$i++){
			$sql_det = $this->db->query("insert into goods_load_memo_det(glm_id, glm_itm_id, glm_svipl1_runner, 
			glm_svipl1_fix, glm_sbmi_runner, glm_sbmi_fix, 
			glm_tot_runner, glm_tot_fix, created_by, 
			created_date, modified_by) 
			values('".$glm_id."', '".$glm_itm_id[$i]."', '".$glm_svipl1_runner[$i]."', 
			'".$glm_svipl1_fix[$i]."', '".$glm_sbmi_runner[$i]."', '".$glm_sbmi_fix[$i]."', 
			'".$glm_tot_runner[$i]."', '".$glm_tot_fix[$i]."', '".$created_by."', 
			'".$created_date."', '".$modified_by."')");

			//Getting Previous Stock
			$sql_prev_stk = "select sum(ifs_svipl1_runner) as ifs_svipl1_runner_prev, sum(ifs_svipl1_fix) as ifs_svipl1_fix_prev, 
			sum(ifs_sbmi_runner) as ifs_sbmi_runner_prev, sum(ifs_sbmi_fix) as ifs_sbmi_fix_prev
			from item_fg_stock_det where ifs_itm_id = '".$glm_itm_id[$i]."'";

			$qry_prev_stk = $this->db->query($sql_prev_stk)->row();
			$ifs_svipl1_runner_prev = $qry_prev_stk->ifs_svipl1_runner_prev;
			$ifs_svipl1_fix_prev = $qry_prev_stk->ifs_svipl1_fix_prev;
			$ifs_sbmi_runner_prev = $qry_prev_stk->ifs_sbmi_runner_prev;
			$ifs_sbmi_fix_prev = $qry_prev_stk->ifs_sbmi_fix_prev;
			//Error Text
			$error = "<h2 style='color:red'>Insufficent Stock Or Stock Not Available... Go Back</h2>";
			
			//Stock Checking
			/*
			if(empty($ifs_svipl1_runner_prev) || $ifs_svipl1_runner_prev == 0 || $ifs_svipl1_runner_prev < $glm_svipl1_runner[$i]){
				echo $error;
				$this->db->trans_rollback();
				die;
				//$ifs_svipl1_runner_prev = 0;
			}

			if(empty($ifs_svipl1_fix_prev) || $ifs_svipl1_fix_prev == 0 || $ifs_svipl1_fix_prev < $glm_svipl1_fix[$i]){
				echo $error;
				$this->db->trans_rollback();
				die;
				//$ifs_svipl1_fix_prev = 0;
			}

			if(empty($ifs_sbmi_runner_prev) || $ifs_sbmi_runner_prev == 0 || $ifs_sbmi_runner_prev < $glm_sbmi_runner[$i]){
				echo $error;
				$this->db->trans_rollback();
				die;
				//$ifs_sbmi_runner_prev = 0;
			}

			if(empty($ifs_sbmi_fix_prev) || $ifs_sbmi_fix_prev == 0 || $ifs_sbmi_fix_prev < $glm_sbmi_fix[$i]){
				echo $error;
				$this->db->trans_rollback();
				die;
				//$ifs_sbmi_fix_prev = 0;
			}
			*/
			
			//Total Stock
			$ifs_svipl1_runner_tot = $ifs_svipl1_runner_prev-$glm_svipl1_runner[$i];
			$ifs_svipl1_fix_tot = $ifs_svipl1_fix_prev-$glm_svipl1_fix[$i];
			$ifs_sbmi_runner_tot = $ifs_sbmi_runner_prev-$glm_sbmi_runner[$i];
			$ifs_sbmi_fix_tot = $ifs_sbmi_fix_prev-$glm_sbmi_fix[$i];
			
			$tot_prev_runner = $ifs_svipl1_runner_prev+$ifs_sbmi_runner_prev;
			$tot_prev_fix = $ifs_svipl1_fix_prev+$ifs_sbmi_fix_prev;

			$tot_curr_runner = $glm_svipl1_runner[$i]+$glm_sbmi_runner[$i];
			$tot_curr_fix = $glm_svipl1_fix[$i]+$glm_sbmi_fix[$i];

			$ifs_tot_runner = $tot_prev_runner-$tot_curr_runner;
			$ifs_tot_fix = $tot_prev_fix-$tot_curr_fix;			

			$updt_stk = $this->db->query("update item_fg_stock_det set ifs_svipl1_runner = '".$ifs_svipl1_runner_tot."', 
			ifs_svipl1_fix = '".$ifs_svipl1_fix_tot."', ifs_sbmi_runner = '".$ifs_sbmi_runner_tot."',
			ifs_sbmi_fix = '".$ifs_sbmi_fix_tot."', ifs_tot_runner = '".$ifs_tot_runner."',  
			ifs_tot_fix = '".$ifs_tot_fix."', modified_by = '".$modified_by."'
			where ifs_itm_id = '".$glm_itm_id[$i]."'");
		}

		$this->db->trans_complete();
		//Transanction Complete
	}

	//FG Stock Entry
	public function item_fg_stock_entry($data){
		$ifs_itm_id  = $this->input->post("ifs_itm_id");
		$ifs_svipl1_runner  = $this->input->post("ifs_svipl1_runner");
		$ifs_svipl1_fix  = $this->input->post("ifs_svipl1_fix");
		$ifs_sbmi_runner  = $this->input->post("ifs_sbmi_runner");
		$ifs_sbmi_fix  = $this->input->post("ifs_sbmi_fix");

		$arr_cnt = count($ifs_itm_id);

		//Session Details
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];

		//Transaction Start
		$this->db->trans_start();

		for($i=0;$i<$arr_cnt;$i++){
			//Previous Entries
			$sql_prev = "select count(*) as count from item_fg_stock_det where ifs_itm_id = '".$ifs_itm_id[$i]."'";
			$qry_prev = $this->db->query($sql_prev)->row();
			$count = $qry_prev->count;

			$ifs_svipl1_runner_tot = 0;
			$ifs_svipl1_fix_tot = 0;
			$ifs_sbmi_runner_tot = 0;
			$ifs_sbmi_fix_tot = 0;
			$ifs_tot_runner = 0;
			$ifs_tot_fix = 0;

			if($count > 0){
				//Getting Previous Stock
				$sql_prev_stk = "select sum(ifs_svipl1_runner) as ifs_svipl1_runner_prev, sum(ifs_svipl1_fix) as ifs_svipl1_fix_prev, 
				sum(ifs_sbmi_runner) as ifs_sbmi_runner_prev, sum(ifs_sbmi_fix) as ifs_sbmi_fix_prev
				from item_fg_stock_det where ifs_itm_id = '".$ifs_itm_id[$i]."'";

				$qry_prev_stk = $this->db->query($sql_prev_stk)->row();
				$ifs_svipl1_runner_prev = $qry_prev_stk->ifs_svipl1_runner_prev;
				$ifs_svipl1_fix_prev = $qry_prev_stk->ifs_svipl1_fix_prev;
				$ifs_sbmi_runner_prev = $qry_prev_stk->ifs_sbmi_runner_prev;
				$ifs_sbmi_fix_prev = $qry_prev_stk->ifs_sbmi_fix_prev;
				
				//Total Stock
				$ifs_svipl1_runner_tot = $ifs_svipl1_runner_prev+$ifs_svipl1_runner[$i];
				$ifs_svipl1_fix_tot = $ifs_svipl1_fix_prev+$ifs_svipl1_fix[$i];
				$ifs_sbmi_runner_tot = $ifs_sbmi_runner_prev+$ifs_sbmi_runner[$i];
				$ifs_sbmi_fix_tot = $ifs_sbmi_fix_prev+$ifs_sbmi_fix[$i];
				$ifs_tot_runner = $ifs_svipl1_runner_tot+$ifs_sbmi_runner_tot;
				$ifs_tot_fix = $ifs_svipl1_fix_tot+$ifs_sbmi_fix_tot;

				$updt_stk = $this->db->query("update item_fg_stock_det set ifs_svipl1_runner = '".$ifs_svipl1_runner_tot."', 
				ifs_svipl1_fix = '".$ifs_svipl1_fix_tot."', ifs_sbmi_runner = '".$ifs_sbmi_runner_tot."',
				ifs_tot_runner = '".$ifs_tot_runner."',  ifs_tot_fix = '".$ifs_tot_fix."',
				ifs_sbmi_fix = '".$ifs_sbmi_fix_tot."', modified_by = '".$modified_by."'
				where ifs_itm_id = '".$ifs_itm_id[$i]."'");

				//Updating Item Name
				$updt_itm_nm = $this->db->query("update item_fg_stock_det set ifs_item_name = (select CONCAT(item_name, '-', item_size, '-', item_model) 
				from item_mst where item_id = '".$ifs_itm_id[$i]."') where ifs_itm_id = '".$ifs_itm_id[$i]."'");

			} else {
				//Calculating Total
				$ifs_tot_runner = $ifs_svipl1_runner[$i]+$ifs_sbmi_runner[$i];
				$ifs_tot_fix = $ifs_svipl1_fix[$i]+$ifs_sbmi_fix[$i];

				$sql_ins = $this->db->query("insert into item_fg_stock_det(ifs_itm_id, ifs_svipl1_runner, ifs_svipl1_fix, 
				ifs_sbmi_runner, ifs_sbmi_fix, ifs_tot_runner, ifs_tot_fix,
				created_by, created_date, modified_by)
				values('".$ifs_itm_id[$i]."', '".$ifs_svipl1_runner[$i]."', '".$ifs_svipl1_fix[$i]."', 
				'".$ifs_sbmi_runner[$i]."', '".$ifs_sbmi_fix[$i]."', '".$ifs_tot_runner."', '".$ifs_tot_fix."', 
				'".$created_by."', '".$created_date."', '".$modified_by."')");

				//Updating Item Name
				$updt_itm_nm = $this->db->query("update item_fg_stock_det set ifs_item_name = (select CONCAT(item_name, '-', item_size, '-', item_model) 
				from item_mst where item_id = '".$ifs_itm_id[$i]."') where ifs_itm_id = '".$ifs_itm_id[$i]."'");
			}
		}

		$this->db->trans_complete();
		//Transanction Complete

	}

}  
?>