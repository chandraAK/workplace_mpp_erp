
<?php
if(isset($breadcrumb)&& is_array($breadcrumb) && count($breadcrumb) > 0){
?>  
<ul class="breadcrumb">
<?php
foreach ($breadcrumb as $key=>$value) {
if($value!=''){
?>
    <li><a href="<?php echo base_url(); ?>index.php/<?php echo $value; ?>"><?php echo $key; ?></a> <span class="divider"></span></li>
    
<?php }
}
?>        
</ul>
<?php 
    }
?>  