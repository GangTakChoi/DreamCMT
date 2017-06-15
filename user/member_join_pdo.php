<?php
include("../DBcontent/PDO.php");
$id = $_POST['mbid'];
$pw = $_POST['mbpw'];
$name = $_POST['mbname'];
$email = $_POST['email']."@".$_POST['email_dns'];
$nick = $_POST['mbnickname'];


$dbq = $connection->prepare("INSERT INTO user (id,pw,nick,name,email,created) 
    VALUES(:id,:pw,:nick,:name,:email,curdate())");
$dbq->bindParam(':id',$id,PDO::PARAM_STR);
$dbq->bindParam(':pw',$pw,PDO::PARAM_STR);
$dbq->bindParam(':nick',$nick,PDO::PARAM_STR);
$dbq->bindParam(':name',$name,PDO::PARAM_STR);
$dbq->bindParam(':email',$email,PDO::PARAM_STR);
$dbq->execute();


    ?>
    <meta charset="UTF-8">
    <script>
        alert("회원가입이 완료되었습니다.");
        location.replace('/index.php');
    </script>