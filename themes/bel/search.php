<?php get_header(); ?>

<div class="container-holder hfeed">
	<div class="container-frame hentry">
		<?php if (have_posts()) : ?>
			<div class="heading">
				<h2><?php _e("Resultats de la recherche", "bel"); ?></h2>
			</div>
			<br />
			<hr />
			<?php while (have_posts()) : the_post(); ?>
				<div class="heading">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				</div>
				<div class="entry-content section">
					<?php the_excerpt(); ?>
				</div>
				<hr />
			<?php endwhile; ?>
			<div class="pagination">
				<div class="next"><?php next_posts_link('Older Entries &raquo;') ?></div>
				<div class="prev"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
			</div>
		<?php else:?>
			<div class="heading">
					<h2><?php _e("Aucun article trouve", "bel"); ?></h2>
				</div>
			<div class="searchleft">	
				<p><?php _e("Essayer une nouvelle recherche ?", "bel"); ?></p>
				<?php get_search_form(); ?>
			</div>
				
		<?php endif; ?>
	</div>
</div>
		
<?php get_footer(); ?>
