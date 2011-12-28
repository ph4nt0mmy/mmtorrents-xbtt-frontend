<?php
header("Content-Type: text/html; charset=UTF-8");
require_once('../inc/config.inc.php');
require_once('../classes/class.mysql.php');
require_once('../classes/class.main.php');

$db = new DB($config['database'], $config['server'], $config['user'], $config['pass']);
$db->query("SET NAMES utf8");
$sep=',';

if ( isset($_GET['lang']) && $_GET['lang']!='' && checkLang($_GET['lang']) ) $site_lang = $_GET['lang'];
     else $site_lang = 'hu';
require_once('../lang/'.$site_lang.'.lang.php');

function validateUsername($echoreturn = true) {
	
	GLOBAL $_GET;
	GLOBAL $db;
	GLOBAL $sep;
	
	$username 	= $_GET['username'];
	$sql 		= 'SELECT uid FROM users WHERE username=\''. $username. '\'';
	$res 		= $db->query($sql);
	if ( strlen($username)<5 )
	   {
		 if ( $echoreturn == true ) print 'error'.$sep.'status_username'.$sep.'Túl rövid név! Min. 5 karakter legyen!';
		 return false;
	   }
	elseif ( strlen($username)>10 )
	 	   {
			 if ( $echoreturn == true ) print 'error'.$sep.'status_username'.$sep.'Túl hosszú név! Max. 10 karakter legyen!';
			 return false;
		   }
	elseif ( $db->numRows() > 0 )
		   {
			 if ( $echoreturn == true ) print 'error'.$sep.'status_username'.$sep.'Már van ilyen júzer!';
			 return false;
		   }
	elseif ( $echoreturn == true ) print 'success'.$sep.'status_username'.$sep.'Minden fasza.';
	return true;
}

function validateEmail() {
	
	GLOBAL $_GET;
	GLOBAL $db;
	GLOBAL $sep;
	
	$email = trim($_GET['email']);
	$sql = 'SELECT uid FROM users WHERE email=\''. $email. '\'';
	$res = $db->query($sql);
	if ( $db->numRows() > 0 )
	   {
		 print 'error'.$sep.'status_email'.$sep.'Már van ilyen email!';
		 return false;
	   }
	elseif ( !validEmail($_GET['email']) ) 
		   {
			 print 'error'.$sep.'status_email'.$sep.'Hibás formátum!';
			 return false;
		   }
	else print 'success'.$sep.'status_email'.$sep.'Minden fasza.';
	return true;
}

function validateCaptcha() {
	
	GLOBAL $_GET;
	GLOBAL $db;
	GLOBAL $sep;
	
	$captcha = trim($_GET['captcha']);
	require_once('../classes/secimage/securimage.php');
	$img = new Securimage();
	$valid = $img->check($captcha);
	if($valid != true) {
		print 'error'.$sep.'status_captcha_code'.$sep.'Rossz kód!';
		return false;
	}
	else print 'success'.$sep.'status_captcha_code'.$sep.'Minden fasza.';
	return true;
}
/*
function validatePassword() {
	//ellenőrizni a jelszó hosszát és hogy egyezik -e a két bevitt jelszó
}

function validateBornyear() {
	//ellenőrizni
}

function validateSex() {
	//ellenőrizni
}

function validateLang() {
	//getLang() ?
}

function validateCountry() {
	//ellenőrizni
}

function validateSpeed() {
	//ellenőrizni: downspeed, upspeed
}

function validateIsp() {
	//ellenőrizni
}
*/
$action=trim($_GET['action']);
switch($action):
	case 'validateUsername':
		validateUsername();
	break;
	case 'validateEmail':
		validateEmail();
	break;
	case 'validateCaptcha':
		validateCaptcha();
	break;
	case 'register':
	if ( !isset($_GET["username"]) || !isset($_GET["email"]) || !isset($_GET["password"]) || !isset($_GET["passwordagain"]) || !isset($_GET["bornyear"]) || !isset($_GET["sex"]) || !isset($_GET["lang"]) || !isset($_GET["country"]) || !isset($_GET["upspeed"]) || !isset($_GET["downspeed"]) || !isset($_GET["isp"]) || !isset($_GET["captcha_code"]) || $_GET["username"] == "" || $_GET["email"] == "" || $_GET["password"] == "" || $_GET["passwordagain"] == "" || $_GET["bornyear"] == "" || $_GET["sex"] == "" || $_GET["lang"] == "" || $_GET["country"] == "" || $_GET["upspeed"] == "" || $_GET["downspeed"] == "" || $_GET["isp"] == "" || $_GET["captcha_code"] == "" ) {
		print 'error'.$sep.'regprompt'.$sep.MISSING_DATA.$sep;
		break;
	}
	
	/* NE HASZNÁLD EZEKET, MERT VAN VISSZATÉRÉSI ÉRTÉKÜK A JS FELÉ! 
	validateUsername();
	validateEmail();
	validateCaptcha();
	*/
	
	$username 	= mysql_real_escape_string($_GET["username"]);
	$email 		= mysql_real_escape_string($_GET["email"]);
	$bornyear 	= mysql_real_escape_string($_GET["bornyear"]);
	$sex 		= mysql_real_escape_string($_GET["sex"]);
	$lang 		= mysql_real_escape_string($_GET["lang"]);
	$country 	= mysql_real_escape_string($_GET["country"]);
	$upspeed 	= mysql_real_escape_string($_GET["upspeed"]);
	$downspeed 	= mysql_real_escape_string($_GET["downspeed"]);
	$isp 		= mysql_real_escape_string($_GET["isp"]);
	$rules 		= mysql_real_escape_string($_GET["rules"]);
	//$response = $username. ' '.$email. ' '.$password. ' '.$passwordagain;
	
	$status['username'] = mysql_real_escape_string($_GET["status_username"]);
	$status['email'] = mysql_real_escape_string($_GET["status_email"]);
	$status['password'] = mysql_real_escape_string($_GET["status_password"]);
	$status['passwordagain'] = mysql_real_escape_string($_GET["status_passwordagain"]);
	$status['bornyear'] = mysql_real_escape_string($_GET["status_bornyear"]);
	$status['sex'] = mysql_real_escape_string($_GET["status_sex"]);
	$status['lang'] = mysql_real_escape_string($_GET["status_lang"]);
	$status['country'] = mysql_real_escape_string($_GET["status_country"]);
	$status['upspeed'] = mysql_real_escape_string($_GET["status_upspeed"]);
	$status['downspeed'] = mysql_real_escape_string($_GET["status_downspeed"]);
	$status['isp'] = mysql_real_escape_string($_GET["status_isp"]);
	$status['rules'] = mysql_real_escape_string($_GET["status_rules"]);	
	
	/*foreach ($status as $i => $value) {
		if ( strpos($value, 'alert') > 0 ) print 'error'.$sep.'regprompt'.$sep.$value.$sep;
		//$hogyishivjak .= $value;
	}*/
	//print 'error'.$sep.'regprompt'.$sep.$hogyishivjak.$sep;
	//if ( strpos($status_bornyear, 'alert') > 0 ) print 'error'.$sep.'regprompt'.$sep.'öö'.$sep;
	//print 'error'.$sep.'regprompt'.$sep.strpos($status_bornyear, 'alert').$sep;
	//return false;
	
	//TODO: 
	// 1) csekkolni a bevitt adatokat
	
	$random = genrandom();
	$sql = "SELECT uid FROM users WHERE random = '". $random ."' LIMIT 1";
	$res = $db->query($sql);
	if ( $db->numRows() > 0 )
	   {
		 $randomized = false;
		 while ( !$randomized )
				{
				  $random = genrandom();
				  $sql = "SELECT uid FROM users WHERE random = '". $random ."' LIMIT 1";
				  $res = $db->query($sql);	
				  if ( $db->numRows() == 0 ) $randomized = true;
				}
	   }
	
	$msg  = REG_MAIL1. " ". $username. "\n\n";
	$msg .= REG_MAIL2. " ". $config['baseurl'] ."?mpage=reg&act=confirm&random=". $random. "&email=". $email. "\n\n";
	$msg .= REG_MAIL3. "\n\n";
	$msg .= REG_MAIL4. "\n\n";
	$msg .= REG_MAIL5. " ". $config['baseurl'];
	
	$password 		= md5($siteblowfish. mysql_real_escape_string($_GET["password"]). $random);
	$passwordagain 	= md5($siteblowfish. mysql_real_escape_string($_GET["passwordagain"]). $random);
	$joinipa = ""; //TODO: lekérdezni
	
	$sql = "INSERT INTO users (username, password, email, language, country, random, joined, joinipa, downspeed, upspeed, isp, sex, bornyear, torrent_pass, pid) VALUES ('". $username. "', '". $password. "', '". $email. "', '". $lang. "', '". $country. "', '". $random. "', NOW(),'". $joinipa. "', '". $downspeed. "', '". $upspeed. "', '". $isp. "', '". $sex. "', '". $bornyear. "', '". $random. "', '". $random. "')";
	$db->execute($sql);
	
	UTF8_mail($config['sitename'].  "<". $config['noreplymail']. ">", $username. " <". $email .">", $username. ": ". REG_CONFIRM_SUBJECT, $msg, "", "");
	print 'allsuccess'.$sep.'regme'.$sep.'A megerősítő e-mailt elküldtük a(z) '. $email. ' címedre.';
	//else print 'success'.$sep.'regprompt'.$sep.$response;
	
	//print 'error'.$sep.'regprompt'.$sep.'öö'.$sep.
	break;
	default:
		print 'error';
endswitch;

$db->close();
?>