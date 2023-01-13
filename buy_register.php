 <?php
 require("db_connect.php");
 
$p_num = $_REQUEST["num"];
$buyName = $_REQUEST["buyName"];
$buyPhone = $_REQUEST["buyPhone"];
$buyAddr = $_REQUEST["buyAddr"];
$price = $_REQUEST["price"];
$buyPlz = $_REQUEST["buyPlz"];

session_start();
if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
    $U_ID  = $_SESSION["userId"];
    $user_name = $_SESSION ["userName"];
	
	 $query = $db->query("select mem_info_num from mem_info where mem_info_nickname = '$user_name'");
 $row = $query->fetch();

// 작성자 제목 내용 시간 썸네일 조회수\
 $m_num = $row['mem_info_num'];
} 

 
 $curTime = date("Y-m-d H:i:s");

/* review 테이블에 받아온 값 저장 */
// 상품번호, 회원번호, 주소, 폰번, 가격, 요청사항, 개수, 등록일
$db->exec("insert into purchase_info(store_product_num, mem_info_num, purchase_info_addr, purchase_info_phone, purchase_info_price,purchase_info_plz,
purchase_info_date) values({$p_num}, {$m_num}, '{$buyAddr}','{$buyPhone}',{$price},'{$buyPlz}', '{$curTime}' )");


 echo "<script> alert('구매가 완료되었습니다.'); location.href=('store_view.php?num=$p_num ');</script>";
 
 ?>