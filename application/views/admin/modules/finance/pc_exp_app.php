<?php $this->load->helper("finance"); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Petty Cash Expense Approval</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $pcexp_id = $_REQUEST['id'];
        if($pcexp_id != ''){
            foreach($get_by_id->result() as $row){
                $pcexp_empname = $row->pcexp_empname;
                $pcexp_balamt = $row->pcexp_balamt;
            }
        } else {
            $pcexp_empname = "";
            $pcexp_balamt = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">Petty Cash Expense Approval</header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/financec/pc_exp_app_entry">
            <div class="panel-body">
                <?php
                    if($pcexp_id != ''){
                        echo "<h2>Expense Id - ".$pcexp_id."</h2>";
                ?>
                    <input type="hidden" id="pcexp_id" name="pcexp_id" value="<?=$pcexp_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="pcexp_id" name="pcexp_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Employee Name</label>
                    <div class="col-sm-3">
                        <?=$pcexp_empname;?>
                        <input type="hidden" id="pcexp_empname" name="pcexp_empname" value="<?=$pcexp_empname;?>">
                    </div>

                    <label class="col-sm-3 control-label">Balance Amount</label>
                    <div class="col-sm-3"><?=$pcexp_balamt;?></div>
                </div>

                <div class="form-group">
                    <br/><br/>
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-12"><h3>Expenses</b></h3></div>
                            </div>
                        </div>
                        <table class="table table-bordered" id="item_tbl">
                            <thead>
                                <tr>
                                    <th>Expense Date</th>
                                    <th>Amount</th>
                                    <th>Comments</th>
                                    <th>Bill</th>
                                </tr>
                            </thead>
                            <tbody style="text-align:left">
                                <?php
                                    $sql_itm_list = "select * from petty_cash_exp_dtl where pcexp_id ='".$pcexp_id."'";
                                    $qry_itm_list = $this->db->query($sql_itm_list);

                                    $cnt = 0;
                                    foreach($qry_itm_list->result() as $row){
                                        $cnt++;
                                        $pcexp_dtl_date = $row->pcexp_dtl_date;
                                        $pcexp_dtl_amt = $row->pcexp_dtl_amt;
                                        $pcexp_dtl_com = $row->pcexp_dtl_com;
                                        $pcexp_dtl_bill = $row->pcexp_dtl_bill;
                                ?>
                                <tr>
                                    <td>
                                        <?=$pcexp_dtl_date;?>
                                        <input type="hidden" id="pcexp_dtl_date" name="pcexp_dtl_date[]" value="<?=$pcexp_dtl_date;?>">
                                    </td>
                                    <td>
                                        <?=$pcexp_dtl_amt;?>
                                        <input type="hidden" class="form-control" id="pcexp_dtl_amt" name="pcexp_dtl_amt[]" 
                                        value="<?=$pcexp_dtl_amt;?>" onkeypress="return isNumberKey(event);">
                                    </td>
                                    <td>
                                        <?=$pcexp_dtl_com;?>
                                        <input type="hidden" id="pcexp_dtl_com" name="pcexp_dtl_com[]" value="<?=$pcexp_dtl_com;?>">
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>uploads/<?=$pcexp_dtl_bill;?>" target="_blank">
                                            <?=$pcexp_dtl_bill;?>
                                        </a>
                                        <input type="hidden" class="form-control" id="pcexp_dtl_bill" name="pcexp_dtl_bill[]" value="<?=$pcexp_dtl_bill;?>" onkeypress="return isNumberKey(event);">
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Remarks</label>
                    <div class="col-sm-8">
                        <input type="text" id="app_rmks" name="app_rmks" class="form-control" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Status</label>
                    <div class="col-sm-8">
                        <select id="pcexp_status" name="pcexp_status" class="form-control" required>
                            <option value="">--Select--</option>
                            <?php
                                $sql_stat = "select * from petty_cash_status";
                                $qry_stat = $this->db->query($sql_stat);
                                foreach($qry_stat->result() as $row){
                            ?>
                                <option value="<?=$row->pc_status_name;?>"><?=$row->pc_status_name;?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <input type="submit" id="submit" name="submit" value="Submit" class="form-control">
                    </div>
                    <div class="col-sm-4"></div>
                </div>
                  
            </form>
            </div>
        </section>
        </div>
        <div class="col-lg-2"></div>
    </div>
  </section>
</section>