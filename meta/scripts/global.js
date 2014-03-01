function addLoadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload != 'function') {
        window.onload = func;
    } else {
        window.onload = function() {
            if (oldonload) {
                oldonload();
            }
            func();
        };
    }
}

/*
function getHTTPObject() {
  var xhr = false;
  if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    try {
      xhr = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
      try {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
      } catch(e) {
        xhr = false;
      }
    }
  }
  return xhr;
}
*/

function displayLoading(element) {
  while (element.hasChildNodes()) {
    element.removeChild(element.lastChild);
  }
  var image = document.createElement("img");
  image.setAttribute("src","./meta/img/loading.gif");
  image.setAttribute("alt","Loading...");
  element.appendChild(image);
}

/*
function fadeUp(element,red,green,blue) {
  if (element.fade) {
    clearTimeout(element.fade);
  }
  element.style.backgroundColor = "rgb("+red+","+green+","+blue+")";
  if (red == 255 && green == 255 && blue == 255) {
    return;
  }
  var newred = red + Math.ceil((255 - red)/10);
  var newgreen = green + Math.ceil((255 - green)/10);
  var newblue = blue + Math.ceil((255 - blue)/10);
  var repeat = function() {
    fadeUp(element,newred,newgreen,newblue);
  };
  element.fade = setTimeout(repeat,100);
}

function parseResponse(request) {
  if (request.readyState == 4) {
    if (request.status == 200 || request.status == 304) {
      var details = document.getElementById("main");
      details.innerHTML = request.responseText;
	  eval(document.getElementById("main").innerHTML);
      fadeUp(details,255,255,153);
    }
  }
}

function grabFile(file) {
  var request = getHTTPObject();
  if (request) {
    displayLoading(document.getElementById("main"));
    request.onreadystatechange = function() {
      parseResponse(request);
    };
    request.open("GET", file, true);
    request.send(null);
    return true;
  } else {
    return false;
  }
}

function preparePage() {
  if (!document.getElementById || !document.getElementsByTagName) {
    return;
  }
  if (!document.getElementById("nav")) {
    return;
  }
  var list = document.getElementById("nav");
  var links = list.getElementsByTagName("a");
  for (var i=0; i<links.length; i++) {
    links[i].onclick = function() {
		//set body class for active tab
		var cls = this.getAttribute("href").split("=")[1];
		document.body.setAttribute("class",cls);
		//grab link values to pass page content
		var query = this.getAttribute("href").split("?")[1];
		var url = "switch.php?"+query;
		return !grabFile(url);
    };
  }
}
*/

function hideChrome() {
//generic function to hide url address bar
//window.addEventListener("load",function() {
  //set a timeout...
  setTimeout(function(){
    //hide the address bar
    window.scrollTo(0, 1);
  }, 0);
//});
}

//addLoadEvent(preparePage);
addLoadEvent(hideChrome);
addLoadEvent(displayLoading);

var submit = document.getElementById('btn');
submit.onclick = function() {
    displayLoading(document.getElementById("main"));
}
