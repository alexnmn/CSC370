<?php

$sql_connection = new mysqli('127.0.0.1','main','CSC370','csc370');
if ($sql_connection->connect_error) {
    echo $sql_connection->errno;
    die('Could not connect, error: '. $sql_connection->connect_errno ." ". $sql_connection->connect_error);
}

$request = getTopPosts();
if($result = $sql_connection->query($request)){
    if ($result->num_rows > 0) {
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
    }else{
    	echo "0 Search Results";
    }
}else{
	echo "Error";
}



function getTopPosts(){
    return "SELECT posts.* FROM subsaiddits,posts WHERE(posts.subsaiddit_id=subsaiddits.id AND subsaiddits.is_default=1) ORDER BY (posts.upvotes-posts.downvotes);";
}

$sql_connection->close();

?>
