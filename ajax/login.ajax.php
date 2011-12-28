<?php
header("Content-Type: text/html; charset=UTF-8");
require_once('../inc/config.inc.php');
require_once('../classes/class.mysql.php');

$db = new DB($config['database'], $config['server'], $config['user'], $config['pass']);

if ( isset($_GET['lang']) && $_GET['lang']!='' ) $site_lang = $_GET['lang'];
     else $site_lang = 'hu'; //db -bõl (vagy $_COOKIE['lang']) kell majd kiolvasni a júzer beállítását... ha nincs bejelentkezve, akkor HU!
require_once('../lang/'.$site_lang.'.lang.php'); //db -ben languages tábla létrehozása és ott csekkolni, van -e adott lang!

$action=trim($_GET['action']);
switch($action):
	case 'login':
		$sub = trim($_POST['sub']);
		$loginname = trim($_POST['loginname']);
		$loginpass = trim($_POST['password']);
		$sql = "SELECT random FROM users WHERE username='". $loginname. "' LIMIT 1";
		$res = $db->query($sql);
		$row = $db->fetch_array($res);
		$loginpass = md5($siteblowfish. $loginpass. $row["random"]);
		$sql = 'SELECT uid, username, disabled, id_level FROM users WHERE username=\''. $loginname. '\' AND password=\''. $loginpass. '\' AND disabled=\'no\'';
		$res = $db->query($sql); 
		$sep=',';
		//sleep(1); # simulating
		$msg='';
		$row = $db->fetch_array($res);
		if ( $db->numRows() == 1 && $row['id_level']>0){
		   # REGISTER SESSION HERE
		   require_once('../classes/class.main.php');
		   $mmuid = $row["uid"];
		   //cookie --> JS -ben van megadva!
		   print 'success,./,successlogin,'. $mmuid. ','. $loginpass. ','. $site_lang;
		}
		elseif ( $row['id_level']==0 ) {
		   $msg=EMAIL_NOTCONFIRMED;
		   print 'error'.$sep.$msg;
		}
		else{
		   $msg=PASS_ERROR;
		   print 'error'.$sep.$msg;
		}
//		print 'success,index.php';
	break;
	default:
		print 'error';
endswitch;

$db->close();
?>
