<?php
session_start();
include("../DBcontent/PDO.php");
$seq = $_POST['seq'];
$what = $_GET['what'];


if($_SESSION['is_login']==true){


    
    if($what==0){ // 게시판 추천버튼 클릭한경우
        $dbq = $connection->prepare("SELECT * FROM board_free_recmd WHERE seq_board=:seq AND id=:id");
        $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
        $dbq->bindParam(':id',$_SESSION['id'],PDO::PARAM_STR);
        $dbq->execute();
        $row = $dbq->fetch();
        if(empty($row)){ // 해당 게시글을 해당 아이디가 추천한 이력이 없을 경우
            $dbq = $connection->prepare("INSERT INTO board_free_recmd VALUES(:id,:seq)");
            $dbq->bindParam(':id',$_SESSION['id'],PDO::PARAM_STR);
            $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
            $dbq->execute();

            $dbq = $connection->prepare("UPDATE board_free SET recmd=recmd+1 where seq=:seq");
            $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
            $dbq->execute();
            
            $dbq = $connection->prepare("SELECT recmd FROM board_free WHERE seq=:seq");
            $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
            $dbq->execute();
            $row = $dbq->fetch();

            if($row['recmd']==10){  //추천수가 10개가 되었을때

                $dbq = $connection->prepare("SELECT seq,title,writer,hit,recmd FROM board_free WHERE seq=:seq");
                $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
                $dbq->execute();
                $row = $dbq->fetch();
                
                $dbq = $connection->query("INSERT INTO board_best(seq_board,category,title,writer,hit,recmd)
                    VALUES('".$row['seq']."','board_free','".$row['title']."','".$row['writer']."','".$row['hit']."','".$row['recmd']."')");
                
            }
            echo "추천 ".$row['recmd'];
        }else{
            echo -1;
        }
        
    }else{ //댓글 공감/비공감을 클릭한 경우
        $dbq = $connection->prepare("SELECT * FROM comment_free_ip WHERE seq_comment=:seq and id=:id");
        $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
        $dbq->bindParam(':id',$_SESSION['id'],PDO::PARAM_STR);
        $dbq->execute();
        $row = $dbq->fetch();
        if(empty($row)){  // 해당 댓글에 공감/비공감을 누른적이 없을경우
        
            $dbq = $connection->prepare("INSERT INTO comment_free_ip VALUES(:id,:seq)");
            $dbq->bindParam(':id',$_SESSION['id'],PDO::PARAM_STR);
            $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
            $dbq->execute();
            if($what==1){ // 공감을 누른경우
                $dbq = $connection->prepare("UPDATE comment_free SET recmd=recmd+1 WHERE seq=:seq");
                $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
                $dbq->execute();

                $dbq = $connection->prepare("SELECT recmd FROM comment_free WHERE seq=:seq");
                $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
                $dbq->execute();
                $row = $dbq->fetch();
                echo $row[0];
            }else if($what==2){ //비공감을 누른경우
                $dbq = $connection->prepare("UPDATE comment_free SET not_recmd=not_recmd+1 WHERE seq=:seq");
                $dbq->bindParam(':seq',$seq,PDO::PARAM_INT);
                $dbq->execute();

                $dbq = $connection->prepare("SELECT not_recmd FROM comment_free WHERE seq=:seq");
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