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

$sql_connection = new mysqli('localhost','main','CSC370','csc370');
if ($sql_connection->connect_error) {
    die('Could not connect: ' . $sql_connection->connect_error);
}

function add_account($username,$password){
    return "INSERT INTO accounts VALUES (NULL,".$username.",0,sha2(".$password.",0));";
}

function add_friend($id_1,$id_2){
    if($id_1>$id_2){
        $temp = $id_1;
        $id_1 = $id_2;
        $id_2=$temp;
    }
    return "INSERT INTO friends VALUES (".$id_1.",".$id_2.");";
}

function create_subsaiddit($u_id, $title, $description){
    return "INSERT INTO subsaiddits VALUES(NULL,'" . $title . ",'".$description."'," . $u_id . ",0,CURRENT_TIMESTAMP);";
}

function subscribe_to_subsaiddit($u_id,$s_id){
    return "INSERT INTO subscribes VALUES(".$u_id.",".$s_id.");";
}

function create_post($text,$title,$url,$u_id,$s_id){
    return "INSERT INTO posts VALUES(NULL, '".$text."',CURRENT_TIMESTAMP,NULL,'".$title."','".$url."',0,0,".$u_id.",".$s_id.");";
}

function add_favourite($u_id,$p_id){
    return "INSERT INTO favourite_posts VALUES(".$u_id.",".$p_id . ");";
}

function create_comment($text, $p_id,$u_id,$c_id){
    return "INSERT INTO comments VALUES(NULL,CURRENT_TIMESTAMP,'".$text."',".$p_id.",".$u_id.",".$c_id.");";
}
//
    // function create_comment($text, $p_id,$u_id,$c_id){
    //     return "INSERT INTO comments VALUES(NULL," . "CURRENT_TIMESTAMP,'".$text."',".$p_id.",".$u_id.",".$c_id.");";
    // }

function set_comment_reaction($c_id,$u_id,$r_value){
    update_reputation($u_id);
    return "INSERT INTO comment_reactions (comment_id,user_id,reaction)VALUES (".$c_id.",".$u_id.",".$r_value.") ON DUPLICATE KEY UPDATE reaction = ".$r_value.";";
}

function set_post_reaction($p_id,$u_id,$r_value){
    update_reputation($u_id);
    update_updown_votes($p_id);
    return "INSERT INTO post_reactions (post_id,user_id,reaction) VALUES (".$p_id.",".$u_id.",".$r_value.") ON DUPLICATE KEY UPDATE reaction = ".$r_value.";";
}

function update_reputation($u_id){
    return "UPDATE accounts SET reputation=( SELECT sum(totalReactions) AS reputation FROM( SELECT sum(post_reactions.reaction) totalReactions FROM post_reactions,posts WHERE post_reactions.post_id=posts.id AND posts.creator = " . $u_id . " UNION ALL SELECT sum(comment_reactions.reaction) totalReactions FROM comment_reactions,comments WHERE comment_reactions.comment_id=comments.id AND comments.creator = " . $u_id . ") AS user_reactions) WHERE accounts.id = " . $u_id . ";";

}
//
    // UPDATE accounts SET reputation=(
    //     SELECT sum(totalReactions) AS reputation FROM(
    //     SELECT sum(post_reactions.reaction) totalReactions FROM post_reactions,posts WHERE post_reactions.post_id=posts.id AND posts.creator = 8
    //     UNION ALL
    //     SELECT sum(comment_reactions.reaction) totalReactions FROM comment_reactions,comments WHERE comment_reactions.comment_id=comments.id AND comments.creator = 8
    // ) AS user_reactions) WHERE accounts.id = 8;


function update_updown_votes($p_id){
    return "UPDATE posts SET upvotes=(SELECT COUNT(reaction) FROM post_reactions WHERE reaction = 1 and post_id=" .$p_id. "), downvotes=(SELECT COUNT(reaction) as downvotes FROM post_reactions WHERE reaction = -1 and post_id=" .$p_id. ") WHERE posts.id=" .$p_id. ";";
}
//
    // UPDATE posts SET 
    // upvotes=(SELECT COUNT(reaction) FROM post_reactions WHERE reaction = 1 and post_id=2), 
    // downvotes=(SELECT COUNT(reaction) as downvotes FROM post_reactions WHERE reaction = -1 and post_id=2) WHERE posts.id=2;

    // SELECT * FROM (SELECT COUNT(reaction) as upvotes FROM post_reactions WHERE reaction = 1 and post_id=2) as up,
    //  (SELECT COUNT(reaction) as downvotes FROM post_reactions WHERE reaction = -1 and post_id=2) as down;

switch($type){
    case "1":
        set_comment_reaction($c_id,$u_id,$value);
        update_reputation($u_id);
        break;
    case "2":
        break;
    case "3":
        break;
    case "4":
        break;
    case "5":
        break;
    case "6":
        break;
}

$sql_connection.close();
?>
</body>
</html>