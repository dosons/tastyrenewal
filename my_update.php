<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>

<?php

session_start();
$U_ID = $_SESSION["userId"];

  
$nickName = $_POST["nickname"];
$userPw = $_POST["password"];
$pwCheck = $_POST["passwordCheck"];
$email = $_POST["email"];
$phone = $_POST["phone"];
  
require("db_connect.php");
  
  if (!($nickName && $userPw && $email && $phone)) {
	  
?>

            <script>
            
                alert('모든 입력란에 값이 입력되어야 합니다.');
            	history.back();
            	
            </script>



<?php
     }else if($userPw != $pwCheck) {
?>

            <script>
            
            alert('비밀번호가 일치 하지않습니다');
            history.back();
            
            </script>



<?php

     } else if ($db->query("select count(*) from mem_info where mem_info_nickname ='{$nickName}'")->fetchColumn() > 0) {
 
?>
                <script>
                    alert('사용중인 닉네임입니다.');
                    history.back();
                </script>

<?php

     }else {
		     
        $query = $db->query("select * from mem_info where mem_info_id = '{$U_ID}' ");
        $row = $query->fetch();
        $old_nickName = $row["mem_info_nickname"];

        $db->exec("update mem_info set mem_info_nickname='{$nickName}', mem_info_pw='{$userPw}', 
					mem_info_email='{$email}', mem_info_phone='{$phone}' where mem_info_id='{$U_ID}' ");

            
        //$db->exec("update recipe_info set recipe_info_writer='{$nickName}' where recipe_info_writer='{$old_nickName }' ");
        //$db->exec("update recipe_movie set recipe_movie_writer='{$nickName}' where recipe_movie_writer='{$old_nickName }' ");
	       	
		 
?>

              <script>
            
                alert('회원정보가 수정되었습니다.');
            	window.close();
            	
				location.href='my.php';
              </script>

<?php
	 }      
	 
	 
     
?>





</body>
</html>