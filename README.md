Localize Time
=============

WordPress plugin that provides a **`[localize_time]`** shortcode, which displays times in
the user's local timezone.

## Shortcode

This WordPress plugin adds the **`[localize_time]`** shortcode. The shortcode allows an author
to enter a date and time in any timezone. The shortcode displays the original time with
timezone, followed by the same time in the user's timezone, formatted correctly for the
user's locale. This is useful for announcing live events, e.g. a live online streaming
event, to widely dispersed audiences.

The date and time to be displayed are entered as the shortcode's content, i.e. between the
**`[localize_time]`** and **`[/localize_time]`** tags. The time can be specified in almost
any format that's recognizable as a date and time.

The shortcode takes the following options:

+ **`tz`** - the timezone the shortcode's content is in. If this option is omitted, it defaults
  to the site's timezone. Timezones are specified in any format recognized by
  [PHP's DateTimeZone](http://www.php.net/manual/en/timezones.php).
+ **`fmt`** - a format string specifying how the original time should be displayed. If omitted,
  it defaults to the site's date format followed by the site's time format followed by the
  timezone. To output the original time exactly as entered (with the timezone), specify
  **`fmt="orig"`**. Or you can enter a format string using the same codes that are used on
  WordPress's General Settings tab. See
  [full documentation on date / time format strings here](http://codex.wordpress.org/Formatting_Date_and_Time).
+ **`before_local`** - the string to precede the local time. Defaults to ' ('
+ **`after_local`**  - the string to follow  the local time. Defaults to ')'


### Examples

Below are examples of using the shortcode. For these examples, the site's timezone is set to America/New_York (EST-5EDT) and the user is in the America/Los_Angeles (PST-8PDT) timezone.

* Local time is in a different year and month from original time:  
  `[localize_time]1/1/2014 1:00 am[/localize_time]`  
  outputs:  
  January 1, 2014 1:00 am EST (12/31/2013, 10:00:00 PM PST)

* Specify a time in timezone different from the site's:  
  `[localize_time tz="Europe/Paris" ]July 14, 2014 19:00[/localize_time]`  
  outputs:  
  July 14, 2014 7:00 pm CEST (7/14/2014, 10:00:00 AM PDT)

* Specify a format for the original time:  
  `[localize_time fmt="m/d/Y g:i A T"]June 14, 2014 6:30 AM[/localize_time]`  
  outputs:  
  06/14/2014 6:30 AM EDT (6/14/2014, 3:30:00 AM PDT)

* Specify a time in the same timezone as the user:  
  `[localize_time tz="PST"]3pm Nov. 1, 2014[/localize_time]`  
  outputs:  
  November 1, 2014 3:00 pm PDT


Note that the display of the local time varies by timezone and browser.


## FAQ

Q. Can I change the way the local time is formatted?  
A. No. The local time is displayed by the user's browser in a format appropriate for her locale. You can not change the format.

Q. What if the user is in the same timezone as the original time?  
A. Users in the same timezone as the web site will see only the original time; the local time will not be displayed,
as it would be repititious.

Q. Can I style the times?  
A. Yes. In your theme's CSS target `.localize_time_orig` to style the original times and `.localize_time_local` to style the local times.
