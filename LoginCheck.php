<!doctype html>
 <html>
 <head>
     <meta charset="utf-8">
 </head>
 <body>
 <?php 
        $userId = trim($_POST["id"]);           // post 방식으로 보내서 post로 받나?
        $userPw = trim($_POST["password"]);
        
     
         require("db_connect.php");         // DB 커넥터 호출인듯?
     
         $query = $db->query("select * from mem_info where mem_info_id='$userId' and mem_info_pw='$userPw'");
         if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
             session_start();
             
			 $_SESSION["userNum"] = $row["mem_info_num"];
             $_SESSION["userId"] = $row["mem_info_id"];
             $_SESSION["userName"] = $row["mem_info_nickname"];
			 
			 if($row["mem_info_id"] == "root") {
?>

                <script>
				alert('관리자모드로 접속하셨습니다.');
				location.href='#';
				</script>

<?php				 
			 } else { 

               
 ?>
			     <script>
                 alert('<?=$row["mem_info_nickname"]?>님 로그인 되었습니다');
                 location.href='index.php';
                 </script>
			 
<?php 
     }
?>
 

 
 <?php 
           
         } else {
 ?>
 

 
 <script>
     alert('아이디 또는 비밀번호가 틀렸습니다.');
     history.back();
 </script>
 
<?php   
      }
?>

</body>
</html>