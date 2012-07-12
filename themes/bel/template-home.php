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
	_e('Veuillez installer le plugin wp-multilingual-slider pour afficher les sliders','bel');
}

?></div><?php

get_footer(); ?>
