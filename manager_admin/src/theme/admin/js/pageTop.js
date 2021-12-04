function makeSublist(parent, child, isSubselectOptional, childVal) {
$("body").append("<select style='display:none' id='" + parent + child + "'></select>");
$('#' + parent + child).html($("#" + child + " option"));

var parentValue = $('#' + parent).attr('value');
$('#' + child).html($("#" + parent + child + " .sub_" + parentValue).clone());

childVal = (typeof childVal == "undefined") ? "" : childVal;
$("#" + child + ' option[@value="' + childVal + '"]').attr('selected', 'selected');

$('#' + parent).change( function() {
var parentValue = $('#' + parent).attr('value');
$('#' + child).html($("#" + parent + child + " .sub_" + parentValue).clone());
if (isSubselectOptional) $('#' + child).prepend("<option value='none'> -- Select -- </option>");
$('#' + child).trigger("change");
$('#' + child).focus();
});
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

isIE = document.all;             
isN6 = document.getElementById; 
isN4 = document.layers;         
myObj = "";


function CurrLeft() {
	if (isIE) {
		if(document.compatMode){
			return document.documentElement.scrollLeft;
		}else{
			return document.body.scrollLeft;
		}
	} else if (window.pageXOffset) {
		return window.pageXOffset;
	} else {
		return 0;
	}
}

function CurrTop() {
	if (isIE) {
		if(document.compatMode=="CSS1Compat"){
			return document.documentElement.scrollTop;
		}else{
			return document.body.scrollTop;
		}
	} else if (window.pageYOffset) {
		return window.pageYOffset;
	} else {
		return 0;
	}
}

var TimerOfScrollPage;
var currX;
var currY;
var unittime = 2;

function ScrollPage(toX, toY, breaking) {
	if (TimerOfScrollPage) clearTimeout(TimerOfScrollPage);
	if (!toX || toX < 0)	{toX = 0;}
	if (!toY || toY < 0)	{toY = 0;}
	if (!currX)	{currX = CurrLeft();}
	if (!currY)	{currY = CurrTop();}
	if (!breaking)	{breaking = 5;}
	currX += (toX - CurrLeft()) / breaking;
	if (currX < 0) {currX = 0;}
	currY += (toY - CurrTop()) / breaking;
	if (currY < 0) {currY = 0;}
	currX = Math.floor(currX);
	currY = Math.floor(currY);
	window.scrollTo(currX, currY);
	if (currX != toX || currY != toY) {
		TimerOfScrollPage = setTimeout("ScrollPage(" + toX + "," + toY + "," + breaking + ")", unittime);
	}
}



function PageTop() {
	ScrollPage(0, 0, 10);
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






