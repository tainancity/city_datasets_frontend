<?php
ob_start();
if (!isset($_SESSION)) {
  session_start();
}
include('connections/DB.php');
include('functions.php');
//參考資料：https://i.tainan.gov.tw/ckan-api/datasets.html#

?>
<!--網頁內容開始-->
<style>
#city{background:#000;padding:10px;font-size:20px;color:#fff}
.city{color:#f00}
.city_sum{color:#FFFF00}

.list{  margin: 5px; float: left; background: #eee; padding: 5px; width: 200px;}
ul{ list-style-type: none; margin: 0px;padding: 5px; }
.list li { margin: 5px; padding: 2px; font-size: 15px;  }
input{font-size:18px;}
.link{text-decoration:none;color:#fff;background:#BD0000}
#savemsg{display:none;position:fixed;padding:20px;width:100px;text-align:center;background:rgba(200,200,200,0.8);border:2px solid #333;top:45%;left:45%}
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
					showsave();
                },

                 error:function(xhr, ajaxOptions, thrownError){ 
                    //alert(xhr.status); 
                    //alert(thrownError); 
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
					//window.location.reload();
					showsave();
                },

                 error:function(xhr, ajaxOptions, thrownError){ 
                    //alert(xhr.status); 
                    //alert(thrownError); 
                 }
				});
			});
		  

          
		 
      }
    });
	
});
function showsave()
{
	
	$('#savemsg').show();
	setTimeout(function(){$('#savemsg').fadeOut();},2000);
}
</script>

<?php

echo '<div id="city" >';
$query   = "SELECT o_city ,sum(o_packages) allnum FROM organizations  group by o_city ";
$result  = $db->query($query);
while($value = $db->get_fetch_assoc($result))
{
	echo " <span class=city>";
	echo city_name($value[o_city]);
	echo "</span>";
	echo ":<span class=city_sum>".$value[allnum]."</span>個資料集 ";
}
echo '</div>';

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
			echo '</div>';
			$teno_o_organ_index++;
		}
		echo '<div class="list" >';
		echo '<input type=text size=10 value="'.$value[o_organ_fname].'" source="'.$value[o_organ_fname].'" class="o_organ_fname" ><a href="list_organdata.php?fname='.$value[o_organ_fname].'" class=link target=_blank>(比較)</a>';
		echo '<ul id="sortable'.$teno_o_organ_index.'" class="sortable droptrue" >';
		$temp_o_organ=$value[o_organ_fname];
		//$different=1;
		
	}
	echo '<li class="ui-state-default" index="'.$value[oid].'"><a href="'.$value[o_dataset_url].'" target=_balnk><span class=city>'.city_name($value[o_city]).'</span>'.$value[o_name].'('.$value[o_packages].')</a></li>';

}
echo '</ul>';
	
?>     
<div id=savemsg>已儲存</div>
<!--網頁內容結束-->

<?php
$PAGE_CONTENT = ob_get_contents();
ob_end_clean();
require('master.php');
?>