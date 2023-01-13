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
    <link rel="stylesheet" type="text/css" href="css/board.css" />
</head>
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
                  <li><a href="store_list.php">스토어</a></li>
                  <li><a href="#">커뮤니티</a></li>
                  <li><a href="event.php">이벤트</a></li>
				  <li><a href="my.php">MY</a></li>
				  
              </ul>
          </nav>
    
       </header>


<body>
  <br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br>
  
<div id="board_area"> 
  <h1>자유게시판</h1>
  <br><br>
    <table class="list-table">
      <thead>
          <tr>
              <th width="70">번호</th>
                <th width="500">제목</th>
                <th width="120">글쓴이</th>
                <th width="100">작성일</th>
                <th width="100">조회수</th>
            </tr>
        </thead>
        <?php
        // board테이블에서 idx를 기준으로 내림차순해서 5개까지 표시
        $query = $db->query("select * from board_info order by board_info_num desc limit 0,5");

    
            while($row = $query->fetch())
            {
              //title변수에 DB에서 가져온 title을 선택
              $title=$row["board_info_title"]; 
              if(strlen($title)>30)
              { 
                //title이 30을 넘어서면 ...표시
                $title=str_replace($row["board_info_title"],mb_substr($row["board_info_title"],0,30,"utf-8")."...",$row["board_info_title"]);
              }
        ?>
      <tbody>
        <tr>
          <td width="70"><?php echo $row['board_info_num']; ?></td>
          <td width="500"><a href=""><?php echo $title;?></a></td>
          <td width="120"><?php echo $row['board_info_writer']?></td>
          <td width="100"><?php echo substr($row['board_info_regdate'],0,10)?></td>
          <td width="100"><?php echo $row['board_info_hits']; ?></td>
        </tr>
      </tbody>
      <?php } ?>
    </table>
    <div id="write_btn">
      <a href="/page/board/write.php"><button>글쓰기</button></a>
    </div>
  </div>



  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
</body>
</html>