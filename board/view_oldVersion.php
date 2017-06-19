<?php
session_start();
include("../DBcontent/DB.php");
$page = $_GET['page'];
$category = $_GET['category'];
$index = $_GET['index'];
$SERVER_IP = $_SERVER['REMOTE_ADDR'];
?>

<!DOCTYPE html>
<html>
    <head>
        
        <meta charset="UTF-8">
        <title>Insert title here</title>
        <link rel="stylesheet" href="/css/basic02.css">
        <link rel="stylesheet" href="/css/normalize.css" />
	    <link rel="stylesheet" href="/css/board.css" />
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script>
          
            function formSubmit()
            {
                document.getElementById("frm1").submit();
            }
            function press(f){ 
                if(event.keyCode == 13){ //javascript에서는 13이 enter키를 의미함
                frm1.submit(); //formname에 사용자가 지정한 form의 name입력 
                } 
            }
            
            
        </script>
        
        
    </head>
    <body bgcolor=black>
        <div id ="wrap">

           <?php include("../include/header.php"); ?>  <!-- 해더 -->

           <?php 
              include("../include/nav.php"); 
           ?> 

<?php
/* 조회수 중복방지 */

$result = mysql_query("select * from board_free_hit where ip='".$SERVER_IP."' and seq_board='".$index."'");
$row = mysql_fetch_array($result);
if(empty($row)){
	mysql_query("insert into board_free_hit value ('$SERVER_IP','$index')");
	mysql_query("update board_free set hit=hit+1 where seq=$index");
}


$result = mysql_query("select * from board_free where seq=$index");
$row = mysql_fetch_array($result);
$result = mysql_query("select * from comment_free where seq_board=$index order by seq");
$row_cmt = mysql_fetch_array($result);
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
	<form class="board_recmd" >
	<div class="comment" style="border-top:0px solid #C6C5C6;margin-top:-4px;float:left">
		<button type="button" id="board_recommend_button">추천 <?php echo $row['recmd']?></button>
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

		$('#board_recommend_button').click(function(){
			$.ajax({
				url:'../jquery/process.php?what=0',
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

	while($row_cmt){
	?>
	<div class="comment">
		<table style="margin-bottom:10px;">
			<form class="recmd_<?php echo $row_cmt['seq']?>">
			<tr>
				<input type="hidden" name="seq" value="<?php echo $row_cmt['seq']?>" />
				<td style="text-align:center;width:80px;background-color:#EEEEEE"><?php echo $row_cmt['writer']?></td>
				<td style="color:#5F5F5F"><?php echo $row_cmt['created']?></td>
				<td class="up_<?php echo $row_cmt['seq']?>" style="background-color:#BFCCFF;cursor:pointer">공감</td><td id="plus_<?php echo $row_cmt['seq']?>" style="text-align:center;width:30px"><?php echo $row_cmt['recmd']?></td>
				<td class="down_<?php echo $row_cmt['seq']?>" style="background-color:#FFADAD;cursor:pointer">비공감</td><td id="minus_<?php echo $row_cmt['seq']?>" style="text-align:center;width:30px"><?php echo $row_cmt['not_recmd']?></td>
			</tr>
			</form>
			<?php echo "
			<script>
				$('.up_".$row_cmt['seq']."').click(function(){
					$.ajax({
						url:'../jquery/process.php?what=1',
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
								$('#plus_".$row_cmt['seq']."').html(data);
							}
							
						}
					})
				})
				$('.down_".$row_cmt['seq']."').click(function(){
					$.ajax({
						url:'../jquery/process.php?what=2',
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
								$('#minus_".$row_cmt['seq']."').html(data);
							}
							
						}
					})
				})
			</script>
		";?>
		</table>
		<?php echo $row_cmt['content']?>
	</div>
	
	<?php
	$row_cmt = mysql_fetch_array($result);
	}
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
