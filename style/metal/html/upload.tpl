<!-- TORRENT UPLOAD -->

<script type="text/javascript" src="lang/<tag:lang />.lang.js"></script>
<script type="text/javascript" src="js/_ajax.new.js"></script>
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

var handlecategory = function(response) {
	
	var respArr 			= response.split('&sprt;');
    var respType 			= respArr[0].toLowerCase();
    var respCategory  		= respArr[1];
    var respCategoryName  	= respArr[2];
    var respMsg  			= respArr[3];
    var legendstr1			= '<legend><tag:upload_rules />: ';
    var legendstr2			= '</legend>';
    
    //alert('iéz');

	window.document.getElementById('rules').style.display="block";
	//window.document.getElementById('ruleslegend').style.display="block";

	if (respType == 'success') {
		window.document.getElementById('rules').innerHTML=legendstr1 + respCategoryName + legendstr2 + respMsg;
	}
	else window.document.getElementById('rules').innerHTML=legendstr1 + legendstr2 + JS_ERROR;
	
	return false;
}

function showcategory(categoryid) {
	
	var strDomain	= '';
	var ajax 		= new Ajax();
	
	var strtopost = strDomain +  'inc/upload.ajax.php?action=uploadrules&categoryid=' + categoryid; // + '&language=' + language;
	//alert(strtopost);
	ajax.doGet(strtopost, handlecategory,'text');
	return false;
}

function checkupload(form) {
	
	
	return true;
}

</script>


<form action="./" method="post" ENCTYPE="multipart/form-data" onsubmit="return checkupload(this);">
	<input type=hidden name="mpage" value="upload">
	<input type=hidden name="action" value="takeupload">

<FIELDSET class="upload">	
	<fieldset class="upload_field">
		<legend><tag:data /></legend>
		<span class="upload_left"><tag:torrent />:</span>
		<span class="upload_right"><INPUT id="torrent" TYPE="file" NAME="torrent" size="40"></span>
		<span class="upload_left"><tag:cover />:</span>
		<span class="upload_right"><INPUT id="cover" TYPE="file" NAME="cover" size="40"></span>
		<span class="upload_left"><tag:nfo />:</span>
		<span class="upload_right"><INPUT id="nfo" TYPE="file" NAME="nfo" size="40"></span>
		<span class="upload_left"><tag:filename />:</span>
		<span class="upload_right"><INPUT id="filename" TYPE="text" NAME="filename" size="40"></span>
		<span class="upload_left"><tag:seedtime />:</span>
		<span class="upload_right"><INPUT id="seedtime" TYPE="text" NAME="seedtime" size="40"></span>
		<span class="upload_left"><tag:seedspeed />:</span>
		<span class="upload_right">
			<select id="seedspeed" NAME="seedspeed">
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
		<span class="upload_right"><tag:no /><INPUT TYPE="radio" name="anonymous" value="false" checked />&nbsp;&nbsp;<tag:yes /><INPUT TYPE="radio" name="anonymous" value="true" /></span>
	</fieldset>
	<fieldset id='rules' class="upload_field" style="display: none;">
		<legend><tag:upload_rules /></legend>
	</fieldset>
	<fieldset class="upload_field">
		<legend><tag:description /></legend>
		<TEXTAREA NAME="description" class="description"></TEXTAREA>
	</fieldset>
	
	<input type="submit" id="submitReg" value="<tag:submitbutton />">
</FIELDSET>

</form>

<!-- END OF TORRENT UPLOAD -->