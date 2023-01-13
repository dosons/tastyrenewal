<?php

require("db_connect.php");

/* Session */
session_start();
$U_ID = $_SESSION["userId"];
$user_name = $_SESSION["userName"];

/* member */
$query = $db->query("select * from mem_info where mem_info_id = '{$U_ID}' ");
$row = $query->fetch();
$mnum = $row["mem_info_num"];
$mwriter = $row["mem_info_nickname"];

/*
SELECT recipe_info_num, recipe_info_title, recipe_info_regdate, recipe_info_thum, recipe_info_hits,
   (SELECT mem_info_nickname
   FROM   mem_info AS b
   WHERE a.mem_info_num = b.mem_info_num) AS mem_info_nickname
FROM recipe_info AS a
*/

/*$query2 = $db->query("select mem_info_num from mem_info where mem_info_nickname = '{$writer}' ");

echo "{$query2}";
*/

/* recipe_movie */
$M_title = $_REQUEST["recipe_title"];
$M_introduce = $_REQUEST["recipe_introduce"];
$M_url = substr($_REQUEST["movie_url"],17);

if ($M_title== null){
	echo"<script>alert('레시피 제목을 입력해주세요.'); location.href=('movie_submit.php');</script>";
	return;
}

if ($M_introduce== null){
	echo"<script>alert('만드는 방법을 입력해주세요.'); location.href=('movie_submit.php');</script>";
	return;
}

if ($M_url== null){
	echo"<script>alert('동영상 URL은 필수 항목 입니다.'); location.href=('movie_submit.php');</script>";
	return;
}

/* 현재시간 */
$curTime = date("Y-m-d H:i:s");

/* recipe_movie테이블에 받아온 값 저장 */
$db->exec("insert into recipe_movie(recipe_movie_title, recipe_movie_introduce,  mem_info_num,
			recipe_movie_regdate, recipe_movie_url, recipe_movie_hits)
 values('{$M_title}', '{$M_introduce}', '{$mnum}', '{$curTime}', '{$M_url}', 0)");


/* ingre_w */
$m_name_1= $_REQUEST["messen_name_1"];
$m_name_2= $_REQUEST["messen_name_2"];
$m_name_3= $_REQUEST["messen_name_3"];
$m_name_4= $_REQUEST["messen_name_4"];


$m_num_1= $_REQUEST["movie_essen_num_1"];
$m_num_2= $_REQUEST["movie_essen_num_2"];
$m_num_3= $_REQUEST["movie_essen_num_3"];
$m_num_4= $_REQUEST["movie_essen_num_4"];

$query = $db->query("SELECT a.recipe_movie_num, b.mem_info_nickname
					FROM recipe_movie AS a 
					INNER JOIN mem_info AS b
					ON a.mem_info_num = b.mem_info_num
					WHERE mem_info_nickname='{$mwriter}'
					ORDER BY a.recipe_movie_num DESC LIMIT 1 ");
$row = $query->fetch();
$rwriter = $row["recipe_movie_num"];


/* ingre_m 테이블에 전달받은 값을 저장 */ 
$db->exec("insert into movie_essen (recipe_movie_num, messen_name_1, messen_name_2, messen_name_3, messen_name_4,  
			movie_essen_num_1, movie_essen_num_2, movie_essen_num_3, movie_essen_num_4)
 values('{$rwriter}', '{$m_name_1}', '{$m_name_2}', '{$m_name_3}', '{$m_name_4}', 
			'{$m_num_1}', '{$m_num_2}', '{$m_num_3}', '{$m_num_4}')");

$query = $db->query("select * from recipe_movie where recipe_movie_title = '{$M_title}' ");
$row = $query->fetch();

$Recipe_ID = $row["recipe_movie_num"];






/* connection_m 테이블에 $Recipe_id 와 $Ingre_ID 값 저장 */
//$db->exec("insert into connection_m(recipe_id, ingre_id) values('{$Recipe_ID}', '{$Ingre_ID}')");
//$query = $db->query("select * from connection_m where recipe_id = '{$Recipe_ID}' and ingre_id = '{$Ingre_ID}'");
//$row = $query->fetch();

//$Con_ID = $row["con_m_id"];


/* my_movie테이블에 con_m_id 와 id를 저장 */
//$db->exec("insert into my_movie(con_m_id, id) values('{$Con_ID}', '{$U_ID}')");
echo "<script>alert('레시피가 등록되었습니다.'); location.href=('recipe_video.php?num=$Recipe_ID ');</script>";