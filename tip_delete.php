<?php

session_start();
$U_ID= $_SESSION["userId"];

require("db_connect.php");

$num = $_REQUEST["num"];

//파일 삭제
$query = $db->query("select * from board_info where board_info_num = {$num}");
$row = $query->fetch();
$old_file = $row['board_info_file'];
if($old_file != null) {
	@unlink("./upload/files/".$old_file);

} 



//데이터 삭제
$query = $db->query("delete from reply_info where board_info_num = $num ");
$query = $db->query("delete from board_info where board_info_num = $num ");



echo "<script>alert('등록한 게시글을 삭제 하였습니다.'); location.href=('tip.php');</script>";

?>