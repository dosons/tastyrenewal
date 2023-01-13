<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>

<?php

  $userId = $_POST["id"];
  $userPw = $_POST["pw"];
  $userName = $_POST["name"];
  


  $day = $_POST["year"];
  
  

  $nickName = $_POST["nickname"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  
  require("db_connect.php");
  
  if (!($userId && $userPw && $userName && $day && $nickName && $email && $phone)) {
	  
?>

            <script>
            
                alert('모든 입력란에 값이 입력되어야 합니다.');
            	history.back();
            	
            </script>
<?php
	  
  } else if ($db->query("select count(*) from mem_info where mem_info_id='$userId'")->fetchColumn() > 0) {
 
?>
            <script>
                alert('이미 등록된 아이디입니다.');
                history.back();
            </script>
<?php
     } else if ($db->query("select count(*) from mem_info where mem_info_phone='$phone'")->fetchColumn() > 0){

?>
        <script>
            alert('이미 가입된 계정입니다.');
            history.back();
        </script>
<?php
     }else if($db->query("select count(*) from mem_info where mem_info_nickname='$nickName'")->fetchColumn() > 0) {
?>
      <script>
          alert('사용중인 닉네임입니다.');
          history.back();
      </script>
<?php

     }else {
		     
			 $db->exec("insert into mem_info (mem_info_id, mem_info_pw, mem_info_nickname, mem_info_email, mem_info_name, mem_info_birthday, mem_info_phone)
	                       values ('$userId', '$userPw', '$nickName','$email', '$userName', '$day','$phone')");
				  
	       	
		 
?>

              <script>
            
                alert('회원가입이 완료되었습니다. 로그인 화면으로 이동합니다.');
            	window.close();
            	
				location.href='login_screen.php';
              </script>

<?php
	 }      
	 
	 
     
?>





</body>
</html>