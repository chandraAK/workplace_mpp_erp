<?php
class Productionm extends CI_Model{  
	function __construct(){   
		parent::__construct();  
	}

	function ListHead($tbl_nm){
		$query = $this->db->query("SHOW columns FROM $tbl_nm");
		return $query;
	}

	//Id's Column
	public function get_by_id($tbl_nm, $id_col, $id){
		$query = $this->db->query("select * from $tbl_nm where $id_col = '".$id."'");
		return $query;
	}

	/************************************************ */
	/*******************Masters********************** */
	/************************************************ */

	function company_entry($data){
		$company_id = $this->input->post("company_id");
		$company_name = $this->input->post("company_name");
		$company_createdby = $_SESSION['username'];
		$company_createddate = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($company_id == ""){

            $sql = "insert into company_mst(company_name, company_createdby, company_createddate) 
            values('$company_name','$company_createdby','$company_createddate')";

        } else {

			$sql = "update company_mst set company_name = '$company_name', 
			company_createdby = '$company_createdby', company_createddate = '$company_createddate'
            where company_id = '$company_id'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	function plate_entry($data){
		$plate_id = $this->input->post("plate_id");
		$plate_name = $this->input->post("plate_name");
		$plate_createdby = $_SESSION['username'];
		$plate_createddate = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($company_id == ""){

            $sql = "insert into plate_mst(plate_name, plate_createdby, plate_createddate) 
            values('$plate_name','$plate_createdby','$plate_createddate')";

        } else {

			$sql = "update plate_mst set plate_name = '$plate_name', 
			plate_createdby = '$plate_createdby', plate_createddate = '$plate_createddate'
            where plate_id = '$plate_id'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	function labour_entry($data){
		$labour_id = $this->input->post("labour_id");
		$labour_name = $this->input->post("labour_name");
		$labour_createdby = $_SESSION['username'];
		$labour_createddate = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($labour_id == ""){

            $sql = "insert into labour_mst(labour_name, labour_createdby, labour_createddate) 
            values('$labour_name','$labour_createdby','$labour_createddate')";

        } else {

			$sql = "update labour_mst set labour_name = '$labour_name', 
			labour_createdby = '$labour_createdby', labour_createddate = '$labour_createddate'
            where labour_id = '$labour_id'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	function stone_size_entry($data){
		$size_id = $this->input->post("size_id");
		$size_name = $this->input->post("size_name");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($size_id == ""){

            $sql = "insert into stone_size_mst(size_name, created_by, created_date) 
            values('$size_name','$created_by','$created_date')";

        } else {

			$sql = "update stone_size_mst set size_name = '$size_name', 
			created_by = '$created_by', created_date = '$created_date'
            where size_id = '$size_id'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	function stone_task_entry($data){
		$task_id = $this->input->post("task_id");
		$task_name = $this->input->post("task_name");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($task_id == ""){

            $sql = "insert into stone_task_mst(task_name, created_by, created_date) 
            values('$task_name','$created_by','$created_date')";

        } else {

			$sql = "update stone_task_mst set task_name = '$task_name', 
			created_by = '$created_by', created_date = '$created_date'
            where task_id = '$task_id'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	function prod_proc_entry($data){
		$process_id = $this->input->post("process_id");
		$process_name = $this->input->post("process_name");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($process_id == ""){

            $sql = "insert into prod_process_mst(process_name, created_by, created_date) 
            values('$process_name','$created_by','$created_date')";

        } else {

			$sql = "update prod_process_mst set process_name = '$process_name', 
			created_by = '$created_by', created_date = '$created_date'
            where process_id = '$process_id'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	/************************************************ */
	/*******************Masters********************** */
	/************************************************ */

	//Production Plates Entry
	function lab_jw_entry($data){
		$ljw_id = $this->input->post("ljw_id");
		$ljw_labour_id = $this->input->post("ljw_labour_id");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//dtl cols
		$ljw_stone_job_id = $this->input->post("ljw_stone_job_id");

		$arr_cnt = count($ljw_stone_job_id);

		//Transaction Start
		$this->db->trans_start();

        if($ljw_id == ""){

            $sql = "insert into lab_jw_mst(ljw_labour_id, created_by, created_date) 
			values('$ljw_labour_id','$created_by','$created_date')";

			$this->db->query($sql);
			
			//Getting Max Id
			$sql_max_ljw_id = "select max(ljw_id) as max_ljw_id from lab_jw_mst";
			$qry_max_ljw_id = $this->db->query($sql_max_ljw_id)->row();
			$max_ljw_id = $qry_max_ljw_id->max_ljw_id;

			//Updating Labour Name
			$sql_updt_ln = "UPDATE lab_jw_mst INNER JOIN labour_mst 
			ON lab_jw_mst.ljw_labour_id = labour_mst.labour_id
			SET lab_jw_mst.ljw_labour_name = labour_mst.labour_name
			WHERE lab_jw_mst.ljw_id = '".$max_ljw_id."'";

			$this->db->query($sql_updt_ln);

			//Counting Previous Entries
			$sql_count_dtl = "select count(*) as count from lab_jw_det where ljw_id='".$max_ljw_id."'";
			$qry_count_dtl = $this->db->query($sql_count_dtl)->row();
			$count = $qry_count_dtl->count;
			if($count > 0){
				$sql_del_dtl = $this->db->query("delete from lab_jw_det where ljw_id = '".$max_ljw_id."'");
			}

			//labour Job Details
			for($i=0;$i<$arr_cnt;$i++){
				$sql_ljw_dtl ="insert into lab_jw_det(ljw_id, ljw_stone_job_id)
				values('".$max_ljw_id."', '".$ljw_stone_job_id[$i]."')";

				$this->db->query($sql_ljw_dtl);

				//Updating Stone Job Type Name
				$sql_sjt = "UPDATE lab_jw_det INNER JOIN prod_process_mst 
				ON lab_jw_det.ljw_stone_job_id = prod_process_mst.process_id
				SET lab_jw_det.ljw_stone_job_nm = prod_process_mst.process_name
				WHERE lab_jw_det.ljw_id = '".$max_ljw_id."'";

				$this->db->query($sql_sjt);
			}

        } else {

			$sql = "update lab_jw_mst set ljw_labour_id = '$ljw_labour_id', 
			created_by = '$created_by', created_date = '$created_date' where ljw_id = '$ljw_id'";

			$this->db->query($sql);

			//Updating Labour Name
			$sql_updt_ln = "UPDATE lab_jw_mst INNER JOIN labour_mst 
			ON lab_jw_mst.ljw_labour_id = labour_mst.labour_id
			SET lab_jw_mst.ljw_labour_name = labour_mst.labour_name
			WHERE lab_jw_mst.ljw_id = '".$ljw_id."'";

			$this->db->query($sql_updt_ln);

			//Counting Previous Entries
			$sql_count_dtl = "select count(*) as count from lab_jw_det where ljw_id='".$ljw_id."'";
			$qry_count_dtl = $this->db->query($sql_count_dtl)->row();
			$count = $qry_count_dtl->count;
			if($count > 0){
				$sql_del_dtl = $this->db->query("delete from lab_jw_det where ljw_id = '".$ljw_id."'");
			}

			//labour Job Details
			for($i=0;$i<$arr_cnt;$i++){
				$sql_ljw_dtl ="insert into lab_jw_det(ljw_id, ljw_stone_job_id)
				values('".$ljw_id."', '".$ljw_stone_job_id[$i]."')";

				$this->db->query($sql_ljw_dtl);

				//Updating Stone Job Type Name
				$sql_sjt = "UPDATE lab_jw_det INNER JOIN prod_process_mst 
				ON lab_jw_det.ljw_stone_job_id = prod_process_mst.process_id
				SET lab_jw_det.ljw_stone_job_nm = prod_process_mst.process_name
				WHERE lab_jw_det.ljw_id = '".$ljw_id."'";

				$this->db->query($sql_sjt);
			}

		}

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Production Plates Entry
	function prod_plates_entry($data){
		$prod_id = $this->input->post("prod_id");
		$prod_date = $this->input->post("prod_date");
		$comp_id = $this->input->post("comp_id");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//dtl cols
		$labour_name = $this->input->post("labour_name");
		$plate_name = $this->input->post("plate_name");
		$plate_qty = $this->input->post("plate_qty");

		$arr_cnt = count($labour_name);

		//Transaction Start
		$this->db->trans_start();

        if($prod_id == ""){

            $sql = "insert into prod_plates_mst(prod_date, comp_id, created_by, created_date) 
			values('$prod_date','$comp_id','$created_by','$created_date')";

			$this->db->query($sql);
			
			//Getting Max Id
			$sql_max_prod_id = "select max(prod_id) as max_prod_id from prod_plates_mst";
			$qry_max_prod_id = $this->db->query($sql_max_prod_id)->row();
			$max_prod_id = $qry_max_prod_id->max_prod_id;

			//Counting Previous Entries
			$sql_count_dtl = "select count(*) as count from prod_plates_dtl where prod_id='".$prod_id."'";
			$qry_count_dtl = $this->db->query($sql_count_dtl)->row();
			$count = $qry_count_dtl->count;
			if($count > 0){
				$sql_del_dtl = $this->db->query("delete from prod_plates_dtl where prod_id = '".$prod_id."'");
			}

			//Production Details
			for($i=0;$i<$arr_cnt;$i++){
				$sql_prod_dtl ="insert into prod_plates_dtl(prod_id, prod_date, labour_name, plate_name, plate_qty)
				values('".$max_prod_id."', '".$prod_date."', '".$labour_name[$i]."', '".$plate_name[$i]."', '".$plate_qty[$i]."')";

				$this->db->query($sql_prod_dtl);
			}

			//Update Total Quantity In Master
			$sql_updt_mst = "update prod_plates_mst set total_plates = (select sum(plate_qty) from prod_plates_dtl 
			where prod_plates_dtl.prod_id = prod_plates_mst.prod_id and prod_plates_dtl.prod_id = '".$max_prod_id."')";

			$this->db->query($sql_updt_mst);

        } else {

			$sql = "update prod_plates_mst set prod_date = '$prod_date', 
			created_by = '$created_by', created_date = '$created_date' where prod_id = '$prod_id'";

			$this->db->query($sql);

			//Getting Max Id
			$sql_max_prod_id = "select max(prod_id) as max_prod_id from prod_plates_mst";
			$qry_max_prod_id = $this->db->query($sql_max_prod_id)->row();
			$max_prod_id = $qry_max_prod_id->max_prod_id;

			//Counting Previous Entries
			$sql_count_dtl = "select count(*) as count from prod_plates_dtl where prod_id='".$prod_id."'";
			$qry_count_dtl = $this->db->query($sql_count_dtl)->row();
			$count = $qry_count_dtl->count;
			if($count > 0){
				$sql_del_dtl = $this->db->query("delete from prod_plates_dtl where prod_id = '".$prod_id."'");
			}

			//Production Details
			for($i=0;$i<$arr_cnt;$i++){
				$sql_prod_dtl ="insert into prod_plates_dtl(prod_id, prod_date, labour_name, plate_name, plate_qty)
				values('".$max_prod_id."', '".$prod_date."', '".$labour_name[$i]."', '".$plate_name[$i]."', '".$plate_qty[$i]."')";

				$this->db->query($sql_prod_dtl);
			}

			//Update Total Quantity In Master
			$sql_updt_mst = "update prod_plates_mst set total_plates = (select sum(plate_qty) from prod_plates_dtl 
			where prod_plates_dtl.prod_id = prod_plates_mst.prod_id and prod_plates_dtl.prod_id = '".$max_prod_id."')";

			$this->db->query($sql_updt_mst);

		}

		$this->db->trans_complete();
		//Transanction Complete
	}


	//Chhilai Entry
	function chhilai_entry($data){
		$chhilai_id = $this->input->post("chhilai_id");
		$chhilai_date = $this->input->post("chhilai_date");
		$process_type = $this->input->post("process_type");
		$comp_id = $this->input->post("comp_id");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//dtl cols
		$labour_name = $this->input->post("labour_name");
		$stone_size = $this->input->post("stone_size");
		$stone_task = $this->input->post("stone_task");
		$stone_qty = $this->input->post("stone_qty");

		$arr_cnt = count($labour_name);

		//Transaction Start
		$this->db->trans_start();

        if($chhilai_id == ""){

            $sql = "insert into chhilai_mst(chhilai_date, comp_id, process_type, created_by, created_date) 
			values('$chhilai_date','$comp_id','$process_type','$created_by','$created_date')";

			$this->db->query($sql);
			
			//Getting Max Id
			$sql_max_chhilai_id = "select max(chhilai_id) as max_chhilai_id from chhilai_mst";
			$qry_max_chhilai_id = $this->db->query($sql_max_chhilai_id)->row();
			$max_chhilai_id = $qry_max_chhilai_id->max_chhilai_id;

			//Counting Previous Entries
			$sql_count_dtl = "select count(*) as count from chhilai_dtl where chhilai_id='".$chhilai_id."'";
			$qry_count_dtl = $this->db->query($sql_count_dtl)->row();
			$count = $qry_count_dtl->count;
			if($count > 0){
				$sql_del_dtl = $this->db->query("delete from chhilai_dtl where chhilai_id = '".$chhilai_id."'");
			}

			//Chhilai Details
			for($i=0;$i<$arr_cnt;$i++){
				$sql_chhilai_dtl ="insert into chhilai_dtl(chhilai_id, chhilai_date, labour_name, stone_size, stone_task, stone_qty)
				values('".$max_chhilai_id."', '".$chhilai_date."', '".$labour_name[$i]."', '".$stone_size[$i]."', '".$stone_task[$i]."', 
				'".$stone_qty[$i]."')";

				$this->db->query($sql_chhilai_dtl);
			}

        } else {

			$sql = "update chhilai_mst set chhilai_date = '$chhilai_date', process_type = '$process_type',
			created_by = '$created_by', created_date = '$created_date' where chhilai_id = '$chhilai_id'";

			$this->db->query($sql);

			//Getting Max Id
			$sql_max_chhilai_id = "select max(chhilai_id) as max_chhilai_id from chhilai_mst";
			$qry_max_chhilai_id = $this->db->query($sql_max_chhilai_id)->row();
			$max_chhilai_id = $qry_max_chhilai_id->max_chhilai_id;

			//Counting Previous Entries
			$sql_count_dtl = "select count(*) as count from chhilai_dtl where chhilai_id='".$chhilai_id."'";
			$qry_count_dtl = $this->db->query($sql_count_dtl)->row();
			$count = $qry_count_dtl->count;
			if($count > 0){
				$sql_del_dtl = $this->db->query("delete from chhilai_dtl where chhilai_id = '".$chhilai_id."'");
			}

			//Chhilai Details
			for($i=0;$i<$arr_cnt;$i++){
				$sql_chhilai_dtl ="insert into chhilai_dtl(chhilai_id, chhilai_date, labour_name, stone_size, stone_task, stone_qty)
				values('".$max_chhilai_id."', '".$chhilai_date."', '".$labour_name[$i]."', '".$stone_size[$i]."', '".$stone_task[$i]."', 
				'".$stone_qty[$i]."')";

				$this->db->query($sql_chhilai_dtl);
			}

		}

		$this->db->trans_complete();
		//Transanction Complete
	}
	 
}  
?>