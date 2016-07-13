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
}

function getAllUsers(){
    return "SELECT * FROM accounts;";
}

function getUserPosts($user){
    return  "SELECT posts.* FROM posts,accounts WHERE( posts.creator=accounts.id AND accounts.username = '".$user."');";
}

function getFriendsPosts($user){
    return "SELECT posts.* FROM posts,friends,accounts WHERE((posts.creator=friends.id_1 AND friends.id_2=accounts.id AND accounts.username = '" . $user . "') OR (posts.creator=friends.id_2 AND friends.id_1=accounts.id AND accounts.username = '" . $user . "'));";
}

function getUserSubsaidits($user){
    return "SELECT subsaiddits.* FROM subscribes, subsaiddits,accounts WHERE(subsaiddits.id=subscribes.subsaiddit_id AND subscribes.user_id=accounts.id AND accounts.username = '" . $user . "');";
}

function getUserFavoritePosts($user){
    return "SELECT posts.* FROM posts, favourite_posts,accounts WHERE(posts.id=favourite_posts.post_id AND favourite_posts.user_id=accounts.id AND accounts.username = '" . $user . "');";
}

function getFriendsFavoritePosts($user){
    return "SELECT posts.* FROM posts,friends,accounts,favourite_posts WHERE((posts.id=favourite_posts.post_id AND favourite_posts.user_id=friends.id_1 AND friends.id_2=accounts.id AND accounts.username = '" . $user . "') OR (posts.id=favourite_posts.post_id AND favourite_posts.user_id=friends.id_2 AND friends.id_1=accounts.id AND accounts.username = '" . $user . "'));";
}

function getFriendsSubsaidits($user){
    return "SELECT subsaiddits.* FROM subsaiddits,friends,accounts,subscribes WHERE((subsaiddits.id=subscribes.subsaiddit_id AND subscribes.user_id=friends.id_1 AND friends.id_2=accounts.id AND accounts.username = '" . $user . "') OR (subsaiddits.id=subscribes.subsaiddit_id AND subscribes.user_id=friends.id_2 AND friends.id_1=accounts.id AND accounts.username = '" . $user . "'));";
}

$returntype = "";
$request = "";
switch($type){
    case "1":
        echo ("<h1>Get User's Posts, Query:" . $query . "</h1>");
        $request = getUserPosts($query);
        $returntype = "posts";
        break;
    case "2":
        echo ("<h1>Get User's Friends' Posts, Query:" . $query . "</h1>");
        $request = getFriendsPosts($query);
        $returntype = "posts";
        break;
    case "3":
        echo ("<h1>Get User's Subscribed Subsaidits, Query:" . $query . "</h1>");
        $returntype = "subsaiddits";
        $request = getUserSubsaidits($query);
        break;
    case "4":
        echo ("<h1>Get User's Favorite Posts, Query:" . $query . "</h1>");
        $returntype = "posts";
        $request = getUserFavoritePosts($query);
        break;
    case "5":
        echo ("<h1>Get User's Friends Favorite Posts, Query:" . $query . "</h1>");
        $returntype = "posts";
        $request = getFriendsFavoritePosts($query);
        break;
    case "6":
        echo ("<h1>Get User's Friends' Subscribed Subsaidits, Query:" . $query . "</h1>");
        $returntype = "subsaiddits";
        $request = getFriendsSubsaidits($query);
        break;
    case "7":
        echo ("<h1>All Users</h1>");
        $request = getAllUsers();
        $returntype = "accounts";
        break;
}

if($result = $sql_connection->query($request)){
    if ($result->num_rows > 0) {
        echo "<table>";
        switch($returntype){
            case "accounts":
                echo "
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
                break;
            case "posts":
                echo "
                <tr>
                <th>id</th>
                <th>text</th>
                <th>time_pub</th>
                <th>time_edit</th>
                <th>title</th>
                <th>url</th>
                <th>upvotes</th>
                <th>downvotes</th>
                <th>creator</th>
                <th>subsaiddit_id</th>
                </tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['text'] . "</td>";
                    echo "<td>" . $row['time_pub'] . "</td>";
                    echo "<td>" . $row['time_edit'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['url'] . "</td>";
                    echo "<td>" . $row['upvotes'] . "</td>";
                    echo "<td>" . $row['downvotes'] . "</td>";
                    echo "<td>" . $row['creator'] . "</td>";
                    echo "<td>" . $row['subsaiddit_id'] . "</td>";
                    echo "</tr>";
                }
                break;
            case "subsaiddits":
                echo "
                <tr>
                <th>id</th>
                <th>title</th>
                <th>description</th>
                <th>creator</th>
                <th>is_default</th>
                <th>create_time</th>
                </tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['creator'] . "</td>";
                    echo "<td>" . $row['is_default'] . "</td>";
                    echo "<td>" . $row['create_time'] . "</td>";
                    echo "</tr>";
                }
                break;
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
}else{
    echo "Failure";
}

$sql_connection->close();

?>
</body>
</html>