<?php 
    $username = $_SESSION['username'];
    if($username == ""){
        $url = base_url()."index.php/logout";
        redirect($url);
    }

    $sql_user_det = "select * from login where username = '".$username."'";
    $qry_user_det = $this->db->query($sql_user_det)->row();
    $role_ses = $qry_user_det->role;

    ?>

<?php
    $user_id = $_REQUEST['id'];
    if($user_id !=""){
        $sql_user_det = "select * from login where id = '$user_id'";
        $qry_user_det = $this->db->query($sql_user_det)->row();
        $email = $qry_user_det->email;
        $password = $qry_user_det->password;
        $username = $qry_user_det->username;
        $name = $qry_user_det->name;
        $dob = $qry_user_det->dob;
        $mob_no = $qry_user_det->mob_no;
        $role = $qry_user_det->role;
        $emp_active = $qry_user_det->emp_active;
        $dept = $qry_user_det->dept;
        $emp_comp = $qry_user_det->emp_comp;
        $emp_id = $qry_user_det->emp_id;
    } else {
        $email = "";
        $password = "";
        $username = "";
        $name = "";
        $dob = "";
        $mob_no = "";
        $role = "";
        $emp_active = "";
        $dept = "";  
        $emp_comp = "";
        $emp_id = "";
    }
?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>User Register</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    <form action="<?php echo base_url(); ?>index.php/dbuserc/RegisterUser" method="post">
        <!-- Hidden Id's -->
        <input type="hidden" id="id" name="id" value="<?php echo $user_id; ?>">
        <div class="row" style="text-align:center">
            <div class="col-lg-3"></div>
            <div class="col-lg-3"><h4>Employee ID</h4></div>
            <div class="col-lg-3">
            <?php if($role_ses == "Admin"){ ?>
                <input type="text" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>" class="form-control" autocomplete="none" required>
                <?php } else { ?>
                    <input type="text" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>" class="form-control" autocomplete="none" readonly>
                <?php } ?>
            </div>
            <div class="col-lg-3"></div>   
        </div><br /><br />

        <div class="row" style="text-align:center">
            <div class="col-lg-3"></div>
            <div class="col-lg-3"><h4>Email</h4></div>
            <div class="col-lg-3">            
                <input type="text" id="email" name="email" value="<?php echo $email; ?>" class="form-control" autocomplete="none" required>
            </div>
            <div class="col-lg-3"></div>   
        </div><br /><br />

        <div class="row" style="text-align:center">
            <div class="col-lg-3"></div>
            <div class="col-lg-3"><h4>Name</h4></div>
            <div class="col-lg-3">
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" class="form-control" autocomplete="none" required>
            </div>
            <div class="col-lg-3"></div>   
        </div><br /><br />

        <div class="row" style="text-align:center">
            <div class="col-lg-3"></div>
            <div class="col-lg-3"><h4>Password</h4></div>
            <div class="col-lg-3"><input type="password" id="pass" name="pass" value="" class="form-control" autocomplete="none" required></div>
            <div class="col-lg-3"></div>   
        </div><br /><br />

        <div class="row" style="text-align:center">
            <div class="col-lg-3"></div>
            <div class="col-lg-3"><h4>Username</h4></div>
            <div class="col-lg-3">        
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" autocomplete="none" class="form-control" <?php if($username != ""){ echo "readonly"; } ?> required>
            </div>
            <div class="col-lg-3"></div>   
        </div><br /><br />

        <div class="row" style="text-align:center">
            <div class="col-lg-3"></div>
            <div class="col-lg-3"><h4>Date Of Birth</h4></div>
            <div class="col-lg-3">            
                <input type="text" id="dob" name="dob" value="<?php echo $dob; ?>" class="form-control" autocomplete="none" required>
            </div>
            <div class="col-lg-3"></div>   
        </div><br /><br />

        <div class="row" style="text-align:center">
            <div class="col-lg-3"></div>
            <div class="col-lg-3"><h4>Mobile Number</h4></div>
            <div class="col-lg-3">
                <input type="text" id="mob_no" name="mob_no" value="<?php echo $mob_no; ?>" class="form-control" autocomplete="none" required>
            </div>
            <div class="col-lg-3"></div>   
        </div><br /><br />

        <div class="row" style="text-align:center">
            <div class="col-lg-3"></div>
            <div class="col-lg-3"><h4>Role</h4></div>
            <div class="col-lg-3">
                <?php if($role_ses == "Admin"){ ?>
                    <select id="role" name="role" class="form-control" required>
                        <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                        <option value="">--select--</option>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                        <option value="Management">Management</option>
                    </select>
                <?php } else { ?>
                    <select id="role" name="role" class="form-control" required>
                        <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                    </select>
                <?php } ?>
            </div>
            <div class="col-lg-3"></div>   
        </div><br /><br />

        <div class="row" style="text-align:center">
            <div class="col-lg-3"></div>
            <div class="col-lg-3"><h4>Department</h4></div>
            <div class="col-lg-3">
                <?php if($role_ses == "Admin"){ ?>
                    <select id="dept" name="dept" class="form-control" required>
                        <option value="<?php echo $dept; ?>" selected>
                        <?php
                            $sql_dept_name = "select * from dept_mst where dept_id = '".$dept."'";
                            $qry_dept_name = $this->db->query($sql_dept_name)->row();
                            echo $dept_name = $qry_dept_name->dept_name;
                        ?>
                        </option>
                        <option value="">--select--</option>
                        <?php 
                            $sql_dept = "select * from dept_mst";
                            $qry_dept = $this->db->query($sql_dept);
                            foreach($qry_dept->result() as $row){
                                $dept_id = $row->dept_id;
                                $dept_name = $row->dept_name;
                        ?>
                        <option value="<?=$dept_id;?>"><?=$dept_name;?></option>
                        <?php
                            }
                        ?>
                    </select>
                <?php } else { ?>
                    <select id="dept" name="dept" class="form-control" required>
                        <option value="<?php echo $dept; ?>" selected>
                        <?php
                            $sql_dept_name = "select * from dept_mst where dept_id = '".$dept."'";
                            $qry_dept_name = $this->db->query($sql_dept_name)->row();
                            echo $dept_name = $qry_dept_name->dept_name;
                        ?>
                        </option>
                    </select>
                <?php } ?>
            </div>
            <div class="col-lg-3"></div>   
        </div><br /><br />

        <div class="row" style="text-align:center">
            <div class="col-lg-3"></div>
            <div class="col-lg-3"><h4>Company</h4></div>
            <div class="col-lg-3">
                <?php if($role_ses == "Admin"){ ?>
                    <select id="emp_comp" name="emp_comp" class="form-control" required>
                        <option value="<?php echo $emp_comp; ?>"  selected>
                        <?php
                            $sql_comp_name = "select * from company_mst where company_id = '".$emp_comp."'";
                            $qry_comp_name = $this->db->query($sql_comp_name)->row();
                            echo $company_name = $qry_comp_name->company_name;
                        ?>
                        </option>
                        <option value="">--select--</option>
                        <?php 
                            $sql_comp = "select * from company_mst";
                            $qry_comp = $this->db->query($sql_comp);
                            foreach($qry_comp->result() as $row){
                                $company_id = $row->company_id;
                                $company_name = $row->company_name;
                        ?>
                        <option value="<?=$company_id;?>"><?=$company_name;?></option>
                        <?php
                            }
                        ?>
                    </select>
                <?php } else { ?>
                    <select id="emp_comp" name="emp_comp" class="form-control" required>
                        <option value="<?php echo $emp_comp; ?>"  selected>
                        <?php
                            $sql_comp_name = "select * from company_mst where company_id = '".$emp_comp."'";
                            $qry_comp_name = $this->db->query($sql_comp_name)->row();
                            echo $company_name = $qry_comp_name->company_name;
                        ?>
                        </option>
                    </select>
                <?php } ?>
            </div>
            <div class="col-lg-3"></div>   
        </div><br /><br />

        <div class="row" style="text-align:center">
            <div class="col-lg-3"></div>
            <div class="col-lg-3"><h4>Employee Active</h4></div>
            <div class="col-lg-3">
                <?php if($role_ses == "Admin"){ ?>
                    <select id="emp_active" name="emp_active" class="form-control" required>                    
                        <option value="<?php echo $emp_active; ?>" selected><?php echo $emp_active; ?></option>
                        <option value="">---select---</option>
                        <option value="yes">yes</option>
                        <option value="no">no</option>
                    </select>
                <?php } else { ?>
                    <select id="emp_active" name="emp_active" class="form-control" required>  
                        <option value="<?php echo $emp_active; ?>" selected><?php echo $emp_active; ?></option>
                    </select>
                <?php } ?>
            </div>
            <div class="col-lg-3"></div>   
        </div><br /><br />

        <div class="row" style="text-align:center">
            <div class="col-lg-5"></div>
            <div class="col-lg-2"><input type="submit" id="submit" name="submit" value="Submit" class="form-control"></div>
            <div class="col-lg-5"></div>   
        </div><br /><br />
    </form>

  </section>
</section>