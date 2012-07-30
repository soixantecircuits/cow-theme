<?php get_header(); ?>
<div class="container-holder hfeed">
	<div class="container-frame hentry"><?php
		if (have_posts()) :

			while (have_posts()) : the_post();
				$right_lang = '1';
				if (function_exists("qtrans_getLanguage")) {
					switch (qtrans_getLanguage()) {
						case 'fr':
							$right_lang = '1';
							break;	
						case 'en':
							$right_lang = '3';
							break;
						default:
							break;
					}
				}
				$right_title = get_post_meta(get_the_ID(), "_simple_fields_fieldGroupID_${right_lang}_fieldID_1_numInSet_0", true);
				$right_map = get_post_meta(get_the_ID(), "_wp_geo_latitude", true);
				$terms = get_terms("project-categories");
				$cat_name = $terms[0]->name; ?>
				<!-- heading -->
				<div class="heading">
					<h2><?php the_title(); ?></h2>
					<!--h3><?php echo $cat_name; ?></h3-->
				</div>
				<div class="post entry-content <?php if ($right_title == null && $right_map == null) echo "full"; ?>">
					<?php the_content(); ?>
				</div>
				<!-- column-info -->
				<div class="column-info">
					<?php if ( function_exists( 'wpgeo_post_map' ) ) wpgeo_post_map(); ?>
				</div><?php
				if ($right_title != null) {
					$right_text = get_post_meta(get_the_ID(), "_simple_fields_fieldGroupID_${right_lang}_fieldID_3_numInSet_0", true);
					$right_img = get_post_meta(get_the_ID(), "_simple_fields_fieldGroupID_${right_lang}_fieldID_2_numInSet_0", true); ?>
					<div class="column-info">
						<div class="block-info holder"><div class="holder"><?php
						if ($right_img != null) { ?>
							<img width="75" height="75" alt="image description" src="<?php echo wp_get_attachment_url($right_img, 'thumbnail'); ?>"/><?php
						} ?>
						<h4 class="fn"><?php echo $right_title; ?></h4><?php
						if ($right_text != null) {
							echo $right_text;
						} ?>
						</div></div>
					<a href="http://bel.dev/soumettre_projet/?lang=<?php echo function_exists("qtrans_getLanguage") ? qtrans_getLanguage() : 'fr'; ?>" 
						class="btn-project-<?php echo function_exists("qtrans_getLanguage") ? qtrans_getLanguage() : 'fr'; ?>"
					><?php _e("Soumettre un projet", "bel"); ?></a>
					</div><?php
				}
				
			endwhile; ?>
		<?php else: ?>
			<div class="post entry-content">
				<div class="heading">
					<h2>Not Found</h2>
				</div>
				<p>Sorry, but you are looking for something that isn't here.</p>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php get_footer(); ?>
