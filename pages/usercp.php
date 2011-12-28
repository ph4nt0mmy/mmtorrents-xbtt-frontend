<?php

// ******************* USERCP  **************** //
/*
profile_edit
messages
credits
*/

// CONTROL PANEL header, needed in every case //
$tpl->set('usercp', USERCP);
$tpl->set('usercp_settings', USERCP_SETTINGS);
$tpl->set('usercp_msgin', USERCP_MSGIN);
$tpl->set('usercp_msgout', USERCP_MSGOUT);
$tpl->set('usercp_mytorrents_up', USERCP_MYTORRENTS_UP);
$tpl->set('usercp_mytorrents_down', USERCP_MYTORRENTS_DOWN);
$tpl->set('usercp_mytorrents_bookmarks', USERCP_MYTORRENTS_BOOKMARK);
$tpl->set('usercp_invitation', USERCP_INVITATION);
$tpl->set('usercp_credits', USERCP_CREDITS);
$block_content = $tpl->fetch($style_path. 'html/usercp.tpl');
// END OF CONTROL PANEL header, needed in every case //

// ***************** PROFILE EDIT *************** //
if ( $_GET['mpage'] == 'usercp' && $_GET['sub'] == 'profile' && $_GET['do'] == 'edit' )
{
$tpl->set('lang', $CURUSER['language']);
$tpl->set('block_header', BLOCK_USERCP. ' : '. BLOCK_PROFILE_EDIT);
$tpl->set('reg_username', REG_USERNAME);
$tpl->set('reg_userpwd', REG_USERPWD);
$tpl->set('reg_userpwdagain', REG_USERPWDAGAIN);
$tpl->set('reg_submitbutton', REG_SUBMIT);
$tpl->set('reg_picdescription', REG_PICDESCR);
$tpl->set('reg_bornyear', REG_BORNYEAR);
$tpl->set('reg_sex', REG_SEX);
$tpl->set('reg_lang', REG_LANG);
$tpl->set('reg_country', REG_COUNTRY);
$tpl->set('reg_upspeed', REG_UPSPEED);
$tpl->set('reg_downspeed', REG_DOWNSPEED);
$tpl->set('profile_machineon', PROFILE_MACHINEON);
$tpl->set('reg_isp', REG_ISP);
$tpl->set('reg_readrules', REG_READRULES);
$tpl->set('reg_readyes', REG_READYES);
$tpl->set('reg_readno', REG_READNO);
$tpl->set('reg_email', REG_EMAIL);
$tpl->set('reg_choose', REG_CHOOSE);

$tpl->set('profile_passwdchange', PROFILE_PASSWDCHANGE);
$tpl->set('profile_notchangeable', PROFILE_NOTCHANGEABLE);
$tpl->set('profile_credits', USER_CREDITS);
$tpl->set('profile_passkey', PROFILE_PASSKEY);
$tpl->set('profile_changeable', PROFILE_CHANGEABLE);
$tpl->set('profile_introduction', PROFILE_INTRODUCTION);
$tpl->set('profile_submitbutton', PROFILE_SUBMITBUTTON);
$tpl->set('profile_signature', PROFILE_SIGNATURE);
$tpl->set('profile_passkeychange_description', PROFILE_PASSKEYCHANGE_DESCRIPTION);
$tpl->set('profile_passkeychange', PROFILE_PASSKEYCHANGE);
$tpl->set('profile_avatar', PROFILE_AVATAR);
$tpl->set('profile_style', PROFILE_STYLE);
$tpl->set('profile_idlevel', PROFILE_IDLEVEL);
$tpl->set('profile_downloadslots', PROFILE_DOWNLOADSLOTS);
$tpl->set('profile_uploadslots', PROFILE_UPLOADSLOTS);

$sql = 'SELECT users.username, users.email, users.credits, users.torrent_pass, users.id_level, users.torrents_limit, users.upload_limit, users.bornyear, users.sex, users.language, users.country, users.upspeed, users.downspeed, users.isp, users.machineon, users.introduction, users.signature, users.avatar, users.style, users_level.level, users_level.color FROM users LEFT JOIN users_level ON users_level.group=users.id_level WHERE users.uid='. $CURUSER['uid']. ' LIMIT 1';
$row = $db->query($sql);
$result = $db->fetch_array($row);

$tpl->set('username_value', $result['username']);
$tpl->set('idlevel_value', constant($result['level']));
$tpl->set('email_value', $result['email']);
$tpl->set('credits_value', $result['credits']);
$tpl->set('downloadslots_value', $result['torrents_limit']);
$tpl->set('uploadslots_value', $result['upload_limit']);
$tpl->set('passkey_value', $result['torrent_pass']);
$tpl->set('introduction_value', $result['introduction']);
$tpl->set('signature_value', $result['signature']);
$tpl->set('avatar_value', $result['avatar']);
$tpl->set('machineon_value', $result['machineon']);

$tpl->set('reg_option_bornyear', getBornYear($result['bornyear']));
$tpl->set('reg_option_sex', getSex($result['sex']));
$tpl->set('reg_option_lang', getAvailLangs($result['language']));
$tpl->set('reg_option_country', getAvailCountries($result['country']));
$tpl->set('reg_option_upspeed', getNetSpeed($result['upspeed']));
$tpl->set('reg_option_downspeed', getNetSpeed($result['downspeed']));
$tpl->set('reg_option_isp', getISP($result['isp']));
$tpl->set('profile_option_style', getAvailStyles($result['style']));

$block_content .= $tpl->fetch($style_path. 'html/profile_edit.tpl'); // PROFILE EDIT, just in case sub=profile&do=edit
}
// ***************** END OF PROFILE EDIT *************** //

// ***************** PROFILE SAVE *************** //
if ( $_POST['mpage'] == 'usercp' && $_POST['sub'] == 'profile' && $_POST['do'] == 'save' )
{
$tpl->set('block_header', BLOCK_USERCP. ' : '. BLOCK_PROFILE_SAVE);
if ( isset($_POST['password']) && $_POST['password'] != '' ) $password = md5($siteblowfish. mysql_real_escape_string($_POST["password"]));

if ( !isset($_POST["bornyear"]) || !isset($_POST["sex"]) || !isset($_POST["lang"]) || !isset($_POST["country"]) || !isset($_POST["upspeed"]) || !isset($_POST["downspeed"]) || !isset($_POST["isp"]) || !isset($_POST["style"]) || !isset($_POST["machineon"]) || $_POST["bornyear"] == "" || $_POST["sex"] == "" || $_POST["lang"] == "" || $_POST["country"] == "" || $_POST["upspeed"] == "" || $_POST["downspeed"] == "" || $_POST["isp"] == "" || $_POST["style"] == "" || $_POST["machineon"] == "" ) 
   {
	errorMsg(PROFILE_MISSING_DATA);
	printFooter();
	die();
   }
 else 
 {
  $bornyear 	= mysql_real_escape_string($_POST["bornyear"]);
  $sex 			= mysql_real_escape_string($_POST["sex"]);
  $lang 		= mysql_real_escape_string($_POST["lang"]);
  $country 		= mysql_real_escape_string($_POST["country"]);
  $upspeed 		= mysql_real_escape_string($_POST["upspeed"]);
  $downspeed 	= mysql_real_escape_string($_POST["downspeed"]);
  $isp 			= mysql_real_escape_string($_POST["isp"]);
  $introduction = mysql_real_escape_string($_POST["introduction"]);
  $signature 	= mysql_real_escape_string($_POST["signature"]);
  $avatar 		= mysql_real_escape_string($_POST["avatar"]);
  $style 		= mysql_real_escape_string($_POST["style"]);
  $machineon 	= mysql_real_escape_string($_POST["machineon"]);
  //TODO: changepasskey; check the POSTED data before update the db, if something is not okay, call errorMsg() function

  if ( $CURUSER['style'] != $_POST['style'] && getAvailStyles($_POST['style']) ) setStyle($_POST['style']);
  if ( $CURUSER['language'] != $_POST['lang'] && getAvailLangs($_POST['lang']) ) setLang($_POST['lang']);

  $sql = 'UPDATE users SET bornyear=\''. $bornyear. '\', sex=\''. $sex. '\', language=\''. $lang. '\', country=\''. $country. '\', upspeed=\''. $upspeed. '\', downspeed=\''. $downspeed. '\', isp=\''. $isp. '\', machineon=\''. $machineon. '\', introduction=\''. $introduction. '\', signature=\''. $signature. '\', avatar=\''. $avatar. '\', style=\''. $style. '\' WHERE uid = '. $CURUSER['uid']. ' LIMIT 1';
  $db->execute($sql);
  
  //TODO: passwd change
  
  if ( $_POST["password"] != "" ) 
	 {
	   if ( $_POST["password"] != $_POST["passwordagain"] )
		  {
		    errorMsg(PROFILE_PASSWD_NOT_MATCH);
			printFooter();
			die();
		  }
	   elseif ( strlen($_POST["password"]) < 6 )
			  {
				errorMsg(PROFILE_PASSWD_TOO_SHORT);
				printFooter();
				die();
			  }
		
	   $sql = 'UPDATE users SET password=\''. $password. '\' WHERE uid = '. $CURUSER['uid']. ' LIMIT 1';
	   $db->execute($sql);
	   //TODO: change cookies (password)
	 }

  $tpl->set('profile_changed', PROFILE_CHANGED);
  $tpl->set('profile_uid', $CURUSER['uid']);
  $tpl->set('profile_seechangeseeasme', PROFILE_CHANGESEEASME);
  $tpl->set('profile_seechangeseeasothers', PROFILE_CHANGESEEASOTHERS);

  $block_content .= $tpl->fetch($style_path. 'html/profile_changed.tpl');
 }
}
// ***************** END OF PROFILE SAVE *************** //

$tpl->set('block_content', $block_content);
$content=$content.$tpl->fetch($style_path. 'html/block.tpl');

/* blokk vége */
// ******************* USERCP END **************** //

?>