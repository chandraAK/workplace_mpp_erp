<?php
class Servicem extends CI_Model{  
      function __construct(){   
         parent::__construct();  
      }
	  
	  //Vehicle Entry
	  public function VhclEntry($data){    
	 	$username = $_SESSION['username'];
		$vehicle_arr_tm  = $this->input->post("vehicle_arr_tm");
		$vhcl_type = $this->input->post("vhcl_type");
		$vhcl_reg_no = $this->input->post("vhcl_reg_no");
		$driver_nm = $this->input->post("driver_nm");
		$driver_mob_no = $this->input->post("driver_mob_no");
		$vehicle_arr_plc = $this->input->post("vehicle_arr_plc");
		$doc_by_driver = $this->input->post("doc_by_driver");
		$vehicle_dep_tm = $this->input->post("vehicle_dep_tm");
		$status = "Pending For Weighting Entry";
		
		$sql = "insert into vehicle_entry(vehicle_arr_tm, vhcl_type, vhcl_reg_no, driver_nm, driver_mob_no, doc_by_driver, vehicle_arr_plc, status, created_by) 
		values 
		('$vehicle_arr_tm', '$vhcl_type', '$vhcl_reg_no', '$driver_nm', '$driver_mob_no', '$doc_by_driver', '$vehicle_arr_plc', '$status', '$username')";
		
		$this->db->query($sql);
		
		//action timing
		$sql_at = "insert into vehicle_entry_history(vhcl_reg_no,stage,created_by) values('$vhcl_reg_no','$status','$username')";
		$this->db->query($sql_at);
	  }
	 
   }  
?>