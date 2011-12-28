<?php
// ******************* REG.PHP  **************** //
// TODO: AJAX feedback on form entries

$tpl->set('block_header', REGISTRATION);

if ( isset($_GET["act"]) && $_GET["act"] == "confirm" ) {
	$random = mysql_real_escape_string($_GET["random"]);
	$email 	= mysql_real_escape_string($_GET["email"]);
	$sql = "SELECT uid, username, random, email, id_level FROM users WHERE random='". $random. "' AND email='". $email. "' LIMIT 1";
	
	$res = $db->query($sql);
	if ( $db->numRows() < 1 ) {
		errorMsg(REG_RANDOM_OR_EMAIL_NOT_MATCH);
		printFooter();
		die();
	}
	$row = $db->fetch_array($res);
	if ( $row["id_level"] > 0 ) {
		errorMsg(REG_ALREADY_CONFIRMED);
		printFooter();
		die();
	}
	
	$sql = "UPDATE users SET id_level=2, lastconnect=NOW() WHERE uid=". $row["uid"]. " LIMIT 1";
	//TODO: üdvözlőüzenet a felhasználónak! Erre legyen fv: sendmsg()
	$db->execute($sql);
	
	$tpl->set('reg_successfull', REG_SUCCESSFULL);	
	$content=$tpl->fetch($style_path. 'html/regsuccessfull.tpl');
	$tpl->set('block_content', $content);
	$content=$tpl->fetch($style_path. 'html/block.tpl');
}
else {
if ( $config['openreg'] == true ) {
$tpl->set('reg_referrer', '');
$tpl->set('reg_invitedby', '');

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
$tpl->set('reg_isp', REG_ISP);
$tpl->set('reg_readrules', REG_READRULES);
$tpl->set('reg_readyes', REG_READYES);
$tpl->set('reg_readno', REG_READNO);
$tpl->set('reg_email', REG_EMAIL);
$tpl->set('reg_choose', REG_CHOOSE);
$tpl->set('account_data', ACCOUNT_DATA);
$tpl->set('profile_data', PROFILE_DATA);
$tpl->set('security', SECURITY);
// ********************************************** //

$tpl->set('reg_option_bornyear', getBornYear());
$tpl->set('reg_sex_female', REG_SEX_FEMALE);
$tpl->set('reg_sex_male', REG_SEX_MALE);
$tpl->set('reg_option_lang', getAvailLangs());
$tpl->set('reg_option_country', getAvailCountries());
$speed = getNetSpeed();
$tpl->set('reg_option_upspeed', $speed);
$tpl->set('reg_option_downspeed', $speed);
$tpl->set('reg_option_isp', getISP());

$tpl->set('reg_secimage', "<img id=\"siimage\" align=\"left\" style=\"padding-right: 5px; border: 0\" src=\"classes/secimage/securimage_show.php?sid=". genrandom() ."\">");

// ********************************************** //
$content=$tpl->fetch($style_path. 'html/reg.tpl');
}
else {
$tpl->set('reg_closed', REG_CLOSED);	
$content=$tpl->fetch($style_path. 'html/regclosed.tpl');
}

$tpl->set('block_content', $content);

//}
$content=$tpl->fetch($style_path. 'html/block.tpl');
}
?>