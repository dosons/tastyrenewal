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
            if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
               $user_id = $_SESSION["userId"];
               $user_name = $_SESSION ["userName"];
			   			// 쿼리를 날려서 스토어 번호가 있다면?
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
           

require("db_connect.php");
$query = $db->query("select * from mem_info where mem_info_id='{$user_id}'");
$row = $query->fetch();
$email = $row["mem_info_email"];
$nickname = $row["mem_info_nickname"];
$m_num =  $row["mem_info_num"];
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
        <div class="b-sel-box b-cate-basic">
        <a href="store_list.php"><button type="submit" class="b-sel-btn" style="font-weight:bold; background-color:#FF9D2D;color:#fff">스토어</button></a>
         </div>
         </div>
         
    <?php
    $sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : "recipe_info_title";
    $regdate = "black";
    $hits = "black";
    if ($sort == "regdate") {
        $regdate = "#FF9D2D";
    } else if ($sort == "hits") {
        $hits = "#FF9D2D";
    }
         
    
    ?>




<div class="list con">
    <ul class="row" style = "width : 1300px; margin : auto;">
        

<!--backend-->           
<?php

$sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : "store_product_name";

$numLines = 16;   
$numLinks = 5;

$page = empty($_REQUEST["page"] ) ? 1 : $_REQUEST["page"];
$start = ($page - 1) * $numLines;

    require("db_connect.php");
	

        $query = $db->query("SELECT store_product_num, store_product_name, store_product_img, store_product_price,
	(SELECT store_info_name 
	FROM store_info AS b
	WHERE a.store_info_num = b.store_info_num) AS store_info_name
	FROM store_product AS a
	order by $sort desc limit $start, $numLines");




    //$query = $db->query("select * from recipe_info order by $sort desc limit $start, $numLines");
	
	/*$query = $db->query("select *, (SELECT mem_info_nickname
						FROM	mem_info AS b
						WHERE a.mem_info_num = b.mem_info_num) AS mem_info_nickname
					FROM recipe_info AS a order by recipe_info_hits desc");*/
	
	
	
    while($row = $query->fetch()){
?>
         <li class="cell" style="width : 250px; margin:30px ">
            <div class="img-box"><a href="store_view.php?num=<?=$row['store_product_num']?>"><img src="<?=$row['store_product_img']?>" width="250" height="140" alt=""></a></div>
            <div class="product-name"><a href="store_view.php?num=<?=$row['store_product_num']?>"><?=$row['store_product_name']?></a></div>
            <div class="product-writer">작성자 : <?=$row['store_info_name']?></div>
            <div class="product-week">가격 : <?=substr($row['store_product_price'],0,16)?></div>
        </li>
<?php
       }
?>
 
    </ul>
</div>

<div class="b-btn01 type01">
<ul class="b-btn-wrap">
    <!--  세션이 있어야 등록이 가능하다? -->

      
</ul>
</div> 
           


<!--backend-->      <!-- 페이지 네이션?-->
<?php

    $firstLink = floor(($page - 1) / $numLinks) * $numLinks + 1;
	$lastLink = $firstLink + $numLinks - 1;
	
	$numRecords = $query = $db->query("select count(*) from store_product")->fetchColumn(); 
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
         <a href="store_list.php?page=1&sort=<?=$sort?>" title="처음 페이지로 이동하기"><img src="img/btn-first-page.gif"></a>
         </li>
         <li class="prev pager">
         <a href="store_list.php?page=<?=$firstLink - $numLinks?>&sort=<?=$sort?>" title="이전 페이지로 이동하기"><img src="img/btn-prev-page.gif"></a>
         </li>
         
<?php
    }

	for ($i = $firstLink; $i <= $lastLink; $i++) {
?>

         <li><a href="store_list.php?page=<?=$i?>&sort=<?=$sort?>" <?=($i == $page) ? "class='active'" : $i?> ><?=($i == $page) ? "$i" : $i?></a></li>
	
<?php
	}
	
	if ($lastLink < $numPage) {
?>
    <li class="next pager">
    <a href="store_list.php?page=<?=$firstLink + $numLinks?>&sort=<?=$sort?>" title="다음 페이지로 이동하기"><img src="img/btn-next-page.gif"></a>
    </li>
    <li class="last pager">
    <a href="store_list.php?page=<?=$numPage ?>&sort=<?=$sort?>" title="마지막 페이지로 이동하기"><img src="img/btn-last-page.gif"></a>
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