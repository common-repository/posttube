=== postTube ===
Contributors: Alakhnor.
Donate link: http://www.alakhnor.com/post-thumb/?page_id=2
Tags: media, video, mp3, swfobject, swf, flash, player, wordtube
Requires at least: 2.3
Tested up to: 2.5
Stable tag: 1.1

postTube is a playlist addon for wordTube.

== Description ==

postTube requires wordTube version 1.60+ to be installed. It displays wordTube playlist with html/css codes to make them more user friendly and easier to integrate into theme design.

If Post-Thumb Revisited is installed and highslide activated, the player can be set into a popup window.

== Installation ==

 * unzip the file and upload it to your plugins directory.
 * activate the plugin through the admin plugin screen.
 * add function into your theme template where you want to display the player.

== Screenshots ==

1. The standalone player and playlist without thumbnail
2. The full player with thumbnails
3. The popup icon and the poped up player

== Usage ==

You can use postTube in three ways:

1. To display the full player:

        `<?php echo get_thePlayer(400, 300, 80, false, 'most', true); ?>`

2. To display the popup player (requires Post-Thumb and highslide activated):

        `<?php echo get_thePopupPlayer(400, 250, 80, 'Videos & mp3'); ?>`

3. To display the player and the playlist separately (standalone):

        `<?php echo get_theMedia(400, 300); ?>`
        `<?php echo get_thePlaylist(250, 200, 80); ?>`

Parameters are:

 * 400: width of the video.
 * 300: height of the video (only for standalone player).
 * 250: width of the playlist.
 * 200: height of the playlist.
 * 80: width of the thumbnails. Height is 3/4 of width. If thumbnails are not displayed, height will be title height.
 * false: echo or not the result.
 * 'most': default playlist to select.
 * true: show thumbnail or not.
 * 'Videos & mp3': title to display under popup icon.

If you're using the full player or the popup player, height of the play screen is set to 3/4 of width.

Display format can be fully customized in posttube.css.




