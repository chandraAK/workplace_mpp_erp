<?php
 $db2 = $this->load->database('db2', TRUE);
$this->load->helper("dr");
$sql ="select item_name, parent from `tabSales Invoice Item` 
where sales_order is not null group by item_name";
$query = $db2->query($sql);
foreach ( $query->result() as $row){
    $item_name = $row->item_name;
    $parent = $row->parent;
}