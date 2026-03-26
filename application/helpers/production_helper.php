<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('production')){	

	function labour_list(){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql="select * from labour_mst where labour_name != '' and labour_name is not null";
		
        $query = $ci->db->query($sql);
        
		foreach ($query->result() as $row) {
          $labour_name = $row->labour_name;
          
          $data .= '<option value="'.$labour_name.'">'.$labour_name.'</option>';

		}
		
		return $data;
    }

    function plates_list(){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql="select * from plate_mst where plate_name != '' and plate_name is not null";
		
        $query = $ci->db->query($sql);
        
		foreach ($query->result() as $row) {
          $plate_name = $row->plate_name;
          
          $data .= '<option value="'.$plate_name.'">'.$plate_name.'</option>';

		}
		
		return $data;
    }

    //Get All The Dates Between The Date Range
    function getDatesFromRange($start, $end, $format = 'Y-m-d'){     
        // Declare an empty array 
        $array = array(); 
          
        // Variable that store the date interval 
        // of period 1 day 
        $interval = new DateInterval('P1D'); 
      
        $realEnd = new DateTime($end); 
        $realEnd->add($interval); 
      
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
      
        // Use loop to store date into array 
        foreach($period as $date) {                  
            $array[] = $date->format($format);  
        } 
      
        // Return the array elements 
        return array_reverse($array); 
    }

    //Daily Production Plates
    function daily_prod_plates($plate_type, $prod_date){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT sum(plate_qty) as plate_cnt FROM prod_plates_dtl
        where plate_name = '".$plate_type."' and prod_date = '".$prod_date."'";

        $qry = $ci->db->query($sql)->row();
        $plate_cnt = $qry->plate_cnt;

        if($plate_cnt == ""){
            $plate_cnt = 0;
        } else if($plate_cnt == 0){
            $plate_cnt = 0;
        }

        return $plate_cnt;

    }

    //Plates Wise Total Production Date Range
    function prod_plates_wise_dr($plate_type, $from_dt, $to_dt){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT sum(plate_qty) as plate_cnt FROM prod_plates_dtl
        where plate_name = '".$plate_type."' and prod_date between '".$from_dt."' and '".$to_dt."'";

        $qry = $ci->db->query($sql)->row();
        $plate_cnt = $qry->plate_cnt;

        if($plate_cnt == ""){
            $plate_cnt = 0;
        } else if($plate_cnt == 0){
            $plate_cnt = 0;
        }

        return $plate_cnt;

    }

    //Plates Total Production Date Range
    function prod_plates_dr($from_dt, $to_dt){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT sum(plate_qty) as plate_cnt FROM prod_plates_dtl
        where prod_date between '".$from_dt."' and '".$to_dt."'";

        $qry = $ci->db->query($sql)->row();
        $plate_cnt = $qry->plate_cnt;

        if($plate_cnt == ""){
            $plate_cnt = 0;
        } else if($plate_cnt == 0){
            $plate_cnt = 0;
        }

        return $plate_cnt;

    }


    //Daily Production Plates labour plates wise
    function daily_prod_plates_lw($plate_type, $prod_date, $labour_name){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT sum(plate_qty) as plate_cnt FROM prod_plates_dtl
        where plate_name = '".$plate_type."' and prod_date = '".$prod_date."' and labour_name = '".$labour_name."'";

        $qry = $ci->db->query($sql)->row();
        $plate_cnt = $qry->plate_cnt;

        if($plate_cnt == ""){
            $plate_cnt = 0;
        } else if($plate_cnt == 0){
            $plate_cnt = 0;
        }

        return $plate_cnt;

    }

    //Daily Production by Labour datewise
    function daily_prod_lab_datewise($prod_date, $labour_name){

        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT sum(plate_qty) as plate_cnt FROM prod_plates_dtl
        where prod_date = '".$prod_date."' and labour_name = '".$labour_name."'";

        $qry = $ci->db->query($sql)->row();
        $plate_cnt = $qry->plate_cnt;

        if($plate_cnt == ""){
            $plate_cnt = 0;
        } else if($plate_cnt == 0){
            $plate_cnt = 0;
        }

        return $plate_cnt;
    }

    //Daily Production Plates All
    function daily_prod_datewise($prod_date){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT sum(plate_qty) as plate_cnt FROM prod_plates_dtl where prod_date = '".$prod_date."'";

        $qry = $ci->db->query($sql)->row();
        $plate_cnt = $qry->plate_cnt;

        if($plate_cnt == ""){
            $plate_cnt = 0;
        } else if($plate_cnt == 0){
            $plate_cnt = 0;
        }

        return $plate_cnt;   
    }

    //Stone Size
    function stone_size(){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT * FROM stone_size_mst";

        $qry = $ci->db->query($sql);

        foreach($qry->result() as $row){
            $size_name = $row->size_name;
            $data .= '<option value="'.$size_name.'">'.$size_name.'</option>';
        }

        return $data;   
    }

    //Task Name
    function stone_task(){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT * FROM stone_task_mst";

        $qry = $ci->db->query($sql);

        foreach($qry->result() as $row){
            $task_name = $row->task_name;
            $data .= '<option value="'.$task_name.'">'.$task_name.'</option>';
        }

        return $data;   
    }

    //Process Type Function
    function process_type_fun(){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT * FROM prod_process_mst";

        $qry = $ci->db->query($sql);

        foreach($qry->result() as $row){
            $process_name = $row->process_name;
            $data .= '<option value="'.$process_name.'">'.$process_name.'</option>';
        }

        return $data;
    }

    //Get Labour Name
    function labour_name(){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT * FROM labour_mst";

        $qry = $ci->db->query($sql);

        foreach($qry->result() as $row){
            $labour_id = $row->labour_id;
            $labour_name = $row->labour_name;
            $data .= '<option value="'.$labour_id.'">'.$labour_name.'</option>';
        }

        return $data;
    }

    //Get Stone Type
    function stone_type(){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT * FROM stone_type_mst order by type_name";

        $qry = $ci->db->query($sql);

        foreach($qry->result() as $row){
            $type_id = $row->type_id;
            $type_name = $row->type_name;
            $data .= '<option value="'.$type_id.'">'.$type_name.'</option>';
        }

        return $data;
    }

    //Get Stone Size
    function stone_size_nm(){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT * FROM stone_size_mst order by size_name";

        $qry = $ci->db->query($sql);

        foreach($qry->result() as $row){
            $size_id = $row->size_id;
            $size_name = $row->size_name;
            $data .= '<option value="'.$size_id.'">'.$size_name.'</option>';
        }

        return $data;
    }

    //Get Stone Process
    function stone_process(){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT * FROM prod_process_mst order by process_name";

        $qry = $ci->db->query($sql);

        foreach($qry->result() as $row){
            $process_id = $row->process_id;
            $process_name = $row->process_name;
            $data .= '<option value="'.$process_id.'">'.$process_name.'</option>';
        }

        return $data;
    }
    
	
}