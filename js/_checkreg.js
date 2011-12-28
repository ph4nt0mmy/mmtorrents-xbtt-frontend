function emailCheck (emailStr) {
var emailPat=/^(.+)@(.+)$/
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
var validChars="\[^\\s" + specialChars + "\]"
var quotedUser="(\"[^\"]*\")"
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
var atom=validChars + '+'
var word="(" + atom + "|" + quotedUser + ")"
var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")

var matchArray=emailStr.match(emailPat)
if (matchArray==null) {
	alert(JS_WRONG_EMAIL1)
	return false
}
var user=matchArray[1]
var domain=matchArray[2]

if (user.match(userPat)==null) {
    alert(JS_WRONG_EMAIL2)
    return false
}

var IPArray=domain.match(ipDomainPat)
if (IPArray!=null) {
    // this is an IP address
	  for (var i=1;i<=4;i++) {
	    if (IPArray[i]>255) {
	        alert(JS_WRONG_EMAIL3)
		return false
	    }
    }
    return true
}

var domainArray=domain.match(domainPat)
if (domainArray==null) {
	alert(JS_WRONG_EMAIL4)
    return false
}

var atomPat=new RegExp(atom,"g")
var domArr=domain.match(atomPat)
var len=domArr.length
if (domArr[domArr.length-1].length<2 || 
    domArr[domArr.length-1].length>3) {
   alert(JS_WRONG_EMAIL5)
   return false
}

if (len<2) {
   var errStr=JS_WRONG_EMAIL6
   alert(errStr)
   return false
}

return true;
}

function _checkreg ( form )
{
  if (form.username.value == "") {
    alert(JS_REG_GIVEYOURNAME);
    form.username.focus();
    return false ;
  }
  else {
    var numaric = form.username.value;
	for(var j=0; j<numaric.length; j++)
		{
		  var alphaa = numaric.charAt(j);
		  var hh = alphaa.charCodeAt(0);
		  if((hh > 44 && hh<59) || (hh > 64 && hh<91) || (hh > 96 && hh<123))
		  {
		  }
		  else	{
			 alert(JS_REG_SPECCHARS);
			 return false;
		  }
		}
  }
  var username=form.username.value;
  if (username.length<5) {
	alert(JS_REG_TOOSHORTNAME);
    form.username.focus();
    return false ;
  }
  if (username.length>10) {
	alert(JS_REG_TOOLONGNAME);
    form.username.focus();
    return false ;
  }
  if (form.email.value == "") {
    alert(JS_REG_GIVEYOUREMAIL);
    form.email.focus();
    return false ;
  }
  else
	{
	 if ( !emailCheck (form.email.value) )
	     return false ;
	}
  if (form.password.value == "") {
    alert(JS_REG_GIVEYOURPASSWD);
    form.password.focus();
    return false ;
  }
  if (form.password.value == form.username.value) {
    alert(JS_REG_USERNAMEPASSWDMATCH);
    form.password.focus();
    return false ;
  }
  var password=form.password.value;
  if (password.length<6) {
	alert(JS_REG_TOOSHORTPASSWD);
    form.password.focus();
    return false ;
  }
  if (form.passwordagain.value == "") {
    alert(JS_REG_REPEATPASSWD);
    form.passwordagain.focus();
    return false ;
  }
  if (form.password.value!=form.passwordagain.value) {
    alert(JS_REG_PASSWDNOTMATCH);
    form.passwordagain.focus();
    return false ;
  }
  var bornyear=form.bornyear.value;
  if (bornyear == "" || bornyear == "Válassz!" || bornyear == "Choose" || (bornyear > 1995 || bornyear < 1930)) {
	alert(JS_REG_CHOOSEBORNYEAR);
    form.bornyear.focus();
    return false ;
  }
  var sex=form.sex.value;
  if (sex == "" || sex == "Válassz!" || sex == "Choose") {
	alert(JS_REG_CHOOSESEX);
    form.sex.focus();
    return false ;
  }
  var lang=form.lang.value;
  if (lang == "" || lang == "Válassz!" || lang == "Choose") {
	alert(JS_REG_CHOOSELANG);
    form.lang.focus();
    return false ;
  }
  var country=form.country.value;
  if (country == "" || country == "Válassz!" || country == "Choose") {
	alert(JS_REG_CHOOSECOUNTRY);
    form.country.focus();
    return false ;
  }
  var upspeed=form.upspeed.value;
  if (upspeed == "" || upspeed == "Válassz!" || upspeed == "Choose") {
	alert(JS_REG_CHOOSEUPSPEED);
    form.upspeed.focus();
    return false ;
  }
  var downspeed=form.downspeed.value;
  if (downspeed == "" || downspeed == "Válassz!" || downspeed == "Choose") {
	alert(JS_REG_CHOOSEDOWNSPEED);
    form.downspeed.focus();
    return false ;
  }
  var isp=form.isp.value;
  if (isp == "" || isp == "Válassz!" || isp == "Choose") {
	alert(JS_REG_CHOOSEIPS);
    form.isp.focus();
    return false ;
  }
  if (form.captcha_code.value == "") {
    alert(JS_REG_GIVECAPTCHA);
    form.captcha_code.focus();
    return false ;
  }
  var captcha_code=form.captcha_code.value;
  if (captcha_code.length<6) {
	alert(JS_REG_TOOSHORTCAPTCHA);
    form.captcha_code.focus();
    return false ;
  }
  if (captcha_code.length>6) {
	alert(JS_REG_TOOLONGCAPTCHA);
    form.captcha_code.focus();
    return false ;
  }
  var rules=form.rules.value;
  if (rules == "" || rules == "Válassz!" || rules == "Choose" || rules == "readno") {
	alert(JS_REG_MUSTREADRULES);
    form.rules.focus();
    return false ;
  }
  
  // ** END **
  return true ;
}
