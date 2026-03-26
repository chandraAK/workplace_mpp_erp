<?php $this->load->helper("itemlist"); ?>
<?php
    $item_id = $_REQUEST['item_id'];
    $comp_id = $_REQUEST['comp_id'];

    //Getting Previous Stock
    $sql_prev_stk = "select sum(ifs_fg_stock_runner) as runner_stk, sum(ifs_fg_stock_fix) as fix_stk 
    from item_fg_stock where ifs_itm_id = '".$item_id."' and ifs_comp_id = '".$comp_id."'";
    $qry_prev_stk = $this->db->query($sql_prev_stk)->row();
    $runner_stk = $qry_prev_stk->runner_stk;
    $fix_stk = $qry_prev_stk->fix_stk;

    if($runner_stk == ""){
        $runner_stk = 0;
    }

    if($fix_stk == ""){
        $fix_stk = 0;
    }
?>

<div class="form-group">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-12"><h3 style="text-align:center">Item Details</b></h3></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered" id="item_tbl">
                    <thead>
                        <tr style="font-weight:bold">
                            <th rowspan="2">Item Name</th>
                            <th colspan="2" style="text-align:center">SVIPL Unit1</th>
                            <th colspan="2" style="text-align:center">SBMI</th>
                            <th colspan="2" style="text-align:center">Total</th>
                            <th rowspan="2"><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                        </tr>
                        <tr style="font-weight:bold">
                            <th>Runner</th>
                            <th>Fix</th>
                            <th>Runner</th>
                            <th>Fix</th>
                            <th>Runner</th>
                            <th>Fix</th>
                        </tr>
                    </thead>
                    <tbody style="text-align:left">
                        <tr>
                            <td>
                                <select id="glm_itm_id1" name="glm_itm_id[]" class="form-control  glm_itm_id" required>
                                    <?php echo item_list(); ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="glm_svipl1_runner1" name="glm_svipl1_runner[]" onkeyup="line_tot_runner(1);" value="0" onkeypress="return isNumberKey(event);">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="glm_svipl1_fix1" name="glm_svipl1_fix[]" onkeyup="line_tot_fix(1);"  value="0" onkeypress="return isNumberKey(event);">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="glm_sbmi_runner1" name="glm_sbmi_runner[]" onkeyup="line_tot_runner(1);"  value="0" onkeypress="return isNumberKey(event);">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="glm_sbmi_fix1" name="glm_sbmi_fix[]" onkeyup="line_tot_fix(1);"  value="0" onkeypress="return isNumberKey(event);">
                            </td>
                            <td>
                                <input type="text" class="form-control glm_svipl1_runner" id="glm_tot_runner1" name="glm_tot_runner[]" onkeyup="line_tot_runner(1);"  value="0" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control glm_svipl1_fix" id="glm_tot_fix1" name="glm_tot_fix[]" onkeyup="line_tot_fix(1);"  value="0" readonly>
                            </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6"></div>
            <div class="col-lg-1"><b>Total Runner</b></div>
            <div class="col-lg-2"><input type="text" class="form-control" id="tot_runner" name="tot_runner" value="0" readonly></div>
            <div class="col-lg-1"><b>Total Fixed</b></div>
            <div class="col-lg-2"><input type="text" class="form-control" id="tot_fix" name="tot_fix" value="0" readonly></div>
        </div>
        
    </div>
</div>