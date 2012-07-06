<?php
/*
Template Name: Home Template
*/
init_themes_slider();
get_header();
get_sidebar();

?><div id="content"><?php

if (function_exists('print_home_slider')) {
	print_home_slider();
} else {
	echo 'You should install wp-multilingual-slider plugin to handle home slides.';
}

?></div><?php

get_footer(); ?>
