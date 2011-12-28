<?php
header("Content-Type: text/html; charset=UTF-8");
require_once('../inc/config.inc.php');
require_once('../classes/class.mysql.php');
require_once('../classes/class.main.php');

$db = new DB($config['database'], $config['server'], $config['user'], $config['pass']);
$sep='&sprt;';

if ( isset($_GET['lang']) && $_GET['lang']!='' && checkLang($_GET['lang']) ) $site_lang = $_GET['lang'];
     else $site_lang = 'hu';
require_once('../lang/'.$site_lang.'.lang.php');

/*
Answer: success || error
		categoryid
		categoryname
		upload rules for the selected category in the given language
*/
$categoryid=trim($_GET['categoryid']);

$action=trim($_GET['action']);
switch($action):
	case 'uploadrules':
		$sql="SELECT categories.id, category_names.name, category_rules.rules FROM categories LEFT JOIN category_names ON categories.id=category_names.category LEFT JOIN category_rules ON categories.id=category_rules.category WHERE category_names.language=\"". ( isset($_GET['language']) && checkLang($_GET['language']) ? $_GET['language'] : $site_lang ) ."\" AND category_rules.language=\"". ( isset($_GET['language']) && checkLang($_GET['language']) ? $_GET['language'] : $site_lang ) ."\" AND categories.id=\"". $categoryid ."\" LIMIT 1";
		$row = $db->query($sql);
		$res = $db->fetch_array($row);
		print 'success'. $sep .$categoryid. $sep .$res['name']. $sep . $res['rules'] . $sep;
	break;
	default:
		print 'error';
endswitch;

$db->close();
?>