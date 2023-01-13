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
</head>
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
                  <li><a href="#">커뮤니티</a></li>
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

<?php
require("db_connect.php");
$query = $db->query("select * from mem_info where mem_info_id = '{$user_id}' ");
$row = $query->fetch();
$writer = $row["mem_info_nickname"];

$title="";
$content = "";
$action="free_register.php";

$num = $_REQUEST['num'];
$num = ($num != null && $num > 0) ? $num : 0;

if ($num > 0) {
    
    $query = $db->query("select * from board_info where board_info_num = {$num}");
    $row = $query->fetch();
    $action = "free_update.php?num=$num";

    $title = $row["board_info_title"];
    $content = $row["board_info_content"];
    $free_file = $row["board_info_file"];

}
?>
       <!--body-->
       <body>
        <div class="board_wrap">
        <div class="board_title">
            <strong>자유게시판</strong>
        </div>
        <form method="POST" action="<?=$action?>" enctype="multipart/form-data">
        <div class="board_write_wrap">
            <div class="board_write">
                <div class="title">
                    <dl>
                        <dt>제목</dt>
                        <dd><input type="text" placeholder="제목 입력" name="title" value="<?=$title?>"></dd>
                    </dl>
                </div>
                <div class="info">
                    <dl>
                        <dt>글쓴이</dt>
                        <dd><input type="text" value="<?=$writer?>" readonly></dd>
                    </dl>
                    <dl>
                        <dt>파일첨부</dt>
                        <dd><input id="file-input" type="file" name="free_file" value="<?=$free_file?>">
                            </dd>
                    </dl>
                </div>
                <div class="cont">
                    <textarea placeholder="내용 입력" style="resize: none;" name="content"><?=$content?></textarea>
                </div>
            </div>
      <div class="b-btn01 type01">
      
      <ul class="b-btn-wrap">
      <li>
      <a class="b-btn-type01" href="free.php" >취소</a>
      </li>
      <li>
      <input id="input" type="submit" value="등록">
      </li>
     
 </div>
        </div>
    </div>
</form>
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