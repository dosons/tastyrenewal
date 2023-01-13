<?php

require("db_connect.php");


$num = $_REQUEST["num"];

/* Session */
session_start();
$U_ID = $_SESSION["userId"];
$user_name = $_SESSION["userName"];

/* member */
$query = $db->query("select * from mem_info where mem_info_id = '{$U_ID}' ");
$row = $query->fetch();
$mnum = $row["mem_info_num"];
$mwriter = $row["mem_info_nickname"];

/* recipe_movie */
$M_title = $_REQUEST["recipe_title"];
$M_introduce = $_REQUEST["recipe_introduce"];
$M_url = substr($_REQUEST["movie_url"],32);



if ($M_title== null){
	echo"<script>alert('레시피 제목을 입력해주세요.'); location.href=('movie_update.php?num=$num');</script>";
	return;
}

if ($M_introduce== null){
	echo"<script>alert('만드는 방법을 입력해주세요.'); location.href=('movie_update.php?num=$num');</script>";
	return;
}

if ($M_url== null){
	echo"<script>alert('동영상 URL은 필수 항목 입니다.'); location.href=('movie_update.php?num=$num');</script>";
	return;
}

/* 현재시간 */
$curTime = date("Y-m-d H:i:s");


$db->exec("update recipe_movie set recipe_movie_title='{$M_title}', recipe_movie_introduce='{$M_introduce}',
  mem_info_num='{$mnum}', recipe_movie_regdate='{$curTime}', recipe_movie_url='{$M_url}' where recipe_movie_num = $num");
 


/* ingre_m */
$i_name_1= $_REQUEST["name_1"];
if ($i_name_1== null){
	echo"<script>alert('한개이상의 재료는 입력해주세요.'); location.href=('movie_update.php?num=$num');</script>";
	return;
}
$i_name_2= $_REQUEST["name_2"];
$i_name_3= $_REQUEST["name_3"];
$i_name_4= $_REQUEST["name_4"];


$i_num_1= $_REQUEST["num_1"];
if ($i_num_1== null){
	echo"<script>alert('한개이상의 재료는 입력해주세요.'); location.href=('movie_update.php?num=$num');</script>";
	return;
}
$i_num_2= $_REQUEST["num_2"];
$i_num_3= $_REQUEST["num_3"];
$i_num_4= $_REQUEST["num_4"];


$query = $db->query("SELECT a.recipe_movie_num, b.mem_info_nickname
					FROM recipe_movie AS a 
					INNER JOIN mem_info AS b
					ON a.mem_info_num = b.mem_info_num
					WHERE mem_info_nickname='{$mwriter}'
					ORDER BY a.recipe_movie_num DESC LIMIT 1 ");
$row = $query->fetch();
$rwriter = $row["recipe_movie_num"];

$query = $db->query("select * from movie_basic where recipe_movie_num = $num");
$row = $query->fetch();
$I_ID = $row["movie_basic_num"];


$db->exec("update movie_basic set recipe_movie_num='{$rwriter}', mbasic_name_1='{$i_name_1}', mbasic_name_2='{$i_name_2}', 
	mbasic_name_3='{$i_name_3}', mbasic_name_4='{$i_name_4}', mbasic_num_1='{$i_num_1}', mbasic_num_2='{$i_num_2}',
	mbasic_num_3='{$i_num_3}', mbasic_num_4='{$i_num_4}' where movie_basic_num = $I_ID");



echo "<script>alert('레시피가 수정 되었습니다.'); location.href=('recipe_video.php?num=$num ');</script>";