<?php get_header(); ?>
<div class="container-holder hfeed">
	<div class="container-frame hentry">
		<?php if (have_posts()) : ?>

			<?php while (have_posts()) : the_post(); ?>
				<?php $terms = get_terms("project-categories");
					$cat_name = $terms[1]->name; ?>
				<div class="post entry-content">
					<!-- heading -->
					<div class="heading">
						<h2><?php the_title(); ?></h2>
						<h3><?php echo $cat_name; ?></h3>
					</div>
					<hr />
					<?php the_content(); ?>
					<hr />
					<?php comments_template(); ?>
				</div>
				<!-- column-info -->
				<div class="column-info">
					
					<?php $top_right_image_path = get_post_meta(get_the_ID(),'top_right_image_path',true);?>
					<?php $right_side = get_post_meta(get_the_ID(),'right_side',true);?>
					<?php global $left_image_path; $left_image_path = get_post_meta(get_the_ID(),'left_image_path',true);?>
					<?php if($top_right_image_path):?>
						<div class="block-map">
							<img src="<?php echo str_replace(array('[site-url]','[template-url]'),array(get_bloginfo('url'),get_bloginfo('template_url')),$top_right_image_path); ?>" alt="image description" width="137" height="109" />
						</div>
					<?php endif;?>	
					<?php if($right_side)echo str_replace(array('[site-url]','[template-url]'),array(get_bloginfo('url'),get_bloginfo('template_url')),$right_side); ?>
				</div>
				
			<?php endwhile; ?>
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
