<?php
header("Content-Type: text/html; charset=UTF-8");
require_once('../inc/config.inc.php');
require_once('../classes/class.mysql.php');
require_once('../classes/class.main.php');

$db = new DB($config['database'], $config['server'], $config['user'], $config['pass']);
$sep=',';

if ( isset($_GET['lang']) && $_GET['lang']!='' ) $site_lang = $_GET['lang'];
     else $site_lang = 'hu';
require_once('../lang/'.$site_lang.'.lang.php');

$action=trim($_GET['action']);
switch($action):
	case 'validateUsername':
		$username 	= $_GET['username'];
		$sql 		= 'SELECT uid FROM users WHERE username=\''. $username. '\'';
		$res 		= $db->query($sql);
		if ( strlen($username)<5 )
		   {
			 print 'error'.$sep.'status_username'.$sep.'Túl rövid név! Min. 5 karakter legyen!';
	 	   }
	 	elseif ( strlen($username)>10 )
	 	   {
			 print 'error'.$sep.'status_username'.$sep.'Túl hosszú név! Max. 10 karakter legyen!';
		   }
		elseif ( $db->numRows() > 0 )
		   {
			 print 'error'.$sep.'status_username'.$sep.'Már van ilyen júzer!';
		   }
		else print 'success'.$sep.'status_username'.$sep.'Minden fasza.';
	break;
	case 'validateEmail':
		$email = trim($_GET['email']);
		$sql = 'SELECT uid FROM users WHERE email=\''. $email. '\'';
		$res = $db->query($sql);
		if ( $db->numRows() > 0 )
		   {
			 print 'error'.$sep.'status_email'.$sep.'Már van ilyen email!';
		   }
		elseif ( !validEmail($_GET['email']) ) 
		   {
			 print 'error'.$sep.'status_email'.$sep.'Hibás formátum!';
		   }
		else print 'success'.$sep.'status_email'.$sep.'Minden fasza.';
	break;
	case 'validateCaptcha':
		$captcha = trim($_GET['captcha']);
		require_once('../classes/secimage/securimage.php');
		$img = new Securimage();
		$valid = $img->check($captcha);
		if($valid != true) {
			print 'error'.$sep.'status_captcha_code'.$sep.'Rossz kód!';
		}
		else print 'success'.$sep.'status_captcha_code'.$sep.'Minden fasza.';
	break;
	default:
		print 'error';
endswitch;

$db->close();
?>