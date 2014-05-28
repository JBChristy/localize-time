/**
 * local_time_sc.js
 *
 * jQuery for WordPress Local Time SC plugin
 *
 * Plugin URI: https://github.com/JBChristy/local-time
 * @author JB Christy <JBChristy614@gmail.com>
 *
 * @param {object} $ - jQuery
 * @returns {undefined}
 */
(function($){
  $('document').ready(function(){
    // for each <span> with class="local_time_local"
    $('.localize_time_local').each(function(i, el){
      var ts = parseInt($(this).data('timestamp')) // get the UTC timestamp in seconds
        , dt = new Date(ts * 1000) // create a Date object reprsenting the time in the local timezone
        , offset = parseInt($(this).data('offset')) // get offset of the original time
        , textBefore = $(this).data('before') // text to precede local time
        , textAfter  = $(this).data('after')  // text to follow  local time
        , localTime // string for building the text for the span
        , bits // array to get the user's timezone string
        ;
      textBefore = textBefore || ' ('; // default to wrapping local time in parens
      textAfter  = textAfter  || ')';

      if (offset !== dt.getTimezoneOffset()) { // only specify local time if it differs from original
        localTime = textBefore + dt.toLocaleString(); // add date and time formatted for user's locale
        bits = dt.toString().split(/[()]/); // split the default string representation looking for timezone in ()'s
        if (bits.length > 1) localTime += ' ' + bits[1]; // if found, append the timezone to our text
        localTime += textAfter; // finish our text

        $(this).text(localTime);
      }
    });
  });
})(jQuery);