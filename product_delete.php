<?php

session_start();
//$U_ID= $_SESSION["userId"];
$U_NUM= $_SESSION["userNum"];

require("db_connect.php");

$num = $_REQUEST["num"];

//썸네일 파일 삭제
$query = $db->query("select * from store_product where store_product_num = {$num}");
$row = $query->fetch();
$thum = $row['store_product_img'];
unlink($thum);

//데이터 삭제

$query = $db->query("delete from store_product where store_product_num={$num} ");

echo "<script>alert('등록한 스토어를 삭제 하였습니다.'); location.href=('store_list.php');</script>";

?>