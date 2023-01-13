<?php

require("db_connect.php");

/* Session */
session_start();
$U_ID = $_SESSION["userId"];
$user_name = $_SESSION["userName"];

$num = $_REQUEST["num"];






/* member */
$query = $db->query("select * from mem_info where mem_info_id = '{$U_ID}' ");
$row = $query->fetch();
$writer = $row["mem_info_nickname"];

/* recipe_write */
$title = $_REQUEST["title"];
$content = $_REQUEST["content"];


if ($title== null){
	echo"<script>alert('게시글 제목을 입력해주세요.'); location.href=('tip_update.php?num=$num');</script>";
	return;
}

if ($content == null){
	echo"<script>alert('내용을 입력해주세요.'); location.href=('tip_update.php?num=$num');</script>";
	return;
}




/* board_file  */

if ($_FILES["free_file"]["name"] == NULL) {

	$query = $db->query("select * from board_info where board_info_num = {$num}");
	$row = $query->fetch();
    $fname = $row['board_info_file'];

   } else if (!(isset($_FILES["free_file"]["error"]) && $_FILES["free_file"]["error"] == UPLOAD_ERR_OK)) {
       
             
   } else {


 //기존 파일 삭제
$query = $db->query("select * from board_info where board_info_num = {$num}");
$row = $query->fetch();
$old_file = $row['board_info_file'];
if($old_file != null) {
	@unlink("./upload/files/".$old_file);

} 
       $tname = $_FILES["free_file"]["tmp_name"];
       $fname = $_FILES["free_file"]["name"];
       $fsize = $_FILES["free_file"]["size"];
 
        $save_name = iconv("utf-8", "cp949", $fname);
 
        if (file_exists("upload/files/$save_name")) {
    
             
        } else if (!move_uploaded_file($tname, "upload/files/$save_name")) {
           
             
        } else {
           
            
          
        }
    }

$curTime = date("Y-m-d H:i:s");


 $db->exec("update board_info set board_info_title='{$title}', board_info_content='{$content}', 
			board_info_regdate='{$curTime}', board_info_file='{$fname}' where board_info_num = $num ");
 


 echo "<script>alert('게시글이 수정되었습니다.'); location.href=('t_view.php?num=$num ');</script>";