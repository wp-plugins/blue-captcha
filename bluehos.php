<?php

	echo "\n<style>";
	echo "\n";
	echo "a.blcap_pagenum\n";
	echo "{\n";
	echo "\tpadding: 4px; margin: 1px; opacity: 0.7; border: 1px solid blue; background: cyan; color: black; font-family: arial; font-weight: bold; border-radius: 5px; text-decoration: none;\n";
	echo "}\n";
	echo "a.blcap_pagenum:hover\n";
	echo "{\n";
	echo "\tpadding: 4px; margin: 1px; opacity: 0.7; border: 1px solid cyan; background: lightblue; color: red; font-family: arial; font-weight: bold; border-radius: 5px; text-decoration: none;\n";
	echo "}\n";
	echo ".blcap_pagenumsel\n";
	echo "{\n";
	echo "\tpadding: 4px; margin: 1px; opacity: 0.7; border: 1px solid cyan; background: lightblue; color: red; font-family: arial; font-weight: bold; border-radius: 5px; text-decoration: none;\n";
	echo "}\n";
	echo "\n";
	echo "</style>\n";
	
	$rpp_hos = 25;
		
	$action = "";
	if (isset($_REQUEST["action"])) $action = $_REQUEST["action"];
	
	if (isset ($_REQUEST["sortf"])) $sortf = urldecode ($_REQUEST["sortf"]);
	else $sortf = "";	
	if (isset ($_REQUEST["pagef"]))
	{
		$pagef = urldecode ($_REQUEST["pagef"]);
		$last_page = "NO";
	}
	else
	{
		$pagef = 1;
		$last_page = "YES";
	}
	if (isset ($_REQUEST["resf"])) $resf = urldecode ($_REQUEST["resf"]);
	else $resf = $rpp_hos;

	if ($action == "apply_filter")
	{
		if (isset ($_POST["sel_sort"])) $sortf = $_POST["sel_sort"];
		if (isset ($_POST["sel_page"]))
		{
			$pagef = $_POST["sel_page"];
			$last_page = "NO";
		}
		if (isset ($_POST["sel_res"])) $resf = $_POST["sel_res"];
	}
	else
	if ($action == "delete" || $action == "deleteall")
	{
		$res = "OK";

		$hos = "";
			
		if (isset($_REQUEST["hos"])) $hos = $_REQUEST["hos"];

		if ($hos == "") $res = "ERROR";
		if ($action == "deleteall") $res = "OK";
				
		if ($res == "OK")
		{
			if ($action == "deleteall")
				$res2 = blcap_delete_ip_db ("");
			else
				$res2 = blcap_delete_ip_db ($hos);
				
			if ($res2["result"] == "OK")
			{
				echo "<div align=\"center\"><div class=\"updated\">\n";
				echo "<br><b>Record(s) successfully deleted!</b>";
				echo "<br><br></div></div>\n";
			}
			else
			{
				echo "<div align=\"center\"><div class=\"updated\">\n";
				echo "<br>An error occurred.<br>";
				echo "<br></div></div>\n";
			}
		}
		else
		{
			echo "<div align=\"center\"><div class=\"updated\">\n";
			echo "<br><b>No Records Selected</b>";
			echo "<br><br></div></div>\n";
		}
		echo "<br>\n";
	}
	else
	if ($action == "ban")
	{
		$res = "OK";

		$hos = "";
			
		if (isset($_REQUEST["hos"])) $hos = $_REQUEST["hos"];

		if ($hos == "") $res = "ERROR";

		if ($res == "OK")
		{
			$settings = get_option ("blcap_settings");

			$ban_iplist = (isset ($settings["ban_iplist"]) ? $settings["ban_iplist"] : "");

			foreach ($hos as $ip)
				if (blcap_compare_ip ($ip, $ban_iplist) == false)
				{
					if ($ban_iplist == "") $ban_iplist = $ip;
					else $ban_iplist = $ban_iplist . " , " . $ip;
				}

			$settings["ban_iplist"] = $ban_iplist;

			add_option ("blcap_settings", $settings);
			update_option ("blcap_settings", $settings);
			echo "<div align=\"center\"><div class=\"updated\">\n";
			echo "<br><b>IP(s) successfully added to 'Banned IP Addresses' List!</b>";
			echo "<br><br></div></div>\n";
		}
		else
		{
			echo "<div align=\"center\"><div class=\"updated\">\n";
			echo "<br><b>No IPs Selected</b>";
			echo "<br><br></div></div>\n";
		}
		echo "<br>\n";
	}

	$reslist = "10#25#50#75#100#200#250#400#500#750#1000";

	if (!isset ($pagef))
	{
		$pagef = 1;
		$last_page = "YES";
	}
	if (!isset ($resf)) $resf = $rpp_hos;
	
	if ($resf === "" || !is_numeric ($resf)) $resf = $rpp_hos;
	if ($resf < 10) $resf = 10;
	if ($resf > 1000) $resf = 1000;
	
	if ($pagef === "" || !is_numeric ($pagef)) $pagef = 1;
	if ($pagef < 1) $pagef = 1;
	
	if (round ($pagef) != $pagef) $pagef = round ($pagef);
	if (round ($resf) != $resf) $resf = round ($resf);
	
	if (!isset ($last_page)) $last_page = "NO";

	if (!isset ($sortf)) $sortf = "";

	$res = blcap_get_ips_hos ($sortf, $resf, $pagef, $last_page);
	if ($res["result"] == "OK")
	{
		$count = $res["count"];
		$totaltexts = $res["total"];
		$totalpages = $res["totalpages"];
		$currentpage = $res["currentpage"];
		if ($pagef != $res["currentpage"]) $pagef = $res["currentpage"];
				
		$size = $res["count"];
		
		echo "<table width=\"100%\" class=\"widefat page fixed\" cellspacing=\"0\">\n";
		echo "<thead><tr><th><div align=\"center\"><h2 style=\"color: blue;\">Blue Captcha - Hall of Shame</h2></div></th></tr></thead>";
		echo "</table>\n";
		
		echo "<table width=\"100%\" class=\"widefat page fixed\" cellspacing=\"0\">\n";
		
		echo "<thead>\n";
		echo "<tr>\n";
		echo "<th colspan=\"11\"><div align=\"center\">\n";
		
		echo "<form method=\"post\" name=\"blcap_hos_filter\" action=\"" . $blcap_hossite . "\">\n";
		
		echo "Pages: ";
		
		if ($totalpages > 0)
		{
			$firstpage = 1;
			$lastpage = $totalpages;
			$showxpages = 3;
			
			if ($pagef > $showxpages)
			{
				$this_page = $firstpage;
				$link = $blcap_hossite . "&p=show&sortf=" . urlencode ($sortf) . "&resf=" . $resf . "&pagef=" . $this_page . "\"";
				echo "<a class=\"blcap_pagenum\" href=\"" . $link . "\" title=\"Go to page $this_page\">$this_page</a>";
				echo " &nbsp; ";
				echo " ... ";
				echo " &nbsp; ";
			}
			
			$beforepages = $pagef - $showxpages + 1;
			$afterpages = $pagef + $showxpages - 1;
			
			if ($beforepages < 1) $beforepages = 1;
			if ($afterpages > $lastpage) $afterpages = $lastpage;
			
			for ($k = $beforepages ; $k <= $afterpages ; $k++)
			{
				$this_page = $k;
				$link = $blcap_hossite . "&p=show&sortf=" . urlencode ($sortf) . "&resf=" . $resf . "&pagef=" . $this_page . "\"";
				if ($k == $pagef)
					echo "<span class=\"blcap_pagenumsel\">$this_page</span>";
				else
					echo "<a class=\"blcap_pagenum\" href=\"" . $link . "\" title=\"Go to page $this_page\">$this_page</a>";
				echo " &nbsp; ";
			}
			
			if ($pagef + $showxpages <= $lastpage)
			{
				echo " ... ";
				echo " &nbsp; ";
				$this_page = $lastpage;
				$link = $blcap_hossite . "&p=show&sortf=" . urlencode ($sortf) . "&resf=" . $resf . "&pagef=" . $this_page . "\""; 
				echo "<a class=\"blcap_pagenum\" href=\"" . $link . "\" title=\"Go to page $this_page\">$this_page</a>";
				echo " &nbsp; \n";
			}
		}
		else
		{
			$firstpage = 0;
			$lastpage = 0;
		}
		
		echo "&nbsp;\n";

		echo "Page: ";
		echo "<select name=\"sel_page\">\n";
		for ($k = 0 ; $k < $totalpages; $k++)
		{
			$this_page = $k + 1;
			if ($currentpage == $this_page) $str = " selected";
			else $str = "";
			echo "<option value=\"" . $this_page ."\"" . $str .">" . $this_page . "</option>\n";
		}
		echo "</select>\n";
		
		echo "&nbsp; Entries Per Page: ";

		$reslistarr = explode ("#", $reslist); 

		echo "<select name=\"sel_res\">\n";		
		for ($k = 0 ; $k < count ($reslistarr) ; $k++)
			if (isset ($reslistarr[$k]))
			{
				$resnum = $reslistarr[$k];
				if ($resf == $resnum) $str = " selected";
				else $str = "";
				echo "<option value=\"" . $resnum ."\"" . $str .">" . $resnum . "</option>\n";
			}
		echo "</select>\n";
		
		echo "&nbsp; Sort By: ";
		echo "<select name=\"sel_sort\">\n";
		if ($sortf == "sumprob") $str = " selected"; else $str = "";
		echo "<option value=\"sumprob\"" . $str .">Spam Probability</option>\n";
		if ($sortf == "failure") $str = " selected"; else $str = "";
		echo "<option value=\"failure\"" . $str .">% Failure</option>\n";
		if ($sortf == "failstotal") $str = " selected"; else $str = "";
		echo "<option value=\"failstotal\"" . $str .">Number of Total Fails</option>\n";
		if ($sortf == "trialstotal") $str = " selected"; else $str = "";
		echo "<option value=\"trialstotal\"" . $str .">Number of Total Trials</option>\n";
		if ($sortf == "microtime") $str = " selected"; else $str = "";
		echo "<option value=\"microtime\"" . $str .">Last Date</option>\n";
		if ($sortf == "ip") $str = " selected"; else $str = "";
		echo "<option value=\"ip\"" . $str .">IP Address</option>\n";
		echo "</select>\n";	
		
		echo "<input type=\"submit\" class=\"button\" name=\"button_filter\" value=\"  Apply  \" />\n";
		
		echo "<input type=\"hidden\" name=\"action\" value=\"apply_filter\" />\n";
		
		echo "</form>\n";
		
		echo "</div></th>\n";
		echo "</tr>\n";
		echo "</thead>\n";
		
		echo "</table>\n";
		
		echo "<form method=\"post\" name=\"showhosform\" id=\"showhosform\" action=\"$blcap_hossite" . "&sortf=" . urlencode ($sortf) . "&resf=" . $resf . "&pagef=" . $pagef . "\">\n";

		echo "<table width=\"100%\" class=\"widefat page fixed\" cellspacing=\"0\">\n";
		
		echo "<thead>\n";
		echo "<tr>\n";

		echo "<th scope=\"col\" class=\"manage-column column-cb check-column\" style=\"\"><input type=\"checkbox\" id=\"hos_selall\" title=\"Select All / None\" onclick=\"blcap_hosselall();\" /></th>\n";

		echo "<th width=\"4%\"><div align=\"center\">No</div></th>\n";
		
		echo "<th width=\"12%\"><div align=\"center\">IP Address</div></th>\n";

		echo "<th width=\"8%\"><div align=\"center\">Banned</div></th>\n";

		echo "<th width=\"10%\"><div align=\"center\">Last Date<br>& Time</div></th>\n";

		echo "<th width=\"10%\"><div align=\"center\"># Current<br>Fails</div></th>\n";

		echo "<th width=\"10%\"><div align=\"center\"># Current<br>Trials</div></th>\n";

		echo "<th width=\"10%\"><div align=\"center\"># Total<br>Fails</div></th>\n";

		echo "<th width=\"10%\"><div align=\"center\"># Total<br>Trials</div></th>\n";
		
		echo "<th width=\"10%\"><div align=\"center\">% Failure</div></th>\n";

		echo "<th width=\"12%\"><div align=\"center\">Average Spam<br>Probability</div></th>\n";

		echo "</tr>\n";
		echo "</thead>\n";
		
		$blcap_setser = get_option ("blcap_settings");
		if (is_array ($blcap_setser)) $sss = $blcap_setser;
		else $sss = "";

		$ban_iplist = (isset ($sss["ban_iplist"]) ? $sss["ban_iplist"] : "");
		
		$current_date = date ("Y/m/d");

		$chclass = 'iedit';
		$startfrom = (($pagef - 1) * $resf) + 1;
		for ($i = 0 ; $i < $size ; $i++)
		{
			$no = $startfrom + $i;
			$id = $res[$i]["id"];
			$ip = $res[$i]["ip"];
			$date = $res[$i]["date"];
			$time = $res[$i]["time"];
			$microtime = $res[$i]["microtime"];
			$sumprob = $res[$i]["sumprob"];
			$level = $res[$i]["level"];
			$more = $res[$i]["more"];
			$pp = $res[$i]["pp"];
			$pptotal = $res[$i]["pptotal"];
			$trialstoday = $res[$i]["trialstoday"];
			$trialstotal = $res[$i]["trialstotal"];
			$failstoday = $res[$i]["failstoday"];
			$failstotal = $res[$i]["failstotal"];
			$failure = $res[$i]["failure"];

			if ($trialstoday == "") $trialstoday = "0";
			if ($trialstotal == "") $trialstotal = "0";
			if ($failstoday == "") $failstoday = "0";
			if ($failstotal == "") $failstotal = "0";
			
			if ($date != $current_date)
			{
				$trialstoday = 0;
				$failstoday = 0;
			}

			$pos = "-";
			if ($sumprob != "" && $trialstotal > 0)
				$pos = number_format ((float)$sumprob, 1, ".", "") . " %";

			$failpercent = "-";
			if ($failure != "" && $trialstotal > 0)
				$failpercent = number_format ((float)$failure, 1, ".", "") . " %";

			$banresult = blcap_compare_ip ($ip, $ban_iplist);
			if ($banresult == false)
			{
				$banned = "No";	
				$rescolor = "black";
			}
			else
			{
				$banned = "Yes";
				$rescolor = "blue";
			}
		
			if ($chclass == "iedit")
				$chclass = "alternate iedit";
			else $chclass = "iedit";
						
			echo "<tr class=\"$chclass\">\n";

			echo "<th scope=\"row\" class=\"check-column\"><input type=\"checkbox\" id=\"hos" . ($i+1) . "\" name=\"hos[]\" value=\"$ip\"></th>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$no</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$ip</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$banned</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$date<br>$time</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$failstoday</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$trialstoday</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$failstotal</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$trialstotal</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$failpercent</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$pos</font></div></td>\n";

			echo "</tr>\n";
		}
		
		echo "<input type=\"hidden\" id=\"blcap_action\" name=\"action\" value=\"delete\" />";
	
		echo "<tfoot><tr>\n";
		echo "<th colspan=\"11\">\n";
		echo "<div align=\"center\">\n";
		echo "<input type=\"button\" class=\"button-secondary\" title=\"Click here to delete the selected HoS record(s)\" value=\"  Delete Selected \" onclick=\"blcap_delselected();\" />\n";
		echo " &nbsp;&nbsp; ";
		echo "<input type=\"button\" title=\"Click here to add the selected IP(s) into 'Banned IP Addresses' list\" value=\"  Ban Selected IP(s) \" onclick=\"blcap_banselected();\" />\n";
		echo " &nbsp;&nbsp; ";
		echo "<a href=\"" . $blcap_siteurl . "?bcapact=exphos\" target=\"_blank\"><input type=\"button\" class=\"button-secondary\" title=\"Click here to export Hall of Shame to CSV file\" value=\"  Export to CSV  \" /></a>\n";

		echo "<br /><br />";

		echo "<input type=\"button\" class=\"button-primary\" title=\"Click here to erase all HoS records\" value=\"  Clear HoS File  \" onclick=\"blcap_delall();\" />\n";

		echo "</div>\n";
		echo "</th>\n";
		echo "</tr></tfoot>\n";
			
		echo "</form>\n";
		
		echo "</table>\n";
		
		echo "<script language='javascript'>\n";
		echo "\n";
	
		echo "function blcap_delselected ()\n";
		echo "{\n";
		echo "\t var conf = confirm (\"Are you sure that you want to delete the selected records?\", \"BLUE CAPTCHA\");\n";
		echo "\t if (conf) document.getElementById('showhosform').submit();\n";
		echo "}\n";
		echo "\n";
		echo "function blcap_banselected ()\n";
		echo "{\n";
		echo "\t var conf = confirm (\"Are you sure that you want to block the selected IP(s)?\", \"BLUE CAPTCHA\");\n";
		echo "\t if (conf)\n";
		echo "\t {\n";
		echo "\t\t document.getElementById (\"blcap_action\").value='ban';\n";
		echo "\t\t document.getElementById (\"showhosform\").submit();\n";
		echo "\t }\n";
		echo "}\n";
		echo "function blcap_delall ()\n";
		echo "{\n";
		echo "\t var conf = confirm (\"Are you sure that you want to erase the entire HoS file?\", \"BLUE CAPTCHA\");\n";
		echo "\t if (conf)\n";
		echo "\t {\n";
		echo "\t\t document.getElementById (\"blcap_action\").value='deleteall';\n";
		echo "\t\t document.getElementById (\"showhosform\").submit();\n";
		echo "\t }\n";
		echo "}\n";
		echo "\n";
		echo "function blcap_hosselall ()\n";
		echo "{\n";
		echo "\t var i;\n";
		echo "\t var tt = document.getElementById (\"hos_selall\").checked;\n";
		echo "\t for (i=1;i<=$size;i++)\n";
		echo "\t\t document.getElementById (\"hos\"+i).checked = tt;\n";
		echo "}\n";			
		echo "\n";	
		echo "</script>\n";
	}
	else 
	{
		echo "<div align='center'><div class='updated'>\n";
		echo "<br>An error occurred.<br>";
		echo "<br></div></div>\n";
	}
	
?>
