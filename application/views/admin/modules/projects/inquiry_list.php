<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Inquiry List</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-10"></div>
        <div class="col-lg-2">
            <a href="<?php echo base_url(); ?>index.php/projectsc/inquiry_form?inq_no=">
                <button class="form-control">
                    <i class="fa fa-plus"></i> Add Inquiry
                </button>
            </a>
        </div>
    </div><br />
    
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SNo.</th>
                        <th>Inquiry No</th>
                        <th>Inquiry Received By</th>
                        <th>Inquiry Received On</th>
                        <th>Inquiry For</th>
                        <th>Assigned To</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql_enq = "select * from inq_mst";
                        $qry_enq = $this->db->query($sql_enq);
                        $sno=0;
                        foreach($qry_enq->result() as $row){
                            $sno++;
                    ?>
                    <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo $row->inq_no; ?></td>
                        <td><?php echo $row->inq_rec_by; ?></td>
                        <td><?php echo $row->inq_rec_on; ?></td>
                        <td><?php echo $row->inq_turnkey_sol; ?></td>
                        <td><?php echo $row->inq_lead_owner; ?></td>
                        <td>
                            <!-- Edit Enquiry -->
                            <a href="<?php echo base_url();?>index.php/projectsc/inquiry_form?inq_no=<?php echo $row->inq_no; ?>">
                                <i class="fa fa-edit"></i> Edit
                            </a><br>
                            <!-- Add Contacts -->
                            <a href="<?php echo base_url();?>index.php/projectsc/inquiry_add_contacts?inq_no=<?php echo $row->inq_no; ?>">
                                <i class="fa fa-user"></i> Add Contacts
                            </a>
                        </td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
  </section>
</section>