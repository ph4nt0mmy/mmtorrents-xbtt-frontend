var alertimg	= '<img src=\'style/base/images/status-alert.gif\'>';
var okimg		= '<img src=\'style/base/images/status-ok.gif\'>';
var loaderimg	= '<img src=\'style/base/images/loader.gif\'>';
//var globalstatus = false;

var showstatus = function(response)
{
	var respArr 		= response.split(',');
    var respType 		= respArr[0].toLowerCase();
    var respContainer  	= respArr[1];
    var respMsg  		= respArr[2];

    if (respType == 'success') {
	  window.document.getElementById(respContainer).innerHTML=okimg;
	  //globalstatus = true;
	  //return globalstatus;
	}
	else {
      window.document.getElementById(respContainer).innerHTML=alertimg+JS_ERROR+': '+respMsg;
      //globalstatus = false;
      //return globalstatus;
    }
}

function getstatus(container){
	var strDomain	= '';
	var ajax 		= new Ajax();
	switch(container)
		  {
		    case (container='status_username'):
			  var username = window.document.getElementById('username').value;
			  window.document.getElementById(container).innerHTML=loaderimg;
			  ajax.doGet('reg.ajax.php?action=validateUsername&username='+username,showstatus,'text');
			  break;
			case (container='status_email'):
			  var email = window.document.getElementById('email').value;
			  window.document.getElementById(container).innerHTML=loaderimg;
			  ajax.doGet('reg.ajax.php?action=validateEmail&email='+email,showstatus,'text');
			  break;
			case (container='status_password'):
			  var password = window.document.getElementById('upassword').value;
			  var username = window.document.getElementById('username').value;
			  if (password.length<6) {
				  window.document.getElementById(container).innerHTML=alertimg+JS_ERROR+': '+JS_REG_TOOSHORTPASSWD;
			  }
			  else if (password == username) {
				  window.document.getElementById(container).innerHTML=alertimg+JS_ERROR+': '+JS_REG_USERNAMEPASSWDMATCH;
			  }
			  else {
				  window.document.getElementById(container).innerHTML=okimg;
				  return true;
			  }
			  return false;
			  break;
			case (container='status_passwordagain'):
			  var password 		= window.document.getElementById('upassword').value;
			  var passwordagain = window.document.getElementById('upasswordagain').value;
			  if (password != passwordagain) {
				  window.document.getElementById(container).innerHTML=alertimg+JS_ERROR+': '+JS_REG_PASSWDNOTMATCH;
			  }
			  else if (passwordagain == '') {
				  window.document.getElementById(container).innerHTML=alertimg+JS_ERROR+': '+JS_REG_TOOSHORTPASSWD;
			  }
			  else {
				  window.document.getElementById(container).innerHTML=okimg;
				  return true;
			  }
			  return false;
			  break;
			case (container='status_rules'):
			  var rules = window.document.getElementById('rules').value;
			  if ( rules == 'readyes') {
				  window.document.getElementById(container).innerHTML=okimg;
				  return true;
			  }
			  else window.document.getElementById(container).innerHTML=alertimg;
			  return false;
			  break;
			case (container='status_bornyear'):
			  var cvalue = window.document.getElementById('bornyear').value;
			  if ( cvalue != 'choose') {
				  window.document.getElementById(container).innerHTML=okimg;
				  return true;
			  }
			  else window.document.getElementById(container).innerHTML=alertimg;
			  return false;
			  break;
			case (container='status_sex'):
			  var cvalue = window.document.getElementById('sex').value;
			  if ( cvalue != 'choose') {
				  window.document.getElementById(container).innerHTML=okimg;
				  return true;
			  }
			  else window.document.getElementById(container).innerHTML=alertimg;
			  return false;
			  break;
			case (container='status_lang'):
			  var cvalue = window.document.getElementById('lang').value;
			  if ( cvalue != 'choose') {
				  window.document.getElementById(container).innerHTML=okimg;
				  return true;
			  }
			  else window.document.getElementById(container).innerHTML=alertimg;
			  return false;
			  break;
			case (container='status_country'):
			  var cvalue = window.document.getElementById('country').value;
			  if ( cvalue != 'choose') {
				  window.document.getElementById(container).innerHTML=okimg;
				  return true;
			  }
			  else window.document.getElementById(container).innerHTML=alertimg;
			  return false;
			  break;
			case (container='status_upspeed'):
			  var cvalue = window.document.getElementById('upspeed').value;
			  if ( cvalue != 'choose') {
				  window.document.getElementById(container).innerHTML=okimg;
				  return true;
			  }
			  else window.document.getElementById(container).innerHTML=alertimg;
			  return false;
			  break;
			case (container='status_downspeed'):
			  var cvalue = window.document.getElementById('downspeed').value;
			  if ( cvalue != 'choose') {
				  window.document.getElementById(container).innerHTML=okimg;
				  return true;
			  }
			  else window.document.getElementById(container).innerHTML=alertimg;
			  return false;
			  break;
			case (container='status_isp'):
			  var cvalue = window.document.getElementById('isp').value;
			  if ( cvalue != 'choose') {
				  window.document.getElementById(container).innerHTML=okimg;
				  return true;
			  }
			  else window.document.getElementById(container).innerHTML=alertimg;
			  return false;
			  break;
			case (container='status_captcha_code'):
			  var captcha = window.document.getElementById('captcha_code').value;
			  window.document.getElementById(container).innerHTML=loaderimg;
			  ajax.doGet('reg.ajax.php?action=validateCaptcha&captcha='+captcha,showstatus,'text');
			  break;
		  }
	return true;
}

function getstatusloop()
{
	var status = true;
	var containers = new Array('username','email', 'password', 'passwordagain'); //, 'rules', 'bornyear', 'sex', 'lang', 'country', 'upspeed', 'downspeed', 'isp', 'captcha_code');
	for ( var i in containers ) {
		//alert('status_'+containers[i]);
		//if ( getstatus('status_'+containers[i]) == false ) status=false;
		if ( window.document.getElementById('status_'+containers[i]).innerHTML == '' || window.document.getElementById('status_'+containers[i]).innerHTML.indexOf(alertimg) == -1 ) status=false;
		//alert(getstatus('status_'+containers[i]));
		//alert('status_'+containers[i]+' :'+globalstatus);
	}
	//alert(status);
	//return status;
	return true;
}

var handlereg = function(response)
{
	var respArr 		= response.split(',');
    var respType 		= respArr[0].toLowerCase();
    var respContainer  	= respArr[1];
    var respMsg  		= respArr[2];
    //alert("type: " + respType + "; container:" + respContainer + "; msg:" + respMsg);
    if (respType == 'success') {
	  //window.document.getElementById(respContainer).innerHTML=okimg;
	  //window.document.getElementById('regprompt').innerHTML='';
	  //majd ki kell szedni
	  window.document.getElementById('regprompt').style.display="none";
      window.document.getElementById('submitReg').disabled = false;
	  //
	}
	else if (respType == 'allsuccess') {
		window.document.getElementById(respContainer).innerHTML=respMsg;
		window.document.getElementById('regprompt').style.display="none";
	}
	else {
      window.document.getElementById(respContainer).innerHTML=alertimg+JS_ERROR+': '+respMsg;
      window.document.getElementById('regprompt').style.display="block";
      window.document.getElementById('submitReg').disabled = false;
      //alert(response);
    }
	return false;
}

function postregister() {
	var strDomain	= '';
	var ajax 		= new Ajax();
	
	if ( getstatusloop() == true ) {
	//alert("oké");
	
	var username 		= window.document.getElementById('username').value;
	var email 			= window.document.getElementById('email').value;
	var password 		= window.document.getElementById('upassword').value;
	var passwordagain 	= window.document.getElementById('upasswordagain').value;
	var rules 			= window.document.getElementById('rules').value;
	var bornyear 		= window.document.getElementById('bornyear').value;
	var sex 			= window.document.getElementById('sex').value;
	var lang 			= window.document.getElementById('lang').value;
	var country 		= window.document.getElementById('country').value;
	var upspeed 		= window.document.getElementById('upspeed').value;
	var downspeed 		= window.document.getElementById('downspeed').value;
	var isp 			= window.document.getElementById('isp').value;
	var captcha_code 	= window.document.getElementById('captcha_code').value;
	
	var status_username 		= window.document.getElementById('status_username').innerHTML;
	var status_email 			= window.document.getElementById('status_email').innerHTML;
	var status_password 		= window.document.getElementById('status_password').innerHTML;
	var status_passwordagain 	= window.document.getElementById('status_passwordagain').innerHTML;
	var status_rules 			= window.document.getElementById('status_rules').innerHTML;
	var status_bornyear 		= window.document.getElementById('status_bornyear').innerHTML;
	var status_sex 				= window.document.getElementById('status_sex').innerHTML;
	var status_lang 			= window.document.getElementById('status_lang').innerHTML;
	var status_country 			= window.document.getElementById('status_country').innerHTML;
	var status_upspeed 			= window.document.getElementById('status_upspeed').innerHTML;
	var status_downspeed 		= window.document.getElementById('status_downspeed').innerHTML;
	var status_isp 				= window.document.getElementById('status_isp').innerHTML;
	var status_captcha_code 	= window.document.getElementById('status_captcha_code').innerHTML;
	
	window.document.getElementById('regprompt').innerHTML=loaderimg+' Feldolgozás, kérlek várj...';
	window.document.getElementById('regprompt').style.display="block";
	window.document.getElementById('submitReg').disabled = true;

	var strtopost = 'reg.ajax.php?action=register&username=' + username + '&email=' + email + '&password=' + password  + '&passwordagain=' + passwordagain + '&rules=' + rules + '&bornyear=' + bornyear + '&sex=' + sex + '&lang=' + lang + '&country=' + country + '&upspeed=' + upspeed + '&downspeed=' + downspeed + '&isp=' + isp + '&captcha_code=' + captcha_code + '&status_username=' + status_username + '&status_email=' + status_email + '&status_password=' + status_password  + '&status_passwordagain=' + status_passwordagain + '&status_rules=' + status_rules + '&status_bornyear=' + status_bornyear + '&status_sex=' + status_sex + '&status_lang=' + status_lang + '&status_country=' + status_country + '&status_upspeed=' + status_upspeed + '&status_downspeed=' + status_downspeed + '&status_isp=' + status_isp + '&status_captcha_code=' + status_captcha_code + '';
	//alert(strtopost);
	ajax.doGet(strtopost, handlereg,'text');
	}
	else alert("JS_REG_MISSING_OR_BAD_DATA");
	
	return false;
}