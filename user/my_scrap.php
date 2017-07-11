<section>
<table style="margin-left:auto;margin-right:auto">
<tr>
<td style="font-size:23px;padding:8px 20px 8px 20px;box-shadow:5px 5px 10px #cccccc;background-color:#FFB4B4;">나의 스크랩목록</td>
</tr>
</table>

<article class="boardArticle">
<input type="submit" value="선택된 댓글 삭제"></input>
<input type='button' onclick='scrap_check_all();' value='모두 선택' />
<input type='button' onclick='scrap_uncheck_all();' value='모두 해제' />
<table style="margin-top:15px">
    <thead>
        <tr style="font-size:15px">
            <th class="no" style="width:20px"></th>
            <th class="no">번호</th>
            <th class="category">카테고리</th>
            <th class="title">제목</th>
            <th class="author">작성자</th>
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
    $dbq = $connection->prepare("SELECT * FROM user_myscrap WHERE user_seq='".$user_seq['seq']."' ORDER BY seq DESC LIMIT :value,20");
    $dbq->bindParam(":value",$value,PDO::PARAM_INT);
    $dbq->execute();
    while($my_scrap = $dbq->fetch()){
        switch($my_scrap['category']){
            case Category::best : $category_name = "베스트게시판";
            break; //0
            case Category::free : $category_name = "자유"; $comment_table = "comment_free";
                                  $board_table = "board_free";
            break; //1
            case Category::humor : $category_name = "유머"; $comment_table = "comment_humor";
                                  $board_table = "board_humor";
            break; //2
            default : $category_name = "자유"; $comment_table = "comment_free"; $board_table = "board_free"; 
            break;
        }
        $comment_count = $connection->query("SELECT count(*) FROM $comment_table WHERE seq_board=".$my_scrap['board_seq'])->fetchColumn();
        $board = $connection->query("SELECT * FROM $board_table WHERE seq='".$my_scrap['board_seq']."'")->fetch();
    ?>
        <tr>
        <td class="no" style="width:20px"><input type="checkbox" name="scrap_seq[]" id="scrap_seq"/></td>
        <td class="no"><?php echo $my_scrap['seq']?></td>
        <td class="category"><?php echo $category_name?></td>
        
        <td class="title">
            <a href='/board/view.php?index=<?php echo $board['seq']?>&category=<?php echo $my_scrap['category']?>'>
            <?php 
            if(empty($board))
                echo "<a style='color:#C1C1C1'>삭제된글입니다</a>"; 
            else           
                echo $board['title'];?>
            </a>
            <?php if($comment_count>0) {echo "<span style='color:red'> [$comment_count]</span>";}?>
        </td>
        <td class="author"><?php echo $board['writer']?></td>
        <td class="date" style="font-size:13px"><?php echo substr($board['created'],0,16);?></td>
        <td class="hit" style="font-size:11px"><?php echo $board['hit']?></td>
        <td class="hit"><?php echo $board['recmd']?></td>
        </tr>
    <?php 
    }
    ?>
    </tbody>
</table>
</article>

<div id="divPaging">
		<?php
		$row = $connection->query("SELECT count(*) FROM user_myscrap WHERE user_seq='".$user_seq['seq']."'")->fetchColumn();
        
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