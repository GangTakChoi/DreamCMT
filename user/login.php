<?php
session_start();
include("../DBcontent/PDO.php");
$id = $_POST['id'];
$pw = $_POST['pw'];

$dbq = $connection->prepare("select id,pw,nick from user where id=:id and pw=:pw");
$dbq->bindParam(':id',$id,PDO::PARAM_STR);
$dbq->bindParam(':pw',$pw,PDO::PARAM_STR);
$dbq->execute();
$row = $dbq->fetch();
if(!empty($row)){
    $_SESSION['is_login']=true;
    $_SESSION['id']=$row['id'];
    ?>

    <meta charset="UTF-8">
    <script type="text/javascript">
    alert("로그인성공하였습니다!!");
    location.replace("/index.php");
    </script>

    <?php
}else{
    ?>
    <meta charset="UTF-8">
    <script type="text/javascript">
    alert("아이디 또는 비번이 일치하지 않습니다.");
    history.go(-1);
    </script>
    <?php
}
?>