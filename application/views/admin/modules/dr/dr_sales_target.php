<?php $this->load->helper("dr"); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Daily Report Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    <?php
        $dr_sales_target_id = $_REQUEST['id'];

        if($dr_sales_target_id != ''){
            foreach($get_by_id->result() as $row){
                $dr_sales_created_by = $_SESSION['username'];
                $dr_sales_pr_name = $row->dr_sales_pr_name;
                $dr_sales_dispch_amt = $row->dr_sales_dispch_amt;
                $dr_sales_mach_amt  = $row->dr_sales_mach_amt;
                $dr_sales_pur_amt  = $row->dr_sales_pur_amt;
                $dr_sales_ord_amt  = $row->dr_sales_ord_amt;
                $dr_sales_modified_by = $_SESSION['username'];
                $dr_sales_created_date  = $row->dr_sales_created_date ;
                $dr_date = substr($dr_sales_created_date,0,10);
                $dr_sales_modified_date =   $row->dr_sales_modified_date ; 
               
            }
        } else {
            $dr_sales_created_by = "";
            $dr_sales_pr_name = "";
            $dr_sales_dispch_amt = "";
            $dr_sales_mach_amt ="";
            $dr_sales_ord_amt= "";
            $dr_sales_modified_by = "";
            $dr_sales_modified_by = "";
            $dr_sales_created_date = "";
            $dr_sales_modified_date = "" ; 
               
            
        }
    ?>
       

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <section class="panel">
                <header class="panel-heading" style="font-size:18px"><b>
                    Daily Sales Target Form</b>
                </header>
                <form class="form-horizontal " method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/drc/dr_salestarget_entry">
                <div class="panel-body">
                    
                    <!--- Added by Charu 202010291235 -->
                    <div class="form-group">
                    <label class="col-sm-2 control-label" style="align:left">Date</label>
                        <div class="col-sm-10">
                             <input type="text" id="dr_sales_created_date" name="dr_sales_created_date" class="form-control" value="<?php echo $dr_date;?>"><br><br>
                             </div>
                  <!--inquiry details-->
                             <?php
                        if($dr_sales_target_id != ''){
                            echo "<h4>DR No-".$dr_sales_target_id."</h4>";
                            $sql = "select name from login  where username ='".$dr_sales_pr_name."'";
                            $query = $this->db->query($sql);
                            foreach($query->result() as $row){
                               $name= $row->name;
                            }
                    ?>
                        <input type="hidden" id="dr_sales_target_id" name="dr_sales_target_id" value="<?=$dr_sales_target_id; ?>">
                        <label class="col-sm-2 control-label" style="align:left">Sales Person</label>
                         <div class="col-sm-10">
                         <input type="text" id="name" name="name" class="form-control" value=<?="$name"?> readonly><br><br>
                            </div>
         
                    <?php
                        } else {
                    ?>
                        <input type="hidden" id="dr_sales_target_id" name="dr_sales_target_id" value="">
                        <label class="col-sm-2 control-label" style="align:left">Sales Person</label>
                        <div class="col-sm-10">
                            <select id="dr_sales_pr_name" name="dr_sales_pr_name" class="form-control" onChange="sales_form();">
                                <?php echo dr_sales_name(); ?>
                            </select>
                        </div>
                    <?php
                        }
                    ?>

                         </div>
                    <!--- Added by Charu 202011171416 -->
                    <div id="detail"></div>
                </form>
            </section>
        </div>
        <div class="col-lg-2"></div>
    </div>
  </section>
</section>
<script>


$( function() {
    $( "#dr_sales_created_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );

//Sales form  Ajax
function sales_form(){
    //alert("charu");
    //return false;
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
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/drc/dr_sales_ajax",true);
    xmlhttp.send();
}
</script>`