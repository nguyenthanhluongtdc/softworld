var REQUEST_PARAM_ACTION_REPORT_METHOD;
$(document).ready(function() {

	//カレンダーの表示
	var d = new Date();
	var year = d.getFullYear() - 20;
	var yearn = d.getFullYear();
	var day = d.getDate();
	var yrRange = (yearn -100) + ':' + d.getFullYear() +2;

    var date = new Date();
    var year = date.getFullYear();
    $.datepicker.setDefaults({
        defaultDate: new Date(yearn, d.getMonth(), day),
        changeMonth: true,
        changeYear: true,
        yearRange : yrRange,
        //minDate:'-1y',
        maxDate:'+3y',
        closeText: '閉じる',
        prevText: '<前',
        nextText: '次>',
        currentText: '今日',
        monthNames: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
        monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
        dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
        dayNamesShort: ['日','月','火','水','木','金','土'],
        dayNamesMin: ['日','月','火','水','木','金','土'],
        weekHeader: '週',
        showOn: 'button',
        buttonText: '',
        buttonImage: 'theme/admin/tb/images/icons/calendar.png',
        buttonImageOnly: true,
        dateFormat: 'yy/mm/dd',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: true,
        yearSuffix: '年',
        minDate: new Date(2005, 1 - 1, 1),
 	});

	$(".calendar").each(function(){
		var dateValue = $(this).val();
		var idSelector = "#" + $(this).attr("id");
		if(dateValue != "") {
			var dates = $(this).val().split('/');
			$(idSelector + "_year").val(dates[0]);
			$(idSelector + "_month").val(dates[1]);
			$(idSelector + "_day").val(dates[2]);
		}
		$(idSelector + '_datetime_picker').datepicker();
		$(idSelector + '_datetime_picker').change(function(){
			var dates = $(this).val().split('/');
			$(idSelector + "_year").val(dates[0]);
			$(idSelector + "_month").val(dates[1]);
			$(idSelector + "_day").val(dates[2]);
		});
		$(idSelector + "_year," + idSelector + "_month," + idSelector + "_day").change(function(){
			var newdate = $(idSelector + "_year").val() + '/' + $(idSelector + "_month").val() + '/' + $(idSelector + "_day").val();
			if(newdate !== '0/0/0')
       			$(idSelector + '_datetime_picker').val(newdate);
       		else
       			$(idSelector + '_datetime_picker').val(null);
		});

        $(idSelector + "_clear").click( function(){
	    	$(idSelector + "_year").val("");
			$(idSelector + "_month").val("");
			$(idSelector + "_day").val("");
			$(idSelector + '_datetime_picker').val("");
    	});
	});

	$(".date-input input.year, .date-input input.month, .date-input input.day").change(function(){
		$parent = $(this).parent();
		year = $parent.find("input.year").val();
		month = $parent.find("input.month").val();
		$day = $parent.find("input.day");
		if($day && $day.length > 0) {
			day = $day.val();
			if(year != "" || month != "" || day != "") {
				$parent.find("input.ymd").val(year + "-" + month + "-" + day);
			} else {
				$parent.find("input.ymd").val("");
			}
		} else {
			if(year != "" || month != "") {
				$parent.find("input.ymd").val(year + "-" + month);
			} else {
				$parent.find("input.ymd").val("");
			}
		}
	});
   
   	function singleQuoteToUnicode(theString) {
      return theString.replace(/[']/g, "\\u0027");
    }

	$(".input_confirm").click(function(){
		if(confirm("Bạn có muốn lưu thay đổi")){
			return true;
		}else return false;
	})

	$('.btn-delete').click(function(){
		$this = $(this).prev();
		customDialog('Ban co muon xoa khong', function(){
			submitDelete($this);
		}, function (){

		})
	})

	function customDialog(message, yesCallback, noCallback) {
		var dialog = $('#modal_dialog').dialog();
	
		$('.btn-ok').click(function() {
			dialog.dialog('close');
			yesCallback();
		});
		$('#btnNo').click(function() {
			dialog.dialog('close');
			noCallback();
		});
	}

	function submitDelete($this){
		// var confirmMsg = $(this).attr("confirm-msg");
		// var isSubmit = true;
		// if(confirmMsg) {
		// 	isSubmit = confirm(confirmMsg);
		// } 

		//if(isSubmit) {
			var submitAction = $this.attr("submit-action");
			var submitMethod = $this.attr("submit-method");

			var $targetForm = $("<form></form>");
			$targetForm.attr("action", submitAction);
			$targetForm.attr("method", submitMethod);
			$("body").append($targetForm);

			var formData = $this.attr("submit-data");
			if(formData) {
				jsonData = $.parseJSON(formData);
				$.map(jsonData, function(val, key){
					$param = $targetForm.find("#" + key);
					if($param && $param.length > 0) {
						$param.val(val);
					} else {
						if(val instanceof Object) {
			        		$targetForm.append("<input type='hidden' name='"+key+"' value='"+singleQuoteToUnicode(JSON.stringify(val))+"' />");
						} else {
			        		$targetForm.append("<input type='hidden' name='"+key+"' value='"+val+"' />");
						}
					}
				});
			}
			$targetForm.submit();
		//}
	}
	
	$(".submit-form").click(function(){
		submitDelete($(this));
	});

	$("div.pagging ul li a").click(function() {
		var targetForm = "#" + $(this).parents("div.pagging").attr("target-form");
		var page = $(this).attr("page");
		$currentPage = $(targetForm + " #current_page" + "," + targetForm + " input[name='current_page']");
		if($currentPage && $currentPage.length > 0) {
			$currentPage.val(page);
		} else {
        	$(targetForm).append("<input type='hidden' name='current_page' value='"+page+"' />");
		}
		$(targetForm).submit();
	});

	$("table.pagging-header select").change(function() {
		var targetForm = "#" + $(this).parents("table.pagging-header").attr("target-form");
        $('input[name="current_page"]').val(1);
		$(targetForm).submit();
	});

	$("tr.sort-data-table a").click(function() {
		var targetForm = "#" + $(this).parents("tr.sort-data-table").attr("target-form");
		var sort = $(this).attr("sort");
		$sortCondition = $(targetForm + " #sort_condition");
		if($sortCondition && $sortCondition.length > 0) {
			$sortCondition.val(sort);
		} else {
        	$(targetForm).append("<input type='hidden' name='sort_condition' value='"+sort+"' />");
		}
		$(targetForm).submit();
	});
    
    $( "input[data-href]" ).click(function() {
        var url = $(this).attr('data-href');
        window.location.href = url;
    });

	$('input.number').attr("autocomplete", "off");
    $('.number').each(function () {
        if (this.type == "text") {
            $(this).change(function(){
                if ($(this).val() != '')
                    $(this).val(convertvalue($(this).val()));
            });
            if ($(this).val() != '')
                $(this).val(convertvalue($(this).val()));
        } else if ($(this).text() != "") {
                $(this).text(convertvalue($(this).text()));
        }

    });

    $("input.action-report").click(function() {
    	var $form = $(this).parents("form");
    	var reportUrl = $form.attr("action");
    	var reportValidateUrl =  reportUrl + "&" + REQUEST_PARAM_ACTION_REPORT_METHOD + "=validate";
    	
    	var submitData = $form.serialize();
    	$form.find("ul.item-error-messages").remove();

    	$.ajax({
            type: 'get',
            dataType: "json",
            url: reportValidateUrl,
            data: submitData,
            success: function (data) {
              if(data.result == true) {
              	$form.submit();
              } else {
              	showErrors(data.errors);
              }
            }
        });
    	return false;
    });
});

function convertvalue(val, isFloat){
    val = val.replace(/[Ａ-Ｚａ-ｚ０-９．]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
    val = val.replace("ー", "-");
    if(isFloat) {
        val = $.number(val, 1, '.', ',');
    } else {
        val = $.number(val, 0, '.', ',');
    }
    return val;
}