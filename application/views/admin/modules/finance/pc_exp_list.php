<!-- DATA TABLES -->
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css" rel="stylesheet" type="text/css" />
<style>
    div.container { max-width : 1200px; }
</style>


<?php 
    $username = $_SESSION['username'];

    $sql_user_det = "select * from login where username = '$username'";
    $qry_user_det = $this->db->query($sql_user_det)->row();
    $role = $qry_user_det->role; 
?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Petty Cash Expense List</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-8"></div>
        <div class="col-lg-2">
            <button class="form-control" onclick="location.reload();"><i class="fa fa-refresh"></i> Refresh</button>
        </div>

        <div class="col-lg-2">
            <a href="<?php echo base_url(); ?>index.php/financec/pc_exp_add?id=">
                <input type="button" class="form-control" value="Add New">
            </a>
        </div>
    </div><br>

    <?php /*
    <div class="row">
        <div class="col-lg-1"><b>Filter:</b></div>
        <div class="col-lg-1"><b>From Date:</b></div>
        <div class="col-lg-2"><input type="" id="from_dt" name="from_dt" class="form-control"></div>
        <div class="col-lg-1"><b>To Date:</b></div>
        <div class="col-lg-2"><input type="" id="to_dt" name="to_dt" class="form-control"></div>
        <div class="col-lg-1"><b>Status:</b></div>
        <div class="col-lg-2">
            <select id="status" name="status" class="form-control">
                <option value="">--Select--</option>
                <?php
                    $sql_status = "select pc_status_name from petty_cash_status";
                    $qry_status = $this->db->query($sql_status);
                    foreach($qry_status->result() as $row){
                ?>
                <option value="<?=$row->pc_status_name;?>"><?=$row->pc_status_name;?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-lg-2"><input type="button" class="form-control" value="Search" onclick="filter()"></div>
    </div><br>
    */ ?>

    <div class="row">
        <div class="box-body table-responsive" id="detail">
            <table class="table table-bordered" id="example1" style="margin-top:60px">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Employee Name</th>
                        <th>Balance Amount</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Edit</th>
                        <th>Approval</th>
                </thead>
                <tbody>
                    <?php
                        $sql_inq = "select * from petty_cash_exp_mst order by pcexp_id desc";
                        $qry_inq = $this->db->query($sql_inq);
                        $sno=0;
                        foreach($qry_inq->result() as $row){
                            $sno++;
                            $pcexp_status = $row->pcexp_status;
                    ?>
                    <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo $row->pcexp_empname; ?></td>
                        <td><?php echo $row->pcexp_balamt; ?></td>
                        <td><?php echo $row->pcexp_tot_amt; ?></td>
                        <td><?php echo $row->pcexp_status; ?></td>
                        <td><?php echo $row->created_date; ?></td>
                        <td>
                            <?php if($pcexp_status != "Approved"){ ?>
                                <a href="<?php echo base_url();?>index.php/financec/pc_exp_add?id=<?php echo $row->pcexp_id; ?>">
                                    <i class="fa fa-pencil">Edit</i>
                                </a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($pcexp_status != "Approved"){ ?>
                                <a href="<?php echo base_url();?>index.php/financec/pc_exp_app?id=<?php echo $row->pcexp_id; ?>">
                                    <i class="fa fa-pencil">Approval</i>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>  
    </div><br /><br />
        
  </section>
</section>

<!-- DATA TABES SCRIPT -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

<script type="text/javascript">
    //Data TAble
    $(document).ready(function() {
        var table = $('#example1').DataTable( {
            responsive: true,
            paging: true
        } );
    
        new $.fn.dataTable.FixedHeader( table );
    } );
</script>

<script type="text/javascript">
$( function() {
    $( "#from_dt" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );

$( function() {
    $( "#to_dt" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );
</script>

<script type="text/javascript">
    function filter(){
        var from_dt = document.getElementById("from_dt").value;
        var to_dt = document.getElementById("to_dt").value;
        var status = document.getElementById("status").value;

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
                $('#example1').dataTable();
            }
        }
        
        var queryString="?from_dt="+encodeURIComponent(from_dt)+"&to_dt="+encodeURIComponent(to_dt)+"&status="+encodeURIComponent(status);
        
        xmlhttp.open("GET","<?php echo base_url(); ?>index.php/crmc/inquiry_list_ajax" + queryString, true);
        xmlhttp.send();
    }
</script>