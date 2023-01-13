<?php

require("db_connect.php");

$review_num = $_REQUEST["num"];

$query = $db->query("select * from store_review where store_review_num = $review_num");
$row = $query->fetch();
$Board_id = $row["store_product_num"];


//데이터 삭제
$query = $db->query("delete from store_review where store_review_num = $review_num ");



echo "<script> location.href=('store_view.php?num=$Board_id&convention=ad');</script>";

?>