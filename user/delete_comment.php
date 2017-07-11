<?php
session_start();
include("../DBcontent/PDO.php");
$comment_seq = $_POST['comment_seq'];
$count = sizeof($comment_seq);
if(empty($comment_seq)){
    echo "<meta charset='UTF-8'>
        <script>
            alert('삭제할 댓글을 선택해주세요.');
            history.go(-1);
        </script>";
    die();
}
class Category{
	const best = "0";
	const free = "1";
	const humor = "2";
}
$user_seq = $connection->query("SELECT seq FROM user WHERE id='".$_SESSION['id']."'")->fetch();
for($i=1; $i<=$count;$i++)
{   
    
    $strTok = explode('/',$comment_seq[$i-1]);
    switch($strTok[1]){
			case Category::best : $board_table = "베스트게시판";
			break; //0
			case Category::free : $comment_table = "comment_free";
			break; //1
			case Category::humor : $comment_table = "comment_humor";
			break; //2
			default : $category_name = "자유"; 
			break;
		}
    $dbq = $connection->prepare("DELETE FROM $comment_table WHERE seq=:seq AND writer_seq=:writer_seq");
    $dbq->bindParam(':seq',$strTok[0],PDO::PARAM_INT);
    $dbq->bindParam(':writer_seq',$user_seq['seq'],PDO::PARAM_INT);
    $dbq->execute();
    
   
}
echo "<meta charset='UTF-8'>
        <script>
            alert('삭제완료');
            history.go(-1);
        </script>";
?>