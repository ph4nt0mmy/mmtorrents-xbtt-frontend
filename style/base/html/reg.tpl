<script type="text/javascript" src="js/_ajax.new.js"></script>
<script type="text/javascript" src="js/reg.js"></script>

<form method="post" onsubmit="postregister();">
<input type=hidden name="mpage" value="reg">
<input type=hidden name="act" value="signup">
<input type=hidden name="ref" value="<tag:reg_referrer />">
<input type=hidden name="invitedby" value="<tag:reg_invitedby />">

<div id="regme" style="margin: 0; padding: 0;">

<fieldset class="register">
<fieldset style="width: 824px;">
	<legend><tag:account_data /></legend>
<p id="register">
  <span class="left"><tag:reg_username />:</span>
  <span class="right"><input type=text id="username" name="username" onchange="getstatus('status_username');">
	<span id="status_username" class="status"></span>
  </span>
  <span class="left"><tag:reg_email />:</span>
  <span class="right"><input type=text id="email" name="email" onchange="getstatus('status_email');">
	<span id="status_email" class="status"></span>
  </span>
  <span class="left"><tag:reg_userpwd />:</span>
  <span class="right"><input type="password" id="upassword" name="password" onchange="getstatus('status_password');">
	<span id="status_password" class="status"></span>
  </span>
  <span class="left"><tag:reg_userpwdagain />:</span>
  <span class="right"><input type=password id="upasswordagain" name="passwordagain" onchange="getstatus('status_passwordagain');">
	<span id="status_passwordagain" class="status"></span>
  </span>
  <span class="left"><tag:reg_readrules />:</span>
  <span class="right">
   <select id="rules" name="rules" onchange="getstatus('status_rules');">
    <option value="choose" selected><tag:reg_choose /></option>
    <option value="readno"><tag:reg_readno /></option>
    <option value="readyes"><tag:reg_readyes /></option>
   </select>
   <span id="status_rules" class="status"></span>
  </span>
</p>
</fieldset>
</fieldset>

<fieldset class="register">
<fieldset style="width: 824px;">
	<legend><tag:profile_data /></legend>
<p id="register">
  <span class="left"><tag:reg_bornyear />:</span>
  <span class="right">
   <select id="bornyear" name="bornyear" onchange="getstatus('status_bornyear');">
    <option value="choose"><tag:reg_choose /></option>
    <tag:reg_option_bornyear />
   </select>
   <span id="status_bornyear" class="status"></span>
  </span>
  <span class="left"><tag:reg_sex />:</span>
  <span class="right">
   <select id="sex" name="sex" onchange="getstatus('status_sex');">
    <option value="choose"><tag:reg_choose /></option>
    <option value="female"><tag:reg_sex_female /></option>
    <option value="male"><tag:reg_sex_male /></option>
   </select>
   <span id="status_sex" class="status"></span>
  </span>
  <span class="left"><tag:reg_lang />:</span>
  <span class="right">
   <select id="lang" name="lang" onchange="getstatus('status_lang');">
    <option value="choose"><tag:reg_choose /></option>
    <tag:reg_option_lang />
   </select>
   <span id="status_lang" class="status"></span>
  </span>
  <span class="left"><tag:reg_country />:</span>
  <span class="right">
   <select id="country" name="country" onchange="getstatus('status_country');">
    <option value="choose"><tag:reg_choose /></option>
    <tag:reg_option_country />
   </select>
   <span id="status_country" class="status"></span>
  </span>
  <span class="left"><tag:reg_upspeed />:</span>
  <span class="right">
   <select id="upspeed" name="upspeed" onchange="getstatus('status_upspeed');">
    <option value="choose"><tag:reg_choose /></option>
    <tag:reg_option_upspeed />
   </select>
   <span id="status_upspeed" class="status"></span>
  </span>
  <span class="left"><tag:reg_downspeed />:</span>
  <span class="right">
   <select id="downspeed" name="downspeed" onchange="getstatus('status_downspeed');">
    <option value="choose"><tag:reg_choose /></option>
    <tag:reg_option_downspeed />
   </select>
   <span id="status_downspeed" class="status"></span>
  </span>
  <span class="left"><tag:reg_isp />:</span>
  <span class="right">
   <select id="isp" name="isp" onchange="getstatus('status_isp');">
    <option value="choose"><tag:reg_choose /></option>
    <tag:reg_option_isp />
   </select>
   <span id="status_isp" class="status"></span>
  </span> 
 </p>
</fieldset>
</fieldset>  

<fieldset class="register">
<fieldset style="width: 824px;">
	<legend><tag:security /></legend>
 <div>
    <tag:reg_picdescription />
 </div>

<p id="register">
  <span class="left"><tag:reg_secimage /></span>
  <span class="right"><input type=text id="captcha_code" name="captcha_code" onchange="getstatus('status_captcha_code');">
   <span id="status_captcha_code" class="status"></span>
  </span>
  </p>
</fieldset>  
</fieldset>
  
 <div id="reg_submit">
  <input type="submit" id="submitReg" value="<tag:reg_submitbutton />" onClick="postregister(); return false;">
 </div>
 
</div>

<div id="regprompt" style="display: none; padding: 12px 0px 2px 6px;">

</div>
</form>
<br />&nbsp;