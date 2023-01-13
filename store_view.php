<?php
require("db_connect.php");
?>

<!DOCTYPE html>
<html lang="ko">
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0, maximum-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

   
    <link rel="stylesheet" type="text/css" href="css/h.css">
    <!--font-->
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="css/css.css">

    <!--script-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/scrolla.jquery.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/com.js"></script>

    <!-- config // -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
   
    
    <meta property="og:type" content="website">
    <meta property="og:title" content="ServeQ Recipe - 페퍼로니피자 토스트">
    <meta property="og:image" content="https://www.serveq.co.kr/upload/recipe/P20211102163226884_859.png"> <!--SNS 이미지-->
    <meta property="og:url" content="http://www.serveq.co.kr/recipe/WST/recipe_view?R_IDX=1374&amp;PAGESIZE=12&amp;SORTCOL=&amp;SORTDIR=&amp;SEL_R_CATE_CODE=&amp;SEARCH_COL=&amp;SEARCH_KEYWORD=">

   
    <link rel="shortcut icon" type="image/x-icon" href="/pjtCom/images/common/favicon.ico">

    <link rel="stylesheet" type="text/css" href="css/normalize.min.css" />
    <link rel="stylesheet" type="text/css" href="css/swiper.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="css/common.css" />

    <link rel="stylesheet" href="css/recipe_view.css">


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
<body class="sub">
    <!-- header // -->

<noscript>
   
    <a href="https://www.enable-javascript.com/ko/" target="_blank"></a>
</noscript>


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
                <li class="test"><a href="logout.php"><p>로그아웃</p></a></li>
			    <li class="test"><p style="Color:#4e4e4e;"><?=$user_name?>님</p></li>
<?php
            } else {
?>
                <li class="test"><a href="join_screen.php"><p>회원가입</p></a></li>
			    <li class="test"><a href="login_screen.php"><p>로그인</p></a></li>
<?php
            }
           
 ?>            
			
			
	    </ul>
		</div>
	    </div>
          <span class ="bg"></span>
          <a href="#" class="open"><span class="lnr lnr-menu"></span></a>
          <a href="index.php" class="logo"><img src="img/logo1.png" style="width: 100%; padding-top:14px"></a>
          <nav>
             <a href="#" class="close"><span class="lnr lnr-cross"></span></a>
              <ul class="gnb">
				  <li><a href="#about">소개</a></li>
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
				  <li><a href="myStore.php?num=<?= $num?>">내 스토어</a></li>
				 <?php
				}
					?>
				  
              </ul>
          </nav> 
       </header>

<hr />


     <!-- // header -->
        <div id="contents" class="recipe">

    <!-- Section 본문-->

    <section class="western">
    <h2 class="tit" style="margin-top: 100px;">스토어</h2><br><br>
        
        
        

<?php 
// 파라메타로 받은 상품번호
$p_num = $_REQUEST["num"];

// 스토어 상세보기
// 스토어 이름, 상품명, 원산지, 가격, 할인적용가격, 설명, 이미지포스터, 배송기간, 배송비, 할인율, 등록일
$query = $db->query("SELECT 
						(SELECT store_info_name
						FROM		store_info AS b
						WHERE a.store_info_num = b.store_info_num) AS store_info_name, store_product_name, store_product_origin,  store_info_num,
						store_product_price, SUBSTRING_INDEX(store_product_price - (store_product_price * (store_product_sale/100)),'.',1) AS total_price,
						store_product_notice, store_product_img, store_product_delivery, store_product_fee, store_product_sale, store_product_regdate, store_product_poster,store_product_poster2
					FROM store_product AS a
					WHERE store_product_num = $p_num;");
$row = $query->fetch();

// 스토어 이름, 상품명, 원산지, 가격, 할인적용가격, 설명, 이미지포스터, 배송기간, 배송비, 할인율, 등록일
$store_name = $row['store_info_name'];
$product_name = $row['store_product_name'];
$product_origin = $row['store_product_origin'];
$product_price = $row['store_product_price'];
$product_total = $row['total_price'];
$product_notice = $row['store_product_notice'];
$product_img = $row['store_product_img'];
$product_delivery = $row['store_product_delivery'];
$product_fee = $row['store_product_fee'];
$product_sale = $row['store_product_sale'];
$regdate = $row['store_product_regdate'];
$product_poster = $row['store_product_poster'];
$product_poster2 = $row['store_product_poster2'];
$store_info_num = $row['store_info_num'];

$query = $db->query("SELECT *,
						(SELECT mem_info_nickname
						FROM mem_info AS b
						WHERE b.mem_info_num = a.mem_info_num) AS mem_info_nickname
					FROM store_product AS c
					INNER JOIN store_info AS a
					ON a.store_info_num = c.store_info_num
					WHERE c.store_product_num = '{$p_num}'");
$row = $query->fetch();
$r_writer = $row['mem_info_nickname'];

?>

<div id = "na" style="text-align: right; margin-left: 800px; margin-top: 50px; display:inline-block;" >
            <h9>등록일:&nbsp;&nbsp;<?=$regdate?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h9>
        </div>
        
        
<!--backend-->


<div class="contain" style="height: auto !important;">
	
	<div class="rec_view_top clr" style="width:1120px; height: auto !important;"> 
		<div class="fl rec_view_img" style="height: auto !important;">
			<img style= "width:400px; height:400px;"src="<?= $product_img?>" alt="">

		</div>
		<div class="fr rec_info" style="height: auto; border-left:1px; "  >
			<div class="icon_box clr">
				<div class="fl">
					<ul class="clr">
						
					</ul>
				</div>
				
			</div>
			<div class="rec_exp">
				<h2 class="prod_title"><?= $product_name?></h2>
				<a href="store_info.php?num=<?= $store_info_num?>"><p class="s_title"><?= $store_name?></p></a>

                <div class="price" style="margin-top: 30px; margin-bottom:10px;"><s style="font-size:17px;"><?= $product_price?></s></div>
					<div class="flex"><div class="priceInfo">
						<span class="discountValue" style="font-size:25px; line-height: 28px; margin-right:8px; color: rgb(246,111,88); font-family:Arial ;"><?= $product_sale?>%</span>
						<span class="salesPrice" style="font-size:25px; line-height: 28px; margin-right:8px; font-family:Arial;"><?= $product_total?>원</span>
					</div>
				</div>
                
				<div class="text_box"><?= $product_notice?>	</div>
			</div>
			
			<div class="rec_mate">
            <div class="style__Component-tdm8v5-0 hTLXDP ProductOptions">
				<ul class="style__SelectedOptionList-tdm8v5-2 dorbzQ">
					<li class= "style__SelectedOption-tdm8v5-3 ixsQCD">
						<div class="style__Counter-tdm8v5-4 dgWIdy">
							<div class="Counter__Component-sc-1c40ccr-0 iLXQth"></p></div>
					</li>
				</ul>
							<div class="style__CheckoutButton-tdm8v5-5 jBxVFd">
								<p class="price"></p>
									<div class="buttons">
										<button class="addToCart" onclick="location.href='cart_register.php?num=<?= $p_num?>'">찜 추가</button>
										<button class="checkout" onclick="location.href='buy.php?num=<?= $p_num?>'">바로구매</button>
									</div>
							</div>
						</div>
								
                
			</div></iframe></div></ins><div class="jori" style="width:500px;">
    
     <div class="prod_title" style="width:500px; height:580px;"> </div>
     <div class="slide_anchor">
            <ul class="xans-element- xans-product xans-product-detail ">
<li class="on"><a href="#a">상품설명</a></li> 
<li><a href="#b">상세/배송정보</a></li>
<li><a href="#c">상품후기 </a></li>
</ul>
</div>
     </div> </div>
		</div>
	</div>
    <a name="a">
	<!-- 광고위치 START
	<div class="def_location clr">
..
	</div>
	 광고위치 2 END -->
    
	<div class="rec_content"> 
		<ul class="section">
			<li>
				<div class="con_box img_s" style="width:1000px; height:100%; text-align: center;"><!--- 이미지 두개일 경우 img_d --->
					<div class="img_box clr" style="text-align: center;">
                    <img style= "width:100%; height:100%; text-align: center;"src="<?= $product_poster?>" alt="">
																	</div>
					
				</div>
							
								
			
							</li>

                            
		</ul>
        <a name="b">
        <ul class="section">
			<li>
							<div class="con_box img_s" style="width:1000px; height:100%; text-align: center;"><!--- 이미지 두개일 경우 img_d --->
					<div class="img_box clr" style="text-align: center;">

                    <img style= "width:100%; height:100%; text-align: center;"src="<?= $product_poster2?>" alt="">
																	</div>
					
				</div>
							
								
			
							</li>

                            
		</ul>
        <a name="c">

        <ul class="section" style = "margin : 0 auto; text-alignl:left">
			<li> 
        



            <div class="board_wrap">
       
        <div class="board_view_wrap">
            <div class="board_view">
                
                
                <div class="cont">
                
                    <b style="font-size: 15px;">상품후기</b><br>
                </div>
               
            </div>

        <!-- 댓글 폼-->
       
     <div id= "reply_wrap">

			<!-- back end-->


			<?php
			// 1. 상품번호로 댓글조회
			 $query = $db->query("select * from store_review where store_product_num = $p_num");

			 while($row = $query->fetch()) {
			   //컬럼들 닉네임 $user_name . 내용, 시간 
			   $review_content = $row["store_review_content"];
			   $m_num = $row["mem_info_num"];	//DB속 회원번호
			   //$review_regdate = $row["store_review_regdate"];

			?>

			<div>
					<br>
				   <h1 style="font-size:13px;"><b><?=$user_name?></b>&nbsp;<na style="font-size:11px; Color:gray;"><?=substr($row['store_review_regdate'],0,16)?></na></h1>
				   <br>
				   <?=nl2br($review_content)?><br><br>
			<?php

			if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
					   
					  if($user_num == $m_num) {
						$query3 = $db->query("select * from store_review where store_product_num = $p_num and store_review_content = '{$review_content}' ");
						$row = $query3->fetch()
			?>
				   <a href="review_delete.php?num=<?=$row['store_review_num']?>">삭제</a>
			<?php

					  }
			}
			?>
				   <br> <br>
				   <hr  style="border: solid 0.1px; Color:#e4e4e4; width: 100%; margin-left: auto;margin-right: auto;">
				</div>

			<?php
			 }

?>

    </div>
    </div>


<form action="review_register.php?num=<?=$p_num?>" method="POST">
            <div id="comment_box">
                <img id="title_comment">
            <textarea style="resize:none;" name="review"></textarea>
            <div id="ok_ripple"><input type="submit" style="display:block;padding:30px 22px;border:1px solid rgba(0,0,0,0.3);font-size:14px;color:#333; background-Color:white;" value="등록"></div>
            </div>
</form>

   </div>

		</li>
		</ul>

	</div>


		<div class="rec_foot_banner">
		
	</div>



	
		</div>
		<a href="javascript:void(0);" id="cMore" class="det_more" style="display: none;"><img src="/skin/nodskin_argio/images/btn_more.jpg" alt=""></a>

	</div>


</div>





<?php
           // userName = nickname임
           if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
            $user_nickname= $_SESSION["userName"];
            // 세션의 닉네임과 DB의 닉네임을 비교하여서 DB ROW를 받고, 글쓴이가 맞다면 수정
            $query = $db->query("select * from mem_info where mem_info_nickname = '{$user_nickname}' ");
            $row = $query->fetch();
            $check_name = $row['mem_info_nickname'];

            if($check_name == $r_writer) {
?>
            <div class="function_area">
                <a href="product_update.php?num=<?=$p_num?>"><input type=button style="width:40pt;height:25pt;" value="수정">&nbsp;&nbsp;
                <a href="product_delete.php?num=<?=$p_num?>"><input type=button style="width:40pt;height:25pt; " value="삭제" ></a> 
            </div>

<?php   
                }
 }
                
?>



           


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
       </footer>
</body>

</html>

<style>
    @import url(//fonts.googleapis.com/earlyaccess/notosanskr.css);

/************************* 20170410 이밥차 *************************/
/* 바디 배경 */
*{margin:0;padding:0;font-family: 'Noto Sans KR', sans-serif;}
html {width:100%; height:100%;}
body {width:100%; height:100%;  margin:0; padding:0;font-family: 'Noto Sans KR', sans-serif;overflow-y:scroll;}
img, fieldset {border:0;display:block;}
ul, ol, li, dl {list-style:none;}
a {color:inherit; cursor:pointer;}
a, a:link {color:#383838; text-decoration:none;}
a, input, select, textarea{outline:none;}

.clr{*zoom:1;}
.clr:after {content:""; display:block; clear:both;}
*, *:before, *:after {-webkit-box-sizing: border-box;-moz-box-sizing: border-box;-ms-box-sizing: border-box;-o-box-sizing: border-box;box-sizing: border-box;-webkit-font-smoothing: antialiased;letter-spacing:-1px}
.fl{float:left;}
.fr{float:right;}
.g_box{background-color:#f9f9f9}

#container  {*zoom:1; width:100%;min-width:1080px; position:relative; z-index:2;margin-top:-13px;min-height:100px;padding-bottom:75px;}
#container:after {content:""; display:block; clear:both;}

.contain{width:1080px;margin:0 auto;}
.def_title{font-size:22px;color:#383838;font-weight:400;line-height:20px;margin-bottom:15px;}
.def_title .s_text{display:inline-block;margin-left:6px;font-size:12px;color:#5e5e5e;font-weight:300;}
.def_title .fr{font-size:14px;color:#888;}
.def_title .fr img{display:inline-block;margin-left:5px;vertical-align:middle;margin-top:-3px;}

/**** header ****/
#header{position:relative;width:100%;min-width:1080px;height:110px;background:url(../images/header_bg.png) 0 0 repeat-x;z-index:99;}
#header .contain, .search_wrap .contain{position:relative;}
.h_logo{float:left;}
.h_navi{float:right;}
#header li{float:left;}
#header .h_logo{position:absolute;left:50%;margin-left:-50px;top:19px;}
#header .h_navi{margin-top:34px;margin-left:25px;}
#header .menu li{margin-left:42px;line-height:94px;}
#header .menu li:first-child{margin-left:0;}
#header .menu li a{font-size:16px;color:#5e5e5e;}
#header .menu li.on a{color:#fc7405;font-weight:500}
#header .gnb li{margin-left:25px;line-height:96px;font-size:11px;}
#header .gnb li a{display:block;color:#5e5e5e;letter-spacing:0;}
#header .gnb li img{margin-top:36px;}
#header .gnb li img.search_btn{margin-right:5px;}
#header .gnb li a.cart{position:relative;}
#header .gnb li a.cart .num{position:absolute;top:0;right:0;text-align:center;display:inline-block;width:29px;height:14px;line-height:14px;font-size:11px;color:#fff;}
.search_wrap{position:absolute;top:96px;background-color:#fff;z-index:98;;width:100%;min-width:1080px;padding:35px 0 32px;border-bottom:1px solid #eaeaea;display:none;}
.search_box{width:338px;height:34px;background-color:#f9efe7;margin:0 auto;margin-bottom:20px;}
.search_box input{float:left;width:302px;height:100%;border:none;background:none;padding-left:10px}
.search_box a{float:right}
.search_tag{text-align:center;height:27px;}
.search_tag *{display:inline-block;vertical-align:middle;}
.search_tag .tag_box{margin-left:7px;height:27px;line-height:20px;}
.search_tag .tag_box a{margin-right:2px;font-size:12px;color:#888;}
.search_wrap .search_close{position:absolute;top:5px;right:19px;}
.ui-widget.ui-widget-content li.ui-state-focus{background-color:#f4f4f4;border:0;}
.ui-menu .ui-state-focus, .ui-menu .ui-state-active{margin:0;}


.navi_wrap{position:absolute;top:96px;width:100%;z-index:100;display:none;}
.navi_wrap .contain{background-color:#fff;position:relative;}
.navi_wrap .w_bg{position:relative;padding:40px 0;box-shadow:0 0 20px rgba(25,25,25,0.14)}
.navi_wrap .navi_al{display:table;width:100%;}
.navi_wrap .navi_al th{font-size:18px;color:#383838;line-height:17px;background:url(../images/navi_line.jpg) 33px 37px no-repeat;padding:0 33px 46px;}
.navi_wrap .navi_al th img{display:inline-block;margin-right:5px;vertical-align:middle;margin-top:-5px;}
.navi_wrap .navi_al td{padding:0 33px;vertical-align:top;border-left:1px solid #ececec}
.navi_wrap .navi_al td:first-child{border-left:0;width:270px;}
.navi_wrap .navi_list{margin-top:-7px;;}
.navi_wrap .navi_list li a{font-size:13px;line-height:28px;color:#5e5e5e}
.navi_wrap .navi_list li a:hover{color:#fd7405;}
.navi_wrap .navi_close{position:absolute;top:0;right:-47px;}

/* footer */
#footer{position:relative;z-index:1;border-top:1px solid #ececec;padding-bottom:45px;min-width:1080px;}
.foot_menu{padding:29px 0;}
.foot_menu .foot_logo{float:left;}
.foot_menu .menu{display:inline-block;margin-top:20px;margin-left:39px;}
.foot_menu .menu li{float:left;margin-right:10px;line-height:13px;}
.foot_menu .menu li a{font-size:13px;color:#939393;}
.foot_menu .menu li span{display:inline-block;margin-left:10px;}

.foot_menu .fr{margin-top:15px;}
.foot_menu .fr li{float:left;margin-left:9px;}

.foot_info p{font-size:12px;line-height:18px;color:#ababab;}
.foot_info p a, .foot_info p a:hover{color:#ababab;}
.foot_info p.copy{font-family:'Arial';font-size:11px;}
.foot_info .fr p.text{float:right;text-align:right;margin-top:24px;margin-right:13px;}
.foot_info i{display:inline-block;margin-right:10px;}

#dfloorTop{display:none;position:fixed;right:16px;bottom:15px;margin-left:585px;z-index:100;cursor:pointer }

/******** recipe ********/
.recipe_contian{width:100%;min-width:1080px;}
.recipe_contian .no_list{text-align:center;padding:200px 0;color:#888}
/* tag */
.tag_wrap{margin-bottom:55px;}
.tag_wrap .title_area{padding-top:60px;}
.tag_wrap .title_area img{margin:0 auto;}

.tag_area{position:relative;background:url(../images/tag_top_border.jpg) top repeat-x;border-bottom:1px solid #efefef;padding-top:5px;}
/* .tag_area ul{display:none;} */
/* .tag_area.on ul{display:block;} */
.tag_area ul.dp_none{display:none;}
.tag_area li{float:left;width:99px;height:98px;margin-left:-1px;padding:17px 0 22px;border:1px solid #ededed;}
.tag_area li img{margin:0 auto;}
.tag_area li.first{width:100px;margin:0;}
.tag_area li.mtm1{margin-top:-1px;}
.tag_area li p{text-align:center;font-size:12px;color:#888;font-weight:400;line-height:12px;margin-top:10px;}
.tag_area li.on{position:relative;z-index:2;border:1px solid #fc7405}
.tag_area li.on p{color:#fc7405;}
.tag_btn{position:absolute;bottom:-25px;left:50%;margin-left:-72px;display:block;width:144px;height:25px;line-height:25px;background:url(../images/tag_btn_on.png) 0 0 no-repeat;text-align:center;color:#fff;}
.tag_btn.on{background:url(../images/tag_btn_off.png) 0 0 no-repeat;}

/* recipe list */
.title_area .select_wrap{position:relative;width:123px;height:25px;background:url(../images/select_arrow.jpg) 99px 55% no-repeat;border:1px solid #f3f3f3;}
.select_wrap p{width:100%;height:100%;line-height:25px;margin:0;text-indent:10px;cursor:pointer;font-size:12px;color:#888}
.select_wrap .select_list{display:none;position:absolute;width:123px; margin:0; top:24px;background-color:#fff; left:-1px; border-radius: 0 0 5px 5px;z-index: 100;border:1px solid #f3f3f3;}
.select_wrap .select_list li{width:100%;height:25px;line-height:25px; text-indent: 10px;cursor:pointer}
.select_wrap .select_list li a{font-size:12px;color:#888}


.rec_list li{float:left;width:208px;margin-left:10px;margin-bottom:12px;}
.rec_list li.ml_none{margin-left:0;}
.rec_list li a{display:block;}
.rec_list li .img_wrap{position:relative;width:100%;height:205px;overflow:hidden;}
.rec_list li .img_wrap img{position:absolute;bottom:0;}
.rec_list li .text_box{padding:5px; }
.rec_list li .s_title{font-size:12px;color:#888;line-height:21px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.rec_list li .b_title{font-size:14px;color:#383838;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}

/* recipe view */
.rec_view_top{border-bottom:1px solid #ececec;padding-bottom:20px;}
.rec_view_top .rec_view_img{width:490px;}
.rec_view_top .rec_view_img > img{width:100%;}
.rec_view_top .rec_view_img .like_btn{margin-top:20px}
.rec_view_top .rec_view_img .like_btn img{margin:0 auto;}
.rec_view_top .rec_info{width:555px;}

.rec_info .icon_box{border-bottom:2px solid #f6f6f6;padding:2px 0 17px;}
.rec_info .icon_box li{float:left;}
.rec_info .icon_box .fl li{margin-right:12px;height:20px;line-height:20px;font-size:13px;color:#888;}
.rec_info .icon_box .fl li img{display:inline-block;vertical-align:text-bottom;margin-right:5px;margin-bottom:3px}
.rec_info .icon_box .fl li:first-child img{margin-bottom:4px}
.rec_info .icon_box .fr li{margin-left:7px;}
.rec_info .rec_exp{padding:35px 0;border-bottom:1px solid #f6f6f6;}
.rec_exp .prod_title{font-size:30px;color:#383838;font-weight:500;margin-top:-8px}
.rec_exp .s_title{font-size:16px;color:#888;margin-top:9px;}
.rec_exp .text_box{font-size:12px;color:#888;line-height:20px;margin-top:50px;}
.rec_info .rec_mate{padding-top:37px;}
.rec_mate .mate_title{font-size:24px;color:#383838;font-weight:500; border-top:1px}
.rec_mate .mate_title .text_o{font-size:12px;color:#fd7405;}
.rec_mate .mate_title .text_o img{display:inline-block;margin-right:4px;margin-left:10px;}

.rec_mate .text_box{margin-top:20px;}
.rec_mate .text_box .s_title{font-size:16px;color:#5e5e5e;font-weight:500;line-height:16px;margin-bottom:6px}
.rec_mate .text_box .mate_list{font-size:12px;color:#888;line-height:20px;}
.rec_mate .tip{font-size:12px;color:#888;line-height:16px;margin-top:20px;}
.rec_mate .tip img{float:left;margin-right:3px;}
.rec_mate { font-family: 'Noto Sans KR', sans-serif;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
    margin: 0;
    padding: 0;
    color: #383838;
    font-size: 12px;
    letter-spacing: -1px;
    padding-top: 37px;
    display:block;
}
.rec_exp { font-family: 'Noto Sans KR', sans-serif;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
    margin: 0;
    color: #383838;
    font-size: 12px;
    letter-spacing: -1px;
    padding: 35px 0;
    border-bottom: 1px solid #f6f6f6;
}
.mate_title.clr { font-family: 'Noto Sans KR', sans-serif;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
    margin: 0;
    padding: 0;
    letter-spacing: -1px;
    font-size: 24px;
    color: #383838;
    font-weight: 500;
}
.text_box {  font-family: 'Noto Sans KR', sans-serif;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
    margin: 0;
    padding: 0;
    color: #383838;
    font-size: 12px;
    letter-spacing: -1px;
    margin-top: 20px;
}



.rec_content{padding-top:70px;padding-bottom:60px;border-bottom:1px solid #ececec}
.rec_content .section{display:table}
.rec_content .section > li{display:table-cell;vertical-align:top}
.rec_content .section > li:first-child{width:2400px;/*border-right:1px*/ solid #ececec}
.rec_content .img_d{width:708px;margin:0 auto;}
.rec_content .img_d .img_box img{float:left;width:50%;}
.rec_content .img_s{width:354px;margin:0 auto;}
.rec_content .img_s .img_box img{width:100%;}
.rec_content .con_box{margin-top:70px;}
.rec_content .con_box:first-child{margin-top:0;}
.rec_content .con_box .text_wrap{margin-top:18px;}
.rec_content .con_box .text_wrap .num{float:left;font-family:'Arial';font-size:30px;color:#fd7405;line-height:30px;}
.rec_content .con_box .text_wrap .text_box{margin-left:32px;}
.rec_content .con_box .text_exp{font-size:14px;color:#5e5e5e;font-weight:500;line-height:20px;}
.rec_content .con_box .tip{margin-top:10px;}
.rec_content .con_box .tip img{float:left;}
.rec_content .con_box .tip .tip_text{margin-left:58px;font-size:12px;color:#888;line-height:16px;}

.rec_content .sec_r{padding-left:35px;}
.rec_go_shop{position:relative;width:265px;margin-bottom:30px;}
.rec_go_shop .icon_cart{position:absolute;top:0;left:-1px;z-index:2}
.rec_go_shop p.clr img{float:right;margin-top:5px;}
.rec_go_shop a.img_box{display:block;width:100%;height:139px;position:relative;margin-top:8px;overflow:hidden;}
.rec_go_shop a.img_box img{position:absolute;width:100%;bottom:0;}
.rec_go_shop a.img_box .mark{position:absolute;width:100%;height:100%;background-color:rgba(0,0,0,0.6);}
.rec_go_shop a.img_box .title{position:absolute;top:65px;left:107px;font-size:18px;color:#fff;font-weight:500}

.rec_slide_wrap{position:relative;width:265px;margin-bottom:20px;}
.rec_slide_wrap h2.title{font-size:15px;color:#383838;font-weight:500;line-height:15px;margin-bottom:8px;}
.rec_slide{width:100%;overflow:hidden;position:relative;}
.rec_slide .img_wrap{position:relative;;width:100%;padding-bottom:100%;overflow:hidden;}
.rec_slide .img_wrap img{position:absolute;bottom:0;left:0;width:100%;}
.rec_slide .text_box{width:100%;height:98px;background:url(../images/rec_view_slider_text.jpg) 0 0 no-repeat;padding:19px}
.rec_slide .text_box .s_title{font-size:12px;color:#888;line-height:12px;margin-bottom:10px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.rec_slide .text_box .b_title{font-size:18px;color:#383838;font-weight:500;line-height:18px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.rec_slide .bx-controls{display:none;}
.rec_slide .slide_next{position:absolute;background:url(../images/icon_rec_btn_next.png) 0 0 no-repeat;width:26px ;height:24px;right:0;top:120px;margin:0;font-size:0;line-height:0;}
.rec_slide .slide_prev{position:absolute;background:url(../images/icon_rec_btn_prev.png) 0 0 no-repeat;width:26px ;height:24px;left:0;top:120px;margin:0;font-size:0;line-height:0;}
.rec_slide .slide_prev a, .rec_slide .slide_next a{display:block;width:100%;height:100%;}

.rec_ad{width:250px;height:250px;overflow:hidden;}
.rec_ad img{width:100%;}

.key_list{text-align:center;}
.key_list .key{display:inline-block;padding:0 12px;height:24px;line-height:24px;background-image:url(../images/round_left.jpg),url(../images/round_right.jpg),url(../images/../images/round_center.jpg);background-repeat:no-repeat, no-repeat, repeat-x;background-position:left, right, left;font-size:12px;color:#888;margin:19px 3px 0 3px;}

.rec_foot_banner{position:relative;overflow:hidden;}
.rec_foot_banner img{width:100%;}
.rec_foot_banner li{margin-top:58px;}
/* .rec_foot_banner .swiper-pagination{top:20px;height:11px;line-height:11px;text-align:right;bottom:inherit;padding-right:20px;}
.rec_foot_banner .swiper-pagination-bullet{width:11px;height:11px;background-color:#fff;opacity:0.5}
.rec_foot_banner .swiper-pagination-bullet-active{background-color:#fff;opacity:1}
.rec_foot_banner.swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet{margin:0;margin-left:8px;} */
.rec_foot_banner .bx-controls-direction{display:none;}
.rec_foot_banner .bx-pager{position:absolute;top:78px;padding-right:20px;text-align:right;width:100%;height:0;line-height:0;}
.rec_foot_banner .bx-pager > div{display:inline-block;margin-left:8px}
.rec_foot_banner .bx-pager a{display:block;width:11px;height:11px;background-color:#fff;opacity:0.5;font-size:0;line-height:0;border-radius:50%;}
.rec_foot_banner .bx-pager a.active{background-color:#fff;opacity:1;font-size:0;line-height:0;}
.rec_foot_banner .bx-wrapper li{margin:0;padding-top:58px;}



.detail_reply{margin-top:58px;position:relative;}
.detail_reply .title_area{font-size:22px;color:#1a1a1a;margin-bottom:10px;}
.detail_reply .title_area .icon_box li{float:left;margin-left:3px;}
.detail_reply .title_area .icon_box li img{float:left;}
.detail_reply .title_area .icon_box li .id{display:inline-block;line-height:26px;padding-left:5px;padding-right: 7px;font-size:12px;color:#383838}

.detail_reply .reply_input{padding:29px;background-color:#f9f9f9;border:1px solid #ececec}
.detail_reply .reply_input input{float:left;width:880px;height:40px;border:1px solid #ececec;margin-right:10px;padding-left:15px;font-size:13px;color:#888;}

.detail_reply .reply_list{padding-top:30px;padding-bottom:28px;border-bottom:1px solid #f6f6f6}
.detail_reply .reply_list .img_wrap{float:left;position:relative;width:65px;height:65px;overflow:hidden;}
.detail_reply .reply_list .img_wrap img{width:100%;}
.detail_reply .reply_list .img_wrap .cover{position:absolute;left:0;top:0;width:100%;height:100%;background:url(../images/user_img_wrap.png) 0 0 no-repeat;}
.detail_reply .reply_list .text_box{position:relative;margin-left:80px;padding-top:9px;}
.detail_reply .reply_list .text_box .name{font-size:14px;color:#1a1a1a;font-weight:500;line-height:26px;}
.detail_reply .reply_list .text_box .date{display:inline-block;font-size:12px;color:#c1c1c1;margin-left:10px;}
.detail_reply .reply_list .text_box .text{font-size:13px;color:#888;font-weight:500;line-height:26px;padding-right:30px;}
.detail_reply .reply_list .text_box img{position:absolute;right:0;top:50%;margin-top:-10px;}

.detail_reply .face_share{padding-top:15px;padding-bottom:15px;border-bottom:1px solid #f6f6f6}
.detail_reply .face_share input{vertical-align:middle;margin-top:-2px;margin-right:5px}
.detail_reply .face_share img{margin-right:5px;margin-top:-3px}
.detail_reply .face_share label{font-size:12px;color:#888;}
.detail_reply .loading{position:absolute;width:108px;left:50%;margin-left:-54px;top:35px;display:none;}
.detail_reply .loading .loading_icon{position:absolute;top:50%;margin-top:-21px;left:50%;margin-left:-19px;}

.detail_reply .det_more{display:block;width:96px;margin:0 auto;margin-top:27px;}

/******** tv ********/
.tv_contian{width:100%;min-width:1080px;}
.tv_contian .no_list{text-align:center;padding:200px 0;color:#888}
/* tv list */
.tv_list_top{min-width:1080px;padding:41px 0 42px;background-color:#f7f7f7;}
.tv_list_top ul.contain{display:table;}
.tv_list_top ul.contain > li{display:table-cell;vertical-align:top}
.tv_list_top .img_wrap{position:relative;width:720px;}
.tv_list_top .img_wrap iframe{display:block;}
.tv_list_top .img_wrap .icon{position:absolute;top:50%;margin-top:-25px;left:50%;margin-left:-25px;}
.tv_list_top .exp{background-color:#fff;padding:27px;}
.tv_list_top .exp .text_box{position:relative;margin-top:30px;height:185px;border-bottom:1px solid #f7f7f7;overflow:hidden;}
.tv_list_top .exp .text_box a{color:#888}
.tv_list_top .exp .text_box .icon_box{position:absolute;bottom:24px;right:0;}
.tv_list_top .exp .text_box .icon_box li{float:left;margin-left:8px;}
.tv_list_top .exp .btn_box{padding-top:24px;}
.tv_list_top .exp .btn_box img{float:left;margin-right:6px;}

.tv_list_all{padding-top:40px;}
.tv_list li{float:left;width:354px;margin-left:9px;margin-bottom: 12px;}
.tv_list li.ml_none{margin-left:0;}
.tv_list li .img_wrap{position:relative;width:100%;height:192px;overflow:hidden;}
.tv_list li .img_wrap img.list_item{width:100%;}
.tv_list li  .cover{position:absolute;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.6);}
.tv_list li .icon{position:absolute;top:50%;margin-top:-25px;left:50%;margin-left:-25px;}
.tv_list li .text_box{padding:11px 0 11px 5px; }
.tv_list li .s_title{font-size:12px;color:#888;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-top:-3px}
.tv_list li .b_title{font-size:14px;color:#383838;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}

/* tv view */
.tv_veiw{padding-top:36px;}
.tv_player iframe{display:block;}

.tv_detail{padding:60px 0;border-bottom:1px solid #ececec;}
.tv_detail .tv_content{display:table;width:100%;}
.tv_detail .tv_content > li{display:table-cell;vertical-align:top;padding-left:97px;background:url(../images/tv_line.jpg) 47px 0 repeat-y}
.tv_detail .tv_content > li:first-child{width:718px;border-left:0;padding-left:0;background:none;}

.tv_detail .icon_box{border-bottom:1px solid #f6f6f6;padding:2px 0 17px;}
.tv_detail .icon_box li{float:left;}
.tv_detail .icon_box .fl li{margin-right:12px;height:20px;line-height:20px;}
.tv_detail .icon_box .fl li img{display:inline-block;vertical-align:text-bottom;margin-right:5px;margin-bottom:3px}
.tv_detail .icon_box .fl li:first-child img{margin-bottom:4px}
.tv_detail .icon_box .fr li{margin-left:7px;}
.tv_detail .rec_exp{position:relative;padding:35px 0 0;}
.tv_detail .like_btn{position:absolute;right:0;bottom:0;} 
.tv_rel{padding-top:60px;}
.tv_rel h2.title{font-size:20px;color:#383838;font-weight:500;line-height:20px;margin-bottom:15px;}
.tv_rel .tv_list li{margin-bottom:0;}

/* search */
.search_top{padding:35px 0 45px;}
.search_top .text_box{font-size:13px;color:#888;line-height:13px;text-align:center;}
.search_top .text_box .text_o{color:#ed731b}

/* 로그인 */
.login {*zoom:1; position:relative;padding:60px 0 200px;}
.mix_title{font-size:12px;color:#b2b2b2;font-weight:400;line-height:15px;padding-bottom:10px;border-bottom:1px solid #f4f4f4;}
.mix_title .title{font-size:22px;color:#3b3b3b;font-weight:500;letter-spacing:0;display:inline-block;margin-right:10px}
/* .login .mix_title{width:990px;margin:0 auto;} */
.login_wrap{display:table;width:100%;margin-top:65px;}
.login_wrap > li{display:table-cell;width:50%;text-align:center;border-left:1px solid #efefef;vertical-align:top;}
.login_wrap > li:first-child{border-left:0;}
.login_wrap .login_box{display:inline-block;text-align:left;}
.login_wrap .title{font-size:16px;color:#3b3b3b;font-weight:500;padding-bottom:20px;}
.member_loginArea ul{float:left;margin-right:10px;}
.member_loginArea li{width:295px;line-height:34px;font-size:12px;color:#5e5e5e}
.member_loginArea li:first-child{margin-bottom:9px;}
.member_loginArea li:after{content:'';display:block;clear:both;}
.member_loginArea li input{float:right;width:239px;height:35px;border:1px solid #dedede;padding-left:15px;}
.member_loginArea .btn_login{float:right;}
.member_loginArea .btn_login input{display:block;}

.no_login{margin-left:47px;margin-top:14px;}
.no_login a{display:inline-block;margin:0 9px;font-size:12px;color:#b2b2b2;font-weight:500}
.no_login .line{color:#b2b2b2;font-weight:300;font-size:10px;display:inline-block;vertical-align:top;margin-top:1px}

.login_social{width:384px;display:inline-block;}
.login_social .title{font-size:16px;color:#3b3b3b;font-weight:500;padding-bottom:20px;text-align:left}
.login_social .btn_wrap a{display:inline-block;margin:0 15px}

.find_pop{width:505px;margin:0 auto;padding-top:40px;padding-bottom:40px;}
.find_pop h1{text-align:center;font-size:24px;color:#383838;}
.find_pop .text{text-align:center;font-size:12px;color:#888;margin-top:20px;margin-bottom:30px;}
.find_pop dl{width:100%;border-top:1px solid #f4f4f4;border-bottom:1px solid #f4f4f4;margin-top:-1px}
.find_pop dl dt{float:left;width:122px;height:52px;line-height:52px;padding-left:11px;font-size:13px;}
.find_pop dl dd{margin-left:122px;height:52px;padding-top:12px;font-size:13px;color:#888;}
.find_pop .input{border:1px solid #f4f4f4; padding:0 10px; height:27px; line-height:20px; color:#717171; }
.find_pop .find_btn{margin:0 auto;margin-top:30px;display:block;}
.find_pop .value_box{border-top:1px solid #f4f4f4;border-bottom:1px solid #f4f4f4;padding:40px 0;text-align:center;margin-top:30px;font-size:16px;color:#888;}
.find_pop .value_box span{color:#fd7405;font-weight:500}
.find_pop .wd128{width:128px;margin-right:5px;}
.find_pop .wd215{width:215px;margin-left:5px;}

/* 비회원 로그인 */
.notLogin .text{font-size:12px;color:#b2b2b2;}
.notLogin a{display:inline-block;margin-top:30px;margin-left:82px;}

/* shop_login */
.shop_login #tab_con2{display:none;}
.shop_tab{margin-bottom:25px;}
.shop_tab li{float:left;width:50%;text-align:center;font-size:15px;color:#3b3b3b;font-weight:500;border:1px solid #dcdcdc;background-color:#f9f9f9;padding:10px 0;}
.shop_tab li:first-child{border-right:0}
.shop_tab li.active{background-color:#fff;border-bottom:0;color:#4a753d;}


/* 기획전 */
.exh_top{width:100%;overflow:hidden;}
.exh_top img{position:relative;margin:0 auto;max-width:100%;}
.exh_list{margin-top:25px;}
.exh_list li{float:left;width:208px;margin-left:10px;margin-bottom:12px;position:relative;}
.exh_list li.ml_none{margin-left:0;}
.exh_list li a{display:block;}
.exh_list li .img_wrap{position:relative;width:100%;height:208px;overflow:hidden;}
.exh_list li .img_wrap img{position:absolute;bottom:0;}
.exh_list li .text_box{position:absolute;width:100%;bottom:0;padding:11px 0 11px 5px;background-color:rgba(0,0,0,0.45);}
.exh_list li .s_title{font-size:12px;color:#fff;line-height:12px;margin-bottom:9px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.exh_list li .b_title{font-size:14px;color:#fff;line-height:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}

/* 검색 */
.search_tab{border-bottom:1px solid #dedede}
.search_tab li{float:left;border:1px solid #efefef;border-bottom:0;margin-left:-1px;margin-bottom:-1px;background-color:#f9f9f9;}
.search_tab li:first-child{margin-left:0;}
.search_tab li a{display:block;padding:9px 24px;font-size:13px;color:#888;font-weight:400}
.search_tab li.on{position:relative;padding-bottom:1px;z-index:2;background-color:#fff;border:1px solid #dedede;border-bottom:0;}
.search_tab li.on a{color:#fc7405;font-weight:500}
.search_con{padding-top:12px;}
.search_con li.list_none{width:100%;padding:150px 0;text-align:center;color:#888}

/* 게시판 공통 */
.bbs_title {position:relative; font-size:22px; font-weight:400; color:#383838; line-height:20px;margin-bottom:16px;}
/* .bbs_title h2 {font-weight:bold; color:#121212; letter-spacing:0;} */
.bbs_title .huwon_review_select {position:absolute; top:0; right:0; width:300px; text-align:right;}
.bbs_title .huwon_review_select p {display:inline-block;position:relative;}

/* .bbscontent {margin-bottom:80px;} */
.bbsVisual {height:230px; margin-bottom:80px;}
.flex{    -webkit-text-size-adjust: 100%;
    font-weight: 500;
    word-break: keep-all;
    word-wrap: break-word;
    line-height: 1.4;
    color: #383838;
    font-size: 12px;
    margin: 0;
    padding: 0;
    font-family: 'Noto Sans KR', sans-serif;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
    letter-spacing: -1px;}

.flax{letter-spacing: 1.3px;
    --primary: #937062;
    --primary_6: rgb(147,112,98,0.6);
    --primary_hover: #BF917E;
    --primary_press: #75574B;
    --secondary_hover: #FBEDE8;
    --secondary_press: #EFDCD4;
    --gray_100: #F5F5F5;
    --gray_200: #EEEEEE;
    --gray_300: #e0e0e0;
    --gray_400: #bdbdbd;
    --gray_500: #9e9e9e;
    --gray_600: #757575;
    --gray_700: #616161;
    --accent: #F66F58;
    --error: #D32F2F;
    margin: 0px;
    padding: 0px;
    border: 0px;
    font: inherit;
    vertical-align: baseline;
    text-decoration: none;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;}
/* 메인 */
.main_box{margin-top:60px;}
.main_box2{margin-top:55px;}
.main_top{width:100%;min-width:1080px;height:422px;overflow:hidden;}
.main_top img{float:right;/* width:622px; */}
.main_top .text_box{margin-top:162px;max-width:430px;}
.main_top .text_box .s_title{font-size:30px;color:#1a1a1a;font-weight:300;line-height:30px;margin-bottom:25px;}
.main_top .text_box .b_title{font-size:60px;color:#1a1a1a;font-weight:400;line-height:60px;}
.main_top_slide{position:relative;}
.main_top_slide .bx-pager{display:none;}
.main_top_slide .bx-controls{position:absolute;top:0;width:100%;}
.main_top_slide .bx-controls-direction{position:relative;width:1298px;margin:0 auto;}
.main_top_slide .bx-controls-direction a{position:absolute;display:inline-block;width:27px;height:57px;top:197px;z-index:99;font-size:0;line-height:0}
.main_top_slide .bx-controls-direction a.bx-prev{background:url(../images/main_top_left_arrow.png) 0 0 no-repeat;}
.main_top_slide .bx-controls-direction a.bx-next{right:0;background:url(../images/main_top_right_arrow.png) 0 0 no-repeat;}
.main_new .rec_list li{position:relative;margin-bottom:0;}
.main_new .rec_list li .text_box{position:absolute;bottom:0;width:100%;background:url(../images/main_prod_bg.png) repeat;}
.main_new .rec_list li .s_title{color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.main_new .rec_list li .b_title{color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.main_hit ul{margin-top:1px}
.main_hit li{position:relative;float:left;width:50%;border-top:1px solid #f4f4f4;border-bottom:1px solid #f4f4f4;padding:12px 0;margin-top:-1px;}
.main_hit li .num{float:left;width:54px;text-align:center;line-height:80px;font-family:'Arial';font-size:24px;color:#383838;}
.main_hit li a{display:block;}
.main_hit li .img_box{float:left;position:relative;width:80px;height:80px;overflow:hidden;margin-right:11px;}
.main_hit li .img_box img{position:absolute;bottom:0;width:100%;}
.main_hit li .text_box{display:table-cell;height:80px;vertical-align:middle;max-width:300px;}
.main_hit li .text_box .s_title{font-size:12px;color:#888;}
.main_hit li .text_box .b_title{font-size:18px;color:#383838;}
.main_hit li .like{position:absolute;right:50px;top:50%;margin-top:-19px;}
.main_hit .more{display:block;width:100%;border-bottom:1px solid #f3f3f3;line-height:46px;font-size:16px;color:#888;text-align:center;}
.main_hit .more img{display:inline-block;vertical-align:middle;margin-top:-4px;margin-right:8px;}

.main_tv .tv_list li{width:262px;margin-left:10px;margin-bottom:0;}
.main_tv .tv_list li.ml_none{margin-left:0;}
.main_tv .tv_list li .img_wrap{height:144px;}
.main_tag .key_list .key{margin:5px 3px;height:28px;line-height:28px;background-image:url(../images/main_round_left.jpg),url(../images/main_round_right.jpg),url(../images/../images/main_round_center.jpg);background-repeat:no-repeat, no-repeat, repeat-x;background-position:left, right, left;padding:0 16px}

.main_int li{float:left;width:262px;margin-left:10px;height:340px;}
.main_int li.text_wrap{margin-left:0;background-color:#ffebda;padding:42px 28px;}
.main_int .rec_list li.text_wrap .s_title{font-size:18px;line-height:18px;color:#383838}
.main_int .rec_list li.text_wrap .b_title{font-size:24px;line-height:32px;color:#383838;font-weight:500;margin-top:11px;}
.main_int .rec_list li.text_wrap .s_text{font-size:14px;color:#888;line-height:25px;margin-top:15px;}

.main_int .rec_list li .img_wrap{height:262px;}
.main_int .rec_list li .text_box{padding:20px 5px;}
.main_int .rec_list li .s_title{font-weight:500;line-height:18px;}
.main_int .rec_list li .b_title{font-size:18px;font-weight:500;line-height:24px;}
.main_int .rec_list li .text_box span.fr{font-size:12px;color:#c5c5c5;font-weight:500;margin-right:4px;}
.main_int .rec_list li .text_box span.fr img{display:inline-block;vertical-align:middle;margin-top:-2px;margin-right:3px;}

.main_thema{background-color:#f9f9f9;padding:24px 50px 20px;position:relative;}
.main_thema_slide{height:95px;overflow:hidden;position:relative;}
/* .main_thema_slide li{width:auto;margin-right:33px;} */
.main_thema_slide li a:hover p{color:#fd7405}
.main_thema_slide img{margin:0 auto;}
.main_thema_slide li a p{text-align:center;font-size:14px;color:#888;line-height:14px;margin-top:11px;}
.main_thema .bx-controls{display:none;}
.main_thema .mt_right{position:absolute;width:13px;height:22px;background:url(../images/main_thema_right.jpg) 0 0 no-repeat;right:19px;top:50%;margin-top:-11px;font-size:0;line-height:0;}
.main_thema .mt_left{position:absolute;width:13px;height:22px;background:url(../images/main_thema_left.jpg) 0 0 no-repeat;left:19px;top:50%;margin-top:-11px;font-size:0;line-height:0;}
.main_thema .mt_right a, .main_thema .mt_left a{display:block;width:100%;height:100%}

/* .main_thema_slide .swiper-button-next.swiper-button-disabled, .swiper-button-prev.swiper-button-disabled{opacity:1;} */

.main_season li{margin-bottom:0;}
.main_season li .text_box{padding-bottom:0;}
.main_season li .text_box .s_title{line-height:18px}
.main_season li .text_box .b_title{font-size:18px;line-height:24px}

.main_cen_banner{position:relative;overflow:hidden;}
/* .main_cen_banner .swiper-pagination{top:20px;height:11px;line-height:11px;text-align:right;bottom:inherit;padding-right:20px;}
.main_cen_banner .swiper-pagination-bullet{width:11px;height:11px;background-color:#fff;opacity:0.5}
.main_cen_banner .swiper-pagination-bullet-active{background-color:#fff;opacity:1}
.main_cen_banner.swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet{margin:0;margin-left:8px;} */
.main_cen_slide .bx-controls-direction{display:none;}
.main_cen_slide .bx-pager{position:absolute;top:20px;padding-right:20px;text-align:right;width:100%;height:0;line-height:0;}
.main_cen_slide .bx-pager > div{display:inline-block;margin-left:8px}
.main_cen_slide .bx-pager a{display:block;width:11px;height:11px;background-color:#fff;opacity:0.5;font-size:0;line-height:0;border-radius:50%;}
.main_cen_slide .bx-pager a.active{background-color:#fff;opacity:1;font-size:0;line-height:0;}

.plan_type1 > div{width:515px;border-top:1px solid #f4f4f4;}
.plan_type1 li{width:100%;padding:15px 0;border-bottom:1px solid #f4f4f4;}
.plan_type1 li:after{content:'';display:block;clear:both;}
.plan_type1 li .img_box{float:left;position:relative;width:120px;height:120px;overflow:hidden;}
.plan_type1 li .img_box img{position:absolute;bottom:0;width:100%;}
.plan_type1 li .text_box{margin-left:135px;}
.plan_type1 li .text_box .title{font-size:18px;color:#383838;line-height:24px;margin-bottom:9px;margin-top:-3px;}
.plan_type1 li .text_box .text{font-size:12px;color:#888;line-height:20px;}

.plan_type2 li{margin-bottom:0;}
.plan_type2 li .text_box{padding-bottom:0;}
.plan_type2 li .text_box .s_title{line-height:18px}
.plan_type2 li .text_box .b_title{font-size:18px;line-height:24px}

.main_cen_ban{position:relative;float:left;width:516px;height:290px;overflow:hidden;}
/* .main_cen_ban .swiper-pagination-bullet{width:12px;height:12px;background-color:#fff;opacity:0.5;}
.main_cen_ban .swiper-pagination-bullet-active{background-color:#fff;opacity:1;} */
.main_cen_ban .bx-controls-direction{display:none;}
.main_cen_ban .bx-pager{position:absolute;top:20px;padding-right:20px;text-align:right;width:100%;height:0;line-height:0;}
.main_cen_ban .bx-pager > div{display:inline-block;margin-left:8px}
.main_cen_ban .bx-pager a{display:block;width:11px;height:11px;background-color:#fff;opacity:0.5;font-size:0;line-height:0;border-radius:50%;}
.main_cen_ban .bx-pager a.active{background-color:#fff;opacity:1;font-size:0;line-height:0;}


.main_comm{float:right;width:514px;}
.main_comm .def_title{margin-top:2px;margin-bottom:16px;}
.main_comm_list{border-top:1px solid #f2f2f2}
.main_comm_list li{border-bottom:1px solid #f2f2f2;width:100%;}
.main_comm_list li a{display:block;padding:13px 13px 12px;;vertical-align:middle;width:100%}
.main_comm_list li .text_box{margin-left:57px;}
.main_comm_list li .text_box .name{font-size:12px;color:#888;}
.main_comm_list li .text_box .text{font-size:14px;color:#383838;}

.main_month li{margin-bottom:0;}
.main_month li .text_box{padding-bottom:0;}
.main_month li .text_box .s_title{line-height:18px}
.main_month li .text_box .b_title{font-size:18px;line-height:24px}

.main_instar ul{margin-top:-10px}
.main_instar li{float:left;width:171px;height:171px;margin-left:1%;margin-top:10px;overflow:hidden;position:relative;}
.main_instar li.no_mar{margin-left:0;}

@media (max-width:1298px) {
   .main_top_slide .bx-controls{left:50%;margin-left:-649px;}
}

/* 퀵영역 */
#quick {position:absolute; top:175px; right:0;z-index:97;height:447px;}
#quick .quick_bg{width:129px;height:524px;background:url(../images/quick_bg.png) right 0 no-repeat;padding-left:19px;padding-top:2px}
#quick .quick_bg.bg2{height:447px;background:url(../images/quick_bg3.png) right 0 no-repeat;}
.quick_inner{position:relative;padding-top:20px;height:100%;}
.quick_link{margin-left:16px;/* border-bottom:1px solid #f6f6f6; */width:78px;padding-bottom:17px;}
.quick_link a{display:block;font-size:12px;color:#5e5e5e;margin-top:20px;line-height:14px;}
.quick_link a:first-child{margin:0;}
.quick_link a img{display:inline-block;vertical-align:middle;margin-right:5px;margin-top:-2px}

.quick_product{margin-left:15px;}
.quick_prod_top{padding-top:16px;width:79px;margin-bottom:8px;}
.quick_prod_top img{margin:0 auto;}
.quick_prod_top p{text-align:center;font-size:12px;color:#5e5e5e;line-height:12px;margin-top:7px;}


.quick_area {font-size:0; line-height:0; overflow:hidden; position:relative;}
.quick_areaList {position:absolute; top:0px;height:255px;}
.quick_area .quick_areaList .sliderQuick{margin-bottom:9px;}
.quick_area .quick_areaList a {display:block; width:79px;height:79px;position:relative;overflow:hidden;}
.quick_area .quick_areaList img {width:100%;position:absolute;bottom:0;}
.quick_areaList .no_list{padding-top:100px;line-height:20px;font-size:12px;color:#888;text-align:center;word-break:keep-all;}
.quick_today_btn {font-size:0; line-height:0; margin-top:9px;}
.quick_today_btn a:first-child {margin-right:2px;}
.quick_today_btn img{float:left;margin-right:3px;}

#quick .quicktop{display:block;position:absolute;width:110px;right:0;bottom:7px;height:34px;line-height:34px;text-align:center;font-size:10px;color:#383838;font-weight:500}
#quick .quick_btn{display:block;position:absolute;left:0;top:224px;width:19px;height:64px;background:url(../images/btn_quick_off.png) 0 0 no-repeat;}
#quick .quick_btn{position:absolute;left:0;top:50%;margin-top:-30px;}
#quick .quick_btn.on{background:url(../images/btn_quick_on.png) 0 0 no-repeat;}


#quick.off{background:none;}
#quick.off .quick_bg{display:none;}
#quick.off .quick_inner{display:none;}
#quick.off .quicktop{display:none;}

/* .ui-widget.ui-widget-content{border:1px solid #dedede;border-radius:0;padding-top:13px;padding-bottom:13px;} */
.ui-spinner a.ui-spinner-button{display:inline-block;width:16px;}
.ui-menu .ui-menu-item a{line-height:30px;display:block;padding-left:15px;font-size:14px;color:#888}

/* 광고 및 마케팅 제휴문의 */
.mark_wrap{width:990px;margin:0 auto;}
.mark_title{text-align:center;padding-top:60px;padding-bottom:57px;border-bottom:2px solid #f4f4f4;}
.mark_title .b_title{font-size:40px;color:#3b3b3b;line-height:36px;margin-bottom:23px;}
.mark_title .s_text{font-size:14px;color:#b2b2b2;line-height:14px;}

.mark_form{width:877px;margin:0 auto;margin-top:42px;}
.mark_form .def_title{font-size:16px;line-height:16px;color:#3b3b3b;font-weight:500;}
.mark_form textarea{border:1px solid #dedede; padding:10px; height:215px; line-height:20px; color:#717171; width:100%;resize:none;}
.mark_form .join table td{padding-right:0;}

.mark_agg{margin-top:39px;}
.mark_agg > p{font-size:12px;color:#5e5e5e;line-height:12px;margin-bottom:10px;}
.mark_agg > p input{vertical-align:middle;margin-right:5px;}
.mark_agg_box{height:112px;border:1px solid #dedede;overflow-y: auto;padding:20px;font-size:12px;line-height:18px;color:#b2b2b2;}

.mark_agg .submit{display:block;width:145px;height:35px;margin:0 auto;margin-top:40px;}

/* shop main */
.shop_top{width:100%;min-width:1080px;height:444px;overflow:hidden;}
.shop_top_slide{position:relative;}
.shop_top_slide .contain{overflow:hidden;}
.shop_top_slide .bx-pager{display:none;}
.shop_top_slide .bx-controls{position:absolute;top:0;width:100%;}
.shop_top_slide .bx-controls-direction{position:relative;width:1298px;margin:0 auto;}
.shop_top_slide .bx-controls-direction a{position:absolute;display:inline-block;width:27px;height:57px;top:197px;z-index:99;font-size:0;line-height:0}
.shop_top_slide .bx-controls-direction a.bx-prev{background:url(../images/main_top_left_arrow.png) 0 0 no-repeat;}
.shop_top_slide .bx-controls-direction a.bx-next{right:0;background:url(../images/main_top_right_arrow.png) 0 0 no-repeat;}

.shop_wrap .con1{margin-top:56px;}
/* .shop_wrap .con1 > div{width:533px;height:218px;overflow:hidden;position:relative;}
.shop_wrap .con1 .bx-controls-direction{display:none;}
.shop_wrap .con1 .bx-pager{position:absolute;top:20px;padding-right:20px;text-align:right;width:100%;height:0;line-height:0;}
.shop_wrap .con1 .bx-pager > div{display:inline-block;margin-left:8px}
.shop_wrap .con1 .bx-pager a{display:block;width:11px;height:11px;background-color:#fff;opacity:0.5;font-size:0;line-height:0;border-radius:50%;}
.shop_wrap .con1 .bx-pager a.active{background-color:#fff;opacity:1;font-size:0;line-height:0;} */

.shop_wrap .con1 li{float:Left;width:533px;}
.shop_wrap .con1 li.fr{float:right;}

.shop_wrap .con1 li > a > img{display:block;width:100%}
.shop_wrap .con2{margin-top:56px;display:table;width:100%;}
.shop_wrap .con2 > div{display:table-cell;}
.shop_wrap .con2 > .title{width:271px}
.shop_wrap .con2 .con2_slide_wrap{border:1px solid #f2f2f2;border-left:0;vertical-align:top;position:relative;height:400px;overflow:hidden;}
.shop_wrap .con2_slide{width:707px;height:400px;overflow:hidden;margin:0 auto;}
.shop_wrap .con2_slide ul{margin-left:-21px;}
.shop_wrap .con2_slide li{width:249px;height:398px;padding:30px 20px 0 20px;border-left:1px solid #f2f2f2}
.shop_wrap .con2_slide li a{display:block;}
.shop_wrap .con2_slide li .img_wrap{width:100%;height:208px;overflow:hidden;}
.shop_wrap .con2_slide li img{width:100%}
.shop_wrap .con2_slide li .text_box{text-align:center;}
.shop_wrap .con2_slide li .text_box .title{font-size:18px;color:#383838;margin-top:14px;}
.shop_wrap .con2_slide li .text_box .g_text{font-size:12px;color:#888;line-height:19px;margin-top:12px;}
.shop_wrap .con2_slide li .text_box .price{font-size:16px;color:#568448;line-height:19px;margin-top:14px;}
.shop_wrap .con2_slide_wrap .bx-controls{display:none;}
.shop_wrap .con2_slide_wrap .con2_right{position:absolute;width:31px;height:25px;top:50%;margin-top:-12px;background:url(../images/con2_right.jpg) 0 0 no-repeat;right:-1px}
.shop_wrap .con2_slide_wrap .con2_left{position:absolute;width:31px;height:25px;top:50%;margin-top:-12px;background:url(../images/con2_left.jpg) 0 0 no-repeat;left:0}
.shop_wrap .con2_slide_wrap .con2_right a, .shop_wrap .con2_slide_wrap .con2_left a{display:block;width:100%;height:100%;font-size:0;line-height:0;}
.shop_wrap .con3{margin-top:55px;padding:0 89px;position:relative;}
.shop_wrap .con3 .key_list .key{height:31px;line-height:31px;font-size:16px;padding:0 16px;background-image:url(../images/shop_round_left.jpg), url(../images/shop_round_right.jpg), url(../images/shop_round_center.jpg);background-repeat:no-repeat, no-repeat, repeat-x;background-position:left, right, left}

.shop_wrap .con4{margin-top:55px;}
.shop_wrap .con4 li{float:left;margin-left:10px;width:262px;}
.shop_wrap .con4 li:first-child{margin-left:0;margin-right:1px}
.shop_wrap .con4 li .img_wrap{width:262px;height:262px;overflow:hidden;}
.shop_wrap .con4 li .img_wrap img{width:100%;}
.shop_wrap .con4 li .text_box{text-align:center;margin-top:17px}
.shop_wrap .con4 li .title{font-size:18px;color:#383838;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.shop_wrap .con4 li .price{font-size:16px;color:#888;font-weight:500;margin-top:3px}
.shop_wrap .con5{margin-top:56px;}
.shop_wrap .con5 ul{margin-top:1px}
.shop_wrap .con5 li{position:relative;float:left;width:50%;border-top:1px solid #f4f4f4;border-bottom:1px solid #f4f4f4;padding:12px 0;margin-top:-1px;}
.shop_wrap .con5 li .num{float:left;width:54px;text-align:center;line-height:80px;font-family:'Arial';font-size:24px;color:#383838;}
.shop_wrap .con5 li a{display:block;}
.shop_wrap .con5 li .img_box{float:left;position:relative;width:80px;height:80px;overflow:hidden;margin-right:11px;}
.shop_wrap .con5 li .img_box img{position:absolute;bottom:0;width:100%;}
.shop_wrap .con5 li .text_box{display:table-cell;height:80px;vertical-align:middle;max-width:300px;}
.shop_wrap .con5 li .text_box .s_title{font-size:12px;color:#888;}
.shop_wrap .con5 li .text_box .b_title{font-size:18px;color:#383838;}
.shop_wrap .con5 li .like{position:absolute;right:50px;top:50%;margin-top:-19px;}
.shop_wrap .con5 .more{display:block;width:100%;border-bottom:1px solid #f3f3f3;line-height:46px;font-size:16px;color:#888;text-align:center;}
.shop_wrap .con5 .more img{display:inline-block;vertical-align:middle;margin-top:-4px;margin-right:8px;}
.shop_wrap .con6{margin-top:56px;}
.shop_wrap .con6 img{width:100%}
.shop_wrap .con7{margin-top:56px;}
.shop_wrap .con7 li{float:left;margin-left:10px;width:262px;}
.shop_wrap .con7 li:first-child{margin-left:0;margin-right:1px}
.shop_wrap .con7 li .img_wrap{width:262px;height:262px;overflow:hidden;}
.shop_wrap .con7 li .img_wrap img{width:100%;}
.shop_wrap .con7 li .text_box{text-align:center;margin-top:17px}
.shop_wrap .con7 li .g_text{font-size:16px;color:#888;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.shop_wrap .con7 li .title{font-size:18px;color:#383838;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.shop_wrap .con7 li .price{font-size:16px;color:#568448;font-weight:500;}
.shop_wrap .con8{margin-top:56px;}
.shop_wrap .con8 .fr img{width:425px;}
.shop_wrap .con9{margin-top:56px;}
.shop_wrap .con9 li{float:left;width:210px;margin-left:7px;}
.shop_wrap .con9 li:first-child{margin-left:0;margin-right:2px;}
.shop_wrap .con9 li .img_wrap{width:100%;border:1px solid #f5f5f5;}
.shop_wrap .con9 li .img_wrap img{width:100%;}
.shop_wrap .con9 li .text_box{text-align:center;margin-top:17px;}
.shop_wrap .con9 li .text_box .title{font-size:18px;color:#383838;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.shop_wrap .con9 li .text_box .price{font-size:14px;color:#383838;}
.shop_wrap .con9 li .text_box .no_price{font-size:12px;color:#888;text-decoration:line-through;display:inline-block;margin-right:7px;}

/* goods_list */
.goods_list{padding-top:62px;}
.goods_tab .tab_list li{float:left;width:361px;height:44px;line-height:42px;margin-left:-1px;text-align:center;border:1px solid #f2f2f2;}
.goods_tab .tab_list li.on{line-height:40px;border:2px solid #568448;position:relative;z-index:2;}
.goods_tab .tab_list li a{display:block;color:#568448;font-size:16px;}
.goods_tab .tab_list li .icon{display:inline-block;width:11px;height:6px;background:url(../images/icon_goods_tab_arrow_off.jpg) 0 0 no-repeat;vertical-align:middle;margin-left:10px;margin-top:-2px;}
.goods_tab .tab_list li.on .icon{background-image:url(../images/icon_goods_tab_arrow_on.jpg)}
.goods_tab .tab_con > div{display:none;height:46px;line-height:45px;border-bottom:1px solid #ececec;}
.goods_tab .tab_con > div.on{display:block;}
.goods_tab .tab_con li{float:left;height:46px;}
.goods_tab .tab_con li a{display:block;padding:0 30px;font-size:14px;color:#5e5e5e;}
.goods_tab .tab_con li.on{border-bottom:2px solid #568448;}
.goods_tab .tab_con li.on a{color:#568448;}
.goods_tab .tab_con .con2{text-align:center}
.goods_tab .tab_con .con2 ul{display:inline-block;}
.goods_tab .tab_con .con3 ul{float:right;}

.goodlist_default_prod_title {text-align:center; margin-bottom:40px}
.goodlist_default {padding:5px 0 ;}
.goodlist_default ul {*zoom:1; width:105%}
.goodlist_default ul:after {content:""; display:block; clear:both;}
.goodlist_default li {float:left; width:208px; margin:0 10px 40px 0;}
.goodlist_default li a {display:block; width:100%; color:#555; text-decoration:none;}
.goodlist_default li a .prod_img {width:100%;height:208px;overflow:hidden}
.goodlist_default.book li a .prod_img{height:auto;overflow:inherit}
.goodlist_default li a .prod_img img {width:100%;}
.goodlist_default li a dl {width:190px;margin:0 auto;}
.goodlist_default li a dl dt {font-size:14px;color:#383838;line-height:20px;height:40px;margin-top:7px;}
.goodlist_default li a dl dd {font-weight:bold; color:#383838;font-size:14px;margin-top:5px;}
.goodlist_default li a dl dd span.fixprice {font-weight:normal; text-decoration:line-through; display:inline-block; margin-right:10px;font-size:12px; color:#888; }
.goodlist_default li a dl dd.prod_icon{padding-bottom:0;margin-top:8px;font-size:0;line-height:0}
.goodlist_default li a dl dd.prod_icon img{display:inline-block;margin-right:5px;}
.goodlist_default li.none {float:none; text-align:center; width:100%; margin:0; padding:150px 0;text-align:center;color:#888}

.goods_list .paging .paging_num strong, .goods_view .paging .paging_num strong{color:#4a753d}


/* 상품상세보기 */
.view_title { width:100%;margin-top:60px;margin-bottom:20px;}
.view_title .location { font-size:11px; color:#dedede;letter-spacing:0; }
.view_title .location img{vertical-align:middle;display:inline-block;margin:-2px 5px 0;}
.view_title .location a, .view_title .location span{color:#888}
.goodview_wrap {*zoom:1; width:100%; margin:0 auto 90px;}
.goodview_wrap:after {content:""; display:block; clear:both;}
.goodsview_image{ float:left; width:492px; text-align:center; }
.goodsview_image .image{width:100%; cursor:pointer; }
.goodsview_image .btn{float:left; cursor:pointer; text-align:center; }
.goodsview_image .btn1{width:100%; cursor:pointer; text-align:center; margin-top:10px; }
.goodsview_image .thumb{clear:both; width:100%; margin-bottom:50px;}
.goodsview_image .thumb img{float:left;border:1px solid #e4e4e4;padding:0.5%;margin-right:1.0%;display:block;width:22.4%;height:inherit;}
.prod_title2 {border:1px solid red;text-align:center; padding:7px 0 0; height:157px;}

.goodRight {float:right; width:555px;}
.goodRight .icon_box{padding-bottom:15px;border-bottom:2px solid #f6f6f6;}
.goodRight .icon_box .fl img{display:inline-block;margin-right:5px;}
.goodRight .icon_box li{float:left;margin-left:7px;}
.goodRight .btn {margin-top:15px;}
.goodRight .btn ul { width:100%; }
.goodRight .btn ul li {float:left; margin-right:6px;}
.goodRight .btn ul li.last { margin-right:0;}
/* .goodRight .btn ul li:first-child { width:191px; } */
.goodRight .btn ul li:last-child { margin-right:0;} 

.goodsview_exp{padding:30px 0;border-bottom:2px solid #f6f6f6;}
.goodsview_exp .title{font-size:30px;color:#383838;font-weight:500;}
.goodsview_exp .g_text{font-size:16px;color:#888;}
.goodsview_exp .price_wrap{margin-top:5px;}
.goodsview_exp .no_price{font-size:14px;color:#888;text-decoration:line-through;display:inline-block;margin-right:10px;}
.goodsview_exp .price{font-size:24px;color:#383838;}

.goodsview_info h1{width:100%; font-size:16px; font-family:'dotum'; font-weight: bold;color:#333333; letter-spacing:-1px; line-height:24px; border-bottom:1px solid #e4e4e4;}
.goodsview_info h2{width:100%;color:#ff3300; }

.goodsview_info .all_op_box{padding:7px 0;}
.goodsview_info ul {padding:7px 0;}
.goodsview_info ul.prod_top_info{border-bottom:1px solid #f1f1f1}
/* .goodsview_info ul ul{margin-top:7px;padding:0;}
.goodsview_info ul + ul{padding:0;border-top: 0} */
.goodsview_info ul.op_num_box, .goodsview_info ul.option_box, .goodsview_info ul.add_op_box{padding:0;}
.goodsview_info li {position:relative;/*  padding-left:107px; */ line-height:20px; color:#888; font-size:14px; padding:7px 0;}
/* .goodsview_info li.option_li{padding-bottom:14px;} */
/* .goodsview_info li.option_li + li.option_li{padding-top:0;} */
.goodsview_info li:after{content:'';display:block;clear:both;}
.goodsview_info li > span {float:left;/* position:absolute; top:0; left:1px;  */color:#5e5e5e;font-size:14px;font-weight:500;}
.goodsview_info li.option_li span{width:105px;display:block;min-height:23px;}
.goodsview_info li.option_li select{border:1px solid #dedede;color:#888}
.goodsview_info li .con_box{margin-left:105px;line-height:20px; color:#888; font-size:14px;}
.goodsview_info li .comm{margin-left:105px;font-size:12px;color:#888}
.goodsview_info li.option_li .second_add{margin-left:105px;}
.goodsview_info li .mr{display:inline-block;margin-right:15px;}
.goodsview_info li .d_price {line-height:20px; color:#888; font-size:12px;}
.goodsview_info li .text_box{/* margin-left:107px; */line-height:24px; color:#888; font-size:14px;letter-spacing:0;}

.number_stepper {font-size:0; line-height:0;}
.number_stepper * {vertical-align:middle;}
.goodsview_info .line { border-bottom:1px #dadada solid; padding-bottom:15px;}

.pcs_input {padding:2px 10px; width:45px; height:27px; text-align:center;font-size:12px !important; line-height:15px; color:#717171; border:1px solid #dedede; border-right:0;}
.stepper {display:inline-block; width:16px;}
.ui-spinner-input {margin:0 20px 0 0; border:0;}

.goodsview_info .option_list {padding:0;}
.goodsview_info .option_list li {*zoom:1; background:#fff; border-top:1px solid #f1f1f1; padding:7px 0; margin:0;}
.goodsview_info .option_list li + li{border-top:0}
.goodsview_info .option_list + .option_list li{border-top:0;}
.goodsview_info .option_list li:after {content:""; display:block; clear:both;}
.goodsview_info .option_list li .option_name {float:left; width:63%; padding:4px 0 0 5%; line-height:19px; background:url("../images/option_icon.png") 10px no-repeat; color:#737373; }
.goodsview_info .option_list li .option_pcs {float:left; width:15%; font-size:0; line-height:0; text-align:right; }
.goodsview_info .option_list li .option_pcs span.ui-spinner { border-radius:0; border:1px #dedede solid; }
.goodsview_info .option_list li .option_pcs span input { height:25px; width:40px; }
.goodsview_info .option_list li .option_pcs * {vertical-align:middle;}
.goodsview_info .option_list li .option_price {float:left; width:20%;  text-align:right;color:#737373;padding-top:4px;}
.goodsview_info .option_list li .option_price * {vertical-align:middle;}
.goodsview_info .option_list li .option_price span{display:inline-block;margin-top:-3px; margin-right:3px;}
.goodsview_info .option_list li .option_price img {cursor:pointer;display:inline-block;margin-left:10px;}

.goodsview_info .total_price {position:relative; letter-spacing:0; border-top:1px #f2f2f2 solid;  border-bottom:1px solid #dedede; background:#fefbf9; padding:19px 30px; text-align:right; color:#5e5e5e; font-size:16px; font-weight:500;}
.goodsview_info .total_price em { color:#fd7405; font-weight:500; font-size:30px; margin-left:6px; line-height:27px;}

.goods_view .goodlist_default li{margin-bottom:0;}
.goods_view .goodlist_default li a dl dt{height:20px;text-align:center;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.goods_view .goodlist_default li a dl dd{text-align:center;font-weight:400;font-size:12px;color:#888;}

/*상품상세 텝*/
.goods_view_tap{width:100%;}
.goods_view_tap:after{content:'';display:block;clear:both;}
.goods_view_tap a{float:left;width:271px;margin-left:-1px;text-align:center;font-size:14px;color:#888;font-weight:500;background-color:#f9f9f9;border:1px solid #efefef;padding:11px 0;}
.goods_view_tap a.on{color:#568448;background-color:#fff;border-bottom:1px solid #fff;cursor: context-menu;}
.goods_view_tap img{display:inline-block;}

.goods_view .ment{margin-top:35px;font-size:12px;color:#888;}
.goods_view .ment img{display:inline-block;margin-right:5px;}

/* 상품상세 > 하단 상품상세정보 */
.goodsview_description dd {padding:60px 0;/* border-bottom:1px solid #ececec; */}
.goodsview_description img{ max-width:100%;margin:0 auto;}
.goodsview_description img + img{margin-top:20px}
.goodsview_description img + .text_box{margin-top:20px;}
.goodsview_description dd div p { text-align:center; }

.goodsview_withItem{margin-top:60px}
.goodsview_withItem dd {  width:100%; height:100%; overflow:hidden; }
.goodsview_withItem dd ul {  width:100%; }
.goodsview_withItem dd ul li { float:left; margin:0 35px 35px 0; width:264px; }
.goodsview_withItem dd img { width:264px; }
.goodsview_withItem dd ul li.none_p { width:100%; height:98px; padding-top:56px; margin:0; text-align:center; color:#a7a7a7; }

.prod_info table{width:100%;border-top:2px solid #dedede;}
.prod_info th{width:180px;border-bottom:1px solid #f0f0f0;border-right:1px solid #f0f0f0;background-color:#f9f9f9;text-align:left;padding-left:22px;font-size:14px;color:#5e5e5e;font-weight:500}
.prod_info td{border-bottom:1px solid #f0f0f0;font-size:14px;color:#888;padding:12px 22px;}

.prod_cook{padding-bottom:30px;border-bottom:1px solid #ececec;}
.prod_cook .movie_wrap{height:603px;}
.prod_cook ul{display:table;width:100%;margin-top:30px}
.prod_cook li{display:table-cell;}
.prod_cook li:first-child{padding-right:48px;}
.prod_cook li + li{border-left:1px solid #ececec;}
.prod_cook li + li .def_title{padding-left:38px;}
.prod_cook .text_box{font-size:14px;color:#888;line-height:20px;}
.prod_cook .text_box2{font-size:14px;color:#5e5e5e;font-weight:500;padding:0 38px;}
.prod_cook img{margin-top:30px;}

.prod_tip .right_box{margin-left:343px;}
.prod_tip .right_box .s_title{font-size:18px;color:#383838;font-weight:500;line-height:18px;margin-bottom:20px;}
.prod_tip .right_box .text_box{font-size:14px;color:#888;line-height:20px;}

.prod_amount{padding-bottom:60px;border-bottom:1px solid #ececec;}
.prod_amount li{float:left;width:525px;}
.prod_amount li + li{float:right;}
.prod_amount img{border:1px solid #f2f2f2}
.prod_amount .text_box{padding-top:25px;font-size:14px;color:#888;}

/* 상품상세 > 하단 이용후기 */
.goodsview_con_tt {height:20px;}
.goodsview_review{width:100%; margin-top:60px;}
.goodsview_review img{vertical-align:middle;}
.goodsview_review img.goods_bbs_img{margin-top:15px;max-width:120px;}
.goodsview_review h1{height:25px; margin:30px 0 20px 0;  border-bottom:1px solid #e4e4e4;}
.goodsview_review select{font-size:11px;font-family:돋움;width:80px;}
.goodsview_review input{width:85%; height:29px;}
.goodsview_review textarea{width:98%;height:50px;}
.goodsview_review .none{padding:50px 0;width:100%;text-align:center;border-bottom:1px solid #e4e4e4;}
.goodsview_review .text_byte {display:inline-block; padding-left:10px; color:#777;   font-size:12px;}
.goodsview_review .text_byte strong {font-weight:bold; color:#121212;}

/* 상품상세 > 하단 이용후기 > 리스트 테이블 */
.goodsview_tb{width:100%;border-top:2px solid #f2f2f2;margin-top:16px;}
.goodsview_tb th{border-bottom:1px solid #f2f2f2;font-size:12px;color:#5e5e5e;font-weight:500;text-align:center;padding:13px 0;}
.goodsview_tb td{border-bottom:1px solid #f2f2f2;text-align:center;font-size:12px;color:#888;}
.goodsview_tb td.txt_l{text-align:left;cursor:pointer;}
.goodsview_tb .info td{padding:13px 0;}
.goodsview_tb td .star{color:#568448;display:inline-block;margin-right:50px;}
.goodsview_tb .con{display:none;}
.goodsview_tb .con td{background-color:#f9f9f9;padding:30px;text-align:left;line-height:22px;position:relative;}
.goodsview_tb .con td .btn_box{position:absolute;right:30px;top:30px;}
.goodsview_tb .con td .btn_box .btn_w{display:inline-block;width:39px;height:25px;text-align:center;background-color:#fff;border:1px solid #e4e4e4;font-size:11px;color:#ababab;line-height:23px;font-weight:500;}
.goodsview_tb .con td .btn_box .btn_g{display:inline-block;display:inline-block;width:39px;height:25px;text-align:center;line-height:25px;background-color:#a2a2a2;font-size:12px;color:#fff;font-weight:500;margin-left:5px}

.goodsview_acc .acc_header{border-top:2px solid #f2f2f2;margin-top:16px;}
.goodsview_acc .wd_fix{width:100%;display:table}
.goodsview_acc .wd_fix li{/* float:left */display:table-cell;min-height:45px;}
.goodsview_acc .wd_fix li.fix1{width:60px;}
.goodsview_acc .wd_fix li.fix2{width:770px;}
.goodsview_acc .wd_fix li.fix3{width:100px;}
.goodsview_acc .wd_fix li.fix4{width:150px;}
.goodsview_acc .acc_header li{float:left;border-bottom:1px solid #f2f2f2;font-size:12px;color:#5e5e5e;font-weight:500;text-align:center;padding:13px 0;}
.goodsview_acc .acc_body li{border-bottom:1px solid #f2f2f2;text-align:center;font-size:12px;color:#888;padding:13px 0;}
.goodsview_acc .acc_body li.txt_l{text-align:left;}
.goodsview_acc .acc_body li .star{color:#568448;display:inline-block;margin-right:50px;}
.goodsview_acc .acc_body dt{cursor:pointer;}
.goodsview_acc .acc_body dd{background-color:#f9f9f9;padding:30px;text-align:left;line-height:22px;position:relative;border-bottom:1px solid #f2f2f2;display:none;}
.goodsview_acc .acc_body dd.list_none{text-align:center;padding:20px;color:#888;display:block;background-color:#fff;}

.goodsview_acc .acc_body dd .btn_box{position:absolute;right:30px;top:30px;}
.goodsview_acc .acc_body dd .btn_box .btn_w{display:inline-block;width:39px;height:25px;text-align:center;background-color:#fff;border:1px solid #e4e4e4;font-size:11px;color:#ababab;line-height:23px;font-weight:500;}
.goodsview_acc .acc_body dd .btn_box .btn_g{display:inline-block;display:inline-block;width:39px;height:25px;text-align:center;line-height:25px;background-color:#a2a2a2;font-size:12px;color:#fff;font-weight:500;margin-left:5px}

.goodsview_acc .acc_body dd .review_pass{text-align:center;}
.goodsview_acc .acc_body dd .review_pass input{margin:0 5px;height:26px;border:1px solid #ddd;padding-left:7px;}
.goodsview_acc .acc_body dd .review_pass .btn_secret_ok{display:inline-block;height:26px;line-height:26px;padding:0 10px;background-color:#568448;color:#fff;font-size:12;}


.btn_goodsWrite {text-align:right; margin-bottom:60px;}
.btn_goodsWrite a{display:inline-block;width:102px;text-align:center;padding:10px 0;background-color:#568448;font-size:12px;color:#fff;}

.user_location {position:absolute; top:20px; right:0; font-size:11px; color:#bebebe;}
.user_location * {vertical-align:middle;}
.user_location .arrow_img {margin:0 4px;}

/*검색*/
.goodslist_contents_align{font-size:0; line-height:0; padding:20px 0 0;  border-bottom:2px solid #2993d1; height:31px;}
.goodslist_contents_number {text-align:right; margin:-30px 0 30px;}

/* goods_bbs_wirte */
.goods_mask{position:fixed;top:0;left:0;right:0;bottom:0;background:url(../images/b_bg.png) repeat;z-index:100;display:none;}
.goods_board_pop{position:absolute;width:796px;padding:35px;background-color:#fff;z-index:101;top:0;left:50%;margin-left:-398px;display:none;}
.goods_board_pop .title{font-size:32px;color:#444;font-weight:500}
.goods_board_pop .title .fr{margin-top:15px;}
.goods_board_pop table{border-top:2px solid #333;margin-top:40px;width:100%;}
.goods_board_pop th{padding:15px;width:140px;border-bottom:1px solid #ededed;background-color:#f9f9f9;font-size:12px;color:#333;font-weight:500}
.goods_board_pop td{padding:15px 20px;border-bottom:1px solid #ededed;font-size:13px;color:#666;}
.goods_board_pop td input[type="text"], .goods_board_pop td input[type="password"]{height:32px;border:1px solid #ddd;background-color:#f9f9f9;padding-left:15px;color:#666;}
.goods_board_pop td textarea{width:100%;height:250px;border:1px solid #ddd;background-color:#f9f9f9;resize:none;padding:15px;color:#666;}
.goods_board_pop td select{border:1px solid #ededed;height:32px;padding:0 10px;color:#666;}
.goods_board_pop .btn_box{text-align:right;font-size:0;margin-top:17px;}
.goods_board_pop .btn_box a{display:inline-block;width:168px;height:32px;text-align:center;}
.goods_board_pop .btn_box a.btn_w{border:1px solid #333;font-size:13px;color:#333;line-height:30px;}
.goods_board_pop .btn_box a.btn_b{background-color:#333;font-size:13px;color:#fff;line-height:32px;}

/* 공통 */
.paging{text-align:center;margin-top:15px;}
.paging *{vertical-align:middle}
.paging > p{display:inline-block;}
.paging img{float:left;margin-top:-2px}
.paging > p.paging_btn{margin:0 6px;}
.paging_num{padding:0 8px;}
.paging .paging_num a{display:inline-block;width:22px;height:22px;line-height:22px;text-align:center;font-family:'Arial';color:#888;font-size:12px;}
.paging .paging_num strong{display:inline-block;width:22px;height:22px;line-height:22px;text-align:center;font-family:'Arial';font-size:12px;color:#ed731b;border:1px solid #ececec;line-height:21px}

/* 장바구니, 주문 */
#blind {display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:url(../images/b_bg.png) repeat;z-index:99;}

.cartNorder .user_title{font-size:30px;color:#3b3b3b;font-weight:500;line-height:30px;padding-bottom:14px;border-bottom:1px sol}


.dOqhKG .contents .customerCenter > div:first-of-type > div:first-of-type button{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-align-items:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;max-width:332px;height:48px;border-radius:4px;border:solid 1px #75574B;background-color:#fff;text-align:center;font-family:"Noto Sans KR";font-weight:normal;font-family:"Noto Sans KR","Helvetica","Helvetica Neue","Arial","sans-serif";font-size:13px;line-height:20px;text-align:center;-webkit-letter-spacing:0;-moz-letter-spacing:0;-ms-letter-spacing:0;letter-spacing:0;cursor:pointer;width:100%;max-width:100%;}/*!sc*/
.dOqhKG .contents .customerCenter > div:first-of-type > div:first-of-type button:hover{border:solid 1px #937062;background-color:#F4F0EF;}/*!sc*/
.dOqhKG .contents .customerCenter > div:first-of-type > div:first-of-type button:active{border:solid 1px #75574B;background-color:#BF917E;}/*!sc*/
.dOqhKG .contents .customerCenter > div:first-of-type > div:first-of-type button:disabled{border:solid 1px #bdbdbd;background-color:#bdbdbd;cursor:not-allowed;}/*!sc*/
.dOqhKG .contents .customerCenter > div:first-of-type > div:first-of-type button a,.dOqhKG .contents .customerCenter > div:first-of-type > div:first-of-type button span{font-weight:normal;font-family:"Noto Sans KR","Helvetica","Helvetica Neue","Arial","sans-serif";font-size:13px;line-height:20px;text-align:center;-webkit-letter-spacing:0;-moz-letter-spacing:0;-ms-letter-spacing:0;letter-spacing:0;margin-left:4px;}/*!sc*/

.izQONW .productDetailContent .truncate button{width:332px;max-width:332px;height:48px;border-radius:4px;background-color:#75574B;text-align:center;font-family:"Noto Sans KR";color:#fff;font-weight:normal;font-family:"Noto Sans KR","Helvetica","Helvetica Neue","Arial","sans-serif";font-size:16px;line-height:24px;-webkit-letter-spacing:1px;-moz-letter-spacing:1px;-ms-letter-spacing:1px;letter-spacing:1px;text-align:center;font-weight:500;cursor:pointer;width:100%;max-width:100%;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;-webkit-align-items:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;}/*!sc*/
.izQONW .productDetailContent .truncate button:hover{border:solid 1px #75574B;background-color:#75574B;}/*!sc*/
.izQONW .productDetailContent .truncate button:active{border:solid 1px #75574B;background-color:#75574B;color:#fff;}/*!sc*/
.izQONW .productDetailContent .truncate button:disabled{border:solid 1px #bdbdbd;background-color:#bdbdbd;cursor:not-allowed;}/*!sc*/
.izQONW .productDetailContent .truncate button svg{margin-left:4px;}/*!sc*/
.izQONW .productDetailContent .truncate button svg path{stroke:#fff;}/*!sc*/

.bZRViZ button{font-weight:normal;font-family:"Noto Serif KR",serif,Helvetica,"Helvetica Neue",Arial;font-size:14px;line-height:20px;-webkit-letter-spacing:0;-moz-letter-spacing:0;-ms-letter-spacing:0;letter-spacing:0;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-align-items:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;color:#9e9e9e;margin-right:16px;cursor:pointer;}/*!sc*/
.bZRViZ button:last-child{margin-right:0;}/*!sc*/
.bZRViZ button:nth-child(1){font-weight:normal;font-family:"Noto Serif KR",serif,Helvetica,"Helvetica Neue",Arial;font-size:18px;line-height:28px;-webkit-letter-spacing:0;-moz-letter-spacing:0;-ms-letter-spacing:0;letter-spacing:0;font-weight:bold;color:#000;}/*!sc*/
.bZRViZ button:nth-child(1) img{display:none;}/*!sc*/

.jBxVFd .buttons{display:grid;grid-template-columns:1fr 1fr;grid-column-gap:16px;}/*!sc*/
.jBxVFd .buttons .addToCart{max-width:332px;height:48px;border-radius:4px;border:solid 1px #75574B;background-color:#fff;text-align:center;font-family:"Noto Sans KR";font-weight:normal;font-family:"Noto Sans KR","Helvetica","Helvetica Neue","Arial","sans-serif";font-size:13px;line-height:20px;text-align:center;-webkit-letter-spacing:0;-moz-letter-spacing:0;-ms-letter-spacing:0;letter-spacing:0;cursor:pointer;width:100%;}/*!sc*/
.jBxVFd .buttons .addToCart:hover{border:solid 1px #937062;background-color:#F4F0EF;}/*!sc*/
.jBxVFd .buttons .addToCart:active{border:solid 1px #75574B;background-color:#BF917E;}/*!sc*/
.jBxVFd .buttons .addToCart:disabled{border:solid 1px #bdbdbd;background-color:#bdbdbd;cursor:not-allowed;}/*!sc*/
.jBxVFd .buttons .checkout{width:332px;max-width:332px;height:48px;border-radius:4px;background-color:#75574B;text-align:center;font-family:"Noto Sans KR";color:#fff;font-weight:normal;font-family:"Noto Sans KR","Helvetica","Helvetica Neue","Arial","sans-serif";font-size:16px;line-height:24px;-webkit-letter-spacing:1px;-moz-letter-spacing:1px;-ms-letter-spacing:1px;letter-spacing:1px;text-align:center;font-weight:500;cursor:pointer;width:100%;}/*!sc*/
.jBxVFd .buttons .checkout:hover{border:solid 1px #75574B;background-color:#75574B;}/*!sc*/
.jBxVFd .buttons .checkout:active{border:solid 1px #75574B;background-color:#75574B;color:#fff;}/*!sc*/
.jBxVFd .buttons .checkout:disabled{border:solid 1px #bdbdbd;background-color:#bdbdbd;cursor:not-allowed;}/*!sc*/
.jBxVFd .soldout{grid-template-columns:1fr;}/*!sc*/
.jBxVFd .soldout button{width:332px;max-width:332px;height:48px;border-radius:4px;background-color:#75574B;text-align:center;font-family:"Noto Sans KR";color:#fff;font-weight:normal;font-family:"Noto Sans KR","Helvetica","Helvetica Neue","Arial","sans-serif";font-size:16px;line-height:24px;-webkit-letter-spacing:1px;-moz-letter-spacing:1px;-ms-letter-spacing:1px;letter-spacing:1px;text-align:center;font-weight:500;cursor:pointer;width:100%;max-width:100%;}/*!sc*/
.jBxVFd .soldout button:hover{border:solid 1px #75574B;background-color:#75574B;}/*!sc*/
.jBxVFd .soldout button:active{border:solid 1px #75574B;background-color:#75574B;color:#fff;}/*!sc*/
.jBxVFd .soldout button:disabled{border:solid 1px #bdbdbd;background-color:#bdbdbd;cursor:not-allowed;}/*!sc*/
data-styled.g98[id="style__CheckoutButton-tdm8v5-5"]{content:"jBxVFd,"}/*!sc*/

.bjhWSy .anchor button:nth-of-type(2) svg{-webkit-transform:rotate(180deg);-ms-transform:rotate(180deg);transform:rotate(180deg);}/*!sc*/

.jBXLzC .custom-slick-dots li,.jBXLzC .custom-slick-dots button{width:4px !important;height:4px !important;padding:0 !important;margin:0;}/*!sc*/
.jBXLzC .custom-slick-dots li{padding:0 4px !important;}/*!sc*/
.jBXLzC .custom-slick-dots li:last-of-type{padding-right:0 !important;}/*!sc*/
.jBXLzC .custom-slick-dots li button::before{content:none;}/*!sc*/
.jBXLzC .custom-slick-dots li button{border-radius:50%;background-color:#bdbdbd;opacity:1;}/*!sc*/
.jBXLzC .custom-slick-dots .slick-active button{background-color:#F66F58 !important;}/*!sc*/
.jBXLzC .custom-slick-big-dots{position:absolute;cursor:pointer;}/*!sc*/
.jBXLzC .custom-slick-big-dots li,.jBXLzC .custom-slick-big-dots button{width:8px !important;height:8px !important;padding:0 !important;margin:0;}/*!sc*/
.jBXLzC .custom-slick-big-dots li{padding:0 4px !important;}/*!sc*/
.jBXLzC .custom-slick-big-dots li:last-of-type{padding-right:0 !important;}/*!sc*/
.jBXLzC .custom-slick-big-dots li button::before{content:none;}/*!sc*/
.jBXLzC .custom-slick-big-dots li button{border-radius:50%;background-color:#bdbdbd;opacity:1;}/*!sc*/
.jBXLzC .custom-slick-big-dots .slick-active button{background-color:#F66F58 !important;}/*!sc*/
@media (min-width:1024px){.QNUsK .default{display:none;}}/*!sc*/
.QNUsK .default button{width:332px;max-width:332px;height:48px;border-radius:4px;background-color:#75574B;text-align:center;font-family:"Noto Sans KR";color:#fff;font-weight:normal;font-family:"Noto Sans KR","Helvetica","Helvetica Neue","Arial","sans-serif";font-size:16px;line-height:24px;-webkit-letter-spacing:1px;-moz-letter-spacing:1px;-ms-letter-spacing:1px;letter-spacing:1px;text-align:center;font-weight:500;cursor:pointer;width:calc(74.4% + 28px);max-width:calc(74.4% + 28px);margin-right:16px;color:#fff;}/*!sc*/
.QNUsK .default button:hover{border:solid 1px #75574B;background-color:#75574B;}/*!sc*/
.QNUsK .default button:active{border:solid 1px #75574B;background-color:#75574B;color:#fff;}/*!sc*/
.QNUsK .default button:disabled{border:solid 1px #bdbdbd;background-color:#bdbdbd;cursor:not-allowed;}/*!sc*/

button{padding:0;border:0;padding:0;background:none;color:inherit;}/*!sc*/
button:active{color:inherit;}/*!sc*/
button:focus{outline:0;}/*!sc*/
button:disabled{cursor:not-allowed;}/*!sc*/


.slide_anchor{width:1120px;height:36px;margin:0 0 20px;border-bottom:1px solid #555;text-align:center;}.slide_anchor ul{font-size:0;line-height:0;letter-spacing:-4px;}.slide_anchor ul li{display:inline-block;letter-spacing:0;vertical-align:top;}.slide_anchor ul li a{display:block;min-width:280px;height:35px;line-height:35px;margin:0 0 0 -1px;border:1px solid #e8e8e8;border-bottom:none;background:#f6f6f6;color:#888;text-align:center;font-size:12px;}.slide_anchor ul li a:hover{text-decoration:none;background:#f1f1f1;color:#111;}.slide_anchor ul li.on a{position:relative;z-index:1;margin:-4px 0 0 -1px;height:40px;line-height:40px;border:1px solid #555;border-bottom:none;background:#fff;font-weight:700;color:#111;font-size:13px;}.slide_anchor span{display:inline-block;line-height:12px;margin:0 0 0 5px;padding:2px 4px;border-radius:5px;background:#333;color:#fff;font-size:10px;}#prdDetail{margin:50px 0 80px;}#prdDetail .co


    </style>
    