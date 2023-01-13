<?php
require("db_connect.php");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0, maximum-scale=1.0">
    <title>Tasty & Recipe</title>
    <link rel="stylesheet" href="css/event_end.css">
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
                <li class="test"><a href="join_screen.php"><p>회원가입</p></a></li>
			    <li class="test"><a href="login_screen.php"><p>로그인</p></a></li>
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
        <div class="event1">
           <li>이벤트</li>
           <hr  style="border: solid 1px rgb(250, 169, 76); width: 20%; margin-left: auto;margin-right: auto;">
        </div>
     <nav>
        <div class="event2">
            <ul>
      <li> <a href="event.php">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp전체&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a></li>
      <li > <a href="event_ing.php">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp진행중인 이벤트&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a></li>
      <li style="color:#FF9D2D"> <a href="event_end.php">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp종료된 이벤트&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a></li>
      
            </ul>
            </nav>
        </div>
        <div class="img1">
            <li><a href="event_in.php"><img src="img/event1.PNG"  alt=""></a></li>
            <div class="event4">
                <li><a href="event_in.php">[진행중]TASTY 배달 축제</a></li>
                <div class="event6">
                <li><span style="font-size: 14px; margin-left: 3px; margin-top: -3px; ">작성일2022-03-21</span></li>
                </div>
            </div>
     
        </div>
        <div class="img2">
            <li><a href="event_in1.php"><img src="img/event3.png" alt=""></a></li>
            
        <div class="event5">
            <li><a href="event_in1.php">[종료]설맞이 떡국먹자!</a></li>
            <div class="event7">
            <li><span style="font-size: 14px; ">작성일2022-03-21</span></li>
        </div>
            </div>
            </div>



  
	<div class="button">
    <div class="button1">
        <li><a href="#"><img src="img/left_btn.png" width="20px" height="20px"alt=""></a></li>
        </div>

        <div class="button2">
            <li><a href="#"><img src="img/right_btn.png" width="20px" height="20px"alt=""></a></li>
            </div>
        <div class="button3">
            <li><a href="#"><img src="img/num1.PNG" width="16px" height="20px"alt=""></a></li>
            </div>
			</div>
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