<?php

	echo "\n<style>";
	echo "\n";
	echo "a.blcap_pagenum\n";
	echo "{\n";
	echo "\tpadding: 4px; margin: 1px; opacity: 0.7; -ms-filter: \"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)\"; filter: alpha(opacity=70); -moz-opacity: 0.7; -khtml-opacity: 0.7; -webkit-opacity: 0.7; border: 1px solid blue; background: cyan; color: black; font-family: arial; font-weight: bold; border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; -webkit-border-radius: 5px; -o-border-radius: 5px; text-decoration: none;\n";
	echo "}\n";
	echo "a.blcap_pagenum:hover\n";
	echo "{\n";
	echo "\tpadding: 4px; margin: 1px; opacity: 0.7; -ms-filter: \"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)\"; filter: alpha(opacity=70); -moz-opacity: 0.7; -khtml-opacity: 0.7; -webkit-opacity: 0.7; border: 1px solid cyan; background: lightblue; color: red; font-family: arial; font-weight: bold; border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; -webkit-border-radius: 5px; -o-border-radius: 5px; text-decoration: none;\n";
	echo "}\n";
	echo ".blcap_pagenumsel\n";
	echo "{\n";
	echo "\tpadding: 4px; margin: 1px; opacity: 0.7; -ms-filter: \"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)\"; filter: alpha(opacity=70); -moz-opacity: 0.7; -khtml-opacity: 0.7; -webkit-opacity: 0.7; border: 1px solid cyan; background: lightblue; color: red; font-family: arial; font-weight: bold; border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; -webkit-border-radius: 5px; -o-border-radius: 5px; text-decoration: none;\n";
	echo "}\n";
	echo "\n";
	echo "</style>\n";
	
	$MIN_INFO_LEN = 128;

	$rpp_logs = 25;
		
	$action = "";
	if (isset($_REQUEST["action"])) $action = $_REQUEST["action"];
	
	if (isset ($_REQUEST["kindf"])) $kindf = urldecode ($_REQUEST["kindf"]);
	else $kindf = "";	
	if (isset ($_REQUEST["typef"])) $typef = urldecode ($_REQUEST["typef"]);
	else $typef = "";
	if (isset ($_REQUEST["datef"])) $datef = urldecode ($_REQUEST["datef"]);
	else $datef = "";
	if (isset ($_REQUEST["ipf"])) $ipf = urldecode ($_REQUEST["ipf"]);
	else $ipf = "";

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
				echo "<br><b>" . __("Log(s) successfully deleted", "blue-captcha") . "!</b>";
				echo "<br><br></div></div>\n";
			}
			else
			{
				echo "<div align=\"center\"><div class=\"updated\">\n";
				echo "<br>" . __("An error occurred", "blue-captcha") . "<br>";
				echo "<br></div></div>\n";
			}
		}
		else
		{
			echo "<div align=\"center\"><div class=\"updated\">\n";
			echo "<br><b>" . __("No Logs Selected", "blue-captcha") . "</b>";
			echo "<br><br></div></div>\n";
		}
		echo "<br>\n";
	}	

	$reslist = "10#25#50#75#100#200#250#400#500#750#1000";

	if (!isset ($kindf)) $kindf = "";
	if (!isset ($typef)) $typef = "";
	if (!isset ($datef)) $datef = "";
	if (!isset ($ipf)) $ipf = "";
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
		echo "<br>" . __("An error occurred", "blue-captcha") . "<br>";
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

	$res = blcap_get_logs ($filt_date, "id", $kindf, $typef, $resf, $pagef, $last_page, $ipf);
	if ($res["result"] == "OK")
	{
		$count = $res["count"];
		$totaltexts = $res["total"];
		$totalpages = $res["totalpages"];
		$currentpage = $res["currentpage"];
		if ($pagef != $res["currentpage"]) $pagef = $res["currentpage"];
				
		$size = $res["count"];
		
		$info = ($ipf != "" ? " (IP: $ipf)" : "");
		echo "<table width=\"100%\" class=\"widefat page fixed\" cellspacing=\"0\">\n";
		echo "<thead><tr><th><div align=\"center\"><h2 style=\"color: blue;\">Blue Captcha - " . __("Log", "blue-captcha") . " " . $info . "</h2></div></th></tr></thead>";
		echo "</table>\n";
		
		echo "<table width=\"100%\" class=\"widefat page fixed\" cellspacing=\"0\">\n";
		
		echo "<thead>\n";
		echo "<tr>\n";
		echo "<th colspan=\"7\"><div align=\"center\">\n";
		
		echo "<form method=\"post\" name=\"blcap_log_filter\" action=\"" . $blcap_logsite . "\">\n";
		
		echo __("Pages", "blue-captcha") . ": ";
		
		if ($totalpages > 0)
		{
			$firstpage = 1;
			$lastpage = $totalpages;
			$showxpages = 3;
			
			if ($pagef > $showxpages)
			{
				$this_page = $firstpage;
				if ($ipf == "") $link = $blcap_logsite . "&p=show&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&resf=" . $resf . "&pagef=" . $this_page . "\"";
				else $link = $blcap_logsite . "&p=show&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&ipf=" . urlencode ($ipf) . "&resf=" . $resf . "&pagef=" . $this_page . "\"";
				echo "<a class=\"blcap_pagenum\" href=\"" . $link . "\" title=\"" . __("Go to page", "blue-captcha") . " $this_page\">$this_page</a>";
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
				if ($ipf == "") $link = $blcap_logsite . "&p=show&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&resf=" . $resf . "&pagef=" . $this_page . "\"";
				else $link = $blcap_logsite . "&p=show&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&ipf=" . urlencode ($ipf) . "&resf=" . $resf . "&pagef=" . $this_page . "\"";
				if ($k == $pagef)
					echo "<span class=\"blcap_pagenumsel\">$this_page</span>";
				else
					echo "<a class=\"blcap_pagenum\" href=\"" . $link . "\" title=\"" . __("Go to page", "blue-captcha") . " $this_page\">$this_page</a>";
				echo " &nbsp; ";
			}
			
			if ($pagef + $showxpages <= $lastpage)
			{
				echo " ... ";
				echo " &nbsp; ";
				$this_page = $lastpage;
				if ($ipf == "") $link = $blcap_logsite . "&p=show&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&resf=" . $resf . "&pagef=" . $this_page . "\"";
				else $link = $blcap_logsite . "&p=show&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&ipf=" . urlencode ($ipf) . "&resf=" . $resf . "&pagef=" . $this_page . "\"";
				echo "<a class=\"blcap_pagenum\" href=\"" . $link . "\" title=\"" . __("Go to page", "blue-captcha") . " $this_page\">$this_page</a>";
				echo " &nbsp; \n";
			}
		}
		else
		{
			$firstpage = 0;
			$lastpage = 0;
		}
		
		echo "&nbsp;\n";

		echo __("Page", "blue-captcha") . ": ";
		echo "<select name=\"sel_page\">\n";
		for ($k = 0 ; $k < $totalpages; $k++)
		{
			$this_page = $k + 1;
			if ($currentpage == $this_page) $str = " selected";
			else $str = "";
			echo "<option value=\"" . $this_page ."\"" . $str .">" . $this_page . "</option>\n";
		}
		echo "</select>\n";
		
		echo "&nbsp; " . __("Entries Per Page", "blue-captcha") . ": ";

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
		
		echo "<br>" . __("Type", "blue-captcha") . ": ";
		echo "<select name=\"sel_kind\">\n";
		if ($kindf == "") $str = " selected"; else $str = "";
		echo "<option value=\"\"" . $str .">" . __("All Types", "blue-captcha") . "</option>\n";
		if ($kindf == "LOGIN") $str = " selected"; else $str = "";
		echo "<option value=\"LOGIN\"" . $str .">" . __("Login", "blue-captcha") . "</option>\n";
		if ($kindf == "REGISTER") $str = " selected"; else $str = "";
		echo "<option value=\"REGISTER\"" . $str .">" . __("Register", "blue-captcha") . "</option>\n";
		if ($kindf == "LOST_PASSWORD") $str = " selected"; else $str = "";
		echo "<option value=\"LOST_PASSWORD\"" . $str .">" . __("Password Recovery", "blue-captcha") . "</option>\n";
		if ($kindf == "COMMENT") $str = " selected"; else $str = "";
		echo "<option value=\"COMMENT\"" . $str .">" . __("Comment", "blue-captcha") . "</option>\n";
		echo "</select>\n";
		
		echo __("Result", "blue-captcha") . ": ";
		echo "<select name=\"sel_type\">\n";
		if ($typef == "") $str = " selected"; else $str = "";
		echo "<option value=\"\"" . $str .">" . __("All Results", "blue-captcha") . "</option>\n";
		if ($typef == "SUCCESS") $str = " selected"; else $str = "";
		echo "<option value=\"SUCCESS\"" . $str .">" . __("Success", "blue-captcha") . "</option>\n";
		if ($typef == "BANNED") $str = " selected"; else $str = "";
		echo "<option value=\"BANNED\"" . $str .">" . __("Banned", "blue-captcha") . "</option>\n";
		if ($typef == "FAIL") $str = " selected"; else $str = "";
		echo "<option value=\"FAIL\"" . $str .">" . __("Fail", "blue-captcha") . "</option>\n";
		echo "</select>\n";
		
		echo __("Date", "blue-captcha") . ": ";
		echo "<select name=\"blcap_log_date_filter\">\n";

		if ($datef == "ALL")
			$str = " selected";
		else $str = "";
		echo "<option value=\"ALL\"" . $str . ">" . __("All Dates", "blue-captcha") . "</option>\n";
		
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
		
		
		echo "<input type=\"submit\" class=\"button\" name=\"button_filter\" value=\"  " . __("Apply", "blue-captcha") . "  \" />\n";
		
		echo "<input type=\"hidden\" name=\"action\" value=\"apply_filter\" />\n";

		if ($ipf != "") echo "<input type=\"hidden\" name=\"ipf\" value=\"$ipf\" />\n";
		
		echo "</form>\n";
		
		echo "</div></th>\n";
		echo "</tr>\n";
		echo "</thead>\n";
		
		echo "</table>\n";
		
		if ($ipf != "")
			echo "<form method=\"post\" name=\"showlogsform\" id=\"showlogsform\" action=\"$blcap_logsite" . "&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&ipf=" . urlencode ($ipf) . "&resf=" . $resf . "&pagef=" . $pagef . "\">\n";
		else
			echo "<form method=\"post\" name=\"showlogsform\" id=\"showlogsform\" action=\"$blcap_logsite" . "&kindf=" . urlencode ($kindf) . "&typef=" . urlencode ($typef) . "&datef=" . urlencode ($datef) . "&resf=" . $resf . "&pagef=" . $pagef . "\">\n";

		echo "<table width=\"100%\" class=\"widefat page fixed\" cellspacing=\"0\">\n";
		
		echo "<thead>\n";
		echo "<tr>\n";

		echo "<th scope=\"col\" class=\"manage-column column-cb check-column\" style=\"\"><input type=\"checkbox\" id=\"log_selall\" title=\"" . __("Select All / None", "blue-captcha") . "\" onclick=\"blcap_logselall();\" /></th>\n";

		$sn = __("S/N", "blue-captcha");
		if ($sn === "S/N") $sn = "No";

		echo "<th width=\"5%\"><div align=\"center\">" . $sn . "</div></th>\n";
		
		echo "<th width=\"10%\"><div align=\"center\">" . __("Date & Time", "blue-captcha") . "</div></th>\n";

		echo "<th width=\"11%\"><div align=\"center\">" . __("IP Address<br>(Proxy)", "blue-captcha") . "</div></th>\n";

		echo "<th width=\"12%\"><div align=\"center\">" . __("Captcha<br>(# Refreshes)", "blue-captcha") . "</div></th>\n";

		echo "<th width=\"13%\"><div align=\"center\">" . __("Response Time<br>(# Given Chars)", "blue-captcha") . "</div></th>\n";
		
		echo "<th width=\"10%\"><div align=\"center\">" . __("Type", "blue-captcha") . "</div></th>\n";

		echo "<th width=\"10%\"><div align=\"center\">" . __("Result<br>(% Spam P.)", "blue-captcha") . "</div></th>\n";
		
		echo "<th width=\"25%\"><div align=\"center\">" . __("Additional Info", "blue-captcha") . "</div></th>\n";

		echo "</tr>\n";
		echo "</thead>\n";
		
		$blcap_ip_informer_url = get_option ("blcap_ip_informer_url");
		if (!isset ($blcap_ip_informer_url)) $blcap_ip_informer_url = "";
		$informer_site = (isset ($blcap_ip_informer_url) ? $blcap_ip_informer_url : "");

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
			$more = $res[$i]["more"];

			$more_arr = explode ("#", $more);
			$totalchars = (isset ($more_arr[0]) ? $more_arr[0] : "");
			$pos = (isset ($more_arr[1]) ? $more_arr[1] : "");

			if ($totalchars == "") $totalchars = "?";
			if ($pos == "") $pos = "-"; else $pos = $pos . " %";

			if ($type == "LOST_PASSWORD") $type = "PASSWORD RECOVERY";
            
			if (strtoupper ($capres) == "SUCCESS") $rescolor = "green";
			else if (strtoupper ($capres) == "BANNED") $rescolor = "blue";
			else $rescolor = "red";
		
			if ($chclass == "iedit")
				$chclass = "alternate iedit";
			else $chclass = "iedit";

			$info_special = "";
			if ($type != "COMMENT" || $info == "-" || strlen ($info) <= 2 * $MIN_INFO_LEN)
			{
				$info_special = $info;
			}
			else
			{
				$cut_info = "";
				$info_pieces = "";
				$info_pieces = explode ("<br>", $info);
				if (is_array ($info_pieces))
					foreach ($info_pieces as $key => $val)
					{
						$len = ($key < 3 ? (int)($MIN_INFO_LEN / 2) : $MIN_INFO_LEN);
						$piece = ( mb_strlen ($val, "utf-8") <= $len) ? $val : mb_substr ($val, 0, $len, "utf-8") . "...";
						if ($cut_info != "") $cut_info = $cut_info . "<br>";
						$cut_info = $cut_info . $piece;
					}

				if ($cut_info == "") $cut_info = mb_substr ($info, 0, 2 * $MIN_INFO_LEN, "utf-8") . "...";

				$info_special = "<span id=\"blcap_cutinfo_$i\" style=\"display: inline;\">";
				$info_special = $info_special . $cut_info;
				$info_special = $info_special . "</span>";
				$info_special = $info_special . "<span id=\"blcap_info_$i\" style=\"display: none;\">";
				$info_special = $info_special . $info;
				$info_special = $info_special . "</span>";
				$info_special = $info_special . "<input id=\"blcap_button_$i\" type=\"button\" title=\"" . __("Show/Hide more details", "blue-captcha") . "\" value=\">\" onclick=\"blcap_show_details($i);\" \>";			
			}

			$ip_str = $ip;
			$proxy_str = $proxy;
			if ($informer_site != "")
			{
				$informer_site1 = str_replace ("{ip}", $ip, $informer_site);
				$ip_str = "<a href=\"" . $informer_site1 . "\" title=\"" . __("Click here to get details about this IP", "blue-captcha") . "\" rel=\"noreferrer\" target=\"_blank\">";
				$ip_str = $ip_str . $ip;
				$ip_str = $ip_str . "</a>";

				if ($proxy_str != "-")
				{
					$informer_site2 = str_replace ("{ip}", $proxy, $informer_site);
					$proxy_str = "<a href=\"" . $informer_site2 . "\" title=\"" . __("Click here to get details about this IP", "blue-captcha") . "\" rel=\"noreferrer\" target=\"_blank\">";
					$proxy_str = $proxy_str . $proxy;
					$proxy_str = $proxy_str . "</a>";					
				}
			}


			echo "<tr class=\"$chclass\">\n";

			echo "<th scope=\"row\" class=\"check-column\"><input type=\"checkbox\" id=\"log" . ($i+1) . "\" name=\"logs[]\" value=\"$log_id\"></th>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$no</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$date<br>$time</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$ip_str<br>($proxy_str)</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$captcha<br>($refresh)</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">$totaltime<br>($totalchars)</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">" . __($type, "blue-captcha") . "</font></div></td>\n";
			echo "<td><div align=\"center\"><font color=\"$rescolor\">" . __($capres, "blue-captcha") . "<br>($pos)</font></div></td>\n";
			echo "<td><div align=\"left\"><font color=\"$rescolor\">$info_special</font></div></td>\n";
	
			echo "</tr>\n";
		}
		
		echo "<input type=\"hidden\" id=\"blcap_action\" name=\"action\" value=\"delete\" />";
	
		echo "<tfoot><tr>\n";
		echo "<th colspan=\"9\">\n";
		echo "<div align=\"center\">\n";
		echo "<input type=\"button\" class=\"button-secondary\" title=\"" . __("Click here to erase the selected logs", "blue-captcha") . "\" value=\"  " . __("Delete Selected", "blue-captcha") . "  \" onclick=\"blcap_delselected();\" />\n";
		echo " &nbsp;&nbsp; ";
		echo "<input type=\"button\" class=\"button-primary\" title=\"" . __("Click here to erase all logs", "blue-captcha") . "\" value=\"  " . __("Delete Log File", "blue-captcha") . "  \" onclick=\"blcap_delall();\" />\n";
		echo " &nbsp;&nbsp; ";
		echo "<a href=\"" . $blcap_siteurl . "?bcapact=exp\" target=\"_blank\"><input type=\"button\" class=\"button-secondary\" title=\"" . __("Click here to export logs to CSV file", "blue-captcha") . "\" value=\"  " . __("Export to CSV", "blue-captcha") . "  \" /></a>\n";

		echo "</div>\n";
		echo "</th>\n";
		echo "</tr></tfoot>\n";
			
		echo "</form>\n";
		
		echo "</table>\n";
		
		echo "<script language='javascript'>\n";
		echo "\n";
	
		echo "function blcap_delselected ()\n";
		echo "{\n";
		echo "\t var conf = confirm (\"" . __("Are you sure that you want to delete the selected log entries?", "blue-captcha") . "\", \"BLUE CAPTCHA\");\n";
		echo "\t if (conf) document.getElementById('showlogsform').submit();\n";
		echo "}\n";
		echo "\n";
		echo "function blcap_delall ()\n";
		echo "{\n";
		echo "\t var conf = confirm (\"" . __("Are you sure that you want to delete ALL log entries?", "blue-captcha") . "\", \"BLUE CAPTCHA\");\n";
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
		echo "function blcap_show_details (id)\n";
		echo "{\n";
		echo "try {\n";
		echo "\t var btnElem = document.getElementById(\"blcap_button_\" + id);\n";
		echo "\t var infoElem = document.getElementById(\"blcap_info_\" + id);\n";
		echo "\t var cutinfoElem = document.getElementById(\"blcap_cutinfo_\" + id);\n";
		echo "\t if (btnElem && infoElem && cutinfoElem)\n";
		echo "\t {\n";
		echo "\t\t if (btnElem.value == \">\")\n";
		echo "\t\t {\n";
		echo "\t\t\t cutinfoElem.style.display = \"none\";\n";
		echo "\t\t\t infoElem.style.display = \"inline\";\n";
		echo "\t\t\t btnElem.value = \"<\";\n";
		echo "\t\t }\n";
		echo "\t\t else\n";
		echo "\t\t {\n";
		echo "\t\t\t infoElem.style.display = \"none\";\n";
		echo "\t\t\t cutinfoElem.style.display = \"inline\";\n";
		echo "\t\t\t btnElem.value = \">\";\n";
		echo "\t\t }\n";
		echo "\t }\n";
		echo "} catch (e) {alert(e);}\n";
		echo "}\n";
		echo "\n";
		echo "</script>\n";
	}
	else 
	{
		echo "<div align='center'><div class='updated'>\n";
		echo "<br>" . __("An error occurred", "blue-captcha") . "<br>";
		echo "<br></div></div>\n";
	}
	
?>
