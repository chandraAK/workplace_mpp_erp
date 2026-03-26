<table class="table table-bordered">
    <tr>
        <td>Check All <input type="checkbox" id="all_checkbox" name="all_checkbox" onchange="checkAll(this)"></td>
    </tr>
    <?php
        //Getting Previous Checked Entries
        $user_id = $_REQUEST['user_id'];
        //Count Previous
        $sql_rgt_cnt = "select count(*) as count1 from rights_mst where user_id = '".$user_id."'";
        $qry_rgt_cnt = $this->db->query($sql_rgt_cnt)->row();
        $count1 = $qry_rgt_cnt->count1;

        if($count1 > 0){

            $sql_rights = "select * from rights_mst where user_id = '".$user_id."'";
            $qry_rights = $this->db->query($sql_rights);

            foreach($qry_rights->result() as $row){
                $par_cat_right = $row->par_cat_right;
                $sub_cat_right = $row->sub_cat_right;

                //Converting String To Array
                $par_cat_right1 = explode(",",$par_cat_right);
                $sub_cat_right1 = explode(",",$sub_cat_right);
            }

        } else {
            $par_cat_right1 = [];
            $sub_cat_right1 = [];
        }

        $sql_parent_menu = "select * from menu_cat_mst where parent = 0";
        $qry_parent_menu = $this->db->query($sql_parent_menu);

        foreach($qry_parent_menu->result() as $row){
            $id = $row->id;
            $category = $row->category;
    ?>
    <tr>
        <td>
            <?=$category; ?>&nbsp;
            <input type="checkbox" id="par_cat_right" name="par_cat_right[]" value="<?=$id; ?>" 
            <?php if(in_array($id, $par_cat_right1)){ echo "checked"; } ?>>
        </td>
    </tr>
    <tr>
        <?php
            $sql_sub_menu = "select * from menu_cat_mst where parent = '".$id."'";
            $qry_sub_menu = $this->db->query($sql_sub_menu);
            foreach($qry_sub_menu->result() as $row){
                $sub_id = $row->id;
                $sub_cat = $row->category;
        ?>
        <td><?=$sub_cat; ?>&nbsp;
            <input type="checkbox" id="sub_cat_right" name="sub_cat_right[]" value="<?=$sub_id; ?>"
            <?php if(in_array($sub_id, $sub_cat_right1)){ echo "checked"; } ?>>
        </td>
        <?php
            }
        ?>    
    </tr>
    <?php
        }
    ?>
</table>