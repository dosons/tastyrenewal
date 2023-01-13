 <?php
 require("db_connect.php");
 
 // 상품번호 받기
$p_num = $_REQUEST["num"];

session_start();
if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
    $U_ID  = $_SESSION["userId"];
    $user_name = $_SESSION ["userName"];
	
	 $query = $db->query("select mem_info_num from mem_info where mem_info_nickname = '$user_name'");
	 $row = $query->fetch();

	// 작성자 제목 내용 시간 썸네일 조회수\
	 $m_num = $row['mem_info_num'];
} 

 echo $m_num;
 echo $p_num;
 //$curTime = date("Y-m-d H:i:s");

/* review 테이블에 받아온 값 저장 */
// 상품번호, 회원번호, 개수 고정
$db->exec("INSERT INTO store_cart (store_product_num, mem_info_num, store_cart_count)
VALUES ({$p_num}, {$m_num}, 1);");

 echo "<script> alert('장바구니에 추가되었습니다.'); location.href=('store_view.php?num=$p_num ');</script>";
 
 ?>