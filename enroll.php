<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>

<?php
  require("db_connect.php");

  session_start();
	$U_ID = $_SESSION["userId"];
	$user_name = $_SESSION["userName"];

	$query = $db->query("select * from mem_info where mem_info_id = '{$U_ID}' ");
	$row = $query->fetch();
	$num = $row["mem_info_num"];

  $store_name = $_POST["store_name"];
  $store_addr = $_POST["store_addr"];
  $store_call = $_POST["store_call"];
  $store_regist = $_POST["store_regist"];
    
  //echo $store_name;
/* member */

  if (!($store_name && $store_addr && $store_call && $store_regist)) {
	  
?>
            <script>
            
                alert('모든 입력란에 값이 입력되어야 합니다.');
            	history.back();
            	
            </script>
<?php
	  
  } else if ($db->query("select count(*) from store_info where mem_info_num ='$num'")->fetchColumn() > 0) {
 
?>
            <script>
                alert('이미 가입된 스토어가 존재합니다.');
                history.back();
            </script>
<?php
     } else if ($db->query("select count(*) from store_info where store_info_name='$store_name'")->fetchColumn() > 0){

?>
        <script>
            alert('이미 등록된 상호명입니다.');
            history.back();
        </script>
<?php
     }else if($db->query("select count(*) from store_info where store_info_regist='$store_regist'")->fetchColumn() > 0) {
?>
      <script>
          alert('이미 등록된 사업자등록번호입니다.');
          history.back();
      </script>
<?php

     }else {
	
			 $db->exec("insert into store_info (mem_info_num, store_info_name, store_info_call, store_info_regtime, store_info_address, store_info_regist)
	                       values ('$num', '$store_name', '$store_call','221209182730', '$store_addr', '$store_regist')");
				  
		 
?>

              <script>
            
                alert('업주 등록이 완료되었습니다. 메인으로 이동합니다.');
            	window.close();
            	
				location.href='index.php';
              </script>

<?php
	 }      
	 
	 
     
?>





</body>
</html>