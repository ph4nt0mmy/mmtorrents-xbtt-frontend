<!-- PROFILE EDIT -->
<script type="text/javascript" src="js/_checkprofile.js"></script>
<script type="text/javascript" src="lang/<tag:lang />.lang.js"></script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	theme_advanced_buttons1 : "bold, italic, underline, forecolor, fontsizeselect, |, strikethrough, blockquote, undo, redo, |, link, unlink, image, emotions, code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    theme_advanced_resize_horizontal : false,
    forced_root_block : false,
	force_br_newlines : true,
	force_p_newlines : false,    
	convert_newlines_to_brs : true,
	remove_linebreaks : false,
	apply_source_formatting : true,
	convert_fonts_to_spans : false,
	entity_encoding : "raw",
	plugins : "bbcode, emotions",
	language : '<tag:lang />',
	theme_advanced_buttons3_add : "fullpage"
});
</script>

<form action=./ method="post" onsubmit="return _checkprofile(this);">
<input type=hidden name="mpage" value="usercp">
<input type=hidden name="sub" value="profile">
<input type=hidden name="do" value="save">

<FIELDSET class="profile_edit">
	<fieldset id="notchangeable_field" class="profile">
		<legend><tag:profile_notchangeable /></legend>

	<p id="register">
		<span class="left"><tag:reg_username />:</span>
		<span class="right"><input type=text name="username" class="readonly" value="<tag:username_value />" readonly></span>
		<span class="left"><tag:profile_idlevel />:</span>
		<span class="right"><input type=text name="idlevel" class="readonly" value="<tag:idlevel_value />" readonly></span>
		<span class="left"><tag:reg_email />:</span>
		<span class="right"><input type=text name="email" class="readonly" value="<tag:email_value />" readonly></span>
		<span class="left"><tag:profile_credits />:</span>
		<span class="right"><input type=text name="credits" class="readonly" value="<tag:credits_value />" readonly></span>
		<span class="left"><tag:profile_downloadslots />:</span>
		<span class="right"><input type=text name="downloadslots" class="readonly" value="<tag:downloadslots_value />" readonly></span>
		<span class="left"><tag:profile_uploadslots />:</span>
		<span class="right"><input type=text name="uploadslots" class="readonly" value="<tag:uploadslots_value />" readonly></span>
		<span class="left"><tag:profile_passkey />:</span>
		<span class="right"><input type=text name="passkey" class="readonly" value="<tag:passkey_value />" readonly></span>
	</p>
	
	</fieldset>
</FIELDSET>

<FIELDSET class="profile_edit">
	<fieldset id="changeable_field" class="profile">
		<legend><tag:profile_changeable /></legend>

	<p id="register">
		<span class="left"><tag:reg_bornyear />:</span>
		<span class="right">
			<select name="bornyear">
				<option><tag:reg_choose /></option>
				<tag:reg_option_bornyear />
			</select>
		</span>
		<span class="left"><tag:reg_sex />:</span>
		<span class="right">
			<select name="sex">
				<option><tag:reg_choose /></option>
				<tag:reg_option_sex />
			</select>
		</span>
		<span class="left"><tag:reg_lang />:</span>
		<span class="right">
			<select name="lang">
				<option><tag:reg_choose /></option>
				<tag:reg_option_lang />
			</select>
		</span>
		<span class="left"><tag:reg_country />:</span>
		<span class="right">
			<select name="country">
				<option><tag:reg_choose /></option>
				<tag:reg_option_country />
			</select>
		</span>
		<span class="left"><tag:profile_style />:</span>
		<span class="right">
			<select name="style">
				<option><tag:reg_choose /></option>
				<tag:profile_option_style />
			</select>
		</span>
		<span class="left"><tag:reg_upspeed />:</span>
		<span class="right">
			<select name="upspeed">
				<option><tag:reg_choose /></option>
				<tag:reg_option_upspeed />
			</select>
		</span>
		<span class="left"><tag:reg_downspeed />:</span>
		<span class="right">
			<select name="downspeed">
				<option><tag:reg_choose /></option>
				<tag:reg_option_downspeed />
			</select>
		</span>
		<span class="left"><tag:reg_isp />:</span>
		<span class="right">
			<select name="isp">
				<option><tag:reg_choose /></option>
				<tag:reg_option_isp />
			</select>
		</span>
		<span class="left"><tag:profile_machineon />:</span>
		<span class="right">
			<input type=text name="machineon" value="<tag:machineon_value />" style="width: 417px; #width: 412px;" autocomplete="off">
		</span>
		<span class="left"><tag:profile_avatar />:</span>
		<span class="right">
			<input type=text name="avatar" value="<tag:avatar_value />" style="width: 417px; #width: 412px;" autocomplete="off">
		</span>
		<span class="left"><tag:profile_signature />:</span>
		<span class="right">
			<input type=text name="signature" value="<tag:signature_value />" style="width: 417px; #width: 412px;">
		</span>
		<span class="left"><tag:profile_introduction />:</span>
		<span class="right">
			<TEXTAREA NAME="introduction"><tag:introduction_value /></TEXTAREA>
		</span>
	</p>
	
	</fieldset>
</FIELDSET>

<FIELDSET class="profile_edit">
	<fieldset id="passkey_field" class="profile">
		<legend><tag:profile_passkeychange_description /></legend>

	<p id="register">
		<span class="left"><tag:profile_passkeychange />:</span>
		<span class="right"><input type=checkbox name="changepasskey"></span>
	</p>
	
	</fieldset>
</FIELDSET>

<FIELDSET class="profile_edit">
	<fieldset id="passwd_field" class="profile">
		<legend><tag:profile_passwdchange /></legend>

	<p id="register">
		<span class="left"><tag:reg_userpwd />:</span>
		<span class="right"><input type=password name="password" autocomplete="off"></span>
		<span class="left"><tag:reg_userpwdagain />:</span>
		<span class="right"><input type=password name="passwordagain" autocomplete="off"></span>
	</p>

	</fieldset>
</FIELDSET>

<FIELDSET class="profile_edit">
	<div id="reg_submit">
		<input type=submit value="<tag:profile_submitbutton />">
	</div>
</FIELDSET>

</form>
<br>&nbsp;
<!-- END OF PROFILE EDIT -->