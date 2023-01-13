<!DOCTYPE html>
<html lnag="ko">
    <head>
        <meta charset="UTF-8">
        <title>업주등록</title>
        <link rel="stylesheet" href="css/joing.css">
        <!--script-->
        <script src="js/jquery-3.3.1.min.js"></script>
        
    </head>
    <body>
        <?php
            session_start();
            if(isset($_SESSION["userId"]) || isset($_SESSION["userName"])) {
               $user_id = $_SESSION["userId"];
               $user_name = $_SESSION ["userName"];
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
		$query = $db->query("select store_info_num
							 from store_info as a
							 inner join mem_info as b
							 on a.mem_info_num = b.mem_info_num 
							 where b.mem_info_nickname='{$user_name}'");
		$row = $query->fetch();
		$num = $row["store_info_num"];
		$nickname = $row["mem_info_nickname"];

		if(isset($num)){
?>			
		        <script>
                alert('이미등록된 스토어입니다.');
                window.close();
	 
	            location.href='index.php';
        </script>	
<?php			
		}
?>  
       
        <!-- header_m -->
                    <div id="header_m">

           <a href="index.php" class="logo"><img src="img/logo.png" style="max-width: 100%;"></a>
        </div>

		
        <!-- wrapper -->
        <div id="wrapper">
			
			<a>
            <!-- content-->
            <div id="content">
			<h1 style='text-align: center;'>업주등록</h1>
            <form name="joinform" method="POST" action="enroll.php">
                <!-- ID -->
                <div>
                    <h3 class="join_title">
                        <label for="id">스토어 이름</label>
                    </h3>
                    <span class="box int_id">
                        <input type="text" id="store_name" name="store_name" class="int" maxlength="20">
                    </span>
                    <span class="error_next_box"></span>
                </div>

                <!-- PW1 -->
                <div>
                    <h3 class="join_title"><label for="pswd1">스토어 전화번호</label></h3>
                    <span class="box int_pass">
                        <input type="text" id="store_call" name="store_call" class="int" maxlength="20">
                    </span>
                    <span class="error_next_box">필수 정보입니다.</span>
                </div>

                <!-- PW2 -->
                <div>
                    <h3 class="join_title"><label for="pswd2">스토어 주소</label></h3>
                    <span class="box int_pass_check">
                        <input type="text" id="store_addr" name = "store_addr" class="int" maxlength="20">
                    </span>
                    <span class="error_next_box"></span>
                </div>

                <!-- NAME -->
                <div>
                    <h3 class="join_title"><label for="name">사업자등록번호</label></h3>
                    <span class="box int_name">
                        <input type="text" id="store_regist" name="store_regist" class="int" maxlength="20">
                    </span>
                    <span class="error_next_box"></span>
                </div>
               


                <!-- JOIN BTN-->
                <div class="btn_area">
                    <input type="submit" id="btnJoin" value="등록하기">
                   
                </div>
               </form>

                

            </div> 
            <!-- content-->

        </div> 
        <!-- wrapper -->
    <script src="js/joins.js"></script>
        
        <br>
        <!--footer-->
       <footer>
      
       </footer>
     
   </div> 
</body>
</html>