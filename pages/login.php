<?php
// ******************* LOGIN **************** //
$tpl->set('name', USER_NAME);
$tpl->set('passwd', USER_PASSWORD);
$tpl->set('login', LOGIN);
if ( $config['openreg'] == true ) 
   {
	$tpl->set('registration', REGISTRATION);
	$tpl->set('pipe', '|');
   }
else {
		$tpl->set('registration', "");
		$tpl->set('pipe', '');
	 }
$tpl->set('lostpasswd', LOSTPASSWORD);

$tpl->set('lang', $site_lang);
echo $tpl->fetch($style_path. 'html/login.tpl');

?>