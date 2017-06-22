<section>
<table style="margin-left:auto;margin-right:auto">
<tr>
<td style="font-size:23px;padding:8px 20px 8px 20px;box-shadow:5px 5px 10px #cccccc;background-color:#FFB4B4;">나의 게시글</td>
</tr>
</table>

<article class="boardArticle">
<table style="margin-top:15px">
    <thead>
        <tr style="font-size:15px">
            <th class="no">번호</th>
            <th class="category">카테고리</th>
            <th class="title">제목</th>
            <th class="date">등록일</th>
            <th class="hit">조회</th>
            <th class="hit">추천</th>
        </tr>
    </thead>
    <tbody class="new_board_list">
    
    <?php
    
    if(empty($page))
        $page=1;
    $value = ($page-1)*20;

    $user_seq = $connection->query("SELECT seq FROM user WHERE id='".$_SESSION['id']."'")->fetch();
    $dbq = $connection->prepare("SELECT seq,category,title,created,hit,recmd FROM board_free WHERE writer_seq='".$user_seq['seq']."' UNION ALL
                               SELECT seq,category,title,created,hit,recmd FROM board_humor WHERE writer_seq='".$user_seq['seq']."' ORDER BY created DESC LIMIT :value,20");
    $dbq->bindParam(":value",$value,PDO::PARAM_INT);
    $dbq->execute();
    while($my_board = $dbq->fetch()){
    ?>
        <tr>
        <td class="no"><?php echo $my_board['seq']?></td>
        <td class="category"><?php echo $my_board['category']?></td>
        
        <td class="title">
            <a href='/board/view.php?index=<?php echo $my_board['seq']?>&category=<?php echo $my_board['category']?>'>
            <?php echo $my_board['title']?>
            </a>
        </td>
        
        <td class="date" style="font-size:13px"><?php echo substr($my_board['created'],0,16);?></td>
        <td class="hit" style="font-size:11px"><?php echo $my_board['hit']?></td>
        <td class="hit"><?php echo $my_board['recmd']?></td>
        </tr>
    <?php 
    }
    ?>
    </tbody>
</table>
</article>

<div id="divPaging">
		<?php
		$row = $connection->query("SELECT count(*) FROM board_free WHERE writer_seq='".$user_seq['seq']."'")->fetchColumn();
        $row = $row + $connection->query("SELECT count(*) FROM board_humor WHERE writer_seq='".$user_seq['seq']."'")->fetchColumn();
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
			echo "<a href=\"/user/MYSCREEN.php?type=my_board&page=".($startpage-1).">◀</a>";
		for($count=$startpage;$count<=$endpage;$count++){
			if($count==$page)
				echo "<a href=\"/user/MYSCREEN.php?type=my_board&page=".$count."\" style=\"text-decoration:underline;color:blue\">[".$count."]</a>";
			else
				echo "<a href=\"/user/MYSCREEN.php?type=my_board&page=".$count."\">".$count."</a>";
		}

		if($endpage!=$max_page_num)
			echo "<a href=\"/user/MYSCREEN.php?type=my_board&page=".($endpage+1).">▶</a>";
		?>

		<center>
	</div>
</section>