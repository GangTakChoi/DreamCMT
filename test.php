<?php
$dbh = new PDO('mysql:host=localhost;dbname=dreamcmt', 'root', '123123');
$stmt = $dbh->prepare('SELECT * FROM board_free WHERE seq = :seq');
$stmt->bindParam(':seq', $id, PDO::PARAM_INT);
$id = 1;
$stmt->execute();
$topic = $stmt->fetch();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
    </head>   
    <body>
        <form action="./process.php?mode=modify" method="POST">
            <p>제목 : <input type="text" name="title" value="<?=htmlspecialchars($topic['title'])?>"></p>
            <p>본문 : <textarea name="description" id="" cols="30" rows="10"><?=htmlspecialchars($topic['seq'])?></textarea></p>
            <p><input type="submit" /></p>
        </form>
    </body>
</html>