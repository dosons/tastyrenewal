<?php
require("db_connect.php");
?>

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
    <script src="js/com.js"></script>

</head>
<body>
<div class="wrap">
       <!--header-->
       <header>
		<div class="top">
		<div class="wrapper">
		<ul class="top-menu" style="font-weight:600;">
		    
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
              <ul class="gnb" style="font-weight:800;">
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


<!--back end-->
<?php 

 $Board_id = $_REQUEST["num"];

 require("db_connect.php");

//조회수 증가
 $query = $db->query("update board_info set board_info_hits=board_info_hits+1 where board_info_num={$Board_id}");

 //$query = $db->query("select * from board_info where board_info_num = {$Board_id}");
 $query = $db->query("SELECT *,
	(SELECT mem_info_nickname
	FROM mem_info AS b
	WHERE b.mem_info_num = a.mem_info_num) AS mem_info_nickname
	from board_info AS a where a.board_info_num = {$Board_id}");
	
 $row = $query->fetch();



 $title = $row['board_info_title'];
 $writer = $row['mem_info_nickname'];
 $regdate = substr($row['board_info_regdate'],0,10);
 $hits = $row['board_info_hits'];
 $content = $row['board_info_content'];
 $fileName= $row['board_info_file']
 

 

?>
<body>
    <div class="board_wrap">
        <div class="board_title">
            <strong>자유게시판</strong>
        </div>
        <div class="board_view_wrap">
            <div class="board_view">
                <div class="title">
                    <?=$title?>
                </div>
                <div class="info">
                    <dl>
                        <dt>번호</dt>
                        <dd><?=$Board_id?></dd>
                    </dl>
                    <dl>
                        <dt>글쓴이</dt>
                        <dd><?=$writer?></dd>
                    </dl>
                    <dl>
                        <dt>작성일</dt>
                        <dd><?=$regdate?></dd>
                    </dl>
                    <dl>
                        <dt>조회</dt>
                        <dd><?=$hits?></dd>
                    </dl>
                    <dl>
                        <dt>첨부파일 </dt>
                        <dd><a href="download.php?filename=<?=$fileName?>"><?=$fileName?></a></dd>
                    </dl>
                </div>
                <div class="cont">
                    <?=nl2br($content)?><br><br><br><br><br>
<?php
 $numRecords = $query = $db->query("select count(*) from reply_info where board_info_num={$Board_id}")->fetchColumn(); 
?>
                    <b style="font-size: 16px;">댓글(<?=$numRecords?>)</b><br>
                </div>
               
            </div>

        <!-- 댓글 폼-->
       
     <div id= "reply_wrap">

<!-- back end-->
<?php


 $query = $db->query("select * from reply_info where board_info_num = $Board_id");

 while($row = $query->fetch()) {
   $r_content = $row["reply_info_content"];
   $r_writer = $row["reply_info_writer"];


?>

<div>
        <br>
       <h1 style="font-size:15px;"><b><?=$r_writer?></b>&nbsp;<na style="font-size:11px; Color:gray;"><?=substr($row['reply_info_regdate'],0,16)?></na></h1>
       <br>
       <?=nl2br($r_content)?><br><br>
<?php

if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
           
           //$query2 = $db->query("select * from mem_info where mem_info_id = '{$user_id}' ");
           //$row = $query2->fetch();
           //$check_name = $row['mem_info_nickname'];
          if($user_name == $r_writer) {
            $query3 = $db->query("select * from reply_info where board_info_num = $Board_id 
									and reply_info_content = '{$r_content}' ");
            $row = $query3->fetch()

?>

       <a href="reply_delete.php?num=<?=$row['reply_info_num']?>">삭제</a>
<?php

          }
}
?>
       <br> <br>
       <hr  style="border: solid 0.1px; Color:#e4e4e4; width: 100%; margin-left: auto;margin-right: auto;">
    </div>

<?php
 }

?>

   



    </div>
    </div>

<form action="reply_register.php?num=<?=$Board_id?>" method="POST">
            <div id="comment_box">
                
                <img id="title_comment" >
            <textarea style="resize:none;" name="reply"></textarea>
            <div id="ok_ripple"><input type="submit" style="display:block;padding:30px 22px;border:1px solid rgba(0,0,0,0.3);font-size:14px;color:#333; background-Color:white;" value="등록"></div>
            </div>
</form>

            <div class="bt_wrap">
<?php
     if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
                $user_id = $_SESSION["userId"];
                
                $query = $db->query("select * from mem_info where mem_info_id = '{$user_id}' ");
                $row = $query->fetch();
                $check_name = $row['mem_info_nickname'];

                if($check_name == $writer) {
?>
                <a href="free.php" class="on" style="border:none;">목록</a>
                <a href="free_update.php?num=<?=$Board_id?>">수정</a>
                <a href="free_delete.php?num=<?=$Board_id?>">삭제</a>
<?php
      } else {

?>
     <a href="free.php" class="on" style="border:none;">목록</a>

<?php
      }

} else {
?>

<a href="free.php" class="on" style="border:none;">목록</a>
<?php
    
}
?>
 
               
                


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