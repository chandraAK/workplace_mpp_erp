<html>
<head>
</head>

<?php $db2 = $this->load->database('db2', TRUE);
$this->load->helper("sales"); ?>
                                 
<section id="main-content">
  <section class="wrapper"> 
    <div class="row" >
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Pending Payment Dashboard</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row" style="align:center">
        <div class="col-lg-12"></div>
    </div><br><br>    
   
  <div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="info-box blue-bg">            
            <div class="count"><?php //echo pending_payment();?>  200000      
            </div>
            <div class="title"><a href="" style="color:white";>
            Total Outstanding
            </a></div>
          </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="info-box blue-bg">
            <a href="<?php echo base_url(); ?>index.php/salesc/sales_overdue" style="color:white";>
            <div class="count"><?php// echo get_overdue_till_today(); ?>100000 </div>          
            <div class="title" ><a href="" style="color:white";> 
            Total Overdue Till Today</a></div>
          </div>
        </div> 
               
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="info-box blue-bg">          
            <a href="<?php echo base_url(); ?>index.php/salesc/sales_overdue" style="color:white;"> 
            <div class="count"><?php// echo overdue_for_the_day(); ?>200000</div>                    
            
            <div class="title" ><a href="" style="color:white";>
            Total Overdue Today</a></div>
          </div>
        </div>
  </div>
          <!-- <div class="column">
              <p><div class="panel-body text-center" >
                <canvas id="pie" height="268" width="358" style="width: 450px; height: 300px;"></canvas>
                </div>
               </p>
          </div> -->        
    <!--/.col-->
   
       <div>
      <div class="row">
        <div class="col-lg-12">
            <div class="title"><h4>Total Overdue-Product Category Wise</h4></div>
          </div>
       </div>
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <a href="#" target="_blank">
        <div class="info-box brown-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/salesc/product_overdue_list?category=Paper Cup" style="color:white;">
            <div class="count"><?php //echo get_overdue_cat_wise("Paper Cup");?>2000</div>
            <div class="title">Paper Cup</div>
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->
        
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <a href="#" target="_blank">
        <div class="info-box brown-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/salesc/product_overdue_list?category=Paper Blank" style="color:white;">
            <div class="count"><?php //echo get_overdue_cat_wise("Paper Blank");?>2000</div>
            <div class="title">Paper Blank</div>
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <a href="#" target="_blank">
        <div class="info-box brown-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/salesc/product_overdue_list?category=Paper Plate and Bowl" style="color:white;">
            <div class="count"><?php //echo get_overdue_cat_wise("Paper Plate and Bowl");?>2000</div>
            <div class="title">Paper Plate and Bowl</div>
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      </div>
      <!--/.col-->
      <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <a href="#" target="_blank">
        <div class="info-box brown-bg ">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/salesc/product_overdue_list?category=Paper Cup Machines" style="color:white;">
            <div class="count"><?php //echo get_overdue_cat_wise("Paper Cup Machines");?>2000</div>
            <div class="title">Paper Cup Machines</div>
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->      
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <a href="#" target="_blank">
        <div class="info-box brown-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/salesc/product_overdue_list?category=Paper Cup Mould" style="color:white;">
          <div class="count"><?php //echo get_overdue_cat_wise("Paper Cup Mould");?>2000</div>
          <div class="title">Paper Cup Mould</div>
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <a href="#" target="_blank">
        <div class="info-box brown-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/salesc/product_overdue_list?category=Paper Reel" style="color:white;">
            <div class="count"><?php// echo get_overdue_cat_wise("Paper Reel");?>2000</div>
            <div class="title">Paper Reel</div>
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      </div>
      <!--/.col-->
      <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <a href="#" target="_blank">
        <div class="info-box brown-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/drc/product_overdue_list?category=Paper Plate Machines" style="color:white;">
            <div class="count"><?php //echo get_overdue_cat_wise("Paper Plate Machines");?>2000</div>
            <div class="title">Paper Plate Machines</div>
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      </div>
      <!--/.col-->
      
      </div>
      <div class="row" style="align:center">
        <div class="col-lg-12"></div>
    </div><br><br>    
      <div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="info-box blue-bg">
            <a href="<?php echo base_url(); ?>index.php/salesc/dr_pend_pay_filter" style="color:white";>
            <div class="count"><?php //echo get_overdue_till_today();      
                        ?>   2000     
            </div>
            <div class="title">Overdue Party Wise</div>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="info-box blue-bg">
            <a href="<?php echo base_url(); ?>index.php/salesc/sales_overdue" style="color:white";>
            <div class="count"><?php //echo get_overdue_so_wise(); ?>2000  </div>          
            <div class="title" > Overdue SO Wise</div>
            </a>
          </div>
        </div> 
    <!--/.info-box-->
      </div>
      <div>
      <!--/.col-->
   
    
  </section>
</section>


<!-- <script type="text/javascript">
        window.onload = function() {
            var dps = []; //dataPoints. 

            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Accepting DataPoints from User Input"
                },
                data: [{
                    type: "pie",
                    dataPoints: dps
                }]
            });

    
            function addDataPointsAndRender() {
                xValue = Number(document.getElementById("out_today").value);
                yValue = Number(document.getElementById("ovrdue_today").value);
                zValue = Number(document.getElementById("ovrdue_fr_today").value);
                dps.push({
                    x: xValue,
                    y: yValue
                });
                chart.render();
            }

            var renderButton = document.getElementById("renderButton");
            renderButton.addEventListener("click", addDataPointsAndRender);
        }
    </script>
     --><!-- 
     <script>
     function drawChart() {

// Create the data table.
var data = new google.visualization.DataTable();
data.addColumn('string', 'pending payments');
data.addColumn('number', 'value');

data.addRows([
  ['total outstanding', 	6810244.35],
  ['total overdue till today', 233099248.05],
  ['total overdue for today',300000.54],
 
]);

// Set chart options
var options = {'title':'Pending Payments',
              'titleAlign': 'center',
               'align':'center',
               'width':300,
               'height':400,
              'align':'center'
              };

// Instantiate and draw our chart, passing in some options.
var chart = new google.visualization.PieChart(document.getElementById('pie'));
chart.draw(data, options);
}
</script>
<script>
// Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

    </script> -->
    <!-- <script>
    var data = [ [ "Total Outstanding", 100000 ], [ "Total Overdue Till Today",30000 ], [ "Total Overdue For The Day", 2000 ]]; 
var colors = [ "blue", "red", "yellow" ]; 
 
var canvas = document.getElementById( "pie" ); 
var context = canvas.getContext( "2d" ); 
 
// get length of data array 
var dataLength = data.length; 
// declare variable to store the total of all values 
var total = 0; 
 
// calculate total 
for( var i = 0; i < dataLength; i++ ){ 
    // add data value to total 
    total += data[ i ][ 1 ]; 
} 
 
// declare X and Y coordinates of the mid-point and radius 
var x = 100; 
var y = 100; 
var radius = 100; 
 
// declare starting point (right of circle) 
var startingPoint = 0; 
 
for( var i = 0; i < dataLength; i++ ){ 
    // calculate percent of total for current value 
    var percent = data[ i ][ 1 ] * 100 / total; 
 
    // calculate end point using the percentage (2 is the final point for the chart) 
    var endPoint = startingPoint + ( 2 / 100 * percent ); 
 
    // draw chart segment for current element 
    context.beginPath();    
    // select corresponding color 
    context.fillStyle = colors[ i ]; 
    context.moveTo( x, y ); 
    context.arc( x, y, radius, startingPoint * Math.PI, endPoint * Math.PI );     
    context.fill(); 
 
    // starting point for next element 
    startingPoint = endPoint;  
  
    // draw labels for each element 
    context.rect( 220, 25 * i, 15, 15 ); 
    context.fill(); 
    context.fillStyle = "black"; 
    context.fillText( data[ i ][ 0 ] + " (" + data[ i ][ 1 ] + ")", 245, 25 * i + 15 ); 
}  
  
// draw title 
context.font = "15px tahoma"; 
context.textAlign = "center"; 
context.fillText( "Pending Payments", 100, 225 );

</script>
 -->