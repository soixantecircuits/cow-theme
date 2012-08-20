=== Autoptimize ===
Contributors: turl
Donate link: http://www.turleando.com.ar/autoptimize/
Tags: css, html, javascript, js, optimize, speed, cache
Requires at least: 2.7
Tested up to: 3.3.1
Stable tag: 1.4

Autoptimize is a Wordpress plugin that speeds up your website, and helps you save bandwidth. 

== Description ==

Autoptimize makes optimizing your site really easy. It concatenates all scripts and styles, minifies and compresses them, adds expires headers, caches them, and moves styles to the page head, and scripts to the footer. It also minifies the HTML code itself, making your page really lightweight.

I also recommend using WP Super Cache in conjuction with Autoptimize to speed up your blog.

You can [report bugs](https://bugs.launchpad.net/autoptimize), [ask questions](https://answers.launchpad.net/autoptimize) and [help with translations](https://translations.launchpad.net/autoptimize) in our [Launchpad page](https://launchpad.net/autoptimize).

== Installation ==

1. Upload the `autoptimize` folder to  to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to `Settings -> Autoptimize` and enable the options you want. Generally this means "Optimize HTML/CSS/JavaScript", but if you experience problems you might want to disable some.

== Frequently Asked Questions ==

= What does the plugin do to help speed up my site? =

It concatenates all scripts and styles, minifies and compresses them, adds expires headers, caches them, and moves styles to the page head, and scripts to the footer. It also minifies the HTML code itself, making your page really lightweight.

= Where can I report an error? =

You can fill in a bug in our [bug tracker](https://bugs.launchpad.net/autoptimize), or contact the author through Twitter (@turl) or email (turl at tuxfamily dot org).

= Can I help translating the plugin? =

Sure, you can help with translations in the [Launchpad translation page](https://translations.launchpad.net/autoptimize)

== Changelog ==

= 1.4 =
* Add support for inline style tags with CSS media
* Fix Wordpress top bar

= 1.3 =
* Add workaround for TinyMCEComments
* Add workaround for asynchronous Google Analytics

= 1.2 =
* Add workaround for Chitika ads.
* Add workaround for LinkWithin widget.
* Belorussian translation

= 1.1 =
* Add workarounds for amazon and fastclick
* Add workaround for Comment Form Quicktags
* Fix issue with Vipers Video Quicktags
* Fix a bug in where some scripts that shouldn't be moved were moved
* Fix a bug in where the config page wouldn't appear
* Fix @import handling
* Implement an option to disable js/css gzipping
* Implement CDN functionality
* Implement data: URI generation for images
* Support YUI CSS/JS Compressor
* Performance increases
* Handle WP Super Cache's cache files better
* Update translations

= 1.0 =
* Add workaround for whos.among.us
* Support preserving HTML Comments. 
* Implement "delayed cache compression"
* French translation
* Update Spanish translation

= 0.9 =
* Add workaround for networkedblogs.
* Add workarounds for histats and statscounter
* Add workaround for smowtion and infolinks. 
* Add workaround for Featured Content Gallery
* Simplified Chinese translation
* Update Spanish Translation
* Modify the cache system so it uses wp-content/cache/
* Add a clear cache button

= 0.8 =
* Add workaround for Vipers Video Quicktags
* Support <link> tags without media.
* Take even more precautions so we don't break urls in CSS
* Support adding try-catch wrappings to JavaScript code
* Add workaround for Wordpress.com Stats
* Fix a bug in where the tags wouldn't move
* Update translation template
* Update Spanish translation

= 0.7 =
* Add fix for DISQUS Comment System.

= 0.6 =
* Add workaround for mybloglog, blogcatalog, tweetmeme and Google CSE 

= 0.5 =
* Support localization
* Fix the move and don't move system (again)
* Improve url detection in CSS
* Support looking for scripts and styles on just the header
* Fix an issue with data: uris getting modified
* Spanish translation

= 0.4 =
* Write plugin description in English
* Set default config to everything off
* Add link from plugins page to options page
* Fix problems with scripts that shouldn't be moved and were moved all the same

= 0.3 =
* Disable CSS media on @imports - caused an infinite loop

= 0.2 =
* Support CSS media
* Fix an issue in the IE Hacks preservation mechanism
* Fix an issue with some urls getting broken in CSS

= 0.1 =
* First released version.
