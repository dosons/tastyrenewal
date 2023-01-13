<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0, maximum-scale=1.0">
    <title>로그인</title>
    <link rel="stylesheet" href="css/login.css">
    <!--font-->
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">

    <!--script-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/scrolla.jquery.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/script.js"></script>
	
	<!--login-->
    <link rel="stylesheet" href="css/style.css">
	<script src="https://kit.fontawesome.com/51db22a717.js" crossorigin="anonymous"></script>
</head>
<body>

   <div class="wrap">
       <!--header-->
       <header>
		<div class="top">
		<div class="wrapper">
		<ul class="top-menu" style="font-weight: 600;">
			<li class="test"><a href="join_screen.php"><p>회원가입</p></a></li>
			<li class="test"><a href="login_screen.php"><p>로그인</p></a></li>
			
			
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
				  
              </ul>
          </nav> 
		  
       </header>
	   <!--login-->
      
        <form name="LoginForm" method="post" action="">
	   	<section class="login-input-section-wrap">
		<h2 style="font-size: 30px; margin-bottom: 50px;">로그인</h2>
		<div class="login-input-wrap">	
			<input placeholder="아이디" type="text" name="id" id="id"></input>
		</div>
		<div class="login-input-wrap password-wrap">	
			<input placeholder="비밀번호" type="password" name="password"></input>
		</div>
		<div class="login-button-wrap">
			<input type="button" style="width: 425px; height :48px; font-size: 18px; background: #FF9D2D; color: white; border: #FF9D2D;border-radius: 20px;" value="로그인" onclick="LoginCheck();">
		<div class="login-stay-sign-in">
			<input type="checkbox" name="idsave" id="idsave"><span>아이디저장</span></input>
<script>
$(document).ready(function(){

 
 var key = getCookie("key");
 $("#id").val(key);


 if($("#id").val() !=""){               
    $("#idsave").attr("checked", true);  
 }

  $("#idsave").change(function(){
        if($("#idsave").is(":checked")){ 
            setCookie("key", $("#id").val(), 2); 
        }else{ 
            deleteCookie("key");
        }
  });

   
    $("#id").keyup(function(){ 
        if($("#idsave").is(":checked")){ 
            setCookie("key", $("#id").val(), 2); 
        }
    });
});


function setCookie(cookieName, value, exdays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
    document.cookie = cookieName + "=" + cookieValue;
}

function deleteCookie(cookieName){
    var expireDate = new Date();
    expireDate.setDate(expireDate.getDate() - 1);
    document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
}

function getCookie(cookieName) {
    cookieName = cookieName + '=';
    var cookieData = document.cookie;
    var start = cookieData.indexOf(cookieName);
    var cookieValue = '';
    if(start != -1){
        start += cookieName.length;
        var end = cookieData.indexOf(';', start);
        if(end == -1)end = cookieData.length;
        cookieValue = cookieData.substring(start, end);
    }
    return unescape(cookieValue);
}
</script>

        </form>                     <!-- form태그의 끝 -->
			<li><a href="join_screen.php">회원가입</a></li>
       
			
		</div>
		</section>
		</section>
        
	   

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
       
       
    
       
<!--로그인 폼 유효성 체크 부분-->
<script>
    function LoginCheck(){
        var F = document.LoginForm;         // 로그인폼 값 받아오기
        if (F.id.value==""){                // 로그인폼 -> id(name태그 이름)값 가져오기. 공백이라면 alert 출력
            alert("아이디를 입력해주세요");  
            F.id.focus();                   // 해당 id값을 가진 태그로 focus()가 향하게 됨
            return false;                   // 값이 없기 때문에 false로 반환. true라면 -> 값이 없더라도 submit됨
        }
        if (F.password.value==""){          // 비밀번호가 비었을 경우
            alert("비밀번호를 입력해주세요");
            F.password.focus();
            return false;
        }
        F.action="LoginCheck.php";          // 값이 모두 있고 충족한다면, form태그의 action속성을 -> LoginCheck.php로 간다.
        F.submit(); 
    }
</script>       
</div> 
</body>
</html>