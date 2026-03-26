<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<?php

	$from_dt = $_REQUEST['from_dt']; 
	$to_dt = $_REQUEST['to_dt'];
	$dept = $_REQUEST['dept'];
	$hod = $_REQUEST['hod'];
    $att_type = $_REQUEST['att_type'];
	
	
	$dept =json_decode($dept, TRUE);
	$hod =json_decode($hod, TRUE);
	$att_type =json_decode($att_type, TRUE);
	
	//Dept Type
	if( $dept[0] == 'All' ){
		$dept1 = "All";
	}else{
		 
		$str = '';
		foreach($dept as $var){
			if($str == ''){
				$str = "'".$var."'";
			}else{
				$str = $str.","."'".$var."'";
			}
		}
		
		$dept1 = $str;
	}
	
	//HOD
	if( $hod[0] == 'All' ){
		$hod1 = "All";
	}else{
		 
		$str = '';
		foreach($hod as $var){
		
			if($str == ''){
				$str = "'".$var."'";
			}else{
				$str = $str.","."'".$var."'";
			}
		}
		
		$hod1 = $str;
    }
    
	//Attendence Type
	if( $att_type[0] == 'All' ){
		$att_type1 = "All";
	}else{
		 
		$str = '';
		foreach($att_type as $var){
		
			if($str == ''){
				$str = "'".$var."'";
			}else{
				$str = $str.","."'".$var."'";
			}
		}
		
		$att_type1 = $str;
    }
    
    //Department
	if($dept1 == ''){
		$where_str .= "";
	} else if($dept1 == 'All'){	
		$where_str .= "";	
	} else {	
		$where_str .= " and department in(".$dept1.")";	
	}
	
	//HOD
	if($hod1 == ''){
		$where_str .= "";
	} else if($hod1 == 'All'){	
		$where_str .= "";	
	} else {	
		$where_str .= " and reports_to in(".$hod1.")";	
	}
	
	//Attendence Type
	if($att_type1 == ''){
		$where_str .= "";
	} else if($att_type1 == 'All'){	
		$where_str .= "";	
	} else {	
		$where_str .= " and att_type in(".$att_type1.")";	
	}

?>

<table class="table table-bordered" id="example1" style="margin-top:60px">
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Card No</th>
            <th>Employee</th>
            <th>Employee Name</th>
            <th>Department</th>
            <th>HOD</th>
            <th>Pay Days</th>
            <th>Late Coming</th>
            <th>Early Exit</th>
            <th>Overtime</th>
            <?php
            $dates = getDatesFromRange($from_dt, $to_dt);

            foreach ($dates as $key => $value) {
                $AttDate = $value;
                echo "<th>".$AttDate."</th>";      
            }
            ?>           
        </tr>
    </thead>
    <tbody>
    <?php
        $sql_att = "SELECT distinct CardNo, EmpId, EmpName, department, reports_to FROM `tran_attendence` 
        where CalDate between '".$from_dt."' and '".$to_dt."' $where_str";

        $qry_att = $this->db->query($sql_att);
        
        $sno = 0;
        foreach($qry_att->result() as $row){
            $sno++;
            $CardNo = $row->CardNo;
            $EmpId = $row->EmpId;
            $EmpName = $row->EmpName;
            $department = $row->department;
            $reports_to = $row->reports_to;

            //HOD Name
            $sql_empnm = "select employee_name from `tabEmployee` where name='".$reports_to."'";
            $qry_empnm = $db2->query($sql_empnm)->row();
            $reports_to_name = $qry_empnm->employee_name;
    ?>
        <tr>
            <td><?=$sno;?></td>
            <td><?=$CardNo;?></td>
            <td><?=$EmpId;?></td>
            <td><?=$EmpName;?></td>
            <td><?=$department;?></td>
            <td><?=$reports_to_name;?></td>
            <td><?=tot_paid_days($from_dt, $to_dt, $CardNo);?></td>
            <td><?=tot_late_coming($from_dt, $to_dt, $CardNo);?></td>
            <td><?=tot_early_exit($from_dt, $to_dt, $CardNo);?></td>
            <td><?=tot_overtime($from_dt, $to_dt, $CardNo);?></td>
            <?=tot_hrs_cal($from_dt, $to_dt, $CardNo); ?> 
        
    <?php 
        } 
    ?>
    </tbody>
</table>