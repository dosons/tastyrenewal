<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0, maximum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tasty & Recipe</title>
    <link rel="stylesheet" type="text/css" href="css/g.css">
    <!--font-->
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="css/css.css">

    <!--script-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/scrolla.jquery.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
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
                  <li><a href="free.php">커뮤니티</a></li>
                  <li><a href="event.php">이벤트</a></li>
				  <li><a href="my.php">MY</a></li>
				  
              </ul>
          </nav>
    
       </header>
       <!--body-->
<body>
    <div class="board_wrap">
        <div class="board_title">
            <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;내가 쓴 게시글</strong>
            <hr  style="border: solid 1px rgb(250, 169, 76); width: 20%;margin-top: 20px; margin-left: auto;margin-right: auto;">
            <br>
            
            
         <div class="recipe">
        <div class="b-sel-box b-cate-basic">
        <a href="my_community.php"><button type="submit" class="b-sel-btn" style="font-weight:bold;">자유 게시판</button></a>
        <a href="q_my_community.php"><button type="submit" class="b-sel-btn" style="font-weight:bold; background-color:#FF9D2D;color:#fff" >질문 게시판</button></a>
        <a href="t_my_community.php"><button type="submit" class="b-sel-btn" style="font-weight:bold; ">팁과 노하우</button></a>
         </div>
         </div>
        <br>
    
</div>
<div class="board_list_wrap">
   <div class="board_list">
   <div class="top">
                    <th><div class="num">번호</div></th>
                    <th><div class="title">제목</div></th>
                    <th><div class="writer">글쓴이</div></th>
                    <th><div class="date">작성일</div></th>
                    <th><div class="count">조회</div></th>
                </div>
<!--back end-->   
<?php

$numLines = 5;   
$numLinks = 3;

$page = empty($_REQUEST["page"] ) ? 1 : $_REQUEST["page"];
$start = ($page - 1) * $numLines;


require("db_connect.php");
$type = "question";

$query = $db->query("select * from mem_info where mem_info_id = '{$user_id}' ");
$row = $query->fetch();
$check_name = $row['mem_info_nickname'];

//$query = $db->query("select * from board_info where board_info_type = '$type' and board_info_writer = '$check_name' order by board_info_num desc limit $start, $numLines");
$query = $db->query("select * from board_info where board_info_type = '$type' order by board_info_num desc limit $start, $numLines");
while($row = $query->fetch()){ 
    $Board_id = $row['board_info_num'];
?>
                <div>
                    <div class="num"><?=$Board_id ?></div>
                    <?php 
                    $numRecords = $query2 = $db->query("select count(*) from reply_info where board_info_num={$Board_id}")->fetchColumn(); 
                    ?>
                    <div class="title"><a href="q_view.php?num=<?=$Board_id?> "><?=$row['board_info_title']?>&nbsp; [<?=$numRecords?>]</a></div>
                    <div class="writer"><?=$row['mem_info_nickname']?></div>
                    <div class="date"><?=substr($row['board_info_regdate'],0,10)?></div>
                    <div class="count"><?=$row['board_info_hits']?></div>
                </div>


<?php

}

?>

      
   
</div>
                 
<?php

$firstLink = floor(($page - 1) / $numLinks) * $numLinks + 1;
$lastLink = $firstLink + $numLinks - 1;

//$numRecords = $query = $db->query("select count(*) from board_info where board_info_type='$type' and board_info_writer = '$check_name'  ")->fetchColumn(); 
$numRecords = $query = $db->query("select count(*) from board_info where board_info_type='$type'")->fetchColumn(); 
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
     <a href="q_my_community.php?page=1" title="처음 페이지로 이동하기"><img src="img/btn-first-page.gif"></a>
     </li>
     <li class="prev pager">
     <a href="q_my_community.php?page=<?=$firstLink - $numLinks?>" title="이전 페이지로 이동하기"><img src="img/btn-prev-page.gif"></a>
     </li>
     
<?php
}

for ($i = $firstLink; $i <= $lastLink; $i++) {
?>

     <li><a href="q_my_community.php?page=<?=$i?>" <?=($i == $page) ? "class='active'" : $i?> ><?=($i == $page) ? "$i" : $i?></a></li>

<?php
}

if ($lastLink < $numPage) {
?>
<li class="next pager">
<a href="q_my_community.php?page=<?=$firstLink + $numLinks?>" title="다음 페이지로 이동하기"><img src="img/btn-next-page.gif"></a>
</li>
<li class="last pager">
<a href="q_my_community.php?page=<?=$numPage ?>" title="마지막 페이지로 이동하기"><img src="img/btn-last-page.gif"></a>
</li>
<?php
}
?>

                           
                        
    </ul>
    </div>
                             
    </div>
    </div>
    <br>
    <div class="bt_wrap" style="margin-left:890px;">
                <a href="q_write.php" class="on" style="border:none;">글쓰기</a>
                <!--<a href="#">수정</a>-->
            </div>
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