<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Ticket Registration Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $ticket_id = $_REQUEST['id'];
        if($ticket_id != ''){
            foreach($get_by_id->result() as $row){
                $ticket_type = $row->ticket_type;
                $ticket_severity = $row->ticket_severity;
                $ticket_module = $row->ticket_module;
                $ticket_issue_type = $row->ticket_issue_type;
                $ticket_issue_desc = $row->ticket_issue_desc;
                $ticket_remedy = $row->ticket_remedy;
                $ticket_comments = $row->ticket_comments;
                $ticket_assigned_to = $row->ticket_assigned_to;
                $ticket_status = $row->ticket_status;
                $created_by = $row->created_by;
            }
        } else {
            $ticket_type = "";
            $ticket_severity = "";
            $ticket_module = "";
            $ticket_issue_type = "";
            $ticket_issue_desc = "";
            $ticket_remedy = "";
            $ticket_comments = "";
            $ticket_assigned_to = "";
            $ticket_status = "";
            $created_by = "";
        }
    ?>
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Ticket Registration Form
            </header>
            <div class="panel-body">
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/itc/ticket_reg_entry">
                
                <?php if($ticket_id != ''){ ?>
                <div class="form-group">
                    <div class="col-sm-6" style="text-align:left">  
                        <b style="font-size:18px;">Ticket ID - <i><?=$ticket_id;?></i></b>
                    </div>
                    <div class="col-sm-6" style="text-align:right">
                        <b style="font-size:18px;">Status - <i><?=$ticket_status;?></i></b>
                    </div>
                </div>
                <?php } ?>

                <!--- Hidden Feilds --->
                <input type="hidden" id="ticket_id" name="ticket_id" value="<?php if($ticket_id != ''){ echo $ticket_id; } else{ } ?>">

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ticket Created By</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="created_by" name="created_by" 
                        value="<?php if($ticket_id == ""){ echo $_SESSION['username']; } else { echo $created_by; } ?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ticket Severity</label>
                    <div class="col-sm-10">
                        <select id="ticket_severity" name="ticket_severity" class="form-control" required>
                            <option value="">--select--</option>
                            <?php
                                $sql_severity = "select * from ticket_sev_mst order by ticket_sev_name";
                                $qry_severity = $this->db->query($sql_severity);
                                foreach($qry_severity->result() as $row){
                            ?>
                            <option value="<?=$row->ticket_sev_id;?>"><?=$row->ticket_sev_name;?></option>
                            <?php 
                                } 
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ticket Type</label>
                    <div class="col-sm-10">
                        <select id="ticket_type" name="ticket_type" class="form-control" onChange="ticket_module_list(this.value);" required>
                            <option value="">--select--</option>
                            <?php
                                $sql_issue_type = "select * from ticket_type_mst order by ticket_type_name";
                                $qry_issue_type = $this->db->query($sql_issue_type);
                                foreach($qry_issue_type->result() as $row){
                            ?>
                            <option value="<?=$row->ticket_type_id;?>"><?=$row->ticket_type_name;?></option>
                            <?php 
                                } 
                            ?>
                        </select>
                    </div>
                </div>
                
                <div id="detail"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Issue Description</label>
                    <div class="col-sm-10">
                        <textarea id="ticket_issue_desc" name="ticket_issue_desc" class="form-control" required><?php echo $ticket_issue_desc; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Remedy Required</label>
                    <div class="col-sm-10">
                        <textarea id="ticket_remedy" name="ticket_remedy" class="form-control"><?php echo $ticket_remedy; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Comments</label>
                    <div class="col-sm-10">
                        <textarea id="ticket_comments" name="ticket_comments" class="form-control"><?php echo $ticket_comments; ?></textarea>
                    </div>
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
$( function() {
    $( "#inq_rec_on" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );

//Restricting Only to insert Numbers
function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  	return false;

  return true;
  
}
</script>

<script>
//Ticket Module List Ajax
function ticket_module_list(a){
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
    
    var queryString="?ticket_type="+encodeURIComponent(a);
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/itc/ticket_module_list_ajax" + queryString,true);
    xmlhttp.send();
}

//Ticket Issue List Ajax
function ticket_issue_list(b){
    //Ajax
    $("#detail_issue").empty().html('<img src="<?php echo base_url(); ?>assets/images/wait.gif" />');
    
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 

    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById('detail_issue').innerHTML=xmlhttp.responseText;
    }

    }
    
    var queryString="?ticket_module_id="+encodeURIComponent(b);
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/itc/ticket_issue_list_ajax" + queryString,true);
    xmlhttp.send();
}
</script>