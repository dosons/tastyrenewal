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
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	

	
	<link rel="stylesheet" type="text/css" href="https://script.gmarket.co.kr/pc/css/ko/common.css">
	<link rel="stylesheet" type="text/css" href="https://script.gmarket.co.kr/pc/css/common/kr/ui/desktop_layout.css">
	<link rel="stylesheet" type="text/css" href="https://script.gmarket.co.kr/pc/css/ko/myg.css">
	<link rel="stylesheet" type="text/css" href="https://script.gmarket.co.kr/pc/css/ko/myg_net.css">
	<link rel="stylesheet" type="text/css" href="https://script.gmarket.co.kr/pc/css/ko/myg_layer.css">
    <link rel="stylesheet" href="css/main.css">

	
	
    
    
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
    <link rel="stylesheet" type="text/css" href="css/g.css">
    <!--font-->
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="css/css.css">


<script>
  //<![CDATA[
  window.onload = function() {
    //[1] ?????? ????????? ?????? ???????????? ??????????????? ??????????????? ??????

    //?????????????????? ???????????? ?????? ?????? ????????? 9?????? <a>????????? ?????? ??????
    var list_zone = document.getElementById("inner_list");
    var list_a = list_zone.getElementsByTagName("a");

    //?????? ???????????? ?????? <a>??? ?????? ???????????? ???????????? ????????? ???????????? ???????????? ??????
    for(var i=0; i<list_a.length; i++) {
        list_a[i].onclick=function(){
            var ph=document.getElementById("photo").children[0];
            ph.src = this.href;
            return false; //<a>????????? ??????????????? ????????? ?????? ????????? ???.
        }
    }

    //[2] ??????, ?????? ????????? ?????? ???????????? <ul>??? 100px?????? ?????? ?????? ????????????
    //    ???,???????????? ??????

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
<div class="wrap">
       <!--header-->
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
                <li class="test"><a href="logout.php"><p>????????????</p></a></li>
			    <li class="test"><p style="Color:#4e4e4e;"><?=$user_name?>???</p></li>
<?php
            } else {
?>
        <script>
                alert('????????? ??? ?????? ?????? ??? ????????????.');
                window.close();
	 
	            location.href='login_screen.php';
        </script>
<?php
               
            }
           


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
				  <li><a href="index.php?#about">??????</a></li>
                  <li><a href="recipe_write.php">?????????</a></li>
                  <li><a href="store_list.php">?????????</a></li>
                  <li><a href="#">????????????</a></li>
                  <li><a href="event.php">?????????</a></li>
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
				  <li><a href="myStore.php">??? ?????????</a></li>
				 <?php
				}
					?>
				  
              </ul>
          </nav> 
       </header>
<body class="service__mypage page__main"><div id="skip-navigation">
    </div>
    <div id="wrap" class="mygwrap">



       <section class="western"> <h2 class="tit" style="margin-top: 150px;"></h2>









            <div id="contentswrap">
                <div id="contents">
                   

                    <div id="main_cont">
                        <!-- S: BODY :12.12.17 -->
    
	<!-- ???????????? ?????? -->
    
	<div id="top_tit">
    <h4>
			<p class="rec_order_list">??????????????????</p>
            
		</h4>
  </div>
		


  
	<!-- ???????????? -->
	<div id="search_filter" style="display:none;">
<form action="/SearchForm" method="post">
		<input name="__RequestVerificationToken" type="hidden" value="KQFKBD-a3re1yun5Rg391u48M93G0iABISZV_hrpPFUDnG2FCwOoEaYy_uwfaEmVk1BXhVmcckfHv-EelhJL1ZjjxP66zI_sfjBMqsqKJgmZeOIxk1CZtmUnMZb-2WVXPPuU9fggwE1zS7L0gadtWOhoZJWwMIrggOqudqkdmI01">
		<input data-val="true" data-val-number="page ????????? ???????????? ?????????." data-val-required="page ????????? ???????????????." id="page" name="page" type="hidden" value="1">
		<input data-val="true" data-val-number="pageSize ????????? ???????????? ?????????." data-val-required="pageSize ????????? ???????????????." id="pageSize" name="pageSize" type="hidden" value="5">
		<input data-val="true" data-val-number="totalCount ????????? ???????????? ?????????." data-val-required="totalCount ????????? ???????????????." id="totalCount" name="totalCount" type="hidden" value="1">

		<input id="isReservation" name="isReservation" type="hidden" value="N">
		<input id="isFlight" name="isFlight" type="hidden" value="Y">
		<input id="isEbayShopping" name="isEbayShopping" type="hidden" value="N">
		<input id="isUsedCar" name="isUsedCar" type="hidden" value="N">

		<!-- ?????????????????? ?????? -->
		<input id="element" name="element" type="hidden" value="">
		<input id="elementIdx" name="elementIdx" type="hidden" value="">
		<input id="elementType" name="elementType" type="hidden" value="">
		<input id="columnCnt" name="columnCnt" type="hidden" value="">
		<input id="CurrentOrderNo" name="CurrentOrderNo" type="hidden" value="">
		<!-- ?????? ????????? -->
		<input id="waitQyt" name="waitQyt" type="hidden" value="1">

		<!-- ?????? ??????????????? ?????? ????????? -->
		<input id="additionalFeeQyt" name="additionalFeeQyt" type="hidden" value="0">
			
		


</form>
	</div>

					
	<!-- ?????? ???????????? -->
<form action="/" data-ajax="true" data-ajax-mode="replace" data-ajax-update="#orderList" data-ajax-url="/ContractList/GeneralContractList" id="form0" method="post">    <div class="b_ta_info">
        <table width="100%" border="1" class="b_table_grey">
            <colgroup>
				<col width="108" class="date">
				<col class="pinfo">
				<col width="127;" class="status">
				<col width="108;" class="confirm">
            </colgroup>
            <thead>
				<tr class="head">
					<th>??????</th>
					<th>????????????</th>
				</tr>
            </thead>
			<tfoot>
				<tr>
					<td class="last" colspan="2"></td>
				</tr>
			</tfoot>
            <tbody id="orderList">
			<?php
			
				require("db_connect.php");

				// ????????????, ?????????, ????????????, ?????????, ???????
				$query = $db->query("SELECT purchase_info_num, purchase_info_date, purchase_info_addr, purchase_info_phone,
									purchase_info_price, purchase_info_plz,
										(SELECT store_product_name
										FROM store_product AS b
										WHERE a.store_product_num = b.store_product_num) AS store_product_name,
										(SELECT 
											(SELECT store_info_name
											FROM store_info AS d
											WHERE b.store_info_num = d.store_info_num) AS store_info_name
										FROM store_product AS b
										WHERE a.store_product_num = b.store_product_num) AS store_info_name,
										(SELECT store_product_img
										FROM store_product AS b
										WHERE a.store_product_num = b.store_product_num) AS store_product_img
									FROM purchase_info AS a
									INNER JOIN mem_info AS c
									ON a.mem_info_num = c.mem_info_num
									WHERE c.mem_info_num = $m_num;");
				$row = $query->fetch();

				while($row = $query->fetch()){ 
					$purchase_num = $row['purchase_info_num'];
					$purchase_date = $row['purchase_info_date'];
					$purchase_addr = $row['purchase_info_addr'];
					$purchase_phone = $row['purchase_info_phone'];
					$purchase_price = $row['purchase_info_price'];
					$purchase_plz = $row['purchase_info_plz'];
					$product_name = $row['store_product_name'];
					$product_img = $row['store_product_img'];
					$store_name = $row['store_info_name'];
			?>
			<tr cno="3866438170" ctype="G" column="4" class="first">
		        <td class="first_cell" rowspan="1">
				<!--????????????-->
			        <div class="td_detail"><?= $purchase_date?></div>
		        </td>
				<td>
					<div class="td_info"><p><a href="javascript:fnGoVipPage('628809631')">
					<!--???????????????-->
					<img src="<?= $product_img?>" class="thumb" onerror="ImgLoadFirst(this);" alt=""></a></p><ul><li class="seller_info"><em></em>
					<!--????????????-->
					<a href=""><?= $store_name?></a></li><li class="tit_info">
					<!--?????????-->
					<a href="javascript:fnGoVipPage('628809631')"><?= $product_name?></a></li>
					<!--????????????-->
					<li class="cart">???????????? : <?= $purchase_num?></li><li class="price">
					<!--??????-->
					<strong><?= $purchase_price?></strong>???</li></ul></div>
				</td>
			</tr>
<?php

}

?>

            </tbody>
        </table>

    </div>
</form>
	    

    <input id="MemberControlCode" name="MemberControlCode" type="hidden" value="">
    <input id="CultureMoney" name="CultureMoney" type="hidden" value="">
    <input id="pay_self_auth_yn" name="pay_self_auth_yn" type="hidden" value="">
	<input id="hCacheYN" name="hCacheYN" type="hidden" value="Y">

                        <!--// E: BODY :12.12.17 -->
                    </div>

                </div>
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
               <li>????????? ooo | ?????? ?????? ???????????? 110</li>
               <li>?????????????????????:123-12-12345 | ?????????:abc@naver.com</li>
               <li><span class="copyright">COPYRIGHT 2022</span></li>  
           </ul>

    </section>










     <!-- // header -->
        <div id="contents" class="recipe">
            










     <!-- // header -->
        <div id="contents" class="recipe">
            
    <!-- Section ??????-->

<?php 



?>
        
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