<?php

function get_microtime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
    }

function pager($rpp, $count, $href, $currpage = NULL, $opts = array()) {

    if($rpp!=0) $pages = ceil($count / $rpp);
    else $pages=0;

    if (!isset($opts["lastpagedefault"]))
        $pagedefault = 0;
    else {
        $pagedefault = floor(($count - 1) / $rpp);
        if ($pagedefault < 0)
            $pagedefault = 0;
    }

    $pagename="page";

    /*if (isset($opts["pagename"]))
      {
       $pagename=$opts["pagename"];
       if (isset($_GET[$opts["pagename"]]))
          $page = max(0 ,$_GET[$opts["pagename"]]);
       else
          $page = $pagedefault;
      }
    elseif (isset($_GET["page"])) {
        $page = 0 + $_GET["page"];
        if ($page < 0)
            $page = $pagedefault;
    }
    else
        $page = $pagedefault;*/
    $page = $currpage;

    $pager = "";

    $mp = $pages - 1;
    $as = "<b>&lt;&lt;&nbsp;".PREVIOUS."</b>";
    if ($page >= 1) {
        $pager .= "<a href=\"javascript:void(0);\" onclick=\"pager('{$href}$pagename=" . ($page - 1) . "');\">";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;

    $pager .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    $as = "<b>".NEXT."&nbsp;&gt;&gt;</b>";

    if ($page < $mp && $mp >= 0) {
        $pager .= "<a href=\"javascript:void(0);\" onclick=\"pager('{$href}$pagename=" . ($page + 1) . "');\">";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;

    if ($count) {
        $pagerarr = array();
        $dotted = 0;
        $dotspace = 3;
        $dotend = $pages - $dotspace;
        $curdotend = $page - $dotspace;
        $curdotstart = $page + $dotspace;
        for ($i = 0; $i < $pages; $i++) {
            if (($i >= $dotspace && $i <= $curdotend) || ($i >= $curdotstart && $i < $dotend)) {
                if (!$dotted)
                    $pagerarr[] = "...";
                $dotted = 1;
                continue;
            }
            $dotted = 0;
            $start = $i * $rpp + 1;
            $end = $start + $rpp - 1;
            if ($end > $count)
                $end = $count;

            $text = "$start&nbsp;-&nbsp;$end";
            if ($i != $page)
                //$pagerarr[] = "<a href=\"{$href}$pagename=$i\">$text</a>";
                $pagerarr[] = "<a href=\"javascript:void(0);\" onclick=\"pager('{$href}$pagename=$i');\">$text</a>";
            else
                $pagerarr[] = "<b>$text</b>";
        }

        $pagerstr = join(" | ", $pagerarr);
        $pagertop = "<p align=\"center\">$pager<br />$pagerstr</p>\n";
        $pagerbottom = "<p align=\"center\">$pagerstr<br />$pager</p>\n";
    }
    else {
        $pagertop = "<p align=\"center\">$pager</p>\n";
        $pagerbottom = $pagertop;
    }

    $start = $page * $rpp;
    return array($pagertop, $pagerbottom, "LIMIT $start,$rpp");

}

function getLoginStatus($uid, $pass) {
GLOBAL $db;
GLOBAL $CURUSER;

$sql = 'SELECT uid, username, style, language FROM users WHERE uid=\''. $uid. '\' AND password=\''. $pass. '\' AND disabled=\'no\'';
$res = $db->query($sql); 

if ( $db->numRows() == 1 ) {
	$value = $db->fetch_array($res);
	$CURUSER['uid'] = $value['uid'];
	$CURUSER['username'] = $value['username'];
	$CURUSER['style'] = $value['style'];
	$CURUSER['language'] = $value['language'];
	$db->execute('UPDATE users SET lastconnect=NOW() WHERE uid='. $CURUSER['uid']. ' LIMIT 1');
	return true;
    }
else return false;

if ( $uid == "" || $pass == "" ) return false;

}

function logout() {

?>
<script type="text/javascript">
document.cookie = "mmuid"+"="+""+""+"; path=/";
document.cookie = "mmpass"+"="+""+""+"; path=/";
document.cookie = "mmlang"+"="+""+""+"; path=/";
window.location.href="./";
</script>
<?
}

function print_user($uid) {
GLOBAL $db;

$sql = 'SELECT username FROM users WHERE uid=\''. $uid. '\' AND disabled=\'no\'';
$res = $db->query($sql); 
$row = mysql_fetch_array($res);

return '<a class=users_mnu href=?mpage=userdetails&uid='. $uid. '>'. $row["username"]. '</a>';
//users_group és színezés még kell!

}
 
function format_ratio($uploaded, $downloaded) {

if ( $downloaded == 0 ) $ratio = "oo";
else $ratio = number_format($uploaded/$downloaded, 2);

return $ratio;

}

function format_size($bytes) 
{
  if (abs($bytes) < 1000 * 1024)
    return number_format($bytes / 1024, 2) . " KB";
  if (abs($bytes) < 1000 * 1048576)
    return number_format($bytes / 1048576, 2) . " MB";
  if (abs($bytes) < 1000 * 1073741824)
    return number_format($bytes / 1073741824, 2) . " GB";
  return number_format($bytes / 1099511627776, 2) . " TB";
}

function getWord($word) {

// *********** function for setting constant names for language variables  ********* //
$word = strtoupper($word);
$word = 'PAGE_'.$word;
return constant($word);
}

function getLang() {

GLOBAL $_GET;
GLOBAL $_COOKIE;

	
if ( isset($_GET['lang']) && $_GET['lang']!='' ) return $_GET['lang'];
	elseif ( isset($_COOKIE['mmlang']) && $_COOKIE['mmlang']!='' ) return $_COOKIE['mmlang'];
else return 'hu'; //db -bõl kell majd kiolvasni a júzer beállítását... ha nincs bejelentkezve, akkor HU!
}

function setLang($lang) {

GLOBAL $_COOKIE;

require_once('lang/'.$lang.'.lang.php');


if ( $_COOKIE['mmlang'] != $lang ) {

?>
<script type="text/javascript">
document.cookie = "mmlang"+"="+"<?=$lang?>"+""+"; path=/";
</script>
<?

}


}
	
function getStyle() {

GLOBAL $_GET;
GLOBAL $_COOKIE;
GLOBAL $styleArray;

$stylePath = '';

if ( isset($_GET['style']) && $_GET['style']!='' ) $stylePath = 'style/'.$_GET['style'].'/';
elseif ( isset($_COOKIE['mmstyle']) && $_COOKIE['mmstyle']!='' && strlen($_COOKIE['mmstyle'])<20 ) $stylePath = $_COOKIE['mmstyle'];
else $stylePath = 'style/base/'; //db -bõl kell majd kiolvasni a júzer beállítását... ha nincs bejelentkezve, akkor base

if ( in_array($stylePath, $styleArray) ) return $stylePath;
else return 'style/base/';

}

function setStyle($style) {

GLOBAL $_COOKIE;

if ( ( isset($_COOKIE['mmstyle']) && $_COOKIE['mmstyle']!= $style ) || ( !isset($_COOKIE['mmstyle']) ) ) {

?>
<script type="text/javascript">
document.cookie = "mmstyle"+"="+"<?=$style?>"+""+"; path=/";
</script>
<?

}
//return 'style/'.$style;
}

function getNetSpeed($selected = NULL) {

$speedStr = '';
$speedInt = 128;
$bigspeedArray = array('15 Mbit/sec', '30 Mbit/sec', '50 Mbit/sec', '100 Mbit/sec', '1 Gbit/sec');
while ( $speedInt < 10000 )
      {
		$speedStr .= '<option'. (($selected && $selected == $speedInt. ' kbit/sec') ? ' selected' : '') .'>'. $speedInt. ' kbit/sec</option>';
		$speedInt = $speedInt + 128;
	  }
foreach ($bigspeedArray as $i => $value)  
        {
         $speedStr .= '<option'. (($selected && $selected == $value) ? ' selected' : '') .'>'. $value. '</option>';
        }

return $speedStr;
}

function getISP($selected = NULL) {

$ispArray = array('T-home', 'Digi', 'UPC', REG_ISP_CABLE, REG_ISP_OTHER);
$ispStr = '';

foreach ($ispArray as $i => $value)  
        {
         $ispStr .= '<option value=\''. $value. '\''. (($selected && $selected == $value) ? ' selected' : '') .'>'. $value. '</option>';
        }
        
return $ispStr;	
}

function getBornYear($selected = NULL) {

$yearInt = 1995;
$yearStr = '';
while ( $yearInt > 1929 ) 
      {
		$yearStr .= '<option value=\''. $yearInt. '\''. (($selected && $selected == $yearInt) ? ' selected' : '') .'>'. $yearInt. '</option>';
		$yearInt--;
	  }
	  
return $yearStr;	
}


function getAvailLangs($selected = NULL, $event = NULL) {
	
GLOBAL $langArray;
$langStr = '';

foreach ($langArray as $i => $value)  
        {
         $langStr .= '<option value=\''. $value. '\''. (($selected && $selected == $value) ? ' selected' : '') . ( $event!=NULL ? ' '.$event : '' ). '>'. $value. '</option>';
        }
        
return $langStr;	
}

function getSex($selected = NULL) {

$sexStr = '';
$sexStr .= '<option value=\'male\''. (($selected && $selected == 'male') ? ' selected' : '') .'>'. REG_SEX_MALE. '</option>';
$sexStr .= '<option value=\'female\''. (($selected && $selected == 'female') ? ' selected' : '') .'>'. REG_SEX_FEMALE. '</option>';

return $sexStr;	
}

function getAvailStyles($selected = NULL) {
	
GLOBAL $styleNameArray;
GLOBAL $styleArray;
$styleNameStr = '';
$cnt = 0;

foreach ($styleArray as $i => $value)  
        {
         $styleNameStr .= '<option value=\''. $value. '\''. (($selected && $selected == $value) ? ' selected' : '') .'>'. $styleNameArray[$cnt]. '</option>';
         $cnt++;
        }
        
return $styleNameStr;	
}

function getAvailCountries($selected = NULL) {

GLOBAL $db;
$countryStr = '';

//$db->query("SET NAMES utf8");
$rows = $db->query("SELECT id, country FROM countries");


while ($value = $db->fetch_array($rows))
      {
		$countryStr .= '<option value=\''. $value['id']. '\''. (($selected && $selected == $value['id']) ? ' selected' : '') .'>'. $value['country']. '</option>';
	  }
      
return $countryStr;
}

function getAvailCategories($selected = NULL, $language = NULL) {

GLOBAL $db;
GLOBAL $site_lang;
$categoryStr = '';

//$db->query("SET NAMES utf8");
$rows = $db->query("SELECT categories.id, category_names.name FROM categories LEFT JOIN category_names ON categories.id=category_names.category WHERE category_names.language=\"". ($language == NULL ? $site_lang : $language) ."\" ORDER BY name ASC");


while ($value = $db->fetch_array($rows))
      {
		$categoryStr .= '<option value=\''. $value['id']. '\''. (($selected && $selected == $value['id']) ? ' selected' : '') .' onclick="showcategory(\''. $value['id']. '\');">'. $value['name']. '</option>';
	  }
      
return $categoryStr;
}

function checkMpage($mpage = NULL) {

GLOBAL $mpageArray;
$mpageBool = false;

if ( in_array($mpage, $mpageArray) )
	$mpageBool = true;
else $mpageBool = false;

return $mpageBool;
}

function checkLang($lang = NULL) {

GLOBAL $langArray;
$langBool = false;

if ( in_array($lang, $langArray) )
	$langBool = true;
else $langBool = false;

return $langBool;
}

function checkStyle($style = NULL) {

GLOBAL $styleArray;
$styleBool = false;

if ( in_array('style/'. $style. '/', $styleArray) )
	$styleBool = true;
else $styleBool = false;

return $styleBool;
}

function printFooter() {
/* This function is needed to be prepared for errorMsg() function */
/* The propose of this function is to print the footer of the page, it should be called everywhere where we'd like to use die() function with or without errorMsg() 
*/

GLOBAL $tpl;
GLOBAL $time_start;
GLOBAL $db;
GLOBAL $style_path;
GLOBAL $content;
GLOBAL $site_version, $site_mail, $site_copyright;

// ******************* CONTENT (ALL BLOCKS) **************** //
$tpl->set('content', $content);
echo $tpl->fetch($style_path. 'html/content.tpl');
// ******************* CONTENT (ALL BLOCKS) END **************** //


// ******************* FOOTER **************** //
$time_end=get_microtime();
$load_seconds=number_format(($time_end-$time_start),4)." ";
$tpl->set('generated', GENERATED);
$tpl->set('load_seconds', $load_seconds);
$tpl->set('seconds', SECONDS);
$tpl->set('contact', CONTACT);
$tpl->set('site_version', $site_version);
$tpl->set('site_mail', $site_mail);
$tpl->set('copy_right', $site_copyright);
echo $tpl->fetch($style_path. 'html/footer.tpl');
// ******************* FOOTER END **************** //

$db->close();
}

function errorMsg($message = NULL, $displayback = false) {
/* Usage should look like this: errorMsg(); printFooter(); die(); */

GLOBAL $content;
GLOBAL $tpl;
GLOBAL $style_path;

$tpl->set('errormsg', ERRORMSG);
$tpl->set('errormsg_cause', $message);
//TODO displayback: javascript back button!

$content .= $tpl->fetch($style_path. 'html/errormsg.tpl');
}

function unesc($x) {
    if (get_magic_quotes_gpc())
        return stripslashes($x);
    return $x;
}

function formatQuote($text)
{
//TODO: review this function
  $string=$text;
  $prev_string = "";
  while ($prev_string != $string)
        {
    $prev_string = $string;
    $string = preg_replace("/\[quote\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i", "<br /><b>".QUOTE.":</b><br /><table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\" class=\"lista\"><tr><td >\\1</td></tr></table><br />", $string);
    $string = preg_replace("/\[quote=(.+?)\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i", "<br /><b>\${1} ".WROTE.":</b><br /><table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\" class=\"lista\"><tr><td>\\2</td></tr></table><br />", $string);
    // code
    $string = preg_replace("/\[code\]\s*((\s|.)+?)\s*\[\/code\]\s*/i", "<br /><b>Code</b><br /><table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\" class=\"lista\"><tr><td>\\1</td></tr></table><br />", $string);

  }

return $string;
}

function formatBBcode($text, $strip_html = true)
{
//TODO: review this function
    global $smilies, $privatesmilies, $BASEURL;

    $s = $text;

    if ($strip_html)
        $s = htmlspecialchars($s);

    $s = unesc($s);

    $f=@fopen("badwords.txt","r");
    if ($f && filesize ("badwords.txt")!=0)
       {
       $bw=fread($f,filesize("badwords.txt"));
       $badwords=explode("\n",$bw);
       for ($i=0;$i<count($badwords);++$i)
           $badwords[$i]=trim($badwords[$i]);
       $s = str_replace($badwords,"*censored*",$s);
       }
    @fclose($f);

    // [*]
    $s = preg_replace("/\[\*\]/", "<li>", $s);

    // [b]Bold[/b]
    $s = preg_replace("/\[b\]((\s|.)+?)\[\/b\]/", "<b>\\1</b>", $s);
    $s = preg_replace("/\[B\]((\s|.)+?)\[\/B\]/", "<b>\\1</b>", $s);

    // [i]Italic[/i]
    $s = preg_replace("/\[i\]((\s|.)+?)\[\/i\]/", "<i>\\1</i>", $s);
    $s = preg_replace("/\[I\]((\s|.)+?)\[\/I\]/", "<i>\\1</i>", $s);

    // [u]Underline[/u]
    $s = preg_replace("/\[u\]((\s|.)+?)\[\/u\]/", "<u>\\1</u>", $s);
    $s = preg_replace("/\[U\]((\s|.)+?)\[\/U\]/", "<u>\\1</u>", $s);

	// [s]Line-through[/s]
    $s = preg_replace("/\[s\]((\s|.)+?)\[\/s\]/", "<span style=\"text-decoration:line-through;\">\\1</span>", $s);
    $s = preg_replace("/\[S\]((\s|.)+?)\[\/S\]/", "<span style=\"text-decoration:line-through;\">\\1</span>", $s);

    // [img]http://www/image.gif[/img]
    $s = preg_replace("/\[img\](http:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png))\[\/img\]/", "<img border=0 src=\"\\1\">", $s);
	$s = preg_replace("/\[img\]([^\s'\"<>]+(\.gif|\.jpg|\.png))\[\/img\]/", "<img border=0 src=\"\\1\">", $s); //tinymce emotion
    $s = preg_replace("/\[IMG\](http:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png))\[\/IMG\]/", "<img border=0 src=\"\\1\">", $s);
	/*
	$s = preg_replace("/\[img\](http:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png|\.jpeg))\[\/img\]/", "<table valign=center><tr><td valign=center><img src=images/images.gif border=0></td><td valign=center><a href=\"\\1\" target=_blank>Linkelt kép</a></td></tr></table>", $s);
    $s = preg_replace("/\[IMG\](http:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png|\.jpeg))\[\/IMG\]/", "<table valign=center><tr><td valign=center><img src=images/images.gif border=0></td><td valign=center><a href=\"\\1\" target=_blank>Linkelt kép</a></td></tr></table>", $s);
	$s = preg_replace("/\[img\](http:\/\/[^\s'\"<>]+(\.GIF|\.JPG|\.PNG|\.JPEG))\[\/img\]/", "<table valign=center><tr><td valign=center><img src=images/images.gif border=0></td><td valign=center><a href=\"\\1\" target=_blank>Linkelt kép</a></td></tr></table>", $s);*/
	/*
	$s = preg_replace("/\[img\](http:\/\/[^\s'\"<>]+(\.(jpg|gif|png|jpeg)))\[\/img\]/i", "<img border=0 src=\"\\1\" alt=\"\" onload=\"NcodeImageResizer.createOn(this);\">", $s);
	$s = preg_replace("/\[IMG\](http:\/\/[^\s'\"<>]+(\.(JPG|GIF|PNG|JPEG)))\[\/IMG\]/i", "<img border=0 src=\"\\1\" alt=\"\" onload=\"NcodeImageResizer.createOn(this);\">", $s);*/

    // [img=http://www/image.gif]
    $s = preg_replace("/\[img=(http:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png|\.jpeg))\]/", "<table valign=center><tr><td valign=center><img src=images/images.gif border=0></td><td valign=center><a href=\"\\1\" target=_blank>Linkelt kép</a></td></tr></table>", $s);
    $s = preg_replace("/\[IMG=(http:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png|\.jpeg))\]/", "<table valign=center><tr><td valign=center><img src=images/images.gif border=0></td><td valign=center><a href=\"\\1\" target=_blank>Linkelt kép</a></td></tr></table>", $s);
	/*$s = preg_replace("/\[img=(http:\/\/[^\s'\"<>]+(\.(gif|jpg|png|jpeg)))\]/i", "<img border=0 src=\"\\1\" alt=\"\"  onload=\"NcodeImageResizer.createOn(this);\">", $s);
	$s = preg_replace("/\[IMG=(http:\/\/[^\s'\"<>]+(\.(GIF|JPG|PNG|JPEG)))\]/i", "<img border=0 src=\"\\1\" alt=\"\"  onload=\"NcodeImageResizer.createOn(this);\">", $s);*/

    // [color=blue]Text[/color]
    $s = preg_replace(
        "/\[color=([a-zA-Z]+)\]((\s|.)+?)\[\/color\]/i",
        "<font color=\\1>\\2</font>", $s);

    // [color=#ffcc99]Text[/color]
    $s = preg_replace(
        "/\[color=(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\]((\s|.)+?)\[\/color\]/i",
        "<font color=\\1>\\2</font>", $s);

    // [url=http://www.example.com]Text[/url]
    $s = preg_replace(
        "/\[url=((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\]((\s|.)+?)\[\/url\]/i",
        "<a href=http://sjmp.eu/?\\1 target=_blank>\\3</a>", $s);

    // [url]http://www.example.com[/url]
    $s = preg_replace(
        "/\[url\]((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\[\/url\]/i",
        "<a href=http://sjmp.eu/?\\1 target=_blank>\\1</a>", $s);

    // [size=4]Text[/size]
    $s = preg_replace(
        "/\[size=([1-7])\]((\s|.)+?)\[\/size\]/i",
        "<font size=\\1>\\2</font>", $s);

    // [font=Arial]Text[/font]
    $s = preg_replace(
        "/\[font=([a-zA-Z ,]+)\]((\s|.)+?)\[\/font\]/i",
        "<font face=\"\\1\">\\2</font>", $s);

    $s=formatQuote($s);

    // Linebreaks
    $s = nl2br($s);

    // Maintain spacing
    $s = str_replace("  ", " &nbsp;", $s);

    /*reset($smilies);
    while (list($code, $url) = each($smilies))
        $s = str_replace($code, "<img border=0 src=images/smilies/$url>", $s);

    reset($privatesmilies);
    while (list($code, $url) = each($privatesmilies))
        $s = str_replace($code, "<img border=0 src=images/smilies/$url>", $s);
	*/
    return $s;
}

function getLangName($language = NULL) {

GLOBAL $langArray;
GLOBAL $langNameArray;
$cnt = 0;

$langNameStr = '';

foreach ($langArray as $i => $value)  
        {
         if ( $value == $language) $langNameStr = $langNameArray[$cnt];
		 $cnt++;
        }
        
return $langNameStr;
}

function getCountryName($country = NULL) {

GLOBAL $db;

$rows = $db->query("SELECT country FROM countries WHERE id=". $country. " LIMIT 1");
$value = $db->fetch_array($rows);

return $value['country'];
}

function getStyleName($style = NULL) {

GLOBAL $styleArray;
GLOBAL $styleNameArray;
$cnt = 0;

$styleNameStr = '';

foreach ($styleArray as $i => $value)  
        {
         if ( $value == $style) $styleNameStr = $styleNameArray[$cnt];
		 $cnt++;
        }
        
return $styleNameStr;
}

function UTF8_mail($from,$to,$subject,$message,$cc="",$bcc=""){

/* USAGE: 
	UTF8_mail("mmtorrents <noreply@mmtorrents.hu>", "<". $row["email"] .">", "mmtorrents értesítő", $msg, "", "");
*/

$from = explode("<",$from );

$headers =
"From: =?UTF-8?B?"
.base64_encode($from[0])."?= <"
. $from[1] . "\r\n";

$to = explode("<",$to );
$to = "=?UTF-8?B?".base64_encode($to[0])
."?= <". $to[1] ;

$subject="=?UTF-8?B?"
.base64_encode($subject)."?=\n";

if($cc!=""){
$cc = explode("<",$cc );
$headers .= "Cc: =?UTF-8?B?"
.base64_encode($cc[0])."?= <"
. $cc[1] . "\r\n";
}

if($bcc!=""){
$bcc = explode("<",$bcc );
$headers .= "Bcc: =?UTF-8?B?"
.base64_encode($bcc[0])."?= <"
. $bcc[1] . "\r\n";
}

$headers .=
"Content-Type: text/plain; "
. "charset=UTF-8; format=flowed\n"
. "MIME-Version: 1.0\n"
. "Content-Transfer-Encoding: 8bit\n"
. "X-Mailer: PHP\n";

return mail($to, $subject, $message, $headers);
}

function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      /*
      checkdnsrr is not working :-/
      if ($isValid && !(checkdnsrr($domain,"MX") || 
      checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }*/
   }
   return $isValid;
}

function code($ibm_437) {
  $table437 = array("\200", "\201", "\202", "\203", "\204", "\205", "\206", "\207",
  "\210", "\211", "\212", "\213", "\214", "\215", "\216", "\217", "\220",
  "\221", "\222", "\223", "\224", "\225", "\226", "\227", "\230", "\231",
  "\232", "\233", "\234", "\235", "\236", "\237", "\240", "\241", "\242",
  "\243", "\244", "\245", "\246", "\247", "\250", "\251", "\252", "\253",
  "\254", "\255", "\256", "\257", "\260", "\261", "\262", "\263", "\264",
  "\265", "\266", "\267", "\270", "\271", "\272", "\273", "\274", "\275",
  "\276", "\277", "\300", "\301", "\302", "\303", "\304", "\305", "\306",
  "\307", "\310", "\311", "\312", "\313", "\314", "\315", "\316", "\317",
  "\320", "\321", "\322", "\323", "\324", "\325", "\326", "\327", "\330",
  "\331", "\332", "\333", "\334", "\335", "\336", "\337", "\340", "\341",
  "\342", "\343", "\344", "\345", "\346", "\347", "\350", "\351", "\352",
  "\353", "\354", "\355", "\356", "\357", "\360", "\361", "\362", "\363",
  "\364", "\365", "\366", "\367", "\370", "\371", "\372", "\373", "\374",
  "\375", "\376", "\377");

  $tablehtml = array("&#x00c7;", "&#x00fc;", "&#x00e9;", "&#x00e2;", "&#x00e4;",
  "&#x00e0;", "&#x00e5;", "&#x00e7;", "&#x00ea;", "&#x00eb;", "&#x00e8;",
  "&#x00ef;", "&#x00ee;", "&#x00ec;", "&#x00c4;", "&#x00c5;", "&#x00c9;",
  "&#x00e6;", "&#x00c6;", "&#x00f4;", "&#x00f6;", "&#x00f2;", "&#x00fb;",
  "&#x00f9;", "&#x00ff;", "&#x00d6;", "&#x00dc;", "&#x00a2;", "&#x00a3;",
  "&#x00a5;", "&#x20a7;", "&#x0192;", "&#x00e1;", "&#x00ed;", "&#x00f3;",
  "&#x00fa;", "&#x00f1;", "&#x00d1;", "&#x00aa;", "&#x00ba;", "&#x00bf;",
  "&#x2310;", "&#x00ac;", "&#x00bd;", "&#x00bc;", "&#x00a1;", "&#x00ab;",
  "&#x00bb;", "&#x2591;", "&#x2592;", "&#x2593;", "&#x2502;", "&#x2524;",
  "&#x2561;", "&#x2562;", "&#x2556;", "&#x2555;", "&#x2563;", "&#x2551;",
  "&#x2557;", "&#x255d;", "&#x255c;", "&#x255b;", "&#x2510;", "&#x2514;",
  "&#x2534;", "&#x252c;", "&#x251c;", "&#x2500;", "&#x253c;", "&#x255e;",
  "&#x255f;", "&#x255a;", "&#x2554;", "&#x2569;", "&#x2566;", "&#x2560;",
  "&#x2550;", "&#x256c;", "&#x2567;", "&#x2568;", "&#x2564;", "&#x2565;",
  "&#x2559;", "&#x2558;", "&#x2552;", "&#x2553;", "&#x256b;", "&#x256a;",
  "&#x2518;", "&#x250c;", "&#x2588;", "&#x2584;", "&#x258c;", "&#x2590;",
  "&#x2580;", "&#x03b1;", "&#x00df;", "&#x0393;", "&#x03c0;", "&#x03a3;",
  "&#x03c3;", "&#x03bc;", "&#x03c4;", "&#x03a6;", "&#x0398;", "&#x03a9;",
  "&#x03b4;", "&#x221e;", "&#x03c6;", "&#x03b5;", "&#x2229;", "&#x2261;",
  "&#x00b1;", "&#x2265;", "&#x2264;", "&#x2320;", "&#x2321;", "&#x00f7;",
  "&#x2248;", "&#x00b0;", "&#x2219;", "&#x00b7;", "&#x221a;", "&#x207f;",
  "&#x00b2;", "&#x25a0;", "&#x00a0;");
  $s = htmlspecialchars($ibm_437);


  // 0-9, 11-12, 14-31, 127 (decimalt)
  $control = 
      array("\000", "\001", "\002", "\003", "\004", "\005", "\006", "\007", 
      "\010", "\011", /*"\012",*/ "\013", "\014", /*"\015",*/ "\016", "\017",
      "\020", "\021", "\022", "\023", "\024", "\025", "\026", "\027",
      "\030", "\031", "\032", "\033", "\034", "\035", "\036", "\037",
      "\177");

  
  $s = str_replace($control," ",$s); 

  $s = str_replace($table437, $tablehtml, $s);
  return $s;
}

function genrandom() {
	
	$random = mt_rand(0, time());
	$random .=  md5(time());
	$random = md5($random);
	return $random;
}

?>