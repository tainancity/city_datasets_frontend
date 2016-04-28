<?php 
require_once('connections/DB.php'); 
$result=$db->query("SELECT * from...");
print_r($_POST);
if($_POST){
	print_r($_POST);
	return;
	
}
$sql = "INSERT INTO fb_user (fb_uid, name, email)
VALUES ('John', 'Doe', 'john@example.com')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

while($value = $db->get_fetch_assoc($result))
{
        // do something you want...
		$sql="update ...";
		$db->query($sql);
}
