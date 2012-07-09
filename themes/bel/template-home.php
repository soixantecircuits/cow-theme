<?php
/*
Template Name: Home Template
*/
get_header();
get_sidebar();

?><div id="content"><?php

if (function_exists('print_home_slider')) {
	print_home_slider();
} else {
	_e('You should install wp-multilingual-slider plugin to handle home slides.','bel');
}

?></div><?php

get_footer(); ?>
