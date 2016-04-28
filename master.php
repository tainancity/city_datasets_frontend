<?php
if (!isset($_SESSION)) session_start();
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="content-language" content="zh-tw">
<title></title>

<link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script>

	<?php echo $PAGE_SCRIPT_H ; ?>
</script>
</head>
<body>
	<div id='wrapper'>
		<div id='content'><?php echo $PAGE_CONTENT ; ?> </div>               
	</div>	
	
</body>
</html>
<?php ob_end_flush();?>