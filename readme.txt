=== Blue Captcha ===
Contributors: J. Kokkalis (BlueCoder)
Author URI: http://mybluestuff.blogspot.gr
Donate link: http://mybluestuff.blogspot.gr/p/donate_21.html
Tags: captcha, recaptcha, security, protection, safety, spam, antispam, anti-spam, spammer, login, comments, register, password recovery, blue captcha
Requires at least: 2.8.6
Tested up to: 3.8.1
Stable tag: 1.7.2
License: GPLv2

Blue Captcha is a powerful and highly customized WordPress plugin that effectively protects your WP blogs from spammers and unwanted persons.

== Description ==

Blue Captcha is a powerful and highly customized WordPress plugin that effectively protects your WP blogs from spammers and unwanted persons. It is easily installed and provides high protection against spammers, bots or unwanted persons.

= Do you like Blue Captcha? Then Support it! =

If you like Blue Captcha, then you can help it grow by [__donating one dollar__](http://mybluestuff.blogspot.gr/p/donate_21.html). Any donation will be highly appreciated and will help in further development of this plugin.

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

= Blue Captcha Translation =

Blue Captcha is now available in Greek, Spanish, Russian & Italian.

I would be very grateful if someone is willing to translate Blue Captcha to another language.
For those interested, the template translation file ("blue-captcha.pot") is located on "languages" folder of blue-captcha plugin.

== Installation ==
1. Copy the full directory (blue-captcha) into your wp-content/plugins directory or download the plugin from plugin administration page
2. Activate the plugin at the plugin administration page

== Frequently Asked Questions == 
None for Now

== Contribution ==
Special Thanks To The Following Contributors:

Ericka Morales Hernández (http://todoriesgo.net) => Italian Translation
Alex Balashov => Russian Translation
Andrew Kurtis (http://www.webhostinghub.com) => Spanish Translation

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

= 1.7.2 =
* 16 Mar 2014
* New option "Enable Translation" was added in General Options
* Translation to Russian Language (ru) was added - Translation by Alex Balashov
* Translation to Italian Language (it) was added - Translation by Ericka Morales Hernández

= 1.7.1 =
* 5 Feb 2014
* Translation to Spanish Language (es) was added - Translation by Andrew Kurtis

= 1.7 =
* 21 Dec 2013
* New option "Captcha Position On Comment Form" was added in General Options (Beta)
* New option "Refresh Type" was added in General Options (default text "Refresh" or icon can be used for refreshing captcha)
* Opportunity of selecting a particular color & background for all captcha types
* Template translation file ("blue-captcha.pot") was created and located in "languages" folder
* Translation to Greek Language (el) was added - Translation by Jotis
* Bug with "cut" non-english characters in Log File was fixed
* Minor UI improvements

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
