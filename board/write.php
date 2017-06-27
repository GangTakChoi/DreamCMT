<?php 
session_start();
if(empty($_SESSION['is_login'])){
    ?>
    <script>
        alert("로그인하셔야합니다.");
        history.go(-1);
    </script>
    <?php
}
$category = $_GET['category'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Insert title here</title>
        <link rel="stylesheet" href="/css/basic.css">
        <link rel="stylesheet" href="/css/normalize.css" />
	    <link rel="stylesheet" href="/css/board.css" />
        <script>
        function formSubmit()
        {
            document.getElementById("freeboard_form").submit();
        }
        </script>
        <style type="text/css">
        .board_write_button a {
            -webkit-transition: all 200ms cubic-bezier(0.390, 0.500, 0.150, 1.360);
            -moz-transition: all 200ms cubic-bezier(0.390, 0.500, 0.150, 1.360);
            -ms-transition: all 200ms cubic-bezier(0.390, 0.500, 0.150, 1.360);
            -o-transition: all 200ms cubic-bezier(0.390, 0.500, 0.150, 1.360);
            transition: all 200ms cubic-bezier(0.390, 0.500, 0.150, 1.360);
            display: block;
            margin: 0;
            width: 62px;
            height:30px;
            text-decoration: none;
            border-radius: 0px;
            padding: 3px 0 0 9px;
            font-size:15px;
            box-sizing:border-box;
        }

        .board_write_button a.button {
            color: rgba(30, 22, 54, 0.6);
            box-shadow: rgba(30, 22, 54, 0.4) 0 0px 0px 2px inset;
        }

        .board_write_button a.button:hover {
            color: rgba(255, 255, 255, 0.85);
            box-shadow: rgba(30, 22, 54, 0.7) 0 0px 0px 40px inset;
        }
        .board_register_table{
            width:868px;
        }
        .board_name{
            height:60px;
            background-color:#73FFFF;
            text-align:center;
            font-family: Times;
            font-size:20px;
        }
        .title{
            height:50px;
            border-bottom:1px solid #D6D6D6;
        }
        .content{
            height:500px;
            border-bottom:1px solid #D6D6D6;
        }
        .title .name{
            background-color:#F3F3F3;
            width:100px;
            text-align:center;
        }
        .title .input{
            background-color:white;
            padding:0 0 0 15px;
        }
        .content .name{
            background-color:#F3F3F3;
            width:100px;
            text-align:center;
        }
        .content .input{
            background-color:white;
            padding:0 0 0 15px;
        }
        .border_register_section{
            padding:0px;
        }
        .board_button_layout{
            width:868px;
            height:190px;
            padding:40px;
            box-sizing:border-box;
            text-align:center;
        }
        .board_button_layout a {
            -webkit-transition: all 200ms cubic-bezier(0.390, 0.500, 0.150, 1.360);
            -moz-transition: all 200ms cubic-bezier(0.390, 0.500, 0.150, 1.360);
            -ms-transition: all 200ms cubic-bezier(0.390, 0.500, 0.150, 1.360);
            -o-transition: all 200ms cubic-bezier(0.390, 0.500, 0.150, 1.360);
            transition: all 200ms cubic-bezier(0.390, 0.500, 0.150, 1.360);
            display: block;
            margin: auto;
            width: 90px;
            height:40px;
            text-decoration: none;
            border-radius: 0px;
            padding: 9px 0 0 5px;
            font-size:15px;
            box-sizing:border-box;
        }

        .board_button_layout a.button {
            color: rgba(30, 22, 54, 0.6);
            box-shadow: rgba(30, 22, 54, 0.4) 0 0px 0px 2px inset;
        }

        .board_button_layout a.button:hover {
            color: rgba(255, 255, 255, 0.85);
            box-shadow: rgba(30, 22, 54, 0.7) 0 0px 0px 40px inset;
        }
        </style>
    </head>
    <body bgcolor=black>
        <div id ="wrap">
            <?php include("../include/header.php"); ?>  <!-- 해더 -->

            <?php include("../include/nav.php"); ?> <!-- 왼쪽 로그인 -->

            <section class="border_register_section">
                <form id="freeboard_form" action="board_process.php" method="POST">
                <table class="board_register_table">
                <tr class="title">
                    <td class="name">제목</td><td class="input"><input type="text" style="width:720px;" name="title" maxlength="31"></td>
                </tr>
                <tr class="content">
                    <td class="name">내용</td><td class="input"><textarea style="width:720px; height:460px" name="content"></textarea></td>
                </tr>
                </table>
                <div class="board_button_layout">
                    <!--<input type="submit" value="등록하기" style="width:90px; height:40px" class="button"></input>&nbsp;&nbsp;-->
                    <a class="button" onclick="JavaScript:formSubmit()">등록하기</a>
                </div>
                <input type="hidden" name="category" value="<?php echo $category?>"></input>
                <input type="hidden" name="action" value="board_register"></input>
                </form>
            </section>


            <div class="clear"></div>

        </div>
        <footer> <!--저작권 정보-->
            footer
        </footer>
    </body>
</html>