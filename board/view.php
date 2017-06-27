<?php
session_start();
include("../DBcontent/PDO.php");
$page = $_GET['page'];
$category = $_GET['category'];
$index = $_GET['index'];
$best = $_GET['best'];
$SERVER_IP = $_SERVER['REMOTE_ADDR'];
$user_fetch = $connection->query("SELECT seq FROM user WHERE id='".$_SESSION['id']."'")->fetch();
?>

<!DOCTYPE html>
<html>
    <head>
        
        <meta charset="UTF-8">
        <title>Insert title here</title>
        <link rel="stylesheet" href="/css/basic.css">
        <link rel="stylesheet" href="/css/normalize.css" />
	    <link rel="stylesheet" href="/css/board.css" />
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script>
          
            function formSubmit()
            {
                document.getElementById("Adelete").submit();
            }
            function press(f){ 
                if(event.keyCode == 13){ //javascript에서는 13이 enter키를 의미함
                frm1.submit(); //formname에 사용자가 지정한 form의 name입력 
                } 
            }
            
            
        </script>
		<style type="text/css">
		.view_button {
		border: 1px solid #0a3c59;
		background: #4e7691;
		background: -webkit-gradient(linear, left top, left bottom, from(#79b7e0), to(#4e7691));
		background: -webkit-linear-gradient(top, #79b7e0, #4e7691);
		background: -moz-linear-gradient(top, #79b7e0, #4e7691);
		background: -ms-linear-gradient(top, #79b7e0, #4e7691);
		background: -o-linear-gradient(top, #79b7e0, #4e7691);
		background-image: -ms-linear-gradient(top, #79b7e0 0%, #4e7691 100%);
		padding: 5.5px 11px;
		-webkit-border-radius: 28px;
		-moz-border-radius: 28px;
		border-radius: 28px;
		-webkit-box-shadow: rgba(255,255,255,0.4) 0 0px 0, inset rgba(255,255,255,0.4) 0 1px 0;
		-moz-box-shadow: rgba(255,255,255,0.4) 0 0px 0, inset rgba(255,255,255,0.4) 0 1px 0;
		box-shadow: rgba(255,255,255,0.4) 0 0px 0, inset rgba(255,255,255,0.4) 0 1px 0;
		text-shadow: #828282 0 1px 0;
		color: #121212;
		font-size: 14px;
		font-family: helvetica, serif;
		text-decoration: none;
		vertical-align: middle;
		margin-top:20px;
		margin-right:10px;
		}
		.view_button:hover {
		border: 1px solid #0a3c59;
		text-shadow: #1e4158 0 1px 0;
		background: #3e779d;
		background: -webkit-gradient(linear, left top, left bottom, from(#65a9d7), to(#3e779d));
		background: -webkit-linear-gradient(top, #65a9d7, #3e779d);
		background: -moz-linear-gradient(top, #65a9d7, #3e779d);
		background: -ms-linear-gradient(top, #65a9d7, #3e779d);
		background: -o-linear-gradient(top, #65a9d7, #3e779d);
		background-image: -ms-linear-gradient(top, #65a9d7 0%, #3e779d 100%);
		color: #ffffff;
		}
		.view_button:active {
		text-shadow: #1e4158 0 1px 0;
		border: 1px solid #0a3c59;
		background: #65a9d7;
		background: -webkit-gradient(linear, left top, left bottom, from(#3e779d), to(#3e779d));
		background: -webkit-linear-gradient(top, #3e779d, #65a9d7);
		background: -moz-linear-gradient(top, #3e779d, #65a9d7);
		background: -ms-linear-gradient(top, #3e779d, #65a9d7);
		background: -o-linear-gradient(top, #3e779d, #65a9d7);
		background-image: -ms-linear-gradient(top, #3e779d 0%, #65a9d7 100%);
		color: #fff;
		}
		</style>
	
        
    </head>
    <body bgcolor=black>
        <div id ="wrap">

           <?php include("../include/header.php"); ?>  <!-- 해더 -->

           <?php 
              include("../include/nav.php"); 
           ?> 

<?php
class Category{
	const best = "0";
	const free = "1";
	const humor = "2";
}
switch($category){
	case Category::free: 
		$board_table = "board_free";
		$board_hit_table = "board_free_hit";
		$comment_table = "comment_free";
		
	break;
	case Category::humor: 
		$board_table = "board_humor";
		$board_hit_table = "board_humor_hit";
		$comment_table = "comment_humor";
	break;
}
//게시판 테이블이름 변수
//게시판 중복조회 방지 테이블이름 변수
//해당 게시판 댓글 테이블이름 변수



/* 조회수 중복방지 */
$dbq = $connection->prepare("SELECT * FROM $board_hit_table WHERE ip = :S_IP AND seq_board = :index");

$dbq->bindParam(':index',$index,PDO::PARAM_INT);
$dbq->bindParam(':S_IP',$SERVER_IP,PDO::PARAM_STR);
$dbq->execute();
$row = $dbq->fetch();

if(empty($row)){ // 해당 IP가 처음 조회하는 게시글이라면
	$dbq = $connection->prepare("INSERT INTO $board_hit_table value (:S_IP,:index)"); //중복체크 테이블에 해당 게시글 seq번호와 IP추가
	$dbq->bindParam(':index',$index,PDO::PARAM_INT);
	$dbq->bindParam(':S_IP',$SERVER_IP,PDO::PARAM_STR);
	$dbq->execute();

	$dbq = $connection->prepare("UPDATE $board_table SET hit=hit+1 WHERE seq=:index"); // 해당 게시글 조회수 +1
	$dbq->bindParam(':index',$index,PDO::PARAM_INT);
	$dbq->execute();
}
$max_seq = $connection->query("SELECT seq FROM $board_table ORDER BY seq DESC LIMIT 0,1")->fetch();
$min_seq = $connection->query("SELECT seq FROM $board_table ORDER BY seq ASC LIMIT 0,1")->fetch();

$dbq = $connection->prepare("SELECT * FROM $board_table WHERE seq=:index"); // 해당 게시글 내용 불어오기
$dbq->bindParam(':index',$index,PDO::PARAM_INT);
$dbq->execute();
$row = $dbq->fetch();

$dbq = $connection->prepare("SELECT * FROM $comment_table WHERE seq_board=:index order by seq"); //해당 게시글 댓글 목록 불러오기
$dbq->bindParam(':index',$index,PDO::PARAM_INT);
$dbq->execute();
$row_cmt = $dbq->fetch();
if(empty($row)){ //삭제된 글인지 확인?>
<div style="width:868px;display:inline-block;height:300px;text-align:center;padding-top:200px;
position:relative;background-color:white;margin:3px;">
	삭제된 글입니다.<br><br><br><center>
	<?php if($max_seq['seq']>$index){?>
	<a href="/board/view.php?index=<?php echo $index+1?>&category=<?php echo $category?>&page=<?php echo $page?>" >
	<div id="prev">이전 글</div></a><?php }?>
	<?php if($min_seq['seq']<$index){?>
	<a href="/board/view.php?index=<?php echo $index-1?>&category=<?php echo $category?>&page=<?php echo $page?>" >
	<div id="next">다음 글</div></a><?php }?>
	<a href="/board/list.php?category=<?php echo $category?>&page=<?php echo $page?>"><div id="go_list">목록보기</div></a>
	</center>
</div>
<?php
die();
}
if($best==1){ $category=0;}
?>
	<div class="view_title">
		<table style="padding:10px;">
			<tr>
				<td style="padding:11px"><?php echo $row['title']?></td>
			</tr>
		</table>
	</div>
	<div class="view_writer">
		<table style="border-bottom:1px solid #dad8db; width:160px;height:30px ">
			<tr>
				<td style="border-right:0px solid black;padding:3px;width:35px;background-color:#dad8db;border-top-left-radius:7px">작성자 </td>
				<td width=77px><?php echo $row['writer']?></td>
			</tr>
		</table>
	</div>
	<div class="view_writer" style="width:180px">
		<table style="border-bottom:1px solid #dad8db; width:180px;height:30px ">
			<tr>
				<td style="border-right:0px solid black;padding:3px;width:35px;background-color:#dad8db;border-top-left-radius:7px">등록일 </td>
				<td width=77px style="font-size:11px"><?php echo $row['created']?></td>
			</tr>
		</table>
	</div>
	<div class="view_writer">
		<table style="border-bottom:1px solid #dad8db; width:160px;height:30px ">
			<tr>
				<td style="border-right:0px solid black;padding:3px;width:35px;background-color:#dad8db;border-top-left-radius:7px">조회수 </td>
				<td width=77px><?php echo $row['hit']?></td>
			</tr>
		</table>
	</div>
	<section style="padding:15px;height:auto; min-height:250px"> <!-- 본문 -->
		<?php echo $row['content']?>
	</section>
	<form class="board_recmd" action="/board/board_process.php" method="POST">
	<div class="comment" style="border-top:0px solid #C6C5C6;margin-top:-4px;float:left">
		<button type="button" id="board_recommend_button">추천 <?php echo $row['recmd']?></button>
		
		<?php if($max_seq['seq']>$row['seq']){?>
		<a href="/board/view.php?index=<?php echo $row['seq']+1?>&category=<?php echo $category?>&page=<?php echo $page?>" class="view_button" style="float:left">
		<div id="prev">이전 글</div></a><?php }?>
		<?php if($min_seq['seq']<$row['seq']){?>
		<a href="/board/view.php?index=<?php echo $row['seq']-1?>&category=<?php echo $category?>&page=<?php echo $page?>" class="view_button" style="float:left">
		<div id="next">다음 글</div></a><?php }?>
		<a href="/board/list.php?category=<?php echo $category?>&page=<?php echo $page?>" class="view_button" style="float:left"><div id="go_list">목록보기</div></a>
		<?php if($row['writer_seq']==$user_fetch['seq']){?>
		<a href="/board/board_process.php?category=<?php echo $category?>&index=<?php echo $index?>" class="view_button" style="float:left"><div id="go_list">수정</div></a>
		
		
		<input type="submit" class="view_button" style="float:left" value="삭제"></input>
		<input type="hidden" name="action" value="board_delete"></input>
		<input type="hidden" name="index" value="<?php echo $row['seq']?>"></input>
		<input type="hidden" name="category" value="<?php echo $category?>"></input>
		

		<?php }?>
		<span id="scrap"><a href="#" class="view_button" style="float:right">스크랩</a></span>
	</div>
	<input type="hidden" name="seq" value="<?php echo $row['seq']?>" />
	</form>
	<?php
	echo "
	<script>
		$('.hover').mouseleave(
			function() {
				$(this).removeClass('hover');
			}
		);
		$('#scrap .view_button').click(function(){
			$.ajax({
				url:'../jquery/process.php?what=3&category=$category',
				type:'post',
				data:$('.board_recmd').serialize(),
				success:function(data){
					if(data==-1){
						alert('이미 스크랩완료되었습니다');
					}else if(data==-2){
						alert('로그인하셔야합니다.');
					}else if(data==-3){
						alert('유효하지 않을 값을 전달받았습니다.');
					}
					else{
						alert('스크랩완료되었습니다~');
						$('#scrap').text('');
					}
				}

			})
		})
		$('#board_recommend_button').click(function(){
			$.ajax({
				url:'../jquery/process.php?what=0&category=$category',
				type:'post',
				data:$('.board_recmd').serialize(),
				success:function(data){
					if(data==-1){
						alert('이미 추천을 하셨습니다~');
					}else if(data==-2){
						alert('로그인하셔야합니다.');
					}else if(data==-3){
						alert('유효하지 않을 값을 전달받았습니다.');
					}
					else{
						
						$('#board_recommend_button').text(data);
					}
				}

			})
		})
	</script>";

	while(!empty($row_cmt)){
	?>
	<div class="comment">
		<table style="margin-bottom:10px;">
			<form class="recmd_<?php echo $row_cmt['seq']?>">
			<tr>
				<input type="hidden" name="seq" value="<?php echo $row_cmt['seq']?>" />
				<td style="text-align:center;width:80px;background-color:#EEEEEE"><?php echo $row_cmt['writer']?></td>
				<td style="color:#5F5F5F"><?php echo $row_cmt['created']?></td>
				<td class="up_<?php echo $row_cmt['seq']?>" style="background-color:#BFCCFF;cursor:pointer">공감</td>
				<td id="plus_<?php echo $row_cmt['seq']?>" style="text-align:center;width:30px"><?php echo $row_cmt['recmd']?></td>
				<td class="down_<?php echo $row_cmt['seq']?>" style="background-color:#FFADAD;cursor:pointer">비공감</td>
				<td id="minus_<?php echo $row_cmt['seq']?>" style="text-align:center;width:30px"><?php echo $row_cmt['not_recmd']?></td>
			</tr>
			</form>
			<?php echo "
			<script>
				$('.up_".$row_cmt['seq']."').click(function(){
					$.ajax({
						url:'../jquery/process.php?what=1&category=$category',
						type:'post',
						data:$('.recmd_".$row_cmt['seq']."').serialize(),
						success:function(data){
							if(data==-1){
								alert('이미 공감/비공감을 하셨습니다~');
							}else if(data==-2){
								alert('로그인하셔야합니다.');
							}else if(data==-3){
								alert('유효하지 않을 값을 전달받았습니다.');
							}
							else{
								alert('공감완료!');
								$('#plus_".$row_cmt['seq']."').html(data);
							}
							
						}
					})
				})
				$('.down_".$row_cmt['seq']."').click(function(){
					$.ajax({
						url:'../jquery/process.php?what=2&category=$category',
						type:'post',
						data:$('.recmd_".$row_cmt['seq']."').serialize(),
						success:function(data){
							if(data==-1){
								alert('이미 공감/비공감을 하셨습니다~');
							}else if(data==-2){
								alert('로그인하셔야합니다.');
							}else if(data==-3){
								alert('유효하지 않을 값을 전달받았습니다.');
							}
							else{
								alert('비공감완료!');
								$('#minus_".$row_cmt['seq']."').html(data);
							}
							
						}
					})
				})
			</script>
		";?>
		</table>
		<div style="width:704px">
		<?php echo $row_cmt['content']?>
		</div>
	</div>
	
	<?php
	$row_cmt = $dbq->fetch();
	} // 댓글 while문 end부분

	
	if($_SESSION['is_login']==true){?>
	<div class="comment_input">
		<form action="/board/board_process.php" name="frm1" method="POST">
			<table style="height:90px;padding:0px;box-sizing:border-box">
				<tr>
					<td style="width:708px">
						<textarea name="content" style="width:710px;height:92px;resize:none;box-sizing:border-box;vertical-align:middle"></textarea>
					</td>
					<td>
						<input type="submit" value="등록" style="display:inline-block"></input>
					</td>
				</tr>
			</table>
			<input type="hidden" name="action" value="comment_register">
			<input type="hidden" name="category" value="<?php echo $category?>">
			<input type="hidden" name="index" value="<?php echo $index?>">
		</form>
	</div>
   <?php 
   }else{
   ?>
	<div class="comment_input">
		<div style="position:absolute;top:40%;width:852px;text-align:center;vertical-align:middle">
			로그인 하셔야 댓글을 달 수 있습니다 ^.^
		</div>
	</div>
	<?php }?>
