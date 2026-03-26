<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Employee Details</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row" style="text-align:center">
    	<div class="col-lg-1"><b>Card No:</b></div>
        <div class="col-lg-2"><select id="card_no" name="card_no" class="form-control"><?php echo CardNo();?></select></div>
        <div class="col-lg-1"><input type="button" id="submit" name="submit" value="Submit" class="form-control" onClick="filter()"></div>
        <div class="col-lg-2"></div>
    </div><br><br>

    <div id="detail"></div>

  </section>
</section>

<script>
//Select2
$(function(){
    $("#card_no").select2();
});

//Ajax Filter
function filter(){
    var card_no = document.getElementById("card_no").value;
    
    if(card_no == ""){
        alert("Please select CardNo.");
        document.getElementById("card_no").focus();
        return false;
    }

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
    
    var queryString="?card_no="+encodeURIComponent(card_no);
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/hrmsc/emp_det_ajax" + queryString,true);
    xmlhttp.send();
}

</script>