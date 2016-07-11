function getTable(type,str) {
	if (str == "") {
		return;
	}else { 
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				console.log("freedom");
				document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
			}
		};
		var x = "generateTable.php?t=".concat(type.concat("&q=".concat(str)));
		xmlhttp.open("GET",x,true);
		xmlhttp.send();
	}
}