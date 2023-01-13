<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0, maximum-scale=1.0">
    <title>Tasty & Recipe</title>
    <link rel="stylesheet" href="css/reciperegis.css">
    <!--font-->
    <link rel="stylesheet" type="
    text/css" href="https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css">
    <link rel="stylesheet" href="css/slick.css">
	    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">

    <!--script-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/scrolla.jquery.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/script.js"></script>
    
    <link rel="stylesheet" href="css/upload.css">


    
</head>
<body>
   
       <!--body-->
       <body>
        <div class="event1">
          
        </div>
<!--back end-->




<div class="abcd" style="width:1500px; height:200px;">
<h2 class="tit" style="margin-top: 100px;">레시피</h2><br><br>
</div>
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
        <script>
                alert('로그인 후 이용 하실 수 있습니다.');
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
          <a href="index.php" class="logo"><img src="img/logo.png" style="max-width: 100%;"></a>
          <nav>
             <a href="#" class="close"><span class="lnr lnr-cross"></span></a>
              <ul class="gnb">
				  <li><a href="index.php?#about">소개</a></li>
                  <li><a href="recipe_write.php">레시피</a></li>
                  <li><a href="store_list.php">스토어</a></li>
                  <li><a href="free.php">커뮤니티</a></li>
                  <li><a href="event.php">이벤트</a></li>
				  <li><a href="my.php">MY</a></li>
				  
              </ul>
          </nav> 
       </header>

   
       <!--body-->
       <body>

<!--back end-->
<?php

$recipe_title = "";
$recipe_introduce = "";
$recipe_thum = "";

$sub_img1 = "";
$sub_img2 = "";
$sub_img3 = "";
$sub_img4 = "";

$i_name1 = "";
$i_name2 = "";
$i_name3 = "";
$i_name4 = "";


$i_num_1 = "";
$i_num_2 = "";
$i_num_3 = "";
$i_num_4 = "";


 
$num = $_REQUEST['num'];
$num = ($num != null && $num > 0) ? $num : 0;




if ($num > 0) {
    require("db_connect.php");
	$query = $db->query("select * from recipe_info where recipe_info_num = {$num}");
    $row = $query->fetch();

    $action = "recipe_change.php?num=$num";

    $recipe_title = $row['recipe_info_title'];
    $recipe_introduce = $row['recipe_info_introduce'];
    $recipe_thum = $row['recipe_info_thum'];

    $query = $db->query("select * from info_basic where recipe_info_num = {$num}");
    $row = $query->fetch();
    $Ingre_id = $row['info_basic_num'];

    $query = $db->query("select * from info_basic where info_basic_num = {$Ingre_id}");
    $row = $query->fetch();
	
    $i_name1 = $row['ibasic_name_1'];
    $i_name2 = $row['ibasic_name_2'];
    $i_name3 = $row['ibasic_name_3'];
    $i_name4 = $row['ibasic_name_4'];


    $i_num_1 = $row['ibasic_num_1'];
    $i_num_2 = $row['ibasic_num_2'];
    $i_num_3 = $row['ibasic_num_3'];
    $i_num_4 = $row['ibasic_num_4'];



}

?>
<form action="<?=$action?>" method="POST"  enctype="multipart/form-data">

       <form name="insFrm" id="insFrm" method="post" enctype="multipart/form-data">

<script>
$(document).ready(function() {
    bindEvent(document.getElementById("q_main_file"), 'change', handlePhotoFiles);
	bindEvent(document.getElementById("q_video_file"), 'change', handlePhotoFiles);
    for (var i=1; i<=4; i++) {
        bindEvent(document.getElementById("q_work_file_"+i), 'change', handlePhotoFiles);
    }
    bindEvent(document.getElementById("multifile_1"), 'change', handleMultiPhoto);
	bindEvent(document.getElementById("multifile_2"), 'change', handleMultiPhoto);
    addMaterialGroup('재료',[]);addStep();

	$('#divAutoMaterialModal').on('show.bs.modal',function(e) {
		var idx = $(e.relatedTarget).data('group_idx');
		var title = $("#material_group_title_"+idx).val();
		if ($.trim(title) == '') {
			title = '재료/양념';
		}
		$("#auto_material_title").attr('group_idx',idx);
		$("#auto_material_title").html('['+title+'] 한번에 넣기');
    });
	$("#btnAutoMaterialConfirm").click(function() {
		var idx = $("#auto_material_title").attr('group_idx');
		var str = $.trim($("#q_auto_material").val());
		if (str == '') {
			alert("내용을 입력하세요.");
			$("#q_auto_material").focus();
		} else {
			if (idx != '') {
                setAutoMaterial(idx,str);
            }
		}
	});

        	//동영상 사진 관련 /////////////////////////////////////
    $("#cok_video_url").blur(function() {
        if ($(this).val() != '' && $(this).val() != $(this).attr('prev_url')) {
            if ($(this).val().indexOf('http://') > -1 || $(this).val().indexOf('https://') > -1) {
                getVideoThumb($.trim($(this).val()));
            } else {
                delVideoPhoto();
            }
        } else if ($.trim($(this).val()) == '' || ($(this).val().indexOf('http://') < 0 && $(this).val().indexOf('https://') < 0)) {
            delVideoPhoto();
        }
    });
    $('#viewVideoDivModal').on('hidden.bs.modal', function () {
        $('#viewVideoModalCont').html('');
    });

    $(".btn-lineup").tooltip({
        'placement': 'top',
        'container': $('.recipe_regi'),
        'title': '드래그하면 순서를 변경할 수 있습니다.'
    });

	$("#divWorkArea").sortable({
        cursor: 'move',
        handle: $('.complete_pic'),
        helper: function(e, ui){
			/* 드래그 시, tr의 width 보존 */
            ui.children().each(function() {
                $(this).width($(this).width());
				$(this).height($(this).height());
            });
            return ui;
        },
		start: function(e, ui){
	    },
        stop: function(e,ui) {
        }
    }).disableSelection();
});
var isSubmit = false;
function doSubmit(q_mode)
{
	if (isGettingThumb) {
        alert("동영상 썸네일을 가져오는 중입니다. 잠시만 기다리세요.");
        return;
    }
    $("#q_mode").val(q_mode);

    chkResult = validateRecipeForm(q_mode);
    if (!chkResult) {
        return isSubmit = false;
    }
    if (q_mode == 'save') {
        if (confirm("저장하시겠습니까?")) {
            isSubmit = true;
            $("#insFrm").submit();
        }
        else {
            isSubmit = false;
        }
    } else if (q_mode == 'save_preview') {
        if (confirm("미리보기를 하려면 저장하셔야 합니다. 저장하시겠습니까?")) {
            isSubmit = true;
            $("#insFrm").submit();
        }
        else {
            isSubmit = false;
        }
    } else if (q_mode == 'save_public') {
				var msg = '레시피 공개 후, 리스트 및 검색에 노출되는 데는 하루 정도의 시간이 소요됩니다.\n\n레시피를 공개하시겠습니까?';
		        if (confirm(msg)) {
            isSubmit = true;
            $("#insFrm").submit();
        }
        else {
            isSubmit = false;
        }
    } else if (q_mode == 'save_work' || q_mode == 'save_confirm') {
        isSubmit = true;
        $("#insFrm").submit();
    } else {
        isSubmit = false;
    }
}
function validateRecipeForm(q_mode) {
    if ($.trim($("#cok_title").val()) == '') {
        alert('레시피 제목을 입력해 주세요.');
        $("#cok_title").focus();
        return isSubmit = false;
    }

    if (q_mode != 'save') {
        if ($("#main_photo").val() == '') {
            alert('대표사진을 선택해 주세요.');
            return isSubmit = false;
        }
        if ($.trim($("#cok_intro").val()) == '') {
            alert('요리소개 내용을 입력해 주세요.');
            $("#cok_intro").focus();
            return isSubmit = false;
        }
        if ($("#cok_sq_category_1").val() == '') {
            alert('방법별 카테고리를 선택해 주세요.');
            $("#cok_sq_category_1").focus();
            return isSubmit = false;
        }
        if ($("#cok_sq_category_2").val() == '') {
            alert('상황별 카테고리를 선택해 주세요.');
            $("#cok_sq_category_2").focus();
            return isSubmit = false;
        }
        if ($("#cok_sq_category_3").val() == '') {
            alert('재료별 카테고리를 선택해 주세요.');
            $("#cok_sq_category_3").focus();
            return isSubmit = false;
        }
        if ($("#cok_sq_category_4").val() == '') {
            alert('종류별 카테고리를 선택해 주세요.');
            $("#cok_sq_category_4").focus();
            $("#btnAllCategory").trigger('click');

            return isSubmit = false;
        }
		if ($("#is_tv_recipe").prop('checked')) {

		} else {
			if ($("#cok_portion").val() == '') {
                alert('요리인원 선택해 주세요.');
                $("#cok_portion").focus();
                return isSubmit = false;
            }
			if ($("#cok_time").val() == '') {
                alert('요리시간을 선택해 주세요.');
                $("#cok_time").focus();
                return isSubmit = false;
            }
            if ($("#cok_degree").val() == '') {
                alert('난이도를 선택해 주세요.');
                $("#cok_degree").focus();
                return isSubmit = false;
            }
		}

        var resource_cnt = 0;
		$("#divResourceArea [id^=liResource_]").each(function(i) {
            var step = $(this).prop('id').replace('liResource_','');
            if ($.trim($("#cok_resource_nm_" + step).val()) != '') {
                resource_cnt++;
            }
        });
		var invalid_resource = false;
        $("[id^=cok_material_nm_]").each(function() {
			if ($.trim($(this).val()) != '') {
                resource_cnt++;
            }
			var idx = $(this).prop('id').replace('cok_material_nm_','');
			if ($(this).val().indexOf('[') > -1 || $(this).val().indexOf(']') > -1) {
				invalid_resource = true;
				$(this).focus();
				return false;
			}
			if ($("#cok_material_amt_"+idx).val().indexOf('[') > -1 || $("#cok_material_amt_"+idx).val().indexOf(']') > -1) {
				invalid_resource = true;
				$("#cok_material_amt_"+idx).focus();
                return false;
            }
		});
		if (invalid_resource) {
			alert('요리재료에 [ 또는 ] 문자를 입력할 수 없습니다.');
			return isSubmit = false;
		}
        if (resource_cnt < 1) {
            alert('요리재료는 최소 1개 이상이어야 합니다.');
			if ($("#divResourceArea [id^=liResource_]").length > 0) {
				$("#divResourceArea > li:last-child").find('input')[0].focus();
			} else {
				$("[id^=cok_material_nm_]:first").focus();
			}
            return isSubmit = false;
        }

        var step_cnt = 0;
        var invalid_step = 0;
        $("#divStepArea [id^=divStepItem_]").each(function(i) {
            var step = $(this).prop('id').replace('divStepItem_','');
            if ($("#step_photo_"+step).val() != '' && $.trim($("#step_text_" + step).val()) == '') {
                alert("내용을 입력하세요.");
                $("#step_text_" + step).focus();
                invalid_step = step;
                return false;
            } else if ($.trim($("#step_text_" + step).val()) != '') {
                step_cnt++;
            }
        });
        if (invalid_step > 0) {
            return isSubmit = false;
        }
        if (step_cnt < 3) {
            alert('요리순서는 최소 3개 이상이어야 합니다.');
            $("#divStepArea textarea").last().focus();
            return isSubmit = false;
        }

    }
    return true;
}
function doDelete() {
    if (confirm("레시피를 삭제하시겠습니까?")) {
        isSubmit = true;
        $("#insFrm [name=q_mode]").val('delete');
        $("#insFrm").submit();
    }
    else {
        isSubmit = false;
    }
}
function addRecipe(json) {

    if (json.length) {
        var idx = 0;
        $("[id^=trRecipeRow_]").each (function() {
            var num = parseInt($(this).prop('id').replace('trRecipeRow_',''),10);
            idx = Math.max(idx,num);
        });

        var str = '';
        for (var i=0; i<json.length; i++) {

            if ($("[name='recipe_no[]'][value='"+json[i]['recipe_no']+"']").length) {
                alert('['+$("<div>").text(json[i]['recipe_nm']).html()+']는 이미 추가된 레시피 입니다.');
                continue;
            }

            idx++;

            str += '<tr id="trRecipeRow_'+idx+'" class="sortable_row">';
            str += '<input type="hidden" name="rel_cok_sq_board[]" value="'+json[i]['recipe_no']+'">';
            var title_width = $("#tableRecipeList").width() - 60 - 80 - 100 - 80 - 5;
            //alert(title_width);
            if (json[i]['recipe_no']) {
                str += '<td class="ac sortable_col" style="height:39px;width:120px;"><div class="sortable_row_class">' + json[i]['recipe_no'] + '</div></td>';
            } else {
                str += '<td class="sortable_col" style="height:39px;width:120px;"></td>';
            }
            if (json[i]['str_reg_type']) {
                str += '<td class="ac" style="height:39px;width:120px;">' + json[i]['str_reg_type'] + '</td>';
            } else {
                str += '<td class="ac" style="height:39px;width:120px;"></td>';
            }
            if (json[i]['thumb'] != '') {
                str += '<td class="ac" style="width:60px"><img src="' + json[i]['thumb'] + '" style="width:32px;height:32px"></td>';
            } else {
                str += '<td style="width:60px"></td>';
            }
            if (json[i]['recipe_no']) {
                str += '<td class="al" style="width:'+title_width+'px;"><a href="javascript:EAD.showDialog({\'title\':\'레시피 정보\',\'url\':\'/admin/recipe/view_recipe.html?cok_sq_board='+json[i]['recipe_no']+'\',\'width\':1300,\'modal\':false,\'fullsize\':true});">' + json[i]['recipe_nm'] + '</a></td>';
            } else {
                str += '<td class="al" style="width:'+title_width+'px;">' + json[i]['recipe_nm'] + '</td>';
            }
            str += '<td style="width:80px"><a href="javascript:delRecipe('+idx+');" role="button" class="btn btn-xs btn-default">삭제</td>';
            str += '</tr>';
        }
        $("#trNoRecipe").hide();
        $(str).appendTo("#tbodyRecipeList");

        $("#tbodyRecipeList").sortable({
            cursor: 'move',
            handle: $('.sortable_col'),
            helper: function(e, ui){
                /* 드래그 시, tr의 width 보존 */
                ui.children().each(function() {
                    $(this).width($(this).width());
                });
                return ui;
            },
            stop: function(e,ui) {

            }
        }).disableSelection();

        $(".sortable_row_class").tooltip({
            'placement': 'top',
            'container': $('#tableRecipeList'),
            'title': '드래그하면 순서를 변경할 수 있습니다.'
        });

    }

}
function delRecipe(idx) {
    $("#trRecipeRow_"+idx).remove();
    if (!$("[id^=trRecipeRow_]").length) {
        $("#trNoRecipe").show();
    }
}
function handleMultiPhoto(evt) {
    var files = evt.target.files; // FileList object
    var max_step = 0;
	var file_gubun = $(evt.target).attr('file_gubun');
	var holder_cnt = 0;
	var json_holder = [];
	var json_occupy = [];

	$("#"+(file_gubun == 'step' ? 'divStepArea' : 'divWorkArea') + " [id^="+file_gubun+"_photo_]").each(function() {
		var temp_step = parseInt($(this).prop('id').replace(file_gubun+'_photo_',''),10);
        if ($(this).val() == '') {
			json_holder.push(temp_step);
        }
		max_step = Math.max(max_step,temp_step);
    });
	for (var i = json_holder.length; i < files.length; i++) {
       addStep();
	   max_step = max_step + 1;
	   json_holder.push(max_step);
	}

	for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (!file.type.match('image')) continue; //Only pics
        var reader = new FileReader();
		readerOnloadPhoto(reader,file,file_gubun,json_holder[i]);
		//step_num++;
    }
}

function readerOnloadPhoto(reader,file,file_gubun,step_num)
{
	if (file_gubun == 'step') {
        $('#divStepPhotoBox_' + step_num).html('<div class="text-center" style="margin:50px 0 0 0;width:160px"><span class="fa fa-spinner fa-spin fa-2x"></span></div>');
    } else if (file_gubun == 'work') {
        $('#divWorkPhotoBox_' + step_num).html('<div class="text-center" style="margin:50px 0 0 0"><span class="fa fa-spinner fa-spin fa-2x"></span></div>');
    }
    reader.onload = function (e) {

        var finalFile = e.target.result;
        var finalName = file.name;

        var img = new Image();
        img.src = reader.result;
        img.onload = function () {

            $.ajax({
				beforeSend: function(xhr){
                    xhr.setRequestHeader('Content-Type', 'canvas/upload');
                },
                type: "POST",
                url: "/common/upload_photo.html?file_gubun=" + file_gubun + "&id=" + step_num,
                data: "canvasData="+finalFile,
                dataType: "json",
                cache: "false",
				async: false,
                processData: false,
                success: function(json) {
                    if(json['result'] == "SUCCESS") {
						if (json['file_gubun'] == 'step') {
						    setStepPhoto('1', json['url'], '', json['id']);
						} else if (json['file_gubun'] == 'work') {
						    setWorkPhoto('1', json['url'], '', json['id']);
						}
                    } else {
                        alert("처리에 실패하였습니다.");
                    }
                },
                error: function (request,status,error) {
                    //alert('오류가 발생하였습니다.');
                    alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
            });
        }
    }
    reader.readAsDataURL(file);
}

$(function() {

    var cache = {};
    $("#mySingleFieldTags").tagit({
        singleField: true,
        singleFieldNode: $('#mySingleFieldTags'),
        singleFieldDelimiter: ',',
        allowSpaces: true,
        afterTagAdded : function(event, ui) {
            // limit length
            var tArr = $("#mySingleFieldTags").tagit("assignedTags");
            if(tArr.length > 10)
            {
                alert('태그는 10개까지만 작성이 가능합니다.');
                $("#mySingleFieldTags").tagit("removeTagByLabel", tArr[tArr.length - 1]);
            }
        },
        autocomplete : {
            //minLength : 2,
            source: function( request, response ) {
                var term = request.term;
                if ( term in cache ) {
                    response( cache[ term ] );
                    return;
                }
                $.getJSON( "/util/autocomplete.html?q_mode=tag", request, function( data, status, xhr ) {
                    cache[ term ] = data;
                    response( data );
                });
            }
        }
    });
});

</script>

<div class="container recipe_regi">
    <div class="regi_center">
    <div class="regi_title">레시피 등록
    	
	</div>
    <div class="cont_box pad_l_60">
      <div id="divMainPhotoUpload" class="cont_pic2">
        <input type="hidden" name="main_photo" id="main_photo" value="">
        <input type="hidden" name="new_main_photo" id="new_main_photo" value="">
		<input type="hidden" name="del_main_photo" id="del_main_photo" value="">
        <div style="position:absolute;left:-3000px"><input type="file" name="q_main_file" id="q_main_file" file_gubun="main" accept="jpeg,png,gif" style="display:;width:0px;height:0px;font-size:0px;" text=""></div>
        <!-- 대표이미지 등록 -->
	  <div id="divStepItem_1" class="step">
			<label for="mainImg7">
                <img id="mainPreview7" src="https://recipe1.ezmember.co.kr/img/pic_none2.gif" style="width : 300px; height : 300px;">
             </label>
              <input type="file" id="mainImg7" name="thum_img" accept=".png, .jpg" style="width: 0; height : 0 ; overflow : hidden;"> 
			  
					<script type="text/javascript">
					
								/* main_img */
					function readImage7(input) {
						if (input.files && input.files[0]) {
							const reader = new FileReader();
							
							reader.onload = (e) => {
								const previewImage = document.getElementById('mainPreview7');
								previewImage.src = e.target.result;
							}
							reader.readAsDataURL(input.files[0]);
						}
					}

					document.getElementById('mainImg7').addEventListener('change', (e) => {
						readImage7(e.target);
					})
					</script>
			
            <div id="divStepBtn_1" class="step_btn" style="display: none;">
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-up moveUp"></span></a>
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-down moveDown"></span></a>
                <a href="javascript:adjustStep(1)"><b>맞춤</b></a>
                <a href="javascript:addStep(1)"><span class="glyphicon glyphicon-plus"></span></a>
                <a href="javascript:delStep(1)"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div style="width:580px;border:1px;margin:5px 200px 5px;">
          <div style="padding:5px;">
            
          </div>
            </div>

          </div>
      </div>
      <div class="cont_line">
		<p class="cont_tit4">레시피 제목</p>
		<input type="text" name="recipe_title" id="cok_title" value="" class="form-control" placeholder="예) 소고기 미역국 끓이기" style="width:610px; ">
	  </div>
      <div class="cont_line pad_b_25">
		<p class="cont_tit4">요리소개</p>
		<textarea name="recipe_introduce" id="cok_intro" class="form-control step_cont" placeholder="짧은 요리 소개" style="height:100px; width:610px; resize:none;">
		</textarea>
      </div>

	  <div class="cont_line pad_b_25"><p class="cont_tit4">동영상</p>
    	  <input type="hidden" name="video_photo" id="video_photo" value="">
          <input type="hidden" name="new_video_photo" id="new_video_photo" value="">
          <input type="hidden" name="del_video_photo" id="del_video_photo" value="1">
		  <input type="hidden" name="cok_video_src" id="cok_video_src" value="">
		  <textarea name="cok_video_url" id="cok_video_url" class="form-control step_cont" prev_url="" placeholder="동영상이 있으면 주소를 입력하세요.(Youtube,네이버tvcast,다음tvpot 만 가능) 예)http://youtu.be/lA0Bxo3IZmM" style="height:100px; width:380px; resize:none;"></textarea>
		  <div style="position:absolute;left:-3000px"><input type="file" name="q_video_file" id="q_video_file" file_gubun="video" accept="jpeg,png,gif" style="display:;width:0px;height:0px;font-size:0px;" text=""></div>
		  <div id="divVideoPhotoBox" is_over="0" class="thumb_m"><img id="videoPhotoHolder" src="https://recipe1.ezmember.co.kr/img/pic_none5.gif" style="width: 178px; height: 100px;"></div>
	  </div>

      
    </div>
    <!-- 필수재료 추가 -->
    <div class="cont_box pad_l_60">
    <input type="file" name="file" id="multifile_1" file_gubun="step" style="display:none;" multiple="">
      <div class="cont_box pad_l_60">
        <span class="guide mag_b_15" style="width:100%;">재료가 남거나 부족하지 않도록 정확한 계량정보를 적어주세요.</span>
		<div class="mag_b_25 ui-sortable" id="divMaterialGroupArea">
			<li id="liMaterialGroup_1">
				<p class="cont_tit6 st2 mag_r_15">
					<input type="text" name="material_group_title_1" id="material_group_title_1" value="필수재료" class="form-control" style="font-weight:bold;font-size:18px;width:210px;">
						<span class="cont_tit_btn">
				</p>
				<ul id="divMaterialArea_1" class="ui-sortable">
					<li id="liMaterial_1_1">
					<li id="liMaterial_1_3">
						<a href="#" class="btn-lineup" data-original-title="" title=""></a>
						<input type="text" name="e_name_1" id="cok_material_nm_1_3" class="form-control" style="width:330px;" placeholder="예) 참기름">
						<input type="text" name="e_num_1" id="cok_material_amt_1_3" class="form-control" style="width:280px;" placeholder="예) 1T">
						<a id="btnMaterialDel_1_3" href="javascript:delMaterial(1,3)" class="btn-del" style="display: none;"></a>
					</li>
					<li id="liMaterial_1_4">
						<a href="#" class="btn-lineup"></a>
						<input type="text" name="e_name_2" id="cok_material_nm_1_4" class="form-control" style="width:330px;" placeholder="예) 소금"><input type="text" name="e_num_2" id="cok_material_amt_1_4" class="form-control" style="width:280px;" placeholder="예) 2t">
						<a id="btnMaterialDel_1_4" href="javascript:delMaterial(1,4)" class="btn-del" style="display: none;"></a>
					</li>
					<li id="liMaterial_1_5">
						<a href="#" class="btn-lineup"></a>
						<input type="text" name="e_name_3" id="cok_material_nm_1_5" class="form-control" style="width:330px;" placeholder="예) 고추가루 약간">
						<input type="text" name="e_num_3" id="cok_material_amt_1_5" class="form-control" style="width:280px;" placeholder="예) ">
						<a id="btnMaterialDel_1_5" href="javascript:delMaterial(1,5)" class="btn-del" style="display: none;"></a>
					</li>
					<li id="liMaterial_1_6"><a href="#" class="btn-lineup"></a>
						<input type="text" name="e_name_4" id="cok_material_nm_1_6" class="form-control" style="width:330px;" placeholder="예) 돼지고기">
						<input type="text" name="e_num_4" id="cok_material_amt_1_6" class="form-control" style="width:280px;" placeholder="예) 300g">
						<a id="btnMaterialDel_1_6" href="javascript:delMaterial(1,6)" class="btn-del" style="display: none;"></a>
					</li>
					<li id="liMaterial_1_6"><a href="#" class="btn-lineup"></a>
						<input type="text" name="e_name_5" id="cok_material_nm_1_6" class="form-control" style="width:330px;" placeholder="예) 돼지고기">
						<input type="text" name="e_num_5" id="cok_material_amt_1_6" class="form-control" style="width:280px;" placeholder="예) 300g">
						<a id="btnMaterialDel_1_6" href="javascript:delMaterial(1,6)" class="btn-del" style="display: none;"></a>
					</li>					
					<li id="liMaterial_1_6"><a href="#" class="btn-lineup"></a>
						<input type="text" name="e_name_6" id="cok_material_nm_1_6" class="form-control" style="width:330px;" placeholder="예) 돼지고기">
						<input type="text" name="e_num_6" id="cok_material_amt_1_6" class="form-control" style="width:280px;" placeholder="예) 300g">
						<a id="btnMaterialDel_1_6" href="javascript:delMaterial(1,6)" class="btn-del" style="display: none;"></a>
					</li>					
				</ul>
				</li>
			</div>	
					

        <div class="noti">※ 양념, 양념장, 소스, 드레싱, 토핑, 시럽, 육수 밑간 등으로 구분해서 작성해주세요.
            
        </div>

    </div>
	<!-- 기본재료 추가 -->
      <div class="cont_box pad_l_60">
        <span class="guide mag_b_15" style="width:100%;">재료가 남거나 부족하지 않도록 정확한 계량정보를 적어주세요.</span>
		<div class="mag_b_25 ui-sortable" id="divMaterialGroupArea">
			<li id="liMaterialGroup_1">
				<p class="cont_tit6 st2 mag_r_15">
					<input type="text" name="material_group_title_1" id="material_group_title_1" value="기본재료" class="form-control" style="font-weight:bold;font-size:18px;width:210px;">
						<span class="cont_tit_btn">
				</p>
				<ul id="divMaterialArea_1" class="ui-sortable">
					<li id="liMaterial_1_1">
					<li id="liMaterial_1_3">
						<a href="#" class="btn-lineup" data-original-title="" title=""></a>
						<input type="text" name="b_name_1" id="cok_material_nm_1_3" class="form-control" style="width:330px;" placeholder="예) 참기름">
						<input type="text" name="b_num_1" id="cok_material_amt_1_3" class="form-control" style="width:280px;" placeholder="예) 1T">
						<a id="btnMaterialDel_1_3" href="javascript:delMaterial(1,3)" class="btn-del" style="display: none;"></a>
					</li>
					<li id="liMaterial_1_4">
						<a href="#" class="btn-lineup"></a>
						<input type="text" name="b_name_2" id="cok_material_nm_1_4" class="form-control" style="width:330px;" placeholder="예) 소금"><input type="text" name="b_num_2" id="cok_material_amt_1_4" class="form-control" style="width:280px;" placeholder="예) 2t">
						<a id="btnMaterialDel_1_4" href="javascript:delMaterial(1,4)" class="btn-del" style="display: none;"></a>
					</li>
					<li id="liMaterial_1_5">
						<a href="#" class="btn-lineup"></a>
						<input type="text" name="b_name_3" id="cok_material_nm_1_5" class="form-control" style="width:330px;" placeholder="예) 고추가루 약간">
						<input type="text" name="b_num_3" id="cok_material_amt_1_5" class="form-control" style="width:280px;" placeholder="예) ">
						<a id="btnMaterialDel_1_5" href="javascript:delMaterial(1,5)" class="btn-del" style="display: none;"></a>
					</li>
					<li id="liMaterial_1_6"><a href="#" class="btn-lineup"></a>
						<input type="text" name="b_name_4" id="cok_material_nm_1_6" class="form-control" style="width:330px;" placeholder="예) 돼지고기">
						<input type="text" name="b_num_4" id="cok_material_amt_1_6" class="form-control" style="width:280px;" placeholder="예) 300g">
						<a id="btnMaterialDel_1_6" href="javascript:delMaterial(1,6)" class="btn-del" style="display: none;"></a>
					</li>
					<li id="liMaterial_1_6"><a href="#" class="btn-lineup"></a>
						<input type="text" name="b_name_5" id="cok_material_nm_1_6" class="form-control" style="width:330px;" placeholder="예) 돼지고기">
						<input type="text" name="b_num_5" id="cok_material_amt_1_6" class="form-control" style="width:280px;" placeholder="예) 300g">
						<a id="btnMaterialDel_1_6" href="javascript:delMaterial(1,6)" class="btn-del" style="display: none;"></a>
					</li>					
					<li id="liMaterial_1_6"><a href="#" class="btn-lineup"></a>
						<input type="text" name="b_name_6" id="cok_material_nm_1_6" class="form-control" style="width:330px;" placeholder="예) 돼지고기">
						<input type="text" name="b_num_6" id="cok_material_amt_1_6" class="form-control" style="width:280px;" placeholder="예) 300g">
						<a id="btnMaterialDel_1_6" href="javascript:delMaterial(1,6)" class="btn-del" style="display: none;"></a>
					</li>					
				</ul>
				</li>
			</div>	
					

        <div class="noti">※ 양념, 양념장, 소스, 드레싱, 토핑, 시럽, 육수 밑간 등으로 구분해서 작성해주세요.
        </div>
    </div>



	<!--/cont_box-->
    <div class="cont_box pad_l_60">
      <input type="file" name="file" id="multifile_1" file_gubun="step" style="display:none;" multiple="">
      <p class="cont_tit3">요리순서
    	
      </p>
	  <span class="guide mag_b_15"><b>요리의 맛이 좌우될 수 있는 중요한 부분은 빠짐없이 적어주세요.</b><br>
		예) 10분간 익혀주세요 ▷ 10분간 약한불로 익혀주세요.<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;마늘편은 익혀주세요 ▷ 마늘편을 충분히 익혀주셔야 매운 맛이 사라집니다.<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;꿀을 조금 넣어주세요 ▷ 꿀이 없는 경우, 설탕 1스푼으로 대체 가능합니다.
	  </span>

      
      <div id="divStepArea" class="ui-sortable">
	  <div id="divStepItem_1" class="step">
            <p id="divStepNum_1" class="cont_tit2_1 ui-sortable-handle" style="cursor:pointer" data-original-title="" title="">Step1</p>
            <div id="divStepText_1" style="display:inline-block">
                <textarea name="method_text_1" id="step_text_1" class="form-control step_cont" placeholder="예) 소고기는 기름기를 떼어내고 적당한 크기로 썰어주세요." style="height:160px; width:430px; resize:none;"></textarea>
            </div>
			<label for="mainImg">
                <img id="mainPreview" src="https://recipe1.ezmember.co.kr/img/pic_none2.gif" style="width : 160px; height : 160px;">
             </label>
              <input type="file" id="mainImg" name="method_img_1" accept=".png, .jpg" style="width: 0; height : 0 ; overflow : hidden;"> 
			  
					<script type="text/javascript">
					
								/* main_img */
					function readImage(input) {
						if (input.files && input.files[0]) {
							const reader = new FileReader();
							
							reader.onload = (e) => {
								const previewImage = document.getElementById('mainPreview');
								previewImage.src = e.target.result;
							}
							reader.readAsDataURL(input.files[0]);
						}
					}

					document.getElementById('mainImg').addEventListener('change', (e) => {
						readImage(e.target);
					})
					</script>
			
            <div id="divStepBtn_1" class="step_btn" style="display: none;">
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-up moveUp"></span></a>
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-down moveDown"></span></a>
                <a href="javascript:adjustStep(1)"><b>맞춤</b></a>
                <a href="javascript:addStep(1)"><span class="glyphicon glyphicon-plus"></span></a>
                <a href="javascript:delStep(1)"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div style="width:580px;border:1px;margin:5px 200px 5px;">
          <div style="padding:5px;">
            
          </div>
            </div>

          </div>
		  <div id="divStepItem_2" class="step">
            <p id="divStepNum_2" class="cont_tit2_1" style="cursor:pointer" data-original-title="" title="">Step2</p>
            <div id="divStepText_2" style="display:inline-block">
                <textarea name="method_text_2" id="step_text_2" class="form-control step_cont" placeholder="예) 준비된 양념으로 먼저 고기를 조물조물 재워 둡니다." style="height:160px; width:430px; resize:none;"></textarea>
            </div>
			
			
			<label for="mainImg2">
                <img id="mainPreview2" src="https://recipe1.ezmember.co.kr/img/pic_none2.gif" style="width : 160px; height : 160px;">
             </label>
              <input type="file" id="mainImg2" name="method_img_2" accept=".png, .jpg" style="width: 0; height : 0 ; overflow : hidden;"> 
			  
			<script type="text/javascript">
			
						/* main_img */
			function readImage2(input) {
				if (input.files && input.files[0]) {
					const reader = new FileReader();
					
					reader.onload = (e) => {
						const previewImage = document.getElementById('mainPreview2');
						previewImage.src = e.target.result;
					}
					reader.readAsDataURL(input.files[0]);
				}
			}

			document.getElementById('mainImg2').addEventListener('change', (e) => {
				readImage2(e.target);
			})
			</script>
			
            <div id="divStepBtn_2" class="step_btn" style="display: none;">
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-up moveUp"></span></a>
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-down moveDown"></span></a>
                <a href="javascript:adjustStep(2)"><b>맞춤</b></a>
                <a href="javascript:addStep(2)"><span class="glyphicon glyphicon-plus"></span></a>
                <a href="javascript:delStep(2)"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div style="width:580px;border:1px;margin:5px 200px 5px;">
          <div style="padding:5px;">
             

             
          </div>
            </div>

          </div>
		  <div id="divStepItem_3" class="step">
            <p id="divStepNum_3" class="cont_tit2_1" style="cursor:pointer" data-original-title="" title="">Step3</p>
            <div id="divStepText_3" style="display:inline-block">
                <textarea name="method_text_3" id="step_text_3" class="form-control step_cont" placeholder="예) 그 사이 양파와 버섯, 대파도 썰어서 준비하세요." style="height:160px; width:430px; resize:none;"></textarea>
            </div>
			<label for="mainImg3">
                <img id="mainPreview3" src="https://recipe1.ezmember.co.kr/img/pic_none2.gif" style="width : 160px; height : 160px;">
             </label>
              <input type="file" id="mainImg3" name="method_img_3" accept=".png, .jpg" style="width: 0; height : 0 ; overflow : hidden;"> 
			  
			<script type="text/javascript">
			
						/* main_img */
			function readImage3(input) {
				if (input.files && input.files[0]) {
					const reader = new FileReader();
					
					reader.onload = (e) => {
						const previewImage = document.getElementById('mainPreview3');
						previewImage.src = e.target.result;
					}
					reader.readAsDataURL(input.files[0]);
				}
			}

			document.getElementById('mainImg3').addEventListener('change', (e) => {
				readImage3(e.target);
			})
			</script>
			
			
            <div id="divStepBtn_3" class="step_btn" style="display: none;">
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-up moveUp"></span></a>
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-down moveDown"></span></a>
                <a href="javascript:adjustStep(3)"><b>맞춤</b></a>
                <a href="javascript:addStep(3)"><span class="glyphicon glyphicon-plus"></span></a>
                <a href="javascript:delStep(3)"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div style="width:580px;border:1px;margin:5px 200px 5px;">
          <div style="padding:5px;">
             
          </div>
            </div>

          </div>
		  <div id="divStepItem_4" class="step">
            <p id="divStepNum_4" class="cont_tit2_1" style="cursor:pointer" data-original-title="" title="">Step4</p>
            <div id="divStepText_4" style="display:inline-block">
                <textarea name="method_text_4" id="step_text_4" class="form-control step_cont" placeholder="예) 고기가 반쯤 익어갈 때 양파를 함께 볶아요." style="height:160px; width:430px; resize:none;"></textarea>
            </div>
			<label for="mainImg4">
                <img id="mainPreview4" src="https://recipe1.ezmember.co.kr/img/pic_none2.gif" style="width : 160px; height : 160px;">
             </label>
              <input type="file" id="mainImg4" name="method_img_4" accept=".png, .jpg" style="width: 0; height : 0 ; overflow : hidden;"> 
			  
			<script type="text/javascript">
			
						/* main_img */
			function readImage4(input) {
				if (input.files && input.files[0]) {
					const reader = new FileReader();
					
					reader.onload = (e) => {
						const previewImage = document.getElementById('mainPreview4');
						previewImage.src = e.target.result;
					}
					reader.readAsDataURL(input.files[0]);
				}
			}

			document.getElementById('mainImg4').addEventListener('change', (e) => {
				readImage4(e.target);
			})
			</script>
            <div id="divStepBtn_4" class="step_btn" style="display: none;">
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-up moveUp"></span></a>
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-down moveDown"></span></a>
                <a href="javascript:adjustStep(4)"><b>맞춤</b></a>
                <a href="javascript:addStep(4)"><span class="glyphicon glyphicon-plus"></span></a>
                <a href="javascript:delStep(4)"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div style="width:580px;border:1px;margin:5px 200px 5px;">
          <div style="padding:5px;">
              
          </div>
            </div>

          </div>
		  <div id="divStepItem_5" class="step">
            <p id="divStepNum_5" class="cont_tit2_1" style="cursor:pointer" data-original-title="" title="">Step5</p>
            <div id="divStepText_5" style="display:inline-block">
                <textarea name="method_text_5" id="step_text_5" class="form-control step_cont" placeholder="예) 소고기는 기름기를 떼어내고 적당한 크기로 썰어주세요." style="height:160px; width:430px; resize:none;"></textarea>
            </div>
			<label for="mainImg5">
                <img id="mainPreview5" src="https://recipe1.ezmember.co.kr/img/pic_none2.gif" style="width : 160px; height : 160px;">
             </label>
              <input type="file" id="mainImg5" name="method_img_5" accept=".png, .jpg" style="width: 0; height : 0 ; overflow : hidden;"> 
			  
			<script type="text/javascript">
			
						/* main_img */
			function readImage5(input) {
				if (input.files && input.files[0]) {
					const reader = new FileReader();
					
					reader.onload = (e) => {
						const previewImage = document.getElementById('mainPreview5');
						previewImage.src = e.target.result;
					}
					reader.readAsDataURL(input.files[0]);
				}
			}

			document.getElementById('mainImg5').addEventListener('change', (e) => {
				readImage5(e.target);
			})
			</script>
            <div id="divStepBtn_5" class="step_btn" style="display: none;">
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-up moveUp"></span></a>
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-down moveDown"></span></a>
                <a href="javascript:adjustStep(5)"><b>맞춤</b></a>
                <a href="javascript:addStep(5)"><span class="glyphicon glyphicon-plus"></span></a>
                <a href="javascript:delStep(5)"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div style="width:580px;border:1px;margin:5px 200px 5px;">
          <div style="padding:5px;">
             
          </div>
            </div>

          </div>
		  <div id="divStepItem_5" class="step">
            <p id="divStepNum_5" class="cont_tit2_1" style="cursor:pointer" data-original-title="" title="">Step6</p>
            <div id="divStepText_5" style="display:inline-block">
                <textarea name="method_text_6" id="step_text_6" class="form-control step_cont" placeholder="예) 소고기는 기름기를 떼어내고 적당한 크기로 썰어주세요." style="height:160px; width:430px; resize:none;"></textarea>
            </div>
			<label for="mainImg6">
                <img id="mainPreview6" src="https://recipe1.ezmember.co.kr/img/pic_none2.gif" style="width : 160px; height : 160px;">
             </label>
              <input type="file" id="mainImg6" name="method_img_6" accept=".png, .jpg" style="width: 0; height : 0 ; overflow : hidden;"> 
			  
			<script type="text/javascript">
			
						/* main_img */
			function readImage6(input) {
				if (input.files && input.files[0]) {
					const reader = new FileReader();
					
					reader.onload = (e) => {
						const previewImage = document.getElementById('mainPreview6');
						previewImage.src = e.target.result;
					}
					reader.readAsDataURL(input.files[0]);
				}
			}

			document.getElementById('mainImg6').addEventListener('change', (e) => {
				readImage6(e.target);
			})
			</script>
            <div id="divStepBtn_5" class="step_btn" style="display: none;">
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-up moveUp"></span></a>
                <a href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-down moveDown"></span></a>
                <a href="javascript:adjustStep(5)"><b>맞춤</b></a>
                <a href="javascript:addStep(5)"><span class="glyphicon glyphicon-plus"></span></a>
                <a href="javascript:delStep(5)"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div style="width:580px;border:1px;margin:5px 200px 5px;">
          <div style="padding:5px;">
             
          </div>
            </div>

          </div>
		  </div>
		  


     </div><!--/regi_center-->
	  <div class="regi_btm">
		<input type="submit" id="input" value="저장" class="btn-lg btn-primary"></button>
			<button type="button" onclick="doSubmit('save_public')" class="btn-lg btn-warning">저장 후 공개하기</button>
			<button type="button" onclick="history.back();" class="btn-lg btn-default">취소</button>
		  </div>
</div><!-- /container --></form>
</div>
 </form>
      

 
       
       
   </div> 
</body>
</html>
<style>


@charset "utf-8";

body {min-width: 1240px;}
.container {width: 1240px; max-width: none !important;}
.container_full {width:100%; max-width: none !important;}
.navbar-collapse {display: block !important; visibility: visible !important;}
.navbar-header, .navbar-form, .navbar-nav, .navbar-nav > li { float: left ;}
/*a, a:focus, input:focus,bu:focus, .btn:active, .btn:hover {outline-style:none; }*/


/*main*/
.rcp_m_cate {position:relative;}
.rcp_cate {margin-top:2px; border:1px solid #e6e7e8; border-bottom:none; background:url(//recipe1.ezmember.co.kr/img/cate_btm.gif?v.) bottom left repeat-x; background-color:#fff; padding:15px 30px 28px;}
.rcp_cate.st2 {border:1px solid #e6e7e8; border-bottom:none; background:#fff; padding:16px 30px 17px; vertical-align:top; position:relative; margin-top:0;}
.rcp_cate.st3 {background:#fff; padding:16px 15px 8px 12px; vertical-align:top; margin-top:0; border-right:none; border-left:none; border-top:none;}
.rcp_cate .cate_list {font-size:15px; padding:8px 0; line-height:1; height: 41px;}
.rcp_cate .cate_list span {color:#74b243; display:inline-block; font-weight:500; width:62px; height:28px; margin:0 5px 0 0; text-align:center; padding-top:6px; vertical-align:middle; font-size:15px;}
.rcp_cate .cate_list a {padding:3px 8px 4px; color:#666; vertical-align:middle; font-size:15px; line-height:1; font-weight: 300;}
.rcp_cate .cate_list a:hover {color:#57c006; text-decoration:none;}
.rcp_cate .cate_list a.active {color:#fff; background:#74b243; margin:0; border-radius:16px;}
.rcp_cate .cate_list2 {font-size:15px; padding:8px 0; line-height:1;}
.rcp_cate .cate_list_line {border-top:1px solid #ebebeb; height:15px; margin-top:14px;}
.rcp_cate .cate_list2 span {background:url(//recipe1.ezmember.co.kr/img/cate_bg2.gif) left top no-repeat; background-size:120px 30px; color:#74b243; display:inline-block; font-weight:bold; width:120px; height:30px; margin:0 16px 0 0; text-align:center; padding-top:6px; vertical-align:middle;}
.rcp_cate .cate_list2 ul {display:inline-block; margin:0; padding:0;}
.rcp_cate .cate_list2 li {padding-top:5px; color:#666; background:#f7f7f7; border:1px solid #ebebeb; border-radius:14px; width:94px; height:30px; display:inline-block; text-align:center; vertical-align:middle; margin:0 3px; cursor:pointer;}
.rcp_cate .cate_list2 li.active {background:#74b243; color:#fff;}
.rcp_cate .cate_list2 .form-control {width:300px; display:inline-block; border-radius:0; margin-left:3px;}

.rcp_cate_btn {border-bottom:1px solid #e6e7e8; text-align:center;}
.rcp_cate_btn a {color:#5da619; font-size:14px; padding:12px 50px; display:inline-block;}
.rcp_cate_btn a span {padding-left:5px;}
.rcp_cate_btn a span img {margin-top:-1px;}

.thumbs_hb {height:120px;}

.rcp_m_banner {width:1240px; margin:7px 0 14px 0; float:left;}
.rcp_m_banner a {margin-right:5px; float:left;}
.rcp_m_banner a img {width:410px; -webkit-box-shadow:0 2px 2px rgba(0, 0, 0, 0.2); box-shadow:0 2px 2px rgba(0, 0, 0, 0.2);}
.rcp_m_banner a:last-child {margin-right:0;}
.rcp_m_list {margin-top:38px;}
.rcp_m_list .row {margin:0 -7px 0 -6px;}
.rcp_m_list .row .col-xs-3 {padding:0 7px;}
.rcp_m_list .thumbnail {border-radius:0; padding:0; height:400px; width:299px;}
.rcp_m_list .thumbnail img {border-bottom:1px solid #e6e7e8;}
.rcp_m_list .thumbnail .caption {padding:10px 20px;}
.rcp_m_list .thumbnail .caption h4 {font-size:18px; font-weight:bold;}
.rcp_m_list .thumbnail .caption p.m_list_cate {color:#84accb; margin-bottom:4px;}
.rcp_m_list .thumbnail .caption p {color:#999; margin:0;}
.rcp_m_list .thumbnail .caption span {margin:0 6px; display:inline-block;}
.rcp_m_list .thumbnail .caption span.down {background:url(//recipe1.ezmember.co.kr/img/ico_down.gif) left 2px no-repeat; padding-left:20px;}
.rcp_m_list .thumbnail_over {
	position: absolute;
	left:7px; top:0;
	width: 100%;
	height: 100%;
	opacity: 0;
	filter:alpha(opacity=0);

	-webkit-transition: all 0.4s ease-in-out;
	-moz-transition: all 0.4s ease-in-out;
	-o-transition: all 0.4s ease-in-out;
	-ms-transition: all 0.4s ease-in-out;
	transition: all 0.4s ease-in-out;

-webkit-backface-visibility: hidden; /*for a smooth font */

}
.rcp_m_list .thumbnail:hover .thumbnail_over {opacity: 1; filter:alpha(opacity=70);}
.rcp_m_list .m_list_tit {font-size:18px; color:#333; padding-bottom:18px;}
.rcp_m_list .m_list_tit b {color:#74b243; font-size:30px;}
.rcp_m_list .best_label {position:absolute; right:10px; top:-8px; z-index:10;}
.rcp_m_list .best_label img {border-bottom:none !important;}
.rcp_m_list .vod_label {position:absolute; right:14px; top:210px; z-index:10;}
.rcp_m_list .vod_label img {border-bottom:none !important;}
.rcp_m_list .thumbnail_original {position:absolute; right:16px; top:8px; border:3px solid #fff; -webkit-transition:border .2s ease-in-out; -o-transition:border .2s ease-in-out; transition:border .2s ease-in-out}
.rcp_m_list .thumbnail_original img {width:80px; height:80px; }
.rcp_m_list .thumbnail_original:focus, .rcp_m_list .thumbnail_original:hover {border:3px solid #5ca920;}

.rcp_m_list2 {margin-top:30px; padding:0 22px;}
.rcp_m_list2.st2 {margin-top:30px; padding:0 0;}
.rcp_m_list2 .row {margin:0 -4px 0 -4px;}
.rcp_m_list2 .row .col-xs-4 {padding:0 5px;}
.rcp_m_list2 .thumbnail {border-radius:0; padding:0; height:400px; width:277px;}
.rcp_m_list2 .thumbnail img {border-bottom:1px solid #e6e7e8;}
.rcp_m_list2 .thumbnail .caption {padding:10px 20px; min-height:114px;}
.rcp_m_list2 .thumbnail .caption h4 {font-size:16px;}
.rcp_m_list2 .thumbnail .caption p.m_list_cate {color:#84accb; margin-bottom:4px;}
.rcp_m_list2 .thumbnail .caption p {color:#999; margin:0; font-weight: 300;}
.rcp_m_list2 .thumbnail .caption span {margin:0 6px; display:inline-block;}
.rcp_m_list2 .thumbnail .caption span.down {background:url(//recipe1.ezmember.co.kr/img/ico_down.gif) left 2px no-repeat; padding-left:20px;}
.rcp_m_list2 .thumbnail_over {position: absolute; left:6px; top:1px; width:275px; height:275px; opacity: 0; filter:alpha(opacity=0); z-index:10;
	-webkit-transition: all 0.4s ease-in-out;
	-moz-transition: all 0.4s ease-in-out;
	-o-transition: all 0.4s ease-in-out;
	-ms-transition: all 0.4s ease-in-out;
	transition: all 0.4s ease-in-out;
	-webkit-backface-visibility: hidden; /*for a smooth font */}
#contents_area_full .rcp_m_list2 .thumbnail_over {left:auto;}
.rcp_m_list2 .thumbnail_over img {width:275px; height:275px;}
.rcp_m_list2 .thumbnail:hover .thumbnail_over {opacity: 1; filter:alpha(opacity=70);}
.rcp_m_list2 .m_list_tit {font-size:16px; color:#333; padding:5px 0 20px 8px;}
.rcp_m_list2 .m_list_tit b {color:#74b243; font-size:26px;}
.rcp_m_list2 .best_label {position:absolute; right:12px; top:8px; z-index:10;}
.rcp_m_list2 .best_label img {border-bottom:none !important; width:50px;}
.rcp_m_list2 .vod_label {position:absolute; right:15px; top:195px; z-index:10;}
.rcp_m_list2 .vod_label img {border-bottom:none;}
.search_btn {position:absolute; right:22px; padding:0; margin:0;}
.search_btn.st1 {top:120px;}
.search_btn.st2 {top:417px;}
.search_btn .btn {background:#479ffc; font-size:18px; color:#fff; padding:10px 0; width:150px; border:0; border-radius:0;}
.search_btn .btn img {width:25px; margin-right:4px; vertical-align:text-top;}
.search_re {float:right; display:inline-block; padding-top:1px;}
.search_re .form-control {width:250px; border:1px solid #ccc; border-radius:0; height:38px;}
.search_re .input-group-btn {display:inline-block;}
.search_re .input-group-btn .btn {background:#74b243; color:#fff; border:0; height:38px; border-radius:0; }
.search_sort {float:right; margin-left:6px; padding-top:1px;}
.search_sort .btn {height:38px; border:1px solid #ccc; border-radius:0; padding:5px 10px; color:#666;}
.search_sort img {width:21px; vertical-align:top; margin-left:4px;}
.search_sort .btn .caret {margin-left:16px; color:#999;}
.search_sort li a {padding:8px 20px;}

.rcp_lately_list {margin-top:44px;}
.rcp_lately_list h3 {margin-left:20px;}
.rcp_lately_list .row {margin:22px 40px 0 40px; position:relative;}
.rcp_lately_list .list_btn_pre {position:absolute; left:16px; top:70px; z-index:100;}
.rcp_lately_list .list_btn_next {position:absolute; right:0; top:70px; z-index:100;}
.rcp_lately_list .thumbnail {width:180px; border-radius:0; padding:0; height:255px; border:1px solid #ddd;}
.rcp_lately_list .thumbnail img {}
.rcp_lately_list .thumbnail .caption b {font-size:16px; display:inline-block; padding:4px 0 2px 0;}
.rcp_lately_list .thumbnail .caption p {color:#999; margin:0;}

.event_cont {width:100%; border:none; padding:20px 27px 15px;}
.event_cont h3 {font-size:30px; background:url(//recipe1.ezmember.co.kr/img/icon_dot2.gif) 5px top no-repeat; background-size:23px 4px; padding:10px 0 0 5px; font-weight:bold; display:inline-block; margin:0 0 15px 0; position:relative; width:100%;}
.event_cont h3 b {font-size:24px; padding-left:6px;}
.event_cont h3 b span {color:#6da812;}
.event_cont h3 u {text-decoration:none; font-size:16px; color:#999; font-weight:normal; padding-left:6px;}
.event_cont h3 .list_sort a.active {background:url(//recipe1.ezmember.co.kr/img/icon_check.gif) left 20px no-repeat;}
.event_cont ul.theme_list {list-style:none; padding:0; margin:0;}
.event_cont ul.theme_list li:not(.dropdown-li)  {width:200px; display:inline-block; padding:0; margin:0 11px 30px 0; position:relative;}
.event_cont ul.theme_list li:nth-child(4n+4) {margin:0 -4px 30px -1px;}
.event_cont ul.theme_list .thumbnail {margin:0;}
.event_cont ul.theme_list .btn-default {display:block; color:#999; background-color:#fbfbfb; border:1px solid #ebebeb; font-size:16px; font-weight:normal; width:200px; margin:10px 0 0 0;}
.event_cont ul.theme_list .btn-default:hover {border:1px solid #ccc;}
.event_cont div.theme_list .thumbnail {margin:0 11px 20px 0}
.event_cont .thumbnail_original {position:absolute; right:8px; top:8px; border:3px solid #fff; -webkit-transition:border .2s ease-in-out; -o-transition:border .2s ease-in-out; transition:border .2s ease-in-out; z-index:100;}
.event_cont .thumbnail_original img {width:54px; height:54px; }
.event_cont .thumbnail_original:focus, .event_cont .thumbnail_original:hover {border:3px solid #5ca920;}
.event_btn_area {border:1px solid #ddd; margin-top:10px;}
.event_btn_area img {vertical-align:text-top; margin-left:3px}
.event_btn_area a {width:50%; display:inline-block; text-align:center; padding:7px 0 8px 5px ;}
.event_btn_area a:first-child {border-right:1px solid #ddd}
.event_btn_area a:hover {background:#fafafa;}
.event_btn_area.st2 a {width:100%; border:none;}

.home_cont {width:1240px; background:#fff; border:1px solid #e9e9e9; padding:28px 141px 24px 141px; margin-bottom:8px; float:left; position:relative;}
.home_cont.st2 {width:100%; margin-bottom:8px; float:left;}
.home_cont.st3 {width:100%; float:left; border:none; padding:35px 0 0;}
.home_cont.st6 {width:893px; border:none; padding:28px 50px 24px 94px; margin:0 1px;}
.home_cont.st7 {width:893px; border:none; padding:28px 50px 0 94px; margin:0 1px;}
.home_cont.st8 {padding: 28px 25px 24px;}
.home_cont.st8 dt {padding: 0 54px;}
.home_cont.st8 dd {position: relative;}
.home_cont.st8 .common_sp_list_li { margin-bottom: 0;}
.home_cont:after {clear:both;}
.home_cont dt { font-weight:normal; margin-bottom:20px; padding-left:5px;}
.home_cont .brand_banner {position:absolute; left:-40px; top:-24px; z-index:1000;}
.home_cont dt h3 {color:#000; display:inline-block; margin:0;}
.home_cont dt h3 span {color: #64a70a;}
.home_cont dt h3 a {color:#000;}
.home_cont.st3 dt h3 {font-size:30px; background:url(//recipe1.ezmember.co.kr/img/icon_dot2.gif) left top no-repeat; background-size:23px 4px; padding-top:10px;}
.home_cont.st3 dt h3 b {font-size:24px; padding-left:6px;}
.home_cont.st3 dt h3 b span {color:#6da812;}
.home_cont.st3 dd {padding:0 23px;}
.home_cont_r {float:right; letter-spacing:4px; padding-right:3px;}
.home_cont.st6 .home_cont_r {padding-bottom:14px;}
.home_cont_r span {color:#999; margin-right:10px; font-size:16px;}
.home_cont_r span b {color:#333;}
.home_cont_r a {padding:2px 0 2px 4px; border:1px solid #ccc; margin-left:-1px; text-align:center; width:30px!important; height:30px; font-size:15px; color:#000; display:inline-block; font-weight:bold;}
.home_cont_r a:hover {color:#74b243;}
.home_cont_r2 {float:right; padding:8px 0 0 0;}
.home_cont_r2 .btn_more {border:1px solid #d6c1aa; color:#b99773; font-size:13px; padding:5px 8px;}
.home_cont dd ul, .home_cont dd li {list-style:none; padding:0;}
.home_cont dd ul.home_recipe li {display:inline-block; height:270px; width:232px; position:relative; margin:0 2px 10px 2px; vertical-align:top;}
.home_cont.st3 dd ul.home_recipe li {height:247px;margin:0 12px 20px 12px;}
.home_cont dd ul.home_recipe2 li {display:inline-block; width:232px; height:262px; position:relative; margin:0 2px 10px 2px; vertical-align:top;}
.home_cont dd ul.home_recipe2.st2 li {height:230px;}
.home_cont dd ul.home_recipe2.st2 li p {font-size:13px; margin-top:2px}
.home_cont dd ul.home_recipe2.st2 li h4 {margin-top:3px;}
.home_recipe2 .list_num {background:#000; filter:alpha(opacity=50); opacity:0.5; margin:0; padding:2px 6px; position:absolute; right:10px; top:120px; color:#fff; font-size:12px;}
.home_cont dd ul.home_recipe2.st3 li {height:345px;}
.home_cont dd ul.home_recipe2.st3 li p {font-size:13px;}
.home_cont dd ul.home_recipe2.st3 li h4 {margin-top:3px;}

.home_cont .thumbnail {border-radius:0; padding:0; height:100%;}
.home_cont.st3 .thumbnail {border-radius:0; padding:0; height:100%;}
.home_cont.st4 .thumbnail {height:280px; margin:0 11px 20px 1px; display:inline-block; padding:0;}
.home_cont.st4 .thumbnail .caption {text-align:center;}
.home_cont.st4 .thumbnail img {border-bottom:none; width:220px; height:220px;}
.home_cont.st5 .thumbnail {height:300px;}
.home_cont.st5 .thumbnail img {border-bottom:none; width:230px; height:230px;}
.home_cont.st6 .thumbnail {height:300px;}
.home_cont.st6 .thumbnail img {border-bottom:none; width:230px; height:230px;}
.home_cont.st7 .thumbnail {height:324px; position:relative;}
.home_cont.st7 .thumbnail img {border-bottom:none; width:230px; height:230px;}
.home_cont.st7 dt {font-size:24px; padding:0 0 15px 0; font-weight:bold; margin:0 0 0 -44px;}
.home_cont.st7 dd ul.home_recipe li {height:auto; margin:0 14px 0 0;}
.home_cont.st7 .thumbnail .caption {padding:11px 0 0 0; line-height:1.4; border-top:1px solid #ebebeb;}
.home_cont.st7 .thumbnail .caption p {color:#333;}
.home_cont.st7 .thumbnail .caption_tit {font-size:14px; padding:0 15px; height:40px;}
.home_cont.st7 .thumbnail p.caption_price  {color:#ff321b; font-size:16px; padding:0 15px 8px;}
.home_cont.st7 .thumbnail .caption_price b {color:#000; font-family:'Poppins', 'Nanum Gothic'; margin-left:6px;}
.home_cont.st7 .thumbnail .caption_price span {color:#666; font-size:12px; width:auto;}
.home_cont.st7 .thumbnail .caption_name {margin:0; text-align:right; position:absolute; left:1px; top:209px; width:229px;}
.home_cont.st7 .thumbnail .caption_name_a {color:#fff; font-size:11px; display:inline-block; padding:3px 7px; width:auto; margin:0; background:#ff6600;}
.home_cont.st7 .thumbnail .caption_name_b {color:#fff; font-size:11px; display:inline-block; padding:3px 7px; width:auto; margin:0; background:#6794b6;}
.home_cont.st8 {}
.home_cont .home_cont_tab {padding-left:0; width:944px;}
.home_cont_tab {border-bottom:1px solid #ddd; padding-left:0;}
.home_cont_tab.st2 {margin:30px 30px -15px;}
.home_cont_tab .tab_mn {display:inline-block; padding:10px 35px; font-size:16px; color:#888; margin-bottom:-1px; background:#fff;}
.home_cont_tab .tab_mn.active {border-top:1px solid #ddd; border-right:1px solid #ddd; border-left:1px solid #ddd; border-bottom:1px solid #fff; font-weight:bold; color:#000;}
.home_cont_tab .home_cont_r2 {padding-right:0;}
.home_cont_tab .home_cont_r2 span {color:#999; padding:0 18px 0 6px;}
.home_cont_tab .home_cont_r2 img {margin-top:-4px;}
.brand_cont .cont_list.st3 .home_review {margin-top:14px;}
.home_review {border-top:1px solid #ddd; margin-top:18px; padding:12px 15px 0 15px;}
.brand_cont .cont_list.st3 .home_review p {font-size:12px;}
.home_review p {padding:0; margin-bottom:0; font-size:13px;}
.home_review .name {color:#999;}
.home_review .star { margin-top:2px;}
.home_cont .thumbnail .home_review .star img, .home_review .star img {width:16px; border:0; margin:0;}
.home_review .comment {color:#1a77ac; margin-top:6px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; line-height: 1.4; height:inherit;}
.brand_cont .cont_list.st3 p.comment {font-size:13px;}
.home_review .date {color:#999; margin-top:4px;}

.home_cont .eg-flick-panel span {padding-top:8px; height: 26px!important;}

.home_cont dd ul.recipe_home .thumbnail {background:#fbfbfb;}
.home_cont .thumbnail img {border-bottom:1px solid #e6e7e8;}
.home_cont .thumbnail .caption {padding:7px 15px 0 15px;}
.home_cont .thumbnail .caption h4 {font-size:15px; margin:2px 0 4px;}
.home_cont .thumbnail .caption2 h4 {font-size:15px; font-weight:bold; margin-bottom:0;}
.home_cont.st5 .thumbnail .caption h4, .home_cont.st6 .thumbnail .caption h4 {text-align:center;}
.home_cont .thumbnail .caption p.m_list_cate {color:#84accb; margin-bottom:1px;}
.home_cont .thumbnail .caption p {color:#999; margin:0 0 0 -2px; font-size:14px;}
.home_cont .thumbnail .caption p b {color:#000;}
.home_cont .thumbnail .caption p span {display:inline-block; width:170px; vertical-align:middle;}
.home_cont .thumbnail .caption span {margin:0; display:inline-block;}
.home_cont .thumbnail .caption span.down {background:url(//recipe1.ezmember.co.kr/img/ico_down.gif) left 2px no-repeat; padding-left:20px;}
.home_cont .thumbnail .caption_name img {width:28px; height:28px; border-radius:50%; margin-right:4px; border:1px solid #ddd;}
.home_cont .thumbnail_over {
	position: absolute;
	left:1px; top:1px;
	width: 100%;
	height: 100%;
	opacity: 0;
	filter:alpha(opacity=0);

	-webkit-transition: all 0.4s ease-in-out;
	-moz-transition: all 0.4s ease-in-out;
	-o-transition: all 0.4s ease-in-out;
	-ms-transition: all 0.4s ease-in-out;
	transition: all 0.4s ease-in-out;

-webkit-backface-visibility: hidden; /*for a smooth font */

}
.home_cont .thumbnail:hover .thumbnail_over {opacity: 1; filter:alpha(opacity=70);}
.home_cont .best_label {position:absolute; right:6px; top:6px; z-index:10;}
.home_cont .best_label img {border-bottom:none !important; width:40px;}
.home_cont .best_label2 {position:absolute; right:6px; top:6px; z-index:10; background:#83c832; width:38px; height:38px; border-radius:50%; filter:alpha(opacity=70); opacity:0.7; color:#fff; font-size:11px; font-weight:bold;}
.home_cont .vod_label {position:absolute; right:6px; top:105px; z-index:10;}
.home_cont .vod_label img {border-bottom:none !important; width:40px;}
.home_cont .thumbnail_original {position:absolute; right:11px; top:11px; border:3px solid #fff; -webkit-transition:border .2s ease-in-out; -o-transition:border .2s ease-in-out; transition:border .2s ease-in-out}
.home_cont .thumbnail_original img {width:54px; height:54px; }
.home_cont .thumbnail_original:focus, .home_cont .thumbnail_original:hover {border:3px solid #5ca920;}
.theme_cate {margin-bottom:22px;}
.home_cont .member_list {margin:28px 0 30px 0;}
.home_cont .member_list .info_pic2 {display:inline-block; margin:0  1px 10PX 2px; width:16%; vertical-align:top;}
.home_cont .member_list .info_name {font-size:14px;}
.hotchef_best.home_best {background:url(//recipe1.ezmember.co.kr/img/hot_bg.jpg) left top no-repeat; width:893px; height:319px; margin:-30px -20px -10px; text-align:right; padding:20px 22px 0 0;}
.hotchef_best.home_best .ranking_today_in {width:334px; display:inline-block;}
.hotchef_best.home_best .ranking_today_in .today_num {left:0; top:0;}
.hotchef_best.home_best .home_cont_r {width:100%; padding-bottom:12px;}
.hotchef_best.home_best .ranking_today_in .today_caption span.today_pic img {border-radius:50%; width:65px; height:65px; border:2px solid #fff; margin:5px 6px 0 -3px;}
.home_cont2 {padding-top:14px; margin:30px 0 10px 0; background:#fff; width:100%; float:left;}
.home_cont2 dt {font-size:18px; color:#000; line-height:22px; padding:0 8px 14px 8px; margin-bottom:8px; }
.home_cont2 dt img {width:25px; margin:0 3px 0 0; vertical-align:text-bottom;}
.home_cont2 .chef_list.st2 {float:left; margin-top:0; padding-top:0; padding-bottom:8px; width:100%;}
.home_cont2 .home_cont_list {float:left; margin-top:4px; padding-bottom:20px; width:100%;}
.home_cont2 .chef_list.st2 .list_cont2 b a {font-size:16px; color:#74b243;}
.home_cont2 dd ul, .home_cont2 dd li {list-style:none; padding:0;}
.home_cont2 .member_list {margin:16px 0 0 0; float:left;}
.home_cont2 .member_list .info_pic2 {width:134px; margin:0 4px 15px;}
.list_mem2 .mem_pic {position:relative; display:inline-block; vertical-align:top;}
.list_mem2 .mem_pic img {width:60px; height:60px; border-radius:50%;}
.chef_list .list_cont2 {width:760px;  display:inline-block; font-size:14px; line-height:20px; padding:8px 0 18px 5px; margin-left:10px; border-bottom:1px solid #e6e7e8;}
.chef_list .list_cont3 {width:710px; float:left; font-size:14px; line-height:20px; padding:8px 0 20px 5px; border-bottom:1px solid #e6e7e8; position:relative;}
.chef_list .list_cont2 span {font-size:12px; color:#888;}
.chef_list .list_cont2 b img {width:18px; height:18px; vertical-align:text-top;}
.chef_list .list_lump {padding:10px 0 0 10px; margin:0 auto;}

.home_cont .thumbnail .caption .line2 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; line-height: 1.4;}

.gnb_top_wrap {background:#fff; width:100%; height:112px;}
.gnb_top {width:1240px; margin:0 auto; padding:16px 0 0 176px;}
.gnb_top h1 {margin:0 30px 0 0; display:inline-block; vertical-align:top;}
.gnb_search {width:450px; display:inline-block; padding-top:12px;}
.gnb_search .btn {background:#74b243; border:1px solid #68a13a; height:38px;}
.gnb_search .btn span {color:#fff; font-size:22px;}
.gnb_search .form-control {border:1px solid #ccc; background:#fbfbfb; height:38px;}
.gnb_search_word {padding-top:8px;}
.gnb_search_word ul {display:inline-block; padding:1px 0 0 6px; width:381px;}
.gnb_search_word li {display:inline-block; list-style:none; padding:0; border-right:1px solid #ddd; padding:0 9px; font-size:14px; line-height:1;}
.gnb_search_word li:last-child {border-right:0;}
.gnb_search_word li a {color:#000;}
.gnb_search_btn {display:inline-block; vertical-align:top;}
.gnb_search_btn a {float:left;}
.gnb_right {display:inline-block; padding:16px 0 0 50px; vertical-align:top; position:relative;}
.gnb_right li {list-style:none; padding:0 3px; display:inline-block;}
.gnb_right li a {height:30px;}
.gnb_right li a img {width:44px; border-radius:50%;}
.gnb_right li.st2 a img {width:auto; border-radius:0;}
.gnb_right .mem_layer {position:absolute; left:22px; top:51px; width:182px; z-index:1000000;}
.gnb_right .mem_layer_m a {height:auto;}
.gnb_right .write_layer { position:absolute; right:-4px; top:50px; width:372px;}
.gnb_right .write_layer a {height:auto;}

.gnb_nav { background:url(//recipe1.ezmember.co.kr/img/gnb_bg.gif) left top repeat-x; height:46px; width:100%; -webkit-box-shadow:0 2px 5px rgba(0, 0, 0, 0.2); box-shadow:0 2px 5px rgba(0, 0, 0, 0.2); margin-bottom:16px;}
.gnb_nav ul {width:1240px; margin:0 auto; padding:9px 30px 0; text-align:center}
/*.gnb_nav ul.gnb_nav_ea10 li {width:9%;}
.gnb_nav ul.gnb_nav_ea9 li {width:10.8%;}
.gnb_nav ul.gnb_nav_ea8 li {width:12.2%;}
.gnb_nav ul.gnb_nav_ea7 li {width:14%;}
.gnb_nav ul.gnb_nav_ea6 li {width:16.3%;}
.gnb_nav ul.gnb_nav_ea5 li {width:19.7%;}
.gnb_nav ul.gnb_nav_ea4 li {width:24%;}
*/
.gnb_nav ul li {list-style:none; padding:0; width:1%; display:table-cell;}
.gnb_nav ul li a {display:block; font-size:18px; margin:0 8px; color:#fff;}
.gnb_nav ul li a.active {color:#ffff00;}
.gnb_nav ul li a:hover {color:#ffff00;}


/*sub*/
#contents_area {border-top:1px solid #e6e7e8; width:895px; padding:0 0 20px 0;}
#contents_area_full {border:1px solid #e6e7e8; padding:0 0 20px 0; background:#fff;}
#right_area {border-top:1px solid #e6e7e8; width:335px; margin-left:10px; padding:0 0 30px 0; height:auto;}
#right_area a img {-webkit-box-shadow:0 1px 2px rgba(0, 0, 0, 0.3); box-shadow:0 1px 2px rgba(0, 0, 0, 0.3);}
#right_area dt a img {-webkit-box-shadow:none; box-shadow:none;}
.sub_bg {background:url(//recipe1.ezmember.co.kr/img/container_bg.gif) left top repeat-y; position:relative;}
.sub_bg_btm {background:url(//recipe1.ezmember.co.kr/img/container_bg_btm.gif) left bottom no-repeat;}
.chef_cont {padding:30px 21px 30px;}
.chef_cont.st2 {padding:0 1px 0 1px;}
.chef_cont.st2 p {margin-bottom:0;}
.chef_cont.st3 { text-align:center;}
.chef_cont.st3 p {margin-bottom:0; padding-bottom:80px;}
.chef_cont .chef_top {margin:-30px -20px 0 -20px; padding-bottom:40px;}
.chef_cont .chef_top2 {margin:0; padding:0;}
.chef_cont_list { padding-bottom:20px;}
.chef_cont_list .member_list {margin:35px 0 50px -4px;}
.chef_cont_list .member_list .info_pic2 {display:inline-block; margin:0  1px 10PX 2px; width:16%; vertical-align:top;}
.chef_cont_list .member_list .info_name {font-size:14px;}
.cont_list {margin:22px 10px; clear:both;}
.cont_list.st2 {margin:30px 10px 0; clear:both;}
.cont_list .thumbnail {width:182px; border-radius:0; padding:0; height:250px; border:1px solid #ddd; background:#fff;}
.cont_list.st2 .thumbnail {height:292px; position:relative;}
.cont_list.st3 {margin:0; padding:0; clear:both;}
.cont_list.st3 .thumbnail {width:200px; margin:0 14px 20px 0; height:240px; display:inline-block; vertical-align:top; position:relative;}
.cont_list.st3.st3_1 .thumbnail {height:376px;}
.cont_list.st3 .thumbnail:nth-child(4n+4) {margin:0 -4px 20px 0;}
.cont_list.st3 .thumbnail .caption {padding:6px 15px;}
.cont_list.st4 {margin:28px 0 0 0; padding:0; clear:both;}
.cont_list.st4 .thumbnail {width:200px; margin:0 14px 20px 0; height:186px; display:inline-block; vertical-align:top; position:relative;}
.cont_list.st4 .thumbnail:nth-child(4n+4) {margin:0 -4px 20px 0;}
.cont_list .thumbnail img {}
.cont_list .best_label {position:absolute; right:4px; top:6px; z-index:10;}
.cont_list .best_label img {border-bottom:none !important; width:40px;}
.cont_list .copyshot_thumb {width:180px; height:260px; position:relative; padding:0; display:inline-block; margin:0 30px 0 0;}
.cont_list .thumbnail_original {position:absolute; right:28px; top:9px; border:2px solid #fff; -webkit-transition:border .2s ease-in-out; -o-transition:border .2s ease-in-out; transition:border .2s ease-in-out}
.cont_list .thumbnail_original img {width:54px; height:54px; }
.cont_list .thumbnail_original:focus, .cont_list .thumbnail_original:hover {border:2px solid #5ca920;}
.caption_blind {background:url(//recipe1.ezmember.co.kr/img/bg_blind.png) center 34px no-repeat; font-size:12px !important; color:#999 !important; text-align:center; padding:118px 10px !important;}
.caption_blind p {padding-top:10px;}
.cont_list .thumbnail .caption h4 {font-size:15px; font-weight:bold;}
.cont_list .thumbnail .caption p.m_list_cate {color:#84accb; margin-bottom:1px; width:162px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;word-wrap:normal;}
.cont_list .thumbnail .caption p {color:#999; margin:0; font-size:12px;}

.chef_info {background:url(//recipe1.ezmember.co.kr/img/chef_bg2.jpg) left top no-repeat; width:895px; height:250px; position:relative; margin:-1px -1px 0 0; text-align:center;}
.chef_info .info_pic {padding:52px 0 0 0; width:116px; display:inline-block; vertical-align:top; position:relative;}
.chef_info .info_pic img {width:116px; height:116px; border-radius:50%;}
.chef_info .info_add {position:absolute; right:-7px; top:45px;}
.chef_info .info_add img {width:42px; height:42px;}
.chef_info .info_follow {font-size:24px; color:#444; text-align:center; font-family:Helvetica; line-height:26px; padding-top:90px; width:140px; display:inline-block;}
.chef_info .info_follow p {color:#444; font-size:14px; font-family:'Nanum Gothic'}
.chef_info .info_name {color:#444; font-size:22px; text-align:center; padding-top:10px; width:100%; line-height:1.1;}
.chef_info .info_name span {font-size:14px; color:#777; display:block;}
.chef_info .info_level {position:absolute; left:26px; top:18px;}
.chef_cont .scrap_list {margin:20px 10px 22px 10px;}
.chef_cont .scrap_list .media {border-bottom:1px solid #d5d6d7; padding:50px 30px; margin:0 17px;}
.chef_cont .scrap_list .media h3 {padding-top:5px; font-weight:bold;}
.chef_cont .scrap_list .media p {font-size:18px; color:#999; line-height:18px;}
.chef_cont .scrap_list .media p span {color:#74b243; font-weight:bold;}
.chef_cont .scrap_list .media .media-left {padding-right:24px;}
.chef_cont .scrap_list .media .like_hit p {width:80px; background:url(//recipe1.ezmember.co.kr/img/icon_heart.gif) center top no-repeat; padding-top:46px; color:#de4830; text-align:center; font-weight:bold; font-size:18px; font-family:Helvetica;}
.chef_cont .admin_btn p {width:40px; padding-left:8px;}
.chef_cont .admin_btn .dropdown-toggle {width:40px; border:none;}
.chef_cont .admin_btn .btn-group.open .dropdown-toggle, .admin_btn .btn-group .dropdown-toggle:active {box-shadow:none;}

.list_sort {position:absolute; right:0; top:4px; padding-right:10px; font-weight:normal;}
.list_sort a {display:inline-block; color:#333; padding:10px; font-size:14px;}
.list_sort a.active {background:url(//recipe1.ezmember.co.kr/img/icon_check.gif) left 9px no-repeat; padding-left:18px; margin-left:4px; font-weight:400;}
.list_sort a.sort_btn {padding:2px 0 0 0; vertical-align:top; margin-right:8px;}
.member_list {margin:40px 10px;}
.member_list .row {margin-bottom:50px;}
.member_list .info_pic {text-align:center; padding:20px 0 0 20px; width:175px;}
.member_list .info_pic img {width:100px; height:100px; border-radius:50%;}
.member_list .info_pic2 {text-align:center; padding:0; margin:0 14px 56px;}
.member_list .info_pic2 img {width:100px; height:100px; border-radius:50%;}
.member_list.st2 .info_pic2 img {width:100px; height:100px; border-radius:50%; -webkit-box-shadow:0 0 4px rgba(0, 0, 0, 0.2); box-shadow:0 0 4px rgba(0, 0, 0, 0.2);}
.member_list .info_name {font-size:16px; font-weight:400; padding-top:12px;}
.info_name_m {color:#44b6b5;}
.info_name_f {color:#de4830;}
.member_list .thumbnail {width:144px; border-radius:0; padding:0; margin:0 3px; height:220px; border:1px solid #ddd; background:#fff !important; display:inline-block; vertical-align:top;}
.member_list .thumbnail img {width:144px; height:144px;}
.member_list .btn_more {background:#f1f1f2; width:30px; height:220px; padding:0;}
.member_list .btn_more a {width:30px; height:220px; padding:87px 0 0 0; text-align:center; display:inline-block;}

.blank_bottom {background:#f1f1f2; height:10px; border-top:1px solid #e6e7e8; border-bottom:1px solid #e6e7e8; clear:both;}
.blank_bottom2 {background:#f1f1f2; height:10px; border-top:1px solid #e6e7e8;}
.blank_bottom_wave {background:url(//recipe1.ezmember.co.kr/img/bg_btm_wave.gif) left top; width:895px; height:23px;}

.talk_title {padding:15px 25px 8px; font-size:16px; font-weight:bold; position:relative;}
.talk_title .col-xs-2 {position:absolute; right:20px; top:10px; width:auto;}
.talk_title.st2 .col-xs-3 { text-align:right;}
.talk_title .btn {font-size:24px; padding:6px 35px;}
.talk_title .btn.st2 {font-size:18px; font-weight:bold; padding:6px 30px; margin-top:3px;}
.talk_title .btn.btn-info3 {padding:6px 25px; margin-right:4px;}
.talk_title .btn.btn-info3 span {vertical-align:text-top; margin-right:5px;}
.talk_title p {padding:12px 0;}
.talk_title.st2 {font-size:30px; line-height:1;}
.talk_title.st2 p {padding:8px 0 15px 6px; margin:0;}
.talk_title.st3 {padding:15px 0 15px 25px}
.talk_list {padding:0 0 20px 0;}
.talk_list .list_lump {padding:18px 0 10px 0;}
.chef_cont .talk_list .list_lump {padding:22px 0 60px 0; margin:10px 12px; border:1px solid #e6e7e8;}
.talk_list .info_pic {padding-left:45px;}
.chef_cont .talk_list .info_pic {padding-left:30px;}
.talk_list .info_pic img {width:100px; height:100px; border-radius:50%;}
.talk_list .info_name {font-size:22px; padding-top:12px; line-height:26px;}
.talk_list .info_name p {font-size:16px; font-weight:normal; color:#999;}
.talk_list .icon_like {background:url(//recipe1.ezmember.co.kr/img/icon_heart2.gif) left 3px no-repeat; margin-top:7px; padding-left:30px; font-size:22px; color:#999; font-family:Helvetica; display:inline-block;}
.talk_list .icon_reply {background:url(//recipe1.ezmember.co.kr/img/icon_reply.gif) left 2px no-repeat; margin-top:7px; padding-left:30px; font-size:22px; color:#74b243; font-weight:bold; font-family:Helvetica; display:inline-block;}
.talk_list .summary {font-size:18px; width:700px;  word-break:break-all;  padding-bottom:20px; line-height:160%;}
.talk_list .picture {width:680px; margin:0 0 30px 0; position:relative;}
.talk_list .picture img {border-radius:10px; border:none; }
.talk_list .picture_r {position:absolute; right:0px; top:10px; border-radius:0; border:5px solid  #fff; -webkit-transition:border .2s ease-in-out; -o-transition:border .2s ease-in-out; transition:border .2s ease-in-out;}
.talk_list .picture_r img {width:130px; height:130px; border-radius:0;}
.talk_list .picture_r:focus, .talk_list .picture_r:hover {border:5px solid #5ca920;}

.copyshot_original {border-bottom:1px solid #e6e7e8; margin:0 50px; padding:40px 0 30px 0;}
.copyshot_original .original_tit {padding:0 0 26px 20px;}
.copyshot_original .original_pic {width:750px; position:relative; margin:0 auto; border:1px solid #bbb; border-bottom:none;}
.copyshot_original .original_pic .pic_shadow {background:url(//recipe1.ezmember.co.kr/img/bg_pic.png) left bottom no-repeat; width:750px; height:18px; margin-left:-1px;}
.copyshot_original .original_pic_in {width:710px; position:relative; margin:20px auto; background:#ddd; display:block; text-align:center;}
.copyshot_original .original_pic_in img {max-width:710px; max-height:480px;}
.copyshot_original .original_pic_in .tit {width:710px; background:#000;	filter:alpha(opacity=70); opacity:.7; padding:8px 0 0 0; text-align:center; height:45px; position:absolute; left:0; bottom:0;}
.copyshot_original .original_pic_in .tit span {font-size:18px; color:#fff;}
.copyshot_original h3 {margin:0 0 18px 0;}
.copyshot_original .r_btn {float:right;}
.copyshot_original .r_btn .btn {font-size:14px; padding:5px 16px 6px; font-weight:normal; border-radius:0;}
.copyshot_original .r_btn span {font-size:18px; color:#444; margin:0 4px 0 0; display:inline-block; vertical-align:top}
.copyshot_original .r_btn b {color:#74b243; margin-left:2px;}
.copyshot_original .name { font-size:16px; color:#444; padding:0 40px 20px;}
.copyshot_original .name span {float:right;}
.copyshot_original .list_btn_pre {position:absolute; left:19px; top:100px; z-index:100;}
.copyshot_original .list_btn_next {position:absolute; right:19px; top:100px; z-index:100;}

.view_movie {margin:0 50px; padding:20px 0 40px 0;}
.view_movie .movie_tit {padding:0 0 26px 20px;}
.view_movie .movie_area {width:750px; position:relative; margin:0 auto;}

.talk_list .reply_feel .btn {border:none; margin:0; padding:0; background:none;}
.talk_list .reply_feel .dropdown-menu { width:400px; height:94px; margin:0 0 4px -10px; padding:0; background:none; border:none; box-shadow:none; border-radius:0;}
.talk_list .reply_feel .dropdown-menu li {width:82px; display:inline-block;}
.talk_list .reply_feel .dropdown-menu a, .reply_feel .dropdown-menu a:hover {background:none; width:82px; display:inline-block; padding:0; margin:0;}
.talk_list .view_btn {margin-bottom:35px;}
.talk_list .reply_feel .dropdown-menu a, .reply_feel ul img {width: 80px;}

.scrap_list {margin:30px 10px;}
.scrap_list .info_pic {padding-left:40px; padding-top:15px;}
.scrap_list .info_pic img {width:100px; height:100px; border-radius:50%;}
.scrap_list .info_cont {padding-left:50px; padding-top:18px;}
.scrap_list .info_cont .title {font-size:24px; font-weight:bold; line-height:30px; padding-top:5px;}
.scrap_list .info_cont .title p span {padding-left:24px; font-size:16px; margin-right:20px; color:#999;}
.scrap_list .info_cont .title p .info_name {background:url(//recipe1.ezmember.co.kr/img/icon_chef.gif) left top no-repeat; font-weight:normal;}
.scrap_list .info_cont .title p .info_recipe {background:url(//recipe1.ezmember.co.kr/img/icon_recipe.gif) left top no-repeat; font-family:Helvetica;}
.scrap_list .info_cont .title p .info_like {color:#de4830; background:url(//recipe1.ezmember.co.kr/img/icon_heart3.gif) left top no-repeat; font-family:Helvetica;}
.scrap_list .info_cont .btn_more {margin-top:12px;}
.scrap_list .list_thumb {padding-top:5px; border-bottom:1px solid #e6e7e8; }
.scrap_list .thumbnail {width:146px; height:146px; margin-right:12px; font-size:0; line-height:0; padding:0; border:1px solid #fff; display:inline-block; border-radius:0; vertical-align:top;}
.scrap_list .thumbnail img { }

.friend_list {margin-top:15px;}
.friend_list.st2 {margin-top:0;}
.friend_list.st2 .list-group-item:last-child {border-bottom:none;}
.friend_list .list-group-item {border-bottom:1px solid #d5d6d7; border-top:1px solid #d5d6d7; border-right:none; border-left:none; padding:18px 15px;}
.friend_list .list-group-item:first-child {border-top:none;}
.friend_list .info_pic {padding-right:16px; display:inline-block; vertical-align:top;}
.friend_list .info_pic img {width:70px; height:70px; border-radius:50%;}
.friend_list .info_name {}
.friend_list .list_r {float:right; padding-top:5px;}
.friend_list .info_cont {display:inline-block; vertical-align:middle; width:640px; padding-top:6px;}
.friend_list .info_cont .info_tit {color:#999; font-size:18px; margin:0 0 6px 0; line-height:1.5; padding-right:10px;}
.friend_list .info_cont_tit {color:#333; font-size:20px;}
.friend_list .info_cont_tit span {}
.friend_list .info_cont_tit .info_name {padding-right:4px;}
.friend_list .info_cont_reply {font-size:17px;}
.friend_list .info_cont_reply .info_name {padding-right:5px;}
.friend_list .info_date {color:#999; font-size:14px;}
.friend_list .list_r .btn-default {font-size:15px; width:68px; background:#ededed; border-radius:0; border:1px solid #d4d4d4; color:#555; font-weight:bold; padding:12px; line-height:1; letter-spacing:-0.06em;}
.friend_list .list_r .btn-default span {font-size:14px; padding-right:2px;}

.recipe_view {border:1px solid #e6e7e8; border-bottom:none; background:#fff; padding:20px; vertical-align:top; position:relative;}
.recipe_view .view_pic {padding:10px 53px 0 15px; display:inline-block; vertical-align:top;}
.recipe_view .view_pic img {width:300px; height:300px;}
.recipe_view .view_pic_menu {padding:10px 53px 10px 15px; display:inline-block; vertical-align:top;}
.recipe_view .view_pic_menu img {width:480px; height:310px;}
.recipe_view .view_info {display:inline-block; padding-top:3px;}
.recipe_view .view_pic_pdt {margin:10px 53px 0 15px; display:inline-block; vertical-align:top; text-align:center;}
.recipe_view .view_pic_pdt .large {margin:0; padding:0;}
.recipe_view .view_pic_pdt .large img {width:300px; height:300px; border:1px solid #ccc;}
.recipe_view .view_pic_pdt .small {padding-top:16px; margin:0;}
.recipe_view .view_pic_pdt .small a { display:inline-block; width:44px; height:44px; border:2px solid #ddd; margin:0 2px; vertical-align:top;}
.recipe_view .view_pic_pdt .small a.active, .recipe_view .view_pic_pdt .small a:hover {border:2px solid #74b243;}
.recipe_view .view_pic_pdt .small a img {width:40px; height:40px;}
.recipe_view .view_mv_pdt {margin:10px 53px 0 15px; display:inline-block; vertical-align:top; text-align:center;}
.info_pdt_btn {margin-top:40px;}
.info_pdt_btn .btn {color:#fff; background:#479ffc; line-height:1.2; padding:14px 100px; font-size:20px; font-weight:normal; border-radius:0; border:none;}

.view_info .info_title {font-size:18px; color:#999; line-height:36px; width:650px; padding-bottom:10px;}
.view_info.st2 .info_title {width:470px;}
.view_info .info_title p {font-size:40px; color:#333; font-weight:bold; margin-left:-6px; line-height:120%;}
.view_info .info_title span {color:#dedede;}
.view_info .info_cont {padding-top:1px;}
.view_info .info_cont span {padding-left:32px; margin-top:10px; color:#999; display:block;}
.view_info .info_cont_1 {background:url(//recipe1.ezmember.co.kr/img/icon_info1.gif) left top no-repeat;}
.view_info .info_cont_2 {background:url(//recipe1.ezmember.co.kr/img/icon_info2.gif) left 1px no-repeat;}
.view_info .info_cont_3 {background:url(//recipe1.ezmember.co.kr/img/icon_info3.gif) left 2px no-repeat;}
.view_info .info_share {width:780px; padding:0 6px 12px 0; border-bottom:1px solid #e6e7e8;}
.view_info.st2 .info_share {width:600px; margin-top:56px;}
.view_info .info_share a {margin:0 2px;}
.view_info .info_share_in {width:500px; display:inline-block; margin:0;}
.view_info.st2 .info_share_in { width:100%;}
.view_info .info_share_in span {color:#ccc; padding:0 14px; font-size:16px;}
.view_info .info_share_btn {width:270px; display:inline-block; text-align:right; margin:0; vertical-align:text-bottom;}
.view_info .info_chef {width:780px; padding-top:14px; }
.view_info.st2 .info_chef {width:600px;}
.view_info .info_chef_pic {display:inline-block; padding-right:12px; vertical-align:top;}
.view_info .info_chef_pic img {width:70px; height:70px; border-radius:50%; border:1px solid #ddd;}
.view_info .info_chef_name {display:inline-block; font-size:20px; font-weight:bold; color:#de4830; line-height:20px; padding-top:14px;}
.view_info .info_chef_name p {font-size:14px; color:#333; font-weight:normal; padding-top:6px;}
.view_info .info_chef_name p span {color:#ccc; padding:0 14px; font-size:16px;}
.view_cont {padding:35px 54px;}
.view_cont.st2 {padding:28px 0 35px;}
.view_cont.st2 .theme_list {margin:30px 0 20px 0; padding:0 21px;}
.view_cont.st2 .theme_list .best_label {position:absolute; top:4px; right:4px; z-index:10;}
.view_cont.st2 .theme_list .best_label img {width:40px; height:40px;}
.view_cont.st2 .theme_list .menu_label {position:absolute; top:4px; left:4px; z-index:10; opacity: 0.9; filter: alpha(opacity=90);}
.view_cont.st2 .theme_list .menu_label img {width:50px; height:50px;}
.view_cont.st2 .theme_list .vod_label {position:absolute; right:4px; top:86px; z-index:10;}
.view_cont.st2 .theme_list .vod_label img {border-bottom:none !important;}
.view_cont.st3 {font-size:16px; line-height:190%; padding:30px 45px;}
.ready_ingre3 {padding:0 20px 18px 24px; vertical-align:top;}
.ready_ingre3_tt {padding-bottom:8px; color:#333; font-size:16px; padding-left:20px; display:block;}
.ready_ingre3 ul {padding:0 0 25px 0; width:49%; display:inline-block; vertical-align:top;}
.ready_ingre3 ul.case1 {width:100%;}
.ready_ingre3 ul.case1 li {width:45%; display:inline-block; vertical-align:top;}
.ready_ingre3 li {border-bottom:1px solid #ececec; padding:10px 6px; list-style:none; margin:0 18px; font-size:16px;font-weight:300;}
.ready_ingre3 li a {margin:-1px 0 0 5px; vertical-align:middle; display:inline-block; }
.ready_ingre3 li a img {width:19px; height:19px; vertical-align:sub;}
.ready_ingre3 li .ingre_unit {float:right; color:#999; margin-top: 2px;}
.ready_ingre3 li .ingre_list_btn {display: inline-block; float: right; font-size: 14px; color: #222; border: 1px solid #d7d7d7; padding:5px 14px 7px; line-height: 1; border-radius:15px; margin-left:20px;}

.view_cont_old {padding:45px 54px 40px; line-height:160%; font-family:se-nanumsquare, 'Nanum Gothic', sans-serif; font-size: 15px;}
.view_cont_old b {font-weight: bold;}
.view_cont_old p {line-height:180%; margin-bottom: 0;}
.view_cont_old img {max-width:100%;}
.view_cont .cont_intro {font-size:16px; line-height:190%; padding:16px;}
.view_cont.st2 .cont_intro {padding:0 30px;}
.view_cont .cont_intro2 {background:#f4f4f4; border-radius:10px; padding:20px 35px; margin:0 30px 35px; font-size:16px; line-height:190%; color:#000;}
.view_cont .cont_ingre {background:#f1f1f2; border-radius:10px; padding:24px 45px 2px; margin-top:24px; font-size:18px; color:#000;}
.view_cont .cont_ingre dd {padding-bottom:10px;}
.view_cont .cont_ingre dt {font-weight:bold; padding-bottom:2px;}
.view_cont .cont_ingre dd {line-height:170%;}
.cont_ingre2 {padding:35px 20px 0 25px;}
.cont_ingre2 .best_tit {margin:0 -25px;}


/**
* @se/product-blog/v1.4.1 - 2020-02-13 15:33:29
* Copyright(c) 2020, NAVER corp, SmartEditor
*/
@font-face {
    font-family: se-nanumgothic;
    font-weight: 400;
    src: url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumgothic-regular.eot?iefix") format("embedded-opentype"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumgothic-regular.woff2") format("woff2"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumgothic-regular.woff") format("woff"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumgothic-regular.ttf") format("truetype")
}
@font-face {
    font-family: se-nanumgothic;
    font-weight: 700;
    src: url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumgothic-bold.eot?iefix") format("embedded-opentype"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumgothic-bold.woff2") format("woff2"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumgothic-bold.woff") format("woff"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumgothic-bold.ttf") format("truetype")
}
@font-face {
    font-family: se-nanummyeongjo;
    font-weight: 400;
    src: url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanummyeongjo-regular.eot?iefix") format("embedded-opentype"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanummyeongjo-regular.woff2") format("woff2"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanummyeongjo-regular.woff") format("woff"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanummyeongjo-regular.ttf") format("truetype")
}
@font-face {
    font-family: se-nanummyeongjo;
    font-weight: 700;
    src: url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanummyeongjo-bold.eot?iefix") format("embedded-opentype"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanummyeongjo-bold.woff2") format("woff2"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanummyeongjo-bold.woff") format("woff"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanummyeongjo-bold.ttf") format("truetype")
}
@font-face {
    font-family: se-nanumbarungothic;
    font-weight: 400;
    src: url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumbarungothic-regular.eot?iefix") format("embedded-opentype"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumbarungothic-regular.woff2") format("woff2"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumbarungothic-regular.woff") format("woff"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumbarungothic-regular.ttf") format("truetype")
}
@font-face {
    font-family: se-nanumbarungothic;
    font-weight: 700;
    src: url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumbarungothic-bold.eot?iefix") format("embedded-opentype"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumbarungothic-bold.woff2") format("woff2"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumbarungothic-bold.woff") format("woff"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumbarungothic-bold.ttf") format("truetype")
}
@font-face {
    font-family: se-nanumsquare;
    font-weight: 400;
    src: url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumsquare-regular.eot?iefix") format("embedded-opentype"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumsquare-regular.woff2") format("woff2"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumsquare-regular.woff") format("woff"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumsquare-regular.ttf") format("truetype")
}
@font-face {
    font-family: se-nanumsquare;
    font-weight: 700;
    src: url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumsquare-bold.eot?iefix") format("embedded-opentype"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumsquare-bold.woff2") format("woff2"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumsquare-bold.woff") format("woff"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-nanumsquare-bold.ttf") format("truetype")
}
@font-face {
    font-family: se-sourcecodepro;
    font-weight: 400;
    src: url("https://editor-static.pstatic.net/c/resources/common/fonts/se-sourcecodepro-regular.eot?iefix") format("embedded-opentype"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-sourcecodepro-regular.woff2") format("woff2"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-sourcecodepro-regular.woff") format("woff"), url("https://editor-static.pstatic.net/c/resources/common/fonts/se-sourcecodepro-regular.ttf") format("truetype")
}
@font-face {
    font-family: Symbola;
    src: url(https://ssl.pstatic.net/static/matheditor/1.0.14/Symbola.eot);
    src: local("Symbola Regular"), local("Symbola"), url(https://ssl.pstatic.net/static/matheditor/1.0.14/Symbola.woff2) format("woff2"), url(https://ssl.pstatic.net/static/matheditor/1.0.14/Symbola.woff) format("woff"), url(https://ssl.pstatic.net/static/matheditor/1.0.14/Symbola.ttf) format("truetype"), url(https://ssl.pstatic.net/static/matheditor/1.0.14/Symbola.svg#Symbola) format("svg")
}
.view_cont_old .se-360vr-fullscreen-button:before, .view_cont_old .se-360vr-gyro-loading, .view_cont_old .se-360vr-loading, .view_cont_old .se-360vr-state-info:before, .view_cont_old .se-file-icon, .view_cont_old .se-file-save-button:before, .view_cont_old .se-file-save-option-button.se-file-save-option-button-cloud:before, .view_cont_old .se-file-save-option-button.se-file-save-option-button-local:before, .view_cont_old .se-gyro-disabled, .view_cont_old .se-l-anniversary_autumn .se-anniversary-date-info:after, .view_cont_old .se-l-anniversary_spring .se-anniversary-date-info:after, .view_cont_old .se-l-anniversary_summer .se-anniversary-date-info:after, .view_cont_old .se-l-anniversary_winter .se-anniversary-date-info:after, .view_cont_old .se-material-npay, .view_cont_old .se-schedule-detail-description .se-schedule-info:before, .view_cont_old .se-schedule-detail-location .se-schedule-info:before, .view_cont_old .se-schedule-detail-url .se-schedule-info:before, .view_cont_old .se-section-horizontalLine.se-l-line3 .se-hr, .view_cont_old .se-section-horizontalLine.se-l-line4 .se-hr, .view_cont_old .se-section-horizontalLine.se-l-line5 .se-hr, .view_cont_old .se-section-horizontalLine.se-l-line6 .se-hr, .view_cont_old .se-section-imageGroup .se-imageGroup-navigation-button.se-imageGroup-navigation-button-next:before, .view_cont_old .se-section-imageGroup .se-imageGroup-navigation-button.se-imageGroup-navigation-button-prev:before, .view_cont_old .se-section-oglink.se-l-shopping_affiliate_image .se-oglink-npay, .view_cont_old .se-section-oglink.se-l-shopping_affiliate_text .se-oglink-npay, .view_cont_old .se-section-oglink .se-oglink-thumbnail-video-icon, .view_cont_old .se-section-placesMap.se-l-map_text .se-map-marker:before, .view_cont_old .se-section-placesMap .se-placesMap-button-bookmark.se-placesMap-button-bookmark-saved:before, .view_cont_old .se-section-placesMap .se-placesMap-button-bookmark:before, .view_cont_old .se-section-placesMap .se-placesMap-button-call:before, .view_cont_old .se-section-placesMap .se-placesMap-button-reservation:before, .view_cont_old .se-section-placesMap.se-section-placesMap-multiple .se-module-map-text:before, .view_cont_old .se-section-quotation.se-l-default .se-quotation-container:after, .view_cont_old .se-section-quotation.se-l-default .se-quotation-container:before, .view_cont_old .se-section-quotation.se-l-quotation_bubble .se-quotation-container:after, .view_cont_old .se-section-quotation.se-l-quotation_postit .se-quotation-container:before, .view_cont_old .se-section-quotation.se-l-quotation_underline .se-quotation-container:before, .view_cont_old .se-talktalk.se-l-default .se-module-talktalk:after, .view_cont_old .se-talktalk.se-l-default .se-module-talktalk:before, .view_cont_old .se-talktalk .se-talktalk-banner-text:before, .view_cont_old .se-video .se-media-meta-toggle-button:after {
    background-image: url(//editor-static.pstatic.net/v/blog//img/se-sp-viewer.4dc622f3.png);
    background-repeat: no-repeat;
    background-size: 390px 319px
}
.se-viewer { /* font-family:se-nanumgothic,sans-serif; */ /* line-height:1; */ /* -webkit-font-smoothing:antialiased; */
}
.se-viewer a, .se-viewer audio, .se-viewer blockquote, .se-viewer caption, .se-viewer code, .se-viewer dd, .se-viewer del, .se-viewer div, .se-viewer dl, .se-viewer dt, .se-viewer em, .se-viewer embed, .se-viewer h1, .se-viewer h2, .se-viewer h3, .se-viewer h4, .se-viewer h5, .se-viewer h6, .se-viewer iframe, .se-viewer img, .se-viewer ins, .se-viewer li, .se-viewer mark, .se-viewer object, .se-viewer ol, .se-viewer p, .se-viewer pre, .se-viewer q, .se-viewer s, .se-viewer small, .se-viewer span, .se-viewer strike, .se-viewer summary, .se-viewer table, .se-viewer tbody, .se-viewer td, .se-viewer tfoot, .se-viewer th, .se-viewer thead, .se-viewer tr, .se-viewer ul, .se-viewer video {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 12px; /* font:inherit; */ vertical-align: baseline;
}
.se-viewer b {
    font-weight: bold;
}
.se-viewer i {
    font-style: italic
}
.se-viewer u {
    text-decoration: underline
}
.se-viewer strike {
    text-decoration: line-through
}
.se-viewer button {
    border: none;
    margin: 0;
    padding: 0;
    width: auto;
    overflow: visible;
    background: transparent;
    color: inherit;
    font: inherit;
    line-height: normal;
    -webkit-font-smoothing: inherit;
    -moz-osx-font-smoothing: inherit;
    -webkit-appearance: none;
    cursor: pointer
}
.se-viewer button::-moz-focus-inner {
    border: 0;
    padding: 0
}
.se-viewer ol, .se-viewer ul {
    list-style: none
}
.se-viewer blockquote, .se-viewer q {
    quotes: none
}
.se-viewer blockquote:after, .se-viewer blockquote:before, .se-viewer q:after, .se-viewer q:before {
    content: none
}
.se-viewer table {
    border-collapse: collapse;
    border-spacing: 0
}
.view_cont_old .se-blind {
    position: absolute;
    overflow: hidden;
    clip: rect(0 0 0 0);
    width: 1px;
    height: 1px
}
.view_cont_old .rangeslider, .view_cont_old .rangeslider__fill {
    display: block;
    height: 2px;
    width: 100%;
    cursor: pointer
}
.view_cont_old .rangeslider {
    position: relative;
    background: #e5e5e5;
    border-radius: 3px
}
.view_cont_old .rangeslider--disabled {
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=40);
    opacity: .4
}
.view_cont_old .rangeslider__fill {
    background: #00c73c;
    border-radius: 3px;
    position: absolute;
    top: 0
}
.view_cont_old .rangeslider__handle {
    position: absolute;
    width: 16px;
    height: 16px;
    border: 1px solid #ccc;
    border-radius: 50%;
    background-color: #fff;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .1);
    cursor: pointer;
    cursor: grab;
    touch-action: pan-x;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0)
}
.view_cont_old .rangeslider__handle:active, .view_cont_old .rangeslider__handle:hover {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .4)
}
.view_cont_old .rangeslider__handle:focus {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .4);
    outline: none
}
.view_cont_old .rangeslider__handle:active {
    cursor: grabbing
}
.view_cont_old .se-module-text b, .view_cont_old .se-module-text i, .view_cont_old .se-module-text strike, .view_cont_old .se-module-text u {
    background-color: inherit
}
.view_cont_old .se-text-paragraph {
    word-wrap: break-word;
    word-break: break-word;
    overflow-wrap: break-word;
    white-space: pre-wrap
}
.view_cont_old .se-text-paragraph-align-left {
    text-align: left
}
.view_cont_old .se-text-paragraph-align-center {
    text-align: center
}
.view_cont_old .se-text-paragraph-align-right {
    text-align: right
}
.view_cont_old .se-text-paragraph-align-justify {
    text-align: justify;
    white-space: normal !important
}
.view_cont_old .se-inline-image {
    display: inline-block;
    vertical-align: text-bottom;
    font-size: 0 !important
}
.view_cont_old .se-inline-image .se-inline-image-resource {
    width: 100%
}
.view_cont_old .se-inline-image .se-state-error {
    width: 200px
}
.view_cont_old .se-inline-image .se-state-error .se-state-error-detail {
    right: 50px;
    left: 50px
}
.view_cont_old .se-inline-image .se-state-error .se-state-error-detail:before {
    display: none
}
.view_cont_old .se-module-text b { /* font-family:inherit */
}
.view_cont_old .se-state-error {
    position: relative;
    display: inline-block;
    width: 100%;
    padding-top: 56%;
    background: #fcfcfc;
    border: 1px solid #e9e9e9;
    box-sizing: border-box
}
.view_cont_old .se-state-error[style*=height] {
    padding-top: 0
}
.view_cont_old .se-state-error.se-state-error-small .se-state-error-detail:before, .view_cont_old .se-state-error.se-state-error-tiny .se-state-error-detail {
    display: none
}
.view_cont_old .se-state-error .se-state-error-detail {
    position: absolute;
    left: 12%;
    right: 12%;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    text-align: center
}
.view_cont_old .se-state-error .se-state-error-detail .se-state-error-text {
    font-family: se-nanumsquare, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo;
    font-size: 16px;
    line-height: 1.38;
    color: #ccc;
    white-space: normal
}
.view_cont_old .se-module-map-text {
    text-decoration: none
}
.view_cont_old .se-map-info {
    display: block;
    line-height: 1.3;
    text-decoration: none;
    font-size: 0
}
.view_cont_old .se-map-address {
    text-decoration: none
}
.view_cont_old .se-map-address, .view_cont_old .se-map-title {
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all
}
.view_cont_old .se-map-title {
    display: block;
    position: relative;
    max-width: 100%;
    box-sizing: border-box
}
.view_cont_old .se-map-image {
    display: block;
    width: 100%
}
.view_cont_old .se-fs-fs11 {
    font-size: 13px;
    font-size: 11px
}
.view_cont_old .se-fs-fs13 {
    font-size: 15px;
    font-size: 13px
}
.view_cont_old .se-fs-fs15 {
    font-size: 16px;
    font-size: 15px
}
.view_cont_old .se-fs-fs16 {
    font-size: 17px;
    font-size: 16px
}
.view_cont_old .se-fs-fs19 {
    font-size: 20px;
    font-size: 19px
}
.view_cont_old .se-fs-fs24 {
    font-size: 22px;
    font-size: 24px
}
.view_cont_old .se-fs-fs26 {
    font-size: 24px;
    font-size: 26px
}
.view_cont_old .se-fs-fs28 {
    font-size: 23px;
    font-size: 28px
}
.view_cont_old .se-fs-fs30 {
    font-size: 26px;
    font-size: 30px
}
.view_cont_old .se-fs-fs32 {
    font-size: 26px;
    font-size: 32px
}
.view_cont_old .se-fs-fs34 {
    font-size: 27px;
    font-size: 34px
}
.view_cont_old .se-fs-fs38 {
    font-size: 28px;
    font-size: 38px
}
.view_cont_old .se-fs-fs45 {
    font-size: 30px;
    font-size: 45px
}
.view_cont_old .se-ff-system {
    font-family: HelveticaNeue, Helvetica Neue, helvetica, AppleSDGothicNeo, arial, malgun gothic, "\B9D1\C740 \ACE0\B515", sans-serif, Meiryo
}
.view_cont_old .se-ff-nanumgothic {
    font-family: se-nanumgothic, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo
}
.view_cont_old .se-ff-nanummyeongjo {
    font-family: se-nanummyeongjo, \\B098\B214\BA85\C870, nanummyeongjo, serif, simsun
}
.view_cont_old .se-ff-nanumbarungothic {
    font-family: se-nanumbarungothic, \\B098\B214\BC14\B978\ACE0\B515, nanumbarungothic, sans-serif, Meiryo;
}
.view_cont_old .se-ff-nanumsquare {
    font-family: se-nanumsquare, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo
}
.view_cont_old .se-component {
    position: relative
}
.view_cont_old .se-component:first-child {
    margin-top: 0
}
.view_cont_old .se-component-content {
    padding-right: 20px;
    padding-left: 20px;
    margin: 0 auto;
    max-width: 640px;
    max-width: 100%;
    padding-right: 40px;
    padding-left: 40px
}
.view_cont_old .se-component-content.se-component-content-extend, .view_cont_old .se-component-content.se-component-content-fit, .view_cont_old .se-component-content.se-component-content-pagefull {
    max-width: 100%
}
.view_cont_old .se-component-content.se-component-content-pagefull {
    padding-right: 0;
    padding-left: 0
}
.view_cont_old .se-section-align-left {
    margin-right: auto;
    margin-left: 0
}
.view_cont_old .se-section-align-center {
    margin-right: auto;
    margin-left: auto
}
.view_cont_old .se-section-align-right {
    margin-right: 0;
    margin-left: auto
}
.view_cont_old .se-text-paragraph {
    font-size: 0
}
.view_cont_old .se-text-paragraph-align-left {
    text-align: left !important
}
.view_cont_old .se-text-paragraph-align-center {
    text-align: center !important
}
.view_cont_old .se-text-paragraph-align-right {
    text-align: right !important
}
.view_cont_old .se-text-paragraph-align-justify {
    text-align: justify !important;
    white-space: pre-line
}
.view_cont_old .se-link {
    color: #608cba !important;
    text-decoration: underline;
    -webkit-text-decoration-skip: none;
    text-decoration-skip-ink: none;
    word-break: break-all
}
.view_cont_old .se-image-resource {
    position: relative;
    width: 100%;
    vertical-align: top
}
.view_cont_old .se-caption {
    margin-right: auto;
    margin-left: auto;
    max-width: 640px;
    max-width: 100%
}
.view_cont_old .se-caption span {
    color: #555
}
.view_cont_old .se-style-unset { /* font-style:normal!important */
}
.view_cont_old .se-weight-unset {
    font-weight: 400 !important
}
.view_cont_old .se-decoration-unset {
    text-decoration: none !important
}
.view_cont_old .se-documentTitle.se-l-default .se-fs- {
    font-size: 26px;
    font-size: 32px
}
.se-viewer:lang(ko-KR) .se-documentTitle.se-l-default .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-documentTitle {
    position: relative;
    margin-bottom: 26px;
    margin-bottom: 40px
}
.view_cont_old .se-documentTitle.se-component {
    margin-top: 0
}
.view_cont_old .se-documentTitle .se-component-content:after {
    content: "";
    position: absolute;
    right: 20px;
    left: 20px;
    border-bottom: 1px solid rgba(0, 0, 0, .1);
    right: 40px;
    left: 40px
}
.view_cont_old .se-documentTitle.se-documentTitle-cover-image .se-title-cover-wrap {
    display: block
}
.view_cont_old .se-documentTitle.se-documentTitle-cover-image .se-component-content:after {
    display: none
}
.view_cont_old .se-documentTitle.se-documentTitle-cover-image .se-component-content .se-text-paragraph {
    color: #fff
}
.view_cont_old .se-documentTitle.se-documentTitle-cover-image .se-section-align-, .view_cont_old .se-documentTitle.se-documentTitle-cover-image .se-section-align-left {
    padding-top: 83px;
    padding-bottom: 30px;
    padding-top: 80px;
    padding-bottom: 29px
}
.view_cont_old .se-documentTitle.se-documentTitle-cover-image .se-section-align-center {
    padding-top: 55px;
    padding-bottom: 30px;
    padding-top: 65px;
    padding-bottom: 29px
}
.view_cont_old .se-documentTitle .se-section-align-, .view_cont_old .se-documentTitle .se-section-align-left {
    padding-top: 35px;
    padding-bottom: 30px;
    padding-top: 40px;
    padding-bottom: 29px
}
.view_cont_old .se-documentTitle .se-section-align-center {
    padding-top: 55px;
    padding-bottom: 30px;
    padding-top: 65px;
    padding-bottom: 31px
}
.view_cont_old .se-documentTitle .se-component-content {
    position: relative
}
.view_cont_old .se-documentTitle .se-fs-fs26 {
    line-height: 35px;
    line-height: 41px
}
.view_cont_old .se-documentTitle .se-fs- {
    line-height: 37px;
    line-height: 48px
}
.view_cont_old .se-documentTitle .se-fs-fs32 {
    line-height: 37px;
    line-height: 48px
}
.view_cont_old .se-documentTitle .se-fs-fs38 {
    line-height: 39px;
    line-height: 55px
}
.view_cont_old .se-title-cover-exception-image {
    opacity: 0;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto
}
.view_cont_old .se-title-cover-wrap {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    display: none;
    margin: auto;
    width: 100%
}
.view_cont_old .se-title-cover {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    overflow: hidden;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: 50% 50%
}
.view_cont_old .se-title-cover:after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    content: "";
    background-color: rgba(0, 0, 0, .2)
}
.view_cont_old .se-sectionTitle {
    margin-top: 25px;
    margin-top: 30px
}
.view_cont_old .se-text + .se-sectionTitle {
    margin-top: 10px
}
.view_cont_old .se-sectionTitle + .se-sectionTitle {
    margin-top: 0
}
.view_cont_old .se-sticker + .se-sectionTitle {
    margin-top: 20px
}
.view_cont_old .se-horizontalLine + .se-sectionTitle {
    margin-top: 30px
}
.view_cont_old .se-image + .se-sectionTitle, .view_cont_old .se-imageGroup + .se-sectionTitle, .view_cont_old .se-imageStrip + .se-sectionTitle {
    margin-top: 20px
}
.view_cont_old .se-section-sectionTitle.se-l-default .se-fs- {
    font-size: 26px;
    font-size: 30px
}
.se-viewer:lang(ko-KR) .se-section-sectionTitle.se-l-default .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-sectionTitle.se-l-default .se-text-paragraph {
    line-height: 1.5
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs- {
    font-size: 28px;
    font-size: 32px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs11 {
    font-size: 15px;
    font-size: 13px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs13 {
    font-size: 17px;
    font-size: 15px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs15 {
    font-size: 18px;
    font-size: 17px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs16 {
    font-size: 19px;
    font-size: 18px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs19 {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs24 {
    font-size: 24px;
    font-size: 26px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs26 {
    font-size: 26px;
    font-size: 28px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs28 {
    font-size: 25px;
    font-size: 30px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs30 {
    font-size: 28px;
    font-size: 32px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs32 {
    font-size: 28px;
    font-size: 34px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs34 {
    font-size: 29px;
    font-size: 36px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs38 {
    font-size: 30px;
    font-size: 40px
}
.se-viewer.se-viewer-text-scale-1 .se-section-sectionTitle.se-l-default .se-fs-fs45 {
    font-size: 32px;
    font-size: 47px
}
.view_cont_old .se-text {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-wrappingParagraph + .se-text {
    margin-top: 0
}
.view_cont_old .se-sectionTitle + .se-text {
    margin-top: 10px
}
.view_cont_old .se-horizontalLine + .se-text, .view_cont_old .se-sticker + .se-text {
    margin-top: 20px
}
.view_cont_old .se-horizontalLine + .se-text {
    margin-top: 30px
}
.view_cont_old .se-image + .se-text, .view_cont_old .se-imageGroup + .se-text, .view_cont_old .se-imageStrip + .se-text, .view_cont_old .se-video + .se-text {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-text {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-text.se-l-default .se-fs- {
    font-size: 16px;
    font-size: 15px
}
.se-viewer:lang(ko-KR) .se-section-text.se-l-default .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-text.se-l-default .se-text-paragraph {
    line-height: 1.8
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs- {
    font-size: 18px;
    font-size: 17px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs11 {
    font-size: 15px;
    font-size: 13px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs13 {
    font-size: 17px;
    font-size: 15px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs15 {
    font-size: 18px;
    font-size: 17px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs16 {
    font-size: 19px;
    font-size: 18px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs19 {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs24 {
    font-size: 24px;
    font-size: 26px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs26 {
    font-size: 26px;
    font-size: 28px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs28 {
    font-size: 25px;
    font-size: 30px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs30 {
    font-size: 28px;
    font-size: 32px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs32 {
    font-size: 28px;
    font-size: 34px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs34 {
    font-size: 29px;
    font-size: 36px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs38 {
    font-size: 30px;
    font-size: 40px
}
.se-viewer.se-viewer-text-scale-1 .se-section-text.se-l-default .se-fs-fs45 {
    font-size: 32px;
    font-size: 47px
}
.view_cont_old .se-section-text:after {
    display: block;
    content: "";
    clear: both
}
.view_cont_old .se-section-text .se-text-paragraph-drop-cap {
    clear: left
}
.view_cont_old .se-drop-cap {
    float: left;
    line-height: .62;
    padding-right: .15em;
    padding-top: .34em;
    padding-bottom: .2em;
    background-color: inherit;
    text-transform: uppercase;
    text-decoration: none !important;
    font-style: normal !important;
    font-weight: 400 !important;
    font-size: 3em !important
}
.view_cont_old .se-quotation {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-quotation.se-l-default .se-quote .se-fs- {
    font-size: 20px;
    font-size: 19px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-default .se-quote .se-ff- {
    font-family: se-nanummyeongjo, serif
}
.view_cont_old .se-section-quotation.se-l-default .se-quote .se-text-paragraph {
    line-height: 1.8;
    text-align: center
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs- {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs11 {
    font-size: 15px;
    font-size: 13px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs13 {
    font-size: 17px;
    font-size: 15px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs15 {
    font-size: 18px;
    font-size: 17px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs16 {
    font-size: 19px;
    font-size: 18px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs19 {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs24 {
    font-size: 24px;
    font-size: 26px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs26 {
    font-size: 26px;
    font-size: 28px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs28 {
    font-size: 25px;
    font-size: 30px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs30 {
    font-size: 28px;
    font-size: 32px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs32 {
    font-size: 28px;
    font-size: 34px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs34 {
    font-size: 29px;
    font-size: 36px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs38 {
    font-size: 30px;
    font-size: 40px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-default .se-quote .se-fs-fs45 {
    font-size: 32px;
    font-size: 47px
}
.view_cont_old .se-section-quotation.se-l-default .se-cite .se-fs- {
    font-size: 15px;
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-default .se-cite .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-quotation.se-l-default .se-cite .se-text-paragraph {
    line-height: 1.5;
    text-align: center
}
.view_cont_old .se-section-quotation.se-l-quotation_line .se-quote .se-fs- {
    font-size: 20px;
    font-size: 19px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-quotation_line .se-quote .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-quotation.se-l-quotation_line .se-quote .se-text-paragraph {
    line-height: 1.8;
    text-align: left
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs- {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs11 {
    font-size: 15px;
    font-size: 13px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs13 {
    font-size: 17px;
    font-size: 15px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs15 {
    font-size: 18px;
    font-size: 17px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs16 {
    font-size: 19px;
    font-size: 18px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs19 {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs24 {
    font-size: 24px;
    font-size: 26px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs26 {
    font-size: 26px;
    font-size: 28px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs28 {
    font-size: 25px;
    font-size: 30px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs30 {
    font-size: 28px;
    font-size: 32px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs32 {
    font-size: 28px;
    font-size: 34px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs34 {
    font-size: 29px;
    font-size: 36px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs38 {
    font-size: 30px;
    font-size: 40px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_line .se-quote .se-fs-fs45 {
    font-size: 32px;
    font-size: 47px
}
.view_cont_old .se-section-quotation.se-l-quotation_line .se-cite .se-fs- {
    font-size: 15px;
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-quotation_line .se-cite .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-quotation.se-l-quotation_line .se-cite .se-text-paragraph {
    line-height: 1.5;
    text-align: left
}
.view_cont_old .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs- {
    font-size: 20px;
    font-size: 19px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-quotation_bubble .se-quote .se-ff- {
    font-family: se-nanummyeongjo, serif
}
.view_cont_old .se-section-quotation.se-l-quotation_bubble .se-quote .se-text-paragraph {
    line-height: 1.8;
    text-align: center
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs- {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs11 {
    font-size: 15px;
    font-size: 13px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs13 {
    font-size: 17px;
    font-size: 15px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs15 {
    font-size: 18px;
    font-size: 17px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs16 {
    font-size: 19px;
    font-size: 18px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs19 {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs24 {
    font-size: 24px;
    font-size: 26px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs26 {
    font-size: 26px;
    font-size: 28px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs28 {
    font-size: 25px;
    font-size: 30px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs30 {
    font-size: 28px;
    font-size: 32px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs32 {
    font-size: 28px;
    font-size: 34px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs34 {
    font-size: 29px;
    font-size: 36px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs38 {
    font-size: 30px;
    font-size: 40px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_bubble .se-quote .se-fs-fs45 {
    font-size: 32px;
    font-size: 47px
}
.view_cont_old .se-section-quotation.se-l-quotation_bubble .se-cite .se-fs- {
    font-size: 15px;
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-quotation_bubble .se-cite .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-quotation.se-l-quotation_bubble .se-cite .se-text-paragraph {
    line-height: 1.5;
    text-align: center
}
.view_cont_old .se-section-quotation.se-l-quotation_underline .se-quote .se-fs- {
    font-size: 20px;
    font-size: 19px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-quotation_underline .se-quote .se-ff- {
    font-family: se-nanummyeongjo, serif
}
.view_cont_old .se-section-quotation.se-l-quotation_underline .se-quote .se-text-paragraph {
    line-height: 1.8;
    text-align: left
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs- {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs11 {
    font-size: 15px;
    font-size: 13px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs13 {
    font-size: 17px;
    font-size: 15px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs15 {
    font-size: 18px;
    font-size: 17px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs16 {
    font-size: 19px;
    font-size: 18px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs19 {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs24 {
    font-size: 24px;
    font-size: 26px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs26 {
    font-size: 26px;
    font-size: 28px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs28 {
    font-size: 25px;
    font-size: 30px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs30 {
    font-size: 28px;
    font-size: 32px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs32 {
    font-size: 28px;
    font-size: 34px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs34 {
    font-size: 29px;
    font-size: 36px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs38 {
    font-size: 30px;
    font-size: 40px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_underline .se-quote .se-fs-fs45 {
    font-size: 32px;
    font-size: 47px
}
.view_cont_old .se-section-quotation.se-l-quotation_underline .se-cite .se-fs- {
    font-size: 15px;
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-quotation_underline .se-cite .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-quotation.se-l-quotation_underline .se-cite .se-text-paragraph {
    line-height: 1.5;
    text-align: left
}
.view_cont_old .se-section-quotation.se-l-quotation_postit .se-quote .se-fs- {
    font-size: 20px;
    font-size: 19px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-quotation_postit .se-quote .se-ff- {
    font-family: se-nanumbarungothic, sans-serif
}
.view_cont_old .se-section-quotation.se-l-quotation_postit .se-quote .se-text-paragraph {
    line-height: 1.8;
    text-align: center
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs- {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs11 {
    font-size: 15px;
    font-size: 13px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs13 {
    font-size: 17px;
    font-size: 15px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs15 {
    font-size: 18px;
    font-size: 17px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs16 {
    font-size: 19px;
    font-size: 18px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs19 {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs24 {
    font-size: 24px;
    font-size: 26px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs26 {
    font-size: 26px;
    font-size: 28px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs28 {
    font-size: 25px;
    font-size: 30px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs30 {
    font-size: 28px;
    font-size: 32px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs32 {
    font-size: 28px;
    font-size: 34px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs34 {
    font-size: 29px;
    font-size: 36px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs38 {
    font-size: 30px;
    font-size: 40px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_postit .se-quote .se-fs-fs45 {
    font-size: 32px;
    font-size: 47px
}
.view_cont_old .se-section-quotation.se-l-quotation_postit .se-cite .se-fs- {
    font-size: 15px;
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-quotation_postit .se-cite .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-quotation.se-l-quotation_postit .se-cite .se-text-paragraph {
    line-height: 1.5;
    text-align: center
}
.view_cont_old .se-section-quotation.se-l-quotation_corner .se-quote .se-fs- {
    font-size: 20px;
    font-size: 19px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-quotation_corner .se-quote .se-ff- {
    font-family: se-nanumbarungothic, sans-serif
}
.view_cont_old .se-section-quotation.se-l-quotation_corner .se-quote .se-text-paragraph {
    line-height: 1.8;
    text-align: center
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs- {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs11 {
    font-size: 15px;
    font-size: 13px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs13 {
    font-size: 17px;
    font-size: 15px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs15 {
    font-size: 18px;
    font-size: 17px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs16 {
    font-size: 19px;
    font-size: 18px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs19 {
    font-size: 22px;
    font-size: 21px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs24 {
    font-size: 24px;
    font-size: 26px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs26 {
    font-size: 26px;
    font-size: 28px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs28 {
    font-size: 25px;
    font-size: 30px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs30 {
    font-size: 28px;
    font-size: 32px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs32 {
    font-size: 28px;
    font-size: 34px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs34 {
    font-size: 29px;
    font-size: 36px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs38 {
    font-size: 30px;
    font-size: 40px
}
.se-viewer.se-viewer-text-scale-1 .se-section-quotation.se-l-quotation_corner .se-quote .se-fs-fs45 {
    font-size: 32px;
    font-size: 47px
}
.view_cont_old .se-section-quotation.se-l-quotation_corner .se-cite .se-fs- {
    font-size: 15px;
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-quotation.se-l-quotation_corner .se-cite .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-quotation.se-l-quotation_corner .se-cite .se-text-paragraph {
    line-height: 1.5;
    text-align: center
}
.view_cont_old .se-quotation .se-component-content {
    position: relative
}
.view_cont_old .se-quotation-container {
    position: relative;
    margin: auto;
    box-sizing: border-box
}
.view_cont_old .se-section-quotation {
    margin: 0 auto
}
.view_cont_old .se-section-quotation .se-cite .se-text-paragraph {
    color: #777
}
.view_cont_old .se-section-quotation .se-cite .se-text-paragraph .se-fs- {
    font-size: 13px
}
.view_cont_old .se-section-quotation.se-l-default {
    padding-top: 10px;
    padding-bottom: 10px
}
.view_cont_old .se-section-quotation.se-l-default .se-quotation-container {
    padding: 31px 0
}
.view_cont_old .se-section-quotation.se-l-default .se-quotation-container:after, .view_cont_old .se-section-quotation.se-l-default .se-quotation-container:before {
    content: "";
    position: absolute;
    right: 0;
    left: 0;
    margin: auto
}

.view_cont_old .se-section-quotation.se-l-default .se-quotation-container:before {
    width: 21px;
    height: 16px;
    background-position: -261px -265px;
    top: 0
}
.view_cont_old .se-section-quotation.se-l-default .se-quotation-container:after {
    width: 21px;
    height: 16px;
    background-position: -284px -265px;
    bottom: 0
}
.view_cont_old .se-section-quotation.se-l-default .se-quote span {
    font-style: italic
}
.view_cont_old .se-section-quotation.se-l-default .se-cite {
    margin-top: 20px
}
.view_cont_old .se-section-quotation.se-l-quotation_line {
    padding-top: 10px;
    padding-bottom: 10px
}
.view_cont_old .se-section-quotation.se-l-quotation_line .se-quotation-container {
    padding: 0 20px
}
.view_cont_old .se-section-quotation.se-l-quotation_line .se-quotation-container:before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    border-left: 6px solid #515151
}
.view_cont_old .se-section-quotation.se-l-quotation_line .se-cite {
    margin-top: 10px
}
.view_cont_old .se-section-quotation.se-l-quotation_bubble {
    padding-top: 10px;
    padding-bottom: 34px;
    padding-bottom: 47px
}
.view_cont_old .se-section-quotation.se-l-quotation_bubble .se-quotation-container {
    max-width: 500px;
    padding: 21px;
    border: 4px solid #e4e4e4;
    box-sizing: border-box;
    background: #fff;
    padding-top: 22px;
    padding-bottom: 27px;
    border-width: 5px
}
.view_cont_old .se-section-quotation.se-l-quotation_bubble .se-quotation-container:after {
    width: 24px;
    height: 28px;
    background-position: -172px -47px;
    content: "";
    position: absolute;
    top: 100%;
    left: 30%;
    width: 38px;
    height: 42px;
    background-position: -300px -208px
}
.view_cont_old .se-section-quotation.se-l-quotation_bubble .se-quote span {
    font-weight: 700
}
.view_cont_old .se-section-quotation.se-l-quotation_bubble .se-cite {
    margin-top: 16px
}
.view_cont_old .se-section-quotation.se-l-quotation_underline {
    padding-top: 10px;
    padding-bottom: 10px
}
.view_cont_old .se-section-quotation.se-l-quotation_underline .se-quotation-container {
    padding: 35px 0 20px;
    border-bottom: 1px solid #9b9b9b
}
.view_cont_old .se-section-quotation.se-l-quotation_underline .se-quotation-container:before {
    width: 24px;
    height: 15px;
    background-position: -239px -241px;
    content: "";
    position: absolute;
    top: 0;
    left: 0
}
.view_cont_old .se-section-quotation.se-l-quotation_underline .se-cite {
    margin-top: 16px
}
.view_cont_old .se-section-quotation.se-l-quotation_postit {
    padding-top: 10px;
    padding-bottom: 59px
}
.view_cont_old .se-section-quotation.se-l-quotation_postit .se-quotation-container {
    max-width: 534px;
    padding: 33px 33px 0;
    border: solid #d5d5d5;
    border-width: 4px 4px 0;
    background: #fff
}
.view_cont_old .se-section-quotation.se-l-quotation_postit .se-quotation-container:before {
    width: 42px;
    height: 49px;
    background-position: -342px -58px;
    content: "";
    position: absolute;
    top: 100%;
    right: -4px
}
.view_cont_old .se-section-quotation.se-l-quotation_postit .se-quotation-container:after {
    content: "";
    position: absolute;
    top: 100%;
    left: -4px;
    right: 38px;
    height: 49px;
    background-color: #fff;
    border: solid #d5d5d5;
    border-width: 0 0 4px 4px;
    box-sizing: border-box
}
.view_cont_old .se-section-quotation.se-l-quotation_postit .se-cite {
    margin-top: 16px
}
.view_cont_old .se-section-quotation.se-l-quotation_corner {
    padding-top: 10px;
    padding-bottom: 10px
}
.view_cont_old .se-section-quotation.se-l-quotation_corner .se-quotation-container {
    max-width: 532px;
    padding: 32px 36px;
    box-sizing: border-box
}
.view_cont_old .se-section-quotation.se-l-quotation_corner .se-quotation-container:after, .view_cont_old .se-section-quotation.se-l-quotation_corner .se-quotation-container:before {
    content: "";
    position: absolute;
    width: 26px;
    height: 26px;
    border: solid #4a4a4a
}
.view_cont_old .se-section-quotation.se-l-quotation_corner .se-quotation-container:before {
    top: 0;
    left: 0;
    border-width: 6px 0 0 6px
}
.view_cont_old .se-section-quotation.se-l-quotation_corner .se-quotation-container:after {
    bottom: 0;
    right: 0;
    border-width: 0 6px 6px 0
}
.view_cont_old .se-section-quotation.se-l-quotation_corner .se-cite {
    margin-top: 16px
}
.view_cont_old .se-module-image-360vr {
    position: relative;
    font-size: 0
}
.view_cont_old .se-360vr-preview {
    padding-top: 56.3%;
    background-size: cover;
    background-position: 50%;
    background-repeat: no-repeat
}
.view_cont_old .se-360vr-canvas {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto;
    max-height: 100%;
    max-width: 100%;
    outline: none;
    width: 100%;
    height: 100%
}
.view_cont_old .se-360vr-controller {
    position: absolute;
    top: 10px;
    right: 10px;
    bottom: 10px;
    z-index: 5
}
.view_cont_old .se-360vr-viewing-angle {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    height: 33px;
    cursor: pointer
}
.view_cont_old .se-360vr-fullscreen-button {
    position: absolute;
    top: 0;
    right: 0
}
.view_cont_old .se-360vr-fullscreen-button:before {
    display: block;
    width: 30px;
    height: 30px;
    background-position: -358px -124px;
    content: ""
}
.view_cont_old .se-360vr-loading {
    display: inline-block;
    width: 88px;
    height: 88px;
    background-position: -90px -82px;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto;
    z-index: 10
}
.view_cont_old .se-360vr-loading:before {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    top: 64px;
    width: 32px;
    height: 8px;
    margin: auto;
    background-image: url(//editor-static.pstatic.net/v/blog//img/common-loading-square-white-desktop.f78ac5c4.gif);
    background-repeat: no-repeat
}
.view_cont_old .se-360vr-gyro-loading {
    display: inline-block;
    width: 88px;
    height: 88px;
    background-position: 0 -82px;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto;
    z-index: 10
}
.view_cont_old .se-360vr-state-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 90px;
    background-image: -webkit-linear-gradient(top, transparent, rgba(0, 0, 0, .5));
    background-image: linear-gradient(180deg, transparent, rgba(0, 0, 0, .5));
    z-index: 10;
    height: 120px
}
.view_cont_old .se-360vr-state-info:before {
    display: inline-block;
    width: 56px;
    height: 36px;
    background-position: -300px -124px;
    content: "";
    position: absolute;
    margin: auto;
    bottom: 64px;
    left: 0;
    right: 0
}
.view_cont_old .se-gyro-disabled {
    display: inline-block;
    width: 88px;
    height: 88px;
    background-position: -90px -82px;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto
}
.view_cont_old .se-360vr-state-info-text {
    position: absolute;
    bottom: 22px;
    left: 0;
    right: 0;
    line-height: 1.45;
    color: #fff;
    text-align: center;
    font-size: 12px
}
.view_cont_old .se-360vr-fullscreen {
    display: none;
    position: fixed;
    z-index: 2147483647;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: #000
}
.view_cont_old .se-360vr-fullscreen.se-is-on {
    display: block
}
.view_cont_old .se-360vr-fullscreen .se-360vr-fullscreen-button:before {
    background-position: -340px -208px
}
.view_cont_old .se-360vr-fullscreen .se-module-image-360vr {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0
}
.view_cont_old .se-image {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-image .se-caption {
    margin: 10px auto 20px
}
.view_cont_old .se-image + .se-image {
    margin-top: 2px;
    margin-top: 5px
}
.view_cont_old .se-imageStrip + .se-image {
    margin-top: 2px;
    margin-top: 5px
}
.view_cont_old .se-imageGroup + .se-image {
    margin-top: 2px;
    margin-top: 5px
}
.view_cont_old .se-sectionTitle + .se-image, .view_cont_old .se-sticker + .se-image, .view_cont_old .se-text + .se-image {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-image {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-image.se-l-default .se-caption .se-fs- {
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-image.se-l-default .se-caption .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-image.se-l-default .se-caption .se-text-paragraph {
    line-height: 1.5;
    text-align: center
}
.view_cont_old .se-image .se-module-image {
    display: block
}
.view_cont_old .se-image .se-component-content-extend .se-module-image {
    margin-right: -20px;
    margin-left: -20px;
    margin-right: -40px;
    margin-left: -40px
}
.view_cont_old .se-image .se-component-content-pagefull .se-module-image {
    margin-right: -20px;
    margin-left: -20px;
    margin-right: auto;
    margin-left: auto
}
.view_cont_old .se-imageStrip {
    margin-top: 30px
}
.view_cont_old .se-imageStrip .se-caption {
    margin: 10px auto 20px
}
.view_cont_old .se-image + .se-imageStrip {
    margin-top: 2px;
    margin-top: 5px
}
.view_cont_old .se-imageStrip + .se-imageStrip {
    margin-top: 2px;
    margin-top: 5px
}
.view_cont_old .se-imageGroup + .se-imageStrip {
    margin-top: 2px;
    margin-top: 5px
}
.view_cont_old .se-sectionTitle + .se-imageStrip, .view_cont_old .se-sticker + .se-imageStrip, .view_cont_old .se-text + .se-imageStrip {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-imageStrip {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-imageStrip.se-l-default .se-caption .se-fs- {
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-imageStrip.se-l-default .se-caption .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-imageStrip.se-l-default .se-caption .se-text-paragraph {
    line-height: 1.5;
    text-align: center
}
.view_cont_old .se-imageStrip .se-component-content-extend .se-imageStrip-container {
    margin-right: -20px;
    margin-left: -20px;
    margin-right: -40px;
    margin-left: -40px
}
.view_cont_old .se-imageStrip .se-module-image {
    display: inline-block;
    margin-left: 2px;
    box-sizing: border-box;
    vertical-align: top;
    margin-left: 5px
}
.view_cont_old .se-imageStrip .se-module-image:first-child {
    margin-left: 0
}
.view_cont_old .se-imageStrip .se-state-error {
    position: relative;
    padding: 50px 20px;
    box-sizing: border-box;
    font-size: 0;
    text-align: center
}
.view_cont_old .se-imageStrip .se-state-error:before {
    display: inline-block;
    content: "";
    height: 100%;
    vertical-align: middle
}
.view_cont_old .se-imageStrip .se-state-error .se-state-error-detail {
    display: inline-block;
    position: relative;
    left: auto;
    right: auto;
    top: auto;
    -webkit-transform: none;
    -ms-transform: none;
    transform: none
}
.view_cont_old .se-imageStrip-container {
    position: relative;

    font-size: 0
}
.view_cont_old .se-imageStrip-col-2.se-imageStrip-container {
    padding-right: 2px;
    padding-right: 5px
}
.view_cont_old .se-imageStrip-col-3.se-imageStrip-container {
    padding-right: 4px;
    padding-right: 10px
}
.view_cont_old .se-imageGroup {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-imageGroup .se-caption {
    margin: 10px auto 20px
}
.view_cont_old .se-image + .se-imageGroup {
    margin-top: 2px;
    margin-top: 5px
}
.view_cont_old .se-imageStrip + .se-imageGroup {
    margin-top: 2px;
    margin-top: 5px
}
.view_cont_old .se-imageGroup + .se-imageGroup {
    margin-top: 2px;
    margin-top: 5px
}
.view_cont_old .se-sectionTitle + .se-imageGroup, .view_cont_old .se-sticker + .se-imageGroup, .view_cont_old .se-text + .se-imageGroup {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-imageGroup {

    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-imageGroup.se-l-collage .se-caption .se-fs- {
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-imageGroup.se-l-collage .se-caption .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-imageGroup.se-l-collage .se-caption .se-text-paragraph {
    line-height: 1.5;
    text-align: center
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-caption .se-fs- {
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-imageGroup.se-l-slide .se-caption .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-caption .se-text-paragraph {
    line-height: 1.5;
    text-align: center
}
.view_cont_old .se-imageGroup .se-imageGroup-viewer {
    word-wrap: normal
}
.view_cont_old .se-imageGroup .se-component-content-extend .se-imageGroup-viewer {
    margin-right: -20px;
    margin-left: -20px;
    margin-right: -40px;
    margin-left: -40px
}
.view_cont_old .se-imageGroup.se-l-slide .se-component-content-extend .se-imageGroup-navigation-button.se-imageGroup-navigation-button-prev {
    left: -40px
}
.view_cont_old .se-imageGroup.se-l-slide .se-component-content-extend .se-imageGroup-navigation-button.se-imageGroup-navigation-button-next {
    right: -40px
}
.view_cont_old .se-imageGroup.se-l-slide .se-component-content-fit .se-imageGroup-viewer {
    height: 240px;
    height: 420px
}
.view_cont_old .se-imageGroup.se-l-slide .se-component-content-fit .se-imageGroup-navigation-button {
    top: 210px
}
.view_cont_old .se-imageGroup.se-l-slide .se-component-content-extend .se-imageGroup-viewer {
    height: 300px;
    height: 480px
}
.view_cont_old .se-imageGroup.se-l-slide .se-component-content-extend .se-imageGroup-navigation-button {
    top: 240px
}
.view_cont_old .se-section-imageGroup .se-module-image {
    position: relative;
    vertical-align: top
}
.view_cont_old .se-section-imageGroup.se-l-collage .se-imageGroup-item {
    white-space: nowrap;
    font-size: 0;
    margin-top: 2px;
    overflow: hidden;
    margin-top: 5px
}
.view_cont_old .se-section-imageGroup.se-l-collage .se-imageGroup-item:first-child {
    margin-top: 0
}
.view_cont_old .se-section-imageGroup.se-l-collage .se-imageGroup-item.se-imageGroup-col-2 {
    padding-right: 2px;
    padding-right: 5px
}
.view_cont_old .se-section-imageGroup.se-l-collage .se-module-image {
    display: inline-block;
    margin-left: 2px;
    margin-left: 5px
}
.view_cont_old .se-section-imageGroup.se-l-collage .se-module-image:first-child {
    margin-left: 0
}
.view_cont_old .se-section-imageGroup.se-l-collage .se-module-image .se-image-resource {
    width: 100%
}
.view_cont_old .se-section-imageGroup.se-l-collage .se-state-error {
    position: relative;
    padding: 50px 20px;
    box-sizing: border-box;
    font-size: 0;
    text-align: center
}
.view_cont_old .se-section-imageGroup.se-l-collage .se-state-error:before {
    display: inline-block;
    content: "";
    height: 100%;
    vertical-align: middle
}
.view_cont_old .se-section-imageGroup.se-l-collage .se-state-error .se-state-error-detail {
    display: inline-block;
    position: relative;
    left: auto;
    right: auto;
    top: auto;
    -webkit-transform: none;
    -ms-transform: none;
    transform: none
}
.view_cont_old .se-section-imageGroup.se-l-slide {
    position: relative
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-imageGroup-viewer {
    position: relative;
    overflow: hidden;
    font-size: 0;
    white-space: nowrap
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-imageGroup-container {
    height: 100%;
    text-align: center
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-module-image {
    display: block;
    height: 100%
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-state-error {
    width: 250px;
    padding: 0;
    height: 100%
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-image-resource {
    max-width: none
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-imageGroup-item {
    height: 100%;
    margin-left: 2px;
    vertical-align: top
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-imageGroup-item:first-child {
    margin-left: 0
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-imageGroup-item {
    margin-left: 5px
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-imageGroup-progress {
    position: relative;
    max-width: 700px;
    margin-top: 8px;
    margin-right: auto;
    margin-left: auto;
    height: 24px;
    margin-top: 10px
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-imageGroup-progress:before {
    content: "";
    display: block;
    position: absolute;
    top: 5px;
    right: 0;
    left: 0;
    height: 3px;
    background-color: #d8d8d8;
    height: 4px
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-imageGroup-thumb {
    position: relative;
    height: 100%;
    cursor: pointer;
    background-color: hsla(0, 0%, 100%, 0)
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-imageGroup-thumb:before {
    content: "";
    display: block;
    position: absolute;
    top: 5px;
    left: 0;
    width: 100%;
    height: 5px;
    margin-top: -1px;
    background-color: #000;
    height: 6px
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-imageGroup-item {
    position: relative;
    display: inline-block;
    box-sizing: border-box
}
.view_cont_old .se-section-imageGroup.se-l-slide .se-image-resource {
    width: auto;
    height: 100%
}
.view_cont_old .se-section-imageGroup .se-imageGroup-navigation {
    display: none;
    display: block
}
.view_cont_old .se-section-imageGroup .se-imageGroup-navigation-button {
    position: absolute;
    z-index: 10;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    width: 48px;
    height: 48px;
    border: 1px solid hsla(0, 0%, 100%, .3);
    background: hsla(0, 0%, 100%, .85);
    box-shadow: 0 1px 5px 0 rgba(0, 0, 0, .1)
}
.view_cont_old .se-section-imageGroup .se-imageGroup-navigation-button:disabled {
    opacity: 0
}
.view_cont_old .se-section-imageGroup .se-imageGroup-navigation-button:before {
    content: "";
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%)
}
.view_cont_old .se-section-imageGroup .se-imageGroup-navigation-button.se-imageGroup-navigation-button-prev {
    left: 0
}
.view_cont_old .se-section-imageGroup .se-imageGroup-navigation-button.se-imageGroup-navigation-button-prev:before {
    display: inline-block;
    width: 28px;
    height: 28px;
    background-position: -142px -47px
}
.view_cont_old .se-section-imageGroup .se-imageGroup-navigation-button.se-imageGroup-navigation-button-next {
    right: 0
}
.view_cont_old .se-section-imageGroup .se-imageGroup-navigation-button.se-imageGroup-navigation-button-next:before {
    display: inline-block;
    width: 28px;
    height: 28px;
    background-position: -112px -47px
}
.view_cont_old .se-section-imageGroup .se-imageGroup-navigation .se-is-on .se-imageGroup-navigation-button {
    display: block
}
.view_cont_old .se-video {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-video .se-caption {
    margin: 10px auto 20px
}
.view_cont_old .se-sectionTitle + .se-video, .view_cont_old .se-text + .se-video {
    margin-top: 20px
}
.view_cont_old .se-video + .se-video {
    margin-top: 2px;
    margin-top: 5px
}
.view_cont_old .se-sticker + .se-video {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-video {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-video.se-l-default .se-caption .se-fs- {
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-video.se-l-default .se-caption .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-video.se-l-default .se-caption .se-text-paragraph {
    line-height: 1.5;
    text-align: center
}
.view_cont_old .se-video {
    position: relative
}
.view_cont_old .se-video .se-section-video {
    position: relative;
    z-index: 1
}
.view_cont_old .se-video .se-component-content-normal .se-module-video {
    margin-right: -20px;
    margin-left: -20px;
    margin: auto
}
.view_cont_old .se-video .se-component-content-fit .se-module-video {
    margin-right: -20px;
    margin-left: -20px;
    margin: auto
}
.view_cont_old .se-video .se-component-content-extend .se-module-video {
    margin-right: -20px;
    margin-left: -20px;
    margin-right: -40px;
    margin-left: -40px
}
.view_cont_old .se-video .se-component-content-extend .se-media-meta {
    margin-right: -40px;
    margin-left: -40px;
    padding-left: 40px;
    padding-right: 40px
}
.view_cont_old .se-video .se-media-meta {
    position: relative;
    padding: 12px 20px 10px;
    box-sizing: border-box;
    border-bottom: 1px solid rgba(0, 0, 0, .12);
    margin-right: -20px;
    margin-left: -20px;
    border-bottom: 1px solid rgba(0, 0, 0, .15);
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .04)
}
.view_cont_old .se-video .se-media-meta:after {
    display: block;
    content: "";
    clear: both
}
.view_cont_old .se-video .se-media-meta {
    margin-right: 0;
    margin-left: 0;
    background-color: hsla(0, 0%, 100%, .2);
    border: 1px solid rgba(0, 0, 0, .15)
}
.view_cont_old .se-video .se-media-meta:not(.se-is-activated) .se-media-meta-info {
    font-size: 14px;
    font-weight: 400
}
.view_cont_old .se-video .se-media-meta:not(.se-is-activated) .se-media-meta-toggle-button ~ .se-media-meta-info-title {
    display: block;
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all
}
.view_cont_old .se-video .se-media-meta:not(.se-is-activated) .se-media-meta-info-title-only {
    display: block;
    font-size: 16px;
    font-weight: 700;
    white-space: nowrap
}
.view_cont_old .se-video .se-media-meta:not(.se-is-activated) .se-media-meta-info-title-long {
    display: block;
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    font-size: 14px;
    font-weight: 400
}
.view_cont_old .se-video .se-media-meta:not(.se-is-activated) .se-media-meta-info-description {
    display: block;
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    min-height: 20px
}
.view_cont_old .se-video .se-media-meta:not(.se-is-activated) .se-media-meta-info-description + .se-media-meta-info-title {
    display: none
}
.view_cont_old .se-video .se-media-meta.se-is-activated .se-media-meta-info-title {
    display: table;
    font-size: 16px;
    font-weight: 700;
    word-wrap: break-word;
    word-break: break-word
}
.view_cont_old .se-video .se-media-meta.se-is-activated .se-media-meta-info-description {
    word-break: break-word;
    word-wrap: break-word;
    padding-bottom: 9px
}
.view_cont_old .se-video .se-media-meta.se-is-activated .se-media-meta-info-description + .se-media-meta-info-title {
    padding-top: 11px;
    border-top: 1px solid rgba(0, 0, 0, .06)
}
.view_cont_old .se-video .se-media-meta.se-is-activated .se-media-meta-toggle-button {
    padding-bottom: 7px
}
.view_cont_old .se-video .se-media-meta.se-is-activated .se-media-meta-toggle-button:after {
    background-position: -281px -195px
}
.view_cont_old .se-video .se-media-meta.se-is-activated .se-media-meta-tags {
    display: block
}
.view_cont_old .se-video .se-media-meta-info {
    font-size: 14px;
    color: #333;
    word-wrap: normal
}
.view_cont_old .se-video .se-media-meta-info-title {
    font-family: se-nanumsquare, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo;
    line-height: 24px;
    color: #333
}
.view_cont_old .se-video .se-media-meta-info-description {
    line-height: 24px
}
.view_cont_old .se-video .se-media-meta-toggle-button {
    overflow: hidden;
    float: right;
    position: relative;
    margin-top: -12px;
    margin-right: -20px;
    font-size: 0;
    outline: none;
    padding: 17px 18px;
    margin-bottom: -7px
}
.view_cont_old .se-video .se-media-meta-toggle-button:after {
    content: "";
    display: inline-block;
    width: 12px;
    height: 12px;
    background-position: -284px -138px
}
.view_cont_old .se-video .se-media-meta-tags {
    display: none
}
.view_cont_old .se-video .se-media-meta-info-tag {
    margin: 5px 10px 0 0;
    font-size: 14px;
    line-height: 22px;
    color: rgba(0, 0, 0, .4);
    word-wrap: break-word;
    word-break: break-all;
    text-decoration: none
}
.view_cont_old .se-video .se-media-meta-info-tag:last-child {
    margin-right: 0
}
.view_cont_old .se-file {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-file, .view_cont_old .se-sticker + .se-file {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-file {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-file {
    position: relative;
    max-width: 450px;
    vertical-align: top
}
.view_cont_old .se-module-file {
    padding-left: 55px;
    padding-right: 70px;
    height: 60px;
    border: 1px solid #e0e0e0;
    background-color: #fff;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .08);
    text-align: left;
    box-sizing: border-box;
    font-size: 0
}
.view_cont_old .se-module-file:after {
    content: "";
    display: inline-block;
    vertical-align: middle;
    height: 100%
}
.view_cont_old .se-file-icon {
    width: 21px;
    height: 17px;
    background-position: -238px -265px;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 20px;
    margin: auto 0
}
.view_cont_old .se-file-name-container {
    width: 100%;
    font-size: 13px;
    color: #333;
    line-height: 1.69
}
.view_cont_old .se-file-name, .view_cont_old .se-file-name-container {
    display: inline-block;
    white-space: nowrap;
    vertical-align: middle
}
.view_cont_old .se-file-name {
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    max-width: calc(100% - 26px)
}
.view_cont_old .se-file-extension {
    display: inline-block;
    vertical-align: middle
}
.view_cont_old .se-file-save-button {
    position: absolute;
    right: 0;
    top: 0;
    width: 66px;
    height: 100%
}
.view_cont_old .se-file-save-button:before {
    display: inline-block;
    width: 20px;
    height: 18px;
    background-position: -194px -265px;
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto
}
.view_cont_old .se-file-save-button.se-file-save-button-activated:before, .view_cont_old .se-file-save-button.se-is-activated:before, .view_cont_old .se-file-save-button:active:before, .view_cont_old .se-file-save-button:focus:before, .view_cont_old .se-file-save-button:hover:before {
    background-position: -216px -265px
}
.view_cont_old .se-file-save-button.se-is-activated ~ .se-file-save-option {
    display: block
}
.view_cont_old .se-file-save-option-button {
    position: relative;
    display: block;
    width: 100%;
    box-sizing: border-box;
    padding: 13px 15px 12px 18px;
    text-align: left;
    white-space: nowrap;
    font-size: 12px;
    outline: none;
    text-decoration: none;
    color: #333
}
.view_cont_old .se-file-save-option-button:active, .view_cont_old .se-file-save-option-button:focus, .view_cont_old .se-file-save-option-button:hover {
    background-color: #f8f8f8
}
.view_cont_old .se-file-save-option-button.se-file-save-option-button-local:before {
    display: inline-block;
    width: 18px;
    height: 14px;
    background-position: -307px -265px;
    content: "";
    vertical-align: middle;
    margin-right: 7px
}
.view_cont_old .se-file-save-option-button.se-file-save-option-button-cloud:before {
    display: inline-block;
    width: 19px;
    height: 14px;
    background-position: -265px -241px;
    content: "";
    vertical-align: middle;
    margin-right: 7px
}
.view_cont_old .se-file-save-option {
    display: none;
    position: absolute;
    right: 0;
    top: 59px;
    min-width: 180px;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .08);
    border: 1px solid #e0e0e0;
    background-color: #fff;
    box-sizing: border-box;
    z-index: 1
}
.view_cont_old .se-file-save-option .se-file-save-option-item {
    border-top: 1px solid #eee
}
.view_cont_old .se-file-save-option .se-file-save-option-item:first-child {
    border-top: 0
}
.view_cont_old .se-file-save-option-button-label {
    font-size: 12px;
    line-height: normal;
    color: #333
}
.view_cont_old .se-horizontalLine {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sticker + .se-horizontalLine {
    margin-top: 20px
}
.view_cont_old .se-horizontalLine + .se-horizontalLine {
    margin-top: 10px;
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-horizontalLine {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-hr {
    display: block !important;
    margin: 0 auto;
    border: 0
}
.view_cont_old .se-section-horizontalLine.se-l-default {
    width: 100px;
    width: 220px
}
.view_cont_old .se-section-horizontalLine.se-l-default .se-module-horizontalLine {
    padding-top: 30px;
    padding-bottom: 29px
}
.view_cont_old .se-section-horizontalLine.se-l-default .se-hr {
    height: 1px;
    background-color: #ddd
}
.view_cont_old .se-section-horizontalLine.se-l-line1 .se-component-section {
    display: block
}
.view_cont_old .se-section-horizontalLine.se-l-line1 .se-module-horizontalLine {
    width: 100%;
    padding-top: 30px;
    padding-bottom: 29px
}
.view_cont_old .se-section-horizontalLine.se-l-line1 .se-hr {
    width: 100%;
    height: 1px;
    background-color: #ddd
}
.view_cont_old .se-section-horizontalLine.se-l-line2 {
    width: 67px
}
.view_cont_old .se-section-horizontalLine.se-l-line2 .se-module-horizontalLine {
    padding-top: 28px;
    padding-bottom: 29px
}
.view_cont_old .se-section-horizontalLine.se-l-line2 .se-hr {
    height: 3px;
    background-color: #333
}
.view_cont_old .se-section-horizontalLine.se-l-line3 {
    width: 238px
}
.view_cont_old .se-section-horizontalLine.se-l-line3 .se-module-horizontalLine {
    padding-top: 29px;
    padding-bottom: 23px
}
.view_cont_old .se-section-horizontalLine.se-l-line3 .se-hr {
    display: block;
    width: 238px;
    height: 9px;
    background-position: 0 -290px
}
.view_cont_old .se-section-horizontalLine.se-l-line4 {
    width: 192px
}
.view_cont_old .se-section-horizontalLine.se-l-line4 .se-module-horizontalLine {
    padding-top: 19px;
    padding-bottom: 19px
}
.view_cont_old .se-section-horizontalLine.se-l-line4 .se-hr {
    display: block;
    width: 192px;
    height: 23px;
    background-position: 0 -265px
}
.view_cont_old .se-section-horizontalLine.se-l-line5 {
    width: 66px
}
.view_cont_old .se-section-horizontalLine.se-l-line5 .se-module-horizontalLine {
    padding-top: 28px;
    padding-bottom: 26px
}
.view_cont_old .se-section-horizontalLine.se-l-line5 .se-hr {
    display: block;
    width: 66px;
    height: 6px;
    background-position: -300px -252px
}
.view_cont_old .se-section-horizontalLine.se-l-line6 {
    width: 44px
}
.view_cont_old .se-section-horizontalLine.se-l-line6 .se-module-horizontalLine {
    padding-top: 8px;
    padding-bottom: 8px
}
.view_cont_old .se-section-horizontalLine.se-l-line6 .se-hr {
    display: block;
    width: 44px;
    height: 44px;
    background-position: -300px -162px
}
.view_cont_old .se-section-horizontalLine.se-l-line7 .se-module-horizontalLine {
    padding-top: 0;
    padding-bottom: 0
}
.view_cont_old .se-section-horizontalLine.se-l-line7 .se-hr {
    display: inline-block !important;
    width: 2px;
    height: 60px;
    vertical-align: top;
    background-color: #aaa
}
.view_cont_old .se-section-horizontalLine.se-l-line7.se-section-align-left .se-module-horizontalLine {
    text-align: left
}
.view_cont_old .se-section-horizontalLine.se-l-line7.se-section-align-center .se-module-horizontalLine {
    text-align: center
}
.view_cont_old .se-section-horizontalLine.se-l-line7.se-section-align-right .se-module-horizontalLine {
    text-align: right
}
.view_cont_old .se-module-schedule {
    padding: 24px 19px 22px;
    border: 1px solid rgba(0, 0, 0, .12);
    background-color: #fff;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .08);
    box-sizing: border-box;
    padding-right: 29px;
    padding-left: 29px
}
.view_cont_old .se-module-schedule-end-date {
    padding-top: 14px;
    padding-bottom: 17px;
    padding-top: 24px;
    padding-bottom: 26px
}
.view_cont_old .se-module-schedule-expanded {
    margin-right: -20px;
    margin-left: -20px;
    border-width: 1px 0;
    margin-right: auto;
    margin-left: auto;
    border-width: 1px
}
.view_cont_old .se-module-schedule-finished .se-schedule-date {
    color: #999
}
.view_cont_old .se-schedule-header {
    display: table;
    table-layout: fixed;
    width: 100%;
    min-height: 58px
}
.view_cont_old .se-schedule-date-container {
    display: table-cell;
    width: 80px;
    padding-top: 8px;
    margin-left: 30px;
    text-align: right;
    letter-spacing: -1px;
    vertical-align: middle
}
.view_cont_old .se-schedule-date {
    display: inline-block;
    margin-right: 5px;
    text-align: center;
    font-family: se-nanumsquare, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo;
    color: #333
}
.view_cont_old .se-schedule-summary {
    display: table-cell;
    vertical-align: middle
}
.view_cont_old .se-schedule-month {
    vertical-align: middle
}
.view_cont_old .se-schedule-month-number {
    font-size: 14px;
    font-size: 15px;
    margin-right: -1px
}
.view_cont_old .se-schedule-month-text {
    font-size: 13px;
    font-size: 15px
}
.view_cont_old .se-schedule-day {
    display: block;
    font-family: se-nanumsquare, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo;
    font-size: 34px;
    line-height: 1;
    letter-spacing: 0;
    padding-top: 4px;
    font-size: 46px
}
.view_cont_old .se-schedule-title {
    line-height: 1.33;
    word-break: break-all;
    line-height: 1.56
}
.view_cont_old .se-schedule-title-text {
    font-size: 15px;
    color: #333;
    vertical-align: middle;
    font-family: se-nanumgothic, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo;
    font-size: 19px
}
.view_cont_old .se-schedule-title-text:after {
    content: "";
    display: inline-block;
    width: 7px
}
.view_cont_old .se-schedule-state {
    display: inline-block;
    margin-top: -2px;
    line-height: 1;
    vertical-align: middle;
    font-family: se-nanumsquare, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo
}
.view_cont_old .se-schedule-state + .se-schedule-state {
    margin-left: 4px
}
.view_cont_old .se-schedule-state-d-day {
    padding: 4px 5px 3px 6px;
    border-radius: 2px;
    background-color: #00c73c;
    font-size: 15px;
    color: #fff
}
.view_cont_old .se-schedule-state-finished {
    padding: 5px 7px 4px;
    background-color: #999;
    border-radius: 2px;
    font-family: se-nanumgothic, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo;
    font-weight: 700;
    font-size: 14px;
    color: #fff
}
.view_cont_old .se-schedule-state-notice-on {
    border: 1px solid #00c73c;
    color: #00c73c
}
.view_cont_old .se-schedule-state-notice-off, .view_cont_old .se-schedule-state-notice-on {
    padding: 4px 2px 3px;
    font-size: 13px;
    font-family: se-nanumgothic, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo
}
.view_cont_old .se-schedule-state-notice-off {
    border: 1px solid #999;
    color: #aaa
}
.view_cont_old .se-schedule-duration {
    margin-top: 8px;
    font-size: 12px;
    color: #666;
    font-family: se-nanumgothic, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo;
    margin-top: 9px;
    font-size: 14px
}
.view_cont_old .se-schedule-duration + .se-schedule-duration {
    margin-top: 6px;
    margin-top: 8px
}
.view_cont_old .se-schedule-duration-notice {
    margin-top: 8px;
    color: #999;
    font-size: 13px
}
.view_cont_old .se-schedule-content {
    margin-top: 18px;
    padding-top: 15px;
    border-top: 1px solid #e5e5e5;
    margin-top: 26px;
    padding-top: 20px
}
.view_cont_old .se-schedule-detail ~ .se-schedule-detail {
    margin-top: 16px
}
.view_cont_old .se-schedule-detail ~ .se-schedule-detail-url {
    margin-top: 17px
}
.view_cont_old .se-schedule-info {
    position: relative;
    padding-left: 29px;
    font-size: 13px;
    color: #555
}
.view_cont_old .se-schedule-detail-location .se-schedule-info:before {
    display: inline-block;
    width: 21px;
    height: 21px;
    background-position: -237px -172px;
    content: "";
    position: absolute;
    top: 3px;
    left: 1px
}
.view_cont_old .se-schedule-detail-url .se-schedule-info:before {
    display: inline-block;
    width: 15px;
    height: 16px;
    background-position: -282px -172px;
    content: "";
    position: absolute;
    top: -3px;
    left: 1px
}
.view_cont_old .se-schedule-detail-description .se-schedule-info:before {
    display: inline-block;
    width: 15px;
    height: 10px;
    background-position: -374px -109px;
    content: "";
    position: absolute;
    top: 5px;
    left: 1px
}
.view_cont_old .se-schedule-description {
    line-height: 1.54;
    word-break: break-all
}
.view_cont_old .se-schedule-info-map {
    position: relative;
    margin-bottom: 15px;
    margin-bottom: 21px
}
.view_cont_old .se-module-map-image:before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    border: 1px solid rgba(0, 0, 0, .08)
}
.view_cont_old .se-schedule-info-title {
    position: absolute;
    overflow: hidden;
    clip: rect(0 0 0 0);
    margin: -1px;
    width: 1px;
    height: 1px
}
.view_cont_old .se-schedule-url {
    display: block;
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    color: #555;
    text-decoration: none
}
.view_cont_old .se-schedule-url:hover {
    color: #00c73c
}
.view_cont_old .se-schedule {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-schedule, .view_cont_old .se-sticker + .se-schedule {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-schedule {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-schedule {
    max-width: 450px
}
.view_cont_old .se-section-schedule .se-map-title {
    font-size: 13px;
    color: #555;
    font-weight: 400
}
.view_cont_old .se-section-schedule .se-map-title:after {
    display: none
}
.view_cont_old .se-section-schedule .se-map-address {
    font-size: 12px;
    color: #999
}
.view_cont_old .se-section-schedule .se-map-image {
    display: block;
    width: 100%
}
.view_cont_old .se-section-schedule .se-map-link {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto
}
.view_cont_old .se-section-schedule-scroll .se-module-schedule-expanded {
    margin-right: 0;
    margin-left: 0
}
.view_cont_old .se-sticker {
    margin-top: 20px
}
.view_cont_old .se-sticker + .se-sticker {
    margin-top: 10px
}
.view_cont_old .se-quotation + .se-sticker {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-sticker {
    display: table
}
.view_cont_old .se-sticker-image {
    vertical-align: top;
    height: 120px;
    height: 160px
}
.view_cont_old .se-wrappingParagraph {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-wrappingParagraph, .view_cont_old .se-sticker + .se-wrappingParagraph {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-wrappingParagraph {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-wrappingParagraph .se-component-content:after {
    display: block;
    content: "";
    clear: both
}
.view_cont_old .se-wrappingParagraph .se-section-text .se-text-paragraph.se-text-paragraph-drop-cap {
    overflow: hidden;
    clear: none
}
.view_cont_old .se-wrappingParagraph .se-section-text .se-text-paragraph.se-text-paragraph-drop-cap:last-child {
    overflow: inherit
}
.view_cont_old .se-component-slot .se-section-image {
    max-width: none !important;
    margin-top: 6px
}
.view_cont_old .se-component-slot ~ .se-component-slot {
    margin-top: 30px;
    margin-top: 0
}
.view_cont_old .se-l-inner-left .se-component-slot-float {
    float: left;
    width: 228px;
    margin-right: 36px;
    margin-bottom: 30px
}
.view_cont_old .se-l-inner-right .se-component-slot-float {
    float: right;
    width: 228px;
    margin-left: 36px;
    margin-bottom: 30px
}
.view_cont_old .se-l-inner-big-left .se-component-slot-float {
    float: left;
    width: 310px;
    margin-right: 36px;
    margin-bottom: 30px
}
.view_cont_old .se-l-inner-big-right .se-component-slot-float {
    float: right;
    width: 310px;
    margin-left: 36px;
    margin-bottom: 30px
}
.view_cont_old .se-l-outer-left .se-component-slot-float {
    float: left;
    width: 415px;
    margin-right: 36px;
    margin-left: -95px;
    margin-bottom: 30px
}
.view_cont_old .se-l-outer-right .se-component-slot-float {
    float: right;
    width: 415px;
    margin-left: 36px;
    margin-right: -95px;
    margin-bottom: 30px
}
.view_cont_old .se-audio {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-audio, .view_cont_old .se-sticker + .se-audio {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-audio {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-audio {
    position: relative;
    max-width: 450px
}
.view_cont_old .se-module-audio {
    width: 100%;
    height: 60px;
    border: 1px solid #e0e0e0;
    background-color: #fff;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .08);
    text-align: left;
    box-sizing: border-box
}
.view_cont_old .se-audio-blocker {
    position: absolute;
    top: 1px;
    right: 1px;
    bottom: 1px;
    left: 1px;
    font-size: 0;
    text-align: center
}
.view_cont_old .se-audio-blocker:before {
    content: "";
    display: inline-block;
    height: 100%;
    vertical-align: middle
}
.view_cont_old .se-audio-blocker-text {
    display: inline-block;
    position: relative;
    padding: 0 50px;
    font-size: 13px;
    line-height: 1.6;
    color: #666;
    vertical-align: middle
}
.view_cont_old .se-audio-blocker-cause {
    font-weight: 400;
    color: #f54545
}
.view_cont_old .se-audio-blocker-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fff;
    opacity: .9;
    filter: alpha(opacity=90)
}
.view_cont_old .se-audio-play-button {
    width: 32px;
    height: 32px;
    margin: 14px 0 0 20px;
    border: 1px solid #666;
    border-radius: 50%;
    vertical-align: top
}
.view_cont_old .se-audio-play-button:before {
    content: "";
    display: block;
    width: 0;
    height: 0;
    margin-left: 11px;
    border: solid transparent;
    border-width: 6px 0 6px 9px;
    border-left-color: #666
}
.view_cont_old .se-audio-play-button:hover {
    border-color: #00c73c
}
.view_cont_old .se-audio-play-button:hover:before {
    border-left-color: #00c73c
}
.view_cont_old .se-audio-play-button.se-is-play:before {
    width: 4px;
    height: 12px;
    margin: auto;
    border-color: #666;
    border-width: 0 3px
}
.view_cont_old .se-audio-play-button.se-is-play:hover:before {
    border-color: #00c73c
}
.view_cont_old .se-audio-time-current, .view_cont_old .se-audio-time-duration, .view_cont_old .se-audio-time-remaining {
    position: absolute;
    top: 0;
    font-size: 13px;
    line-height: 62px
}
.view_cont_old .se-audio-time-current {
    left: 68px;
    color: #00c73c
}
.view_cont_old .se-audio-time-duration {
    right: 20px;
    color: #333
}
.view_cont_old .se-audio-time-remaining {
    display: none
}
.view_cont_old .se-audio-bar {
    position: absolute;
    top: 29px;
    right: 64px;
    left: 112px
}
.view_cont_old .se-audio-bar-slider {
    position: absolute;
    top: 1px;
    left: 0;
    width: 1px;
    height: 1px;
    opacity: 0;
    filter: alpha(opacity=0)
}
.view_cont_old .se-material {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-material, .view_cont_old .se-sticker + .se-material {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-material {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-material {
    max-width: 450px;
    vertical-align: top
}
.view_cont_old .se-module-material {
    display: block;
    position: relative;
    max-width: 450px;
    background-color: #fff;
    text-align: left;
    text-decoration: none;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .08)
}
.view_cont_old .se-module-material:after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    border: 1px solid rgba(0, 0, 0, .1);
    content: ""
}
.view_cont_old .se-material-thumbnail {
    overflow: hidden;
    z-index: 1;
    position: relative;
    font-size: 0;
    background-color: #f4f4f4
}
.view_cont_old .se-material-thumbnail:before {
    content: "";
    display: inline-block;
    vertical-align: middle
}
.view_cont_old .se-material-thumbnail:after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    border: 1px solid rgba(0, 0, 0, .1);
    content: ""
}
.view_cont_old .se-material-thumbnail-resource {
    position: relative;
    left: 50%;
    width: auto;
    height: 100%;
    max-height: 120px;
    -webkit-transform: translate(-50%);
    -ms-transform: translate(-50%);
    transform: translate(-50%);
    max-height: 145px
}
.view_cont_old .se-material-thumbnail-no-image {
    padding: 0 8px;
    box-sizing: border-box;
    text-align: center
}
.view_cont_old .se-material-thumbnail-no-image-text {
    font-family: se-nanumgothic, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo;
    font-size: 12px;
    color: #aaa;
    vertical-align: middle
}
.view_cont_old .se-material-info {
    padding: 0 20px;
    box-sizing: border-box;
    font-size: 0;
    padding-right: 31px;
    padding-left: 26px
}
.view_cont_old .se-material-info:before {
    content: "";
    display: inline-block;
    height: 100%;
    vertical-align: middle
}
.view_cont_old .se-material-info-container {
    display: inline-block;
    vertical-align: middle;
    max-width: 100%
}
.view_cont_old .se-material-title {
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    display: block;
    font-weight: 700;
    font-size: 13px;
    line-height: 1.2;
    color: #333;
    font-size: 15px;
    line-height: 1.35
}
.view_cont_old .se-material-detail {
    font-size: 12px;
    line-height: 1.5;
    color: #666;
    font-size: 13px
}
.view_cont_old .se-material-detail-title {
    clear: both;
    float: left;
    font-size: 12px;
    line-height: 1.5;
    color: #999;
    font-size: 13px
}
.view_cont_old .se-material-detail-description {
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    min-height: 18px;
    min-height: 19px
}
.view_cont_old .se-material-detail-news-source {
    margin-top: 6px;
    margin-top: 7px
}
.view_cont_old .se-material-detail-shopping-price {
    min-height: 14px;
    line-height: 14px;
    color: #00a832;
    min-height: 19px;
    line-height: 19px
}
.view_cont_old .se-material-detail-news-summary {
    margin-top: 2px;
    color: #999;
    margin-top: 0
}
.view_cont_old .se-material-npay {
    display: inline-block;
    width: 30px;
    height: 13px;
    background-position: -126px -219px;
    margin: 2px 0 0 8px;
    vertical-align: top;
    margin: 2px 0 0 3px
}
.view_cont_old .se-material-book .se-material-thumbnail, .view_cont_old .se-material-broadcast .se-material-thumbnail, .view_cont_old .se-material-movie .se-material-thumbnail, .view_cont_old .se-material-show .se-material-thumbnail {
    width: 85px;
    min-height: 120px;
    max-height: 120px
}
.view_cont_old .se-material-book .se-material-thumbnail ~ .se-material-info, .view_cont_old .se-material-broadcast .se-material-thumbnail ~ .se-material-info, .view_cont_old .se-material-movie .se-material-thumbnail ~ .se-material-info, .view_cont_old .se-material-show .se-material-thumbnail ~ .se-material-info {
    left: 85px
}
.view_cont_old .se-material-book .se-material-thumbnail-no-image, .view_cont_old .se-material-book .se-material-thumbnail-no-image:before, .view_cont_old .se-material-broadcast .se-material-thumbnail-no-image, .view_cont_old .se-material-broadcast .se-material-thumbnail-no-image:before, .view_cont_old .se-material-movie .se-material-thumbnail-no-image, .view_cont_old .se-material-movie .se-material-thumbnail-no-image:before, .view_cont_old .se-material-show .se-material-thumbnail-no-image, .view_cont_old .se-material-show .se-material-thumbnail-no-image:before {
    height: 120px
}
.view_cont_old .se-material-book .se-material-thumbnail, .view_cont_old .se-material-broadcast .se-material-thumbnail, .view_cont_old .se-material-movie .se-material-thumbnail, .view_cont_old .se-material-show .se-material-thumbnail {
    width: 100px;
    min-height: 130px;
    max-height: 145px
}
.view_cont_old .se-material-book .se-material-thumbnail ~ .se-material-info, .view_cont_old .se-material-broadcast .se-material-thumbnail ~ .se-material-info, .view_cont_old .se-material-movie .se-material-thumbnail ~ .se-material-info, .view_cont_old .se-material-show .se-material-thumbnail ~ .se-material-info {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 100px
}
.view_cont_old .se-material-book .se-material-thumbnail-no-image, .view_cont_old .se-material-book .se-material-thumbnail-no-image:before, .view_cont_old .se-material-broadcast .se-material-thumbnail-no-image, .view_cont_old .se-material-broadcast .se-material-thumbnail-no-image:before, .view_cont_old .se-material-movie .se-material-thumbnail-no-image, .view_cont_old .se-material-movie .se-material-thumbnail-no-image:before, .view_cont_old .se-material-show .se-material-thumbnail-no-image, .view_cont_old .se-material-show .se-material-thumbnail-no-image:before {
    height: 130px
}
.view_cont_old .se-material-book .se-material-detail, .view_cont_old .se-material-broadcast .se-material-detail, .view_cont_old .se-material-movie .se-material-detail, .view_cont_old .se-material-show .se-material-detail {
    margin-top: 6px;
    margin-top: 12px
}
.view_cont_old .se-material-book .se-material-detail-title, .view_cont_old .se-material-broadcast .se-material-detail-title, .view_cont_old .se-material-movie .se-material-detail-title, .view_cont_old .se-material-show .se-material-detail-title {
    width: 30px;
    width: 35px
}
.view_cont_old .se-material-music .se-material-thumbnail {
    width: 85px;
    height: 85px
}
.view_cont_old .se-material-music .se-material-thumbnail ~ .se-material-info {
    left: 85px
}
.view_cont_old .se-material-music .se-material-thumbnail-no-image:before {
    height: 85px
}
.view_cont_old .se-material-music .se-material-thumbnail {
    width: 110px;
    height: 110px
}
.view_cont_old .se-material-music .se-material-thumbnail ~ .se-material-info {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 110px
}
.view_cont_old .se-material-music .se-material-thumbnail-no-image:before {
    height: 110px
}
.view_cont_old .se-material-music .se-material-detail-title {
    width: 52px;
    width: 60px
}
.view_cont_old .se-material-music .se-material-detail {
    margin-top: 6px;
    margin-top: 12px
}
.view_cont_old .se-material-shopping .se-material-thumbnail {
    width: 85px;
    height: 85px
}
.view_cont_old .se-material-shopping .se-material-thumbnail ~ .se-material-info {
    left: 85px
}
.view_cont_old .se-material-shopping .se-material-thumbnail-no-image:before {
    height: 85px
}
.view_cont_old .se-material-shopping .se-material-thumbnail {
    width: 110px;
    height: 110px
}
.view_cont_old .se-material-shopping .se-material-thumbnail ~ .se-material-info {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 110px
}
.view_cont_old .se-material-shopping .se-material-thumbnail-no-image:before {
    height: 110px
}
.view_cont_old .se-material-shopping .se-material-title {
    white-space: nowrap;
    word-wrap: normal;
    max-height: 40px;
    display: block;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all
}
.view_cont_old .se-material-shopping .se-material-detail-title {
    position: absolute;
    overflow: hidden;
    clip: rect(0 0 0 0);
    margin: -1px;
    width: 1px;
    height: 1px
}
.view_cont_old .se-material-shopping .se-material-detail-description {
    margin-top: 8px;
    margin-top: 4px
}
.view_cont_old .se-material-shopping .se-material-detail-description:nth-child(2) {
    margin-top: 6px;
    margin-top: 4px
}
.view_cont_old .se-material-shopping .se-material-detail-description.se-material-detail-shopping-shop {
    margin-top: 2px
}
.view_cont_old .se-material-news {
    min-height: 85px
}
.view_cont_old .se-material-news .se-material-thumbnail {
    width: 85px;
    height: 85px
}
.view_cont_old .se-material-news .se-material-thumbnail ~ .se-material-info {
    left: 85px
}
.view_cont_old .se-material-news .se-material-thumbnail-no-image:before {
    height: 85px
}
.view_cont_old .se-material-news {
    min-height: 110px
}
.view_cont_old .se-material-news .se-material-thumbnail {
    width: 110px;
    height: 110px
}
.view_cont_old .se-material-news .se-material-thumbnail ~ .se-material-info {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 110px
}
.view_cont_old .se-material-news .se-material-thumbnail-no-image:before {
    height: 110px
}
.view_cont_old .se-material-news .se-material-detail-title {
    position: absolute;
    overflow: hidden;
    clip: rect(0 0 0 0);
    margin: -1px;
    width: 1px;
    height: 1px
}
.view_cont_old .se-material-news-bSize .se-material-thumbnail {
    width: 100%;
    height: auto
}
.view_cont_old .se-material-news-bSize .se-material-thumbnail ~ .se-material-info {
    position: static;
    padding-top: 14px;
    padding-bottom: 12px;
    padding-top: 22px;
    padding-bottom: 16px
}
.view_cont_old .se-material-news-bSize .se-module-material {
    display: block
}
.view_cont_old .se-material-news-bSize .se-material-thumbnail-resource {
    width: 100%;
    height: auto;
    max-height: 450px
}
.view_cont_old .se-material-news-bSize .se-material-title {
    margin: 0 0 2px;
    margin: 0 0 7px
}
.view_cont_old .se-material-news-bSize .se-material-detail-news-summary {
    white-space: nowrap;
    word-wrap: normal;
    max-height: 18px;
    line-height: 1.4;
    display: block;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    max-height: 37px
}
.view_cont_old .se-material-news-bSize .se-material-detail-news-source {
    margin-top: 6px;
    margin-top: 10px
}
.view_cont_old .se-section-code.se-l-code_black div[class*=language-] {
    color: #fff;
    background: none
}
.view_cont_old .se-section-code.se-l-code_black .se-module-code {
    color: #f8f8f2;
    background: #272822
}
.view_cont_old .se-section-code.se-l-code_black .se-code-source-editor {
    color: #fff
}
.view_cont_old .se-section-code.se-l-code_black .token.se-code-cdata, .view_cont_old .se-section-code.se-l-code_black .token.se-code-comment, .view_cont_old .se-section-code.se-l-code_black .token.se-code-doctype, .view_cont_old .se-section-code.se-l-code_black .token.se-code-prolog {
    color: #62626b
}
.view_cont_old .se-section-code.se-l-code_black .token.se-code-punctuation {
    color: #fff
}
.view_cont_old .se-section-code.se-l-code_black .se-code-namespace {
    color: #13adb7
}
.view_cont_old .se-section-code.se-l-code_black .token.se-code-boolean, .view_cont_old .se-section-code.se-l-code_black .token.se-code-constant, .view_cont_old .se-section-code.se-l-code_black .token.se-code-deleted, .view_cont_old .se-section-code.se-l-code_black .token.se-code-number, .view_cont_old .se-section-code.se-l-code_black .token.se-code-property, .view_cont_old .se-section-code.se-l-code_black .token.se-code-symbol, .view_cont_old .se-section-code.se-l-code_black .token.se-code-tag {
    color: #f86634
}
.view_cont_old .se-section-code.se-l-code_black .token.se-code-attr-name, .view_cont_old .se-section-code.se-l-code_black .token.se-code-builtin, .view_cont_old .se-section-code.se-l-code_black .token.se-code-char, .view_cont_old .se-section-code.se-l-code_black .token.se-code-inserted, .view_cont_old .se-section-code.se-l-code_black .token.se-code-selector, .view_cont_old .se-section-code.se-l-code_black .token.se-code-string {
    color: #f761aa
}
.view_cont_old .se-section-code.se-l-code_black .language-css .token.se-code-string, .view_cont_old .se-section-code.se-l-code_black .style .token.se-code-string, .view_cont_old .se-section-code.se-l-code_black .token.se-code-entity, .view_cont_old .se-section-code.se-l-code_black .token.se-code-operator, .view_cont_old .se-section-code.se-l-code_black .token.se-code-url {
    color: #9fba45
}
.view_cont_old .se-section-code.se-l-code_black .token.se-code-atrule, .view_cont_old .se-section-code.se-l-code_black .token.se-code-attr-value, .view_cont_old .se-section-code.se-l-code_black .token.se-code-keyword {
    color: #f2c13f
}
.view_cont_old .se-section-code.se-l-code_black .token.se-code-function {
    color: #36bcfc
}
.view_cont_old .se-section-code.se-l-code_black .token.se-code-important, .view_cont_old .se-section-code.se-l-code_black .token.se-code-regex, .view_cont_old .se-section-code.se-l-code_black .token.se-code-variable {
    color: #af91fc
}
.view_cont_old .se-section-code.se-l-default {
    background-color: #fdfdfd
}
.view_cont_old .se-section-code.se-l-default .se-code-cdata, .view_cont_old .se-section-code.se-l-default .se-code-comment, .view_cont_old .se-section-code.se-l-default .se-code-doctype, .view_cont_old .se-section-code.se-l-default .se-code-prolog {
    color: #708091
}
.view_cont_old .se-section-code.se-l-default .se-code-punctuation {
    color: #666
}
.view_cont_old .se-section-code.se-l-default .se-code-namespace {
    color: #13adb7
}
.view_cont_old .se-section-code.se-l-default .se-code-boolean, .view_cont_old .se-section-code.se-l-default .se-code-constant, .view_cont_old .se-section-code.se-l-default .se-code-deleted, .view_cont_old .se-section-code.se-l-default .se-code-number, .view_cont_old .se-section-code.se-l-default .se-code-property, .view_cont_old .se-section-code.se-l-default .se-code-symbol, .view_cont_old .se-section-code.se-l-default .se-code-tag {
    color: #e57523
}
.view_cont_old .se-section-code.se-l-default .se-code-attr-name, .view_cont_old .se-section-code.se-l-default .se-code-builtin, .view_cont_old .se-section-code.se-l-default .se-code-char, .view_cont_old .se-section-code.se-l-default .se-code-inserted, .view_cont_old .se-section-code.se-l-default .se-code-selector, .view_cont_old .se-section-code.se-l-default .se-code-string {
    color: #60911b
}
.view_cont_old .se-section-code.se-l-default .language-css .se-code-string, .view_cont_old .se-section-code.se-l-default .se-code-entity, .view_cont_old .se-section-code.se-l-default .se-code-operator, .view_cont_old .se-section-code.se-l-default .se-code-url, .view_cont_old .se-section-code.se-l-default .style .se-code-string {
    color: #a77f71
}
.view_cont_old .se-section-code.se-l-default .se-code-atrule, .view_cont_old .se-section-code.se-l-default .se-code-attr-value, .view_cont_old .se-section-code.se-l-default .se-code-keyword {
    color: #137fb7
}
.view_cont_old .se-section-code.se-l-default .se-code-function {
    color: #df4a68
}
.view_cont_old .se-section-code.se-l-default .se-code-important, .view_cont_old .se-section-code.se-l-default .se-code-regex, .view_cont_old .se-section-code.se-l-default .se-code-variable {
    color: #b834a1
}
.view_cont_old .se-section-code.se-l-default .se-code-bold, .view_cont_old .se-section-code.se-l-default .se-code-important {
    font-weight: 700
}
.view_cont_old .se-section-code.se-l-default .se-code-italic {
    font-style: italic
}
.view_cont_old .se-section-code.se-l-default .se-code-entity {
    cursor: help
}
.view_cont_old .se-section-code.se-l-code_stripe .se-fs-fs13 {
    background-image: url(//editor-static.pstatic.net/v/blog//img/component-code-stripe-13-background.96780135.png);
    background-size: 24px 48px
}
.view_cont_old .se-section-code.se-l-code_stripe .se-fs-fs15 {
    background-image: url(//editor-static.pstatic.net/v/blog//img/component-code-stripe-15-background.a1398b1c.png);
    background-size: 24px 56px
}
.view_cont_old .se-section-code.se-l-code_stripe .se-fs-fs16 {
    background-image: url(//editor-static.pstatic.net/v/blog//img/component-code-stripe-16-background.1b5b46e2.png);
    background-size: 24px 60px
}
.view_cont_old .se-section-code.se-l-code_stripe .se-module-code {
    background-position: 0 0;
    background-image: -webkit-linear-gradient(#f4f5f5 25%, #eaecee 0, #eaecee 75%, #f4f5f5 0);
    background-image: linear-gradient(#f4f5f5 25%, #eaecee 0, #eaecee 75%, #f4f5f5 0)
}
.view_cont_old .se-section-code.se-l-code_stripe .token.se-code-cdata, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-comment, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-doctype, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-prolog {
    color: #708091
}
.view_cont_old .se-section-code.se-l-code_stripe .token.se-code-punctuation {
    color: #666
}
.view_cont_old .se-section-code.se-l-code_stripe .se-code-namespace {
    color: #13adb7
}
.view_cont_old .se-section-code.se-l-code_stripe .token.se-code-boolean, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-constant, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-deleted, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-number, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-property, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-symbol, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-tag {
    color: #e57523
}
.view_cont_old .se-section-code.se-l-code_stripe .token.se-code-attr-name, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-builtin, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-char, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-inserted, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-selector, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-string {
    color: #60911b
}
.view_cont_old .se-section-code.se-l-code_stripe .language-css .token.se-code-string, .view_cont_old .se-section-code.se-l-code_stripe .style .token.se-code-string, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-entity, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-operator, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-url {
    color: #a77f71
}
.view_cont_old .se-section-code.se-l-code_stripe .token.se-code-atrule, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-attr-value, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-keyword {
    color: #137fb7
}
.view_cont_old .se-section-code.se-l-code_stripe .token.se-code-function {
    color: #df4a68
}
.view_cont_old .se-section-code.se-l-code_stripe .token.se-code-important, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-regex, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-variable {
    color: #b834a1
}
.view_cont_old .se-section-code.se-l-code_stripe .token.se-code-important {
    font-weight: 400
}
.view_cont_old .se-section-code.se-l-code_stripe .token.se-code-cr:before, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-lf:before, .view_cont_old .se-section-code.se-l-code_stripe .token.se-code-tab:not(:empty):before {
    color: #e0d7d1
}
.view_cont_old .se-module-code {
    overflow-y: hidden;
    overflow-x: auto;
    padding: 12px 0
}
.view_cont_old .se-module-code.se-fs-fs13 div[class*=language-] {
    line-height: 24px
}
.view_cont_old .se-module-code.se-fs-fs15 div[class*=language-] {
    line-height: 28px
}
.view_cont_old .se-module-code.se-fs-fs16 div[class*=language-] {
    line-height: 30px
}
.view_cont_old .se-module-code div[class*=language-] {
    color: #000;
    background: none;
    font-family: Source Code Pro, sourcecodepro, se-sourcecodepro, Consolas, Monaco, Andale Mono, Ubuntu Mono, monospace, sans-serif;
    text-align: left;
    white-space: pre;
    word-spacing: normal;
    word-break: normal;
    word-wrap: normal;
    tab-size: 4;
    hyphens: none
}
.view_cont_old .se-module-code .se-code-source {
    display: inline-block;
    padding: 0 17px
}
.view_cont_old .se-code {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-code, .view_cont_old .se-sticker + .se-code {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-code {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-code {
    position: relative
}
.view_cont_old .se-oglink {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-oglink, .view_cont_old .se-sticker + .se-oglink {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-oglink {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-oglink {
    width: 100%;
    max-width: 450px
}
.view_cont_old .se-section-oglink .se-oglink-thumbnail {
    display: block;
    position: relative;
    z-index: 1
}
.view_cont_old .se-section-oglink .se-oglink-thumbnail:after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    border: 1px solid rgba(0, 0, 0, .1);
    content: ""
}
.view_cont_old .se-section-oglink .se-oglink-thumbnail-iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10
}
.view_cont_old .se-section-oglink .se-oglink-thumbnail-resource {
    width: 100%;
    height: auto;
    vertical-align: top
}
.view_cont_old .se-section-oglink .se-oglink-info {
    position: relative;
    display: block;
    padding: 14px 20px 13px;
    line-height: 1.4;
    text-align: left;
    box-sizing: border-box;
    font-size: 0;
    padding: 21px 26px 18px
}
.view_cont_old .se-section-oglink .se-oglink-info-container {
    display: inline-block;
    max-width: 100%;
    vertical-align: middle
}
.view_cont_old .se-section-oglink .se-oglink-thumbnail-video-icon {
    display: inline-block;
    width: 42px;
    height: 42px;
    background-position: -346px -162px;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto
}
.view_cont_old .se-section-oglink .se-oglink-title {
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    display: block;
    line-height: 15px;
    font-weight: 700;
    font-size: 13px;
    color: #333;
    font-size: 15px
}
.view_cont_old .se-section-oglink .se-oglink-summary {
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    margin-top: 5px;
    line-height: 18px;
    font-size: 12px;
    color: #999
}
.view_cont_old .se-l-og_bSize .se-section-oglink .se-oglink-summary {
    display: block;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all
}
.view_cont_old .se-section-oglink .se-oglink-summary {
    margin-top: 7px;
    font-size: 13px
}
.view_cont_old .se-section-oglink .se-oglink-url {
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    margin-top: 5px;
    line-height: 15px;
    font-size: 13px;
    color: #00a832;
    text-decoration: none;
    margin-top: 9px
}
.view_cont_old .se-section-oglink.se-l-text .se-oglink-info:before {
    content: "";
    display: inline-block;
    height: 100%;
    vertical-align: middle
}
.view_cont_old .se-section-oglink.se-l-text .se-oglink-thumbnail-resource {
    min-height: 85px;
    min-height: 110px
}
.view_cont_old .se-section-oglink.se-l-image .se-oglink-thumbnail {
    width: 85px;
    width: 110px
}
.view_cont_old .se-section-oglink.se-l-image .se-oglink-thumbnail ~ .se-oglink-info {
    position: absolute;
    left: 85px;
    right: 0;
    top: 0;
    bottom: 0;
    left: 110px
}
.view_cont_old .se-section-oglink.se-l-image .se-oglink-info:before {
    content: "";
    display: inline-block;
    height: 100%;
    vertical-align: middle
}
.view_cont_old .se-section-oglink.se-l-image .se-oglink-thumbnail-resource {
    min-height: 85px;
    min-height: 110px
}
.view_cont_old .se-section-oglink.se-l-large_image .se-oglink-thumbnail {
    overflow: hidden;
    max-height: 200px;
    max-height: 450px
}
.view_cont_old .se-section-oglink.se-l-large_image .se-oglink-thumbnail-resource {
    max-height: 450px
}
.view_cont_old .se-section-oglink.se-l-large_image .se-oglink-info {
    padding: 12px 16px 11px;
    padding: 21px 26px 18px
}
.view_cont_old .se-section-oglink.se-l-large_image .se-oglink-summary {
    max-height: 34px
}
.view_cont_old .se-section-oglink.se-l-og_bSize .se-oglink-thumbnail {
    overflow: hidden;
    max-height: 200px;
    max-height: 450px
}
.view_cont_old .se-section-oglink.se-l-og_bSize .se-oglink-info {
    padding: 12px 16px 11px;
    padding: 21px 26px 18px
}
.view_cont_old .se-section-oglink.se-l-vertical_image .se-oglink-thumbnail {
    overflow: hidden;
    width: 85px;
    height: 151px;
    width: 130px;
    height: 231px
}
.view_cont_old .se-section-oglink.se-l-vertical_image .se-oglink-thumbnail ~ .se-oglink-info {
    position: absolute;
    left: 85px;
    right: 0;
    top: 0;
    bottom: 0;
    left: 130px
}
.view_cont_old .se-section-oglink.se-l-vertical_image .se-oglink-info:before {
    content: "";
    display: inline-block;
    height: 100%;
    vertical-align: middle
}
.view_cont_old .se-section-oglink.se-l-vertical_image .se-oglink-summary {
    display: block;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    white-space: normal;
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_image .se-oglink-thumbnail {
    width: 85px;
    width: 120px
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_image .se-oglink-thumbnail ~ .se-oglink-info {
    position: absolute;
    left: 85px;
    right: 0;
    top: 0;
    bottom: 0;
    left: 120px
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_image .se-oglink-info:before {
    content: "";
    display: inline-block;
    height: 100%;
    vertical-align: middle
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_image .se-oglink-thumbnail-resource {
    min-height: 85px;
    min-height: 120px
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_image .se-oglink-summary {
    position: relative;
    display: inline-block;
    max-width: 100%;
    box-sizing: border-box;
    padding-right: 38px;
    margin-top: 4px;
    margin-top: 0;
    padding-right: 34px
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_image .se_affiliate_dummy_image {
    width: 1px;
    height: 1px;
    position: absolute;
    left: -1000px;
    filter: alpha(opacity=0);
    opacity: 0
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_image .se-oglink-title {
    max-height: 14px;
    line-height: 17px;
    font-size: 14px;
    white-space: nowrap;
    word-wrap: normal;
    max-height: 48px;
    line-height: 24px;
    font-size: 15px;
    display: block;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_image .se-oglink-npay {
    display: inline-block;
    width: 30px;
    height: 13px;
    background-position: -342px -109px;
    position: absolute;
    right: 0;
    margin: 2px 0 0 8px;
    margin: 2px 0 0 3px
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_text .se-oglink-info:before {
    content: "";
    display: inline-block;
    height: 100%;
    vertical-align: middle
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_text .se-oglink-summary {
    position: relative;
    display: inline-block;
    max-width: 100%;
    box-sizing: border-box;
    padding-right: 38px;
    margin-top: 4px;
    padding-right: 34px
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_text .se_affiliate_dummy_image {
    width: 1px;
    height: 1px;
    position: absolute;
    left: -1000px;
    filter: alpha(opacity=0);
    opacity: 0
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_text .se-oglink-title {
    max-height: 14px;
    line-height: 17px;
    font-size: 14px;
    white-space: nowrap;
    word-wrap: normal;
    max-height: 48px;
    line-height: 24px;
    font-size: 15px;
    display: block;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all
}
.view_cont_old .se-section-oglink.se-l-shopping_affiliate_text .se-oglink-npay {
    display: inline-block;
    width: 30px;
    height: 13px;
    background-position: -342px -109px;
    position: absolute;
    right: 0;
    margin: 2px 0 0 8px;
    margin: 2px 0 0 3px
}
.view_cont_old .se-module-oglink {
    display: block;
    position: relative;
    width: 100%;
    background-color: #fff;
    text-decoration: none;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .08);
    cursor: pointer
}
.view_cont_old .se-module-oglink:before {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    border: 1px solid rgba(0, 0, 0, .1);
    content: ""
}
.view_cont_old .se-oembed {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-oembed, .view_cont_old .se-sticker + .se-oembed {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-oembed {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-oembed.se-l-default .se-caption .se-fs- {
    font-size: 13px
}
.se-viewer:lang(ko-KR) .se-section-oembed.se-l-default .se-caption .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-oembed.se-l-default .se-caption .se-text-paragraph {
    line-height: 1.5;
    text-align: center
}
.view_cont_old .se-oembed .se-component-content-normal .se-section-oembed {
    max-width: 75%
}
.view_cont_old .se-oembed .se-component-content-fit .se-section-oembed {
    margin-right: -20px;
    margin-left: -20px;
    margin-right: 0;
    margin-left: 0
}
.view_cont_old .se-oembed .se-component-content-extend .se-section-oembed {
    margin-right: -20px;
    margin-left: -20px;
    margin-right: -40px;
    margin-left: -40px
}
.view_cont_old .se-oembed .se-component-content-fit .se-section-oembed-rich {
    margin-right: 0;
    margin-left: 0
}
.view_cont_old .se-oembed .se-component-content .se-section-oembed-video {
    max-width: none
}
.view_cont_old .se-oembed .se-component-content-normal .se-section-oembed-video {
    max-width: 75%
}
.view_cont_old .se-module-oembed, .view_cont_old .se-section-oembed {
    position: relative
}
.view_cont_old .se-module-oembed iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%
}
.view_cont_old .se-oembed-container {
    position: relative
}
.view_cont_old .se-placesMap-bookmark-layer {
    display: block;
    position: absolute;
    width: 166px;
    padding: 13px 14px 11px 15px;
    box-shadow: 1px 1px 7px 0 rgba(0, 0, 0, .15);
    border: 1px solid rgba(0, 0, 0, .15);
    background-color: #fff;
    z-index: 10;
    top: 64px;
    right: -7px;
    box-sizing: border-box;
    -webkit-animation-delay: 3s;
    animation-delay: 3s;
    -webkit-animation-duration: .3s;
    animation-duration: .3s;
    -webkit-animation-name: placesMap-bookmark-layer-animation;
    animation-name: placesMap-bookmark-layer-animation;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
    cursor: default
}
.view_cont_old .se-placesMap-bookmark-layer:before {
    content: "";
    display: block;
    padding: 4px;
    border-top: 1px solid rgba(0, 0, 0, .15);
    border-left: 1px solid rgba(0, 0, 0, .15);
    background-color: #fff;
    position: absolute;
    top: -5px;
    right: 20px;
    -webkit-transform: rotate(50deg) skew(11deg);
    -ms-transform: rotate(50deg) skew(11deg);
    transform: rotate(50deg) skew(11deg);
    box-shadow: -2px -2px 4px -3px rgba(0, 0, 0, .3)
}
.view_cont_old .se-placesMap-bookmark-layer.se-placesMap-bookmark-layer-saved {
    width: 174px;
    text-decoration: none;
    cursor: pointer
}
.view_cont_old .se-placesMap-bookmark-layer.se-placesMap-bookmark-layer-saved .se-placesMap-bookmark-contents:after {
    content: "";
    display: inline-block;
    border: 3px solid #fff;
    border-left-color: #00c73c;
    margin: 0 0 2px 4px;
    vertical-align: middle
}
.view_cont_old .se-placesMap-bookmark-layer .se-placesMap-bookmark-contents {
    font-size: 12px;
    line-height: 1.42;
    font-family: se-nanumgothic, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo;
    color: #111
}
.view_cont_old .se-placesMap-bookmark-layer .se-placesMap-bookmark-contents-highlight {
    color: #00c73c;
    font-weight: 700
}
@-webkit-keyframes placesMap-bookmark-layer-animation {
    0% {
        visibility: visible;
        z-index: 10;
        opacity: 1
    }
    99.9% {
        visibility: visible;
        z-index: 10;
        opacity: 0
    }
    to {
        visibility: hidden;
        z-index: -1;
        opacity: 0
    }
}
@keyframes placesMap-bookmark-layer-animation {
    0% {
        visibility: visible;
        z-index: 10;
        opacity: 1
    }
    99.9% {
        visibility: visible;
        z-index: 10;
        opacity: 0
    }
    to {
        visibility: hidden;
        z-index: -1;
        opacity: 0
    }
}
.view_cont_old .se-placesMap {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-placesMap, .view_cont_old .se-sticker + .se-placesMap {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-placesMap {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-placesMap {
    background-color: #fff;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .08);
    border: 1px solid rgba(0, 0, 0, .12);
    box-sizing: border-box;
    text-align: left;
    cursor: pointer
}
.view_cont_old .se-section-placesMap .se-module-map-text {
    position: relative;
    display: table;
    table-layout: fixed;
    width: 100%;
    box-sizing: border-box;
    font-size: 0;
    padding-right: 9px;
    border-collapse: separate
}
.view_cont_old .se-section-placesMap .se-module-map-image:before {
    border-width: 0;
    border-bottom-width: 1px
}
.view_cont_old .se-section-placesMap .se-map-info {
    display: table-cell;
    width: 100%;
    padding-right: 10px;
    white-space: nowrap
}
.view_cont_old .se-section-placesMap .se-map-title {
    font-size: 13px;
    font-weight: 700;
    color: #333;
    font-size: 15px
}
.view_cont_old .se-section-placesMap .se-map-address {
    font-size: 11px;
    color: #999
}
.view_cont_old .se-section-placesMap .se-placesMap-additional-button-wrap {
    position: relative;
    display: table-cell;
    width: 40px;
    padding: 1px 2px 0;
    vertical-align: middle
}
.view_cont_old .se-section-placesMap .se-placesMap-additional-button {
    display: block;
    width: 40px;
    box-sizing: border-box;
    text-align: center;
    text-decoration: none
}
.view_cont_old .se-section-placesMap .se-placesMap-additional-button:before {
    content: "";
    display: block;
    margin-bottom: 2px
}
.view_cont_old .se-section-placesMap .se-placesMap-additional-button-label {
    display: block;
    margin-top: 2px;
    font-size: 10px;
    line-height: 1.1;
    font-weight: 700;
    color: #00c73c
}
.view_cont_old .se-section-placesMap .se-placesMap-button-bookmark:before {
    display: inline-block;
    width: 20px;
    height: 20px;
    background-position: -259px -195px
}
.view_cont_old .se-section-placesMap .se-placesMap-button-bookmark.se-placesMap-button-bookmark-saved:before {
    display: inline-block;
    width: 20px;
    height: 20px;
    background-position: -104px -219px
}
.view_cont_old .se-section-placesMap .se-placesMap-button-reservation:before {
    display: inline-block;
    width: 20px;
    height: 20px;
    background-position: -237px -195px
}
.view_cont_old .se-section-placesMap .se-placesMap-button-call {
    line-height: 1
}
.view_cont_old .se-section-placesMap .se-placesMap-button-call:before {
    display: inline-block;
    width: 20px;
    height: 20px;
    background-position: -260px -172px
}
.view_cont_old .se-section-placesMap.se-l-default {
    border-left-width: 0;
    border-right-width: 0;
    margin-left: -20px;
    margin-right: -20px;
    border-left-width: 1px;
    border-right-width: 1px;
    margin: 0
}
.view_cont_old .se-section-placesMap.se-l-default .se-dynamic-map {
    position: relative;
    z-index: 0
}
.view_cont_old .se-section-placesMap.se-l-default .se-module-map-image {
    position: relative
}
.view_cont_old .se-section-placesMap.se-l-default .se-module-map-image .se-map-link {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%
}
.view_cont_old .se-section-placesMap.se-l-default .se-map-info {
    padding: 16px 10px 15px 20px
}
.view_cont_old .se-section-placesMap.se-l-default .se-map-address {
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    margin-top: 4px
}
.view_cont_old .se-section-placesMap.se-l-map_text {
    height: 60px;
    max-width: 450px;
    box-sizing: border-box;
    height: 70px
}
.view_cont_old .se-section-placesMap.se-l-map_text .se-module-map-text {
    padding-right: 20px
}
.view_cont_old .se-section-placesMap.se-l-map_text .se-map-marker {
    display: block;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    width: 60px;
    box-sizing: border-box;
    width: 70px;
    border-right: 1px solid #eee
}
.view_cont_old .se-section-placesMap.se-l-map_text .se-map-marker:before {
    display: block;
    width: 20px;
    height: 27px;
    background-position: -198px -47px;
    content: "";
    position: absolute;
    top: 16px;
    left: 19px;
    top: 20px;
    left: 24px
}
.view_cont_old .se-section-placesMap.se-l-map_text .se-map-info {
    padding: 13px 10px 13px 59px;
    padding: 16px 10px 15px 90px
}
.view_cont_old .se-section-placesMap.se-l-map_text .se-map-address {
    margin-top: 3px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple .se-module-map-text {
    margin: 0 auto;
    max-width: 538px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple .se-module-map-text:not(:last-child):after {
    content: "";
    display: block;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 1px;
    background-color: #f2f2f2
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple .se-module-map-text:before {
    content: "";
    position: absolute;
    top: 50%;
    left: 19px;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    display: inline-block;
    width: 18px;
    height: 27px;
    background-position: -372px -208px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple .se-module-map-text.se-module-map-text-spot-0:before {
    background-position: -372px -208px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple .se-module-map-text.se-module-map-text-spot-1:before {
    background-position: -220px -47px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple .se-module-map-text.se-module-map-text-spot-2:before {
    background-position: -240px -47px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple .se-module-map-text.se-module-map-text-spot-3:before {
    background-position: -260px -47px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple .se-module-map-text.se-module-map-text-spot-4:before {
    background-position: -280px -47px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple .se-map-title {
    font-size: 13px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-default {
    margin-right: auto;
    margin-left: auto;
    padding-bottom: 14px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-default .se-module-map-image {
    margin-bottom: 14px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-default .se-module-map-text {
    padding-right: 19px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-default .se-module-map-text:before {
    left: 21px;
    left: 19px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-default .se-map-info {
    padding: 21px 10px 21px 50px;
    padding: 18px 10px 18px 49px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-default .se-map-address {
    margin-top: 3px;
    margin-top: 4px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-map_text {
    height: auto;
    padding: 8px 0 9px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-map_text .se-module-map-text:not(:last-child):after {
    left: 20px;
    right: 20px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-map_text .se-module-map-text:before {
    left: 29px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-map_text .se-map-info {
    padding: 20px 10px 18px 49px;
    padding: 18px 10px 17px 59px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-map_text .se-map-title {
    font-size: 13px
}
.view_cont_old .se-section-placesMap.se-section-placesMap-multiple.se-l-map_text .se-map-address {
    margin-top: 5px
}
.view_cont_old .se-table {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-table, .view_cont_old .se-sticker + .se-table {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-table {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-table.se-l-default .se-fs- {
    font-size: 16px;
    font-size: 15px
}
.se-viewer:lang(ko-KR) .se-section-table.se-l-default .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-table.se-l-default .se-text-paragraph {
    line-height: 1.6
}
.view_cont_old .se-section-table.se-l-table_layout1 .se-fs- {
    font-size: 16px;
    font-size: 15px
}
.se-viewer:lang(ko-KR) .se-section-table.se-l-table_layout1 .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-table.se-l-table_layout1 .se-text-paragraph {
    line-height: 1.6
}
.view_cont_old .se-section-table.se-l-table_layout2 .se-fs- {
    font-size: 16px;
    font-size: 15px
}
.se-viewer:lang(ko-KR) .se-section-table.se-l-table_layout2 .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-table.se-l-table_layout2 .se-text-paragraph {
    line-height: 1.6
}
.view_cont_old .se-section-table.se-l-table_layout3 .se-fs- {
    font-size: 16px;
    font-size: 15px
}
.se-viewer:lang(ko-KR) .se-section-table.se-l-table_layout3 .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-table.se-l-table_layout3 .se-text-paragraph {
    line-height: 1.6
}
.view_cont_old .se-section-table.se-l-table_layout4 .se-fs- {
    font-size: 16px;
    font-size: 15px
}
.se-viewer:lang(ko-KR) .se-section-table.se-l-table_layout4 .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-table.se-l-table_layout4 .se-text-paragraph {
    line-height: 1.6
}
.view_cont_old .se-section-table.se-l-table_layout5 .se-fs- {
    font-size: 16px;
    font-size: 15px
}
.se-viewer:lang(ko-KR) .se-section-table.se-l-table_layout5 .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-table.se-l-table_layout5 .se-text-paragraph {
    line-height: 1.6
}
.view_cont_old .se-section-table.se-l-table_layout6 .se-fs- {
    font-size: 16px;
    font-size: 15px
}
.se-viewer:lang(ko-KR) .se-section-table.se-l-table_layout6 .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-table.se-l-table_layout6 .se-text-paragraph {
    line-height: 1.6
}
.view_cont_old .se-section-table.se-l-table_layout7 .se-fs- {
    font-size: 16px;
    font-size: 15px
}
.se-viewer:lang(ko-KR) .se-section-table.se-l-table_layout7 .se-ff- {
    font-family: se-nanumgothic, sans-serif
}
.view_cont_old .se-section-table.se-l-table_layout7 .se-text-paragraph {
    line-height: 1.6
}
.view_cont_old .se-table-content {
    width: 100%;
    border-collapse: separate;
    text-align: left
}
.view_cont_old .se-table-content .se-tr:first-child .se-cell {
    border-top-width: 0
}
.view_cont_old .se-tr {
    height: 40px
}
.view_cont_old .se-cell {
    padding: 10px;
    background-color: #fff;
    vertical-align: middle;
    box-sizing: border-box;
    max-width: 0
}
.view_cont_old .se-section-table.se-l-default .se-table-content {
    border: solid #d2d2d2;
    border-width: 1px 0 0 1px
}
.view_cont_old .se-section-table.se-l-default .se-table-content .se-cell {
    border: solid #d2d2d2;
    border-width: 0 1px 1px 0
}
.view_cont_old .se-section-table.se-l-table_layout1 .se-table-content {
    border: solid #d2d2d2;
    border-width: 2px 1px 1px 2px
}
.view_cont_old .se-section-table.se-l-table_layout1 .se-cell {
    border: solid #d2d2d2;
    border-width: 0 1px 1px 0
}
.view_cont_old .se-section-table.se-l-table_layout1 .se-tr:first-child .se-cell {
    background-color: #f7f7f7
}
.view_cont_old .se-section-table.se-l-table_layout2 .se-table-content {
    border-collapse: collapse;
    border: 1px solid #d2d2d2
}
.view_cont_old .se-section-table.se-l-table_layout2 .se-cell {
    border: 1px dashed #d2d2d2
}
.view_cont_old .se-section-table.se-l-table_layout2 .se-tr:first-child .se-cell {
    background-color: #f7f7f7
}
.view_cont_old .se-section-table.se-l-table_layout3 .se-table-content {
    border: solid #858585;
    border-width: 2px 0
}
.view_cont_old .se-section-table.se-l-table_layout3 .se-cell {
    border-top: 1px solid #c2c2c2
}
.view_cont_old .se-section-table.se-l-table_layout3 .se-tr:first-child .se-cell {
    background-color: #f7f7f7
}
.view_cont_old .se-section-table.se-l-table_layout3 .se-tr:last-child:not(:first-child) .se-cell {
    border-top-width: 3px;
    border-top-style: double
}
.view_cont_old .se-section-table.se-l-table_layout4 .se-table-content {
    border: solid #858585;
    border-width: 1px 0
}
.view_cont_old .se-section-table.se-l-table_layout4 .se-cell {
    border-top: 1px solid #e2e2e2
}
.view_cont_old .se-section-table.se-l-table_layout5 .se-table-content {
    border-collapse: collapse;
    border-top: 2px solid #404040;
    border-bottom: 1px solid #9f9f9f
}
.view_cont_old .se-section-table.se-l-table_layout5 .se-cell {
    border-top: 1px solid #f0f0f0
}
.view_cont_old .se-section-table.se-l-table_layout5 .se-tr:first-child .se-cell {
    border-bottom: 1px solid #9f9f9f
}
.view_cont_old .se-section-table.se-l-table_layout5 .se-tr:first-child + .se-tr .se-cell {
    border-top: 0
}
.view_cont_old .se-section-table.se-l-table_layout6 .se-table-content {
    border-collapse: collapse;
    border-bottom: 1px solid #939393
}
.view_cont_old .se-section-table.se-l-table_layout6 .se-cell {
    border-top: 1px solid #e0e0e0
}
.view_cont_old .se-section-table.se-l-table_layout6 .se-tr:first-child .se-cell {
    border-bottom: 2px solid #272727
}
.view_cont_old .se-section-table.se-l-table_layout6 .se-tr:first-child + .se-tr .se-cell {
    border-top: 0
}
.view_cont_old .se-section-table.se-l-table_layout7 .se-table-content {
    border-bottom: 1px solid #e2e2e2
}
.view_cont_old .se-section-table.se-l-table_layout7 .se-cell {
    border-top: 1px solid #e2e2e2
}
.view_cont_old .se-section-table.se-l-table_layout7 .se-tr:nth-child(odd) .se-cell {
    background-color: #f7f7f7
}
.view_cont_old .se-section-table.se-l-table_layout7 .se-tr:first-child .se-cell {
    background-color: #e2e2e2
}
.view_cont_old .se-table-container {
    position: relative;
    width: 100%;
    background-color: #fff;
    font-size: 0;
    overflow-y: hidden;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch
}
@font-face {
    font-family: Symbola;
    src: url(https://ssl.pstatic.net/static/matheditor/1.1.6/Symbola.eot);
    src: local("Symbola Regular"), local("Symbola"), url(https://ssl.pstatic.net/static/matheditor/1.1.6/Symbola.woff2) format("woff2"), url(https://ssl.pstatic.net/static/matheditor/1.1.6/Symbola.woff) format("woff"), url(https://ssl.pstatic.net/static/matheditor/1.1.6/Symbola.ttf) format("truetype"), url(https://ssl.pstatic.net/static/matheditor/1.1.6/Symbola.svg#Symbola) format("svg")
}
.view_cont_old .mq-editable-field, .view_cont_old .mq-editable-field .mq-cursor {
    display: -moz-inline-box;
    display: inline-block
}
.view_cont_old .mq-editable-field .mq-cursor {
    border-left: 1px solid #000;
    margin-left: -1px;
    position: relative;
    z-index: 1;
    padding: 0
}
.view_cont_old .mq-editable-field .mq-cursor.mq-blink {
    visibility: hidden
}
.view_cont_old .mq-editable-field, .view_cont_old .mq-math-mode .mq-editable-field {
    border: 1px solid gray
}
.view_cont_old .mq-editable-field.mq-focused, .view_cont_old .mq-math-mode .mq-editable-field.mq-focused {
    box-shadow: 0 0 1px 2px #8bd, inset 0 0 2px 0 #6ae;
    border-color: #709ac0;
    border-radius: 1px
}
.view_cont_old .mq-math-mode .mq-editable-field {
    margin: 1px
}
.view_cont_old .mq-editable-field .mq-latex-command-input {
    color: inherit;
    font-family: Courier New, monospace;
    border: 1px solid gray;
    padding-right: 1px;
    margin-right: 1px;
    margin-left: 2px
}
.view_cont_old .mq-editable-field .mq-latex-command-input.mq-empty {
    background: transparent
}
.view_cont_old .mq-editable-field .mq-latex-command-input.mq-hasCursor {
    border-color: ActiveBorder
}
.view_cont_old .mq-editable-field .mq-cursor:only-child:after, .view_cont_old .mq-editable-field.mq-empty:after, .view_cont_old .mq-editable-field.mq-text-mode:after, .view_cont_old .mq-editable-field .mq-textarea + .mq-cursor:last-child:after, .view_cont_old .mq-math-mode .mq-empty:after {
    visibility: hidden;
    content: "c"
}
.view_cont_old .mq-editable-field .mq-text-mode .mq-cursor:only-child:after {
    content: ""
}
.view_cont_old .mq-editable-field.mq-text-mode {
    overflow-x: auto;
    overflow-y: hidden
}
.view_cont_old .mq-math-mode .mq-root-block, .view_cont_old .mq-root-block {
    display: -moz-inline-box;
    display: inline-block;
    width: 100%;
    padding: 2px;
    box-sizing: border-box;
    white-space: nowrap;
    overflow: hidden;
    vertical-align: middle
}
.view_cont_old .mq-math-mode {
    font-variant: normal;
    font-weight: 400;
    font-style: normal;
    font-size: 115%;
    line-height: 1
}
.view_cont_old .mq-math-mode, .view_cont_old .mq-math-mode .mq-non-leaf, .view_cont_old .mq-math-mode .mq-scaled {
    display: -moz-inline-box;
    display: inline-block
}
.view_cont_old .mq-math-mode .mq-nonSymbola, .view_cont_old .mq-math-mode .mq-text-mode, .view_cont_old .mq-math-mode var {
    font-family: Times New Roman, Symbola, serif;
    line-height: .9
}
.view_cont_old .mq-math-mode * {
    font-size: inherit;
    line-height: inherit;
    margin: 0;
    padding: 0;
    border-color: #000;
    -webkit-user-select: none;
    user-select: none;
    box-sizing: border-box
}
.view_cont_old .mq-math-mode .mq-empty {
    background: #ccc
}
.view_cont_old .mq-math-mode.mq-empty, .view_cont_old .mq-math-mode .mq-empty.mq-root-block {
    background: transparent
}
.view_cont_old .mq-math-mode .mq-text-mode {
    display: inline-block
}
.view_cont_old .mq-math-mode .mq-text-mode.mq-hasCursor {
    box-shadow: inset 0 .1em .2em #a9a9a9;
    padding: 0 .1em;
    margin: 0 -.1em;
    min-width: 1ex
}
.view_cont_old .mq-math-mode .mq-font {
    font: 1em Times New Roman, Symbola, serif
}
.view_cont_old .mq-math-mode .mq-font * {
    font-family: inherit;
    font-style: inherit
}
.view_cont_old .mq-math-mode b, .view_cont_old .mq-math-mode b.mq-font {
    font-weight: bolder
}
.view_cont_old .mq-math-mode i, .view_cont_old .mq-math-mode i.mq-font, .view_cont_old .mq-math-mode var {
    font-style: italic
}
.view_cont_old .mq-math-mode var.mq-f {
    margin-right: .2em;
    margin-left: .1em
}
.view_cont_old .mq-math-mode .mq-roman var.mq-f {
    margin: 0
}
.view_cont_old .mq-math-mode big {
    font-size: 200%
}
.view_cont_old .mq-math-mode .mq-int > big {
    display: inline-block;
    -webkit-transform: scaleX(.7);
    -ms-transform: scaleX(.7);
    transform: scaleX(.7);
    vertical-align: -.16em
}
.view_cont_old .mq-math-mode .mq-int > .mq-supsub {
    font-size: 80%;
    vertical-align: -1.1em;
    padding-right: .2em
}
.view_cont_old .mq-math-mode .mq-int > .mq-supsub > .mq-sup > .mq-sup-inner {
    vertical-align: 1.3em
}
.view_cont_old .mq-math-mode .mq-int > .mq-supsub > .mq-sub {
    margin-left: -.35em
}
.view_cont_old .mq-math-mode .mq-roman {
    font-style: normal
}
.view_cont_old .mq-math-mode .mq-sans-serif {
    font-family: sans-serif
}
.view_cont_old .mq-math-mode .mq-monospace {
    font-family: monospace, Symbola, serif
}
.view_cont_old .mq-math-mode .mq-overline {
    border-top: 1px solid #000;
    margin-top: 1px
}
.view_cont_old .mq-math-mode .mq-underline {
    border-bottom: 1px solid #000;
    margin-bottom: 1px
}
.view_cont_old .mq-math-mode .mq-binary-operator {
    padding: 0 .2em;
    display: -moz-inline-box;
    display: inline-block
}
.view_cont_old .mq-math-mode .mq-supsub {
    text-align: left;
    font-size: 90%;
    vertical-align: -.5em
}
.view_cont_old .mq-math-mode .mq-supsub.mq-sup-only {
    vertical-align: .5em
}
.view_cont_old .mq-math-mode .mq-supsub.mq-sup-only .mq-sup {
    display: inline-block;
    vertical-align: text-bottom
}
.view_cont_old .mq-math-mode .mq-supsub .mq-sup {
    display: block
}
.view_cont_old .mq-math-mode .mq-supsub .mq-sub {
    display: block;
    float: left
}
.view_cont_old .mq-math-mode .mq-supsub .mq-binary-operator {
    padding: 0 .1em
}
.view_cont_old .mq-math-mode .mq-supsub .mq-fraction {
    font-size: 70%
}
.view_cont_old .mq-math-mode sup.mq-nthroot {
    font-size: 80%;
    vertical-align: .8em;
    margin-right: -.6em;
    margin-left: .2em;
    min-width: .5em
}
.view_cont_old .mq-math-mode .mq-paren {
    padding: 0 .1em;
    vertical-align: top;
    -webkit-transform-origin: center .06em;
    -ms-transform-origin: center .06em;
    transform-origin: center .06em
}
.view_cont_old .mq-math-mode .mq-paren.mq-ghost {
    color: silver
}
.view_cont_old .mq-math-mode .mq-paren + span {
    margin-top: .1em;
    margin-bottom: .1em
}
.view_cont_old .mq-math-mode .mq-array {
    vertical-align: middle;
    text-align: center
}
.view_cont_old .mq-math-mode .mq-array > span {
    display: block
}
.view_cont_old .mq-math-mode .mq-operator-name {
    font-family: Symbola, Times New Roman, serif;
    line-height: .9;
    font-style: normal
}
.view_cont_old .mq-math-mode var.mq-operator-name.mq-first {
    padding-left: .2em
}
.view_cont_old .mq-math-mode .mq-supsub.mq-after-operator-name, .view_cont_old .mq-math-mode var.mq-operator-name.mq-last {
    padding-right: .2em
}
.view_cont_old .mq-math-mode .mq-fraction {
    font-size: 90%;
    text-align: center;
    vertical-align: -.4em;
    padding: 0 .2em
}
.view_cont_old .mq-math-mode .mq-fraction, .view_cont_old .mq-math-mode .mq-large-operator, .view_cont_old .mq-math-mode x:-moz-any-link {
    display: -moz-groupbox
}
.view_cont_old .mq-math-mode .mq-fraction, .view_cont_old .mq-math-mode .mq-large-operator, .view_cont_old .mq-math-mode x:-moz-any-link, .view_cont_old .mq-math-mode x:default {
    display: inline-block
}
.view_cont_old .mq-math-mode .mq-denominator, .view_cont_old .mq-math-mode .mq-dot-recurring, .view_cont_old .mq-math-mode .mq-numerator {
    display: block
}
.view_cont_old .mq-math-mode .mq-numerator {
    padding: 0 .1em
}
.view_cont_old .mq-math-mode .mq-denominator {
    border-top: 1px solid;
    float: right;
    width: 100%;
    padding: .1em
}
.view_cont_old .mq-math-mode .mq-dot-recurring {
    text-align: center;
    height: .3em
}
.view_cont_old .mq-math-mode .mq-sqrt-prefix {
    padding-top: 0;
    position: relative;
    top: .1em;
    vertical-align: top;
    -webkit-transform-origin: top;
    -ms-transform-origin: top;
    transform-origin: top
}
.view_cont_old .mq-math-mode .mq-sqrt-stem {
    border-top: 1px solid;
    margin-top: 1px;
    padding-left: .15em;
    padding-right: .2em;
    margin-right: .1em;
    padding-top: 1px
}
.view_cont_old .mq-math-mode .mq-diacritic-above {
    display: block;
    text-align: center;
    line-height: .4em
}
.view_cont_old .mq-math-mode .mq-diacritic-stem, .view_cont_old .mq-math-mode .mq-hat-prefix {
    display: block;
    text-align: center
}
.view_cont_old .mq-math-mode .mq-hat-prefix {
    line-height: .95em;
    margin-bottom: -.7em;
    -ms-transform: scaleX(1.5);
    transform: scaleX(1.5);
    -moz-transform: scaleX(1.5);
    -o-transform: scaleX(1.5);
    -webkit-transform: scaleX(1.5)
}
.view_cont_old .mq-math-mode .mq-hat-stem {
    display: block
}
.view_cont_old .mq-math-mode .mq-large-operator {
    vertical-align: -.2em;
    padding: .2em;
    text-align: center
}
.view_cont_old .mq-math-mode .mq-large-operator .mq-from, .view_cont_old .mq-math-mode .mq-large-operator .mq-to, .view_cont_old .mq-math-mode .mq-large-operator big {
    display: block
}
.view_cont_old .mq-math-mode .mq-large-operator .mq-from, .view_cont_old .mq-math-mode .mq-large-operator .mq-to {
    font-size: 80%
}
.view_cont_old .mq-math-mode .mq-large-operator .mq-from {
    float: right;
    width: 100%
}
.view_cont_old .mq-math-mode, .view_cont_old .mq-math-mode .mq-editable-field {
    cursor: text;
    font-family: Symbola, Times New Roman, serif
}
.view_cont_old .mq-math-mode .mq-overarc {
    border-top: 1px solid #000;
    border-top-right-radius: 50% .3em;
    border-top-left-radius: 50% .3em;
    margin-top: 1px;
    padding-top: .15em
}
.view_cont_old .mq-math-mode .mq-overarrow {
    min-width: .5em;
    border-top: 1px solid #000;
    margin-top: 1px;
    padding-top: .2em;
    text-align: center
}
.view_cont_old .mq-math-mode .mq-overarrow:before {
    display: block;
    position: relative;
    top: -.34em;
    font-size: .5em;
    line-height: 0;
    content: "\27A4";
    text-align: right
}
.view_cont_old .mq-math-mode .mq-overarrow.mq-arrow-left:before {
    -webkit-transform: scaleX(-1);
    -ms-transform: scaleX(-1);
    transform: scaleX(-1);
    filter: FlipH;
    -ms-filter: "FlipH"
}
.view_cont_old .mq-math-mode .mq-overarrow.mq-arrow-both {
    vertical-align: text-bottom
}
.view_cont_old .mq-math-mode .mq-overarrow.mq-arrow-both.mq-empty {
    min-height: 1.23em
}
.view_cont_old .mq-math-mode .mq-overarrow.mq-arrow-both.mq-empty:after {
    top: -.34em
}
.view_cont_old .mq-math-mode .mq-overarrow.mq-arrow-both:before {
    -webkit-transform: scaleX(-1);
    -ms-transform: scaleX(-1);
    transform: scaleX(-1);
    filter: FlipH;
    -ms-filter: "FlipH"
}
.view_cont_old .mq-math-mode .mq-overarrow.mq-arrow-both:after {
    display: block;
    position: relative;
    top: -2.3em;
    font-size: .5em;
    line-height: 0;
    content: "\27A4";
    visibility: visible;
    text-align: right
}
.view_cont_old .mq-editable-field .mq-selection, .view_cont_old .mq-editable-field .mq-selection .mq-non-leaf, .view_cont_old .mq-editable-field .mq-selection .mq-scaled, .view_cont_old .mq-math-mode .mq-selection, .view_cont_old .mq-math-mode .mq-selection .mq-non-leaf, .view_cont_old .mq-math-mode .mq-selection .mq-scaled {
    background: #b4d5fe !important;
    background: Highlight !important;
    color: HighlightText;
    border-color: HighlightText
}
.view_cont_old .mq-editable-field .mq-selection .mq-matrixed, .view_cont_old .mq-math-mode .mq-selection .mq-matrixed {
    background: #39f !important
}
.view_cont_old .mq-editable-field .mq-selection .mq-matrixed-container, .view_cont_old .mq-math-mode .mq-selection .mq-matrixed-container {
    filter: progid:DXImageTransform.Microsoft.Chroma(color="#3399FF") !important
}
.view_cont_old .mq-editable-field .mq-selection.mq-blur, .view_cont_old .mq-editable-field .mq-selection.mq-blur .mq-matrixed, .view_cont_old .mq-editable-field .mq-selection.mq-blur .mq-non-leaf, .view_cont_old .mq-editable-field .mq-selection.mq-blur .mq-scaled, .view_cont_old .mq-math-mode .mq-selection.mq-blur, .view_cont_old .mq-math-mode .mq-selection.mq-blur .mq-matrixed, .view_cont_old .mq-math-mode .mq-selection.mq-blur .mq-non-leaf, .view_cont_old .mq-math-mode .mq-selection.mq-blur .mq-scaled {
    border-color: #000
}
.view_cont_old .mq-editable-field .mq-selection.mq-blur .mq-matrixed-container, .view_cont_old .mq-math-mode .mq-selection.mq-blur .mq-matrixed-container {
    filter: progid:DXImageTransform.Microsoft.Chroma(color="#D4D4D4") !important
}
.view_cont_old .mq-math-mode .mq-matrixed {
    background: #fff;
    display: -moz-inline-box;
    display: inline-block
}
.view_cont_old .mq-math-mode .mq-matrixed-container {
    filter: progid:DXImageTransform.Microsoft.Chroma(color="white");
    margin-top: -.1em
}
.view_cont_old .lama-viewer {
    vertical-align: middle;
    overflow: hidden
}
.view_cont_old .lama-editor, .view_cont_old .lama-viewer {
    display: inline-block
}
.view_cont_old .mq-math-mode-wrapper {
    text-align: center
}
.view_cont_old .mq-math-mode * {
    -webkit-user-select: auto;
    user-select: auto
}
.view_cont_old .mq-math-mode.mq-editable-field * {
    -webkit-user-select: none;
    user-select: none
}
.view_cont_old .mq-editable-field, .view_cont_old .mq-math-mode .mq-editable-field {
    border: 0
}
.view_cont_old .mq-editable-field.mq-focused, .view_cont_old .mq-math-mode .mq-editable-field.mq-focused {
    box-shadow: none
}
.view_cont_old .mq-math-mode, .view_cont_old .mq-math-mode .mq-editable-field {
    font-family: Symbola, Times New Roman, AppleMyungjo, batang, \\BC14\D0D5, serif
}
.view_cont_old .mq-math-mode .mq-root-block {
    padding-top: .44em;
    padding-bottom: .44em
}
.view_cont_old .mq-editable-field .mq-selection, .view_cont_old .mq-editable-field .mq-selection .mq-non-leaf, .view_cont_old .mq-editable-field .mq-selection .mq-scaled, .view_cont_old .mq-math-mode .mq-selection, .view_cont_old .mq-math-mode .mq-selection .mq-non-leaf, .view_cont_old .mq-math-mode .mq-selection .mq-scaled {
    background-color: #ccf4d8 !important
}
.view_cont_old .mq-math-mode .mq-selection .mq-nthroot {
    position: relative;
    z-index: 2
}
.view_cont_old .mq-math-mode .mq-text-mode {
    white-space: pre
}
.view_cont_old .mq-math-mode .mq-empty {
    color: currentColor
}
.view_cont_old .mq-math-mode .mq-empty, .view_cont_old .mq-math-mode .mq-hasCursor {
    position: relative;
    padding-left: .2em;
    padding-right: .2em;
    background-color: transparent
}
.view_cont_old .mq-math-mode .mq-hasCursor > span, .view_cont_old .mq-math-mode .mq-hasCursor > sup, .view_cont_old .mq-math-mode .mq-hasCursor > var {
    position: relative;
    z-index: 1
}
.view_cont_old .mq-math-mode .mq-empty:before, .view_cont_old .mq-math-mode .mq-hasCursor:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border: 1px dotted #555
}
.view_cont_old .mq-math-mode .mq-hasCursor:before {
    background-color: #e6e6e6;
    z-index: 0
}
.view_cont_old .mq-math-mode .mq-text-mode.mq-hasCursor {
    border: 1px dotted #555;
    background-color: #e6e6e6
}
.view_cont_old .mq-math-mode .mq-root-block.mq-empty:before, .view_cont_old .mq-math-mode .mq-root-block.mq-hasCursor:before, .view_cont_old .mq-math-mode .mq-text-mode.mq-hasCursor:before {
    display: none
}
.view_cont_old .mq-editable-field .mq-selection.mq-blur, .view_cont_old .mq-editable-field .mq-selection.mq-blur .mq-matrixed, .view_cont_old .mq-editable-field .mq-selection.mq-blur .mq-non-leaf, .view_cont_old .mq-editable-field .mq-selection.mq-blur .mq-scaled, .view_cont_old .mq-math-mode .mq-selection.mq-blur, .view_cont_old .mq-math-mode .mq-selection.mq-blur .mq-matrixed, .view_cont_old .mq-math-mode .mq-selection.mq-blur .mq-non-leaf, .view_cont_old .mq-math-mode .mq-selection.mq-blur .mq-scaled {
    background: #d4d4d4 !important;
    color: #000
}
.view_cont_old .mq-editable-field .mq-textarea, .view_cont_old .mq-math-mode .mq-textarea {
    position: relative;
    -webkit-user-select: text;
    user-select: text
}
.view_cont_old .mq-editable-field .mq-selectable, .view_cont_old .mq-editable-field .mq-textarea *, .view_cont_old .mq-math-mode .mq-selectable, .view_cont_old .mq-math-mode .mq-textarea * {
    -webkit-user-select: text;
    user-select: text;
    position: absolute;
    clip: rect(1em 1em 1em 1em);
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    transform: scale(0);
    resize: none;
    width: 1px;
    height: 1px;
    box-sizing: content-box
}
.view_cont_old .mq-math-mode .mq-fraction {
    position: relative;
    top: .27em;
    padding-bottom: .27em
}
.view_cont_old .mq-math-mode .mq-fraction .mq-divider {
    display: block;
    width: 100%;
    height: 1px;
    margin: .2em 0;
    background-color: currentColor
}
.view_cont_old .mq-math-mode .mq-denominator, .view_cont_old .mq-math-mode .mq-numerator {
    position: relative;
    padding: .1em .2em 0;
    border: 0
}
.view_cont_old .mq-math-mode .mq-denominator > .mq-non-leaf {
    margin-top: .05em
}
.view_cont_old .mq-math-mode .mq-sqrt-prefix {
    top: 1px
}
.view_cont_old .mq-math-mode .mq-sqrt-stem {
    margin-top: 0;
    padding-left: .1em;
    padding-right: .1em;
    border-top: 1px solid currentColor
}
.view_cont_old .mq-math-mode .mq-sqrt-data {
    display: inline-block;
    margin-top: 2px;
    padding-left: .2em;
    padding-right: .22em
}
.view_cont_old .mq-math-mode .mq-sqrt-data.mq-empty:before, .view_cont_old .mq-math-mode .mq-sqrt-data.mq-hasCursor:before {
    top: 1px
}
.view_cont_old .mq-math-mode .mq-sqrt-data .mq-fraction {
    top: .15em
}
.view_cont_old .mq-math-mode sup.mq-nthroot {
    vertical-align: .9em
}
.view_cont_old .mq-math-mode .mq-int > .mq-supsub > .mq-sup > .mq-sup-inner {
    display: inline-block
}
.view_cont_old .mq-math-mode .mq-limit {
    text-align: center
}
.view_cont_old .mq-math-mode .mq-supsub.mq-sub-under {
    display: block;
    text-align: center;
    padding-right: 0;
    margin-top: -1.1em
}
.view_cont_old .mq-math-mode .mq-supsub.mq-sub-under > .mq-sub {
    float: none;
    display: inline-block;
    margin-left: 0;
    vertical-align: -1.1em
}
.view_cont_old .mq-math-mode .mq-arrow {
    position: relative;
    display: block;
    top: 0;
    margin: .3em 0;
    height: 1px;
    background-color: currentColor
}
.view_cont_old .mq-math-mode .mq-arrowhead {
    position: absolute;
    display: block;
    top: -9px;
    font-size: 17px
}
.view_cont_old .mq-math-mode .mq-arrowhead-left {
    left: -1px
}
.view_cont_old .mq-math-mode .mq-arrowhead-right {
    right: -1px
}
.view_cont_old .mq-math-mode .mq-arrowhead-left:after {
    content: "\2039"
}
.view_cont_old .mq-math-mode .mq-arrowhead-right:after {
    content: "\203A"
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-arrow, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-arrow, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-arrow, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-arrow {
    height: 2px;
    font-weight: 700
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-arrowhead, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-arrowhead {
    top: -12px;
    font-size: 23px
}
.se-viewer [style*="font-size: 34"] .mq-math-mode .mq-arrowhead, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-arrowhead {
    top: -14px;
    font-size: 25px
}
.view_cont_old .mq-math-mode .mq-arrow-double {
    position: relative;
    display: block;
    height: 3px;
    margin: .3em 0;
    border-top: 1px solid;
    border-bottom: 1px solid
}
.view_cont_old .mq-math-mode .mq-arrow-double .mq-arrowhead {
    top: -10px;
    font-size: 19px
}
.view_cont_old .mq-math-mode .mq-arrow-double .mq-arrowhead-left {
    left: -2px
}
.view_cont_old .mq-math-mode .mq-arrow-double .mq-arrowhead-right {
    right: -2px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-arrow-double, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-arrow-double, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-arrow-double, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-arrow-double {
    height: 5px;
    border-top-width: 2px;
    border-bottom-width: 2px;
    font-weight: 700
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-arrow-double .mq-arrowhead-left, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-arrow-double .mq-arrowhead-left, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-arrow-double .mq-arrowhead-left, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-arrow-double .mq-arrowhead-left {
    left: -4px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-arrow-double .mq-arrowhead-right, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-arrow-double .mq-arrowhead-right, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-arrow-double .mq-arrowhead-right, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-arrow-double .mq-arrowhead-right {
    right: -4px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-arrow-double .mq-arrowhead, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-arrow-double .mq-arrowhead {
    top: -15px;
    font-size: 27px
}
.se-viewer [style*="font-size: 34"] .mq-math-mode .mq-arrow-double .mq-arrowhead, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-arrow-double .mq-arrowhead {
    top: -17px;
    font-size: 30px
}
.view_cont_old .mq-math-mode .mq-harpoonup {
    position: absolute;
    display: block;
    top: -3px
}
.view_cont_old .mq-math-mode .mq-harpoonup:after {
    content: "";
    position: absolute;
    display: block;
    width: 4px;
    height: 4px
}
.view_cont_old .mq-math-mode .mq-harpoonup-left {
    left: 1px
}
.view_cont_old .mq-math-mode .mq-harpoonup-right {
    right: 1px
}
.view_cont_old .mq-math-mode .mq-harpoonup-left:after {
    border-left: 1px solid;
    left: 0;
    -ms-transform: skew(-45deg);
    -webkit-transform: skew(-45deg);
    transform: skew(-45deg)
}
.view_cont_old .mq-math-mode .mq-harpoonup-right:after {
    right: 0;
    border-right: 1px solid;
    -ms-transform: skew(45deg);
    -webkit-transform: skew(45deg);
    transform: skew(45deg)
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-harpoonup:after, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-harpoonup:after {
    top: -1px;
    width: 6px;
    height: 6px
}
.se-viewer [style*="font-size: 34"] .mq-math-mode .mq-harpoonup:after, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-harpoonup:after {
    top: -3px;
    width: 8px;
    height: 8px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-harpoonup-left:after, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-harpoonup-left:after, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-harpoonup-left:after, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-harpoonup-left:after {
    border-left: 2px solid #000
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-harpoonup-right:after, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-harpoonup-right:after, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-harpoonup-right:after, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-harpoonup-right:after {
    border-right: 2px solid #000
}
.view_cont_old .mq-math-mode .mq-diacritic {
    text-align: center
}
.view_cont_old .mq-math-mode .mq-diacritic-mark {
    display: block;
    text-align: center;
    height: .3em;
    line-height: inherit
}
.view_cont_old .mq-math-mode .mq-diacritic-overset, .view_cont_old .mq-math-mode .mq-diacritic-underset {
    display: inline-block;
    width: 100%;
    padding-left: .2em;
    padding-right: .2em
}
.view_cont_old .mq-math-mode .mq-diacritic-overset {
    margin-bottom: .1em
}
.view_cont_old .mq-math-mode .mq-dot-triple {
    margin-left: -.1em;
    letter-spacing: -.1em
}
.view_cont_old .mq-math-mode .mq-hat {
    -webkit-transform: scaleX(1.5);
    -ms-transform: scaleX(1.5);
    transform: scaleX(1.5)
}
.view_cont_old .mq-math-mode .mq-check {
    -webkit-transform: scaleX(1.5) scaleY(-1);
    -ms-transform: scaleX(1.5) scaleY(-1);
    transform: scaleX(1.5) scaleY(-1)
}
.view_cont_old .mq-math-mode .mq-tilde {
    line-height: .3em
}
.view_cont_old .mq-math-mode .mq-overline-double {
    position: relative;
    border-top: 1px solid;
    border-bottom: 1px solid;
    margin-bottom: .1em;
    height: 4px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-overline-double, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-overline-double, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-overline-double, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-overline-double {
    height: 5px
}
.view_cont_old .mq-math-mode .mq-overbrace, .view_cont_old .mq-math-mode .mq-underbrace {
    position: relative;
    height: 2px;
    background-color: transparent;
    font-size: 16px;
    border: 0;
    color: transparent
}
.view_cont_old .mq-math-mode .mq-overbrace {
    margin: .3em 0;
    border-radius: .2em .2em 0 0
}
.view_cont_old .mq-math-mode .mq-brace {
    position: absolute;
    background-repeat: no-repeat
}
.view_cont_old .mq-math-mode .mq-brace-left, .view_cont_old .mq-math-mode .mq-brace-right {
    width: 50%;
    border: 0;
    color: transparent
}
.view_cont_old .mq-math-mode .mq-brace-left {
    left: 0
}
.view_cont_old .mq-math-mode .mq-brace-right {
    right: 0
}
.view_cont_old .mq-math-mode .mq-brace-middle {
    top: -4px;
    left: 50%;
    width: 8px;
    height: 6px;
    margin-left: -4px;
    background-size: 8px 6px
}
.view_cont_old .mq-math-mode .mq-brace-extender {
    position: absolute;
    border-top: 2px solid #000
}
.view_cont_old .mq-math-mode .mq-brace-left .mq-brace-extender {
    left: 2px;
    right: 3px
}
.view_cont_old .mq-math-mode .mq-brace-right .mq-brace-extender {
    left: 3px;
    right: 2px
}
.view_cont_old .mq-math-mode .mq-brace-end {
    position: absolute;
    width: 3px;
    height: 5px;
    background-size: 3px 5px;
    border: 0;
    color: transparent
}
.view_cont_old .mq-math-mode .mq-brace-left .mq-brace-end {
    left: 0
}
.view_cont_old .mq-math-mode .mq-brace-right .mq-brace-end {
    right: 0
}
.view_cont_old .mq-math-mode .mq-overbrace .mq-brace-left .mq-brace-end {
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAYAAAAJCAYAAAARml2dAAAACXBIWXMAAAsSAAALEgHS3X78AAAASklEQVQI123MUQ2AQAwE0ReUIQEJ5wgJWMABEpCABCSUnwMuTSfZNJnNlp+GE9EDtkF8RStkSPMDC2aDXCUCV5ZTv7uCeH9m7ko+wvIYi5T5J40AAAAASUVORK5CYII=")
}
.view_cont_old .mq-math-mode .mq-overbrace .mq-brace-middle {
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAMCAYAAABr5z2BAAAACXBIWXMAAAsSAAALEgHS3X78AAAAnklEQVQoz5WRaxGDQAyEv9QAOKgFJFAHOMACEpBwEloltVAJ1EEdLH8Cc0BzpZnZSeZmd/M4k0QUZpYAJA0h54fBxw3qiHMpiBugAiqv/zMAuqDehqSvACZAjinkBeKUiRekUwbAmHfeTTLu+QY0QO15AK7Zhg/Pffb29glfAObOUdw8Pwucw66HnYObLCiLT5hsDnYH2sLXts5ZDzsD7hfCJP6bO74AAAAASUVORK5CYII=")
}
.view_cont_old .mq-math-mode .mq-overbrace .mq-brace-right .mq-brace-end {
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAYAAAAJCAYAAAFmnW0LAAAACXBIWXMAAAsSAAALEgHS3X78AAAAVElEQVQI12NgYGD4z4ACBGCM/wwMDAznERKMmGohoJ8ZKvOQgYHhAgtUdD6ykvnoev8zIXE+wKxDxnD9DgwMDAEMDAz7kSTPY3PHfVwODGBgYPgPAOMUFzbi49ypAAAAAElFTkSuQmCC")
}
.view_cont_old .mq-math-mode .mq-underbrace {
    margin: .3em 0;
    font-size: 15px
}
.view_cont_old .mq-math-mode .mq-underbrace .mq-brace-left, .view_cont_old .mq-math-mode .mq-underbrace .mq-brace-right {
    top: -3px
}
.view_cont_old .mq-math-mode .mq-underbrace .mq-brace-extender {
    top: 3px
}
.view_cont_old .mq-math-mode .mq-underbrace .mq-brace-left .mq-brace-end {
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAYAAAAJCAYAAAARml2dAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAACXBIWXMAAAsTAAALEwEAmpwYAAABWWlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS40LjAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyI+CiAgICAgICAgIDx0aWZmOk9yaWVudGF0aW9uPjE8L3RpZmY6T3JpZW50YXRpb24+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgpMwidZAAAAS0lEQVQIHWNgYGB4D8RYwX+gqAO6DBNUwB9dAsQH6biPSwIk2Y8ueR4oAJIA4f1AHADEDkDMkADEMAlkGiTHMB+LJFgCRCQAMdxYAIjZGCpmaXHSAAAAAElFTkSuQmCC")
}
.view_cont_old .mq-math-mode .mq-underbrace .mq-brace-middle {
    top: 0;
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAMCAYAAABr5z2BAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAACXBIWXMAAAsTAAALEwEAmpwYAAABWWlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS40LjAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyI+CiAgICAgICAgIDx0aWZmOk9yaWVudGF0aW9uPjE8L3RpZmY6T3JpZW50YXRpb24+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgpMwidZAAAAp0lEQVQoFZ2RAQ3CMBBFC5kAHGBhOBhOkICESUBCncwCEoqDORjvQj85mrYBfvJyv/96bZeFEMKWSdQIE7Q00YiQQHNvo8DqDUpZ5vfIV8PykNbwtsunlrdpfc5mUVDWgeAEBxjhCkeQLjKuPvD2orvLPuzMSt+X8IbWM/4r2Q0aUrXsJyV2a9h8Vftq+gqj63nv4r4daesF5v/SypTRlP3GnmKvab0n2bM7Bpjqe/4AAAAASUVORK5CYII=")
}
.view_cont_old .mq-math-mode .mq-underbrace .mq-brace-right .mq-brace-end {
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAYAAAAJCAYAAAFmnW0LAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAVlpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IlhNUCBDb3JlIDUuNC4wIj4KICAgPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICAgICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIKICAgICAgICAgICAgeG1sbnM6dGlmZj0iaHR0cDovL25zLmFkb2JlLmNvbS90aWZmLzEuMC8iPgogICAgICAgICA8dGlmZjpPcmllbnRhdGlvbj4xPC90aWZmOk9yaWVudGF0aW9uPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KTMInWQAAAFdJREFUCB1jYICC/yBaAMYD02AhhMh5BJOBoZ8RyENTAJF/j6zsPxOUNx8mCtIDwgkgATgDxEEHAUABkAIMcB8oApZwADJAqvZDBUCCYFeCGMh4PpDPAAAWTRadAIyJowAAAABJRU5ErkJggg==")
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-brace-extender, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-brace-extender, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-brace-extender, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-brace-extender {
    border-top-width: 3px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-overbrace, .se-viewer [style*="font-size: 28"] .mq-math-mode .mq-underbrace, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-overbrace, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-underbrace, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-overbrace, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-underbrace, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-overbrace, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-underbrace {
    font-size: 33px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-underbrace .mq-brace, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-underbrace .mq-brace, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-underbrace .mq-brace, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-underbrace .mq-brace {
    top: -8px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-overbrace .mq-brace-left .mq-brace-end, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-overbrace .mq-brace-left .mq-brace-end, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-overbrace .mq-brace-left .mq-brace-end, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-overbrace .mq-brace-left .mq-brace-end {
    width: 5px;
    height: 8px;
    left: -1px;
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAeCAYAAAG012XDAAAACXBIWXMAAAsSAAALEgHS3X78AAABK0lEQVRIx62UfXEDIRDFfzAngDqoBCSkDiLh6iASEgWtg0wUXKsgEhoHrYOTQP+BlpDl2ITbmZtjlsdjPx4L/xZMWiTPmXw7LRLMA87Gna8bGMCmPFMiXgBcdF4dpeak5iztKOYEYIFdjTcAU+mcmxFYic8CP5pY99nl+bcZMtAca1U10yjPBTjF/0W6dlxiz4GulVACnjXZB21Ll2wXbxPJXCyfVOM/GyuAK6BvgILRanRoFPwd+JSKX23CsKCJRbE+aboza9u4XaXfVtv4BPzQSm01c/EJfbc0kY9CybySREU6PkBUnTnE2e57a3XXILvXJmVqM/AGPLcItwqycc0op0dTr8lm31NPifDYQ2gqT8/0kEoT4tArJSlS00taRvq6lvBDVIBfi/AXR46rZxtobVwAAAAASUVORK5CYII=");
    background-size: 5px 8px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-overbrace .mq-brace-right .mq-brace-end, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-overbrace .mq-brace-right .mq-brace-end, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-overbrace .mq-brace-right .mq-brace-end, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-overbrace .mq-brace-right .mq-brace-end {
    width: 5px;
    height: 8px;
    right: -1px;
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAeCAYAAAFbFQ79AAAACXBIWXMAAAsSAAALEgHS3X78AAABEUlEQVRIx62Uu3HDMBBEH6gGUAJLYOiQJTB0qBJUAjtQCRpXoBJsZ85Ygt2B7AqgBKcB4QN0lLAzF5DY2dv7AACBCJd+pAhd/mep8vUjl374SNDzqZq7ePIHfOV0iX0xu9MSOEvm3t4XzVIa3kqUmKTyT+AN+AVelIyvgHeUsaqgqxAd8FNqUFF5ZyB68S7VnYHhnnQeJ8uyqYvXWQqxEEltjHHtlsoYVRwVYrEbY0Y817ytrLiWVWOZtS/sqEo0ebz5tHj8sF6u7ziE3lp42BgXucGtBP89dS0FxbFvKShxt8c9MEcHwTi8TZgM4gcewFwRXHgQ49bXxIJDa0EK795TmFoLai6fxtBaUB7EdyBcAZznzn8oH+GxAAAAAElFTkSuQmCC");
    background-size: 5px 8px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-overbrace .mq-brace-middle, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-overbrace .mq-brace-middle, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-overbrace .mq-brace-middle, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-overbrace .mq-brace-middle {
    width: 10px;
    height: 8px;
    top: -5px;
    margin-left: -6px;
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAeCAYAAAEp2mxLAAAACXBIWXMAAAsSAAALEgHS3X78AAAB/klEQVRYw8VYbXHDMAx9GoKMQYZgZbBAKIQwWCEMQsvAEAohY5AiaIZgZaD9qJyprh3LSdbpTlfHVp71bafEzAjpyQ+IqB1nmRkizdfH65v6oQXAWtL5MXlxImJmphFTIHZeOsRkAEwxPW+gQt21kP4d5wX6hpiZQkGN+MXM5LfUYwCI6hijqI5E1NzNh4het0mriWiT3FvFpvLO1Q5X67eLAOrIHN/50es25ccXbYCMD3c6TjGALtQ5KWsE9DZ1OdlspEPbxeTBnBETYCf5PRORy8ZZxbqLhG8ITNfc5vIh5MtUckU4DxQJ0jb5njHKziJXmjbdKoAAmlgxLgHs1gZMpkhxpRBRDeAc6x6zKiUEy3bDqW4DwClT+1SnNPkwAPMHXpjEVRZwPGQjvRvAEFnrQmBLLXvA2iJrAazU7pelgG0mL4sAtxMZcCkB3BsbRh0NlLUtGTbQqbVbC9d8vclReDjmSt5KTysp92GZm4W91INEVAH4Tiw/M/Plvz14nLlmo4WF4Qx9wi3aY4FyvbHVMoD+YQpmvHYUXs2bVqWaxGkX8kY4JzcAaEx9UDb3VAs3AN4K0/nAzDup7D2A98L3P+V4H4R/62QFdjMLaJXrQo63sz4RHqBgW1BY7aMUdKm7pVHRqjT0sX9XTpKknXwv9fhDkmt/I1wDeNXrP+TnOOfbwR9sAAAAAElFTkSuQmCC");
    background-size: 10px 8px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-underbrace .mq-brace-left .mq-brace-end, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-underbrace .mq-brace-left .mq-brace-end, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-underbrace .mq-brace-left .mq-brace-end, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-underbrace .mq-brace-left .mq-brace-end {
    width: 5px;
    height: 8px;
    top: -2px;
    left: -1px;
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAfCAYAAADnTu3OAAAA60lEQVRIia2V4Q2CMBCFP3CBjuAIbKAbyAiM4Ahs4AiMwAiOoBvIBo5Qf7RVBNq03L2kgQT48t71rhyAHqcJJVm/Om3gGzBSWD27N0CrCQS4SIHwixxiqwIt0Ehgy8gAZ23gSQKEdWRxHZdAi6B9tiKDsH22HFp2Tk3MIcB1DxDcJsRc7urJewL4oDB6DTwTzxvgVuqwTTicOz3mAk0GMDR8T2YJxkxoAA8+2Qpe+WvnX9qjicj/6FXgMrW+ytmcIiCU1TILaHAtogbUgG5KAk2q1waCG7lBExhkcAMwkjjyqtjXGWq8+78z8wN8bNQzTcMF/wAAAABJRU5ErkJggg==");
    background-size: 5px 8px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-underbrace .mq-brace-right .mq-brace-end, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-underbrace .mq-brace-right .mq-brace-end, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-underbrace .mq-brace-right .mq-brace-end, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-underbrace .mq-brace-right .mq-brace-end {
    width: 5px;
    height: 8px;
    top: -2px;
    right: -1px;
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAfCAYAAADnTu3OAAAA4UlEQVRIia2Uaw2DMBSFvy38Xx1sDjYJSKgEJEzC5mASkIAEJFTCJOCA/YAu5KYPSu9JTkJL8uXcR3pCT+1qFXXAvLpaBpg88KwAtMDFH7SAqvqXi0IPHwJW3cNWXqgDayX7V9VDG4BV9VB1XQyBdFQkfCoFAwK7t/FUCjOASwDH0pI/wD3x3+0F3TLJvLOTN8CL8AKHbGIQC/QFoBkYABpgFKVdc7EjGvzH3gQpf7dkDaDVBA4I1cAcgcmqwo4Co7AjwFcMVArsWfY0qxhgYplglypPqgHe4s6xLOrul2OrH3PI1N27wseKAAAAAElFTkSuQmCC");
    background-size: 5px 8px
}
.se-viewer [style*="font-size: 28"] .mq-math-mode .mq-underbrace .mq-brace-middle, .se-viewer [style*="font-size: 30"] .mq-math-mode .mq-underbrace .mq-brace-middle, .se-viewer [style*="font-size: 34"] .mq-math-mode .mq-underbrace .mq-brace-middle, .se-viewer [style*="font-size: 38"] .mq-math-mode .mq-underbrace .mq-brace-middle {
    width: 10px;
    height: 8px;
    top: -5px;
    margin-left: -6px;
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAeCAYAAAEp2mxLAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAACXBIWXMAAAsTAAALEwEAmpwYAAABWWlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS40LjAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyI+CiAgICAgICAgIDx0aWZmOk9yaWVudGF0aW9uPjE8L3RpZmY6T3JpZW50YXRpb24+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgpMwidZAAACHUlEQVRYCc1TDXmDMBBlU4AEJCABCZWABCR0DiYhEiohEpCAhDnY3mO9fI80AUK7tfd917vc+8kV2qqqqm+kRvuGUzxUwgyuEqpxwYedemofeMHvPYykSUk4swhqG1glwGyvNUukwF9J7Dcj6cThsCK9AJuF/LDsRWAzq4EUBiA7pJ2tBo8pAXYBjRq+pxuHiBOOSWLydUHyEWQrTfZR2VVxrVfMCDlkrOE5OVTiiSQJxVJ91YHMPCNTBM4+kYwc7oH1yA6ZDQdEDS7ROSvcAtSUvdsSbOF8OWq6xd+Fm2ERmc+o3aVYkgYcR2S41Bqtbqm5OdVioDr2wTkGZvDG6vfnkeLabNUwNj1tLDDzzTlXnWyZ4+h8/nX3EHmkAtoDmv8tOtP+DLy7JsoyOhyVzL5NzCbMikJNL1Dq2RU5CVlNrB8FL24dFGZktdgkFpgRq4/BI2c1rI8YxJozBmYaY4fPf2I47F3Hbs/VCUafyAb5qGhgRM8JmbvX5psEI1r9gukJWRrUUGs+e2uxQI37HVuSo5rS/i4xL+NTqZFxcHbkicVf4O4FzbCRDdnb/N4qtsuWT6BHeuSeSybwLCY0ezQevB6ZegMYlwVNHHLt4gE4c41Dj4csBJ9sOCCpJUbMmSmMmn+NFrelFknNyH1KNLg1tZDOyHlq9LhdF9Ke2EuExxa6GHvOXiY6bBIvyNlLhcc2tiT7lwyHrZgPix9HwNE5Puh92wAAAABJRU5ErkJggg==");
    background-size: 10px 8px
}
.view_cont_old .mq-math-mode .mq-overarrow {
    min-width: auto;
    border: 0;
    margin: 0;
    padding: 0;
    text-align: inherit;
    position: relative;
    margin: .15em 0 0;
    padding: .2em .2em 0;
    font-size: 90%
}
.view_cont_old .mq-math-mode .mq-overarrow:before {
    display: none
}
.view_cont_old .mq-math-mode .mq-overarrow .mq-arrow + span {
    padding: .05em .25em
}
.view_cont_old .mq-math-mode .mq-overline {
    margin-bottom: .1em
}
.view_cont_old .mq-math-mode .mq-overline, .view_cont_old .mq-math-mode .mq-underline {
    height: 1px;
    border-color: currentColor
}
.view_cont_old .mq-math-mode .mq-boxed {
    padding: .1em;
    border: 1px double
}
.view_cont_old .mq-math-mode .mq-boxed-inner {
    display: inline-block;
    padding: .03em .2em
}
.view_cont_old .mq-math-mode .mq-xarrow {
    position: relative;
    padding: 0 .2em;
    text-align: center;
    vertical-align: -.4em
}
.view_cont_old .mq-math-mode .mq-xarrow-overset, .view_cont_old .mq-math-mode .mq-xarrow-underset {
    display: inline-block;
    width: 100%;
    font-size: 90%;
    padding: .05em .25em
}
.view_cont_old .mq-math-mode table {
    font-family: Symbola, Times New Roman, serif;
    font-size: 1em;
    color: currentColor
}
.view_cont_old .mq-math-mode .mq-matrix {
    vertical-align: middle;
    margin-left: .1em;
    margin-right: .1em
}
.view_cont_old .mq-math-mode .mq-matrix table {
    width: auto;
    border-bottom: none;
    border-spacing: 3px;
    border-collapse: separate
}
.view_cont_old .mq-math-mode .mq-matrix table.mq-rows-1 {
    vertical-align: middle;
    margin-bottom: 1px
}
.view_cont_old .mq-math-mode .mq-matrix td {
    border: none;
    width: auto;
    padding: .1em .3em;
    vertical-align: baseline
}
.view_cont_old .mq-math-mode .mq-grid {
    vertical-align: middle;
    margin-left: .1em;
    margin-right: .1em
}
.view_cont_old .mq-math-mode .mq-grid table {
    width: auto;
    border: 0;
    border-bottom: none;
    border-collapse: collapse
}
.view_cont_old .mq-math-mode .mq-grid td {
    border: none;
    width: auto;
    height: 100%;
    vertical-align: middle;
    text-align: center
}
.view_cont_old .mq-math-mode .mq-grid .mq-grid-border-top {
    border-top: 1px solid
}
.view_cont_old .mq-math-mode .mq-grid .mq-grid-border-left {
    border-left: 1px solid
}
.view_cont_old .mq-math-mode .mq-grid .mq-grid-border-bottom {
    border-bottom: 1px solid
}
.view_cont_old .mq-math-mode .mq-grid .mq-grid-border-right {
    border-right: 1px solid
}
.view_cont_old .mq-grid-cell-inner {
    box-sizing: border-box;
    position: relative;
    display: block;
    height: 100%;
    padding: 5px
}
.view_cont_old .mq-math-mode .mq-grid-box {
    display: block;
    padding: .058em .32em
}
.view_cont_old .mq-math-mode .mq-grid-box .mq-binary-operator {
    margin: 0 -.19em;
    padding: 0
}
.view_cont_old .mq-right-triangle {
    padding-right: .2em;
    font-size: 80%
}
.view_cont_old .mq-mu {
    display: inline-block
}
.view_cont_old .mq-mu-3 {
    width: .15em
}
.view_cont_old .mq-mu--3 {
    margin: 0 -.0745em
}
.view_cont_old .mq-mu-4 {
    width: .2em
}
.view_cont_old .mq-mu-5 {
    width: .25em
}
.view_cont_old .mq-mu-18 {
    width: 1em
}
.view_cont_old .mq-mu-36 {
    width: 2em
}
.view_cont_old .mq-mu-space:after {
    content: "\A0"
}
.view_cont_old .mq-math-mode .mq-combi > .mq-empty, .view_cont_old .mq-math-mode .mq-combi > .mq-hasCursor {
    display: inline-block;
    margin: 0 .05em
}
.view_cont_old .mq-math-mode .mq-italic .mq-normal, .view_cont_old .mq-math-mode .mq-italic .mq-normal i, .view_cont_old .mq-math-mode .mq-italic .mq-normal i.mq-font, .view_cont_old .mq-math-mode .mq-italic .mq-normal var, .view_cont_old .mq-math-mode .mq-normal, .view_cont_old .mq-math-mode .mq-normal i, .view_cont_old .mq-math-mode .mq-normal i.mq-font, .view_cont_old .mq-math-mode .mq-normal var {
    font-style: normal
}
.view_cont_old .mq-math-mode .mq-italic, .view_cont_old .mq-math-mode .mq-italic i, .view_cont_old .mq-math-mode .mq-italic i.mq-font, .view_cont_old .mq-math-mode .mq-italic var {
    font-style: italic
}
.view_cont_old .mq-align-equal {
    white-space: nowrap;
    position: relative
}
.view_cont_old .mq-math-mode .mq-textcolor {
    display: inline-block
}
.view_cont_old .mq-math-mode .mq-textcolor .mq-fraction .mq-divider {
    background-color: currentColor
}
.view_cont_old .mq-editable-field .mq-selection, .view_cont_old .mq-editable-field .mq-selection.mq-blur, .view_cont_old .mq-editable-field .mq-selection.mq-blur .mq-matrixed, .view_cont_old .mq-editable-field .mq-selection.mq-blur .mq-non-leaf, .view_cont_old .mq-editable-field .mq-selection.mq-blur .mq-scaled, .view_cont_old .mq-editable-field .mq-selection .mq-non-leaf, .view_cont_old .mq-editable-field .mq-selection .mq-scaled, .view_cont_old .mq-math-mode .mq-selection, .view_cont_old .mq-math-mode .mq-selection.mq-blur, .view_cont_old .mq-math-mode .mq-selection.mq-blur .mq-matrixed, .view_cont_old .mq-math-mode .mq-selection.mq-blur .mq-non-leaf, .view_cont_old .mq-math-mode .mq-selection.mq-blur .mq-scaled, .view_cont_old .mq-math-mode .mq-selection .mq-non-leaf, .view_cont_old .mq-math-mode .mq-selection .mq-scaled {
    color: currentColor;
    border-color: currentColor
}
.view_cont_old .mq-math-mode .mq-paren {
    padding-top: .05em
}
.view_cont_old .mq-math-mode .mq-paren + span {
    margin-top: .05em
}
.view_cont_old .mq-math-mode .mq-matrix .mq-paren {
    padding-top: .03em
}
.se-viewer [style*="font-size: 11"] .mq-math-mode .mq-paren + span, .se-viewer [style*="font-size: 13"] .mq-math-mode .mq-paren + span {
    margin-top: .15em
}
.se-viewer [style*="font-size: 11"] .mq-math-mode .mq-matrix .mq-paren, .se-viewer [style*="font-size: 13"] .mq-math-mode .mq-matrix .mq-paren {
    padding-top: .04em
}
.se-viewer [data-useragent*=Trident] [style*="font-size: 38"] .mq-math-mode .mq-arrowhead {
    top: -13px
}
.se-viewer [data-useragent*=Trident] [style*="font-size: 38"] .mq-math-mode .mq-arrow-double .mq-arrowhead {
    top: -16px
}
.view_cont_old .se-formula {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-formula, .view_cont_old .se-sticker + .se-formula {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-formula {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-section-formula {
    display: table
}
.view_cont_old .se-section-formula .mq-math-mode .mq-supsub.mq-sub-under {
    margin-top: 0
}
.view_cont_old .se-section-formula .mq-math-mode .mq-int > .mq-supsub > .mq-sup > .mq-sup-inner {
    vertical-align: baseline
}
.view_cont_old .se-section-formula .mq-math-mode .mq-int > .mq-supsub > .mq-sup {
    padding-bottom: 1.3em
}
.view_cont_old .se-section-formula .mq-math-mode .mq-int > .mq-supsub > .mq-sup > .mq-sup-inner > .mq-non-leaf {
    margin-bottom: -1.3em
}
.view_cont_old .se-section-formula .mq-math-mode .mq-int > .mq-supsub > .mq-sup > .mq-sup-inner > .mq-matrix {
    margin-bottom: 0
}
.view_cont_old .se-section-formula .lama-viewer {
    display: table !important
}
.view_cont_old .se-section-formula .se-module-formula {
    overflow: auto
}
.view_cont_old .se-talktalk {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-talktalk, .view_cont_old .se-sticker + .se-talktalk {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-talktalk {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-talktalk.se-l-default .se-section-talktalk {
    max-width: 450px
}
.view_cont_old .se-talktalk.se-l-default .se-module-talktalk {
    position: relative;
    display: block;
    height: 54px;
    width: 100%;
    box-sizing: border-box
}
.view_cont_old .se-talktalk.se-l-default .se-module-talktalk:after, .view_cont_old .se-talktalk.se-l-default .se-module-talktalk:before {
    content: "";
    position: absolute;
    top: 0
}
.view_cont_old .se-talktalk.se-l-default .se-module-talktalk:before {
    display: inline-block;
    width: 40px;
    height: 64px;
    background-position: -300px -58px;
    left: 0
}
.view_cont_old .se-talktalk.se-l-default .se-module-talktalk:after {
    display: inline-block;
    width: 5px;
    height: 54px;
    background-position: -284px -82px;
    right: 0
}
.view_cont_old .se-talktalk .se-section-align-center {
    text-align: center
}
.view_cont_old .se-talktalk .se-section-align-left {
    text-align: left
}
.view_cont_old .se-talktalk .se-section-align-right {
    text-align: right
}
.view_cont_old .se-talktalk .se-module-talktalk {
    display: inline-block
}
.view_cont_old .se-talktalk .se-talktalk-banner-text {
    position: absolute;
    top: 0;
    left: 40px;
    right: 5px;
    height: 54px;
    background-image: url(//editor-static.pstatic.net/v/blog//img/component-talktalk-banner-bg.12fce697.png);
    background-repeat: repeat-x
}
.view_cont_old .se-talktalk .se-talktalk-banner-text:before {
    display: inline-block;
    width: 237px;
    height: 22px;
    background-position: 0 -241px;
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    margin-left: -20px
}
.view_cont_old .se-talktalk .se-talktalk-custom-resource {
    max-width: 100%;
    width: 100%;
    vertical-align: top
}
.view_cont_old .se-mrBlog {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-mrBlog, .view_cont_old .se-sticker + .se-mrBlog {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-mrBlog {
    margin-top: 30px;
    margin-top: 40px
}
.view_cont_old .se-mrBlog-from {
    font-weight: 700
}
.view_cont_old .se-mrBlog-from, .view_cont_old .se-mrBlog-question {
    font-family: se-nanumgothic, \\B098\B214\ACE0\B515, nanumgothic, sans-serif, Meiryo;
    line-height: 1.8
}
.view_cont_old .se-anniversarySection {
    margin-top: 20px;
    margin-top: 30px
}
.view_cont_old .se-sectionTitle + .se-anniversarySection, .view_cont_old .se-sticker + .se-anniversarySection {
    margin-top: 20px
}
.view_cont_old .se-quotation + .se-anniversarySection {
    margin-top: 30px;
    margin-top: 40px
}
/*! anniversary */ .view_cont_old .se-section-anniversarySection {
    width: 100%;
    max-width: 480px;
    box-shadow: 0 2px 8px 0 rgba(0, 0, 0, .12)
}
.view_cont_old .se-section-anniversarySection:after {
    z-index: 1;
    position: absolute;
    right: 0;
    bottom: 0;
    left: 0;
    height: 0;
    border: 1px solid rgba(0, 0, 0, .1);
    border-bottom: 0
}
.view_cont_old .se-module-anniversarySection {
    display: block;
    position: relative;
    text-decoration: none
}
.view_cont_old .se-module-anniversarySection:before {
    left: 0;
    clear: both
}
.view_cont_old .se-module-anniversarySection:after, .view_cont_old .se-module-anniversarySection:before {
    z-index: 1;
    position: absolute;
    top: 0;
    bottom: 0;
    content: "";
    width: 0;
    border: 1px solid rgba(0, 0, 0, .1);
    border-right: 0
}
.view_cont_old .se-module-anniversarySection:after {
    right: 0
}
.view_cont_old .se-module-anniversarySection:hover {
    text-decoration: none
}
.view_cont_old .se-anniversary-info {
    padding: 17px 14px 19px;
    background-color: #f9f9f9;
    text-align: left
}
.view_cont_old .se-anniversary-info:after {
    content: "";
    position: absolute;
    bottom: 0;
    right: 0;
    left: 0;
    border: solid rgba(0, 0, 0, .1);
    border-width: 0 0 1px
}
.view_cont_old .se-anniversary-info {
    padding: 21px 20px 20px
}
.view_cont_old .se-anniversary-title {
    display: block;
    font-size: 14px;
    font-weight: 700;
    color: #444;
    font-size: 15px;
    font-weight: 400
}
.view_cont_old .se-anniversary-summary, .view_cont_old .se-anniversary-title {
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all
}
.view_cont_old .se-anniversary-summary {
    font-size: 13px;
    margin-top: 6px;
    color: #666;
    margin-top: 10px
}
.view_cont_old .se-anniversary-blog {
    white-space: nowrap;
    word-wrap: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-all;
    margin-top: 6px;
    font-size: 12px;
    color: #6e93b0;
    margin-top: 10px
}
.view_cont_old .se-anniversary-date-info {
    position: relative;
    height: 30px;
    padding: 12px 14px 0;
    font-size: 14px;
    line-height: 18px;
    color: #fff;
    text-align: left;
    padding: 12px 21px 0
}
.view_cont_old .se-anniversary-date-info:after {
    content: "";
    position: absolute;
    bottom: 0;
    right: 0
}
.view_cont_old .se-anniversary-date-info .se-anniversary-date, .view_cont_old .se-anniversary-date-info .se-anniversary-date-text {
    font-style: normal
}
.view_cont_old .se-l-anniversary_spring .se-anniversary-date-info {
    margin-top: 25px;
    background-color: #d9ab9e
}
.view_cont_old .se-l-anniversary_spring .se-anniversary-date-info:after {
    display: inline-block;
    width: 102px;
    height: 67px;
    background-position: 0 -172px
}
.view_cont_old .se-l-anniversary_summer .se-anniversary-date-info {
    margin-top: 15px;
    background-color: #64bbe2
}
.view_cont_old .se-l-anniversary_summer .se-anniversary-date-info:after {
    display: inline-block;
    width: 90px;
    height: 56px;
    background-position: -300px 0
}
.view_cont_old .se-l-anniversary_autumn .se-anniversary-date-info {
    margin-top: 38px;
    background-color: #907b6c
}
.view_cont_old .se-l-anniversary_autumn .se-anniversary-date-info:after {
    display: inline-block;
    width: 110px;
    height: 80px;
    background-position: 0 0
}
.view_cont_old .se-l-anniversary_winter .se-anniversary-date-info {
    margin-top: 38px;
    background-color: #99a2c1
}
.view_cont_old .se-l-anniversary_winter .se-anniversary-date-info:after {
    display: inline-block;
    width: 102px;
    height: 75px;
    background-position: -180px -82px
}
.view_cont_old .se-anniversary-thumbnail {
    overflow: hidden;
    position: relative
}
.view_cont_old .se-anniversary-thumbnail:after {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    content: "";
    border: 1px solid rgba(0, 0, 0, .1);
    height: 0;
    border-bottom: 0
}
.view_cont_old .se-anniversary-thumbnail .se-anniversary-thumbnail-resource {
    display: block;
    width: 100%
}
.view_cont_old .se-anniversary-thumbnail ~ .se-anniversary-date-info {
    margin-top: 0
}
.view_cont_old .se_component.se_video .se_viewArea {
    position: relative;
    z-index: 1
}

.view_step {padding:35px 0 10px;}
.view_step_cont {padding:6px 0 60px 96px; width:850px; font-size:22px;}
.view_step_cont.step1 {background:url(//recipe1.ezmember.co.kr/img/icon_step_1.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step2 {background:url(//recipe1.ezmember.co.kr/img/icon_step_2.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step3 {background:url(//recipe1.ezmember.co.kr/img/icon_step_3.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step4 {background:url(//recipe1.ezmember.co.kr/img/icon_step_4.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step5 {background:url(//recipe1.ezmember.co.kr/img/icon_step_5.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step6 {background:url(//recipe1.ezmember.co.kr/img/icon_step_6.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step7 {background:url(//recipe1.ezmember.co.kr/img/icon_step_7.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step8 {background:url(//recipe1.ezmember.co.kr/img/icon_step_8.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step9 {background:url(//recipe1.ezmember.co.kr/img/icon_step_9.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step10 {background:url(//recipe1.ezmember.co.kr/img/icon_step_10.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step11 {background:url(//recipe1.ezmember.co.kr/img/icon_step_11.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step12 {background:url(//recipe1.ezmember.co.kr/img/icon_step_12.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step13 {background:url(//recipe1.ezmember.co.kr/img/icon_step_13.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step14 {background:url(//recipe1.ezmember.co.kr/img/icon_step_14.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step15 {background:url(//recipe1.ezmember.co.kr/img/icon_step_15.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step16 {background:url(//recipe1.ezmember.co.kr/img/icon_step_16.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step17 {background:url(//recipe1.ezmember.co.kr/img/icon_step_17.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step18 {background:url(//recipe1.ezmember.co.kr/img/icon_step_18.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step19 {background:url(//recipe1.ezmember.co.kr/img/icon_step_19.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step20 {background:url(//recipe1.ezmember.co.kr/img/icon_step_20.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step21 {background:url(//recipe1.ezmember.co.kr/img/icon_step_21.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step22 {background:url(//recipe1.ezmember.co.kr/img/icon_step_22.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step23 {background:url(//recipe1.ezmember.co.kr/img/icon_step_23.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step24 {background:url(//recipe1.ezmember.co.kr/img/icon_step_24.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step25 {background:url(//recipe1.ezmember.co.kr/img/icon_step_25.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step26 {background:url(//recipe1.ezmember.co.kr/img/icon_step_26.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step27 {background:url(//recipe1.ezmember.co.kr/img/icon_step_27.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step28 {background:url(//recipe1.ezmember.co.kr/img/icon_step_28.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step29 {background:url(//recipe1.ezmember.co.kr/img/icon_step_29.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont.step30 {background:url(//recipe1.ezmember.co.kr/img/icon_step_30.gif) no-repeat 48px 6px; background-size:36px;}
.view_step_cont img {border-radius:10px; max-width:100%; height:auto; margin:20px 0 10px;}
.view_step_cont .media-right {padding-left:20px;}
.view_step_cont .media-right img {margin:0;}
.view_step .view_step_cont .media-right img {max-width:300px;}
.view_step_tip {padding-bottom:40px;}
.view_step_tip dd {font-size:20px; padding:20px 32px 0;}
.view_step_tip.st2 {padding:30px 0 40px 0; clear:both; margin-left:-21px;}
.view_step_tip.st2 dd {padding:14px 28px 0; font-size:16px; line-height:1.6;}
.view_step .carousel .carouItem img {max-width:100%;}

.view_btn {margin:0 40px; border-top:1px solid #e6e7e8; padding-top:13px;}
.view_btn.st2 {margin:0 40px 15px; border-top:none;; padding-top:20px;}
.view_btn a {margin:0 3px;}
.view_btn_r {float:right;}
.view_copyshot {padding:30px 20px 45px;}
.view_copyshot .copyshot_tit {font-size:24px; padding:0 20px 15px;}
.view_copyshot .copyshot_btn {float:right;}
.view_copyshot .copyshot_btn a {margin-left:7px;}
.view_copyshot .copyshot_list {}
.view_copyshot .thumbnail {width:180px; height:260px; padding:0; border:1px solid #fff; background:#f1f1f2; display:inline-block; border-radius:0; margin:0 15px;}
.view_copyshot .thumbnail img {width:180px; height:180px;}
.view_copyshot .copyshot_thumb {width:180px; height:260px; position:relative; padding:0; display:inline-block; margin:0 30px 0 0;}
.view_copyshot .thumbnail_original {position:absolute; right:-6px; top:9px; border:2px solid #fff; -webkit-transition:border .2s ease-in-out; -o-transition:border .2s ease-in-out; transition:border .2s ease-in-out}
.view_copyshot .thumbnail_original img {width:54px; height:54px; }
.view_copyshot .thumbnail_original:focus, .view_copyshot .thumbnail_original:hover {border:2px solid #5ca920;}
.view_reply {padding:40px 50px 10px;}
.view_reply.st2 {padding:40px 50px 25px;}
.view_reply.st3 {padding:20px 0 0;}
.view_reply.st3 .media:first-child {margin-top:15px;}
.view_banner img {width:895px; height:150px;}
.reply_tit {font-size:24px; font-weight:bold; padding-bottom:15px; border-bottom:1px solid #e6e7e8; margin-bottom:10px;}
.reply_tit span {color:#74b243; font-weight: normal;}
.reply_tit.st2 {border: none; padding-bottom: 0; margin-bottom: 6px;}
.reply_list {border-bottom:1px solid #e6e7e8; padding-bottom:20px; padding-top:5px;}
.reply_list .media-left img {width:50px; height:50px;  border-radius:50%;}
.reply_list .media-heading {color:#999; font-size:14px; position:relative;}
.reply_list .media-heading b {font-size:17px; margin-right:10px; font-weight: normal;}
.reply_list .media-heading span {color:#ddd; margin:0 5px;}
.reply_list .media-heading a {color:#999;}
.reply_list .media-body {line-height:22px;}

.reply_list .info_more { float:right; position:relative;}
.reply_list .info_more .dropdown-menu {width:70px; min-width:70px; margin:-4px -5px 0 0; }
.reply_list .info_more .dropdown-menu li {font-size:13px; border-bottom:1px solid #ebebeb;}
.reply_list .info_more .dropdown-menu li:last-child {border-bottom:none;}
.reply_list .info_more .tmn_more {display:inline-block; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_more3.png) center top no-repeat; background-size:17px; margin:0; width:20px; height:20px;}


.reply_write { display:block; height:116px; margin-top:14px;}
.reply_write2 { display:block; margin-top:14px;}
.reply_write2_tt {font-size:14px; color:#000; padding:10px 0 12px 3px;}
.reply_write2_file {display:inline-block; color:#999; margin-left:24px;}
.reply_write2_file .btn {display:inline-block; border:1px solid #999; background:#ebebeb; font-size:13px; padding:3px 10px; border-radius:1px; margin-right:6px;}
.reply_write2_tt b {margin-right:8px;}
.reply_write2_star img {width:28px; margin:-4px 0 0 0;}
.reply_write .info_pic {width:50px; display:inline-block; padding:0;}
.reply_write .info_pic img {width:50px; height:50px;  border-radius:50%;}
.reply_write .input-group {width:730px; float:right;}
.reply_more {border-bottom:1px solid #e6e7e8; text-align:center;}
.reply_more a {background:url(//recipe1.ezmember.co.kr/img/icon_arrow4.gif) right 11px no-repeat; color:#555; padding:5px 25px 15px 15px; font-size:15px; display:inline-block;}
.reply_list_star img {width:16px; margin:0 1px 0 0; vertical-align:text-top;}
.reply_list_hit {float:right; color:#444 !important; font-size:14px;}
.reply_list_hit img {width:20px; margin:-2px 3px 0 0; vertical-align:top;}
.reply_list_cont {float:left; width:650px; padding:0; margin:0;}
.reply_list_img {float:right; margin:5px 4px 0 0; padding:0;}
.reply_list_img.st2 {float:right; margin:-30px 4px 0 0; padding:0;}
.reply_list_img img {width:60px; height:60px;}
.reply_list_btn img {vertical-align:text-top; margin:1px 0 0 0;}
.reply_list_re {float:left; border-top:1px solid #e6e7e8; padding-top:18px; position:relative;}
.reply_list_icon {position:absolute; left:-36px; top:-2px;}

.view2_review_rere {padding:6px 0 2px 0;}
.view_reply  .btn_w {display:block; margin:15px auto 30px; float:right}
.view_reply  .btn_w span {padding-right:4px;}
.view2_box_noti {padding:0 12px 15px; line-height:1.8; letter-spacing:-0.02em;}
.view2_box_noti .tit {font-size:20px; font-weight:bold; margin:30px 0 10px;}
.view2_box_noti p {margin:0;}
.view2_box_noti dt {margin:15px 0;}
.view2_box_noti dd {margin-bottom:24px; line-height:1.8;}
.view2_box_noti dl {margin-bottom:10px;}

.review_w_star {color:#999; font-size:14px; text-align:center; padding:25px 0 12px 0; border-bottom:1px solid #ebebeb;}
.review_w_star p {padding-top:6px;}
.review_w_star p img {width:42px; margin:0 3px;}
.review_w_option {padding:10px 22px 5px;}
.review_w_option .media-left img {width:65px; height:65px;}
.review_w_option .media-body {font-size:12px;}
.review_w_option .media-body .form-control {box-shadow:none; resize: none; padding:3px; padding:8px;}



.view_step .carousel-control.right, .view_step .carousel-control.left {background:none;}
.view_step .carousel-control .glyphicon {color:#fff; filter:alpha(opacity=70); opacity:0.7; text-shadow:0 0 4px #000;}
.view_step .carousel.slide {border:2px solid #ececec; box-shadow:6px 6px 0px #f0f0f0; padding:5px; }
.view_step .carousel-indicators li {border:2px solid #ccc; width:14px; height:14px; vertical-align:middle;}
.view_step .carousel-indicators li.active {background:#74b243; border:none;}

.best_tit {font-size:20px; color:#000; padding:0 35px 30px 35px; }
.best_tit b {font-weight: 500;}
.best_tit span {color:#ccc; font-size:14px; font-style:italic; padding-left:4px;}
.best_tit_rmn {float:right; margin:-3px 0 0 0;}
.best_tit_rmn a {display:inline-block; float:left; margin:0; padding:0;}
.best_tit_rmn a img {height:36px; vertical-align:top;}
.best_tit_rmn .btn {background:#fff; border:1px solid #e5e5e5; border-radius:0; color:#888; font-size:15px; height:36px; padding:0 20px 1px; float:left; margin-right:5px;}
.best_tit_rmn .btn:hover {border:1px solid #bbb;}
.best_tit_rmn .btn span {vertical-align:text-top; font-style:normal; padding:1px 3px 0 0; color:#888; font-size:16px;}


.view_qrcode {float:right; margin-right:-20px; position:relative}
.view_qrcode .qrcode_layer {background: url(//recipe1.ezmember.co.kr/img/bg_layer5.png) left top; width:211px; height:278px; position:absolute;left: -212px;top: -7px; padding:40px 12px 11px;}
.view_qrcode .qrcode_layer p.qrimg {background:#6a6f74; padding:4px; width:124px; height:142px; text-align:center; margin:0 auto;}
.view_qrcode .qrcode_layer p.qrimg img {width:110px; height:110px;}
.view_qrcode .qrcode_layer p.qrimg span {display:block; padding-top:4px; color:#fff; font-size:13px;}
.view_qrcode .qrcode_layer p.tit {margin-top:29px; font-size:14px; color:#444; border-top:1px solid #ebebeb; padding:10px 0; background:#f8f8f8; text-align:center; line-height:18px;}
.view_qrcode a {display:block; margin-bottom:8px;}
.view_notice {background:#f9f9f9; border:1px dashed #ccc; margin:0 40px 32px; padding:12px 18px 11px 8px; text-align:right;}
.view_notice span {display:inline-block; background:url(//recipe1.ezmember.co.kr/img/icon_noti.png) left top no-repeat; padding:5px 0 6px 31px; font-size:13px; color:#999;}
.view_notice_in {display:inline-block; width:370px; text-align:left; padding-left:10px;}
.view_notice_in a {font-weight:bold; margin-left:12px;}
.view_notice_in a img {border:1px solid #ccc; margin-right:8px;}
.view_notice_date {float:left; margin:0; padding:0; line-height:1; padding:7px 0 0 0; color:#999; font-size:13px;}
.view_notice_date b {font-weight:normal; border-right:1px solid #dedede; padding:0 12px;}
.view_notice_date b:last-child {border:none;}

.view_nametag {background:#fcfaf6; border:1px solid #ededed; padding:18px 30px; margin:0 200px 40px;}
.view_nametag_pic {width:120px; display:inline-block; vertical-align:top;}
.view_nametag_pic img {width:100px; height:100px; border-radius:50%;}
.view_nametag_cont {display:inline-block; width:auto; margin:0;}
.view_nametag_cont dt {color:#555; font-size:11px; line-height:1.5;}
.view_nametag_cont dt b {font-size:16px; display:block;}
.view_nametag_cont dd {color:#aaa; line-height:1.4; margin:5px 0 0 0;}
.view_nametag_cont dd a {display:block; color:#6693b5; margin-top:4px;}

.view_tag {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_tag.png) left top no-repeat; background-size:50px; padding:0 0 20px 54px; line-height:1.5; margin:0 40px;}
.view_tag a {color:#2a7830; margin:0 4px 6px; background:#f2f2f2; padding:1px 5px; display:inline-block;}

.view_pdt {background:#fffdee; margin:0 1px; padding:25px 0 25px 80px;}
.view_pdt_tit {padding:4px 0; width:200px; text-align:center; font-size:14px; font-weight:bold; border:1px solid #74b243; color:#74b243; border-radius:20px; background:#fffdee; display:inline-block; margin:0 0 12px -12px; vertical-align:top;}
.view_pdt2 {background:#fff; padding:22px 40px 16px; word-break:break-all;}
.pdt_pic {width:150px; height:150px; border:1px solid #e4e4e4; background:#fff; padding:5px; display:inline-block; vertical-align:top;}
.pdt_pic img {width:100%; height:100%; max-width:140px; max-height:140px;}
.pdt_pic2 {width:220px; height:220px; display:inline-block; vertical-align:middle;}
.pdt_pic2 img {width:100%; height:100%; max-width:220px; max-height:220px; vertical-align:top;}
.pdt_cont {font-size:14px; color:#777;  display:inline-block; padding:8px 0 0 30px; line-height:23px; width:540px; vertical-align:top;}
.pdt_cont.st2 {display:inline-block; padding:20px 0 0 20px; width:550px; }
.pdt_cont b {font-size:18px; color:#000; display:block; padding-bottom:8px;}
.pdt_cont .btn {font-size:12px; color:#000; border-radius:1px; padding:3px 15px; font-weight:bold; display:block; margin-top:10px; float:right;}
.pdt_cont .btn strong {font-size:16px; padding-right:4px; vertical-align:middle;}
.pdt_list {padding:30px 30px 10px; width:100%; float:left;}
.pdt_list_box {width:23.8%; width:-webkit-calc(25% - 10px); width:-moz-calc(25% - 10px); width:calc(25% - 10px); float:left; margin:5px; padding:20px 0 10px; background:#fff; border:1px solid #ccc; border-radius:6px; text-align:center;}
.pdt_list_box img {width:100%; height:100%; max-width:150px; max-height:150px;}
.pdt_list_cont {line-height:18px; padding:8px 0 10px 0;}
.pdt_list_cont b {font-size:16px; color:#000; display:block; padding-bottom:6px;}
.pdt_list_cont .list_cont1 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_fork.png) left top no-repeat; background-size:20px; padding-left:22px; font-size:14px; color:#888; margin-right:15px;}
.pdt_list_cont .list_cont2 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_use.png) left top no-repeat; background-size:20px; padding-left:20px; font-size:14px; color:#888; margin-right:15px;}
.pdt_list_tit {font-size:32px; font-weight:bold; width:100%; text-align:center; padding:40px 0 20px;}
.pdt_list2 {padding:0 55px; list-style:none;}
.pdt_list2 li {margin:0 10px 30px; width:224px; display:inline-block; vertical-align:top; text-align:center;}
.pdt_list2 li a {}
.pdt_list2 li a img {width:204px;}
.pdt_list2 li p {margin:10px 0 0 0; font-size:16px;}
.pdt_list2 li:nth-child(4), .pdt_list2 li:nth-child(5), .pdt_list2 li:nth-child(6) {margin-bottom:0}

.view_pdt_btn {text-align:right; width:100%;}
.view_pdt2_btn {font-size:18px!important; color:#fff !important; background:#3691f1;  border-radius:4px; padding:9px 0 11px!important; font-weight:normal !important; display:block; margin:18px auto 0; border:none;}
.view_pdt2_btn:hover, .view_pdt2_btn:active, .view_pdt2_btn:focus {color:#fff; background:#3691f1; }
.view_pdt_cont {margin:40px 10px; border-top:2px solid #000;}
.view_pdt_cont dt {border-bottom:1px solid #000; padding:16px 0; text-align:center; font-size:16px; font-weight:bold; color:#000;}
.view_pdt_cont dd {color:#777; padding:18px 8px; line-height:2;}
.view_pdt_cont dd .picture2 {text-align:center;}
.view_pdt3 {padding:22px; position:relative;}
.view_pdt3_label {position:absolute; left:-45px; top:-45px; z-index:1000;}
.pdt_pic3 {margin-right:40px; display:inline-block;}
.pdt_pic3 img {width:300px; height:300px;}
.pdt_cont3 {display:inline-block; width:460px; vertical-align:top;}
.pdt_cont3 dt {font-size:24px; padding:28px 0 14px 0;}
.pdt_cont3 dt span {font-size:14px; color:#aaa; display:block; font-weight:normal;}
.pdt_cont3 dd {font-size:14px; color:#777;line-height:1.7;}
.pdt_cont3 dd b {font-size:18px; color:#000; display:block; padding-bottom:5px;}
.pdt_cont3 dd .btn-default1 {color:#fff; background:#77b347;  padding:9px 0 11px; width:220px; font-size:18px; font-weight:normal; margin-top:30px;}
.pdt_cont3 dd .btn-default1:hover {color:#fff; background:#67aa32;}
.pdt_cont3 dd .btn-default2 {color:#fff; background:#479ffc; padding:9px 0 11px; width:220px; font-size:18px; font-weight:normal; margin-top:30px;}
.pdt_cont3 dd .btn-default2:hover {color:#fff; background:#3691f1;}
.view_pdt_detail {padding:40px 80px; margin:0;}
.view_pdt_detail dt {font-size:30px; border-bottom:1px solid #666; border-top:2px solid #000; margin:0; padding:18px 0; text-align:center; line-height:1; font-weight:bold;}
.view_pdt_detail dd {padding:35px 0 0 0; text-align:center;}
.view_pdt_detail dd img {max-width:735px;}
.view_pdt_recipe {padding:40px 50px 0 50px; margin-bottom:10px;}
.view_pdt_recipe.st2 {padding:0 50px 0 50px; margin-bottom:10px;}
.view_pdt_recipe dt {font-size:24px; padding:0 0 25px 0;}
.view_pdt_recipe .thumb {width:180px; display:inline-block; margin:0 21px 18px 0; vertical-align:top;}
.view_pdt_recipe .thumb:nth-child(4n+4) {margin-right:0;}
.view_pdt_recipe .thumb img {width:180px; height:180px;}
.view_pdt_recipe .thumb .caption {padding:10px;}
.view_pdt_sale {padding:40px 50px 0 50px; margin-bottom:10px;}
.view_pdt_sale dt {font-size:24px; padding:0 0 25px 0;}

.view2_pic {margin:0 auto; padding:60px 0 70px; position:relative; text-align:center; background:#fff; max-width:600px;}
.view2_pic_img {max-width:600px; width:100%; height:auto; -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2); box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2); max-width:640px;}
.view_cate {padding:0 12px 7px 0; color:#fff; position:absolute; right:0; bottom:25px; text-align:right; line-height:20px; vertical-align:bottom;}
.view_cate.st2 {position:absolute; right:0; bottom:66px;}
.view_cate a {display:block; text-shadow:0 0 2px #000; font-weight:bold;}
.view_cate a, .view_cate a:hover, .view_cate a:visited, .view_cate a:active {color:#fff;}
.view_cate_num {background:#000; border-radius:15px;  opacity: 0.6; filter: alpha(opacity=60); margin-bottom:10px; display:inline-block; padding:3px 10px 5px 16px; margin-right:0;}
.view_cate_num span.hit {font-size:14px; font-family: Myriad Pro; color:#fff; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_view.png?v1) left top no-repeat; background-size:20px auto; padding:2px 14px 2px 25px;}
.view_cate_num span.share {font-size:14px; font-family: Myriad Pro; color:#fff; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_share.png?v1) left 1px no-repeat; background-size:20px auto; padding:2px 14px 2px 22px;}
.view_cate_num span.like {font-size:11px; font-family: Myriad Pro; color:#fff; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_heart.png) left -3px no-repeat; background-size:20px auto; padding:0 0 0 21px;}
.user_info2 {position:absolute; bottom:0; left:0; text-align:center; width:100%; height:130px;}
.user_info2_pic {width:120px; height:120px; border-radius:50%; padding:5px; display:block; margin:0 auto 5px; background:url(//recipe1.ezmember.co.kr/img/mobile/pic_bg.png) left top repeat;}
.user_info2_pic img {width:110px; height:110px; border-radius:50%;}
.user_info2_name {color:#333; font-size:15px; display:inline-block; line-height:1; position:relative; margin-top:4px;}
.user_info2_name .btn {border:1px solid #74b243; font-size:14px; color:#74b243; width:66px; padding:5px 0; position:absolute; right:-76px; top:-7px;}
.user_info2_name .btn.st2 {border:1px solid #bbb; color:#bbb;}
.view2_summary {width:640px; margin:40px auto 0; padding-bottom:40px;}
.view2_summary h3 {font-size:34px; letter-spacing:-0.05em; line-height:1.3; text-align:center; padding:0 10px;}
.view2_summary_in {position:relative; padding:10px 18px 10px 24px; color:#aaa; font-style:italic; font-size:16px; line-height:170%; width:510px; margin:0 auto;}
.view2_summary_in_m1 {position:absolute; left:0; top:0; display:block;}
.view2_summary_in_m2 {position:absolute; right:0; bottom:16px; display:block;}
.view2_summary_in span img {width:24px;}
.view2_summary_info {padding:2px 15px 0; text-align:center; padding-bottom:40px;}
.view2_summary_info span {display:inline-block; width:32%; padding-top:56px; color:#bcb7b7; font-size:16px;}
.view2_summary_info1 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_man.png) center no-repeat; background-size:34px;}
.view2_summary_info2 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_time2.png) center no-repeat; background-size:34px;}
.view2_summary_info3 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_star.png) center no-repeat; background-size:34px;}
.view2_btn {background:#e6e6e6; padding:10px 20px; font-size:14px; font-weight:bold; line-height:1; position:relative; border:1px solid #d2d2d2;}
.view2_btn a {margin:0 5px}
.view2_btn a span {color:#fff; margin:0 10px 0 7px;}
.view2_btn_r {float:right;}
.view2_btn .view_qrcode2 {position:relative; display:inline-block;}
.view2_btn .qrcode_layer {background: url(//recipe1.ezmember.co.kr/img/bg_layer6.png) left top; width:211px; height:278px; position:absolute;left:-80px; top:-266px; padding:40px 12px 11px;}
.view2_btn .qrcode_layer p.qrimg {background:#6a6f74; padding:4px; width:124px; height:142px; text-align:center; margin:0 auto;}
.view2_btn .qrcode_layer p.qrimg img {width:110px; height:110px;}
.view2_btn .qrcode_layer p.qrimg span {display:block; padding-top:4px; color:#fff; font-size:13px;}
.view2_btn .qrcode_layer p.tit {margin-top:24px; font-size:14px; color:#444; border-top:1px solid #ebebeb; padding:10px 0; background:#f8f8f8; text-align:center; line-height:18px;}

.view2_summary .btn_list {border-top:1px solid #e3e3e3; margin:0; padding:30px 0 0 0; text-align:center;}
.view2_summary .btn_list a {font-size:15px; color:#666; width:23%; display:inline-block;}
.view2_summary .btn_list a span {margin:0; display:block; padding-top:8px;}
.view2_summary .btn_list a img {width:70px; height:70px; border-radius:50%;}
.view2_summary .btn_list.st2 a img {width:70px; height:70px; border-radius:0;}
.view2_summary .btn_list.st2 a span b.st1 {color:#cb221c; padding-left:5px;}
.view2_summary .btn_list.st2 a span b.st2 {color:#0ba987; padding-left:5px;}
.view2_summary .btn_list.st2 a span b.st3 {color:#0097ad; padding-left:5px;}
.view_btn_more {padding:15px 0 0;}
.view_btn_more a{/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+75,efefef+100 */
background: #ffffff; /* Old browsers */
background: -moz-linear-gradient(top,  #ffffff 75%, #efefef 100%); /* FF3.6-15 */
background: -moz-linear-gradient(top,  #ffffff 75%, #efefef 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #ffffff 75%,#efefef 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #ffffff 75%,#efefef 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#efefef',GradientType=0 ); /* IE6-9 */
display:block; border:1px solid #d5d5d5; padding:8px 0; text-align:center; font-size:13px; color:#8e8e8e; width:360px; margin:0 auto; border-radius:1px;
}
.view_pdt_recipe2 {margin-top:-6px; padding:0 50px;}
.view_pdt_recipe2 li {width:180px; display:inline-block; margin:0 21px 18px 0; vertical-align:top; text-align:center;}
.view_pdt_recipe2 li:nth-child(4n+4) {margin-right:0;}
.view_pdt_recipe2 li img {width:180px; height:180px;}
.view_pdt_recipe2 li .caption {padding:10px;}
.view_pdt_recipe2 li .tag {border:1px solid #74b243; font-size:17px; color:#509d12; margin:0 0 12px 0; display:inline-block; padding:7px 16px 8px;; border-radius:17px; line-height:1; font-weight:bold;}
.view_pdt_recipe2 li .tag:hover {background:#ffffd6; border:1px solid #438b09; }
.view_pdt_recipe2 li a {position:relative; display:block;}
.view_pdt_recipe2 li .caption {text-align:left; height:100%; line-height:1.4; color:#fff; position:absolute; left:0; top:0; width:100%;
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#000000+0,000000+100&0+57,0.9+100 */
background: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0) 57%, rgba(0,0,0,0.9) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0) 57%,rgba(0,0,0,0.9) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0) 57%,rgba(0,0,0,0.9) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#e6000000',GradientType=0 ); /* IE6-9 */
}
.view_pdt_recipe2 li .caption p {position:absolute; left:0; bottom:2px; padding:10px 12px; margin:0;}


.theme_cate {border:1px solid #ebebeb; margin:0; padding:0; list-style:none; float:left; width:100%;}
.theme_cate:after {clear:both;}
.theme_cate li {width:25%; border-right:1px solid #ebebeb; height:72px; border-bottom:1px solid #ebebeb; float:left; margin:0; padding:0; position:relative;}
.theme_cate li:nth-child(4n+4) {border-right:none;}
.theme_cate li:nth-last-child(1), .theme_cate li:nth-last-child(2), .theme_cate li:nth-last-child(3), .theme_cate li:nth-last-child(4)  {border-bottom:none;}
.theme_cate li a {background:url(//recipe1.ezmember.co.kr/img/icon_theme.png) no-repeat 22px 9px; padding:23px 0 25px 92px; font-size:16px; display:inline-block; width:100%; margin:0;}
.theme_cate li a.cate_1 {}
.theme_cate li a.cate_2 {background-position:22px -73px;}
.theme_cate li a.cate_3 {background-position:22px -155px;}
.theme_cate li a.cate_4 {background-position:22px -237px;}
.theme_cate li a.cate_5 {background-position:22px -319px;}
.theme_cate li a.cate_6 {background-position:22px -401px;}
.theme_cate li a.cate_7 {background-position:22px -483px;}
.theme_cate li a.cate_8 {background-position:22px -565px;}
.theme_cate li a.cate_9 {background-position:22px -647px;}
.theme_cate li a.cate_10 {background-position:22px -729px;}
.theme_cate li:hover {background:#fffadb;
	-webkit-transition: all 0.3s ease-in-out;
	-moz-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	-ms-transition: all 0.3s ease-in-out;
	transition: all 0.3s ease-in-out;
}
.theme_cate li.cate_none:hover {background:#fff;}
/*.theme_cate li span {font-size:15px; color:#ccc; display:inline-block; float:right; margin-right:27px; font-weight:bold;}*/
.theme_cate li .label_pay {position:absolute; left:58px; bottom:12px;}
.theme_cate li .label_pay img {width:18px;}

.theme_cate.st2 li a {background:none; padding:10px 0 0 23px}
.theme_cate.st2 li img {width:50px; height:50px; margin-right:19px;}

.theme_list {clear:both;}
.theme_list_tit {font-size:18px; padding:34px 0 20px 4px; font-weight:bold; clear:both;}
.theme_list .thumbnail {width:224px; border-radius:0; padding:0 0 15px 0; margin:0 14px 20px 0; background:#fbfbfb; border:1px solid #ddd; display:inline-block; vertical-align:top; position:relative;}
.theme_list a.thumbnail:nth-child(5n+5) {margin:0 -4px 20px 0;}
.theme_list.st2 a.thumbnail:nth-child(5n+5) {margin:0 0 20px 0!important;}
.theme_list.st2 a.thumbnail {display: inline-block;padding-bottom: 10px;}
.theme_list.st3 a.thumbnail:nth-child(4n+4) {margin:0 0 20px 0!important;}
.theme_list.st3 a.thumbnail {display: inline-block;padding-bottom: 10px; width:202px;}
.theme_list.st4 a.thumbnail:nth-child(4n+4) {margin:0 0 20px 0!important;}
.theme_list.st4 a.thumbnail {display: inline-block;padding-bottom: 10px; width:202px;}
.theme_list.st4 a.thumbnail:nth-child(5n+5) {margin:0 14px 20px 0!important;}

.theme_list .thumbnail img {width:100%;}
.theme_list .thumbnail.st2 {height:230px;}
.theme_list .thumbnail .vod_label {position:absolute; right:6px; top:84px; z-index:10;}
.theme_list .thumbnail .vod_label img {border-bottom:none !important; width:40px; height:40px;}
.event_cont ul.theme_list .thumbnail.st2 {height:256px!important;}
.event_cont ul.theme_list .thumbnail.st2 img {width:200px; height:200px;}
.theme_list .caption {font-size:15px;}
.theme_list .caption_cate {font-size:13px; color:#999; display:block;}
.theme_list .list_num {background:#000; filter:alpha(opacity=50); opacity:0.5; margin:0; padding:2px 6px; position:absolute; right:5px; top:116px; color:#fff; font-size:12px;}
.theme_list .list_num2 {background:#000; filter:alpha(opacity=80); opacity:0.8; margin:0; padding:3px 8px 5px; position:absolute; right:5px; top:100px; color:#fff; font-size:12px; border-radius:10px; line-height:1;}
.event_cont ul.theme_list .thumbnail.st2 .list_num2 {position:absolute; right:5px; bottom:64px; top:auto;}
.theme_list .list_num2 span {vertical-align:top; padding-right:3px; color:#F03;}
.theme_title {width:895px; height:150px; font-size:18px; color:#fff; text-align:center; padding-top:26px;}
.theme_title b {font-size:36px; display:block;}
.theme_title em {font-weight:bold; font-style:normal; font-family:Myriad Pro;}
.theme_title p {font-size:12px; padding:0; margin:0; line-height:1.2; padding-top:12px;}
.title_bg01 {background:url(//recipe1.ezmember.co.kr/img/theme_cate_01.jpg) left top no-repeat;}
.title_bg02 {background:url(//recipe1.ezmember.co.kr/img/theme_cate_02.jpg) left top no-repeat;}
.title_bg03 {background:url(//recipe1.ezmember.co.kr/img/theme_cate_03.jpg) left top no-repeat;}
.title_bg04 {background:url(//recipe1.ezmember.co.kr/img/theme_cate_04.jpg) left top no-repeat;}
.title_bg05 {background:url(//recipe1.ezmember.co.kr/img/theme_cate_05.jpg) left top no-repeat;}
.title_bg06 {background:url(//recipe1.ezmember.co.kr/img/theme_cate_06.jpg) left top no-repeat;}
.title_bg07 {background:url(//recipe1.ezmember.co.kr/img/theme_cate_07.jpg) left top no-repeat;}
.title_bg08 {background:url(//recipe1.ezmember.co.kr/img/theme_cate_08.jpg) left top no-repeat;}
.title_bg09 {background:url(//recipe1.ezmember.co.kr/img/theme_cate_09.jpg) left top no-repeat;}
.title_bg10 {background:url(//recipe1.ezmember.co.kr/img/theme_cate_10.jpg) left top no-repeat;}
.theme_list .caption_cate2 {display:block; font-size:16px; padding-top:5px; text-align:center;}
.theme_list .caption_tit {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word;}
.theme_list .caption_name {color:#999; font-size:14px; display:block; padding-top:3px;}
.theme_list_tit2 {font-size:20px; padding:0 0 24px 0; position:relative;}
.theme_list_tit2.st2 .pull-right {margin-top:-4px;}
.theme_list_tit2 span {color:#999; padding-left:4px;}
.theme_list_tit2 .btn {padding:4px 15px 6px 10px; margin-top:-2px;}
.theme_list_tit2 .btn .glyphicon {margin-left:20px; color:#333;}
.theme_list_tit2 .btn-info2 {padding:4px 30px 5px; font-size:20px;}
.theme_list_tit2 img {vertical-align:top;}
.theme_list .label_premium {position:absolute; left:-1px; top:7px; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_premium.png) left top no-repeat; background-size:72px; width:72px; height:26px;}
.theme_list2 {clear:both;}
.theme_list2 .thumbnail {width:418px; border-radius:0;  padding:0; margin:0 14px 20px 0; height:210px; background:#fbfbfb; border:1px solid #ddd; display:inline-block; vertical-align:top; position:relative;}
.theme_list2 .thumbnail:nth-child(2n+2) {margin:0 -4px 20px 0;}
.theme_list2 .thumbnail .theme_list2_l img {width:200px; height:130px;}
.theme_list2 .caption {font-size:15px;}
.theme_list2 .caption_cate {font-size:13px; color:#999; display:block;}
.theme_list2 .list_num {background:#000; filter:alpha(opacity=50); opacity:0.5; margin:0; padding:2px 6px; position:absolute; right:5px; top:100px; color:#fff; font-size:12px;}
.theme_list2 .caption_cate2 {display:block; font-size:16px; padding-top:8px; text-align:center;}
.theme_list2 .caption_name {color:#999; font-size:14px; display:block; padding-top:3px;}
.theme_list2 .label_premium {position:absolute; left:-1px; top:7px; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_premium.png) left top no-repeat; background-size:72px; width:72px; height:26px;}
.theme_list2_l {width:200px; float:left;}
.theme_list2_r {width:216px; float:left; border-left:1px solid #ddd; height:100%; background:url(//recipe1.ezmember.co.kr/img/bg_note.gif) left 16px repeat; font-size:12px; line-height:26px; padding:8px 18px; box-shadow:2px 0 2px #efeeda inset}
.theme_list2_r img {width:94px; margin-left:-10px; margin-bottom:4px;}
.theme_list2_r p { width:186px; height:158px; overflow-y:auto;}
.theme_advice {background:url(//recipe1.ezmember.co.kr/img/mobile/bg_theme.png) left top repeat; padding:20px 30px; -webkit-box-shadow:0 1px 2px rgba(0, 0, 0, 0.08) inset; box-shadow:0 1px 2px rgba(0, 0, 0, 0.08) inset; position:relative; margin:-5px 0 25px;}
.theme_advice_pic {display:inline-block; width:118px; vertical-align:top;}
.theme_advice_pic img {width:100px; height:100px; border-radius:50%;}
.theme_advice_cont {display:inline-block; padding:14px 0 0 0; }
.theme_advice_cont b {font-size:18px; display:block; padding-bottom:10px;}
.theme_advice_img {position:absolute; right:20px; top:-2px;}
.theme_advice_img img {width:130px;}
.theme_advice_more {border-top:1px dashed #9fa094; margin:15px 0; padding:16px 0 0 0; line-height:1.5;}
.theme_advice .btn {background:url(//recipe1.ezmember.co.kr/img/mobile/bg_theme.png) left top repeat; border:1px solid #565653; color:#000; font-size:12px; border-radius:0; padding:7px 20px; display:block; margin:5px auto 0;}
.theme_advice .btn span {margin-left:3px;}
.banner_premium {text-align:center; padding:0; margin-top:2px;}
.theme_list_tit2 .list_sort {padding:0; top:-6px;}
.banner_premium td {vertical-align:top;}
.banner_premium_in { background:url(//recipe1.ezmember.co.kr/img/mobile/theme_t3.png) left top repeat-x; background-size:2px; width:100%; text-align:center;}
.banner_premium img {width:25px;}
.banner_premium_in .btn {border-radius:14px; font-size:13px; padding:5px 30px; color:#fff; border:0;}
.banner_premium_in .btn.st1 {background:#63302a;}
.banner_premium_in .btn.st2 {background:#5e0b02;}
.banner_premium_in1 {color:#fff; font-size:15px; line-height:1.4; display:block; margin:18px 0 12px 0;}
.banner_premium_in1 img {width:18px; vertical-align:text-bottom; margin-right:2px;}
.banner_premium_in2 {display:block; margin:0;}
.banner_premium_in2 img {width:250px;}


.menu_best.home {padding:70px 0 0 0; background:url(//recipe1.ezmember.co.kr/img/menu_best_bg.jpg?v.0721) left top no-repeat; width:893px; height:440px; margin:-30px -20px -10px; text-align:center; position:relative;}
.menu_best.home .thumbnail {width:337px; height:324px; padding:0; margin:2px 8px 8px; border:none; display:inline-block; vertical-align:top; position:relative; border-radius:none; text-align:left; box-shadow:none; padding:37px 15px; background:url(//recipe1.ezmember.co.kr/img/menu_best_bg2.png?v.0721) left top no-repeat;}
.menu_best_in {display:inline-block;}
.menu_best .best_tit {position:absolute; left:50%; top:25px; margin-left:-185px; z-index:100;}
.menu_best { clear:both;}
.menu_best .thumbnail {width:200px; border-radius:0; padding:0; margin:0 14px 20px 0; height:278px; border:1px solid #ddd; display:inline-block; vertical-align:top; position:relative;}
.menu_best a.thumbnail:nth-child(4n+4) {margin:0 -4px 20px 0;}
.menu_best .thumbnail img {width:198px; height:128px;}
.menu_best.home .caption {font-size:18px; padding:15px 9px 0; line-height:18px; color:#000; font-weight:bold;}
.menu_best .caption {font-size:14px; padding:14px 12px 0; line-height:20px; color:#000;}
.menu_best .caption .jq_elips2 {font-weight:bold}
.menu_best .caption_name {font-size:11px; color:#999; display:block; padding:4px 0 0 3px;}
.menu_best.home .caption_name {font-size:14px; color:#999; display:block; padding:10px 0 0 3px;}
.menu_best .caption_menu1 {font-size:12px; color:#777; display:block; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_menu_a1.png) left 2px no-repeat; background-size:19px; padding:0 0 2px 23px; margin:7px 0 0 -1px; line-height:1.5;}
.menu_best .caption_menu2 {font-size:12px; color:#777; display:block; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_menu_a2.png) left 2px no-repeat; background-size:19px; padding:0 0 2px 23px; margin:1px 0 0 -1px; line-height:1.5;}
.menu_list_img {width:100%; position:relative;}
a.label_like {position:absolute; right:8px; bottom:8px; background:#000; border-radius:15px; opacity: 0.8; filter: alpha(opacity=80); color:#fff; font-size:16px; font-weight:bold; margin:0; padding:5px 12px;}
a.label_like span {color:#f64000; padding:0 5px 0 0; vertical-align:middle;}
.menu_best .menu_list_img1 {width:65%; height:129px; border-right:1px solid #fff;}
.menu_best .menu_list_img2 {width:35%; height:65px; border-bottom:1px solid #fff;}
.menu_best .menu_list_img3 {width:35%; height:64px;}
.menu_best.home .menu_list_img1 {width:65%; height:190px; border-right:1px solid #fff;}
.menu_best.home .menu_list_img2 {width:35%; height:95px; border-bottom:1px solid #fff;}
.menu_best.home .menu_list_img3 {width:35%; height:94px;}
.menu_img_none {background:url(//recipe1.ezmember.co.kr/img/df/rp_328_328.png) center no-repeat; background-size:cover; width:auto; width:100%;}
.menu_list_img.menu_img_none .menu_list_img1 {border-right:none;}
.menu_list_img.menu_img_none .menu_list_img2 {border-bottom:none;}
.menu_cate {float:left; padding-bottom:20px;}
.menu_cate_ul {width:100%; border:1px solid #ebebeb; margin:0 auto; padding:0; list-style:none; background:#fff; float:left; }
.menu_cate_ul li {width:25%; border-right:1px solid #ebebeb; border-bottom:1px solid #ebebeb; float:left; margin:0; padding:0;}
.menu_cate_ul li:nth-child(4n+4) {border-right:none;}
.menu_cate_ul li:nth-last-child(1), .menu_cate li:nth-last-child(2), .menu_cate li:nth-last-child(3), .menu_cate li:nth-last-child(4)  {border-bottom:none;}
.menu_cate_ul li a {padding:12px 16px; font-size:16px; display:inline-block; width:100%; margin:0; line-height:1.3;}
.menu_cate_ul li a span {font-size:11px; font-weight:bolder; padding-left:4px; font-family:Tahoma,Helvetica; }
.menu_cate_ul li a img {width:38px; height:38px; margin-right:7px;}
.menu_list_tit {font-size:18px; padding:34px 0 12px 2px; font-weight:bold; clear:both;}
.menu_list_tit img {width:32px; padding-right:1px; vertical-align:text-top;}
/*.best_arrow {display:inline-block; width:44px; height:120px; text-align:center; margin:110px 5px 0; padding-top:20px; vertical-align:top;}*/
.menu_view {padding:0 8px; float:left; width:100%;}
.menu_view.st2 {padding:0; margin:-30px 0 0 -21px; float:left; width:895px;}
.menu_view dl {margin:-1px 0 0 0; padding:0;}
.menu_view dt {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_history.png) left 2px no-repeat; background-size:30px; padding:4px 0 3px 38px; font-size:20px; font-weight:bold; color:#666; line-height:24px;}
.menu_view dd {padding:10px 0 50px 35px; margin-right:8px; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_history_bg.png) 12px top repeat-y; background-size:6px auto;}
.menu_view .thumbnail {border-radius:0; margin:0; padding:14px; clear:both; height:280px; position:relative;}
.menu_view .thumbnail_top {border-radius:0; margin:0; padding:0; float:left; width:100%; border:1px solid #d4d4d4;}
.menu_view .menu_list_img {width:390px; float:left;}
.menu_view .menu_list_img1 {height:250px; width:65%; border-right:2px solid #fff;}
.menu_view .menu_list_img2 {height:125px; width:35%; border-bottom:2px solid #fff;}
.menu_view .menu_list_img3 {height:125px; width:35%;}
.menu_view .menu_list_img img {width:390px;}
.menu_view .thumbnail_top .menu_list_img {width:480px; float:left;}
.menu_view .thumbnail_top .menu_list_img1 {height:310px; width:65%; border-right:2px solid #fff;}
.menu_view .thumbnail_top .menu_list_img2 {height:155px; width:35%; border-bottom:2px solid #fff;}
.menu_view .thumbnail_top .menu_list_img3 {height:155px; width:35%;}
.menu_view .caption {font-size:25px; padding:18px 6px 0 28px; line-height:34px; color:#000; width:350px; vertical-align:top; float:left;}
.menu_view .caption.st2 {font-size:30px; line-height:1.3; padding:35px 6px 0 28px; width:382px;}
.menu_view .caption_name {font-size:11px; color:#999; display:block; padding:4px 0 0 3px;}
.menu_view .caption_menu1 {font-size:14px; color:#777; display:block; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_menu_a1.png) left 2px no-repeat; background-size:24px; padding:2px 0 2px 30px; margin:16px 0 5px 0; line-height:1.5;}
.menu_view .caption_menu2 {font-size:14px; color:#777; display:block; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_menu_a2.png) left 2px no-repeat; background-size:24px; padding:2px 0 2px 30px; margin:1px 0 0 0; line-height:1.5;}
.menu_view .caption_cont {font-size:16px; line-height:1.6; color:#777; word-break:break-all; height:160px; width:360px; padding-right:15px; overflow-y:auto; margin:18px 0 10px 0; position:relative;}
.menu_view .caption_cont2 {font-size:16px; line-height:1.6; color:#777; margin:20px 0 0 2px;}
.menu_view_cont {padding:18px 12px 25px; font-size:16px; line-height:1.6; color:#000;}
.menu_view_tip {background:url(//recipe1.ezmember.co.kr/img/mobile/tit_tip.png) left top no-repeat; background-size:110px; padding:38px 18px 15px 20px; font-size:14px; line-height:1.6;}

.menu_etc {position:absolute; right:14px; bottom:14px; width:356px; margin:0; padding:0; border:1px solid #e8e8e8; background:#f6f6f6;}
.menu_etc li {text-align:center; border-right:1px solid #e8e8e8; width:33%; list-style:none; float:left; padding:9px 0 8px 0; font-size:11px; font-family:Tahoma,Helvetica; font-weight:bold;}
.menu_etc li:last-child {border-right:0; width:34%;}
.menu_etc li img {width:24px; padding-right:3px;}
.menu_etc2 {width:100%; margin:0; padding:0; border:1px solid #d4d4d4; background:#f6f6f6; float:left; border-top:0; box-shadow:0 2px 3px #eee;}
.menu_etc2 li {text-align:center; border-right:1px solid #e3e3e3; width:25%; list-style:none; float:left; padding:15px 0; font-size:12px; font-family:Tahoma,Helvetica; font-weight:bold;}
.menu_etc2 li:last-child {border-right:0; width:25%;}
.menu_etc2 li img {width:24px; padding-right:3px;}
.cont_list.st3 .best_label2 {position:absolute; top:3px; right:2px; z-index:10;}
.cont_list.st3 .best_label2 img {width:50px; height:50px;}
.cont_list.st3 .menu_label {position:absolute; top:3px; left:3px; z-index:10; opacity: 0.8; filter: alpha(opacity=80);}
.cont_list.st3 .menu_label img {width:50px; height:50px;}

.menu_write {margin:-1px 1px;}
.menu_write dt {background:#f8f8f8; font-size:20px; font-weight:bold; border-bottom:1px solid #e6e7e8; border-top:1px solid #d8d8d8; padding:10px 20px;}
.menu_write .form-control {font-size:16px; background:#fff; border:1px solid #e7e7e7; border-top:0; border-right:0; border-left:0; border-radius:0; box-shadow:none; padding:30px 20px;}
.menu_write textarea.form-control {border-bottom:0; padding:15px 20px;}
.menu_write .write_pic2 {text-align:center; font-size:16px; color:#999; width:100%; margin:0; padding:30px 0;}
.menu_write .write_pic2 a {color:#666; border:1px solid #ddd; display:block; width:312px; padding-top:86px; height:310px; margin:0 auto; background:#f7f7f7;}
.menu_write .write_pic2 img {margin-bottom:14px;}
.menu_write .write_pic2 span {display:block; font-size:12px; color:#999; margin-top:5px;}
.menu_write .dropdown {display:inline-block; width:33%; float:left;}
.menu_write dl {clear:both;}
.menu_write dd {clear:both; margin:0 1px 0 0;}
.menu_write dd .cate_select {width:893px;}
.menu_write dd .cate_select select { color:#666; border:1px solid #dedfe0; border-left:0; border-top:0; padding:14px 15px; text-align:left;  font-size:14px; float:left; width:446px;}
.menu_write dd .cate_select select:last-child {border-right:0; width:447px;}
/*.menu_write dd .dropdown .btn {display:inline-block; border:1px solid #dedfe0; border-left:0; border-top:0; border-radius:0; width:100%; padding:15px 18px; text-align:left;  font-size:14px;}
.menu_write dd .dropdown .btn span {float:right; color:#777;}
.menu_write dd .dropdown:last-child {width:34%;}
.menu_write dd .dropdown:last-child .btn {border-right:0;}
.menu_write dd .dropdown-menu, .dropdown-menu li {width:100%; border-radius:0;}*/
.menu_write .write_pic3 {padding:14px 0 20px; margin:10px; 0; text-align:center;}
.menu_write .write_pic3 .menu_thumb {display:inline-block; width:202px; position:relative; margin:0 5px 20px; padding:0; vertical-align:top;}
.menu_write .write_pic3 .menu_thumb img {width:200px; height:200px; border:1px solid #ddd;}
.menu_write .write_pic3 .menu_thumb .menu_label {position:absolute; top:5px; left:5px; z-index:10; opacity: 0.8; filter: alpha(opacity=80);}
.menu_write .write_pic3 .menu_thumb .menu_label img {width:50px; height:50px; border:none;}
.menu_write .write_pic3 .menu_thumb .pic_del {position:absolute; right:1px; top:1px; display:block; filter:alpha(opacity=60); opacity:0.6; background:url(//recipe1.ezmember.co.kr/img/mobile/btn_del.png) left top no-repeat; background-size:30px; z-index:10000; width:30px; height:30px;}
.menu_write .write_pic3 .menu_thumb_t {padding:10px 12px; margin:0; text-align:left;}
.menu_write .write_pic3 .btn_add {text-align:center;}
.menu_write .write_pic3 .btn_add .btn {border:none; background:none; padding:0; font-size:16px; color:#444; font-weight:bold;}
.menu_write .write_pic3 .btn_add .btn span {color:#74b243; font-size:20px; margin:-3px 4px 0 0; vertical-align:middle;}
.menu_btn {text-align:center; border-top:1px solid #ddd; padding:35px 0 40px;}
.menu_btn .btn {margin:0 2px;}
.menu_write .write_pic3 .menu_thumb .menu_tit {background:#000; filter:alpha(opacity=70); opacity:0.7; color:#fff; position:absolute; left:0; bottom:0; height:56px; padding:6px 8px 0; margin:0 2px; width:198px;}

/*modal*/
.modal-header .close {text-shadow:none;	filter:alpha(opacity=100); opacity:1;}
.modal-title {font-size:16px; font-weight:bold;}
.modal-body p {font-size:12px; padding-top:10px;}
.modal-body .follw_list {padding:0; font-size:16px; font-weight:bold;}
.modal-body .follw_list li {padding:16px 20px 14px 17px; margin:0; list-style:none; border-bottom:1px solid #d5d6d7;}
.modal-body .follw_list li img {width:60px; height:60px; margin-right:15px; border-radius:50%;}
.modal-body .follw_list li .btn {float:right; margin-top:11px;}
.modal-body .follw_list li:last-child {border:none;}
.modal-dialog .new_folder .modal-title {padding-top:5px; text-align:center;}
.modal-dialog .new_folder .btn {margin-right:20px;}
.modal-dialog .new_folder .btn span {background:url(//recipe1.ezmember.co.kr/img/icon_folder.png) left top no-repeat; padding-left:23px; font-size:15px; font-weight:bold;}
.modal-body .scrap_list {margin:0 10px 22px 10px;}
.modal-body .scrap_list {margin:12px 0 0 0;}
.modal-body .scrap_list .media {border-bottom:1px solid #d5d6d7; padding:10px 25px;}
.modal-body .scrap_list .media h3 {padding-top:3px; font-weight:bold; font-size:16px; margin-bottom:2px;}
.modal-body .scrap_list .media h3 .small {font-size:12px;}
.modal-body .scrap_list .media p {font-size:14px; color:#999; padding:0; }
.modal-body .scrap_list .media p span {color:#74b243; font-weight:bold;}
.modal-body .scrap_list .media .media-left {padding-right:14px;}
.modal-body .scrap_list .media .like_hit p {width:80px; background:url(//recipe1.ezmember.co.kr/img/icon_heart4.gif) center top no-repeat; padding-top:30px; color:#de4830; text-align:center; font-weight:bold; font-size:14px; font-family:Helvetica;}
.modal-body .scrap_list .media:last-child {border:none;}
.modal-body .scrap_list .admin_btn p {width:60px; padding-left:8px;}
.modal-body .scrap_list .admin_btn .dropdown-toggle {width:40px; border:none;}
.modal-body .scrap_list .admin_btn .btn-group.open .dropdown-toggle, .admin_btn .btn-group .dropdown-toggle:active {box-shadow:none;}

.modal-body .panel-heading {background:#fff; border:none; padding:18px 30px;}
.modal-body .panel-group {width:895px; margin:0 auto;}
.modal-body .panel-group .panel {border-radius:0;}
.modal-body .guide_tit {width:895px; padding:20px 0 15px 0; margin:0 auto;}
.modal-body .talk_guide {border:none; width:895px; margin:8px auto 30px;}
.modal-body .talk_guide .btn {margin:0;}
.guide_icon {vertical-align:top; margin-right:8px; display:inline-block;}
*+ .guide_icon {vertical-align:middle;}
* .guide_icon {vertical-align:middle;}
.modal-body i.btn_arrow {margin:5px 10px 0 0;}
.modal-body .panel-group .panel+.panel {margin-top:-1px;}
.modal-noti {font-size:11px; color:#999; text-align:center; margin:5px 0 25px;}

.modal-body .nav-tabs2 {margin:12px;}
.modal-body .nav-tabs2.three li {width:33.3%; text-align:center;}
.modal-body .nav-tabs2.three li:lash-child {width:34%;}
.modal-body .nav-tabs2 li a {padding:8px 0 9px; }
.modal-body .nav-tabs2 li.active a { background:#515e72;}
.tab_st1 {border-bottom:1px solid #ddd; background:#fff;}
.tab_st1 a {text-align:center; color:#666; display:inline-block; font-size:15px; padding:13px 0 12px; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_dot3.png) right 18px no-repeat; background-size:1px 14px;}
.tab_st1.two a {width:49%;}
.tab_st1.three a {width:32%;}
.tab_st1.four a {width:24%;}
.tab_st1 a.active {color:#74b243; font-weight:bold;}
.tab_st1 a:last-child {background:none;}
.modal-body .cont_list .media-left .best_label {right:18px; top:4px;}
.modal-body .cont_list .media-left .best_label img {width:40px;}
.modal-body .cont_list .media-left {padding-right:14px;}
.modal-body .cont_list .info_cate {font-size:14px; padding-top:5px;}
.modal-body .cont_list .media-heading {width:100%; font-size:16px; line-height:1.4; padding-top:3px;}
.modal-body .cont_list .info_name {font-size:14px;}
.modal-body .cont_list .media {padding:0 0 13px 10px; margin-top:10px;}
.modal-body .cont_list .media-body .btn { float:right; margin:20px 8px 0 10px; padding:15px;}
.body-tit {display:block; padding:10px 0 8px 2px;}
.btn_area {text-align:center; padding:5px 0 20px 0;}
.btn_area .btn {padding:8px 30px; border:1px solid #aaa; font-size:16px; margin:0 2px; font-weight:bold;}
.btn_area .btn span {font-size:20px; color:#000; vertical-align:top; margin-right:5px; margin-top:-1px;}
.btn_area .btn:hover {border:1px solid #333;}
.btn_area .btn.active {background:#d25100; color:#fff; border:1px solid #9d430b;}
.btn_area .btn.active span {color:#fff;}
.btn_area .btn .btn_area_cont {font-size:12px; color:#999; margin-left:4px; vertical-align:text-bottom;}
.btn_area .btn.active .btn_area_cont {font-size:12px; color:#fff;}
.recipe_result {border-top:1px solid #ddd; border:1px solid #ddd; border-bottom:1px solid #ddd; margin:0 30px; width:758px;}
.recipe_result img {width:60px; height:60px; border:1px solid #ccc;}
.recipe_result th {background:#f7f7f7;}
.recipe_result th, .recipe_result td {text-align:center; font-size:13px; padding:8px 5px 9px 5px!important;}
.modal_guide { padding:10px 15px 0;}
.modal_guide.st2 {padding: 0; width:895px; margin:0 auto;}
.modal_guide .list {background:url(//recipe1.ezmember.co.kr/img/icon_dot1.gif) left 10px no-repeat; padding:0 0 18px 6px; font-size:14px; margin:0; line-height:1.8;}
.modal_guide .list:last-child {padding-bottom:0;}
.modal_guide .list span {color:#999;}
.modal_guide .list b {color:#000;}
.modal_guide .list img {margin:8px 0 0 0;}
.modal_guide .r_id {border:2px solid #f3bc13; border-radius:6px; margin:6px 0 0 0; line-height:1; padding:12px 16px; font-size:26px; color:#67a934; font-weight:bold; text-align:center;}



.panel-heading span.date {font-size:15px; color:#999; display:block;}
.panel-heading i.btn_arrow {float:right; margin-right:10px;}
.panel-heading .step_1 {font-size:15px; color:#5134cb; display:block; line-height:18px;}
.panel-heading .step_2 {font-size:15px; color:#03baff; display:block; line-height:18px;}
.panel-heading .step_3 {font-size:15px; color:#e42d70; display:block; line-height:18px;}
.panel-collapse .qna_q {background:url(//recipe1.ezmember.co.kr/img/icon_q.png) 50px 25px no-repeat; padding-left:110px;}
.panel-collapse .qna_a {background:url(//recipe1.ezmember.co.kr/img/icon_a.png) 50px 25px no-repeat; padding-left:110px;}
#contents_area .panel-body {border:none; border-left:1px solid #e6e7e8; border-right:1px solid #e6e7e8;}
#contents_area .panel-group .panel-default {border:none;}
#contents_area .panel-group .panel {border:none;}
#contents_area .panel-heading {background:#fff; border-color:#e6e7e8;}
.cs_write input, .cs_write textarea { height:40px; border:1px solid #ebebeb; background:#f5f5f5; width:860px; margin:17px; line-height:180%; font-size:16px; border-radius:0; resize:none; box-shadow:none; display:inline-block; outline-style:none;}
.cs_write input:focus, .cs_write textarea:focus {transition:none; box-shadow:none;}
.cs_write .radio-inline {margin:15px 20px 10px 25px;}
.cs_write .radio-inline input {padding:0; border:none; height:inherit; background:#fff; width:inherit; margin-top:4px;}
.cs_write	.file_search {padding:20px 30px}
.cs_write	.file_search input, .cs_write	.file_search textarea {margin:0;}
.cs_write	.file_input_textbox { font-size:14px; float:left; border:1px solid #e6e7e8; background:#f1f1f2; width:660px; height:40px; padding:6px 20px;}
.cs_write	.file_input_div {position:relative; width:120px; height:40px; overflow:hidden;}
.cs_write	.file_input_img_btn {padding:0 0 0 5px; width:120px; height:40px;}
.cs_write	.file_input_hidden {position:absolute; right:0px; top:0px; opacity:0; filter: alpha(opacity=0); -ms-filter: alpha(opacity=0); cursor:pointer;}
.cs_write	.write_btn {text-align:center; padding:30px 0 50px;}
.cs_write .write_pic {background:url(//recipe1.ezmember.co.kr/img/img_pic.gif) center no-repeat; height:480px; padding:20px 16px;}
.cs_write .write_pic2 {background:url(//recipe1.ezmember.co.kr/img/img_pic2.gif) center no-repeat; padding:20px 16px;}
.cs_write .write_pic3 {background:url(//recipe1.ezmember.co.kr/img/img_pic3.gif) center no-repeat; padding:20px 16px;}
.cs_write .write_pic4 {background:url(//recipe1.ezmember.co.kr/img/img_pic4.gif?v.1) 260px center no-repeat; padding:20px 16px;}
.cs_write .write_pic5 {background:url(//recipe1.ezmember.co.kr/img/img_pic5.gif?v.1) center no-repeat; padding:20px 16px;}
.cs_write .write_pic_n {padding:20px 16px;}
.cs_write .write_pic_r {padding:20px 16px; text-align:center;}
.write_pic_n #add_banner {width:425px; height:165px; background:#f7f7f7; border:1px solid #e1e1e1; color:#aaa; text-align:center; font-size:24px; padding-top:60px; display:inline-block; position:relative;}
.write_pic_n #add_thumb {width:380px; height:125px; background:#f7f7f7; border:1px solid #e1e1e1; color:#aaa; text-align:center; font-size:24px; padding-top:44px; display:inline-block; position:relative;}
.write_pic_n #add_alim {width:125px; height:125px; background:#f7f7f7; border:1px solid #e1e1e1; color:#aaa; text-align:center; font-size:24px; padding-top:44px; display:inline-block; position:relative;}
.write_pic_n #add_sns {width:238px; height:125px; background:#f7f7f7; border:1px solid #e1e1e1; color:#aaa; text-align:center; font-size:24px; padding-top:44px; display:inline-block; position:relative;}
.write_pic_n #add_banner_web {width:600px; height:100px; background:#f7f7f7; border:1px solid #e1e1e1; color:#aaa; text-align:center; font-size:24px; padding-top:32px; display:inline-block; position:relative;}
.write_pic_n #add_banner_mob {width:250px; height:208px; background:#f7f7f7; border:1px solid #e1e1e1; color:#aaa; text-align:center; font-size:24px; padding-top:90px; display:inline-block; position:relative;}
.write_pic_n_noti {display:inline-block; vertical-align:top; color:#999; margin:5px 0 0 10px; width:415px; line-height:1.5;}
.write_pic_n_noti.st2 {width:100%; margin-top:10px;}
.write_pic_n_noti b {display:block; font-size:16px; color:#333; padding-bottom:5px;}
.write_pic_n .banner_area { position:relative; border:1px solid #e1e1e1; display:inline-block;}
.write_pic_n .thumb_area { position:relative; border:1px solid #e1e1e1; display:inline-block;}
.write_pic_n input {margin:15px 0 0 0;}
.write_pic_n_noti .btn-default {font-size:12px; border-radius:0; margin-top:12px;}
.write_pic_n_noti span {color:#C00; margin-top:8px; display:block; font-size:12px; line-height:1.6;}
.write_pic_btn {width:32px; height:32px; filter:alpha(opacity=70); opacity:0.7; margin-top:-16px; padding:0; border:0; -webkit-box-shadow:0 1px 2px rgba(0, 0, 0, 0.4); box-shadow:0 1px 2px rgba(0, 0, 0, 0.4);}
.write_pic_btn.p_left {position:absolute; left:0; top:50%; border-radius:0 12px 12px 0;}
.write_pic_btn.p_right {position:absolute; right:0; top:50%; border-radius:12px 0 0 12px;}
.write_pic_btn span {font-size:20px;}

.cs_write.st2 {width:100%;}
.cs_write.st2 table {display:inline-block; vertical-align:top; width:620px; margin:20px 30px 15px 40px;}
.cs_write.st2 table th {width:162px; border-bottom:1px dashed #ddd; padding:10px 0 10px 10px; font-size:17px;}
.cs_write.st2 table td {padding:10px 10px 10px 0; border-bottom:1px dashed #ddd; font-size:15px;}
.cs_write.st2 table tr:last-child th {border:none;}
.cs_write.st2 table tr:last-child td {border:none;}
.cs_write.st2 input {margin:0;}
.write2_pic { display:inline-block; margin-top:30px;}
.write2_pic img {border:1px solid #ddd;}
.write2_pic p {font-size:13px; color:#aaa; text-align:center; margin:0; padding:8px 0 0 0;}
.write2_noti {padding:20px 30px; background:#fffbdd; font-size:15px; border-right:1px solid #e6e7e8; border-left:1px solid #e6e7e8; color:#888; line-height:1.8;}
.write2_noti a {text-decoration:underline; color:#06F; font-weight:bold;}


#goods_list table th, #recipe_list table th {background:#fffee8; text-align:center; border-bottom:0;}
#goods_list table td, #recipe_list table td { vertical-align:middle; text-align:center;}
#goods_list, #recipe_list {padding-bottom: 5px; margin:0 20px; display:block;}
#goods_list .btn-sm, #recipe_list .btn-sm {margin-bottom:3px;}

.chef_cont .top_title {border-top:2px solid #666; border-bottom:1px solid #e6e7e8; position:relative; padding:18px 10px; margin:12px 0 10px; font-size:20px; font-weight:bold;}
.chef_cont .top_title_r {position:absolute; right:0; top:16px;}
.chef_cont .top_title_r .btn {border-radius:0; padding:0 15px; margin-right:6px; height:34px; color:#666; font-weight:normal;}
.chef_cont .top_title_r .btn-lg {border-radius:0; padding:5px 13px 4px 12px; margin:0; height:34px;}
.chef_cont .top_title_r .btn-group {margin-left:5px;}
.chef_cont .top_title_r .btn .glyphicon {color:#ccc; width:16px; }
.chef_cont .top_title_r .active {background:#6a6f74; border-color:#6a6f74;}
.chef_cont .top_title_r .active .glyphicon {color:#fff;}
.chef_cont .nav-tabs3 .btn-lg {position:absolute; right:4px; top:-4px; padding:7px 35px; font-size:24px;}

.cont_list .list_check {text-align:center; margin:-10px 0 30px;}
.cont_list .media .list_check {padding:80px 15px 0 0;}
.cont_list .media {border-bottom:1px solid #e6e7e8; padding:4px 0 20px 20px; position:relative;}
.cont_list .media-left {padding-right:26px; position:relative;}
.cont_list .media-left .best_label {position:absolute; right:42px; top:6px; z-index:10;}
.cont_list .media-left .vod_label {position:absolute; right:42px; bottom:6px; z-index:10;}
.cont_list .media-left .vod_label img {width:40px;}
.cont_list .media-left .vod_label2 {position:absolute; left:62px; top:62px; z-index:10;}
.cont_list .media-left .vod_label2 img {width:56px;}
.cont_list .info_cate {font-size:20px; color:#74b243; padding-top:20px;}
.cont_list .info_cate2 {padding:8px 0 12px 0;}
.cont_list .media-heading {font-size:28px; width:540px; line-height:35px; padding-top:20px;}
#list_list .media-heading {width:100%; padding-top:6px;}
.cont_list .info_name {font-size:18px; color:#999; padding-top:6px;}
.cont_list .info_name span {margin-left:10px;}
.cont_list .panel-group {padding-top:8px;}
.cont_list .panel-heading {border:1px solid #e6e7e8;}
.cont_list .panel-body {border-top:none !important; border-bottom:1px solid #e6e7e8 !important;}
.cont_list .info_thumb {margin:0 0 6px 0; padding:18px 0 0 0; width:400px;}
.cont_list .info_thumb li {display:inline-block; border:1px solid #ddd; margin:0 0 4px 0; padding:0;}
.cont_list .info_thumb li img {width:60px; height:60px;}
.cont_list .media-body .list_clock {font-size:13px; color:#888; margin:5px 0 -5px 0;}
.cont_list .media-body .list_clock img {margin-right:4px;}
.btn_event {background:#ffea3d; position:absolute; right:0; bottom:20px; color:#333; font-size:16px; border-radius:0;}
.btn_event span {vertical-align:text-top; margin:1px 5px 0 0; color:#ff4747;}
.btn_event.active, .btn_event.focus, .btn_event:active, .btn_event:focus, .btn_event:hover, .open>.dropdown-toggle.btn_event  {background:#fff074;}
.btn_event2 {background:#fff; position:absolute; right:0; bottom:20px; color:#333; font-size:16px; border-radius:0;}
.btn_event2 span {vertical-align:text-top; margin:1px 5px 0 0; color:#ff4747;}
.btn_event2.active, .btn_event2.focus, .btn_event2:active, .btn_event2:focus, .btn_event2:hover, .open>.dropdown-toggle.btn_event2  {background:#fbfbfb;}
.btn_event3 {position:absolute; right:0; bottom:20px;}
.btn_event3 .btn-lg {background:#fff; color:#333; font-size:14px; border-radius:0; padding:8px 24px 0; height:41px; border:2px solid #dcdcdc; display:inline-block; vertical-align:top; margin-left:10px;}
.btn_event3 .btn-lg span {vertical-align:bottom; margin:0 4px 0 0; color:#77b347; font-size:16px;}
.event_list {margin:0 10px 20px;}
.event_list .media .list_check {padding:80px 15px 0 0;}
.event_list .media {border-bottom:1px dashed #ddd; padding:5px 0 20px 10px;}
.event_list .media-left {padding-right:28px; vertical-align: middle;}
.event_list .media-left img {-webkit-box-shadow:0 2px 2px rgba(0, 0, 0, 0.2); box-shadow:0 2px 2px rgba(0, 0, 0, 0.2);}
.event_list .media-body {vertical-align: middle;}
.event_list .info_cate {color:#4a89dc; padding-right:5px;}
.event_list .info_cate.st2 {color:#12a148;}
.event_list .info_cate.st3 {color:#a35903;}
.event_list .info_cate2 {color:#589726; font-size:16px; font-weight:bold; padding:0 0 5px 0; display:block;}
.event_list .media-heading {font-size:26px; padding-top:6px; width:380px; line-height:1.2; word-break:break-all;}
.event_list .media-heading2 {font-size:22px; line-height:30px; word-break:break-all; margin-top:0;}
.event_list .info_name {font-size:18px; color:#999;}
.event_list2 {margin:0; padding:0;}
.event_list2 li {border-bottom:1px solid #d5d6d7; list-style:none; margin:0; padding:20px 18px 17px 25px; font-size:16px;}
.event_list2 li input {vertical-align:text-bottom; width:18px; height:18px; margin:0 8px 1px 0;}
.event_list2 li a {vertical-align:text-bottom; margin:0 0 2px 5px;}
.event_list2 li a img {vertical-align:text-bottom}
.event_list2 li .btn {}
.event_list2 li .btn-primary {background:#f0aa15; border:1px solid #d4940c;}
.event_list2 li p {float:right; margin:-2px 0 0 0; font-size:14px; padding:5px 15px 6px; border-radius:8px;}
.sub_list_tit {font-size: 28px; border-bottom: 1px solid #d6d6d6; margin: 70px 10px 0; padding: 0 8px 20px;}

.talk_cont {padding:20px 47px 20px;  width:895px;}
.talk_cont.st2 {padding:20px 22px 20px;  width:895px;}
.talk_cont img {max-width:800px;}
.talk_cont p {margin-bottom:0;}

.chef_cont .note_top {background:url(//recipe1.ezmember.co.kr/img/note_bg_t.gif) left top no-repeat; height:45px; font-size:20px; color:#666; text-align:right; padding:18px 22px 0 0; vertical-align:middle; margin-top:10px;}
.chef_cont .note_top a {margin-right:10px;}
.chef_cont .note_body {background:url(//recipe1.ezmember.co.kr/img/note_bg.gif) left top repeat-y; padding:0 20px 0 56px; line-height:50px; font-size:20px;}
.chef_cont .note_btm {background:url(//recipe1.ezmember.co.kr/img/note_bg_b.gif) left top no-repeat; height:118px; padding:17px 22px 0 0; text-align:right;}
.chef_cont .note_btm span {display:inline-block; vertical-align:middle; margin-right:20px; font-size:22px; color:#666; line-height:28px; width:330px;}
.chef_cont .note_btm img {vertical-align:middle;}



.chef_list4 {padding:30px 21px 30px;}
.chef_list4 .nav-tabs3 {margin-bottom:15px;}
.chef_list4 .my_nav2 {margin:0; border-top:1px solid #d2d2d2; background:#efefef; padding:0;}
.chef_list4 .my_nav2 li {display:table-cell; width:1%; text-align:center; font-size:16px; border-right:1px solid #d2d2d2; border-bottom:1px solid #d2d2d2;}
.chef_list4 .my_nav2 li:last-child {border-right:0;}
.chef_list4 .my_nav2 li a {padding:12px 0; color:#999; display:inline-block; width:100%; }
.chef_list4 .my_nav2 li.active {border-bottom:1px solid #fff;}
.chef_list4 .my_nav2 li.active a {color:#4a9c08; font-weight:bold; background:#fff;}
.chef_list_top img {max-width:100%;}
.my_nav2_sub {background:#fff; border-bottom:1px solid #d4d4d4; height:45px; font-size:13px;}
.my_nav2_sub p {font-weight:bold; padding:11px 0 0 20px; display:inline-block;}
.my_nav2_sub .dropdown .btn {font-size:15px; color:#999; border:0; padding:11px 12px; background:#fff;}
.my_nav2_sub .dropdown .btn span {margin-right:4px; font-size:16px; vertical-align:text-bottom;}
.chef_list4_in {background:#fff; padding:2px;}
.chef_list4_in .list_lump {padding:18px 5px; border-bottom:1px solid #e6e7e8;}
.chef_list4_in .list_mem3 {display:inline-block; vertical-align:middle; padding-right:10px;}
.chef_list4_in .list_mem3 .mem_pic {display:inline-block; vertical-align:top;}
.chef_list4_in .list_mem3 .mem_pic img {width:70px; height:70px; border-radius:50%;}
.chef_list4_in .list_cont4 {display:inline-block; vertical-align:middle;}
.chef_list4_in .list_cont4 b {display:block; padding-bottom:6px;}
.chef_list4_in .list_cont4 b a {color:#de4830; font-size:18px; font-weight: normal;}
.chef_list4_in .list_cont4 .btn-sm {font-size:13px; padding:4px 8px; margin:-2px 0 2px 6px;}
.chef_list4_in .mem_cont1 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_fork.png) left 1px no-repeat; background-size:18px; padding:0 0 1px 21px; font-size:15px; color:#888; margin-right:20px; letter-spacing:-0.02em;}
.chef_list4_in .mem_cont2 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_mem.png) left 1px no-repeat; background-size:18px; padding:1px 0 1px 21px; font-size:15px; color:#888; margin-right:20px; letter-spacing:-0.02em}
.chef_list4_in .mem_cont3 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_scrap.png) left 1px no-repeat; background-size:18px; padding:1px 0 1px 21px; font-size:15px; color:#888; margin-right:20px; letter-spacing:-0.02em}
.chef_list4_in .mem_cont7 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_view3.png) left 1px no-repeat; background-size:18px; padding:1px 0 1px 22px; font-size:15px; color:#888; margin-right:20px; letter-spacing:-0.02em}
.list_ranking2 {width:170px; line-height:1; display:inline-block; vertical-align:middle;}
.list_ranking2_num { width:90px; text-align:right; font-size:32px; color:#000; font-weight:900; margin:0 0 4px 0; display:inline-block; letter-spacing:-0.05em;}
.list_ranking2_num.txt4 {font-size:14px;}
.list_ranking2_num2 {font-size:13px; margin:0 0 2px 10px; display:inline-block; vertical-align:super;}
.list_ranking2_num2 span {padding-right:4px; vertical-align:text-top;}





.recipe_regi {}
.regi_left {width:550px; display:inline-block; border:1px solid #e6e7e8; border-right:1px solid #b2b2b2; background:#fff; vertical-align:top; margin:0; padding:0;}
.regi_right {width:690px; display:inline-block; border:1px solid #e6e7e8; background:#fff; margin:0; padding:0; float:right; }
::i-block-chrome, .regi_right {width:686px;}
.regi_center {width:1500px; border:1px solid #e6e7e8; background:#fff; margin:0; padding:0;}
.regi_title {background:#f8f8f8; border-bottom:1px solid #e6e7e8; padding:14px 18px; font-size:20px; font-weight:bold; position:relative;}
.regi_title span {font-size:12px; color:#C00; padding-left:10px;}
.regi_title .tit_right a { margin-left:10px;}
.regi_title .tit_right {float:right; padding:0; margin:-4px 0 0 0;}
.regi_title_r {position:absolute; right:350px; bottom:0; margin:0; padding:0;}
.regi_cont {height:1000px; overflow-y:scroll; overflow-x: hidden}
.regi_left .regi_cont {padding:15px;}
.regi_cont div:last-child {border:none;}
.cont_box {padding:26px 30px; border-bottom:10px solid #f1f1f2; margin:0 -1px;}
.cont_box input {background:#f5f5f5; border:1px solid #e1e1e1; font-size:16px; padding-left:15px; height:50px; vertical-align:middle; margin-top:-1px;}
.cont_box select {background:#f5f5f5; border:1px solid #e1e1e1; font-size:16px; padding:8px 2px; margin:0 2px 0 0; border-radius:4px;}
::i-block-chrome, .cont_box select {padding:0px 12px;}
.cont_box li input {display:inline-block; margin:0 3px; vertical-align:middle;}
.cont_pic {width:170px; float:right; text-align:center;}
.cont_pic p {margin:0 0 0 0 !important;}
.cont_pic img {border:1px solid #e1e1e1;}
.cont_pic2 {width:250px; float:right; margin-right:60px;}
.cont_pic2 img {border:1px solid #e1e1e1;}
.cont_pic3 {width:250px; margin:0 10px;}
.cont_pic3 img {border:1px solid #e1e1e1;}
.cont_box p {font-size:20px; padding:0 0 0 2px; margin:0 0 22px 0; line-height:50px;  display:inline-block;}
.cont_box p label {font-weight:normal; display:inline-block; font-size:18px;}
.cont_box .guide {font-size:14px; display:inline-block; line-height:1.8; margin-top:6px; color:#999; background:url(//recipe1.ezmember.co.kr/img/icon_tip.png) left 2px no-repeat; padding:0 0 0 20px; vertical-align:top;}
.cont_box .cont_tit {width:100px; display:inline-block; font-size:20px; font-weight:normal; vertical-align:top;}
.cont_box .cont_tit2 {width:100px; display:inline-block; font-size:30px; font-weight:normal; vertical-align:top; color:#74b243;}
.cont_box .cont_tit2_1 {width:120px; display:inline-block; font-size:30px; font-weight:normal; vertical-align:top; color:#74b243; margin-left:70px;}
.cont_box .cont_tit3 {font-size:20px; font-weight:normal; margin:0; width:100%;}
.cont_box .cont_tit4 {width:140px; display:inline-block; font-size:20px; font-weight:normal; vertical-align:top;}
.cont_box .cont_tit4.st2 {width:140px; display:block; font-size:20px; font-weight:normal; vertical-align:top; margin:0;}
.cont_box .cont_tit4.st3 {margin:0;}
.cont_box .cont_tit4.st4 {width:100%; margin-bottom:10px;}
.cont_box .cont_tit4.st4 a {margin-left:15px;}
.cont_box .cont_tit5 {width:140px; display:inline-block; font-size:20px; font-weight:normal; vertical-align:top; padding-left:20px}
.cont_box .cont_tit6 {width:230px; display:inline-block; font-size:20px; text-align:center; vertical-align:top; margin-left:-16px;}
.cont_box .cont_tit6.st2 {width:250px;}
.cont_tit6 .cont_tit_btn {display:block; margin:10px 0 0 34px; text-align:center; line-height:1;}
.cont_tit6 .cont_tit_btn .btn-sm {margin:0 2px;}
.cont_box .cont_tit6 input {background:#fffdd7; display:inline-block;}
.cont_box .noti {color:#f43434; font-size:13ppx; text-align:center; border-top:1px solid #e4e4e4!important; padding-top:15px;}
.cont_box .noti_btn {margin:15px 0 6px 0;}
.cont_box ul {display:inline-block;}
.cont_box ul, .cont_box li {list-style:none; margin:0; padding:0;}
.cont_box li {margin-bottom:8px;}
.cont_box .btn-del { background:url(//recipe1.ezmember.co.kr/img/btn_del2.gif) center no-repeat; display:inline-block; width:30px; height:30px; vertical-align:middle;}
.cont_box .btn-lineup { background:url(//recipe1.ezmember.co.kr/img/btn_lineup.gif) center no-repeat; display:inline-block; width:30px; height:30px; vertical-align:middle;}
.note-editor p {font-size:16px; line-height:200%; margin:0;}
.note-editor ul {display:none;}
.note-editor .btn {margin:0; height:30px;}
.note-editor .btn-sm, .btn-group-sm > .btn {line-height :1.5; padding:5px 10px;}
.note-editor .btn-group > .btn:last-child:not(:first-child), .note-editor .btn-group > .dropdown-toggle:not(:first-child)
{border-top-left-radius:0; border-bottom-left-radius:0}
.cont_box_table {margin:0; display:block;}
.cont_box_table table th {background:#fffee8; text-align:center; border-bottom:0;}
.cont_box_table table td { vertical-align:middle; text-align:center;}
.cont_box_table .btn-sm {margin-bottom:3px;}


.btn_add {text-align:center;}
.btn_add .btn {border:none; background:none; margin:10px 0 0 0; padding:0; font-size:16px; color:#444;}
.btn_add .btn span {color:#74b243; font-size:16px; margin-right:4px;}
.step {display:inline-block; margin:6px 0;}
.step img {border:1px solid #e1e1e1; display:inline-block; vertical-align:middle;}
.step a img {border:none;}
#stepForm_material_1 img, #stepForm_cooker_1 img, #stepForm_fire_1 img, #stepForm_tip_1 img {border:none;}
.step_cont {display:inline-block; vertical-align:middle; background:#f5f5f5; border:1px solid #e1e1e1; font-size:16px; line-height:25px;}
.cont_line .thumb_m {display:inline-block; margin-left:10px;}
.step_btn {display:inline-block; vertical-align:middle;}
.step_btn a {width:30px; height:30px; background:#eee; color:#999; display:block; font-size:13px; text-align:center; margin:1px; padding-top:5px;}
.step_btn a:hover, .step_btn a:active, .step_btn a.active {background:#53961f; color:#fff;}
.step_btn a  span {padding-top:2px;}
.complete_pic.st2 {width:190px; height:190px; margin:0 4px;}
.complete_pic {position:relative; width:140px; height:140px; display:inline-block; margin:0 4px 8px; vertical-align:top;}
.pic_del {position:absolute; right:0; top:0; display:block; filter:alpha(opacity=60); opacity:0.6; background:url(//recipe1.ezmember.co.kr/img/btn_del3.gif) left top no-repeat; width:30px; height:30px; z-index:10000;}
.complete_pic img {border:1px solid #e1e1e1;}
.regi_btm {border:1px solid #e6e7e8; background:#fff; text-align:center; padding:35px 0 40px 0; border-top:none;}
.regi_btm .btn-lg {padding:12px 50px;}
.cont_line {width:800px; padding:8px 0 0 0;}
.cont_line input {display:inline-block;}
.cont_line .cont_check {vertical-align:middle; height:35px; margin:4px;}
.box_left {width:890px; border-right:1px solid #ebebeb; display:inline-block; padding:15px 45px 30px; border-bottom:none; vertical-align:top;}
.box_right {width:348px; display:inline-block; padding:25px 40px; border-bottom:none; vertical-align:top; text-align:center;}
::i-block-chrome, .box_right {width:344px;}
.write_noti {background:url(//recipe1.ezmember.co.kr/img/icon_drag.gif) center top no-repeat; padding-top:76px; margin:20px auto 10px; font-size:14px; color:#999; width:250px;}
.write_thumb {width:270px; margin:0 auto;}
.write_thumb li {background:#f1f1f1; border:1px solid #eaeaea; width:85px; height:85px; margin:3px 1px; display:inline-block; vertical-align:top;}
.write_thumb li img {width:83px; height:83px;}
.btn_blue {background:#44b6b5; border:1px solid #34a5a4;}
.btn_blue:focus, .btn_blue:hover {background:#35aead; border:1px solid #30a09f;}
.write_layer { position:absolute; right:0; top:65px; width:372px; height:171px; background:url(//recipe1.ezmember.co.kr/img/bg_layer2.png) left top no-repeat; padding:24px 12px 12px 12px; z-index:1000000;}
.write_layer a {width:174px; display:inline-block; margin:0 !important; text-align:center;}
.write_layer img {width:82px !important; height:82px !important;}
.w_layer2 {border-right:1px solid #ebebeb; z-index:10000;}
.w_layer3 {}
.write_layer span {background:#f8f8f8; border-top:1px solid #ebebeb; display:block; color:#444; font-size:16px; font-weight:bold; padding:8px 0; margin-top:14px;}
.w_layer2 span {border-right:1px solid #ebebeb; }
.navbar-right li img {width:42px; height:42px; border-radius:50%;}
.mem_layer {position:absolute; left:-63px; top:65px; width:182px; z-index:1000000;}
.mem_layer p {padding:0; margin:0;}
.mem_layer_t {background:url(//recipe1.ezmember.co.kr/img/bg_layer3_t.png) left top no-repeat; height:11px;}
.mem_layer_m {background:url(//recipe1.ezmember.co.kr/img/bg_layer3_bg.png) left top repeat-y;}
.mem_layer_m a {border-bottom:1px solid #ebebeb; padding:12px 0 !important; text-align:center; display:block; margin:0 12px !important; font-size:15px; height:auto}
.mem_layer_m a:hover, .mem_layer_m a:active {background:#f9f9f9;}
.mem_layer_b {background:url(//recipe1.ezmember.co.kr/img/bg_layer3_b.png) left top no-repeat; height:12px;}
.rmenu_top {width:50px; height:50px; position:fixed; right:28px; bottom:28px; border:1px solid #d0d0d0; color:#111; font-size:20px; text-align:center; padding-top:13px; z-index:1000000;}

.myhome_list {background:#fff; padding:25px 25px 0 40px;}
.myhome_list a {display:inline-block; text-align:center; color:#000; font-size:16px; line-height:15px; padding-bottom:28px;}
.myhome_list.three {text-align:center; padding:25px 40px 0;}
.myhome_list.three a {width:24%;}
.myhome_list.four a {width:24%;}
.myhome_list.five a {width:19.5%;}
.myhome_list.six a {width:16%;}
.myhome_icon {background:url(//recipe1.ezmember.co.kr/img/icon_myhome.png?v.0911) no-repeat; background-size:80px auto; display:block; width:80px; height:83px; margin:0 auto 10px;}
.myhome_icon.icon_view {background-position:left top;}
.myhome_icon.icon_scrap {background-position:center -83px;}
.myhome_icon.icon_write {background-position:center -166px;}
.myhome_icon.icon_copyshot {background-position:center -249px;}
.myhome_icon.icon_idea {background-position:center -332px;}
.myhome_icon.icon_note {background-position:center -415px;}
.myhome_icon.icon_menu {background-position:center -830px;}
.myhome_icon.icon_talk {background-position:center -581px;}
.myhome_icon.icon_diary {background-position:center -664px;}
.myhome_icon.icon_alim {background-position:center -747px;}
.myhome_icon.icon_recipe {background-position:center -498px;}
.myhome_icon.icon_product {background-position:center -913px;}
.myhome_icon.icon_event {background-position:center -996px;}
.myhome_icon.icon_chef1 {background-position:center -1079px;}
.myhome_icon.icon_chef2 {background-position:center -1162px;}
.myhome_icon.icon_chef3 {background-position:center -1245px;}
.myhome_icon.icon_qna {background-position:center -1328px;}
.myhome_icon.icon_chef4 {background-position:center -1411px;}
.myhome_icon.icon_chef5 {background-position:center -1494px;}
.myhome_main_t {height:150px; margin:0 auto; padding-top:22px;  position:relative; border-bottom:1px solid #ddd;}
.myhome_main_info {text-align:center; margin-top:-70px; padding-bottom:5px;}
.myhome_main_info .info_pic, .myhome_main_t .info_pic {display:inline-block; vertical-align:top; position:relative; padding:4px; margin:0 auto; background:url(//recipe1.ezmember.co.kr/img/mobile/shop_bg_name.png) left top; border-radius:50%;}
.myhome_main_info .info_pic img, .myhome_main_t .info_pic img {width:110px; height:110px; border-radius:50%;}
.myhome_main_info .info_set, .myhome_main_t .info_set {position:absolute; right:-2px; top:-2px;}
.myhome_main_info .info_set img, .myhome_main_t .info_set img {width:42px; height:42px;}
.myhome_main_info .info_name {margin:0; color:#777; font-size:12px; line-height:1.5; margin-top:5px;}
.myhome_main_info .info_name b {font-size:18px; display:block; color:#000;}
.myhome_main_info .btn-default {font-size:14px; background:none; border:2px solid #ccc; border-radius:20px; color:#ccc; font-weight:bold; padding:7px 20px 8px; margin-top:15px;}
.myhome_main_info .btn-default span {font-weight:normal; padding-right:2px;}
.myhome_main_info .info_follow {border-top:1px solid #ddd; border-bottom:1px solid #ccc; float:left; width:100%; margin-top:20px; list-style:none; padding:0}
.myhome_main_info .info_follow  li {font-size:14px; font-weight:bold; width:50%; float:left; text-align:left; padding:14px 20px;}
.myhome_main_info .info_follow  li:first-child {border-right:1px solid #ddd;}
.myhome_main_info .info_follow span {float:right; display:inline-block; font-family: Myriad Pro; font-size:18px; margin-top:-3px;}
.myhome_main_info .info_follow2 {margin-top:10px; color:#333;}
.myhome_main_info .info_follow2 b {margin-left:4px; font-family:'Poppins', 'Nanum Gothic';}
.myhome_main_info .info_follow2 span {margin:0 8px; font-weight:bold; color:#999;}
.myhome_main_info .myhome_intro {padding:10px 0 2px 4px; color:#ddd; line-height:1.5;}
.myhome_main_info .myhome_intro a {color:#999; text-decoration:underline;}
.myhome_main_info .myhome_intro img {width:14px; margin:0 4px 0 0;}

.view_profile {padding:0 50px 6px; margin-top:-6px;}
.profile_pic {display:table-cell; vertical-align:top; padding-right:14px;}
.profile_pic img {border-radius:50%; width:80px; border:1px solid #ddd;}
.profile_cont {display:table-cell; padding:5px 0; vertical-align:middle;}
.profile_cont .cont_name {margin:0 0 6px 0; font-size:17px; color:#000; font-weight:bold;}
.profile_cont .btn-default {font-size:13px; background:none; border:1px solid #51c351; border-radius:20px; color:#51c351; font-weight:bold; padding:3px 16px 4px; margin:-3px 0 0 8px;}
.profile_cont .btn-default span {font-size:12px; font-weight:normal; padding-right:2px;}
.profile_cont .cont_intro {color:#777; font-size:15px; line-height:1.5; margin:0;}

.myhome_num {padding-top:8px; font-size:14px; color:#888; display:block;}
.myhome_history {padding:20px 40px 0; border:1px solid #e6e7e8; margin:20px 21px 0; background:#f1f1f2;}
.myhome_history.st2 {margin:15px 20px 0; border:none; background:none; padding:0;}
.myhome_history dt {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_history.png) left top no-repeat; background-size:30px; padding:2px 0 4px 36px; font-size:18px; font-weight:bold; color:#000; line-height:24px;}
.myhome_history.st2 dt {background:url(//recipe1.ezmember.co.kr/img/icon_ranking.png) left top no-repeat; padding:8px 0 4px 52px; font-size:24px; color:#000; line-height:1; height:45px;}
.myhome_history dd {padding-top:14px; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_history_bg.png) 11px top repeat-y; background-size:6px auto;}
.myhome_history.st2 dd {padding:14px 0 10px 0; background:url(//recipe1.ezmember.co.kr/img/icon_ranking_bg.png) 20px top repeat-y;}
.history_list {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_history3.png) 5px 5px no-repeat; background-size:38px auto; padding-left:43px; padding-bottom:26px;}
.myhome_history.st2 .history_list {background:url(//recipe1.ezmember.co.kr/img/icon_ranking2.png) 12px 5px no-repeat; padding-left:65px; padding-bottom:26px; position:relative;}
.myhome_history.st2 .history_list_arw {position:absolute; left:39px; top:12px;}
.history_list_in {background:#fff; border-radius:5px; padding:15px 18px 35px; font-size:16px; color:#999; line-height:18px;}
.myhome_history.st2 .history_list_in {background:#fbfbfb; border-radius:5px; padding:15px 18px 35px; font-size:16px; color:#999; border:1px solid #ebebeb; line-height:18px;}
.history_list_in .list_thumb {float:right; margin-left:20px;}
.history_list_in .list_thumb img {width:60px; height:60px;}
.history_list_in .list_tit {font-weight:normal; color:#000;}
.history_list_in .list_time {display:block; padding-top:4px; font-size:14px;}
.history_more {background: #fbfbfb; padding: 15px 0 14px; text-align:center; font-size:16px; font-weight:bold; color: #333; margin:0 21px 20px;border: 1px solid #ebebeb;}
.history_more.st2 {margin:0 20px 20px;}
.history_more a {color:#333; display:block;}
.history_more span {vertical-align:text-top; margin-left:10px;}
.history_more2 {padding:10px 0; text-align:center; font-size:16px; font-weight:bold; color:#fff; margin:0 30px 20px;}
.history_more2 a {color:#aaa; display:inline-block; padding:0 30px;}
.history_more2 span {vertical-align:text-top; margin-left:10px;}
.history_list .list_mem {}
.chef_list .list_mem {padding:0 0 0 5px; display:inline-block; vertical-align:top;}
.modal-body .list_mem {padding:0 0 0 5px; display:inline-block; vertical-align:top;}
.chef_list .list_mem2 {padding:0 0 0 5px; display:inline-block; vertical-align:top;}
.list_mem .mem_pic {position:relative; display:inline-block; vertical-align:top;}
.list_mem .mem_pic img {width:66px; height:66px; border-radius:50%; margin-right:0!important;}
.list_mem .mem_pic_lv {position:absolute; right:-1px; bottom:-1px;}
.list_mem .mem_pic_lv img {width:24px!important; height:20px!important; border-radius:noen; margin-right:0!important;}
.list_mem2 .mem_pic {position:relative; display:inline-block; vertical-align:top;}
.list_mem2 .mem_pic img {width:60px; height:60px; border-radius:50%;}
.list_mem2 .mem_pic_lv {position:absolute; right:-1px; bottom:-1px;}
.list_mem2 .mem_pic_lv img {width:24px; height:20px; border-radius:noen;}
.list_title {font-size:14px; border-bottom:1px solid #dedfe0; color:#3d8901; padding:9px 0 8px 20px; font-weight:bold; margin-bottom:5px;}
.list_mem_btn {float:right; margin:3px 10px 0 0;}
.list_mem_btn img {width:56px; height:32px;}
.list_sns {width:100%; text-align:center; padding:15px 0 30px 0; border-bottom:1px solid #e4e4e4;}
.list_sns a {background-size:77px; width:22%; display:inline-block; padding-top:80px; text-align:center; color:#444; line-height:20px; font-weight:bold; margin:0 5px;}
.list_sns_k {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_sns3_k.png) center top no-repeat; }
.list_sns_f {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_sns3_f.png) center top no-repeat; }
.list_sns_sms {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_sns3_sms.png) center top no-repeat; }
.search_input2 {padding:10px 12px; height:55px; background:#f7f7f7; border-bottom:1px solid #eaeaea;}
.search_input2 .input-group {display:block;}
.search_input2_in {display:inline-block; position:relative; width:68%; background:#fff; width:-webkit-calc(100% - 102px); width:-moz-calc(100% - 102px); width:calc(100% - 102px);}
.search_input2 .form-control {border-radius:0 !important; height:34px;}
.search_input2 .form-control.st2 {width:100%;}
.search_input2 .btn {background:#74b243; border:none; width:90px; height:34px; padding:0 0 3px 0 ; margin:0 0 0 5px; vertical-align:top;}
.search_input2 .btn span {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_chef5.png) left top no-repeat; background-size:17px auto; padding-left:20px; color:#2b4106; font-size:12px; font-weight:bold;}

.ranking_cont {padding:0 20px 15px;}
.ranking_top {margin:0 0 0 -19px;}
.ranking_box {padding:10px 0 0 19px;}
.ranking_box.st2 {padding:120px 0 10px 39px; margin:20px -20px -35px -20px; background:#582f29; position:relative;}
.ranking_box.st2.ea3 a {width:260px; text-align:center; padding:26px 0;}
.ranking_box.st2.ea3 p {margin:10px 0 0 0; width:100%;}
.ranking_box.ea3 a {width:260px;}
.ranking_box.ea4 a, .ranking_box.ea2 a {width:397px;}
.ranking_box.ea5 a {width:260px;}
.ranking_box.ea5 a:nth-child(1), .ranking_box.ea5 a:nth-child(2) {width:397px;}
.ranking_box.ea6 a {width:260px;}
.ranking_box.ea7 a {width:397px;}
.ranking_box.ea7 a:nth-child(5), .ranking_box.ea7 a:nth-child(6), .ranking_box.ea7 a:nth-child(7) {width:260px;}
.ranking_box.ea8 a {width:260px;}
.ranking_box.ea8 a:nth-child(7), .ranking_box.ea8 a:nth-child(8) {width:397px;}
.ranking_box.ea9 a {width:260px;}
.ranking_box.ea10 a {width:260px;}
.ranking_box.ea10 a:nth-child(7), .ranking_box.ea10 a:nth-child(8), .ranking_box.ea10 a:nth-child(9), .ranking_box.ea10 a:nth-child(10) {width:397px;}
.ranking_box a {border:1px solid #ddd; background:#fff; border-radius:8px; display:inline-block; padding:20px; margin:0 5px 10px 5px; width:397px;}
.ranking_box a img {width:100px; height:100px; display:inline-block;}
.ranking_box.st2 a {width:397px; background:#fdf5e1;}
.ranking_box p {margin:0 0 0 10px; width:240px; color:#888; font-size:14px; display:inline-block; vertical-align:middle;}
.ranking_box b {color:#000; font-size:18px; display:block; margin-bottom:2px;}
.ranking_box b img {width:24px; height:24px; vertical-align:text-bottom;}
.ranking_top_t {border-bottom:1px solid #ddd; margin:10px; padding:14px 5px 15px 5px;}
.ranking_top_t.st2 {margin:-16px 0 20px 0; padding:14px 5px 15px 5px;}
.ranking_box .ranking_h_tit {position:absolute; left:0; top:26px; text-align:center; width:100%;}
.ranking_box .ranking_h_tit img {width:460px;}
.top_icon {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_ranking.png) left top no-repeat; padding:3px 0 6px 35px; font-size:18px; font-weight:bold;}
.top_icon img {width:24px; height:24px; margin-left:4px;}
.ranking_top_t .btn {padding:4px 15px 6px 10px; margin-top:-2px;}
.ranking_top_t .btn .glyphicon {margin-left:20px;}
.ranking_lineup {padding:70px 0 0 20px;}
.ranking_lineup.st2 {padding:14px; float:left;}
.lineup_num {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_num.png) center top no-repeat; width:40px; height:40px; display:block;}
.lineup_num.num1 {background-position:center top;}
.lineup_num.num2 {background-position:center -80px;}
.lineup_num.num3 {background-position:center -160px;}
.lineup_num.num4 {background-position:center -240px;}
.lineup_num.num5 {background-position:center -320px;}
.lineup_num.num6 {background-position:center -400px;}
.lineup_num.num7 {background-position:center -480px;}
.lineup_num.num8 {background-position:center -560px;}
.lineup_num.num9 {background-position:center -640px;}
.lineup_num.num10 {background-position:center -720px;}
.lineup_num.num11 {background-position:center -800px;}
.lineup_num.num12 {background-position:center -880px;}
.lineup_num.num13 {background-position:center -960px;}
.lineup_num.num14 {background-position:center -1040px;}
.lineup_num.num15 {background-position:center -1120px;}
.lineup_num.num16 {background-position:center -1200px;}
.lineup_num.num17 {background-position:center -1280px;}
.lineup_num.num18 {background-position:center -1360px;}
.lineup_num.num19 {background-position:center -1440px;}
.lineup_num.num20 {background-position:center -1520px;}
.lineup_num.num21 {background-position:center -1600px;}
.lineup_num.num22 {background-position:center -1680px;}
.lineup_num.num23 {background-position:center -1760px;}
.lineup_num.num24 {background-position:center -1840px;}
.lineup_num.num25 {background-position:center -1920px;}
.lineup_num.num26 {background-position:center -2000px;}
.lineup_num.num27 {background-position:center -2080px;}
.lineup_num.num28 {background-position:center -2160px;}
.lineup_num.num29 {background-position:center -2240px;}
.lineup_num.num30 {background-position:center -2320px;}
.lineup_num.num31 {background-position:center -2400px;}
.lineup_num.num32 {background-position:center -2480px;}
.lineup_num.num33 {background-position:center -2560px;}
.lineup_num.num34 {background-position:center -2640px;}
.lineup_num.num35 {background-position:center -2720px;}
.lineup_num.num36 {background-position:center -2800px;}
.lineup_num.num37 {background-position:center -2880px;}
.lineup_num.num38 {background-position:center -2960px;}
.lineup_num.num39 {background-position:center -3040px;}
.lineup_num.num40 {background-position:center -3120px;}
.lineup_num.num41 {background-position:center -3200px;}
.lineup_num.num42 {background-position:center -3280px;}
.lineup_num.num43 {background-position:center -3360px;}
.lineup_num.num44 {background-position:center -3440px;}
.lineup_num.num45 {background-position:center -3520px;}
.lineup_num.num46 {background-position:center -3600px;}
.lineup_num.num47 {background-position:center -3680px;}
.lineup_num.num48 {background-position:center -3760px;}
.lineup_num.num49 {background-position:center -3840px;}
.lineup_num.num50 {background-position:center -3920px;}
.info_name .info_copyshot {font-size:14px; color:#999; display:inline-block; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_pic3.png) left top no-repeat; background-size:20px; padding:0 0 0 25px; margin-left:15px;}
.info_name .info_scrap {font-size:14px; color:#999; display:inline-block; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_scrap.png) left top no-repeat; background-size:20px; padding:0 0 0 22px; margin-left:15px;}
.info_name .info_share {font-size:14px; color:#999; display:inline-block; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_share4.png) left top no-repeat; background-size:20px; padding:0 0 0 22px; margin-left:15px;}
.ranking_cont .friend_list {margin:0 10px;}
.cont_recipe_ea {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_recipe4.png) center top no-repeat; background-size:50px; padding:53px 0 0 0; text-align:center; font-size:14px; width:100px; position:absolute; right:12px; top:15px;}
.cont_talk_ea {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_talk.png) center top no-repeat; background-size:50px; padding:53px 0 0 0; text-align:center; font-size:14px; width:100px; position:absolute; right:12px; top:15px;}
.cont_comment_ea {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_comment.png) center top no-repeat; background-size:50px; padding:53px 0 0 0; text-align:center; font-size:14px; width:100px; position:absolute; right:12px; top:15px;}
.cont_pic_ea {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_pic5.png) center top no-repeat; background-size:50px; padding:53px 0 0 0; text-align:center; font-size:14px; width:100px; position:absolute; right:12px; top:15px;}

.ranking_today {padding:10px 60px;}
.ranking_today_t {text-align:center; margin:25px 0 10px;}
.ranking_today_t .btn_date {vertical-align:middle; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_arrow4.png) center bottom no-repeat; background-size:9px; font-size:36px; font-weight:bold; color:#000; padding:0 30px 3px 30px; display:inline-block;}
.ranking_today_in {height:240px; position:relative; margin-bottom:2px; color:#fff; display:block; text-align:left;}
.ranking_today_in:hover, .ranking_today_in:focus, .ranking_today_in:active {color:#fff;}
.ranking_today_in .today_thumb_over {background:#000; opacity:0.2; filter:alpha(opacity=20); width:100%; height:100%; display:block; position:absolute; left:0; top:0; z-index:1;}
.ranking_today_in .today_num {display:block; position:absolute; left:10px; top:10px; background:#74b243; opacity:0.9; filter:alpha(opacity=90); color:#fff; font-size:32px; font-weight:bold; width:50px; height:50px; text-align:center; z-index:2; padding-top:8px; line-height:1;}
.ranking_today_in .today_caption {font-size:22px; font-weight:bold; text-shadow:1px 1px 0 #000; position:absolute; left:16px; bottom:8px; z-index:2; width:80%; line-height:1.3;}
.ranking_today_in .today_caption .today_pic {font-size:14px; display:block; margin:3px 0; font-weight:normal;}
.ranking_today_in .today_caption span img {border-radius:50%; width:45px; height:45px; border:2px solid #fff; margin:5px 6px 0 0;}
.ranking_cont .home_best {padding:0 5px; text-align:center;}
.ranking_cont .home_best .ranking_today_in {width:49%; display:inline-block;}
.ranking_cont .home_best .ranking_today_in .today_num {left:0; top:0;}
.ranking_honor {background:#fff; margin-top:8px; padding:16px 3px 0;}
.ranking_honor dt {font-size:18px; color:#000; padding:0 0 14px 15px;}
.ranking_honor ul {box-shadow:none; -webkit-box-shadow:none; }
.main_cate {padding:0; margin:0 10px; border:1px solid #ebebeb; border-top:none;}
.main_cate li {font-size:16px; width:25%; margin:0 -1px 0 -2px; display:inline-block; border-top:1px solid #ebebeb; border-right:1px solid #ebebeb; }
.main_cate li:nth-child(4n+4) { border-right:none;}
.main_cate li span {width:52px; height:52px; margin:0 9px 0 0; display:inline-block; color:#333; vertical-align:middle;}
.main_cate li span.cate1 {background:url(//recipe1.ezmember.co.kr/img/mobile/main_cate1.png) no-repeat left top; background-size:52px auto;}
.main_cate li:nth-child(1) span.cate1 {}
.main_cate li:nth-child(2) span.cate1 {background-position:0 -52px;}
.main_cate li:nth-child(3) span.cate1 {background-position:0 -104px;}
.main_cate li:nth-child(4) span.cate1 {background-position:0 -156px;}
.main_cate li:nth-child(5) span.cate1 {background-position:0 -208px;}
.main_cate li:nth-child(6) span.cate1 {background-position:0 -260px;}
.main_cate li:nth-child(7) span.cate1 {background-position:0 -312px;}
.main_cate li:nth-child(8) span.cate1 {background-position:0 -364px;}
.main_cate li:nth-child(9) span.cate1 {background-position:0 -416px;}
.main_cate li:nth-child(10) span.cate1 {background-position:0 -469px;}
.main_cate li:nth-child(11) span.cate1 {background-position:0 -521px;}
.main_cate li:nth-child(12) span.cate1 {background-position:0 -573px;}
.main_cate li:nth-child(13) span.cate1 {background-position:0 -625px;}
.main_cate li:nth-child(14) span.cate1 {background-position:0 -677px;}
.main_cate li:nth-child(15) span.cate1 {background-position:0 -729px;}
.main_cate li:nth-child(16) span.cate1 {background-position:0 -781px;}
.main_cate li a {display:block; padding:12px 0 13px 18px;}

.search_word {padding:0 12px;}
.search_word ul {border-top:1px solid #ddd; display:table; width:100%;}
.search_word ul li {font-size:14px; color:#444; padding:10px 0 0 10px; height:48px; display:inline-block; width:50%; border-bottom:1px solid #ddd;}
.search_word ul li:nth-child(2n+1) {border-right:1px solid #ddd; float:left;}
.search_btn {padding:20px 12px; text-align:center;}
.search_word ol {list-style:none; margin:0; padding:0;}
.search_word ol li {font-size:16px; color:#444; padding:7px 30px 30px 76px; margin-top:25px; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_num.png) 30px top no-repeat; border-bottom:1px solid #ddd;}
.search_word ol li:nth-child(1) {background-position:30px top;}
.search_word ol li:nth-child(2) {background-position:30px -80px;}
.search_word ol li:nth-child(3) {background-position:30px -160px;}
.search_word ol li:nth-child(4) {background-position:30px -240px;}
.search_word ol li:nth-child(5) {background-position:30px -320px;}
.search_word ol li:nth-child(6) {background-position:30px -400px;}
.search_word ol li:nth-child(7) {background-position:30px -480px;}
.search_word ol li:nth-child(8) {background-position:30px -560px;}
.search_word ol li:nth-child(9) {background-position:30px -640px;}
.search_word ol li:nth-child(10) {background-position:30px -720px;}
.search_word ol li:nth-child(11) {background-position:30px -800px;}
.search_word ol li:nth-child(12) {background-position:30px -880px;}
.search_word ol li:nth-child(13) {background-position:30px -960px;}
.search_word ol li:nth-child(14) {background-position:30px -1040px;}
.search_word ol li:nth-child(15) {background-position:30px -1120px;}
.search_word ol li:nth-child(16) {background-position:30px -1200px;}
.search_word ol li:nth-child(17) {background-position:30px -1280px;}
.search_word ol li:nth-child(18) {background-position:30px -1360px;}
.search_word ol li:nth-child(19) {background-position:30px -1440px;}
.search_word ol li:nth-child(20) {background-position:30px -1520px;}
.search_word ol li:nth-child(21) {background-position:30px -1600px;}
.search_word ol li:nth-child(22) {background-position:30px -1680px;}
.search_word ol li:nth-child(23) {background-position:30px -1760px;}
.search_word ol li:nth-child(24) {background-position:30px -1840px;}
.search_word ol li:nth-child(25) {background-position:30px -1920px;}
.search_word ol li:nth-child(26) {background-position:30px -2000px;}
.search_word ol li:nth-child(27) {background-position:30px -2080px;}
.search_word ol li:nth-child(28) {background-position:30px -2160px;}
.search_word ol li:nth-child(29) {background-position:30px -2240px;}
.search_word ol li:nth-child(30) {background-position:30px -2320px;}
.search_word ol li:nth-child(31) {background-position:30px -2400px;}
.search_word ol li:nth-child(32) {background-position:30px -2480px;}
.search_word ol li:nth-child(33) {background-position:30px -2560px;}
.search_word ol li:nth-child(34) {background-position:30px -2640px;}
.search_word ol li:nth-child(35) {background-position:30px -2720px;}
.search_word ol li:nth-child(36) {background-position:30px -2800px;}
.search_word ol li:nth-child(37) {background-position:30px -2880px;}
.search_word ol li:nth-child(38) {background-position:30px -2960px;}
.search_word ol li:nth-child(39) {background-position:30px -3040px;}
.search_word ol li:nth-child(40) {background-position:30px -3120px;}
.search_word ol li:nth-child(41) {background-position:30px -3200px;}
.search_word ol li:nth-child(42) {background-position:30px -3280px;}
.search_word ol li:nth-child(43) {background-position:30px -3360px;}
.search_word ol li:nth-child(44) {background-position:30px -3440px;}
.search_word ol li:nth-child(45) {background-position:30px -3520px;}
.search_word ol li:nth-child(46) {background-position:30px -3600px;}
.search_word ol li:nth-child(47) {background-position:30px -3680px;}
.search_word ol li:nth-child(48) {background-position:30px -3760px;}
.search_word ol li:nth-child(49) {background-position:30px -3840px;}
.search_word ol li:nth-child(50) {background-position:30px -3920px;}

.search_word .search_num {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_search3.png) left top no-repeat; font-family:Helvetica; color:#999; font-size:14px; float:right; padding:1px 8px 8px 15px; width:90px; text-align:right;}


.mem_cont {display:inline-block; padding:0 0 0 15px; line-height:18px;}
.mem_cont.st2 {width:720px;}
.mem_cont.st3 {width:300px;}
.mem_cont p {margin:0; padding:15px 0 0 0;}
.mem_cont b {display:block; font-size:16px; color:#000; padding:8px 0 6px 0;}
.mem_cont1 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_fork.png) left top no-repeat; background-size:20px; padding-left:22px; font-size:14px; color:#888; margin-right:15px;}
.mem_cont2 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_mem.png) left -3px no-repeat; background-size:20px; padding-left:21px; font-size:14px; color:#888; margin-right:15px;}
.mem_cont3 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_scrap.png) left -1px no-repeat; background-size:20px; padding:0 0 2px 21px; font-size:14px; color:#888; margin-right:15px;}
.mem_cont4 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_best2.png) left top no-repeat; background-size:20px; padding-left:20px; font-size:14px; color:#888; margin-right:15px;}
.mem_cont5 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_mem2.png) left -1px no-repeat; background-size:20px; padding-left:21px; font-size:14px; color:#888; margin-right:15px;}
.mem_cont6 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_pic3.png) left -2px no-repeat; background-size:19px; padding-left:21px; font-size:14px; color:#888; margin-right:15px;}
.mem_cont7 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_view3.png) left -1px no-repeat; background-size:19px; padding-left:21px; font-size:14px; color:#888; margin-right:15px;}
.mem_cont8 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_comment2.png) left -1px no-repeat; background-size:19px; padding:0 0 2px 23px; font-size:14px; color:#888; margin-right:15px;}
.mem_cont9 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_heart6.png) left top no-repeat; background-size:19px; padding:0 0 2px 21px; font-size:14px; color:#888; margin-right:15px;}
.mem_cont10 {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_date.png) left top no-repeat; background-size:19px; padding:0 0 2px 23px; font-size:14px; color:#888; margin-right:15px;}

.list_cont b {display:block; font-size:13px; color:#000; padding:0;}
.list_cont2 b {display:block; font-size:16px; color:#000; padding:0;}
.list_cont3 b {display:block; font-size:16px; color:#000; padding:0;}
.list_cont_in {width:100%; font-size:16px; color:#999; padding:12px 15px 4px 0; line-height:18px;}
.list_cont_in .list_tit u {color:#000; text-decoration:none;}
.list_cont_in .list_tit {color:#999;}
.list_cont_in .list_time, .list_cont_in .list_time a {font-size:14px; color:#999; display:block; padding-top:4px;}
.list_thumb {float:right; margin-left:15px;}
.list_thumb img {width:70px; height:80px;}
.friend_list .list_mem {padding:0 0 0 5px; display:inline-block; vertical-align:top;}

.search_area {width:100%; padding:10px 12px; margin-top:18px; height:55px; background:#f7f7f7; border:1px solid #eaeaea;}
.search_area_in {position:relative; padding:0!important; margin:0; width:520px; margin:0 auto;}
.search_area.st2 {margin-top:0;}
.search_area.st2 .search_area_in {width:100%;}
.search_area.st2 .form-control {width:370px;}
.search_area.st3 {background:#fff7a2; margin:0 0 15px 0;}
.search_area.st3 .form-control {width:350px; padding:0 0 0 12px;}
.search_area.st4 {background:#f7f7f7; margin:0 0 20px 0;}
.search_area .form-control {border-radius:0 !important; width:410px; height:34px; background:#fff; padding:0 0 0 34px; display:inline-block; vertical-align:middle;}
.search_area.st4 .form-control {padding:0 0 0 8px; margin-right:4px;}
.search_area .glyphicon {position:absolute; left:10px; top:7px; z-index:100; font-size:20px; color:#ccc;}
.search_area .btn {background:#f7f7f7; border:1px solid #ccc;; width:90px; height:34px; padding:0 0 1px 0 ; margin:0 0 0 8px; color:#333; font-size:14px; font-weight:bold; text-align:center;}
.search_area.st4 .btn {margin:0;}
.search_area.st4 .search_area_in {width:100%;}
.search_area.st4 .search_area_in b {font-size:14px; margin:0 8px 0 10px;}

.modal-body .blog_select {padding:20px 15px 0 15px; margin:0;}
.modal-body .blog_select dt {font-size:24px; font-weight:normal;}
.modal-body .blog_select dd {padding:18px 0 10px 27px; font-size:18px; color:#999;}
.modal-body .blog_select dd span {font-size:16px; padding:0 2px;}
.modal-body .blog_select dd span input {margin-right:4px;}
.modal-body .blog_select dd input {display:inline-block;}
.modal-body .blog_select dd span.blog_t1 {color:#22b500; padding-right:40px;}
.modal-body .blog_select dd span.blog_t2 {color:#5f8dfc; padding-right:40px;}
.modal-body .blog_select dd span.blog_t3 {color:#de4830; padding-right:40px;}
.modal-body .blog_select dd label {font-weight:normal;}
.modal-body .blog_select2 {padding:0; margin:0;}
.modal-body .blog_select2 li {border-bottom:1px solid #ebebeb; list-style:none; padding:12px; margin:0; font-size:15px;}
.modal-body .blog_select2 li input {margin-right:5px; vertical-align:middle;}
.modal-body .blog_select2_page {text-align:center; border-bottom:1px solid #ebebeb; padding:16px 0;}
.modal-body .blog_select2_page .btn {font-size:14px; color:#444; border-radius:25px !important; padding:4px 30px; margin:0 4px; }
.modal-body .blog_select2_page .btn span {margin:0 6px 0 0;}
.modal-body .blog_select2_page .btn_next {color:#62a42e;}
.modal-body .blog_select2_page .btn_next span {margin:0 0 0 6px;}
.modal-body .select_list {padding:0 0 10px 0; margin:0; border-bottom:1px solid #ebebeb;}
.modal-body .select_list li {list-style:none; padding:6px 12px; margin:0; font-size:14px;}
.modal-body .select_list li input {margin-right:5px; vertical-align:middle;}

.weighing_modal {width:100%; margin-bottom:10px;}
.weighing_modal tr {border-bottom:1px solid #e9e9e9;}
.weighing_modal th {width:120px; color:#000; padding:9px 2px 9px 15px;}
.weighing_modal td {text-align:right; line-height:1.6; color:#888; padding:9px 15px 9px 2px;}
.weighing_modal tr:nth-child(2n+2) {background:#f9f9f9;}

.drag_area {background:#FF0; border:2px dashed #C00 !important; width:100%; height:100%; filter:alpha(opacity=70); opacity:0.7; text-align:center; position:absolute; left:0; top:0;}
.drag_area b {color:#C00; font-size:18px; margin-top:-webkit-calc(50% - 9px); margin-top:-moz-calc(50% - 9px); margin-top:calc(50% - 9px); vertical-align:top; display:block; line-height:18px;}
.drag_img {position:relative; margin:0 auto; text-align:right;}
.drag_img_btn {position:absolute; right:10px; top:10px;}

.result_none {padding:40px 0; text-align:center; color:#999; font-size:16px; line-height:26px;}
.result_none img {width:180px;}
.result_none p {margin:0; padding:25px 0 20px; font-size:24px; color:#333; line-height:150%;}
.result_none p span {color:#74b243;}
.result_none .btn {padding:4px 20px; font-size:14px; border-radius:0; background:#f5f5f5; margin:0 4px;}
.result_none .btn-lg {margin-top:20px;}
.talk_guide {margin:15px 24px 8px; padding:12px 2px;}
.talk_guide span {display:inline-block; background:url(//recipe1.ezmember.co.kr/img/icon_talk.gif) left top no-repeat; padding:0 0 0 24px; color:#777;}
.talk_guide .btn {padding:4px 20px; font-size:14px; border-radius:0; background:#f5f5f5; float:right; margin:0 4px;}

.h_banner {position:relative; margin:18px auto 20px;}
.h_banner.st2 {margin:0 0 0 1px;}
.h_banner .btn_pic {position:absolute; top:15px; left:20px;}
.h_banner .btn_pic img {width:36px;}
.h_banner a {margin:0 5px 0 10px;}
.h_banner a img { width:400px;}
.banner_page {position:absolute; top:6px; right:10px;}
.banner_page li {display:inline-block; width:12px; height:12px; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_dot4.png) left top no-repeat; background-size:12px;}
.banner_page li.active {display:inline-block; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_dot4_on.png) left top no-repeat; background-size:12px;}

.brand_logo {background:#fff; padding:8px 20px 14px; font-weight:bold; font-size:15px; position:relative; width:100%; -webkit-box-shadow:inset 0 2px 3px rgba(0, 0, 0, 0.2); box-shadow:inset 0 2px 3px rgba(0, 0, 0, 0.2); line-height:1.2; position:relative;}
.brand_logo_img { width:130px; height:130px; background:#fff; -webkit-box-shadow:1px 1px 2px rgba(0, 0, 0, 0.4); box-shadow:1px 1px 2px rgba(0, 0, 0, 0.4); position:absolute; left:15px; top:-80px; border-radius:50%;}
.brand_logo_img img {width:130px; height:130px; border-radius:50%;}
.brand_logo_l {font-size:14px; color:#000; padding:5px 0 0 140px;}
.brand_logo_l .name {font-size:18px; padding-right:14px;}
.brand_logo_l a b {padding:0 0 0 3px; font-family:Myriad Pro;}
.brand_logo_l a {font-weight:normal; color:#555;}
.brand_logo_l .dot {padding:0 6px; color:#999; }
.brand_logo_l .logo_l_cont {color:#666; padding:4px 0 0 0; margin-left:-2px; font-weight:normal; line-height:1.3;}
.brand_logo_l .logo_l_cont a {color:#999;}
.brand_logo_l .logo_l_cont span {padding-right:3px;}
.brand_cont {padding:5px 30px 0 30px; margin-bottom:8px;}
.brand_logo_r { position:absolute; right:18px; top:16px;}
.brand_logo_r .btn-default {font-size:13px; background:none; border:1px solid #51c351; border-radius:20px; color:#51c351; font-weight:bold; padding:3px 16px 4px; margin:-3px 0 0 8px;}
.brand_logo_r .btn-default span {font-size:12px; font-weight:normal; padding-right:2px;}
.brand_cont dt {border-bottom:1px solid #e6e6e6; font-size:18px; padding:7px 10px 0 8px; height:44px;}
.brand_cont dt img {width:25px; margin:0 3px 0 0; vertical-align:middle;}
.brand_cont dt a {float:right; font-size:14px; color:#888; font-weight:normal; margin-top:2px;}
.brand_cont dd {padding:0; margin-bottom:0;}
.brand_cont dd .h_banner img {border:1px solid #eee;}
.brand_cont.st2 {padding:0;}
.brand_cont.st3 {padding:1px 5px 0 5px;}
.brand_cont.st3 .home_best {margin:20px 0 0 -4px;}
.brand_cont.st3 .home_best .thumbnail img {width:200px; height:200px; border-radius:4px 4px 0 0;}
.brand_cont.st3 .home_best .thumbnail .best_label img {width:36px; height:36px;}
.brand_cont.st3 .home_best .thumbnail {width:200px; height:265px; margin:0 10px 20px -2px; display:inline-block; padding:0; vertical-align:top; position:relative;}
.brand_cont.st3 .home_best .thumbnail:nth-child(4n+4) {margin-right:-5px;}
.brand_cont.st3 .home_best .caption {font-size:14px; text-align:center; padding-top:10px; line-height:1.4;}
.brand_cont.st3 .home_best .vod_label {position:absolute; left:70px; top:70px; z-index:10;}
.brand_cont.st3 .home_best .vod_label img {width:60px; height:60px;}
.brand_cont.st3 .home_best .time_label {display:inline-block; border-radius:0 15px 15px 0; height:30px; background:#ff321b; padding:3px 15px 0 10px; color:#fff; font-size:15px; position:absolute; left:0; top:10px;}
.brand_cont.st3 .home_best .time_label img {margin:0 5px 2px 0; width:18px; height:18px;}

.brand2_top {background: url(//recipe1.ezmember.co.kr/img/brand2_top_bg.jpg) left top repeat-x;margin-top: -16px;text-align: center;}
.brand2_top_in {background: url(//recipe1.ezmember.co.kr/img/brand2_top.jpg) center top repeat-x;height: 566px;margin: 0;}
.brand2_cont1 {background: #fff;text-align: center;padding: 70px 0; border-bottom:1px solid #ddd;}
.brand2_cont2 {background: #efefef;text-align: center;padding: 70px 0;}
.apply_cont .cont_add {margin: 30px 0 0 0;}
.apply_cont .cont_add_tt b {font-size: 20px;color: #fff;padding-right: 5px}
.apply_cont .cont_add_tt span {font-size: 15px;color: #fff;margin-bottom: 8px;display: inline-block;}
.apply_cont .cont_add_in {background: #fff;border: 1px solid #ccc;padding: 15px 0 15px 25px;}
.apply_cont .cont_add_in .radio-inline {display: inline-block;width: 200px;margin: 6px 0;font-size: 15px;}
.chef_apply .apply_cont .cont_add .btn {display: inline-block;width: 110px;vertical-align: baseline;height: 60px;margin-left: 6px;}
.brand2_cont1 .member_list {margin:15px auto 0; width:1200px; padding:0;}
.brand2_cont1 .member_list .info_pic2 {display:inline-block; margin:30px 0 0 0; width:160px; vertical-align:top;}
.brand2_cont1 .member_list .info_pic2 img {width:100px; height:100px; border-radius:50%; -webkit-box-shadow:0 0 4px rgba(0, 0, 0, 0.2); box-shadow:0 0 4px rgba(0, 0, 0, 0.2);}
.brand2_cont1 .member_list .info_name {font-size:14px; padding-top:8px;}

.brand3_top_in {background: url(//recipe1.ezmember.co.kr/img/brand4_img_bg.jpg) left top repeat-x #c2a888; margin: 0; text-align:center;}

.main_nav {background:#fff; -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); margin:0; text-align:center; padding:0;}
.main_nav.st2 {background:#4e525a;}
.main_nav.st2 li a, .main_nav.st2 li a:hover {color:#fff;}
.main_nav.six li {width:12%;}
.main_nav.five li {width:15%;}
.main_nav.four li {width:20%;}
.main_nav.three li {width:28%;}
.main_nav.two li {width:42%;}
.main_nav li {width:1%; display:table-cell; text-align:center; height:48px; padding-top:13px; margin:0 2%; font-size:16px; border-right:1px solid #71757b;}
.main_nav li a:hover {color:#4d9712;}
.main_nav li.active {border-bottom:4px solid #74b243; font-weight:bold;}
.main_nav li:last-child {border-right:none;}
.main_nav li a {display:block;}
.main_nav li a .num {color:#abef76; padding-left:14px;}
.brand_cont .cont_list.st3 {margin:20px -2px 0 -1px; }
.brand_cont .cont_list.st3 .thumbnail {margin-right:7px; margin-bottom:20px;}
.brand_cont .cont_list.st3 .thumbnail:nth-child(4n+4) {margin:0 -4px 20px 0;}
.brand_cont .cont_list.st3 .thumbnail .caption { text-align:left;}
.brand_cont .cont_list.st3 li {list-style:none; padding:0; margin:0 -3px 0 0; display:inline-block; position:relative; vertical-align:top;}
.brand_cont .cont_list.st3 .thumbnail_original {position:absolute; right:15px; top:7px; border:2px solid #fff; -webkit-transition:border .2s ease-in-out; -o-transition:border .2s ease-in-out; transition:border .2s ease-in-out; z-index:100;}
.brand_cont .cont_list.st3 .thumbnail_original img {width:50px; height:50px; }
.brand_cont .cont_list.st3 .thumbnail_original:focus, .brand_cont .cont_list.st3 .thumbnail_original:hover {border:2px solid #5ca920;}


.event_summary {background:#eceff1; padding:34px 35px 38px;}
.event_summary dt {font-size:30px; color:#000; line-height:1.2;}
.event_summary dt b {display:block; font-size:44px; color:#de4830; padding-top:3px; letter-spacing:-2px;}
.event_summary dd {font-size:20px; color:#000; padding-top:22px;}
.event_summary dd p {font-size:24px; font-weight:bold; padding:20px 0 0 0; margin:0;}

/*right*/
.talk_smn {border:none;}
.talk_smn .list-group-item {background:url(//recipe1.ezmember.co.kr/img/icon_arrow2.png) 285px 15px no-repeat;}
.talk_smn .list-group-item.s_sub {background:url(//recipe1.ezmember.co.kr/img/icon_rmn.gif) 30px 14px no-repeat; padding:15px 0 15px 52px; font-size:16px;}
.talk_smn .list-group-item.s_sub.active {color:#e24b44;}
.talk_smn .list-group-item:first-child {border-top:none;}
.talk_smn .list-group-item:last-child {border-bottom:none;}
.talk_smn .list-group-item .count {font-size:16px; color:#999; margin:0 6px; font-weight:bold;}
.right_talk {padding:20px;}
.right_talk ul {margin-bottom:10px;}
.right_talk_list {padding:2px 0 0 0; margin:0;}
.right_talk_list li {list-style:none; background:url(//recipe1.ezmember.co.kr/img/icon_dot1.gif) left 8px no-repeat; padding:0 0 0 8px; margin:6px 12px;}
.right_talk h4 {font-weight:bold; padding-left:5px;}
.right_banner {text-align:center; margin:10px 0 0 0;}
.right_banner a {margin-bottom:10px; display:block;}
.right_banner a img {border:1px solid #e6e6e6;}

.container.sub_full {background:#fff; border:1px solid #e6e7e8; padding:0 120px;}

/* etc */
.nav_etc {background:url(//recipe1.ezmember.co.kr/img/bg_wave.png?v.2) left bottom repeat-x; width:100%; text-align:center; height:85px; padding-top:15px;}
.container_etc {margin:0 auto 30px; padding-top:20px;}
.container_etc h2 {text-align:center; font-weight:bold; margin-bottom:15px;}
.container_etc input {height:60px;}
.container_etc .checkbox input {height:auto; margin-top: 6px;}
.container_etc .btn {margin:0 4px 20px 0; position:relative;}
.container_etc .btn_gender {position:absolute; left:250px; top:13px; z-index:100;}
.container_etc .btn_gender span .btn {height:32px; }
.container_etc .btn_gender span .btn-default:active, .container_etc .btn_gender span .btn-default.active {color: #fff; background-color: #44b6b5; border-color:#44b6b5;}
.container_etc .etc_line {border-bottom:1px solid #dadcdd; margin-bottom:15px;}
.container_etc .btn-lg {margin-top:25px; height:60px;}
.container_etc .panel-body {padding:0;}
.container_etc .help-block {color:#999; margin-bottom:25px; font-size:14px;}
.container_etc .guide_txt {font-size:16px; color:#888;}
.container_etc .join_btn {margin:15px 0; text-align:center; border:1px solid #ddd;}
.container_etc .join_btn a {color:#555; display:table-cell; width:1%; background:#fff; font-size:13px; line-height:1; vertical-align:middle; padding:16px 2px; border-right:1px solid #ddd; }
.container_etc .join_btn a:last-child {border:none;}
.container_etc .join_btn a.active {font-weight:bold; border:2px solid #dddddd; border-bottom:none;}
.container_etc .join_b_order {border:3px solid #ddd; margin:-15px 0 20px; padding:12px;}
.container_etc .join_b_order .info {color:#666; text-align:center; line-height:1.5; padding-bottom:8px; margin-top:-4px; font-size:14px;}
.container_etc .space_line {color:#ccc; margin:0 30px;}
.container_etc .join_f {background:#527bd4; border-color:#3f68c2; margin-bottom:10px; font-size:16px; font-weight:normal;}
.container_etc .join_f:focus, .container_etc .join_f:active, .container_etc .join_f:hover {background:#3a63bc;}
.container_etc .join_f span {background:url(//recipe1.ezmember.co.kr/img/icon_sns2_f.png) 7px top no-repeat; width:270px; padding:8px 0 0 20px; display:inline-block; height:40px;}
.container_etc .join_k {background:#fff000; border-color:#ddd110; color:#363139; margin:0 0 10px 0; font-size:16px; font-weight:normal;}
.container_etc .join_k:focus, .container_etc .join_k:active, .container_etc .join_k:hover {background:#ffe400;}
.container_etc .join_k span {background:url(//recipe1.ezmember.co.kr/img/icon_sns2_k.png) left 2px no-repeat; width:270px; padding:8px 0 0 20px; display:inline-block; height:40px;}
.container_etc .join_n {background:#26cc09; border-color:#28b80f; margin:0 0 10px 0; font-size:16px; font-weight:normal;}
.container_etc .join_n:focus, .container_etc .join_n:active, .container_etc .join_n:hover {background:#24b70b;}
.container_etc .join_n span {background:url(//recipe1.ezmember.co.kr/img/icon_sns2_n.png) left 4px no-repeat; width:270px; padding:8px 0 0 20px; display:inline-block; height:40px;}
.container_etc .join_g {background:#de3d2b; border-color:#c52816; margin:0 0 10px 0; font-size:16px; font-weight:normal;}
.container_etc .join_g:focus, .container_etc .join_g:active, .container_etc .join_g:hover {background:#cf2f1d;}
.container_etc .join_g span {background:url(//recipe1.ezmember.co.kr/img/icon_sns2_g.png?v2) left 2px no-repeat; width:270px; padding:8px 0 0 20px; display:inline-block; height:40px;}
.container_etc .panel-default {margin-top:20px; padding-bottom:20px;}
.container_etc .guide_txt2 {padding:0 20px 5px; font-size:16px; color:#333; font-weight:500;}
.container_etc .guide_txt2 input {height:auto; float:right;}
.container_etc .panel-body textarea {width:-webkit-fill-available;height:200px; margin:0 20px; background:#f7f7f7; border:1px solid #f0f0f0; padding:10px; font-weight: 300;}
.container_etc .j_title {font-size:36px; color:#444; padding:60px 0 26px 0;}
.container_etc .j_title p {margin-bottom:20px;}
.container_etc .j_cont {font-size:24px; color:#444; line-height:40px;}
.container_etc .j_cont span {color:#74b243; font-weight:bold;}
.container_etc .j_cont2 {color:#999; padding-top:25px;}

.container_etc .form-group {margin-bottom:-1px;}
.container_etc .form-control {
	display:block;
	width:100%;
	padding:6px 12px;
	font-size:14px;
	line-height:1.42857143;
	color:#555;
	background-color:#fff ;
	background-image:none;
	border:1px solid #ccc;
	border-radius:0;
	-webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075);
	box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075);
-webkit-transition:border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
-o-transition:border-color ease-in-out .15s, box-shadow ease-in-out .15s;
transition:border-color ease-in-out .15s, box-shadow ease-in-out .15s;
margin-bottom:-1px !important;
}
.container_etc .form-control:focus {
	border-color:#66afe9;
	outline:0;
	-webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
	box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6)
}
.container_etc .form-control::-moz-placeholder {color:#666;opacity:1}
.container_etc .form-control:-ms-input-placeholder {color:#666}
.container_etc .form-control::-webkit-input-placeholder {color:#666}
.container_etc .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
	cursor:not-allowed;
	background-color:#eee;
	opacity:1
}
.container_etc  textarea.form-control {	height:auto}
.etc_wrap {background:#fff; border:1px solid #ccc;}
.etc_wrap p {padding:2px 20px 0;}
.etc_wrap .form-group {text-align:center;}
.etc_wrap .form-group .form-control {width:320px; margin:0 auto; height:50px; background:#f5f5f5;}
.etc_wrap .btn-success, .etc_wrap .btn-primary {margin-top:10px;}

.footer {background:#fff; color:#999; padding:2px 0 5px 0; margin-top:30px; border-top:1px solid #dcdcdc;}
.footer .intro {width:428px; padding:26px 0 0 24px;}
.footer .intro h3 {font-weight:bold;}
.footer .intro p.f_link {margin:0; padding-bottom:16px;}
.footer .intro p.f_info {font-size:13px; line-height:1.6; margin-bottom:16px; font-weight: 300;}
.footer .intro p.f_link a { font-size:13px; color:#999;}
.footer .intro p.f_link span {color:#ddd; padding:0 4px;}
.footer .intro .copyright {font-size:12px; padding:20px 0; color:#999; font-family:Helvetica;}
.footer .banner {width:200px; padding:25px 0 0 0; position:relative;}
.footer .banner a {margin-bottom:9px; display:block;}
.footer .facebook {width:320px; padding:25px 0 0 22px;}
.footer .comment {width:300px; padding:28px 0 0 0;}
.footer .comment b {padding-bottom:14px; display:block;}
.footer .comment textarea {width:300px; height:150px; font-size:13px; background:#f5f5f5; border:1px solid #e6e7e8;}
.footer .comment button {border:1px solid #dcdcdc; background:#fff; border-radius:0; color:#444; width:300px; margin:8px 0 0 -1px;}
.footer .comment p.noti {margin:0; padding:10px 0 0 0; text-align:center; width:300px; font-size:13px; color:#999; display:block;}
.footer .app_layer {background:url(//recipe1.ezmember.co.kr/img/bg_layer4.png) left top; width:372px; height:321px; position:absolute; left:-10px; top:-300px; padding:12px 12px; z-index:1000;}
.app_layer  p.tit {font-size:14px; color:#444; border-bottom:1px solid #ebebeb; padding:10px 0; background:#f8f8f8; text-align:center; font-weight:bold; line-height:18px; margin:0;}
.footer .app_layer .layer_l {width:172px; border-right:1px solid #ebebeb; display:inline-block; text-align:center; padding:12px 0 8px;}
.footer .app_layer .layer_r {width:172px; display:inline-block; text-align:center; padding:12px 0 8px;}
.footer .app_layer .layer_l a, .footer .app_layer .layer_r a {margin-top:14px;}
.footer .banner_sns {padding-top:20px;}
.footer .banner_sns a {display:table-cell;}

.footer.st2 {background:#289f5d; margin-top:0; border-top:none;}
.footer.st2 .container {padding:18px 0 18px 40px;}
.footer.st2 .btm_stats {background:url(//recipe1.ezmember.co.kr/img/btm_line.png) 32px 24px no-repeat; display:inline-block; vertical-align:middle; padding:0; margin-left:22px;}
.footer.st2 .btm_stats li {text-align:center; display:inline-block; color:#fff; font-size:12px; width:160px;}
.footer.st2 .btm_stats li span {width:100%; height:66px; display:block; margin-bottom:6px;}
.footer.st2 .btm_stats li b {color:#fdff51; display:block; font-size:18px; font-weight:normal; margin-top:4px;}
.footer.st2 .btm_stats_1 {background:url(//recipe1.ezmember.co.kr/img/btm_icon1.png) center no-repeat;}
.footer.st2 .btm_stats_2 {background:url(//recipe1.ezmember.co.kr/img/btm_icon2.png) center no-repeat;}
.footer.st2 .btm_stats_3 {background:url(//recipe1.ezmember.co.kr/img/btm_icon3.png) center no-repeat;}
.footer.st2 .btm_stats_4 {background:url(//recipe1.ezmember.co.kr/img/btm_icon4.png) center no-repeat;}
.footer.st2 .btm_stats_5 {background:url(//recipe1.ezmember.co.kr/img/btm_icon5.png) center no-repeat;}
.footer.st2 .btm_mail {background:url(//recipe1.ezmember.co.kr/img/btm_img1.png) left top no-repeat; padding:12px 0 0 108px; display:inline-block; margin-left:10px;}

.chef_apply .apply_info {background:#fff; padding:50px 0 60px 0; text-align:center; color:#444;}
.chef_apply .apply_info dl {padding:0 0 50px 0;}
.chef_apply .apply_info dt span {font-size:30px; background:url(//recipe1.ezmember.co.kr/img/chef_apply_icon.png) left top no-repeat; padding:20px 0 6px 32px; display:inline-block;}
.chef_apply .apply_info dd {font-size:16px; color:#555; padding:16px 0 0 0; line-height:26px}
.chef_apply .apply_info ul {margin:0; padding:25px 0 80px 0;}
.chef_apply .apply_info li {width:260px; display:inline-block;}
.chef_apply .apply_info li p {font-size:18px; color:#eb1000; line-height:24px; padding:15px 0 0 0; margin:0; font-weight:bold;}
.chef_apply .apply_info p {margin:0;}
.chef_apply .apply_cont {background:url(//recipe1.ezmember.co.kr/img/chef_apply2_bg.gif) left top repeat; padding:60px 0 60px 0;}
.chef_apply .apply_cont dl {width:460px; margin:0 auto;}
.chef_apply .apply_cont dt { text-align:center; padding-bottom:28px;}
.chef_apply .apply_cont dt span {font-size:30px; background:url(//recipe1.ezmember.co.kr/img/chef_apply_icon.png) left top no-repeat; padding:20px 0 30px 32px; color:#fff; display:inline-block;}
.chef_apply .apply_cont .form-control {padding:0 24px; border-radius:0; font-size:15px; height:60px}
.chef_apply .apply_cont textarea {padding:15px 24px; border-radius:0; font-size:15px;}
.chef_apply .apply_cont p {color:#acafb6; font-size:13px; padding:10px 0 30px 0;}
.chef_apply .apply_cont p.guide_txt2 {text-align:center;}
.chef_apply .apply_cont p.guide_txt2 input {margin-left:2px; vertical-align:sub;}
.chef_apply .apply_cont .btn {width:100%; margin:16px 0 0 0; padding:16px 0;}
.apply_info4 .btn {margin:16px 0 42px 0; padding:16px 50px;}
.chef_apply2 {width:890px; background:#fff; margin:10px auto; padding:20px 50px 5px; position:relative;}
.chef_apply2 h2 {border-bottom:1px solid #ebebeb; padding-bottom:20px;}
.chef_apply2 .apply_cont {padding:20px 10px;}
.chef_apply2 .apply_cont .form-control {background:#f5f5f5; border:1px solid #ebebeb; height:34px; display:inline-block; vertical-align:middle; margin:0 4px;}
.chef_apply2 .apply_cont .btn_small {height:34px; margin:0 0 0 5px; border-radius:0; font-size:12px; color:#666;}
.chef_apply2 .apply_cont form div {margin-bottom:15px;}
.chef_apply2 .apply_cont form p {font-size:12px; color: #bbb; padding:8px 0 0 4px;}
.chef_apply2 .apply_cont form .form_line {border-bottom:1px solid #ebebeb; padding-top:20px; margin:0 -10px;}
.chef_apply2 .apply_cont form .form_tit {font-size:16px; color:#444; padding:25px 0 20px 4px; margin:0;}
.chef_apply2 .apply_cont form .form_tit2 {font-size:18px; color:#000; padding:25px 0 14px 4px; margin:0;}
.chef_apply2 .apply_cont form .form_cont {font-size:12px; color:#666; padding:0 0 0 4px; margin:0; line-height:21px;}
.chef_apply2 .apply_cont form .apply_btn  {text-align:center; padding-top:20px;}
.chef_apply2 .apply_cont form .apply_btn .btn {padding:10px 80px;}
.chef_apply2 .apply_cont p.form_noti {color:#888; padding:20px; border:1px solid #ddd; margin:20px 0;}
.chef_apply2 .apply_cont p.form_noti label {padding:0; margin:15px 0 0 0; display:block; color:#555;}
.chef_apply2 .apply_cont p.form_noti label input {vertical-align:middle; margin-right:3px; margin-top:-1px; height:20px;}
.chef_apply2 .apply_icon {position:absolute; right:35px; top:0;}
.chef_apply2  h1 {font-weight:bold; padding:20px 0 40px 0;}
.chef_apply2 .apply_cont2 dl {padding:0 0 30px 0;}
.chef_apply2 .apply_cont2 dt {color:#74b243; font-size:23px;}
.chef_apply2 .apply_cont2 dd {color:#444; font-size:15px; padding:7px 0 0 0; line-height:26px;}
.chef_apply2 .apply_cont2 dd span {color:#84accb; font-size:16px; display:block; padding:20px 0 2px 0; font-weight:bold;}
.chef_apply2 .apply_cont2 dd b {display:block; font-size:17px; color:#de4830; padding:25px 0 20px 0;}
.chef_apply .chef_top {background:url(//recipe1.ezmember.co.kr/img/chef_apply2_01.jpg) center no-repeat; background-size:cover; height:479px; margin-top:-22px; text-align:center; padding-top:100px;}
.chef_apply .brand_top {background:url(//recipe1.ezmember.co.kr/img/brand_bg1.jpg) center no-repeat; background-size:cover; height:477px; margin-top:-22px; text-align:center; padding-top:82px;}
.chef_apply .brand_top p {font-size:20px; line-height:1.5; color:#fff; padding-top:28px;}
.chef_apply .brand_top span {font-size:36px; font-weight:bold; display:block; padding-bottom:18px;}
.chef_apply .chef_top dl {padding-top:42px; color:#fff; font-size:20px;}
.chef_apply .chef_top dt {font-weight:bold; padding-bottom:4px;}
.chef_apply .chef_top dd {line-height:30px;}
.chef_apply .info_h {font-weight:bold; font-size:24px; color:#333; line-height:1.3; padding:20px 0 10px 0;}
.chef_apply .apply_info b, .apply_info2 b, .apply_info3 b {color:#000;}
.chef_apply .apply_info2 {padding:50px 0 60px 0; background:#eceff1; text-align:center; color:#444;}
.chef_apply .apply_info3 {padding:50px 0 60px 0; background:#fff; text-align:center; color:#444;}
.chef_apply .apply_info4 {background:url(//recipe1.ezmember.co.kr/img/brand_bg2.jpg) center repeat-y; background-size:100%; text-align:center; padding:40px 0 20px 0; margin:0;}
.chef_apply .apply_info4 dt {font-size:48px;  font-weight:normal; color:#000;}
.chef_apply .apply_info4 dd {font-size:20px; color:#333;}
.chef_apply .apply_info4 dd ul {padding:30px 0 0 0; width:1200px; text-align:center; margin:0 auto; position:relative;}
.chef_apply .apply_info4 .brand_ex {position:absolute; right:80px; top:-256px;}
.chef_apply .apply_info4 dd li {width:24%; display:inline-block; padding-bottom:22px;}
.chef_apply .apply_info4 dd li img {width:285px;}
.chef_apply .apply_info4 dd li span {display:block; font-size:20px; margin-top:6px; color:#8b5b4f; font-weight:bold;}
.chef_apply .apply_info5 {background:#fff; text-align:center; margin:0; padding:45px 0 34px 0;}
.chef_apply .apply_info5 dt {font-size:48px; color:#000; font-weight:normal;}
.chef_apply .apply_info5 dd {padding:15px 0 25px 0;}
.chef_apply .apply_info5 dd ul {width:1200px; margin:0 auto; padding:16px 0 0 0;}
.chef_apply .apply_info5 dd li {width:24%; display:inline-block; vertical-align:top;}
.chef_apply .apply_info5 dd li img {width:218px;}
.chef_apply .apply_info5 dd li span {display:block; font-size:20px; color:#333; font-weight:bold; padding-top:10px; line-height:1.4;}
.chef_apply .table {width:1000px; margin:0 auto 10px;}
.chef_apply .table caption {text-align:center; padding-bottom:30px;}
.chef_apply .table>tbody>tr, .chef_apply .table>tbody>tr>td {border-top:none; font-size:16px; color:#333; font-weight:bold; line-height:24px;}
.chef_apply .table .info3_plus {padding-top:95px; width:40px;}
.apply_benefit {background:url(//recipe1.ezmember.co.kr/img/ch_apply1_bg.jpg?v.1) left top no-repeat; height:335px; margin-top:30px; text-align:left;}
.apply_benefit_1 {padding:138px 0 0 52px; display:inline-block;}
.apply_benefit_1 a img {width:362px; height:114px; -webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.3); box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);}
.apply_benefit_2 {display:inline-block; padding:73px 0 0 0; float:right;}

.account_cate {text-align:right; padding:14px 0 0 0;}
.account_cate select {background:#f5f5f5; border:1px solid #e1e1e1; border-radius:5px; height:40px; padding:0 0 0 12px;}
.account_cont {padding:12px 0 0 0;}
.account_cont .table {font-size:12px;}
.account_cont .table>thead>tr {background:#f7f7f7; border:1px solid #e4e4e4;}
.account_cont .table>thead>tr>th {border-bottom:0; text-align:center; padding:10px 8px 11px 8px;}
.account_cont .table>tbody>tr>td {border-bottom:1px solid #e4e4e4; text-align:center; padding:10px 8px 11px 8px; vertical-align:middle;}
.account_cont .table>tbody>tr.account_total td {padding:20px 8px 22px 8px; font-weight:bold;}

.ncard_top {background:url(//recipe1.ezmember.co.kr/img/ncard_t_bg.jpg) left top no-repeat; padding:201px 0 0 49px;}
.ncard_info {padding:50px 30px; background:#fff;}
.ncard_info dt {font-size:20px; text-align:center; border-bottom:1px solid #eee; padding-bottom:25px;}
.ncard_info dt img {vertical-align:text-top;}
.ncard_info dt.st2 {font-size:28px; text-align:center; border-bottom:none; padding:40px 0 50px 0;}
.ncard_info dt.st2 p {font-size:16px; color:#777; margin-top:26px;}
.ncard_info dt.st2 p a {color:#777; text-decoration:underline;}
.ncard_info dt span {color:#e80000; font-size:16px; padding-left:5px;}
.ncard_info dd {padding:40px 0 0 0;}
.ncard_info .control-label {font-size:16px; color:#444; text-align:left; padding-left:10px;}
.ncard_info .form-control {display:inline-block; background:#f5f5f5; border-radius:0;}
.ncard_info .btn_small {height:34px; margin:0 0 0 5px; border-radius:0; font-size:12px; color:#666; vertical-align:top;}
.ncard_info .form-group p {font-size:12px; color:#bbb; padding:8px 0 0 0; width:100%;}
.ncard_info .apply_btn {border-top:1px solid #eee; margin-top:40px; padding-top:35px; text-align:center;}
.ncard_info .apply_btn .btn-lg {padding:10px 80px; height:60px;}
.sample_select {text-align:center; width:150px; padding:30px 5px 0 0; display:inline-block;}
.sample_select b {font-size:22px; display:block;}
.sample_select label {cursor:pointer;}
.sample_select p {color:#dc0000; font-size:14px;}
.sample_select span {display:block; color:#666;}
.sample_ex {display:inline-block; vertical-align:top;}
.sample_ex img {width:640px;}
.sample_list_a, .sample_list_b {padding-bottom:26px; margin-bottom:25px; border-bottom:1px dashed #ddd;}
.ncard_tit {font-size:16px; color:#000; font-weight:bold; padding-bottom:8px;}
.ncard_tit_1 {font-size:14px; color:#777; padding:0 0 30px 11px; line-height:22px;}
.ncard_tit_2 {font-size:14px; color:#e80000; padding:10px 0;}
.ncard_file {margin-top:25px;}
.ncard_file .form-control {margin-bottom:14px;}
.ncard_noti {border:1px solid #e6e6e6; background:#f8f8f8; padding:20px 10px 10px 10px!important; margin-top:40px;}
.ncard_noti_t {font-size:18px; color:#e50000; display:block; padding:0 0 20px 8px;}
.ncard_noti p {font-size:13px; color:#000; line-height:24px; padding:0 0 15px 6px; margin:0;}
.ncard_noti p span {color:#e60000; padding-left:10px; display:block;}
.ncard_info .table {border-bottom:1px solid #ddd;}
.ncard_info .table th, .ncard_info .table td {padding:15px; font-size:16px;}

.gnb_chef .gnb_top_wrap {height:96px;}
.gnb_chef .gnb_top {padding:13px 0 0 20px;}
.gnb_chef .gnb_top .gnb_right {float:right;}
.gnb_chef .gnb_top h1 span {border-left:1px solid #ccc; padding-left:14px; margin-left:14px; color:#666; font-size:30px; font-weight:bold; line-height:1; display:inline-block;}
.gnb_chef .gnb_top .gnb_right li.tel {font-size:24px; color:#000; vertical-align:middle; padding-right:12px; padding-top:4px;}
.gnb_chef .gnb_top .gnb_right li.tel img {padding-right:4px;}
.gnb_chef .gnb_nav {background:#667180;}
.gnb_chef .gnb_nav ul {background:url(//recipe1.ezmember.co.kr/img/gnb_bg3.png) left top repeat-y; height:46px; padding-top:0;}
.gnb_chef .gnb_nav ul li {background:url(//recipe1.ezmember.co.kr/img/gnb_bg2.gif) right top repeat-y; height:46px; padding-top:9px;}
.gnb_chef .gnb_nav ul li:last-child {background:none;}
.gnb_chef .gnb_nav ul li a {display:block; font-size:18px; margin:0 8px; color:#cdcdd1;}
.gnb_chef .gnb_nav ul li a.active {color:#fff;}
.gnb_chef .gnb_nav ul li a:hover {color:#fff;}
.right_chef {border-bottom:1px solid #e6e6e6; padding-bottom:25px; margin-bottom:0;}
.right_chef dt {font-size:20px; color:#444; font-weight:normal; padding:18px 24px 17px; border-bottom:1px solid #e6e6e6; line-height:1;}
.right_chef dt a {float:right; margin-top:-2px;}
.right_chef dd {padding:8px 18px;}
.right_talk_list img {vertical-align:text-bottom; margin-left:4px;}
.right_comment {width:290px; padding:20px 0 0 0; margin:0 auto;}
.right_comment textarea {height:150px; font-size:13px; background:#f5f5f5; border:1px solid #e6e7e8;}
.right_comment .btn {border:none; background:#479ffc; border-radius:0; color:#fff; width:100%; margin:8px 0 0 -1px;}
.right_comment .btn:hover {background:#479ffc; color:#fff;}
.chefhome_cont {margin:20px; position:relative;}
.chefhome_stats {width:423px; display:inline-block;}
.chefhome_stats dl {border:1px solid #ddd; padding:20px; margin-bottom:10px;}
.chefhome_stats dt {font-size:18px; line-height:1; padding-bottom:20px;}
.chefhome_stats .table {margin-bottom:10px;}
.chefhome_stats .table th {font-weight:normal; color:#666; background:#f8f8f8; text-align:center; padding:10px 0;}
.chefhome_stats .table td {color:#333; text-align:center; line-height:1.4; padding:16px; font-weight:bold;}
.chefhome_stats .table.st2 td {padding:inherit; padding:10px; color:#6eab3e;}
.line_area {background:url(//recipe1.ezmember.co.kr/img/icon_star_bg.gif) left 50% repeat-x; text-align:center; margin:25px 15px;}
.chefhome_ranking {padding:0;}
.chefhome_ranking h3 {color:#333; font-weight:bold; padding:0 6px;}
.chefhome_ranking h3 span {font-size:15px; color:#999; font-weight:normal; margin-left:4px;}
.chefhome_ranking .ranking_list {margin:18px 16px 0;}
.chefhome_ranking .ranking_list .thumbnail {width:144px; border-radius:0; padding:0; height:218px; border:1px solid #ddd; display:inline-block; vertical-align:top; position:relative; margin:0 21px 5px 0;}
.chefhome_ranking .ranking_list .thumbnail:last-child {margin-right:0;}
.chefhome_ranking .ranking_list .thumbnail img {}
.chefhome_ranking .ranking_list .thumbnail .caption b {font-size:16px; display:inline-block; padding:4px 0 2px 0;}
.chefhome_ranking .ranking_list .thumbnail .caption p {color:#999; margin:0;}
.chefhome_ranking .ranking_list .thumbnail .num_label {background:#51c351; color:#fff; padding:6px 10px; position:absolute; left:0; top:0; line-height:1; font-size:18px;}
.chefhome_tab {border-bottom:1px solid #ebebeb; padding:5px 0 26px; margin-bottom:30px;}
.chefhome_tab_r {float:right;}
.chefhome_tab_r .form-control {border-radius:0; font-size:13px; line-height:1; height:38px; width:120px; display:inline-block;}
.ranking_list_btn {padding:15px 10px 0; text-align:center;}
.ranking_list_btn a {margin:0 -2px; background:#fbfbfb; border:1px solid #ebebeb; display:inline-block; width:49%; color:#479ffc; font-size:15px; line-height:1; padding:10px 0 11px;}
.ranking_list_btn a:first-child {border-right:0;}
.ranking_list_btn a b {padding-left:5px;}
.chefhome_benefit {background:url(//recipe1.ezmember.co.kr/img/chefhome_img1.jpg) left top no-repeat; width:893px; height:316px; margin:-20px 0 0 -19px; padding:148px 0 0 32px;}
.chefhome_benefit dt {font-size:24px; color:#333;}
.chefhome_benefit dd {font-size:14px; color:#333; line-height:1.6; padding-top:6px;}
.chefhome_benefit2 {padding:40px 0 0 30px;}
.chefhome_benefit2.st2 {padding:15px 0 0 30px;}
.chefhome_benefit2 li {display:inline-block; width:49%; padding-bottom:50px; font-size:13px;}
.chefhome_benefit2 li img {float:left; margin-right:20px; vertical-align:top; margin-bottom:20px;}
.chefhome_benefit2 li b {display:block; font-size:20px; color:#738410; padding:8px 0 4px 0;}
.chefhome_benefit2.st2 li b {color:#e23500;}
.chefhome_benefit2 li a {display:block; color:#666; padding-top:6px; font-weight:bold;}
.chefhome_benefit2 li a u {margin-right:4px;}

.chefhome_cont2 {margin:0 1px 20px; position:relative;}
.chefhome_benefit3 {background:url(//recipe1.ezmember.co.kr/img/benefit_event_00.jpg) left top no-repeat; height:196px; position:relative; padding:20px 0 0 397px;}
.chefhome_benefit3 a img {border:3px solid #ae9b84; width:478px; height:156px;}
.chefhome_benefit3a {background:url(//recipe1.ezmember.co.kr/img/benefit_event_00_1.jpg) left top no-repeat; height:147px; position:relative; padding:22px 0 0 450px;}
.chefhome_benefit3a a {margin-right:8px;}
.chefhome_benefit3a a img {border:3px solid #ae9b84; width:325px; height:102px;}
.chefhome_benefit3_1 {position:absolute; left:-13px; top:35px;}
.chefhome_benefit3_1a {position:absolute; left:-13px; top:16px;}
.chefhome_benefit3_2 {position:absolute; right:-7px; bottom:-6px;}
.chefhome_benefit4 {padding:30px 0 0 24px;}
.chefhome_benefit4a {margin-top:18px;}
.chefhome_benefit4 a {margin-top:10px;}
.chefhome_benefit5 {margin-top:40px; clear:both;}
.chefhome_benefit5 a {float:left;}
.chefhome_benefit6 {background:url(//recipe1.ezmember.co.kr/img/benefit_card_01.jpg) left top no-repeat; height:331px; padding:28px 0 0 354px; position:relative; clear:both;}
.chefhome_benefit6a {background:url(//recipe1.ezmember.co.kr/img/benefit_card_01_1.jpg) left top no-repeat; height:242px; padding:17px 0 0 380px; position:relative; clear:both; margin-top:18px;}
.chefhome_benefit6_1 {position:absolute; left:42px; top:235px;}
.chefhome_benefit6_1a {position:absolute; left:42px; top:180px;}
.chefhome_benefit7 {padding:50px 24px 0;}
.chefhome_benefit7_1 {width:380px; margin-top:32px; display:inline-block;}
.chefhome_benefit7_1 a {position:relative; display:block;}
.chefhome_benefit7_1_over {
	position: absolute; left:0; top:0; width:380px; height:380px; opacity: 0; filter:alpha(opacity=0); z-index:10; background:#3a579d; display:block;
	-webkit-transition: all 0.4s ease-in-out;
	-moz-transition: all 0.4s ease-in-out;
	-o-transition: all 0.4s ease-in-out;
	-ms-transition: all 0.4s ease-in-out;
	transition: all 0.4s ease-in-out;
}
.chefhome_benefit7_1 a:hover .chefhome_benefit7_1_over {opacity: 0.8; filter:alpha(opacity=80);}
.chefhome_benefit7_1_over b {border:2px solid #fff; color:#fff; border-radius:18px; padding:8px 25px; font-size:18px; text-align:center; display:table; margin:170px auto 0; line-height:1;}
.chefhome_benefit7_2 {width:453px; margin:32px 0 0 8px;  display:inline-block;}
.chefhome_benefit7_2 a {position:relative; display:block;}
.chefhome_benefit7_2_over {
	position: absolute; left:0; top:0; width:453px; height:380px; opacity: 0; filter:alpha(opacity=0); z-index:10; background:#fbde00; display:block;
	-webkit-transition: all 0.4s ease-in-out;
	-moz-transition: all 0.4s ease-in-out;
	-o-transition: all 0.4s ease-in-out;
	-ms-transition: all 0.4s ease-in-out;
	transition: all 0.4s ease-in-out;
}
.chefhome_benefit7_2 a:hover .chefhome_benefit7_2_over {opacity: 0.8; filter:alpha(opacity=80);}
.chefhome_benefit7_2_over b {border:2px solid #000; color:#000; border-radius:18px; padding:8px 25px; font-size:18px; text-align:center; display:table; margin:170px auto 0; line-height:1;}
.chefhome_benefit7_3 {width:845px; margin-top:32px; display:inline-block;}
.chefhome_benefit7_3 a {position:relative; display:block;}
.chefhome_benefit7_3_over {
	position: absolute; left:0; top:0; width:845px; height:280px; opacity: 0; filter:alpha(opacity=0); z-index:10; background:#666; display:block;
	-webkit-transition: all 0.4s ease-in-out;
	-moz-transition: all 0.4s ease-in-out;
	-o-transition: all 0.4s ease-in-out;
	-ms-transition: all 0.4s ease-in-out;
	transition: all 0.4s ease-in-out;
}
.chefhome_benefit7_3 a:hover .chefhome_benefit7_3_over {opacity: 0.8; filter:alpha(opacity=80);}
.chefhome_benefit7_3_over b {border:2px solid #fff; color:#fff; border-radius:18px; padding:8px 25px; font-size:18px; text-align:center; display:table; margin:120px auto 0; line-height:1;}

.chefhome_bf1 {background:url(//recipe1.ezmember.co.kr/img/ch_benefit2.jpg) left top no-repeat; width:893px; height:573px;}
.chefhome_bf1a {background:url(//recipe1.ezmember.co.kr/img/ch_apply6.jpg) left top no-repeat; height:581px;}
.chefhome_bf1_zoom {background:#e4cf91; width:695px; padding:10px; margin:0 auto;}
.chefhome_bf1_list {width:695px; height:130px; margin:0 auto; padding-top:20px;}
.chefhome_bf1_list a {width:1%; display:table-cell; text-align:center;}
.chefhome_bf1_list img {vertical-align:top;}
.chefhome_bf1_list .list_bnt1 {text-align:left;}
.chefhome_bf1_list .list_bnt2 {text-align:right;}
.chefhome_bf2 {background:url(//recipe1.ezmember.co.kr/img/ch_benefit5_1.jpg) left top no-repeat; height:178px; padding:54px 0 0 464px;}
.chefhome_bf2 a img {width:362px; height:114px; -webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.3); box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);}

.chefhome_guide {background:url(//recipe1.ezmember.co.kr/img/chefhome_img2.jpg) left top no-repeat; width:893px; height:316px; padding:148px 0 0 32px; margin:-20px 0 0 -19px;}
.chefhome_guide dt {font-size:24px; color:#650807;}
.chefhome_guide dd {font-size:14px; color:#650807; line-height:1.6; padding-top:6px;}
.chefhome_guide2 {background:url(//recipe1.ezmember.co.kr/img/chefhome_img6.jpg) left top no-repeat; width:893px; height:316px; padding:148px 0 0 32px; margin:-20px 0 0 -19px;}
.chefhome_guide2 dt {font-size:24px; color:#650807;}
.chefhome_guide2 dd {font-size:14px; color:#650807; line-height:1.6; padding-top:6px;}
.chefhome_guide3 {padding:20px 26px 0; display:inline-block; vertical-align:top;}
.chefhome_guide3 dd ul {margin:0; padding:6px 0 0 0;}
.chefhome_guide3 dd li {list-style:none; background:url(//recipe1.ezmember.co.kr/img/icon_dot1.gif) 12px 17px no-repeat; padding:9px 0 15px 20px; margin:6px 12px; border-bottom:1px dashed #ccc; font-size:15px;}

.chefhome_cont h2 {color:#650807; font-weight:bold; padding:20px 0 0 40px;}
.chefhome_emblem {background:url(//recipe1.ezmember.co.kr/img/chefhome_img3.jpg) left top no-repeat; width:893px; height:376px; margin:-20px 0 0 -19px; padding:256px 0 0 32px;}
.chefhome_emblem dd {font-size:18px; color:#333; line-height:1.6; padding-top:6px;}
.chefhome_emblem2 {padding:30px 0 0 20px;}
.chefhome_emblem2 dt {font-size:30px; font-weight:bold; color:#70ad40; margin-bottom:5px;}
.chefhome_emblem2 dt b {color:#de4830; padding-right:6px;}
.chefhome_emblem2 dd {font-size:18px;}
.emblem_input {font-size:24px; color:#70ad40; padding:30px 0;}
.emblem_input .form-control {font-size:24px; width:260px; height:80px; border:3px solid #70ad40; border-radius:0; display:inline-block; vertical-align:middle; margin:0 3px 0 8px;}
.emblem_input .btn-primary {font-size:24px; width:138px; height:80px; }
.emblem_noti {margin:0; font-size:14px; color:#de4830; line-height:1.8;}
.emblem_url {background:#e6ecdb; border:1px solid #cfdabc; font-size:24px; color:#000; text-align:center; padding:40px 0; line-height:1; margin-top:15px;}
.emblem_style {padding-top:40px;}
.emblem_style .btn {background:#6a6f74; border:1px solid #585c61; color:#fff; font-size:24px; width:170px; font-weight:normal; padding:10px 45px; line-height:1; margin:18px auto 50px; display:block;}
.emblem_style.st2 {padding-top:40px; width:49%; display:inline-block;}
.chefhome_ncard {background:url(//recipe1.ezmember.co.kr/img/chefhome_img5.jpg) left top no-repeat; width:893px; height:286px; margin:-20px 0 0 -19px; padding:136px 0 0 42px;}
.chefhome_ncard dd {font-size:18px; color:#333; line-height:1.6; padding-top:6px;}

.chefhome_banner {text-align:center; padding-bottom:10px;}
.list_none {font-size:18px; color:#aaa; text-align:center; font-style:italic; padding-bottom:20px;}

.chefhome_cont .nav-tabs3 li img {margin:-2px 0 0 3px; width:22px;}
.chefhome_cont .cont_list {margin:0;}
.btn_extend {border:1px solid #cbcbcb; background:#fff; width:350px; padding:15px 0; margin:20px auto; display:block; font-size:18px; color:#8b8b8b}
.btn_extend:hover {border-color:#999;}
.chefhome_cont .ranking_today_t {padding-bottom:20px; border-bottom:1px solid #e6e7e8; margin-bottom:15px; clear:both;}

.info_list {padding:30px 30px 15px 30px;}
.info_list .media {border-bottom:1px solid #ebebeb; padding:0 0 22px 0;}
.info_list .media-left {padding-right:25px;}
.info_list  h4 {font-weight:bold;}
.info_writer {font-size:12px; color:#777; padding-top:5px; margin:0; display:inline-block;}
.info_writer span {color:#e4e4e4; padding:0 15px;}
.info_writer .cate_view {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_view4.png) left 1px no-repeat; background-size:20px; padding:0 0 0 22px; color:#777;}
.info_writer .cate_comment {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_comment3.png) left 1px no-repeat; background-size:20px; padding:0 0 0 22px; color:#777;}
.info_srarch {width:360px; margin:-6px auto 30px;}
.info_srarch .form-control {height:40px;}
.info_srarch .btn { width:40px; height:40px; border-radius:0; padding:0 0 1px 0;}
.info_srarch2 {width:360px; margin:0; float:right;}
.info_srarch2 .form-control {height:37px; border:1px solid #74b243; border-radius:0; line-height:1;}
.info_srarch2 .btn { width:37px; height:37px; border-radius:0; padding:0; background:#74b243;  border:1px solid #74b243;}
.info_srarch2 .btn span {color:#fff; font-size:16px;}
.info_summary {color:#666; margin:10px 0 8px;}
.info_url {color:#5f99e7; margin-bottom:5px;}
.info_url a {color:#5f99e7;}
.info_srarch select {height:40px; display:inline-block; margin-right:5px; float:left;}

.talk_list h2 {padding:0 40px; margin:35px 0 -5px 0;}
.info_view {padding:0;}
.talk_content {padding:0 40px 80px 40px; font-size:20px; line-height:1.8;}
.write_tag {padding-bottom:25px; clear:both;}
.tagit {margin:17px 17px 8px 17px!important; padding:5px 8px!important; border-radius:0!important;}
.tagit li.tagit-new {padding:0 4px 0 0!important;}
.write_edit {padding:17px 17px 12px 17px;}
.write_edit .glyphicon {font-size:15px; vertical-align:sub; margin-right:2px;}
.write_file {margin:20px 10px;}
.write_file .btn {margin:3px 0;}
.write_file .glyphicon {font-size:15px; vertical-align:sub; margin-right:2px;}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {color:#078b11!important;}
.write_thumbnail {width:80px; height:80px; border:1px solid #ddd; display:inline-block; position:relative; margin:0 -7px 0 0;}
.write_thumbnail img {width:78px; height:78px;}
.write_thumbnail a {position:absolute; right:0; top:0; display:block; background:#000; color:#fff; filter:alpha(opacity=60); opacity:0.6; padding:4px;}
.talk_list .recipe_wrap:last-child {margin-bottom:0;}
.recipe_wrap {border-bottom:1px dashed #ccc; padding:10px 0 50px 0; margin-bottom:40px;}
.recipe_wrap.st2 {border-bottom:none; padding-bottom:0px;}
.recipe_warp_l {display:inline-block; width:330px; vertical-align:top; margin-top:26px;}
.recipe_warp_r {display:inline-block; width:470px; margin-top:10px;}
.recipe_wrap h1 {text-align:center; line-height:1.3; font-size:40px; margin:0;}
.recipe_wrap h1 span {display:block; font-size:14px; color:#999; margin-top:6px;}
.recipe_wrap h1 img {max-width:100%; margin:30px 0 5px 0;}
.recipe_wrap.st2 h1 img {max-width:100%; margin:0 0 5px 0;}
.recipe_info {border:2px solid #ddd; text-align:center; border-radius:20px; margin:20px auto 0; padding:8px 30px 8px 10px; font-size:14px;  display:inline-block;}
.recipe_info b {margin:0 4px 0 20px; display:inline-block;}
.recipe_cont {font-size:16px; margin:40px; line-height:1.8;}
.recipe_cont dt {margin-bottom:6px;}
.recipe_cont dd {line-height:1.8;}
.recipe_cont.st_line {border-bottom:1px dashed #ccc; padding-bottom:20px;}
.iframe_wrap {max-width:100%; margin:0 auto; position:relative; display:block; margin-top:20px; height:0; overflow:hidden; padding-bottom:56.25%;}
.iframe_wrap iframe, .iframe_wrap object, .iframe_wrap embed { width:100%; height:100%; position:absolute; left:0; top:0;}
.recipe_cont.st_line td p {padding-top:0;}
.recipe_cont dl {padding-right:14px; vertical-align:top; margin-bottom:0;}
.recipe_cont_pdt {background:#ffefe5; border:1px solid #d8d8d8; padding:8px; width:250px;}
.recipe_cont_pdt .thumb {width:98px; display:inline-block; margin:0; }
.recipe_cont_pdt .cont {width:120px; display:inline-block; font-size:15px; line-height:1.4; margin:0; font-weight:bold; letter-spacing:-0.02em; vertical-align:middle; padding-bottom:10px;}
.recipe_cont_pdt .cont a {background:#b86941; border-radius:2px; display:block; color:#fff; font-size:12px; width:90px; padding:4px 0; text-align:center; font-weight:normal; margin-top:8px;}


.btn_view {border:2px solid #51c351; border-radius:20px; color:#51c351; margin:30px auto 0; display:block; padding:6px 30px; font-size:14px;}
.btn_view:hover {color:#219e21; border:2px solid #2fa42f;}
.btn_view span {margin-right:4px;}
.recipe_main_img {text-align:center; margin-bottom:30px;}
.recipe_main_img img {max-width:100%;}
.recipe_wrap .table {margin-top:14px;}
.recipe_wrap .table th {width:20%;}
.recipe_wrap .table th, .recipe_wrap .table td {padding:12px 15px; border:none;}
.recipe_wrap .table-striped>tbody>tr:nth-of-type(odd) {background:#ededed;}
.recipe_effect {border:2px solid #77b347; border-radius:4px; position:relative; margin:40px; text-align:center; font-size:16px; padding:26px 15px 18px; line-height:1.4;}
.recipe_effect dt {border-radius:15px; background:#77b347; font-size:16px; color:#fff; text-align:center; padding:4px 20px 0; height:30px; margin-left:-60px; display:inline-block; position:absolute; left:50%; top:-16px;}
.recipe_effect_in {display:inline-block;}
.recipe_effect_in .thumb {position:relative; border:1px solid #d8d8d8; display:table-cell; width:75px; vertical-align:middle;}
.recipe_effect_in .thumb p { position:absolute; left:50%; top:50%; margin:-20px 0 0 -20px;}
.recipe_effect_in .thumb p img {width:40px; height:40px;}
.recipe_effect_in .cont {display:table-cell; padding-left:10px; text-align:left; vertical-align:middle; line-height:1.6;}
.recipe_effect_in .btn_more {font-size:12px; color:#888; border:1px solid #d3d3d3; letter-spacing:-0.03em; display:inline-block; padding:0 12px 0 0; margin-left:6px; line-height:1.2; vertical-align:top;}
.recipe_effect_in .btn_more span {display:inline-block; width:25px; height:25px; vertical-align:middle; background:#d3d3d3; color:#fff; font-size:20px;  text-align:center; margin-right:8px;}


.premium_wrap {padding:0 0 20px 0; margin:0 1px;}
.premium_select {padding:35px 4px 0;}
.premium_select dt {font-size:26px; padding:0 0 16px 4px; color:#000; font-weight:normal;}
.premium_select ul {padding:0;}
.premium_select li {background:#eee; margin-bottom:8px; border-radius:6px; padding:18px 40px; font-size:24px; list-style:none; color:#000;}
.premium_select li span {margin-left:6px; color:#888;}
.premium_select input {vertical-align:text-bottom; margin-right:18px; width:30px; height:30px;}
.premium_select label {font-weight:normal;}
.premium_select_a {padding:24px 0 40px 46px; font-size:20px; color:#666; margin:0;}
.premium_select_a input {margin-right:10px; width:20px; height:20px;}
.premium_select_a a {margin-left:4px; text-decoration:underline; color:#666;}
.premium_select_b {padding:30px 4px 10px; font-size:20px; color:#666; margin:0; text-align:center;}
.premium_select_b .btn {margin-top:50px!important;}
.premium_select_b2 {padding:30px 4px 10px; font-size:11px; color:#666; margin:0; text-align:center;}
.premium_select_b2 .btn {font-size:24px!important; color:#fff; border-radius:4px!important; display:inline-block!important; width:auto!important; margin:0 6px!important; padding:12px 40px!important; border:none;}
.premium_select_b2 .btn.st1 {background:#de4830;}
.premium_select_b2 .btn.st1:hover {background:#d73e25;}
.premium_select_b2 .btn.st2 {background:#479ffc;}
.premium_select_b2 .btn.st2:hover {background:#328eee;}
.modal-body p.premium_select_b3 {padding-top:0;}
.premium_select_b3 .btn {font-size:24px!important; color:#fff; border-radius:4px!important; background:#aaa; display:block; padding:8px 80px; margin:8px auto;}
.premium_select_b3 .btn:hover {background:#9f9f9f;}
.premium_select_c {padding:10px;}
.premium_wrap .btn {background:#479ffc; color:#fff; width:740px; margin:0 auto; display:block; border-radius:0; height:92px; font-size:28px; border:0; font-weight:bold;}
.premium_wrap .btn:hover {background:#3590f0;}
.premium_wrap .btn.st2 {background:#75a031; color:#fff; width:740px; margin:0 auto; display:block; border-radius:0; height:92px; font-size:28px; border:0; font-weight:bold;}
.premium_wrap .btn.st2:hover {background:#668f26;}
.premium_select2 {padding:50px 4px 0;}
.premium_select2 dt {font-size:20px; padding-bottom:14px; border-bottom:1px solid #ccc; color:#000; font-weight:normal;}
.premium_select2 dd {color:#666; font-size:16px; padding-top:20px;}
.premium_select2 dd span {background:url(//recipe1.ezmember.co.kr/img/icon_dot1.gif) 6px 14px no-repeat; background-size:3px; padding-left:18px; display:block; line-height:1.5; margin-bottom:6px;}
.premium_result {padding:40px 62px;}
.premium_result .table {width:760px; background:#fff; border:1px solid #ddd; margin:35px auto;}
.premium_result .table th {background:#f3f4f8; border-right:1px solid #ddd; text-align:center; font-weight:normal; font-size:20px; padding:28px 10px;}
.premium_result .table td {font-size:20px; padding:28px 10px 28px 40px;}
.premium_ticket_date {margin:0 30px; font-size:30px; border-radius:0 0 4px 4px; background:#58150a; color:#fff; text-align:center; padding:14px 0 15px;}
.premium_ticket_none {font-size:40px; text-align:center; padding:60px 0 40px 0; background:url(//recipe1.ezmember.co.kr/img/bg_line.png) center bottom repeat-x; margin:0 60px 15px; color:#000;}
.premium_ticket_none img {display:block; margin:0 auto 30px;}
.premium_result2 {margin:5px 12px 0; border-radius:6px; padding:0 0 8px 0;}
.premium_result2 span {display:block; font-size:50px; color:#000; line-height:1.2; text-align:center; padding:26px 12px 50px 12px;}
.premium_result2 img {display:block; margin:0 auto; padding-bottom:25px;}
.result_guide {border-radius:4px; width:680px; background:#f3f4f8; margin:10px auto 20px; padding:28px 20px 0; text-align:center; font-size:20px; height:86px; color:#de4830;}
.premium_review {padding:60px 70px 10px;}
.premium_review dt {font-size:28px; color:#000; font-weight:normal; line-height:1.2; padding-bottom:44px;}
.premium_review dt b {font-size:60px; display:block; margin-left:-6px;}
.premium_review dt b span {color:#de4830; margin-left:8px;}
.premium_ticket_my {padding:36px 0 0 0; margin:0 62px;}
.premium_ticket_my dt { font-size:26px; colo#000; padding:0 0 10px 6px;}
.premium_ticket_my dd {padding:0 6px;}
.premium_ticket_my .table {margin:0; border:1px solid #ddd; margin-top:2px; font-size:20px; color:#000;}
.premium_ticket_my .table th, .premium_ticket_my .table td {border-bottom:1px solid #ddd; border-right:1px solid #ddd; vertical-align:middle; text-align:center;}
.premium_ticket_my .table th {background:#f3f4f8; padding:28px 10px;}
.premium_ticket_my .table td {background:#fff; padding:10px 2px; line-height:1.5;}
.premium_ticket_my .table td b {color:#de4830;}
.premium_ticket_my .premium_box {background:#f6f6f6; border:1px solid #ddd; margin:0 2px; border-radius:4px; padding:20px 24px 12px;}
.premium_ticket_my .premium_box p { line-height:1.4; margin-bottom:20px;}
.premium_ticket_my .premium_box p b {display:block; font-size:18px; margin-bottom:4px; color:#de4830;}
.premium_ticket_line {background:url(//recipe1.ezmember.co.kr/img/bg_line.png) center top repeat-x; margin:0; height:40px;}
.premium_modal {margin:0 12px; background:#fff; position:relative;}
.premium_modal_tt {position:absolute; left:-5px; top:8px; display:block;}
.premium_modal_tt img {width:116px;}
.premium_modal_close {position:absolute; right:8px; top:8px; display:block;}
.premium_modal_close img {width:25px;}
.premium_modal_cont {padding:10px 0 10px 0;}
.premium_modal_emb {font-size:16px!important; color:#333; text-align:center; margin:0 0 20px 0; line-height:1.7!important;}
.premium_modal_emb img {width:260px; display:block; margin:0 auto 10px;}
.premium_modal_emb b {color:#de4830;}
.premium_modal_emb span {font-size:14px;}
.premium_modal_emb u {display:block; text-decoration:none; font-size:20px; letter-spacing:-0.08em; line-height:1.4; margin-bottom:8px; color:#de4830; font-weight:bold;}

.premium_info {background:#ffdd76; margin:0; position:relative; padding:20px;}
.premium_info.st2 {margin:0; border-radius:0; padding:0 10px 12px;}
.premium_info.st3 {margin:100px 50px 0;}
.premium_info_t {background:url(//recipe1.ezmember.co.kr/img/premium_service_t.png) center top no-repeat; text-align:center; color:#fff; padding:21px 0 0 0; margin:0 auto; width:690px; height:130px; font-size:34px; letter-spacing:-0.08em;}
.premium_info_t.st2 {margin:-74px auto 0;}
.premium_info_cont {text-align:center; padding:20px 10px 18px;}
.premium_info_cont li { padding:10px 0; list-style:none; display:inline-block; font-size:18px; width:19%; text-align:center; vertical-align:top; line-height:1.2;}
.premium_info_cont.st2 {padding:5px 20px 18px;}
.premium_info_cont.st2 li {width:32%;}
.premium_info_cont.st2 p {font-size:22px; color:#72453a; letter-spacing:-0.08em;}
.premium_info_cont.st2 p b {color:#de4830;}
.premium_info_cont li img {display:block; margin:0 auto 8px; width:150px;}
.premium_info_t2 {font-size:24px; margin:0; padding:5px 0 0 0; text-align:center; color:#72453a; letter-spacing:-0.1em;}
.premium_info_t2 b {display:block; font-size:92px; line-height:1.2; margin-bottom:10px; letter-spacing:-0.1em;}
.premium_info_t2 b span {color:#f04848;}
.premium_cash {margin-top:45px; text-align:center; padding:0 56px;}
.premium_cash2 {margin-top:45px; padding:0 56px;}
.premium_cash_in {background:#de4830; border:1px solid #c22d15; width:48%; display:inline-block; margin:0 4px; padding:28px 0 20px; color:#fff; line-height:1.1;  border-radius:4px;}
.premium_cash_in span {font-size:32px;}
.premium_cash_in span em {color:#fffb90; font-style:normal;}
.premium_cash_in b {display:block; font-size:38px; margin:18px 0 15px 0;}
.premium_cash_in label {font-weight:normal; font-size:18px; display:block;}
.premium_cash_in label input {vertical-align:text-bottom; margin-right:5px; width:16px; height:16px;}
.premium_cash_in2 {background:#de4830; border:1px solid #c22d15; width:100%; display:block; margin:0; padding:42px 0 44px; color:#fff; line-height:1.2;  border-radius:4px; text-align:center;}
.premium_cash_in2 span {font-size:44px; display:inline-block;  vertical-align:middle; margin-right:25px;}
.premium_cash_in2 span em {color:#fffb90; font-style:normal;}
.premium_cash_in2 b {display:inline-block; font-size:56px;  vertical-align:middle;}
.premium_select_s {margin:20px 0 0 0; background:#ffead5; border:2px solid #e5bd96; border-radius:4px; padding:10px 12px 0; text-align:center; position:relative;}
.premium_select_s.st2 {background:#fff; border:0;}
.premium_select_s.st3 {margin:30px 50px 20px;}
.premium_select_s_in {background:url(//recipe1.ezmember.co.kr/img/mobile/premium_sns.png) left top no-repeat; background-size:80px; margin:0 0 0 30px; padding:12px 0 24px 90px; font-size:20px; letter-spacing:-0.1em; line-height:1.4; text-align:left; display:table;}
.premium_select_s_in b {font-size:28px; display:block;}
.premium_select_s_in b span {color:#de4830;}
.premium_select_s_in2 {position:absolute; right:30px; top:40px;}
.premium_select_s_in2 .btn-sm {border:0; font-size:18px; padding:4px 25px; margin:0 4px;}
.premium_select_s_in2 .btn-sm.sns_k {background:#ffe400; border:1px solid #c7b416; color:#554c0c; }
.premium_select_s_in2 .btn-sm.sns_f {background:#3b5997; border:1px solid #244282; color:#fff; }
.premium_select_copy {width:500px; margin:0 auto 20px;}
.premium_select_copy .form-control {width:390px; height:100px; display:inline-block;}
.premium_select_copy .btn {width:100px; display:inline-block; height:100px; vertical-align:top; margin-left:8px; padding:0; text-align:center;}

.premium_cash_in3 {background:#de4830; border:1px solid #c22d15; width:100%; display:block; margin-bottom:8px; color:#fff; line-height:1;  border-radius:4px;}
.premium_cash_in3 span {font-size:20px; display:inline-block; width:460px;  vertical-align:middle; font-weight:normal;}
.premium_cash_in3 span em {color:#fffb90; font-style:normal;}
.premium_cash_in3 b {display:inline-block; font-size:20px; width:150px; text-align:center;  vertical-align:middle;}
.premium_cash_in3 em {font-style:normal; display:inline-block; width:110px; text-align:center;}
.premium_cash_in3 label {font-weight:normal; font-size:18px; display:block; padding:20px 10px 16px 30px;}
.premium_cash_in3 label input {vertical-align:text-bottom; margin-right:5px; width:16px; height:16px;}

.invitation_msg {margin:0 10px; padding:12px; background:#ffdd76; border:2px solid #f3ce5f;}
.invitation_msg p {margin:0 0 10px 0; line-height:1.5; font-size:14px; padding:8px;}
.invitation_msg a {background:#fff; border-radius:4px; display:block; border:1px solid #f3ce5f; padding:8px 15px; color:#777;}
.invitation_msg img {width:36px; margin-right:10px;}

.review_list {padding:0 0 40px 8px;}
.review_list .info_pic {width:126px; display:inline-block; vertical-align:top; padding-top:3px;}
.review_list .info_pic img {width:100px; border-radius:50%;}
.review_list .info_cont {display:inline-block; width:610px;}
.review_list .info_name {padding:0 0 6px 2px; font-size:24px;}
.review_list .summary {background:#cdcdd1; border-radius:4px; position:relative; color:#4d383d; padding:22px; font-size:20px;}
.review_list .summary_arrow {position:absolute; left:-21px; top:2px; margin:0;}
.summary_arrow2 {margin:0; text-align:center;}
.premium_view {margin:0 -20px -20px -20px; background:#59493f; font-size:28px; padding-top:30px; height:100px; text-align:center;}
.premium_view a {color:#fffb90; text-decoration:underline;}
.premium_select_wrap {padding:15px 62px 40px;}

.premium_view2 {padding:0; background:#fff;}
.premium_view2 .panel-group {margin:0 0 0 0; border-top:1px solid #ddd;}
.premium_view_tit img {width:170px; margin-left:-4px;}
.premium_view_tit .r_kcal {float:right; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_kcal.png) left top no-repeat; background-size:22px; padding:4px 0 4px 24px; display:inline-block; margin:18px 8px 0 0;}
.premium_view2 .panel-heading {padding:0; border-bottom:1px solid #ddd!important;}
.premium_view2 .panel-title a.collapsed .btn_arrow {float:right; margin:5px 15px 0 0; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_arrow5.png) left top no-repeat; background-size:24px; width:24px; height:20px; display:block;}
.premium_view2 .panel-title a.collapsed {display:block; padding:14px 15px; font-size:15px; background:#eee; color:#666;}
.premium_view2 .panel-title a.collapsed b {color:#479ffc;}
.premium_view2 .panel-title a .btn_arrow {float:right; margin:5px 15px 0 0; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_arrow5_1.png) left top no-repeat; background-size:24px; width:24px; height:20px; display:block;}
.premium_view2 .panel-title a {display:block; padding:14px 15px; font-size:15px; background:#479ffc; color:#fff;}
.premium_view2 .panel-title a b {color:#fff;}
.premium_view2 .panel-collapse {background:#fbfbfb; color:#666; font-size:14px;}
.premium_view2 .panel-body {padding:12px 15px;}
.premium_view2 .panel-group .panel+.panel {margin-top:0;}
.panel-collapse.in {border-bottom:1px solid #ddd;}

.error_page {margin:0 auto; padding:30px; width:820px;}
.error_page dt {border-bottom:2px solid #77b347; padding:0 0 16px 6px;}
.error_page dt img {width:120px;}
.error_page dt .pull-right {font-size:12px; font-weight:normal; padding:25px 6px 0 0;}
.error_page dt .pull-right a {color:#666;}
.error_page dt .pull-right span {color:#ccc; margin:0 10px;}
.error_page dd {padding:40px 10px; line-height:2; font-size:14px; color:#666;}
.error_page dd h5, .error_page dd h4, .error_page dd h3, .error_page dd h2, .error_page dd h1 {font-weight:bold; padding-bottom:15px; color:#000;}
.error_page dd a {text-decoration:underline;}

.issue_top { text-align:center;}
.issue_top .issue_top_info { line-height:1.6; position:relative; padding:45px 0 22px 0; border-bottom:1px solid #e4e4e4;}
.issue_top .issue_top_info0 {position:absolute; left:0; top:-50px; z-index:100; width:100%;}
.issue_top .issue_top_info0 img {width:100px; -webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.3); box-shadow: 0 0 4px rgba(0, 0, 0, 0.3); border-radius:50%;}
.issue_top .issue_top_info1 {font-size:26px; display:block; padding-top:16px;}
.issue_top .issue_top_info2 {color:#333; font-size:16px; display:block; padding-top:8px;}
.issue_top .issue_top_info2 img {height:22px; margin-top:-2px;}
.issue_top .issue_top_info3 {color:#999; font-size:16px; display:block; padding-top:2px;}

.right_sns_wrap {position:relative; margin:0 auto; width:1240px; line-height:0; height:0;}
.right_sns {position:fixed; z-index:1000; width:129px; background:url(//recipe1.ezmember.co.kr/img/rmn_sns.png?v.3) left top no-repeat; text-align:center; margin-left:-129px;}
.right_sns_f {height:103px; padding-top:30px;}
.right_sns_k {height:106px; padding-top:10px;}
.right_sns a {margin-bottom:6px; display:block;}



.shop_cate {-webkit-box-shadow:0 0 3px rgba(0, 0, 0, 0.2); box-shadow:0 0 3px rgba(0, 0, 0, 0.2); position:relative; padding-left:160px; height:107px; background:#fff;}
.shop_cate .shop_cate_tt {position:absolute; left:0; top:-1px; margin:0; padding:0; z-index:10;}
.shop_cate .nav-tabs li {background:#fff; border-right:1px solid #eee; margin:0; font-size:14px; text-align:center;}
.shop_cate .nav-tabs li:last-child {border-right:0;}
.shop_cate .nav-tabs li a {padding:21px 0 0 0;}
.shop_cate .nav-tabs.nav-justified, .shop_cate .nav-tabs.nav-justified li a, .shop_cate .nav-tabs.nav-justified .active a, .shop_cate .nav-tabs.nav-justified .active a:focus {border:0; height:107px; border-radius:0; background-color:transparent; color:#444;}
.shop_cate .nav-tabs li a img {display:block; margin:0 auto 3px; width:38px; height:38px;}
.shop_cate .nav-tabs li a span {padding-bottom:3px; width:100%;}
.shop_cate .nav-tabs li.active a span {color:#74b243; border-bottom:4px solid #74b243;}
.shop_list .thumbnail {margin:14px 10px 6px 0; border-radius:0; width:240px; padding:0; position:relative; float:left;}
.shop_list .thumbnail:nth-child(5n+5) {margin-right:0;}
.shop_list .thumbnail .vod_label {position:absolute; left:84px; top:84px; z-index:10;}
.shop_list .thumbnail .time_label {display:inline-block; border-radius:0 15px 15px 0; height:34px; background:#ff321b; padding:6px 15px 0 10px; color:#fff; font-size:15px; position:absolute; left:0; top:10px;}
.shop_list .thumbnail .time_label img {margin:0 5px 2px 0; }
.shop_list .thumbnail .caption {padding:11px 0 0 0; line-height:1.4; border-top:1px solid #ebebeb;}
.shop_list .thumbnail .caption_tit {font-size:14px; padding:0 15px; height:38px;}
.shop_list .thumbnail .caption_price {color:#ff321b; font-size:16px; padding:0 15px 12px;}
.shop_list .thumbnail .caption_price b {color:#000; font-family:'Poppins', 'Nanum Gothic'; margin-left:6px;}
.shop_list .thumbnail .caption_price span {color:#666; font-size:12px;}
.shop_list .thumbnail .caption_name {border-top:1px solid #ebebeb; padding:8px 15px 9px; margin:0;}
.shop_list .thumbnail .caption_name img {width:36px; height:36px; border-radius:50%; margin:0; display:inline-block; margin-right:5px;}
.shop_list .thumbnail .caption_name a {color:#999;}

.shop_search {font-size:18px; color:#333; line-height:1; padding:40px 0 4px 4px;}
.shop_search b {font-size:30px; color:#74b243; margin-right:3px;}
.shop_search strong {color:#ff321b;}

.view_info.st3 .info_title p {font-size:28px; padding:5px 50px 0 0; margin-left:-3px;}
.view_info.st3 .info_title.st2 {width:440px;}
.view_info.st3 .info_title.st2 p {font-size:28px; padding:5px 0 0 0;}
.view_info.st3 .info_title.st2 img {margin:20px 0 5px 0;}
.view_info.st3 .info_price {font-size:38px; letter-spacing:-0.04em; font-family:'Poppins', 'Nanum Gothic';}
.view_info.st3 .info_price b {font-size:48px; color:#ff321b; font-weight:normal; margin-right:10px;}
.view_info.st3 .info_price small {font-size:70%;}
.view_info.st3 .info_price span {font-size:18px; margin-left:2px;}
.view_info.st3 .info_price s {font-size:18px; color:#bbb; margin-left:12px;}
.view_info.st3 .info_price .info_price1, .view_info.st3 .info_price .info_price2 {font-size:15px;  font-family:'Nanum Gothic'; letter-spacing:0; }
.view_info.st3 .info_price .info_price1 {color:#999; margin:15px 0 5px 4px;}
.view_info.st3 .info_price .info_price2 {color:#666; margin:0 0 8px 4px;}
.view_info.st3 .info_price .info_price1 img, .view_info.st3 .info_price .info_price2 img {margin:0 6px 4px 0; width:34px; height:22px;}
.view_info.st3 .info_buy_btn {margin:30px 0 10px 0;}
.view_info.st3 .info_buy_btn .btn {border:1px solid #5fa900; font-size:24px; border-radius:2px; width:370px; -webkit-box-shadow:inset 1px 1px 0 rgba(255, 255, 255, 0.4); box-shadow:inset 1px 1px 0 rgba(255, 255, 255, 0.4);
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#70c206+0,4b8f13+100 */
background: #70c206; /* Old browsers */
background: -moz-linear-gradient(top,  #70c206 0%, #4b8f13 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #70c206 0%,#4b8f13 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #70c206 0%,#4b8f13 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#70c206', endColorstr='#4b8f13',GradientType=0 ); /* IE6-9 */
}
.view_info.st3 .info_buy_btn.st2 .btn {width:inherit; font-size:19px; padding:12px 60px; vertical-align:middle;}
.view_info.st3 .info_buy_btn.st2 .btn.st2 {border:1px solid #999; border-radius:2px;  -webkit-box-shadow:inset 1px 1px 0 rgba(255, 255, 255, 0.4); box-shadow:inset 1px 1px 0 rgba(255, 255, 255, 0.4);
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#c4c4c4+0,a0a0a0+100 */
background: #c4c4c4; /* Old browsers */
background: -moz-linear-gradient(top,  #c4c4c4 0%, #a0a0a0 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #c4c4c4 0%,#a0a0a0 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #c4c4c4 0%,#a0a0a0 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4c4c4', endColorstr='#a0a0a0',GradientType=0 ); /* IE6-9 */
}
.view_info.st3 .info_buy_btn.st2 .btn.st2 b.icon {vertical-align:middle; background:none; display:inline-block; padding-right:0; -webkit-text-shadow:0 0 2px rgba(0, 0, 0, 0.6); text-shadow:0 0 2px rgba(0, 0, 0, 0.6); color:#fff;}
.view_info.st3 .info_buy_btn .btn:hover {background:#559702;}
.view_info.st3 .info_buy_btn.st2 .btn.st2:hover {background:#aaa;}
.view_info.st3 .info_buy_btn .btn.st3 {border:1px solid #666; font-size:24px; border-radius:2px; width:370px; -webkit-box-shadow:inset 1px 1px 0 rgba(255, 255, 255, 0.4); box-shadow:inset 1px 1px 0 rgba(255, 255, 255, 0.4);
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#70c206+0,4b8f13+100 */
background: #70c206; /* Old browsers */
background: -moz-linear-gradient(top,  #757575 0%, #515151 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #757575 0%,#515151 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #757575 0%,#515151 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#757575', endColorstr='#515151',GradientType=0 ); /* IE6-9 */
}
.view_info.st3 .info_buy_btn.st2 .btn.st3:hover {background:#555;}
.view_info.st3 .info_buy_btn.st2 .btn.st3 b.icon {vertical-align:middle; background:url(//recipe1.ezmember.co.kr/img/icon_arrow7.png) right center no-repeat; display:inline-block; padding-right:22px; -webkit-text-shadow:0 0 2px rgba(0, 0, 0, 0.6); text-shadow:0 0 2px rgba(0, 0, 0, 0.6); color:#fff;}
.view_info.st3 .info_buy_btn .btn b.icon {vertical-align:middle; background:url(//recipe1.ezmember.co.kr/img/icon_arrow6.png) right center no-repeat; display:inline-block; padding-right:22px; -webkit-text-shadow:0 0 2px rgba(0, 0, 0, 0.6); text-shadow:0 0 2px rgba(0, 0, 0, 0.6); color:#fff;}
.view_info.st3 .info_share_btn { margin-top:5px; padding-left:40px; width:auto; float:right;}
.info_buy_btn_wrap {float:left; width:560px;}
.info_buy_btn_area {display:table-cell; width:1%; padding-right:6px;}
.view_info.st3 .info_buy_btn.st2 .info_buy_btn_area .btn {font-size:20px; padding:12px 0; text-align:center; vertical-align:middle; width:100%;}

.premium_cont { padding:10px 25px;}
.premium_cont h3 {font-weight:bold;}
.premium_my {background:#fffbe2; border:2px solid #d8cb8e; border-radius:10px; padding:10px 30px; margin:0; list-style:none}
.premium_my li {font-size:15px; color:#000; padding:14px 10px; line-height:1; border-bottom:1px dashed #ccc; font-weight:bold;}
.premium_my li:last-child {border:none;}
.premium_my li span {color:#666; border-right:1px solid #ddd; display:inline-block; width:140px; margin-right:20px; font-weight:normal;}
.premium_list {padding-top:15px;}
.premium_list_s {border-bottom:1px solid #d6d6d6; padding:40px 10px 40px 20px;}
.list_s_left {background:#de4830; border:1px solid #c22d15; border-radius:4px; color:#fff; font-size:26px; text-align:center; padding:30px 0px; width:240px; margin-right:20px; display:inline-block;}
.list_s_right {display:inline-block; vertical-align:top;}
.list_s_price {list-style:none; margin:0; padding:0; width:540px; font-size:15px; color:#000; letter-spacing:-0.05em;}
.list_s_price li div {padding:9px 0; border-bottom:1px dashed #ccc;}
.list_s_price .price_tit {width:316px; display:inline-block; }
.list_s_price .price_1 {width:95px; display:inline-block; text-align:center; border-right:2px solid #bababa; border-left:2px solid #bababa;}
.list_s_price .price_2 {width:20px; color:#ff4d4d; display:inline-block; text-align:center; font-size:12px;}
.list_s_price .price_3 {width:95px; display:inline-block; text-align:center; font-weight:bold; color:#de1111; border-right:2px solid #ff4d4d; border-left:2px solid #ff4d4d;}
.list_s_price li:first-child .price_tit {padding:5px 0; border:none;}
.list_s_price li:first-child .price_1 {background:#bababa; color:#fff; padding:5px 0; border:none;}
.list_s_price li:first-child .price_2 {padding:5px 0; border:none;}
.list_s_price li:first-child .price_3 {background:#ff4d4d; color:#fff; padding:5px 0; border:none;}
.list_s_price li:last-child .price_1 {border-bottom:2px solid #bababa;}
.list_s_price li:last-child .price_3 {border-bottom:2px solid #ff4d4d;}
.list_s_info {padding-top:14px;}
.list_s_info .info_txt {font-size:13px; color:#888; display:inline-block; line-height:1.8;}
.list_s_info .info_btn { display:inline-block; vertical-align:top; float:right; padding-top:4px;}

.list_s_info .info_btn .btn {border:1px solid #5fa900; font-size:16px; border-radius:2px; width:190px; -webkit-box-shadow:inset 1px 1px 0 rgba(255, 255, 255, 0.4); box-shadow:inset 1px 1px 0 rgba(255, 255, 255, 0.4); color:#fff; margin-left:5px;
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#70c206+0,4b8f13+100 */
background: #70c206; /* Old browsers */
background: -moz-linear-gradient(top,  #70c206 0%, #4b8f13 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #70c206 0%,#4b8f13 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #70c206 0%,#4b8f13 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#70c206', endColorstr='#4b8f13',GradientType=0 ); /* IE6-9 */
}
.list_s_info .info_btn .btn:hover {background:#559702;}




.homeshop_list .media {border-bottom:1px solid #ebebeb; padding:20px 0;}
.homeshop_list .list_logo {padding:0 40px 0 30px;}
.homeshop_list .list_pic {padding-right:40px; position:relative;}
.homeshop_list .list_pic .vod_label {position:absolute; left:47px; top:47px; z-index:10;}
.homeshop_list .list_pic .vod_label img {width:56px;}
.homeshop_list .media-body {width:450px; padding-right:50px;}
.homeshop_list .list_clock {font-size:13px; color:#888; margin-bottom:6px;}
.homeshop_list .list_clock img {margin-right:4px;}
.homeshop_list .list_tit {font-size:16px; margin-bottom:8px;}
.homeshop_list .list_price {font-size:20px; font-family:'Poppins', 'Nanum Gothic'; font-weight:bold; margin-bottom:14px;}
.homeshop_list .list_price b {color:#ff321b; margin-right:6px;}
.homeshop_list .list_price span {font-size:14px; font-weight:normal;}
.homeshop_list .list_price s {font-size:12px; color:#aaa; font-weight:normal; margin-left:8px;}
.homeshop_list .list_price2 {margin:0; font-size:13px; color:#999;}
.homeshop_list .list_price2 span {margin-right:14px;}
.homeshop_list .info_buy_btn2 { padding-right:30px;}
.homeshop_list .info_buy_btn2 .btn {border:1px solid #5fa900; font-size:17px; border-radius:2px; -webkit-box-shadow:inset 1px 1px 0 rgba(255, 255, 255, 0.4); box-shadow:inset 1px 1px 0 rgba(255, 255, 255, 0.4); -webkit-text-shadow:0 0 2px rgba(0, 0, 0, 0.6); text-shadow:0 0 2px rgba(0, 0, 0, 0.6); color:#fff; width:70px; height:70px; padding:0; line-height:1.2;
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#70c206+0,4b8f13+100 */
background: #70c206; /* Old browsers */
background: -moz-linear-gradient(top,  #70c206 0%, #4b8f13 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #70c206 0%,#4b8f13 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #70c206 0%,#4b8f13 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#70c206', endColorstr='#4b8f13',GradientType=0 ); /* IE6-9 */
}
.homeshop_list .info_buy_btn2 .btn:hover {background:#559702;}


.rmn_campaign {padding:24px 0;}
.rmn_campaign h4 {text-align:center; font-weight:bold;}
.rmn_campaign ul {margin:0 auto; width:200px; margin-top:22px; padding:0;}
.rmn_campaign li {margin-bottom:32px; list-style:none;}
#right_area .rmn_campaign li img {width:200px; height:200px; border:1px solid #eaeaea; -webkit-box-shadow:none; box-shadow:none;}
.rmn_campaign_tit {color:#666; font-size:13px; padding-top:8px; margin-bottom:3px;}
.rmn_campaign_tit b {display:block; color:#333; font-size:14px; font-weight:normal;}
.rmn_campaign_price {font-size:15px; color:#000; font-family:'Poppins', 'Nanum Gothic'; font-weight:bold;}
.rmn_campaign_price span {color:#ff321b; margin-right:4px;}


.chef_search { padding-top:4px; margin:0 -10px 0 0;}
.chef_search .form-control {border-radius:0 !important; width:240px; height:34px; background:#fff; padding:0 0 0 32px; display:inline-block; vertical-align:middle;}
.chef_search .glyphicon {position:absolute; left:8px; top:10px; z-index:100; font-size:20px; color:#ccc;}
.chef_search .btn.search {background:#f7f7f7; border:1px solid #ccc;; width:60px; height:34px; padding:0 0 1px 0 ; margin:1px 5px 0 -6px; color:#333; font-size:14px; font-weight:bold; text-align:center; border-radius:0 3px 03px 0;}
.chef_search .btn.apply {font-size:14px; color:#000; padding:0 20px; border:1px solid #d3d3d3; background:#fff; height:34px;}
.chef_search .btn.apply b {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_confirm2.png) left top no-repeat; background-size:16px; padding-left:20px;}

.chef_list3 { padding-top:15px;}
.chef_list3 .media {padding:25px 50px 20px; margin:0 0 8px 0; border-bottom:1px solid #d5d6d7;}
.chef_list3 .media-left {padding-right:18px;}
.chef_list3 .media-object {width:66px; height:66px; border-radius:50%; border:1px solid #e6e6e6;}
.chef_list3 .media-heading {padding:10px 0 0 0; margin:0;}
.chef_list3 .info_cont_name {font-size:18px; font-weight:bold; margin:0 0 6px 0; line-height:1;}
.chef_list3 .info_cont_hit {color:#666; font-size:15px; font-weight:200; margin:0;}
.chef_list3 .info_cont_hit b {margin:0 10px 0 2px;}
.chef_list3 .info_recipe {padding:18px 0 0 0;}
.chef_list3 .info_recipe a {margin-right:5px; display:inline-block;}
.chef_list3 .info_recipe a img {width:140px; height:140px;}
.info_reply {margin-top:18px;}
.info_reply dt {line-height:1; margin-top:12px;}
.info_reply dt b {color:#de4830; margin-right:4px;}
.info_reply_star img {width:15px; margin:-1px 1px 0 0;}
.info_reply dd {color:#555; margin:4px 0; line-height:1.4; font-size:15px;}

.my_tabs {padding:21px 21px 0;}
.my_tabs .nav-tabs li a {padding:15px 0;}
.my_tabs .nav-tabs li span {margin:1px 6px 0 0; vertical-align:inherit;}

.app_install {background:url(//recipe1.ezmember.co.kr/img/install_bg.gif) left top no-repeat; height:66px; width:1240px; margin:0 auto 6px; padding:10px 22px 0 30px; color:#fff; font-size:14px; position:relative; line-height:1.4;}
.app_install p {display:table-cell; vertical-align:middle; margin:0;}
.app_install p img {padding-right:10px;}
.app_install_r { position:absolute; right:20px; top:12px;}


table.sp_buy {width:94%; margin:0 auto;}
table.sp_buy.st2 {width:780px; margin:20px 0 0 0; border-top:1px solid #dedede;}
.sp_buy .input-sm {border-radius:3px; padding:8px 5px; font-size:14px; height:inherit; background:#f7f7f7; border:1px solid #ccc;}
.sp_buy .buy_price {color:#888; text-decoration:line-through; line-height:1; float:left;}
.sp_buy .buy_price2 { font-size:18px; line-height:1; color:#e40000; font-weight:bold; float:left;}
.sp_buy .buy_price2_1 {color:#888; font-size:13px; margin-left:2px; font-weight:normal;}
.sp_buy th {padding:15px 10px; width:100px;}
.sp_buy td {padding:6px 10px;}
.sp_buy th, .sp_buy td {border-bottom:1px solid #e6e6e6;}
.sp_buy .fa {font-size:20px; margin:0 12px; vertical-align:middle;}
.sp_buy td .buy_select {margin:15px 0;}
.sp_buy td .buy_select .form-group {margin:0;}
.sp_buy td .buy_select .glyphicon {color:#888; margin:0 6px;}
.sp_buy .price_total {font-weight:bold; background:#fffcd8; line-height:1; padding:12px 10px 14px;}
.buy_select .btn_del { margin-left:5px; vertical-align:text-bottom;}

.sp_cont {padding:25px 50px 40px; border-bottom:10px solid #f1f1f2; margin:0 -1px;}
.sp_cont.st2 {padding:25px 30px 20px; border:none}
.sp_cont .cont_tit, .sp_cont dt {font-size:20px; font-weight:normal; margin:0; width:100%; line-height:50px; font-weight:bold; padding:0 5px;}
.sp_cont .table {border-top:2px solid #ddd; border-bottom:2px solid #ddd; margin:0;}
.sp_cont .table th {padding:14px 0; text-align:center; background:#f6f6f6; line-height:1;}
.sp_cont .table th span label {font-weight:normal; font-size:13px; color:#888; display:block; margin-top:5px;}
.sp_cont .table label input {vertical-align:sub; margin-right:4px;}
.sp_cont .table td {padding:12px;}
.sp_cart_pic { display:table-cell; vertical-align:middle; padding:5px 20px 5px 0;}
.sp_cart_tit { display:table-cell; vertical-align:middle;}
.sp_cart_tit {font-weight:bold; font-size:15px;}
.sp_cart_tit span {font-weight:normal; color:#999; font-size:13px; display:block; margin:2px 0;}
.sp_cart_tit u {text-decoration:none; color:#c41209; margin:0 1px;}
.sp_cart_tit .btn-xs {font-weight:normal; margin:0 6px;}
.sp_cart_cash {font-weight:bold; color:#000; text-align:center;}
.sp_cart_cash2 b {color:#e40000; text-align:center; font-size:18px; margin-right:2px;}
.sp_cont .table input {border:1px solid #ccc; padding:4px 6px;}
.sp_cont .table .btn_zip {height:30px; vertical-align:top; margin-left:2px;}
.sp_cont .table .sp_cart_comm {margin:8px 0 12px 0;}
.sp_cont .table .sp_cart_comm:last-child {margin-bottom:0;}
.sp_cont .table .sp_cart_comm input {display:block; margin:8px 0;}
.sp_btn {padding:40px 0 20px 0; text-align:center;}
.sp_btn2 {margin:0; padding-top:10px;}
.sp_btn2 .btn-xs {margin:0 4px;}
.sp_order_step {display:block; font-size:17px; color:#67b700; margin-bottom:8px;}
.sp_order_search {padding:0; float:right; margin:-6px -30px 0 0;}
.sp_order_search .form-group {margin-right:5px;}
.sp_order_search .form-group .form-control {height:34px; vertical-align:middle;}
.sp_order_search .input-group {vertical-align:text-top; margin:-3px 0 0 0;}
.sp_order_search .info_srarch .btn {width:34px; height:34px; vertical-align:text-bottom;}

.step_add { font-size:16px!important; color:#888; padding:0 0 0 32px!important; line-height:1.6; margin:14px 0 0 0;}
.add_material {background:url(//recipe1.ezmember.co.kr/img/mobile/app_icon_step_material.png) left top no-repeat; background-size:26px 26px;}
.add_tool {background:url(//recipe1.ezmember.co.kr/img/mobile/app_icon_step_tool.png) left top no-repeat; background-size:26px 26px;}
.add_fire {background:url(//recipe1.ezmember.co.kr/img/mobile/app_icon_step_fire.png) left top no-repeat; background-size:26px 26px;}
.add_tip {background:url(//recipe1.ezmember.co.kr/img/mobile/icon_tip2.png?v.1) 10px 6px no-repeat  #fffde2; background-size:29px 25px; border:1px dashed #ff7171; padding:9px 9px 9px 35px; color:#666;}
.add_tip2 {background:url(//recipe1.ezmember.co.kr/img/mobile/app_icon_step_tip.png) left -2px no-repeat; background-size:26px 26px;}
.add_vod {background:url(//recipe1.ezmember.co.kr/img/mobile/app_icon_step_video.png) left top no-repeat; background-size:26px 26px;}
.add_info {background:url(//recipe1.ezmember.co.kr/img/mobile/app_icon_step_info.png) left top no-repeat; background-size:26px 26px;}
.add_store {background:url(//recipe1.ezmember.co.kr/img/mobile/app_icon_step_store.png?v.1) left -2px no-repeat; background-size:26px 26px;}
.add_store a {color: #74b243; vertical-align: text-top;}
.add_store_request {font-size:16px!important; color:#888; padding: 0 0 0 0; line-height:1.6; margin:14px 0 0 0;}
.add_store_request a {color:#f37466; vertical-align: text-top; text-decoration: underline;}
.add_store_request span {color:#f37466; font-size: 20px; text-align: center; width: 28px; vertical-align: -3px;}
.add_store_request_icon {background: #f37466; color: #fff; padding:4px 6px 6px; line-height: 1; border-radius: 3px; font-size: 13px; display: inline-block; margin: -1px 3px 0;}

.chef2_top {background:url(//recipe1.ezmember.co.kr/img/chef2_top.jpg) left top no-repeat; height:494px; padding:338px 0 0 462px; color:#444; font-size:14.5px; line-height:1.7;}
.chef2_top p {margin:0; font-weight:bold; color:#000;}
.chef2_top p img {margin-right:7px;}
.chef2_top .chef2_top1 {margin-top:15px;}
.chef2_top .chef2_top2 {margin-top:7px;}
.chef2_benefit {padding:0 50px; background:#fff;}
.chef2_sns {text-align:center; background:#fff; padding-bottom:80px;}
.chef2_sns_tit {padding:90px 0 45px 0;}
.chef2_sns a {margin:0 4px;}
.chef2_sns_tit2 {padding:75px 0 40px 0;}
.chef2_sns_tit3 {padding:0 0 30px 0;}
.chef2_sns_tit4 {padding:0 0 10px 0;}

.print_wrap {width:100%; margin:0 auto;}
.print_top .top_tag {float:right; padding:0; border:3px solid #ccc; margin-left:20px;}
.print_top .top_tag b {display:block; text-align:center; margin-top:-15px;}
.print_top .top_tit {padding-bottom:30px;}
.print_top .top_tit .title {font-weight:bold; line-height:1.3; padding:35px 0 10px 8px; font-size:28px;}
.print_top .top_tit .cont {padding:5px 0 0 10px; }
.print_top .top_tit .cont span {padding-right:50px;}
.print_top .top_tit .cont span img {padding-right:4px; margin-top:-4px;}
.print_top .top_tit .cont span.name {float:right; font-weight:bold; color:#999; background:none; padding:0;}
.print_top2 {color:#888; font-size:11px; border-bottom:1px solid #ddd; margin-bottom:-1px; padding:10px;}
.print_wrap .cont_ingre2 {margin:0 0 0 10px; padding-top:5px;}
.print_wrap .cont_ingre2 .ready_ingre3 {padding-bottom:5px;}
.print_step {padding:0; margin-top:5px;}
.print_step ol {padding:5px 10px 0 30px;}
.print_step ol li {padding-bottom:8px; line-height:1.6; color:#000; font-size:15px;}
.print_step ol li p {display:block; color:#999; padding:5px 0 0 0; margin:0;}
.print_step ol li p b {margin-right:6px; color:#000;}
.print_wrap .ready_ingre3_tt {}
.print_wrap .ready_ingre3 {padding:0 ; margin:0 -25px; color:#666; line-height:1.8;}
.print_wrap .ready_ingre3 li {margin:0 22px;}
.print_wrap  .best_tit { padding:0; font-size:16px;}
.print_step  .best_tit {padding-left:10px;}
.print_step.tip {margin-top:-15px;}
.print_btm {text-align:center; color:#999; padding:20px 0 10px 0;}
.step_tip { padding:5px 10px 10px;}

.ch_home {padding-top:5px}
.ch_home dl {display:inline-block; margin-bottom:5px; vertical-align:top;}
.ch_home dt {font-size:24px; padding:0 0 8px 2px;}
.ch_home ul {padding:6px 22px; margin:0; list-style:none;}
.ch_home li {border-bottom:1px dashed #cbcbcb; font-size:15px; line-height:1; background:url(//recipe1.ezmember.co.kr/img/icon_arrow8.png) 5px 18px no-repeat; padding:15px 0 0 18px; height:47px;}
.ch_home li span {border-right:1px solid #d5d5d5; width:130px; display:inline-block; margin-right:12px;}
.ch_home li b {color:#43880c;}
.ch_home li a {color:#e12a00; text-decoration:underline; margin-right:3px; font-weight:bold;}
.ch_home li:last-child {border:none;}
.ch_home_info {width:423px;}
.ch_home_info dd {background:#f4f4f4; border:1px solid #ddd; height:200px;}
.ch_home_premium {width:423px; margin-left:5px;}
.ch_home_premium dd {background:#fff9e4; border:1px solid #ddd; height:200px;}
.ch_home_premium dt .btn-sm {padding:5px 10px; vertical-align:text-bottom; float:right;}
.cont_none {text-align:center;}
.cont_none p {font-size:20px; color:#aaa; font-style:italic; margin:0; padding:56px 0 25px;}
.ch_sbar {position:relative; padding:8px 6px; border-bottom:1px solid #d3d3d3; margin-top:5px; min-height:56px;}
.ch_sbar .input-group {display:inline-block;}
.ch_sbar2 {background:#f0f0f0; padding:16px 24px 18px; font-size:13px; color:#666; line-height:1.8;}
.ch_sbar2_l {display:inline-block; width:80%; margin:0; vertical-align:middle;}
.ch_sbar2_r {display:inline-block; text-align:right;  width:19%; margin:0; vertical-align:middle;}

.ch_ticket {padding:50px 40px 0;}
.ch_ticket table {width:390px; vertical-align:top; display:inline-table; margin-right:28px;}
.ch_ticket table:last-child {margin-right:0;}
.ch_ticket .tit {background:#de4830; color:#fff; font-size:24px; padding:8px 0;}
.ch_ticket th {text-align:center; font-size:15px; border:1px solid #d0d0d0; padding:12px 0;}
.ch_ticket td {border:1px solid #d0d0d0; font-size:15px; text-align:center; padding:10px 0;}
.ch_ticket td.align_r {text-align:right; padding-right:12px;}
.ch_ticket td.align_l {text-align:left; padding-left:12px;}
.ch_ticket .list1 {background:#fff1f1;}
.ch_ticket .list2 {background:#fbffe0;}
.ch_ticket .list3 {background:#e7fff6;}
.ch_ticket .list4 {background:#f7f7f7;}
.ch_ticket .list5 {background:#fffaa2;}
.ch_ticket2 {border:5px solid #e5e5e5; padding:15px 45px 0; margin:30px 40px 10px;}
.ch_ticket2 dl {padding-bottom:10px;}
.ch_ticket2 dt {border-bottom:1px solid #ccc; font-size:22px; padding:10px 0 14px 0; margin-bottom:12px;}
.ch_ticket2 dd p {padding:12px 5px; line-height:1; font-size:16px;}
.ch_ticket2 dd p input {margin:0 6px 0 0; vertical-align:middle;}
.ch_ticket2 dd p span {display:inline-block; width:90px;}

.rmn_ch {border:5px solid #d2d2d2; padding:18px 22px 0; font-size:15px; letter-spacing:-0.04em;}
#right_area .rmn_ch a img {box-shadow:none; -webkit-box-shadow:none;}
.rmn_ch ul {list-style:none; margin:0; padding:0 10px 16px;}
.rmn_ch li {padding:5px 0;}
.rmn_ch li span {text-align:right; display:inline-block; float:right;}
.rmn_ch li a {color:#e12a00; text-decoration:underline; margin-right:3px; font-weight:bold;}
.rmn_ch_my1 {border-bottom:1px solid #dbdbdb;}
.rmn_ch_my1_t {font-size:16px; color:#000; font-weight:bold; margin-bottom:5px;}
.rmn_ch_my2 { padding-top:16px;}
.rmn_ch_my2_t {font-size:20px; color:#000; font-weight:bold; margin-bottom:8px;}
.rmn_ch_my2_date {padding:6px 0 7px; text-align:center; background: #eaeaea; margin-bottom:6px; font-weight:bold; color:#000;}
.rmn_ch .cont_none { text-align:center; font-size:16px; color:#aaa; font-style:italic; margin:0; padding:12px 0 35px;}
.rmn_ch .btn-xs {padding:1px 4px 2px; margin-top:-2px;}


.sp_main_tit {text-align:center; text-align:left; padding:12px 5px; border-bottom:1px solid #e6e6e6;}
.sp_main_tit b {font-size:18px; color:#000; letter-spacing:-0.05em; font-weight: 500;}
.sp_main_tit b span {color:#74b243;}
.sp_main_tit a {display:inline-block; float:right; font-size:13px; color:#999; margin-top:4px;}
.sp_main {padding:12px 14px 0;}
.sp_main_ul {line-height:0px; font-size:0px; margin:15px 0 0 0; padding:0;}
.sp_main li { margin-bottom:35px;}
.sp_main li a {text-decoration:none;}
.sp_main_pic {width:305px; height:125px; border:1px solid #ddd;}
.sp_main_cont {padding:8px 2px 2px; margin-bottom:18px;}
.sp_main_cont_t {font-size:16px; color:#000;overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; line-height: 1.4; margin-bottom:8px;}
.sp_main_cont_p {font-size:20px; color:#000; font-weight:600; letter-spacing:-0.02em; font-family: 'Montserrat'; line-height: 1; margin-bottom: 0;}
.sp_main_cont_p small {font-weight:normal; color:#000; font-size:16px; margin-left:1px; font-family: 'Noto Sans KR', sans-serif;}
.sp_main_cont_p del {font-size:12px; color:#888; font-weight:normal; margin-left:4px;}
.sp_main_cont_star {padding-top:8px;}
.sp_main_cont_star .cont_star_num {color:#999; font-size:11px; padding-left:3px; vertical-align:middle ; font-weight: 300;}
.sp_main_cont_star img {width:13px; margin:-1px 1px 0 0; border:none; box-shadow:none!important; -webkit-box-shadow:none!important;}
.sp_main_cont_sell {padding:5px 0 0; color:#888; font-size:14px; font-weight: 300; padding-left:6px; font-family: 'Noto Sans KR'}
.sp_main_cont_sell b {color:#000; padding-right:1px;}
.sp_main_more {border-top:1px solid #e6e6e6; margin-top:-10px;}
.sp_main_more button {display:inline-block; width:100%; padding:10px 0; text-align:center; color:#999; background:#ffffff; border:none;  font-weight:normal; font-size:14px; font-family:'Noto Sans KR', sans-serif!important;}

.home_cont_cate {width:1240px; background:#fff; border:1px solid #e9e9e9; padding:28px 0; margin-bottom:8px; position:relative; text-align:center;}
.home_cont_cate.st2 {width:100%; border:none; border-top:1px solid #e9e9e9; padding:24px 0 28px; margin-bottom:0; margin-top:-6px;}
.home_cont_cate.st3 {width:100%; border:none; border-top:1px solid #e9e9e9; padding:20px 0 8px; margin-bottom:0; margin-top:-6px;}
.home_cont_cate .cate_arrow {display:inline-block;}
.home_cont_cate .cate_arrow a {padding:10px; display:block;}
.home_cont_cate .cate_arrow a img {width:14px;}
.home_cont_cate .cate_cont  {width:940px; overflow:hidden; display:inline-block; vertical-align:middle; margin:0;}
.home_cont.st8 .cate_cont {width:1100px; overflow:hidden; display:inline-block; vertical-align:middle; margin:0;}
.home_cont_cate.st2 .cate_cont {width:1090px; text-align:left;}
.home_cont_cate.st3 .cate_cont {width:750px; text-align:left;}
.home_cont_cate .cate_cont a, .home_cont.st8 .cate_cont a  {padding:0; text-align:center; display:table-cell; margin:0; width: 92px;}
.home_cont_cate .cate_cont a img, .home_cont.st8 .cate_cont a img  {width:66px;}
.home_cont_cate .cate_cont a span, .home_cont.st8 .cate_cont a span  {display:block; padding-top:6px; font-size:14px;}

.snb_nav { height:44px; border-bottom:1px solid #e6e7e8; background:#fff; margin:-16px -3px 16px; -webkit-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2) inset; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2) inset;}
.snb_nav ul {width:1240px; margin:0 auto; padding-top:5px; position:relative;}
.snb_nav_rcp {}
.snb_nav_rcp li {list-style:none; padding:0; display:inline-block;}
.snb_nav_rcp li a {display:block; padding:5px 10px; margin:0 10px; font-size:15px; color:#999;}
.snb_nav_rcp li a.active {color:#6ba73c; font-weight:bold;}
.snb_nav_arrow {position:absolute; display:block; top:-15px;}

.s_category_tag {padding:0 24px; margin-bottom:-10px; position:relative;}
.s_category_tag.st2 {padding:0; margin-bottom:-10px; border-top:1px solid #e9e9e9; margin-top:-5px;}
.s_category_tag .tag_tit {font-size:20px; border-bottom:1px solid #e6e7e8; padding:30px 0 10px 8px; line-height:1;}
.s_category_tag .tag_cont { padding:16px 4px 0; margin-bottom:0;}
.s_category_tag .tag_cont li {display:inline-block; margin:0 2px 12px; padding:2px 0;}
.s_category_tag .tag_cont li a {padding:4px 15px 6px; line-height:1; color:#666; background:#eee; border-radius:14px; font-size:14px;}
.s_category_tag .tag_cont li.active a {background:#74b243; color:#fff;}

.tag_cont_more {position:absolute; right:0; bottom:4px;}
.tag_cont_more a {color:#5da619; font-size:14px; font-weight:bold; padding:10px 30px; display:inline-block;}
.tag_cont_more a span {padding-left:5px;}
.tag_cont_more a span img {margin-top:-1px;}

.event_poll {border: 5px solid #e6e6e6; padding:30px 47px 20px; margin: 10px 47px;}
.poll_area {font-size: 18px;}
.poll_area dt .poll_txt1 {color: #d00000; padding-right: 6px;}
.poll_area dt .poll_txt2 {color: #999; padding-right: 6px;}
.poll_area dd {margin:15px 0 40px;}
.poll_area .poll_check {padding:0;}
.poll_area .poll_check li {list-style: none; padding: 0 0 8px 4px; margin: 0; display: inline-block; margin-right: 10px;}
.poll_area .poll_check label {font-weight: normal;}
.poll_area .poll_check input {margin-right: 6px;}
.event_poll .event_btn {text-align: center; padding-bottom: 40px;}
.event_poll .event_btn img {max-width: 100%; margin-bottom: 8px;}
.modal .poll_area {padding: 15px 15px 0; margin-bottom: 10px;}
.modal .poll_area li {padding: 6px 0 0 4px; display: block;}
.modal .poll_area ul {padding-top: 10px;}
.modal .poll_area li span {font-weight: bold; padding-right: 8px}
.modal .poll_area dd {margin:5px 0 40px;}
.modal .poll_area dd:last-child {margin:5px 0 0;}
.modal .poll_area .poll_result {vertical-align:top; margin-bottom: 9px; display: inline-block;}
.modal .poll_area .poll_result_bar {display:inline-block; margin-left:5px; height: 25px;}
.modal .poll_area .poll_result_value {color: #da5721; display: inline-block; vertical-align: top; padding-left: 12px;}
.modal .poll_area .progress {margin-bottom: 0;}
.modal .poll_area .progress-bar {background: #da5721;}

.view_cate_pdt {position: absolute; left: 12px; bottom:82px; z-index: 1;}
.view_cate_pdt img {height: 34px;}
.sp_pdt_wrap {padding:0 40px; margin-bottom: 50px; position: relative;}
.sp_pdt_list {margin: 0; padding: 0;}
.sp_pdt_list li {display: inline-block; vertical-align: top; padding-top: 25px; margin: 0 2px;}
.sp_pdt_img {overflow: hidden; border-radius: 4px; border: 1px solid #dedede; width: 142px; height: 142px;}
.brand .sp_pdt_img, .sp_pdt_all .brand .sp_pdt_img {border-radius: 50%;}
.sp_pdt_img img {width: 100%; margin: 0; }
.sp_pdt_cont {line-height: 1; padding-top: 8px; text-align: left;}
.sp_cont_tit {text-overflow:ellipsis; white-space:nowrap; overflow:hidden; padding-bottom: 6px; color: #333; font-size: 14px; margin: 0;}
.sp_cont_price {color: #999; font-size: 14px; margin: 0;}
.sp_pdt_btn_wrap {text-align: center; padding: 20px 0 50px;}
.sp_pdt_btn {background: #73b142; border: none; color: #fff; font-size: 19px; border-radius:30px; padding: 6px; line-height: 1; -webkit-box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.1); box-shadow: 4px 4px 0 rgba(0, 0, 0, 0.1); letter-spacing: -0.02em;}
.sp_pdt_btn strong {padding: 0 30px 0 20px; font-weight: normal;}
.sp_pdt_all_wrap {}
.sp_pdt_all_wrap {}
.sp_pdt_all_wrap.st2 {margin: 40px;}
.sp_pdt_all_tit {border-bottom: 1px solid #e6e6e6; padding: 18px 22px 12px; font-size: 15px; line-height: 1; position: relative; color: #000;}
.sp_pdt_all_tit.st2 {padding: 0 0 0 0; border-bottom: none; color: #333; font-size: 16px;}
.sp_pdt_all_tit img {margin-right: 5px; vertical-align: middle;  margin-top: -2px;}
.sp_pdt_all_tit a {display: block; position: absolute; right: 15px; top: 14px;}
.sp_pdt_all {padding: 18px 12px; margin: 0 ; }
.sp_pdt_all.st2 {padding: 20px 0;}
.sp_pdt_all li {display: inline-block; vertical-align: top; padding-bottom: 30px; margin: 0 2px 0 10px; width: 31%;}
.sp_pdt_all .sp_pdt_img {width: 235px; height: 235px}
.sp_pdt_all .sp_pdt_img img {width: 100%;}
.sp_pdt_all .sp_pdt_cont {line-height: 1; padding: 10px 0 0 0;}
.sp_pdt_all .sp_cont_tit {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; line-height: 1.5; padding:0 0 0 0; max-height: 42px; color: #333; font-size: 14px; margin-bottom:8px;}
.sp_pdt_all .sp_cont_price {color: #999; padding: 0; font-size: 14px; margin: 0;}

.sp_pdt_all .unity_pic {position:relative; border-radius:6px; border:none;}
.sp_pdt_all .unity_pic img {width:100%; border-radius:6px;}
.sp_pdt_all .unity_cont, .sp_pdt_wrap .unity_cont {padding:12px 4px; line-height:1;}
.sp_pdt_all .cont_tit, .sp_pdt_wrap .cont_tit {font-size:14px; font-weight:400; margin: 0; text-align: left;}
.sp_pdt_all .brand .cont_tit, .sp_pdt_wrap .brand .cont_tit {text-align: center;}
.sp_pdt_all .cont_tit.line1, .sp_pdt_wrap .cont_tit.line1 {text-overflow:ellipsis; white-space:nowrap; overflow:hidden; padding-bottom:2px;}
.sp_pdt_all .cont_tit.line2, .sp_pdt_wrap .cont_tit.line2 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.4; padding:0 ;}
.sp_pdt_all .cont_name, .sp_pdt_wrap .cont_name {padding-top:10px; color:#666;}
.sp_pdt_all .cont_name img, .sp_pdt_wrap .cont_name img {border-radius:50%; width:23px; margin-right:5px;}
.sp_pdt_all .cont_review, .sp_pdt_wrap .cont_review {color:#666; padding-top:4px; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;}
.sp_pdt_all .cont_star {padding-top:7px; margin: 0; text-align: left;}
.sp_pdt_wrap .cont_star {margin: 0; text-align: left;}
.sp_pdt_all .star_img, .sp_pdt_wrap .star_img {font-size: 0px;vertical-align: middle; text-shadow;none; position:relative;}
.sp_pdt_all .star_img img, .sp_pdt_wrap .star_img img {width:12px; margin:-1px 1px 0 0;}
.sp_pdt_all .star_ea, .sp_pdt_wrap .star_ea {padding-top:4px; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; color:#999; font-size:11px; padding-left:5px; text-shadow;none; position:relative; margin-left: 0; font-weight: 300;}
.sp_pdt_all .price_box, .sp_pdt_wrap .price_box {padding:4px 0 3px; line-height:1; text-align:left;}
.sp_pdt_all .price_box .price, .sp_pdt_wrap .price_box .price {font-size:20px; color:#000; font-weight:600; letter-spacing:-0.02em; font-family: 'Montserrat';}
.sp_pdt_all .price_box .price small, .sp_pdt_wrap .price_box .price small {font-weight:normal; color:#000; font-size:16px; margin-left:1px; font-family: 'Noto Sans KR', sans-serif;}
.sp_pdt_all .price_box .price_original, .sp_pdt_wrap .price_box .price_original {color:#999; font-size:12px; margin-left:2px; text-decoration:line-through; }
.sp_pdt_all .price_box .price_original small, .sp_pdt_wrap .price_box .price_original small {font-size:12px;}
.sp_pdt_all .price_box .buyer, .sp_pdt_wrap .price_box .buyer {color:#999; font-size:12px; margin-left:1px; text-shadow;none; position:relative; font-weight: 300;}
.sp_pdt_tit {padding: 0 8px 12px 0;}
.sp_pdt_tit b {font-size: 17px;}
.sp_pdt_tit img {vertical-align: top; margin:-2px 5px 0 0;}
.sp_pdt_tit a {float: right; color: #999; font-size: 14px;  display: block; padding: 0 10px;}

.goods_list_unity { padding:40px 6px 10px;}
.goods_list_unity.my { padding:30px 6px 10px;}
.goods_list_unity li {width:24.1%; display:inline-block; vertical-align:top; margin:0 4px 50px 4px; padding:0 2px;}
.goods_list_unity.my li {width:32%;}
.goods_list_unity .unity_pic {position:relative; border-radius:6px; border:none;}
.goods_list_unity .unity_pic img {width:100%; border-radius:6px;}
.goods_list_unity .unity_cont {padding:12px 5px; line-height:1;}
.goods_list_unity .cont_tit {font-size:14px; margin-bottom:5px; line-height:1.4; max-height:2.8em;}
.goods_list_unity .cont_tit.line1 {text-overflow:ellipsis; white-space:nowrap; overflow:hidden; padding-bottom:2px;}
.goods_list_unity .cont_tit.line2 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.4;}
.goods_list_unity .cont_name {padding:10px 2px 0 0; color:#666; vertical-align: sub;}
.goods_list_unity .cont_name img {border-radius:50%; width:23px; margin-right:5px;}
.goods_list_unity .cont_review {color:#666; padding-top:4px; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; margin-bottom: 8px; font-size: 15px;}
.goods_list_unity .cont_review_img {display: table-cell; vertical-align: top; padding:40px 0 0 6px;}
.goods_list_unity .cont_review_img img {border-radius:3px;}
.goods_list_unity .cont_review.line2 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.5;}
.goods_list_unity .cont_review.line3 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.5;}
.goods_list_unity .cont_review.line4 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 4; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.5;}
.goods_list_unity .cont_date {color: #999; font-size: 12px;}
.goods_list_unity .cont_star {padding-top:7px; }
.goods_list_unity .star_img {font-size: 0px;vertical-align: middle;}
.goods_list_unity .star_img img {width:12px; margin:-1px 1px 0 0;}

.home_cont .cont_star {padding-top:0; margin: 0; text-align: left;}
.home_cont .cont_star .star_img {font-size: 0px;vertical-align: middle; text-shadow;none; position:relative; width:auto !important;}
.home_cont .cont_star .star_img img {width:12px; margin:-1px 1px 0 0; border-bottom:none;}
.home_cont .cont_star .star_ea {padding-top:0; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; color:#999; font-size:11px; padding-left:2px; text-shadow;none; position:relative; margin-left: 0; margin-top: -2px; width:auto !important;}

.rcp_m_list2 .ranking_num {background:#fff; border:1px solid #bbb; -webkit-box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.08); box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.08); min-width:36px; text-align:center; border-radius:4px;  line-height:1; padding:8px 7px 10px; letter-spacing:-0.03em; vertical-align:unset;}
.rcp_m_list2 .ranking_num.st1 {position:absolute; left:-4px; top:-4px; z-index: 100;}
.rcp_m_list2 .ranking_num b {font-size:17px; color:#333;}

.goods_best3_1 {overflow:hidden; padding:4px 20px 20px 88px;}
.goods_best3_1 li {padding:24px 6px; vertical-align:top; border-bottom:1px solid #ddd; list-style: none; width: 300px; display: inline-block; margin-right: 60px;}
.goods_best3_1 .best_cont {text-overflow:ellipsis; white-space:nowrap; overflow:hidden; font-size:16px; padding:0; display:inline-block; vertical-align:middle; font-weight:500;}
.goods_best3_1 .ranking_num {margin-right:18px; margin-bottom: 0;}
.goods_best3_1 .ranking_r {float:right; color:#999; line-height:1; margin-top:10px; font-size:13px; text-align:center; min-width:40px;}
.goods_best3_1 .ranking_r.up {color:#e50000;}
.goods_best3_1 .ranking_r.down {color:#1e66c7;}
.ranking_num.st2 {display:inline-block;}
.ranking_num.st3 {position:absolute; left:-2%; top:-2%;}
.goods_best4_1 {overflow:hidden; padding:16px 20px 10px 100px;}
.goods_best4_1 li {display:inline-block; width:110px; margin:2px 45px 24px; vertical-align:top;}
.goods_best4_1 .best_pic { width:100%; border-radius:50%; border:1px solid #dbdbdb; margin:0 auto; position:relative;}
.goods_best4_1 .best_pic img {max-width:100%; border-radius:50%;}
.goods_best4_1 .best_cont {font-size:16px; padding:8px 0 4px 0; font-weight:500; text-align: center;}
.goods_best4_1 .best_cont .btn {border:1px solid #74b243; font-size:11px; color:#74b243; background:#fff; border-radius:12px; padding:6px 8px 5px; line-height:1; display:block; margin:0
auto; margin-top:4px;}

.alim_banner {padding-top: 40px; text-align: center;}
.alim_store {background:url('//recipe1.ezmember.co.kr/img/mobile/alim_img1.png?v.1') 188px bottom no-repeat #fff; background-size:contain; margin-right: 6px; text-align: left;}
.alim_rcp {background:url('//recipe1.ezmember.co.kr/img/mobile/alim_img2.png?v.2') left bottom no-repeat #fff; background-size:contain; text-align: right;}
.alim_btn_st1, .alim_btn_st2 {color: #77b347; background:#fff; border: 1px solid #77b347; border-radius:16px; line-height: 1; display: inline-block; text-align: center; letter-spacing: -0.05em;}
.alim_btn_st1 {font-size: 14px; padding: 6px 16px;}
.alim_btn_st2 {font-size: 14px; padding: 5px 0 6px;}
.alim_btn_st1:hover, .alim_btn_st1:visited, alim_btn_st1:active, .alim_btn_st2:hover, .alim_btn_st2:visited, alim_btn_st2:active {color: #77b347;}
.alim_store, .alim_rcp {font-size: 17px; padding: 0 30px; width: 420px; height: 170px; border-radius: 6px; border: 1px solid #d5d5d5; display:inline-block;}
.alim_store p, .alim_rcp p {margin: 0; line-height: 1.6; letter-spacing: -0.02em; display: table-cell; vertical-align: middle; height: 168px; width:360px;}
.alim_store b, .alim_rcp b {color: #77b347;}
.alim_push_list li {padding: 14px 0 14px 6px; border-bottom: 1px solid #e5e5e5; margin: 0; width: 390px; display: inline-block; margin: 0 16px;}
.alim_push_tit {font-size: 16px; font-weight: bold; padding-bottom: 10px; line-height: 1.4; margin: 0;}
.alim_push_cont {color: #666;}
.alim_push_wrap {padding:15px 0 0 3px;}

.alim_chef {padding: 50px 70px 40px;}
.alim_chef .box_tit {padding:0 0 12px 15px; border:none;}
.alim_chef .box_tit b {font-size:22px; color:#000; letter-spacing:-0.04em;}
.alim_chef .box_tit .more {display:block; float:right; line-height:1; border:1px solid #d6c1aa; color:#b99773; font-size:13px; padding:5px 8px; font-weight:bold;}

.alim_chef .box_tit span {color:#74b243;}

.alim_list_wrap {padding: 0 30px;}
.alim_list { border-top: 1px solid #e5e5e5;}
.alim_list li {padding: 20px 0 20px 20px; border-bottom: 1px solid #e5e5e5; margin: 0;}
.info_pic {padding-right: 25px;}
.info_pic img {width: 64px; height: 64px; border-radius: 50%;}
.info_cont {line-height: 1.8; font-size: 17px;}
.info_date {margin:0; font-size: 14px;}
.info_date a {color: #999; }
.info_cont2 {color: #999; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; line-height: 1em; margin: 5px 0 6px 0;}
.view2_review_star {font-size: 0px;vertical-align: middle; text-shadow;none; position:relative; width:auto !important;}
.view2_review_star img {width:16px; margin:-1px 1px 0 0; border-bottom:none;}






.common_rcp_list_ul {padding: 0; margin: 0; vertical-align: top;}
.common_rcp_list_li {list-style:none; padding: 0; margin: 0 12px 35px 0; display: inline-block; vertical-align: top;}
.common_rcp_list_li:nth-child(4n+4) {margin-right: 0;}
.common_rcp_thumb {border-radius:6px; overflow: hidden; position: relative;}
.common_rcp_thumb img {max-width: 100%;}
.common_rcp_caption_tit {margin: 0; padding:9px 0 0; color: #000; text-align: left;}
.common_rcp_caption_tit.line1 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.5;}
.common_rcp_caption_tit.line2 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.5;}
.common_rcp_caption_tit.line3 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; /* 라인수 */ -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.5;}
.common_rcp_caption_name {padding: 6px 2px 0 0; color: #666; vertical-align:middle;}
.common_rcp_caption_name_pic { margin: 0;}
.common_rcp_caption_name_pic img {width:28px; height: 28px; border-radius: 50%; margin-right: 4px;}
.common_rcp_caption_rv {vertical-align:middle; line-height: 1; margin-top: -4px;}
.common_rcp_caption_rv_star img {width: 13px; margin-right: 1px;}

/*
.common_rcp_caption_price_box {padding: 2px 0 0;}
.common_rcp_caption_price {font-size:16px; color:#73b142; font-weight:bold; letter-spacing:-0.02em; font-family: roboto;}
.common_rcp_caption_price small {font-weight:normal; color:#73b142; font-size:14px; margin-left:1px; font-family: 'Noto Sans KR'}
.common_rcp_caption_buyer {color:#999; font-size:13px; margin-left:2px; font-weight:300;}
.common_rcp_caption_rv_ea {color:#999; padding-top:4px; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; font-size:11px; padding-left:3px; vertical-align: 0; font-weight:300;}
*/
.common_rcp_caption_price_box {padding:0; margin: 0 0 6px 0; line-height: 1;}
.common_rcp_caption_price {font-size:20px; color:#000; letter-spacing:-0.02em; font-family: 'Montserrat'; font-weight: 600;}
.common_rcp_caption_price small {font-weight:normal; font-size:18px; margin-left:1px; font-family: 'Noto Sans KR', sans-serif;}
.common_rcp_caption_buyer {color:#999; font-size:13px; margin-left:2px; font-weight:300;}
.common_rcp_caption_rv_ea {color:#999; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; font-size:12px; vertical-align:0; padding-left: 1px; line-height:normal; font-weight:300; vertical-align: inherit;}
.common_rcp_list_ul.ea3 .common_rcp_caption_tit {font-size: 16px; color: #222; font-weight: 300;}
.common_rcp_list_ul.ea3 .price_box {padding-top:4px;}
.common_rcp_list_ul.ea3 .common_sp_icon_free {padding:7px 12px 9px;}
.store_list_none {padding:90px 20px 150px; text-align: center; font-size: 18px; color:#666;}
.store_list_none b {color: #222;}
.store_list_none p img {width:80px; margin-bottom:20px;}

.push_agree {border-top:1px dashed #dedede; padding: 18px 12px 5px 2px; margin: 18px;}
.push_agree dt {display: inline-block;}
.onoffswitch {position: relative; width:58px;-webkit-user-select:none; -moz-user-select:none; -ms-user-select: none; float:right; margin-top:1px;}
.onoffswitch-checkbox {display: none;}
.onoffswitch-label {display: block; overflow: hidden; cursor: pointer; border:none; border-radius: 20px;}
.onoffswitch-inner {display: block; width: 200%; margin-left: -100%;
-moz-transition: margin 0.2s ease-in 0s; -webkit-transition: margin 0.2s ease-in 0s;
-o-transition: margin 0.2s ease-in 0s; transition: margin 0.2s ease-in 0s;}
.onoffswitch-inner:before, .onoffswitch-inner:after {display: block; float: left; width: 50%; height: 22px; padding: 0;  -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;}
.onoffswitch-inner:before {content: "";padding-left: 10px; background-color: #7AB549;
-webkit-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.40);
box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.40);}
.onoffswitch-inner:after {content: ""; padding-right: 10px; background-color: #d5d5d5; }
.onoffswitch-switch {
    display: block; width: 30px; margin: -1px;
    background: #FFFFFF;
    border: 1px solid #bbb;; border-radius: 20px;
    position: absolute; top:-3px; bottom:2px; right: 40px;
    -moz-transition: all 0.2s ease-in 0s; -webkit-transition: all 0.2s ease-in 0s;
    -o-transition: all 0.2s ease-in 0s; transition: all 0.2s ease-in 0s;
	  -webkit-box-shadow: inset 0 -2px 4px rgba(0, 0, 0, 0.40);
     box-shadow: inset 0 -2px 4px rgba(0, 0, 0, 0.40);}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {margin-left: 0;}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {right: 0px; }


.ingredient_wrap {background: #fff; padding-bottom:40px; width: 912px; margin: 0 auto; max-width: 100%;}
.ingredient_top {padding: 18px 40px;}
.ingredient_pic {width:90px; height:90px; border-radius:50%; -webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.16); box-shadow: 0 0 5px rgba(0, 0, 0, 0.16); display: table-cell; vertical-align: middle; }
.ingredient_tit {display: table-cell; vertical-align: middle; padding-left: 10px;}
.ingredient_tit b {font-size: 38px;}
.ingredient_info table {width: 100%; border-top: 1px solid #eeeeee;}
.ingredient_info th {background: #f9f9f9; font-weight: 500; padding: 12px 0 12px 40px; font-size: 15px;}
.ingredient_info td {font-weight:normal; padding: 12px 20px;  font-size: 15px;}
.ingredient_info tr {border-bottom: 1px solid #eeeeee;}
.ingredient_btn_wrap {padding: 30px 0 60px; text-align: center;}
.ingredient_btn {background: #74b243; font-size: 18px; color: #fff; padding:8px 40px; border-radius:24px; border:none; line-height: 1; margin: 0 4px;}
.ingredient_btn img {width:28px; margin-right:8px;}
.ingredient_cont {padding: 0 40px 40px;}
.ingredient_cont dt {border-left:4px #000 solid; padding-left:8px; font-size:22px; line-height: 1; margin-bottom:15px;}
.ingredient_cont dd {font-size: 16px; color: #666; line-height: 1.6;}
.ingredient_cont_tag {padding-top: 8px;}
.ingredient_cont_tag a {background: #eee; border-radius: 15px; padding:8px 14px 10px; margin:0 5px 15px 0; display: inline-block; line-height: 1; font-size: 16px;}

.story_topic_area {padding:34px 0 15px 0;}
.story_topic_list {line-height: 1; display: inline-block; padding: 0;}
.story_topic_list li {background: #000;  position: relative; text-align: center; border-radius: 6px; display: inline-block; margin:0 2px; height: 120px;}
.story_topic_list_tit {color:  #fff; ; position: absolute; left: 0; top: 0; width: 100%; height: 100%; filter:alpha(opacity=100); opacity:1; font-weight: bold; z-index: 1; display: table;}
.story_topic_list_tit p {margin: 0; display:table-cell; vertical-align: middle;}
.story_topic_list_tit p span {line-height: 1.3; padding:0 15px 2px 15px ; font-size: 18px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; font-weight: 400; text-shadow:1px 1px 4px #000000ab;}
.story_topic_list_bg {border-radius: 6px; height:100%; filter:alpha(opacity=70); opacity:0.7;}
.story_topic_ul_arrow {display:inline-block; width:40px; text-align:center; vertical-align: top; padding-top: 30px;}
.story_tag_area { padding: 4px 0 0 12px;}
.story_tag_list {padding: 0;}
.story_tag_list li {display: inline-block; margin-right:2px; margin-bottom: 10px;}
.story_tag_list li a {background: #fff; border: 1px solid #ddd; padding:6px 20px 9px; line-height: 1; border-radius:20px; color: #aaa; font-size: 15px; display: block; margin-right:2px;}
.story_tag_list li.on a {background: #eee; color: #444; border:1px solid #eee; }
.story_tag_list li.active a {background: #bbb; color: #fff; border:1px solid #bbb; }

.story_list_thumb {width: 275px; height: 275px;}
.story_list_caption {padding:10px 20px}
.story_list_caption_tit {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:140%; font-size: 16px; margin-bottom:8px; padding-bottom: 1px;}
.story_list_caption_name_l {display: inline-block; color: #777; font-weight: 300;}
.story_list_caption_name_l img {border-radius:50%; width:28px; height: 28px; margin: 0 6px 0 0!important; display: inline-block!important;}
.story_list_caption_name_r {float: right; color: #999; font-size: 14px; vertical-align: top; margin-right: 2px;}
.story_list_caption_name_r img {width: 15px; height: 15px;  margin: -2px 3px 0 0; border-bottom:0!important;}
.story_list_caption_name_r span {padding-left: 6px; color: #74b243; font-weight:400;}
.story_list_top {padding:5px 15px 20px; border-bottom: 1px solid #ddd; margin-bottom: 10px;}
.story_list_top_tag { font-size:32px; font-weight:400; line-height: 1.2; letter-spacing:-0.04em;}
.story_list_top_tag img {width: 38px; vertical-align:top; margin-right:7px;}
.story_list_top_sub {color: #999; line-height: 1.5; margin-top:12px; font-size: 16px; font-weight: 300; padding-left:2px;}

.story_view_area { padding:35px 40px 0;}
.story_view_top {padding:0 10px;}
.story_view_top_name {font-size:22px; font-weight: 400; color: #666; display: inline-block; width: 80%;}
.story_view_top_name img {width:76px; border-radius: 50%; margin-right:15px; float: left; margin-top: -6px;}
.story_view_top_date {color: #999; font-size: 16px; display: block; font-weight: 300; padding-top: 4px;}
.story_view_top_icon {float: right; color: #999; font-size: 16px; font-weight: 300; vertical-align: top; margin-right:8px; padding-top: 15px;}
.story_view_top_icon span img {width: 22px;height:22px; margin:-2px 5px 0 0;}
.story_view_top_icon span {margin-left:15px; color: #74b243; font-weight:400;}
.story_view_cont {padding:25px 0; width: 650px; margin: 0 auto;}
.story_view_cont_img {margin-bottom: 8px;}
.story_view_cont_img img {max-width: 100%; border-radius: 6px;}
.story_view_cont_txt { font-size: 18px; padding: 10px 4px 80px; line-height: 1.8;}
.story_view_tag_a {padding: 0 5px 10px;}
.story_view_tag_a li { margin-bottom:10px; list-style: none;}
.story_view_tag_a li a {background:#fff8ce; border: 1px solid #ddd; padding:8px 20px; line-height: 1; border-radius:20px; display: block; width: 60%; font-size: 16px; font-weight:400;}
.story_view_tag_a li a span {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp:1; -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.2; color: #444; padding:1px 0 1px 30px; letter-spacing: -0.04em;}
.story_view_tag_a li a span.event {background: url(https://recipe1.ezmember.co.kr/img/icon_story_event.svg) left top no-repeat; background-size:22px;}
.story_view_tag_a li a span.sp {background: url(https://recipe1.ezmember.co.kr/img/icon_story_sp.svg) left top no-repeat; background-size: 22px;}
.story_view_tag_a li a span.rcp {background: url(https://recipe1.ezmember.co.kr/img/icon_story_rcp.svg?v.1) left top no-repeat; background-size: 22px;}
.story_view_tag_a li a span.topic {background: url(https://recipe1.ezmember.co.kr/img/icon_story_topic.svg) left top no-repeat; background-size: 22px;}
.story_view_tag_a li a img {width:20px;}
.story_view_tag_b {padding:10px 5px 30px ;}
.story_view_tag_b_tit {font-size:22px; font-weight: 400; letter-spacing: -0.04em; padding: 0 0 15px 0;}

.story_write_area {padding: 20px 140px 0;}
.story_write_pic { padding: 20px 16px 15px;}
.story_write_pic_img {margin-right:5px; position:relative; display:inline-block;}
.story_write_pic_img img {width:140px; height:140px; border:1px solid #ddd;}
.story_write_pic_add {width:140px; height:140px; border:1px solid #ddd; background:#f7f7f7; color:#ababab; margin:0; padding:0; border-radius:0; font-size:18px; vertical-align:top;}
.story_write_pic_add span {font-size:30px; font-weight: 100;}
.story_write_pic_img .btn_close {border-radius:50%; background:#fff; border:1px solid #999; width:32px; height:32px; margin:0; padding:4px 0 0 0; color:#666; position:absolute; right:-5px; top:-5px; opacity: 0.7; filter: alpha(opacity=70);}
.story_write_pic_img .btn_close span {font-size: 16px; display: block; line-height: 0; margin-top: -2px;}
.story_write_txt {padding:15px 12px 20px;}
.story_write_txt .form-control {border: 1px solid #ddd; box-shadow:none; -webkit-box-shadow:none; margin: 0; border-radius:10px; background: #fff; width: 100%; padding: 15px 25px;}
.story_write_tag {padding: 0 4px;}
.story_view_tag_input {padding:24px 0 ;}
.story_view_tag_input input {box-shadow:none; -webkit-box-shadow:none; border: 1px solid #ddd; margin: 0; border-radius:10px; background: #fff; padding:12px 15px 14px; height: auto; line-height: 1; width: 100%}

.cont_null {padding: 80px 0 150px; text-align: center;}
.cont_null img {width: 130px; padding-bottom: 20px;}
.cont_null_t1 {font-size: 20px; color: #333;}
.cont_null_t2 {font-size: 16px; color: #999;}
.cont_null_btn {padding-top: 30px;}
.cont_null_btn a {padding: 6px 30px 8px; border: 1px solid #ddd; border-radius: 22px; font-size: 16px; color: #999; line-height: 1;}

.modal_view_step {}
.step_store {background:#f9f9f9; border-bottom: 1px solid #e6e6e6; border-top: 1px solid #e6e6e6; padding:22px 0; margin: -30px 0 60px;}
.step_store_search {text-align: center;}
.step_store_search input, .store_request_li input {border: 1px solid #ccc; border-radius: 4px; height: 36px; padding:0 15px 2px; font-size: 16px; line-height: 1; vertical-align: middle; margin-right: 2px;}
.step_store_search .btn-mid {height: 36px;}
.step_store_search .btn-default {text-shadow:0 1px 0 #fff;background-image:-webkit-linear-gradient(top,#fff 0,#e0e0e0 100%);background-image:-o-linear-gradient(top,#fff 0,#e0e0e0 100%);background-image:-webkit-gradient(linear,left top,left bottom,from(#fff),to(#e0e0e0));background-image:linear-gradient(to bottom,#fff 0,#e0e0e0 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe0e0e0', GradientType=0);filter:progid:DXImageTransform.Microsoft.gradient(enabled=false);background-repeat:repeat-x;border-color:#dbdbdb;border-color:#ccc}
.step_store_search .btn-success {background-image:-webkit-linear-gradient(top,#5cb85c 0,#419641 100%);background-image:-o-linear-gradient(top,#5cb85c 0,#419641 100%);background-image:-webkit-gradient(linear,left top,left bottom,from(#5cb85c),to(#419641));background-image:linear-gradient(to bottom,#5cb85c 0,#419641 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5cb85c', endColorstr='#ff419641', GradientType=0);filter:progid:DXImageTransform.Microsoft.gradient(enabled=false);background-repeat:repeat-x;border-color:#3e8f3e}
.step_add.add_store .btn_del, .add_store_request .btn_del {padding:0 4px;}
.step_add.add_store .btn_del img, .add_store_request .btn_del img {margin:-1px 0 0 0;}
.step_store_noti {color: #999; padding:20px 0; line-height: 1.8; color:#e70e0e; font-weight: 300; text-align: center;}
.step_store_list {background: #fff; border: 1px solid #e6e6e6; width: 1045px; margin: 0 auto; padding:30px 18px 0 35px; overflow-y: scroll;}
.step_store_list_input input {border: 1px solid #ccc; border-radius: 4px; height: 32px; padding:0 4px 2px 8px; font-size: 12px; line-height: 1; width: 100%;}
.step_store_request {text-align: center; padding:30px 0 20px}
.store_request_li .btn-default1 {border: 1px solid #ccc; padding:6px 20px 8px;}
.store_request_li {padding-bottom: 14px;}
.store_request_btn {padding: 20px 0 10px;}
.common_sp_thumb_over {position: absolute; left:0; top:0; width: 100%; height: 100%; opacity: 0; filter:alpha(opacity=0); -webkit-transition: all 0.4s ease-in-out; -moz-transition: all 0.4s ease-in-out; -o-transition: all 0.4s ease-in-out; -ms-transition: all 0.4s ease-in-out; transition: all 0.4s ease-in-out; -webkit-backface-visibility: hidden; background:url(//recipe1.ezmember.co.kr/img/icon_check2.png) center center no-repeat; background-color: rgba(255, 255, 255, .7); z-index: 1000}
.common_sp_link:hover .common_sp_thumb_over {opacity: 1; filter:alpha(opacity=100);}
.common_sp_list_li.on .common_sp_thumb_over {opacity: 1; filter:alpha(opacity=100); background:url(//recipe1.ezmember.co.kr/img/icon_check2_on.png) center center no-repeat; background-color: rgba(255, 255, 255, .7); z-index: 1000;}
.view_step.st2 .view_step_cont {margin:0 auto; width: 1100px;}
.common_thumb_date {position: absolute; right:10px; top: 10px; background:rgba(0,0,0,0.4); color: #fff; padding: 5px 14px 6px; border-radius: 14px; line-height: 1;}
.common_thumb_class {position: absolute; left:10px; top: 8px; background:url(//recipe1.ezmember.co.kr/img/mobile/icon_class.png) left top no-repeat; background-size:66px; text-indent:-9999px; width: 80px; height: 30px;}

.view2_summary.st2, .view2_summary.st3 {width:640px; margin:40px auto 0; padding-bottom:40px; }
.view2_summary.st2 h3, .view2_summary.st3 h3 {font-size:34px; letter-spacing:-0.05em; line-height:1.3; padding:0 10px; text-align: left;}
.view2_summary.st2 .view2_summary_in, .view2_summary.st3 .view2_summary_in {position:relative; padding:2px 10px 10px 10px; color:#aaa; font-size:16px; line-height:170%; font-style: normal; margin: 0; width: 100%;}

.view2_summary.st2 .price_box {border:none; padding:3px 10px 8px;margin: 8px 0 10px;}

.view2_summary.st2 .price_box .price {font-size:34px; color:#000; font-family:roboto; font-weight:normal; letter-spacing:-0.02em; line-height: 1; display: inline-block; margin-right: 6px}
.view2_summary.st2 .price_box .price small {color:#000; font-size:50%; font-family: 'Noto Sans KR'}
.view2_summary.st2 .price_box .dc {font-size:34px; color:#73b142; font-family:roboto; font-weight:normal; letter-spacing:-0.02em; line-height: 1; display: inline-block; margin-right: 4px;}
.view2_summary.st2 .price_box .dc small {color:#73b142; font-size:60%}
.view2_summary.st2 .price_box .del {font-size:16px; color:#999; line-height: 1; display: inline-block; margin-right: 4px; text-decoration: line-through;}

.view2_summary.st2  .view2_summary_info {font-size: 16px; padding: 18px 0; border-top: 1px solid #e3e3e3; margin-top: 8px;}
.view2_summary.st2 .info_delivery {margin:0 0 2px; padding: 13px 20px; display: inline-block;}
.view2_summary.st2 .info_delivery dt {display: inline-block; padding-right: 5px; vertical-align: top; color: #666; font-weight:bold;}
.view2_summary.st2 .info_delivery dt img {padding-right: 5px; vertical-align: inherit;}
.view2_summary.st2 .info_delivery dd {display: inline-block; vertical-align: top; color: #666; font-weight: normal;}
.view2_summary.st2 .price_add .info_ea {color: #666; padding: 13px 15px;border-top: 1px dashed #dfdfdf;}
.view2_summary.st2 .price_add .info_ea b {color: #000;}
.view2_summary.st2 .info_ea {color: #666; margin: 0 -12px;padding: 10px 20px 12px; font-weight: normal; display: inline-block; margin: 0;}
.view2_summary.st2 .info_ea b {color: #000;}
.view2_summary.st2 .info_ea .cont_star {display: inline-block; }
.view2_summary.st2 .info_ea .cont_star .star_img img {width: 21px;}
.view2_summary.st2 .view2_summary_info span {width: auto; padding:0 0 0 2px; font-size: 14px; vertical-align: text-bottom; }
.class_buy_btn {margin: 15px auto 10px;}
.class_buy_btn a {display:block; width:100%; padding:18px 0; font-size:20px; text-align:center; background:#77b347; border:1px solid #77b347; color:#fff; font-weight:bold; }
.class_buy_btn a:hover {color: #fff;}

.class_view_list {}
.class_view_list_li {display: table; width: 100%; margin-bottom:8px;}
.class_view_list_wrap .class_view_list_li:last-child {margin-bottom: 0;}
.class_view_list_tit {display: table-cell; background: #fff; border-radius:8px; padding: 14px 22px 16px; line-height: 1.3; border-bottom:1px solid #ddd; border-left: 1px solid #ddd; border-top: 1px solid #ddd; width:74%;}
.class_view_list_tit b {color: #333; font-size: 17px; line-height: 1.4;}
.class_view_list_tit span {color: #999; padding-left: 6px;}
.class_view_list_btn {display: table-cell; font-size:14px; background: #fff; text-align: center; border-left: 1px dashed #ddd; border-radius:8px; vertical-align: middle; border-bottom:1px solid #ddd; border-right: 1px solid #ddd; border-top: 1px solid #ddd;}
.class_view_list_btn a {display: block; color: #73b142; padding:5px 6px; font-size: 15px;}
.class_view_list_btn a:hover {color: #4c8d18;}
.class_view_list_wrap { margin-bottom: 0; padding:11px 0 15px;}
.class_view_list_chapter {font-size: 16px; padding: 14px 2px 5px; letter-spacing: -0.03em; color:#74b243; font-weight: bold;}
.class_view_list_wrap .class_view_list_chapter:first-child {padding-top: 0;}
.class_view_list_btn span {font-size:20px; display: block; margin-bottom: 1px;}
.class_view_list_btn.st_free {width:134px;}
.class_view_list_btn.st_play {width:60px; border-right:none;}
.class_view_list_btn.st_rcp {width:74px;}
.class_view_list_li .class_view_list_btn:nth-last-child(2) {border-right:none;}
.class_view_list_btn.active {border: 1px solid #73b142;}
.class_view_list_rcp { border: 1px solid #73b142; border-radius:8px; color: #333; font-size: 16px; padding:22px; margin-bottom: 14px; line-height: 1.8;}

.view_class_info .info_tit {padding:20px 20px 15px; border-bottom:1px solid #e2e2e2; font-size:18px; letter-spacing:-0.05em; line-height:1;}
.view_class_info .info_tit b {vertical-align:middle;vertical-align:text-top;padding: 18px 0 17px 32px;}
.view_class_info .info_tit b.st1 {background: url(https://recipe1.ezmember.co.kr/img/mobile/icon_goods_detail.png) left 20px no-repeat;background-size:27px;}
.view_class_info .info_tit b.st2 {background:url(https://recipe1.ezmember.co.kr/img/mobile/icon_goods_info1.png) left 21px no-repeat; background-size:27px; padding-left:24px;}
.view_class_info .info_tit b.st3 {background:url(https://recipe1.ezmember.co.kr/img/mobile/icon_goods_info2.png) left 21px no-repeat; background-size:27px; padding-left:28px;}
.view_class_info .info_tit b.st4 {background:url(https://recipe1.ezmember.co.kr/img/mobile/icon_goods_qna.png) left 21px no-repeat; background-size:27px; padding-left:24px;}
.view_class_info .info_tit .btn_more {float:right; display:block; padding:3px 6px; margin-top: -2px;}
.view_class_info .info_tit span {color:#74b243; font-size:14px; margin-left:4px;}
.view_class_info .info_cont {padding:16px 25px 25px; border-bottom:1px solid #e2e2e2;}
.view_class_info .info_cont img {max-width:100%;}
.view_class_info .info_cont.detail {overflow:hidden; position:relative;}
.view_class_info .detail_more {background:#fff; position:absolute; left:1px; right: 1px; bottom:0; padding:0 0 15px;}
.view_class_info .detail_more a {display:block; border:1px solid #7bb64d; text-align:center; padding:12px 0; margin:0 10px; color:#74b243; font-size:16px;}
.view_class_info .detail_more a.down {background:url(https://recipe1.ezmember.co.kr/img/mobile/icon_more6_down.png) right bottom no-repeat; background-size:14px;}
.view_class_info .detail_more a.up {background:url(https://recipe1.ezmember.co.kr/img/mobile/icon_more6_up.png) right top no-repeat; background-size:14px;}
.view_class_info .rmn_tab {float:right; vertical-align:top; margin:4px 5px 0 0;}
.view_class_info .rmn_tab a {padding:8px 12px 9px 28px; display:inline-block; line-height:1; border:1px solid #e2e2e2; margin-right:-1px; font-size:12px; background:url(https://recipe1.ezmember.co.kr/img/mobile/icon_check1.png) 10px center no-repeat; background-size:15px; color:#aaa;}
.view_class_info .rmn_tab a:first-child {border-radius:0 4px 4px 0;}
.view_class_info .rmn_tab a:last-child {border-radius:4px 0 0 4px;}
.view_class_info .rmn_tab a.active {color:#fff; background:url(https://recipe1.ezmember.co.kr/img/mobile/icon_check1_on.png) 10px center no-repeat #a3a3a3; background-size:15px;}
.info_policy_tit {font-size: 16px;}
.info_policy_cont {margin-top: 6px; font-size: 14px;}
.info_policy_cont table { border:1px solid #ddd;}
.info_policy_cont th, .info_policy_cont td {padding: 12px 8px; border-bottom:1px solid #ddd; border-right:1px solid #ddd;text-align: center;}
.info_policy_cont td:last-child, .info_policy_cont th:last-child {border-right: none;}
.info_policy_cont th {background: #f6f6f6;}
.info_policy_cont td {color: #666;}
.info_policy_cont_i {color: #999; padding: 8px 0 2px;}

.class_pay_wrap { width: 860px; margin: 60px auto;}
.class_pay_wrap dt {font-size: 24px; font-weight: normal; padding: 0 0 16px 0; border-bottom: 1px solid #ddd;}
.class_pay_wrap dt b {color:#60a431;}
.class_pay_wrap dd {margin-bottom:60px;}
.class_pay_list {border: 1px solid #ddd;}
.class_pay_list_pic {display: inline-block;}
.class_pay_list_pic img {width: 150px;}
.class_pay_list_cont {display: inline-block; vertical-align: middle; padding: 0 0 0 22px;}
.class_pay_info {padding-top:14px;}
.class_pay_info table {}
.class_pay_info th, .class_pay_info td {font-size: 16px;}
.class_pay_info th {color: #666; font-weight: normal; padding: 14px 0 8px 20px; width: 110px;}
.class_pay_info td {padding: 10px 0 6px 8px;}
.class_pay_info td .form-control {height: 46px; font-size: 16px; width: 550px;}
.class_pay_method { padding:30px 0 0; text-align: center;}
.class_pay_method a {margin: 0 10px; display: inline-block;}
.class_pay_method a img {width: 230px;}
.btn_pay_wrap {padding:30px 14px 50px; text-align: center}
.btn_pay_wrap button {display:inline-block; width:530px; padding:18px 0; font-size:20px; text-align:center; background:#77b347; border:1px solid #77b347; color:#fff; font-weight:bold; box-sizing:border-box; margin: 0 auto;}
.class_pay_end { text-align: center; padding:20px 0;}
.class_pay_end img {width: 159px;}
.class_pay_end p {font-size:30px; color:#333; padding:25px 0 40px;}

.s_foot_list .btn_st1 {background: #74b243; display: block; color: #fff; border-radius: 4px; padding: 6px 15px 9px; line-height: 1; margin-top: -4px;}











/*0629 store*/
.s_list_ul_arrow {display:inline-block; width:50px; text-align:center; padding-top:60px;}
.s_list_ul_arrow.st2 {width:40px; text-align:center; padding-top:35px; vertical-align:top;}
.s_list_ul_arrow.st2 img {width:15px;}
.s_list_ul_arrow.st2 button {background: none; border:none;}
.s_list_ul_arrow2_pre button, .s_list_ul_arrow2_next button {background: none; border:none;}
.s_list_ul_arrow2_pre.st1 {position: absolute; left: -40px; top:170px;}
.s_list_ul_arrow2_next.st1 {position: absolute; right: -40px; top:170px;}
.s_list_ul_arrow2_pre.st2 {position: absolute; left: -40px; top:110px;}
.s_list_ul_arrow2_next.st2 {position: absolute; right: -40px; top:110px;}
.s_list_ul_arrow2_pre.st3 {position: absolute; left: -40px; top:105px;}
.s_list_ul_arrow2_next.st3 {position: absolute; right: -40px; top:105px;}
.s_list_ul_arrow2_pre.st4 {position: absolute; left: -40px; top:40px;}
.s_list_ul_arrow2_next.st4 {position: absolute; right: -40px; top:40px;}
.s_list_ul_arrow2_pre.st5 {position: absolute; left: 0px; top:59px;}
.s_list_ul_arrow2_next.st5 {position: absolute; right: 0px; top:59px;}
.s_list_ul_arrow2_pre.st6 {position: absolute; left: 0px; top:32px;}
.s_list_ul_arrow2_next.st6 {position: absolute; right: 0px; top:32px;}

.gnb_nav ul li .glyphicon {font-size: 14px; margin:-2px 0 0 6px;}
.gnb_nav ul.dropdown-menu {width: 80%; padding:7px 0 8px; margin-top:4px;}
.gnb_nav ul.dropdown-menu li {display: block; width: 100%;}
.gnb_nav ul.dropdown-menu li a {color: #666; margin: 0; font-size: 16px; padding:5px 0 6px;}
.exhibition_box {padding: 0; margin: 0;}
.exhibition_box li {list-style: none; display: inline-block;}
.chefDivs_li {display: table-cell; padding: 10px;}
.chefDivs_li img {width:90px;height:90px;border-radius:50%}
.chefDivs_li_name {display:block;width:90px;height:30px;overflow:hidden;text-align:center; padding-top: 8px;}
.chefDivs_li .alim_btn_st2 {width: 90px;margin-top:10px;}
.h_ranking_list_ul {margin:0 auto;}
.home_cont .h_ranking_list_li, .h_ranking_list_li {display:inline-block; width:24%; margin:0 8px 12px 0; vertical-align:top; font-size: 16px; background:#f6f6f6; border-radius: 30px; padding:0 30px;}
.h_ranking_list_li a {padding:13px 0 17px 0; display: inline-block;}
.h_ranking_num {background:#fff; border:1px solid #bbb; -webkit-box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.08); box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.08); min-width:36px; text-align:center; border-radius:4px;  line-height:1; padding:7px 7px 10px; letter-spacing:-0.03em; vertical-align:unset; display: inline-block; margin: 0 12px 0 0; font-size: 17px; font-weight: bold;}
.h_ranking_num.st2 {position: absolute; left: -3px; top: -3px; z-index: 10;}
.rcp_m_cate table th {text-align: center; vertical-align: top; border-right: 1px solid #e6e7e8; border-bottom: 1px solid #e6e7e8;}
.rcp_m_cate table th span {color:#74b243; display:block; font-weight:500; margin:0 5px 0 0; text-align:center; padding-top:6px; vertical-align:middle; font-size:15px; height: 41px; width: 100%; padding-top:12px;}
.rcp_m_cate table td {border-bottom: 1px solid #e6e7e8;}
.common_vod_label {position:absolute; right:10px; bottom:10px; z-index:10;}
.common_vod_label img {border-bottom:none;}
.s_list_ea {border-bottom:1px solid #e6e7e8; font-size:15px; padding:6px 4px 12px; margin:14px 30px 0; }
.s_list_ea b {color:#407d15; padding-left:5px;}
.s_list_ea.tit {font-size: 28px; padding-top: 14px;}

.view_reply .photoreview_list {padding:12px 4px;}
.view_reply .photoreview_list li img {width: 128px; height: 128px;}
.view_reply .photoreview_list li .last_more {width: 128px; height: 128px; padding-top:40px;}
.view_reply .reply_qa .media {margin-top: 5px;}


.modal .photoreview_layer.D_rcp_list li {background: none;}
.modal .layer_view_arrow button {background: none; border: none;}
.modal .photoreview_layer {padding:25px 15px 30px 5px;}

.rcp_top_noti2 {position:fixed; width: 100%; left: 0; top: 0; right: 0; z-index: 1000; height:44px; margin: 0 auto;}
.rcp_top_noti_cont {width:50%; float: left; height:44px;}
.rcp_top_noti_cont a {text-align: center; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; padding: 12px 8px 0; display:block;} 
.rcp_top_noti_cont.tab1 {background: #eaf1ce; border-right: 1px solid #fff;}
.rcp_top_noti_cont.tab1 a {width: 620px; color: #677b20; float: right;}
.rcp_top_noti_cont.tab1 a b {color: #384507;}
.rcp_top_noti_cont.tab2 {background: #ffefc9;}
.rcp_top_noti_cont.tab2 a {width: 620px; color: #b28622}
.rcp_top_noti_cont.tab2 a b { color: #664701;}
.rcp_top_noti_cont a svg {vertical-align: -4px; margin-left:6px;}
.modal-tab_area {padding: 0 39px 30px;}
.modal-tab {display: table; width: 100%; }
.modal-tab a {display: table-cell; color: #999; background:#ededed; text-align: center; font-size: 18px; border-radius:12px 12px 0 0; line-height: 1; padding: 18px 0; border-bottom: 1px solid #74b243;}
.modal-tab a.active {background: #74b243; color: #fff;}
.modal-tab_smn {border-bottom: 1px solid #ddd; padding-left: 10px;}
.modal-tab_smn a {display: inline-block; padding:16px 0;}
.modal-tab_smn a span {border-right: 1px solid #ddd; padding:0 20px; line-height: 1; font-size: 15px; color: #999;}
.modal-tab_smn a:last-child span {border-right:none;}
.modal-tab_smn a.active span {color: #000;}
.modal-faq_area {padding: 0 39px 30px;}
.modal-faq_tit {color: #9e8373; font-size:40px; font-weight: 500; letter-spacing: -0.05em; line-height: 1;}
.modal-faq_tit span {color: #e09a78;}


.faq_list {padding:20px 0;}
.faq_list .panel-group { width: 100%; border-bottom: 1px solid #ddd;}
.faq_list .panel-default>.panel-heading {line-height: 1.2; background: transparent;}
.faq_list .panel-heading {border-top: 1px solid #ddd; padding:15px 20px 17px;}
.faq_list .panel-group .panel {border: none;}
.faq_list .panel-collapse.in {border-bottom: none;}
.faq_list .panel-title {font-size: 16px; padding-left:30px; background: url(//recipe1.ezmember.co.kr/img/partners/icon_faq_q.png) left top no-repeat; background-size: 21px;}
.faq_list .panel-body {padding: 15px 50px 20px; background: url(//recipe1.ezmember.co.kr/img/partners/icon_faq_a.png) #f9f9f9 22px 17px no-repeat; background-size: 21px; color: #888; font-weight: 300;}
.faq_list .panel-body .blank {display: block;}
.ptn_tit_faq_w {float: right; color: #888; font-size: 15px; padding-top: 18px;}
.ptn_tit_faq_w a {color: #64a70b; text-decoration: underline;}
.ptn_tit_faq_m {display: none;}

.modal-faq_area .accordion-caret .accordion-toggle {display: block;}
.modal-faq_area .accordion-caret .accordion-toggle:not(.collapsed) { background: url(//recipe1.ezmember.co.kr/img/mobile/icon_arrow7_up.png) right center no-repeat; background-size: 20px;}
.modal-faq_area .accordion-caret .accordion-toggle.collapsed {background: url(//recipe1.ezmember.co.kr/img/mobile/icon_arrow7_down.png) right center no-repeat; background-size: 20px;}


.home_cont.recruit {padding:8px 25px 0;}
.home_cont.recruit dt {display:inline-block; vertical-align: middle; padding: 0 54px 10px; margin-bottom: 0;}
.home_cont.recruit dd {display:inline-block; vertical-align: middle; width: 890px; padding-right: 10px;}
.home_cont_recruit {display: table; width: 100%; margin: 0; }
.home_cont_recruit li {display: table-cell; width: 1%; text-align: center; background: url(//recipe1.ezmember.co.kr/img/img_recruit_line.png?v.1) left 10px no-repeat; background-size:30px; padding-left:20px!important;}
.home_cont_recruit li a {display: block; padding-left: 60px;}
.home_recruit_img {display: table-cell; vertical-align: middle; padding-right:10px;}
.home_recruit_img img {width: 100px;}
.home_recruit_cont {display: table-cell; text-align: left; vertical-align: middle;}
.home_recruit_cont p {margin-bottom: 2px; font-size: 18px; letter-spacing: -0.05em;}
.home_recruit_cont svg {color: #aaa; margin-left: 1px;}

.letter_floating {width: 550px; height: 270px; background: url(//recipe1.ezmember.co.kr/img/letter_popup_img.png) #64a70b right bottom no-repeat; background-size:156px;}
.letter_floating_tit {margin:20px 20px 15px 20px; border-bottom: 1px solid #83b93c; padding-bottom:15px}
.letter_floating_tit b {color: #fff; font-size:20px; padding-left:5px;}
.letter_floating_tit a {float: right; color: #fff; padding:0 5px}
.letter_floating_cont { padding:0 32px;}
.letter_floating_cont_txt {font-size: 16px; color: #fff; line-height: 1.7; padding-left: 4px; padding-bottom:6px}
.letter_floating_cont_btn {padding-top:26px; padding-bottom:15px;}
.letter_floating_cont_btn a {color: #fff; font-size: 16px; background: #3a5a11; border-radius:6px; padding:8px 20px 10px ;line-height: 1; -webkit-box-shadow:1px 1px 4px rgba(0, 0, 0, 0.2); box-shadow:1px 1px 4px rgba(0, 0, 0, 0.2);}
.letter_floating_cont_btn a:hover, .letter_floating_cont_btn a:focus {color: #fff;}
.letter_floating_cont_btn a img {vertical-align: top; margin-left: 4px;}
.letter_floating_check label {font-weight: normal; color: #cadeb9; font-size: 12px;}
.letter_floating_check input[type=checkbox] {background:#64a70b; border: 1px solid #cadeb9;}
.letter_floating_check span {padding-left: 3px; vertical-align:2px;}
.letter_floating_cont input {border: 2px dashed #ffde00; background: #64a70b; color: #ffde00; outline-style:none; padding:6px 10px 9px; margin-bottom: 4px; font-size: 16px;}
.letter_floating_cont input::-ms-input-placeholder { color: #ffde00; font-weight: normal;}
.letter_floating_cont input::-webkit-input-placeholder { color: #ffde00; font-weight: normal;} 
.letter_floating_cont input::-moz-placeholder { color: #ffde00; font-weight: normal;}


.letter_apply {}
.letter_apply_top {background: url(//recipe1.ezmember.co.kr/img/letter_top_bg.png) left top repeat-x; height: 170px; text-align: center; padding-top:46px;}
.letter_apply_top img {width:162px;} 
.letter_apply_cont {max-width:600px; width: 100%; margin:0 auto; padding:50px 15px 0;}
.letter_apply_cont1 { font-size:22px; font-weight: 500;}
.letter_apply_cont2 { font-size:15px; line-height: 1.8;}
.letter_apply_cont3 { font-size:15px; color: #999; padding-top: 10px;}
.letter_apply_info {padding-top:46px;}
.letter_apply_info td {font-size: 15px; color: #999; padding-bottom: 16px;}
.letter_apply_info .form-control {border: 1px solid #ddd; padding:10px 12px; height: auto;}
.letter_apply_info table {margin-bottom: 20px;}
.letter_apply_check {font-size: 15px; color: #333; padding: 5px;}
.letter_apply_check label {font-weight: 300;}
.letter_apply_check input {border: 1px solid #999;}
.letter_apply_check span {vertical-align:1px; padding-left: 4px;}
.letter_apply_btn {padding-top:40px;}
.letter_apply_btn a {background: #549a27; color: #fff; font-size: 20px;; text-align: center; display: block; padding: 14px 0}

.push_landing {padding: 0 10px; margin:0 auto; max-width: 780px;}
.push_landing_logo { text-align: center; padding:30px 0;}
.push_landing_list {border: 1px solid #e2e2e2; border-radius: 12px; margin-bottom: 12px;}
.push_landing_list dt {background:url(//recipe1.ezmember.co.kr/img/icon_dot_line.png) center 34px no-repeat; background-size:90px; padding:58px 14px 22px; text-align: center; font-size: 24px; font-weight:500; letter-spacing: -0.04em; line-height: 1.3;}
.push_landing_list dd {padding-bottom:10px;}
.push_landing_list_pic {padding: 0 12px 16px; }
.push_landing_list_pic img {max-width: 100%; width: 100%; border-radius: 10px;}
.push_landing_list_cont {color: #666; font-size: 16px; letter-spacing: -0.04em; font-weight:300; padding: 0 18px 25px; line-height: 1.6;}
.push_landing_list_btn {text-align: center; padding-bottom:20px;}
.push_landing_list_btn a {display: inline-block; border:1px solid #bbb; color: #999; font-size: 15px; padding:7px 40px 8px; border-radius: 30px; line-height: 1; }
.push_landing_list_btn a:hover {color: #999;}


.class_cate_wrap {padding:0 30px 0;}
.class_cate {border-bottom: 1px solid #ddd; padding: 14px 0; display: table; margin-bottom: 0;}
.class_cate li {display:table-cell; width:1%; font-size: 18px; padding:6px 0 0 52px; height: 40px; text-align: center;}
.class_cate li.class_cate_1 {background:url(//recipe1.ezmember.co.kr/img/icon_class_cate1.png) 60px center no-repeat; background-size: 46px;}
.class_cate li.class_cate_2 {background:url(//recipe1.ezmember.co.kr/img/icon_class_cate2.png) 56px center no-repeat; background-size: 46px;}
.class_cate li.class_cate_3 {background:url(//recipe1.ezmember.co.kr/img/icon_class_cate3.png) 56px center no-repeat; background-size: 46px;}
.class_cate li.class_cate_4 {background:url(//recipe1.ezmember.co.kr/img/icon_class_cate4.png) 56px center no-repeat; background-size: 46px;}
.class_cate li.class_cate_5 {background:url(//recipe1.ezmember.co.kr/img/icon_class_cate5.png) 50px center no-repeat; background-size: 46px;}
.class_cate li.class_cate_6 {background:url(//recipe1.ezmember.co.kr/img/icon_class_cate7.png) 56px center no-repeat; background-size: 46px;}
.class_cate li a {padding:2px 0; border-right: 1px solid #ddd; line-height: 1; vertical-align: middle; display: inline-block; width: 100%;}
.class_cate li:last-child a {border: none;}
.class_cate li.active a {color: #74b243;}

.class_cate_wrap .story_tag_area {padding:18px 0 0 0; }
.class_cate_wrap .story_tag_list {margin-bottom: 0;}

.class_best {margin: -1px 30px 5px; position: relative; background: #fff;}
.class_best_list { overflow: hidden;}
.class_best_list ul {margin-bottom: 0; padding: 0; }
.class_best_list li {padding: 0; list-style: none; display: inline-block; border-radius:10px; overflow: hidden; position: relative; margin: 0 4px; width:580px; height:280px;}
.class_best_btn_pre {left:-4px; top:98px;}
.class_best_btn_next { right:-6px; top:98px;}
.class_best_btn_pre, .class_best_btn_next { font-size:64px; color: #fff; position: absolute;  display: block; padding:10px 0; filter:alpha(opacity=80); opacity:0.8; line-height: 0;}
.class_best_btn_pre:hover, .class_best_btn_next:hover, .class_best_btn_pre:focus, .class_best_btn_next:focus {color: #fff;}
.class_best_btn_pre .bi, .class_best_btn_next .bi { width: 1em; height: 1em;}
 
.class_best_list_tit { width:580px; height:280px; position: absolute; left: 0; top: 0; padding:152px 0 0 52px; display: block; border-radius:10px 0 0 10px;
/* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#000000+0,000000+80&0.8+0,0+80 */
background: -moz-linear-gradient(45deg,  rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 70%); /* FF3.6-15 */
background: -webkit-linear-gradient(45deg,  rgba(0,0,0,0.7) 0%,rgba(0,0,0,0) 70%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(45deg,  rgba(0,0,0,0.7) 0%,rgba(0,0,0,0) 70%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cc000000', endColorstr='#00000000',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}
.class_best_list_tit_t {color: #fff; font-size: 24px; width:280px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.3; font-weight:300; letter-spacing: -0.04em; margin-bottom:8px;}
.class_best_list_tit_p_per {font-size: 26px; color: #74b243; margin-right: 2px; font-family: roboto;}
.class_best_list_tit_p_per small { font-weight: 300;}
.class_best_list_tit_p_price { color: #fff; font-size: 26px; font-family: roboto; margin-right: 2px; letter-spacing: -0.02em;}
.class_best_list_tit_p_price small {font-size: 18px;}
.class_best_list_tit_p_pre { color: #aaa; text-decoration: line-through; font-size: 18px;}



/*211220*/
.join_btn2_k {padding-top:30px;}
.join_btn2_k .btn, .join_btn2_n .btn {background: #ffe600; color: #333; width: 100%; padding: 0; border:1px solid rgba(0, 0, 0, 0.14); outline-style:none; border-radius:10px; -webkit-box-shadow:0 2px 3px rgba(0, 0, 0, 0.08); box-shadow:0 2px 3px rgba(0, 0, 0, 0.08);}
.join_btn2_k .btn span {font-size:20px; padding:16px 0px 15px 46px ; background:url(//recipe1.ezmember.co.kr/img/mobile/2022/icon_sns_k.png) left 16px no-repeat; background-size:30px auto; display: inline-block;}
.join_btn2_n {padding-top:0;}
.join_btn2_n .btn {background: #fff;}
.join_btn2_n .btn span {font-size:20px; padding:16px 0px 15px 46px ; background:url(//recipe1.ezmember.co.kr/img/mobile/2022/icon_sns_n2.png) left 16px no-repeat; background-size:30px auto; display: inline-block;}
.join_btn2_etc {text-align: center; padding:8px 0 40px;}
.join_btn2_etc .btn {padding:6px; background: #fff; width:62px; height:62px; margin: 0 15px; border:1px solid rgba(0, 0, 0, 0.14); outline-style:none; border-radius:50%; -webkit-box-shadow:0 2px 3px rgba(0, 0, 0, 0.08); box-shadow:0 2px 3px rgba(0, 0, 0, 0.08);}
.join_btn2_etc .btn img {width:100%; }
.join_btn2_k .btn:hover, .join_btn2_n .btn:hover, .join_btn2_etc .btn:hover, .join_btn2_k .btn:focus, .join_btn2_n .btn:focus, .join_btn2_etc .btn:focus {outline-style:none;}
.form_login_in {display:table-cell; width: 1%;}
.form_login_in input {border: none; border-bottom:1px solid #ccc; font-size: 18px; padding: 10px 2px; width: 100%; outline-style:none;}
.form_login_btn {width: 100%; text-align: center; margin:30px 0;}
.form_login_btn button {background: #fff; color: #333; font-size:20px; border: 1px solid rgba(0, 0, 0, 0.14); padding:10px 60px 11px; border-radius: 28px; outline-style:none; -webkit-box-shadow:0 2px 3px rgba(0, 0, 0, 0.08); box-shadow:0 2px 3px rgba(0, 0, 0, 0.08);}
.join_btn3 {text-align: center; font-size: 16px; padding:20px 0;}
.join_btn3 a {padding: 6px 10px; text-decoration: underline; color: #666;}

.form_join_i {padding-top: 20px;}
.form_join_i .form-control {box-shadow: none;}
.form_join_i .form-control:focus {box-shadow: none; border-color:#ccc;}
.form_join_p {border: 1px solid #ddd; padding:15px 18px 10px; margin:40px 0 15px;}
.form_join_p .guide_txt2 {padding:2px 6px;}
.form_join_p .guide_txt2 span {margin-bottom: 0; font-size: 14px;}
.form_join_p .guide_txt2 span a {text-decoration: underline;}
.form_join_p .guide_txt2 b {color: #999; font-weight: normal;padding-left:4px;}
.form_join_p .guide_txt2.check_all {border-bottom: 1px solid #ddd; padding-bottom:12px; margin-bottom:12px}
.form_join_p .guide_txt2.check_all span {font-size: 16px;}

input:-webkit-autofill { -webkit-box-shadow: 0 0 0 30px #fff inset ; -webkit-text-fill-color: #000; }
input:-webkit-autofill, input:-webkit-autofill:hover, input:-webkit-autofill:focus, input:-webkit-autofill:active { transition: background-color 5000s ease-in-out 0s; }




















.mag_5 {margin:5px !important;}
.mag_10 {margin:10px !important;}
.mag_15 {margin:15px !important;}
.mag_t_-20 {margin-top:-20px !important;}
.mag_t_5 {margin-top:5px !important;}
.mag_t_10 {margin-top:10px !important;}
.mag_t_15 {margin-top:15px !important;}
.mag_t_35 {margin-top:35px !important;}
.mag_r_5 {margin-right:5px !important;}
.mag_r_10 {margin-right:10px !important;}
.mag_r_15 {margin-right:15px !important;}
.mag_b_-20 {margin-bottom:-20px !important;}
.mag_b_5 {margin-bottom:5px !important;}
.mag_b_10 {margin-bottom:10px !important;}
.mag_b_15 {margin-bottom:15px !important;}
.mag_b_25 {margin-bottom:25px !important;}
.mag_l_5 {margin-left:5px !important;}
.mag_l_10 {margin-left:10px !important}
.mag_l_15 {margin-left:15px !important;}
.mag_l_30 {margin-left:30px !important;}

.pad_5 {padding:5px !important;}
.pad_10 {padding:10px !important;}
.pad_15 {padding:15px !important;}
.pad_t_5 {padding-top:5px !important;}
.pad_t_10 {padding-top:10px !important;}
.pad_t_15 {padding-top:15px !important;}
.pad_t_25 {padding-top:25px !important;}
.pad_t_35 {padding-top:35px !important;}
.pad_r_5 {padding-right:5px !important;}
.pad_r_10 {padding-right:10px !important;}
.pad_r_15 {padding-right:15px !important;}
.pad_b_5 {padding-bottom:5px !important;}
.pad_b_10 {padding-bottom:10px !important;}
.pad_b_15 {padding-bottom:15px !important;}
.pad_b_20 {padding-bottom:20px !important;}
.pad_b_25 {padding-bottom:25px !important;}
.pad_l_5 {padding-left:5px !important;}
.pad_l_10 {padding-left:10px !important;}
.pad_l_15 {padding-left:15px !important;}
.pad_l_20 {padding-left:20px !important;}
.pad_l_30 {padding-left:30px !important;}
.pad_l_40 {padding-left:40px !important;}
.pad_l_60 {padding-left:60px !important;}















.common_sp_caption_per {font-size:20px; color:#73b142; letter-spacing:-0.02em; margin-right:2px; font-family: roboto;}
.common_sp_caption_per small {font-weight: normal;}
.common_sp_caption_pre {font-size: 14px; color: #999; text-decoration: line-through; margin-left: 2px; }



/*공통부분*/
.common_sp_list_ul {margin: 0; vertical-align: top;}
.common_sp_list_ul.ea3 li {width: 381px;}
.common_sp_list_ul.ea4 li {width: 282px;}
.common_sp_list_ul.ea4_sm li {width:195px; margin : 0 6px 40px;}
.common_sp_list_ul.ea5 li {width: 222px;}
.common_sp_list_li {list-style:none; padding: 0; margin: 0 12px 40px 0; display: inline-block; vertical-align: top; position: relative;}
.common_sp_thumb { position: relative; border-radius: 4px; overflow: hidden;}
.common_sp_thumb img {width: 100%; }
.common_sp_icon_free {position: absolute; right: 0; bottom: 0; background:rgba(0, 0, 0, 0.4); color: #fff; line-height: 1; padding:6px 8px; border-radius: 4px;}
.common_sp_icon_add {position: absolute; right:4px; bottom:5px; background:#ffde00; color: #000; line-height: 1; padding:4px 10px 5px; border-radius:20px; font-size:12px; -webkit-box-shadow:2px 2px 0 rgba(0, 0, 0, 0.2); box-shadow:2px 2px 0 rgba(0, 0, 0, 0.2);}
.common_sp_icon_add b { color:#d70000; font-size:130%; vertical-align:-1px;}
.common_sp_icon_add small { color:#d70000;}
.common_sp_caption {padding:10px 2px;}
.common_sp_caption_tit {margin:0 0 6px 0; color: #000; text-align: left; font-size: 15px;}
.common_sp_caption_tit.line1 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.5;}
.common_sp_caption_tit.line2 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.5;}
.common_sp_caption_tit.line3 {overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; word-wrap:break-word; white-space:normal; line-height:1.5;}
.common_sp_caption_tit.rv {font-weight: normal; }
.common_sp_caption_name {padding: 6px 2px 0 0; color: #666; vertical-align:middle; font-size: 13px;}
.common_sp_caption_name_pic { margin: 0;}
.common_sp_caption_name_pic img {width:28px; height: 28px; border-radius: 50%; margin-right: 4px;}
.common_sp_caption_rv {vertical-align:super;  line-height:1; margin: 0 0 9px 0;}
.common_sp_caption_rv_star {vertical-align:1px;}
.common_sp_caption_rv_star img {width: 14px; margin-right: 1px; margin: 0;}
.common_sp_caption_rv2 {vertical-align:middle; line-height:0;}
.common_sp_caption_rv2 img {width: 14px; margin-right: 2px;}
.common_sp_caption_rv2 .common_sp_caption_rv_ea {margin-right: 1px; font-size: 12px;}
.common_sp_caption_rv2 .common_sp_caption_rv_ea b {padding-right: 2px;}
.common_sp_caption_price_box {padding:0; margin: 0 0 4px 0; line-height: 1;}
.common_sp_caption_price {font-size:20px; color:#000; font-weight:600; letter-spacing:-0.02em; font-family: 'Montserrat';}
.common_sp_caption_price.st2, .common_sp_caption_price.st2 small {color:#000; }
.common_sp_caption_price small {font-weight:normal; color:#000; font-size:16px; margin-left:1px; font-family: 'Noto Sans KR', sans-serif;}
.common_sp_caption_buyer {color:#999; font-size:13px; margin-left:2px; font-weight:300;}
.common_sp_caption_rv_ea {color:#999; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; font-size:12px; vertical-align:middle; padding-left: 1px; line-height:normal; font-weight:300;}
.common_sp_caption_rv_name {color:#999; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; font-size:14px; vertical-align:0; padding:0  1px 7px 0; font-weight: 300;}
.common_sp_caption_rv_name img {width: 22px; height: 22px; border-radius: 50%; margin:0 4px -2px 0; vertical-align: text-bottom;}
.common_sp_caption_pdt {vertical-align:middle; line-height: 1; margin-top: -2px;}
.common_sp_caption_pdt img {width:21px; margin-right: 2px; -webkit-filter: grayscale(100%); filter: gray; vertical-align:-6px;}
.common_sp_caption_rv_box {display: table-cell;width:100%;}
.common_sp_caption_rv_img {display: table-cell; vertical-align: top; padding:0 0 0 6px;}
.common_sp_caption_rv_img img {border-radius:3px;}



.common2_sp_caption_rv2 {margin-left: -1px; line-height: 1; margin-bottom:10px; margin-top: 10px;}
.common2_sp_caption_price_box {padding:0; padding-bottom:8px; line-height: 1;}
.common2_sp_caption_price {color: #222;}
.common2_sp_caption_price span {font-size:18px; color:#000; font-weight:600; letter-spacing:-0.02em; font-family: 'Montserrat' }
.common2_sp_caption_price small {font-size:16px;}
.common2_sp_caption_per {font-size:18px; color:#ff5e5e; letter-spacing:-0.02em; font-family: 'Montserrat' }
.common2_sp_caption_per b {font-weight:600; }
.common2_sp_caption_pre {color: #c3c3c3; text-decoration: line-through; padding-bottom:8px;}
.common2_sp_caption_icon {margin-top: 2px;}
.common2_sp_caption_icon .icon_free {font-size: 11px; color: #555; border-radius:2px; border:1px solid #ddd; padding:1px 6px; display: inline-block; height: 24px;}
.caption_rv2_img {background: url(//recipe1.ezmember.co.kr/img/mobile/icon_star6_on.png?v.2) 1px center no-repeat; background-size:84px; width:16px; height:18px; display: inline-block; margin-right:4px; vertical-align:sub;}
.caption_rv2_pt {vertical-align: 0; margin-right:4px; font-size: 14px; font-family: 'Montserrat'; font-weight:600;}
.caption_rv2_ea {color:#666; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; vertical-align:0; -moz-vertical-align:0; font-size: 14px; line-height: 1; font-family: 'Montserrat'; font-weight:500;}


.panel-body pre {padding: 22px;}

.common_rcp_list_ul.ea3 { padding: 0 10px;}
.common_rcp_list_ul.ea3 .common_rcp_thumb {border: 1px solid #e6e6e6;}
.common_rcp_list_ul.ea3 .common_rcp_caption, .common_rcp_list_ul.ea3 .price_box {padding-left:6px;}
.common_rcp_list_ul.ea3 .common_sp_caption_icon2 {display: inline-block; vertical-align:3px; padding-left:5px;}
.common_rcp_list_ul.ea3 .common_sp_caption_icon2 img {width:66px;}
.common_rcp_list_ul.ea3 .common_rcp_caption_tit {padding-top: 12px;}

</style>


      

   <br><br>
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
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
   </div> 
</body>
</html>