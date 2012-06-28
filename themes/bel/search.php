<?php get_header(); ?>

<div class="container-holder hfeed">
	<div class="container-frame hentry">
		<?php if (have_posts()) : ?>
			<div class="heading">
				<h2>Search Results</h2>
			</div>
	
			<?php while (have_posts()) : the_post(); ?>
				<div class="heading">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				</div>
				<div class="entry-content">
					<?php the_excerpt(); ?>
				</div>
			<?php endwhile; ?>
			<div class="pagination">
				<div class="next"><?php next_posts_link('Older Entries &raquo;') ?></div>
				<div class="prev"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
			</div>
		<?php else:?>
			<div class="heading">
					<h2>No posts found.</h2>
				</div>
			<div class="searchleft">	
				<p> Try a different search?</p>
				<?php get_search_form(); ?>
			</div>
				
		<?php endif; ?>
	</div>
</div>
		
<?php get_footer(); ?>
