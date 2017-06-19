<?php
$connection = new PDO('mysql:host=localhost;dbname=dreamcmt;charset=utf8', 'root', '123123');
//$dbq = $connection->prepare('SELECT COUNT(*) FROM board_list');
$test="user";
$dbq = $connection->prepare("SELECT * FROM $test limit :value,:value_1");
$dbq->bindParam(':value',$value,PDO::PARAM_INT);
$dbq->bindParam(':value_1',$value_1,PDO::PARAM_INT);
$value = 0;
$value_1 = 5;
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
class MyEnum{
    const TypeA = "1";
    const TypeB = "2";
    const TypeC = "3";
}
while($row=$dbq->fetch()){
    echo $row['seq']." ".MyEnum::TypeB."<br>";
}
?>