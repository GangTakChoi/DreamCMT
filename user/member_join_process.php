<?php
include("../DBcontent/DB.php");
$id = $_POST['mbid'];
$pw = $_POST['mbpw'];
$name = $_POST['mbname'];
$email = $_POST['email']."@".$_POST['email_dns'];
$nick = $_POST['mbnickname'];
$level = 1;


$result=mysql_query("INSERT INTO user (id,pw,nick,name,email,created,level,warning) VALUES('"
.$id."','".$pw."','".$nick."','".$name."','"
.$email."',curdate(),'".$level."','')");
/*
if($result==true)
{
    ?>
    <meta charset="UTF-8">
    <script>
        alert("회원가입이 완료되었습니다.");
        location.replace('/index.php');
    </script>
    <?php
}else{
    ?>
    <meta charset="UTF-8">
    <script>
        alert("회원정보를 DB에 삽입중 오류가 발생하였습니다.\n");
        history.go(-1);
    </script>
    <?php
    
}
   */


?>