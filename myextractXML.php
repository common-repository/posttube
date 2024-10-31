<?php

/*
+----------------------------------------------------------------+
+	wordtube-XML V1.40
+	by Alex Rabe reviewed by Alakhnor
+   	required for PostTube
+----------------------------------------------------------------+
*/

// get the path url from querystring
$playlist_id = $_GET['id'];
$twidth = $_GET['tw'];
if ($twidth == '') $twidth = 90;
$theight = (int) 3/4 * $twidth;

// extract the id name from path
// $playlist_id = basename($wppath);  

$wpconfig = realpath("../../../wp-config.php");
//$wpconfig = dirname($wppath).'/wp-config.php';
if (!file_exists($wpconfig)) die; // stop when wp-config is not there

require_once($wpconfig);
//require_once($wppath.'/wp-config.php');

function get_out_now() { exit; }
add_action('shutdown', 'get_out_now', -1);


global $wpdb;

// Shows all files when 0
if (($playlist_id === 0) or (!$playlist_id && $playlist_id != 'v' && $playlist_id != 'm' && $playlist_id != 'f')) {

	$themediafiles = $wpdb->get_results("SELECT * FROM $wpdb->wordtube ORDER BY vid DESC");
 	$title = 'WordTube Playlist';

}
// Otherwise gets most viewed
elseif ($playlist_id == 'most') {

	$themediafiles = $wpdb->get_results("SELECT * FROM $wpdb->wordtube WHERE counter >0 ORDER BY counter DESC LIMIT 10");
 	$title = 'WordTube Playlist';

}
// Otherwise gets mp3
elseif ($playlist_id == 'music') {

	$themediafiles = $wpdb->get_results("SELECT * FROM $wpdb->wordtube WHERE file LIKE '%.mp3%' ORDER BY vid DESC");
 	$title = 'WordTube Playlist';

}
// Otherwise gets flv
elseif ($playlist_id == 'video') {

	$themediafiles = $wpdb->get_results("SELECT * FROM $wpdb->wordtube WHERE file LIKE '%.flv%' ORDER BY vid DESC");
 	$title = 'WordTube Playlist';

}
// Otherwise gets playlist
else {
 	$playlist = $wpdb->get_row("SELECT * FROM $wpdb->wordtube_playlist WHERE pid = '$playlist_id'");
	$select = " SELECT * FROM {$wpdb->wordtube} w
			INNER JOIN {$wpdb->wordtube_med2play} m
			WHERE (m.playlist_id = '".$playlist_id."' AND m.media_id = w.vid)
			GROUP BY w.vid 
			ORDER BY w.vid ".$playlist->playlist_order;
	$themediafiles = $wpdb->get_results($select);
 	$title = $playlist->playlist_name;
}

// Create XML output
header("content-type:text/xml;charset=utf-8");
	
echo "\n"."<playlist version='1' xmlns='http://xspf.org/ns/0/'>";
echo "\n\t".'<title>'.$title.'</title>';
echo "\n\t".'<trackList>';

$arg = 'width='.$twidth.'&height='.$theight.'&keepratio=0&subfolder=playlist';
	
if (is_array ($themediafiles)){
	foreach ($themediafiles as $tmp) {
		
                $creator = htmlspecialchars(stripslashes($tmp->creator));
                if ($creator == '') $creator = 'Unknown';
                if ($tmp->image == '') $image = get_option('siteurl').'/wp-content/plugins/' . dirname(plugin_basename(__FILE__)).'/wordtube.jpg'; else $image = $tmp->image;

		if (class_exists('')) {
			$t = new pt_thumbnail (get_pt_options_all(), $image, $arg);
			$thumb = $t->thumb_url;
			unset($t);
		} else
			$thumb = $image;

                $file = pathinfo($tmp->file);$ext = strtolower($file['extension']);
                if ($ext == 'flv' or $ext == 'mp3') $icons = true; else $icons = false;

		echo "\n\t\t".'<track>';
		echo "\n\t\t\t".'<title>'.htmlspecialchars(stripslashes($tmp->name)).'</title>';
		echo "\n\t\t\t".'<creator>'.$creator.'</creator>';
		echo "\n\t\t\t".'<location>'.$tmp->file.'</location>';
		echo "\n\t\t\t".'<thumb>'.$thumb.'</thumb>';
		echo "\n\t\t\t".'<image>'.$image.'</image>';
		echo "\n\t\t\t".'<id>'.$tmp->vid.'</id>';
		echo "\n\t\t\t".'<counter>'.$tmp->counter.'</counter>';
		echo "\n\t\t\t".'<icons>'.$icons.'</icons>';
		echo "\n\t\t\t".'<info>'.$tmp->link.'</info>';
		echo "\n\t\t".'</track>';
	}
}
	 
echo "\n\t".'</trackList>';
echo "\n"."</playlist>\n";	

?>