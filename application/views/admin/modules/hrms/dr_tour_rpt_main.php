<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>DR Tour Report</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row" style="text-align:center">
        <div class="col-lg-1"><b>From Date:</b></div>
        <div class="col-lg-2"><input type="text" id="from_date" name="from_date" value="" class="form-control" required></div>
        <div class="col-lg-1"><b>To Date:</b></div>
        <div class="col-lg-2"><input type="text" id="to_date" name="to_date" value="" class="form-control" required></div>
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

//Date Picker
$( function() {
    $( "#from_date" ).datepicker({
        "dateFormat" : "yy-mm-dd",
    });
} );

$( function() {
    $( "#to_date" ).datepicker({
        "dateFormat" : "yy-mm-dd",
    });
} );

//Ajax Filter
function filter(){
	var card_no = document.getElementById("card_no").value;
	var from_date = document.getElementById("from_date").value;
	var to_date = document.getElementById("to_date").value;

    if(from_date == ""){
        alert("Please select From Date.");
        document.getElementById("from_date").focus();
        return false;
    }

    if(to_date == ""){
        alert("Please select To Date.");
        document.getElementById("to_date").focus();
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
    
    var queryString="?card_no="+encodeURIComponent(card_no)+"&from_date="+encodeURIComponent(from_date)+"&to_date="+encodeURIComponent(to_date);
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/hrmsc/dr_tour_rpt_ajax" + queryString,true);
    xmlhttp.send();
}

</script>