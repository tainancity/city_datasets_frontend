<?php
    require_once("class_DB.php");
    $db = new mydb();
    $db->init_db();
	/*
	//範例程式
    $result=$db->query("SELECT * from ...");
	while($value = $db->get_fetch_assoc($result))
	{
			// do something you want...
			echo $value[cus_name];
	}
    */

