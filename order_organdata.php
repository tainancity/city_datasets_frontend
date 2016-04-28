<?php
ob_start();
if (!isset($_SESSION)) {
  session_start();
}
include('connections/DB.php');
//參考資料：https://i.tainan.gov.tw/ckan-api/datasets.html#
?>
<!--網頁內容開始-->
<style>
.sortable{ list-style-type: none; margin: 5px; float: left; margin-right: 10px; background: #eee; padding: 5px; width: 200px;}
.sortable li { margin: 5px; padding: 2px; font-size: 15px;  }
input{font-size:18px;}
.link{text-decoration:none;color:#fff;background:#BD0000}
</style>
</style>
<script>
$(function() {
    $( "ul.droptrue" ).sortable({
      connectWith: "ul"
    });

	$('.o_organ_fname').change(function(){
		s_name=$(this).attr('source');
		e_name=$(this).val();
		
		$.ajax({
                url: "ajax.php?op=edit_organ_fname",
                data: "s="+s_name+"&e="+e_name,
                type:"GET",
                success: function(msg){
					//alert(msg);
                    $(this).attr('source',s_name);
                },

                 error:function(xhr, ajaxOptions, thrownError){ 
                    alert(xhr.status); 
                    alert(thrownError); 
                 }
            });
		
	});
	
	$( "ul.droptrue" ).droppable({
      drop: function( event, ui ) {
		  $(ui.draggable).detach().appendTo(this);//先把項目移過去
		  fname=$(this).children( "input" ).val();
		  $(this).children( "li" ).each(function(i){
			  id=$(this).attr('index');
			  $.ajax({
                url: "ajax.php?op=edit_fname",
                data: "id="+id+"&fname="+fname,
                type:"GET",
                success: function(msg){
					//alert(msg);
                },

                 error:function(xhr, ajaxOptions, thrownError){ 
                    alert(xhr.status); 
                    alert(thrownError); 
                 }
				});
			});
		  

          
		 
      }
    });
	
  });
</script>

<?php

$temp_o_organ="";
$teno_o_organ_index=1;
$query   = "select * from organizations  order by o_organ_fname ";
$result  = $db->query($query);
while($value = $db->get_fetch_assoc($result))
{
	$different=0;
	if($temp_o_organ!=$value[o_organ_fname])
	{
		if($temp_o_organ!="")
		{
			$different=1;
			echo '</ul>';
			$teno_o_organ_index++;
		}
		echo '<ul id="sortable'.$teno_o_organ_index.'" class="sortable droptrue" >';
		echo '<input type=text size=10 value="'.$value[o_organ_fname].'" source="'.$value[o_organ_fname].'" class="o_organ_fname" ><a href="list_organdata.php?fname='.$value[o_organ_fname].'" class=link target=_blank>(連結)</a>';
		$temp_o_organ=$value[o_organ_fname];
		//$different=1;
		
	}
	echo '<li class="ui-state-default" index="'.$value[oid].'"><a href="'.$value[o_dataset_url].'" target=_balnk>'.$value[o_city].$value[o_name].'('.$value[o_packages].')</a></li>';

}
echo '</ul>';
	
?>     

<!--網頁內容結束-->

<?php
$PAGE_CONTENT = ob_get_contents();
ob_end_clean();
require('master.php');
?>