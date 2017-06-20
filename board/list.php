<?php
session_start();
include("../DBcontent/PDO.php");
$page = $_GET['page'];
$category = $_GET['category'];
$SERVER_IP = $_SERVER['REMOTE_ADDR'];
class Category{
	const best = "0";
	const free = "1";
	const humor = "2";
	
}
switch($category){
	case Category::best : $table = "board_best"; $board_name = "베스트게시판";
						  break; //0
	case Category::free : $table = "board_free"; $board_name = "자유게시판";
					   	  break; //1
	case Category::humor : $table = "board_humor"; $board_name = "유머게시판";
						  break; //2
	default : $table = "board_free"; break;
}
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


if($category>=0 AND $category<=7){?>
<section> <!-- 본문 -->
	<article class="boardArticle">
		
		<h3 style="display:inline;float:left;margin-top:10px"><?php echo $board_name;?></h3>
		<div class="board_write_button" style="display:inline-block; float:right;margin:10px 0"><a href="/board/write.php?category=<?php echo $category;?>" class="button">글쓰기</a></div>
		
		<table>
			<thead>
				<tr>
					<th scope="col" class="no">번호</th>
					<th scope="col" class="title">제목</th>
					<th scope="col" class="author">작성자</th>
					<th scope="col" class="date">작성일</th>
					<th scope="col" class="hit">조회</th>
					<th scope="col" class="recmd">추천</th>
				</tr>
			</thead>
			<tbody class="new_board_list">
				<?php

				if(empty($page))
					$page=1;

				$value = ($page-1)*20;
				$dbq = $connection->prepare("SELECT seq,title,writer,created,hit,recmd FROM $table ORDER BY seq DESC LIMIT :value,20");
				$dbq->bindParam(':value',$value,PDO::PARAM_INT);
				$dbq->execute();
				
				for($count=1; $count<=20; $count++){
					$row=$dbq->fetch();
					//$row = mysql_fetch_array($result);
					if(empty($row)){
						break;
					}
					
					?>
						
						<tr>
						<td class="no" style="font-size:12px"><?php echo $row['seq']?></td>
						<td class="title"><a href='/board/view.php?index=<?php echo $row['seq']?>&category=<?php echo $category?>'><?php echo $row['title']?></a></td>
						<td class="author" style="font-size:13px"><a href='#'><?php echo $row['writer']?></a></td>
						<td class="date" style="font-size:11px"><?php echo $row['created']?></td>
						<td class="hit" style="font-size:11px"><?php echo $row['hit']?></td>
						<td class="hit"><?php echo $row['recmd']?></td>
						</tr>
					<?php
				}
				?>
				
				
				

			</tbody>
		</table>
	</article>
	<div id="divPaging">
		<?php
		$row = $connection->query("SELECT count(*) FROM $table")->fetchColumn();
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
			echo "<a href=\"/board/list.php?page=".($startpage-1)."&category=".$category."\">◀</a>";
		for($count=$startpage;$count<=$endpage;$count++){

			if($count==$page)
				echo "<a href=\"/board/list.php?page=".$count."&category=".$category."\" style=\"text-decoration:underline;color:blue\">[".$count."]</a>";
			else
				echo "<a href=\"/board/list.php?page=".$count."&category=".$category."\">".$count."</a>";
		}

		if($endpage!=$max_page_num)
			echo "<a href=\"/board/list.php?page=".($endpage+1)."&category=".$category."\">▶</a>";
		?>
			
		 
		<center>
	</div>
</section>
<?php }else{
?>
<section>
test
</section>
<?php }?>
