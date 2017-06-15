<?php
session_start();
include("DBcontent/DB.php");
?>

<!DOCTYPE html>
<html>
    <head>
        
        <meta charset="UTF-8">
        <title>Insert title here</title>
        <link rel="stylesheet" href="css/basic02.css">
        <link rel="stylesheet" href="css/normalize.css" />
	    <link rel="stylesheet" href="css/board.css" />
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

           <?php include("./include/header.php"); ?>  <!-- 해더 -->

           <?php 
              include("./include/nav.php"); 
           ?> <!-- 왼쪽 로그인 -->
           
            <section>
             test
            </section>-- 본문 -->
        
            <div class="clear"></div>
            
        </div>
 
    </body>
</html>