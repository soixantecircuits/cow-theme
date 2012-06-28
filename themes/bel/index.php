<?php get_header(); ?>

<div class="container-holder hfeed">
	<div class="container-frame hentry">
		<?php if (have_posts()) : ?>
	
			<?php while (have_posts()) : the_post(); ?>
				<div class="heading">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<p class="info"><strong class="date" style="float:right;"><?php the_time('\L\e l j F Y \à g:i') ?></strong></p>
				</div>
				<div class="entry-content">
					<?php the_excerpt(); ?>
				</div>
				<div class="meta">
					<ul>
						<li>Posté dans <?php the_category(', ') ?></li>
						<li><?php comments_popup_link('Pas de commentaires', '1 Commentaire', '% Commentaires'); ?></li>
						<?php the_tags('<li>Tags: ', ', ', '</li>'); ?>
					</ul>
				</div>
				<hr />
				<br />
				<br />
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
				<p> <?php _e("Sorry, but you are looking for something that isn't here.", "bel") ?></p>
			</div>
				
		<?php endif; ?>
	</div>
</div>
		

<?php get_footer(); ?>
