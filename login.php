<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php

$password = $_REQUEST['p'];
$username = $_REQUEST['u'];

$sql_connection = new mysqli('127.0.0.1','main','CSC370','csc370');
if ($sql_connection->connect_error) {
    echo $sql_connection->errno;
    die('Could not connect, error: '. $sql_connection->connect_errno ." ". $sql_connection->connect_error);
}

// Code for production db (all passwords use sha hash)
$request = "SELECT * FROM accounts WHERE username='".$username."' AND password=sha2('".$password."',0);";
// Code for the test db(Not all passwords use the same hash)
$request = "SELECT * FROM accounts WHERE username='".$username."' AND ( password=sha('".$password."') OR password=sha2('".$password."',0) OR password='".$password."');";

if($result = $sql_connection->query($request)){
    if ($result->num_rows == 0) {
    	echo "Invalid Login Information";
    }elseif ($result->num_rows == 1) {
    	setcookie("id",$result->fetch_assoc()['id'],time()+10000000);
    	header('Location: home.html');
		exit;
    }else{
    	echo "Whoops Something Went Wrong";
    }
}else {
	echo "Connection Failed";
}

$sql_connection->close();

?>
</body>
</html>