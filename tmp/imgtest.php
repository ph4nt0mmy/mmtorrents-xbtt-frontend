<?php
/**
 * Function for converting Text to Image.
 * Kip CENTURY.TTF file in same folder.
 *
 * @author Taslim Mazumder Sohel
 * @deprecated 1.0 - 2007/08/03
 *
 */
     //Example call.
    //$str = "New life in programming.\nNext Line of Image.\nLine Number 3\n" .
    //    "This is line numbet 4\nLine number 5\nYou can write as you want.";   
    header("Content-type: image/gif");   
    //imagegif(imagettfJustifytext($str,"../classes/secimage/elephant.ttf",2));
    //End of example.
    
    require_once('../inc/config.inc.php');
	require_once('../classes/class.mysql.php');
	require_once('../classes/class.main.php');
	$db = new DB($config['database'], $config['server'], $config['user'], $config['pass']);
	$db->query("SET NAMES utf8");
	
	$sql = "SELECT nfo FROM torrents WHERE fid=5 LIMIT 1";
	$res=$db->query($sql);
	$str=$db->fetch_array($res);
	
	imagegif(imagettfJustifytext($str['nfo'],"../data/fonts/cour.ttf",0));
	
   
   
    /**
     * @name                    : makeImageF
     *
     * Function for create image from text with selected font. Justify text in image (0-Left, 1-Right, 2-Center).
     *
     * @param String $text     : String to convert into the Image.
     * @param String $font     : Font name of the text. Kip font file in same folder.
     * @param int    $W        : Width of the Image.
     * @param int    $H        : Hight of the Image.
     * @param int    $X        : x-coordinate of the text into the image.
     * @param int    $Y        : y-coordinate of the text into the image.
     * @param int    $fsize    : Font size of text.
     * @param array  $color       : RGB color array for text color.
     * @param array  $bgcolor  : RGB color array for background.
     *
     */
    function imagettfJustifytext($text, $font="CENTURY.TTF", $Justify=2, $W=0, $H=0, $X=0, $Y=0, $fsize=12, $color=array(0x0,0x0,0x0), $bgcolor=array(0xFF,0xFF,0xFF)){
       
        $angle = 0;
        $L_R_C = $Justify;
        $_bx = imageTTFBbox($fsize,0,$font,$text);
		
		$W = 600; //TODO: analyse $text and insert a \n after every X char is there isn't any \n. X = number of chars fit in 600px width
        $W = ($W==0)?abs($_bx[2]-$_bx[0]):$W;    //If Height not initialized by programmer then it will detect and assign perfect height.
        $H = ($H==0)?abs($_bx[5]-$_bx[3]):$H;    //If Width not initialized by programmer then it will detect and assign perfect width.
        $H = $H+10;

        $im = @imagecreate($W, $H)
            or die("Cannot Initialize new GD image stream");
           
           
        $background_color = imagecolorallocate($im, $bgcolor[0], $bgcolor[1], $bgcolor[2]);        //RGB color background.
        $text_color = imagecolorallocate($im, $color[0], $color[1], $color[2]);            //RGB color text.
       
        if($L_R_C == 0){ //Justify Left
           
            imagettftext($im, $fsize, $angle, $X, $fsize, $text_color, $font, $text);
           
        }elseif($L_R_C == 1){ //Justify Right
            $s = split("[\n]+", $text);
            $__H=0;
           
            foreach($s as $key=>$val){
           
                $_b = imageTTFBbox($fsize,0,$font,$val);
                $_W = abs($_b[2]-$_b[0]);
                //Defining the X coordinate.
                $_X = $W-$_W;
                //Defining the Y coordinate.
                $_H = abs($_b[5]-$_b[3]); 
                $__H += $_H;             
                imagettftext($im, $fsize, $angle, $_X, $__H, $text_color, $font, $val);   
                $__H += 6;
               
            }
           
        }
        elseif($L_R_C == 2){ //Justify Center
           
            $s = split("[\n]+", $text);
            $__H=0;
           
            foreach($s as $key=>$val){
           
                $_b = imageTTFBbox($fsize,0,$font,$val);
                $_W = abs($_b[2]-$_b[0]);
                //Defining the X coordinate.
                $_X = abs($W/2)-abs($_W/2);
                //Defining the Y coordinate.
                $_H = abs($_b[5]-$_b[3]); 
                $__H += $_H;             
                imagettftext($im, $fsize, $angle, $_X, $__H, $text_color, $font, $val);   
                $__H += 6;
               
            }
           
        }       
                       
        return $im;
       
    }
	$db->close();
?>