
var appErrors = null;

$(document).ready(function() {
	showErrors(appErrors, "#show-error-messages");
});
function clearMessage(selectorAreaError) {
	// clear all current message
	if(selectorAreaError) {
		$(selectorAreaError).remove();
	}
}
function showErrors(errors, selectorAreaError) {
	//check errors !== null
	if(errors != null) {
		var minTop = -1;
		var hasErrorInArea = false;
		for (var i = 0; i < errors.length; i++) {
			var message = errors[i].message;
			var itemId = errors[i].itemId;

			console.log(message+'---'+itemId)

			var $item = $("#" + itemId);
			if($item && $item.length > 0) {
				var offset = $item.offset();
				if(offset && (minTop == -1 || offset.top < minTop)) {
					minTop = offset.top;
				}
				var $itemNext = $item.next();
				if($itemNext && $itemNext.length > 0 && $itemNext.hasClass("item-error-messages")) {
					$itemNext.append("<li>" + message + "</li>");
				} else {
					$item.after("<ul class='item-error-messages'><li>" + message + "</li></ul>");
				}
			} else {
				$(selectorAreaError).append("<li>" + message + "</li>");
				hasErrorInArea = true;
			}
			
		}

		if(hasErrorInArea) {
			$(selectorAreaError).show();
			//$(selectorAreaError).fadeOut(20000);
		} else {
			$(selectorAreaError).hide();
		}
		
		if(minTop != -1) {
			// scroll to minTop
			$(window).scrollTop(minTop - 100);
		}

	}
}