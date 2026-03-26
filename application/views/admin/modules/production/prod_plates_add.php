<?php $this->load->helper("production"); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Production Plates Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $prod_id = $_REQUEST['id'];
        if($prod_id != ''){
            foreach($get_by_id->result() as $row){
                $prod_date = $row->prod_date;
            }
        } else {
            $prod_date = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">Production Plates Form</header>
            
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/productionc/prod_plates_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($prod_id != ''){
                        echo "<h2>Production Id :- ".$prod_id."</h2>";
                ?>
                    <input type="hidden" id="prod_id" name="prod_id" value="<?=$prod_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="prod_id" name="prod_id" value="">
                <?php } ?>

                <input type="hidden" id="comp_id" name="comp_id" value="1">

                <div class="form-group">
                    <label class="col-sm-2 control-label">Production Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="prod_date" name="prod_date" value="<?php echo $prod_date; ?>" 
                        required>
                    </div>
                </div>

                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h3>Production Details</b></h3></div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="item_tbl">
                        <thead>
                            <tr>
                                <th>Labour Name</th>
                                <th>Plate Name</th>
                                <th>Qty</th>
                                <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                            </tr>
                        </thead>
                        <tbody style="text-align:left">
                            <?php
                            if($prod_id != ''){
                                $sql_pp_list = "select * from prod_plates_dtl where prod_id='".$prod_id."'";
                                $qry_pp_list = $this->db->query($sql_pp_list);

                                $cnt = 0;
                                foreach($qry_pp_list->result() as $row){
                                    $cnt++;
                                    $labour_name = $row->labour_name;
                                    $plate_name = $row->plate_name;
                                    $plate_qty = $row->plate_qty;
                            ?>
                            <tr>
                                <td>
                                    <?=$labour_name;?>
                                    <input type="hidden" id="labour_name" name="labour_name[]" value="<?=$labour_name;?>">
                                </td>
                                <td>
                                    <?=$plate_name;?>
                                    <input type="hidden" id="plate_name" name="plate_name[]" value="<?=$plate_name;?>">
                                </td>
                                <td>
                                    <?=$plate_qty;?>
                                    <input type="hidden" id="plate_qty" name="plate_qty[]" value="<?=$plate_qty;?>" onkeypress="return isNumberKey(event);">
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
                                    <select id="plate_name" name="plate_name[]" class="form-control" required>
                                        <?=plates_list();?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" id="plate_qty" name="plate_qty[]" value="" class="form-control" 
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
        $( "#prod_date" ).datepicker({
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
        newCell1.innerHTML = '<select id="plate_name" name="plate_name[]" class="form-control" required><?=plates_list();?></select>';

        var newCell1 = row.insertCell(2);
        newCell1.innerHTML = '<input type="text" id="plate_qty" name="plate_qty[]" value="" class="form-control" onkeypress="return isNumberKey(event);" required>';
        
        var newCell1 = row.insertCell(3);
        newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>';
        

    }

    //Delete Row Function
    function deleterow(){
        var table = document.getElementById('item_tbl');
        var rowCount = table.rows.length;
        table.deleteRow(rowCount -1);
    }
</script>