<?php
header("Content-Type: text/html; charset=UTF-8");
require_once('../inc/config.inc.php');
require_once('../classes/class.mysql.php');
require_once('../classes/class.main.php');

$db = new DB($config['database'], $config['server'], $config['user'], $config['pass']);
$sep='&sprt;';
$db->query("SET NAMES utf8");

if ( isset($_GET['lang']) && $_GET['lang']!='' && checkLang($_GET['lang']) ) $site_lang = $_GET['lang'];
     else $site_lang = 'hu';
require_once('../lang/'.$site_lang.'.lang.php');

/*
Answer: success || error
		fid
		description || nfo
		action
*/
$fid = trim($_GET['fid']);
$fid = mysql_real_escape_string($fid);

$action = trim($_GET['action']);
switch($action):
	case 'showtorrent':
		//$sql="SELECT torrents.description FROM torrents WHERE torrents.language=\"". ( isset($_GET['language']) && checkLang($_GET['language']) ? $_GET['language'] : $site_lang ) ."\" AND torrents.fid=\"". $fid ."\" LIMIT 1";
		/* SHOULD FIX: should give a message about there is no description in the current langauge */
		
		$sql="SELECT torrents.description FROM torrents WHERE torrents.fid=\"". $fid ."\" LIMIT 1";
		$row = $db->query($sql);
		$res = $db->fetch_array($row);
		print 'success'. $sep .$fid. $sep .formatBBcode($res['description']). $sep. $action .$sep;
	break;
	case 'shownfo':
		//$sql="SELECT torrents.nfo FROM torrents WHERE torrents.language=\"". ( isset($_GET['language']) && checkLang($_GET['language']) ? $_GET['language'] : $site_lang ) ."\" AND torrents.fid=\"". $fid ."\" LIMIT 1";
		/* SHOULD FIX: should give a message about there is no description in the current langauge */
		
		$sql="SELECT torrents.nfo FROM torrents WHERE torrents.fid=\"". $fid ."\" LIMIT 1";
		$row = $db->query($sql);
		$res = $db->fetch_array($row);
		print 'success'. $sep .$fid. $sep .( $res['nfo']!= '' ? code($res['nfo']) : 'ERR_NO_NFO_UPLOADED' ). $sep. $action .$sep;
	break;
	case 'showfiles':
		require_once('../classes/class.lightbenc.php');
		
		$sql = "SELECT torrents.url, torrents.added FROM torrents WHERE torrents.language=\"". ( isset($_GET['language']) && checkLang($_GET['language']) ? $_GET['language'] : $site_lang ) ."\" AND torrents.fid=\"". $fid ."\" LIMIT 1";
		$row = $db->query($sql);
		$res = $db->fetch_array($row);
		
		if ( $res["added"] > "2010-04-01" )
			$filepath 	= $row["url"];
		else
			$filepath 	= "data/". $res["url"];
		//$filepath 	= "../data/". $res["url"]; //TODO : url should contain data!

		//if (!is_file($filepath) || !is_readable($filepath))	print 'error'. $sep. $param;
		//TODO : give error msg if file does not exist
		
		$content 		= bdecode_file($filepath);
		$returns		= "";
		/* TODO : clear the code and get formating from a template file */
		$numfiles = 0;
		if (isset($content["info"]) && $content["info"])
			{
			$thefile=$content["info"];
			if (isset($thefile["length"]))
				{
				$numfiles++;
				$returns .= "<table><tr><td align=left>".$thefile["name"]."</td><td align=right>" .format_size($thefile["length"]). "</td></tr></table>";
				}
			elseif (isset($thefile["files"]))
				{
				foreach($thefile["files"] as $singlefile)
						{
						$returns .= "\n<table><tr>\n<td align=\"left\" class=\"lista\">".implode("/",$singlefile["path"])."</td>\n<td align=\"right\" class=\"lista\">".format_size($singlefile["length"])."</td></tr></table>\n";
						$numfiles++;
						}
				}
			else
				{
				$returns .= "\n<tr>\n<td colspan=\"2\">nincs adat...</td></tr>\n";   // TODO : handle error
				}
			}
		/* TODO end */
		
		print 'success'. $sep .$fid. $sep . $returns. $sep. $action .$sep;
	break;
	case 'showcomments':
		print 'success'. $sep .$fid. $sep . 'TODO: show comments' . $sep. $action .$sep;
	break;
	case 'showpeers':
		print 'success'. $sep .$fid. $sep . 'TODO: show peers and sum(speed)' . $sep. $action .$sep;
	break;
	case 'showhistory' :
		print 'success'. $sep .$fid. $sep . 'TODO: show history (last X downloaders)' . $sep. $action .$sep;
	break;
	case 'pager' : 
		require_once('../classes/btemplate.class.php');
		$style_path = '../style/base/'; //TODO: get the style_path
		$page 		= mysql_real_escape_string($_GET["page"]);
		$search 	= mysql_real_escape_string($_GET["search"]);
		$order 		= mysql_real_escape_string($_GET["order"]);
		$sort 		= mysql_real_escape_string($_GET["sort"]);
		$category 	= mysql_real_escape_string($_GET["category"]);
		
		if ( $page == '' || !$page ) $page='0';
		
		$where		= "";
		$where		= "torrents.flags!=1 AND mark_deleted='no'";
		
		if ( $search && $search!="" ) $where .= " AND torrents.filename LIKE '%".$search."%'";
		if ( $category && $category!="" ) $where .= " AND torrents.category = ".$category;
		
		$sqlorder		= "";
		$sqlsort		= "";
		if ( !$order || $order=="" ) $sqlorder .= "added";
		else $sqlorder = $order;
		if ( !$sort || $sort=="" || ( $sort!="ASC" || $sort!="DESC" ) ) $sqlsort .= "DESC";
		else $sqlsort = $sort;
		
		$tpl = new bTemplate();
		$tpl->set('block_header', TORRENTS);
		$tpl->set('path', $style_path);
		$tpl->set('category', TORRENT_CATEGORY);
		$tpl->set('filename', TORRENT_FILENAME);
		$tpl->set('filedate', TORRENT_DATE);
		$tpl->set('multiplier', TORRENT_MULTIPLIER);
		$tpl->set('language', LANGUAGE);
		$tpl->set('staff', TORRENT_STAFF);
		$tpl->set('size', TORRENT_SIZE);
		$tpl->set('sl', TORRENT_SL);
		$tpl->set('comments', TORRENT_COMMENTS);
		$tpl->set('seeders', TORRENT_SEEDERS);
		$tpl->set('leechers', TORRENT_LEECHERS);
		$tpl->set('completed', TORRENT_COMPLETED);
		
		//if ( isset($_GET["page"]) ) $page = mysql_real_escape_string(trim($_GET['page']));
		//else $page = 0;
		
		$sql = "SELECT fid FROM torrents WHERE ". $where;
		$db->query($sql);
		$torrcount = $db->numRows();
		$rpp = 25;
		
		$params = "staff=". $staff ."&active=". $active ."&category=" . $category ."&search=" . $search . "&order=" . $sqlorder . "&sort=". $sqlsort ."&onlyfree=". $onlyfree. "&";
		//$params = htmlentities($params);
		
		list($pagertop, $pagerbottom, $limit) = pager($rpp, $torrcount, $params, $page);
		$params .= "page=". $page;
		$content = $pagertop;
		
		$torrents = '';
		$cnt = 0;
		$sql = 'SELECT torrents.fid, torrents.category as category, torrents.filename as filename, torrents.staff_ok, torrents.added, torrents.language, torrents.size, torrents.leechers, torrents.seeders, torrents.completed, categories.image as catimg FROM torrents LEFT JOIN categories ON torrents.category=categories.id WHERE '. $where. ' ORDER BY '. $sqlorder. ' '. $sqlsort . ' '. $limit;
		$rows = $db->query($sql);

		while ($value = $db->fetch_array($rows))
			  {
				$torrents[$cnt] = $value;
				$torrents[$cnt]['size'] = format_size($torrents[$cnt]['size']);
				
				if ($torrents[$cnt]['language']=='en') $torrents[$cnt]['language'] = 'gb';
				
				if ($torrents[$cnt]['leechers']>0) $status=($torrents[$cnt]['seeders']/($torrents[$cnt]['seeders']+$torrents[$cnt]['leechers']))*100;
				else $status=($torrents[$cnt]['seeders']/1)*100;
				$status = round($status, -1);

				if ($torrents[$cnt]['seeders']==0 && $torrents[$cnt]['leechers']==0 && $status==0) $torrents[$cnt]['sl'] = "00.gif";
				if ($torrents[$cnt]['seeders']==0 && $torrents[$cnt]['leechers']>0 && $status==0) $torrents[$cnt]['sl'] = "s00.gif";
				if ($status>9 && $status<101) $torrents[$cnt]['sl'] = $status.".gif";
				if ($status>100) $torrents[$cnt]['sl'] = "100.gif";

				++$cnt;
			  } 

		$tpl->set('torrents', $torrents);
		$tpl->set('is_even', TRUE);
		$content .= $tpl->fetch($style_path. 'html/torrents.ajax.tpl');
		print 'success'. $sep .$content . $sep. $params .$sep. $sql. $sep;
	break;
	case 'searchtorrent' :
		$content 	= '';
		$sql 		= "SELECT filename FROM torrents WHERE filename LIKE '%".$_GET["text"]."%'";
		$db->query($sql);
		$torrcount 	= $db->numRows();
		$rows 		= $db->query($sql);
		
		while ($value = $db->fetch_array($rows))
			  {
				$content .= $value['filename'] . '<br />';
			  } 

		print 'success'. $sep .$content. $sep;
	break;
	default:
		print 'error'. $sep. $param;
endswitch;

$db->close();
?>