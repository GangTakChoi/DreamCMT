<?php 
session_start();
include("../DBcontent/PDO.php");
if(empty($_SESSION['is_login'])){
    ?>
    <meta charset="UTF-8">
    <script>
        alert("잘못된 접근이네요!<br>로그인하셔야합니다!");
        history.go(-1);
    </script>
    <?php
}
$title = $_POST['title'];
$content = $_POST['content'];
$category = $_POST['category'];
$action = $_POST['action'];
$index = $_POST['index'];
$content = nl2br($content);

class Category{
	const best = "0";
	const free = "1";
	const humor = "2";
	
}
switch($category){
	case Category::best : $board_table = "board_best";
						  break; //0
	case Category::free : $board_table = "board_free";
                          $comment_table = "comment_free";
					   	  break; //1
	case Category::humor : $board_table = "board_humor";
                           $comment_table = "comment_humor";
						  break; //2
	default : $table = "board_free"; break;
}

$row = $connection->query("SELECT seq,nick FROM user WHERE id='".$_SESSION['id']."'")->fetch();

    switch($action){
        case 'board_register':        //글등록 동작일 경우
            $dbq = $connection->prepare("INSERT INTO $board_table (title,content,writer,writer_seq,created)
                VALUES (:title,:content,:nickname,:writer_seq,now())");
            $dbq->bindParam(':title',$title,PDO::PARAM_STR);
            $dbq->bindParam(':content',$content,PDO::PARAM_STR);
            $dbq->bindParam(':nickname',$row['nick'],PDO::PARAM_STR);
            $dbq->bindParam(':writer_seq',$row['seq'],PDO::PARAM_INT);
            $result = $dbq->execute();
            if($result==true){
                ?>
                <meta charset="UTF-8">
                <?php
                echo "<script>alert('게시글 등록이 완료되었습니다.');";
                echo "location.replace(\"/board/list.php?category=".$category."\")</script>";
            }
        break;
        case 'comment_register':        // 댓글 등록 동작일 경우
            $dbq = $connection->prepare("INSERT INTO $comment_table (seq_board,writer,writer_seq,content,created)
                VALUES (:index,:nickname,:writer_seq,:content,now())");
            $dbq->bindParam(':index',$index,PDO::PARAM_INT);
            $dbq->bindParam(':nickname',$row['nick'],PDO::PARAM_STR);
            $dbq->bindParam(':writer_seq',$row['seq'],PDO::PARAM_STR);
            $dbq->bindParam(':content',$content,PDO::PARAM_STR);
            $result = $dbq->execute();
            if($result==true){
                ?>
                <meta charset="UTF-8">
                <?php
                echo "<script>location.replace(\"/board/view.php?index=".$index."&category=".$category."\")</script>";
            }
        break;
        default :
            echo "<meta charset='UTF-8'><script>alert('잘못된 파라미터 정보입니다.');
                    history.go(-1);</script>";
        break;

    }
   

    
?>