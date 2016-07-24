<?php
session_start();

$sql_connection = new mysqli('127.0.0.1','main','CSC370','csc370');
if ($sql_connection->connect_error) {
    echo $sql_connection->errno;
    die('Could not connect, error: '. $sql_connection->connect_errno ." ". $sql_connection->connect_error);
}

$request = getTopPosts();
if($_COOKIE['id']){
    if($result = $sql_connection->query($request)){
        if ($result->num_rows > 0) {
        	echo "
            <tr>
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
        }else{
        	echo "0 Search Results";
        }
    }else{
    	echo "Error";
    }
}else{
    echo "Not logged in";
}

function getTopPosts(){
    return "SELECT posts.* FROM subsaiddits,posts,subscribes WHERE(posts.subsaiddit_id=subsaiddits.id AND subsaiddits.id=subscribes.subsaiddit_id AND subscribes.user_id=" .$_COOKIE["id"]. ") ORDER BY (posts.upvotes-posts.downvotes) DESC;";
}

$sql_connection->close();

?>
