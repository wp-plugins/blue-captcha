=== Blue Captcha ===
Contributors: J. Kokkalis (BlueCoder)
Tags: captcha, recaptcha, security, protection, safety, spam, antispam, anti-spam, spammer, login, comments, register, password recovery, blue captcha
Requires at least: 2.8.6
Tested up to: 3.6
Stable tag: 1.6
License: GPLv2

Blue Captcha is a powerful and highly customized WordPress plugin that effectively protects your WP blogs from spammers and unwanted persons.


== Description ==

Blue Captcha is a powerful and highly customized WordPress plugin that effectively protects your WP blogs from spammers and unwanted persons. It is easily installed and provides high protection against spammers, bots or unwanted persons.

Features:
--------
* It can be applied to any of the following : login form, registration form, commentary form or password recovery form
* It's highly customized
* It has 7 predefined CAPTCHA difficulty levels to choose from - of course, you can adjust your CAPTCHA settings and create a custom level
* The possible CAPTCHA customizations are more than enough
* It can apply the same or totally different CAPTCHA settings on login form, registration form, commentary form and password recovery form
* It can display CAPTCHA to only non-registered users or registered users
* It can preview CAPTCHA image before applying it
* It supports 5 different fonts and 30 different background images
* It supports single or double CAPTCHA layer
* It can display up to 20(!) characters on Captcha Images
* It is capable of adding extra drawing (lines, circles, grid, transparent lines) on CAPTCHA image
* It is capable of keeping log file which registers all activities concerning user logins, user registrations, user comments and password recovery
* It has "Hall of Shame" (HoS)
* It provides blocking options as well
* It can export the entire log file or HoS into CSV file (Excel)
* With the help of log file and HoS, it's easy to track down the IP address of spammers or unwanted persons and ban them for ever

You can visit <a href="http://mybluestuff.blogspot.com/p/blue-captcha.html">Blue Captcha Page</a> for more information.


== Installation ==
1. Copy the full directory (blue-captcha) into your wp-content/plugins directory or download the plugin from plugin administration page
2. Activate the plugin at the plugin administration page


== Frequently Asked Questions == 
None for Now


== Screenshots ==
1. Login Options
2. Some Possible Customizations
3. Log File
4. Blue Captcha On Register Form
5. Blue Captcha On Commentary Form #1
6. Blue Captcha On Commentary Form #2
7. Failed Captcha Checks - 99% of cases are bot attempts (especially A, B, C & D)
8. Blocking Options
9. General Options
10. Typical examples of spam bots trying to bypass normal form submission
11. Hall of Shame
12. Typical Brute Force Attack spotted in Log File

== Changelog ==

= 1.6 =
* 16 Aug 2013
* New options were added for "Make Empty Captcha Check Before Form Submission" in General Options
* "Save Incorrect Passwords Only" option was added for "Save Passwords" in General Options
* Issue with saving blocked IPs was fixed (for PHP versions prior to 5.2.9)
* IPs are grouped in Hall Of Shame
* "View Log" link was added for every IP address in Hall Of Shame

= 1.5 =
* 20 Jul 2013
* Blue Captcha entry is now displayed above "Post Comment" button on commentary form
* The attribute "required" was added in all Blue Captcha input fields
* Several UI improvements

= 1.4 =
* 07 Jan 2013
* "Make Empty Captcha Check Before Form Submission" option was added in General Options
* "Keep Comment After Failed Captcha" option was added in General Options
* "Ignore Case Sensitivity In Characters" option was added in Options

= 1.3 =
* 19 Oct 2012
* "IP Informer URL" option was added in General Options
* "Allow Pingbacks & Trackbacks" option was added in General Options
* More details about Comments are provided in Log File
* 25 new background images were added (30 background images are now available in total)

= 1.2 =
* 06 Apr 2012
* "LOST_PASSWORD" type was changed to "LOST PASSWORD" in Log File
* Blue Captcha is now able to estimate Spam Probability
* "# Given Chars" and "% Spam Probability" indicators were added in Log File
* "Hall of Shame" (HoS) was introduced

= 1.1 =
* 26 Mar 2012
* Database management was changed and all DB handling is now made through $wpdb
* Image format returned by Blue Captcha is now "png" (changed from "gif")
* "Random" choice was added to "Background" options
* Captcha Sessions Data can be stored either into Sessions or Database
* Some bugs were fixed
* Security was further improved
* Extra protection key was added

= 1.0 =
* 19 Mar 2012
* Initial version of Blue Captcha WP Plugin
