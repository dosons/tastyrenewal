<?php

session_start();
//$U_ID= $_SESSION["userId"];
$U_NUM= $_SESSION["userNum"];

require("db_connect.php");

$movie_id = $_REQUEST["num"];

$query = $db->query("select * from recipe_movie where mem_info_num = {$U_NUM}");
$row = $query->fetch();
//$Con_ID = $row['con_m_id'];
$Ingre_id = $row['recipe_movie_num'];

$query = $db->query("select * from movie_basic where recipe_movie_num = {$movie_id}");
$row = $query->fetch();
$Recipe_id = $row['movie_basic_num'];

//$query = $db->query("select * from my_movie where con_m_id={$Con_ID} and id='{$U_ID}' ");
//$row = $query->fetch();
//$My_movie_id = $row['my_movie_id'];




//데이터 삭제
//$query = $db->query("delete from my_movie where my_movie_id = {$My_movie_id} ");
//$query = $db->query("delete from connection_m where con_m_id={$Con_ID} ");
$query = $db->query("delete from recipe_movie where recipe_movie_num={$movie_id} ");
$query = $db->query("delete from movie_basic where movie_basic_num={$Recipe_id} ");




echo "<script>alert('업로드 한 영상을 삭제 하였습니다.'); location.href=('recipe_movie.php');</script>";

?>