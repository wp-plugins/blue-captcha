<?php

function blcap_get_specific_color ($color)
{
	$c1 = 0;
	$c2 = 0;
	$c3 = 0;

	$c1 = hexdec (substr ($color, 0, 2));
	$c2 = hexdec (substr ($color, 2, 2));
	$c3 = hexdec (substr ($color, 4, 2));
	
	return array ($c1, $c2, $c3);
}

function blcap_get_random_color ()
{
	$c = mt_rand (0, 2);
	if ($c == 0) $c1 = 0;
	else if ($c == 1) $c1 = 128;
	else $c1 = 255;
	$c = mt_rand (0, 2);
	if ($c == 0) $c2 = 0;
	else if ($c == 1) $c2 = 128;
	else $c2 = 255;
	$c = mt_rand (0, 2);
	if ($c == 0) $c3 = 0;
	else if ($c == 1) $c3 = 128;
	else $c3 = 255;
	
	return array ($c1, $c2, $c3);
}

function blcap_normcol ($c)
{
	if ($c > 255) return 255;
	else
	if ($c < 0) return 0;
	else return $c;
}

$capid = "";

if ($cid == "preview")
{
	global $current_user;

	$user_id = (isset ($current_user->ID) ? $current_user->ID : -1);
	$user_level = (isset ($current_user->user_level) ? $current_user->user_level : -1);
		
	if ($user_id < 0 || $user_level < 10)
	{
		header ("Content-type: image/png");
		$my_img = @imagecreate (200, 50);
		
		$clr = imagecolorallocate ($my_img, 128, 128, 128);
		$text_color = imagecolorallocate ($my_img, 255, 0, 0);
		
		imagestring ($my_img, 4, 30, 5, "UNAUTHORIZED USAGE", $text_color);
		imagestring ($my_img, 4, 60, 25, "OF CAPTCHA", $text_color);
		
		imagepng ($my_img);
		imagedestroy ($my_img);
		
		die (0);	
	}
	
	$pre = "";
	$sss = $_REQUEST;
	
}
else
{
	$blcap_setser = get_option ("blcap_settings");
	if (is_array ($blcap_setser))
		$sss = $blcap_setser;
	else
		$sss = @unserialize ($blcap_setser);
 
 	$captcha_use_sessions = (isset ($sss["gen_use_sessions"]) ? $sss["gen_use_sessions"] : "no");
    
	$capid = "";
	if ($captcha_use_sessions == "yes")
	{
		if (!isset ($_SESSION)) session_start ();

		if (isset ($_SESSION["capid"])) $capid = $_SESSION["capid"];
	}
	else
	{
		$res = blcap_get_captcha_session ($cid);
		$capid = (isset ($res["capid"]) ? $res["capid"] : "");
		$caprefresh = (isset ($res["caprefresh"]) ? $res["caprefresh"] : 0);
	}

	if ($capid == "" || $capid != $cid)
	{
		header ("Content-type: image/png");
		$my_img = @imagecreate (200, 50);
		
		$clr = imagecolorallocate ($my_img, 128, 128, 128);
		$text_color = imagecolorallocate ($my_img, 255, 0, 0);
		
		imagestring ($my_img, 4, 10, 5, "CAPTCHA SESSION EXPIRED", $text_color);
		imagestring ($my_img, 4, 40, 25, "RELOAD THE PAGE", $text_color);
		
		imagepng ($my_img);
		imagedestroy ($my_img);
		
		die (0);
	}
	
	$form = substr ($capid, 0, 1);

	if ($form == "L") $pre = "log_";
	else
	if ($form == "R") $pre = "reg_";
	else
	if ($form == "P") $pre = "pwd_";
	else $pre = "com_";
}


$AVAILABLE_BG_IMAGES = 30;


$enabled = (isset ($sss[$pre . "enabled"]) ? $sss[$pre . "enabled"] : "yes");

$gen_ignore_case = (isset ($sss["gen_ignore_case"]) ? $sss["gen_ignore_case"] : "no");
$ignore_case = (isset ($sss[$pre . "ignore_case"]) ? $sss[$pre . "ignore_case"] : "general");
if ($ignore_case == "general") $ignore_case = $gen_ignore_case;

$user = (isset ($sss[$pre . "user"]) ? $sss[$pre . "user"] : "-1");
$chars = array ();
if (isset ($sss[$pre . "char_3"])) $chars[] = 3;
if (isset ($sss[$pre . "char_4"])) $chars[] = 4;
if (isset ($sss[$pre . "char_5"])) $chars[] = 5;
if (isset ($sss[$pre . "char_6"])) $chars[] = 6;
if (isset ($sss[$pre . "char_7"])) $chars[] = 7;
if (isset ($sss[$pre . "char_8"])) $chars[] = 8;
if (isset ($sss[$pre . "char_9"])) $chars[] = 9;
if (isset ($sss[$pre . "char_10"])) $chars[] = 10;
$type = (isset ($sss[$pre . "type"]) ? $sss[$pre . "type"] : "numbers_letters");
$letter = (isset ($sss[$pre . "letter"]) ? $sss[$pre . "letter"] : "uppercase");
$usefont = (isset ($sss[$pre . "font"]) ? $sss[$pre . "font"] : "yes1");
$available_fonts = array ();
if (isset ($sss[$pre . "availfont_1"])) $available_fonts[] = 1;
if (isset ($sss[$pre . "availfont_2"])) $available_fonts[] = 2;
if (isset ($sss[$pre . "availfont_3"])) $available_fonts[] = 3;
if (isset ($sss[$pre . "availfont_4"])) $available_fonts[] = 4;
if (isset ($sss[$pre . "availfont_5"])) $available_fonts[] = 5;
$sizes = array ();
if (isset ($sss[$pre . "size_smaller"])) $sizes[] = 16;
if (isset ($sss[$pre . "size_small"])) $sizes[] = 20;
if (isset ($sss[$pre . "size_medium"])) $sizes[] = 24;
if (isset ($sss[$pre . "size_large"])) $sizes[] = 28;
if (isset ($sss[$pre . "size_larger"])) $sizes[] = 32;
$colorvalue = (isset ($sss[$pre . "speccolor"]) ? $sss[$pre . "speccolor"] : "");
if (substr ($colorvalue, 0, 1) == "#") $colorvalue = substr ($colorvalue, 1);
$color = (isset ($sss[$pre . "color"]) ? $sss[$pre . "color"] : "colorn");
$rotate = (isset ($sss[$pre . "rotate"]) ? $sss[$pre . "rotate"] : "yes");
$background = (isset ($sss[$pre . "background"]) ? $sss[$pre . "background"] : "palette");
$bgcolorvalue = (isset ($sss[$pre . "specbg"]) ? $sss[$pre . "specbg"] : "");
if (substr ($bgcolorvalue, 0, 1) == "#") $bgcolorvalue = substr ($bgcolorvalue, 1);
$available_images = array ();
if (isset ($sss[$pre . "availbg_1"])) $available_images[] = 1;
if (isset ($sss[$pre . "availbg_2"])) $available_images[] = 2;
if (isset ($sss[$pre . "availbg_3"])) $available_images[] = 3;
if (isset ($sss[$pre . "availbg_4"])) $available_images[] = 4;
if (isset ($sss[$pre . "availbg_5"])) $available_images[] = 5;
if (isset ($sss[$pre . "availbg_6"]))
{
	for ($i = 0 ; $i < $AVAILABLE_BG_IMAGES ; $i++)
		$available_images[$i] = $i+1;
}

$extra = (isset ($sss[$pre . "extra"]) ? $sss[$pre . "extra"] : "no");
$lines = (isset ($sss[$pre . "lines"]) ? $sss[$pre . "lines"] : "no");
$lineslevel = (isset ($sss[$pre . "trlevel"]) ? $sss[$pre . "trlevel"] : "1");
$layer = (isset ($sss[$pre . "layer"]) ? $sss[$pre . "layer"] : "single");

$height = 50;

if ($type == "random")
{
	$dd = mt_rand (0, 2);
	if ($dd == 0) $type = "numbers";
	else
	if ($dd == 1) $type = "letters";
	else $type = "numbers_letters";
}

if ($letter == "random")
{
	$dd = mt_rand (0, 2);
	if ($dd == 0) $letter = "lowercase";
	else
	if ($dd == 1) $letter = "uppercase";
	else $letter = "mixed";
}

$blcap_set = $type;

$charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890123456789";
if ($blcap_set == "numbers")
	$charset = "0123456789";
else
if ($blcap_set == "letters")
{
	if ($letter == "lowercase")
		$charset = "abcdefghijklmnopqrstuvwxyz";
	else
	if ($letter == "uppercase")
		$charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	else
		$charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
}
else
{
	if ($letter == "lowercase")
		$charset = "abcdefghijklmnopqrstuvwxyz01234567890123456789";
	else
	if ($letter == "uppercase")
		$charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890123456789";
	else
		$charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890123456789012345678901234567890123456789";
}

$charlen = strlen ($charset);

$totalchars = 5;

$chars_count = count ($chars);
if ($chars_count > 0)
{
	$dd = mt_rand (0, $chars_count-1);
	$totalchars = (isset ($chars[$dd]) ? $chars[$dd] : 5);
}

if ($totalchars < 3) $totalchars = 3;
if ($totalchars > 10) $totalchars = 10;

$secret = "";
for ($i = 0 ; $i < $totalchars ; $i++)
{
	$posc = mt_rand (0, $charlen-1);
	$secret = $secret . $charset[$posc];
}

if ($layer == "random")
	if (mt_rand (0, 1) == 0) $layer = "double";

if ($layer == "double") $height = 100;
else $height = 50;
		
$secret2 = "";
if ($layer == "double")
{
	$totalchars2 = 5;

	$chars_count = count ($chars);
	if ($chars_count > 0)
	{
		$dd = mt_rand (0, $chars_count-1);
		$totalchars2 = (isset ($chars[$dd]) ? $chars[$dd] : 5);
	}

	if ($totalchars2 < 3) $totalchars2 = 3;
	if ($totalchars2 > 10) $totalchars2 = 10;

	$secret2 = "";
	for ($i = 0 ; $i < $totalchars2 ; $i++)
	{
		$posc = mt_rand (0, $charlen-1);
		$secret2 = $secret2 . $charset[$posc];
	}
}

if ($cid != "preview")
{     
	$protection_key = "";
	$protection_key = get_option ("blcap_protection_key");

	$word = $secret . $secret2;
	if ($ignore_case == "yes") $word = strtoupper ($word);

	$encrypted_captcha = sha1 ($protection_key . $word);
	$original_captcha = $secret . $secret2;    
	// $original_captcha = $encrypted_captcha;
    
	$gen_refresh = (isset ($sss["gen_refresh"]) ? $sss["gen_refresh"] : "yes");

	if ($captcha_use_sessions == "yes")
	{
		$caprefresh = 0;
		if (isset ($_SESSION["caprefresh"]))
		{
			$caprefresh = 1 + (int)$_SESSION["caprefresh"];
			$_SESSION["caprefresh"] = $caprefresh;
		}
		
		// protection against spammers
		if ($gen_refresh != "yes" && $caprefresh > 0)
			$encrypted_captcha = "";
			
		$_SESSION["captcha"] = $encrypted_captcha;       
	}
	else
	{
		if (!isset ($caprefresh)) $caprefresh = 0;
		$caprefresh = $caprefresh + 1;
		
		// protection against spammers
		if ($gen_refresh != "yes" && $caprefresh > 0)
			$encrypted_captcha = "";
			
		blcap_update_captcha_session ($cid, $encrypted_captcha, $original_captcha, $caprefresh);
	}
}

// plugin directory is "blue-captcha" usually
$path = realpath (".") . "/wp-content/plugins/" . plugin_basename (dirname (__FILE__)) . "/";

header ("Content-type: image/png");

if ($background == "random")
{
	$chance = mt_rand (0, 3);
	if ($chance == 0) $background = "color";
	else if ($chance == 1) $background = "mosaic";
	else if ($chance == 2) $background = "image";
	else $background = "palette";
}

$noc = 3;
if ($background == "color" || $background == "color0")
{
	$my_img = @imagecreatetruecolor (200, $height);

	if ($background == "color0")
	{
		$bgcol = blcap_get_specific_color ($bgcolorvalue);
	}
	else
	{
		$noc = mt_rand (0, 2);
		$bgcol = blcap_get_random_color ();
	
		$bgcol[$noc] = 255;
	}
	
	$r = $bgcol[0];
	$g = $bgcol[1];
	$b = $bgcol[2];
	
	$clr = imagecolorallocate ($my_img, $r, $g, $b);
	
	for ($x = 0 ; $x < 200 ; $x++)
		for ($y = 0 ; $y < $height ; $y++)
			imagesetpixel ($my_img, $x, $y, $clr);
}
else if ($background == "mosaic")
{
	$my_img = @imagecreatetruecolor (200, $height);

	for ($x = 0 ; $x < 200 ; $x++)
		for ($y = 0 ; $y < $height ; $y++)
		{
			$r = mt_rand (0, 255);
			$g = mt_rand (0, 255);
			$b = mt_rand (0, 255);
			$clr = imagecolorallocate ($my_img, $r, $g, $b);
			imagesetpixel ($my_img, $x, $y, $clr);		
		}
}
else
{
	if (count ($available_images) < 1)
		$bg = "";
	else
	{
		$b = mt_rand (1, count ($available_images)) - 1;
		$bgfile = "bg/" . "bg" . $available_images[$b] . ".jpg";
		$bg = $path . $bgfile;
		if (!file_exists ($bg)) $bg = "";
	}
	
	if ($bg == "")
	{
		$my_img = @imagecreatetruecolor (200, $height);

		$noc = mt_rand (0, 2);
		$bgcol = blcap_get_random_color ();
		
		$bgcol[$noc] = 255;
		
		$r = $bgcol[0];
		$g = $bgcol[1];
		$b = $bgcol[2];
		
		$clr = imagecolorallocate ($my_img, $r, $g, $b);
		
		for ($x = 0 ; $x < 200 ; $x++)
			for ($y = 0 ; $y < $height ; $y++)
				imagesetpixel ($my_img, $x, $y, $clr);	
	}
	else
	{
		if ($layer == "double")
		{
			$my_img0 = @imagecreatefromjpeg ($path . $bgfile);
			$my_img = @imagecreatetruecolor (200, $height);
			for ($x = 0 ; $x < 200 ; $x++)
				for ($y = 0 ; $y < $height ; $y++)
				{
					$rgb = imagecolorat ($my_img0, $x, (int)($y / 2) );
					imagesetpixel ($my_img, $x, $y, $rgb);
				}
		}
		else
		{
			$my_img = @imagecreatefromjpeg ($path . $bgfile);
		}
	}
}

if ($extra == "random")
{
	if (mt_rand (0, 3) == 0) $extra = "lines";
	else
	{
		if (mt_rand (0, 2) == 0) $extra = "circles";
		else
		if (mt_rand (0, 1) == 0) $extra = "lines_circles";
		else $extra = "grid";
	}
}

$addlines = false;
if ($extra != "no") $addlines = true;

if ($addlines)
{
	if ($extra == "grid")
	{
		$rnd_col = blcap_get_random_color ();
		$rnd_col[$noc] = 128;
		$grid_color = imagecolorallocate ($my_img, $rnd_col[0], $rnd_col[1], $rnd_col[2]);
		imagesetthickness ($my_img, 1);
		for ($y = 0 ; $y < $height ; $y = $y + 5)
			imageline ($my_img, 0, $y, 200, $y, $grid_color);
		for ($x = 0 ; $x < 200 ; $x = $x + 5)
			imageline ($my_img, $x, 0, $x, $height, $grid_color);
	}
	else
	for ($i = 0 ; $i < 20 ; $i++)
	{
		$rnd_col = blcap_get_random_color ();
		$rnd_col[$noc] = 0;
		
		$text_color = imagecolorallocate ($my_img, $rnd_col[0], $rnd_col[1], $rnd_col[2]);
		
		$x1 = mt_rand (0, 200);
		$x2 = mt_rand (0, 200);
		$y1 = mt_rand (0, $height);
		$y2 = mt_rand (0, $height);
		$rad = mt_rand (5, 25);
		
		if ($extra == "lines_circles") $dr = mt_rand (1, 2);
		else $dr = 0;
		
		imagesetthickness ($my_img, mt_rand (1, 2));
		if ($extra == "lines" || $dr == 1)
			imageline ($my_img, $x1, $y1, $x2, $y2, $text_color);
		if ($extra == "circles" || $dr == 2)
			imageellipse ($my_img, $x1, $y1, $rad, $rad, 1+$text_color);
	}
}

if ($background == "palette")
	$change_pal = true;
else
	$change_pal = false;

if ($change_pal)
{
	$rcoef = mt_rand (-50, 50);
	$gcoef = mt_rand (-50, 50);
	$bcoef = mt_rand (-50, 50);
}
else
{
	$rcoef = 0;
	$gcoef = 0;
	$bcoef = 0;
}

$colormap = array ();
for ($x = 0 ; $x < 200 ; $x++)
	for ($y = 0 ; $y < $height ; $y++)
	{
		$rgb = imagecolorat ($my_img, $x, $y);
		$rgbarr = imagecolorsforindex ($my_img, $rgb);
		$colormap[$x][$y]["r"] = blcap_normcol ($rgbarr["red"] + $rcoef);
		$colormap[$x][$y]["g"] = blcap_normcol ($rgbarr["green"] + $gcoef);
		$colormap[$x][$y]["b"] = blcap_normcol ($rgbarr["blue"] + $bcoef);
	}

for ($x = 0 ; $x < 200 ; $x++)
	for ($y = 0 ; $y < $height ; $y++)
	{
		$r = $colormap[$x][$y]["r"];
		$g = $colormap[$x][$y]["g"];
		$b = $colormap[$x][$y]["b"];
		$clr = imagecolorallocate ($my_img, $r, $g, $b);
		imagesetpixel ($my_img, $x, $y, $clr);
	}

$useangle = false;
if ($rotate == "yes") $useangle = true;
if ($rotate == "random") 
	if (mt_rand (0, 1) == 0) $useangle = true;

$initposx = (int)((200 - $totalchars*20) / 2.0);
if ($useangle) $initposx = $initposx + 10;

if ($usefont == "random")
{
	if (mt_rand (0, 2) == 0) $usefont = "no";
	else
	{
		if (mt_rand (0, 1) == 0) $usefont = "yes1";
		else $usefont = "yes2";
	}
}

$font = "";
if ($usefont == "yes1")
{
	if (count ($available_fonts) < 1)
		$font = "";
	else
	{
		$f = mt_rand (1, count ($available_fonts)) - 1;
		$ffile = "fonts/" . "font" . $available_fonts[$f] . ".ttf";
		$font = $path . $ffile;
		if (!file_exists ($font)) $font = "";
	}
}
if ($usefont == "no") $font = "";

$size = 25;

$sizes_count = count ($sizes);
if ($sizes_count > 0)
{
	$dd = mt_rand (0, $sizes_count-1);
	$size = (isset ($sizes[$dd]) ? $sizes[$dd] : 25);
}

if ($size < 12) $size = 12;
if ($size > 30) $size = 30;

if ($color == "random")
{
	$rr = mt_rand (0, 2);
	if ($rr == 0) $color = "color1";
	else if ($rr == 1) $color = "colorn";
	else $color = "colorful";
}

if (isset ($rnd_col)) unset ($rnd_col);

if ($color == "colorful")
{
	$my_img2 = @imagecreatetruecolor (200, $height);

	$clr2 = imagecolorallocate ($my_img2, 0, 0, 0);
	
	for ($x = 0 ; $x < 200 ; $x++)
		for ($y = 0 ; $y < $height ; $y++)
			imagesetpixel ($my_img2, $x, $y, $clr2);
}
			
for ($i = 0 ; $i < $totalchars ; $i++)
{
	$thischar = $secret[$i];

	$posy = mt_rand ($size, 50);
	
	if ($useangle)
		$angle = mt_rand (0, 60);
	else $angle = 0;
	
	if ($usefont == "yes2")
	{
        	if (count ($available_fonts) < 1)
			$font = "";
		else
		{
			$f = mt_rand (1, count ($available_fonts)) - 1;
			$ffile = "fonts/" . "font" . $available_fonts[$f] . ".ttf";
			$font = $path . $ffile;
			if (!file_exists ($font)) $font = "";
		}
	}

	if ($color == "color0")
	{
		$rnd_col = blcap_get_specific_color ($colorvalue);
	}
	else
	if ($color != "color1" || ($color == "color1" && !isset ($rnd_col)))
	{
		$rnd_col = blcap_get_random_color ();
		$rnd_col[$noc] = 0;
	}
	
	if ($color == "colorful")
	{
		$text_color = imagecolorallocate ($my_img2, 255, 255, 255);

		if ($font != "")
		{
			$bres = imagettftext ($my_img2, $size, $angle, $initposx + $i*20, $posy, $text_color, $font, $thischar);
			if (!$bres) imagestring ($my_img2, 5, $initposx + $i*20, $posy - 20, $thischar, $text_color);
		}
		else
			imagestring ($my_img2, 5, $initposx + $i*20, $posy - 20, $thischar, $text_color);
	}
	else
	{
		$text_color = imagecolorallocate ($my_img, $rnd_col[0], $rnd_col[1], $rnd_col[2]);

		if ($font != "")
		{
			$bres = imagettftext ($my_img, $size, $angle, $initposx + $i*20, $posy, $text_color, $font, $thischar);
			if (!$bres) imagestring ($my_img, 5, $initposx + $i*20, $posy - 20, $thischar, $text_color);
		}
		else
			imagestring ($my_img, 5, $initposx + $i*20, $posy - 20, $thischar, $text_color);
	}
}

if ($layer == "double")
{
	$initposx = (int)((200 - $totalchars2*20) / 2.0);
	if ($useangle) $initposx = $initposx + 10;
	
	for ($i = 0 ; $i < $totalchars2 ; $i++)
	{
		$thischar = $secret2[$i];

		$posy = 50 + mt_rand ($size, 50);
		
		if ($useangle)
			$angle = mt_rand (0, 60);
		else $angle = 0;
		
		if ($usefont == "yes2")
		{
			if (count ($available_fonts) < 1)
				$font = "";
			else
			{
				$f = mt_rand (1, count ($available_fonts)) - 1;
				$ffile = "fonts/" . "font" . $available_fonts[$f] . ".ttf";
				$font = $path . $ffile;
				if (!file_exists ($font)) $font = "";
			}
		} 
		
		if ($color == "color0")
		{
			$rnd_col = blcap_get_specific_color ($colorvalue);
		}
		else
		if ($color != "color1" || ($color == "color1" && !isset ($rnd_col)))
		{
			$rnd_col = blcap_get_random_color ();
			$rnd_col[$noc] = 0;
		}
		
		if ($color == "colorful")
		{
			$text_color = imagecolorallocate ($my_img2, 255, 255, 255);

			if ($font != "")
			{
				$bres = imagettftext ($my_img2, $size, $angle, $initposx + $i*20, $posy, $text_color, $font, $thischar);
				if (!$bres) imagestring ($my_img2, 5, $initposx + $i*20, $posy - 20, $thischar, $text_color);
			}
			else
				imagestring ($my_img2, 5, $initposx + $i*20, $posy - 20, $thischar, $text_color);
		}
		else
		{
			$text_color = imagecolorallocate ($my_img, $rnd_col[0], $rnd_col[1], $rnd_col[2]);

			if ($font != "")
			{
				$bres = imagettftext ($my_img, $size, $angle, $initposx + $i*20, $posy, $text_color, $font, $thischar);
				if (!$bres) imagestring ($my_img, 5, $initposx + $i*20, $posy - 20, $thischar, $text_color);
			}
			else
				imagestring ($my_img, 5, $initposx + $i*20, $posy - 20, $thischar, $text_color);
		}
	}
}

if ($color == "colorful")
{
	$colstep1 = 3;
	$colstep2 = 3;
	$colstep3 = 3;
	
	$rnd_col = blcap_get_random_color ();
	$rnd_col[$noc] = 0;
	$curcol = 0;
	for ($x = 0 ; $x < 200 ; $x++)
	{
		if ($curcol == 0)
		{
			$rnd_col[0] = $rnd_col[0] + $colstep1;
			$rnd_col[1] = $rnd_col[1] + $colstep2;
			$rnd_col[2] = $rnd_col[2] + $colstep3;
			
			if ($rnd_col[0] > 255)
			{
				$colstep1 = -3;
				$rnd_col[0] = 255;
			}
			if ($rnd_col[0] < 0)
			{
				$colstep1 = 3;
				$rnd_col[0] = 0;
			}
			if ($rnd_col[1] > 255)
			{
				$colstep2 = -3;
				$rnd_col[1] = 255;
			}
			if ($rnd_col[1] < 0)
			{
				$colstep2 = 3;
				$rnd_col[1] = 0;
			}
			if ($rnd_col[2] > 255)
			{
				$colstep3 = -3;
				$rnd_col[2] = 255;
			}
			if ($rnd_col[2] < 0) 
			{
				$colstep3 = 3;
				$rnd_col[2] = 0;
			}
			
			$text_color = imagecolorallocate ($my_img, $rnd_col[0], $rnd_col[1], $rnd_col[2]);
		}
		$curcol = $curcol + 1;
		if ($curcol > 0) $curcol = 0;
		for ($y = 0 ; $y < $height ; $y++)
		{
			$rgb = imagecolorat ($my_img2, $x, $y);
			$rgbarr = imagecolorsforindex ($my_img2, $rgb);
			if ($rgbarr["red"] == 255)
			{
				imagesetpixel ($my_img, $x, $y, $text_color);
			}
		}
	}
}

$addlineshor = $addlinesver = false;

if ($lines == "random")
{
	if (mt_rand (0, 2) == 0) $lines = "horizontal";
	else
	{
		if (mt_rand (0, 1) == 0) $lines = "vertical";
		else $lines = "both";
	}
}

if ($lines == "horizontal" || $lines == "both")
	$addlineshor = true;
if ($lines == "vertical" || $lines == "both")
	$addlinesver = true;

if ($lineslevel == "random") $step = 2 + mt_rand (1, 5);
else $step = (int)$lineslevel;

if ($step < 2) $step = 2;
if ($step > 7) $step = 7;

if ($addlineshor || $addlinesver)
{
	for ($y = 0 ; $y < $height ; $y++)
		for ($x = 0 ; $x < 200 ; $x++)
		{
			if (($y % $step == 0 && $addlineshor) || ($x % $step == 0 && $addlinesver))
			{
				$r = $colormap[$x][$y]["r"];
				$g = $colormap[$x][$y]["g"];
				$b = $colormap[$x][$y]["b"];
				$clr = imagecolorallocate ($my_img, $r, $g, $b);
				imagesetpixel ($my_img, $x, $y, $clr);
			}
		}
}
	
imagepng ($my_img);
imagedestroy ($my_img);

?>
