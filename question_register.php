<?php

require("db_connect.php");

/* Session */
session_start();
$U_ID = $_SESSION["userId"];
$user_name = $_SESSION["userName"];

/* member */
$query = $db->query("select * from mem_info where mem_info_id = '{$U_ID}' ");
$row = $query->fetch();
$qnum = $row["mem_info_num"];
$qwriter = $row["mem_info_nickname"];

/* board(free) */
$title = $_REQUEST["title"];
$content = $_REQUEST["content"];

if ($title== null){
	echo"<script>alert('게시글 제목을 입력해주세요.'); location.href=('q_write.php');</script>";
	return;
}

if ($content== null){
	echo"<script>alert('게시글 내용을 입력해주세요.'); location.href=('q_write.php');</script>";
	return;
}


/* board_file  */

   if ($_FILES["free_file"]["name"] == NULL) {

    $fname = "";

   } else if (!(isset($_FILES["free_file"]["error"]) && $_FILES["free_file"]["error"] == UPLOAD_ERR_OK)) {
       
             
   } else {
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
$type = "question";
/* board 테이블에 받아온 값 저장 */

$query = $db->query("SELECT a.board_info_num, b.mem_info_nickname
					FROM board_info AS a 
					INNER JOIN mem_info AS b
					ON a.mem_info_num = b.mem_info_num
					WHERE mem_info_nickname='{$qwriter}'
					ORDER BY a.board_info_num DESC LIMIT 1 ");
$row = $query->fetch();

$db->exec("insert into board_info(board_info_title, board_info_content, mem_info_num, board_info_regdate, board_info_file, board_info_hits, board_info_type)
 values('{$title}', '{$content}', '{$qnum}', '{$curTime}', '{$fname}', 0, '{$type}')");

/*
$query = $db->query("select * from board_info where board_info_title = '{$title}' and board_info_writer = '{$writer}' 
					and board_info_content = '{$content}' and board_info_type='{$type}' ");
$row = $query->fetch();
*/

$Board_id = $row["board_info_num"];
 


 echo "<script>alert('게시글이 등록되었습니다.'); location.href=('q_view.php?num=$Board_id ');</script>";