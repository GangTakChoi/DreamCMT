<?php session_start();?>
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
            document.getElementById("frm1").submit();
        }
        function press(f){ 
            if(event.keyCode == 13){ //javascript에서는 13이 enter키를 의미함
                frm1.submit(); //formname에 사용자가 지정한 form의 name입력 
            } 
        }
        </script>
        <style type="text/css">
        form{
            margin:0 0;
            margin-left:auto;
            margin-right:auto;
        }
        form fieldset {
            padding:10px 0 20px 5px;
            border:none;
        }
        form legend{
            font-size: 20px;
            border-bottom: 2px dotted pink;
            width:100%;
            padding:5px 0;
            font-weight: bold;
        }
        form label{
            width:160px;
            float:left;
            margin:5px 0;
        }
        .clear{
            clear:both;
        }
        #chk_mail, #interest{
            width:30px;
        }
        #button{
            text-align:center;
        }
        </style>
    </head>
    <body bgcolor=black>
        <div id ="wrap">
            
            <?php include("../include/header.php"); ?>  <!-- 해더 -->

            <?php include("../include/nav.php"); ?> <!-- 왼쪽 로그인 -->
            
            <section> <!-- 본문 -->
                <form action="member_join_pdo.php" name="frm" id="frm" method="POST">
                <fieldset>
                <legend>필수 사항</legend>
                <label for="mbname">이름</label>
                <input type="text" id="mbname" name="mbname" maxlength=11>
                <div class="clear"></div>

                <label for="mbnickname">닉네임</label>
                <input type="text" id="mbnickname" name="mbnickname" maxlength=10>
                10 byte 이하(한글 5자/영어 10자 이하)
                <div class="clear"></div>

                <label for="mbid">아이디</label>
                <input type="text" id="mbid" name="mbid" maxlength=15>
                <button>중복확인</button> &nbsp;영어/숫자 만 가능 15자 이하
                <div class="clear"></div>

                <label for="'mbpw"> 비밀번호</label>
                <input type="password" id="mbpw" name="mbpw" placeholder="영어/숫자포함 6자 이상" maxlength=20>
                영어/숫자/특수기호 만 가능 6자 이상 20자 이하
                <div class="clear"></div>

                <label for="mbpw_re"> 비밀번호 확인 </label>
                <input type="password" id="mbpw_re" name="mbpw_re" maxlength=>
                <div class="clear"></div>

                <label for="email">이메일</label>
                <input type="text" name="email" maxlength=20> @
                <input type="text" name="email_dns" maxlength=20>
                <select name="emailaddr">
                    <option value="">직접입력</option>
                    <option value="daum.net">daum.net</option>
                    <option value="empal.com">empal.com</option>
                    <option value="gmail.com">gmail.com</option>
                    <option value="hanmail.net">hanmail.net</option>
                    <option value="msn.com">msn.com</option>
                    <option value="naver.com">naver.com</option>
                    <option value="nate.com">nate.com</option>
                </select>
                <div class="clear"></div>
                </fieldset>
                <div id="button">
                    <input type="submit" value="회원 가입">
                    <input type="reset" value="취소">
                </div>
                </form>
            </section>

            <div class="clear"></div>
            
        </div>
        <footer> <!--저작권 정보-->
            footer
        </footer>
    </body>
</html>