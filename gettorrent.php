<?
require_once('inc/config.inc.php');
require_once('classes/class.mysql.php');
//require_once('classes/class.main.php');
require_once('classes/class.lightbenc.php');

/* TODO: 	- authenticate users before download 
			- accents in filename are problematic in IE --> MS bug, no fix released
 */

$db = new DB($config['database'], $config['server'], $config['user'], $config['pass']);
//getLoginStatus($_COOKIE["mmuid"], $_COOKIE["mmpass"]);
$CURUSER["uid"] = 7;

if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression','Off');

$fid=mysql_real_escape_string($_GET["fid"]);
/*$filepath=$TORRENTSDIR."/".$infohash . ".btf";

if (!is_file($filepath) || !is_readable($filepath))
   {
       errormsg(CANT_FIND_TORRENT);
       die();
    }*/

//$f=urldecode($_GET["f"]);
//$f=$_GET["f"];

$sql 	= "SELECT torrent_pass FROM users WHERE uid=".$CURUSER["uid"];
$result = $db->query($sql);
$row 	= $db->fetch_array($result);
$pid 	= $row["torrent_pass"];
//
if (!$pid)
   {
    $random = mt_rand(100000, 999999);
	$random = md5($random);
	$pid = $random;
	$sql = "SELECT uid FROM users WHERE pid='$pid' OR torrent_pass='$pid'";
	$res = $db->query($sql);
	while ( $db->numRows() > 0 )
	      {
		   $random=mt_rand(100000, 999999);
	       $random=md5($random);
	       $pid=$random;
		   $sql = "SELECT uid FROM users WHERE pid='$pid' OR torrent_pass='$pid'";
		   $res = $db->query($sql);
		  }
    $db->execute("UPDATE users SET pid='".$pid."' WHERE uid='".$CURUSER["uid"]."'");
    $db->execute("UPDATE users SET torrent_pass='".$pid."' WHERE uid='".$CURUSER["uid"]."'");
//
}

$sql 	= "SELECT * FROM torrents WHERE fid='".$fid."'";
$result = $db->query($sql);
$row 	= $db->fetch_array($result);

if ($row["staff_ok"]!='okay' && $row["uploader"]!=$CURUSER["uid"])
   {
	//errorMsg(ERR_TORR_NOTABLE_TODOWNLOAD);
	//die();
   }

if ( $row["added"] > "2010-04-01" )
	$filepath 	= $row["url"];
else
	$filepath 	= "data/". $row["url"];

if (!is_file($filepath) || !is_readable($filepath))
   {
       errorMsg(ERR_CANT_FIND_TORRENT);
       printFooter();
       die();
    }

$rfilename=$row["filename"];
//$rfilename 	= 'űáéűéűáőúő';
//$f=unesc($rfilename).".torrent";
$f 			= $rfilename.".torrent";
$alltorrent = $filepath;

$array 				= bdecode_file($alltorrent);
$array["announce"] 	= $config['trackerdownbaseurl']."/$pid/announce";
$alltorrent 		= bencode($array);

header("Content-Type: application/x-bittorrent; charset=UTF-8");
header('Content-Disposition: attachment; filename="[mm6_alpha_'.$row["fid"].']'.$f.'"');
print($alltorrent);

$db->close();
?>