<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Rights Add Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <?php
        $right_id = $_REQUEST['id'];
        if($right_id != ''){
            foreach($get_by_id->result() as $row){
                $rgt_user_name = $row->user_name;
            }
        } else {
            $rgt_user_name = "";
        }
    ?>
    
    <div class="row" style="text-align:center">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Rights Add Form
            </header>
            <form class="form-horizontal " method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/dbuserc/UserRightEntry">
                <div class="panel-body">

                    <div class="form-group">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-1"><b>Select User</b></div>
                        <div class="col-sm-3">
                            <select id="user_id" name="user_id" class="form-control" onchange="right_div(this.value);" required>
                                <?php if($right_id != ""){ ?>
                                <option value="<?=$right_id;?>"><?=$rgt_user_name;?></option>
                                <?php } ?>

                                <option value="">--Select--</option>
                                <?php
                                    $sql_user = "select * from login where emp_active = 'yes'";
                                    $qry_user = $this->db->query($sql_user);
                                    foreach($qry_user->result() as $row){
                                        $name = $row->name;
                                        $user_id = $row->id;
                                        $emp_id = $row->emp_id;
                                ?>
                                <option value="<?=$user_id;?>"><?=$emp_id;?> - <?=$name;?></option>
                                <?php        
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>

                    <div id="ajax_div"></div>
                    
                    <div class="form-group">
                        <div class="col-sm-5"></div>
                        <div class="col-sm-2">
                            <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
                        </div>
                        <div class="col-sm-5"></div>
                    </div>

                </div>
            </form>
        </section>
        </div>
    </div>

  </section>
</section>

<script>
    //Select 2 Function
    $( function(){
        $("#user_id").select2();
    });

    //Ajax Function
    function right_div(user_id){
        if(user_id != ""){
            $("#ajax_div").empty().html('<img src="<?php echo base_url(); ?>assets/images/loading.gif" width="317px" height="58px"/>');
            if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();	
            } else {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");	
            }
            
            xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById('ajax_div').innerHTML=xmlhttp.responseText;
                } 
            }

            var qryStr = "?user_id="+user_id;
                
            xmlhttp.open("GET","<?php echo base_url(); ?>index.php/dbuserc/userrightajax"+ qryStr,true);    	
            xmlhttp.send();	
        }    
    }    


    function checkAll(ele) {
        var checkboxes = document.getElementsByTagName('input');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                console.log(i)
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }
</script>
<!-- Trigger -->
<script type="text/javascript"> $(document).ready(function(){ right_div('<?php echo $right_id; ?>'); }); </script>