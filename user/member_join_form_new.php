<?php session_start();?>
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
        
        function formSubmit()
        {
            document.getElementById("frm1").submit();
        }
        function press(f){
            if(event.keyCode == 13){ //javascript에서는 13이 enter키를 의미함
            frm1.submit(); //formname에 사용자가 지정한 form의 name입력 
            } 
        }
        
        function checkfield(){
            
            
            if(document.addjoin.name.value==""){ //id값이 없을 경우
            alert("이름을 입력하세요");         //메세지 경고창을 띄운 후
            document.addjoin.name.focus();     // id 텍스트박스에 커서를 위치
            exit;
            
            }else if(document.addjoin.nickname.value==""){ //id값이 없을 경우
            alert("닉네임을 입력하세요");         //메세지 경고창을 띄운 후
            document.addjoin.nickname.focus();     // id 텍스트박스에 커서를 위치
            exit;
            
            }else if(document.addjoin.id.value==""){ //id값이 없을 경우
            alert("아이디를 입력하세요");         //메세지 경고창을 띄운 후
            document.addjoin.id.focus();     // id 텍스트박스에 커서를 위치
            exit;
            
            }else if(document.addjoin.pw.value==""){
            alert("비밀번호를 입력하세요");
            document.addjoin.pw.focus();
            exit;
            
            }else if(document.addjoin.pw_re.value==""){
            alert("비밀번호확인을 입력하세요");
            document.addjoin.pw_re.focus();
            exit;
            
            }else if(document.addjoin.email.value==""){
            alert("이메일를 입력하세요");
            document.addjoin.email.focus();
            exit;
            
            }
            if(document.addjoin.name.value.length>5){
                alert("이름은 5자 이내로 입력해주세요.");
                document.addjoin.name.focus();
                exit;
            }else if(document.addjoin.nickname.value.length>5){
                alert("닉네임은 5자 이내로 입력해주세요.");
                document.addjoin.nickname.focus();
                exit;
            }else if(document.addjoin.id.value.length<5 || document.addjoin.id.value.length>15){
                alert("아이디는 5자~15자 이내로 입력해주세요.");
                document.addjoin.id.focus();
                exit;
            }else if(document.addjoin.pw.value.length>20 || document.addjoin.pw.value.length<8){
                alert("비번은 8자~20자 이내로 입력해주세요.");
                document.addjoin.pw.focus();
                exit;
            }
           
            if(document.addjoin.pw.value!=document.addjoin.pw_re.value){
            //비밀번호와 비밀번호확인의 값이 다를 경우
            
            alert("비밀번호가 일치하지않습니다.");
            document.addjoin.pw.focus();
            exit;
            
            }
            var score = 0;
            //var expreg = /[~!@\#$%<>^&*\()\-=+_\’]/;
            if (document.addjoin.pw.value.match(/[a-z]/) || document.addjoin.pw.value.match(/[A-Z]/))
                score++;
            // at least one num char
            if (document.addjoin.pw.value.match(/[0-9]+/))
                score++;
            // at least one special char
            if (document.addjoin.pw.value.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)-]/))
                score++;
            if(score<2){
                alert("영문/숫자/특수문자 중 2가지 이상 조합하여야합니다.");
                exit;
            }

            var exptext = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;
             
            if(exptext.test(document.addjoin.email.value)==false){
            //이메일 형식이 알파벳+숫자@알파벳+숫자.알파벳+숫자 형식이 아닐경우
            
            alert("이 메일형식이 올바르지 않습니다.");
            document.addjoin.email.focus();
            exit;
            }
            document.addjoin.submit();
           
        }
        
        
        </script>
        <style type="text/css">
        div.formtag input[type=text],div.formtag input[type=password], select { 
        width: 100%; /*입력 칸 (input field) 의 폭을 지정하기 위해, 폭 속성 (width property) 를 사용하였습니다.*/ padding: 12px 20px; 
        margin: 8px 0; 
        display: inline-block; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
        box-sizing: border-box; } 
        div.formtag label{
            display:block;
        }
        div.formtag input[type=button] { 
        width: 100%; 
        background-color: orange; 
        color: white; padding: 14px 20px; 
        margin: 8px 0; 
        border: none; 
        border-radius: 4px; 
        cursor: pointer; } 
        div.formtag input[type=button]:hover { background-color: OrangeRed; } 
        div.formtag input[type=text]:focus { background-color: lightblue; border: 3px solid #555; } 
        div.formtag input[type=password]:focus { background-color: lightblue; border: 3px solid #555; } 
        div.formtag { 
        border-radius: 5px; 
        background-color: #f2f2f2; 
        padding: 40px; 
        height:100%;
        } 
        </style>
    </head>
    <body bgcolor=black>
        <div id ="wrap">
            
            <?php include("../include/header.php"); ?>  <!-- 해더 -->

            <?php include("../include/nav.php"); ?> <!-- 왼쪽 로그인 -->
            
            <section style="padding:0px 0px 0px 0px;height:auto"> <!-- 본문 -->
                <form class="join" action="member_join_pdo.php" name="addjoin" id="addjoin" method="POST"> 
                    <div class="formtag">
                        <center><h3>회원가입</h3></center> 

                        <label id="name">이름</label> 
                        <input type="text" id="name" name="name" maxlength=5 style="ime-mode:disabled"> 
                        <label id="nickname">닉네임 <span style="color:blue;font-size:13px">5자 이하</span></label> 
                        <input type="text" id="nickname" name="nickname" style="width:86%" maxlength=5> 
                        <input type="button" value="중복확인" style="width:103px" class="nick_check">
                        <label id="id">아이디 <span style="color:blue;font-size:13px">영문 5~15자 이하</span></label>
                        <input type="text" id="id" name="id"  style="width:86%" maxlength=15> 
                        <input type="button" value="중복확인" style="width:103px" class="id_check"> 
                        <label id="pw">비밀번호 <span style="color:blue;font-size:13px">영문/숫자/특수문자 중 2가지 이상 조합 8~20자이하</span></label>
                        <input type="password" id="pw" name="pw" maxlength=20>
                        <label id="pw_re">비밀번호 재입력</label>
                        <input type="password" id="pw_re" name="pw_re" maxlength=20>
                        <label id="email">E-Mail<br></label>
                        <input type="text" id="email" name="email" style="width:100%" maxlength=40> 
                        <input type="button" value="가입하기" onclick="checkfield()"> 
                    </div>
                </form> 
                <script>
                        $('.id_check').click(function(){
                            $.ajax({
                                url:'../jquery/process.php?what=join&kind=id_check',
                                type:'post',
                                data:$('.join').serialize(),
                                success:function(data){
                                    alert(data);
                                }

                            })
                        })
                        $('.nick_check').click(function(){
                            $.ajax({
                                url:'../jquery/process.php?what=join&kind=nick_check',
                                type:'post',
                                data:$('.join').serialize(),
                                success:function(data){
                                    alert(data);
                                }

                            })
                        })
                </script>
                
            </section>

        <div class="clear"></div>
                
        </div>
    </body>
</html>

