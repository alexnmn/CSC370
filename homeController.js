// function getTable() {
// 	var type = document.forms["form"]["t"].value;
//     var str = document.forms["form"]["q"].value;
// 	if (str == "") {
// 		return;
// 	}else { 
// 		if (window.XMLHttpRequest) {
// 			// code for IE7+, Firefox, Chrome, Opera, Safari
// 			xmlhttp = new XMLHttpRequest();
// 		} else {
// 			// code for IE6, IE5
// 			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
// 		}
// 		xmlhttp.onreadystatechange = function() {
// 			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
// 				console.log("freedom");
// 				document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
// 			}
// 		};
// 		var x = "generateTable.php?t=".concat(type.concat("&q=".concat(str)));
// 		xmlhttp.open("GET",x,true);
// 		xmlhttp.send();
// 	}
// }

function getTable() {
	var parameters = {
		t: document.forms["form"]["t"].value,
		q: document.forms["form"]["q"].value
	}
    alert('return sent');
    $.ajax({
        type: "POST",
        url: "generateTable.php",
        data: parameters,
        success: function(data){
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    });
}