<?php
include("../DBcontent/PDO.php");
$id = $_POST['id'];
$pw = $_POST['pw'];
$pw_re = $_POST['pw_re'];
$name = $_POST['name'];
$email = $_POST['email']."@".$_POST['email_dns'];
$nick = $_POST['nickname'];

if(strlen(utf8_decode($name))>5 || $name==""){
    echo "<meta charset='UTF-8'>
            <script>
            alert('이름의 길이를 확인해주세요');
            history.go(-1);
            </script>";
    die();
}else if(strlen($email)>40 || $email==""){
    echo "<meta charset='UTF-8'>
            <script>
            alert('이메일의 길이를 확인해주세요');
            history.go(-1);
            </script>";
    die();
}else if(strlen($id)<5 || $id=="" || strlen($id)>15){
    echo "<meta charset='UTF-8'>
            <script>
            alert('아이디의 길이를 확인해주세요');
            history.go(-1);
            </script>";
    die();
}else if(strlen($pw)<8 || $pw=="" || strlen($pw)>20){
    echo "<meta charset='UTF-8'>
            <script>
            alert('비밀번호의 길이를 확인해주세요');
            history.go(-1);
            </script>";
    die();
}else if(strlen(utf8_decode($nick))>5 || $nick==""){
    echo "<meta charset='UTF-8'>
            <script>
            alert('닉네임의 길이를 확인해주세요');
            history.go(-1);
            </script>";
    die();
}else if($pw!=$pw_re){
    echo "<meta charset='UTF-8'>
            <script>
            alert('비밀번호가 일치하지않습니다.');
            history.go(-1);
            </script>";
    die();
}
$score=0;
if(preg_match("/[~!@\#$%<>^&*\()\-=+_\’]/",$pw)){
    $score++;
}
if(preg_match("/[0-9]/",$pw)){
    $score++;
}
if(preg_match("/[a-zA-Z]/",$pw)){
    $score++;
}
if($score<2){
    echo "<meta charset='UTF-8'>
            <script>
            alert('비밀번호는 숫자/영어/특수문자 중 2가지 이상으로 조합해주십시오');
            history.go(-1);
            </script>";
    die();
}

$dbq = $connection->prepare("SELECT id FROM user WHERE id=:id");
$dbq->bindParam('id',$id,PDO::PARAM_STR);
$dbq->execute();
if(!empty($dbq->fetch())){
    echo "<meta charset='UTF-8'>
            <script>
            alert('중복된 아이디입니다.');
            history.go(-1);
            </script>";
    die();
}
$dbq = $connection->prepare("SELECT id FROM user WHERE nick=:nick");
$dbq->bindParam('nick',$nick,PDO::PARAM_STR);
$dbq->execute();
if(!empty($dbq->fetch())){
    echo "<meta charset='UTF-8'>
            <script>
            alert('중복된 닉네임입니다.');
            history.go(-1);
            </script>";
    die();
}
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