<?php
header("Content-Type: text/html; charset=UTF-8");
require_once('../inc/config.inc.php');
require_once('../classes/class.mysql.php');
require_once('../classes/class.main.php');

$db = new DB($config['database'], $config['server'], $config['user'], $config['pass']);
$sep='&sprt;';

if ( isset($_GET['lang']) && $_GET['lang']!='' && checkLang($_GET['lang']) ) $site_lang = $_GET['lang'];
     else $site_lang = 'hu';
require_once('../lang/'.$site_lang.'.lang.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HTML>
 <HEAD>
  <TITLE> MMv6&alpha; | mmtorrents | Kategória szabályok (tmp)</TITLE>
  <link rel="stylesheet" type="text/css" href="style/base/style.css" media="all"/>
  <link rel="icon" type="image/png" href="style/base/images/favicon.png" />
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <META NAME="Author" CONTENT="ph4nt0mmy">

  <META NAME="Keywords" CONTENT="magyar torrent oldal letöltés film">
  <META NAME="Description" CONTENT="mmtorrents - magyar torrent oldal - torrent site">
 </HEAD>
 <BODY>

<script type="text/javascript" src="../lang/hu.lang.js"></script>
<script type="text/javascript" src="../js/_ajax.new.js"></script>
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	theme_advanced_buttons1 : "bold, italic, underline, forecolor, fontsizeselect, |, strikethrough, blockquote, undo, redo, |, link, unlink, image, emotions, bullist, code",
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
	plugins : "emotions",
	language : 'hu',
	theme_advanced_buttons3_add : "fullpage"
});

var handlecategory = function(response) {
	
	var respArr 			= response.split('&sprt;');
    var respType 			= respArr[0].toLowerCase();
    var respCategory  		= respArr[1];
    var respCategoryName  	= respArr[2];
    var respMsg  			= respArr[3];
    var legendstr1			= '<legend>Feltöltési szabályzat: ';
    var legendstr2			= '</legend>';
    var ed = tinyMCE.get('rules');
    
    //alert('iéz');

	//window.document.getElementById('category').style.display="block";
	//window.document.getElementById('ruleslegend').style.display="block";

	if (respType == 'success') {
		//alert(respMsg);
		//window.document.getElementById('rules').value = respMsg;
		ed.setContent(respMsg);
	}
	else window.document.getElementById('rules').value = 'Szarság van';
	
	return false;
}

function showcategory(categoryid) {
	
	var strDomain	= '';
	var ajax 		= new Ajax();
	
	if ( !categoryid ) {
		var selected 	= window.document.getElementById('category').selectedIndex;
		//alert(selected);
		var cid 		= window.document.getElementById('category')[selected].value; 
		//alert(cid);
		var categoryid 	= cid;
	}
	if ( !language ) {
		selected 		= window.document.getElementById('language').selectedIndex;
		var language 	= window.document.getElementById('language')[selected].value; 
		//alert(language);
	}
	
	var strtopost = strDomain +  '../inc/upload.ajax.php?action=uploadrules&categoryid=' + categoryid + '&language=' + language;
	//alert(strtopost);
	ajax.doGet(strtopost, handlecategory,'text');
	return false;
}

</script>

<form action="catrules.php" method="get" ENCTYPE="multipart/form-data">
	<input type=hidden name="action" value="save">

<?php

if ( isset($_GET['action']) && $_GET['action'] == 'save' )
   {
	   $sql = 'SELECT id FROM category_rules WHERE category='. $_GET['category'] .' AND language=\''. $_GET['language'] .'\'';
	   //echo $sql. '<br />';
	   $res = $db->query($sql);
	   if ( $db->numRows() > 0 ) {
			$sql = 'UPDATE category_rules SET rules=\''. $_GET['rules']. '\' WHERE category='. $_GET['category'] .' AND language=\''. $_GET['language'] .'\'';
	   }
	   else {
			$sql = 'INSERT INTO category_rules (category, language) VALUES ('. $_GET['category'] .', \''. $_GET['language'] .'\')';
	   }
	   $db->execute($sql);
   }

echo "Kategória: <select name=category id=category><option>Válassz</option>". getAvailCategories('', 'hu'). "</select>";
echo "<br />";
echo "Nyelv: <select name=language id=language><option>Válassz</option>". getAvailLangs('', 'onclick="showcategory();"'). "</select>";
echo "<br /><br />";
?>

<TEXTAREA NAME="rules" id="rules" style="width: 846px; height: 300px;"></TEXTAREA>
<br /><br />

<input type="submit" value="Mentés">

</form>
<?php

$db->close();
?>