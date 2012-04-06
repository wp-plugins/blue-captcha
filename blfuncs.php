<?php

function blcap_remove_db ()
{
	global $wpdb;
	
	$sql = "DROP TABLE blcap_log";
	$wpdb->get_results ($sql);
	
	$sql2 = "DROP TABLE blcap_banlog";
	$wpdb->get_results ($sql2);
	
	$sql3 = "DROP TABLE blcap_sessions";
	$wpdb->get_results ($sql3);
	
	$result["result"] = "OK";
	
	return $result;	
}

function blcap_get_logs ($date = "" , $sort = "", $kind = "", $type = "", $rpp = "", $page = 1, $last_page = "NO")
{
	global $wpdb;
	
	$result = "";

	$table = "blcap_log";
	$str = "";
	
	if ($date != "") $str = " WHERE date='$date'";
	else $str = "";
	
	if ($kind != "")
	{
		if ($str == "") $str = " WHERE type='$kind'";
		else $str = $str . " AND type='$kind'";
	}
	
	if ($type != "")
	{
		if ($str == "") $str = " WHERE result='$type'";
		else $str = $str . " AND result='$type'";
	}
	
	if ($sort != "") $str = $str . " ORDER BY $sort";
	
	$sql0 = "SELECT COUNT(id) AS total FROM " . $table . $str;

	$r0 = $wpdb->get_results ($sql0);
	
	if (isset ($r0[0]))
		$total = $r0[0]->total;
	else $total = 0;
	
	if ($total == 0) 
	{
		$result["count"] = 0;
		$result["total"] = 0;
		$result["totalpages"] = 0;
		$result["currentpage"] = 0;
		$result["result"] = "OK";
		return $result;	
	}
	
	$curpage = 1;
	$totalpages = 1;

	$limitstr = "";
	if ($rpp === "" || $rpp <= 0 || !is_numeric ($rpp) || $total == 0)
		$limitstr = "";
	else
	{
		$totalpages = ceil (($total*1.0) / $rpp);
		if ($page < 1 || $page === "" || !is_numeric ($page)) $page = 1;
		if ($page > $totalpages) $page = $totalpages;
		if ($last_page == "YES") 
			$page = $totalpages;
		$curpage = $page;
		$start = ceil (($page - 1) * $rpp);
		$end = ceil ($rpp);
		
		$limitstr = " LIMIT " . $start . ", " . $end;
	}
	
	$sql = "SELECT * FROM " . $table . $str . $limitstr;
	
	$r1 = $wpdb->get_results ($sql);
	
	$x = 0;
	foreach ($r1 as $row) 
	{
		$result[$x]["id"] = $row->id;
		$result[$x]["ip"] = $row->ip;
		$result[$x]["proxy"] = $row->proxy;
		$result[$x]["totaltime"] = $row->totaltime;
		$result[$x]["type"] = $row->type;
		$result[$x]["captcha"] = urldecode ($row->captcha);
		$result[$x]["refresh"] = $row->refresh;
		$result[$x]["result"] = $row->result;
		$result[$x]["date"] = $row->date;
		$result[$x]["time"] = $row->time;
		$result[$x]["info"] = urldecode ($row->info);
		$result[$x]["more"] = $row->more;
		$x++;
	}
	
	$result["count"] = $x;
	$result["total"] = $total;
	$result["totalpages"] = $totalpages;
	$result["currentpage"] = $curpage;		
	$result["result"] = "OK";

	return $result;	
}

function blcap_add_log ($ip, $proxy, $totaltime, $type, $captcha, $refresh, $capres, $info,  $logdate, $logtime)
{
	global $wpdb;

	$captcha = stripslashes (strip_tags ($captcha));
	$info = stripslashes ($info);
	$date = $logdate;
	$time = $logtime;
	$more = "";
	
	$captcha = urlencode ($captcha);
	$info = urlencode ($info);

	$table = "blcap_log";
	
	$r = $wpdb->insert ($table, array ("ip" => $ip, "proxy" => $proxy, "totaltime" => $totaltime, "type" => $type, "captcha" => $captcha, "refresh" => $refresh, "result" => $capres, "info" => $info, "more" => $more, "date" => $date, "time" => $time));
	
	$result["result"] = "OK";
	return $result;	
}

function blcap_get_log_dates ()
{
	global $wpdb;

	$result = "";
	$table = "blcap_log";
	
	$sql = "SELECT DISTINCT date FROM " . $table . " ORDER BY date DESC";
	
	$r = $wpdb->get_results ($sql);

	$x = 0;
	foreach ($r as $row)
	{
		$result[$x]["date"] = $row->date;
		$x++;
	}
	
	$result["count"] = $x;
	$result["result"] = "OK";

	return $result;
}

function blcap_delete_logs ($logs = "")
{
	global $wpdb;
	
	$result = "";
	
	$table = "blcap_log";
	
	$size = count ($logs);
	
	if ($logs == "")
	{
		$sql0 = "DELETE FROM " . $table;
		
		$r0 = $wpdb->get_results ($sql0);
	
		$result["result"] = "OK";
		return $result;
	}
	
	for ($i = 0 ; $i < $size ; $i++)
		if (isset ($logs[$i]))
		{
			$log_id = $logs[$i];
			
			$sql = "DELETE FROM " . $table . " WHERE id='$log_id'";
			$r = $wpdb->get_results ($sql);
		}
	
	$result["result"] = "OK";
	
	return $result;
}

function blcap_create_csv ()
{
	global $wpdb;
	
	$table = "blcap_log";
	
	$sql = "SELECT * FROM " . $table . " ORDER BY id";
	
	$r = $wpdb->get_results ($sql);
	
	$x = 0;
	foreach ($r as $row) 
	{
		$x++;
		$id = $row->id;
		$ip = $row->ip;
		$proxy = $row->proxy;
		$totaltime = $row->totaltime;
		$totaltime = str_replace (".", ",", $totaltime);
		$type = $row->type;
		$captcha = $row->captcha;
		$refresh = $row->refresh;
		$capres = $row->result;
		$date = $row->date;
		$time = $row->time;
		$more = $row->more;
		$info = $row->info;

		$captcha = urldecode ($captcha);
		$captcha = str_replace ("\"", "''", $captcha);
		
		$info = urldecode ($info);
		$info = str_replace ("\"", "''", $info);
		$info = str_replace ("<br>", chr (10), $info);

		$ip = "\"" . $ip . "\"";
		$proxy = "\"" . $proxy . "\"";
		$captcha = "\"" . $captcha . "\"";
		$info = "\"" . $info . "\"";
		
		echo $x . ";" . $date . ";" . $time . ";" . $ip . ";" . $proxy . ";" . $captcha . ";" . $refresh . ";" . $totaltime . ";" . $type . ";" . $capres . ";" . $info;
		echo "\n";
	}

	$result["result"] = "OK";
	return $result;		
}

function blcap_get_captcha_session ($capid)
{
	global $wpdb;
    
    $table = "blcap_sessions";
    
	$sql = "SELECT * FROM " . $table . " WHERE capid='" . $capid . "'";
	
	$r = $wpdb->get_results ($sql);
	
  	if (isset ($r[0]))
    {
        $result["found"] = true;
        $result["no"] = $r[0]->no;
        $result["capid"] = $r[0]->capid;
        $result["ip"] = $r[0]->ip;
        $result["captcha"] = $r[0]->captcha;
        $result["original"] = $r[0]->original;
        $result["caprefresh"] = $r[0]->caprefresh;
        $result["captime"] = $r[0]->captime;
        $result["capurl"] = $r[0]->capurl;
        
        return $result;
    }
    
	$result["found"] = false;
	return $result;	
}

function blcap_add_captcha_session ($capid, $ip, $captcha, $original, $caprefresh, $captime, $capurl)
{
	global $wpdb;

	$table = "blcap_sessions";
	
	$r = $wpdb->insert ($table, array ("capid" => $capid, "ip" => $ip, "captcha" => $captcha, "original" => $original, "caprefresh" => $caprefresh, "captime" => $captime, "capurl" => $capurl));
	
	$result["result"] = "OK";
	return $result;	
}

function blcap_update_captcha_session ($capid, $captcha, $original, $caprefresh)
{
	global $wpdb;

	$table = "blcap_sessions";
	
	$sql = "UPDATE " . $table . " SET captcha='" . $captcha . "', original='" . $original . "', caprefresh='" . $caprefresh . "' WHERE capid='" . $capid . "'";
	
	$r = $wpdb->get_results ($sql);

	$result["result"] = "OK";
	return $result;	
}

function blcap_delete_captcha_session ($capid)
{
	global $wpdb;

	$table = "blcap_sessions";
	
	$sql = "DELETE FROM " . $table . " WHERE capid='" . $capid . "'";
	
	$r = $wpdb->get_results ($sql);

	$result["result"] = "OK";
	return $result;	
}

function blcap_truncate_captcha_session ()
{
	global $wpdb;

	$table = "blcap_sessions";
	
	$sql = "TRUNCATE TABLE " . $table;
	
	$r = $wpdb->get_results ($sql);

	$result["result"] = "OK";
	return $result;	
}

?>