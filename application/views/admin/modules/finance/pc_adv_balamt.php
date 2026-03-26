<?php
    $emp_name = $_REQUEST["emp_name"];
    $bal_amt = 0;

    $sql_bal_amt = "select pc_adv_bal_amt from petty_cash_adv 
    where pc_emp_name = '".$emp_name."'
    and pc_adv_id = (select max(pc_adv_id) from petty_cash_adv 
    where pc_emp_name = '$emp_name' and pc_adv_status = 'Approved')";

    $qry_bal_amt = $this->db->query($sql_bal_amt)->row();

    $pc_adv_bal_amt = $qry_bal_amt->pc_adv_bal_amt;

    if($pc_adv_bal_amt == ""){
        $pc_adv_bal_amt = 0.00;
    }

    //Expenses
    $sql_exp = "select sum(pcexp_tot_amt) as tot_exp from petty_cash_exp_mst 
    where pcexp_empname = '".$emp_name."'  and pcexp_status = 'Approved'";

    $qry_exp = $this->db->query($sql_exp)->row();

    $tot_exp = $qry_exp->tot_exp;

    if($tot_exp == ""){
        $tot_exp = 0.00;
    }

    $bal_amt = $pc_adv_bal_amt-$tot_exp;

    if($bal_amt == ""){
        $bal_amt = 0.00;
    }
?>

<input type="text" id="pc_adv_bal_amt" name="pc_adv_bal_amt" value="<?=number_format($bal_amt,2,".",""); ?>" class="form-control" readonly>