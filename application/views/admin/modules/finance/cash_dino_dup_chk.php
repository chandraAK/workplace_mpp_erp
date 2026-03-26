<?php
    $comp_id = $_REQUEST['comp_id'];
    $cd_date = $_REQUEST['cd_date'];

    $sql = "select count(*) as count from cash_dino_mst where cd_comp_id = '".$comp_id."' and cd_date = '".$cd_date."'";
    $qry = $this->db->query($sql)->row();

    $count = $qry->count;

    if($count > 0){
        echo "<h3 style='color:red'>Entry already exist of selected company & selected date.</h3>";
    } else {
?>

<div class="form-group">
    <h3 style="text-align:center">Cash Dinomination Details</h3>
    <div class="col-sm-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <?php
                        $sql = "select * from curr_unit_mst where curr_active = 1";
                        $qry = $this->db->query($sql);
                        foreach($qry->result() as $row){
                            $curr_name = $row->curr_name;
                    ?>
                    <th><?=$curr_name;?></th>
                    <?php } ?>
                    <th><b>Total</b></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                        foreach($qry->result() as $row){
                            $curr_id = $row->curr_id;
                            $curr_name = $row->curr_name;
                    ?>
                    <td>
                        <input type="hidden" id="curr_unit_id" name="curr_unit_id[]" value="<?=$curr_id;?>">
                        
                        <input type="hidden" id="curr_unit_name" name="curr_unit_name[]" value="<?=$curr_name;?>">

                        <input type="text" id="curr_unit_<?=$curr_name;?>" name="curr_unit_val[]" value="0" 
                        class="form-control" onkeypress="return isNumberKey(event); " onkeyup="tot_calc()" required>
                        
                    </td>
                    <?php } ?>
                    <td><input type="text" id="curr_tot" name="curr_tot" value="0" class="form-control" readonly></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-5"></div>
    <div class="col-sm-2">
        <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
    </div>
    <div class="col-sm-5"></div>
</div>

<?php
    }
?>