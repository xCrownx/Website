// JavaScript Document

function srvtime(){
	var date = new Date()
	var hour = date.getHours()
	var minute = date.getMinutes() 
	
	if (hour<10) hour="0"+hour;
	if (minute<10) minute="0"+minute; 
	
	$('#srvtime').html(hour + ":" + minute); 
}

var display = window.setInterval("srvtime()", 1000);