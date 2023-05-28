// JavaScript Document

function ServerstatusRequest(strURL)
{
	var xmlHttp;
	if(window.XMLHttpRequest)
	{ // For Mozilla, Safari, ...
		var xmlHttp = new XMLHttpRequest();
	}
	else if(window.ActiveXObject)
	{ // For Internet Explorer
		var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlHttp.open('GET', strURL, true);
	xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlHttp.onreadystatechange = function()
	{
		if (xmlHttp.readyState == 4){
			getserverstatus(xmlHttp.responseText);
		}
	}
	xmlHttp.send(strURL);
}
function getserverstatus(str)
{
	if(str.charAt(0) == 1) {
		$('#srvworld').html('<span id="online">Online</span>');
	} else {
		$('#srvworld').html('<span id="offline">Offline</span>');
	}
}

ServerstatusRequest('./inc/srvstate.php');