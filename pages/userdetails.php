<?php
// ******************* USERDETAILS  **************** //

if ( isset($_GET["uid"]) && $_GET["uid"] != "" )
	$uid = mysql_real_escape_string($_GET["uid"]);
else $uid = $CURUSER["uid"];

$sql = 'SELECT users.username, users.joined, users.lastconnect, users.uploaded, users.downloaded, users.credits, users.id_level, users.bornyear, users.sex, users.language, users.country, users.upspeed, users.downspeed,users.machineon, users.introduction, users.signature, users.avatar, users.style, users_level.level, users_level.color FROM users LEFT JOIN users_level ON users_level.group=users.id_level WHERE users.uid='. $uid. ' LIMIT 1';
$row = $db->query($sql);
$result = $db->fetch_array($row);

$tpl->set('block_header', BLOCK_USERDETAILS. ": ". $result["username"]);
$tpl->set('userdetails_avatar', ($result['avatar'] != '' ? $result['avatar'] : $style_path.'images/anonym.jpg'));

$tpl->set('userdetails_username', REG_USERNAME);
$tpl->set('userdetails_idlevel', PROFILE_IDLEVEL);
$tpl->set('userdetails_joined', JOINED);
$tpl->set('userdetails_lastconnect', LASTCONNECT);
$tpl->set('userdetails_uploaded', USER_UPLOADED);
$tpl->set('userdetails_downloaded', USER_DOWNLOADED);
$tpl->set('userdetails_ratio', USER_RATIO);
$tpl->set('userdetails_credits', USER_CREDITS);
$tpl->set('userdetails_upspeed', UPSPEED);
$tpl->set('userdetails_downspeed', DOWNSPEED);
$tpl->set('userdetails_machineon', MACHINEON);
$tpl->set('userdetails_sex', SEX);
$tpl->set('userdetails_bornyear', BORNYEAR);
$tpl->set('userdetails_lang', REG_LANG);
$tpl->set('userdetails_country', REG_COUNTRY);
$tpl->set('userdetails_style', PROFILE_STYLE);
$tpl->set('userdetails_introduction', INTRODUCTION);
$tpl->set('userdetails_signature', SIGNATURE);

$tpl->set('userdetails_username_value', $result['username']); //printUsername
$tpl->set('userdetails_idlevel_value', constant($result['level']));
$tpl->set('userdetails_joined_value', $result['joined']);
$tpl->set('userdetails_lastconnect_value', $result['lastconnect']);
$tpl->set('userdetails_uploaded_value', format_size($result['uploaded']));
$tpl->set('userdetails_downloaded_value', format_size($result['downloaded']));
$tpl->set('userdetails_ratio_value', format_ratio($result["uploaded"], $result["downloaded"]));
$tpl->set('userdetails_credits_value', $result['credits']);
$tpl->set('userdetails_upspeed_value', $result['upspeed']);
$tpl->set('userdetails_downspeed_value', $result['downspeed']);
$tpl->set('userdetails_machineon_value', $result['machineon']);
$tpl->set('userdetails_sex_value', constant(strtoupper($result['sex'])));
$tpl->set('userdetails_bornyear_value', $result['bornyear']);
$tpl->set('userdetails_lang_value', getLangName($result['language']));
$tpl->set('userdetails_country_value', getCountryName($result['country']));
$tpl->set('userdetails_style_value', getStyleName($result['style']));
$tpl->set('userdetails_introduction_value', formatBBcode($result['introduction']));
$tpl->set('userdetails_signature_value', formatBBcode($result['signature']));

$block_content .= $tpl->fetch($style_path. 'html/userdetails.tpl');
$tpl->set('block_content', $block_content);
$content=$content.$tpl->fetch($style_path. 'html/block.tpl');
// ******************* END OF USERDETAILS  **************** //
?>