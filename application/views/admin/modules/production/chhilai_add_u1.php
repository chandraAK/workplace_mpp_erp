<?php $this->load->helper("production"); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Entry Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $chhilai_id = $_REQUEST['id'];
        if($chhilai_id != ''){
            foreach($get_by_id->result() as $row){
                $chhilai_date = $row->chhilai_date;
                $process_type = $row->process_type;
            }
        } else {
            $chhilai_date = "";
            $process_type = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">Entry Form</header>
            
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/productionc/chhilai_entry_u1">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($chhilai_id != ''){
                        echo "<h2>Id :- ".$chhilai_id."</h2>";
                ?>
                    <input type="hidden" id="chhilai_id" name="chhilai_id" value="<?=$chhilai_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="chhilai_id" name="chhilai_id" value="">
                <?php } ?>

                <input type="hidden" id="comp_id" name="comp_id" value="1">

                <div class="form-group">
                    <label class="col-sm-2 control-label">Chhilai Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="chhilai_date" name="chhilai_date" value="<?php echo $chhilai_date; ?>" 
                        required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Process Type</label>
                    <div class="col-sm-3">
                        <select id="process_type" name="process_type" class="form-control" required>
                            <?php if($process_type != ""){ ?>
                                <option value="<?=$process_type;?>"><?=$process_type;?></option>
                            <?php } ?>
                            <?=process_type_fun();?>
                        </select>
                    </div>
                </div>
                
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h3>Details</b></h3></div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="item_tbl">
                        <thead>
                            <tr>
                                <th>Labour Name</th>
                                <th>Stone Size</th>
                                <th>Stone Task</th>
                                <th>Qty</th>
                                <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                            </tr>
                        </thead>
                        <tbody style="text-align:left">
                            <?php
                            if($chhilai_id != ''){
                                $sql_chhilai_list = "select * from chhilai_dtl where chhilai_id='".$chhilai_id."'";
                                $qry_chhilai_list = $this->db->query($sql_chhilai_list);

                                $cnt = 0;
                                foreach($qry_chhilai_list->result() as $row){
                                    $cnt++;
                                    $labour_name = $row->labour_name;
                                    $stone_size = $row->stone_size;
                                    $stone_task = $row->stone_task;
                                    $stone_qty = $row->stone_qty;
                            ?>
                            <tr>
                                <td>
                                    <?=$labour_name;?>
                                    <input type="hidden" id="labour_name" name="labour_name[]" value="<?=$labour_name;?>">
                                </td>
                                <td>
                                    <?=$stone_size;?>
                                    <input type="hidden" id="stone_size" name="stone_size[]" value="<?=$stone_size;?>">
                                </td>
                                <td>
                                    <?=$stone_task;?>
                                    <input type="hidden" id="stone_task" name="stone_task[]" value="<?=$stone_task;?>">
                                </td>
                                <td>
                                    <?=$stone_qty;?>
                                    <input type="hidden" id="stone_qty" name="stone_qty[]" value="<?=$stone_qty;?>" onkeypress="return isNumberKey(event);">
                                </td>
                                <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                             </tr>
                            <?php
                                }    
                            } else {
                            ?>
                            <tr>
                                <td>
                                    <select id="labour_name" name="labour_name[]" class="form-control" required>
                                        <?=labour_list();?>
                                    </select>
                                </td>
                                <td>
                                    <select id="stone_size" name="stone_size[]" class="form-control" required>
                                        <?=stone_size();?>
                                    </select>
                                </td>
                                <td>
                                    <select id="stone_task" name="stone_task[]" class="form-control" required>
                                        <?=stone_task();?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" id="stone_qty" name="stone_qty[]" value="" class="form-control" 
                                    onkeypress="return isNumberKey(event);" required>
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
    //Restricting Only to insert Numbers
    function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
    
    }

    //Date Picker
    $(function(){
        $( "#chhilai_date" ).datepicker({
            "dateFormat" : "yy-mm-dd"
        });
    });

    //Add Row Function
    function addrow(){
        var table = document.getElementById('item_tbl');
        
        var a =  document.getElementById('item_tbl').rows.length;
        var rowCount = a-1;
        
        var row = table.insertRow(a);
        
        var newCell1 = row.insertCell(0);
        newCell1.innerHTML = '<select id="labour_name" name="labour_name[]" class="form-control" required><?=labour_list();?></select>';
        
        var newCell1 = row.insertCell(1);
        newCell1.innerHTML = '<select id="stone_size" name="stone_size[]" class="form-control" required><?=stone_size();?></select>';

        var newCell1 = row.insertCell(2);
        newCell1.innerHTML = '<select id="stone_task" name="stone_task[]" class="form-control" required><?=stone_task();?></select>';
        
        var newCell1 = row.insertCell(3);
        newCell1.innerHTML = '<input type="text" id="stone_qty" name="stone_qty[]" value="" class="form-control" onkeypress="return isNumberKey(event);" required>';
        
        var newCell1 = row.insertCell(4);
        newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>';
        

    }

    //Delete Row Function
    function deleterow(){
        var table = document.getElementById('item_tbl');
        var rowCount = table.rows.length;
        table.deleteRow(rowCount -1);
    }
</script>