<?php
/*
Template Name: Two Columns  Template
*/
get_header(); ?>
<div class="container-holder">
	<div class="container-frame">
		<div class="twocolumns">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				<div class="main-block">
					<?php the_content(); ?>
				</div>
				<?php endwhile; ?>
			<?php else:?>
				<div class="heading"><h2>Not Found</h2></div>
				<div class="main-block">
					<p>Sorry, but you are looking for something that isn't here.</p>
				</div>
			<?php endif; ?>
			<?php if (is_active_sidebar('two-column-template-rightbar')) : ?>
				<div class="column-info">
					<?php dynamic_sidebar('two-column-template-rightbar'); ?>	
				</div>
			<?php endif; ?>
		</div>
		
	</div>
</div>
<?php get_footer(); ?>
