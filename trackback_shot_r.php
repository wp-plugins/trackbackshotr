<?php
/*
 * Plugin Name: TrackbackShotR
 * Plugin URI: http://basicblogger.de/2008/12/07/wp-plugin-trackbackshotr/
 * Description: Show the Trackbacks Shot
 * Version: 0.3
 * Author: Ahmet Topal
 * Author URI: http://basicblogger.de
 */
$bs_option_w = get_option('ts_option_w');

if ('insert' == $HTTP_POST_VARS['action'])
{
    update_option("ts_option_w",$HTTP_POST_VARS['ts_option_w']);
}


// Innerhalb von the_loop reicht das
function ts_description_w() {
  global $id, $post_meta_cache, $ts_option_w; // globale Variablen

  if ( $keys = get_post_custom_keys() ) {
    foreach ( $keys as $key ) {
      $values = array_map('trim', get_post_custom_values($key));
      $value = implode($values,', ');
      if ( $key == ts_option_w ) {
        echo "$value";
      }
    }
  }
} // Ende Funktion ts_description_w()

$ts_option_h = get_option('ts_option_h');

if ('insert' == $HTTP_POST_VARS['action'])
{
    update_option("ts_option_h",$HTTP_POST_VARS['ts_option_h']);
}

// Innerhalb von the_loop reicht das
function ts_description_h() {
  global $id, $post_meta_cache, $ts_option_h; // globale Variablen

  if ( $keys = get_post_custom_keys() ) {
    foreach ( $keys as $key ) {
      $values = array_map('trim', get_post_custom_values($key));
      $value = implode($values,', ');
      if ( $key == ts_option_h ) {
        echo "$value";
      }
    }
  }
} // Ende Funktion ts_description_h()

function ts_option_page() {
?>

<!-- Start Optionen im Admin -->
  <div class="wrap">
    <h2>TrackbackShotR Options</h2>
<form name="form2" method="post" action="<?=$location ?>">
	<label for="width" class="width">Image Width:</label>
      <input name="ts_option_w" value="<?=get_option("ts_option_w");?>" type="text" /><br />
	<label for="height" class="height">Image Heilght:</label>
      <input name="ts_option_h" value="<?=get_option("ts_option_h");?>" type="text" />
      <input type="submit" value="Save" />
      <input name="action" value="insert" type="hidden" />
    </form>
  </div>
<?php
} // Ende Funktion ts_option_page()

// Adminmenu Optionen erweitert
function ts_add_menu() {
  add_option("ts_option_w","90"); // optionsfield in Tabelle TABLEPRÄFIX_options
  add_option("ts_option_h","70"); // optionsfield in Tabelle TABLEPRÄFIX_options
  add_options_page('TrackbackShotR-Plugin', 'TrackbackShotR', 9, __FILE__, 'ts_option_page'); //optionenseite hinzufügen
}

function ts_image($text) {
	global $comment;
	if ((get_comment_type() == "trackback") || (get_comment_type() == "pingback")) {
$ts_url = $comment->comment_author_url;
$ts_option_h = get_option('ts_option_h');
$ts_option_w = get_option('ts_option_w');
$ts_img = "<img src='http://images.websnapr.com/?url=$ts_url&size=t' alt='' class='' width='$ts_option_w' height='$ts_option_h'/>";
$text = "<span class='bs-image' style='float:right;'>$ts_img</span><br />" . $text;
return $text;
}
	else {}
}


add_filter('comment_text', 'ts_image');
add_action('admin_menu', 'ts_add_menu');
?>