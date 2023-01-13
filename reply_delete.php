<?php

require("db_connect.php");

$reply_id = $_REQUEST["num"];

$query = $db->query("select * from reply_info where reply_info_num = $reply_id  ");
$row = $query->fetch();
$Board_id = $row["board_info_num"];


//데이터 삭제
$query = $db->query("delete from reply_info where reply_info_num = $reply_id ");



echo "<script> location.href=('view.php?num=$Board_id');</script>";

?>