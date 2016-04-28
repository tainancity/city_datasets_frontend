<?php
ob_start();
if (!isset($_SESSION)) {
  session_start();
}
include('connections/DB.php');
?>
<!--網頁內容開始-->
<style>
.list{ list-style-type: none; margin: 5px; float: left; margin-right: 10px; background: #eee; padding: 5px; width: 200px;overflow:hidden;font-size:18px;}
.list_dataset{background:#fff;border:1px solid #f1f1f1;padding:2px;margin:2px;font-size:15px;color: #1c94c4;}
</style>
</style>
<script>
$(function() {
   
	
  });
</script>

<?php


$query   = "select * from organizations  where  o_organ_fname ='".$_GET[fname]."' ";
$result  = $db->query($query);
while($value = $db->get_fetch_assoc($result))
{
	echo '<div  class="list" >';
	echo $value[o_city].$value[o_name];
	$query_list   = "select * from dataset  where  oid ='".$value[oid]."' ";
	$result_list  = $db->query($query_list);
	while($value_list = $db->get_fetch_assoc($result_list))
	{
		echo '<div class="list_dataset"><a href="'.$value_list[d_url].'" target=_balnk>'.$value_list[d_name].'('.$value[o_packages].')</a></div>';
	}
	echo '</div>';
}

	
?>     

<!--網頁內容結束-->

<?php
$PAGE_CONTENT = ob_get_contents();
ob_end_clean();
require('master.php');
?>