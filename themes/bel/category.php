<?php get_header(); ?>

<div class="container-holder hfeed">
	<div class="container-frame hentry">
		<?php if (have_posts()) : ?>
		<div class="heading">
			<h2><?php single_cat_title(); ?></h2>
		</div>
		<?php
		$current_category = single_cat_title("", false);
		$image = '/wp-content/uploads/images/' . strtolower(str_replace(' ', '-', $current_category)) . '.jpg';
		if (file_exists(ABSPATH . $image)) {
		echo '<img src="' . get_bloginfo('url') . $image . '" alt="' . $current_category . '" />';
		}
		?>
		<?php while (have_posts()) : the_post(); ?>
		<div class="heading">
			<h4>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
			</h4>
			<p class="info"><strong class="date" style="float:right;"><?php the_time('d/m/Y') ?></strong></p>
			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div>
			<hr />
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
</div>
		

<?php get_footer(); ?>
