<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Module Add Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <?php
        $id = $_REQUEST['id'];

        if($id != ""){
            $sql ="select * from menu_cat_mst where id = '$id'";
            $qry = $this->db->query($sql)->row();

            $category = $qry->category;
            $parent = $qry->parent;
            $url = $qry->url;
            $use_base_url = $qry->use_base_url;

            $sql_parent_name = "select category from menu_cat_mst where id = '".$parent."'";
            $qry_parent_name = $this->db->query($sql_parent_name)->row();
            $parent_cat_name = $qry_parent_name->category;
        } else {
            $category = "";
            $parent = "";
            $url = "";
            $use_base_url = "";
            $parent_cat_name = "";
        }
    ?>
    
    <div class="row" style="text-align:center">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Module Add Form
            </header>
            <form class="form-horizontal " method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/dbuserc/module_entry">
                <div class="panel-body">

                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />

                    <div class="form-group">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-1"><b>Module Name</b></div>
                        <div class="col-sm-3">
                            <input type="text" id="module_name" name="module_name" value="<?=$category;?>" class="form-control">
                        </div>
                        <div class="col-sm-4"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-1"><b>Select Parent</b></div>
                        <div class="col-sm-3">
                            <select id="parent_id" name="parent_id" class="form-control">
                                <?php
                                if($parent != ""){
                                ?>
                                <option value="<?=$parent;?>"><?=$parent_cat_name;?></option>
                                <?php
                                }
                                ?>
                                <option value="">--Select--</option>
                                <?php
                                    $sql_menu_mst = "select * from menu_cat_mst";
                                    $qry_menu_mst = $this->db->query($sql_menu_mst);
                                    foreach($qry_menu_mst->result() as $row){
                                        $id = $row->id;
                                        $category = $row->category;
                                ?>
                                <option value="<?=$id;?>"><?=$category;?></option>
                                <?php        
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-1"><b>URL</b></div>
                        <div class="col-sm-3">
                            <input type="text" id="module_url" name="module_url" value="<?=$url;?>" class="form-control">
                        </div>
                        <div class="col-sm-4"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-1"><b>Use Base Url</b></div>
                        <div class="col-sm-3">
                            <select id="base_url" name="base_url" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-5"></div>
                        <div class="col-sm-2">
                            <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
                        </div>
                        <div class="col-sm-5"></div>
                    </div>

                </div>
            </form>
        </section>
        </div>
    </div>

  </section>
</section>
<script>
    //Select 2 Function
    $( function(){
        $("#parent_id").select2();
    });
</script>