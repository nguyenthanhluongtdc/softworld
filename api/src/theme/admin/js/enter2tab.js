$(document).ready(function() {
	$(document).on("keydown", "[tabindex]:not(textarea)", function (e) {
		if(true || this.type != "submit") {
	        var isEnter = e.which == 13;
	        if (isEnter) {
	            e.preventDefault();
	            var tabindex = parseInt($(this).attr("tabindex"));
	            var $next =
	            $("input[tabindex='"+(tabindex+1)+"'], input[tabindex='"+(tabindex+1)+"'], select[tabindex='"+(tabindex+1)+"']");
	            if($next && $next.length > 0) {
		            $next.focus();
	            } else {
	            	var $prev =
			            $("input[tabindex='1'], input[tabindex='1'], select[tabindex='1']");
			        $prev.focus();
	            }
	        }	
		}
     });
	initEnter2Tab(".enter2tab");
});

function initEnter2Tab(selector) {
	$(selector).each(function() {
		var tabindex = 0;
		$(this).find("input[type='text'],input[type='submit'], input[type='button'], select")
		.filter(":not([disabled]):not([readonly]):visible").each(function(){
			tabindex++;
			$(this).attr("tabindex", tabindex);
		});
	});
}
