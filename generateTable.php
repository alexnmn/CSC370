<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {$text-align: left;}
</style>
</head>
<body>

<?php
$query = $_REQUEST['q'];
$type = $_REQUEST['t'];

$sql_connection = new mysqli('127.0.0.1','main','CSC370','csc370');
if ($sql_connection->connect_error) {
    echo $sql_connection->errno;
    die('Could not connect, error: '. $sql_connection->connect_errno ." ". $sql_connection->connect_error);
}else{ 
    echo("Connected $type=1");
}

function getUserPosts($user){
    return "SELECT * FROM accounts WHERE username = '".$user."';";

}

function getFriendsPosts($user){
    return  "SELECT * FROM accounts WHERE username = '".$user."';";
}

$type = '1';
$request = "";
switch($type){
    case "1":
        echo ("<div>Get User's Posts  " . $query . "</div><br>");
        $request = getUserPosts($query);
        break;
    case "2":
        echo ("<div>Get User's Friends' Posts  " . $query . "</div>");
        $request = getFriendsPosts($query);
        break;
    case "3":
        echo ("<div>Get User's Subscribed Subsaidits  " . $query . "</div>");
        break;
    case "4":
        echo ("<div>Get User's Favorite Posts  " . $query . "</div>");
        break;
    case "5":
        echo ("<div>Get User's Friends Favorite Posts  " . $query . "</div>");
        break;
    case "6":
        echo ("<div>Get User's Friends' Subscribed Subsaidits  " . $query . "</div>");
        break;
}
echo("<br><br>");
echo($request."<br>");
if($result = $sql_connection->query($request)){
    echo $result->num_rows;
}else{
    echo "Failure";
}
//if ($result = $sql_connection->query($request) {
    if ($result->num_rows > 0) {
        echo "<table>
        <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Reputation</th>
        <th>Password</th>
        </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['reputation'] . "</td>";
            echo "<td>" . $row['password'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
//}
// $sql_connection.close();
// $result = getUserPosts($query);
// $result = update_reputation($query);



?>
</body>
</html>