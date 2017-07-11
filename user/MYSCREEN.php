<?php
session_start();
include("../DBcontent/PDO.php");
$page = $_GET['page'];
$type = $_GET['type'];
$category = $_GET['category'];
class Category{
	const best = "0";
	const free = "1";
	const humor = "2";
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
            function comment_check_all() {
                for(i=0; i < comment_form.comment_seq.length; i++) {
                    comment_form.comment_seq[i].checked = true;
                }
            }
            function comment_uncheck_all() {
                for(i=0; i < comment_form.comment_seq.length; i++) {
                    comment_form.comment_seq[i].checked = false;
                }
            }
            function scrap_check_all() {
                for(i=0; i < comment_form.comment_seq.length; i++) {
                    comment_form.comment_seq[i].checked = true;
                }
            }
            function scrap_uncheck_all() {
                for(i=0; i < comment_form.comment_seq.length; i++) {
                    comment_form.comment_seq[i].checked = false;
                }
            }
            function formSubmit() {
                document.getElementById("frm1").submit();
            }
            function press(f){
                if(event.keyCode == 13){ //javascript에서는 13이 enter키를 의미함
                frm1.submit(); //formname에 사용자가 지정한 form의 name입력 
                } 
            }
            
            
        </script>
        <style type="text/css">
            a:hover{
                text-decoration:underline;
            }
            a{
                color:black;
                text-decoration:none;
            }
            section input[type=button],section input[type=submit] { 
            width: 150px; 
            height: 40px;
            
            background-color: orange; 
            color: white;  
            margin: 15px 0; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; } 
            section input[type=button]:hover { background-color: OrangeRed; } 
            section input[type=submit]:hover { background-color: OrangeRed; } 
        </style>
        
    </head>
    <body bgcolor=black>
        <div id ="wrap">

           <?php include("../include/header.php"); ?>  <!-- 해더 -->

           <?php include("../include/nav.php"); ?> <!-- 왼쪽 로그인 -->
           
           <?php 
           switch($type){
               case "my_board": include("./my_board.php"); break;
               case "my_comment": include("./my_comment.php"); break;
               case "my_profile": include("./my_profile.php"); break;
               case "my_scrap": include("./my_scrap.php"); break;
               default : echo "<section>error</section>"; break;
           }
           
           ?>
        
            <div class="clear"></div>
            
        </div>
 
    </body>
</html>