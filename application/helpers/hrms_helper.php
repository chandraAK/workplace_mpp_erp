<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('hrms')){

	function month(){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql="select distinct substring(CalDate,6,2) as month from tran_attendence";
		
        $query = $ci->db->query($sql);
        
        $data = '<option value="" selected>--Select--</option>';
        
		foreach ($query->result() as $row) {
            $month = $row->month;

            if($month == '01'){
                $month_word = "JAN";
            } else if($month == '02'){
                $month_word = "FEB";
            } else if($month == '03'){
                $month_word = "MAR";
            } else if($month == '04'){
                $month_word = "APR";
            } else if($month == '05'){
                $month_word = "MAY";
            } else if($month == '06'){
                $month_word = "JUNE";
            } else if($month == '07'){
                $month_word = "JULY";
            } else if($month == '08'){
                $month_word = "AUG";
            } else if($month == '09'){
                $month_word = "SEP";
            } else if($month == '10'){
                $month_word = "OCT";
            } else if($month == '11'){
                $month_word = "NOV";
            } else if($month == '12'){
                $month_word = "DEC";
            }
          
            $data .= '<option value="'.$month.'">'.$month_word.'</option>';

		}
		
		return $data;
    }

    function month_disp($month){
		$ci =& get_instance();
		$ci->load->database();

        if($month == '01'){
            $month_word = "Jan";
        } else if($month == '02'){
            $month_word = "Feb";
        } else if($month == '03'){
            $month_word = "Mar";
        } else if($month == '04'){
            $month_word = "Apr";
        } else if($month == '05'){
            $month_word = "May";
        } else if($month == '06'){
            $month_word = "June";
        } else if($month == '07'){
            $month_word = "July";
        } else if($month == '08'){
            $month_word = "Aug";
        } else if($month == '09'){
            $month_word = "Sep";
        } else if($month == '10'){
            $month_word = "Oct";
        } else if($month == '11'){
            $month_word = "Nov";
        } else if($month == '12'){
            $month_word = "Dec";
        }
		
		return $month_word;
    }

    function month_mpp(){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql="select distinct substring(CalDate,6,2) as month from mpp_tran_attendence";
		
        $query = $ci->db->query($sql);
        
        $data = '<option value="" selected>--Select--</option>';
        
		foreach ($query->result() as $row) {
            $month = $row->month;

            if($month == '01'){
                $month_word = "JAN";
            } else if($month == '02'){
                $month_word = "FEB";
            } else if($month == '03'){
                $month_word = "MAR";
            } else if($month == '04'){
                $month_word = "APR";
            } else if($month == '05'){
                $month_word = "MAY";
            } else if($month == '06'){
                $month_word = "JUNE";
            } else if($month == '07'){
                $month_word = "JULY";
            } else if($month == '08'){
                $month_word = "AUG";
            } else if($month == '09'){
                $month_word = "SEP";
            } else if($month == '10'){
                $month_word = "OCT";
            } else if($month == '11'){
                $month_word = "NOV";
            } else if($month == '12'){
                $month_word = "DEC";
            }
          
            $data .= '<option value="'.$month.'">'.$month_word.'</option>';

		}
		
		return $data;
    }
    
    function year(){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql="select distinct substring(CalDate,1,4) as year from tran_attendence";
		
        $query = $ci->db->query($sql);
        
        $data = '<option value="" selected>--Select--</option>';
        
		foreach ($query->result() as $row) {
            $year = $row->year;
          
            $data .= '<option value="'.$year.'">'.$year.'</option>';

		}
		
		return $data;
    }

    function comp(){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql="select distinct branch from tran_attendence where branch != '' and branch is not null";
		
        $query = $ci->db->query($sql);
        
        $data = '<option value="All" selected>All</option>';
        
		foreach ($query->result() as $row) {
            $branch = $row->branch;
          
            $data .= '<option value="'.$branch.'">'.$branch.'</option>';

		}
		
		return $data;
    }

    function year_mpp(){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql="select distinct substring(CalDate,1,4) as year from mpp_tran_attendence";
		
        $query = $ci->db->query($sql);
        
        $data = '<option value="" selected>--Select--</option>';
        
		foreach ($query->result() as $row) {
            $year = $row->year;
          
            $data .= '<option value="'.$year.'">'.$year.'</option>';

		}
		
		return $data;
    }
    
    function CardNo(){
		$ci =& get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);

        $username = $_SESSION['username'];

        //Sql Emp Details
        $sql_emp_det = "SELECT emp_id, role FROM login where username = '".$username."'";
        $qry_emp_det = $ci->db->query($sql_emp_det)->row();
        $emp_id = $qry_emp_det->emp_id;
        $role = $qry_emp_det->role;

        if($role != 'Admin'){

            $CardNoArr = array();

            //Getting HOD Card No
            $sql_hod_cardNo = "select distinct emp_card_no from `emp_rep_to_mst` where emp_id = '".$emp_id."'";
            $qry_hod_cardNo = $ci->db->query($sql_hod_cardNo)->row();
            $hod_card_no = $qry_hod_cardNo->emp_card_no;

            array_push($CardNoArr,$hod_card_no);

            //Getting Team IDS
            $sql_team_id = "select distinct emp_card_no from `emp_rep_to_mst` where emp_reportsto_id = '".$emp_id."'";
            $qry_team_id = $ci->db->query($sql_team_id);

            foreach($qry_team_id->result() as $row){
                $card_no = $row->emp_card_no;
                array_push($CardNoArr,$card_no);

                //Getting Sub Team IDS
                $sql_team_team_id = "select distinct emp_card_no from `emp_rep_to_mst` 
                where emp_reportsto_cardno = '".$card_no."'";
                $qry_team_team_id = $ci->db->query($sql_team_team_id);

                foreach($qry_team_team_id->result() as $row){
                    $card_no1 = $row->emp_card_no;
                    array_push($CardNoArr,$card_no1);

                    //Getting Sub Team IDS
                    $sql_team_team_id1 = "select distinct emp_card_no from `emp_rep_to_mst` 
                    where emp_reportsto_cardno = '".$card_no1."'";
                    $qry_team_team_id1 = $ci->db->query($sql_team_team_id1);

                    foreach($qry_team_team_id1->result() as $row){
                        $card_no2 = $row->emp_card_no;
                        array_push($CardNoArr,$card_no2);

                        //Getting Sub Team IDS
                        $sql_team_team_id2 = "select distinct emp_card_no from `emp_rep_to_mst` 
                        where emp_reportsto_cardno = '".$card_no2."'";
                        $qry_team_team_id2 = $ci->db->query($sql_team_team_id2);

                        foreach($qry_team_team_id2->result() as $row){
                            $card_no3 = $row->emp_card_no;
                            array_push($CardNoArr,$card_no3);

                            //Getting Sub Team IDS
                            $sql_team_team_id3 = "select distinct emp_card_no from `emp_rep_to_mst` 
                            where emp_reportsto_cardno = '".$card_no3."'";
                            $qry_team_team_id3 = $ci->db->query($sql_team_team_id3);

                            foreach($qry_team_team_id3->result() as $row){
                                $card_no4 = $row->emp_card_no;
                                array_push($CardNoArr,$card_no4);
                            }
                        }
                    }
                }
            }

            $str = '';
            foreach($CardNoArr as $var){
                if($str == ''){
                    $str = "'".$var."'";
                }else{
                    $str = $str.","."'".$var."'";
                }
            }
                
            $sql="select distinct CardNo as CardNo from tran_attendence where CardNo in(".$str.")";

        } else {
            $sql="select distinct CardNo as CardNo from tran_attendence";
        }

        
		
        $query = $ci->db->query($sql);

        $data = '<option value="" selected>--Select--</option>';

		foreach ($query->result() as $row) {
            $CardNo = $row->CardNo;

            //EMP ID & CARD NO
            $sql_emp_det = "select emp_id, emp_name from `emp_rep_to_mst` where emp_card_no = '".$CardNo."'";
            $qry_emp_det = $ci->db->query($sql_emp_det)->row();

            $emp_id = $qry_emp_det->emp_id;
            $emp_name = $qry_emp_det->emp_name;
          
            $data .= '<option value="'.$CardNo.'">'.$CardNo.' - '.$emp_name.'</option>';

		}
		
		return $data;
    }

    function EmpId(){
		$ci =& get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);

        $username = $_SESSION['username'];

        //Sql Emp Details
        $sql_emp_det = "SELECT emp_id, role FROM login where username = '".$username."'";
        $qry_emp_det = $ci->db->query($sql_emp_det)->row();
        $emp_id = $qry_emp_det->emp_id;
        $role = $qry_emp_det->role;
       

        if($role != 'Admin'){

            $EmpIdArr = array();
            array_push($EmpIdArr,$emp_id);

            //Getting Team IDS
            $sql_team_id = "select distinct emp_id from `emp_rep_to_mst` where emp_reportsto_id = '".$emp_id."'";
            $qry_team_id = $ci->db->query($sql_team_id);

            foreach($qry_team_id->result() as $row){
                $EmpId = $row->emp_id;
                array_push($EmpIdArr,$EmpId);

                //Getting Sub Team IDS
                $sql_team_team_id = "select distinct emp_id from `emp_rep_to_mst` 
                where emp_reportsto_id = '".$emp_id."'";
                $qry_team_team_id = $ci->db->query($sql_team_team_id);

                foreach($qry_team_team_id->result() as $row){
                    $emp_id1 = $row->emp_id;
                    array_push($EmpIdArr,$emp_id1);

                    //Getting Sub Team IDS
                    $sql_team_team_id1 = "select distinct emp_id from `emp_rep_to_mst` 
                    where emp_reportsto_id = '".$emp_id1."'";
                    $qry_team_team_id1 = $ci->db->query($sql_team_team_id1);

                    foreach($qry_team_team_id1->result() as $row){
                        $emp_id2 = $row->emp_id;
                        array_push($EmpIdArr,$emp_id2);

                        //Getting Sub Team IDS
                        $sql_team_team_id2 = "select distinct emp_id from `emp_rep_to_mst` 
                        where emp_reportsto_id = '".$emp_id2."'";
                        $qry_team_team_id2 = $ci->db->query($sql_team_team_id2);

                        foreach($qry_team_team_id2->result() as $row){
                            $emp_id3 = $row->emp_id;
                            array_push($EmpIdArr,$emp_id3);

                            //Getting Sub Team IDS
                            $sql_team_team_id3 = "select distinct emp_id from `emp_rep_to_mst` 
                            where emp_reportsto_id = '".$emp_id3."'";
                            $qry_team_team_id3 = $ci->db->query($sql_team_team_id3);

                            foreach($qry_team_team_id3->result() as $row){
                                $emp_id4 = $row->emp_id;
                                array_push($EmpIdArr,$emp_id4);

                                //Getting Sub Team IDS
                                $sql_team_team_id4 = "select distinct emp_id from `emp_rep_to_mst` 
                                where emp_reportsto_id = '".$emp_id4."'";
                                $qry_team_team_id4 = $ci->db->query($sql_team_team_id4);

                                foreach($qry_team_team_id4->result() as $row){
                                    $emp_id5 = $row->emp_id;
                                    array_push($EmpIdArr,$emp_id5);
                                }
                            }
                        }
                    }
                }
            }

            $str = '';
            foreach($EmpIdArr as $var){
                if($str == ''){
                    $str = "'".$var."'";
                }else{
                    $str = $str.","."'".$var."'";
                }
            }
                
            $sql="select distinct EmpId as EmpId from tran_attendence where EmpId in(".$str.")";

        } else {
            $sql="select distinct EmpId as EmpId from tran_attendence";
        }

        
		
        $query = $ci->db->query($sql);

        $data = '<option value="">--Select--</option>';

		foreach ($query->result() as $row) {
            $EmpId = $row->EmpId;

            //EMP ID & CARD NO
            $sql_emp_det = "select emp_id, emp_name from `emp_rep_to_mst` where emp_id = '".$EmpId."'";
            $qry_emp_det = $ci->db->query($sql_emp_det)->row();

            $emp_id = $qry_emp_det->emp_id;
            $emp_name = $qry_emp_det->emp_name;
          
            $data .= '<option value="'.$emp_id.'">'.$emp_id.' - '.$emp_name.'</option>';

		}
		
		return $data;
    }

    function EmpIdCont(){
		$ci =& get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);

        $username = $_SESSION['username'];

        //Sql Emp Details
        $sql_emp_det = "SELECT emp_id, role FROM login where username = '".$username."'";
        $qry_emp_det = $ci->db->query($sql_emp_det)->row();
        $emp_id = $qry_emp_det->emp_id;
        $role = $qry_emp_det->role;
       

        if($role != 'Admin'){

            $EmpIdArr = array();
            array_push($EmpIdArr,$emp_id);

            //Getting Team IDS
            $sql_team_id = "select distinct emp_id from `emp_rep_to_mst` where emp_reportsto_id = '".$emp_id."'";
            $qry_team_id = $ci->db->query($sql_team_id);

            foreach($qry_team_id->result() as $row){
                $EmpId = $row->emp_id;
                array_push($EmpIdArr,$EmpId);

                //Getting Sub Team IDS
                $sql_team_team_id = "select distinct emp_id from `emp_rep_to_mst` 
                where emp_reportsto_id = '".$emp_id."'";
                $qry_team_team_id = $ci->db->query($sql_team_team_id);

                foreach($qry_team_team_id->result() as $row){
                    $emp_id1 = $row->emp_id;
                    array_push($EmpIdArr,$emp_id1);

                    //Getting Sub Team IDS
                    $sql_team_team_id1 = "select distinct emp_id from `emp_rep_to_mst` 
                    where emp_reportsto_id = '".$emp_id1."'";
                    $qry_team_team_id1 = $ci->db->query($sql_team_team_id1);

                    foreach($qry_team_team_id1->result() as $row){
                        $emp_id2 = $row->emp_id;
                        array_push($EmpIdArr,$emp_id2);

                        //Getting Sub Team IDS
                        $sql_team_team_id2 = "select distinct emp_id from `emp_rep_to_mst` 
                        where emp_reportsto_id = '".$emp_id2."'";
                        $qry_team_team_id2 = $ci->db->query($sql_team_team_id2);

                        foreach($qry_team_team_id2->result() as $row){
                            $emp_id3 = $row->emp_id;
                            array_push($EmpIdArr,$emp_id3);

                            //Getting Sub Team IDS
                            $sql_team_team_id3 = "select distinct emp_id from `emp_rep_to_mst` 
                            where emp_reportsto_id = '".$emp_id3."'";
                            $qry_team_team_id3 = $ci->db->query($sql_team_team_id3);

                            foreach($qry_team_team_id3->result() as $row){
                                $emp_id4 = $row->emp_id;
                                array_push($EmpIdArr,$emp_id4);

                                //Getting Sub Team IDS
                                $sql_team_team_id4 = "select distinct emp_id from `emp_rep_to_mst` 
                                where emp_reportsto_id = '".$emp_id4."'";
                                $qry_team_team_id4 = $ci->db->query($sql_team_team_id4);

                                foreach($qry_team_team_id4->result() as $row){
                                    $emp_id5 = $row->emp_id;
                                    array_push($EmpIdArr,$emp_id5);
                                }
                            }
                        }
                    }
                }
            }

            $str = '';
            foreach($EmpIdArr as $var){
                if($str == ''){
                    $str = "'".$var."'";
                }else{
                    $str = $str.","."'".$var."'";
                }
            }
                
            $sql="select distinct EmpId as EmpId from tran_attendence where EmpId in(".$str.") and is_on_contract = 1";

        } else {
            $sql="select distinct EmpId as EmpId from tran_attendence where is_on_contract = 1";
        }

        
		
        $query = $ci->db->query($sql);

        $data = '<option value="">--Select--</option>';

		foreach ($query->result() as $row) {
            $EmpId = $row->EmpId;

            //EMP ID & CARD NO
            $sql_emp_det = "select emp_id, emp_name from `emp_rep_to_mst` where emp_id = '".$EmpId."'";
            $qry_emp_det = $ci->db->query($sql_emp_det)->row();

            $emp_id = $qry_emp_det->emp_id;
            $emp_name = $qry_emp_det->emp_name;
          
            $data .= '<option value="'.$emp_id.'">'.$emp_id.' - '.$emp_name.'</option>';

		}
		
		return $data;
    }

    function CardNoMpp(){
		$ci =& get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);
			
        $sql="SELECT distinct CardNo, EmpName FROM mpp_emp_mst ORDER BY EmpName ASC ";
		
        $query = $ci->db->query($sql);

        $data = '<option value="" selected>--Select--</option>';

		foreach ($query->result() as $row) {
            $CardNo = $row->CardNo;
            $EmpName = $row->EmpName;
          
            $data .= '<option value="'.$CardNo.'">'.$CardNo.' - '.$EmpName.'</option>';

		}
		
		return $data;
    }
    
    //InDateTime
    function FunInDateTime($CalDate, $CardNo){
        $ci =& get_instance();
		$ci->load->database();
			
        $sql="select InDateTime from tran_attendence where CardNo = '".$CardNo."' and CalDate = '".$CalDate."'";
		
        $query = $ci->db->query($sql)->row();

        $InDateTime = $query->InDateTime;

        if($InDateTime == ""){
            $InDateTime = "";
        }
		
		return $InDateTime;
    }

    //OutDateTime
    function FunOutDateTime($CalDate, $CardNo){
        $ci =& get_instance();
		$ci->load->database();
			
        $sql="select OutDateTime from tran_attendence where CardNo = '".$CardNo."' and CalDate = '".$CalDate."'";
		
        $query = $ci->db->query($sql)->row();

        $OutDateTime = $query->OutDateTime;

        if($OutDateTime == ""){
            $OutDateTime = "";
        }
		
		return $OutDateTime;
    }

    function count_array_value($my_array, $match) 
    { 
        $count = 0; 
        
        foreach ($my_array as $key => $value) 
        { 
            if ($value == $match) 
            { 
                $count++; 
            } 
        } 
        
        return $count; 
    } 

    //Count Total
    function count_tot_att($status, $date){
        $ci = & get_instance();
        $db2 = $ci->load->database('db2',TRUE);
        
        //$response = array();
        $sql = "select count(*) as cnt 
        from `tabAttendance` where status = '".$status."' 
        and attendance_date = '".$date."'" ;

        $query = $db2->query($sql)->row();

        $cnt = $query->cnt;
	
		return $cnt;
    }

    //Count Total
    function att_count_tot($status, $from_dt, $to_dt){
        $ci = & get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2',TRUE);

        $sql = "SELECT count(*) as cnt FROM `tran_attendence` 
        WHERE CalDate between '".$from_dt."' AND '".$to_dt."'
        AND $status = 1 AND is_on_contract = 0";

        $query = $ci->db->query($sql)->row();

        $cnt = $query->cnt;
	
		return $cnt;
    }

    //Detail Total
    function att_det_tot($status,  $from_dt, $to_dt, $shift_type){
        $ci = & get_instance();
        $ci->load->database();

        $where_str = "";

        if($shift_type == "All"){
            $where_str .= "";
        } else {
            $where_str .= " and ShiftOnAttDateType = '".$shift_type."'";
        }
        
        $data = '
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th>SNO</th>
                    <th>Branch</th>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Reports To</th>
                    <th>Reports Name</th>
                    <th>Emp Type</th>
                    <th>Att Date</th>
                    <th>Day</th>
                    <th>DefaultShift</th>
                    <th>Shift On Att Date</th>
                    <th>Shift On Att Date Type</th>
                    <th>Shift Start Time</th>
                    <th>Shift End Time</th>
                    <th>Shift Working Hrs</th>
                    <th>In Date Time</th>
                    <th>Out Date Time</th>
                    <th>Tot Hrs</th>
                    <th>Paid Day</th>
                    <th>Leave</th>
                    <th>Gate Pass</th>
                    <th>Mispunch</th>
                    <th>Holiday</th>
                    <th>Att Type</th>
                    <th>Late Coming</th>
                    <th>Over Time</th>
                    <th>Early Exit</th>
                </tr>
            </thead>
            <tbody>';

            $sql_att = "SELECT * FROM `tran_attendence` 
            WHERE CalDate between '".$from_dt."' AND '".$to_dt."'
            AND $status = 1 AND is_on_contract = 0 $where_str";

            $qry_att = $ci->db->query($sql_att);
            $sno = 0;
            foreach($qry_att->result() as $row){
                $sno++;
                $CardNo = $row->CardNo;
                $EmpId = $row->EmpId;
                $EmpName = $row->EmpName;
                $department = $row->department;
                $reports_to = $row->reports_to;
                $is_employee = $row->is_employee;
                $CalDate = $row->CalDate;
                $Day = $row->Day;
                $DefaultShift = $row->DefaultShift;
                $ShiftOnAttDate = $row->ShiftOnAttDate;
                $ShiftOnAttDateType = $row->ShiftOnAttDateType;
                $ShiftStartTime = $row->ShiftStartTime;
                $ShiftEndTime = $row->ShiftEndTime;
                $ShiftWorkingHrs = $row->ShiftWorkingHrs;
                $InDateTime = $row->InDateTime;
                $OutDateTime = $row->OutDateTime;
                $Tot_Hrs = $row->Tot_Hrs;
                $PaidDay = $row->PaidDay;
                $emp_leave = $row->emp_leave;
                $emp_gatepass = $row->emp_gatepass;
                $emp_mispunch = $row->emp_mispunch;
                $emp_holiday = $row->emp_holiday;
                $att_type = $row->att_type;
                $LateComing = $row->LateComing;
                $OverTime = $row->OverTime;
                $EarlyExit = $row->EarlyExit;
                $branch = $row->branch;

                $sql_rep_name = "select emp_name from emp_rep_to_mst where emp_id='".$reports_to."'";
                $qry_rep_name = $ci->db->query($sql_rep_name)->row();
                $rep_emp_name = $qry_rep_name->emp_name;

                $emp_type = "";
                if($is_employee == 1){
                    $emp_type = "TYPE-1";
                } else {
                    $emp_type = "TYPE-2";
                }

                $data .='
                <tr>
                    <td>'.$sno.'</td>
                    <td>'.$branch.'</td>
                    <td>'.$CardNo.'</td>
                    <td>'.$EmpId.'</td>
                    <td>'.$EmpName.'</td>
                    <td>'.$department.'</td>
                    <td>'.$reports_to.'</td>
                    <td>'.$rep_emp_name.'</td>
                    <td>'.$emp_type.'</td>
                    <td>'.$CalDate.'</td>
                    <td>'.$Day.'</td>
                    <td>'.$DefaultShift.'</td>
                    <td>'.$ShiftOnAttDate.'</td>
                    <td>'.$ShiftOnAttDateType.'</td>
                    <td>'.$ShiftStartTime.'</td>
                    <td>'.$ShiftEndTime.'</td>
                    <td>'.$ShiftWorkingHrs.'</td>
                    <td>'.$InDateTime.'</td>
                    <td>'.$OutDateTime.'</td>
                    <td>'.$Tot_Hrs.'</td>
                    <td>'.$PaidDay.'</td>
                    <td>'.$emp_leave.'</td>
                    <td>'.$emp_gatepass.'</td>
                    <td>'.$emp_mispunch.'</td>
                    <td>'.$emp_holiday.'</td>
                    <td>'.$att_type.'</td>
                    <td>'.$LateComing.'</td>
                    <td>'.$OverTime.'</td>
                    <td>'.$EarlyExit.'</td>
                </tr>';
            }
        $data .='
            </tbody>
        </table>';

        return $data;
    }

    //Fixed Overtime Hours Amount
    //Detail Total
    function fixed_ot_tot($from_dt, $to_dt, $month_days){
        $ci = & get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2',TRUE);
        
        $data = '
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th>Card No</th>
                    <th>Employee</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Reports To</th>
                    <th>Employee Type</th>
                    <th>Salary Mode</th>
                    <th>OT Calculate</th>
                    <th>Mandatory OT Hours</th>
                    <th>Duty Hours</th>
                    <th>Total OT Hours</th>
                    <th>Monthly Salary</th>
                    <th>Per Hour Salary</th>
                    <th>Total OT Amount</th>
                </tr>
            </thead>
            <tbody>';

            $sql_att = "SELECT distinct CardNo, EmpId, EmpName, department, reports_to,
            is_on_contract, is_employee, is_overtime_calculate
            FROM `tran_attendence` 
            WHERE CalDate between '".$from_dt."' AND '".$to_dt."' 
            AND is_on_contract = 0
            AND is_employee = 1
            AND is_overtime_calculate = 1";

            $qry_att = $ci->db->query($sql_att);
            $sno = 0;
            $OTAmt_Tot_GT = 0;
            foreach($qry_att->result() as $row){
                $sno++;
                $CardNo = $row->CardNo;
                $EmpId = $row->EmpId;
                $EmpName = $row->EmpName;
                $department = $row->department;
                $reports_to = $row->reports_to;
                $is_on_contract = $row->is_on_contract;
                $is_employee = $row->is_employee;
                $is_overtime_calculate = $row->is_overtime_calculate;

                if($is_employee > 0){
                    $emp_type = "TYPE-1";
                } else {
                    $emp_type = "TYPE-2";
                }

                if($is_overtime_calculate > 0){
                    $ot_cal = "Yes";
                } else {
                    $ot_cal = "No";
                }

                $sql_ot_hrs = "select custom_overtime_ as ot_hrs, custom_duty_hours, custom_employee_type, salary_mode from `tabEmployee` 
                where name = '".$EmpId."' 
                and is_overtime_calculate = 1 
                and is_employee = 1";

                $qry_ot_hrs = $db2->query($sql_ot_hrs)->row();
                $ot_hrs = $qry_ot_hrs->ot_hrs;
                $duty_hour = $qry_ot_hrs->custom_duty_hours;
                $employee_type = $qry_ot_hrs->custom_employee_type;
                $salary_mode = $qry_ot_hrs->salary_mode;
                $OT_Tot = 0;
                $gross_sal = 0;
                $PerDaySal = 0;
                $PerHrSal = 0;
                $OTAmt_Tot = 0;

                //Overtime Hours Calculation
                //February OT - 2021
                if($to_dt <= '2021-02-28'){

                    $sql_ot = "select sum(OverTime) as OT_Tot FROM `tran_attendence` 
                    WHERE CalDate between '".$from_dt."' AND '".$to_dt."'
                    AND EmpId = '".$EmpId."' 
                    AND is_on_contract = 0
                    AND is_employee = 1
                    AND is_overtime_calculate = 1";

                    $qry_ot = $ci->db->query($sql_ot)->row();

                    $OT_Tot = $qry_ot->OT_Tot;

                } else {

                    $sql_ot = "select OverTime FROM `tran_attendence` 
                    WHERE CalDate between '".$from_dt."' AND '".$to_dt."'
                    AND EmpId = '".$EmpId."' 
                    AND is_on_contract = 0
                    AND is_employee = 1
                    AND is_overtime_calculate = 1";

                    $qry_ot = $ci->db->query($sql_ot);

                    foreach($qry_ot->result() as $row){
                        $OverTime = $row->OverTime;

                        if($OverTime >=  $ot_hrs){
                            $OT_Tot = $OT_Tot+$ot_hrs;
                        }
                    }

                }

                //Getting Monthly Salary
                $sql_emp_sal = "select base from `tabSalary Structure Assignment` 
                where workflow_state = 'Approved' 
                and from_date = (select max(from_date) from `tabSalary Structure Assignment` 
                where workflow_state = 'Approved' and employee = '".$EmpId."')
                and employee = '".$EmpId."'";

                $qry_emp_sal = $db2->query($sql_emp_sal)->row();
                $gross_sal = $qry_emp_sal->base;
                $PerDaySal = $gross_sal/$month_days;

                //Per Hour Salary
                $PerHrSal = $PerDaySal/$duty_hour;

                //OT Amount Calculation
                $OTAmt_Tot = $PerHrSal*$OT_Tot;



                $data .='
                <tr>
                    <td>'.$CardNo.'</td>
                    <td>'.$EmpId.'</td>
                    <td>'.$EmpName.'</td>
                    <td>'.$department.'</td>
                    <td>'.$reports_to.'</td>
                    <td>'.$employee_type.'</td>
                    <td>'.$salary_mode.'</td>
                    <td>'.$ot_cal.'</td>
                    <td>'.$ot_hrs.'</td>
                    <td>'.number_format($duty_hour,2,".","").'</td>
                    <td>'.$OT_Tot.'</td>
                    <td>'.number_format($gross_sal,2,".","").'</td>
                    <td>'.number_format($PerHrSal,2,".","").'</td>
                    <td>'.number_format(round($OTAmt_Tot),2,".","").'</td>
                </tr>';

                $OTAmt_Tot_GT = $OTAmt_Tot_GT+$OTAmt_Tot;
            }

            $data .='
                <tr style="font-weight:bold">
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>'.number_format(round($OTAmt_Tot_GT),2,".","").'</td>
                </tr>';

        $data .='
            </tbody>
        </table>';

        return $data;
    }


    //Attendence Hours
    function tot_hrs_cal($from_dt, $to_dt, $CardNo){
        $ci = & get_instance();
        $ci->load->database();

        $dates = getDatesFromRange($from_dt, $to_dt);

        $str = '';
		foreach($dates as $var){
		
			if($str == ''){
				$str = "'".$var."'";
			}else{
				$str = $str.","."'".$var."'";
			}
		}
        
        $sql_att = "SELECT Tot_Hrs, InDateTime, OutDateTime FROM `tran_attendence` where CalDate in(".$str.") and CardNo = '".$CardNo."'";
        $qry_att = $ci->db->query($sql_att);

        //return $qry_att->Tot_Hrs; 
        $html = "";
        foreach($qry_att->result() as $row){
            $html .= "<td>Total Hrs:".$row->Tot_Hrs."<br/><br/>In:".$row->InDateTime."<br/><br/>Out:".$row->OutDateTime."</td>";
        }
        
        $html .="</tr>";
        
        return $html;
    }

    //Attendence Hours
    function tot_hrs_cal_dw($from_dt, $to_dt, $CardNo){
        $ci = & get_instance();
        $ci->load->database();
       
        
        $sql_att = "SELECT sum(Pay_Hrs) as Tot_Hrs FROM `tran_attendence` 
        where CalDate between '".$from_dt."' and '".$to_dt."' and CardNo = '".$CardNo."'";

        $qry_att = $ci->db->query($sql_att)->row();

        $Tot_Hrs = $qry_att->Tot_Hrs;
        
        return $Tot_Hrs;
    }

    //Attendence Hours MPP
    function tot_hrs_cal_mpp($date, $CardNo){
        $ci = & get_instance();
        $ci->load->database();

        $sql_att = "SELECT Tot_Hrs FROM `mpp_tran_attendence` where CalDate = '".$date."' and CardNo = '".$CardNo."'";
        $qry_att = $ci->db->query($sql_att)->row();

        return $qry_att->Tot_Hrs;      
    }

    //Attendence Hours MPP
    function tot_hrs_cal_mpp_dw($from_dt, $to_dt, $CardNo){
        $ci = & get_instance();
        $ci->load->database();

        $sql_att = "SELECT sum(Tot_Hrs) as Tot_Hrs FROM `mpp_tran_attendence` 
        where CalDate between '".$from_dt."' and '".$to_dt."' and CardNo = '".$CardNo."'";
        $qry_att = $ci->db->query($sql_att)->row();

        return $qry_att->Tot_Hrs;      
    }

    //Attendence Hours
    function InMisPunch($date, $CardNo){
        $ci = & get_instance();
        $ci->load->database();

        $sql_att = "SELECT count(*) as cnt FROM `tran_attendence` 
        where CalDate = '".$date."' 
        and CardNo = '".$CardNo."'
        and YEAR(InDateTime) = 0 
        and YEAR(OutDateTime) != 0
        ";

        $qry_att = $ci->db->query($sql_att)->row();

        $cnt = $qry_att->cnt;
        
        if($cnt > 0){
            return "In Punch Missing";
        } else {
            return "";
        }
    }

    function OutMispunch($date, $CardNo){
        $ci = & get_instance();
        $ci->load->database();

        $sql_att = "SELECT count(*) as cnt FROM `tran_attendence` 
        where CalDate = '".$date."' 
        and CardNo = '".$CardNo."'
        and YEAR(InDateTime) != 0 
        and YEAR(OutDateTime) = 0
        ";

        $qry_att = $ci->db->query($sql_att)->row();

        $cnt = $qry_att->cnt; 
        
        if($cnt > 0){
            return "Out Punch Missing";
        } else {
            return "";
        }
    }

    //Attendence Type Daywise
    function att_type_cal($date, $CardNo){
        $ci = & get_instance();
        $ci->load->database();

        $sql_att = "SELECT att_type FROM `tran_attendence` where CalDate = '".$date."' and CardNo = '".$CardNo."'";
        $qry_att = $ci->db->query($sql_att)->row();

        return $qry_att->att_type;      
    }

    //Total Paid Days
    function tot_paid_days($from_dt, $to_dt, $CardNo){
        $ci = & get_instance();
        $ci->load->database();

        $sql_att = "SELECT sum(PaidDay) as pay_days FROM `tran_attendence` 
        where CalDate BETWEEN '".$from_dt."' AND '".$to_dt."' 
        and CardNo = '".$CardNo."'";

        $qry_att = $ci->db->query($sql_att)->row();

        return $qry_att->pay_days; 
    }

    //Total Paid Days MPP
    function tot_paid_days_mpp($from_dt, $to_dt, $CardNo){
        $ci = & get_instance();
        $ci->load->database();

        $sql_att = "SELECT sum(PaidDay) as pay_days FROM `mpp_tran_attendence` where CalDate BETWEEN '".$from_dt."' AND '".$to_dt."' and CardNo = '".$CardNo."'";
        $qry_att = $ci->db->query($sql_att)->row();

        return $qry_att->pay_days; 
    }

    //Total Late Coming
    function tot_late_coming($from_dt, $to_dt, $CardNo){
        $ci = & get_instance();
        $ci->load->database();

        $sql_att = "SELECT sum(LateComing) as LateComing FROM `tran_attendence` where CalDate BETWEEN '".$from_dt."' AND '".$to_dt."' and CardNo = '".$CardNo."'";
        $qry_att = $ci->db->query($sql_att)->row();

        return $qry_att->LateComing; 

    }

    //Total Early Exit
    function tot_early_exit($from_dt, $to_dt, $CardNo){
        $ci = & get_instance();
        $ci->load->database();

        $sql_att = "SELECT sum(EarlyExit) as EarlyExit FROM `tran_attendence` where CalDate BETWEEN '".$from_dt."' AND '".$to_dt."' and CardNo = '".$CardNo."'";
        $qry_att = $ci->db->query($sql_att)->row();

        return $qry_att->EarlyExit; 

    }

    //Total Overtime
    function tot_overtime($from_dt, $to_dt, $CardNo){
        $ci = & get_instance();
        $ci->load->database();

        $sql_att = "SELECT sum(OverTime) as OverTime FROM `tran_attendence` where CalDate BETWEEN '".$from_dt."' AND '".$to_dt."' and CardNo = '".$CardNo."'";
        $qry_att = $ci->db->query($sql_att)->row();

        return $qry_att->OverTime; 

    }

    //HOD List
    function hod_list(){
        $ci = & get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2',TRUE);

        $data="";

        $username = $_SESSION['username'];

        $sql_user_det = "select * from login where username = '".$username."'";
        $qry_user_det = $ci->db->query($sql_user_det)->row();
        $role = $qry_user_det->role;
        $emp_id = $qry_user_det->emp_id; 

        if($role == "Admin"){
            $where_str = "";
        } else {
            $where_str = " and reports_to = '".$emp_id."'";
        }

        $sql_hod = "SELECT distinct reports_to FROM `tran_attendence` 
        WHERE reports_to is not NULL 
        and reports_to != '' 
        and reports_to not like 'EMP-MPP%' 
        $where_str
        order by reports_to desc ";

        $qry_hod = $ci->db->query($sql_hod);
        
        foreach($qry_hod->result() as $row){
            $reports_to = $row->reports_to;

            $sql_empnm = "select employee_name from `tabEmployee` where name='".$reports_to."'";
            $qry_empnm = $db2->query($sql_empnm)->row();
            $employee_name = $qry_empnm->employee_name;

            $data .= '<option value="'.$reports_to.'">'.$reports_to.' - '.$employee_name.'</option>';
        }

        return $data;
    }


    //Department List
    function dept_list(){
        $ci = & get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2',TRUE);

        $data="";

        $sql_dept = "SELECT distinct department FROM `tran_attendence` 
        WHERE department is not NULL 
        and department != ''
        order by department";

        $qry_dept = $ci->db->query($sql_dept);
        
        foreach($qry_dept->result() as $row){
            $department = $row->department;

            $data .= '<option value="'.$department.'">'.$department.'</option>';
        }

        return $data;
    }

    //Attendence Type List
    function att_type_list(){
        $ci = & get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2',TRUE);

        $data="";

        $sql_att_type = "SELECT distinct att_type FROM `tran_attendence` 
        WHERE att_type is not NULL 
        and att_type != '' 
        order by att_type";

        $qry_att_type = $ci->db->query($sql_att_type);
        
        foreach($qry_att_type->result() as $row){
            $status = $row->att_type;

            $data .= '<option value="'.$status.'">'.$status.'</option>';
        }

        return $data;
    }


    function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        $array = array();
        $interval = new DateInterval('P1D');
    
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
    
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
    
        foreach($period as $date) { 
            $array[] = $date->format($format); 
        }
    
        return $array;
    }


    function get_rep_email($reports_to){
        $ci = & get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2',TRUE);

        //echo $reports_to; die;

        //Reporting Email
        if($reports_to == "" && $reports_to == NULL){
            $emp_rt_email = "";
        } else {
            $sql_rt_email = "select prefered_email from tabEmployee where name = '".$reports_to."'";
            $qry_rt_email = $db2->query($sql_rt_email)->row();
            $emp_rt_email = $qry_rt_email->prefered_email;
        }

        return $emp_rt_email;

    }

    function get_emp_email($EmpId){
        $ci = & get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2',TRUE);

        $sql_emp_email = "select prefered_email from tabEmployee where name = '".$EmpId."'";
        $qry_emp_email = $db2->query($sql_emp_email)->row();
        $emp_comp_email = $qry_emp_email->prefered_email;

        return $emp_comp_email;

    }

    function get_prev_entry($from_dt, $type, $EmpId){
        $ci = & get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2',TRUE);

        $sql_prev_cnt = "select count(*) as cnt_prev from tran_mail_det 
        where CalDate = '".$from_dt."' 
        and MailType='".$type."'
        and EmpId = '".$EmpId."'";

        $qry_prev_cnt = $ci->db->query($sql_prev_cnt)->row();
        $cnt_prev = $qry_prev_cnt->cnt_prev;

        return $cnt_prev;    
    }

    //Get Type1 Employees List
    function get_type1_emp(){
        $ci = & get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2',TRUE);

        $name_arr = array();
        $sql_emp_type1 = "select distinct name from tabEmployee where status = 'Active' and custom__type_2 = 0";
        $qry_emp_type1 = $db2->query($sql_emp_type1);
        foreach($qry_emp_type1->result() as $row){
            $name = $row->name;
            array_push($name_arr,$name);
        }

        return $name_arr;   
    }

    //Get Type2 Employees List
    function get_type2_emp(){
        $ci = & get_instance();
        $ci->load->database();
        $db2 = $ci->load->database('db2',TRUE);

        $name_arr = array();
        $sql_emp_type1 = "select distinct name from tabEmployee where status = 'Active' and custom__type_2 = 1";
        $qry_emp_type1 = $db2->query($sql_emp_type1);
        foreach($qry_emp_type1->result() as $row){
            $name = $row->name;
            array_push($name_arr,$name);
        }

        return $name_arr;   
    }

    //Get Casual Leaves
    function GetLeaves($emp_id, $leave_type){
        $ci = & get_instance();
        $ci->load->database();
        
        $sql = "SELECT sum(leave_days) as tot_leaves FROM `leave_mst` 
        where leave_emp_id = '".$emp_id."' 
        and leave_type = '".$leave_type."' and leave_status = 'Approved'";

        $qry = $ci->db->query($sql)->row();
        $tot_leaves = $qry->tot_leaves;

        if($tot_leaves == ""){
            $tot_leaves = 0;
        }

        return $tot_leaves;
    }


    function case_count_mp($status){
		$ci =& get_instance();
		$ci->load->database();
        $username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR mp_hod_id = '".$emp_id."' OR mp_emp_id = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
        $sql_cnt = "select count(*) as cnt from miss_punch where mp_status = '".$status."' $where_str";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
		
		return $cnt;
	}
	
	function case_det_mp($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;
       
		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR mp_hod_id = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
		$sql_det = "select * from miss_punch where mp_status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
				<td>Miss Punch ID</td>
				<td>Employee ID</td>
				<td>Employee Name</td>
                <td>HOD ID</td>
                <td>HOD Name</td>
				<td>Miss Punch Type</td>
                <td>Miss Punch Date</td>                
                <td>Miss Punch Time</td>                
				<td>Status</td>
				<td>Created By</td>				
				<td>Age(Days)</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $miss_pun_id = $row->miss_pun_id;
            $mp_emp_id = $row->mp_emp_id;
            $mp_hod_id = $row->mp_hod_id;
            $miss_pun_type = $row->miss_pun_type;
            $miss_pun_date = $row->miss_pun_date;
            $miss_pun_time = $row->miss_pun_time;
            $mp_status = $row->mp_status;
            $created_by = $row->created_by;            
            $curr_date = date("Y-m-d h:i:s");
            $date1=date_create($created_date);
            $date2=date_create($curr_date);
            $age = date_diff($date1,$date2);
                       
            //Emp Name
            $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$mp_emp_id."'";
            $qry_emp_name = $ci->db->query($sql_emp_name)->row();
            $emp_name = $qry_emp_name->emp_name;

            //Reports To Name
            $sql_emprt_name = "select emp_name from emp_rep_to_mst where emp_id = '".$mp_hod_id."'";
            $qry_emprt_name = $ci->db->query($sql_emprt_name)->row();
            $emp_rt_name = $qry_emprt_name->emp_name;
            
            

			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/hrmsc/'.$url.$miss_pun_id.'">'.$miss_pun_id.'</td>
				<td>'.$mp_emp_id.'</td>
				<td>'.$emp_name.'</td>
				<td>'.$mp_hod_id.'</td>
				<td>'.$emp_rt_name.'</td>
				<td>'.$miss_pun_type.'</td>
				<td>'.$miss_pun_date.'</td>
				<td>'.$miss_pun_time.'</td>
				<td>'.$mp_status.'</td>
				<td>'.$created_by.'</td>				
				<td>'.$age->format("%R%a").'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    function case_count_sa($status){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."' OR emp_id = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
			
        $sql_cnt = "select count(*) as cnt from salary_adv where status = '".$status."' $where_str";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
        
		return $cnt;
	}
	
	function case_det_sa($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}

       
		$sql_det = "select * from salary_adv where status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
				<td>Salary Advance ID</td>
				<td>Employee ID</td>
				<td>Employee Name</td>
                <td>Reports To</td>
				<td>Advance Amount</td>
				<td>Status</td>
				<td>Created By</td>				
				<td>Age(Days)</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $sal_adv_id = $row->sal_adv_id;
            $sal_emp_id = $row->emp_id;
            $reports_to = $row->reports_to;
            $sal_adv_req = $row->sal_adv_req;
            $status = $row->status;
            $created_by = $row->created_by;
            $created_date = $row->created_date;           
            $curr_date = date("Y-m-d h:i:s");
            $date1=date_create($created_date);
            $date2=date_create($curr_date);
            $age = date_diff($date1,$date2);

            $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$sal_emp_id."'";
            $qry_emp_name = $ci->db->query($sql_emp_name)->row();
            $emp_name = $qry_emp_name->emp_name;      

			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/hrmsc/'.$url.$sal_adv_id.'">'.$sal_adv_id.'</td>
				<td>'.$sal_emp_id.'</td>
				<td>'.$emp_name.'</td>
				<td>'.$reports_to.'</td>
				<td>'.$sal_adv_req.'</td>
				<td>'.$status.'</td>
				<td>'.$created_by.'</td>				
				<td>'.$age->format("%R%a").'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    function case_det_sa_all($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}

       
		$sql_det = "select * from salary_adv where status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>Select</td>
				<td>S.No.</td>
				<td>Salary Advance ID</td>
				<td>Employee ID</td>
				<td>Employee Name</td>
                <td>Reports To</td>
				<td>Advance Amount</td>
				<td>Status</td>
				<td>Created By</td>				
				<td>Age(Days)</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $sal_adv_id = $row->sal_adv_id;
            $sal_emp_id = $row->emp_id;
            $reports_to = $row->reports_to;
            $sal_adv_req = $row->sal_adv_req;
            $status = $row->status;
            $created_by = $row->created_by;
            $created_date = $row->created_date;           
            $curr_date = date("Y-m-d h:i:s");
            $date1=date_create($created_date);
            $date2=date_create($curr_date);
            $age = date_diff($date1,$date2);

            $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$sal_emp_id."'";
            $qry_emp_name = $ci->db->query($sql_emp_name)->row();
            $emp_name = $qry_emp_name->emp_name;       

			$data .='
			<tr>
				<td><input type="checkbox" id="Chk_App" name="Chk_App[]" value="'.$sal_adv_id.'"></td>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/hrmsc/'.$url.$sal_adv_id.'">'.$sal_adv_id.'</td>
				<td>'.$sal_emp_id.'</td>
				<td>'.$emp_name.'</td>
				<td>'.$reports_to.'</td>
				<td>'.$sal_adv_req.'</td>
				<td>'.$status.'</td>
				<td>'.$created_by.'</td>				
				<td>'.$age->format("%R%a").'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    function case_count_ot($status){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR ot_reports_to = '".$emp_id."' OR ot_emp_id = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
			
        $sql_cnt = "select count(*) as cnt from over_time where ot_status = '".$status."' $where_str";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
        
		return $cnt;
	}

    function case_det_ot($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR ot_reports_to = '".$emp_id."' OR ot_emp_id = '".$emp_id."') 
            order by over_tim_id desc";
		} else {
			$where_str = " order by over_tim_id desc";
		}
			
        
		$sql_det = "select * from over_time where ot_status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
				<td>Over Time ID</td>
				<td>Employee ID</td>
				<td>Employee NAME</td>
                <td>Reports To</td>                			
                <td>From Date</td>                			
				<td>Status</td>
				<td>Created By</td>				
				<td>Age(Days)</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $over_tim_id = $row->over_tim_id;
            $ot_emp_id = $row->ot_emp_id;
            $ot_reports_to = $row->ot_reports_to;
            $ot_frm_date = $row->ot_frm_date;
            $ot_tot_hrs = $row->ot_tot_hrs;
            $ot_status = $row->ot_status;
            $created_by = $row->created_by;
            $created_date = $row->created_date;           
            $curr_date = date("Y-m-d h:i:s");
            $date1=date_create($created_date);
            $date2=date_create($curr_date);
            $age = date_diff($date1,$date2);

            $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$ot_emp_id."'";
            $qry_emp_name = $ci->db->query($sql_emp_name)->row();
            $emp_name = $qry_emp_name->emp_name;     
          

			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/hrmsc/'.$url.$over_tim_id.'">'.$over_tim_id.'</td>
				<td>'.$ot_emp_id.'</td>
				<td>'.$emp_name.'</td>
				<td>'.$ot_reports_to.'</td>				
				<td>'.$ot_frm_date.'</td>				
				<td>'.$ot_status.'</td>
				<td>'.$created_by.'</td>				
				<td>'.$age->format("%R%a").'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    function case_count_leave($status){
		$ci =& get_instance();
		$ci->load->database();
        $username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."' OR leave_emp_id = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
        $sql_cnt = "select count(*) as cnt from leave_mst where leave_status = '".$status."' $where_str";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
		
		return $cnt;
	}
	
	function case_det_leave($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
		$sql_det = "select * from leave_mst where leave_status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
				<td>Leave ID</td>
				<td>Employee ID</td>
				<td>Employee Name</td>
                <td>HOD ID</td>
				<td>Leave Type</td>
                <td>Leave From Date</td>                
                <td>Leave To Date</td>                
				<td>Status</td>
				<td>Created By</td>				
				<td>Age(Days)</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $leave_id = $row->leave_id;
            $leave_emp_id = $row->leave_emp_id;
            $leave_hod_id = $row->reports_to;
            $leave_type = $row->leave_type;
            $leave_from_date = $row->leave_from_date;
            $leave_to_date = $row->leave_to_date;
            $leave_status = $row->leave_status;
            $created_by = $row->created_by;            
            $curr_date = date("Y-m-d h:i:s");
            $date1=date_create($created_date);
            $date2=date_create($curr_date);
            $age = date_diff($date1,$date2);

            $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$leave_emp_id."'";
            $qry_emp_name = $ci->db->query($sql_emp_name)->row();
            $emp_name = $qry_emp_name->emp_name;                 

			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/hrmsc/'.$url.$leave_id.'">'.$leave_id.'</td>
				<td>'.$leave_emp_id.'</td>
				<td>'.$emp_name.'</td>
				<td>'.$leave_hod_id.'</td>
				<td>'.$leave_type.'</td>
				<td>'.$leave_from_date.'</td>
				<td>'.$leave_to_date.'</td>
				<td>'.$leave_status.'</td>
				<td>'.$created_by.'</td>				
				<td>'.$age->format("%R%a").'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    function case_count_dr($status){
		$ci =& get_instance();
		$ci->load->database();
        $username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."' OR dr_emp_id = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
        $sql_cnt = "select count(*) as cnt from dr_hrms_mst where dr_status = '".$status."' $where_str";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
		
		return $cnt;
	}

    function case_det_dr($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."' OR dr_emp_id = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
		$sql_det = "select * from dr_hrms_mst where dr_status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
				<td>DR ID</td>
				<td>Employee ID</td>
				<td>Employee Name</td>
                <td>HOD ID</td>                
                <td>DR Date</td>                
				<td>Status</td>
				<td>Created By</td>				
				<td>Age(Days)</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $dr_id = $row->dr_id;
            $dr_emp_id = $row->dr_emp_id;
            $dr_date = $row->dr_date;
            $reports_to = $row->reports_to;
            $dr_status = $row->dr_status;
            $created_by = $row->created_by;            
            $created_date = $row->created_date;            
            $curr_date = date("Y-m-d h:i:s");
            $date1=date_create($created_date);
            $date2=date_create($curr_date);
            $age = date_diff($date1,$date2);

            $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$dr_emp_id."'";
            $qry_emp_name = $ci->db->query($sql_emp_name)->row();
            $emp_name = $qry_emp_name->emp_name;                 

			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/hrmsc/'.$url.$dr_id.'">'.$dr_id.'</td>
				<td>'.$dr_emp_id.'</td>
				<td>'.$emp_name.'</td>
				<td>'.$reports_to.'</td>
                <td>'.$dr_date.'</td>
				<td>'.$dr_status.'</td>
				<td>'.$created_by.'</td>				
				<td>'.$age->format("%R%a").'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    //Housekeeping and Construction DR
    function case_count_hkcldr($status){
		$ci =& get_instance();
		$ci->load->database();
        $username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
        $sql_cnt = "select count(*) as cnt from hkcl_dr_mst where dr_status = '".$status."' $where_str";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
		
		return $cnt;
	}

    function case_det_hkcldr($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
		$sql_det = "select * from hkcl_dr_mst where dr_status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
				<td>DR ID</td>
				<td>Employee Name</td>                
                <td>DR Date</td>                
				<td>Status</td>
				<td>Created By</td>				
				<td>Age(Days)</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $hkcl_dr_id = $row->hkcl_dr_id;
            $dr_name = $row->dr_name;
            $dr_date = $row->dr_date;
            $dr_type = $row->dr_type;
            $dr_comp = $row->dr_comp;
            $dr_status = $row->dr_status;
            $created_by = $row->created_by;            
            $created_date = $row->created_date;            
            $curr_date = date("Y-m-d h:i:s");
            $date1=date_create($created_date);
            $date2=date_create($curr_date);
            $age = date_diff($date1,$date2);                

			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/hrmsc/'.$url.$hkcl_dr_id.'">'.$hkcl_dr_id.'</td>
				<td>'.$dr_name.'</td>
                <td>'.$dr_date.'</td>
				<td>'.$dr_status.'</td>
				<td>'.$created_by.'</td>				
				<td>'.$age->format("%R%a").'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    //Special Salary Advance
    function case_count_spcl_sa($status){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."' OR emp_id = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
			
        $sql_cnt = "select count(*) as cnt from spcl_salary_adv where status = '".$status."' $where_str";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
        
		return $cnt;
	}
	
    //Special Salary Advance
	function case_det_spcl_sa($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}

       
		$sql_det = "select * from spcl_salary_adv where status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
				<td>Salary Advance ID</td>
				<td>Employee ID</td>
				<td>Employee Name</td>
                <td>Reports To</td>
				<td>Advance Amount</td>
				<td>Status</td>
				<td>Created By</td>				
				<td>Age(Days)</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $sal_adv_id = $row->sal_adv_id;
            $sal_emp_id = $row->emp_id;
            $reports_to = $row->reports_to;
            $sal_adv_req = $row->sal_adv_req;
            $status = $row->status;
            $created_by = $row->created_by;
            $created_date = $row->created_date;           
            $curr_date = date("Y-m-d h:i:s");
            $date1=date_create($created_date);
            $date2=date_create($curr_date);
            $age = date_diff($date1,$date2);

            $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$sal_emp_id."'";
            $qry_emp_name = $ci->db->query($sql_emp_name)->row();
            $emp_name = $qry_emp_name->emp_name;      

			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/hrmsc/'.$url.$sal_adv_id.'">'.$sal_adv_id.'</td>
				<td>'.$sal_emp_id.'</td>
				<td>'.$emp_name.'</td>
				<td>'.$reports_to.'</td>
				<td>'.$sal_adv_req.'</td>
				<td>'.$status.'</td>
				<td>'.$created_by.'</td>				
				<td>'.$age->format("%R%a").'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    //Payment Request / Return Count
    function case_count_pr($status){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id, dept from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;
        $dept = $qry_user_role->dept;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."') order by created_date";
        } else {
			$where_str = " order by created_date desc";
		}
			
        $sql_cnt = "select count(*) as cnt from pr_mst where status = '".$status."' $where_str";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
        
		return $cnt;
	}
	
    //Payment Request / Return Detail
	function case_det_pr($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id, dept from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;
        $dept = $qry_user_role->dept;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}

       
		$sql_det = "select * from pr_mst where status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
				<td>PR ID</td>
				<td>Employee ID</td>
				<td>Employee Name</td>
                <td>Reports To</td>
				<td>PR Amount</td>
				<td>Status</td>
				<td>Created By</td>				
				<td>Age(Days)</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $pr_id = $row->pr_id;
            $emp_id = $row->emp_id;
            $reports_to = $row->reports_to;
            $pr_amt = $row->pr_amt;
            $status = $row->status;
            $created_by = $row->created_by;
            $created_date = $row->created_date;           
            $curr_date = date("Y-m-d h:i:s");
            $date1=date_create($created_date);
            $date2=date_create($curr_date);
            $age = date_diff($date1,$date2);

            $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$emp_id."'";
            $qry_emp_name = $ci->db->query($sql_emp_name)->row();
            $emp_name = $qry_emp_name->emp_name;      

			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/hrmsc/'.$url.$pr_id.'">'.$pr_id.'</td>
				<td>'.$emp_id.'</td>
				<td>'.$emp_name.'</td>
				<td>'.$reports_to.'</td>
				<td>'.$pr_amt.'</td>
				<td>'.$status.'</td>
				<td>'.$created_by.'</td>				
				<td>'.$age->format("%R%a").'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    function get_prefer_mail($leave_emp_id,$reports_to){
        $ci =& get_instance();
        $ci->load->database(); 
        $db2 = $ci->load->database('db2',TRUE);           


        $sql_reports_to = "select prefered_email, reports_to from `tabEmployee` where name = '".$leave_emp_id."'";
        $qry_reports_to = $db2->query($sql_reports_to)->row();
        $reports_to = $qry_reports_to->reports_to;
        $leave_pref_mail = $qry_reports_to->prefered_email;	
        return $leave_pref_mail;	
    }

    //Penalties Attendence Card
    function Penalty($CardNo,$CalDate){
        $ci =& get_instance();
        $ci->load->database(); 

        $sql_penalty = "SELECT sum(Penalty) as Penalty FROM `tran_penalties` 
        where CardNo = '".$CardNo."' and CalDate = '".$CalDate."'";

        $qry_penalty = $ci->db->query($sql_penalty)->row();

        $Penalty = $qry_penalty->Penalty;

        return $Penalty;
    }


    //Penalty 
    function case_count_penalty($status){
		$ci =& get_instance();
		$ci->load->database();
        $username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."' OR leave_emp_id = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
        $sql_cnt = "select count(*) as cnt from penalty where penalty_status = '".$status."' $where_str";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
		
		return $cnt;
	}
	
	function case_det_penalty($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
		$sql_det = "select * from penalty where penalty_status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
				<td>Penalty ID</td>
				<td>Employee ID</td>
				<td>Employee Name</td>
				<td>Penalty Hours</td>
                <td>Penalty Date</td>                
                <td>Penalty Status</td> 
				<td>Created By</td>				
				<td>Created Date</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $penalty_id = $row->penalty_id;
            $penalty_emp_id = $row->penalty_emp_id;
            $penalty_hours = $row->penalty_hours;
            $penalty_date = $row->penalty_date;
            $penalty_status = $row->penalty_status;
            $created_by = $row->created_by;
            $created_date = $row->created_date;

            $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$penalty_emp_id."'";
            $qry_emp_name = $ci->db->query($sql_emp_name)->row();
            $emp_name = $qry_emp_name->emp_name;                 

			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/hrmsc/'.$url.$penalty_id.'">'.$penalty_id.'</td>
				<td>'.$penalty_emp_id.'</td>
				<td>'.$emp_name.'</td>
				<td>'.$penalty_hours.'</td>
				<td>'.$penalty_date.'</td>
				<td>'.$penalty_status.'</td>
				<td>'.$created_by.'</td>
				<td>'.$created_date.'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    //Penalty 
    function case_count_adjustments($status){
		$ci =& get_instance();
		$ci->load->database();
        $username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."' OR leave_emp_id = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
        $sql_cnt = "select count(*) as cnt from adjustments where adjustments_status = '".$status."' $where_str";
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
		
		return $cnt;
	}
	
	function case_det_adjustments($status, $url){
		$ci =& get_instance();
		$ci->load->database();

		$username = $_SESSION['username'];

		$sql_user_role = "select role, emp_id from login where username = '".$username."'";
		$qry_user_role = $ci->db->query($sql_user_role)->row();
		$role = $qry_user_role->role;
        $emp_id = $qry_user_role->emp_id;

		if($role != 'Admin'){
			$where_str = " and (created_by ='".$username."' OR reports_to = '".$emp_id."') order by created_date";
		} else {
			$where_str = " order by created_date desc";
		}
		
			
		$sql_det = "select * from adjustments where adjustments_status = '".$status."' $where_str";
		$qry_det = $ci->db->query($sql_det);
		
		$data = '
		<table class="table table-bordered">
			<tr style="background-color:#ddd; font-weight:bold">
				<td>S.No.</td>
				<td>Penalty ID</td>
				<td>Employee ID</td>
				<td>Employee Name</td>
				<td>Penalty Hours</td>
                <td>Penalty Date</td>                
                <td>Penalty Status</td> 
				<td>Created By</td>				
				<td>Created Date</td>
			</tr>
		';
		$sno = 0;
		foreach($qry_det->result() as $row){
            $sno++;
            $adjustments_id = $row->adjustments_id;
            $adjustments_emp_id = $row->adjustments_emp_id;
            $adjustments_hours = $row->adjustments_hours;
            $adjustments_date = $row->adjustments_date;
            $adjustments_status = $row->adjustments_status;
            $created_by = $row->created_by;
            $created_date = $row->created_date;

            $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$adjustments_emp_id."'";
            $qry_emp_name = $ci->db->query($sql_emp_name)->row();
            $emp_name = $qry_emp_name->emp_name;                 

			$data .='
			<tr>
				<td>'.$sno.'</td>
				<td><a href="'.base_url().'index.php/hrmsc/'.$url.$adjustments_id.'">'.$adjustments_id.'</td>
				<td>'.$adjustments_emp_id.'</td>
				<td>'.$emp_name.'</td>
				<td>'.$adjustments_hours.'</td>
				<td>'.$adjustments_date.'</td>
				<td>'.$adjustments_status.'</td>
				<td>'.$created_by.'</td>
				<td>'.$created_date.'</td>
			</tr>
			';
		}

		$data .='</table>';
		
		return $data;
    }

    //Present Employees
    function present_emp($date, $shift_arr){
        $ci =& get_instance();
		$ci->load->database();

        $str = '';
        foreach($shift_arr as $var){

            if($str == ''){
                $str = "'".$var."'";
            }else{
                $str = $str.","."'".$var."'";
            }
        }

        $shifts = $str;

        //where str
        if($shifts == ''){
            $where_str .= "";
        } else {	
            $where_str .= "and ShiftOnAttDate in(".$shifts.")";	
        }

        $sql = "select count(*) as cnt from tran_attendence 
        where CalDate = '".$date."' 
        and Tot_Hrs > 0 $where_str";

        $qry = $ci->db->query($sql)->row();
        
        $cnt = $qry->cnt;

        return $cnt;
    }


    function emp_type(){
        $ci =& get_instance();
		$ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);
			
        $sql="select distinct custom_employee_type from `tabEmployee` where custom_employee_type is not NULL and custom_employee_type != ''";
		
        $query = $db2->query($sql);
        
        $data = '<option value="ALL" selected>ALL</option>';
        
		foreach ($query->result() as $row) {
            $employee_type = $row->custom_employee_type;
          
            $data .= '<option value="'.$employee_type.'">'.$employee_type.'</option>';

		}
		
		return $data;
    }

    function sal_type(){
        $ci =& get_instance();
		$ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);
			
        $sql="select distinct salary_mode from `tabEmployee` where salary_mode is NOT NULL and salary_mode != ''";
		
        $query = $db2->query($sql);
        
        $data = '<option value="ALL" selected>ALL</option>';
        
		foreach ($query->result() as $row) {
            $salary_mode = $row->salary_mode;
          
            $data .= '<option value="'.$salary_mode.'">'.$salary_mode.'</option>';

		}
		
		return $data;
    }

    //Counter Sheet PNI
    function cs_pni($col_name, $tbl_name, $start_dt, $end_dt, $employee_type, $is_labour, $comp_type, $pay_status, $cond){
        $ci =& get_instance();
		$ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);

        $where_str = "";
        if($employee_type == ""){
            $where_str .= " ";
        } else {
            $where_str .= " and employee_type='".$employee_type."'";
        }

        if($is_labour == ""){
            $where_str .= " ";
        } else {
            $where_str .= " and is_labour='".$is_labour."'";
        }
        
        if($comp_type == 'MDPL'){
            $where_str .= "and EmpId like '%EMP-MDPL%'";
        } else if($comp_type == 'MPP'){
            $where_str .= "and EmpId like '%EMP-MPP%'";
        } else {
            $where_str .= "and EmpId not like '%EMP-MDPL%'";
            $where_str .= "and EmpId not like '%EMP-MPP%'";
        }

        if($pay_status == "All"){
            $where_str .= " ";
        } else {
            $where_str .= " and status = '".$pay_status."'";
        }

        if($cond == ""){
            $where_str .= " ";
        } else {
            $where_str .= " and ".$cond;
        }
			
        $sql="select sum($col_name) as tot_amt 
        from $tbl_name 
        where date(month_start_date) = '".$start_dt."' 
        and date(month_end_date) = '".$end_dt."'
        $where_str";
		
        $query = $ci->db->query($sql)->row();

        $tot_amt = number_format($query->tot_amt,2,".","");

        $det_url = "<a href='".base_url()."index.php/hrmsc/counter_sheet_det?col_name=".$col_name."&tbl_name=".$tbl_name."&start_dt=".$start_dt."&end_dt=".$end_dt."&employee_type=".$employee_type."&is_labour=".$is_labour."&comp_type=".$comp_type."&pay_status=".$pay_status."&cond=".$cond."' target='_blank'>".$tot_amt."</a>";

        return $det_url;
    }

    //Counter Sheet Total
    function cs_tot($col_name, $start_dt, $end_dt, $pay_status, $cond){
        $ci =& get_instance();
		$ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);

        if($col_name == "NetSalary"){
            $col_name1 = "EmpTotSal";
        } else {
            $col_name1 = $col_name;
        }

        $where_str = "";
        if($pay_status == "All"){
            $where_str .= " ";
        } else {
            $where_str .= " and status = '".$pay_status."'";
        }

        if($cond == ""){
            $where_str .= " ";
        } else {
            $where_str .= " and ".$cond;
        }
			
        $sql="
        select sum($col_name) as tot_amt 
        from payroll_mst_type1 
        where date(month_start_date) = '".$start_dt."' 
        and date(month_end_date) = '".$end_dt."'
        $where_str
        UNION
        select sum($col_name1) as tot_amt 
        from payroll_mst_type2 
        where date(month_start_date) = '".$start_dt."' 
        and date(month_end_date) = '".$end_dt."'
        $where_str
        UNION
        select sum($col_name) as tot_amt 
        from payroll_mst_pc 
        where date(month_start_date) = '".$start_dt."' 
        and date(month_end_date) = '".$end_dt."'
        $where_str
        UNION
        select sum($col_name) as tot_amt 
        from payroll_mst_pb 
        where date(month_start_date) = '".$start_dt."' 
        and date(month_end_date) = '".$end_dt."'
        $where_str
        UNION
        select sum($col_name) as tot_amt 
        from payroll_mst_mpppro 
        where date(month_start_date) = '".$start_dt."' 
        and date(month_end_date) = '".$end_dt."'
        $where_str";
		
        $query = $ci->db->query($sql);

        $grand_tot = 0;
        foreach($query->result() as $row){
            $tot_amt = $row->tot_amt;

            $grand_tot = $grand_tot+$tot_amt;
        }

        $grand_tot = number_format($grand_tot,2,".","");

        return $grand_tot;
    }

    //Counter Sheet Total
    function cs_tot_pni($col_name, $start_dt, $end_dt, $employee_type, $comp_type, $pay_status, $cond){
        $ci =& get_instance();
		$ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);

        if($col_name == "NetSalary"){
            $col_name1 = "EmpTotSal";
        } else {
            $col_name1 = $col_name;
        }

        $where_str = "";
        if($employee_type == ""){
            $where_str .= " ";
        } else {
            $where_str .= " and employee_type='".$employee_type."'";
        }

        if($comp_type == 'MDPL'){
            $where_str .= "and EmpId like '%EMP-MDPL%'";
        } else {
            $where_str .= "and EmpId not like '%EMP-MDPL%'";
        }

        if($pay_status == "All"){
            $where_str .= " ";
        } else {
            $where_str .= " and status = '".$pay_status."'";
        }

        if($cond == ""){
            $where_str .= " ";
        } else {
            $where_str .= " and ".$cond;
        }
			
        $sql="
        select sum($col_name) as tot_amt 
        from payroll_mst_type1 
        where month_start_date = '".$start_dt."' 
        and month_end_date = '".$end_dt."'
        $where_str
        UNION
        select sum($col_name1) as tot_amt 
        from payroll_mst_type2 
        where month_start_date = '".$start_dt."' 
        and month_end_date = '".$end_dt."'
        $where_str
        UNION
        select sum($col_name) as tot_amt 
        from payroll_mst_pc 
        where month_start_date = '".$start_dt."' 
        and month_end_date = '".$end_dt."'
        $where_str";
		
        $query = $ci->db->query($sql);

        $grand_tot = 0;
        foreach($query->result() as $row){
            $tot_amt = $row->tot_amt;

            $grand_tot = $grand_tot+$tot_amt;
        }

        $grand_tot = number_format($grand_tot,2,".","");

        return $grand_tot;
    }

    //Housekeeping & Construction Labour DR Report Count
    function hkcl_dr_cnt($date, $dr_type){
        $ci =& get_instance();
		$ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);

        if($dr_type == 'Housekeeping'){
            $where_str = "and dr_type = '".$dr_type."'";
        } else {
            $where_str = "and dr_type = '".$dr_type."'";
        }

        $sql = "select count(*) as cnt from hkcl_dr_mst 
        where dr_date='".$date."' 
        and dr_status = 'Approved' 
        $where_str";
        
        $qry = $ci->db->query($sql)->row();

        return $cnt = $qry->cnt;
    }


    //Total Payment Employee
    function TotPayment($emp_id, $col_name, $pay_status){
        $ci =& get_instance();
		$ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);

        
        if($col_name == "NetSalary"){
            $col_name1 = "EmpTotSal";
        } else {
            $col_name1 = $col_name;
        }

        $where_str = "";
        if($pay_status == "All"){
            $where_str .= " ";
        } else {
            $where_str .= " and status = '".$pay_status."'";
        }
			
        $sql="
        select sum($col_name) as tot_amt 
        from payroll_mst_type1 
        where EmpId = '".$emp_id."'
        $where_str
        UNION
        select sum($col_name1) as tot_amt 
        from payroll_mst_type2 
        where EmpId = '".$emp_id."'
        $where_str
        UNION
        select sum($col_name) as tot_amt 
        from payroll_mst_pc 
        where EmpId = '".$emp_id."'
        $where_str
        UNION
        select sum($col_name) as tot_amt 
        from payroll_mst_pb 
        where EmpId = '".$emp_id."'
        $where_str";
		
        $query = $ci->db->query($sql);

        $grand_tot = 0;
        foreach($query->result() as $row){
            $tot_amt = $row->tot_amt;

            $grand_tot = $grand_tot+$tot_amt;
        }

        $grand_tot = number_format($grand_tot,2,".","");

        return $grand_tot;
    }


    //Leave Allocated Employee
    function lv_allocated($employee, $leave_type, $from_date, $to_date){
        $ci =& get_instance();
		$ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);
			
        $sql="
        select sum(new_leaves_allocated) as total_leaves_allocated 
        from `tabLeave Allocation` where employee = '".$employee."'
        and leave_type = '".$leave_type."'
        and from_date between '".$from_date."' and '".$to_date."'
        and to_date between '".$from_date."' and '".$to_date."'
        and docstatus = 1";
		
        $query = $db2->query($sql)->row();

        $total_leaves_allocated = $query->total_leaves_allocated;

        if($total_leaves_allocated == 0){
            $total_leaves_allocated = 0;
        }

        return $total_leaves_allocated;
    }

    //Leave Availed Employee
    function lv_availed($employee, $leave_type, $from_date, $to_date){
        $ci =& get_instance();
		$ci->load->database();
        $db2 = $ci->load->database('db2', TRUE);
			
        $sql="
        select sum(leave_days) as total_leaves_availed 
        from leave_mst where leave_emp_id = '".$employee."'
        and leave_type = '".$leave_type."'
        and leave_from_date between '".$from_date."' and '".$to_date."'
        and leave_to_date between '".$from_date."' and '".$to_date."'
        and leave_status = 'Approved'";
		
        $query = $ci->db->query($sql)->row();

        $total_leaves_availed = $query->total_leaves_availed;

        if($total_leaves_availed == 0){
            $total_leaves_availed = 0;
        }

        return $total_leaves_availed;
    }

    

}