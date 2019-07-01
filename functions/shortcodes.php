<?php

/**
 * Custom shortcodes
 */


/**
 * Hide email from Spam Bots using a shortcode.
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 *
 * @return string The obfuscated email address.
 */
function shortcode_hide_email($atts, $content = null) {
   if (!is_email($content)) {
      return;
   }
   return '<a href="mailto:' . antispambot($content) . '">' . antispambot($content) . '</a>';
}


/**
 * Hide email from Spam Bots using a shortcode.
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 *
 * @return string The obfuscated email address.
 */
function shortcode_hide_email2($atts, $content = null) {
   if (!is_email($content)) {
      return;
   }
   return '<a href="mailto:' . antispambot($content) . '">Email</a>';
}


/**
 * Calculates the current age, given a birthdate.
 * Could also be used for anniversaries or any other recurring events.
 *
 * @param string $birthday The date, formatted as dd.MM.yyyy. e.g. 28.12.1969
 *
 * @return string The years since the given date to now as a whole number.
 */
function shortcode_whats_my_age_again($birthday) {
   extract(shortcode_atts(array(
      'birthday' => 'birthday'
   ) , $birthday));
   $birthday = date("Ymd", strtotime($birthday));
   $diff = date("Ymd") - $birthday;
   return substr($diff, 0, -4);
}


/**
 * Creates a preformatted code block with syntax highlighting. Uses prism.js.
 *
 * @param string $lang the programming language used for syntax highlighting. e.g. java
 *
 * @return string the code block
 */
function shortcode_codeblock($atts, $content = null) {
   extract(shortcode_atts(array(
      'lang' => ''
   ) , $atts));
   return '<pre class="normalize-whitespace">'
       . '<code class="lang-'. $lang . '">'
       . $content
       . '</code>'
       . '</pre>';
}


/**
 * Wraps the given content in kbd-html-tags. Also replaces alls blanks with
 * non-breaking-spaces.
 *
 * @return string the content
 */
function shortcode_kbd($atts, $content = null) {
   $content = str_replace(' ', '&nbsp;', $content);
   return '<kbd>'
       . $content
       . '</kbd>';
}
