<?php 
session_start();
include("../DBcontent/DB.php");
if(empty($_SESSION['is_login'])){
    ?>
    <meta charset="UTF-8">
    <script>
        alert("잘못된 접근이네요!<br>로그인하셔야합니다!");
        history.go(-1);
    </script>
    <?php
}
$writer = $_SESSION['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$category = $_POST['category'];
$action = $_POST['action'];
$index = $_POST['index'];
$content = nl2br($content);
    switch($action){
        case 'board_register':         //글등록 동작일 경우
             $result = mysql_query("INSERT INTO board_free (title,content,writer,created) 
                VALUES ('".$title."','".$content."','".$_SESSION['nickname']."',now())");
            if($result==true){
                ?>
                <meta charset="UTF-8">
                <?php
                echo "<script>alert('게시글 등록이 완료되었습니다.');";
                echo "location.replace(\"/board/list.php?category=".$category."\")</script>";
            }
        break;
        case 'comment_register':        // 댓글 등록 동작일 경우
            $result = mysql_query("INSERT INTO comment_free (seq_board,writer,content,created)
                VALUES ('".$index."','".$_SESSION['nickname']."','".$content."',now())");
            if($result==true){
                ?>
                <meta charset="UTF-8">
                <?php
                echo "<script>location.replace(\"/board/view.php?index=".$index."\")</script>";
            }
        break;
        default :
            echo "<meta charset='UTF-8'><script>alert('잘못된접근입니다.');
                    history.go(-1);</script>";
        break;

    }
   

    
?>