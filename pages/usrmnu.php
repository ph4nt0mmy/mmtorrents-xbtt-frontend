<?php
// ******************* USER MENU **************** //

$sql = 'SELECT uid, uploaded, downloaded, credits FROM users WHERE uid=\''. $_COOKIE["mmuid"]. '\' AND password=\''. $_COOKIE["mmpass"]. '\' AND disabled=\'no\'';
$res = $db->query($sql); 
$row = $db->fetch_array($res);

$tpl->set('tip_admincp', TIP_ADMINCP);
$tpl->set('tip_usercp', TIP_USERCP);
$tpl->set('tip_profile', TIP_PROFILE);
$tpl->set('tip_messages', TIP_MESSAGES);
$tpl->set('tip_mytorrents', TIP_MYTORRENTS);
$tpl->set('tip_credits', TIP_CREDITS);
$tpl->set('tip_logout', TIP_LOGOUT);

$tpl->set('user_welcome', USER_WELCOME);
$tpl->set('user_name', print_user($row["uid"])); //print_user() függvény!
$tpl->set('uploaded', USER_UPLOADED. ': '. format_size($row["uploaded"]));
$tpl->set('downloaded', USER_DOWNLOADED. ': '. format_size($row["downloaded"]));
$tpl->set('ratio', USER_RATIO. ': '. format_ratio($row["uploaded"], $row["downloaded"]));
$tpl->set('credits', USER_CREDITS. ': '. $row["credits"]);
echo $tpl->fetch($style_path. 'html/usrmnu.tpl');  //a júzer sajátmenüje (a barna rész)
// ******************* USER MENU END **************** //
?>
