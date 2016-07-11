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

th {text-align: left;}
</style>
</head>
<body>

<?php
$query = $_GET['q'];
$type = $_GET['t'];

$con = mysqli_connect('localhost','root','password','CSC370');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

switch($type){
    case "1":
        echo ("<div>Get User's Posts  " . $query . "</div>");
        break;
    case "2":
        echo ("<div>Get User's Friends' Posts  " . $query . "</div>");
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

function getUserPosts($user){
    $sql="SELECT * FROM users WHERE username = '".$q."'";
    $result = mysqli_query($con,$sql);
}

function getFriendsPosts($user){
    $sql="SELECT * FROM users WHERE username = '".$q."'";
    $result = mysqli_query($con,$sql);
}

echo "<table>
<tr>
<th>FirstName</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";
$row = array("FirstName"=>"FirstName", "LastName"=>"LastName", "Age"=>"Age", "Hometown"=>"Hometown", "Job"=>"Job");
// while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['FirstName'] . "</td>";
    echo "<td>" . $row['LastName'] . "</td>";
    echo "<td>" . $row['Age'] . "</td>";
    echo "<td>" . $row['Hometown'] . "</td>";
    echo "<td>" . $row['Job'] . "</td>";
    echo "</tr>";
// echo "</table>";
// mysqli_close($con);
?>
</body>
</html>