<?php
/**
 * Plugin Name: Localize Time
 * Plugin URI: https://github.com/JBChristy/localize-time
 * Description: Provide a shortcode to allow displaying a time in the user's local timezone
 * Version: 1.0.0
 * Author: JB Christy <JBChristy614@gmail.com>
 * License: GPL2
 */

/*  Copyright 2014  JB Christy  (email : JBChristy614@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


class localize_time {

  /** @staticvar localize_time - singleton instance of this class */
  private static $instance = NULL;

  /**
   * Returns the singleton instance of this class, generating it if necessary
   *
   * @return localize_time - the singleton instance
   */
  public static function factory() {
    if (NULL === self::$instance) {
      self::$instance = new localize_time();
    }

    return self::$instance;
  }


  /**
   * constructor - declared protected to prevent creating instance outside
   * this class using 'new'
   *
   * adds the shortcode
   */
  protected function __construct() {
    add_shortcode('localize_time', array($this, 'shortcode_localize_time'));
  }

  /**
   * [localize_time] shortcode processing
   *
   * @param array $atts - options passed to the shortcode. Valid options are:
   *    tz  - valid timezone identifier, which specifies $content's timezone (original timezone)
   *          default: site's timezone
   *    fmt - 'orig' OR format string appropriate for date() function, which specifies format for
   *          original time. If 'orig' is specified, the time will be displayed as entered by the
   *          author.
   *          default: site's date format followed by site's time format followed by timezone
   *    before_local, after_local - strings to wrap the local time in
   *          default: ' (' and ')' (wraps the local time in parens)
   * @param string $content - the time in any format parsable by strtotime()
   *
   * @return string - HTML with time in the timezone entered by the author and an empty span to
   *                  hold the localized time
   */
  public function shortcode_localize_time($atts, $content = NULL) {
    // enqueue our jQuery, which fills the localize_time_local span with the user's local time
    // based on the UTC timestamp, formatted for user's locale
    wp_register_script('localize_time', plugins_url('localize-time.js', __FILE__), 'jQuery', 1.0);
    wp_enqueue_script('localize_time');

    // get our options and make them variables
    extract( shortcode_atts(array(
        'tz'  => get_option('timezone_string')
      , 'fmt' => get_option('date_format') . ' ' . get_option('time_format') . ' T'
      , 'before_local' => NULL
      , 'after_local'  => NULL
    ), $atts, 'localize_time'));

    // do the server-side calculations
    try {
      $timezone = new DateTimeZone($tz);
      $time = new DateTime($content, $timezone); // get DateTime object in appropriate timezone
      if ($fmt != 'orig') { // format the time in the original timezone
        $time_orig = $time->format($fmt);
      } else { // use time as entered by author
        $time_orig = $content;
        if (strpos($time_orig, $tz) === FALSE) { // if author didn't include timezone
          $time_orig .= " {$tz}"; // ensure original timezone is displayed to the user
        }
      }
      // get offset of original timezone in minutes behind GMT to match Javascript Date.getTimezoneOffset()
      $js_offset = $timezone->getOffset($time) / -60;
      $time->setTimezone(new DateTimeZone('GMT')); // translate the time to UTC
      $timestamp = $time->getTimestamp(); // get the UTC timestamp in seconds
    } catch (Exception $e) { // if there were erros parsing the time or the timezone
      return "<span class='error'>" . $e->getMessage() . "</span>"; // display the error message and fail gracefully
    }

    // build the html
    // first the space conatining the time in the original timezone
    $html  = "<span class='localize_time_orig'>"; // <span> containing the time in the original timezone
    $html .= $time_orig;
    $html .= "</span>";

    // add the span where the javascript will place the user's local time
    $html .= "<span class='localize_time_local'"; // js will look for all elements with this class
    $html .= " data-timestamp='{$timestamp}' data-offset='{$js_offset}'";
    if (!empty($before_local)) $html .= " data-before='" . attribute_escape($before_local) . "'";
    if (!empty($after_local))  $html .= " data-after='"  . attribute_escape($after_local)  . "'";
    $html .= "></span>"; // span is initially empty - will be filled in by the javaascript

    // return the html for display
    return $html;
  }

}

// create singleton instance of our class
if (empty($localize_time_singleton)) $localize_time_singleton = localize_time::factory();
