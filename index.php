<?php
require_once('inc/config.inc.php');
require_once('classes/class.mysql.php');
require_once('classes/class.main.php');
$time_start = get_microtime();
session_start();

$CURUSER = '';

require_once('classes/btemplate.class.php');
$tpl = new bTemplate();

$db = new DB($config['database'], $config['server'], $config['user'], $config['pass']);
$db->query("SET NAMES utf8");

$site_lang = getLang();
if (!checkLang($site_lang)) $site_lang = 'hu';
setLang( !checkLang($site_lang) ? 'hu' : $site_lang );



$style_path = getStyle();


// ******************* HEADER **************** //
$tpl->set('style_path', $style_path);
$tpl->set('lang', $site_lang);
$tpl->set('page_title', $site_name. getWord((!getLoginStatus($_COOKIE["mmuid"], $_COOKIE["mmpass"]) && ( $_GET["mpage"] == "" )) ? "LOGIN" : $_GET["mpage"] ) ); //modul nevét hozzáfûzni!
//tpl->set('page_title', $site_name. getWord($_GET["mpage"]));
if ( $style_path != $CURUSER['style'] ) setStyle($CURUSER['style']);
else setStyle($style_path);
echo $tpl->fetch($style_path. 'html/header.tpl');
// ******************* HEADER END **************** //


if (( !isset($_COOKIE["mmuid"]) || !isset($_COOKIE["mmpass"]) ) ||  ( getLoginStatus($_COOKIE["mmuid"], $_COOKIE["mmpass"]) == false )) 
   {
    require_once('pages/login.php');
    if ( isset($_GET["mpage"]) && ( $_GET["mpage"]=="reg" || $_GET["mpage"]=="lostpwd" ) )
		require_once('pages/'. $_GET["mpage"]. '.php');
	elseif ( isset($_POST["mpage"]) && $_POST["mpage"]=="reg" )
	 	require_once('pages/'. $_POST["mpage"]. '.php');
    else require_once('pages/loginblock.php');
   }
elseif (( isset($_COOKIE["mmuid"]) && isset($_COOKIE["mmpass"]) ) && ( getLoginStatus($_COOKIE["mmuid"], $_COOKIE["mmpass"]) == true ))
   {
    require_once('pages/mnu.php'); //if logged_in==true  
	require_once('pages/usrmnu.php'); //if logged_in==true
	//print_r($_COOKIE);
	if ( isset($_GET["mpage"]) && checkMpage($_GET["mpage"]) ) 
		require_once('pages/'. $_GET["mpage"]. '.php');
	elseif ( isset($_POST["mpage"]) && checkMpage($_POST["mpage"]) ) 
		require_once('pages/'. $_POST["mpage"]. '.php');
	elseif ( isset($_GET["logout"]) ) 
	        {
		     logout();
			}
	else require_once('pages/news.php');
   }

printFooter();
?>
