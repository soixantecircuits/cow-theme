<?php get_header(); ?>

<div class="container-holder hfeed">
	<div class="container-frame hentry">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<div class="heading">
						<h2><?php the_title();?></h2>
					</div>
					<!-- section -->
					<div class="section entry-content">
						<?php the_content(); ?>
					</div>
					<?php $side_image = get_post_meta(get_the_ID(),'side_image',true);?>
				<?php endwhile; ?>
			<?php else:?>
				<div class="heading">
						<h2>Not Found</h2>
					</div>
					<!-- section -->
					<div class="section entry-content">
						<p>Sorry, but you are looking for something that isn't here.</p>
					</div>
			<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>
