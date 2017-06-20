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


if(strcmp($category,"board_free")==false){?>
<section> <!-- 본문 -->
	<article class="boardArticle">
		
		<h3 style="display:inline;float:left">자유게시판</h3>
		<div class="board_write_button" style="display:inline-block; float:right;margin:20px 0"><a href="/board/write.php?category=board_free" class="button">글쓰기</a></div>
		
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
				$result = mysql_query("select seq,title,writer,created,hit,recmd,not_recmd from ".$category." order by seq DESC limit ".$value.",20");
				
				for($count=1; $count<=20; $count++){
					$row = mysql_fetch_array($result);
					if($row==false){
						break;
					}
					?>
						<tr onclick="location.href='/board/view.php?index=<?php echo $row[0]?>'">
						<td class="no" style="font-size:12px"><?php echo $row[0]?></td>
						<td class="title"><?php echo $row[1]?></td>
						<td class="author" style="font-size:13px"><?php echo $row[2]?></td>
						<td class="date"  style="font-size:11px"><?php echo $row[3]?></td>
						<td class="hit" style="font-size:11px"><?php echo $row[4]?></td>
						<td class="hit"><?php echo $row[5]?></td>
						</tr>
					<?php
				}
				?>
				
				
				

			</tbody>
		</table>
	</article>
	<div id="divPaging">
		<?php
		$result = mysql_query("select count(*) from board_free");
		$row = mysql_fetch_array($result);
		if($row[0]%20!=0){
			$max_page_num = (int)($row[0]/20) + 1;
		}else{
			$max_page_num = (int)$row[0]/20;
		}
		$startpage = ((int)(($page-1)/10)*10)+1;
		$endpage = $startpage+9;
		if($max_page_num<$endpage)
			$endpage = $max_page_num;
		?>
		<center>
		
		
		<?php
		if($startpage!=1)
			echo "<a href=\"/list.php?page=".($startpage-1)."&category=".$category."\">◀</a>";
		for($count=$startpage;$count<=$endpage;$count++){

			if($count==$page)
				echo "<a href=\"/list.php?page=".$count."&category=".$category."\" style=\"text-decoration:underline;color:blue\">[".$count."]</a>";
			else
				echo "<a href=\"/list.php?page=".$count."&category=".$category."\">".$count."</a>";
		}

		if($endpage!=$max_page_num)
			echo "<a href=\"/list.php?page=".($endpage+1)."&category=".$category."\">▶</a>";
		?>
			
		 
		<center>
	</div>
</section>
<?php }else{?>
<section>
test
</section>
<?php }?>
