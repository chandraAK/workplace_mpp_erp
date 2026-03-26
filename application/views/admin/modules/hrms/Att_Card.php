<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Attendance Card</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row" style="text-align:center">
    	<div class="col-lg-1"><b>Month:</b></div>
    	<div class="col-lg-2"><select id="att_month" name="att_month" class="form-control"><?php echo month();?></select></div>
    	<div class="col-lg-1"><b>Year:</b></div>
        <div class="col-lg-2"><select id="att_year" name="att_year" class="form-control"><?php echo year();?></select></div>
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
    var att_month = document.getElementById("att_month").value;
	var att_year = document.getElementById("att_year").value;
	var card_no = document.getElementById("card_no").value;
    
    if(att_month == ""){
        alert("Please select Month.");
        document.getElementById("att_month").focus();
        return false;
    }

    if(att_year == ""){
        alert("Please select Year.");
        document.getElementById("att_year").focus();
        return false;
    }

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
    
    var queryString="?att_month="+encodeURIComponent(att_month)+"&att_year="+encodeURIComponent(att_year)+"&card_no="+encodeURIComponent(card_no);
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/hrmsc/Att_Card_Ajax" + queryString,true);
    xmlhttp.send();
}

</script>