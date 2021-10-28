

function clickme() {
    alert("You have clicked on me");
}
function navMan(URL) {
    window.location = URL;
}

function do_login() {
  document.getElementById("frmLogin").submit();
}


function addToCart(ID) {
	
    var qty = document.getElementById("fldQTY-"+ID).value;
	document.cookie = "qty="+qty;
    alert(qty + "x Item: " + ID + " has been added to your cart");
    var theCookies = document.cookie.split('');
    var n = theCookies.length -36;
   if(getCookie("cartItem" + n)){
        setCookie("cartItem"+ n, ID,  1); 
   }else { 
        setCookie("cartItem"+ n, ID,  1); }
  }

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires; + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function getCookie2(name){
var re = new RegExp(name + "=([^;]+)");
    var value = re.exec(document.cookie);
    return (value != null) ? unescape(value[1]) : null;
}

function getCookieValue (name){
document.write(getCookie2(name));
}


function deleteCookie (name) {
  document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
} 
 

function listCookies() {
  var theCookies = document.cookie.split(';');
  var aString = '';
  for (var i = 1 ; i <= theCookies.length; i++) {
      aString += i + ' ' + theCookies[i-1] + "\n";
  }
  return aString;
}


jQuery.fn.center = function (container) {
  this.css("position","absolute");
  if(container) {
    this.css("top", Math.max(0, (($(container).height() - $(this).outerHeight()) / 2) +
    $(container).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(container).width() - $(this).outerWidth()) / 2) +
    $(container).scrollLeft()) + "px");
  } else {
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
    $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
    $(window).scrollLeft()) + "px");
  }
  return this;
};
jQuery.fn.cs_draggable = function(Prams) {
  var handleVal=true;
  var handle=false;
  var container = "window";
  var jObj = JSON.stringify(Prams);
  if(jObj) {
    JSON.parse(jObj, function (k, v) {
      if (k == "handle") { handleVal = v; }
      if (k == "container") { container = v; }
    });
  }
  if(handleVal == true) { handle = ".cs-gen-dialog-header"; }
  else if(handle == false) {
    if(handleVal) {
      handle = handleVal;
    } else {
      handle = false;
    }
  }
  this.draggable({
    handle      : handle,
    containment : container,
    opacity     : 0.50,
    scroll      : false
  }).css({});
  $(handle).css({
    cursor : "move"
  });
};