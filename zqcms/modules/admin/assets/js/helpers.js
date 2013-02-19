
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