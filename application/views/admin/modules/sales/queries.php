<?php  $db2 = $this->load->database('db2', TRUE);  
       $sql = "select * from `tabSales Invoice`";
   
       $query = $db2->query($sql);
    
           foreach($query->result() as $row){
           //$id = $row->id;
            $name = $row->name; 
           $base_net_total = $row->base_net_total;
           $plc_conversion_rate = $row->plc_conversion_rate ;
           $base_rounding_adjustment = $row->base_rounding_adjustment;
           $total_qty = $row->total_qty;
           $base_total =  $row->base_total ;
           $grand_total = $row->grand_total;
           $base_grand_total =  $row->base_grand_total;
           $rounding_adjustment= $row->rounding_adjustment;
           $rounded_total =$row->rounded_total ;
           $base_rounded_total = $row->base_rounded_total;
           $total_taxes_and_charges = $row->total_taxes_and_charges; 
           $net_total  = $row->net_total; 
           $customer_name  = $row->customer_name ;
           $base_total_taxes_and_charges = $row->base_total_taxes_and_charges;
           $sales_person_name = $row->sales_person_name;
           $commitment_amount = $row->$commitment_amount;
           $commitment_date = $row->commitment_date;
           $total= $row->total ;
           $due_date =$row->due_date;
           $commitment_amount = $row->commitment_amount;
           $commitment_date = $row->commitment_date;
           $sales_person_name = $row->sales_person_name;
           
    
           $sql1 = "select count(name) as count from `tabSales Invoice` where name = '".$name."'";
           $query1 = $db2->query($sql1);
           foreach($query1->result() as $row){
           $count = $row->count;
           }
           if($count<0){
    
            $sql_insert = "insert into tab_sales_invoice(name,base_net_total,plc_conversion_rate,
            base_rounding_adjustment,total_qty ,base_total,grand_total,base_grand_total
            ,rounding_adjustment ,rounded_total, base_rounded_total, total_taxes_and_charges, 
            net_total,customer_name,base_total_taxes_and_charges,total,due_date,sales_person_name,commitment_date,commitment_amount)values 
            ('".$name."','".$base_net_total."','".$plc_conversion_rate."','".$base_rounding_adjustment."',
            '".$total_qty."', '".$base_total."', '".$grand_total."' ,'".$base_grand_total."' ,
            '".$rounding_adjustment."' ,'".$rounded_total."','".$base_rounded_total."','".$total_taxes_and_charges."',
            '".$net_total."','".$customer_name."','".$base_total_taxes_and_charges."','".$total."','".$due_date."','".$sales_person_name."',
            '".$commitment_date."','".$commitment_amount."')";
            $query_ins = $this->db->query($sql_insert);
    
       }
     }
      $sql_entry = "select * from `tabPayment Entry`";
   
      $query_entry = $db2->query($sql_entry);
   
          foreach($query_entry->result() as $row){
          //$id = $row->id;
           $name = $row->name; 
          $base_paid_amount = $row->base_paid_amount;
          $paid_amount= $row->paid_amount ;
          $paid_to_account_balance = $row->paid_to_account_balance;
          $payment_type = $row->payment_type;
          $reference_date =  $row->reference_date;
          $received_amount = $row->received_amount;
          $total_allocated_amount =  $row->total_allocated_amount;
          $title= $row->title;
          $party_balance =$row->party_balance ;
          $paid_from_account_balance = $row->paid_from_account_balance;
          $base_received_amount = $row->base_received_amount; 
          $party_name = $row->party_name; 
          $base_total_allocated_amount  = $row->base_total_allocated_amount;
          $contact_person = $row->contact_person;
          $unallocated_amount= $row->unallocated_amount ;

                $sql_insert_entry = "insert into tab_pay_entry(name ,base_paid_amount ,paid_amount ,paid_to_account_balance,
                payment_type ,reference_date, received_amount,total_allocated_amount ,title ,party_balance ,
                paid_from_account_balance ,base_received_amount ,party_name ,base_total_allocated_amount ,contact_person, 
                unallocated_amount )values 
                ('".$name."','".$base_paid_amount."' ,'".$paid_amount."' ,'".$paid_to_account_balance."',
                '".$payment_type."','".$reference_date."','".$received_amount."','".$total_allocated_amount."',
                '".$title."','".$party_balance."','".$paid_from_account_balance."',	'".$base_received_amount."',
                '".$party_name."','".$base_total_allocated_amount."','".$contact_person."','".$unallocated_amount."' )";
                $query_insert_entry = $this->db->query($sql_insert_entry);
   
      }
   
   
        /* $sql= "SELECT * from `tabSales Order Item`";
        $query = $db2->query($sql);

            foreach($query->result() as $row){
            //$id = $row->id;
            $name = $row->name;
            $parent= $row->parent;
            $parent_field = $row->parent_field;
            $parenttype = $row->parenttype;
            $base_net_amount = $row->base_net_amount;
            $projected_qty = $row->projected_qty;
            //$category_name = str_replace("'","", $cat_name);
            $amount = $row->amount;
            $billed_amt = $row->billed_amt;
            $valuation_rate = $row->valuation_rate;
            $warehouse = $row->warehouse ;	
            $base_rate_with_margin= $row->base_rate_with_margin;
            $rate_with_margin= $row->rate_with_margin ;
            $discount_percentage=$row->discount_percentage; 	
            $margin_rate_or_amount=$row->margin_rate_or_amount ;
            $item_code  =  $row->item_code 	;
            $item_name  =   $row->item_name ;
            $item_tax_template =  $row->item_tax_template ;
            $actual_qty  =  $row->actual_qty ;
            $base_price_list_rate  = $row->base_price_list_rate ;
            $delivered_qty  =  $row->delivered_qty ;
            $qty =$row->delivered_qty ;
            $conversion_factor  = $row->conversion_factor ;
            $gross_profit  = $row->gross_profit ;	
            $discount_amount  = $row->discount_amount ;
            $base_net_rate  = $row->base_net_rate ;
            $base_rate  = $row->base_rate ;
            $net_amount  = $row->net_amount ;	
            $net_rate  =  $row->net_rate ;	
            $item_group  = $row->item_group ;
            $price_list_rate  = $row->price_list_rate ;
            $base_amount  = $row->base_amount; 
            $base_uom_rate  = $row->base_uom_rate ;
            $unit_price_pni  = $row->unit_price_pni ;
        
            $sql1 = "select count(name) as count from `tabSales Order Item` where name = '".$name."'";
            $query1 = $db2->query($sql1);
            foreach($query1->result() as $row){
            $count = $row->count;
        
        if($count<0){
            
            $sql2 = "insert into tab_sales_ord_item(name ,parent ,parent_field ,parenttype ,base_net_amount ,
            projected_qty ,amount ,billed_amt ,valuation_rate ,warehouse ,base_rate_with_margin ,rate_with_margin,
            discount_percentage ,margin_rate_or_amount ,item_code ,item_name ,item_tax_template ,actual_qty ,
            base_price_list_rate ,delivered_qty ,qty ,conversion_factor ,gross_profit ,discount_amount ,
            base_net_rate ,base_rate ,net_amount ,net_rate ,item_group ,price_list_rate ,base_amount ,
            base_uom_rate ,unit_price_pni )
            values('".$name."','".$parent."','".$parent_field."','".$parenttype."','".$base_net_amount."',
            '".$projected_qty."','".$amount."','".$billed_amt."','".$valuation_rate."','".$warehouse."',
            '".$base_rate_with_margin."','".$rate_with_margin."','".$discount_percentage."','".$margin_rate_or_amount."',
            '".$item_code ."','".$item_name."','".$item_tax_template."','".$actual_qty."','".$base_price_list_rate."',
            '".$delivered_qty."','".$qty."','".$conversion_factor."','".$gross_profit."','".$discount_amount."',
            '".$base_net_rate."','".$base_rate."' ,'".$net_amount."','".$net_rate."','".$item_group."',
            '".$price_list_rate ."','".$base_amount."','".$base_uom_rate."' ,'".$unit_price_pni."' )";
            $query2 = $this->db->query($sql2);

        }
    } */
    

        /* $sql= "select * from `tabItem` ";
        $query = $db2->query($sql);
         foreach ($query->result() as $row){
            $item_code = $row->item_code;
            $item_name = $row->item_name;
            $sql2= "update erp_pend_pay set item_code='".$item_code."',item_name='".$item_name."'";  
            $query2 = $this->db->query($sql2);    
         }

         $sql= "select * from tabSales Order";
         $query = $db2->query($sql);
            foreach ($query->result() as $row){
            $so_code = $row->name;
            $sales_person = $row->sales_person;
            $cust_name = $row->customer_name;
            $base_amt = $row->base_rounded_total;
        }

        $sql= "select * from tabSales Order Item";
        $query = $db2->query($sql);

            foreach ($query->result() as $row){
            $parent_so = $row->parent;
            $so_item_code = $row->item_code;
            $so_item_name = $row->so_item_name;
        } 
         */
        $sql = "select * from `tabSales Order`";
        $queries = $db2->query($sql);
        foreach($queries->result() as $row){
        $sales_order =$row->name; 
         $base_rounded_total =$row->base_rounded_total;
         $customer_name = $row->customer_name;
         $net_toal = $row->net_total;
         $total =$row->total;
        $party_name = $row->title;
        $base_grand_total = $row->base_grand_total;
         $grand_total =$row->grand_total;
          $delivery_date = $row->delivery_date;
         $rounded_total = $row->rounded_total;
         $base_total = $row->base_total;
      $base_net_total = $row->base_net_total;
    $sales_person_name = $row->sales_person_name;
    $sql_insert="insert into tab_sales_order(sales_order ,base_rounded_total ,customer_name ,net_toal ,total ,party_name ,
        base_grand_total ,grand_total ,delivery_date ,rounded_total ,base_total ,base_net_total ,sales_person_name )values(
        '".$sales_order."','".$base_rounded_total."','".$customer_name."','".$net_toal."','".$total ."',
        '".$party_name."','".$base_grand_total."','".$grand_total."','".$delivery_date."' ,'".$rounded_total."',
        '".$base_total."','".$base_net_total."','".$sales_person_name."')";
    
        $qry_insert = $this->db->query($sql_insert);
        }
    ?>    
 ?>