<?php
$connection = new PDO('mysql:host=localhost;dbname=dreamcmt;charset=utf8', 'root', '123123');
//$dbq = $connection->prepare('SELECT COUNT(*) FROM board_list');
$dbq = $connection->prepare("SELECT * FROM :user");
$user = "user";
$dbq->bindParam(':user',$user,PDO::PARAM_STR);
$dbq->execute();
//$dbq->bindParam(':index',$index,PDO::PARAM_INT);
//$dbq->bindParam(':id',$id,PDO::PARAM_STR);
//$index = 150;
//$id = "tototo";

/*
foreach($connection->query('SELECT * FROM user') as $row) {
    echo $row['index'] . ' ' . $row['id'];
}
*/

while($row=$dbq->fetch()){
    echo $row['id']."<br>";
}
?>