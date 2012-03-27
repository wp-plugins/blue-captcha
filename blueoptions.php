<?php

function blcap_valid_ip ($ip)
{
	if ($ip == "") return false;

    $ip_arr = explode (".", $ip);
    
    $no = 0;
    foreach ($ip_arr as $key => $part)
    {
        $no++;
        if ($no > 4) return false;
        if ($part == "*" && $no > 2) {}
        else
        {
            if (intval ($part) < 0 || intval ($part) > 255 || (string)intval ($part) !== (string)$part)
                return false;
        }
    }
    if ($no != 4) return false;
        
    return true;
}

function blcap_process_ip_list ($list)
{
	$iplist = "";

	$listlen = strlen ($list);
	$thisip = "";
	$no = 0;
	for ($i = 0 ; $i < $listlen ; $i++)
	{
		$ch = substr ($list, $i, 1);
		if ($ch == '0' || $ch == '1' || $ch == '2' || $ch == '3'|| $ch == '4' || $ch == '5' || $ch == '6' || $ch == '7' || $ch == '8' || $ch == '9' || $ch == '.' || $ch == '*')
			$thisip = $thisip . $ch;
		else
		{
			if ($thisip != "")
			{
				$iplist[$no] = $thisip;
				$no++;
			}
			$thisip = "";
		}
	}
	if ($thisip != "") $iplist[$no++] = $thisip;

	$invalid = 0;
	$newno = 0;
    $iparr = Array ();
	for ($j = 0 ; $j < $no ; $j++) 
	{
		$pr = $iplist[$j];
		$valid = blcap_valid_ip ($pr);
		if ($valid == true) 
		{
            $iparr[$newno] = $pr;
			$newno++;
		}
		else 
			$invalid++;
	} 
	
    sort ($iparr);
    
	$result["count"] = $newno;
	$result["invalid"] = $invalid;
    $result["ip"] = $iparr;
	
	return $result;
}

	echo "\n";
	echo "<style>\n";
	echo ".blcapmenu\n";
	echo "{\n";
	echo "\tcolor: darkblue;\n";
	echo "\tfont-size: 13px;\n";
	echo "\tfont-weight: bold;\n";
	echo "\tpadding: 5px;\n";
	echo "\tmargin: 5px;\n";
	echo "\tborder: 2px solid cyan;\n";
	echo "\tborder-radius: 10px;\n";
	echo "\tbackground: lightcyan;\n";
	echo "}\n";
	echo ".blcapmenu:hover\n";
	echo "{\n";
	echo "\tcursor: pointer;\n";
	echo "\tcolor: red;\n";
	echo "\tfont-size: 13px;\n";
	echo "\tfont-weight: bold;\n";
	echo "\tpadding: 5px;\n";
	echo "\tmargin: 5px;\n";
	echo "\tborder: 2px solid cyan;\n";
	echo "\tborder-radius: 10px;\n";
	echo "\tbackground: lightblue;\n";
	echo "}\n";
	echo ".blcapmenusel\n";
	echo "{\n";
	echo "\tcursor: pointer;\n";
	echo "\tcolor: red;\n";
	echo "\tfont-size: 13px;\n";
	echo "\tfont-weight: bold;\n";
	echo "\tpadding: 5px;\n";
	echo "\tmargin: 5px;\n";
	echo "\tborder: 2px solid cyan;\n";
	echo "\tborder-radius: 10px;\n";
	echo "\tbackground: lightblue;\n";
	echo "}\n";		
	echo "</style>\n";
	echo "\n";
	
	echo "<script language=\"javascript\">\n";
	echo "\n";
	echo "function blcap_apply_profile (t)\n";
	echo "{\n";
	echo "var type;\n";
	echo "\tt = t + '_';\n";
	echo "try {\n";
	echo "\tif (document.getElementById (t + 'profile'))\n";
	echo "\t\ttype = document.getElementById (t + 'profile').value;\n";
	echo "\telse return;\n";
	echo "\tif (type == 1)\n";
	echo "\t{\n";
	echo "\t\tdocument.getElementById (t + 'char3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'char4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char5').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char6').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char7').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char8').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char9').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char10').checked = false;\n";	
	echo "\t\tdocument.getElementById (t + 'type1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'letter2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'font2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont2').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availfont3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availfont4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availfont5').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size1').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size2').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size5').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'color1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'rotate1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'background1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg1').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg2').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg5').checked = false;\n";	
	echo "\t\tdocument.getElementById (t + 'extra1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'lines1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'trlevel1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'layer1').checked = true;\n";	
	//echo "\t\tdocument.getElementById (t + 'noise1').checked = true;\n";
	echo "\t}\n";
	echo "\telse if (type == 2)\n";
	echo "\t{\n";
	echo "\t\tdocument.getElementById (t + 'char3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'char5').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char6').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char7').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char8').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char9').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char10').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'type2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'letter2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'font2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont5').checked = false;\n";	
	echo "\t\tdocument.getElementById (t + 'size1').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size2').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size5').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'color3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'rotate1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'background1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg1').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg2').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg5').checked = false;\n";		
	echo "\t\tdocument.getElementById (t + 'extra1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'lines1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'trlevel1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'layer1').checked = true;\n";	
	//echo "\t\tdocument.getElementById (t + 'noise1').checked = true;\n";
	echo "\t}\n";
	echo "\telse if (type == 3)\n";	
	echo "\t{\n";
	echo "\t\tdocument.getElementById (t + 'char3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char5').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'char6').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char7').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char8').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char9').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char10').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'type3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'letter2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'font2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont5').checked = false;\n";	
	echo "\t\tdocument.getElementById (t + 'size1').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size2').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size5').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'color2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'rotate2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'background3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg5').checked = true;\n";		
	echo "\t\tdocument.getElementById (t + 'extra1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'lines1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'trlevel1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'layer1').checked = true;\n";	
	//echo "\t\tdocument.getElementById (t + 'noise1').checked = true;\n";
	echo "\t}\n";
	echo "\telse if (type == 4)\n";	
	echo "\t{\n";
	echo "\t\tdocument.getElementById (t + 'char3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char5').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char6').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'char7').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char8').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char9').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char10').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'type3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'letter2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'font2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont5').checked = false;\n";	
	echo "\t\tdocument.getElementById (t + 'size1').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size2').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'size5').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'color2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'rotate2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'background4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg5').checked = true;\n";		
	echo "\t\tdocument.getElementById (t + 'extra1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'lines1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'trlevel1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'layer1').checked = true;\n";		
	//echo "\t\tdocument.getElementById (t + 'noise2').checked = true;\n";	
	echo "\t}\n";
	echo "\telse if (type == 5)\n";
	echo "\t{\n";
	echo "\t\tdocument.getElementById (t + 'char3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char5').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char6').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char7').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'char8').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'char9').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char10').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'type3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'letter4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'font3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont5').checked = false;\n";	
	echo "\t\tdocument.getElementById (t + 'size1').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size2').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'size4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'size5').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'color2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'rotate2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'background1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg1').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg2').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'availbg5').checked = false;\n";		
	echo "\t\tdocument.getElementById (t + 'extra1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'lines4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'trlevel3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'layer1').checked = true;\n";	
	//echo "\t\tdocument.getElementById (t + 'noise2').checked = true;\n";	
	echo "\t}\n";
	echo "\telse if (type == 6)\n";
	echo "\t{\n";
	echo "\t\tdocument.getElementById (t + 'char3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char5').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char6').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char7').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char8').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'char9').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'char10').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'type3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'letter1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'font3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont5').checked = true;\n";	
	echo "\t\tdocument.getElementById (t + 'size1').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size2').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'size4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size5').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'color2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'rotate2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'background4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg5').checked = true;\n";		
	echo "\t\tdocument.getElementById (t + 'extra5').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'lines2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'trlevel5').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'layer1').checked = true;\n";		
	//echo "\t\tdocument.getElementById (t + 'noise2').checked = true;\n";	
	echo "\t}\n";
	echo "\telse if (type == 7)\n";		
	echo "\t{\n";
	echo "\t\tdocument.getElementById (t + 'char3').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char5').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char6').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char7').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char8').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char9').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'char10').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'type3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'letter3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'font3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availfont5').checked = true;\n";	
	echo "\t\tdocument.getElementById (t + 'size1').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'size3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'size4').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'size5').checked = false;\n";
	echo "\t\tdocument.getElementById (t + 'color2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'rotate2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'background4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg1').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'availbg5').checked = true;\n";		
	echo "\t\tdocument.getElementById (t + 'extra4').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'lines2').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'trlevel3').checked = true;\n";
	echo "\t\tdocument.getElementById (t + 'layer1').checked = true;\n";		
	//echo "\t\tdocument.getElementById (t + 'noise2').checked = true;\n";
	echo "\t}\n";
	echo "\telse\n";
	echo "\t{\n";

	echo "\t}\n";
	echo "}\n";
	echo "catch (exc)\n";
	echo "{\n";
	echo "\talert (exc);\n";
	echo "}\n";
	echo "}\n";
	echo "\n";
	
	echo "function blcap_disable_tbl (t, en)\n";
	echo "{\n";
	echo "\tvar i;\n";
	//echo "\tt = t + '_';\n";
	echo "\tfor (i=3;i<=10;i++)\n";
	echo "\t\tdocument.getElementById (t + 'char' + i).disabled = en;\n";
	echo "\tfor (i=1;i<=4;i++)\n";
	echo "\t\tdocument.getElementById (t + 'type' + i).disabled = en;\n";
	echo "\tfor (i=1;i<=4;i++)\n";
	echo "\t\tdocument.getElementById (t + 'letter' + i).disabled = en;\n";
	echo "\tfor (i=1;i<=4;i++)\n";
	echo "\t\tdocument.getElementById (t + 'font' + i).disabled = en;\n";
	echo "\tfor (i=1;i<=5;i++)\n";
	echo "\t\tdocument.getElementById (t + 'size' + i).disabled = en;\n";
	echo "\tfor (i=1;i<=4;i++)\n";
	echo "\t\tdocument.getElementById (t + 'color' + i).disabled = en;\n";
	echo "\tfor (i=1;i<=3;i++)\n";
	echo "\t\tdocument.getElementById (t + 'rotate' + i).disabled = en;\n";
	echo "\tfor (i=1;i<=5;i++)\n";
	echo "\t\tdocument.getElementById (t + 'background' + i).disabled = en;\n";
	echo "\tfor (i=1;i<=6;i++)\n";
	echo "\t\tdocument.getElementById (t + 'extra' + i).disabled = en;\n";
	echo "\tfor (i=1;i<=5;i++)\n";
	echo "\t\tdocument.getElementById (t + 'lines' + i).disabled = en;\n";
	echo "\tfor (i=1;i<=6;i++)\n";
	echo "\t\tdocument.getElementById (t + 'trlevel' + i).disabled = en;\n";
	echo "\tfor (i=1;i<=3;i++)\n";
	echo "\t\tdocument.getElementById (t + 'layer' + i).disabled = en;\n";	
	echo "}\n";
	echo "\n";

	echo "function blcap_change_prof (t)\n";
	echo "{\n";
	echo "\tdocument.getElementById (t + '_profile').value = '8';\n";
	echo "}\n";
	echo "\n";
	
	echo "function blcap_change_menu (m, option)\n";
	echo "{\n";
	echo "\tdocument.getElementById ('blcapm1').className = 'blcapmenu';\n";
	echo "\tdocument.getElementById ('blcapm2').className = 'blcapmenu';\n";
	echo "\tdocument.getElementById ('blcapm3').className = 'blcapmenu';\n";
	echo "\tdocument.getElementById ('blcapm4').className = 'blcapmenu';\n";
	echo "\tdocument.getElementById ('blcapm5').className = 'blcapmenu';\n";
	echo "\tdocument.getElementById ('blcapm6').className = 'blcapmenu';\n";    
	echo "\tdocument.getElementById ('blcap_opt1').style.display = 'none';\n";
	echo "\tdocument.getElementById ('blcap_opt2').style.display = 'none';\n";
	echo "\tdocument.getElementById ('blcap_opt3').style.display = 'none';\n";
	echo "\tdocument.getElementById ('blcap_opt4').style.display = 'none';\n";
	echo "\tdocument.getElementById ('blcap_opt5').style.display = 'none';\n";
   	echo "\tdocument.getElementById ('blcap_opt6').style.display = 'none';\n";
	echo "\tdocument.getElementById ('blcapm' + m).className = 'blcapmenusel';\n";
	echo "\tdocument.getElementById ('blcap_opt' + m).style.display = '';\n";
	echo "\tdocument.getElementById ('blcap_option').value = option;\n";
	echo "}\n";
	
	echo "\n";
	echo "var blcap_refno = 0;\n";	
	echo "\n";
	
	$captchaurl = get_option ("siteurl") . "?bcapact=gen&id=preview";

	echo "\n";
	echo "function blcap_captcha_preview (t)\n";
	echo "{\n";
	echo "\t\tvar qq = '';\n";
	echo "\n";
	echo "\tt = t + '_';\n";
	echo "\tif (document.getElementById (t + 'char3').checked) qq = qq + '&char_3=1';\n";
	echo "\tif (document.getElementById (t + 'char4').checked) qq = qq + '&char_4=1';\n";
	echo "\tif (document.getElementById (t + 'char5').checked) qq = qq + '&char_5=1';\n";
	echo "\tif (document.getElementById (t + 'char6').checked) qq = qq + '&char_6=1';\n";
	echo "\tif (document.getElementById (t + 'char7').checked) qq = qq + '&char_7=1';\n";
	echo "\tif (document.getElementById (t + 'char8').checked) qq = qq + '&char_8=1';\n";
	echo "\tif (document.getElementById (t + 'char9').checked) qq = qq + '&char_9=1';\n";
	echo "\tif (document.getElementById (t + 'char10').checked) qq = qq + '&char_10=1';\n";
	echo "\tif (document.getElementById (t + 'type1').checked) qq = qq + '&type=numbers';\n";
	echo "\tif (document.getElementById (t + 'type2').checked) qq = qq + '&type=letters';\n";
	echo "\tif (document.getElementById (t + 'type3').checked) qq = qq + '&type=numbers_letters';\n";
	echo "\tif (document.getElementById (t + 'type4').checked) qq = qq + '&type=random';\n";
	echo "\tif (document.getElementById (t + 'letter1').checked) qq = qq + '&letter=lowercase';\n";
	echo "\tif (document.getElementById (t + 'letter2').checked) qq = qq + '&letter=uppercase';\n";
	echo "\tif (document.getElementById (t + 'letter3').checked) qq = qq + '&letter=mixed';\n";
	echo "\tif (document.getElementById (t + 'letter4').checked) qq = qq + '&letter=random';\n";
	echo "\tif (document.getElementById (t + 'font1').checked) qq = qq + '&font=no';\n";
	echo "\tif (document.getElementById (t + 'font2').checked) qq = qq + '&font=yes1';\n";
	echo "\tif (document.getElementById (t + 'font3').checked) qq = qq + '&font=yes2';\n";
	echo "\tif (document.getElementById (t + 'font4').checked) qq = qq + '&font=random';\n";
	echo "\tif (document.getElementById (t + 'availfont1').checked) qq = qq + '&availfont_1=1';\n";    
  	echo "\tif (document.getElementById (t + 'availfont2').checked) qq = qq + '&availfont_2=1';\n"; 
	echo "\tif (document.getElementById (t + 'availfont3').checked) qq = qq + '&availfont_3=1';\n"; 
	echo "\tif (document.getElementById (t + 'availfont4').checked) qq = qq + '&availfont_4=1';\n"; 
	echo "\tif (document.getElementById (t + 'availfont5').checked) qq = qq + '&availfont_5=1';\n";     
	echo "\tif (document.getElementById (t + 'size1').checked) qq = qq + '&size_smaller=1';\n";
	echo "\tif (document.getElementById (t + 'size2').checked) qq = qq + '&size_small=1';\n";
	echo "\tif (document.getElementById (t + 'size3').checked) qq = qq + '&size_medium=1';\n";
	echo "\tif (document.getElementById (t + 'size4').checked) qq = qq + '&size_large=1';\n";
	echo "\tif (document.getElementById (t + 'size5').checked) qq = qq + '&size_larger=1';\n";
	echo "\tif (document.getElementById (t + 'color1').checked) qq = qq + '&color=color1';\n";
	echo "\tif (document.getElementById (t + 'color2').checked) qq = qq + '&color=colorn';\n";
	echo "\tif (document.getElementById (t + 'color3').checked) qq = qq + '&color=colorful';\n";
	echo "\tif (document.getElementById (t + 'color4').checked) qq = qq + '&color=random';\n";
	echo "\tif (document.getElementById (t + 'rotate1').checked) qq = qq + '&rotate=no';\n";
	echo "\tif (document.getElementById (t + 'rotate2').checked) qq = qq + '&rotate=yes';\n";
	echo "\tif (document.getElementById (t + 'rotate3').checked) qq = qq + '&rotate=random';\n";
	echo "\tif (document.getElementById (t + 'background1').checked) qq = qq + '&background=color';\n";
	echo "\tif (document.getElementById (t + 'background2').checked) qq = qq + '&background=mosaic';\n";
	echo "\tif (document.getElementById (t + 'background3').checked) qq = qq + '&background=image';\n";
	echo "\tif (document.getElementById (t + 'background4').checked) qq = qq + '&background=palette';\n";
	echo "\tif (document.getElementById (t + 'background5').checked) qq = qq + '&background=random';\n";
	echo "\tif (document.getElementById (t + 'availbg1').checked) qq = qq + '&availbg_1=1';\n";    
  	echo "\tif (document.getElementById (t + 'availbg2').checked) qq = qq + '&availbg_2=1';\n"; 
	echo "\tif (document.getElementById (t + 'availbg3').checked) qq = qq + '&availbg_3=1';\n"; 
	echo "\tif (document.getElementById (t + 'availbg4').checked) qq = qq + '&availbg_4=1';\n"; 
	echo "\tif (document.getElementById (t + 'availbg5').checked) qq = qq + '&availbg_5=1';\n"; 	
	echo "\tif (document.getElementById (t + 'extra1').checked) qq = qq + '&extra=no';\n";
	echo "\tif (document.getElementById (t + 'extra2').checked) qq = qq + '&extra=lines';\n";
	echo "\tif (document.getElementById (t + 'extra3').checked) qq = qq + '&extra=circles';\n";
	echo "\tif (document.getElementById (t + 'extra4').checked) qq = qq + '&extra=lines_circles';\n";
	echo "\tif (document.getElementById (t + 'extra5').checked) qq = qq + '&extra=grid';\n";
	echo "\tif (document.getElementById (t + 'extra6').checked) qq = qq + '&extra=random';\n";
	echo "\tif (document.getElementById (t + 'lines1').checked) qq = qq + '&lines=no';\n";
	echo "\tif (document.getElementById (t + 'lines2').checked) qq = qq + '&lines=horizontal';\n";
	echo "\tif (document.getElementById (t + 'lines3').checked) qq = qq + '&lines=vertical';\n";
	echo "\tif (document.getElementById (t + 'lines4').checked) qq = qq + '&lines=both';\n";
	echo "\tif (document.getElementById (t + 'lines5').checked) qq = qq + '&lines=random';\n";
	echo "\tif (document.getElementById (t + 'trlevel1').checked) qq = qq + '&trlevel=1';\n";
	echo "\tif (document.getElementById (t + 'trlevel2').checked) qq = qq + '&trlevel=2';\n";
	echo "\tif (document.getElementById (t + 'trlevel3').checked) qq = qq + '&trlevel=3';\n";
	echo "\tif (document.getElementById (t + 'trlevel4').checked) qq = qq + '&trlevel=4';\n";
	echo "\tif (document.getElementById (t + 'trlevel5').checked) qq = qq + '&trlevel=5';\n";
	echo "\tif (document.getElementById (t + 'trlevel6').checked) qq = qq + '&trlevel=random';\n";
	echo "\tif (document.getElementById (t + 'layer1').checked) qq = qq + '&layer=single';\n";
	echo "\tif (document.getElementById (t + 'layer2').checked) qq = qq + '&layer=double';\n";
	echo "\tif (document.getElementById (t + 'layer3').checked) qq = qq + '&layer=random';\n";
	echo "\tvar im = new Image();\n";
	echo "\tblcap_refno = blcap_refno + 1;\n";
	echo "\tim.src=\"" . $captchaurl . "&refresh=\" + blcap_refno + qq;\n";
	echo "\tdocument.getElementById (\"blcap_\" + t + \"img\").src = im.src;\n";
	echo "\tdocument.getElementById (\"blcap_\" + t + \"img\").style.display = '';\n";
	
	echo "\treturn;\n";
	echo "}\n";
		
	echo "function blcap_generate_key ()\n";
	echo "{\n";
	echo "\tvar charset = \"ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789\";\n";
	echo "\tvar key = '';\n";
	echo "\tvar i, x;\n";
	echo "\tfor (x=0;x<16;x++)\n";
	echo "\t{\n";
	echo "\t\ti = Math.floor (Math.random () * 36);\n";
	echo "\t\tkey = key + charset.charAt (i);\n";
	echo "\t}\n";
	echo "\tdocument.getElementById ('blcap_protection_key').value = key;\n";
	echo "}\n";
    
	echo "\n";
	echo "</script>\n";
	echo "\n";
	
	echo "<h2 style=\"color: lightblue;\">Blue Captcha - Options</h2>\n";

	$menu = "general";
	if (isset ($_REQUEST["blcap_save"]))
	{
		$settings = array ();
		foreach ($_REQUEST as $key => $value)
		{
			if (substr ($key, 0, 3) == "log")
				$settings["$key"] = $value;
			if (substr ($key, 0, 3) == "reg")
				$settings["$key"] = $value;
			if (substr ($key, 0, 3) == "pwd")
				$settings["$key"] = $value;
			if (substr ($key, 0, 3) == "com")
				$settings["$key"] = $value;
			if (substr ($key, 0, 3) == "gen")
				$settings["$key"] = $value;
		}
        
        if (isset ($_REQUEST["ban_log"])) $settings["ban_log"] = 1;
        if (isset ($_REQUEST["ban_reg"])) $settings["ban_reg"] = 1;
        if (isset ($_REQUEST["ban_pwd"])) $settings["ban_pwd"] = 1;
        if (isset ($_REQUEST["ban_com"])) $settings["ban_com"] = 1;
        
        $iplist = (isset ($_REQUEST["ban_iplist"]) ? $_REQUEST["ban_iplist"] : "");
        $iplist_arr = blcap_process_ip_list ($iplist);
		$iplist_uniq = array_unique ($iplist_arr["ip"], SORT_STRING);

        $list = "";
        foreach ($iplist_uniq as $key => $thisip)
            if ($list == "") $list = $list . $thisip;
            else $list = $list . " , " . $thisip;
        
        $settings["ban_iplist"] = $list;
        
		$menu = (isset ($_REQUEST["blcap_option"]) ? $_REQUEST["blcap_option"] : "general");
		
		add_option ("blcap_settings", $settings);
		update_option ("blcap_settings", $settings);
        
        $blcap_protection_key = (isset ($_REQUEST["blcap_protection_key"]) ? $_REQUEST["blcap_protection_key"] : "");
        $blcap_protection_key = stripslashes (str_replace ("\"", "'", $blcap_protection_key));
		
        add_option ("blcap_protection_key", $blcap_protection_key);
		update_option ("blcap_protection_key", $blcap_protection_key);        
	}
	
    $blcap_protection_key = "";
    $blcap_protection_key = get_option ("blcap_protection_key");
    
	$blcap_setser = get_option ("blcap_settings");

	if ($blcap_setser != "")
	{
		if (is_array ($blcap_setser))
			$blcap_set = $blcap_setser;
		else
			$blcap_set = @unserialize ($blcap_setser);
	}
	else
	{
		$blcap_setar = array ("active" => true);
		$blcap_setser = @serialize ($blcap_setar);
		
		add_option ("blcap_settings", $blcap_setser);
		update_option ("blcap_settings", $blcap_setser);
	}
	
	echo "<div style=\"border: 3px solid blue; outline: 3px solid cyan; padding: 10px; margin: 5px; overflow: auto;\">\n";
	
	if ($menu == "general") $sclass = "blcapmenusel"; else $sclass = "blcapmenu";
	echo "<span class=\"$sclass\" id=\"blcapm1\" onclick=\"blcap_change_menu(1, 'general');\">General</span>\n";
	if ($menu == "login") $sclass = "blcapmenusel"; else $sclass = "blcapmenu";
	echo "<span class=\"$sclass\" id=\"blcapm2\" onclick=\"blcap_change_menu(2, 'login');\">Login</span>\n";
	if ($menu == "register") $sclass = "blcapmenusel"; else $sclass = "blcapmenu";
	echo "<span class=\"$sclass\" id=\"blcapm3\" onclick=\"blcap_change_menu(3, 'register');\">Register</span>\n";
	if ($menu == "password") $sclass = "blcapmenusel"; else $sclass = "blcapmenu";
	echo "<span class=\"$sclass\" id=\"blcapm4\" onclick=\"blcap_change_menu(4, 'password');\">Password Recovery</span>\n";
	if ($menu == "comment") $sclass = "blcapmenusel"; else $sclass = "blcapmenu";
	echo "<span class=\"$sclass\" id=\"blcapm5\" onclick=\"blcap_change_menu(5, 'comment');\">Comment Posting</span>\n";
	if ($menu == "blocking") $sclass = "blcapmenusel"; else $sclass = "blcapmenu";
	echo "<span class=\"$sclass\" id=\"blcapm6\" onclick=\"blcap_change_menu(6, 'blocking');\">Blocking</span>\n";

	echo "<br \>\n";
	echo "<br \>\n";
		
	echo "<form name=\"blcap_form\" id=\"blcap_form\" method=\"post\" action=\"\">\n";
	echo "\n";
	
	/* General Options */
	
	if ($menu != "general") $sstyle = " style=\"display: none;\""; else $sstyle = "";
	echo "<span id=\"blcap_opt1\"" . $sstyle . ">\n";
	
	
	echo "<h2>General Options</h2>\n";
	
	echo "<table border=\"0\" cellspacing=\"15\" width=\"100%\" align=\"left\">\n";
	
	echo "<tbody>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Plugin Is Active\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["gen_activated"]) ? $blcap_set["gen_activated"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"gen_activated\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"gen_activated\" value=\"yes\" $checked2/>&nbsp;Yes &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Keep Actions In Log\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["gen_log"]) ? $blcap_set["gen_log"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"gen_log\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"gen_log\" value=\"yes\" $checked2/>&nbsp;Yes &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Save Additional Info In Log\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["gen_keepinfo"]) ? $blcap_set["gen_keepinfo"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"gen_keepinfo\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"gen_keepinfo\" value=\"yes\" $checked2/>&nbsp;Yes &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Save Passwords In Log\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["gen_keeppwd"]) ? $blcap_set["gen_keeppwd"] : "no");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"gen_keeppwd\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"gen_keeppwd\" value=\"yes\" $checked2/>&nbsp;Yes &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Image Size In Double Layer\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["gen_layersize"]) ? $blcap_set["gen_layersize"] : "1");
	if ($vv == "1") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "2") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"gen_layersize\" value=\"1\" $checked1/>&nbsp;Normal (200x50) &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"gen_layersize\" value=\"2\" $checked2/>&nbsp;Double (200x100) &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Refreshing Captcha Image\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["gen_refresh"]) ? $blcap_set["gen_refresh"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"gen_refresh\" value=\"no\" $checked1/>&nbsp;Unavailable &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"gen_refresh\" value=\"yes\" $checked2/>&nbsp;Available &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
    
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Keep Captcha Data In\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["gen_use_sessions"]) ? $blcap_set["gen_use_sessions"] : "1");
	if ($vv == "yes") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "no") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"gen_use_sessions\" value=\"yes\" $checked1/>&nbsp;Sessions &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"gen_use_sessions\" value=\"no\" $checked2/>&nbsp;Database &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Extra Protection Key\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$key = $blcap_protection_key;
	echo "<input type=\"text\" name=\"blcap_protection_key\" id=\"blcap_protection_key\" value=\"" . $key . "\" > &nbsp;&nbsp; <input type=\"button\" class=\"button-secondary\" title=\"Click here to generate a new random key\" onclick=\"blcap_generate_key ();\" value=\"Generate New Key\" />\n";
	echo "</td>\n";
	echo "</tr>\n";
    
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Auto Generate New Key Daily\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["gen_autogeneratekey"]) ? $blcap_set["gen_autogeneratekey"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"gen_autogeneratekey\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"gen_autogeneratekey\" value=\"yes\" $checked2/>&nbsp;Yes &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";      
	
	echo "</tbody>\n";
	
	echo "</table>\n";
	
	
	echo "</span>\n";
	
	
	/* Login Options */
	
	if ($menu != "login") $sstyle = " style=\"display: none;\""; else $sstyle = "";
	echo "<span id=\"blcap_opt2\"" . $sstyle . ">\n";
	
	echo "<h2>Login Options</h2>\n";
	
	echo "<table border=\"0\" cellspacing=\"15\" width=\"100%\" align=\"left\">\n";
	
	echo "<tbody>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Login Captcha\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_enabled"]) ? $blcap_set["log_enabled"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"log_enabled\" value=\"no\" $checked1/>&nbsp;Disabled &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"log_enabled\" value=\"yes\" $checked2/>&nbsp;Enabled &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Show Captcha To\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_user"]) ? $blcap_set["log_user"] : "0");
	if ($vv == "-1") $checked1 = "checked "; else $checked1 = "";	
	if ($vv == "0") $checked2 = "checked "; else $checked2 = "";	
	if ($vv == "7") $checked3 = "checked "; else $checked3 = "";	
	if ($vv == "10") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked4 = "checked ";
	echo "<input type=\"radio\" name=\"log_user\" value=\"-1\" $checked1/>&nbsp;Guests&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"log_user\" value=\"0\" $checked2/>&nbsp;Guests & Subscribers&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"log_user\" value=\"7\" $checked3/>&nbsp;Everyone Except Admin &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"log_user\" value=\"10\" $checked4/>&nbsp;Everyone &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Number of Chars\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 3 ; $i <= 10 ; $i++)
	{
		if (isset ($blcap_set["log_char_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"log_char" . $i . "\" name=\"log_char_" . $i . "\" onchange=\"blcap_change_prof('log');\" value=\"" . $i . "\" $checked/>&nbsp;" . $i . " &nbsp;&nbsp;\n";
	}
	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Type of Chars\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_type"]) ? $blcap_set["log_type"] : "numbers_letters");
	if ($vv == "numbers") $checked1 = "checked "; else $checked1 = "";	
	if ($vv == "letters") $checked2 = "checked "; else $checked2 = "";	
	if ($vv == "numbers_letters") $checked3 = "checked "; else $checked3 = "";	
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked3 = "checked ";	
	echo "<input type=\"radio\" id=\"log_type1\" name=\"log_type\" onchange=\"blcap_change_prof('log');\" value=\"numbers\" $checked1/>&nbsp;Only Numbers &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_type2\" name=\"log_type\" onchange=\"blcap_change_prof('log');\" value=\"letters\" $checked2/>&nbsp;Only Letters &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_type3\" name=\"log_type\" onchange=\"blcap_change_prof('log');\" value=\"numbers_letters\" $checked3/>&nbsp;Numbers & Letters &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_type4\" name=\"log_type\" onchange=\"blcap_change_prof('log');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Type of Letters\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_letter"]) ? $blcap_set["log_letter"] : "uppercase");
	if ($vv == "lowercase") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "uppercase") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "mixed") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"log_letter1\" name=\"log_letter\" onchange=\"blcap_change_prof('log');\" value=\"lowercase\" $checked1/>&nbsp;Lowercase &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_letter2\" name=\"log_letter\" onchange=\"blcap_change_prof('log');\" value=\"uppercase\" $checked2/>&nbsp;Uppercase &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_letter3\" name=\"log_letter\" onchange=\"blcap_change_prof('log');\" value=\"mixed\" $checked3/>&nbsp;Mixed &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_letter4\" name=\"log_letter\" onchange=\"blcap_change_prof('log');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Font Usage\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_font"]) ? $blcap_set["log_font"] : "yes1");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes1") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "yes2") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"log_font1\" name=\"log_font\" onchange=\"blcap_change_prof('log');\" value=\"no\" $checked1/>&nbsp;No&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_font2\" name=\"log_font\" onchange=\"blcap_change_prof('log');\" value=\"yes1\" $checked2/>&nbsp;Yes - One Font For All&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_font3\" name=\"log_font\" onchange=\"blcap_change_prof('log');\" value=\"yes2\" $checked3/>&nbsp;Yes - Different Fonts&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_font4\" name=\"log_font\" onchange=\"blcap_change_prof('log');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Available Fonts\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 1 ; $i <= 5 ; $i++)
	{
		if (isset ($blcap_set["log_availfont_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"log_availfont" . $i . "\" name=\"log_availfont_" . $i . "\" onchange=\"blcap_change_prof('log');\" value=\"" . $i . "\" $checked/>&nbsp;" . "Font" . $i . " &nbsp;&nbsp;\n";
	}	
	echo "</td>\n";
	echo "</tr>\n";
    
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Size\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	if (isset ($blcap_set["log_size_smaller"])) $checked1 = "checked "; else $checked1 = "";
	if (isset ($blcap_set["log_size_small"])) $checked2 = "checked "; else $checked2 = "";
	if (isset ($blcap_set["log_size_medium"])) $checked3 = "checked "; else $checked3 = "";
	if (isset ($blcap_set["log_size_large"])) $checked4 = "checked "; else $checked4 = "";
	if (isset ($blcap_set["log_size_larger"])) $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked4 = "checked ";
	echo "<input type=\"checkbox\" id=\"log_size1\" name=\"log_size_smaller\" onchange=\"blcap_change_prof('log');\" value=\"smaller\" $checked1/>&nbsp;Very Small &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"log_size2\" name=\"log_size_small\" onchange=\"blcap_change_prof('log');\" value=\"small\" $checked2/>&nbsp;Small &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"log_size3\" name=\"log_size_medium\" onchange=\"blcap_change_prof('log');\" value=\"medium\" $checked3/>&nbsp;Medium &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"log_size4\" name=\"log_size_large\" onchange=\"blcap_change_prof('log');\" value=\"large\" $checked4/>&nbsp;Large &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"log_size5\" name=\"log_size_larger\" onchange=\"blcap_change_prof('log');\" value=\"larger\" $checked5/>&nbsp;Very Large &nbsp;&nbsp;\n";	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Color\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_color"]) ? $blcap_set["log_color"] : "colorn");
	if ($vv == "color1") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "colorn") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "colorful") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"log_color1\" name=\"log_color\" onchange=\"blcap_change_prof('log');\" value=\"color1\" $checked1/>&nbsp;One Color For All&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_color2\" name=\"log_color\" onchange=\"blcap_change_prof('log');\" value=\"colorn\" $checked2/>&nbsp;Different Colors&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_color3\" name=\"log_color\" onchange=\"blcap_change_prof('log');\" value=\"colorful\" $checked3/>&nbsp;Colorful Chars &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_color4\" name=\"log_color\" onchange=\"blcap_change_prof('log');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Rotation\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_rotate"]) ? $blcap_set["log_rotate"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "random") $checked3 = "checked "; else $checked3 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"log_rotate1\" name=\"log_rotate\" onchange=\"blcap_change_prof('log');\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_rotate2\" name=\"log_rotate\" onchange=\"blcap_change_prof('log');\" value=\"yes\" $checked2/>&nbsp;Yes &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_rotate3\" name=\"log_rotate\" onchange=\"blcap_change_prof('log');\" value=\"random\" $checked3/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Background\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_background"]) ? $blcap_set["log_background"] : "palette");
	if ($vv == "color") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "mosaic") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "image") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "palette") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "random") $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked4 = "checked ";
	echo "<input type=\"radio\" id=\"log_background1\" name=\"log_background\" onchange=\"blcap_change_prof('log');\" value=\"color\" $checked1/>&nbsp;Single Color &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_background2\" name=\"log_background\" onchange=\"blcap_change_prof('log');\" value=\"mosaic\" $checked2/>&nbsp;Mosaic &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_background3\" name=\"log_background\" onchange=\"blcap_change_prof('log');\" value=\"image\" $checked3/>&nbsp;Image &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_background4\" name=\"log_background\" onchange=\"blcap_change_prof('log');\" value=\"palette\" $checked4/>&nbsp;Image Palette &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_background5\" name=\"log_background\" onchange=\"blcap_change_prof('log');\" value=\"random\" $checked5/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Available BG Images\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 1 ; $i <= 5 ; $i++)
	{
		if (isset ($blcap_set["log_availbg_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"log_availbg" . $i . "\" name=\"log_availbg_" . $i . "\" onchange=\"blcap_change_prof('log');\" value=\"" . $i . "\" $checked/>&nbsp;" . "Image" . $i . " &nbsp;&nbsp;\n";
	}	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Extra Drawing\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_extra"]) ? $blcap_set["log_extra"] : "no");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "lines") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "circles") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "lines_circles") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "grid") $checked5 = "checked "; else $checked5 = "";
	if ($vv == "random") $checked6 = "checked "; else $checked6 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "" && $checked6 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"log_extra1\" name=\"log_extra\" onchange=\"blcap_change_prof('log');\" value=\"no\" $checked1/>&nbsp;None &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_extra2\" name=\"log_extra\" onchange=\"blcap_change_prof('log');\" value=\"lines\" $checked2/>&nbsp;Lines &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_extra3\" name=\"log_extra\" onchange=\"blcap_change_prof('log');\" value=\"circles\" $checked3/>&nbsp;Circles &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_extra4\" name=\"log_extra\" onchange=\"blcap_change_prof('log');\" value=\"lines_circles\" $checked4/>&nbsp;Lines & Circles &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_extra5\" name=\"log_extra\" onchange=\"blcap_change_prof('log');\" value=\"grid\" $checked5/>&nbsp;Grid &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_extra6\" name=\"log_extra\" onchange=\"blcap_change_prof('log');\" value=\"random\" $checked6/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Transparent Lines\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_lines"]) ? $blcap_set["log_lines"] : "no");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "horizontal") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "vertical") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "both") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "random") $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"log_lines1\" name=\"log_lines\" onchange=\"blcap_change_prof('log');\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_lines2\" name=\"log_lines\" onchange=\"blcap_change_prof('log');\" value=\"horizontal\" $checked2/>&nbsp;Horizontal &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_lines3\" name=\"log_lines\" onchange=\"blcap_change_prof('log');\" value=\"vertical\" $checked3/>&nbsp;Vertical &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_lines4\" name=\"log_lines\" onchange=\"blcap_change_prof('log');\" value=\"both\" $checked4/>&nbsp;Horizontal & Vertical &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_lines5\" name=\"log_lines\" onchange=\"blcap_change_prof('log');\" value=\"random\" $checked5/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Line-Transparency Level\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_trlevel"]) ? $blcap_set["log_trlevel"] : "1");
	if ($vv == "1") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "2") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "3") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "4") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "5") $checked5 = "checked "; else $checked5 = "";
	if ($vv == "random") $checked6 = "checked "; else $checked6 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "" && $checked6 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"log_trlevel1\" name=\"log_trlevel\" onchange=\"blcap_change_prof('log');\" value=\"1\" $checked1/>&nbsp;1 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_trlevel2\" name=\"log_trlevel\" onchange=\"blcap_change_prof('log');\" value=\"2\" $checked2/>&nbsp;2 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_trlevel3\" name=\"log_trlevel\" onchange=\"blcap_change_prof('log');\" value=\"3\" $checked3/>&nbsp;3 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_trlevel4\" name=\"log_trlevel\" onchange=\"blcap_change_prof('log');\" value=\"4\" $checked4/>&nbsp;4 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_trlevel5\" name=\"log_trlevel\" onchange=\"blcap_change_prof('log');\" value=\"5\" $checked5/>&nbsp;5 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_trlevel6\" name=\"log_trlevel\" onchange=\"blcap_change_prof('log');\" value=\"random\" $checked6/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Captcha Layer\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_layer"]) ? $blcap_set["log_layer"] : "no");
	if ($vv == "single") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "double") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "random") $checked3 = "checked "; else $checked3 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"log_layer1\" name=\"log_layer\" onchange=\"blcap_change_prof('log');\" value=\"single\" $checked1/>&nbsp;Single &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_layer2\" name=\"log_layer\" onchange=\"blcap_change_prof('log');\" value=\"double\" $checked2/>&nbsp;Double &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"log_layer3\" name=\"log_layer\" onchange=\"blcap_change_prof('log');\" value=\"random\" $checked3/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Difficulty Level\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["log_profile"]) ? $blcap_set["log_profile"] : "8");
	echo "<select name=\"log_profile\" id=\"log_profile\">\n";
	if ($vv == "1") $selected = " selected"; else $selected = "";
	echo "<option value=\"1\"" . $selected . ">Very Easy</option>\n";
	if ($vv == "2") $selected = " selected"; else $selected = "";
	echo "<option value=\"2\"" . $selected . ">Easy</option>\n";
	if ($vv == "3") $selected = " selected"; else $selected = "";
	echo "<option value=\"3\"" . $selected . ">Medium</option>\n";
	if ($vv == "4") $selected = " selected"; else $selected = "";
	echo "<option value=\"4\"" . $selected . ">Hard</option>\n";
	if ($vv == "5") $selected = " selected"; else $selected = "";
	echo "<option value=\"5\"" . $selected . ">Very Hard</option>\n";
	if ($vv == "6") $selected = " selected"; else $selected = "";
	echo "<option value=\"6\"" . $selected . ">Too Hard</option>\n";
	if ($vv == "7") $selected = " selected"; else $selected = "";
	echo "<option value=\"7\"" . $selected . ">Impossible</option>\n";
	if ($vv == "8") $selected = " selected"; else $selected = "";
	echo "<option value=\"8\"" . $selected . ">Custom</option>\n";
	echo "</select>\n";
	echo "&nbsp; <input type=\"button\" value=\" Apply \" onclick=\"blcap_apply_profile ('log');\" title=\"Click here to apply selected profile\" />&nbsp;&nbsp;\n";
	echo "<input type=\"button\" name=\"blcap_log_preview_button\" value=\" Preview \" onclick=\"blcap_captcha_preview('log');\" title=\"Click here to preview Login Captcha\" />\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "</tbody>\n";
	
	echo "</table>\n";

	$captcha_layersize = (isset ($blcap_set["gen_layersize"]) ? $blcap_set["gen_layersize"] : "1");

	if ($captcha_layersize == "1")
		$wh_tag = "width=\"200\" height=\"50\" ";
	else
		$wh_tag = "";
				
	echo "<div align=\"center\"><img id=\"blcap_log_img\" src=\"\" " . $wh_tag . "style=\"display: none;\" /></div>\n";	
	
	echo "</span>\n";

	/* Register Options */
	
	if ($menu != "register") $sstyle = " style=\"display: none;\""; else $sstyle = "";
	echo "<span id=\"blcap_opt3\"" . $sstyle . ">\n";

	echo "<h2>Register Options</h2>\n";
	
	echo "<table border=\"0\" cellspacing=\"15\" width=\"100%\" align=\"left\">\n";
	
	echo "<tbody>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Register Captcha\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_enabled"]) ? $blcap_set["reg_enabled"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"reg_enabled\" value=\"no\" $checked1/>&nbsp;Disabled &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"reg_enabled\" value=\"yes\" $checked2/>&nbsp;Enabled &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Show Captcha To\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_user"]) ? $blcap_set["reg_user"] : "0");
	if ($vv == "-1") $checked1 = "checked "; else $checked1 = "";	
	if ($vv == "0") $checked2 = "checked "; else $checked2 = "";	
	if ($vv == "7") $checked3 = "checked "; else $checked3 = "";	
	if ($vv == "10") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked4 = "checked ";
	echo "<input type=\"radio\" name=\"reg_user\" value=\"-1\" $checked1/>&nbsp;Guests&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"reg_user\" value=\"0\" $checked2/>&nbsp;Guests & Subscribers&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"reg_user\" value=\"7\" $checked3/>&nbsp;Everyone Except Admin &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"reg_user\" value=\"10\" $checked4/>&nbsp;Everyone &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Number of Chars\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 3 ; $i <= 10 ; $i++)
	{
		if (isset ($blcap_set["reg_char_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"reg_char" . $i . "\" name=\"reg_char_" . $i . "\" onchange=\"blcap_change_prof('reg');\" value=\"" . $i . "\" $checked/>&nbsp;" . $i . " &nbsp;&nbsp;\n";
	}
	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Type of Chars\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_type"]) ? $blcap_set["reg_type"] : "numbers_letters");
	if ($vv == "numbers") $checked1 = "checked "; else $checked1 = "";	
	if ($vv == "letters") $checked2 = "checked "; else $checked2 = "";	
	if ($vv == "numbers_letters") $checked3 = "checked "; else $checked3 = "";	
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked3 = "checked ";	
	echo "<input type=\"radio\" id=\"reg_type1\" name=\"reg_type\" onchange=\"blcap_change_prof('reg');\" value=\"numbers\" $checked1/>&nbsp;Only Numbers &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_type2\" name=\"reg_type\" onchange=\"blcap_change_prof('reg');\" value=\"letters\" $checked2/>&nbsp;Only Letters &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_type3\" name=\"reg_type\" onchange=\"blcap_change_prof('reg');\" value=\"numbers_letters\" $checked3/>&nbsp;Numbers & Letters &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_type4\" name=\"reg_type\" onchange=\"blcap_change_prof('reg');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Type of Letters\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_letter"]) ? $blcap_set["reg_letter"] : "uppercase");
	if ($vv == "lowercase") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "uppercase") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "mixed") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"reg_letter1\" name=\"reg_letter\" onchange=\"blcap_change_prof('reg');\" value=\"lowercase\" $checked1/>&nbsp;Lowercase &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_letter2\" name=\"reg_letter\" onchange=\"blcap_change_prof('reg');\" value=\"uppercase\" $checked2/>&nbsp;Uppercase &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_letter3\" name=\"reg_letter\" onchange=\"blcap_change_prof('reg');\" value=\"mixed\" $checked3/>&nbsp;Mixed &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_letter4\" name=\"reg_letter\" onchange=\"blcap_change_prof('reg');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Font Usage\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_font"]) ? $blcap_set["reg_font"] : "yes1");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes1") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "yes2") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"reg_font1\" name=\"reg_font\" onchange=\"blcap_change_prof('reg');\" value=\"no\" $checked1/>&nbsp;No&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_font2\" name=\"reg_font\" onchange=\"blcap_change_prof('reg');\" value=\"yes1\" $checked2/>&nbsp;Yes - One Font For All&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_font3\" name=\"reg_font\" onchange=\"blcap_change_prof('reg');\" value=\"yes2\" $checked3/>&nbsp;Yes - Different Fonts&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_font4\" name=\"reg_font\" onchange=\"blcap_change_prof('reg');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Available Fonts\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 1 ; $i <= 5 ; $i++)
	{
		if (isset ($blcap_set["reg_availfont_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"reg_availfont" . $i . "\" name=\"reg_availfont_" . $i . "\" onchange=\"blcap_change_prof('reg');\" value=\"" . $i . "\" $checked/>&nbsp;" . "Font" . $i . " &nbsp;&nbsp;\n";
	}	
	echo "</td>\n";
	echo "</tr>\n";
    
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Size\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	if (isset ($blcap_set["reg_size_smaller"])) $checked1 = "checked "; else $checked1 = "";
	if (isset ($blcap_set["reg_size_small"])) $checked2 = "checked "; else $checked2 = "";
	if (isset ($blcap_set["reg_size_medium"])) $checked3 = "checked "; else $checked3 = "";
	if (isset ($blcap_set["reg_size_large"])) $checked4 = "checked "; else $checked4 = "";
	if (isset ($blcap_set["reg_size_larger"])) $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked4 = "checked ";
	echo "<input type=\"checkbox\" id=\"reg_size1\" name=\"reg_size_smaller\" onchange=\"blcap_change_prof('reg');\" value=\"smaller\" $checked1/>&nbsp;Very Small &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"reg_size2\" name=\"reg_size_small\" onchange=\"blcap_change_prof('reg');\" value=\"small\" $checked2/>&nbsp;Small &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"reg_size3\" name=\"reg_size_medium\" onchange=\"blcap_change_prof('reg');\" value=\"medium\" $checked3/>&nbsp;Medium &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"reg_size4\" name=\"reg_size_large\" onchange=\"blcap_change_prof('reg');\" value=\"large\" $checked4/>&nbsp;Large &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"reg_size5\" name=\"reg_size_larger\" onchange=\"blcap_change_prof('reg');\" value=\"larger\" $checked5/>&nbsp;Very Large &nbsp;&nbsp;\n";	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Color\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_color"]) ? $blcap_set["reg_color"] : "colorn");
	if ($vv == "color1") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "colorn") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "colorful") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"reg_color1\" name=\"reg_color\" onchange=\"blcap_change_prof('reg');\" value=\"color1\" $checked1/>&nbsp;One Color For All&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_color2\" name=\"reg_color\" onchange=\"blcap_change_prof('reg');\" value=\"colorn\" $checked2/>&nbsp;Different Colors&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_color3\" name=\"reg_color\" onchange=\"blcap_change_prof('reg');\" value=\"colorful\" $checked3/>&nbsp;Colorful Chars &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_color4\" name=\"reg_color\" onchange=\"blcap_change_prof('reg');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Rotation\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_rotate"]) ? $blcap_set["reg_rotate"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "random") $checked3 = "checked "; else $checked3 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"reg_rotate1\" name=\"reg_rotate\" onchange=\"blcap_change_prof('reg');\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_rotate2\" name=\"reg_rotate\" onchange=\"blcap_change_prof('reg');\" value=\"yes\" $checked2/>&nbsp;Yes &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_rotate3\" name=\"reg_rotate\" onchange=\"blcap_change_prof('reg');\" value=\"random\" $checked3/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Background\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_background"]) ? $blcap_set["reg_background"] : "palette");
	if ($vv == "color") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "mosaic") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "image") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "palette") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "random") $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked4 = "checked ";
	echo "<input type=\"radio\" id=\"reg_background1\" name=\"reg_background\" onchange=\"blcap_change_prof('reg');\" value=\"color\" $checked1/>&nbsp;Single Color &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_background2\" name=\"reg_background\" onchange=\"blcap_change_prof('reg');\" value=\"mosaic\" $checked2/>&nbsp;Mosaic &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_background3\" name=\"reg_background\" onchange=\"blcap_change_prof('reg');\" value=\"image\" $checked3/>&nbsp;Image &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_background4\" name=\"reg_background\" onchange=\"blcap_change_prof('reg');\" value=\"palette\" $checked4/>&nbsp;Image Palette &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_background5\" name=\"reg_background\" onchange=\"blcap_change_prof('reg');\" value=\"random\" $checked5/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Available BG Images\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 1 ; $i <= 5 ; $i++)
	{
		if (isset ($blcap_set["reg_availbg_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"reg_availbg" . $i . "\" name=\"reg_availbg_" . $i . "\" onchange=\"blcap_change_prof('reg');\" value=\"" . $i . "\" $checked/>&nbsp;" . "Image" . $i . " &nbsp;&nbsp;\n";
	}	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Extra Drawing\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_extra"]) ? $blcap_set["reg_extra"] : "no");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "lines") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "circles") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "lines_circles") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "grid") $checked5 = "checked "; else $checked5 = "";
	if ($vv == "random") $checked6 = "checked "; else $checked6 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "" && $checked6 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"reg_extra1\" name=\"reg_extra\" onchange=\"blcap_change_prof('reg');\" value=\"no\" $checked1/>&nbsp;None &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_extra2\" name=\"reg_extra\" onchange=\"blcap_change_prof('reg');\" value=\"lines\" $checked2/>&nbsp;Lines &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_extra3\" name=\"reg_extra\" onchange=\"blcap_change_prof('reg');\" value=\"circles\" $checked3/>&nbsp;Circles &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_extra4\" name=\"reg_extra\" onchange=\"blcap_change_prof('reg');\" value=\"lines_circles\" $checked4/>&nbsp;Lines & Circles &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_extra5\" name=\"reg_extra\" onchange=\"blcap_change_prof('reg');\" value=\"grid\" $checked5/>&nbsp;Grid &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_extra6\" name=\"reg_extra\" onchange=\"blcap_change_prof('reg');\" value=\"random\" $checked6/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Transparent Lines\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_lines"]) ? $blcap_set["reg_lines"] : "no");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "horizontal") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "vertical") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "both") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "random") $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"reg_lines1\" name=\"reg_lines\" onchange=\"blcap_change_prof('reg');\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_lines2\" name=\"reg_lines\" onchange=\"blcap_change_prof('reg');\" value=\"horizontal\" $checked2/>&nbsp;Horizontal &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_lines3\" name=\"reg_lines\" onchange=\"blcap_change_prof('reg');\" value=\"vertical\" $checked3/>&nbsp;Vertical &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_lines4\" name=\"reg_lines\" onchange=\"blcap_change_prof('reg');\" value=\"both\" $checked4/>&nbsp;Horizontal & Vertical &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_lines5\" name=\"reg_lines\" onchange=\"blcap_change_prof('reg');\" value=\"random\" $checked5/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Line-Transparency Level\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_trlevel"]) ? $blcap_set["reg_trlevel"] : "1");
	if ($vv == "1") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "2") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "3") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "4") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "5") $checked5 = "checked "; else $checked5 = "";
	if ($vv == "random") $checked6 = "checked "; else $checked6 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "" && $checked6 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"reg_trlevel1\" name=\"reg_trlevel\" onchange=\"blcap_change_prof('reg');\" value=\"1\" $checked1/>&nbsp;1 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_trlevel2\" name=\"reg_trlevel\" onchange=\"blcap_change_prof('reg');\" value=\"2\" $checked2/>&nbsp;2 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_trlevel3\" name=\"reg_trlevel\" onchange=\"blcap_change_prof('reg');\" value=\"3\" $checked3/>&nbsp;3 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_trlevel4\" name=\"reg_trlevel\" onchange=\"blcap_change_prof('reg');\" value=\"4\" $checked4/>&nbsp;4 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_trlevel5\" name=\"reg_trlevel\" onchange=\"blcap_change_prof('reg');\" value=\"5\" $checked5/>&nbsp;5 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_trlevel6\" name=\"reg_trlevel\" onchange=\"blcap_change_prof('reg');\" value=\"random\" $checked6/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Captcha Layer\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_layer"]) ? $blcap_set["reg_layer"] : "no");
	if ($vv == "single") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "double") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "random") $checked3 = "checked "; else $checked3 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"reg_layer1\" name=\"reg_layer\" onchange=\"blcap_change_prof('reg');\" value=\"single\" $checked1/>&nbsp;Single &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_layer2\" name=\"reg_layer\" onchange=\"blcap_change_prof('reg');\" value=\"double\" $checked2/>&nbsp;Double &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"reg_layer3\" name=\"reg_layer\" onchange=\"blcap_change_prof('reg');\" value=\"random\" $checked3/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Difficulty Level\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["reg_profile"]) ? $blcap_set["reg_profile"] : "8");
	echo "<select name=\"reg_profile\" id=\"reg_profile\">\n";
	if ($vv == "1") $selected = " selected"; else $selected = "";
	echo "<option value=\"1\"" . $selected . ">Very Easy</option>\n";
	if ($vv == "2") $selected = " selected"; else $selected = "";
	echo "<option value=\"2\"" . $selected . ">Easy</option>\n";
	if ($vv == "3") $selected = " selected"; else $selected = "";
	echo "<option value=\"3\"" . $selected . ">Medium</option>\n";
	if ($vv == "4") $selected = " selected"; else $selected = "";
	echo "<option value=\"4\"" . $selected . ">Hard</option>\n";
	if ($vv == "5") $selected = " selected"; else $selected = "";
	echo "<option value=\"5\"" . $selected . ">Very Hard</option>\n";
	if ($vv == "6") $selected = " selected"; else $selected = "";
	echo "<option value=\"6\"" . $selected . ">Too Hard</option>\n";
	if ($vv == "7") $selected = " selected"; else $selected = "";
	echo "<option value=\"7\"" . $selected . ">Impossible</option>\n";
	if ($vv == "8") $selected = " selected"; else $selected = "";
	echo "<option value=\"8\"" . $selected . ">Custom</option>\n";
	echo "</select>\n";
	echo "&nbsp; <input type=\"button\" value=\" Apply \" onclick=\"blcap_apply_profile ('reg');\" title=\"Click here to apply selected profile\" />&nbsp;&nbsp;\n";
	echo "<input type=\"button\" name=\"blcap_reg_preview_button\" value=\" Preview \" onclick=\"blcap_captcha_preview('reg');\" title=\"Click here to preview Register Captcha\" />\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "</tbody>\n";
	
	echo "</table>\n";

	$captcha_layersize = (isset ($blcap_set["gen_layersize"]) ? $blcap_set["gen_layersize"] : "1");

	if ($captcha_layersize == "1")
		$wh_tag = "width=\"200\" height=\"50\" ";
	else
		$wh_tag = "";
				
	echo "<div align=\"center\"><img id=\"blcap_reg_img\" src=\"\" " . $wh_tag . "style=\"display: none;\" /></div>\n";	
	
	echo "</span>\n";
	
	/* Password Recovery Options */
	
	if ($menu != "password") $sstyle = " style=\"display: none;\""; else $sstyle = "";
	echo "<span id=\"blcap_opt4\"" . $sstyle . ">\n";

	echo "<h2>Password Recovery Options</h2>\n";
	
	echo "<table border=\"0\" cellspacing=\"15\" width=\"100%\" align=\"left\">\n";
	
	echo "<tbody>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Password Recovery Captcha\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_enabled"]) ? $blcap_set["pwd_enabled"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"pwd_enabled\" value=\"no\" $checked1/>&nbsp;Disabled &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"pwd_enabled\" value=\"yes\" $checked2/>&nbsp;Enabled &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Show Captcha To\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_user"]) ? $blcap_set["pwd_user"] : "0");
	if ($vv == "-1") $checked1 = "checked "; else $checked1 = "";	
	if ($vv == "0") $checked2 = "checked "; else $checked2 = "";	
	if ($vv == "7") $checked3 = "checked "; else $checked3 = "";	
	if ($vv == "10") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked4 = "checked ";
	echo "<input type=\"radio\" name=\"pwd_user\" value=\"-1\" $checked1/>&nbsp;Guests&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"pwd_user\" value=\"0\" $checked2/>&nbsp;Guests & Subscribers&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"pwd_user\" value=\"7\" $checked3/>&nbsp;Everyone Except Admin &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"pwd_user\" value=\"10\" $checked4/>&nbsp;Everyone &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Number of Chars\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 3 ; $i <= 10 ; $i++)
	{
		if (isset ($blcap_set["pwd_char_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"pwd_char" . $i . "\" name=\"pwd_char_" . $i . "\" onchange=\"blcap_change_prof('pwd');\" value=\"" . $i . "\" $checked/>&nbsp;" . $i . " &nbsp;&nbsp;\n";
	}
	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Type of Chars\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_type"]) ? $blcap_set["pwd_type"] : "numbers_letters");
	if ($vv == "numbers") $checked1 = "checked "; else $checked1 = "";	
	if ($vv == "letters") $checked2 = "checked "; else $checked2 = "";	
	if ($vv == "numbers_letters") $checked3 = "checked "; else $checked3 = "";	
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked3 = "checked ";	
	echo "<input type=\"radio\" id=\"pwd_type1\" name=\"pwd_type\" onchange=\"blcap_change_prof('pwd');\" value=\"numbers\" $checked1/>&nbsp;Only Numbers &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_type2\" name=\"pwd_type\" onchange=\"blcap_change_prof('pwd');\" value=\"letters\" $checked2/>&nbsp;Only Letters &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_type3\" name=\"pwd_type\" onchange=\"blcap_change_prof('pwd');\" value=\"numbers_letters\" $checked3/>&nbsp;Numbers & Letters &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_type4\" name=\"pwd_type\" onchange=\"blcap_change_prof('pwd');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Type of Letters\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_letter"]) ? $blcap_set["pwd_letter"] : "uppercase");
	if ($vv == "lowercase") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "uppercase") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "mixed") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"pwd_letter1\" name=\"pwd_letter\" onchange=\"blcap_change_prof('pwd');\" value=\"lowercase\" $checked1/>&nbsp;Lowercase &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_letter2\" name=\"pwd_letter\" onchange=\"blcap_change_prof('pwd');\" value=\"uppercase\" $checked2/>&nbsp;Uppercase &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_letter3\" name=\"pwd_letter\" onchange=\"blcap_change_prof('pwd');\" value=\"mixed\" $checked3/>&nbsp;Mixed &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_letter4\" name=\"pwd_letter\" onchange=\"blcap_change_prof('pwd');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Font Usage\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_font"]) ? $blcap_set["pwd_font"] : "yes1");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes1") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "yes2") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"pwd_font1\" name=\"pwd_font\" onchange=\"blcap_change_prof('pwd');\" value=\"no\" $checked1/>&nbsp;No&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_font2\" name=\"pwd_font\" onchange=\"blcap_change_prof('pwd');\" value=\"yes1\" $checked2/>&nbsp;Yes - One Font For All&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_font3\" name=\"pwd_font\" onchange=\"blcap_change_prof('pwd');\" value=\"yes2\" $checked3/>&nbsp;Yes - Different Fonts&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_font4\" name=\"pwd_font\" onchange=\"blcap_change_prof('pwd');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Available Fonts\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 1 ; $i <= 5 ; $i++)
	{
		if (isset ($blcap_set["pwd_availfont_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"pwd_availfont" . $i . "\" name=\"pwd_availfont_" . $i . "\" onchange=\"blcap_change_prof('pwd');\" value=\"" . $i . "\" $checked/>&nbsp;" . "Font" . $i . " &nbsp;&nbsp;\n";
	}	
	echo "</td>\n";
	echo "</tr>\n";
    
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Size\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	if (isset ($blcap_set["pwd_size_smaller"])) $checked1 = "checked "; else $checked1 = "";
	if (isset ($blcap_set["pwd_size_small"])) $checked2 = "checked "; else $checked2 = "";
	if (isset ($blcap_set["pwd_size_medium"])) $checked3 = "checked "; else $checked3 = "";
	if (isset ($blcap_set["pwd_size_large"])) $checked4 = "checked "; else $checked4 = "";
	if (isset ($blcap_set["pwd_size_larger"])) $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked4 = "checked ";
	echo "<input type=\"checkbox\" id=\"pwd_size1\" name=\"pwd_size_smaller\" onchange=\"blcap_change_prof('pwd');\" value=\"smaller\" $checked1/>&nbsp;Very Small &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"pwd_size2\" name=\"pwd_size_small\" onchange=\"blcap_change_prof('pwd');\" value=\"small\" $checked2/>&nbsp;Small &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"pwd_size3\" name=\"pwd_size_medium\" onchange=\"blcap_change_prof('pwd');\" value=\"medium\" $checked3/>&nbsp;Medium &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"pwd_size4\" name=\"pwd_size_large\" onchange=\"blcap_change_prof('pwd');\" value=\"large\" $checked4/>&nbsp;Large &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"pwd_size5\" name=\"pwd_size_larger\" onchange=\"blcap_change_prof('pwd');\" value=\"larger\" $checked5/>&nbsp;Very Large &nbsp;&nbsp;\n";	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Color\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_color"]) ? $blcap_set["pwd_color"] : "colorn");
	if ($vv == "color1") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "colorn") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "colorful") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"pwd_color1\" name=\"pwd_color\" onchange=\"blcap_change_prof('pwd');\" value=\"color1\" $checked1/>&nbsp;One Color For All&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_color2\" name=\"pwd_color\" onchange=\"blcap_change_prof('pwd');\" value=\"colorn\" $checked2/>&nbsp;Different Colors&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_color3\" name=\"pwd_color\" onchange=\"blcap_change_prof('pwd');\" value=\"colorful\" $checked3/>&nbsp;Colorful Chars &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_color4\" name=\"pwd_color\" onchange=\"blcap_change_prof('pwd');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Rotation\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_rotate"]) ? $blcap_set["pwd_rotate"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "random") $checked3 = "checked "; else $checked3 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"pwd_rotate1\" name=\"pwd_rotate\" onchange=\"blcap_change_prof('pwd');\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_rotate2\" name=\"pwd_rotate\" onchange=\"blcap_change_prof('pwd');\" value=\"yes\" $checked2/>&nbsp;Yes &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_rotate3\" name=\"pwd_rotate\" onchange=\"blcap_change_prof('pwd');\" value=\"random\" $checked3/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Background\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_background"]) ? $blcap_set["pwd_background"] : "palette");
	if ($vv == "color") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "mosaic") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "image") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "palette") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "random") $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked4 = "checked ";
	echo "<input type=\"radio\" id=\"pwd_background1\" name=\"pwd_background\" onchange=\"blcap_change_prof('pwd');\" value=\"color\" $checked1/>&nbsp;Single Color &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_background2\" name=\"pwd_background\" onchange=\"blcap_change_prof('pwd');\" value=\"mosaic\" $checked2/>&nbsp;Mosaic &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_background3\" name=\"pwd_background\" onchange=\"blcap_change_prof('pwd');\" value=\"image\" $checked3/>&nbsp;Image &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_background4\" name=\"pwd_background\" onchange=\"blcap_change_prof('pwd');\" value=\"palette\" $checked4/>&nbsp;Image Palette &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_background5\" name=\"pwd_background\" onchange=\"blcap_change_prof('pwd');\" value=\"random\" $checked5/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Available BG Images\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 1 ; $i <= 5 ; $i++)
	{
		if (isset ($blcap_set["pwd_availbg_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"pwd_availbg" . $i . "\" name=\"pwd_availbg_" . $i . "\" onchange=\"blcap_change_prof('pwd');\" value=\"" . $i . "\" $checked/>&nbsp;" . "Image" . $i . " &nbsp;&nbsp;\n";
	}	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Extra Drawing\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_extra"]) ? $blcap_set["pwd_extra"] : "no");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "lines") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "circles") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "lines_circles") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "grid") $checked5 = "checked "; else $checked5 = "";
	if ($vv == "random") $checked6 = "checked "; else $checked6 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "" && $checked6 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"pwd_extra1\" name=\"pwd_extra\" onchange=\"blcap_change_prof('pwd');\" value=\"no\" $checked1/>&nbsp;None &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_extra2\" name=\"pwd_extra\" onchange=\"blcap_change_prof('pwd');\" value=\"lines\" $checked2/>&nbsp;Lines &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_extra3\" name=\"pwd_extra\" onchange=\"blcap_change_prof('pwd');\" value=\"circles\" $checked3/>&nbsp;Circles &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_extra4\" name=\"pwd_extra\" onchange=\"blcap_change_prof('pwd');\" value=\"lines_circles\" $checked4/>&nbsp;Lines & Circles &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_extra5\" name=\"pwd_extra\" onchange=\"blcap_change_prof('pwd');\" value=\"grid\" $checked5/>&nbsp;Grid &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_extra6\" name=\"pwd_extra\" onchange=\"blcap_change_prof('pwd');\" value=\"random\" $checked6/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Transparent Lines\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_lines"]) ? $blcap_set["pwd_lines"] : "no");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "horizontal") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "vertical") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "both") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "random") $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"pwd_lines1\" name=\"pwd_lines\" onchange=\"blcap_change_prof('pwd');\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_lines2\" name=\"pwd_lines\" onchange=\"blcap_change_prof('pwd');\" value=\"horizontal\" $checked2/>&nbsp;Horizontal &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_lines3\" name=\"pwd_lines\" onchange=\"blcap_change_prof('pwd');\" value=\"vertical\" $checked3/>&nbsp;Vertical &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_lines4\" name=\"pwd_lines\" onchange=\"blcap_change_prof('pwd');\" value=\"both\" $checked4/>&nbsp;Horizontal & Vertical &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_lines5\" name=\"pwd_lines\" onchange=\"blcap_change_prof('pwd');\" value=\"random\" $checked5/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Line-Transparency Level\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_trlevel"]) ? $blcap_set["pwd_trlevel"] : "1");
	if ($vv == "1") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "2") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "3") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "4") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "5") $checked5 = "checked "; else $checked5 = "";
	if ($vv == "random") $checked6 = "checked "; else $checked6 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "" && $checked6 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"pwd_trlevel1\" name=\"pwd_trlevel\" onchange=\"blcap_change_prof('pwd');\" value=\"1\" $checked1/>&nbsp;1 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_trlevel2\" name=\"pwd_trlevel\" onchange=\"blcap_change_prof('pwd');\" value=\"2\" $checked2/>&nbsp;2 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_trlevel3\" name=\"pwd_trlevel\" onchange=\"blcap_change_prof('pwd');\" value=\"3\" $checked3/>&nbsp;3 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_trlevel4\" name=\"pwd_trlevel\" onchange=\"blcap_change_prof('pwd');\" value=\"4\" $checked4/>&nbsp;4 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_trlevel5\" name=\"pwd_trlevel\" onchange=\"blcap_change_prof('pwd');\" value=\"5\" $checked5/>&nbsp;5 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_trlevel6\" name=\"pwd_trlevel\" onchange=\"blcap_change_prof('pwd');\" value=\"random\" $checked6/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Captcha Layer\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_layer"]) ? $blcap_set["pwd_layer"] : "no");
	if ($vv == "single") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "double") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "random") $checked3 = "checked "; else $checked3 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"pwd_layer1\" name=\"pwd_layer\" onchange=\"blcap_change_prof('pwd');\" value=\"single\" $checked1/>&nbsp;Single &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_layer2\" name=\"pwd_layer\" onchange=\"blcap_change_prof('pwd');\" value=\"double\" $checked2/>&nbsp;Double &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"pwd_layer3\" name=\"pwd_layer\" onchange=\"blcap_change_prof('pwd');\" value=\"random\" $checked3/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Difficulty Level\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["pwd_profile"]) ? $blcap_set["pwd_profile"] : "8");
	echo "<select name=\"pwd_profile\" id=\"pwd_profile\">\n";
	if ($vv == "1") $selected = " selected"; else $selected = "";
	echo "<option value=\"1\"" . $selected . ">Very Easy</option>\n";
	if ($vv == "2") $selected = " selected"; else $selected = "";
	echo "<option value=\"2\"" . $selected . ">Easy</option>\n";
	if ($vv == "3") $selected = " selected"; else $selected = "";
	echo "<option value=\"3\"" . $selected . ">Medium</option>\n";
	if ($vv == "4") $selected = " selected"; else $selected = "";
	echo "<option value=\"4\"" . $selected . ">Hard</option>\n";
	if ($vv == "5") $selected = " selected"; else $selected = "";
	echo "<option value=\"5\"" . $selected . ">Very Hard</option>\n";
	if ($vv == "6") $selected = " selected"; else $selected = "";
	echo "<option value=\"6\"" . $selected . ">Too Hard</option>\n";
	if ($vv == "7") $selected = " selected"; else $selected = "";
	echo "<option value=\"7\"" . $selected . ">Impossible</option>\n";
	if ($vv == "8") $selected = " selected"; else $selected = "";
	echo "<option value=\"8\"" . $selected . ">Custom</option>\n";
	echo "</select>\n";
	echo "&nbsp; <input type=\"button\" value=\" Apply \" onclick=\"blcap_apply_profile ('pwd');\" title=\"Click here to apply selected profile\" />&nbsp;&nbsp;\n";
	echo "<input type=\"button\" name=\"blcap_pwd_preview_button\" value=\" Preview \" onclick=\"blcap_captcha_preview('pwd');\" title=\"Click here to preview Password Recovery Captcha\" />\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "</tbody>\n";
	
	echo "</table>\n";
		
	$captcha_layersize = (isset ($blcap_set["gen_layersize"]) ? $blcap_set["gen_layersize"] : "1");

	if ($captcha_layersize == "1")
		$wh_tag = "width=\"200\" height=\"50\" ";
	else
		$wh_tag = "";
				
	echo "<div align=\"center\"><img id=\"blcap_pwd_img\" src=\"\" " . $wh_tag . "style=\"display: none;\" /></div>\n";		
	
	echo "</span>\n";
	
	/* Comment Options */
	
	if ($menu != "comment") $sstyle = " style=\"display: none;\""; else $sstyle = "";
	echo "<span id=\"blcap_opt5\"" . $sstyle . ">\n";

	echo "<h2>Comment Options</h2>\n";
	
	echo "<table border=\"0\" cellspacing=\"15\" width=\"100%\" align=\"left\">\n";
	
	echo "<tbody>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Comment Captcha\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_enabled"]) ? $blcap_set["com_enabled"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($checked1 == "" && $checked2 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" name=\"com_enabled\" value=\"no\" $checked1/>&nbsp;Disabled &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"com_enabled\" value=\"yes\" $checked2/>&nbsp;Enabled &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Show Captcha To\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_user"]) ? $blcap_set["com_user"] : "0");
	if ($vv == "-1") $checked1 = "checked "; else $checked1 = "";	
	if ($vv == "0") $checked2 = "checked "; else $checked2 = "";	
	if ($vv == "7") $checked3 = "checked "; else $checked3 = "";	
	if ($vv == "10") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked4 = "checked ";
	echo "<input type=\"radio\" name=\"com_user\" value=\"-1\" $checked1/>&nbsp;Guests&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"com_user\" value=\"0\" $checked2/>&nbsp;Guests & Subscribers&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"com_user\" value=\"7\" $checked3/>&nbsp;Everyone Except Admin &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" name=\"com_user\" value=\"10\" $checked4/>&nbsp;Everyone &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Number of Chars\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 3 ; $i <= 10 ; $i++)
	{
		if (isset ($blcap_set["com_char_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"com_char" . $i . "\" name=\"com_char_" . $i . "\" onchange=\"blcap_change_prof('com');\" value=\"" . $i . "\" $checked/>&nbsp;" . $i . " &nbsp;&nbsp;\n";
	}
	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Type of Chars\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_type"]) ? $blcap_set["com_type"] : "numbers_letters");
	if ($vv == "numbers") $checked1 = "checked "; else $checked1 = "";	
	if ($vv == "letters") $checked2 = "checked "; else $checked2 = "";	
	if ($vv == "numbers_letters") $checked3 = "checked "; else $checked3 = "";	
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked3 = "checked ";	
	echo "<input type=\"radio\" id=\"com_type1\" name=\"com_type\" onchange=\"blcap_change_prof('com');\" value=\"numbers\" $checked1/>&nbsp;Only Numbers &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_type2\" name=\"com_type\" onchange=\"blcap_change_prof('com');\" value=\"letters\" $checked2/>&nbsp;Only Letters &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_type3\" name=\"com_type\" onchange=\"blcap_change_prof('com');\" value=\"numbers_letters\" $checked3/>&nbsp;Numbers & Letters &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_type4\" name=\"com_type\" onchange=\"blcap_change_prof('com');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Type of Letters\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_letter"]) ? $blcap_set["com_letter"] : "uppercase");
	if ($vv == "lowercase") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "uppercase") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "mixed") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"com_letter1\" name=\"com_letter\" onchange=\"blcap_change_prof('com');\" value=\"lowercase\" $checked1/>&nbsp;Lowercase &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_letter2\" name=\"com_letter\" onchange=\"blcap_change_prof('com');\" value=\"uppercase\" $checked2/>&nbsp;Uppercase &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_letter3\" name=\"com_letter\" onchange=\"blcap_change_prof('com');\" value=\"mixed\" $checked3/>&nbsp;Mixed &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_letter4\" name=\"com_letter\" onchange=\"blcap_change_prof('com');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Font Usage\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_font"]) ? $blcap_set["com_font"] : "yes1");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes1") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "yes2") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"com_font1\" name=\"com_font\" onchange=\"blcap_change_prof('com');\" value=\"no\" $checked1/>&nbsp;No&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_font2\" name=\"com_font\" onchange=\"blcap_change_prof('com');\" value=\"yes1\" $checked2/>&nbsp;Yes - One Font For All&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_font3\" name=\"com_font\" onchange=\"blcap_change_prof('com');\" value=\"yes2\" $checked3/>&nbsp;Yes - Different Fonts&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_font4\" name=\"com_font\" onchange=\"blcap_change_prof('com');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Available Fonts\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 1 ; $i <= 5 ; $i++)
	{
		if (isset ($blcap_set["com_availfont_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"com_availfont" . $i . "\" name=\"com_availfont_" . $i . "\" onchange=\"blcap_change_prof('com');\" value=\"" . $i . "\" $checked/>&nbsp;" . "Font" . $i . " &nbsp;&nbsp;\n";
	}	
	echo "</td>\n";
	echo "</tr>\n";
    
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Size\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	if (isset ($blcap_set["com_size_smaller"])) $checked1 = "checked "; else $checked1 = "";
	if (isset ($blcap_set["com_size_small"])) $checked2 = "checked "; else $checked2 = "";
	if (isset ($blcap_set["com_size_medium"])) $checked3 = "checked "; else $checked3 = "";
	if (isset ($blcap_set["com_size_large"])) $checked4 = "checked "; else $checked4 = "";
	if (isset ($blcap_set["com_size_larger"])) $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked4 = "checked ";
	echo "<input type=\"checkbox\" id=\"com_size1\" name=\"com_size_smaller\" onchange=\"blcap_change_prof('com');\" value=\"smaller\" $checked1/>&nbsp;Very Small &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"com_size2\" name=\"com_size_small\" onchange=\"blcap_change_prof('com');\" value=\"small\" $checked2/>&nbsp;Small &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"com_size3\" name=\"com_size_medium\" onchange=\"blcap_change_prof('com');\" value=\"medium\" $checked3/>&nbsp;Medium &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"com_size4\" name=\"com_size_large\" onchange=\"blcap_change_prof('com');\" value=\"large\" $checked4/>&nbsp;Large &nbsp;&nbsp;\n";	
	echo "<input type=\"checkbox\" id=\"com_size5\" name=\"com_size_larger\" onchange=\"blcap_change_prof('com');\" value=\"larger\" $checked5/>&nbsp;Very Large &nbsp;&nbsp;\n";	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Color\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_color"]) ? $blcap_set["com_color"] : "colorn");
	if ($vv == "color1") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "colorn") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "colorful") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "random") $checked4 = "checked "; else $checked4 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"com_color1\" name=\"com_color\" onchange=\"blcap_change_prof('com');\" value=\"color1\" $checked1/>&nbsp;One Color For All&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_color2\" name=\"com_color\" onchange=\"blcap_change_prof('com');\" value=\"colorn\" $checked2/>&nbsp;Different Colors&nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_color3\" name=\"com_color\" onchange=\"blcap_change_prof('com');\" value=\"colorful\" $checked3/>&nbsp;Colorful Chars &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_color4\" name=\"com_color\" onchange=\"blcap_change_prof('com');\" value=\"random\" $checked4/>&nbsp;Random &nbsp;&nbsp;\n";	
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Char Rotation\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_rotate"]) ? $blcap_set["com_rotate"] : "yes");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "yes") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "random") $checked3 = "checked "; else $checked3 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "") $checked2 = "checked ";
	echo "<input type=\"radio\" id=\"com_rotate1\" name=\"com_rotate\" onchange=\"blcap_change_prof('com');\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_rotate2\" name=\"com_rotate\" onchange=\"blcap_change_prof('com');\" value=\"yes\" $checked2/>&nbsp;Yes &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_rotate3\" name=\"com_rotate\" onchange=\"blcap_change_prof('com');\" value=\"random\" $checked3/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Background\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_background"]) ? $blcap_set["com_background"] : "palette");
	if ($vv == "color") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "mosaic") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "image") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "palette") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "random") $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked4 = "checked ";
	echo "<input type=\"radio\" id=\"com_background1\" name=\"com_background\" onchange=\"blcap_change_prof('com');\" value=\"color\" $checked1/>&nbsp;Single Color &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_background2\" name=\"com_background\" onchange=\"blcap_change_prof('com');\" value=\"mosaic\" $checked2/>&nbsp;Mosaic &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_background3\" name=\"com_background\" onchange=\"blcap_change_prof('com');\" value=\"image\" $checked3/>&nbsp;Image &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_background4\" name=\"com_background\" onchange=\"blcap_change_prof('com');\" value=\"palette\" $checked4/>&nbsp;Image Palette &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_background5\" name=\"com_background\" onchange=\"blcap_change_prof('com');\" value=\"random\" $checked5/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Available BG Images\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	for ($i = 1 ; $i <= 5 ; $i++)
	{
		if (isset ($blcap_set["com_availbg_" . $i])) $checked = "checked "; else $checked = "";
		echo "<input type=\"checkbox\" id=\"com_availbg" . $i . "\" name=\"com_availbg_" . $i . "\" onchange=\"blcap_change_prof('com');\" value=\"" . $i . "\" $checked/>&nbsp;" . "Image" . $i . " &nbsp;&nbsp;\n";
	}
	echo "</td>\n";
	echo "</tr>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Extra Drawing\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_extra"]) ? $blcap_set["com_extra"] : "no");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "lines") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "circles") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "lines_circles") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "grid") $checked5 = "checked "; else $checked5 = "";
	if ($vv == "random") $checked6 = "checked "; else $checked6 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "" && $checked6 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"com_extra1\" name=\"com_extra\" onchange=\"blcap_change_prof('com');\" value=\"no\" $checked1/>&nbsp;None &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_extra2\" name=\"com_extra\" onchange=\"blcap_change_prof('com');\" value=\"lines\" $checked2/>&nbsp;Lines &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_extra3\" name=\"com_extra\" onchange=\"blcap_change_prof('com');\" value=\"circles\" $checked3/>&nbsp;Circles &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_extra4\" name=\"com_extra\" onchange=\"blcap_change_prof('com');\" value=\"lines_circles\" $checked4/>&nbsp;Lines & Circles &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_extra5\" name=\"com_extra\" onchange=\"blcap_change_prof('com');\" value=\"grid\" $checked5/>&nbsp;Grid &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_extra6\" name=\"com_extra\" onchange=\"blcap_change_prof('com');\" value=\"random\" $checked6/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Transparent Lines\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_lines"]) ? $blcap_set["com_lines"] : "no");
	if ($vv == "no") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "horizontal") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "vertical") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "both") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "random") $checked5 = "checked "; else $checked5 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"com_lines1\" name=\"com_lines\" onchange=\"blcap_change_prof('com');\" value=\"no\" $checked1/>&nbsp;No &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_lines2\" name=\"com_lines\" onchange=\"blcap_change_prof('com');\" value=\"horizontal\" $checked2/>&nbsp;Horizontal &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_lines3\" name=\"com_lines\" onchange=\"blcap_change_prof('com');\" value=\"vertical\" $checked3/>&nbsp;Vertical &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_lines4\" name=\"com_lines\" onchange=\"blcap_change_prof('com');\" value=\"both\" $checked4/>&nbsp;Horizontal & Vertical &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_lines5\" name=\"com_lines\" onchange=\"blcap_change_prof('com');\" value=\"random\" $checked5/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Line-Transparency Level\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_trlevel"]) ? $blcap_set["com_trlevel"] : "1");
	if ($vv == "1") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "2") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "3") $checked3 = "checked "; else $checked3 = "";
	if ($vv == "4") $checked4 = "checked "; else $checked4 = "";
	if ($vv == "5") $checked5 = "checked "; else $checked5 = "";
	if ($vv == "random") $checked6 = "checked "; else $checked6 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "" && $checked4 == "" && $checked5 == "" && $checked6 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"com_trlevel1\" name=\"com_trlevel\" onchange=\"blcap_change_prof('com');\" value=\"1\" $checked1/>&nbsp;1 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_trlevel2\" name=\"com_trlevel\" onchange=\"blcap_change_prof('com');\" value=\"2\" $checked2/>&nbsp;2 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_trlevel3\" name=\"com_trlevel\" onchange=\"blcap_change_prof('com');\" value=\"3\" $checked3/>&nbsp;3 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_trlevel4\" name=\"com_trlevel\" onchange=\"blcap_change_prof('com');\" value=\"4\" $checked4/>&nbsp;4 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_trlevel5\" name=\"com_trlevel\" onchange=\"blcap_change_prof('com');\" value=\"5\" $checked5/>&nbsp;5 &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_trlevel6\" name=\"com_trlevel\" onchange=\"blcap_change_prof('com');\" value=\"random\" $checked6/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Captcha Layer\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_layer"]) ? $blcap_set["com_layer"] : "no");
	if ($vv == "single") $checked1 = "checked "; else $checked1 = "";
	if ($vv == "double") $checked2 = "checked "; else $checked2 = "";
	if ($vv == "random") $checked3 = "checked "; else $checked3 = "";
	if ($checked1 == "" && $checked2 == "" && $checked3 == "") $checked1 = "checked ";
	echo "<input type=\"radio\" id=\"com_layer1\" name=\"com_layer\" onchange=\"blcap_change_prof('com');\" value=\"single\" $checked1/>&nbsp;Single &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_layer2\" name=\"com_layer\" onchange=\"blcap_change_prof('com');\" value=\"double\" $checked2/>&nbsp;Double &nbsp;&nbsp;\n";
	echo "<input type=\"radio\" id=\"com_layer3\" name=\"com_layer\" onchange=\"blcap_change_prof('com');\" value=\"random\" $checked3/>&nbsp;Random &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Difficulty Level\n";
	echo "</td>\n\n";
	echo "<td width=\"75%\">\n";
	$vv = (isset ($blcap_set["com_profile"]) ? $blcap_set["com_profile"] : "8");
	echo "<select name=\"com_profile\" id=\"com_profile\">\n";
	if ($vv == "1") $selected = " selected"; else $selected = "";
	echo "<option value=\"1\"" . $selected . ">Very Easy</option>\n";
	if ($vv == "2") $selected = " selected"; else $selected = "";
	echo "<option value=\"2\"" . $selected . ">Easy</option>\n";
	if ($vv == "3") $selected = " selected"; else $selected = "";
	echo "<option value=\"3\"" . $selected . ">Medium</option>\n";
	if ($vv == "4") $selected = " selected"; else $selected = "";
	echo "<option value=\"4\"" . $selected . ">Hard</option>\n";
	if ($vv == "5") $selected = " selected"; else $selected = "";
	echo "<option value=\"5\"" . $selected . ">Very Hard</option>\n";
	if ($vv == "6") $selected = " selected"; else $selected = "";
	echo "<option value=\"6\"" . $selected . ">Too Hard</option>\n";
	if ($vv == "7") $selected = " selected"; else $selected = "";
	echo "<option value=\"7\"" . $selected . ">Impossible</option>\n";
	if ($vv == "8") $selected = " selected"; else $selected = "";
	echo "<option value=\"8\"" . $selected . ">Custom</option>\n";
	echo "</select>\n";
	echo "&nbsp; <input type=\"button\" value=\" Apply \" onclick=\"blcap_apply_profile ('com');\" title=\"Click here to apply selected profile\" />&nbsp;&nbsp;\n";
	echo "<input type=\"button\" name=\"blcap_com_preview_button\" value=\" Preview \" onclick=\"blcap_captcha_preview('com');\" title=\"Click here to preview Comment Captcha\" />\n";
	echo "</td>\n";
	echo "</tr>\n";	
	
	echo "</tbody>\n";
	
	echo "</table>\n";
	
	$captcha_layersize = (isset ($blcap_set["gen_layersize"]) ? $blcap_set["gen_layersize"] : "1");

	if ($captcha_layersize == "1")
		$wh_tag = "width=\"200\" height=\"50\" ";
	else
		$wh_tag = "";
				
	echo "<div align=\"center\"><img id=\"blcap_com_img\" src=\"\" " . $wh_tag . "style=\"display: none;\" /></div>\n";
	
	echo "</span>\n";	
	
	/* Blocking Options */
	
	if ($menu != "blocking") $sstyle = " style=\"display: none;\""; else $sstyle = "";
	echo "<span id=\"blcap_opt6\"" . $sstyle . ">\n";
	
	echo "<h2>Blocking Options</h2>\n";
	
	echo "<table border=\"0\" cellspacing=\"15\" width=\"100%\" align=\"left\">\n";
	
	echo "<tbody>\n";
	
	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Banned IP Addresses\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	$baniplist = (isset ($blcap_set["ban_iplist"]) ? $blcap_set["ban_iplist"] : "");
    echo "<textarea name=\"ban_iplist\" rows=\"20\" cols=\"60\">";
    echo $baniplist;
    echo "</textarea>\n";
	echo "</td>\n";
	echo "</tr>\n";

	echo "\n<tr>\n";
	echo "<td width=\"25%\">\n";
	echo "Apply To\n";
	echo "</td>\n";
	echo "<td width=\"75%\">\n";
	if (isset ($blcap_set["ban_log"])) $checked = "checked "; else $checked = "";
	echo "<input type=\"checkbox\" name=\"ban_log\" value=\"1\" $checked />&nbsp; Login &nbsp;&nbsp;\n";
	if (isset ($blcap_set["ban_reg"])) $checked = "checked "; else $checked = "";
	echo "<input type=\"checkbox\" name=\"ban_reg\" value=\"1\" $checked />&nbsp; Register &nbsp;&nbsp;\n";
	if (isset ($blcap_set["ban_pwd"])) $checked = "checked "; else $checked = "";
	echo "<input type=\"checkbox\" name=\"ban_pwd\" value=\"1\" $checked />&nbsp; Password Recovery &nbsp;&nbsp;\n";
	if (isset ($blcap_set["ban_com"])) $checked = "checked "; else $checked = "";
	echo "<input type=\"checkbox\" name=\"ban_com\" value=\"1\" $checked />&nbsp; Comment Posting &nbsp;&nbsp;\n";
	echo "</td>\n";
	echo "</tr>\n";
    
	
	echo "</tbody>\n";
	
	echo "</table>\n";
	
	echo "</span>\n";


	echo "<br>\n";
	
	echo "<div align=\"center\">\n";
	echo "<input type=\"submit\" class=\"button-primary\" name=\"blcap_submit_button\" value=\" Save \" title=\"Click here to save settings\" />&nbsp;&nbsp;\n";
	echo "<input type=\"reset\" class=\"button-secondary\"  name=\"blcap_reset_button\" value=\" Reset \" title=\"Click here to reset value settings\" />&nbsp; \n";
	echo "<input type=\"hidden\" name=\"blcap_save\" value=\"save\" />\n";
	echo "<input type=\"hidden\" id=\"blcap_option\" name=\"blcap_option\" value=\"$menu\" />\n";
	echo "</div>\n";
	
	echo "\n";
	echo "</form>\n";
	
	echo "</div>\n";
?>