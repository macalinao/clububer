var xmlhttp = findXMLHttp();

//Function to get best possible XMLHTTP
function findXMLHttp() {
  var xmlhttp;

  //Try internal HTTP
  if (window.XMLHttpRequest) {
  xmlhttp = new XMLHttpRequest();
  }

  //If not try ActiveX
  else{

  //List ActiveX Versions
  //Some can be deleted if we dont wish to support certain types
  //Most effective at top supported listed below
  var xmlhttpVersions = ["MSXML2.XMLHttp.6.0",
  "MSXML2.XMLHttp.5.0",
  "MSXML2.XMLHttp.4.0",
  "MSXML2.XMLHttp.3.0",  
  "MSXML2.XMLHttp",
  "Microsoft.XMLHttp"];


  //Try the differante versions
  for (var i = 0; i < xmlhttpVersions.length; i++) {
  if (!xmlhttp) {
  try{xmlhttp = new ActiveXObject(xmlhttpVersions[i]);} 
  catch (e) { xmlhttp = false;}
  }
  }

  //Start an instance for selected ActiveX
  //If not started as internal
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
  try { xmlhttp = new XMLHttpRequest();} 
  catch (e) { xmlhttp = false;}
  }
  
  //If ActiveX not even supported alert it.
  if (!xmlhttp) {
  alert('Please check that your browser supports XMLhttp');
  return false;
  }
  
  }
  return xmlhttp;
}


function Search() {
	var theQuery = document.getElementById('query').value;
	if(theQuery !== "") {
		document.getElementById('lajv').innerHTML = '<div style="height: 30px;"><em><IMG SRC="img/loading.gif">Searching ...</em></div>';
		var url = '/infusions/varcade/admin/search.php?q=' + theQuery;
		xmlhttp.open('GET', url, true);
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById('lajv').innerHTML = xmlhttp.responseText + ' ';
			} else {
				document.getElementById('lajv').innerHTML = '<div style="height: 30px;"><em><IMG SRC="/infusions/varcade/img/loading.gif">Searching ...</em></div>';
			}
		};
		xmlhttp.send(null);  
	}
}
