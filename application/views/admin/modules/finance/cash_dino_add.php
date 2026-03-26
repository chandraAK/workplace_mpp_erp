<?php $this->load->helper("finance"); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Cash Dinomination</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $cd_id = $_REQUEST['id'];
        if($cd_id != ''){
            foreach($get_by_id->result() as $row){
                $cd_comp_id = $row->cd_comp_id;
                $cd_comp_name = $row->cd_comp_name;
            }
        } else {
            $cd_comp_id = "";
            $cd_comp_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Cash Dinomination</header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/financec/cash_dino_entry">
            <div class="panel-body">
                <!-- Cash Dimomination Details -->
                <?php
                    if($cd_id != ''){
                        echo "<h2>Cash Dinomination Id - ".$cd_id."</h2>";
                ?>
                    <input type="hidden" id="cd_id" name="cd_id" value="<?=$cd_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="cd_id" name="cd_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Company Name</label>
                    <div class="col-sm-3">
                        <select id="cd_comp_id" name="cd_comp_id" class="form-control" onchange="ChkDup(this.value);" required>
                            <?php if($cd_comp_id != ""){ ?>
                                <option value="<?=$cd_comp_id;?>" selected><?=$cd_comp_name?></option>
                            <?php } ?>
                            <option value="">--Select--</option>
                            <?php echo company_list(); ?>
                        </select>
                    </div>

                    <label class="col-sm-2 control-label">Date</label>
                    <div class="col-sm-3">
                        <input type="text" id="cd_date" name="cd_date" value="<?php echo date("Y-m-d"); ?>" class="form-control" readonly>
                    </div>
                </div>

                <div id="detail"></div>
                  
            </form>
            </div>
        </section>
        </div>
    </div>
  </section>
</section>

<script>
    //Date Picker
    $(function(){
        $( "#cd_date" ).datepicker({
            "dateFormat" : "yy-mm-dd"
        });
    });

    //Select 2 Function
    $( function(){
        $("#cd_comp_id").select2();
    });

    //Restricting Only to insert Numbers
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
            return false;
        }

        //tot_calc();

        return true;
    }

    function tot_calc(){
        var curr_unit_2000 = document.getElementById("curr_unit_2000").value;
        var curr_unit_500 = document.getElementById("curr_unit_500").value;
        var curr_unit_200 = document.getElementById("curr_unit_200").value;
        var curr_unit_100 = document.getElementById("curr_unit_100").value;
        var curr_unit_50 = document.getElementById("curr_unit_50").value;
        var curr_unit_20 = document.getElementById("curr_unit_20").value;
        var curr_unit_10 = document.getElementById("curr_unit_10").value;
        var curr_unit_5 = document.getElementById("curr_unit_5").value;
        var curr_unit_2 = document.getElementById("curr_unit_2").value;
        var curr_unit_1 = document.getElementById("curr_unit_1").value;

        var curr_tot1 = (Number(curr_unit_2000)*2000)+(Number(curr_unit_500)*500)+(Number(curr_unit_200)*200)+(Number(curr_unit_100)*100)+(Number(curr_unit_50)*50)+(Number(curr_unit_20)*20)+(Number(curr_unit_10)*10)+(Number(curr_unit_5)*5)+(Number(curr_unit_2)*2)+(Number(curr_unit_1)*1);

        document.getElementById("curr_tot").value = curr_tot1;
    }

    //Check Duplicate Entries
    function ChkDup(comp_id){
        var cd_date = document.getElementById("cd_date").value;

        //Ajax
        $("#detail").empty().html('<img src="<?php echo base_url(); ?>assets/images/wait.gif" />');
        
        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        } else {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        } 

        xmlhttp.onreadystatechange=function(){
            if(xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById('detail').innerHTML=xmlhttp.responseText;
            }
        }
        
        var queryString="?comp_id="+encodeURIComponent(comp_id)+"&cd_date="+encodeURIComponent(cd_date);
        
        xmlhttp.open("GET","<?php echo base_url(); ?>index.php/financec/cash_dino_dup_chk" + queryString,true);
        xmlhttp.send();
    }
</script>