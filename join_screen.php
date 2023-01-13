<!DOCTYPE html>
<html lnag="ko">
    <head>
        <meta charset="UTF-8">
        <title>회원가입</title>
        <link rel="stylesheet" href="css/joing.css">
        <!--script-->
        <script src="js/jquery-3.3.1.min.js"></script>
        
    </head>
    <body>
        
       
        <!-- header_m -->
                    <div id="header_m">

           <a href="index.php" class="logo"><img src="img/logo1.png" style="width: 160px; height:140px; object-fit:cover;"></a>
        </div>


        <!-- wrapper -->
        <div id="wrapper">

            <!-- content-->
            <div id="content">
            <form name="joinform" method="POST" action="join.php">
                <!-- ID -->
                <div>
                    <h3 class="join_title">
                        <label for="id">아이디</label>
                    </h3>
                    <span class="box int_id">
                        <input type="text" id="id" name="id" class="int" maxlength="20" placeholder="아이디를 입력해주세요.">
                    </span>
                    <span class="error_next_box"></span>
                </div>

                <!-- PW1 -->
                <div>
                    <h3 class="join_title"><label for="pswd1">비밀번호</label></h3>
                    <span class="box int_pass">
                        <input type="text" id="pswd1" name="pw" class="int" maxlength="20" placeholder="비밀번호를 입력해주세요.">
                        <span id="alertTxt">사용불가</span>
                        <img src="img/lock.PNG" id="pswd1_img1" class="pswdImg">
                    </span>
                    <span class="error_next_box"></span>
                </div>

                <!-- PW2 -->
                <div>
                    <h3 class="join_title"><label for="pswd2">비밀번호 재확인</label></h3>
                    <span class="box int_pass_check">
                        <input type="text" id="pswd2" class="int" maxlength="20" placeholder="비밀번호 재확인을해주세요.">
                        <img src="img/lock.PNG" id="pswd2_img1" class="pswdImg">
                    </span>
                    <span class="error_next_box"></span>
                </div>

                <!-- NAME -->
                <div>
                    <h3 class="join_title"><label for="name">이름</label></h3>
                    <span class="box int_name">
                        <input type="text" id="name" name="name" class="int" maxlength="20" placeholder="이름을 입력해주세요.">
                    </span>
                    <span class="error_next_box"></span>
                </div>
                 
                <!-- birth -->
                <div>
                    <h3 class="join_title"><label for="yy">생년월일</label></h3>
                    <div id="bir_wrap">
                    <span class="box int_name">
                        <input type="text" id="name" name="year" class="int" maxlength="20" placeholder="생년월일 (-) 를빼고 입력해주세요. 예) 19990303">
                    </span>
                    <span class="error_next_box"></span>
                </div>
             </div>


                <!-- NICKNAME -->
                <div>
                    <h3 class="join_title"><label for="nickname">닉네임</label></h3>
                    <span class="box int_name">
                        <input type="text" id="name" name="nickname" class="int" maxlength="20" placeholder="닉네임을 입력해주세요.">
                                             
                    </span>
                    <span class="error_next_box">필수 정보입니다.</span>
                </div>

                <!-- EMAIL -->
                <div>
                    <h3 class="join_title"><label for="email">이메일<span class="optional"></span></label></h3>
                    <span class="box int_email">
                        <input type="text" id="email" name="email" class="int" maxlength="100" placeholder="선택입력">
                    </span>
                    <span class="error_next_box">이메일 주소를 다시 확인해주세요.</span>    
                </div>

                <!-- MOBILE -->
                <div>
                    <h3 class="join_title"><label for="phoneNo">휴대전화</label></h3>
                    <span class="box int_mobile">
                        <input type="tel" id="mobile" name="phone" class="int" maxlength="16" placeholder="전화번호를  입력해주세요.">
                    </span>
                    <span class="error_next_box"></span>    
                </div>


                <!-- JOIN BTN-->
                <div class="btn_area">
                    <input type="submit" style="font-weight:800" id="btnJoin" value="가입하기">
                   
                </div>
               </form>

                

            </div> 
            <!-- content-->

        </div> 
        <!-- wrapper -->
    <script src="js/joins.js"></script>
        
        <br>
        <!--footer-->
       <footer>
      
       </footer>
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
   </div> 
</body>
</html>