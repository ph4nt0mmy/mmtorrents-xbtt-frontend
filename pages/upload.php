<?php
// ******************* TORRENT UPLOAD  **************** //
$block_content = '';
$tpl->set('block_header', BLOCK_UPLOAD);

if ( isset($_POST['action']) && $_POST['action']=='takeupload' ) {
	
require_once('classes/class.lightbenc.php');
require_once('classes/class.imgupload.php');

if ( !is_uploaded_file($_FILES["torrent"]["tmp_name"]) ) {
	errorMsg(ERR_UPLOADED_FILE);
	printFooter();
	die();
}

$length=filesize($_FILES["torrent"]["tmp_name"]);
if ( !$length ) {
	errorMsg(ERR_UPLOADED_FILE_LENGTH_ZERO);
	printFooter();
	die();
}
elseif ( $length > $config['maxtorrentsize'] ) {
	errorMsg(ERR_UPLOADED_FILE_LENGTH_TOOBIG);
	printFooter();
	die();
}

/*
if ( !isset($_POST["filename"]) || $_POST["filename"]=="" || !isset($_POST["seedtime"]) || $_POST["seedtime"]=="" || !isset($_POST["seedspeed"]) || $_POST["seedspeed"]=="" || !isset($_POST["language"]) || $_POST["language"]=="" || !isset($_POST["category"]) || $_POST["category"]=="" || !isset($_POST["anonymous"]) || $_POST["anonymous"]=="" || !isset($_POST["description"]) || $_POST["description"]=="" ) {
		
		errorMsg(ERR_MISSING_DATA);
		printFooter();
		die();
}
*/

$alltorrent 	= $_FILES["torrent"]["tmp_name"];
$cover 			= '';
$filename 		= mysql_real_escape_string($_POST["filename"]);
$seedtime 		= mysql_real_escape_string($_POST["seedtime"]);
$seedspeed 		= mysql_real_escape_string($_POST["seedspeed"]);
$language 		= mysql_real_escape_string($_POST["language"]);
$category 		= mysql_real_escape_string($_POST["category"]);
$anonymous 		= mysql_real_escape_string($_POST["anonymous"]);
$description 	= mysql_real_escape_string($_POST["description"]);
$description 	= strip_tags($description, "<p><span><a><img>");

$dict 			= bdecode_file($alltorrent);
// change announce url
$dict['announce'] 		= $config['announceurl'];
$dict['announce-list'] 	= '';
$dict['source'] 		= $config['baseurl'];
$dict['comment'] 		= $config['baseurl']; 
// add private tracker flag
$dict['info']['private'] = 1;
// compute infohash
$infohash 		= sha1(bencode($dict["info"]));

if (isset($dict["info"]) && $dict["info"]) $upfile=$dict["info"];
    else $upfile = 0;

if (isset($upfile["length"]))
{
  $size = floatval($upfile["length"]);
}
else if (isset($upfile["files"]))
     {
         $size=0;
         foreach ($upfile["files"] as $file)
                 {
                 $size+=floatval($file["length"]);
                 }
     }
else
    $size = "0";


$sql = 'SELECT fid FROM torrents WHERE info_hash=\''. $infohash. '\' LIMIT 1';
$db->query($sql);

if ( $db->numRows() == 1 ) { 
	errorMsg(ERR_TORRENT_ALREADY_UPLOADED);
	printFooter();
	die();
	}

$url = $config['torrentsdir'] . "/" . $infohash . ".btf";
move_uploaded_file($_FILES["torrent"]["tmp_name"] , $url) or die(ERR_MOVING_TORR);
// recreate the torrent file
$alltorrent		= bencode($dict);
$fd 			= fopen($config['torrentsdir'] . "/" . $infohash . ".btf", "rb+");
fwrite($fd,$alltorrent);
fclose($fd);


/* upload cover */
if ( is_uploaded_file($_FILES["cover"]["tmp_name"]) ) {

$dir_dest 	= $config['coversdir'];
$handle 	= new Upload($_FILES["cover"]);

if ($handle->uploaded) {

	$handle->image_resize             = true;
    $handle->image_ratio_y            = true;
    $handle->image_x 				  = $config['cover_x'];
	//$handle->image_watermark          = "data/images/watermark.png";
	//$handle->image_watermark_position = 'BR'; //bottom right
			
	$handle->file_name_body_add = '';
	$handle->file_max_size 		= $config['maxcoversize'];
	$handle->allowed 			= array('image/jpeg', 'image/gif', 'image/png');
	$handle->image_convert 		= 'jpg';
	$handle->file_new_name_body = $infohash;
	$handle->file_auto_rename	= false;
	$handle->file_overwrite		= true;

    $handle->Process($dir_dest);

    if ($handle->processed) {
		$block_content .= SUCCESS_COVER_UPLOAD;
		$cover = $config['coversdir']. '/'. $infohash. '.jpg';
		
    } 
    else {
           // one error occured
           $block_content .= ERROR . $handle->error . '';
    }

   }
   else {
            $block_content .= ERROR . $handle->error . '';
        }
}
/* end of upload cover */

/* upload nfo */
if(is_uploaded_file($_FILES['nfo']['tmp_name'])) {  
$nfofile 		= $_FILES['nfo'];
$nfo_types 		= $nfoFileTypes;
$nfofilename 	= $nfofile['tmp_name'];
$nfo_file_name 	= $nfofile['name'];
$nfo_file_size 	= $_FILES["nfo"]["size"];
$limit 			= $config['maxnfosize'];

if ($nfofile['size'] > $limit){
       $var = $limit / 1024;
	   $var1 = $nfo_file_size / 1024;
	   $res = round($var, 1); 
       $res1 = round($var1, 1); 
       errorMsg(ERR_TOO_BIG_NFOFILE);
	   printFooter();
	   die();
}

$ext = strrchr($nfo_file_name,'.');
if(!in_array(strtolower($ext),$nfo_types)) {
             errorMsg(ERR_NOT_NFOFILE);
			 printFooter();
			 die();
}
if (!is_uploaded_file($nfofilename))  {
             errorMsg(ERR_FAILED_NFOFILE_UPLOAD);
			 printFooter();
			 die();
}
//else { echo"<center>$nfo_file_name sikeresen feltöltve!</center><br />"; }

$nfo = mysql_real_escape_string(str_replace("\x0d\x0d\x0a", "\x0d\x0a", file_get_contents($nfofilename)));
}
else {
$nfo = "";
}
/* end of upload nfo */

$sql = 'INSERT INTO torrents (info_hash, filename, url, added, size, description, category, language, uploader, anonymous, nfo, requested, cover_url, seedtime, seedspeed) VALUES (\''. $infohash.'\',\''. $filename .'\',\''. $url . '\',NOW(),\''. $size .'\',\''. $description .'\',\''. $category .'\',\''. $language .'\',\''. $CURUSER['uid'] .'\',\''. $anonymous .'\',\''. $nfo .'\', \'false\',\''. $cover .'\',\''. $seedtime .'\',\''. $seedspeed .'\')';
$db->execute($sql);

$sql 	= 'SELECT fid FROM torrents WHERE info_hash=\''. $infohash .'\' LIMIT 1';
$result = $db->query($sql);
$row 	= $db->fetch_array($result);

$block_content .= $infohash.'<br />';
$block_content .= "<a href=\"/gettorrent.php?fid=". $row["fid"] ."\">LETÖLTÉS</a><br />";

//$block_content = "Save torrent..";
}
else {
$tpl->set('choose', CHOOSE);
$tpl->set('categories', getAvailCategories());
$tpl->set('languages', getAvailLangs());
$tpl->set('seedspeeds', getNetSpeed());

$tpl->set('data', DATA);
$tpl->set('torrent', TORRENT);
$tpl->set('cover', COVER);
$tpl->set('nfo', NFO);
$tpl->set('filename', FILENAME);
$tpl->set('seedtime', SEEDTIME);
$tpl->set('seedspeed', SEEDSPEED);
$tpl->set('anonymous', ANONYMOUS);
$tpl->set('no', NO);
$tpl->set('yes', YES);
$tpl->set('language', LANGUAGE);
$tpl->set('category', CATEGORY);
$tpl->set('upload_rules', UPLOAD_RULES);
$tpl->set('description', DESCRIPTION);
$tpl->set('submitbutton', SUBMIT);


$block_content .= $tpl->fetch($style_path. 'html/upload.tpl');
}
$tpl->set('block_content', $block_content);
$content=$content.$tpl->fetch($style_path. 'html/block.tpl');
// ******************* END OF TORRENT UPLOAD  **************** //
?>