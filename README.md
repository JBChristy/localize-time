Localize Time
=============

WordPress plugin that provides a shortcode to display times in the user's local timezone.

## Shortcode

This WordPress plugin adds the `[localize_time]` shortcode. The shortcode allows an author
to enter a date and time in any timezone (defaults to site's timezone). The shortcode displays
the original time with timezone, followed by the same time specified in user's browser's
timezone formatted correctly for the user's locale. This is useful for announcing live events,
e.g. a live online streaming event, to international audiences.

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

### FAQ

Q. Can I change the way the local time is formatted?  
A. No. The local time is displayed by the user's browser in a format appropriate for her locale. You can not override it.

Q. What if the user is in the same timezone as the original time?  
A. Users in the same timezone as the web site will see only the original time; the local time will not be displayed,
as it would be repititious.
