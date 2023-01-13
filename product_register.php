<?php

require("db_connect.php");

/* Session */
session_start();
$U_ID = $_SESSION["userId"];
$user_name = $_SESSION["userName"];

/* 스토어 */
$product_name= $_REQUEST["product_name"];
$product_origin= $_REQUEST["product_origin"];
$product_price= $_REQUEST["product_price"];
$product_notice= $_REQUEST["product_notice"];
$product_delivery= $_REQUEST["product_delivery"];
$product_fee= $_REQUEST["product_fee"];
$product_sale= $_REQUEST["product_sale"]; 
// 할인율 적용 총금액
//$product_total= $product_price - ($product_price*($product_sale/100));

/* member */
$query = $db->query("select * from mem_info where mem_info_id = '{$U_ID}' ");
$row = $query->fetch();
$inum = $row["mem_info_num"];
$iwriter = $row["mem_info_nickname"];

// 세션을 통해 자신의 스토어 번호 가져오기
$query = $db->query("SELECT *
					FROM store_info AS a
					INNER JOIN mem_info AS b
					ON a.mem_info_num = b.mem_info_num
					WHERE b.mem_info_nickname = '$user_name';");
$row = $query->fetch();
$num = $row["store_info_num"];

if ($product_name== null){
	echo"<script>alert('상품의 이름을 입력하세요'); location.href=('product_form.php');</script>";
	return;
}

if ($product_price== null){
	echo"<script>alert('가격을 입력해주세요'); location.href=('product_form.php');</script>";
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
	echo"<script>alert('메인 이미지는 필수 항목입니다.'); location.href=('product_form.php');</script>";
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
			 echo "<script>alert('파일 업로드에 실패하였습니다.'); location.href=('product_form.php');</script>";
		}
	}	// end if - extStatus
		// 확장자가 jpg, bmp, gif, png가 아닌 경우 else문 실행
	else {
	     echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.'); location.href=('product_form.php');</script>";
		
	}	
}	// end if - filetype
	// 파일 타입이 image가 아닌 경우 
else {
	echo "<script>alert('이미지 파일이 아닙니다.'); location.href=('product_form.php');</script>";
	
}
//*************************thum_img file *****************************

// ******************** product_poster*****************************************
if($_FILES['product_poster']['type'] == NUll) {

	$product_poster = "";
	
} else {

$tempFile = $_FILES['product_poster']['tmp_name'];
$fileTypeExt = explode("/", $_FILES['product_poster']['type']);
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
		
		$product_poster = "./upload/{$_FILES['product_poster']['name']}";
		$imageUpload = move_uploaded_file($tempFile, $product_poster);
		
		if($imageUpload == true){
		
            //업로드 성공
            
		}else{
			 echo "<script>alert('파일 업로드에 실패하였습니다.'); location.href=('product_form.php');</script>";
		}
	}	
		
	else {
	     echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.'); location.href=('product_form.php');</script>";
		
	}	

} else {
	echo "<script>alert('이미지 파일이 아닙니다.'); location.href=('product_form.php');</script>";
	
       }
}
 // ********************product_poster*****************************************

 // ********************product_poster2*****************************************
if($_FILES['product_poster2']['type'] == NUll) {

	$product_poster2 = "";
	
} else {

$tempFile = $_FILES['product_poster2']['tmp_name'];
$fileTypeExt = explode("/", $_FILES['product_poster2']['type']);
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
		
		$product_poster2 = "./upload/{$_FILES['product_poster2']['name']}";
		$imageUpload = move_uploaded_file($tempFile, $product_poster2);
		
		if($imageUpload == true){
		
            //업로드 성공
            
		}else{
			 echo "<script>alert('파일 업로드에 실패하였습니다.'); location.href=('product_form.php');</script>";
		}
	}	
		
	else {
	     echo "<script>alert('파일 확장자는 jpg, bmp, gif, png 이어야 합니다.'); location.href=('product_form.php');</script>";
		
	}	

} else {
	echo "<script>alert('이미지 파일이 아닙니다.'); location.href=('product_form.php');</script>";
	
       }
}

/* 현재시간 */
$curTime = date("Y-m-d H:i:s");
			
$db->exec("INSERT INTO store_product (store_info_num, store_product_name, store_product_origin, store_product_price, 
			store_product_notice, store_product_img, store_product_delivery, store_product_fee, store_product_sale, 
			store_product_regdate, store_product_poster,store_product_poster2)
			VALUES ({$num}, '{$product_name}', '{$product_origin}', $product_price, '{$product_notice}', '{$resFile}', 
			$product_delivery, $product_fee, $product_sale,'221211051330', '{$product_poster}', '{$product_poster2}');");


// 상품번호 받아서 돌아가기
//echo "<script>alert('상품이 등록되었습니다'); location.href=('product_form.php?num=$rwriter ');</script>";
echo "<script>alert('상품이 등록되었습니다'); location.href=('store_list.php');</script>";