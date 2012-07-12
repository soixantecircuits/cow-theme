<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/all.css"  />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/style.css"  />
	
	<?php if ( is_singular() ) wp_enqueue_script( 'theme-comment-reply', get_bloginfo('template_url')."/js/comment-reply.js" ); ?>
	
	<?php 
		wp_enqueue_script('jquery'); 
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
	<script src="<?php bloginfo('template_url'); ?>/js/jquery.main.js" type="text/javascript"></script>
	<!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/ie.css" /><![endif]-->
</head>
<body>
	<noscript><p>Javascript must be enabled for the correct page display</p></noscript>
	<!-- wrapper -->
	<div id="wrapper" class="vcard">
		<div class="w1">
			<a class="skip" href="#main" tabindex="1" accesskey="s">Skip to content</a>
			<!-- header -->
			<div id="header">
				<!-- box-logo -->
				<div class="box-logo">
					<div class="frame">
						<!-- logo -->
						<h1 class="logo org fn"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
						<!-- slogan -->
						<strong class="slogan"><?php bloginfo('description'); ?></strong>
					</div>
				</div>
				<div class="holder">
					<!-- user-panel -->
					<div class="user-panel">
						<!-- box-languague -->
						<?php if (function_exists('qtrans_getLanguage')) {
							if (qtrans_getLanguage() == 'en') {
								$lang = 'fr';
							} else {
								$lang = 'en';
							} ?>
								<div class="box-language">
									<?php echo qtrans_generateLanguageSelectCode('image'); ?>
									<!--<a href="#"><img class="png" src="<?php bloginfo('template_url'); ?>/images/flag-en.png" alt="image description" width="14" height="14" /></a>-->
								</div><?php 
						} ?>
						<!-- mail -->
						<a href="#" class="mail">newsletter</a>
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
