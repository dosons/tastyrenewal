<?php

require("db_connect.php");

/* Session */
session_start();
if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
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

/* member */
$query = $db->query("select * from mem_info where mem_info_id = '{$U_ID}' ");
$row = $query->fetch();
$writer = $row["mem_info_nickname"];

$Board_id = $_REQUEST["num"];

$reply = $_REQUEST["reply"];

if ($reply== null){
	echo"<script>alert('댓글 내용을 적어주세요.'); location.href=('view.php?num=$Board_id');</script>";
	return;
}

$curTime = date("Y-m-d H:i:s");

/* reply 테이블에 받아온 값 저장 */
$db->exec("insert into reply_info(board_info_num, reply_info_writer, reply_info_content, reply_info_regdate) values({$Board_id}, '{$writer}', '{$reply}', '{$curTime}' )");
 echo "<script>location.href=('view.php?num=$Board_id ');</script>";