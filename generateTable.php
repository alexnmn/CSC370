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
    return  "SELECT posts.* FROM posts,accounts WHERE( posts.creator=accounts.id AND accounts.username = '".$user."') ORDER BY (posts.upvotes-posts.downvotes) DESC;";
}

function getFriendsPosts($user){
    return "SELECT posts.* FROM posts,friends,accounts WHERE((posts.creator=friends.id_1 AND friends.id_2=accounts.id AND accounts.username = '" . $user . "') OR (posts.creator=friends.id_2 AND friends.id_1=accounts.id AND accounts.username = '" . $user . "')) ORDER BY (posts.upvotes-posts.downvotes) DESC;";
}

function getUserSubsaiddits($user){
    return "SELECT subsaiddits.* FROM subscribes, subsaiddits,accounts WHERE(subsaiddits.id=subscribes.subsaiddit_id AND subscribes.user_id=accounts.id AND accounts.username = '" . $user . "');";
}

function getUserFavoritePosts($user){
    return "SELECT posts.* FROM posts, favourite_posts,accounts WHERE(posts.id=favourite_posts.post_id AND favourite_posts.user_id=accounts.id AND accounts.username = '" . $user . "') ORDER BY (posts.upvotes-posts.downvotes) DESC;";
}

function getFriendsFavoritePosts($user){
    return "SELECT DISTINCT posts.* FROM posts,friends,accounts,favourite_posts WHERE((posts.id=favourite_posts.post_id AND favourite_posts.user_id=friends.id_1 AND friends.id_2=accounts.id AND accounts.username = '" . $user . "') OR (posts.id=favourite_posts.post_id AND favourite_posts.user_id=friends.id_2 AND friends.id_1=accounts.id AND accounts.username = '" . $user . "')) ORDER BY (posts.upvotes-posts.downvotes) DESC;";
}

function getFriendsSubsaiddits($user){
    return "SELECT DISTINCT subsaiddits.* FROM subsaiddits,friends,accounts,subscribes WHERE((subsaiddits.id=subscribes.subsaiddit_id AND subscribes.user_id=friends.id_1 AND friends.id_2=accounts.id AND accounts.username = '" . $user . "') OR (subsaiddits.id=subscribes.subsaiddit_id AND subscribes.user_id=friends.id_2 AND friends.id_1=accounts.id AND accounts.username = '" . $user . "'));";
}

function deletePost($p_id){
    deleteComments($p_id);
    return "DELETE FROM posts WHERE id=".$p_id.";";
}

function queryText($str){
    return "SELECT * FROM posts WHERE text LIKE '%" .$str. "%';";
}

function deleteComments($p_id){
    return $sql_connection->query("DELETE FROM comments WHERE post=".$p_id.";");
}


$returntype = "";
$request = "";
switch($type){
    case "1":
        echo ("<h3>Get User's Posts, Query:" . $query . "</h3>");
        $request = getUserPosts($query);
        $returntype = "posts";
        break;
    case "2":
        echo ("<h3>Get User's Friends' Posts, Query:" . $query . "</h3>");
        $request = getFriendsPosts($query);
        $returntype = "posts";
        break;
    case "3":
        echo ("<h3>Get User's Subscribed Subsaiddits, Query:" . $query . "</h3>");
        $returntype = "subsaiddits";
        $request = getUserSubsaiddits($query);
        break;
    case "4":
        echo ("<h3>Get User's Favorite Posts, Query:" . $query . "</h3>");
        $returntype = "posts";
        $request = getUserFavoritePosts($query);
        break;
    case "5":
        echo ("<h3>Get User's Friends Favorite Posts, Query:" . $query . "</h3>");
        $returntype = "posts";
        $request = getFriendsFavoritePosts($query);
        break;
    case "6":
        echo ("<h3>Get User's Friends' Subscribed Subsaiddits, Query:" . $query . "</h3>");
        $returntype = "subsaiddits";
        $request = getFriendsSubsaiddits($query);
        break;
    case "7":
        echo ("<h3>All Users</h3>");
        $request = getAllUsers();
        $returntype = "accounts";
        break;
    case "8":
        echo ("<h3>Delete Post</h3>");
        $request = deletePost($query);
        $returntype = "Meow";
        break;
    case "9":
        echo ("<h3>Query By Text</h3>");
        $request = queryText($query);
        $returntype = "posts";
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
                echo "<tr>
                <th>id</th>
                <th style='width:150px'>text</th>
                <th>time_pub</th>
                <th style='width:150px'>title</th>
                <th>url</th>
                <th>up</th>
                <th>down</th>
                <th>creator</th>
                <th>subsaiddit_id</th>
                </tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['text'] . "</td>";
                    echo "<td>" . $row['time_pub'] . "</td>";
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
            case "Meow":
                echo "<tr>
                <th>Post deleted!!!</th></tr></table>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
}else{
    // echo "Failure";
}

$sql_connection->close();

?>
