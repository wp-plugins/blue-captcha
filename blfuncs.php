<?php

function blcap_remove_db ()
{
	$server = DB_HOST;
	$dbname = DB_NAME;
	$dbuser = DB_USER;
	$dbpasswd = DB_PASSWORD;

	$result = "";

	$connection = mysql_connect ($server, $dbuser, $dbpasswd);
	if (!$connection)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error connecting to DB Server: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	       
	if (!mysql_select_db ($dbname, $connection))
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error selecting DataBase: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	
	$table = "blcap_log";
	
	$sql = "DROP TABLE " . $table;
	
	$r = mysql_query ($sql);
	if (!$r)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error in sql query [$sql]: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;
	}
	
	$table = "blcap_banlog";
	
	$sql = "DROP TABLE " . $table;
	
	$r = mysql_query ($sql);
	if (!$r)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error in sql query [$sql]: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;
	}
	
	$result["result"] = "OK";
	
	return $result;
}

function blcap_get_logs ($date = "" , $sort = "", $kind = "", $type = "", $rpp = "", $page = 1, $last_page = "NO")
{
	$server = DB_HOST;
	$dbname = DB_NAME;
	$dbuser = DB_USER;
	$dbpasswd = DB_PASSWORD;

	$result = "";

	$connection = mysql_connect ($server, $dbuser, $dbpasswd);
	if (!$connection)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error connecting to DB Server: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	       
	if (!mysql_select_db ($dbname, $connection))
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error selecting DataBase: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}

	$table = "blcap_log";

	if (isset ($date)) $date = mysql_real_escape_string (stripslashes ($date));
	if (isset ($sort)) $sort = mysql_real_escape_string (stripslashes ($sort));
	if (isset ($kind)) $kind = mysql_real_escape_string (stripslashes ($kind));
	if (isset ($type)) $type = mysql_real_escape_string (stripslashes ($type));
		
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
	
	$r0 = mysql_query ($sql0);
	if (!$r0)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error in sql query [$sql0]: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	
	$aa = mysql_fetch_array($r0);
	if (isset ($aa["total"])) $total = $aa["total"];
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
	
	$r = mysql_query ($sql);
	if (!$r)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error in sql query [$sql]: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	
	$x = 0;
	while ($row = mysql_fetch_array($r))
	{
		$result[$x]["id"] = $row["id"];
		$result[$x]["ip"] = $row["ip"];
		$result[$x]["proxy"] = $row["proxy"];
		$result[$x]["totaltime"] = $row["totaltime"];
		$result[$x]["type"] = $row["type"];
		$result[$x]["captcha"] = urldecode ($row["captcha"]);
		$result[$x]["refresh"] = $row["refresh"];
		$result[$x]["result"] = $row["result"];
		$result[$x]["date"] = $row["date"];
		$result[$x]["time"] = $row["time"];
		$result[$x]["info"] = urldecode ($row["info"]);
		$result[$x]["more"] = $row["more"];
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
	$server = DB_HOST;
	$dbname = DB_NAME;
	$dbuser = DB_USER;
	$dbpasswd = DB_PASSWORD;
	
	$connection = mysql_connect ($server, $dbuser, $dbpasswd);
	if (!$connection)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error connecting to DB Server: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	      
	if (!mysql_select_db ($dbname, $connection))
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error selecting DataBase: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}

	$ip = mysql_real_escape_string (stripslashes ($ip));
	$proxy = mysql_real_escape_string (stripslashes ($proxy));
	$totaltime = mysql_real_escape_string (stripslashes ($totaltime));
	$type = mysql_real_escape_string (stripslashes ($type));
	$captcha = mysql_real_escape_string (stripslashes ($captcha));
	$refresh = mysql_real_escape_string (stripslashes ($refresh));
	$capres = mysql_real_escape_string (stripslashes ($capres));
	$date = mysql_real_escape_string (stripslashes ($logdate));
	$time = mysql_real_escape_string (stripslashes ($logtime));
	$more = "";
	$info = mysql_real_escape_string (stripslashes ($info));
	
	$captcha = urlencode ($captcha);
	$info = urlencode ($info);

	$table = "blcap_log";
	
	$sql = "INSERT INTO " . $table . " (ip , proxy , totaltime , type , captcha , refresh , result , info , more , date , time) VALUES ('$ip' , '$proxy' , '$totaltime' , '$type' , '$captcha' , '$refresh' , '$capres' , '$info' , '$more' , '$date' , '$time')";

	$r = mysql_query ($sql);
	if (!$r)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error in sql query [$sql]: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}

	$result["result"] = "OK";
	return $result;	
}

function blcap_get_log_dates ()
{
	$server = DB_HOST;
	$dbname = DB_NAME;
	$dbuser = DB_USER;
	$dbpasswd = DB_PASSWORD;

	$result = "";

	$connection = mysql_connect ($server, $dbuser, $dbpasswd);
	if (!$connection)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error connecting to DB Server: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	       
	if (!mysql_select_db ($dbname, $connection))
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error selecting DataBase: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}

	$table = "blcap_log";
	
	$sql = "SELECT DISTINCT date FROM " . $table . " ORDER BY date DESC";
	
	$r = mysql_query ($sql);
	if (!$r)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error in sql query [$sql]: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	
	$x = 0;
	while ($row = mysql_fetch_array($r))
	{
		$result[$x]["date"] = $row["date"];
		$x++;
	}
	
	$result["count"] = $x;
	$result["result"] = "OK";

	return $result;
}

function blcap_delete_logs ($logs = "")
{
	$server = DB_HOST;
	$dbname = DB_NAME;
	$dbuser = DB_USER;
	$dbpasswd = DB_PASSWORD;

	$result = "";

	$connection = mysql_connect ($server, $dbuser, $dbpasswd);
	if (!$connection)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error connecting to DB Server: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	       
	if (!mysql_select_db ($dbname, $connection))
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error selecting DataBase: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}

	$table = "blcap_log";
	
	$size = count ($logs);
	
	if ($logs == "")
	{
		$sql0 = "DELETE FROM " . $table;
		if (!mysql_query ($sql0))
		{
			$result["result"] = "ERROR";
			$result["errormessage"] = "Error in sql query [$sql0]: " . mysql_error ();
			$result["errorcode"] = mysql_errno ();
			@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);			
			return $result;	
		}
		
		$result["result"] = "OK";
		return $result;
	}
	
	for ($i = 0 ; $i < $size ; $i++)
		if (isset ($logs[$i]))
		{
			$log_id = $logs[$i];
			$sql = "DELETE FROM " . $table . " WHERE id='$log_id'";
			
			if (!mysql_query ($sql))
			{
				$result["result"] = "ERROR";
				$result["errormessage"] = "Error in sql query [$sql]: " . mysql_error ();
				$result["errorcode"] = mysql_errno ();
				@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);				
				return $result;	
			}
		}
	
	$result["result"] = "OK";
	
	return $result;
}

function blcap_create_csv ()
{
	$server = DB_HOST;
	$dbname = DB_NAME;
	$dbuser = DB_USER;
	$dbpasswd = DB_PASSWORD;
	
	$connection = mysql_connect ($server, $dbuser, $dbpasswd);
	if (!$connection)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error connecting to DB Server: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	      
	if (!mysql_select_db ($dbname, $connection))
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error selecting DataBase: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	
	$table = "blcap_log";
	
	$sql = "SELECT * FROM " . $table . " ORDER BY id";
	
	$r = mysql_query ($sql);
	if (!$r)
	{
		$result["result"] = "ERROR";
		$result["errormessage"] = "Error in sql query [$sql]: " . mysql_error ();
		$result["errorcode"] = mysql_errno ();
		@blcap_errorhandler (mysql_errno (), mysql_error (), __FILE__, __LINE__);
		return $result;	
	}
	
	$x = 0;
	while ($row = mysql_fetch_array($r))
	{
		$x++;
		$id = $row["id"];
		$ip = $row["ip"];
		$proxy = $row["proxy"];
		$totaltime = $row["totaltime"];
		$totaltime = str_replace (".", ",", $totaltime);
		$type = $row["type"];
		$captcha = $row["captcha"];
		$refresh = $row["refresh"];
		$capres = $row["result"];
		$date = $row["date"];
		$time = $row["time"];
		$more = $row["more"];

		$captcha = urldecode ($row["captcha"]);
		$info = urldecode ($row["info"]);
		$info = str_replace (";", "?", $info);
		$info = str_replace ("<br>", chr (10), $info);
		$info = "\"" . $info . "\"";
		
		echo $x . ";" . $date . ";" . $time . ";" . $ip . ";" . $proxy . ";" . $captcha . ";" . $refresh . ";" . $totaltime . ";" . $type . ";" . $capres . ";" . $info;
		echo "\n";
	}

	$result["result"] = "OK";
	return $result;		
}

?>