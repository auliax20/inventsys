// JavaScript Document
window.onload = initPage;
function createRequest() {
	try {
		request = new XMLHttpRequest();
	}catch (tryMS) {
		try {
			request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (otherMS) {
			try {
				request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
				request = null;
			}
		}
	}
	return request;
}
function initPage(){
	document.getElementById("tags").onblur = checkStok;
}
function checkStok() {
	request = createRequest();
	if(request==null){
		alert("Unable to create request");
	}else{
		var theName = document.getElementById("tags").value;
    	var kobr = escape(theName);
    	var url= "handler.php?mod=stok&filter=" + kobr;
    	request.onreadystatechange = showCheckStokStatus;
    	request.open("GET", url, true);
    	request.send(null);
	}
}
function showCheckStokStatus() {
  if (request.readyState == 4) {
    if (request.status == 200) {
		document.getElementById("stokawal").value = request.responseText;
    }else{
		alert("Can't Create Request = "+request.status);
	}
  }
}