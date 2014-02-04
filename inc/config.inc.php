<?php
//************ Basic config settings... I'd be nice to write a tool to handle these stuffs in the future *************//

$js_path = 'js/';
$site_lang = 'hu';
$site_name = 'MMv6&alpha; | mmtorrents | ';
$site_version = 'MM6 v0.8.2&alpha;';
$site_mail = 'info@mmtorrents.hu';
$site_copyright = '&copy; 2006-2010 mmtorrents';
//$siteblowfish = '';

$config['noreplymail'] 			= 'noreply@localhost';
$config['sitename']				= 'mmtorrents';
//database config
$config['server'] 				= "localhost";
$config['user'] 				= "user";
$config['pass'] 				= "password";
$config['database'] 			= "mm6";
$config['tablePrefix'] 			= "";

$config['baseurl'] 				= "http://localhost/";
$config['announceurl'] 			= "http://localhost:8887/announce";
$config['trackerdownbaseurl'] 	= "http://localhost:8887";
$config['torrentsdir'] 			= "data/torrents";
$config['coversdir'] 			= "data/covers";
$config['avatarsdir'] 			= "data/avatars";

$config['openreg']	 			= false;
$config['inviteon']	 			= true;

$config['maxtorrentsize'] 		= 1024*1024; //1 Mbyte
$config['maxcoversize'] 		= 2*1024*1024; //2 Mbyte
$config['maxnfosize'] 			= 65*1024; //65 Kbyte
$config['cover_x'] 				= 150; //width in px

$mpageArray = array("userdetails", "torrents", "upload", "requests", "users", "staff", "rules", "faq", "forum", "chat", "stat", "donate", "usercp");
$langArray = array("hu", "en", "pt_br");
$langNameArray = array("Magyar", "English", "Portugues BR");
$styleArray = array("style/base/", "style/metal/");
$styleNameArray = array("Classic", "Metal");
$nfoFileTypes = array ( ".nfo", ".txt");

?>