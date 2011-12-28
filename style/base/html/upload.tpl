<script type="text/javascript" src="lang/<tag:lang />.lang.js"></script>
<script type="text/javascript" src="js/_ajax.new.js"></script>
<script type="text/javascript" src="3rdparty/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/upload.js"></script>

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
	force_br_newlines : false,
	force_p_newlines : false,    
	convert_newlines_to_brs : false,
	remove_linebreaks : false,
	apply_source_formatting : true,
	convert_fonts_to_spans : true,
	entity_encoding : "raw",
	plugins : "emotions",
	language : '<tag:lang />',
	theme_advanced_buttons3_add : "fullpage"
});
</script>

<form action="./" method="post" enctype="multipart/form-data" onsubmit="return checkupload(this);">
	<input type=hidden name="mpage" value="upload">
	<input type=hidden name="action" value="takeupload">

<fieldset class="upload">	
	<fieldset class="upload_field">
		<legend><tag:data /></legend>
		<span class="upload_left"><tag:torrent />:</span>
		<span class="upload_right"><input id="torrent" type="file" name="torrent" size="40"></span>
		<span class="upload_left"><tag:cover />:</span>
		<span class="upload_right"><input id="cover" type="file" name="cover" size="40"></span>
		<span class="upload_left"><tag:nfo />:</span>
		<span class="upload_right"><input id="nfo" type="file" name="nfo" size="40"></span>
		<span class="upload_left"><tag:filename />:</span>
		<span class="upload_right"><input id="filename" type="text" name="filename" size="40"></span>
		<span class="upload_left"><tag:seedtime />:</span>
		<span class="upload_right"><input id="seedtime" type="text" name="seedtime" size="40"></span>
		<span class="upload_left"><tag:seedspeed />:</span>
		<span class="upload_right">
			<select id="seedspeed" name="seedspeed">
				<option value="choose" selected><tag:choose /></option>
				<tag:seedspeeds />
			</select>
		</span>
		<span class="upload_left"><tag:language />:</span>
		<span class="upload_right">
			<select id="language" name="language">
				<option value="choose" selected><tag:choose /></option>
				<tag:languages />
			</select>
		</span>
		<span class="upload_left"><tag:category />:</span>
		<span class="upload_right">
			<select id="category" name="category">
				<option value="choose" selected><tag:choose /></option>
				<tag:categories />
			</select>
		</span>
		<span class="upload_left"><tag:anonymous />:</span>
		<span class="upload_right"><tag:no /><input type="radio" name="anonymous" value="false" checked />&nbsp;&nbsp;<tag:yes /><input type="radio" name="anonymous" value="true" /></span>
	</fieldset>
	<fieldset id='rules' class="upload_field" style="display: none;">
		<legend><tag:upload_rules /></legend>
	</fieldset>
	<fieldset class="upload_field">
		<legend><tag:description /></legend>
		<textarea name="description" class="description"></textarea>
	</fieldset>
	
	<input type="submit" id="submitReg" value="<tag:submitbutton />">
</fieldset>

</form>