<?php
/* lightbenc.php


	Dear Bram Cohen, 
		You are an arse
	WHAT were you smoking ?
	
	

This implementation should use one order of magnitude less memory then the TBdev version
The bdecoding speed is similar to TBdev, bencoding is faster, and much faster then bdecoding
	
Call the bdecode() function with a variable (a const can't be passed by reference):

$str="d7:oneListl8:a stringe10:oneIntegeri34ee";
var_dump(bdecode($str));

array(3) {
  ["oneList"]=>
  array(1) {
    [0]=>
    string(8) "a string"
  }
  ["oneInteger"]=>
  int(34)
  ["isDct"]=>
  bool(true)
}

The returned value is a nested data type with the following type of elements:
 - ints    (test type with is_integer($x))
 - strings (test type with is_string($x))
 - lists   (test type with is_array($x) && !isset($x[isDct])
 - dicts   (test type with is_array($x) && isset($x[isDct])

All elements have the native PHP type, except for the dictionary which is an array with an "isDct" key.
This is necessary since PHP makes no distinction between flat and associative arrays.

As such, this implementation is not a drop-in replacement of the TBDev code, hence the new function names
For all practical purposes, it's just as flexible, and very easy to use. For example:

// decode the torrent file
$dict= bdecode_file($torrentfilename);
// change announce url
$dict['announce']='http://inferno.demonoid.com'; 
// add private tracker flag
$dict['info']['private']=1;
// compute infohash
$infohash = pack("H*", sha1(bencode($dict["info"])));
// recreate the torrent file
$torrentfile=bencode($dict);


This implementation is hereby released under the GFYPL, version 1.00.


	The Go Fuck Yourself Public License, version 1.00
		
	Article 1
	You can go fuck yourself.
	
	END OF ALL TERMS AND CONDITIONS

*/

function bdecode(&$s, &$pos=0) {
	if($pos>=strlen($s)) {
		return null;
	}
	switch($s[$pos]){
	case 'd':
		$pos++;
		$retval=array();
		while ($s[$pos]!='e'){
			$key=bdecode($s, $pos);
			$val=bdecode($s, $pos);
			if ($key===null || $val===null)
				break;
			$retval[$key]=$val;
		}
		$retval["isDct"]=true;
		$pos++;
		return $retval;

	case 'l':
		$pos++;
		$retval=array();
		while ($s[$pos]!='e'){
			$val=bdecode($s, $pos);
			if ($val===null)
				break;
			$retval[]=$val;
		}
		$pos++;
		return $retval;

	case 'i':
		$pos++;
		$digits=strpos($s, 'e', $pos)-$pos;
		$val=(int)substr($s, $pos, $digits);
		$pos+=$digits+1;
		return $val;

//	case "0": case "1": case "2": case "3": case "4":
//	case "5": case "6": case "7": case "8": case "9":
	default:
		$digits=strpos($s, ':', $pos)-$pos;
		if ($digits<0 || $digits >20)
			return null;
		$len=(int)substr($s, $pos, $digits);
		$pos+=$digits+1;
		$str=substr($s, $pos, $len);
		$pos+=$len;
		//echo "pos: $pos str: [$str] len: $len digits: $digits\n";
		return (string)$str;
	}
	return null;
}

function bencode(&$d){
	if(is_array($d)){
		$ret="l";
		if($d["isDct"]){
			$isDict=1;
			$ret="d";
		}
		foreach($d as $key=>$value) {
			if($isDict){
				if($key=="isDct") continue;
				$ret.=strlen($key).":".$key;
			}
			if (is_string($value)) {
				$ret.=strlen($value).":".$value;
			} elseif (is_int($value)){
				$ret.="i${value}e";
			} else {
				$ret.=bencode ($value);
			}
		}
		return $ret."e";
	}
	return null;
}

function bdecode_file($filename){
	$f=file_get_contents($filename);
	return bdecode($f);
}
?>