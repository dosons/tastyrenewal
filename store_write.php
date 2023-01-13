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
          <a href="index.php" class="logo"><img src="img/logo.png" style="max-width: 100%;"></a>
          <nav>
             <a href="#" class="close"><span class="lnr lnr-cross"></span></a>
              <ul class="gnb">
				  <li><a href="index.php?#about">소개</a></li>
                  <li><a href="recipe_write.php">레시피</a></li>
                  <li><a href="store_write.php">스토어</a></li>
                  <li><a href="free.php">커뮤니티</a></li>
                  <li><a href="event.php">이벤트</a></li>
				  <li><a href="my.php">MY</a></li>
				  
              </ul>
          </nav>
    
       </header>
       <!--body-->
       <body>
        <div class="recipe">
       <p class='title' style="font-size:40px;" >
  스토어
</p>
         </div>
         
    <?php
    $sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : "recipe_title";
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

$sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : "recipe_title";



$numLines = 16;   
$numLinks = 5;

$page = empty($_REQUEST["page"] ) ? 1 : $_REQUEST["page"];
$start = ($page - 1) * $numLines;

    require("db_connect.php");


    
    $query = $db->query("select * from recipe_write  order by $sort desc limit $start, $numLines");
    while($row = $query->fetch()){

?>
         <li class="cell" style="width : 250px; margin:30px ">
            <div class="img-box"><a href="store_view.php?num=<?=$row['recipe_id']?>"><img src="<?=$row['recipe_thum']?>" width="250" height="140" alt=""></a></div>
            <div class="product-name"><a href="store_view.php?num=<?=$row['recipe_id']?>"><?=$row['recipe_title']?></a></div>





            <div class="description" style="text-align: center;">
        <p class="color displaynone">
            </p>
        
        <p class="name">
            <a href="/product/detail.html?product_no=1245&amp;cate_no=1&amp;display_group=2" class=""><span class="title displaynone"><span style="font-size:12px;color:#555555;font-weight:bold;">상품명</span> :</span> <span style="font-size:12px;color:#555555;font-weight:bold;">여기에 상품명 입력</span></a>
            </p>
<div class="line -mov"></div>
        
        <ul class="xans-element- xans-product xans-product-listitem-1 xans-product-listitem xans-product-1 spec"><li class=" xans-record-">

<li class=" xans-record-">
<strong class="title displaynone"><span style="font-size:12px;color:#999999;">소비자가</span> :</strong> <span style="font-size:12px;color:#999999;text-decoration:line-through;">29,700원</span></li>
<li class=" xans-record-">
<strong class="title displaynone"><span style="font-size:13px;color:#333333;font-weight:bold;">판매가</span> :</strong> <span style="font-size:13px;color:#333333;font-weight:bold;">24,600원</span><span id="span_product_tax_type_text" style=""> </span></li>

</ul>
<div class="status">
            <div class="icon">    <img src="/web/upload/custom_21.gif" alt=""><img src="/web/upload/custom_23.gif" alt=""><img src="/web/upload/custom_24.gif" alt=""><img src="/web/upload/custom_29.gif" alt="">  </div>
        </div>
    </div>






        </li>
<?php
       }
?>
 
    </ul>
</div>


           


<!--backend-->      <!-- 페이지 네이션?-->
<?php

    $firstLink = floor(($page - 1) / $numLinks) * $numLinks + 1;
	$lastLink = $firstLink + $numLinks - 1;
	
	$numRecords = $query = $db->query("select count(*) from recipe_write")->fetchColumn(); 
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
         <a href="store_write.php?page=1&sort=<?=$sort?>" title="처음 페이지로 이동하기"><img src="img/btn-first-page.gif"></a>
         </li>
         <li class="prev pager">
         <a href="store_write.php?page=<?=$firstLink - $numLinks?>&sort=<?=$sort?>" title="이전 페이지로 이동하기"><img src="img/btn-prev-page.gif"></a>
         </li>
         
<?php
    }

	for ($i = $firstLink; $i <= $lastLink; $i++) {
?>

         <li><a href="store_write.php?page=<?=$i?>&sort=<?=$sort?>" <?=($i == $page) ? "class='active'" : $i?> ><?=($i == $page) ? "$i" : $i?></a></li>
	
<?php
	}
	
	if ($lastLink < $numPage) {
?>
    <li class="next pager">
    <a href="store_write.php?page=<?=$firstLink + $numLinks?>&sort=<?=$sort?>" title="다음 페이지로 이동하기"><img src="img/btn-next-page.gif"></a>
    </li>
    <li class="last pager">
    <a href="store_write.php?page=<?=$numPage ?>&sort=<?=$sort?>" title="마지막 페이지로 이동하기"><img src="img/btn-last-page.gif"></a>
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