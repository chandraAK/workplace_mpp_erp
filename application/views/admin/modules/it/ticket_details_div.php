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
<input type="hidden" id="ticket_id" name="ticket_id" value="<?php echo $ticket_id; ?>">


<div class="form-group" style="text-align:left">
    <div class="col-sm-12"><h4>Ticket Details</h4></div>
</div>

<div class="form-group" style="text-align:left">
    <div class="col-sm-3"><b>Ticket Created By</b><br><?php echo $created_by; ?></div>
    <div class="col-sm-3"><b>Ticket Created Date</b><br><?php echo substr($created_date,0,11); ?></div>
    <div class="col-sm-3"><b>Ticket Severity</b><br><?php echo $ticket_sev_name; ?></div>
    <div class="col-sm-3"><b>Ticket Type</b><br><?php echo $ticket_type_name; ?></div>
</div>

<div class="form-group" style="text-align:left">
    <div class="col-sm-3"><b>Ticket Module</b><br><?php echo $ticket_module_name; ?></div>
    <div class="col-sm-3"><b>Ticket Issue Type</b><br><?php echo $ticket_issue_name; ?></div>
</div>

<div class="form-group" style="text-align:left">
    <div class="col-sm-3"><b>User Issue</b><br><?php echo $ticket_issue_desc; ?></div>
    <div class="col-sm-3"><b>User Remedy</b><br><?php echo $ticket_remedy; ?></div>
    <div class="col-sm-3"><b>User Comments</b><br><?php echo $ticket_comments; ?></div>
</div>

<div class="form-group" style="text-align:left">
    <div class="col-sm-12"><h4>Assign Details</h4></div>
</div>

<div class="form-group" style="text-align:left">
    <div class="col-sm-3"><b>Assign Remarks</b><br><?php echo $ticket_rmks_assign; ?></div>
    <div class="col-sm-3"><b>Assign By</b><br><?php echo $ticket_assigned_by; ?></div>
    <div class="col-sm-3"><b>Assign Date</b><br><?php echo $ticket_assigned_date; ?></div>
</div>

<div class="form-group" style="text-align:left">
    <div class="col-sm-12"><h4>Resolution Details</h4></div>
</div>


<div class="form-group" style="text-align:left">
    <div class="col-sm-3"><b>Resolution Given</b><br><?php echo $ticket_open_rg; ?></div>
    <div class="col-sm-3"><b>Resolution Remarks</b><br><?php echo $ticket_open_rmks; ?></div>
    <div class="col-sm-3"><b>Resolution Action</b><br><?php echo $ticket_open_act; ?></div>
    <div class="col-sm-3"><b>Resolution By</b><br><?php echo $ticket_open_act_by; ?></div>
</div>

<div class="form-group" style="text-align:left">
    <div class="col-sm-12"><h4>Pending Clarification Details</h4></div>
</div>

<div class="form-group" style="text-align:left">
    <div class="col-sm-3"><b>Pending Clarification Remarks</b><br><?php echo $ticket_pc_rmks; ?></div>
    <div class="col-sm-3"><b>Pending Clarification Action</b><br><?php echo $ticket_pc_act; ?></div>
    <div class="col-sm-3"><b>Pending Clarification By</b><br><?php echo $ticket_pc_act_by; ?></div>
</div>