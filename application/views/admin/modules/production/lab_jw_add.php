<?php $this->load->helper("production"); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Labour Job Work Add</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $ljw_id = $_REQUEST['id'];
        if($ljw_id != ''){
            foreach($get_by_id->result() as $row){
                $ljw_labour_id = $row->ljw_labour_id;
                $ljw_labour_name = $row->ljw_labour_name;
            }
        } else {
            $ljw_labour_id = "";
            $ljw_labour_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Labour Job Work Add
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/productionc/lab_jw_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($ljw_id != ''){
                        echo "<h2>Labour Jobwork Id - ".$ljw_id."</h2>";
                ?>
                    <input type="hidden" id="ljw_id" name="ljw_id" value="<?=$ljw_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="ljw_id" name="ljw_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Labour Name</label>
                    <div class="col-sm-3">
                        <select id="ljw_labour_id" name="ljw_labour_id" class="form-control">
                            <?php if($ljw_labour_id !=""){?>
                            <option value="<?=$ljw_labour_id;?>"><?=$ljw_labour_name?></option>
                            <?php } else { ?>
                            <?=labour_name();?>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h3>Labour Job Details</b></h3></div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="item_tbl">
                        <thead>
                            <tr>
                                <th>Stone Job</th>
                                <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                            </tr>
                        </thead>
                        <tbody style="text-align:left">
                            <?php
                            if($ljw_id != ''){
                                $sql_ljw_list = "select * from lab_jw_det where ljw_id='".$ljw_id."'";
                                $qry_ljw_list = $this->db->query($sql_ljw_list);

                                foreach($qry_ljw_list->result() as $row){
                                    $ljw_stone_job_id = $row->ljw_stone_job_id;
                                    $ljw_stone_job_nm = $row->ljw_stone_job_nm;
                            ?>
                            <tr>
                                <td>
                                    <?=$ljw_stone_job_nm;?>
                                    <input type="hidden" id="ljw_stone_job_id" name="ljw_stone_job_id[]" value="<?=$ljw_stone_job_id;?>">
                                </td>
                                <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                             </tr>
                            <?php
                                }    
                            } else {
                            ?>
                            <tr>
                                <td>
                                    <select id="ljw_stone_job_id" name="ljw_stone_job_id[]" class="form-control" required>
                                        <?=stone_process();?>
                                    </select>
                                </td>
                                <td>
                                    <span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>
                                </td>
                             </tr>
                            <?php    
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
                    </div>
                    <div class="col-sm-5"></div>
                </div>
            </form>
            </div>
            <div class="col-lg-2"></div>
        </section>
        </div>
    </div>
  </section>
</section>

<script>
//Add Row Function
function addrow(){
    var table = document.getElementById('item_tbl');
    
    var a =  document.getElementById('item_tbl').rows.length;
    var rowCount = a-1;
    
    var row = table.insertRow(a);
    
    var newCell1 = row.insertCell(0);
    newCell1.innerHTML = '<select id="ljw_stone_job_id" name="ljw_stone_job_id[]" class="form-control" required><?=stone_process();?></select>';
    
    var newCell1 = row.insertCell(1);
    newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>';
    

}

//Delete Row Function
function deleterow(){
    var table = document.getElementById('item_tbl');
    var rowCount = table.rows.length;
    table.deleteRow(rowCount -1);
}

//Select 2 Function
$( function(){
    $("#ljw_labour_id").select2();
});
</script>