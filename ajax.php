<?php
include('connections/DB.php');
switch($_GET[op])
{
	case "edit_organ_fname":
		$query   = "update organizations set o_organ_fname='".$_GET[e]."' where o_organ_fname='".$_GET[s]."' ";
		$result  = $db->query($query);
		//echo $query;
	break;
	
	case "edit_fname":
		if($_GET[id]!="")
		{
		$query   = "update organizations set o_organ_fname='".$_GET[fname]."' where oid='".intval($_GET[id])."' limit 1 ";
		$result  = $db->query($query);
		echo $query;
		}
	break;
	
	default:
	exit();
	break;

}

?>