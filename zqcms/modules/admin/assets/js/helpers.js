
/**
	String filter
*/
function filter(type, str) {

	var regexes = {
		//  Strip spaces
		spaces: /\s+/,
		
		//  Strip non A-Z, 0-9 and dash
		slug: /[^0-9a-z\-]/i,
		
		//  Same, but underscores
		twitter: /[^0-9a-z\_]/i
	};
	
	str = str.toLowerCase().replace(spaces, '');
	
	if(regexes[type]) {
		return str.replace(regexes[type], '');
	}

	return str;
}

function selectall(name) {
  if ($("#check_box").attr("checked")) {
    $("input[name='"+name+"']").each(function() {
        $(this).attr("checked",true);
      
    });
  } else {
    $("input[name='"+name+"']").each(function() {
        $(this).removeAttr("checked");
    });
  }
}

function confirmurl(url,message)
{
    if(confirm(message)) redirect(url);
}
function redirect(url) {
    if(url.indexOf('://') == -1 && url.substr(0, 1) != '/' && url.substr(0, 1) != '?') url = $('base').attr('href')+url;
    location.href = url;
}

var replaceText = function(t, obj) {
 var textarea = document.getElementById(obj);
 var rangeData = getCursorPosition(textarea);
 if (rangeData == null) {
  return;
 }
 var i = rangeData.start;
 var all = textarea.value;
 var temp1 = all.substring(0, i);
 var temp2 = all.substring(i);
 var temp3 = t + temp2.substring(rangeData.text.length);
 textarea.value = temp1 + temp3;
}
var getCursorPosition = function(textarea) {
 var rangeData = {
  text : "",
  start : 0,
  end : 0
 };
 textarea.focus();
 if (textarea.setSelectionRange) { // W3C
  rangeData.start = textarea.selectionStart;
  rangeData.end = textarea.selectionEnd;
  rangeData.text = (rangeData.start != rangeData.end) ? textarea.value.substring(rangeData.start, rangeData.end) : "";
 } else if (document.selection) { // IE
  var i, oS = document.selection.createRange(),
  oR = document.body.createTextRange();
  oR.moveToElementText(textarea);
  rangeData.text = oS.text;
  rangeData.bookmark = oS.getBookmark();
  for (i = 0; oR.compareEndPoints('StartToStart', oS) < 0
    && oS.moveStart("character", -1) !== 0; i++) {
   if (textarea.value.charAt(i) == '\n') {
    i++;
   }
  }
  rangeData.start = i;
  rangeData.end = rangeData.text.length + rangeData.start;
 }
 if (rangeData.text == ""
   || (rangeData.text.length + 2) == textarea.value.length) {
  return null;
 } else {
  return rangeData;
 }
}

$(document).ready(function(){
    $("[data-target]").each(function(el){
      var that = this;
      $(that).click(function(){
        var obj = $(that).attr("data-target"),
        t = $(that).text();
        replaceText(t, obj);
      });
    });
});