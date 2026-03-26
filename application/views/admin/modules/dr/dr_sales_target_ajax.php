<!--- Added By Charu - 202011180953 -->
<div class="table-wrapper">
   <div class="table-title">
      <div class="row">
         <div class="col-sm-12" style="text-align:center">
            <h3><b>Monthly Sales Target</b></h3>
         </div>
      </div>
   </div><br>
   <?php 
  
   ?>

   <div class="form-group">
      <label class="col-sm-2 control-label" style="align:left">Dispatch Amount:</label>
      <div class="col-sm-10">
         <input type="text" id="dr_sales_dispch_amt" name="dr_sales_dispch_amt" value="" class="form-control" onkeypress = "return isNumberKey(event);" required>
      </div>
   </div>

   <div class="form-group">
      <label class="col-sm-2 control-label" style="align:left">Machine Sales Amount:</label>
      <div class="col-sm-10">
         <input type="text" id="dr_sales_mach_amt" name="dr_sales_mach_amt" value="" class="form-control" onkeypress = "return isNumberKey(event);" required>
      </div>
   </div>

   <div class="form-group">
      <label class="col-sm-2 control-label" style="align:left">customer Payment Amount:</label>
      <div class="col-sm-10">
         <input type="text" id="dr_sales_pur_amt" name="dr_sales_pur_amt" value="" class="form-control" onkeypress = "return isNumberKey(event);" required>
      </div>
   </div>

   <div class="form-group">
      <label class="col-sm-2 control-label" style="align:left">Order Booking Amount:</label>
      <div class="col-sm-10">
         <input type="text" id="dr_sales_ord_amt" name="dr_sales_ord_amt" value="" class="form-control" onkeypress = "return isNumberKey(event);" required>
      </div>
   </div>

   <div class="form-group">
      <div class="col-sm-4"></div>
      <div class="col-sm-4">
         <input type="submit" id="submit" name="submit" value="Submit" class="form-control">
      </div>
      <div class="col-sm-4"></div>
   </div>

</div>
//Restricting Only to insert Numbers
<script>
function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  	return false;

  return true;
  
}
</script>
<!-- Ends Charu -->
                
                