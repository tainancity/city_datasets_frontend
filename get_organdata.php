<?php
ob_start();
if (!isset($_SESSION)) {
  session_start();
}
include('connections/DB.php');
/*
擷取組織資料並匯入資料庫
*/
?>
<!--網頁內容開始-->
<script>
$(function(){
		   
		   });
</script>

<?php

$city_a=array('tainan'=>'http://data.tainan.gov.tw/organization/',
			'nantou'=>'http://data.nantou.gov.tw/organization/',
			'hccg'=>'http://opendata.hccg.gov.tw/organization/');

foreach($city_a as $city_index =>$city_url)
{
	echo "匯入並比對".$city_index."_organization.json中...<br>";
	//抓出局處
	//source from: http://data.nantou.gov.tw/api/3/action/organization_list?all_fields=true&order_by=packages
	$file_handle = fopen("dataset/".$city_index."_organization.json", "r");
	while (!feof($file_handle)) {

	$line_of_text = fgets($file_handle);
	$json_a = json_decode($line_of_text, true);
	}
	fclose($file_handle);
	//print_r($json);


	for($i=0;$i<count($json_a[result]);$i++)
	{
		//echo $json_a[result][$i][display_name];
		$org_name=$json_a[result][$i][display_name];
		$org_url=$city_url.$json_a[result][$i]['name'];
		$org_oid=$json_a[result][$i][id];
		$org_packages=$json_a[result][$i][packages];
		$query   = "select * from organizations where o_city='".$city_index."' and o_name='".$org_name."' limit 1";
		$result  = $db->query($query);
		$value = $db->get_fetch_assoc($result);
		if($value[oid]=="")
		{
			$query_insert   = "insert into organizations set
			o_oid='".$org_oid."' ,
			o_city='".$city_index."' ,
			o_organ_fname='".$org_name."',
			o_name='".$org_name."',
			o_dataset_url='".$org_url."',
			o_packages='".$org_packages."'
			";
			echo $query_insert."<br>";
			$result_insert  = $db->query($query_insert);
		}
	}
}
echo "<hr>批次處理完成";	
?>     

<!--網頁內容結束-->

<?php
$PAGE_CONTENT = ob_get_contents();
ob_end_clean();
require('master.php');
?>