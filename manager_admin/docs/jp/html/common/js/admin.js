var agent = navigator.userAgent;
if(agent.search(/iPhone/) != -1){
    var _CARRIER = 'sphone';
    var _CARRIER_NAME = 'iphone';

}else if(agent.search(/Android/) != -1){
    var _CARRIER = 'sphone';
    var _CARRIER_NAME = 'android';

}else if(agent.search(/iPad/) != -1){
    var _CARRIER = 'tablet';
    var _CARRIER_NAME = 'ipad';

}else{
    var _CARRIER = 'pc';
    var _CARRIER_NAME = 'pc';
}

$(function(){
    //if(_CARRIER == 'pc') $("body").niceScroll();

    //■ENTER規制
    if($("#MntForm").size() > 0){
        $("#MntForm input").keypress(function (e) {
            if((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)){
                return false;
            }else{
                return true;
            }
        });
    }

    //■一覧削除チェック
    $(".masterCh").click(function(){
        var checkedStatus = $(this).find('span').hasClass('checked');
        $("tr .chChildren input:checkbox").each(function(){
            this.checked = checkedStatus;
            if (checkedStatus == this.checked){
                $(this).closest('.checker > span').removeClass('checked');
            }
            if(this.checked){
                $(this).closest('.checker > span').addClass('checked');
            }
        });
    });

    //■ファイルを参照
    //$('.upload_ystaff').change(function(){
    $(document).on('change','.upload_local_files',function(e){
        e.preventDefault();
        var id = $(this).attr('id');
        //var para = GetUploadLocalFilesPara(id);
        //$(this).upload('inc/jquery.upload.php?mode=site'+para,UploadLocalFilesCallback(),'html');
		var para = GetUploadLocalFilesPostPara(id);
		/*$(this).upload(
			'inc/jquery_upload2.php',
			para,
			UploadLocalFilesCallback(),
			'html'
		);*/
		$(this).upload(
			'inc/jquery.upload.php',
			para,
			function (res) {
				if(!res || typeof(res) == 'undefined'){
					return;
				}
				if(res == 'error_nofile'){
					alert('ファイルが選択されていません。');
				}else if(res == 'error_ext'){
					alert('拡張子は、.jpgか.gifまたは.pngでご登録願います。');
				}else if(res == 'error_size'){
					alert('ファイルのサイズが大きすぎます。');
				}else{
					var arr_res = JSON.parse(res);
					if(typeof(arr_res['img_name']) != 'undefined' && typeof(arr_res['img_val']) != 'undefined'
					&& typeof(arr_res['id']) != 'undefined' && typeof(arr_res['img_updir']) != 'undefined'){
						if(typeof(arr_res['box_id']) != 'undefined'){
							ShowElfThumbnails(arr_res['img_name'],arr_res['img_val'],arr_res['id'],arr_res['img_updir'],arr_res['box_id']);
						}else{
							ShowElfThumbnails(arr_res['img_name'],arr_res['img_val'],arr_res['id'],arr_res['img_updir']);
						}
					}
				}
			},
			'html'
		);
    });

	if($('div').hasClass('picker')){
		$('.picker').farbtastic('#newsgenre_file_img');
	}	

});

function popitup(url,winname,width,height,scrollbars){
    newwindow=window.open(url,winname,'width='+width+',height='+height+',top=70,left=70,resizable=yes,scrollbars=yes,menubar=no,toolbar=no,directories=no,location=no,status=no');
    if (window.focus) {newwindow.focus()}
    return false;
}

//function checkAll(form, flag, field) {
//    if ( typeof field == 'undefined' ) {
//        for (var i = 0; i < form.elements.length; i++) {
//            var e = form.elements[i];
//            if(e.type == 'checkbox'){
//                e.checked = flag;
//            }
//        }
//    } else {
//        for (var i = 0; i < form.elements.length; i++) {
//            var e = form.elements[i];
//            if(e.type == 'checkbox' && e.name == field){
//                e.checked = flag;
//            }
//        }
//    }
//}

//■ArrangeCheckbox
function ArrangeCheckbox(field,classval){
    var field,classval;
    if(typeof(classval) == 'undefined'){
        classval = '';
    }
    var max = 0;
    $('#'+field+' label'+classval).each(function(){
        if ($(this).width() > max) max = $(this).width()+12;
    });
    if(max > 0){
        $('#'+field+' label'+classval).width(max);
    }
}

function dis_none(){
    if(document.getElementById){
        document.getElementById("FloatBox").style.display="none"
    }else{
        if (document.all){document.all("FloatBox").style.display="none"}
    }
}

//■InsertPageview
function InsertPageview(mode,title){
    var mode,title;
    if(typeof(mode) != 'undefined' && typeof(title) != 'undefined'){
        var html = $.ajax({
           type: 'post',
           cache: false,
           url: 'adminajax.php',
           data:{
               'adminajax':'1',
               'mode':'InsertPageview2',
               'page':mode,
               'title':title
           },
           async: false
        }).responseText;
    }
}

//■MakeErrorMsg
function MakeErrorMsg(errornum){
    var body = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>入力に誤りがあります。（'+errornum+'項目）</strong></div>';
    return body;
}

//■DeleteThumbnails
function DeleteThumbnails(img_name,id,img_updir,cap_name,box_id){
    var img_name,id,img_updir,cap_name,box_id;
    if($('#'+img_name+'_'+id).size() > 0){
        var img_val = $('#'+img_name+'_'+id).val();
    }else{
        var img_val = '';
    }
    var res = $.ajax({
       type: 'post',
       cache: false,
       url: 'top.php',
       data:{
           'myajax':'1',
           'mode':'DeleteThumbnails',
           'img_name':img_name,
           'img_val':img_val,
           'id':id,
           'img_updir':img_updir,
           'cap_name':cap_name,
           'box_id':box_id
       },
       async: false
    }).responseText;

    if(res){
        if(box_id && box_id != ''){
            $('#'+box_id).html(res);
        }else{
            $('#'+img_name+'_'+id+'_form').html(res);
        }
    }
    return false;
}

//■GetUploadLocalFilesPara
function GetUploadLocalFilesPara(id){
    var arr_id = id.toString().split('-'.toString());
    var para = new String();
    if(arr_id[0] && arr_id[0] != '') para += '&img_name=' + arr_id[0];
    if(arr_id[1] && arr_id[1] != '') para += '&id=' + arr_id[1];
    if(arr_id[2] && arr_id[2] != '') para += '&img_updir=' + arr_id[2];
    if(arr_id[3] && arr_id[3] != '') para += '&box_id=' + arr_id[3];
    return para;
}
//Add by T.Yamada (2014/05/25)
function GetUploadLocalFilesPostPara(id){
    var arr_id = id.toString().split('-'.toString());
/*    var para = new Object();
	para[mode] = 'site';
    if(arr_id[0] && arr_id[0] != '') para[img_name] = arr_id[0];
    if(arr_id[1] && arr_id[1] != '') para[id] = arr_id[1];
    if(arr_id[2] && arr_id[2] != '') para[img_updir] = arr_id[2];
    if(arr_id[3] && arr_id[3] != '') para[box_id] = arr_id[3];
*/
	var para = {};
	para.mode = 'site';
    if(arr_id[0] && arr_id[0] != '') para.img_name = arr_id[0];
    if(arr_id[1] && arr_id[1] != '') para.id = arr_id[1];
    if(arr_id[2] && arr_id[2] != '') para.img_updir = arr_id[2];
    if(arr_id[3] && arr_id[3] != '') para.box_id = arr_id[3];
	
    return para;
}

//■UploadLocalFilesCallback
function UploadLocalFilesCallback(res){
    if(!res || typeof(res) == 'undefined') return;
    if(res == 'error_nofile'){
        alert('ファイルが選択されていません。');
    }else if(res == 'error_ext'){
        alert('拡張子は、.jpgか.gifまたは.pngでご登録願います。');
    }else if(res == 'error_size'){
        alert('ファイルのサイズが大きすぎます。');
    }else{
        var arr_res = JSON.parse(res);
        if(
            typeof(arr_res['img_name']) != 'undefined' && typeof(arr_res['img_val']) != 'undefined'
            && typeof(arr_res['id']) != 'undefined' && typeof(arr_res['img_updir']) != 'undefined'
        ){
            if(typeof(arr_res['box_id']) != 'undefined'){
                ShowElfThumbnails(arr_res['img_name'],arr_res['img_val'],arr_res['id'],arr_res['img_updir'],arr_res['box_id']);
            }else{
                ShowElfThumbnails(arr_res['img_name'],arr_res['img_val'],arr_res['id'],arr_res['img_updir']);
            }
        }
    }
}

//■ShowElfThumbnails
function ShowElfThumbnails(img_name,img_val,id,img_updir,box_id){
    var img_name,img_val,id,img_updir,box_id;
    var res = $.ajax({
       type: 'post',
       cache: false,
       url: 'site_mnt.php',
       data:{
           'myajax':'1',
           'mode':'ShowElfThumbnails',
           'img_name':img_name,
           'img_val':img_val,
           'id':id,
           'img_updir':img_updir,
       },
       async: false
    }).responseText;

    if(res){
        if(typeof(box_id) != 'undefined'){
            $('#'+box_id).html(res);
        }else{
            $('#'+img_name+'_'+id+'_form').html(res);
        }
    }
}
//■OpenLocalFiles
//function OpenLocalFiles(id){
//    var id;
////    //alert(id); //TEST
////    $('#'+id).click();
////    return false;
//
//    var $elm = $('#'+id);
//    if(document.createEvent){
//        var e = document.createEvent('MouseEvents');
//        e.initEvent('click', true, true );
//        //e.initMouseEvent("click", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
//        $elm.get(0).dispatchEvent(e);
//    }else{
//        $elm.trigger('click');
//    }
//    return false;
//}

/*
 * jQuery.zip2addr
 *
 * Copyright 2010, Kotaro Kokubo a.k.a kotarok kotaro@nodot.jp
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * https://github.com/kotarok/jQuery.zip2addr
 *
 * Depends:
 *	jQuery 1.4 or above
 */



function today_print_split(id){
    dd = new Date();
    yy = dd.getYear();
    mm = dd.getMonth() + 1;
    dd = dd.getDate();
    if (yy < 2000) { yy += 1900; }
    if (mm < 10) { mm = "0" + mm; }
    if (dd < 10) { dd = "0" + dd; }

    $('select#' + id + '_year').val(yy);
    $('select#' + id + '_month').val(mm);
    $('select#' + id + '_day').val(dd);

}