<?php

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
