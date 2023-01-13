<?php

require("db_connect.php");

/* Session */
session_start();
if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
	$U_NUM= $_SESSION["userNum"];
    $U_ID  = $_SESSION["userId"];
    $user_name = $_SESSION ["userName"];
} else {
     echo "<script>
          alert('로그인 후 이용 하실 수 있습니다.');
          window.close();
	 
	      location.href='login_screen.php';
           </script>
        ";
        return;
}

$store_num = $_REQUEST["num"];

$query = $db->query("SELECT *,
					(SELECT mem_info_nickname
						FROM	mem_info AS b
						WHERE a.mem_info_num = b.mem_info_num) AS mem_info_nickname
					FROM store_review AS a
					WHERE store_product_num = {$store_num}");
$row = $query->fetch();
$review = $_REQUEST["review"];

if ($review== null){
	echo"<script>alert('댓글 내용을 적어주세요.'); location.href=('store_view.php?num=$store_num&convention=ad');</script>";
	return;
}

$curTime = date("Y-m-d H:i:s");

/* reply 테이블에 받아온 값 저장 */
$db->exec("insert into store_review(store_product_num, mem_info_num, store_review_content, store_review_regdate)
			values({$store_num}, '{$U_NUM}', '{$review}', '{$curTime}' )");
 echo "<script>location.href=('store_view.php?num=$store_num&convention=ad');</script>";