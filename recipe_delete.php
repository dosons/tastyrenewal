<?php

session_start();
//$U_ID= $_SESSION["userId"];
$U_NUM= $_SESSION["userNum"];

require("db_connect.php");

$num = $_REQUEST["num"];

$query = $db->query("select * from info_essen where recipe_info_num = {$num}");
$row = $query->fetch();
$e_num = $row['info_essen_num'];

$query = $db->query("select * from info_basic where recipe_info_num = {$num}");
$row = $query->fetch();
$b_num = $row['info_basic_num'];

$query = $db->query("select * from info_method where recipe_info_num = {$num}");
$row = $query->fetch();
$m_num = $row['info_method_num'];

//썸네일 파일 삭제
$query = $db->query("select * from recipe_info where recipe_info_num = {$num}");
$row = $query->fetch();
$thum = $row['recipe_info_thum'];
unlink($thum);

//데이터 삭제

$query = $db->query("delete from info_essen where info_essen_num={$e_num} ");
$query = $db->query("delete from info_basic where info_basic_num={$b_num} ");
$query = $db->query("delete from info_method where info_method_num={$m_num} ");
$query = $db->query("delete from recipe_info where recipe_info_num={$num} ");

echo "<script>alert('등록한 레시피를 삭제 하였습니다.'); location.href=('recipe_write.php');</script>";

?>