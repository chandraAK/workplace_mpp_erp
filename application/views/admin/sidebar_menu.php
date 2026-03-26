<aside>
    <div id="sidebar"  class="nav-collapse">
        <ul class="sidebar-menu">
            <?php 
                $sql_rights = "select * from rights_mst where user_id = '".$user_id."'";
                $qry_rights = $this->db->query($sql_rights);
                foreach($qry_rights->result() as $row){
                    $par_cat_right = $row->par_cat_right;
                    $sub_cat_right = $row->sub_cat_right;

                    //Converting String To Array
                    $par_cat_right1 = explode(",",$par_cat_right);
                    $sub_cat_right1 = explode(",",$sub_cat_right);

                    $count = count($par_cat_right1);

                    for($i=0;$i<$count;$i++){
                        
                        $sql_cat_nm = "select * from menu_cat_mst where id = '".$par_cat_right1[$i]."'";
                        $qry_cat_nm = $this->db->query($sql_cat_nm);

                        foreach($qry_cat_nm->result() as $row){
                            $category_nm = $row->category;
                            $url = $row->url;
                            $use_base_url1 = $row->use_base_url;

                            //Checking Subcategories Exists
                            $sql_subcat_cnt = "select count(*) as cnt1 from menu_cat_mst where parent = '".$par_cat_right1[$i]."'";
                            $qry_subcat_cnt = $this->db->query($sql_subcat_cnt)->row();
                            $cnt1 = $qry_subcat_cnt->cnt1;

            ?>

            <?php if($cnt1 > 0){ ?>
                <li class="sub-menu">
            <?php } else { ?>
                <li>
            <?php } ?>

                <?php if($cnt1 > 0){ ?>
                    <a class="" href="javascript:;">
                    <i class="icon_document_alt"></i>
                        <span style="font-size:14px"><?php echo $category_nm; ?></span>
                        <span class="menu-arrow arrow_carrot-right"></span>
                    </a>
                <?php } else { ?>

                    <?php if($use_base_url1 == 1){ ?>
                        <a href="<?php echo base_url(); ?>index.php/<?=$url; ?>">
                        <i class="fa fa-home"></i>
                    <?php } else { ?>
                        <a href="<?php echo $url; ?>"  target="_blank">
                    <?php } ?>

                        <span style="font-size:14px"><?php echo $category_nm; ?></span>
                    </a>
                <?php } ?>
                
                <ul class="sub">
                <?php
                    $sql_subcat_nm = "select * from menu_cat_mst where parent = '".$par_cat_right1[$i]."'";
                    $qry_subcat_nm = $this->db->query($sql_subcat_nm);

                    foreach($qry_subcat_nm->result() as $row){
                        $subcat_id = $row->id;
                        $subcategory_nm = $row->category;
                        $suburl = $row->url;
                        $use_base_url2 = $row->use_base_url;
                ?>
                
                    <?php 
                        if(in_array($subcat_id, $sub_cat_right1)){ 
                    ?>
                        <li>
                            <?php if($use_base_url2 == 1){ ?>
                            <?php
                            if(strpos($suburl, "?") !== false){
                            ?>
                                <a href="<?php echo base_url(); ?>index.php/<?=$suburl."&id=".$user_id; ?>">
                            <?php
                            } else{
                            ?>
                                <a href="<?php echo base_url(); ?>index.php/<?=$suburl."?id=".$user_id; ?>">
                            <?php
                            }
                            ?>
                            <?php } else { ?>
                                <a href="<?php echo $suburl; ?>" target="_blank">
                            <?php } ?>
                                <?=$subcategory_nm; ?>
                            </a>
                        </li>
                    <?php 
                        }
                    ?>
                
                <?php
                    }
                ?>
                </ul>
            </li>
            <?php
                        }
                    }

                }
            ?>
        </ul>
    </div>
</aside>