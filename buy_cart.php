<?php
require("db_connect.php");

$m_num = $_REQUEST["num"];

session_start();
if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
    $U_ID  = $_SESSION["userId"];
    $user_name = $_SESSION ["userName"];

} 
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="ie=edge"><meta name="keywords" content="##keywords, HTML, CSS, XML, XHTML, JavaScript"><meta name="description" content="##description, The MDN Learning Area aims to provide."><meta property="og:type" content="##content"><meta property="og:title" content="##content"><meta property="og:description" content="##content"><meta property="og:image" content="##content"><meta property="og:url" content="##content"><meta property="al:ios:url" content="##content"><meta property="al:ios:app_store_id" content="##content"><meta property="al:ios:app_name" content="##content"><meta property="al:android:url" content="##content"><meta property="al:android:app_name" content="##content"><meta property="al:android:package" content="##content"><meta property="al:web:url" content="##content"><meta name="twitter:title" content="##content"><meta name="twitter:description" content="##content"><meta name="twitter:image" content="##content"><meta name="twitter:card" content="##content"><meta http-equiv="x-dns-prefetch-control" content="on"><link rel="dns-prefetch" href="//pics.gmarket.co.kr"><link rel="dns-prefetch" href="//script.gmarket.co.kr"><link rel="dns-prefetch" href="//image.gmarket.co.kr"><link rel="shortcut icon" href="//image.gmkt.kr/favicon/gmarket.ico"><link rel="stylesheet" href="//script.gmarket.co.kr/pc/css/ko/common.css"><link rel="stylesheet" href="//script.gmarket.co.kr/pc/css/common/kr/ui/common.css"><link rel="stylesheet" href="//script.gmarket.co.kr/pc/css/common/kr/ui/desktop_layout.css"><link rel="stylesheet" href="//script.gmarket.co.kr/pc/css/application/kr/cart/app.css">
    
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />

    <link rel="stylesheet" type="text/css" href="css/normalize.min.css" />
    <link rel="stylesheet" type="text/css" href="css/swiper.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">

    
    <link rel="stylesheet" href="css/buy_cart.css">


    <script src="js/jquery-3.3.2.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/swiper.min.js"></script>
    <script src="js/utils.js"></script>



    <title>Tasty-recipe</title>
    <!-- // config -->


    <link rel="stylesheet" type="text/css" href="css/sub.css" />

<script>
  //<![CDATA[
  window.onload = function() {
    //[1] 포토 목록에 작은 이미지를 클릭했을때 큰이미지로 변경

    //클릭이벤트를 등록하기 위해 포토 목록에 9개의 <a>요소를 모두 선택
    var list_zone = document.getElementById("inner_list");
    var list_a = list_zone.getElementsByTagName("a");

    //포토 리스트의 모든 <a>에 클릭 이벤트를 등록하기 위해서 반복문을 이용하여 등록
    for(var i=0; i<list_a.length; i++) {
        list_a[i].onclick=function(){
            var ph=document.getElementById("photo").children[0];
            ph.src = this.href;
            return false; //<a>요소를 클릭했을때 링크가 되지 않도록 함.
        }
    }

    //[2] 이전, 다음 버튼을 클릭 할때마다 <ul>이 100px만큼 증가 또는 감소되어
    //    좌,우측으로 이동

    var n_btn = document.getElementById("btn_next");
    var m_num = 0;
    n_btn.onclick = function() {
        if(m_num>=list_a.length-3) return false;
        m_num++;
        list_zone.style.marginLeft=-100*m_num+"px";
        
        return false;
    }

    var b_btn = document.getElementById("btn_before");
    b_btn.onclick=function() {
        if(m_num<=0) return false;
        m_num--;
        list_zone.style.marginLeft = -100*m_num+"px";
    }

  }
    
  //]]>
</script>
 

</head>

<body class="service__cart"><div id="skip-navigation"><strong class="for-a11y">스킵 네비게이션</strong><ul><li><a href="#skip-navigation-search">검색창 바로가기</a></li><li><a href="#skip-navigation-category-all">전체카테고리 바로가기</a></li><li><a href="#skip-navigation-container">본문 바로가기</a></li></ul></div><div id="wrapper">

	  <header>
		<div class="top">
		<div class="wrapper">
		<ul class="top-menu">
<?php
            session_start();
            if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
               $user_id = $_SESSION["userId"];
               $user_name = $_SESSION ["userName"];
?>
                <li class="test"><a href="logout.php"><p>로그아웃</p></a></li>
			    <li class="test"><p style="Color:#4e4e4e;"><?=$user_name?>님</p></li>
<?php					
            
			} else {
?>
        <script>
                alert('로그인 후 이용 하실 수 있습니다.');
                window.close();
	 
	            location.href='login_screen.php';
        </script>
<?php
               
            }
           

require("db_connect.php");
$query = $db->query("select * from mem_info where mem_info_id='{$user_id}'");
$row = $query->fetch();
$email = $row["mem_info_email"];
$nickname = $row["mem_info_nickname"];
$m_num =  $row["mem_info_num"];
?>           
			
	    </ul>
		</div>
	    </div>
          <span class ="bg"></span>
          <a href="#" class="open"><span class="lnr lnr-menu"></span></a>
          <a href="index.php" class="logo"><img src="img/logo1.png" style="width: 100%;"></a>
          <nav>
             <a href="#" class="close"><span class="lnr lnr-cross"></span></a>
              <ul class="gnb" style="font-weight: 800;">
				  <li><a href="index.php?#about">소개</a></li>
                  <li><a href="recipe_write.php">레시피</a></li>
				  <li><a href="store_list.php">스토어</a></li>
                  <li><a href="free.php">커뮤니티</a></li>
                  <li><a href="event.php">이벤트</a></li>
				  <li><a href="my.php">MY</a></li>
				  
				  <?php
			$query = $db->query("SELECT store_info_num
								FROM store_info AS a
									INNER JOIN mem_info AS b
									ON a.mem_info_num = b.mem_info_num
								WHERE b.mem_info_nickname = '$user_name';");
			$row = $query->fetch();
			$num = $row["store_info_num"];
			if(isset($num)) {
				  ?>
				  <li><a href="myStore.php">내 스토어</a></li>
				 <?php
				}
					?>
				 
				  
              </ul>
          </nav> 
       </header>


       <section class="western"> <h2 class="tit" style="margin-top: 150px;"></h2>


<div id="container">
	<div id="wrap" class="wrap box__all">
		<div id="content" class="cart__wrap">
			<div id="cart_header">
				<div class="cart_header_wrapper">
					<div class="cart_header">
						<div class="inner_cont"><h3 class="title">찜목록</h3></div>
					</div>
				</div>
			</div>
				

			<div id="cart_body">
				<div class="inner_cont">
				
				<?php
				
				$query = $db->query("SELECT b.store_product_num, b.store_product_name, b.store_product_price, b.store_product_num,
									SUBSTRING_INDEX(b.store_product_price - (b.store_product_price * (b.store_product_sale/100))+b.store_product_fee,'.',1) AS total_price,
									SUBSTRING_INDEX(b.store_product_price * (b.store_product_sale/100),'.',1) AS sale_price, b.store_product_fee,b.store_product_delivery,
									a.store_cart_count, c.mem_info_nickname, (store_product_price * store_cart_count) AS result_price, b.store_product_img,
									(SELECT  store_info_name
									FROM store_info AS d
									WHERE b.store_info_num = d.store_info_num) AS store_info_name,
									(SELECT  store_info_num
									FROM store_info AS d
									WHERE b.store_info_num = d.store_info_num) AS store_info_num
								FROM store_cart AS a
								INNER JOIN store_product AS b
								ON a.store_product_num = b.store_product_num
								INNER JOIN mem_info AS c
								ON a.mem_info_num = c.mem_info_num
								WHERE c.mem_info_num = $m_num;");

				$row = $query->fetch();

				while($row = $query->fetch()){ 
					$store_product_num = $row['store_product_num'];
					$store_product_name = $row['store_product_name'];
					$store_product_img = $row['store_product_img'];
					$store_product_price = $row['store_product_price'];
					$total_price = $row['total_price'];
					$sale_price = $row['sale_price'];
					$store_product_fee = $row['store_product_fee'];
					$store_product_delivery = $row['store_product_delivery'];
					$store_cart_count = $row['store_cart_count'];
					$result_price = $row['result_price'];
					$store_info_name = $row['store_info_name'];
					$store_info_num = $row['store_info_num'];
			?>
					<div id="cart_list" style="padding-left:240px;"><h3 class="for_a11y"></h3><ol class="basket_list_group"><li class="cart--basket type_minishop">
						<div class="cart--basket_header ">
						<!--스토어명, 링크보류-->
						<a class="link_area" href="store_info.php?num=<?= $store_info_num?>" data-montelena-acode="{getAreaCode(sellerGroup)}"><strong class="shop_name"><?= $store_info_name?></strong>
						</div>
					<div class="cart--basket_body">
						<div class="shipping--no--group">
							<ul class="order--list">
								<li class="order--idx"><div class="item">
									<div class="item_img"><a href="store_view.php?num=<?=$store_product_num?>" data-montelena-acode="200002852" data-montelena-goodscode="628809631">
					
					
					<img src="<?= $store_product_img?>" alt="상품이미지"></a></div>
					
						<div class="item_info">
						<dl class="unit--item case_nooption first"><dt><strong class="for_a11y">구매할 상품 상세 정보</strong></dt>
						<dd class="unit--item_desc" id="xo_cart_unit_1730342614">
						<!--상품명-->
						<div class="section item_title"><a href="store_view.php?num=<?=$store_product_num?>" data-montelena-acode="200002853" data-montelena-goodscode="628809631">
							<strong class="for_a11y">상품명: 	</strong><span class="item_name"><?= $store_product_name?></span></a>
							<span class="box__delivery-info">
							<!--베송기간-->
							<span class="text__delivery-make">예상 배송기간 : <?= $store_product_delivery?>일</span></span>
						</div>

						<div class="section item_price"><b class="for_a11y">상품 금액 : </b>
							<span class="format-price"><span class="box__format-amount"><strong class="text__value"><?= $store_product_price?></strong><span class="text__unit">원</span></span></span>
							<span class="price_desc "></span></div>

							</dd>
							</dl>
						</div></div></li></ul></div>
					</div>
					
					
					<div class="cart--basket_footer"><span class="for_a11y">감귤나라.에서 담은 장바구니 상품 소계</span>
						<div class="cart--basket--total">
						<!--상품금액-->
							<div class="sub_sec"><span class="label">상품금액</span><span class="format-price">
								<span class="box__format-amount"><strong class="text__value"><?= $store_product_price?></strong><span class="text__unit">원</span></span></span></div><div class="math"><i class="icon sprite__cart img_minus">
								<span class="for_a11y">빼기</span></i></div>
								<!--할인금액-->
								<div class="sub_sec discount"><span class="label">할인금액</span><span class="format-price">
								<span class="box__format-amount"><strong class="text__value"><?= $sale_price?></strong><span class="text__unit">원</span></span></span></div><div class="math"><i class="icon sprite__cart img_plus"><span class="for_a11y">더하기</span></i></div>
								<!--배송비-->
								<div class="sub_sec delivery"><span class="label">배송비</span><strong class="price free"><?= $store_product_fee?>원</strong>
								</div>
								<!--토탈금액-->
								<div class="math"><i class="icon sprite__cart img_result"><span class="for_a11y">계산값은</span></i></div><div class="sub_total"><span class="label">주문금액</span><span class="format-price"><span class="box__format-amount"><strong class="text__value"><?= $total_price?></strong><span class="text__unit">원</span></span></span></div></div>
								
					</div></li></ol>
					<div class="fake_cursorpoint"></div>


					</div>
				<?php
					
				}

			?>				

					
					</div></div></div></div>
</div>


<!--footer-->
<footer>
           <ul class="sns">
               <li><img src="img/instagram.png" alt=""></li>
               <li><img src="img/facebook.png" alt=""></li>
               <li><img src="img/youtube.png" alt=""></li>
               <li><img src="img/blog.png" alt=""></li>
           </ul>
		   <br><br>
		   
           <ul>
               <li>대표자 ooo | 서울 중구 세종대로 110</li>
               <li>사업자등록번호:123-12-12345 | 이메일:abc@naver.com</li>
               <li><span class="copyright">COPYRIGHT 2022</span></li>  
           </ul>

    </section>










     <!-- // header -->
        <div id="contents" class="recipe">
            










     <!-- // header -->
        <div id="contents" class="recipe">
            
    <!-- Section 본문-->

        
<!--backend-->
<?php
            
            $convention = isset($_REQUEST["convention"]) ? $_REQUEST["convention"] : "material";
            $material = "white";
            $material_w = "black";

            $make= "white";
            $make_w= "black";
            if ($convention == "material") {
                $material = "#FF9D2D";
                $material_w = "white";
            } else if ($convention == "make") {
                $make = "#FF9D2D";
                $make_w = "white";
            }
                   
?>

<?php
        if($convention == "material") {

?>



<hr />





        <!--Section-->


    </div>
</main>

<?php
            }
            
 ?>


    
       
</body>

</html>

<style>
    </style>