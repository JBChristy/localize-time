=== Localize Time ===
Contributors: JBChristy
Tags: time, timezone
Requires at least: 3.0.1
Tested up to: 3.9.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provides a shortcode to display arbitray times in users' locale timezones.

== Description ==

This WordPress plugin adds the `[localize_time]` shortcode. The shortcode allows an author
to enter a date and time in any timezone (defaults to site's timezone). The shortcode displays
the original time with timezone, followed by the same time specified in user's browser's
timezone formatted correctly for the user's locale. If the original time is in the same
timezone as the user's timezone the local time is not displayed.

The date and time to be displayed are entered as the shortcode's content, i.e. between the
`[localize_time]` and `[/localize_time]` tags. The shortcode takes the following options:

+ `tz` - the timezone the shortcode's content is in. Defaults to the site's timezone.
  Timezones are specified in any format recognized by
  [PHP's DateTimeZone](http://www.php.net/manual/en/timezones.php).
+ `fmt` - a format string specifying how the original time should be displayed.
  Defaults to the site's date format followed by the site's time format followed by a
  timezone indicator. Specify either 'orig', which presents the time as entered by the
  author, or a format string. The format string uses the same codes that are used on
  WordPress's General Settings tab, i.e. codes specified by
  [PHP's date() function](http://php.net/manual/en/function.date.php).
  Note that the format of the local time is dictated by the user's (browser's) locale,
  and is not configurable via the shortcode.
+ `before_local` - the string to precede the local time. Defaults to ' ('
+ `after_local`  - the string to follow  the local time. Defaults to ')'

### Example

```
[localize_time tz="America/Toronto" fmt="m/d/Y g:i A T"]July 17, 2014 7:30 pm[/localize_time]
```

For a user visiting the site from the America/Los_Angeles timezone, the above code will display

```
07/17/2014 7:30 PM EDT (7/17/2014 4:30:00 PM Pacific Daylight Time)
```

Note that the display of the local time varies by timezone and (slightly) by browser.


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

= How do control the format of the localized time? =

You don't. The localized time is formatted by the user's browser in a format appropriate for her locale.

= Can I style the times? =

Yes. The original time is rendered in a span with class="localize_time_orig". The localized time is
rendered in a span with class="localize_time_local". You can target these classes in your theme's CSS.


== Screenshots ==

1. Examples of entering the shortcode.
2. How the shortcode displays in the US Pacific timezone.


== Changelog ==

= 1.0 =
* Initial release
