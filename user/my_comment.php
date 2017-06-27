<section style="height:auto;min-heigth:250px">


<table style="margin-left:auto;margin-right:auto">
<tr>
<td style="font-size:23px;padding:8px 20px 8px 20px;box-shadow:5px 5px 10px #cccccc;background-color:#FFB4B4;">나의 댓글</td>
</tr>
</table>
<?php
if(empty($page))
        $page=1;
$value = ($page-1)*20;

$user_fetch = $connection->query("SELECT seq FROM user WHERE id='".$_SESSION['id']."'")->fetch();
$user_seq = $user_fetch['seq'];
 $dbq = $connection->prepare("SELECT * FROM comment_free WHERE writer_seq=$user_seq UNION ALL
 SELECT * FROM comment_humor WHERE writer_seq=$user_seq ORDER BY created DESC LIMIT :value,20");
$dbq->bindParam(":value",$value,PDO::PARAM_INT);
$dbq->execute();
 while($comment_data = $dbq->fetch()){
$board_seq = $comment_data['seq_board'];
 switch($comment_data['category']){
            case Category::best : $board_table = "베스트게시판";
            break; //0
            case Category::free : $board_table = "board_free"; $comment_table = "comment_free";
            break; //1
            case Category::humor : $board_table = "board_humor"; $comment_table = "comment_humor";
            break; //2
            default : $category_name = "자유"; 
            break;
        }
 $board_data = $connection->query("SELECT title,created,category,seq FROM $board_table WHERE seq=$board_seq")->fetch();
 $index = $board_data['seq'];
 $category = $board_data['category'];
?>





<table style="box-shadow:5px 5px 10px #cccccc;width:850px;padding:0px 0px 0px 0px;border:1px solid #EAE9FF;margin-top:15px">
<tr>
<td rowspan=3 style="width:20px"><input type="checkbox" name="check1"></td>
<td style="width:90px; background-color:#EAE9FF; text-align:center;height:30px">게시글</td>
<td style="width:550px;height:30px;padding-left:10px;">
<?php if(!empty($board_data))
		echo "<a href='/board/view.php?index=$index&category=$category'>".$board_data['title']."</a>";
	  else
	  	echo "<a style='color:#C1C1C1'>삭제된글입니다</a>";
?>
</td>
<td style="width:70px; background-color:#EAE9FF; text-align:center;height:30px">등록일</td>
<td colspan=2 style="width:110px;text-align:center;height:30px"><?php echo substr($board_data['created'],0,11)?></td>
</tr>
<tr>
<td colspan=2 style="width:90px;text-align:center; background-color:#EAE9FF;height:30px">댓글 내용</td>

<td style="background-color:#EAE9FF;text-align:center;height:5px;height:30px">등록일</td>
<td style="background-color:#EAE9FF;text-align:center;height:5px;height:30px">공감</td>
<td style="background-color:#EAE9FF;text-align:center;height:5px;height:30px">비공감</td>
</tr>
<tr>
<td colspan=2 style="width:550px;padding:10px;background-color:#E4FFE7">
<?php echo $comment_data['content']?>
</td>
<td style="font-size:12px;text-align:center;border-left:1px solid #EAE9FF"><?php echo substr($comment_data['created'],0,16)?></td>
<td style="text-align:center;border-left:1px solid #EAE9FF;color:blue"><?php echo $comment_data['recmd']?></td>
<td style="text-align:center;border-left:1px solid #EAE9FF;color:red"><?php echo $comment_data['not_recmd']?></td>
</tr>
</table>
<?php
 }
?>

<div id="divPaging">
		<?php
		$row = $connection->query("SELECT count(*) FROM comment_free WHERE writer_seq=$user_seq")->fetchColumn();
        $row = $row + $connection->query("SELECT count(*) FROM comment_humor WHERE writer_seq=$user_seq")->fetchColumn();
		if($row%20!=0){
			$max_page_num = (int)($row/20) + 1;
		}else{
			$max_page_num = (int)$row/20;
		}
		$startpage = ((int)(($page-1)/10)*10)+1;
		$endpage = $startpage+9;
		if($max_page_num<$endpage)
			$endpage = $max_page_num;

		//echo "게시글 수:".$row."<br>";
		//echo "시작 페이지 : ".$startpage."<br>";
		//echo "마지막 페이지 : ".$endpage."<br>";
		?>

		<center>
		
		
		<?php
        
		if($startpage!=1)
			echo "<a href=\"/user/MYSCREEN.php?type=my_comment&page=".($startpage-1).">◀</a>";
		for($count=$startpage;$count<=$endpage;$count++){
			if($count==$page)
				echo "<a href=\"/user/MYSCREEN.php?type=my_comment&page=".$count."\" style=\"text-decoration:underline;color:blue\">[".$count."]</a>";
			else
				echo "<a href=\"/user/MYSCREEN.php?type=my_comment&page=".$count."\">".$count."</a>";
		}

		if($endpage!=$max_page_num)
			echo "<a href=\"/user/MYSCREEN.php?type=my_comment&page=".($endpage+1).">▶</a>";
		?>

		<center>
</div>




</section>