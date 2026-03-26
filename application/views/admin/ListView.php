<!-- DATA TABLES -->
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css" rel="stylesheet" type="text/css" />

<style>
div.container { max-width : 1200px; }
@page { size: auto;  margin: 0mm; }
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
            <h3><i class="fa fa-laptop"></i><?php echo $list_title; ?></h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-10"></div>
        <div class="col-lg-2">
            <a href="<?php echo base_url(); ?>index.php/<?php echo $edit_url; ?>?id=">
                <input type="button" class="form-control" value="Add New">
            </a>
        </div>
    </div><br>

    <div class="row">
        <div class="col-lg-9"><h4><?php echo $list_title; ?></h4></div>
        <div class="col-lg-1">
            <button onclick="tableToExcel('example1', 'W3C Example Table')" class="form-control">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i> 
            </button>
        </div>
        <div class="col-lg-1">
            <button onclick="printDiv('printableArea')" class="form-control">
                <i class="fa fa-file-pdf-o" aria-hidden="true"></i> 
            </button>
        </div>
        <div class="col-lg-1">
            <button onclick="printDiv('printableArea')" class="form-control">
                <i class="fa fa-print" aria-hidden="true"></i> 
            </button>
        </div>
    </div>

    
    <div class="row">
        <div class="box-body table-responsive">
        <div id="printableArea">
            <table class="table table-bordered" id="example1" style="margin-top:60px">
                <thead>
                    <tr style="background-color:#33f9ff">
                        <th>sno</th>
                        <?php 
                            $column_nm_arr = array();
                            foreach($ViewHead->result() as $row){
                                $column_name = $row->Field;
                                array_push($column_nm_arr,$column_name)
                        ?>
                        <th><?php echo $column_name; ?></th>
                        <?php } ?>
                        <?php
                            if($edit_enable == 'yes'){
                                echo "<th>Edit</th>";
                            } 
                        ?>
                        <?php
                            if($another_link_enable == 'yes'){
                                echo "<th>".$another_link_name."</th>";
                            } 
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $count_arr = count($column_nm_arr);
                        $col_str = "";
                        for($i=0; $i<$count_arr; $i++){
                            $column_nm_arr[$i];

                            if($i == 0){
                                $col_str = $column_nm_arr[$i];
                            } else {
                                $col_str = $col_str.", ".$column_nm_arr[$i];
                            }

                        }

                        if($role == "Admin" || $role == "Management"){
                            if($where_str != ""){
                                $sql = "select $col_str from $tbl_nm $where_str"; 
                            } else {
                                $sql = "select $col_str from $tbl_nm"; 
                            }

                        } else {
                            if($where_str != ""){
                                $sql = "select $col_str from $tbl_nm $where_str"; 
                            } else {
                                $sql = "select $col_str from $tbl_nm $where_str"; 
                            }
                        }
                        //echo $sql; die;

                        $qry = $this->db->query($sql);
                          $sno = 0;
                        foreach($qry->result() as $row){
                            $sno++;
                    ?>
                    <tr>
                        <td><?=$sno;?></td>
                        <?php
                        for($j=0; $j<$count_arr; $j++){
                            echo "<td>".$row->{$column_nm_arr[$j]}."</td>";
                        }
                        ?>
                        <!--- Edit -->
                        <?php
                            if($edit_enable == 'yes'){
                        ?>
                            <td>
                                <a href="<?php echo base_url(); ?>index.php/<?php echo $edit_url; ?>?id=<?php echo $row->{$primary_col}; ?>">
                                    <i class="fa fa-pencil">Edit</i>
                                </a>
                            </td>
                        <?php
                            } 
                        ?>
                        <!--- Another Link -->
                        <?php
                            if($another_link_enable == 'yes'){
                        ?>
                            <td>
                                <a href="<?php echo base_url(); ?>index.php/<?php echo $another_link; ?>?id=<?php echo $row->{$primary_col}; ?>">
                                    <i class="fa fa-pencil"><?php echo $another_link_name; ?></i>
                                </a>
                            </td>
                        <?php
                            } 
                        ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div> 
        </div> 
    </div><br /><br />
        
  </section>
</section>

<!-- DATA TABES SCRIPT -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

<script type="text/javascript">  
    $(document).ready(function() {
        var table = $('#example1').DataTable( {
            responsive: true,
            paging: true
        } );
    
        new $.fn.dataTable.FixedHeader( table );
    } );
</script>

<!-- Print Commands -->
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

<script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})();
</script>