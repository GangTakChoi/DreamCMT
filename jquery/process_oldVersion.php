<?php
session_start();
include("../DBcontent/DB.php");
$seq = $_POST['seq'];
$what = $_GET['what'];


if($_SESSION['is_login']==true){


    
    if($what==0){ // 게시판 추천버튼 클릭한경우
        $result = mysql_query("select * from board_free_recmd where seq_board=$seq and id='".$_SESSION['id']."'");
        $row = mysql_fetch_array($result);
        if(!empty($seq)){
            mysql_query("insert into board_free_recmd value('".$_SESSION['id']."','$seq')");
            mysql_query("update board_free set recmd=recmd+1 where seq=$seq");
            
            $result = mysql_query("select recmd from board_free where seq=$seq");
            $row = mysql_fetch_array($result);
            if($row['recmd']==10){  //추천수가 10개가 되었을때
                $result = mysql_query("select seq,title,writer,hit,recmd from board_free where seq=$seq");
                $row = mysql_fetch_array($result);
                mysql_query("insert into board_best(seq_board,category,title,writer,hit,recmd) 
                value('".$row['seq']."','board_free','".$row['title']."','".$row['writer']."','".$row['hit']."','".$row['recmd']."')");
                
            }
            echo "추천 ".$row['recmd'];
        }else{
            echo -1;
        }
        
    }else{
        $result = mysql_query("select * from comment_free_ip where seq_comment=$seq and id='".$_SESSION['id']."'");
        $row = mysql_fetch_array($result);
        if(empty($row)){  // 해당 댓글에 공감/비공감을 누른적이 없을경우
        
            mysql_query("insert into comment_free_ip value('".$_SESSION['id']."','$seq')");
            if($what==1){ // 공감을 누른경우
                $result = mysql_query("update comment_free set recmd=recmd+1 where seq=$seq");
                $result = mysql_query("select recmd from comment_free where seq=$seq");
                $row = mysql_fetch_array($result);
                echo $row[0];
            }else if($what==2){ //비공감을 누른경우
                $result = mysql_query("update comment_free set not_recmd=not_recmd+1 where seq=$seq");
                $result = mysql_query("select not_recmd from comment_free where seq=$seq");
                $row = mysql_fetch_array($result);
                echo $row[0];
            }else{
                echo -3; // 조작된 또는 엉뚱한 값을 전달받았을 경우
            }
        }else{
            echo -1; //이미 공감/비공감을 하였을 경우
        }
    }
    
}else{
    echo -2; // 로그인을 하지 않았을 경우
}





?>