<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('sales')){	
	function case_count_sales($status){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql_cnt = "select count(*) as cnt from ticket_reg_mst where ticket_status = '".$status."'";
        //echo $sql_cnt; die;
        $qry_cnt = $ci->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;
		
		return $cnt;
	}

	function prod_name(){
		$ci = & get_instance();
		$db2 = $ci->load->database('db2',TRUE);
		//$response = array();
		$sql = "select item_name from `tabSales Invoice Item`" ;
		$query = $db2->query($sql);
		foreach($query->result() as $row){
			$data .= '<option value="'.$row->item_name.'">'.$row->item_name.'</option>';
		}
	
		return $data;
	  }

	function sales_order(){
		$ci = & get_instance();
		$db2 = $ci->load->database('db2',TRUE);
		//$response = array();
		$sql = "select distinct sales_person_name from `tabSales Order`" ;
		$query = $db2->query($sql);
		foreach($query->result() as $row){
		$data .= '<option value="'.$row->sales_person_name.'">'.$row->sales_person_name.'</option>';
		}

		return $data;
	}


		function prod_cat(){
			$ci = & get_instance();
			$db2 = $ci->load->database('db2',TRUE);
			//$data="";
			$sql = "select distinct item_group from `tabSales Order Item`";
			$query = $db2->query($sql);

			foreach($query->result() as $row){
			$data .= '<option value="'.$row->item_group.'">'.$row->item_group.'</option>';
			}

			return $data;
			} 


	function case_det_sales($status, $url){
		$ci =& get_instance();
		$ci->load->database();
			
		$sql_det = "select * from ticket_reg_mst where ticket_status = '".$status."' order by created_date desc";
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

	function get_pending_payment(){
		$ci =& get_instance();
		//$ci->load->database();
		$db2 = $ci->load->database('db2',TRUE);

		$sql_cust = "select distinct `tabCustomer`.name, `tabCustomer`.customer_name from `tabCustomer` 
		inner join `tabSales Invoice` on `tabSales Invoice`.customer_name = `tabCustomer`.customer_name
		where `tabCustomer`.name in (select distinct (customer) from `tabSales Order`)";
			$qry_cust  = $db2->query($sql_cust);                 
						
		$data = '
		<table class="table table-bordered">
		<th>SNO</th>
		<th>Customer Code</th>
		<th>Customer Name</th>		
		<th>Pending Amount </th>';						

		$sno = 0;		
		$total_pend_amt = 0;

		foreach($qry_cust->result() as $row){
		$sno++;
		//$inv_no = $row->name;
		$customer_tot_rec_amt=0;
		$pending_amt = 0;
		$customer_code = $row->name;
		$cust_name = $row->customer_name;
		$customer_name = str_replace("'","",$cust_name);
		
		$sql_so = "select customer_name ,sum(grand_total) as inv_tot_amt from `tabSales Invoice`					
		where customer_name = '".$customer_name."'";
		$qry_so  = $db2->query($sql_so)->row();
		$inv_tot_amt = $qry_so->inv_tot_amt;
		$so_id = $qry_so->name;
		
		$sql_inv = "select name from `tabSales Invoice`				
		where customer_name = '".$customer_name."'";
		$qry_inv=$db2->query($sql_inv);

		foreach ($qry_inv->result() as $row) {
		$inv_no = $qry_inv->name;
		$inv_date = $qry_inv->creation;
		$due_date = $qry_inv->due_date;
		$inv_grand_total = $inv_grand_total + $inv_total;
		

		$sql_inv = "select sum(allocated_amount) as inv_rec_total 
		from `tabPayment Entry Reference`
		where reference_name='".$inv_no."' ";
		$qry_inv  = $db2->query($sql_inv)->row();
		$inv_rec_total = $qry_inv->inv_rec_total;
		$customer_tot_rec_amt = $customer_tot_rec_amt+$inv_rec_total;
		//$inv_rec_grand_total = $inv_rec_grand_total + $inv_rec_total;
		}
		$pending_amt = $inv_tot_amt - $customer_tot_rec_amt;	
		
			if($pending_amt > 0){
			$data.='
			<tr>
			<td>'.$sno.'</td>
			<td><a href ='.base_url().'index.php/salesc/inv_amount?cust_id='.$customer_code.'&cust_name='.$customer_name.'">'.$customer_code.'</a></td>
			<td>'.$customer_name.'</td>			
			<td>'.number_format($pending_amt,2,".","").'</td>
			</tr>';
			} 
			$total_pend_amt = $total_pend_amt + $pending_amt;
		}	
						
			$data.=
			'<tr style="backgroundcolor:blue">  
			<td></td>
			<td></td>                                                 
			<td>TOTAL</td>
			<td><b>'.number_format($total_pend_amt,2,".","").'</b></td>
			</tr>';

			return $data;
	}

	function pending_payment(){
		$ci =& get_instance();
		//$ci->load->database();
		$db2 = $ci->load->database('db2',TRUE);

		$sql_cust = "select distinct `tabCustomer`.name, `tabCustomer`.customer_name, sum(`tabSales Invoice`.grand_total) as inv_tot_amt from `tabCustomer` 
		inner join `tabSales Invoice` on `tabSales Invoice`.customer_name = `tabCustomer`.customer_name
		where `tabCustomer`.name in (select distinct (customer) from `tabSales Order`)
		and 'tabSales Invoice`.customer_name = 'tabCustomer`.name ";
		$qry_cust  = $db2->query($sql_cust);                 
		
		$sno = 0;		
		$total_pend_amt = 0;

		foreach($qry_cust->result() as $row){
		$sno++;
		//$inv_no = $row->name;
		$customer_tot_rec_amt=0;
		$pending_amt = 0;
		$customer_code = $row->name;
		$cust_name = $row->customer_name;
		$customer_name = str_replace("'","",$cust_name);
		$inv_tot_amt = $row->inv_tot_amt;
		$so_id = $row->name;		
		
		
		$sql_inv = "select name from `tabSales Invoice`				
		where customer_name = '".$customer_name."'";
		$qry_inv=$db2->query($sql_inv);

		foreach ($qry_inv->result() as $row) {
		$inv_no = $qry_inv->name;
		$inv_date = $qry_inv->creation;
		$due_date = $qry_inv->due_date;
		$inv_grand_total = $inv_grand_total + $inv_total;
		

		$sql_inv = "select sum(allocated_amount) as inv_rec_total 
		from `tabPayment Entry Reference`
		where reference_name='".$inv_no."' ";
		$qry_inv  = $db2->query($sql_inv)->row();
		$inv_rec_total = $qry_inv->inv_rec_total;
		$customer_tot_rec_amt = $customer_tot_rec_amt+$inv_rec_total;
		//$inv_rec_grand_total = $inv_rec_grand_total + $inv_rec_total;
		}
		$pending_amt = $inv_tot_amt - $customer_tot_rec_amt;
		
			if($pending_amt > 0){
				$total_pend_amt = $total_pend_amt + $pending_amt;	
			} 
			
		}	
						
			echo $total_pend_amt;
	}
	function get_overdue_till_today(){

				$ci =& get_instance();
				//$ci->load->database();
				$db2 = $ci->load->database('db2',TRUE);
				$date = date('Y-m-d');     
				$sno=0;
				$inv_grand_total =0;
				$total_overdue_amt=0;
				
				$sql_cust = "select distinct `tabCustomer`.name, `tabCustomer`.customer_name from `tabCustomer` 
				inner join `tabSales Invoice` on `tabSales Invoice`.customer_name = `tabCustomer`.customer_name
				where `tabCustomer`.name in (select distinct (customer) from `tabSales Order`)
				and `tabSales Invoice`.due_date < '".$date."' 
				and `tabSales Invoice`.due_date != '' 
				and `tabSales Invoice`.due_date is not NULL";
	
				$qry_cust  = $db2->query($sql_cust);
				foreach($qry_cust->result() as $row){
					$sno++;
					$customer_tot_rec_amt = 0;
					$overdue_amt = 0;
	
					$customer_code = $row->name;
					$customer_name= $row->customer_name;
					$customer_name = str_replace("'","",$customer_name);
					
					$sql_inv_tot = "select sum(grand_total) as inv_tot_amt from `tabSales Invoice`
					where due_date < '".$date."'
					and due_date != ''
					and due_date is not NULL
					and customer_name = '".$customer_name."'";
					$qry_inv_tot = $db2->query($sql_inv_tot)->row();
	
					//Total Invoice Amount Customer Wise
					$inv_tot_amt = $qry_inv_tot->inv_tot_amt;
	
					$sql_inv = "select name from `tabSales Invoice`
					where due_date < '".$date."'
					and due_date != ''
					and due_date is not NULL 
					and customer_name = '".$customer_name."'";
					
					$qry_inv  = $db2->query($sql_inv);
	
					foreach($qry_inv->result() as $row){
						$inv_no = $row->name;
	
						$sql_inv_rec = "select sum(allocated_amount) as inv_rec_total 
						from `tabPayment Entry Reference`
						where reference_name='".$inv_no."' 
						and due_date <= '".$date."'
						and due_date != ''
						and due_date is not NULL";

					$qry_inv_rec  = $db2->query($sql_inv_rec)->row();

					$inv_rec_total = $qry_inv_rec->inv_rec_total;

					//Received Amount Total Customer Invoice Wise
					$customer_tot_rec_amt = $customer_tot_rec_amt+$inv_rec_total;
					} 

					$overdue_amt = $inv_tot_amt-$customer_tot_rec_amt;
					if($overdue_amt > 0) {
					$tot_overdue_amt = $tot_overdue_amt + $overdue_amt;				
					}
					
				} 	
				echo $tot_overdue_amt;		  
		}	 
		// Overdue Payment
		function get_overdue_payment(){
			$ci =& get_instance();
			//$ci->load->database();
			$db2 = $ci->load->database('db2',TRUE);
            $date = date('Y-m-d');     
            $sno=0;
            $inv_grand_total =0;
			$total_overdue_amt=0;
			$data ='
			<table class="table table-bordered" id="example1" style="margin-top:60px">
				<thead>
					<th>SNO</th>
					<th>Customer Code</th>
					<th>Customer Name</th>
					<th>Overdue Amount </th>
				</thead>    
            	<tbody>';           
       
			$sql_cust = "select distinct `tabCustomer`.name, `tabCustomer`.customer_name from `tabCustomer` 
			inner join `tabSales Invoice` on `tabSales Invoice`.customer_name = `tabCustomer`.customer_name
			where `tabCustomer`.name in (select distinct (customer) from `tabSales Order`)
			and `tabSales Invoice`.due_date < '".$date."' 
			and `tabSales Invoice`.due_date != '' 
			and `tabSales Invoice`.due_date is not NULL";

            $qry_cust  = $db2->query($sql_cust);
            foreach($qry_cust->result() as $row){
				$sno++;
				$customer_tot_rec_amt = 0;
				$overdue_amt = 0;

                $customer_code = $row->name;
                $customer_name= $row->customer_name;
				$customer_name = str_replace("'","",$customer_name);
				
				$sql_inv_tot = "select sum(grand_total) as inv_tot_amt from `tabSales Invoice`
				where due_date < '".$date."'
				and due_date != ''
				and due_date is not NULL
				and customer_name = '".$customer_name."'";
				$qry_inv_tot = $db2->query($sql_inv_tot)->row();

				//Total Invoice Amount Customer Wise
				$inv_tot_amt = $qry_inv_tot->inv_tot_amt;

				$sql_inv = "select name from `tabSales Invoice`
				where due_date < '".$date."'
				and due_date != ''
				and due_date is not NULL 
				and customer_name = '".$customer_name."'";
				
				$qry_inv  = $db2->query($sql_inv);

				foreach($qry_inv->result() as $row){
					$inv_no = $row->name;

					$sql_inv_rec = "select sum(allocated_amount) as inv_rec_total 
					from `tabPayment Entry Reference`
					where reference_name='".$inv_no."' 
					and due_date <= '".$date."'
					and due_date != ''
					and due_date is not NULL";

					$qry_inv_rec  = $db2->query($sql_inv_rec)->row();

					$inv_rec_total = $qry_inv_rec->inv_rec_total;

					//Received Amount Total Customer Invoice Wise
					$customer_tot_rec_amt = $customer_tot_rec_amt+$inv_rec_total;
				}  
				
				$overdue_amt = $inv_tot_amt-$customer_tot_rec_amt;

				if($overdue_amt > 0){
					$data.=
					'<tr>
						<td>'.$sno.'</td>
						<td>
							<a href ='.base_url().'index.php/salesc/inv_amount?cust_id='.$customer_code.'">'.$customer_code.'</a>
						</td>
						<td>'.$customer_name.'</td>
						<td>'.number_format($overdue_amt,2,".","").'</td>
					</tr>';
				}
				$tot_overdue_amt = $tot_overdue_amt + $overdue_amt;                       
			} 

			$data.='<tr style="background-color:blue">
					<td colspan="3">Total</td>
					<td>'.number_format($tot_overdue_amt,2,".","").'</td>
					<tr>
					</tbody></table>';
			return $data;            
		}	
		//OVERDUE SO WISE 
		function get_overdue_so_wise(){
			$ci =& get_instance();
			//$ci->load->database();
			$db2 = $ci->load->database('db2',TRUE);
            $date = date('Y-m-d');     
            $sno=0;
            $inv_grand_total =0;
			$tot_overdue_amt=0;
			$data ='
			<table class="table table-bordered" id="example1" style="margin-top:60px">
				<thead>
					<th>SNO</th>					
					<th>Sales Person</th>
					<th>Overdue Amount </th>
				</thead>    
            	<tbody>';           
       
			$sql_cust = "select  `tabSales Person`.name,`tabSales Invoice`.customer_name
			 from `tabSales Person` inner join `tabSales Invoice` on `tabSales Invoice`.sales_person_name = `tabSales Person`.name
			where `tabSales Person`.name in (select distinct (sales_person_name) from `tabSales Order`)
			and `tabSales Invoice`.due_date < '".$date."' 
			and `tabSales Invoice`.due_date != ''
			and `tabSales Invoice`.due_date is not NULL";
			//echo $sql_cust;die;
            $qry_cust  = $db2->query($sql_cust);
            foreach($qry_cust->result() as $row){
				$sno++;
				$so_tot_rec_amt = 0;
				//$overdue_amt = 0;
                //$customer_code = $row->name;
				$customer_name= $row->customer_name;
				$sales_pr_nm = $row->name;
				$customer_name = str_replace("'","",$customer_name);
				
				$sql_inv_tot = "select sales_person_name,sum(grand_total) as inv_tot_amt from `tabSales Invoice`
				where due_date < '".$date."'
				and due_date != ''
				and due_date is not NULL				
				and sales_person_name = '".$sales_pr_nm."'";
				//echo $sales_pr_nm;die;				
				$qry_inv_tot = $db2->query($sql_inv_tot)->row();
				$inv_tot_amt = $row->inv_tot_amt;

				$sql_inv_no="select name from `tabSales Invoice`
				where due_date < '".$date."'
				and due_date != ''
				and due_date is not NULL				
				and sales_person_name = '".$sales_pr_nm."'";
				$qry_inv_no = $db2->query($sql_inv_no);

				foreach($qry_inv_no->result() as $row){
				//Total Invoice Amount Customer Wise				
				//echo $inv_tot_amt;die;				
				//echo $sql_inv;die;				
					$inv_no = $row->name;
					//$customer_code=$row->customer;
					//echo $inv_no;die;

					$sql_inv_rec = "select sum(allocated_amount) as inv_rec_total 
					from `tabPayment Entry Reference`
					where reference_name='".$inv_no."' 
					and due_date <= '".$date."'
					and due_date != ''
					and due_date is not NULL";
					//echo $sql_inv_rec;die;

					$qry_inv_rec  = $db2->query($sql_inv_rec)->row();

					$inv_rec_total = $qry_inv_rec->inv_rec_total;

					//Received Amount Total Customer Invoice Wise
					$so_tot_rec_amt = $so_tot_rec_amt+$inv_rec_total;
				}  
				
				$overdue_amt = $inv_tot_amt-$so_tot_rec_amt;

				if($overdue_amt > 0){
					$data.=
					'<tr>
						<td>'.$sno.'</td>
						<td>'.$sales_pr_nm.'</td>
						<td>'.number_format($overdue_amt,2,".","").'</td>
					</tr>';
				}
				$tot_overdue_amt = $tot_overdue_amt + $overdue_amt;
                       
			} 
					$data.=
					'<tr style="background-color:blue">
						<td colspan="3">Total</td>
						<td>'.$tot_overdue_amt.'</td>
					<tr>
					</tbody></table>';
					return $data;            
		}	

		//so wise on dashboard
		function overdue_so_wise(){
			$ci =& get_instance();
			//$ci->load->database();
			$db2 = $ci->load->database('db2',TRUE);
            $date = date('Y-m-d');     
            $sno=0;
            $inv_grand_total =0;
			$total_overdue_amt=0;
			          
       
			$sql_cust = "select distinct `tabSales Person`.name,`tabSales Invoice`.customer_name,`tabSales Invoice`.sales_person_name  from `tabSales Person` 
			inner join `tabSales Invoice` on `tabSales Invoice`.sales_person_name = `tabSales Person`.name
			where `tabSales Person`.name in (select distinct (sales_person_name) from `tabSales Order`)
			and `tabSales Invoice`.due_date < '".$date."' 
			and `tabSales Invoice`.due_date != ''
			and `tabSales Invoice`.due_date is not NULL";

            $qry_cust  = $db2->query($sql_cust);
            foreach($qry_cust->result() as $row){
				$sno++;
				$so_tot_rec_amt = 0;
				//$overdue_amt = 0;

                $customer_code = $row->name;
				$customer_name= $row->customer_name;
				$sales_pr_nm = $row->sales_person_name;
				$customer_name = str_replace("'","",$customer_name);
				
				$sql_inv_tot = "select sales_person_name,name,sum(grand_total) as inv_tot_amt from `tabSales Invoice`
				where due_date < '".$date."'
				and due_date != ''
				and due_date is not NULL				
				and sales_person_name = '".$sales_pr_nm."'";
				//echo $sales_pr_nm;die;				
				$qry_inv_tot = $db2->query($sql_inv_tot);

				foreach($qry_inv_tot->result() as $row){
				//Total Invoice Amount Customer Wise
				$inv_tot_amt = $row->inv_tot_amt;
				//echo $inv_tot_amt;die;
				
				//echo $sql_inv;die;
				
					$inv_no = $row->name;
					//$customer_code=$row->customer;
					//echo $inv_no;die;

				
					$sql_inv_rec = "select sum(allocated_amount) as inv_rec_total 
					from `tabPayment Entry Reference`
					where reference_name='".$inv_no."' 
					and due_date <= '".$date."'
					and due_date != ''
					and due_date is not NULL";

					$qry_inv_rec  = $db2->query($sql_inv_rec)->row();

					$inv_rec_total = $qry_inv_rec->inv_rec_total;

					//Received Amount Total Customer Invoice Wise
					$so_tot_rec_amt = $so_tot_rec_amt+$inv_rec_total;
				}  
				$overdue_amt = $inv_tot_amt-$so_tot_rec_amt;
				

				if($overdue_amt > 0){
					$tot_overdue_amt = $tot_overdue_amt + $overdue_amt;	
				}
				
				echo $tot_overdue_amt;         
			} 

			
		}
		//Overdue for the day	 
		function get_overdue_for_the_day(){
			$ci =& get_instance();
			//$ci->load->database();
			$db2 = $ci->load->database('db2',TRUE);
            $date = date('Y-m-d');     
            $sno=0;
            $inv_grand_total =0;
			$total_overdue_amt=0;
			$data ='
			<table class="table table-bordered" id="example1" style="margin-top:60px">
				<thead>
					<th>SNO</th>
					<th>Customer Code</th>
					<th>Customer Name</th>
					<th>Overdue Amount </th>
				</thead>    
            	<tbody>';           
       
			$sql_cust = "select distinct `tabCustomer`.name, `tabCustomer`.customer_name from `tabCustomer` 
			inner join `tabSales Invoice` on `tabSales Invoice`.customer_name = `tabCustomer`.customer_name
			where `tabCustomer`.name in (select distinct (customer) from `tabSales Order`)
			and `tabSales Invoice`.due_date = '".$date."' 
			and `tabSales Invoice`.due_date != '' 
			and `tabSales Invoice`.due_date is not NULL";

            $qry_cust  = $db2->query($sql_cust);
            foreach($qry_cust->result() as $row){
				$sno++;
				$customer_tot_rec_amt = 0;
				$overdue_amt = 0;

                $customer_code = $row->name;
                $customer_name= $row->customer_name;
				$customer_name = str_replace("'","",$customer_name);
				
				$sql_inv_tot = "select sum(grand_total) as inv_tot_amt from `tabSales Invoice`
				where due_date = '".$date."'
				and due_date != ''
				and due_date is not NULL
				and customer_name = '".$customer_name."'";
				$qry_inv_tot = $db2->query($sql_inv_tot)->row();

				//Total Invoice Amount Customer Wise
				$inv_tot_amt = $qry_inv_tot->inv_tot_amt;

				$sql_inv = "select name from `tabSales Invoice`
				where due_date = '".$date."'
				and due_date != ''
				and due_date is not NULL 
				and customer_name = '".$customer_name."'";
				
				$qry_inv  = $db2->query($sql_inv);

				foreach($qry_inv->result() as $row){
					$inv_no = $row->name;

					$sql_inv_rec = "select sum(allocated_amount) as inv_rec_total 
					from `tabPayment Entry Reference`
					where reference_name='".$inv_no."' 
					and due_date = '".$date."'
					and due_date != ''
					and due_date is not NULL";

					$qry_inv_rec  = $db2->query($sql_inv_rec)->row();

					$inv_rec_total = $qry_inv_rec->inv_rec_total;

					//Received Amount Total Customer Invoice Wise
					$customer_tot_rec_amt = $customer_tot_rec_amt+$inv_rec_total;
				}  
				
				$overdue_amt = $inv_tot_amt-$customer_tot_rec_amt;

				if($overdue_amt > 0){
					$data.=
					'<tr>
						<td>'.$sno.'</td>
						<td>
							<a href ='.base_url().'index.php/salesc/inv_amount?cust_id='.$customer_code.'">'.$customer_code.'</a>
						</td>
						<td>'.$customer_name.'</td>
						<td>'.number_format($overdue_amt,2,".","").'</td>
					</tr>';
				}
				$tot_overdue_amt = $tot_overdue_amt + $overdue_amt;                       
			} 

			$data.='<tr style="background-color:blue">
					<td colspan="3">Total</td>
					<td>'.number_format($tot_overdue_amt,2,".","").'</td>
					<tr>
					</tbody></table>';
			return $data;            
		}	


		//Overdue for the day	 
		function overdue_for_the_day($data){
			$ci =& get_instance();
			//$ci->load->database();
			$db2 = $ci->load->database('db2',TRUE);
            $date = date('Y-m-d');     
            $sno=0;
            $inv_grand_total =0;
			$total_overdue_amt=0;
			         
       
			$sql_cust = "select distinct `tabCustomer`.name, `tabCustomer`.customer_name from `tabCustomer` 
			inner join `tabSales Invoice` on `tabSales Invoice`.customer_name = `tabCustomer`.customer_name
			where `tabCustomer`.name in (select distinct (customer) from `tabSales Order`)
			and `tabSales Invoice`.due_date = '".$date."' 
			and `tabSales Invoice`.due_date != '' 
			and `tabSales Invoice`.due_date is not NULL";

            $qry_cust  = $db2->query($sql_cust);
            foreach($qry_cust->result() as $row){
				$sno++;
				$customer_tot_rec_amt = 0;
				$overdue_amt = 0;

                $customer_code = $row->name;
                $customer_name= $row->customer_name;
				$customer_name = str_replace("'","",$customer_name);
				
				$sql_inv_tot = "select sum(grand_total) as inv_tot_amt from `tabSales Invoice`
				where due_date = '".$date."'
				and due_date != ''
				and due_date is not NULL
				and customer_name = '".$customer_name."'";
				$qry_inv_tot = $db2->query($sql_inv_tot)->row();

				//Total Invoice Amount Customer Wise
				$inv_tot_amt = $qry_inv_tot->inv_tot_amt;

				$sql_inv = "select name from `tabSales Invoice`
				where due_date = '".$date."'
				and due_date != ''
				and due_date is not NULL 
				and customer_name = '".$customer_name."'";
				
				$qry_inv  = $db2->query($sql_inv);

				foreach($qry_inv->result() as $row){
					$inv_no = $row->name;

					$sql_inv_rec = "select sum(allocated_amount) as inv_rec_total 
					from `tabPayment Entry Reference`
					where reference_name='".$inv_no."' 
					and due_date = '".$date."'
					and due_date != ''
					and due_date is not NULL";

					$qry_inv_rec  = $db2->query($sql_inv_rec)->row();

					$inv_rec_total = $qry_inv_rec->inv_rec_total;

					//Received Amount Total Customer Invoice Wise
					$customer_tot_rec_amt = $customer_tot_rec_amt+$inv_rec_total;
				}  
				
				$overdue_amt = $inv_tot_amt-$customer_tot_rec_amt;

				if($overdue_amt > 0){
					$tot_overdue_amt = $tot_overdue_amt + $overdue_amt; 
				}
				                     
			} 
			echo $tot_overdue_amt ;
			
		}	
		//overdues of category
		function get_overdue_cat_wise($item_category){ 
        
			$ci =& get_instance();
			//$ci->load->database();
			$db2 = $ci->load->database('db2',TRUE);
            $date = date('Y-m-d');
            $overdue_amt = 0;
            $sql = "select distinct item_name from `tabItem` where item_group = '".$item_category."'";
            //echo $sql;die;
            $query = $db2->query($sql);
            $sno=0;
            foreach($query->result() as $row){
            $sno++;
            $tot_rec_amt = 0;
            $item_name= $row->item_name;
            //$main_cat = $row->parent;

/*             $sql_item = "select * from `tabItem` where item_group = '".$sub_cat."'";
            //echo $sql_item;die;
            $qry_item  =$db2->query($sql_item)->row();
            $item_name = $qry_item->item_name;
            $item_group = $qry_item->item_group; */

            $sql_tot_item_amt = "select sum(net_amount) as amount,parent from `tabSales Invoice Item` 
            where item_name = '".$item_name."'";
           //echo $sql_tot_item_amt;die;
            $qry_tot_item_amt = $db2->query($sql_tot_item_amt);
            
                foreach($qry_tot_item_amt->result() as $row){
                 $net_amount = $row->amount;
                $inv_no = $row->parent;
                $item = $row->item_name;               
            
            $sql_rec_amt = "select sum(allocated_amount) as received_amt,due_date from `tabPayment Entry Reference` 
            where reference_name= '".$inv_no."' and due_date < '".$date."'";
            
            $qry_rec_amt = $db2->query($sql_rec_amt)->row();
            $inv_rec_amt = $qry_rec_amt->received_amt;
            $tot_rec_amt = $tot_rec_amt + $inv_rec_amt;           
           }
            $pend_amt = $net_amount-$tot_rec_amt;
           
            if($pend_amt >0){
            
                           
            $overdue_amt = $overdue_amt + $pend_amt;
            }
           
		}
		echo number_format($overdue_amt,2,".","");
    }

		


}