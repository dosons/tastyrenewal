<?php
require("db_connect.php");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0, maximum-scale=1.0">
    <title>Tasty & Recipe</title>
    <link rel="stylesheet" href="css/myalter.css">
    <!--font-->
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css">
    <link rel="stylesheet" href="css/slick.css">
	    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">

    <!--script-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/scrolla.jquery.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
   <div class="wrap">
       <!--header-->
       <header>
		<div class="top">
		<div class="wrapper">
		<ul class="top-menu" style="font-weight: 600;">
<?php
            session_start();
            if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
               $user_id = $_SESSION["userId"];
               $user_name = $_SESSION ["userName"];
?>
                <li class="test"><a href="logout.php"><p>로그아웃</p></a></li>
			    <li class="test"><p style="Color:#4e4e4e;"><?=$user_name?>님</p></li>
<?php
            } else {
?>
        <script>
                alert('로그인 후 이용 하실 수 있습니다.');
                window.close();
	 
	            location.href='login_screen.php';
        </script>
<?php
               
            }
           

?>      		
	    </ul>
		</div>
	    </div>
        
          <span class ="bg"></span>
          <a href="#" class="open"><span class="lnr lnr-menu"></span></a>
          <a href="index.php" class="logo"><img src="img/logo1.png" style="width: 100%;"></a>
          <nav>
             <a href="#" class="close"><span class="lnr lnr-cross"></span></a>
              <ul class="gnb" style="font-weight: 800;">
                  <li><a href="index.php?#about">소개</a></li>
                  <li><a href="recipe_write.php">레시피</a></li>
                  <li><a href="store_list.php">스토어</a></li>
                  <li><a href="free.php">커뮤니티</a></li>
                  <li><a href="event.php">이벤트</a></li>
				  <li><a href="my.php">MY</a></li>
                  <?php
			$query = $db->query("SELECT store_info_num
								FROM store_info AS a
									INNER JOIN mem_info AS b
									ON a.mem_info_num = b.mem_info_num
								WHERE b.mem_info_nickname = '$user_name';");
			$row = $query->fetch();
			$num = $row["store_info_num"];
			if(isset($num)) {
				  ?>
				  <li><a href="myStore.php">내 스토어</a></li>
				 <?php
				}
					?>
				  
              </ul>
          </nav> 
       </header>
       <!--body-->
       <body>
        <hr  style="border: solid 1px rgb(250, 169, 76); width: 20%;margin-top: 205px; margin-left: auto;margin-right: auto;">
        <div class="img">
           <br>
      
        </div>
        <div class="hong">
            <li>회원정보 수정</li>
        </div>
        <br><br>
        
        <form method="POST" action="my_update.php">
         <!-- wrapper -->
         <div id="wrapper">

            <!-- content-->
            <div id="content">
                

                <!-- ID -->
                <div>
                    <h3 class="join_title">
                        <label for="id">닉네임</label>
                    </h3>
                    <span class="box int_id">
                        <input type="text" id="id" name="nickname" class="int" maxlength="20" placeholder="변경 하실 닉네임을 입력해주세요.">
                    </span>
                    <span class="error_next_box"></span>
                </div>
                <!-- PW1 -->
                <div>
                    <h3 class="join_title"><label for="pswd1">비밀번호</label></h3>
                    <span class="box int_pass">
                        <input type="password" id="pswd1" name="password" class="int" maxlength="20" placeholder="새로운 비밀번호를 입력해주세요.">
                        <span id="alertTxt">사용불가</span>
                        
                    </span>
                    <span class="error_next_box"></span>
                </div>

                <!-- PW2 -->
                <div>
                    <h3 class="join_title"><label for="pswd2">비밀번호 재확인</label></h3>
                    <span class="box int_pass_check">
                        <input type="password" id="pswd2" name="passwordCheck" class="int" maxlength="20" placeholder="비밀번호 재확인을 위해 입력해주세요.">
                        
                    </span>
                    <span class="error_next_box"></span>
                </div>

                <!-- EMAIL -->
                <div>
                    <h3 class="join_title"><label for="email">이메일<span class="optional"></span></label></h3>
                    <span class="box int_email">
                        <input type="text" id="email" name="email" class="int" maxlength="100" placeholder="변경 하실 이메일을 입력해주세요.">
                    </span>
                    <span class="error_next_box">이메일 주소를 다시 확인해주세요.</span>    
                </div>

                <!-- MOBILE -->
                <div>
                    <h3 class="join_title"><label for="phoneNo">휴대전화</label></h3>
                    <span class="box int_mobile">
                        <input type="tel" id="mobile" name="phone" class="int" maxlength="16" placeholder="전화번호를 입력해주세요.">
                    </span>
                    <span class="error_next_box"></span>    
                </div>


            </div> 
            <!-- content-->

        </div> 
        

<br><br><br><br>


        <div id="btn4">
        <input type="submit" id="btnJoin" style="border-radius:30px; font-weight:bold;" value="수정하기">
            <br>
        </div>
        </form>
        </body>


   <br><br><br>
       <!--footer-->
       <footer>
           <ul class="sns">
               <li><img src="img/instagram.png" alt=""></li>
               <li><img src="img/facebook.png" alt=""></li>
               <li><img src="img/youtube.png" alt=""></li>
               <li><img src="img/blog.png" alt=""></li>
           </ul>
		   <br><br>
		   
           <ul>
               <li>대표자 ooo | 서울 중구 세종대로 110</li>
               <li>사업자등록번호:123-12-12345 | 이메일:abc@naver.com</li>
               <li><span class="copyright">COPYRIGHT 2022</span></li>  
           </ul>
       </footer>
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
   </div> 
</body>
</html>