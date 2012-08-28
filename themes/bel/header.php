<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<?php
		wp_enqueue_style('bel_all', get_bloginfo('template_url').'/all.css');
		wp_enqueue_style('bel_style', get_bloginfo('template_url').'/style.css');
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery_main', get_bloginfo('template_url').'/js/jquery.main.js', array('jquery'), '1.0', true);
		wp_head();
	?>

	<?php $col = 1;
			if(is_page() ||  is_single())
			{
				global $post;
				$columns = get_post_meta($post->ID,'columns',true);
				if($columns)   $col = $columns;

			}
		echo '<script type="text/javascript"> col='.$col.'</script>'; ?>
	<!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/ie.css" /><![endif]-->
</head>
<body>
	<noscript><p>Javascript must be enabled for the correct page display</p></noscript>
	<!-- wrapper -->
	<div id="wrapper" class="vcard">
		<div class="w1">
			<a class="skip" href="#main" tabindex="1" accesskey="s"><?php _e("Aller au contenu", "bel"); ?></a>
			<!-- header -->
			<div id="header">
				<!-- box-logo -->
				<div class="box-logo">
					<div class="frame">
						<!-- logo -->
						<h1 class="logo org fn <?php echo function_exists('qtrans_getLanguage') ? 'logo-'.qtrans_getLanguage() : ''; ?>"><a href="<?php echo get_bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
						<!-- slogan -->
						<strong class="slogan <?php echo function_exists('qtrans_getLanguage') ? 'slogan-'.qtrans_getLanguage() : ''; ?>"><?php bloginfo('description'); ?></strong>
					</div>
				</div>
				<div class="holder">
					<!-- user-panel -->
					<div class="user-panel">
						<!-- box-languague -->
						<?php if (function_exists('qtrans_generateLanguageSelectCode')) { ?>
							<div class="box-language">
								<!-- Custom generation of lang switcher for slug traduction handling -->
								<?php generate_custom_lang_qtranslate();/*echo qtrans_generateLanguageSelectCode('image');*/ ?>
							</div><?php
						} ?>
					</div>
					<?php get_search_form(); ?>
					<?php wp_nav_menu( array('container' => 'div',
						 'theme_location' => 'primary',
						 'menu_id' => 'nav',
						 'container_class' => 'navigation',
						 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						 'walker' => new Custom_Walker_Nav_Menu) ); ?>
				</div>
			</div>
			<div id="main">
			<?php if(!is_front_page()):?>
					<div id="content">
						<div class="container">
							<div class="container-top"></div>
			<?php endif;?>
