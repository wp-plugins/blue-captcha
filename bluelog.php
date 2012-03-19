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
	
	$rpp_logs = 25;
		
	$action = "";
	if (isset($_REQUEST["action"])) $action = $_REQUEST["action"];
	
	if (isset ($_REQUEST["kindf"])) $kindf = urldecode ($_REQUEST["kindf"]);
	else $kindf = "";	
	if (isset ($_REQUEST["typef"])) $typef = urldecode ($_REQUEST["typef"]);
	else $typef = "";
	if (isset ($_REQUEST["datef"])) $datef = urldecode ($_REQUEST["datef"]);
	else $datef = "";
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
	else $resf = $rpp_logs;

	if ($action == "apply_filter")
	{
		if (isset ($_POST["sel_kind"])) $kindf = $_POST["sel_kind"];
		if (isset ($_POST["sel_type"])) $typef = $_POST["sel_type"];
		if (isset ($_POST["blcap_log_date_filter"])) $datef = $_POST["blcap_log_date_filter"];
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

		$logs = "";
			
		if (isset($_REQUEST["logs"])) $logs = $_REQUEST["logs"];

		if ($logs == "") $res = "ERROR";
		if ($action == "deleteall") $res = "OK";
				
		if ($res == "OK")
		{
			if ($action == "deleteall")
				$res2 = blcap_delete_logs ("");
			else
				$res2 = blcap_delete_logs ($logs);
				
			if ($res2["result"] == "OK")
			{
				echo "<div align=\"center\"><div class=\"updated\">\n";
				echo "<br><b>Log(s) successfully deleted!</b>";
				echo "<br><br></div></div>\n";
			}
			else
			{
				echo "<div align=\"center\"><div class=\"updated\">\n";
				echo "<br>An error occurred.<br>";
				echo $res2["errorcode"] . " : " . $res2["errormessage"];
				echo "<br><br></div></div>\n";
			}
		}
		else
		{
			echo "<div align=\"center\"><div class=\"updated\">\n";
			echo "<br><b>No Logs Selected</b>";
			echo "<br><br></div></div>\n";
		}
		echo "<br>\n";
	}	

	$reslist = "10#25#50#75#100#200#250#400#500#750#1000";

	if (!isset ($kindf)) $kindf = "";
	if (!isset ($typef)) $typef = "";
	if (!isset ($datef)) $datef = "";
	if (!isset ($pagef))
	{
		$pagef = 1;
		$last_page = "YES";
	}
	if (!isset ($resf)) $resf = $rpp_logs;
	
	if ($resf === "" || !is_numeric ($resf)) $resf = $rpp_logs;
	if ($resf < 10) $resf = 10;
	if ($resf > 1000) $resf = 1000;
	
	if ($pagef === "" || !is_numeric ($pagef)) $pagef = 1;
	if ($pagef < 1) $pagef = 1;
	
	if (round ($pagef) != $pagef) $pagef = round ($pagef);
	if (round ($resf) != $resf) $resf = round ($resf);
		
	$date_found = 0;
	
	$res0 = blcap_get_log_dates ();
	
	if ($res0["result"] != "OK") 
	{
		echo "<div align=\"center\"><div class=\"updated\">\n";
		echo "<br>An error occurred.<br>";
		echo $res0["errorcode"] . " : " . $res0["errormessage"];
		echo "<br><br></div></div>\n";
		echo "<br>\n";
	}
	else
	{
		$dates = $res0["count"];
		$datef = urldecode ($datef);
		
		if ($datef === "" && $dates > 0)
		{
			if (isset ($res0[0]["date"])) $firstdate = $res0[0]["date"];
			else $firstdate = "";
			$datef = $firstdate;
		}

		for ($i = 0 ; $i < $dates ; $i++)
		{
			if (isset ($res0[$i]["date"])) $date = $res0[$i]["date"];
				else $date = "";
			if ($datef == $date)
			{
				$date_found = 1;
				break;
			}
		}

		if ($datef == "ALL") $date_found = 1;
		
		if ($date_found == 0)
		{
			if (isset ($res0[0]["date"])) $firstdate = $res0[0]["date"];
			else $firstdate = "";
			$datef = $firstdate;
		}
	}

	$filt_date = $datef;
	if ($filt_date == "ALL") $filt_date = "";
	
	if (!isset ($last_page)) $last_page = "NO";

	$res = blcap_get_logs ($filt_date, "id", $kindf, $typef, $resf, $pagef, $last_page);
	if ($res["result"] == "OK")
	{
		$count = $res["count"];
		$totaltexts = $res["total"];
		$totalpages = $res["totalpages"];
		$currentpage = $res["currentpage"];
		if ($pagef != $res["currentpage"]) $pagef = $res["currentpage"];
				
		$size = $res["count"];
		
		echo "<table width=\"100%\" class=\"widefat page fixed\" cellspacing=\"0\">\n";
		echo "<thead><tr><th><div align=\"center\"><h2 style=\"color: blue;\">Blue Captcha - Log</h2></div></th></tr></thead>";
		echo "</table>\n";
		
		echo "<table width=\"100%\" class=\"widefat page fixed\" cellspacing=\"0\">\n";
		
		echo "<thead>\n";
		echo "<tr>\n";
		echo "<th colspan=\"7\"><div align=\"center\">\n";
		
		echo "<form method=\"post\" name=\"blcap_log_filter\" action=\"" . $blcap_logsite . "\">\n";
		
		echo "Pages: ";
		
		if ($totalpages > 0)
		{
			$firstpage = 1;
			$lastpage = $totalpages;
			$showxpages = 3;
			
			if ($pagef > $showxpages)
			{
				$this_page = $firstpage;
				$link = $blcap_logsite . "&p=show&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&resf=" . $resf . "&pagef=" . $this_page . "\"";
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
				$link = $blcap_logsite . "&p=show&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&resf=" . $resf . "&pagef=" . $this_page . "\"";
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
				$link = $blcap_logsite . "&p=show&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&resf=" . $resf . "&pagef=" . $this_page . "\""; 
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
		
		echo "<br>Type: ";
		echo "<select name=\"sel_kind\">\n";
		if ($kindf == "") $str = " selected"; else $str = "";
		echo "<option value=\"\"" . $str .">All Types</option>\n";
		if ($kindf == "LOGIN") $str = " selected"; else $str = "";
		echo "<option value=\"LOGIN\"" . $str .">Login</option>\n";
		if ($kindf == "REGISTER") $str = " selected"; else $str = "";
		echo "<option value=\"REGISTER\"" . $str .">Register</option>\n";
		if ($kindf == "LOST_PASSWORD") $str = " selected"; else $str = "";
		echo "<option value=\"LOST_PASSWORD\"" . $str .">Lost Password</option>\n";
		if ($kindf == "COMMENT") $str = " selected"; else $str = "";
		echo "<option value=\"COMMENT\"" . $str .">Comment</option>\n";
		echo "</select>\n";
		
		echo "Result: ";
		echo "<select name=\"sel_type\">\n";
		if ($typef == "") $str = " selected"; else $str = "";
		echo "<option value=\"\"" . $str .">All Results</option>\n";
		if ($typef == "SUCCESS") $str = " selected"; else $str = "";
		echo "<option value=\"SUCCESS\"" . $str .">Success</option>\n";
		if ($typef == "BANNED") $str = " selected"; else $str = "";
		echo "<option value=\"BANNED\"" . $str .">Banned</option>\n";
		if ($typef == "FAIL") $str = " selected"; else $str = "";
		echo "<option value=\"FAIL\"" . $str .">Fail</option>\n";
		echo "</select>\n";
		
		echo "Date: ";
		echo "<select name=\"blcap_log_date_filter\">\n";

		if ($datef == "ALL")
			$str = " selected";
		else $str = "";
		echo "<option value=\"ALL\"" . $str . ">All Dates</option>\n";
		
		for ($i = 0 ; $i < $dates ; $i++)
		{
			if (isset ($res0[$i]["date"])) $date = $res0[$i]["date"];
			else $date = "";
			$endate = urlencode ($date);
			if ($datef == $date)
				$str = " selected";
			else $str = "";
			echo "<option value=\"" . $endate . "\"" . $str . ">";
			echo "$date";
			echo "</option>\n";
		}
		echo "</select>\n";
		
		
		echo "<input type=\"submit\" class=\"button\" name=\"button_filter\" value=\"  Apply  \" />\n";
		
		echo "<input type=\"hidden\" name=\"action\" value=\"apply_filter\" />\n";
		
		echo "</form>\n";
		
		echo "</div></th>\n";
		echo "</tr>\n";
		echo "</thead>\n";
		
		echo "</table>\n";
		
		echo "<form method=\"post\" name=\"showlogsform\" id=\"showlogsform\" action=\"$blcap_logsite" . "&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&resf=" . $resf . "&pagef=" . $pagef . "\">\n";

		echo "<table width=\"100%\" class=\"widefat page fixed\" cellspacing=\"0\">\n";
		
		echo "<thead>\n";
		echo "<tr>\n";
		echo "<th width=\"4%\"><div align=\"center\"><input type=\"checkbox\" id=\"log_selall\" title=\"Select All / None\" onclick=\"blcap_logselall();\" /></div></th>\n";

		echo "<th width=\"5%\"><div align=\"center\">No</div></th>\n";
		
		echo "<th width=\"10%\"><div align=\"center\">Date & Time</div></th>\n";

		echo "<th width=\"11%\"><div align=\"center\">IP Address<br>(Proxy)</div></th>\n";

		echo "<th width=\"12%\"><div align=\"center\">Captcha<br>(# Refreshes)</div></th>\n";

		echo "<th width=\"12%\"><div align=\"center\">Response Time</div></th>\n";
		
		echo "<th width=\"11%\"><div align=\"center\">Type</div></th>\n";

		echo "<th width=\"10%\"><div align=\"center\">Result</div></th>\n";
		
		echo "<th width=\"25%\"><div align=\"center\">Additional Info</div></th>\n";
		
		echo "</thead>\n";
		
		$chclass = 'iedit';
		$startfrom = (($pagef - 1) * $resf) + 1;
		for ($i = 0 ; $i < $size ; $i++)
		{
			$no = $startfrom + $i;
			
			$log_id = $res[$i]["id"];
			$ip = $res[$i]["ip"];
			$proxy = $res[$i]["proxy"];
			$totaltime = $res[$i]["totaltime"];
			$type = $res[$i]["type"];
			$captcha = $res[$i]["captcha"];
			$refresh = $res[$i]["refresh"];
			$capres = $res[$i]["result"];
			$date = $res[$i]["date"];
			$time = $res[$i]["time"];
			$info = $res[$i]["info"];

			if (strtoupper ($capres) == "SUCCESS") $rescolor = "green";
			else if (strtoupper ($capres) == "BANNED") $rescolor = "blue";
			else $rescolor = "red";
		
			if ($chclass == "iedit")
				$chclass = "alternate iedit";
			else $chclass = "iedit";
						
			echo "<tr class=\"$chclass\">\n";
			echo "<td><div align=\"center\"><input type=\"checkbox\" id=\"log" . ($i+1) . "\" name=\"logs[]\" value=\"$log_id\"></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$no</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$date<br>$time</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$ip<br>($proxy)</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$captcha<br>($refresh)</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$totaltime</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$type</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$capres</font></div></td>\n";
			
			echo "<td><div align=\"left\"><font color=\"$rescolor\">$info</font></div></td>\n";			
			
			echo "</tr>\n";
		}
		
		echo "<input type=\"hidden\" id=\"blcap_action\" name=\"action\" value=\"delete\" />";
	
		echo "<tfoot><tr>\n";
		echo "<th colspan=\"9\">\n";
		echo "<div align=\"center\">\n";
		echo "<input type=\"button\" class=\"button-secondary\" title=\"Click here to erase the selected logs\" value=\"  Delete Selected  \" onclick=\"blcap_delselected();\" />\n";
		echo " &nbsp;&nbsp; ";
		echo "<input type=\"button\" class=\"button-primary\" title=\"Click here to erase all logs\" value=\"  Delete Log File  \" onclick=\"blcap_delall();\" />\n";
		echo " &nbsp;&nbsp; ";
		echo "<a href=\"" . $blcap_siteurl . "?bcapact=exp\" target=\"_blank\"><input type=\"button\" class=\"button-secondary\" title=\"Click here to export logs to CSV file\" value=\"  Export to CSV  \" /></a>\n";

		echo "</div>\n";
		echo "</th>\n";
		echo "</tr></tfoot>\n";
			
		echo "</form>\n";
		
		echo "</table>\n";
		
		echo "<script language='javascript'>\n";
		echo "\n";
	
		echo "function blcap_delselected ()\n";
		echo "{\n";
		echo "\t var conf = confirm (\"Are you sure that you want to delete the selected log entries?\", \"BLUE CAPTCHA\");\n";
		echo "\t if (conf) document.getElementById('showlogsform').submit();\n";
		echo "}\n";
		echo "\n";
		echo "function blcap_delall ()\n";
		echo "{\n";
		echo "\t var conf = confirm (\"Are you sure that you want to delete ALL log entries?\", \"BLUE CAPTCHA\");\n";
		echo "\t if (conf)\n";
		echo "\t {\n";
		echo "\t\t document.getElementById (\"blcap_action\").value='deleteall';\n";
		echo "\t\t document.getElementById (\"showlogsform\").submit();\n";
		echo "\t }\n";
		echo "}\n";
		echo "\n";
		echo "function blcap_logselall ()\n";
		echo "{\n";
		echo "\t var i;\n";
		echo "\t var tt = document.getElementById (\"log_selall\").checked;\n";
		echo "\t for (i=1;i<=$size;i++)\n";
		echo "\t\t document.getElementById (\"log\"+i).checked = tt;\n";
		echo "}\n";			
		echo "\n";	
		echo "</script>\n";
	}
	else 
	{
		echo "<div class='updated'>\n";
		echo "<br>An error occurred.<br>";
		echo $res["errorcode"] . " : " . $res["errormessage"];
		echo "<br><br></div>\n";
	}
	
?>