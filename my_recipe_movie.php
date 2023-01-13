<?php
require("db_connect.php");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0, maximum-scale=1.0">
    <title>Tasty & Recipe</title>
    <link rel="stylesheet" href="css/recipe.css">
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
            if(isset($_SESSION["userNum"]) || isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
               $user_num = $_SESSION["userNum"];
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
       <div class="recipe">
            <b style="font-size: 37px;">나의 레시피</b>
            <hr  style="border: solid 1px rgb(250, 169, 76); width: 20%;margin-top: 20px; margin-left: auto;margin-right: auto;">
        <div class="b-sel-box b-cate-basic">
        <br>
        <br>
            
        <a href="my_recipe_write.php"><button type="submit" class="b-sel-btn" style="font-weight:bold;">레시피</button></a>
        <a href="my_recipe_movie.php"><button type="submit" class="b-sel-btn" style="font-weight:bold; background-color:#FF9D2D;color:#fff">영상</button></a>
         </div>
         </div>
         
    <?php
    $sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : "recipe_movie_title";
    $regdate = "black";
    $hits = "black";
    if ($sort == "recipe_movie_regdate") {
        $regdate = "#FF9D2D";
    } else if ($sort == "recipe_movie_hits") {
        $hits = "#FF9D2D";
    }
         
    
    ?>

    <nav>
      <div class="early" >
      <ul>
      <li><a href="?sort=regdate" style="Color: <?= $regdate?>;">최신순&nbsp</a></li>
      <li> | </li>
      <li><a href="?sort=hits" style="Color: <?= $hits?>;">&nbsp조회순</a></li>
      </ul>
      </div>
    </nav> 

<script>


</script>


<div class="list con">
    <ul class="row">
        

<!--backend-->           

<?php

$sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : "recipe_movie_title";



$numLines = 6;   
$numLinks = 3;

$page = empty($_REQUEST["page"] ) ? 1 : $_REQUEST["page"];
$start = ($page - 1) * $numLines;

require("db_connect.php");

//사용자가 쓴 게시물이 있는지 확인
$query = $db->query("select * from recipe_movie where mem_info_num = '{$user_num}' ");
$row = $query->fetch();

//있을시 게시물 보여줌
if($row) {
//$my_connection = $row['con_m_id'];

//$query = $db->query("select * from connection_m where con_m_id = {$my_connection} ");
//$row = $query->fetch();
//$my_recipe = $row['recipe_movie_num'];


$query = $db->query("select * from mem_info where mem_info_id = '{$user_id}' ");
$row = $query->fetch();
$check_name = $row['mem_info_nickname'];
	
	if ($sort == "regdate") {
        $query = $db->query("SELECT *,
				(SELECT mem_info_nickname
				FROM	mem_info AS b
				WHERE a.mem_info_num = b.mem_info_num) AS mem_info_nickname
			FROM recipe_movie AS a
			where mem_info_num = '{$user_num}'
			ORDER BY recipe_movie_regdate desc limit $start, $numLines");
    } else if ($sort == "hits") {
        $query = $db->query("SELECT *,
				(SELECT mem_info_nickname
				FROM	mem_info AS b
				WHERE a.mem_info_num = b.mem_info_num) AS mem_info_nickname
			FROM recipe_movie AS a
			where mem_info_num = '{$user_num}'
			ORDER BY recipe_movie_hits desc limit $start, $numLines");
    } else {
        $query = $db->query("SELECT *,
				(SELECT mem_info_nickname
				FROM	mem_info AS b
				WHERE a.mem_info_num = b.mem_info_num) AS mem_info_nickname
			FROM recipe_movie AS a where mem_info_num = '{$user_num}' limit $start, $numLines");
	}

    //$query = $db->query("select * from recipe_movie where recipe_movie_writer = '{$check_name}' order by $sort desc limit $start, $numLines");
    while($row = $query->fetch()){

?>
   
         <li class="cell" style="margin-right: 14px;">
            <div class="area"><a href="recipe_video.php?num=<?=$row['recipe_movie_num']?>"><img  src=" https://img.youtube.com/vi/<?=$row['recipe_movie_url']?>/mqdefault.jpg" width="250" height="140" alt="" ></a></div>
            <div class="product-name"><a href="recipe_video.php?num=<?=$row['recipe_movie_num']?>"><?=$row['recipe_movie_title']?></a></div>
            <div class="product-writer">작성자 : <?=$row['mem_info_nickname']?></div>
            <div class="product-price">조회수 :<?=$row['recipe_movie_hits']?></div>
            <div class="product-week">작성일 : <?=substr($row['recipe_movie_regdate'],0,10)?></div>
        </li>
 <?php
       }
       // 없을떄
    } else {
?>
 <hr  style="border: solid 0.1px rgb(250, 169, 76); width: 100%;margin-bottom: 20px; margin-left: auto;margin-right: auto;">
  <a style="font-size:20px;">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;내가 업로드 한 영상이 없습니다</a>
  <hr  style="border: solid 0.1px rgb(250, 169, 76); width: 100%;margin-top: 20px; margin-left: auto;margin-right: auto;">
<?php
    }
?>
 
    </ul>
</div>

<div class="b-btn01 type01">
<ul class="b-btn-wrap">
<?php
    if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
?>
      <li>
         <a class="b-btn-type01" href="movie_submit.php" >레시피 영상 등록</a>
      </li>

<?php
     } else {
?>
      <li>
         <a class="b-btn-type01" href="non_login.php">레시피 영상 등록</a>
      </li>
<?php      
     }
?>
      
</ul>
</div>
           


<!--backend-->
<?php

    $firstLink = floor(($page - 1) / $numLinks) * $numLinks + 1;
	$lastLink = $firstLink + $numLinks - 1;
	
	//$numRecords = $query = $db->query("select count(*) from recipe_movie where recipe_movie_writer = '{$check_name}'")->fetchColumn(); 
	$numRecords = $query = $db->query("select count(*) from recipe_movie where mem_info_num = '{$user_num}'")->fetchColumn(); 
	$numPage = ceil($numRecords / $numLines);
	if ($lastLink > $numPage) {
		$lastLink = $numPage;
	}
?>
   <div class="b-paging01 type01">
   <div class="b-paging-wrap"> 
   <ul>
<?php
   if ($firstLink > 1) {
       
?>      
         <li class="first pager">
         <a href="my_recipe_movie.php?page=1&sort=<?=$sort?>" title="처음 페이지로 이동하기"><img src="img/btn-first-page.gif"></a>
         </li>
         <li class="prev pager">
         <a href="my_recipe_movie.php?page=<?=$firstLink - $numLinks?>&sort=<?=$sort?>" title="이전 페이지로 이동하기"><img src="img/btn-prev-page.gif"></a>
         </li>
         
<?php
    }

	for ($i = $firstLink; $i <= $lastLink; $i++) {
?>

         <li><a href="my_recipe_movie.php?page=<?=$i?>&sort=<?=$sort?>" <?=($i == $page) ? "class='active'" : $i?> ><?=($i == $page) ? "$i" : $i?></a></li>
	
<?php
	}
	
	if ($lastLink < $numPage) {
?>
    <li class="next pager">
    <a href="my_recipe_movie.php?page=<?=$firstLink + $numLinks?>&sort=<?=$sort?>" title="다음 페이지로 이동하기"><img src="img/btn-next-page.gif"></a>
    </li>
    <li class="last pager">
    <a href="my_recipe_movie.php?page=<?=$numPage ?>&sort=<?=$sort?>" title="마지막 페이지로 이동하기"><img src="img/btn-last-page.gif"></a>
    </li>
<?php
	}
?>
    

                     
                  
                  
                  
               
         
      
   </ul>
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