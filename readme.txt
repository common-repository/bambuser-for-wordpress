=== Bambuser for Wordpress ===

Author: Mattias Norell
Contributors: Mattias Norell, Niklas Olsson
Tags: bambuser, embed, stream, plugin, quicktag, widget
Requires at least: 2.8
Tested up to: 3.3
Stable tag: 1.5
Embed livestreams and clips from Bambuser.

== Description ==
Embed livestreams and videos from Bambuser.

== Installation ==

1. Unzip the zipfile and upload the files to the '/wp-content/plugins/' directory

2. Activate the plugin.

== Usage ==

Show a single video

1. Enter the '[bambuser id="012345"]' short code into your post. The id number is the numbers in the end of the bambuser url (ex. 012345 in the url 'http://bambuser.com/channel/user/broadcast/012345')

2. If you want, you can set the height and width of the player by adding the values to the shortcode like this, [bambuser id="012345" height="300" width="400"]

Show a channel

1. Enter the '[bambuser channel="user"]' short code into your post. The channelname is the accounts username that you find in the end of the bambuser url (ex. user in the url 'http://bambuser.com/channel/user/')

2. If you want, you can set the height and width of the player by adding the values to the shortcode like this, [bambuser channel="user" height="300" width="600"]. If you dont set a heightvalue the plugin will automaticly set the height to 500.

Parameters

id - Videostream ID. Must be numeric. Default: empty string

channel - Show all videos from a specific user. - Default: empty string

playlist - Options: show / hide - Default: hide

width - Width of the player - Default: 230

height - Height of the player - Default: 276

debug - Options: on / silent / off - Default: off

== Changelog ==

1.5 - Added support for Bambusers embed-API. Added "channel"-setting in widgets.

1.4 - Added support for Widgets and older Android devices.

1.3 - Added support for and automatic detection of iPhone, iPad and iPod.

1.2.1 - Fixed some errors in the usage text.

1.2 - Added support for later versions of WordPress. Modification by Niklas Olsson, www.geckosolutions.se/blog.

1.1 - Added support for channels.

1.0 - First release. User can embed the video and set the size of the player.