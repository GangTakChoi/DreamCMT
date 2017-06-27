<?php
session_start();
include("../DBcontent/PDO.php");
$seq = $_POST['seq'];
$category = $_GET['category'];
$what = $_GET['what'];
//게시판 테이블이름 변수
//게시판 중복추천 방지 테이블이름 변수
//해당 게시판의 댓글 테이블이름 변수
//댓글 테이블 중복 공감/비공감 방지 테이블이름 변수
class Category{
	const best = "0";
	const free = "1";
	const humor = "2";
}
switch($category){
	case Category::free: 
		$board_table = "board_free";
		$board_recmd_table = "board_free_recmd";
        $comment_table = "comment_free";
		$comment_ip_table = "comment_free_ip";
		
	break;
	case Category::humor: 
		$board_table = "board_humor";
		$board_recmd_table = "board_humor_recmd";
        $comment_table = "comment_humor";
		$comment_ip_table = "comment_humor_ip";
	break;
}

if($_SESSION['is_login']==true){


    
    if($what==0){ // 게시판 추천버튼 클릭한경우
        
        $dbq = $connection->prepare("SELECT * FROM $board_recmd_table WHERE seq_board=:seq AND id=:id");
        $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
        $dbq->bindParam(':id',$_SESSION['id'],PDO::PARAM_STR);
        $dbq->execute();
        $row = $dbq->fetch();
        if(/*empty($row)*/true){ // 해당 게시글을 해당 아이디가 추천한 이력이 없을 경우
            $dbq = $connection->prepare("INSERT INTO $board_recmd_table VALUES(:id,:seq)");
            $dbq->bindParam(':id',$_SESSION['id'],PDO::PARAM_STR);
            $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
            $dbq->execute();

            $dbq = $connection->prepare("UPDATE $board_table SET recmd=recmd+1 where seq=:seq");
            $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
            $dbq->execute();
            
            $dbq = $connection->prepare("SELECT recmd FROM $board_table WHERE seq=:seq");
            $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
            $dbq->execute();
            $row = $dbq->fetch();

            if($row['recmd']==10){  //추천수가 10개가 되었을때

                $dbq = $connection->prepare("SELECT seq,recmd FROM $board_table WHERE seq=:seq");
                $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
                $dbq->execute();
                $row = $dbq->fetch();
                
                $dbq = $connection->query("INSERT INTO board_best(seq_board,board_table,comment_table,category)
                    VALUES('".$row['seq']."','".$board_table."','".$comment_table."','".$category."')");
                
            }
            echo "추천 ".$row['recmd'];
        }else{
            echo -1;
        }
        
    }else if($what==3){ //스크랩을 클릭했을 경우
     
        $user_seq = $connection->query("SELECT seq FROM user WHERE id='".$_SESSION['id']."'")->fetch();
        
        $dbq = $connection->prepare("SELECT seq FROM user_myscrap WHERE user_seq='".$user_seq['seq']."' AND
                                        category=:category AND board_seq=:board_seq");
        
        $dbq->bindParam(":category",$category,PDO::PARAM_INT);
        $dbq->bindParam(":board_seq",$seq,PDO::PARAM_INT);
        $dbq->execute();
        $row = $dbq->fetch();
        
        if(!empty($row)){
            echo -1; //이미 스크랩을 한 게시글이라면
        }else{
            $dbq = $connection->prepare("INSERT INTO user_myscrap(user_seq,category,board_seq) VALUES(:user_seq,:category,:board_seq)");
            $dbq->bindParam(":user_seq",$user_seq['seq'],PDO::PARAM_INT);
            $dbq->bindParam(":category",$category,PDO::PARAM_INT);
            $dbq->bindParam(":board_seq",$seq,PDO::PARAM_INT);
            $dbq->execute();
           die();
        }

    }else{ //댓글 공감/비공감을 클릭한 경우
    
        $dbq = $connection->prepare("SELECT * FROM $comment_ip_table WHERE seq_comment=:seq and id=:id");
        $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
        $dbq->bindParam(':id',$_SESSION['id'],PDO::PARAM_STR);
        $dbq->execute();
        $row = $dbq->fetch();
        if(/*empty($row)*/true){  // 해당 댓글에 공감/비공감을 누른적이 없을경우
        
            $dbq = $connection->prepare("INSERT INTO $comment_ip_table VALUES(:id,:seq)");
            $dbq->bindParam(':id',$_SESSION['id'],PDO::PARAM_STR);
            $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
            $dbq->execute();
            if($what==1){ // 공감을 누른경우
                $dbq = $connection->prepare("UPDATE $comment_table SET recmd=recmd+1 WHERE seq=:seq");
                $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
                $dbq->execute();

                $dbq = $connection->prepare("SELECT recmd FROM $comment_table WHERE seq=:seq");
                $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
                $dbq->execute();
                $row = $dbq->fetch();
                echo $row[0];
            }else if($what==2){ //비공감을 누른경우
                $dbq = $connection->prepare("UPDATE $comment_table SET not_recmd=not_recmd+1 WHERE seq=:seq");
                $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
                $dbq->execute();

                $dbq = $connection->prepare("SELECT not_recmd FROM $comment_table WHERE seq=:seq");
                $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
                $dbq->execute();
                $row = $dbq->fetch();
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