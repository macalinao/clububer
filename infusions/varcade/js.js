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
		var url = '/infusions/varcade/search.php?q=' + theQuery;
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

function sndReq(vote,id_num,ip_num) {
	
	var element = document.getElementById('unit_long'+id_num);
	//new Effect.Fade(element);
    element.innerHTML = '<div style="height: 30px;"><em><IMG SRC="/infusions/varcade/img/loading.gif">Loading ...</em></div>';
	
    xmlhttp.open('get', '/infusions/varcade/rpc.php?j='+vote+'&q='+id_num+'&t='+ip_num);
    xmlhttp.onreadystatechange = handleResponse;
    xmlhttp.send(null);
	
}

function handleResponse() {
    if(xmlhttp.readyState == 4){
		if (xmlhttp.status == 200){
       	
        var response = xmlhttp.responseText;
        var update = new Array();

        if(response.indexOf('|') != -1) {
            update = response.split('|');
            changeText(update[0], update[1]);
        }
		}
    }
}

function changeText( div2show, text ) {
    // Detect Browser
    var IE = (document.all) ? 1 : 0;
    var DOM = 0; 
    if (parseInt(navigator.appVersion) >=5) {DOM=1};

    // Grab the content from the requested "div" and show it in the "container"

    if (DOM) {
        var viewer = document.getElementById(div2show)
        viewer.innerHTML=text
    }
    else if(IE) {
        document.all[div2show].innerHTML=text
    }
}