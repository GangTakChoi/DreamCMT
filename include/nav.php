
<nav>  <!-- 사이드 메뉴 -->
<?php
if($_SESSION['is_login'] == true){
?>
    <div id="login" style="padding-top:30px; text-align:center">
    <?php
    echo $_SESSION['nickname']."님 환영합니다<br>";
    echo "메일함  : <a href=\"#\">[1/100]</a>";
    ?>
    <br><br>
    <table height=40 onclick="location.href='/user/logout.php'"  style="margin:5px 0">
        <tr bgcolor=black id="join_button"><td width=205 align="center"><a href="#" style="text-decoration:none;color:white;">로그아웃</a></td></tr>
    </table>
    </div>
     <div id="login" style="padding:0px; height:193px">
        <div class="vertical_menu" role="navigation">
            <ul>
                <li>
                    <label onclick="location.href='/index.php'">나의 댓글</label>
                </li>
                <li>
                    <label>나의 게시글</label>
                </li>
                <li>
                    <label>나의 d스크랩목록</label>
                </li>
                <li>
                    <label>내 정보 관리</label>
                </li>
            </ul>
        </div>
    </div>

</nav>
<?php
}else{
?>
    <div id="login">
    <table class="login_table">
    <form id="frm1" action="/user/login.php" method="POST">
        <tr>
            <td class="td_disign" width=130><input type="text" id="id" name="id" placeholder="아이디" onkeypress="JavaScript:press(this.form)" tabindex=1> </td>
            <td class="td_disign" rowspan=2 width=60><a href="#" class="button" onclick="formSubmit(); return false;" tabindex=3>로그인</a></td>
        </tr>
        <tr>
            <td class="td_disign"><input type="password" id="pw" name="pw" placeholder="비밀번호" onkeypress="JavaScript:press(this.form)" tabindex=2></td>
        </tr>
    </form>
        <tr>
            <td colspan=2 style="font-size:15px; text-align:center"><a href="#">아이디</a> / <a href="#">비밀번호</a> 찾기</font></td>
        </tr>
        <tr>
    </table>
    <table height=40 onclick="location.href='/user/member_join_form.php'"  style="margin:15px 0">
        <tr bgcolor=black id="join_button"><td width=205 align="center"><a href="#" style="text-decoration:none;color:white;">회원가입</a></td></tr>
    </table>
    </div>
    </nav>
<?php
}
?>
