<?php get_header(); ?>

<div class="container-holder hfeed">
	<div class="container-frame hentry">
		<?php if (have_posts()) : ?>
			<div class="heading">
				<h2><?php _e("Actualités", "bel"); ?></h2>
			</div>
			<hr />
			<?php while (have_posts()) : the_post(); ?>
				<div class="post_thumbnail">
				<a href="<?php the_permalink();?>"><div class="thumbnail_img"><?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail(array(100, 100));
					} else {
						?><img width="70px" height="100px" src="<?php echo site_url(); ?>/wp-content/uploads/2012/07/default1.png" /><?php
					} ?></div></a>
				</div>
				<div class="assoc_excerpt">
					<div class="heading">
						<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<p class="info"><strong class="date" style="float:right;">
							<?php the_time('d/m/Y') ?>
						</strong></p>
					</div>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>
					<div class="meta">
						<ul>
							<li><?php _e("Posté dans", "bel");?> <?php the_category(', ') ?></li>
							<?php the_tags('<li>Tags: ', ', ', '</li>'); ?>
						</ul>
					</div>
				</div>
				<hr />
			<?php endwhile; ?>
			<div class="pagination">
				<div class="next"><?php next_posts_link('Older Entries &raquo;') ?></div>
				<div class="prev"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
			</div>
		<?php else:?>
			<div class="heading">
					<h2>>Not Found</h2>
				</div>
			<div class="searchleft">
				<p> <?php _e("Désolé, mais la page demandé n'existe pas.", "bel") ?></p>
			</div>

		<?php endif; ?>
	</div>
</div>


<?php get_footer(); ?>
