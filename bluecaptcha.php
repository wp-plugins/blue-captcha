<?php

/*
Plugin Name: Blue Captcha
Plugin URI: http://wordpress.org/extend/plugins/blue-captcha/
Description: Blue Captcha
Version: 1.7.2
Author: Jotis Kokkalis (BlueCoder)
Author URI: http://mybluestuff.blogspot.com/
*/

/*  
	By Jotis Kokkalis, (C) 2012-2014

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
	General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software Foundation,
	Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

error_reporting (E_ALL);

function blcap_errorhandler ($errno, $errstr, $errfile, $errline)
{
	//echo "Error : $errstr ($errno) in file $errfile ($errline)<br>";
	//@error_log ("* " . date ("d/m/Y , H:i:s") . " : $errstr [$errno] in line $errline\r\n", 3, "blcap_errors.log");
}
set_error_handler ("blcap_errorhandler", E_ALL);

if (!defined('WP_CONTENT_URL')) {
   define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
}

function blcap_check ()
{
	if (!function_exists ("gd_info") || !extension_loaded ("gd") )
	{
		$message = "";
		$message = $message . "<table class='widefat page fixed' align='center'>\n";
		$message = $message . "<tr><td><div align='center'><h3>BLUE CAPTCHA : GD Library is not installed on your system!</h3></div></td></tr>\n";
		$message = $message . "</table>\n";
		echo $message;	
	}

	if (version_compare (PHP_VERSION, "5.0.0", '<'))
	{
		$message = "";
		$message = $message . "<table class='widefat page fixed' align='center'>\n";
		$message = $message . "<tr><td><div align='center'><h3>BLUE CAPTCHA : Your system doesn't have PHP 5 or newer version!</h3></div></td></tr>\n";
		$message = $message . "</table>\n";
		echo $message;
	}
	
	$blcap_version = get_option ("blcap_version");
	if ($blcap_version == "")
	{
		$message = "";
		$message = $message . "<table class='widefat page fixed' align='center'>\n";
		$message = $message . "<tr><td><div align='center'><h3>BLUE CAPTCHA : Plugin is not installed properly. Try to reinstall it.</h3></div></td></tr>\n";
		$message = $message . "</table>\n";
		echo $message;
        die (0);
	}	
}

function blcap_install ()
{
	global $wpdb;

	require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

	$prefix = "blcap_";

	$blcap_cur_version = "";
	$blcap_cur_version = get_option ("blcap_version");
	
	$blcap_version = "1.7.2";
	add_option ("blcap_version", $blcap_version);
	update_option ("blcap_version", $blcap_version);
	
	if ($blcap_cur_version == "")
	{

		$settings = "a:100:{s:13:\"gen_activated\";s:3:\"yes\";s:15:\"gen_empty_check\";s:2:\"no\";s:15:\"gen_keepcomment\";s:2:\"no\";s:15:\"gen_ignore_case\";s:2:\"no\";s:13:\"gen_pingtrack\";s:3:\"yes\";s:7:\"gen_log\";s:3:\"yes\";s:12:\"gen_keepinfo\";s:3:\"yes\";s:11:\"gen_keeppwd\";s:2:\"no\";s:13:\"gen_layersize\";s:1:\"1\";s:11:\"gen_refresh\";s:3:\"yes\";s:16:\"gen_use_sessions\";s:2:\"no\";s:19:\"gen_autogeneratekey\";s:3:\"yes\";s:11:\"log_enabled\";s:3:\"yes\";s:8:\"log_user\";s:2:\"10\";s:15:\"log_ignore_case\";s:7:\"general\";s:10:\"log_char_6\";s:1:\"6\";s:8:\"log_type\";s:15:\"numbers_letters\";s:10:\"log_letter\";s:9:\"uppercase\";s:8:\"log_font\";s:4:\"yes1\";s:15:\"log_availfont_1\";s:1:\"1\";s:15:\"log_availfont_2\";s:1:\"2\";s:15:\"log_availfont_3\";s:1:\"3\";s:15:\"log_availfont_4\";s:1:\"4\";s:14:\"log_size_large\";s:5:\"large\";s:9:\"log_color\";s:6:\"colorn\";s:10:\"log_rotate\";s:3:\"yes\";s:14:\"log_background\";s:7:\"palette\";s:13:\"log_availbg_1\";s:1:\"1\";s:13:\"log_availbg_2\";s:1:\"2\";s:13:\"log_availbg_3\";s:1:\"3\";s:13:\"log_availbg_4\";s:1:\"4\";s:13:\"log_availbg_5\";s:1:\"5\";s:9:\"log_extra\";s:2:\"no\";s:9:\"log_lines\";s:2:\"no\";s:11:\"log_trlevel\";s:1:\"1\";s:9:\"log_layer\";s:6:\"single\";s:11:\"log_profile\";s:1:\"4\";s:11:\"reg_enabled\";s:3:\"yes\";s:8:\"reg_user\";s:2:\"10\";s:15:\"reg_ignore_case\";s:7:\"general\";s:10:\"reg_char_4\";s:1:\"4\";s:8:\"reg_type\";s:7:\"letters\";s:10:\"reg_letter\";s:9:\"uppercase\";s:8:\"reg_font\";s:4:\"yes1\";s:15:\"reg_availfont_1\";s:1:\"1\";s:15:\"reg_availfont_2\";s:1:\"2\";s:15:\"reg_availfont_3\";s:1:\"3\";s:15:\"reg_availfont_4\";s:1:\"4\";s:15:\"reg_size_larger\";s:6:\"larger\";s:9:\"reg_color\";s:8:\"colorful\";s:10:\"reg_rotate\";s:2:\"no\";s:14:\"reg_background\";s:5:\"color\";s:9:\"reg_extra\";s:2:\"no\";s:9:\"reg_lines\";s:2:\"no\";s:11:\"reg_trlevel\";s:1:\"1\";s:9:\"reg_layer\";s:6:\"single\";s:11:\"reg_profile\";s:1:\"2\";s:11:\"pwd_enabled\";s:3:\"yes\";s:8:\"pwd_user\";s:2:\"10\";s:15:\"pwd_ignore_case\";s:7:\"general\";s:10:\"pwd_char_3\";s:1:\"3\";s:8:\"pwd_type\";s:7:\"numbers\";s:10:\"pwd_letter\";s:9:\"uppercase\";s:8:\"pwd_font\";s:4:\"yes1\";s:15:\"pwd_availfont_1\";s:1:\"1\";s:15:\"pwd_size_larger\";s:6:\"larger\";s:9:\"pwd_color\";s:6:\"color1\";s:10:\"pwd_rotate\";s:2:\"no\";s:14:\"pwd_background\";s:5:\"color\";s:9:\"pwd_extra\";s:2:\"no\";s:9:\"pwd_lines\";s:2:\"no\";s:11:\"pwd_trlevel\";s:1:\"1\";s:9:\"pwd_layer\";s:6:\"single\";s:11:\"pwd_profile\";s:1:\"1\";s:11:\"com_enabled\";s:3:\"yes\";s:8:\"com_user\";s:2:\"10\";s:15:\"com_ignore_case\";s:7:\"general\";s:10:\"com_char_5\";s:1:\"5\";s:8:\"com_type\";s:15:\"numbers_letters\";s:10:\"com_letter\";s:9:\"uppercase\";s:8:\"com_font\";s:4:\"yes1\";s:15:\"com_availfont_1\";s:1:\"1\";s:15:\"com_availfont_2\";s:1:\"2\";s:15:\"com_availfont_3\";s:1:\"3\";s:15:\"com_availfont_4\";s:1:\"4\";s:15:\"com_size_larger\";s:6:\"larger\";s:9:\"com_color\";s:6:\"colorn\";s:10:\"com_rotate\";s:3:\"yes\";s:14:\"com_background\";s:5:\"image\";s:13:\"com_availbg_1\";s:1:\"1\";s:13:\"com_availbg_2\";s:1:\"2\";s:13:\"com_availbg_3\";s:1:\"3\";s:13:\"com_availbg_4\";s:1:\"4\";s:13:\"com_availbg_5\";s:1:\"5\";s:9:\"com_extra\";s:2:\"no\";s:9:\"com_lines\";s:2:\"no\";s:11:\"com_trlevel\";s:1:\"1\";s:9:\"com_layer\";s:6:\"single\";s:11:\"com_profile\";s:1:\"3\";s:10:\"ban_iplist\";s:0:\"\";}";


		$settings_arr = @unserialize ($settings);
		add_option ("blcap_settings", $settings_arr);
		update_option ("blcap_settings", $settings_arr);
	}
    
	$blcap_protection_key = "";
	$charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	for ($i = 0 ; $i < 16 ; $i++)
		$blcap_protection_key .= $charset[mt_rand (0, strlen ($charset)-1)];
	add_option ("blcap_protection_key", $blcap_protection_key);
	update_option ("blcap_protection_key", $blcap_protection_key);
    
	if ($current_version == "" || version_compare ($current_version, "1.2", "<="))
	{
		$default_ip_informer_url = "http://whatismyipaddress.com/ip/{ip}";
		add_option ("blcap_ip_informer_url", $default_ip_informer_url);
		update_option ("blcap_ip_informer_url", $default_ip_informer_url);
	}

	$blcap_date = date ("Y/m/d");
	add_option ("blcap_date", $blcap_date);
	update_option ("blcap_date", $blcap_date);    
     
	add_option ("blcap_sessions", "");
	update_option ("blcap_sessions", "");

	$charset = "utf8";
	if (defined("DB_CHARSET")) $charset = DB_CHARSET;
	if ($charset == "") $charset = "utf8";

	$blcap_table = $prefix . "log";
	
	if ($wpdb->get_var("SHOW TABLES LIKE '" . $blcap_table . "'") != $blcap_table)
	{
		$sql = "CREATE TABLE `$blcap_table` (
			`id` int(11) NOT NULL auto_increment,
			`ip` text NOT NULL,
			`proxy` text NOT NULL,
			`totaltime` text NOT NULL,
			`type` text NOT NULL,
			`captcha` text NOT NULL,
			`refresh` text NOT NULL,
			`result` text NOT NULL,
			`info` longtext NOT NULL,
			`more` longtext NOT NULL,
			`date` text NOT NULL,
			`time` text NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=$charset";
		
		dbDelta($sql);
	}

	$blcap_table = $prefix . "sessions";
	if ($wpdb->get_var("SHOW TABLES LIKE '" . $blcap_table . "'") != $blcap_table)
	{
		$sql = "CREATE TABLE `$blcap_table` (
			`no` int(11) NOT NULL auto_increment,
			`capid` text NOT NULL,
			`ip` text NOT NULL,
			`captcha` text NOT NULL,
			`original` text NOT NULL,
			`caprefresh` text NOT NULL,
			`captime` text NOT NULL,
			`capurl` text NOT NULL,
			PRIMARY KEY (`no`)
			) ENGINE=MyISAM DEFAULT CHARSET=$charset";
			
		dbDelta($sql);
	}

	$blcap_table = $prefix . "ips";
	if ($wpdb->get_var("SHOW TABLES LIKE '" . $blcap_table . "'") != $blcap_table)
	{
		$sql = "CREATE TABLE `$blcap_table` (
			`id` int(11) NOT NULL auto_increment,
			`ip` text NOT NULL,
			`date` text NOT NULL,
			`time` text NOT NULL,
			`microtime` double NOT NULL,
			`sumprob` float NOT NULL,
			`level` text NOT NULL,
			`more` longtext NOT NULL,
			`pp` int(11) NOT NULL,
			`pptotal` int(11) NOT NULL,
			`trialstoday` int(11) NOT NULL,
			`trialstotal` int(11) NOT NULL,
			`failstoday` int(11) NOT NULL,
			`failstotal` int(11) NOT NULL,
			`failure` float NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=$charset";
			
		dbDelta($sql);
	}

	if (version_compare ($current_version, "1.1", "<="))
		$wpdb->get_results ("DROP TABLE blcap_banlog");
}

function blcap_uninstall ()
{
	delete_option ("blcap_version");
	delete_option ("blcap_protection_key");
	delete_option ("blcap_ip_informer_url");
	delete_option ("blcap_date");
	delete_option ("blcap_sessions");
	delete_option ("blcap_settings");
	blcap_remove_db ();
}

function blcap_add_menus ()
{
	add_menu_page ('Blue Captcha', 'Blue Captcha', 'administrator', 'blcap_main_page', 'blcap_main');

	add_submenu_page ('blcap_main_page', 'Options', __('Options', 'blue-captcha'), 'administrator', 'blcap_options_page', 'blcap_options');
	add_submenu_page ('blcap_main_page', 'Hall of Shame', __('Hall of Shame', 'blue-captcha'), 'administrator', 'blcap_hos_page', 'blcap_hos');
	add_submenu_page ('blcap_main_page', 'Log', __('Log', 'blue-captcha'), 'administrator', 'blcap_logs_page', 'blcap_logs');
}

function blcap_main ()
{
	global $wpdb;

	blcap_check ();
	
	$blcap_siteurl = get_option ("siteurl"); 
	$blcap_pageurl = $blcap_siteurl . "/wp-admin/admin.php?page="; 
	$blcap_mainsite = $blcap_pageurl . "blcap_main_page";
	
	$blcap_version = get_option ("blcap_version");

	$action = (isset ($_REQUEST["blcap_action"]) ? $_REQUEST["blcap_action"] : "");
	if ($action == "uninstall")
	{
		@include_once ("blfuncs.php");
		
		blcap_uninstall ();
		
		echo "<div class=\"updated\" align=\"center\">\n";
		echo "<br /><strong>" . __("Blue Captcha has been successfully uninstalled.", "blue-captcha") . "</strong>";
		echo "<br /><strong>" . __("You may now deactivate and delete plugin.", "blue-captcha") . "</strong>";
		echo "<br /><br /></div>\n";		
		die ();
	}

	echo "<script language=\"javascript\">\n";
	echo "function blcap_confirm ()\n";
	echo "{\n";
	echo "\tvar conf;\n";
	echo "\tconf = confirm (\"" . __("Are you sure that you want to uninstall Blue Captcha Plugin?", "blue-captcha") . "\");\n";
	echo "\tif (conf)\n";
	echo "\t{\n";
	echo "\t\tdocument.getElementById (\"blcap_action\").value = \"uninstall\";\n";
	echo "\t\tdocument.getElementById (\"blcap_submit_form\").submit();\n";
	echo "\t}\n";
	echo "}\n";
	echo "</script>\n";
	
	echo "<h1 style=\"color: lightblue;\">Blue Captcha v" . $blcap_version . "</h1>\n";
	echo "<h2 style=\"color: darkblue;\">" . __("By Jotis Kokkalis", "blue-captcha") . "</h2>\n";
	
	echo "<h3>" . __("Visit my blue stuff page at", "blue-captcha") . " <a href=\"http://mybluestuff.blogspot.com\" target=\"_blank\">http://mybluestuff.blogspot.com</a>\n";
    echo "<br />" . __("where you can find documentation about Blue Captcha", "blue-captcha") . "</h3>\n";
	
	echo "<hr style=\"color: blue;\" />\n";	

	echo "\n";
	echo "<form action=\"$blcap_mainsite\" id=\"blcap_submit_form\" name=\"blcap_submit_form\" method=\"post\">\n\n";
	echo "<div align=\"center\">\n";
	echo "<input type=\"button\" class=\"button-primary\" value=\" " . __("Uninstall", "blue-captcha") . " \" title=\"" . __("Click here to uninstall plugin", "blue-captcha") . "\" onclick=\"blcap_confirm();\" />\n";
	echo "<input type=\"hidden\" id=\"blcap_action\" name=\"blcap_action\" value=\"\" />\n";
	echo "</div>\n";
	echo "\n</form>\n";
	echo "\n";
	

	echo "<br />\n";
	echo "<h3>" . __("This plugin is free and will always be free", "blue-captcha") . " ;-)</h3>\n";
	echo "<h3>" . __("However, if this plugin has protected you from spammers,", "blue-captcha") . "<br />\n";
	echo __("has helped you in some way or if you just like it, then", "blue-captcha") . "<br />\n";
	echo __("you could donate one dollar or two. Any donation will be highly", "blue-captcha") . "<br />\n";
	echo __("appreciated and will help in further development of this project.", "blue-captcha") . "</h3>\n";
	echo "<br />\n";

	echo "\n<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">\n";
	echo "<input type=\"hidden\" name=\"encrypted\" value=\"-----BEGIN PKCS7-----MIIHPwYJKoZIhvcNAQcEoIIHMDCCBywCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYCM3uBy28muFK6Ww/GA6+sDp5Uz6cww19rI2HHSx7OPNqxOlwx3kmgf/BaLgcOyeVZJfDmaMQi2VsLg5sDtbQ0bSIO0mfvVSsbR60NEmdcOJEIO9byb1OqWJG5K+Dq56a8Zjw6zUisuYnhaTPYyxFGuJlY3KONP3ZEBq2ngho1E8TELMAkGBSsOAwIaBQAwgbwGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIeNfjcHaXTwWAgZjq5Q6q6Q/zinQ4/KrX/LjHxyy1yIGSIuNVfIkrmnfsRohe65KCbBSua/7MbaFVIERtzRLGu7Y39AxDkWhZ/89hGHffoEP3sO907E6oW0gRr3QvVaWv0qx+3+S3wtPpwfeqavLUXOgn+ctlYY4xPy1nhUkMXIRfZVOoEn25+O0vgHw5sgxvByYKZJsDBW8oV5pgMt+3u9TjE6CCA4cwggODMIIC7KADAgECAgEAMA0GCSqGSIb3DQEBBQUAMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTAeFw0wNDAyMTMxMDEzMTVaFw0zNTAyMTMxMDEzMTVaMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAwUdO3fxEzEtcnI7ZKZL412XvZPugoni7i7D7prCe0AtaHTc97CYgm7NsAtJyxNLixmhLV8pyIEaiHXWAh8fPKW+R017+EmXrr9EaquPmsVvTywAAE1PMNOKqo2kl4Gxiz9zZqIajOm1fZGWcGS0f5JQ2kBqNbvbg2/Za+GJ/qwUCAwEAAaOB7jCB6zAdBgNVHQ4EFgQUlp98u8ZvF71ZP1LXChvsENZklGswgbsGA1UdIwSBszCBsIAUlp98u8ZvF71ZP1LXChvsENZklGuhgZSkgZEwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tggEAMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEAgV86VpqAWuXvX6Oro4qJ1tYVIT5DgWpE692Ag422H7yRIr/9j/iKG4Thia/Oflx4TdL+IFJBAyPK9v6zZNZtBgPBynXb048hsP16l2vi0k5Q2JKiPDsEfBhGI+HnxLXEaUWAcVfCsQFvd2A1sxRr67ip5y2wwBelUecP3AjJ+YcxggGaMIIBlgIBATCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwCQYFKw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTEyMDMxODIxNDkyMFowIwYJKoZIhvcNAQkEMRYEFMxLDk7JFi2UMYLHA6CorDFs9ui/MA0GCSqGSIb3DQEBAQUABIGAJcvELjVTqMHf5hHRZKoxTOKEtxRgYF543Uq4QtX/FnboMQ5CtKnmfpsqIbI+aIUl7sW9c9Qvu/YF+uAzecFEdH1fatyrjq+ullfh4PcXivEwmoeFX7u2DqC9zKPhgBrTaRCujA3/KqFDulRwT4lbiZDnwKmwn1p1ykC2+fEJJ/w=-----END PKCS7-----\">\n";
	echo "<input type=\"image\" src=\"https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\">\n";
	echo "<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\">\n";
	echo "</form>\n\n";
	
	echo "<hr style=\"color: cyan; width: 50%;\" />\n";	
	echo "<h3 align=\"center\">''" . __("The entire project was proudly created with NotePad", "blue-captcha") . "''</h3>\n";
	echo "<hr style=\"color: cyan; width: 50%;\" />\n";

	echo "<h3 align=\"center\">" . __("Special Thanks To The Following Contributors", "blue-captcha") . ":</h3>\n";

	echo "<table border=\"0\" align=\"center\" width=\"40%\">\n";

	echo "<tr>\n";
	echo "<td>Ericka Morales Hernández &nbsp; (<a href=\"http://todoriesgo.net/\" target=\"_blank\">http://todoriesgo.net</a>)</td>";
	echo "<td>Italian Translation</td>\n";
	echo "</tr>\n";

	echo "<tr>\n";
	echo "<td>Alex Balashov</td>";
	echo "<td>Russian Translation</td>\n";
	echo "</tr>\n";

	echo "<tr>\n";
	echo "<td>Andrew Kurtis &nbsp; (<a href=\"http://www.webhostinghub.com/\" target=\"_blank\">http://www.webhostinghub.com</a>)</td>";
	echo "<td>Spanish Translation</td>\n";
	echo "</tr>\n";

	echo "</table>\n";
	

	echo "<hr style=\"color: cyan; width: 50%;\" />\n";

	echo "<br />\n";
	echo "<strong>\n";
	echo __("This program is free software; you can redistribute it and/or modify it", "blue-captcha") . "<br />\n";
	echo __("under the terms of the GNU General Public License, version 2,", "blue-captcha") . "<br />\n";
	echo __("as published by the Free Software Foundation.", "blue-captcha") . "<br />\n";
	echo "<br />\n";
	echo __("This program is distributed in the hope that it will be useful,", "blue-captcha") . "<br />\n";
	echo __("but WITHOUT ANY WARRANTY; without even the implied warranty of", "blue-captcha") . "<br />\n";
	echo __("MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU", "blue-captcha") . "<br />\n";
	echo __("General Public License for more details.", "blue-captcha") . "<br />\n";
	echo "<br />\n";
	echo __("You should have received a copy of the GNU General Public License,", "blue-captcha") . "<br />\n";
	echo __("along with this program; if not, write to the Free Software Foundation,", "blue-captcha") . "<br />\n";
	echo __("Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA", "blue-captcha") . "<br />\n";
	echo "<br />\n";
	echo "</strong><br />\n";
}

function blcap_logs ()
{
	global $wpdb;

	blcap_check ();
	
	$blcap_siteurl = get_option ("siteurl"); 
	$blcap_pageurl = $blcap_siteurl . "/wp-admin/admin.php?page="; 
	$blcap_logsite = $blcap_pageurl . "blcap_logs_page";
	
	$blcap_version = get_option ("blcap_version");

	@include_once ("blfuncs.php");
	
	@include_once ("bluelog.php");
}

function blcap_hos ()
{
	global $wpdb;

	blcap_check ();
	
	$blcap_siteurl = get_option ("siteurl"); 
	$blcap_pageurl = $blcap_siteurl . "/wp-admin/admin.php?page="; 
	$blcap_hossite = $blcap_pageurl . "blcap_hos_page";
	
	$blcap_version = get_option ("blcap_version");

	@include_once ("blfuncs.php");
	
	@include_once ("bluehos.php");
}
	
function blcap_options ()
{
	global $wpdb;

	blcap_check ();
	
	$blcap_siteurl = get_option ("siteurl"); 
	$blcap_pageurl = $blcap_siteurl . "/wp-admin/admin.php?page="; 
	$blcap_mainsite = $blcap_pageurl . "blcap_options_page";
	
	$blcap_version = get_option ("blcap_version");

	include_once ("blueoptions.php");
}

function blcap_get_current_url ()
{
	$isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
	$port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
	$port = (($port) ? ":" . $_SERVER["SERVER_PORT"] : "");
	$url = ($isHTTPS ? "https://" : "http://") . $_SERVER["SERVER_NAME"] . $port . $_SERVER["REQUEST_URI"];	
	return $url;
}

function blcap_get_ip ()
{
	$ip_remote = "-";
	if (isset ($_SERVER['REMOTE_ADDR']))
		$ip_remote = $_SERVER['REMOTE_ADDR'];
	
	$ip_client = "-";
	if (isset ($_SERVER['HTTP_CLIENT_IP']))
		$ip_client = $_SERVER['HTTP_CLIENT_IP'];
		
	$ip_forward = "-";
	if (isset ($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ip_forward = $_SERVER['HTTP_X_FORWARDED_FOR'];

	if ($ip_forward == "-") $ip_forward = $ip_client;
	
	if ($ip_forward != "-")
		return array ($ip_forward, $ip_remote);

	return array ($ip_remote, $ip_forward);
}

function blcap_compare_ip ($remoteip, $list)
{
	$list = str_replace (" ", "", $list);
	if ($list == "") return false;
    
	$list_arr = explode (",", $list);
    
	$remoteip_ar = explode (".", $remoteip);
	$rp1 = (isset ($remoteip_ar[0]) ? $remoteip_ar[0] : -1);
	$rp2 = (isset ($remoteip_ar[1]) ? $remoteip_ar[1] : -1);
	$rp3 = (isset ($remoteip_ar[2]) ? $remoteip_ar[2] : -1);
	$rp4 = (isset ($remoteip_ar[3]) ? $remoteip_ar[3] : -1);

	if (is_array ($list_arr))
	foreach ($list_arr as $ip)
	{
		if ($ip == $remoteip) return true;
		else
		{
			$ip_ar = explode (".", $ip);
			$p1 = (isset ($ip_ar[0]) ? $ip_ar[0] : -1);
			$p2 = (isset ($ip_ar[1]) ? $ip_ar[1] : -1);
			$p3 = (isset ($ip_ar[2]) ? $ip_ar[2] : -1);
			$p4 = (isset ($ip_ar[3]) ? $ip_ar[3] : -1);
			if ($p1 == $rp1 && $p2 == $rp2 && ($p3 == $rp3 || $p3 == "*") && ($p4 == $rp4 || $p4 == "*"))
			return true;
		}
	}

	return false;
}

function blcap_calc_spam_probability ($response, $totalchars, $proxy, $refreshes, $captcha)
{
	$MAX_CHARS_PER_SEC = 10.0;

	$pos = 0.0;
	if ($response > 1000000)
	{
		$pos = 99.0;
		if ($captcha == "" || $proxy != "-") $pos = 99.9;
		if ($captcha == "" && $proxy != "-") $pos = 100.0;
	}
	else
	{
		$caplen = strlen ($captcha);
        
		$mincaptime = 1.0*$refreshes + 0.5*$caplen;
        
		$mintypetime = (float)($totalchars / $MAX_CHARS_PER_SEC);
        
		$mintypetime = $mintypetime + $mincaptime;

		if ($mintypetime < 1.0) $mintypetime = 1.0;        
        
		if ($response >= $mintypetime)
			$pos = 0.0;
		else
			$pos = 100.0*(float)(($mintypetime - $response) / $mintypetime*1.0);
        
		if ($caplen == 0) $pos = $pos + 25.0;
    
		if ($proxy != "-") $pos = $pos + 30.0;
        
		if ($pos >= 99.9) $pos = 99.9;
	}
    
	if ($pos > 100.0) $pos = 100.0;

	$pos = number_format ($pos, 1, ".", "");
    
	return $pos;
}

function blcap_check_date ($gen_autogeneratekey = "yes")
{
	global $wpdb;
	
	$current_date = date ("Y/m/d");
	$blcap_date = get_option ("blcap_date");
    
	if ($blcap_date != $current_date)
	{
		add_option ("blcap_date", $current_date);
		update_option ("blcap_date", $current_date);
		
		if ($gen_autogeneratekey == "yes")
		{
			$new_protection_key = "";
			$keycharset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			for ($i = 0 ; $i < 16 ; $i++)
				$new_protection_key .= $keycharset[mt_rand (0, strlen ($keycharset)-1)];
			add_option ("blcap_protection_key", $new_protection_key);
			update_option ("blcap_protection_key", $new_protection_key);
	        }
		
		// truncate DB table of Captcha Sessions Data
		$r = $wpdb->get_results ("TRUNCATE TABLE blcap_sessions");
	}
}

function blcap_loginform ()
{
	global $current_user;

	$blcap_setser = get_option ("blcap_settings");
	if (is_array ($blcap_setser))
		$sss = $blcap_setser;
	else
		$sss = @unserialize ($blcap_setser);
		
	$user_id = (isset ($current_user->ID) ? $current_user->ID : -1);
	$user_level = (isset ($current_user->user_level) ? $current_user->user_level : -1);
	
	$captcha_active = (isset ($sss["gen_activated"]) ? $sss["gen_activated"] : "yes");
	$captcha_enabled = (isset ($sss["log_enabled"]) ? $sss["log_enabled"] : "yes");
	$captcha_user = (isset ($sss["log_user"]) ? $sss["log_user"] : "0");
	$captcha_use_sessions = (isset ($sss["gen_use_sessions"]) ? $sss["gen_use_sessions"] : "no");
	$captcha_refresh_type = (isset ($sss["gen_refreshtype"]) ? $sss["gen_refreshtype"] : "1");
	$enable_translation = (isset ($sss["gen_enable_translation"]) ? $sss["gen_enable_translation"] : "yes");

	if ($captcha_active == "yes" && $captcha_enabled == "yes")
		if ($user_level <= $captcha_user)
		{
			$time = microtime();
			$time = explode(" ", $time);
			$time = $time[1] + $time[0];
			$start_time = $time;
            
			$sid = "L";
			list ($ip, $remote) = blcap_get_ip ();
			$ip_str = str_replace (".", "", $ip);
			$time_str = str_replace (".", "", (string)$time);
			$sid = $sid . $ip_str . $time_str;
			
			$gen_autogeneratekey = (isset ($sss["gen_autogeneratekey"]) ? $sss["gen_autogeneratekey"] : "yes");
			blcap_check_date ($gen_autogeneratekey);
			
			if ($captcha_use_sessions == "yes")
			{
				if (!isset ($_SESSION)) @session_start ();
                
				$_SESSION["capid"] = $sid;
				$_SESSION["caprefresh"] = -1;
				$_SESSION["captime"] = $start_time;
				$_SESSION["capurl"] = blcap_get_current_url ();
			}
			else
			{
				@include_once ("blfuncs.php");
				
				blcap_add_captcha_session ($sid, $ip, "", "", -1, $start_time, blcap_get_current_url ());
			}
			
			$captchaurl = get_option ("siteurl") . "?bcapact=gen&id=" . $sid;
			
			$captcha_layersize = (isset ($sss["gen_layersize"]) ? $sss["gen_layersize"] : "1");
			$captcha_refresh = (isset ($sss["gen_refresh"]) ? $sss["gen_refresh"] : "yes");
			$captcha_empty_check = (isset ($sss["gen_empty_check"]) ? $sss["gen_empty_check"] : "no");
			$required_text = ($captcha_empty_check == "yes_required" ? "required " : "");

			if ($captcha_layersize == "1")
				$wh_tag = "width=\"200\" height=\"50\" ";
			else
				$wh_tag = "";
			
			if ($captcha_refresh == "yes")
			{
				$title = "Click to refresh Captcha Image";
				$refresh_display = "Refresh";
				if ($enable_translation == "yes")
				{
					$title = __("Click to refresh Captcha Image", "blue-captcha");
					$refresh_display = __("Refresh", "blue-captcha");
				}

				$rf_tag = "title=\"$title\" onclick=\"blcap_refresh_captcha();\" onmouseover=\"style.cursor='pointer';\" ";
				if ($captcha_refresh_type == "2" || $captcha_refresh_type == "3")
				{
					$refresh_img_url = get_option ("siteurl") . "/wp-content/plugins/" . plugin_basename (dirname (__FILE__)) . "/bg/bluerefresh1.png";
					$special_type = $captcha_refresh_type == "2" ? "<br />" : " ";
					$rf_span = "<span>" . $special_type . "<img src=\"$refresh_img_url\" title=\"$title\" alt=\"$refresh_display\" onclick=\"blcap_refresh_captcha();\" onmouseover=\"style.cursor='pointer';\" /></span>";
				}
				else
				{
					$rf_span = "<br /><span onclick=\"blcap_refresh_captcha();\" title=\"$title\" onmouseout=\"style.color='black';style.cursor='';\" onmouseover=\"style.color='red';style.cursor='pointer';\">$refresh_display</span><br />";
				}
			}
			else
			{
				$rf_tag = "";
				$rf_span = "";
			}

			$title = "Enter Captcha here";
			if ($enable_translation == "yes")
				$title = __("Enter Captcha here", "blue-captcha");

			echo "\t<p>\n";
			echo "\t\t<div align=\"center\">\n";
			echo "\t\t\t<img id=\"blcap_img\" src=\"$captchaurl\" " . $wh_tag . "alt=\"Blue Captcha Image\" " . $rf_tag . "/>" . $rf_span . "<br />\n";
			echo "\t\t\t<label for=\"user_captcha\">Captcha<br />\n";
			echo "\t\t\t<input type=\"text\" name=\"user_captcha\" id=\"user_captcha\" title=\"$title\" value=\"\" size=\"15\" tabindex=\"30\" " . $required_text . "/></label><br /><br />\n";
			echo "\t\t\t<input type=\"hidden\" name=\"captcha_id\" value=\"" . $sid . "\" />\n";
			echo "\t\t</div>\n";
			echo "\t</p>\n";
	
			if ($captcha_refresh == "yes" || $captcha_empty_check == "yes")
			{
				echo "\n";
				echo "\t<script language=\"javascript\">\n";
				if ($captcha_refresh == "yes")
				{
					echo "\tvar blcap_refno = 0;\n";
					echo "\tfunction blcap_refresh_captcha()\n";
					echo "\t{\n";
					echo "\t\tvar im = new Image();\n";
					echo "\t\tblcap_refno = blcap_refno + 1;\n";
					echo "\t\tim.src = \"" . $captchaurl . "&refresh=\" + blcap_refno;\n";
					echo "\t\tdocument.getElementById (\"blcap_img\").src = im.src;\n";
					echo "\t}\n";
				}
				if ($captcha_empty_check == "yes")
				{
					echo "\tfunction blcap_check_empty_captcha()\n";
					echo "\t{\n";
					echo "\t\tvar captcha = document.getElementById (\"user_captcha\");\n";
					echo "\t\tif (captcha && captcha.value == '')\n";
					echo "\t\t{\n";
					echo "\t\t\tcaptcha.focus();\n";
					echo "\t\t\talert (\"Captcha is empty.\");\n";
					echo "\t\t\treturn false;\n";
					echo "\t\t}\n";
					echo "\t\treturn true;\n";
					echo "\t}\n";
					echo "\tfunction blcap_set_onclick()\n";
					echo "\t{\n";
					echo "\t\tif (!document.getElementById (\"wp-submit\")) setTimeout (\"blcap_set_onclick();\", 200);\n";
					echo "\t\telse document.getElementById (\"wp-submit\").onclick = function () {return blcap_check_empty_captcha();};\n";					
					echo "\t}\n";
					echo "\tblcap_set_onclick();\n";
				}
				echo "\t</script>\n";
				echo "\n";
			}
		}
}

function blcap_loginact ()
{
	global $current_user;

	$blcap_setser = get_option ("blcap_settings");
	if (is_array ($blcap_setser))
		$sss = $blcap_setser;
	else
		$sss = @unserialize ($blcap_setser);

	$user_level = (isset ($current_user->user_level) ? $current_user->user_level : -1);
	
	$captcha_active = (isset ($sss["gen_activated"]) ? $sss["gen_activated"] : "yes");	
	$captcha_enabled = (isset ($sss["log_enabled"]) ? $sss["log_enabled"] : "no");
	$captcha_user = (isset ($sss["log_user"]) ? $sss["log_user"] : "0");
	$captcha_use_sessions = (isset ($sss["gen_use_sessions"]) ? $sss["gen_use_sessions"] : "no");
	$gen_ignore_case = (isset ($sss["gen_ignore_case"]) ? $sss["gen_ignore_case"] : "no");
	$ignore_case = (isset ($sss["log_ignore_case"]) ? $sss["log_ignore_case"] : "general");
	if ($ignore_case == "general") $ignore_case = $gen_ignore_case;
	$enable_translation = (isset ($sss["gen_enable_translation"]) ? $sss["gen_enable_translation"] : "yes");
	
	if ($captcha_active == "yes" && $captcha_enabled == "yes")
		if ($user_level <= $captcha_user && isset ($_REQUEST["log"]) && isset ($_REQUEST["pwd"]))
		{
			$time = microtime();
			$time = explode(" ", $time);
			$time = $time[1] + $time[0];
			$end_time = $time;
            
			$user_captcha = (isset ($_REQUEST["user_captcha"]) ? $_REQUEST["user_captcha"] : "");
			$captcha_id = (isset ($_REQUEST["captcha_id"]) ? $_REQUEST["captcha_id"] : "");
	
			@include_once ("blfuncs.php");
			
			if ($captcha_use_sessions == "yes")
			{
				if (!isset ($_SESSION)) @session_start ();

				$captcha = (isset ($_SESSION["captcha"]) ? $_SESSION["captcha"] : "");
				$start_time = (isset ($_SESSION["captime"]) ? $_SESSION["captime"] : 0);
				$capurl = (isset ($_SESSION["capurl"]) ? $_SESSION["capurl"] : "");
				$refresh = (isset ($_SESSION["caprefresh"]) ? $_SESSION["caprefresh"] : 0);
				if ($refresh < 0) $refresh = 0;
			}
			else
			{        
				$res = blcap_get_captcha_session ($captcha_id);
                
				$captcha = (isset ($res["captcha"]) ? $res["captcha"] : "");
				$start_time = (isset ($res["captime"]) ? $res["captime"] : 0);
				$capurl = (isset ($res["capurl"]) ? $res["capurl"] : "");
				$refresh = (isset ($res["caprefresh"]) ? $res["caprefresh"] : 0);
				if ($refresh < 0) $refresh = 0;
			}

			$protection_key = "";
			$protection_key = get_option ("blcap_protection_key");
			$user_captcha = str_replace (" ", "", $user_captcha);
			$captcha_to_check = $protection_key . $user_captcha;
			if ($ignore_case == "yes") $captcha_to_check = $protection_key . strtoupper ($user_captcha);
            
			if ($captcha != sha1 ($captcha_to_check) || $user_captcha == "" || $captcha == "") $success = false;
			else $success = true;
	
			$gen_log = (isset ($sss["gen_log"]) ? $sss["gen_log"] : "yes");
			$gen_keepinfo = (isset ($sss["gen_keepinfo"]) ? $sss["gen_keepinfo"] : "yes");
			$gen_keeppwd = (isset ($sss["gen_keeppwd"]) ? $sss["gen_keeppwd"] : "no");
   			$ban_iplist = (isset ($sss["ban_iplist"]) ? $sss["ban_iplist"] : "");
   			$ban = (isset ($sss["ban_log"]) ? $sss["ban_log"] : "0");            
            
			$banresult = false;
			if ($ban > 0 && $ban_iplist != "")
			{
				$iparr = blcap_get_ip ();
				$remoteip = (isset ($iparr[0]) ? $iparr[0] : "-");
				$banresult = blcap_compare_ip ($remoteip, $ban_iplist);
				if ($banresult == true) $success = false;
			}
            
			if ($gen_log == "yes")
			{
				$total_time = round (($end_time - $start_time)*100) / 100.0;
				$total_time = number_format ($total_time, 2, ".", "");
				
				$iparr = blcap_get_ip ();
			
				$ip = (isset ($iparr[0]) ? $iparr[0] : "-");
				$proxy = (isset ($iparr[1]) ? $iparr[1] : "-");
				if ($ip == $proxy) $proxy = "-";
				
				$logdate = date ("Y/m/d");
				$logtime = date ("H:i:s");
		
				$info = "";
				if ($gen_keepinfo == "yes")
				{		
					$MAX_LEN = 64;
					
					$username = (isset ($_REQUEST["log"]) ? $_REQUEST["log"] : "-");
					if ($gen_keeppwd == "yes")
					{						
						$password = (isset ($_REQUEST["pwd"]) ? $_REQUEST["pwd"] : "-");
					}
					else if ($gen_keeppwd == "yes_incorrect")
					{
						$password = (isset ($_REQUEST["pwd"]) ? $_REQUEST["pwd"] : "-");
						$user = get_user_by ("login", $username);
						if ($user && wp_check_password ($password, $user->data->user_pass, $user->ID))
							$password = "******";
					}
					else $password = "******";
					
					if (strlen ($username) > $MAX_LEN) $username = substr ($username, 0, $MAX_LEN) . "...";
					if (strlen ($password) > $MAX_LEN) $password = substr ($password, 0, $MAX_LEN) . "...";
					
					$info = $info . "Username: " . $username . "<br>";
					$info = $info . "Password: " . $password;
					
					$info = strip_tags ($info, "<br>");
				}
				else $info = "-";
				
				$totalchars = 0;
				if (isset ($_REQUEST["log"]))
				    $totalchars = $totalchars + strlen (stripslashes ($_REQUEST["log"]));
				if (isset ($_REQUEST["pwd"]))
				    $totalchars = $totalchars + strlen (stripslashes ($_REQUEST["pwd"]));

				$pos = blcap_calc_spam_probability ($total_time, $totalchars, $proxy, $refresh, $user_captcha);

				$more = $totalchars . "#" . $pos;
		        
				if ($success == true) $result = "SUCCESS";
				else $result = "FAIL";
				if ($banresult == true) $result = "BANNED";

				$logres = blcap_add_log ($ip, $proxy, $total_time, "LOGIN", $user_captcha, $refresh, $result, $info, $more, $logdate, $logtime);

				$ipres = blcap_get_ip_db ($ip);
				if ($ipres["found"] == true)
				{
					$thisdate = (isset ($ipres["date"]) ? $ipres["date"] : "");
					$sumprob = (isset ($ipres["sumprob"]) ? (float)$ipres["sumprob"] : 0.0);
					$trialstoday = (isset ($ipres["trialstoday"]) ? (int)$ipres["trialstoday"] : 0);
					$trialstotal = (isset ($ipres["trialstotal"]) ? (int)$ipres["trialstotal"] : 0);
					$failstoday = (isset ($ipres["failstoday"]) ? (int)$ipres["failstoday"] : 0);
					$failstotal = (isset ($ipres["failstotal"]) ? (int)$ipres["failstotal"] : 0);
					
					if ($sumprob == "" || !is_numeric ($sumprob)) $sumprob = 0.0;
					$sumprob = (float)($sumprob * $trialstotal);
					$sumprob = (float)(1.0*($sumprob + $pos) / ($trialstotal + 1.0));
					$sumprob = number_format ($sumprob, 1, ".", "");

					$trialstotal = (int)($trialstotal + 1);
					if ($thisdate != $logdate)
					{
						$trialstoday = 1;
						$failstoday = 0;
					}
					else $trialstoday = $trialstoday + 1;
					if ($success == false)
					{
						$failstotal = (int)($failstotal + 1);
						$failstoday = (int)($failstoday + 1);
					}
					if ($trialstotal > 0) $failure = 100.0*(1.0*$failstotal / (float)$trialstotal);
					else $failure = 0.0;
					$failure = number_format ($failure, 1, ".", "");

					blcap_update_ip_db ($ip, $logdate, $logtime, $end_time, $sumprob, "0", "", "0", "0", $trialstoday, $trialstotal, $failstoday, $failstotal, $failure);
				}
				else
				{
					if ($success == false)
					{
						$fails = 1;
						$failure = 100.0;
					}
					else
					{
						$fails = 0;
						$failure = 0.0;
					}

					blcap_add_ip_db ($ip, $logdate, $logtime, $end_time, $pos, "0", "", "0", "0", "1", "1", $fails, $fails, $failure);
				}
			}
		
			// TODO : add "https" or use str_replace("http://", "https://", $capurl) for https
			if ($success == false)
			{
				echo "<html>";
				echo "<head>";
				echo "<meta charset=\"utf-8\" />";
				echo "</head>";
				echo "<body>";

				if ($enable_translation == "yes")
				{
					$init_text = __("You have entered a Wrong CAPTCHA.", "blue-captcha");
					$click_text = __("Click", "blue-captcha");
					$here_text = __("here", "blue-captcha");
					$back1_text = __("to go back and try again.", "blue-captcha");
					$back2_text = __("Go back and try again.", "blue-captcha");
				}
				else
				{
					$init_text = "You have entered a Wrong CAPTCHA.";
					$click_text = "Click";
					$here_text = "here";
					$back1_text = "to go back and try again.";
					$back2_text = "Go back and try again.";
				}

				if ($capurl != "")
					echo "<div style=\"padding: 5px; border: 2px solid blue; border-radius: 10px; -moz-border-radius: 10px; -khtml-border-radius: 10px; -webkit-border-radius: 10px; -o-border-radius: 10px;  background: yellow; color: red; font-weight: bold; text-align: center;\"><h3>" . $init_text . "</h3><h4>" . $click_text . " <a href=\"" . $capurl . "\">" . $here_text . "</a> " . $back1_text . "</h4></div>\n";
				else
					echo "<div style=\"padding: 5px; border: 2px solid blue; border-radius: 10px; -moz-border-radius: 10px; -khtml-border-radius: 10px; -webkit-border-radius: 10px; -o-border-radius: 10px;  background: yellow; color: red; font-weight: bold; text-align: center;\"><h3>" . $init_text . "</h3><h4>" . $back2_text . "</h4></div>\n";

				echo "</body>";
				echo "</html>";

				die (0);
			}
			else
			{
				if ($captcha_use_sessions == "yes")
					$_SESSION["captcha"] = "";
				else
					blcap_delete_captcha_session ($captcha_id);
			}
		}
}

function blcap_registerform ()
{
	global $current_user;

	$blcap_setser = get_option ("blcap_settings");
	if (is_array ($blcap_setser))
		$sss = $blcap_setser;
	else
		$sss = @unserialize ($blcap_setser);
		
	$user_id = (isset ($current_user->ID) ? $current_user->ID : -1);
	$user_level = (isset ($current_user->user_level) ? $current_user->user_level : -1);
	
	$captcha_active = (isset ($sss["gen_activated"]) ? $sss["gen_activated"] : "yes");	
	$captcha_enabled = (isset ($sss["reg_enabled"]) ? $sss["reg_enabled"] : "yes");
	$captcha_user = (isset ($sss["reg_user"]) ? $sss["reg_user"] : "0");
	$captcha_use_sessions = (isset ($sss["gen_use_sessions"]) ? $sss["gen_use_sessions"] : "no");
	$captcha_refresh_type = (isset ($sss["gen_refreshtype"]) ? $sss["gen_refreshtype"] : "1");
	$enable_translation = (isset ($sss["gen_enable_translation"]) ? $sss["gen_enable_translation"] : "yes");
	
	if ($captcha_active == "yes" && $captcha_enabled == "yes")
		if ($user_level <= $captcha_user)
		{
			$time = microtime();
			$time = explode(" ", $time);
			$time = $time[1] + $time[0];
			$start_time = $time;
            
			$sid = "R";
			list ($ip, $remote) = blcap_get_ip ();
			$ip_str = str_replace (".", "", $ip);
			$time_str = str_replace (".", "", (string)$time);
			$sid = $sid . $ip_str . $time_str;		
			
			$gen_autogeneratekey = (isset ($sss["gen_autogeneratekey"]) ? $sss["gen_autogeneratekey"] : "yes");
			blcap_check_date ($gen_autogeneratekey);
			
			if ($captcha_use_sessions == "yes")
			{
				if (!isset ($_SESSION)) @session_start ();
                
				$_SESSION["capid"] = $sid;
				$_SESSION["caprefresh"] = -1;
				$_SESSION["captime"] = $start_time;
				$_SESSION["capurl"] = blcap_get_current_url ();
			}
			else
			{
				@include_once ("blfuncs.php");
				
				blcap_add_captcha_session ($sid, $ip, "", "", -1, $start_time, blcap_get_current_url ());
			}
			
			$captchaurl = get_option ("siteurl") . "?bcapact=gen&id=" . $sid;
			
			$captcha_layersize = (isset ($sss["gen_layersize"]) ? $sss["gen_layersize"] : "1");
			$captcha_refresh = (isset ($sss["gen_refresh"]) ? $sss["gen_refresh"] : "yes");
			$captcha_empty_check = (isset ($sss["gen_empty_check"]) ? $sss["gen_empty_check"] : "no");
			$required_text = ($captcha_empty_check == "yes_required" ? "required " : "");

			if ($captcha_layersize == "1")
				$wh_tag = "width=\"200\" height=\"50\" ";
			else
				$wh_tag = "";
			
			if ($captcha_refresh == "yes")
			{
				$title = "Click to refresh Captcha Image";
				$refresh_display = "Refresh";
				if ($enable_translation == "yes")
				{
					$title = __("Click to refresh Captcha Image", "blue-captcha");
					$refresh_display = __("Refresh", "blue-captcha");
				}

				$rf_tag = "title=\"$title\" onclick=\"blcap_refresh_captcha();\" onmouseover=\"style.cursor='pointer';\" ";
				if ($captcha_refresh_type == "2" || $captcha_refresh_type == "3")
				{
					$refresh_img_url = get_option ("siteurl") . "/wp-content/plugins/" . plugin_basename (dirname (__FILE__)) . "/bg/bluerefresh1.png";
					$special_type = $captcha_refresh_type == "2" ? "<br />" : " ";
					$rf_span = "<span>" . $special_type . "<img src=\"$refresh_img_url\" title=\"$title\" alt=\"$refresh_display\" onclick=\"blcap_refresh_captcha();\" onmouseover=\"style.cursor='pointer';\" /></span>";
				}
				else
				{
					$rf_span = "<br /><span onclick=\"blcap_refresh_captcha();\" title=\"$title\" onmouseout=\"style.color='black';style.cursor='';\" onmouseover=\"style.color='red';style.cursor='pointer';\">$refresh_display</span><br />";
				}
			}
			else
			{
				$rf_tag = "";
				$rf_span = "";
			}
			
			$title = "Enter Captcha here";
			if ($enable_translation == "yes")
				$title = __("Enter Captcha here", "blue-captcha");

			echo "\t<p>\n";
			echo "\t\t<div align=\"center\">\n";
			echo "\t\t\t<img id=\"blcap_img\" src=\"$captchaurl\" " . $wh_tag . "alt=\"Blue Captcha Image\" " . $rf_tag . "/>" . $rf_span . "<br />\n";
			echo "\t\t\t<label for=\"user_captcha\">Captcha<br />\n";
			echo "\t\t\t<input type=\"text\" name=\"user_captcha\" id=\"user_captcha\" title=\"$title\" value=\"\" size=\"15\" tabindex=\"30\" " . $required_text ."/></label><br /><br />\n";
			echo "\t\t\t<input type=\"hidden\" name=\"captcha_id\" value=\"" . $sid . "\" />\n";
			echo "\t\t</div>\n";
			echo "\t</p>\n";
	
			if ($captcha_refresh == "yes" || $captcha_empty_check == "yes")
			{
				echo "\n";
				echo "\t<script language=\"javascript\">\n";
				if ($captcha_refresh == "yes")
				{
					echo "\tvar blcap_refno = 0;\n";
					echo "\tfunction blcap_refresh_captcha()\n";
					echo "\t{\n";
					echo "\t\tvar im = new Image();\n";
					echo "\t\tblcap_refno = blcap_refno + 1;\n";
					echo "\t\tim.src = \"" . $captchaurl . "&refresh=\" + blcap_refno;\n";
					echo "\t\tdocument.getElementById (\"blcap_img\").src = im.src;\n";
					echo "\t}\n";
				}
				if ($captcha_empty_check == "yes")
				{
					echo "\tfunction blcap_check_empty_captcha()\n";
					echo "\t{\n";
					echo "\t\tvar captcha = document.getElementById (\"user_captcha\");\n";
					echo "\t\tif (captcha && captcha.value == '')\n";
					echo "\t\t{\n";
					echo "\t\t\tcaptcha.focus();\n";
					echo "\t\t\talert (\"Captcha is empty.\");\n";
					echo "\t\t\treturn false;\n";
					echo "\t\t}\n";
					echo "\t\treturn true;\n";
					echo "\t}\n";
					echo "\tfunction blcap_set_onclick()\n";
					echo "\t{\n";
					echo "\t\tif (!document.getElementById (\"wp-submit\")) setTimeout (\"blcap_set_onclick();\", 200);\n";
					echo "\t\telse document.getElementById (\"wp-submit\").onclick = function () {return blcap_check_empty_captcha();};\n";					
					echo "\t}\n";
					echo "\tblcap_set_onclick();\n";
				}
				echo "\t</script>\n";
				echo "\n";
			}
		}
}

function blcap_registerflt ($err)
{
	global $current_user;

	$blcap_setser = get_option ("blcap_settings");
	if (is_array ($blcap_setser))
		$sss = $blcap_setser;
	else
		$sss = @unserialize ($blcap_setser);

	$user_level = (isset ($current_user->user_level) ? $current_user->user_level : -1);
	
	$captcha_active = (isset ($sss["gen_activated"]) ? $sss["gen_activated"] : "yes");	
	$captcha_enabled = (isset ($sss["reg_enabled"]) ? $sss["reg_enabled"] : "yes");
	$captcha_user = (isset ($sss["reg_user"]) ? $sss["reg_user"] : "0");
	$captcha_use_sessions = (isset ($sss["gen_use_sessions"]) ? $sss["gen_use_sessions"] : "no");
	$gen_ignore_case = (isset ($sss["gen_ignore_case"]) ? $sss["gen_ignore_case"] : "no");
	$ignore_case = (isset ($sss["reg_ignore_case"]) ? $sss["reg_ignore_case"] : "general");
	if ($ignore_case == "general") $ignore_case = $gen_ignore_case;
	$enable_translation = (isset ($sss["gen_enable_translation"]) ? $sss["gen_enable_translation"] : "yes");
	
	if ($captcha_active == "yes" && $captcha_enabled == "yes")
		if ($user_level <= $captcha_user)
		{
			$time = microtime();
			$time = explode(" ", $time);
			$time = $time[1] + $time[0];
			$end_time = $time;
            
			$user_captcha = (isset ($_REQUEST["user_captcha"]) ? $_REQUEST["user_captcha"] : "");
			$captcha_id = (isset ($_REQUEST["captcha_id"]) ? $_REQUEST["captcha_id"] : "");
	
			@include_once ("blfuncs.php");
			
			if ($captcha_use_sessions == "yes")
			{
				if (!isset ($_SESSION)) @session_start ();

				$captcha = (isset ($_SESSION["captcha"]) ? $_SESSION["captcha"] : "");
				$start_time = (isset ($_SESSION["captime"]) ? $_SESSION["captime"] : 0);
				$capurl = (isset ($_SESSION["capurl"]) ? $_SESSION["capurl"] : "");
				$refresh = (isset ($_SESSION["caprefresh"]) ? $_SESSION["caprefresh"] : 0);
				if ($refresh < 0) $refresh = 0;
			}
			else
			{        
				$res = blcap_get_captcha_session ($captcha_id);

				$captcha = (isset ($res["captcha"]) ? $res["captcha"] : "");
				$start_time = (isset ($res["captime"]) ? $res["captime"] : 0);
				$capurl = (isset ($res["capurl"]) ? $res["capurl"] : "");
				$refresh = (isset ($res["caprefresh"]) ? $res["caprefresh"] : 0);
				if ($refresh < 0) $refresh = 0;
			}

			$protection_key = "";
			$protection_key = get_option ("blcap_protection_key");
			$user_captcha = str_replace (" ", "", $user_captcha);
			$captcha_to_check = $protection_key . $user_captcha;
			if ($ignore_case == "yes") $captcha_to_check = $protection_key . strtoupper ($user_captcha);
            
			if ($captcha != sha1 ($captcha_to_check) || $user_captcha == "" || $captcha == "") $success = false;
			else $success = true;

			$gen_log = (isset ($sss["gen_log"]) ? $sss["gen_log"] : "yes");
			$gen_keepinfo = (isset ($sss["gen_keepinfo"]) ? $sss["gen_keepinfo"] : "yes");
			$gen_keeppwd = (isset ($sss["gen_keeppwd"]) ? $sss["gen_keeppwd"] : "no");
   			$ban_iplist = (isset ($sss["ban_iplist"]) ? $sss["ban_iplist"] : "");
   			$ban = (isset ($sss["ban_reg"]) ? $sss["ban_reg"] : "0");            
            
			$banresult = false;
			if ($ban > 0 && $ban_iplist != "")
			{
				$iparr = blcap_get_ip ();
				$remoteip = (isset ($iparr[0]) ? $iparr[0] : "-");
				$banresult = blcap_compare_ip ($remoteip, $ban_iplist);
				if ($banresult == true) $success = false;
			}
            
			if ($gen_log == "yes")
			{
				$total_time = round (($end_time - $start_time)*100) / 100.0;
				$total_time = number_format ($total_time, 2, ".", "");
				
				$iparr = blcap_get_ip ();
				
				$ip = (isset ($iparr[0]) ? $iparr[0] : "-");
				$proxy = (isset ($iparr[1]) ? $iparr[1] : "-");
				if ($ip == $proxy) $proxy = "-";
				
				$logdate = date ("Y/m/d");
				$logtime = date ("H:i:s");
		
				$info = "";
				if ($gen_keepinfo == "yes")
				{		
					$MAX_LEN = 64;

					$user_login = (isset ($_REQUEST["user_login"]) ? $_REQUEST["user_login"] : "-");
					$user_email = (isset ($_REQUEST["user_email"]) ? $_REQUEST["user_email"] : "-");
					
					if (strlen ($user_login) > $MAX_LEN) $user_login = substr ($user_login, 0, $MAX_LEN) . "...";
					if (strlen ($user_email) > $MAX_LEN) $user_email = substr ($user_email, 0, $MAX_LEN) . "...";
					
					$info = $info . "Username: " . $user_login . "<br>";
					$info = $info . "Email: " . $user_email;
					
					$info = strip_tags ($info, "<br>");
				}
				else $info = "-";

				$totalchars = 0;
				if (isset ($_REQUEST["user_login"]))
				    $totalchars = $totalchars + strlen (stripslashes ($_REQUEST["user_login"]));
				if (isset ($_REQUEST["user_email"]))
				    $totalchars = $totalchars + strlen (stripslashes ($_REQUEST["user_email"]));

				$pos = blcap_calc_spam_probability ($total_time, $totalchars, $proxy, $refresh, $user_captcha);

				$more = $totalchars . "#" . $pos;
                
				if ($success == true) $result = "SUCCESS";
				else $result = "FAIL";
				if ($banresult == true) $result = "BANNED";

				$logres = blcap_add_log ($ip, $proxy, $total_time, "REGISTER", $user_captcha, $refresh, $result, $info, $more, $logdate, $logtime);

				$ipres = blcap_get_ip_db ($ip);
				if ($ipres["found"] == true)
				{
					$thisdate = (isset ($ipres["date"]) ? $ipres["date"] : "");
					$sumprob = (isset ($ipres["sumprob"]) ? (float)$ipres["sumprob"] : 0.0);
					$trialstoday = (isset ($ipres["trialstoday"]) ? (int)$ipres["trialstoday"] : 0);
					$trialstotal = (isset ($ipres["trialstotal"]) ? (int)$ipres["trialstotal"] : 0);
					$failstoday = (isset ($ipres["failstoday"]) ? (int)$ipres["failstoday"] : 0);
					$failstotal = (isset ($ipres["failstotal"]) ? (int)$ipres["failstotal"] : 0);
					
					if ($sumprob == "" || !is_numeric ($sumprob)) $sumprob = 0.0;
					$sumprob = (float)($sumprob * $trialstotal);
					$sumprob = (float)(1.0*($sumprob + $pos) / ($trialstotal + 1.0));
					$sumprob = number_format ($sumprob, 1, ".", "");

					$trialstotal = (int)($trialstotal + 1);
					if ($thisdate != $logdate)
					{
						$trialstoday = 1;
						$failstoday = 0;
					}
					else $trialstoday = $trialstoday + 1;
					if ($success == false)
					{
						$failstotal = (int)($failstotal + 1);
						$failstoday = (int)($failstoday + 1);
					}
					if ($trialstotal > 0) $failure = 100.0*(1.0*$failstotal / (float)$trialstotal);
					else $failure = 0.0;
					$failure = number_format ($failure, 1, ".", "");

					blcap_update_ip_db ($ip, $logdate, $logtime, $end_time, $sumprob, "0", "", "0", "0", $trialstoday, $trialstotal, $failstoday, $failstotal, $failure);
				}
				else
				{
					if ($success == false)
					{
						$fails = 1;
						$failure = 100.0;
					}
					else
					{
						$fails = 0;
						$failure = 0.0;
					}

					blcap_add_ip_db ($ip, $logdate, $logtime, $end_time, $pos, "0", "", "0", "0", "1", "1", $fails, $fails, $failure);
				}
			}

			// TODO : add "https" or use str_replace("http://", "https://", $capurl) for https
			if ($success == false)
			{
				echo "<html>";
				echo "<head>";
				echo "<meta charset=\"utf-8\" />";
				echo "</head>";
				echo "<body>";

				if ($enable_translation == "yes")
				{
					$init_text = __("You have entered a Wrong CAPTCHA.", "blue-captcha");
					$click_text = __("Click", "blue-captcha");
					$here_text = __("here", "blue-captcha");
					$back1_text = __("to go back and try again.", "blue-captcha");
					$back2_text = __("Go back and try again.", "blue-captcha");
				}
				else
				{
					$init_text = "You have entered a Wrong CAPTCHA.";
					$click_text = "Click";
					$here_text = "here";
					$back1_text = "to go back and try again.";
					$back2_text = "Go back and try again.";
				}

				if ($capurl != "")
					echo "<div style=\"padding: 5px; border: 2px solid blue; border-radius: 10px; -moz-border-radius: 10px; -khtml-border-radius: 10px; -webkit-border-radius: 10px; -o-border-radius: 10px;  background: yellow; color: red; font-weight: bold; text-align: center;\"><h3>" . $init_text . "</h3><h4>" . $click_text . " <a href=\"" . $capurl . "\">" . $here_text . "</a> " . $back1_text . "</h4></div>\n";
				else
					echo "<div style=\"padding: 5px; border: 2px solid blue; border-radius: 10px; -moz-border-radius: 10px; -khtml-border-radius: 10px; -webkit-border-radius: 10px; -o-border-radius: 10px;  background: yellow; color: red; font-weight: bold; text-align: center;\"><h3>" . $init_text . "</h3><h4>" . $back2_text . "</h4></div>\n";

				echo "</body>";
				echo "</html>";

				die (0);
			}
			else
			{
				if ($captcha_use_sessions == "yes")
					$_SESSION["captcha"] = "";
				else
					blcap_delete_captcha_session ($captcha_id);
			}
		}
	
	return $err;
}

function blcap_lostpasswordform ()
{
	global $current_user;

	$blcap_setser = get_option ("blcap_settings");
	if (is_array ($blcap_setser))
		$sss = $blcap_setser;
	else
		$sss = @unserialize ($blcap_setser);
		
	$user_id = (isset ($current_user->ID) ? $current_user->ID : -1);
	$user_level = (isset ($current_user->user_level) ? $current_user->user_level : -1);
	
	$captcha_active = (isset ($sss["gen_activated"]) ? $sss["gen_activated"] : "yes");	
	$captcha_enabled = (isset ($sss["pwd_enabled"]) ? $sss["pwd_enabled"] : "yes");
	$captcha_user = (isset ($sss["pwd_user"]) ? $sss["pwd_user"] : "0");
	$captcha_use_sessions = (isset ($sss["gen_use_sessions"]) ? $sss["gen_use_sessions"] : "no");
	$captcha_refresh_type = (isset ($sss["gen_refreshtype"]) ? $sss["gen_refreshtype"] : "1");
	$enable_translation = (isset ($sss["gen_enable_translation"]) ? $sss["gen_enable_translation"] : "yes");
	
	if ($captcha_active == "yes" && $captcha_enabled == "yes")
		if ($user_level <= $captcha_user)
		{
			$time = microtime();
			$time = explode(" ", $time);
			$time = $time[1] + $time[0];
			$start_time = $time;
            
			$sid = "P";
			list ($ip, $remote) = blcap_get_ip ();
			$ip_str = str_replace (".", "", $ip);
			$time_str = str_replace (".", "", (string)$time);
			$sid = $sid . $ip_str . $time_str;
			
			$gen_autogeneratekey = (isset ($sss["gen_autogeneratekey"]) ? $sss["gen_autogeneratekey"] : "yes");
			blcap_check_date ($gen_autogeneratekey);
			
			if ($captcha_use_sessions == "yes")
			{
				if (!isset ($_SESSION)) @session_start ();
                
				$_SESSION["capid"] = $sid;
				$_SESSION["caprefresh"] = -1;
				$_SESSION["captime"] = $start_time;
				$_SESSION["capurl"] = blcap_get_current_url ();
			}
			else
			{
				@include_once ("blfuncs.php");
				
				blcap_add_captcha_session ($sid, $ip, "", "", -1, $start_time, blcap_get_current_url ());
			}
			
			$captchaurl = get_option ("siteurl") . "?bcapact=gen&id=" . $sid;
			
			$captcha_layersize = (isset ($sss["gen_layersize"]) ? $sss["gen_layersize"] : "1");
			$captcha_refresh = (isset ($sss["gen_refresh"]) ? $sss["gen_refresh"] : "yes");
			$captcha_empty_check = (isset ($sss["gen_empty_check"]) ? $sss["gen_empty_check"] : "no");
			$required_text = ($captcha_empty_check == "yes_required" ? "required " : "");

			if ($captcha_layersize == "1")
				$wh_tag = "width=\"200\" height=\"50\" ";
			else
				$wh_tag = "";
			
			if ($captcha_refresh == "yes")
			{
				$title = "Click to refresh Captcha Image";
				$refresh_display = "Refresh";
				if ($enable_translation == "yes")
				{
					$title = __("Click to refresh Captcha Image", "blue-captcha");
					$refresh_display = __("Refresh", "blue-captcha");
				}

				$rf_tag = "title=\"$title\" onclick=\"blcap_refresh_captcha();\" onmouseover=\"style.cursor='pointer';\" ";
				if ($captcha_refresh_type == "2" || $captcha_refresh_type == "3")
				{
					$refresh_img_url = get_option ("siteurl") . "/wp-content/plugins/" . plugin_basename (dirname (__FILE__)) . "/bg/bluerefresh1.png";
					$special_type = $captcha_refresh_type == "2" ? "<br />" : " ";
					$rf_span = "<span>" . $special_type . "<img src=\"$refresh_img_url\" title=\"$title\" alt=\"$refresh_display\" onclick=\"blcap_refresh_captcha();\" onmouseover=\"style.cursor='pointer';\" /></span>";
				}
				else
				{
					$rf_span = "<br /><span onclick=\"blcap_refresh_captcha();\" title=\"$title\" onmouseout=\"style.color='black';style.cursor='';\" onmouseover=\"style.color='red';style.cursor='pointer';\">$refresh_display</span><br />";
				}
			}
			else
			{
				$rf_tag = "";
				$rf_span = "";
			}
			
			$title = "Enter Captcha here";
			if ($enable_translation == "yes")
				$title = __("Enter Captcha here", "blue-captcha");

			echo "\t<p>\n";
			echo "\t\t<div align=\"center\">\n";
			echo "\t\t\t<img id=\"blcap_img\" src=\"$captchaurl\" " . $wh_tag . "alt=\"Blue Captcha Image\" " . $rf_tag . "/>" . $rf_span . "<br />\n";
			echo "\t\t\t<label for=\"user_captcha\">Captcha<br />\n";
			echo "\t\t\t<input type=\"text\" name=\"user_captcha\" id=\"user_captcha\" title=\"$title\" value=\"\" size=\"15\" tabindex=\"20\" " . $required_text . "/></label><br /><br />\n";
			echo "\t\t\t<input type=\"hidden\" name=\"captcha_id\" value=\"" . $sid . "\" />\n";
			echo "\t\t</div>\n";
			echo "\t</p>\n";

			if ($captcha_refresh == "yes" || $captcha_empty_check == "yes")
			{
				echo "\n";
				echo "\t<script language=\"javascript\">\n";
				if ($captcha_refresh == "yes")
				{
					echo "\tvar blcap_refno = 0;\n";
					echo "\tfunction blcap_refresh_captcha()\n";
					echo "\t{\n";
					echo "\t\tvar im = new Image();\n";
					echo "\t\tblcap_refno = blcap_refno + 1;\n";
					echo "\t\tim.src = \"" . $captchaurl . "&refresh=\" + blcap_refno;\n";
					echo "\t\tdocument.getElementById (\"blcap_img\").src = im.src;\n";
					echo "\t}\n";
				}
				if ($captcha_empty_check == "yes")
				{
					echo "\tfunction blcap_check_empty_captcha()\n";
					echo "\t{\n";
					echo "\t\tvar captcha = document.getElementById (\"user_captcha\");\n";
					echo "\t\tif (captcha && captcha.value == '')\n";
					echo "\t\t{\n";
					echo "\t\t\tcaptcha.focus();\n";
					echo "\t\t\talert (\"Captcha is empty.\");\n";
					echo "\t\t\treturn false;\n";
					echo "\t\t}\n";
					echo "\t\treturn true;\n";
					echo "\t}\n";
					echo "\tfunction blcap_set_onclick()\n";
					echo "\t{\n";
					echo "\t\tif (!document.getElementById (\"wp-submit\")) setTimeout (\"blcap_set_onclick();\", 200);\n";
					echo "\t\telse document.getElementById (\"wp-submit\").onclick = function () {return blcap_check_empty_captcha();};\n";					
					echo "\t}\n";
					echo "\tblcap_set_onclick();\n";
				}
				echo "\t</script>\n";
				echo "\n";
			}
		}
}

function blcap_lostpasswordact ()
{
	global $current_user;

	$blcap_setser = get_option ("blcap_settings");
	if (is_array ($blcap_setser))
		$sss = $blcap_setser;
	else
		$sss = @unserialize ($blcap_setser);

	$user_level = (isset ($current_user->user_level) ? $current_user->user_level : -1);
	
	$captcha_active = (isset ($sss["gen_activated"]) ? $sss["gen_activated"] : "yes");	
	$captcha_enabled = (isset ($sss["pwd_enabled"]) ? $sss["pwd_enabled"] : "yes");
	$captcha_user = (isset ($sss["pwd_user"]) ? $sss["pwd_user"] : "0");
	$captcha_use_sessions = (isset ($sss["gen_use_sessions"]) ? $sss["gen_use_sessions"] : "no");
	$gen_ignore_case = (isset ($sss["gen_ignore_case"]) ? $sss["gen_ignore_case"] : "no");
	$ignore_case = (isset ($sss["pwd_ignore_case"]) ? $sss["pwd_ignore_case"] : "general");
	if ($ignore_case == "general") $ignore_case = $gen_ignore_case;
	$enable_translation = (isset ($sss["gen_enable_translation"]) ? $sss["gen_enable_translation"] : "yes");
	
	if ($captcha_active == "yes" && $captcha_enabled == "yes")
		if ($user_level <= $captcha_user)
		{
			$time = microtime();
			$time = explode(" ", $time);
			$time = $time[1] + $time[0];
			$end_time = $time;
            
 			$user_captcha = (isset ($_REQUEST["user_captcha"]) ? $_REQUEST["user_captcha"] : "");
			$captcha_id = (isset ($_REQUEST["captcha_id"]) ? $_REQUEST["captcha_id"] : "");
	
			@include_once ("blfuncs.php");

			if ($captcha_use_sessions == "yes")
			{
				if (!isset ($_SESSION)) @session_start ();

				$captcha = (isset ($_SESSION["captcha"]) ? $_SESSION["captcha"] : "");
				$start_time = (isset ($_SESSION["captime"]) ? $_SESSION["captime"] : 0);
				$capurl = (isset ($_SESSION["capurl"]) ? $_SESSION["capurl"] : "");
				$refresh = (isset ($_SESSION["caprefresh"]) ? $_SESSION["caprefresh"] : 0);
				if ($refresh < 0) $refresh = 0;
			}
			else
			{        
				$res = blcap_get_captcha_session ($captcha_id);

				$captcha = (isset ($res["captcha"]) ? $res["captcha"] : "");
				$start_time = (isset ($res["captime"]) ? $res["captime"] : 0);
				$capurl = (isset ($res["capurl"]) ? $res["capurl"] : "");
				$refresh = (isset ($res["caprefresh"]) ? $res["caprefresh"] : 0);
				if ($refresh < 0) $refresh = 0;
			}

			$protection_key = "";
			$protection_key = get_option ("blcap_protection_key");
			$user_captcha = str_replace (" ", "", $user_captcha);
			$captcha_to_check = $protection_key . $user_captcha;
			if ($ignore_case == "yes") $captcha_to_check = $protection_key . strtoupper ($user_captcha);

			if ($captcha != sha1 ($captcha_to_check) || $user_captcha == "" || $captcha == "") $success = false;
			else $success = true;
			
			$gen_log = (isset ($sss["gen_log"]) ? $sss["gen_log"] : "yes");
			$gen_keepinfo = (isset ($sss["gen_keepinfo"]) ? $sss["gen_keepinfo"] : "yes");
			$gen_keeppwd = (isset ($sss["gen_keeppwd"]) ? $sss["gen_keeppwd"] : "no");
   			$ban_iplist = (isset ($sss["ban_iplist"]) ? $sss["ban_iplist"] : "");
   			$ban = (isset ($sss["ban_pwd"]) ? $sss["ban_pwd"] : "0");            
            
			$banresult = false;
			if ($ban > 0 && $ban_iplist != "")
			{
				$iparr = blcap_get_ip ();
				$remoteip = (isset ($iparr[0]) ? $iparr[0] : "-");
				$banresult = blcap_compare_ip ($remoteip, $ban_iplist);
				if ($banresult == true) $success = false;
			}

			if ($gen_log == "yes")
			{
				$total_time = round (($end_time - $start_time)*100) / 100.0;
				$total_time = number_format ($total_time, 2, ".", "");
				
				$iparr = blcap_get_ip ();
				
				$ip = (isset ($iparr[0]) ? $iparr[0] : "-");
				$proxy = (isset ($iparr[1]) ? $iparr[1] : "-");
				if ($ip == $proxy) $proxy = "-";
				
				$logdate = date ("Y/m/d");
				$logtime = date ("H:i:s");
		
				$info = "";
				if ($gen_keepinfo == "yes")
				{	
					$MAX_LEN = 64;
					
					$user_login = (isset ($_REQUEST["user_login"]) ? $_REQUEST["user_login"] : "-");
					
					if (strlen ($user_login) > $MAX_LEN) $user_login = substr ($user_login, 0, $MAX_LEN) . "...";
					
					$info = $info . "Username or E-mail: " . $user_login;
					
					$info = strip_tags ($info, "<br>");
				}
				else $info = "-";

				$totalchars = 0;
				if (isset ($_REQUEST["user_login"]))
					$totalchars = $totalchars + strlen (stripslashes ($_REQUEST["user_login"]));

				$pos = blcap_calc_spam_probability ($total_time, $totalchars, $proxy, $refresh, $user_captcha);

				$more = $totalchars . "#" . $pos;

				if ($success == true) $result = "SUCCESS";
				else $result = "FAIL";
				if ($banresult == true) $result = "BANNED";
				
				$logres = blcap_add_log ($ip, $proxy, $total_time, "LOST_PASSWORD", $user_captcha, $refresh, $result, $info, $more, $logdate, $logtime);

				$ipres = blcap_get_ip_db ($ip);
				if ($ipres["found"] == true)
				{
					$thisdate = (isset ($ipres["date"]) ? $ipres["date"] : "");
					$sumprob = (isset ($ipres["sumprob"]) ? (float)$ipres["sumprob"] : 0.0);
					$trialstoday = (isset ($ipres["trialstoday"]) ? (int)$ipres["trialstoday"] : 0);
					$trialstotal = (isset ($ipres["trialstotal"]) ? (int)$ipres["trialstotal"] : 0);
					$failstoday = (isset ($ipres["failstoday"]) ? (int)$ipres["failstoday"] : 0);
					$failstotal = (isset ($ipres["failstotal"]) ? (int)$ipres["failstotal"] : 0);
					
					if ($sumprob == "" || !is_numeric ($sumprob)) $sumprob = 0.0;
					$sumprob = (float)($sumprob * $trialstotal);
					$sumprob = (float)(1.0*($sumprob + $pos) / ($trialstotal + 1.0));
					$sumprob = number_format ($sumprob, 1, ".", "");

					$trialstotal = (int)($trialstotal + 1);
					if ($thisdate != $logdate)
					{
						$trialstoday = 1;
						$failstoday = 0;
					}
					else $trialstoday = $trialstoday + 1;
					if ($success == false)
					{
						$failstotal = (int)($failstotal + 1);
						$failstoday = (int)($failstoday + 1);
					}
					if ($trialstotal > 0) $failure = 100.0*(1.0*$failstotal / (float)$trialstotal);
					else $failure = 0.0;
					$failure = number_format ($failure, 1, ".", "");

					blcap_update_ip_db ($ip, $logdate, $logtime, $end_time, $sumprob, "0", "", "0", "0", $trialstoday, $trialstotal, $failstoday, $failstotal, $failure);
				}
				else
				{
					if ($success == false)
					{
						$fails = 1;
						$failure = 100.0;
					}
					else
					{
						$fails = 0;
						$failure = 0.0;
					}

					blcap_add_ip_db ($ip, $logdate, $logtime, $end_time, $pos, "0", "", "0", "0", "1", "1", $fails, $fails, $failure);
				}
			}

			// TODO : add "https" or use str_replace("http://", "https://", $capurl) for https
			if ($success == false)
			{
				echo "<html>";
				echo "<head>";
				echo "<meta charset=\"utf-8\" />";
				echo "</head>";
				echo "<body>";

				if ($enable_translation == "yes")
				{
					$init_text = __("You have entered a Wrong CAPTCHA.", "blue-captcha");
					$click_text = __("Click", "blue-captcha");
					$here_text = __("here", "blue-captcha");
					$back1_text = __("to go back and try again.", "blue-captcha");
					$back2_text = __("Go back and try again.", "blue-captcha");
				}
				else
				{
					$init_text = "You have entered a Wrong CAPTCHA.";
					$click_text = "Click";
					$here_text = "here";
					$back1_text = "to go back and try again.";
					$back2_text = "Go back and try again.";
				}

				if ($capurl != "")
					echo "<div style=\"padding: 5px; border: 2px solid blue; border-radius: 10px; -moz-border-radius: 10px; -khtml-border-radius: 10px; -webkit-border-radius: 10px; -o-border-radius: 10px;  background: yellow; color: red; font-weight: bold; text-align: center;\"><h3>" . $init_text . "</h3><h4>" . $click_text . " <a href=\"" . $capurl . "\">" . $here_text . "</a> " . $back1_text . "</h4></div>\n";
				else
					echo "<div style=\"padding: 5px; border: 2px solid blue; border-radius: 10px; -moz-border-radius: 10px; -khtml-border-radius: 10px; -webkit-border-radius: 10px; -o-border-radius: 10px;  background: yellow; color: red; font-weight: bold; text-align: center;\"><h3>" . $init_text . "</h3><h4>" . $back2_text . "</h4></div>\n";

				echo "</body>";
				echo "</html>";

				die (0);
			}
			else
			{
				if ($captcha_use_sessions == "yes")
					$_SESSION["captcha"] = "";
				else
					blcap_delete_captcha_session ($captcha_id);
			}            
		}
}

function blcap_commentform ()
{
	global $current_user;

	if (defined ("BLUE_CAPTCHA_COMMENT_FORM"))
	{
		return;
	}

	$blcap_setser = get_option ("blcap_settings");
	if (is_array ($blcap_setser))
		$sss = $blcap_setser;
	else
		$sss = @unserialize ($blcap_setser);
		
	$user_id = (isset ($current_user->ID) ? $current_user->ID : -1);
	$user_level = (isset ($current_user->user_level) ? $current_user->user_level : -1);
	
	$captcha_active = (isset ($sss["gen_activated"]) ? $sss["gen_activated"] : "yes");	
	$captcha_enabled = (isset ($sss["com_enabled"]) ? $sss["com_enabled"] : "yes");
	$captcha_user = (isset ($sss["com_user"]) ? $sss["com_user"] : "0");
	$captcha_use_sessions = (isset ($sss["gen_use_sessions"]) ? $sss["gen_use_sessions"] : "no");
	$captcha_refresh_type = (isset ($sss["gen_refreshtype"]) ? $sss["gen_refreshtype"] : "1");
	$captcha_positioncomment = (isset ($sss["gen_positioncomment"]) ? $sss["gen_positioncomment"] : "1");
	$captcha_positioncommentvalue = (isset ($sss["gen_positioncommentvalue"]) ? $sss["gen_positioncommentvalue"] : "");
	$enable_translation = (isset ($sss["gen_enable_translation"]) ? $sss["gen_enable_translation"] : "yes");

	if ($captcha_positioncomment == "1" || $captcha_positioncommentvalue == "") $captcha_default_position = true;
	else $captcha_default_position = false;

	define ("BLUE_CAPTCHA_COMMENT_FORM", 1);

	if ($captcha_active == "yes" && $captcha_enabled == "yes")
		if ($user_level <= $captcha_user)
		{
			$time = microtime();
			$time = explode(" ", $time);
			$time = $time[1] + $time[0];
			$start_time = $time;
            
			$sid = "C";
			list ($ip, $remote) = blcap_get_ip ();
			$ip_str = str_replace (".", "", $ip);
			$time_str = str_replace (".", "", (string)$time);
			$sid = $sid . $ip_str . $time_str;
			
			$gen_autogeneratekey = (isset ($sss["gen_autogeneratekey"]) ? $sss["gen_autogeneratekey"] : "yes");
			blcap_check_date ($gen_autogeneratekey);
			
			if ($captcha_use_sessions == "yes")
			{
				if (!isset ($_SESSION)) @session_start ();
                
				$_SESSION["capid"] = $sid;
				$_SESSION["caprefresh"] = -1;
				$_SESSION["captime"] = $start_time;
				$_SESSION["capurl"] = blcap_get_current_url ();
			}
			else
			{
				@include_once ("blfuncs.php");
				
				blcap_add_captcha_session ($sid, $ip, "", "", -1, $start_time, blcap_get_current_url ());
			}
			
			$captchaurl = get_option ("siteurl") . "?bcapact=gen&id=" . $sid;
			
			$captcha_layersize = (isset ($sss["gen_layersize"]) ? $sss["gen_layersize"] : "1");
			$captcha_refresh = (isset ($sss["gen_refresh"]) ? $sss["gen_refresh"] : "yes");
			$captcha_empty_check = (isset ($sss["gen_empty_check"]) ? $sss["gen_empty_check"] : "no");
			$required_text = ($captcha_empty_check == "yes_required" ? "required " : "");

			if ($captcha_layersize == "1")
				$wh_tag = "width=\"200\" height=\"50\" ";
			else
				$wh_tag = "";
			
			if ($captcha_refresh == "yes")
			{
				$title = "Click to refresh Captcha Image";
				$refresh_display = "Refresh";
				if ($enable_translation == "yes")
				{
					$title = __("Click to refresh Captcha Image", "blue-captcha");
					$refresh_display = __("Refresh", "blue-captcha");
				}

				$rf_tag = "title=\"$title\" onclick=\"blcap_refresh_captcha();\" onmouseover=\"style.cursor='pointer';\" ";
				if ($captcha_refresh_type == "2" || $captcha_refresh_type == "3")
				{
					$refresh_img_url = get_option ("siteurl") . "/wp-content/plugins/" . plugin_basename (dirname (__FILE__)) . "/bg/bluerefresh1.png";
					$special_type = $captcha_refresh_type == "2" ? "<br />" : " ";
					$rf_span = "<span>" . $special_type . "<img src=\"$refresh_img_url\" title=\"$title\" alt=\"$refresh_display\" onclick=\"blcap_refresh_captcha();\" onmouseover=\"style.cursor='pointer';\" /></span>";
				}
				else
				{
					$rf_span = "<br /><span onclick=\"blcap_refresh_captcha();\" title=\"$title\" onmouseout=\"style.color='black';style.cursor='';\" onmouseover=\"style.color='red';style.cursor='pointer';\">$refresh_display</span><br />";
				}
			}
			else
			{
				$rf_tag = "";
				$rf_span = "";
			}
		

			if ($captcha_default_position == true) // default position
			{
				$title = "Enter Captcha here";
				if ($enable_translation == "yes")
					$title = __("Enter Captcha here", "blue-captcha");
				
				echo "\n\t<p>\n";
				echo "\t\t<div align=\"left\">\n";
				echo "\t\t\t<img id=\"blcap_img\" src=\"$captchaurl\" " . $wh_tag . "alt=\"Blue Captcha Image\" " . $rf_tag . "/>" . $rf_span . "<br />\n";
				echo "\t\t\t<p class=\"comment-form-captcha\"><label for=\"user_captcha\">Captcha</label> <span class=\"required\">*</span>\n";
				echo "\t\t\t<input type=\"text\" name=\"user_captcha\" id=\"user_captcha\" title=\"$title\" value=\"\" size=\"15\" aria-required=\"true\" " . $required_text . "/><br />\n";
				echo "\t\t\t<input type=\"hidden\" name=\"captcha_id\" value=\"" . $sid . "\" /></p>\n";
				echo "\t\t</div>\n";
				echo "\t</p>\n";
				
			}
	
			if ($captcha_default_position == false || $captcha_refresh == "yes" || $captcha_empty_check == "yes" || $captcha_keep_comment == "yes")
			{
				echo "\n";
				echo "\t<script language=\"javascript\">\n";
				if ($captcha_refresh == "yes")
				{
					echo "\tvar blcap_refno = 0;\n";
					echo "\tfunction blcap_refresh_captcha()\n";
					echo "\t{\n";
					echo "\t\tvar im = new Image();\n";
					echo "\t\tblcap_refno = blcap_refno + 1;\n";
					echo "\t\tim.src = \"" . $captchaurl . "&refresh=\" + blcap_refno;\n";
					echo "\t\tdocument.getElementById (\"blcap_img\").src = im.src;\n";
					echo "\t}\n";
				}
				if ($captcha_empty_check == "yes")
				{
					echo "\tfunction blcap_check_empty_captcha()\n";
					echo "\t{\n";
					echo "\t\tvar captcha = document.getElementById (\"user_captcha\");\n";
					echo "\t\tif (captcha && captcha.value == '')\n";
					echo "\t\t{\n";
					echo "\t\t\tcaptcha.focus();\n";
					echo "\t\t\talert (\"Captcha is empty.\");\n";
					echo "\t\t\treturn false;\n";
					echo "\t\t}\n";
					echo "\t\treturn true;\n";
					echo "\t}\n";
					echo "\tfunction blcap_set_onclick()\n";
					echo "\t{\n";
					echo "\t\tif (!document.getElementById (\"submit\")) setTimeout (\"blcap_set_onclick();\", 200);\n";
					echo "\t\telse document.getElementById (\"submit\").onclick = function () {return blcap_check_empty_captcha();};\n";					
					echo "\t}\n";
					echo "\tblcap_set_onclick();\n";
				}
				if ($captcha_default_position == false && !defined ("BLUE_CAPTCHA_COMMENT_CREATE_CAPTCHA_FUNCTION"))
				{
					define ("BLUE_CAPTCHA_COMMENT_CREATE_CAPTCHA_FUNCTION", 1);

					// process value field
					$val = $captcha_positioncommentvalue;
					$vname = $val;
					$vtype = "class";
					$vinsert = "before";
					if (strpos ($val, ':') !== false)
					{
						$parts_arr = explode (":", $val);
						if (isset ($parts_arr[0])) $vname = trim ($parts_arr[0]);
						if (isset ($parts_arr[1]) && trim ($parts_arr[1]) != '') $vtype = $parts_arr[1];
						if (isset ($parts_arr[2]) && trim ($parts_arr[2]) != '') $vinsert = $parts_arr[2];
						$vtype = trim (strtolower ($vtype));
						$vinsert = trim (strtolower ($vinsert));
					}
					
					echo "\tfunction blcap_create_captcha()\n";
					echo "\t{\n";
					echo "\t\tvar element1 = document.createElement (\"p\");\n";
					echo "\t\tvar img = document.createElement (\"img\");\n";
					echo "\t\tvar spanrefresh = document.createElement (\"span\");\n";
					echo "\t\tvar inp = document.createElement (\"input\");\n";
					echo "\t\tvar inphid = document.createElement (\"input\");\n";
					echo "\t\tvar span = document.createElement (\"span\");\n";
					echo "\t\tvar label = document.createElement (\"label\");\n";
					echo "\t\tlabel.setAttribute (\"for\", \"user_captcha\");\n";
					echo "\t\tlabel.appendChild (document.createTextNode (\"Captcha \"));\n";
					echo "\t\tspan.setAttribute (\"class\", \"required\");\n";
					echo "\t\tspan.appendChild (document.createTextNode(\"*\"));\n";
					echo "\t\timg.setAttribute (\"id\", \"blcap_img\");\n";
					echo "\t\timg.setAttribute (\"src\", \"$captchaurl\");\n";
					echo "\t\timg.setAttribute (\"alt\", \"Blue Captcha Image\");\n";
					if ($captcha_refresh == "yes")
					{
						$refresh_title = "Click to refresh Captcha Image";
						$refresh_text = "Refresh";
						$captcha_title = "Enter Captcha here";
						if ($enable_translation == "yes")
						{
							$refresh_title = __("Click to refresh Captcha Image", "blue-captcha");
							$refresh_text = __ ("Refresh", "blue-captcha");
							$captcha_title = __("Enter Captcha here", "blue-captcha");
						}

						echo "\t\timg.setAttribute (\"onclick\", \"blcap_refresh_captcha();\");\n";
						echo "\t\timg.setAttribute (\"onmouseover\", \"style.cursor='pointer';\");\n";
						echo "\t\timg.setAttribute (\"title\", \"" . $refresh_title . "\");\n";

						if ($captcha_refresh_type == "2" || $captcha_refresh_type == "3")
						{
							$refresh_img_url = get_option ("siteurl") . "/wp-content/plugins/" . plugin_basename (dirname (__FILE__)) . "/bg/bluerefresh1.png";
							echo "\t\tvar imgrefresh = document.createElement (\"img\");\n";
							echo "\t\timgrefresh.setAttribute (\"src\", \"$refresh_img_url\");\n";
							echo "\t\timgrefresh.setAttribute (\"onclick\", \"blcap_refresh_captcha();\");\n";
							echo "\t\timgrefresh.setAttribute (\"onmouseover\", \"style.cursor='pointer';\");\n";
							echo "\t\timgrefresh.setAttribute (\"title\", \"" . $refresh_title . "\");\n";

							if ($captcha_refresh_type == "2")
								echo "\t\tspanrefresh.appendChild (document.createElement (\"br\"));\n";
							else
								echo "\t\tspanrefresh.appendChild (document.createTextNode (\" \"));\n";
							echo "\t\tspanrefresh.appendChild (imgrefresh);\n";
						}
						else
						{
							echo "\t\tspanrefresh.setAttribute (\"onclick\", \"blcap_refresh_captcha();\");\n";
							echo "\t\tspanrefresh.setAttribute (\"onmouseout\", \"style.color='black';style.cursor='';\");\n";
							echo "\t\tspanrefresh.setAttribute (\"onmouseover\", \"style.color='red';style.cursor='pointer';\");\n";
							echo "\t\tspanrefresh.setAttribute (\"title\", \"" . $refresh_title . "\");\n";
							echo "\t\tspanrefresh.appendChild (document.createElement (\"br\"));\n";
							echo "\t\tspanrefresh.appendChild (document.createTextNode (\"" . $refresh_text . "\"));\n";
							echo "\t\tspanrefresh.appendChild (document.createElement (\"br\"));\n";
						}
					}

					echo "\t\tinp.setAttribute (\"type\", \"text\");\n";
					echo "\t\tinp.setAttribute (\"name\", \"user_captcha\");\n";
					echo "\t\tinp.setAttribute (\"id\", \"user_captcha\");\n";
					echo "\t\tinp.setAttribute (\"title\", \"" . $captcha_title . "\");\n";
					echo "\t\tinp.setAttribute (\"value\", \"\");\n";
					echo "\t\tinp.setAttribute (\"size\", \"15\");\n";
					echo "\t\tinp.setAttribute (\"aria-required\", \"true\");\n";
					if ($required_text != '')
						echo "\t\tinp.setAttribute (\"required\", \"true\");\n";
					echo "\t\tinphid.setAttribute (\"type\", \"hidden\");\n";
					echo "\t\tinphid.setAttribute (\"name\", \"captcha_id\");\n";
					echo "\t\tinphid.setAttribute (\"value\", \"$sid\");\n";
					echo "\t\telement1.setAttribute (\"align\", \"left\");\n";
					echo "\t\telement1.appendChild (img);\n";
					echo "\t\telement1.appendChild (spanrefresh);\n";
					echo "\t\telement1.appendChild (document.createElement (\"br\"));\n";
					echo "\t\telement1.appendChild (label);\n";
					//echo "\t\telement1.appendChild (span);\n"; // TODO : uncomment this ?
					echo "\t\telement1.appendChild (inp);\n";
					echo "\t\telement1.appendChild (inphid);\n";
					
					if ($vtype == "id")
					{
						echo "\t\tvar src = document.getElementById (\"$vname\");\n";
						echo "\t\tif (src)\n";
						if ($vinsert == "before")					
							echo "\t\t\tsrc.parentNode.insertBefore (element1, src.previousSibling);\n";
						else if ($vinsert == "after")
							echo "\t\t\tsrc.parentNode.insertBefore (element1, src.nextSibling);\n";
						else
							echo "\t\t\tsrc.parentNode.appendChild (element1);\n";
					}
					else // class
					{
						echo "\t\tvar src = document.getElementsByClassName (\"$vname\");\n";
						echo "\t\tif (src[0])\n";
						if ($vinsert == "before")					
							echo "\t\t\tsrc[0].insertBefore (element1, src[0].firstChild);\n";
						else if ($vinsert == "after")
							echo "\t\t\tsrc[0].insertBefore (element1, src[0].firstChild.nextSibling);\n";
						else
							echo "\t\t\tsrc[0].appendChild (element1);\n";
					}

					echo "\t}\n";
				}
				echo "\t</script>\n";
				echo "\n";

			}
		}
}

function blcap_commentform_2 ()
{
	global $current_user, $wp_version;

	if (!defined("BLUE_CAPTCHA_COMMENT_FORM"))
	{
		blcap_commentform ();
	}

	$blcap_setser = get_option ("blcap_settings");
	if (is_array ($blcap_setser))
		$sss = $blcap_setser;
	else
		$sss = @unserialize ($blcap_setser);
		
	$user_id = (isset ($current_user->ID) ? $current_user->ID : -1);
	$user_level = (isset ($current_user->user_level) ? $current_user->user_level : -1);
	
	$captcha_active = (isset ($sss["gen_activated"]) ? $sss["gen_activated"] : "yes");	
	$captcha_enabled = (isset ($sss["com_enabled"]) ? $sss["com_enabled"] : "yes");
	$captcha_user = (isset ($sss["com_user"]) ? $sss["com_user"] : "0");
	$captcha_keep_comment = (isset ($sss["gen_keepcomment"]) ? $sss["gen_keepcomment"] : "no");
	$captcha_positioncomment = (isset ($sss["gen_positioncomment"]) ? $sss["gen_positioncomment"] : "1");
	$captcha_positioncommentvalue = (isset ($sss["gen_positioncommentvalue"]) ? $sss["gen_positioncommentvalue"] : "");

	if ($captcha_positioncomment == "1" || $captcha_positioncommentvalue == "") $captcha_default_position = true;
	else $captcha_default_position = false;

	if ($captcha_active == "yes" && $captcha_enabled == "yes" && ($captcha_keep_comment == "yes" || $captcha_default_position == false))
		if ($user_level <= $captcha_user)
		{
			$keep_comment = $_SESSION["captcha_keepcomment"];
			$keep_comment = trim ($keep_comment);
			$keep_url = (isset ($_SESSION["captcha_keepurl"]) ? $_SESSION["captcha_keepurl"] : "");
			$current_url = blcap_get_current_url ();
			if ($captcha_default_position == false || ($keep_comment != "" && ($current_url == $keep_url || $keep_url == "")))
			{
				echo "\n";
				echo "\t<script language=\"javascript\">\n";
				$keep_comment = str_replace ("\r", "", $keep_comment);
				$keep_comment = str_replace ("\n", "", $keep_comment);
				$keep_comment = str_replace ("\"", "''", $keep_comment);
				echo "\tblcap_create_captcha();\n";
				echo "\tif (document.getElementById(\"comment\")) document.getElementById(\"comment\").value = \"" . $keep_comment . "\";\n";
				echo "\t</script>\n";
				echo "\n";
				$_SESSION["captcha_keepcomment"] = "";
				$_SESSION["captcha_keepurl"] = "";
			}
		}

}

function blcap_commentflt ($subcomment)
{
	global $current_user;
	
	$blcap_setser = get_option ("blcap_settings");
	if (is_array ($blcap_setser))
		$sss = $blcap_setser;
	else
		$sss = @unserialize ($blcap_setser);
		
	$user_level = (isset ($current_user->user_level) ? $current_user->user_level : -1);
	
	$captcha_active = (isset ($sss["gen_activated"]) ? $sss["gen_activated"] : "yes");	
	$captcha_enabled = (isset ($sss["com_enabled"]) ? $sss["com_enabled"] : "yes");
	$captcha_allow_pingtrack = (isset ($sss["gen_pingtrack"]) ? $sss["gen_pingtrack"] : "yes");
	$captcha_user = (isset ($sss["com_user"]) ? $sss["com_user"] : "0");
	$captcha_use_sessions = (isset ($sss["gen_use_sessions"]) ? $sss["gen_use_sessions"] : "no");
	$gen_ignore_case = (isset ($sss["gen_ignore_case"]) ? $sss["gen_ignore_case"] : "no");
	$ignore_case = (isset ($sss["com_ignore_case"]) ? $sss["com_ignore_case"] : "general");
	if ($ignore_case == "general") $ignore_case = $gen_ignore_case;
	$enable_translation = (isset ($sss["gen_enable_translation"]) ? $sss["gen_enable_translation"] : "yes");

	if ($subcomment["comment_type"] == "pingback" || $subcomment["comment_type"] == "trackback")
	{
		if ($captcha_active == "yes" && $captcha_allow_pingtrack == "no")
		{
			$captcha_enabled = "yes";
			$user_level = -1;
		}
		else return $subcomment;
	}
	
	if ($captcha_active == "yes" && $captcha_enabled == "yes")
		if ($user_level <= $captcha_user)
		{
			$time = microtime();
			$time = explode(" ", $time);
			$time = $time[1] + $time[0];
			$end_time = $time;
            
			$user_captcha = (isset ($_REQUEST["user_captcha"]) ? $_REQUEST["user_captcha"] : "");
			$captcha_id = (isset ($_REQUEST["captcha_id"]) ? $_REQUEST["captcha_id"] : "");
	
			@include_once ("blfuncs.php");

			if ($captcha_use_sessions == "yes")
			{
				if (!isset ($_SESSION)) @session_start ();

				$captcha = (isset ($_SESSION["captcha"]) ? $_SESSION["captcha"] : "");
				$start_time = (isset ($_SESSION["captime"]) ? $_SESSION["captime"] : 0);
				$capurl = (isset ($_SESSION["capurl"]) ? $_SESSION["capurl"] : "");
				$refresh = (isset ($_SESSION["caprefresh"]) ? $_SESSION["caprefresh"] : 0);
				if ($refresh < 0) $refresh = 0;
			}
			else
			{        
				$res = blcap_get_captcha_session ($captcha_id);

				$captcha = (isset ($res["captcha"]) ? $res["captcha"] : "");
				$start_time = (isset ($res["captime"]) ? $res["captime"] : 0);
				$capurl = (isset ($res["capurl"]) ? $res["capurl"] : "");
				$refresh = (isset ($res["caprefresh"]) ? $res["caprefresh"] : 0);
				if ($refresh < 0) $refresh = 0;
			}

			$protection_key = "";
			$protection_key = get_option ("blcap_protection_key");
			$user_captcha = str_replace (" ", "", $user_captcha);
			$captcha_to_check = $protection_key . $user_captcha;
			if ($ignore_case == "yes") $captcha_to_check = $protection_key . strtoupper ($user_captcha);
            
			if ($captcha != sha1 ($captcha_to_check) || $user_captcha == "" || $captcha == "") $success = false;
			else $success = true;
			
			$gen_log = (isset ($sss["gen_log"]) ? $sss["gen_log"] : "yes");
			$gen_keepinfo = (isset ($sss["gen_keepinfo"]) ? $sss["gen_keepinfo"] : "yes");
			$gen_keeppwd = (isset ($sss["gen_keeppwd"]) ? $sss["gen_keeppwd"] : "no");
			$gen_keepcomment = (isset ($sss["gen_keepcomment"]) ? $sss["gen_keepcomment"] : "no");
   			$ban_iplist = (isset ($sss["ban_iplist"]) ? $sss["ban_iplist"] : "");
   			$ban = (isset ($sss["ban_com"]) ? $sss["ban_com"] : "0");

			$banresult = false;
			if ($ban > 0 && $ban_iplist != "")
			{
				$iparr = blcap_get_ip ();
				$remoteip = (isset ($iparr[0]) ? $iparr[0] : "-");
				$banresult = blcap_compare_ip ($remoteip, $ban_iplist);
				if ($banresult == true) $success = false;
			}
		
			if ($gen_log == "yes")
			{
				$total_time = round (($end_time - $start_time)*100) / 100.0;
				$total_time = number_format ($total_time, 2, ".", "");
				
				$iparr = blcap_get_ip ();
				
				$ip = (isset ($iparr[0]) ? $iparr[0] : "-");
				$proxy = (isset ($iparr[1]) ? $iparr[1] : "-");
				if ($ip == $proxy) $proxy = "-";
				
				$logdate = date ("Y/m/d");
				$logtime = date ("H:i:s");
				
				$info = "";
				if ($gen_keepinfo == "yes")
				{
					$MAX_LEN = 512;
					$MAX_COMMENT_LEN = 4096;
					
					$author = (isset ($subcomment["comment_author"]) ? $subcomment["comment_author"] : "-");
					$email = (isset ($subcomment["comment_author_email"]) ? $subcomment["comment_author_email"] : "-");
					$authorurl = (isset ($subcomment["comment_author_url"]) ? $subcomment["comment_author_url"] : "-");
					$targeturl = (isset ($capurl) ? $capurl : "");
					$comment = (isset ($subcomment["comment_content"]) ? $subcomment["comment_content"] : "-");
					if (trim ($targeturl) == "") $targeturl = blcap_get_current_url();

					$author = trim (strip_tags ($author));
					$email = trim (strip_tags ($email));
					$authorurl = trim (strip_tags ($authorurl));
					$targeturl = trim (strip_tags ($targeturl));
					$comment = trim (strip_tags ($comment));

					if (strlen ($author) > $MAX_LEN) $author = substr ($author, 0, $MAX_LEN) . "...";
					if (strlen ($email) > $MAX_LEN) $email = substr ($email, 0, $MAX_LEN) . "...";
					if (strlen ($authorurl) > $MAX_LEN) $authorurl = substr ($authorurl, 0, $MAX_LEN) . "...";
					if (strlen ($targeturl) > $MAX_LEN) $targeturl = substr ($targeturl, 0, $MAX_LEN) . "...";
					if (strlen ($comment) > $MAX_COMMENT_LEN) $comment = substr ($comment, 0, $MAX_COMMENT_LEN) . "...";
					
					$comment_type = (isset ($subcomment["comment_type"]) ? $subcomment["comment_type"] : "");

					if ($comment_type == "pingback" || $comment_type == "trackback")
					{
						$comment_type = " (" . $comment_type . ")";
					}
					else $comment_type = "";

					$info = $info . "Author: " . $author . "<br>";
					$info = $info . "Email: " . $email . "<br>";
					$info = $info . "Author URL: " . $authorurl . "<br>";
					$info = $info . "Target URL: " . $targeturl . "<br>";
					$info = $info . "Comment" . $comment_type . ": " . $comment;
					
					$info = strip_tags ($info, "<br>");
				}
				else $info = "-";

				$totalchars = 0;
				if ($user_level < 0 && isset ($subcomment["comment_author"]))
					$totalchars = $totalchars + strlen (stripslashes ($subcomment["comment_author"]));
				if ($user_level < 0 && isset ($subcomment["comment_author_email"]))
					$totalchars = $totalchars + strlen (stripslashes ($subcomment["comment_author_email"]));
				if ($user_level < 0 && isset ($subcomment["comment_author_url"]))
					$totalchars = $totalchars + strlen (stripslashes ($subcomment["comment_author_url"]));
				if (isset ($subcomment["comment_content"]))
					$totalchars = $totalchars + strlen (stripslashes ($subcomment["comment_content"]));
                    
				$pos = blcap_calc_spam_probability ($total_time, $totalchars, $proxy, $refresh, $user_captcha);

				$more = $totalchars . "#" . $pos;
                
				if ($success == true) $result = "SUCCESS";
				else $result = "FAIL";
				if ($banresult == true) $result = "BANNED";
				
				$logres = blcap_add_log ($ip, $proxy, $total_time, "COMMENT", $user_captcha, $refresh, $result, $info, $more, $logdate, $logtime);

				$ipres = blcap_get_ip_db ($ip);
				if ($ipres["found"] == true)
				{
					$thisdate = (isset ($ipres["date"]) ? $ipres["date"] : "");
					$sumprob = (isset ($ipres["sumprob"]) ? (float)$ipres["sumprob"] : 0.0);
					$trialstoday = (isset ($ipres["trialstoday"]) ? (int)$ipres["trialstoday"] : 0);
					$trialstotal = (isset ($ipres["trialstotal"]) ? (int)$ipres["trialstotal"] : 0);
					$failstoday = (isset ($ipres["failstoday"]) ? (int)$ipres["failstoday"] : 0);
					$failstotal = (isset ($ipres["failstotal"]) ? (int)$ipres["failstotal"] : 0);
					
					if ($sumprob == "" || !is_numeric ($sumprob)) $sumprob = 0.0;
					$sumprob = (float)($sumprob * $trialstotal);
					$sumprob = (float)(1.0*($sumprob + $pos) / ($trialstotal + 1.0));
					$sumprob = number_format ($sumprob, 1, ".", "");

					$trialstotal = (int)($trialstotal + 1);
					if ($thisdate != $logdate)
					{
						$trialstoday = 1;
						$failstoday = 0;
					}
					else $trialstoday = $trialstoday + 1;
					if ($success == false)
					{
						$failstotal = (int)($failstotal + 1);
						$failstoday = (int)($failstoday + 1);
					}
					if ($trialstotal > 0) $failure = 100.0*(1.0*$failstotal / (float)$trialstotal);
					else $failure = 0.0;
					$failure = number_format ($failure, 1, ".", "");

					blcap_update_ip_db ($ip, $logdate, $logtime, $end_time, $sumprob, "0", "", "0", "0", $trialstoday, $trialstotal, $failstoday, $failstotal, $failure);
				}
				else
				{
					if ($success == false)
					{
						$fails = 1;
						$failure = 100.0;
					}
					else
					{
						$fails = 0;
						$failure = 0.0;
					}

					blcap_add_ip_db ($ip, $logdate, $logtime, $end_time, $pos, "0", "", "0", "0", "1", "1", $fails, $fails, $failure);
				}
	
			}
			
			if ($success == false)
			{
				if ($gen_keepcomment == "yes")
				{
					if (!isset ($_SESSION)) @session_start ();

					$comment = (isset ($subcomment["comment_content"]) ? $subcomment["comment_content"] : "-");
					$comment = stripslashes ($comment);
					$comment = strip_tags ($comment); // for security reasons...
					$_SESSION["captcha_keepcomment"] = $comment;
					$_SESSION["captcha_keepurl"] = $capurl;
				}

				// TODO : add "https" or use str_replace("http://", "https://", $capurl) for https

				echo "<html>";
				echo "<head>";
				echo "<meta charset=\"utf-8\" />";
				echo "</head>";
				echo "<body>";

				if ($enable_translation == "yes")
				{
					$init_text = __("You have entered a Wrong CAPTCHA.", "blue-captcha");
					$click_text = __("Click", "blue-captcha");
					$here_text = __("here", "blue-captcha");
					$back1_text = __("to go back and try again.", "blue-captcha");
					$back2_text = __("Go back and try again.", "blue-captcha");
				}
				else
				{
					$init_text = "You have entered a Wrong CAPTCHA.";
					$click_text = "Click";
					$here_text = "here";
					$back1_text = "to go back and try again.";
					$back2_text = "Go back and try again.";
				}

				if ($capurl != "")
					echo "<div style=\"padding: 5px; border: 2px solid blue; border-radius: 10px; -moz-border-radius: 10px; -khtml-border-radius: 10px; -webkit-border-radius: 10px; -o-border-radius: 10px;  background: yellow; color: red; font-weight: bold; text-align: center;\"><h3>" . $init_text . "</h3><h4>" . $click_text . " <a href=\"" . $capurl . "\">" . $here_text . "</a> " . $back1_text . "</h4></div>\n";
				else
					echo "<div style=\"padding: 5px; border: 2px solid blue; border-radius: 10px; -moz-border-radius: 10px; -khtml-border-radius: 10px; -webkit-border-radius: 10px; -o-border-radius: 10px;  background: yellow; color: red; font-weight: bold; text-align: center;\"><h3>" . $init_text . "</h3><h4>" . $back2_text . "</h4></div>\n";

				echo "</body>";
				echo "</html>";

				die (0);
			}
			else
			{
				if ($gen_keepcomment == "yes")
				{
					if (!isset ($_SESSION)) @session_start ();

					$_SESSION["captcha_keepcomment"] = "";
					$_SESSION["captcha_keepurl"] = "";
				}

				if ($captcha_use_sessions == "yes")
					$_SESSION["captcha"] = "";
				else
					blcap_delete_captcha_session ($captcha_id);
			}            
		}
	
	return $subcomment;
}

function blcap_update_func ()
{
	blcap_install ();
}

function blcap_get_version ()
{
	if (!function_exists ("get_plugins"))
	require_once (ABSPATH . "wp-admin/includes/plugin.php");
	$plugin_folder = get_plugins ("/" . plugin_basename (dirname (__FILE__)));
	$plugin_file = basename ((__FILE__));
	return $plugin_folder[$plugin_file]["Version"];
}

function blcap_check_for_update ()
{
	$current_version = get_option ("blcap_version");
	
	if ($current_version == "") return;
	
	$new_version = blcap_get_version ();
	
	if ($new_version == $current_version) return;
	if (version_compare ($current_version, $new_version, "<"))
	{
		blcap_update_func ();
	        add_option ("blcap_version", $new_version);
        	update_option ("blcap_version", $new_version);
	}
}

function blcap_init ()
{
	global $current_user;
	
	//blcap_check_for_update ();
	
	@session_start ();
	
	$act = (isset ($_REQUEST["bcapact"]) ? $_REQUEST["bcapact"] : "");

	if ($act == "gen")
	{
		$cid = (isset ($_REQUEST["id"]) ? $_REQUEST["id"] : "");
		@include_once ("blfuncs.php");
		@include_once ("blimage.php");
		die (0);
	}
	else
	if ($act == "exp" || $act == "exphos")
	{
		$user_id = (isset ($current_user->ID) ? $current_user->ID : -1);
		$user_level = (isset ($current_user->user_level) ? $current_user->user_level : -1);
		
		if ($user_id >= 0 && $user_level == 10)
		{
			@include_once ("blfuncs.php");
			
			header ("Content-type: text/html; charset=utf-8");
			header ("Content-type: application/vnd.ms-excel");
			if ($act == "exp")
				header ("Content-disposition: attachment; filename=bluecaptcha_" . date("Ymd") . ".csv");
			else
				header ("Content-disposition: attachment; filename=bluecaptcha_hos_" . date("Ymd") . ".csv");
			
			if ($act == "exp")
			{	
				echo "no;date;time;ip;proxy;captcha;refreshes;response_time;total_chars;type;result;spam_probability;info";
				echo "\n";
				blcap_create_csv ();
			}
			else
			{
				echo "no;ip;last_date;last_time;current_fails;current_trials;total_fails;total_trials;failure;avg_spam_probabiliy";
				echo "\n";
				blcap_create_csv_hos ();
			}			

			die (0);
		}
	}

	// Localization
	load_plugin_textdomain ("blue-captcha", false, dirname (plugin_basename(__FILE__)) . "/languages");
}

global $wp_version;



add_action ("admin_menu", "blcap_add_menus");

add_action ("init", "blcap_init");
add_action ("plugins_loaded", "blcap_check_for_update");

add_action ("login_form", "blcap_loginform");
add_action ("wp_authenticate", "blcap_loginact", 10);

add_action ("register_form", "blcap_registerform", 10);
add_filter ("registration_errors", "blcap_registerflt");

add_action ("lostpassword_form", "blcap_lostpasswordform", 10);
add_action ("lostpassword_post", "blcap_lostpasswordact", 10);

if (version_compare ($wp_version, '3' ,'>='))
{
	add_action ("comment_form_after_fields", "blcap_commentform", 1);
	add_action ("comment_form_logged_in_after", "blcap_commentform", 1);
}
add_action ("comment_form", "blcap_commentform_2", 1);

add_filter ("preprocess_comment", "blcap_commentflt", 1);

register_activation_hook (__FILE__, "blcap_install");

?>
