=== qTranslate slug with widget ===
Contributors: 3dolab, teonsight
Homepage: http://www.3dolab.net/en/qtranslateslug-plugin-widget
Tags: qtranslate, translation, slug, sidebar, widget, link, permalink
Requires at least: 2.8
Tested up to: 3.2.1
Stable tag: 0.6

Multiple language slugs for qTranslate, now equipped with its own widget for language selection. 
(Requires qTranslate plugin installed and active)

== Description ==

This plugin allows qTranslate users to have slug translation as well, a basic feature unexpectedly missing in the original plugin.
Based on qTranslateslug code by by Cimatti Consulting, patched to have a new widget replacing qTranslate language selection.
Tested with versions 2.5.7 and 2.5.9.

= Plugin Homepage =

http://www.3dolab.net/en/qtranslateslug-plugin-widget

= What's new? version 0.6 (2012.05.08) =
* Bugfix in saving category fields (line 849)
* Slug translation improved by codetavern & ilpiac

See the CHANGELOG for more information


== Installation ==

Unzip in your plugins directory, then enable it from the admin panel.
Add the selection code widget to the sidebar.

Note that it's still necessary to use the qTranslate language code (query, domain or pre-path mode) in your links:
http://www.mysite.com/slugEN
http://www.mysite.com/FR/slugFR
...

if you get 404 errors, try to put %post_id% in your permalink structure
http://www.mysite.com/EN/001/slugEN
...

the function qTranslateSlug_generateLanguageSelectCode() could be manually inserted wherever into the template, to use it without widgets


== CHANGELOG ==

= 0.6 (2012.05.08) =
* Bugfix in saving category fields (line 849)
* Slug translation improved by codetavern & ilpiac

= 0.5 (2011.09.17) =
* Category slug translation implemented by Matteo Plebani: matteo@comunicrea.com
* Un-tested attempt to support custom post types (including WP E-commerce products)
* Un-tested attempt to remove translated slugs when a post is deleted

= 0.4 (2011.02.17) =
* Bugfix: double slash when static page is frontpage

= 0.3 (2010.10.07) =
* Fixed table name generation with wpdb prefix

= 0.2 (2010.09.25) =
* Fixed error "Cannot redeclare qtrans_widget_init()"
* Requires qTranslate plugin installed and activated

= 0.1 (2010.07.15) =
* Initial release
* Requires qTranslate plugin installed and activated