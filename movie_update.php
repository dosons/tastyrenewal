<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0, maximum-scale=1.0">
    <title>Tasty & Recipe</title>
    <link rel="stylesheet" href="css/reciperegis1.css">
    <!--font-->
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css">
    <link rel="stylesheet" href="css/slick.css">
	    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">

    <!--script-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/scrolla.jquery.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js.js"></script>
    
  



    
</head>
<body>
   <div class="wrap">
       <!--header-->
       <header>
		<div class="top">
		<div class="wrapper">
		<ul class="top-menu">
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
          <a href="index.php" class="logo"><img src="img/logo.png" style="max-width: 100%;"></a>
          <nav>
             <a href="#" class="close"><span class="lnr lnr-cross"></span></a>
              <ul class="gnb">
				  <li><a href="index.php?#about">소개</a></li>
                  <li><a href="recipe_write.php">레시피</a></li>
                  <li><a href="store_list.php">스토어</a></li>
                  <li><a href="free.php">커뮤니티</a></li>
                  <li><a href="event.php">이벤트</a></li>
				  <li><a href="my.php">MY</a></li>
				  
              </ul>
          </nav> 
       </header>
       <!--body-->
       <body>

        <div class="event1">
           <li>레시피 등록</li>

<?php

$recipe_title = "";
$recipe_introduce = "";
$movie_url = "";


$i_name1 = "";
$i_name2 = "";
$i_name3 = "";
$i_name4 = "";


$i_num_1 = "";
$i_num_2 = "";
$i_num_3 = "";
$i_num_4 = "";


 
$num = $_REQUEST['num'];
$num = ($num != null && $num > 0) ? $num : 0;




if ($num > 0) {
    require("db_connect.php");
    $query = $db->query("select * from recipe_movie where recipe_movie_num = {$num}");
    $row = $query->fetch();

    $action = "movie_change.php?num=$num";

    $recipe_title = $row['recipe_movie_title'];
    $recipe_introduce = $row['recipe_movie_introduce'];
    $movie_url = $row['recipe_movie_url'];


    $query = $db->query("select * from movie_basic where recipe_movie_num = {$num}");
    $row = $query->fetch();
    $Ingre_id = $row['movie_basic_num'];

    $query = $db->query("select * from movie_basic where movie_basic_num = {$Ingre_id}");
    $row = $query->fetch();
    $i_name1 = $row['mbasic_name_1'];
    $i_name2 = $row['mbasic_name_2'];
    $i_name3 = $row['mbasic_name_3'];
    $i_name4 = $row['mbasic_name_4'];

    $i_num_1 = $row['mbasic_num_1'];
    $i_num_2 = $row['mbasic_num_2'];
    $i_num_3 = $row['mbasic_num_3'];
    $i_num_4 = $row['mbasic_num_4'];


}

?>
<form action="<?=$action?>" method="POST">
        </div>

<div class="box">
    <ul> 
    <li>레시피 제목  &nbsp; &nbsp; <input type="text" id="name" class="int" name="recipe_title" value="<?=$recipe_title?>" ></li>
        <li style="margin-left: 100px; margin-top:-200px">레시피소개 &nbsp; &nbsp;</li><textarea id="make" cols="50"  class="int1" style="vertical-align:top;" rows="10" name="recipe_introduce"><?=$recipe_introduce?></textarea>
    </ul>
           
    <div class="box1">
    <li>동영상 URL &nbsp; &nbsp;  
               
   <input type="text" style="width:300px; height: 50px; font-size:18px;" class="form-control m-3 youtube-url" name="movie_url" value="https://youtu.be<?=$movie_url?>"/><br> 
   <button class="btn btn-primary btn-block mt-3" id="getBtn" type="button" style="width:300px; height: 40px; font-size:18px; border:none; margin-left: 155px; margin-top:3px; border-radius:10px;" >썸네일 미리보기</button>
   
   <div class="thumbnail-wrap" style="margin-left: 150px; margin-top:20px;">
         
   </div>


<!--유튜브 썸네일 미리보기 -->
<script>

const getButton = document.querySelector("#getBtn");
const youtubeUrl = document.querySelectorAll(".youtube-url");
const thumbnailWrap = document.querySelector(".thumbnail-wrap");
 
getButton.addEventListener('click', getThum);
 
function getThum() {
   let thumArr = [];
   youtubeUrl.forEach(url => {
      if (url.value !== "") {
         let replaceUrl = url.value;
         let finUrl = '';
         replaceUrl = replaceUrl.replace("https://youtu.be/", '');
         replaceUrl = replaceUrl.replace("https://www.youtube.com/embed/", '');
         replaceUrl = replaceUrl.replace("https://www.youtube.com/watch?v=", '');
         finUrl = replaceUrl.split('&')[0];
         thumArr.push(finUrl);
      }
   });
   thumArr.forEach(thum => {
      let img = document.createElement("img");
      img.setAttribute("src", `https://img.youtube.com/vi/${thum}/mqdefault.jpg`)
      thumbnailWrap.appendChild(img);
   });
};
</script>
   




</li>
           </div>
           </div>
           <div class="box3" style="margin-bottom:50px;">
               <li>재료  &nbsp; &nbsp; &nbsp; &nbsp; <img src="img/box3.PNG"  class="disabled" width=1122px;></li>
               <li><input type="text" id="name" class="int3" name="name_1" value="<?=$i_name1?>"><input type="text" id="name" class="int4" name="num_1" value="<?=$i_num_1?>"></li> 
               <li><input type="text" id="name" class="int3" name="name_2" value="<?=$i_name2?>"><input type="text" id="name" class="int4" name="num_2" value="<?=$i_num_2?>"></li> 
               <li><input type="text" id="name" class="int3" name="name_3" value="<?=$i_name3?>"><input type="text" id="name" class="int4" name="num_3" value="<?=$i_num_3?>"></li> 
               <li><input type="text" id="name" class="int3" name="name_4" value="<?=$i_name4?>"><input type="text" id="name" class="int4" name="num_4" value="<?=$i_num_4?>"></li> 

             
             
            <div class="b-btn01 type01">
                <ul class="b-btn-wrap">
                <li>
                <a class="b-btn-type01" href="recipe_movie.php" >취소</a>
                </li>
                <li>
                <input id="input" type="submit" value="수정">
                </li>
           </div>
 </form>
      

   <br><br>
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