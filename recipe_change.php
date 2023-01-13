<?php

require("db_connect.php");

/* Session */
session_start();
$U_ID = $_SESSION["userId"];
$user_name = $_SESSION["userName"];

$num = $_REQUEST["num"];

//썸네일 파일 삭제
$query = $db->query("select * from recipe_info where recipe_info_num = {$num}");
$row = $query->fetch();
$thum = $row['recipe_info_thum'];
unlink($thum);

/* member */
$query = $db->query("select * from mem_info where mem_info_id = '{$U_ID}' ");
$row = $query->fetch();
$inum = $row["mem_info_num"];
$iwriter = $row["mem_info_nickname"];

/* recipe_write */
$R_title = $_REQUEST["recipe_title"];
$R_introduce = $_REQUEST["recipe_introduce"];



if ($R_title== null){
	echo"<script>alert('레시피 제목을 입력해주세요.'); location.href=('recipe_update.php?num=$num');</script>";
	return;
}

if ($R_introduce== null){
	echo"<script>alert('만드는 방법을 입력해주세요.'); location.href=('recipe_update.php?num=$num');</script>";
	return;
}


//*************************thum_img file *****************************

// 임시로 저장된 정보(tmp_name)
$tempFile = $_FILES['thum_img']['tmp_name'];

// 파일타입 및 확장자 체크
$fileTypeExt = explode("/", $_FILES['thum_img']['type']);

// 파일 타입 
$fileType = $fileTypeExt[0];

// 파일 확장자
$fileExt = $fileTypeExt[1];
if($fileExt == Null) {
	echo"<script>alert('메인 이미지는 필수 항목입니다.'); location.href=('recipe_update.php?num=$num');</script>";
	return;
}
// 확장자 검사
$extStatus = false;

switch($fileExt){
	case 'jpeg':
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		$extStatus = true;
		break;
	
	default:
		echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
		exit;
		break;
}

// 이미지 파일이 맞는지 검사. 
if($fileType == 'image'){
	// 허용할 확장자를 jpg, bmp, gif, png로 정함, 그 외에는 업로드 불가
	if($extStatus){
		// 임시 파일 옮길 디렉토리 및 파일명
		$resFile = "./upload/{$_FILES['thum_img']['name']}";
		// 임시 저장된 파일을 우리가 저장할 디렉토리 및 파일명으로 옮김
		$imageUpload = move_uploaded_file($tempFile, $resFile);
		
		// 업로드 성공 여부 확인
		if($imageUpload == true){
		
            //업로드 성공
            
		}else{
			 echo "<script>alert('파일 업로드에 실패하였습니다.'); location.href=('recipe_update.php?num=$num');</script>";
		}
	}	// end if - extStatus
		// 확장자가 jpg, bmp, gif, png가 아닌 경우 else문 실행
	else {
	     echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.'); location.href=('recipe_update.php?num=$num');</script>";
		
	}	
}	// end if - filetype
	// 파일 타입이 image가 아닌 경우 
else {
	echo "<script>alert('이미지 파일이 아닙니다.'); location.href=('recipe_update.php?num=$num');</script>";
	
}
//*************************thum_img file *****************************


/* 현재시간 */
$curTime = date("Y-m-d H:i:s");


// 제목 회원번호 소개 등록일(잠깐 빼자) 썸네일(resFile) 조회수 (0시작)
$db->exec("update recipe_info set recipe_info_title='{$R_title}', mem_info_num='{$inum}', recipe_info_introduce='{$R_introduce}', 
			recipe_info_regdate='{$curTime}', recipe_info_thum='{$resFile}', recipe_info_hits=0 where recipe_info_num = '$num'");


 /* sub_img file */

 // ********************Sub_img1*****************************************
if($_FILES['method_img_1']['type'] == NUll) {

	$method_img_1 = "";
	
} else {

$tempFile = $_FILES['method_img_1']['tmp_name'];
$fileTypeExt = explode("/", $_FILES['method_img_1']['type']);
$fileType = $fileTypeExt[0];
$fileExt = $fileTypeExt[1];
$extStatus = false;

switch($fileExt){
	case 'jpeg':
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		$extStatus = true;
		break;
	
	default:
		echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
		exit;
		break;
}

if($fileType == 'image'){
	
	if($extStatus){
		
		$method_img_1 = "./upload/{$_FILES['method_img_1']['name']}";
		$imageUpload = move_uploaded_file($tempFile, $method_img_1);
		
		if($imageUpload == true){
		
            //업로드 성공
            
		}else{
			 echo "<script>alert('파일 업로드에 실패하였습니다.'); location.href=('recipe_update.php?num=$num');</script>";
		}
	}	
		
	else {
	     echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.'); location.href=('recipe_update.php?num=$num');</script>";
		
	}	

} else {
	echo "<script>alert('이미지 파일이 아닙니다.'); location.href=('recipe_update.php?num=$num');</script>";
	
       }
}
 // ********************method_img_1*****************************************

 // ********************Sub_img2*****************************************
if($_FILES['method_img_2']['type'] == NUll) {

	$method_img_2 = "";
	
} else {

$tempFile = $_FILES['method_img_2']['tmp_name'];
$fileTypeExt = explode("/", $_FILES['method_img_2']['type']);
$fileType = $fileTypeExt[0];
$fileExt = $fileTypeExt[1];
$extStatus = false;

switch($fileExt){
	case 'jpeg':
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		$extStatus = true;
		break;
	
	default:
		echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
		exit;
		break;
}

if($fileType == 'image'){
	
	if($extStatus){
		
		$method_img_2 = "./upload/{$_FILES['method_img_2']['name']}";
		$imageUpload = move_uploaded_file($tempFile, $method_img_2);
		
		if($imageUpload == true){
		
            //업로드 성공
            
		}else{
			 echo "<script>alert('파일 업로드에 실패하였습니다.'); location.href=('recipe_update.php?num=$num');</script>";
		}
	}	
		
	else {
	     echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.'); location.href=('recipe_update.php?num=$num');</script>";
		
	}	

} else {
	echo "<script>alert('이미지 파일이 아닙니다.'); location.href=('recipe_update.php?num=$num');</script>";
	
       }
}
 // ********************method_img_3*****************************************
// ********************Sub_img3*****************************************
if($_FILES['method_img_3']['type'] == NUll) {

	$method_img_3 = "";
	
} else {

$tempFile = $_FILES['method_img_3']['tmp_name'];
$fileTypeExt = explode("/", $_FILES['method_img_3']['type']);
$fileType = $fileTypeExt[0];
$fileExt = $fileTypeExt[1];
$extStatus = false;

switch($fileExt){
	case 'jpeg':
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		$extStatus = true;
		break;
	
	default:
		echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
		exit;
		break;
}

if($fileType == 'image'){
	
	if($extStatus){
		
		$method_img_3 = "./upload/{$_FILES['method_img_3']['name']}";
		$imageUpload = move_uploaded_file($tempFile, $method_img_3);
		
		if($imageUpload == true){
		
            //업로드 성공
            
		}else{
			 echo "<script>alert('파일 업로드에 실패하였습니다.'); location.href=('recipe_update.php?num=$num');</script>";
		}
	}	
		
	else {
	     echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.'); location.href=('recipe_update.php?num=$num');</script>";
		
	}	

} else {
	echo "<script>alert('이미지 파일이 아닙니다.'); location.href=('recipe_update.php?num=$num');</script>";
	
       }
}
 // ********************method_img_3*****************************************

// ********************Sub_img4*****************************************
if($_FILES['method_img_4']['type'] == NUll) {

	$method_img_4 = "";
	
} else {

$tempFile = $_FILES['method_img_4']['tmp_name'];
$fileTypeExt = explode("/", $_FILES['method_img_4']['type']);
$fileType = $fileTypeExt[0];
$fileExt = $fileTypeExt[1];
$extStatus = false;

switch($fileExt){
	case 'jpeg':
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		$extStatus = true;
		break;
	
	default:
		echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
		exit;
		break;
}

if($fileType == 'image'){
	
	if($extStatus){
		
		$method_img_4 = "./upload/{$_FILES['method_img_4']['name']}";
		$imageUpload = move_uploaded_file($tempFile, $method_img_4);
		
		if($imageUpload == true){
		
            //업로드 성공
            
		}else{
			 echo "<script>alert('파일 업로드에 실패하였습니다.'); location.href=('recipe_update.php?num=$num');</script>";
		}
	}	
		
	else {
	     echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.'); location.href=('recipe_update.php?num=$num');</script>";
		
	}	

} else {
	echo "<script>alert('이미지 파일이 아닙니다.'); location.href=('recipe_update.php?num=$num');</script>";
	
       }
}
 // ********************method_img_4*****************************************
 
// ********************Sub_img5*****************************************
if($_FILES['method_img_5']['type'] == NUll) {

	$method_img_5 = "";
	
} else {

$tempFile = $_FILES['method_img_5']['tmp_name'];
$fileTypeExt = explode("/", $_FILES['method_img_5']['type']);
$fileType = $fileTypeExt[0];
$fileExt = $fileTypeExt[1];
$extStatus = false;

switch($fileExt){
	case 'jpeg':
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		$extStatus = true;
		break;
	
	default:
		echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
		exit;
		break;
}

if($fileType == 'image'){
	
	if($extStatus){
		
		$method_img_5 = "./upload/{$_FILES['method_img_5']['name']}";
		$imageUpload = move_uploaded_file($tempFile, $method_img_5);
		
		if($imageUpload == true){
		
            //업로드 성공
            
		}else{
			 echo "<script>alert('파일 업로드에 실패하였습니다.'); location.href=('recipe_update.php?num=$num');</script>";
		}
	}	
		
	else {
	     echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.'); location.href=('recipe_update.php?num=$num');</script>";
		
	}	

} else {
	echo "<script>alert('이미지 파일이 아닙니다.'); location.href=('recipe_update.php?num=$num');</script>";
	
       }
}
 // ********************method_img_5*****************************************
 
// ********************Sub_img6*****************************************
if($_FILES['method_img_6']['type'] == NUll) {

	$method_img_6 = "";
	
} else {

$tempFile = $_FILES['method_img_6']['tmp_name'];
$fileTypeExt = explode("/", $_FILES['method_img_6']['type']);
$fileType = $fileTypeExt[0];
$fileExt = $fileTypeExt[1];
$extStatus = false;

switch($fileExt){
	case 'jpeg':
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		$extStatus = true;
		break;
	
	default:
		echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
		exit;
		break;
}

if($fileType == 'image'){
	
	if($extStatus){
		
		$method_img_6 = "./upload/{$_FILES['method_img_6']['name']}";
		$imageUpload = move_uploaded_file($tempFile, $method_img_6);
		
		if($imageUpload == true){
		
            //업로드 성공
            
		}else{
			 echo "<script>alert('파일 업로드에 실패하였습니다.'); location.href=('recipe_update.php?num=$num');</script>";
		}
	}	
		
	else {
	     echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.'); location.href=('recipe_update.php?num=$num');</script>";
		
	}	

} else {
	echo "<script>alert('이미지 파일이 아닙니다.'); location.href=('recipe_update.php?num=$num');</script>";
	
       }
}
 // ********************method_img_6*****************************************




/* recipe_write 테이블에서 글 제목으로 recipe_id를 찾아서 cooking_img 테이블에 저장 */
$query = $db->query("select * from recipe_info where recipe_info_title = '{$R_title}' ");
$row = $query->fetch();

$Recipe_ID = $row["recipe_info_num"];


/* 기본재료 */
$e_name_1= $_REQUEST["e_name_1"];
$e_name_2= $_REQUEST["e_name_2"];
$e_name_3= $_REQUEST["e_name_3"];
$e_name_4= $_REQUEST["e_name_4"];
$e_name_5= $_REQUEST["e_name_5"];
$e_name_6= $_REQUEST["e_name_6"];

// 기본재료 무게
$e_num_1= $_REQUEST["e_num_1"];
$e_num_2= $_REQUEST["e_num_2"];
$e_num_3= $_REQUEST["e_num_3"];
$e_num_4= $_REQUEST["e_num_4"];
$e_num_5= $_REQUEST["e_num_5"];
$e_num_6= $_REQUEST["e_num_6"];

//필수재료
$b_name_1= $_REQUEST["b_name_1"];
$b_name_2= $_REQUEST["b_name_2"];
$b_name_3= $_REQUEST["b_name_3"];
$b_name_4= $_REQUEST["b_name_4"];
$b_name_5= $_REQUEST["b_name_5"];
$b_name_6= $_REQUEST["b_name_6"];

// 필수재료 무게
$b_num_1= $_REQUEST["b_num_1"];
$b_num_2= $_REQUEST["b_num_2"];
$b_num_3= $_REQUEST["b_num_3"];
$b_num_4= $_REQUEST["b_num_4"];
$b_num_5= $_REQUEST["b_num_5"];
$b_num_6= $_REQUEST["b_num_6"];


$r_txt_1= $_REQUEST["method_text_1"];
$r_txt_2= $_REQUEST["method_text_2"];
$r_txt_3= $_REQUEST["method_text_3"];
$r_txt_4= $_REQUEST["method_text_4"];
$r_txt_5= $_REQUEST["method_text_5"];
$r_txt_6= $_REQUEST["method_text_6"];

// 이미지는 위에 파일처리 단에서 변수 선언되어있음



// 최근 엔드포인트 중 한개에서 레시피 번호 가져오기?
$query = $db->query("SELECT a.recipe_info_num, b.mem_info_nickname
					FROM recipe_info AS a 
					INNER JOIN mem_info AS b
					ON a.mem_info_num = b.mem_info_num
					WHERE mem_info_nickname='{$iwriter}'
					ORDER BY a.recipe_info_num DESC LIMIT 1 ");
$row = $query->fetch();
$rwriter = $row["recipe_info_num"];

$query = $db->query("select * from info_essen where recipe_info_num = $num");
$row = $query->fetch();
$e_num = $row["info_essen_num"];

$query = $db->query("select * from info_basic where recipe_info_num = $num");
$row = $query->fetch();
$b_num = $row["info_basic_num"];

$query = $db->query("select * from info_method where recipe_info_num = $num");
$row = $query->fetch();
$m_num = $row["info_method_num"];

/* method 테이블에 설명1~6, 이미지 1~6을 저장해야한다.
0. 
1. 제목, 소개, 썸네일 등록 reciple info에 등록 (첫번째 엔드포인트)
2. recipe_info의 글번호를 받아와서 필수재료 기본재료 추가
3. recipe_info의 글번호를 받아와서 설명1~6과 이미지1~6 추가

$R_title = $_REQUEST["recipe_title"];	제목
$R_introduce = $_REQUEST["recipe_introduce"]; 	내용
$inum = $row["mem_info_num"];	회원번호
$iwriter = $row["mem_info_nickname"];	닉네임

*/

/* 재료 등록 테이블 */ 
$db->exec("update info_essen set recipe_info_num='{$rwriter}', iessen_name_1='{$e_name_1}', iessen_name_2='{$e_name_2}', iessen_name_3='{$e_name_3}', 
			iessen_name_4='{$e_name_4}', iessen_name_5='{$e_name_5}', iessen_name_6='{$e_name_6}',
			iessen_num_1='{$e_num_1}', iessen_num_2='{$e_num_2}', iessen_num_3='{$e_num_3}', 
			iessen_num_4='{$e_num_4}', iessen_num_5='{$e_num_5}', iessen_num_6='{$e_num_6}' where info_essen_num = $e_num");

$db->exec("update info_basic set recipe_info_num='{$rwriter}', ibasic_name_1='{$b_name_1}', ibasic_name_2='{$b_name_2}', ibasic_name_3='{$b_name_3}', 
			ibasic_name_4='{$b_name_4}', ibasic_name_5='{$b_name_5}', ibasic_name_6='{$b_name_6}',
			ibasic_num_1='{$b_num_1}', ibasic_num_2='{$b_num_2}', ibasic_num_3='{$b_num_3}', 
			ibasic_num_4='{$b_num_4}', ibasic_num_5='{$b_num_5}', ibasic_num_6='{$b_num_6}' where info_basic_num = $b_num");
  
  
// method_img_1는 REQUEST로 받을 수 없다. multipart로 받고 위에서 넘겨받은 이미지를 처리해주고 있음
$db->exec("update info_method set recipe_info_num='{$rwriter}', imethod_text_1='{$r_txt_1}',imethod_text_2='{$r_txt_2}', imethod_text_3='{$r_txt_3}', 
imethod_text_4='{$r_txt_4}', imethod_text_5='{$r_txt_5}',imethod_text_6='{$r_txt_6}',
imethod_img_1='{$method_img_1}',imethod_img_2='{$method_img_2}',imethod_img_3='{$method_img_3}',
imethod_img_4='{$method_img_4}',imethod_img_5='{$method_img_5}',imethod_img_6='{$method_img_6}' where info_method_num = $m_num");

echo "<script>alert('레시피가 수정 되었습니다.'); location.href=('recipe_view.php?num=$rwriter ');</script>";



//echo "<script>alert('레시피가 수정 되었습니다.'); location.href=('recipe_view.php?num=$num ');</script>";