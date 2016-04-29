<?php
ob_start();
if (!isset($_SESSION)) {
  session_start();
}
set_time_limit(300);
include('connections/DB.php');

/*
擷取資料表資料並匯入資料庫
*/
?>
<!--網頁內容開始-->
<script>
$(function(){
		   
		   });
</script>

<?php

$city_a=array('tainan'=>'http://data.tainan.gov.tw/dataset/',
			'nantou'=>'http://data.nantou.gov.tw/dataset/',
			'hccg'=>'http://opendata.hccg.gov.tw/dataset/');

foreach($city_a as $city_index =>$city_url)
{
	echo "匯入並比對".$city_index.".json中...<br>";
	//抓出局處
	//source from: http://data.nantou.gov.tw/api/3/action/organization_list?all_fields=true&order_by=packages
	$file_handle = fopen("dataset/".$city_index.".json", "r");
	while (!feof($file_handle)) {

	$line_of_text = fgets($file_handle);
	$json_a = json_decode($line_of_text, true);
	}
	fclose($file_handle);
	
	//print_r($json_a);

	if(is_array($json_a))
	{
		foreach($json_a as $i=>$json_val)
		{
			//echo $i;//組織名稱
			
			$query   = "select oid from organizations where o_city='".$city_index."' and o_name='".$i."' limit 1";
			$result  = $db->query($query);
			$value = $db->get_fetch_assoc($result);
			//echo $value[oid];//資料庫內的組織編號
			//echo $query;
			
			$json_dataset_a=$json_a[$i]['datasets'];
			if(is_array($json_dataset_a))
			{
				foreach($json_dataset_a as $json_dataset_a_i=>$json_dataset_a_d)
				{
					//echo $json_dataset_a_i;//資料集編號
					//echo $json_dataset_a_d[title];//資料集名稱
					$data_url=$city_url.$json_dataset_a_d['name'];
					
					
					$query_s   = "select * from dataset where oid='".$value [oid]."' and d_name='".$json_dataset_a_d[title]."' limit 1";
					$result_s  = $db->query($query_s);
					$value_s = $db->get_fetch_assoc($result_s);
					if($value_s[did]=="")
					{
						$query_insert   = "insert into dataset set 
						oid='".$value[oid]."',
						d_name='".$json_dataset_a_d[title]."',
						d_url='".$data_url."'
						";
						echo $query_insert."<br>";
						$result_insert  = $db->query($query_insert);
					}
				
				}
			}
			
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