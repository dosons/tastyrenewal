<?php
require("db_connect.php");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0, maximum-scale=1.0">
    <title>Tasty & Recipe</title>
    <link rel="stylesheet" href="css/main.css">
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
          <a href="#" class="logo"><img src="img/logo1.png" style="width: 100%;"></a>
          <nav>
             <a href="#" class="close"><span class="lnr lnr-cross"></span></a>
              <ul class="gnb" style="font-weight: 800;">
				  <li><a href="#about">소개</a></li>
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
       <!--visual-->
       <section class="visual">
          <!--슬라이드-->
          <ul class="slide">
              <li>
                  <div class="img">
                      <span class="imgBox"><img src="img/banner1.png" alt=""></span><!--overflow:hidden으로 감싸기위해 imgBox로 묶음-->
                      <span class="mask a"></span><span class="mask b"></span>
                      <span class="mask c"></span><span class="mask d"></span>
                      <span class="page"><img src="img/1.png" alt="01"></span> <!--페이지숫자 이미지-->
                  </div>

              </li>
              <li>
                  <div class="img">
                      <span class="imgBox"><img src="img/bannerB2.png" alt=""></span><!--overflow:hidden으로 감싸기위해 imgBox로 묶음-->
                      <span class="mask a"></span><span class="mask b"></span>
                      <span class="mask c"></span><span class="mask d"></span>
                      <span class="page"><img src="img/2.png" alt="02"></span> <!--페이지숫자 이미지-->
                  </div>

              </li>
              <li>
                  <div class="img">
                      <span class="imgBox"><img src="img/bannerB3.png" alt=""></span><!--overflow:hidden으로 감싸기위해 imgBox로 묶음-->
                      <span class="mask a"></span><span class="mask b"></span>
                      <span class="mask c"></span><span class="mask d"></span>
                      <span class="page"><img src="img/3.png" alt="03"></span> <!--페이지숫자 이미지-->
                  </div>

              </li>
          </ul>
           <!-- 비쥬얼 공통 하단 메뉴-->

       </section>
	   
      
      <!--global-->
       <section class="global animate" data-animate="motion">
           <div class="title">
               <h2>Recipe Ranking</h2> 
               <p>저희 Tasty를 통해<br>
                디양한 레시피를 만나보세요.</p>
           </div>
<ul>



<?php
$numLines = 4;   
$query = $db->query("select * from recipe_info order by recipe_info_hits desc limit $numLines");
while($row = $query->fetch()){
?>
               <li><a href="recipe_view.php?num=<?=$row['recipe_info_num']?>">
                   <p class="img"><img src="<?=$row['recipe_info_thum']?>" style="width: 418.5px; height: 375px;"></p>
               </a></li>

<?php    
}
?>


</ul>
 </section>
      

<?php
$query = $db->query("SELECT recipe_info_num, recipe_info_thum, recipe_info_title
					FROM recipe_info
					ORDER BY RAND()
					LIMIT 1;");
$row = $query->fetch();

// 스토어 이름, 상품명, 원산지, 가격, 할인적용가격, 설명, 이미지포스터, 배송기간, 배송비, 할인율, 등록일
$recipe_info_num = $row['recipe_info_num'];
$recipe_info_thum = $row['recipe_info_thum'];
$recipe_info_title = $row['recipe_info_title'];

$query2 = $db->query("SELECT recipe_info_num, recipe_info_thum, recipe_info_title
					FROM recipe_info
					ORDER BY RAND()
					LIMIT 1;");
$row2 = $query2->fetch();

// 스토어 이름, 상품명, 원산지, 가격, 할인적용가격, 설명, 이미지포스터, 배송기간, 배송비, 할인율, 등록일
$recipe_info_num2 = $row2['recipe_info_num'];
$recipe_info_thum2 = $row2['recipe_info_thum'];
$recipe_info_title2 = $row2['recipe_info_title'];

$query3 = $db->query("SELECT recipe_info_num, recipe_info_thum, recipe_info_title
					FROM recipe_info
					ORDER BY RAND()
					LIMIT 1;");
$row3 = $query3->fetch();

// 스토어 이름, 상품명, 원산지, 가격, 할인적용가격, 설명, 이미지포스터, 배송기간, 배송비, 할인율, 등록일
$recipe_info_num3 = $row3['recipe_info_num'];
$recipe_info_thum3 = $row3['recipe_info_thum'];
$recipe_info_title3 = $row3['recipe_info_title'];
?>




<!-- ranking -->

<section class="global animate motion animated" data-animate="motion" style="visibility: visible; background-color:#ffffff;">
           
<ul>

           <div class="contain" style="width:100%; height:100%;">
           <div class="ranktitle" style="margin:auto;">
               <h2 style="font-size: 40px; margin-bottom: 20px; color:#FF9317;">Today Recipe</h2> 
               <p style="font-size: 18px; line-height: 1.4; margin-bottom: 100px;">현재 인기 있는 레시피들을<br>
                만나보세요.</p>
           </div>
	<div class="rec_view_top clr" style="width:auto! height: auto !important;">
    
		<div class="fl rec_view_img" style="width:50%;  float:left; margin-top:70px;">
        
        <div class="imgtext" style="float:right; text-align:right; margin-right:70px;">
			<a href="recipe_view.php?num=<?= $recipe_info_num?>" >
			<img src="<?= $recipe_info_thum?>" style="width:500px; height:400px;  " >
            <div class="ranktext">
               <h2 style="font-size: 25px; color:#FF9317;"><?= $recipe_info_title?></h2> 
            </div>
			</a>
        </div>
        </div>


        <div class="fl rec_view_img" style="width:50%; margin-bottom:50px; float:left">
        <div class="imgtext" style="float:left; text-align:left; margin-left:70px;">
		<a href="recipe_view.php?num=<?= $recipe_info_num2?>" >
		    <img src="<?= $recipe_info_thum2 ?>"style="width:400px; height:250px;" >
            <div class="ranktext">
               <h2 style="font-size: 25px; color:#FF9317;"><?= $recipe_info_title2?></h2> 
            </div>
			</a>
        </div>
        </div>
            
        <div class="fl rec_view_img" style="width:50%;  float:left">
        <div class="imgtext" style="float:left; text-align:left; margin-left:70px;">
		<a href="recipe_view.php?num=<?= $recipe_info_num3?>" >
		    <img src="<?= $recipe_info_thum3 ?>" style="width:300px; height:200px;" >
            <div class="ranktext">
               <h2 style="font-size: 25px;color:#FF9317;"><?= $recipe_info_title3?></h2> 
            </div>
		</a>
        </div>
        </div>



    </div>
		
          </div>



</ul>
 </section>





















 
       <!--section.premium-->
       <section class="premium">
        <div class="title">
            <h2>Cooking Movie</h2>
            <p>영상으로 만나면 더 맛있는 레시피<br>
               더 쉽게 따라 해보세요.</p>
             <a href="recipe_movie.php">more</a>
       </div>
       <ul class="banner">
        <div class="movie">
<?php
$query = $db->query("select * from recipe_movie order by rand()");
$row = $query->fetch();
?>
           <iframe src="https://www.youtube.com/embed/<?=$row["recipe_movie_url"]?>"  title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
           </div>
      </ul>
       </section>
       <br><br><br><br>
     <!--section.about-->
       <section class="about" id="about">
           <img src="img/main_about1.png" alt="">
           <div class="inner animate" data-animate="motion">
               <h2>Tasty와 함께 하세요.</h2>
               <div class="line">
                   <span></span>
                   <ul>
                       <li class="a"></li>
                       <li class="b"></li>
                       <li class="c"></li>
                   </ul>
                </div>
                <ul>
                     <li>
                         <h3>Recipe</h3>
                         <p>다양한 레시피 정보 공유<br>
                            고민하지 말고 여러가지 음식에 도전해보세요.<br>
                         </p>
                     </li>
                     <li>
                          <h3>Cooking Movie</h3>
                        <p>영상으로 만나면 더 맛있는 레시피<br>
                           쉽게 따라 해보세요.</p>
                     </li>
                     <li>
                         <h3>Community</h3>
                         <p>여러 사람들과 <br>
							 당신의 레시피를 공유해보세요.</p>
                    </li>
                </ul>
           </div>
       </section>
       
       <!--footer-->
       <footer>
           <ul class="sns">
               <li><img src="img/instagram.png" alt=""></li>
               <li><img src="img/facebook.png" alt=""></li>
               <li><img src="img/youtube.png" alt=""></li>
               <li><img src="img/blog.png" alt=""></li>
           </ul>
           <h2 class="footerLogo"><img src="img/logo1.png"></h2>
           <ul>
               <li>대표자 ooo | 서울 중구 세종대로 110</li>
               <li>사업자등록번호:123-12-12345 | 이메일:abc@naver.com</li>
               <li><span class="copyright">COPYRIGHT 2022</span></li>  
           </ul>
           <div class="box animate" data-animate="motion">
               <h2>Man is what he eats.<br>
                   먹는 음식이 곧 자신이다.</h2>
           </div>
       </footer>
       
       
       
<?php


 if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
    $user_id = $_SESSION["userId"];
    $user_name = $_SESSION ["userName"];
    $query = $db->query("select * from mem_info where mem_info_id='{$user_id}'");
    $row = $query->fetch();

    $phone_number = $row["mem_info_phone"];
    $email = $row["mem_info_email"];
    $nick_name = $row["mem_info_nickname"];
?>




<!-- Channel Plugin Scripts -->
<script>
  (function() {
    var w = window;
    if (w.ChannelIO) {
      return (window.console.error || window.console.log || function(){})('ChannelIO script included twice.');
    }
    var ch = function() {
      ch.c(arguments);
    };
    ch.q = [];
    ch.c = function(args) {
      ch.q.push(args);
    };
    w.ChannelIO = ch;
    function l() {
      if (w.ChannelIOInitialized) {
        return;
      }
      w.ChannelIOInitialized = true;
      var s = document.createElement('script');
      s.type = 'text/javascript';
      s.async = true;
      s.src = 'https://cdn.channel.io/plugin/ch-plugin-web.js';
      s.charset = 'UTF-8';
      var x = document.getElementsByTagName('script')[0];
      x.parentNode.insertBefore(s, x);
    }
    if (document.readyState === 'complete') {
      l();
    } else if (window.attachEvent) {
      window.attachEvent('onload', l);
    } else {
      window.addEventListener('DOMContentLoaded', l, false);
      window.addEventListener('load', l, false);
    }
  })();
  ChannelIO('boot', {
    "pluginKey": "c8928a97-de6e-4eb5-a60c-16088244e38f", 
    "memberId": "<?=$user_id ?>", 
    "profile": {
    "name": "<?=$user_name ?>", 
    "mobileNumber": "<?=$phone_number ?>",
    "email": "<?=$email?>", 
    "nickname": "<?=$nick_name?>"
    }
  });
</script>
<!-- End Channel Plugin -->
<?php

 } 


?>

       
       

       
       
       
       
       
       
       
       
   </div> 
</body>
</html>