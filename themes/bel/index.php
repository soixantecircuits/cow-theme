<?php get_header(); ?>

<div class="container-holder hfeed">
	<div class="container-frame hentry">
		<?php if (have_posts()) : ?>
	
			<?php while (have_posts()) : the_post(); ?>
				<div class="heading">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<p class="info"><strong class="date"><?php the_time('F jS, Y') ?></strong> by <?php the_author(); ?></p>
				</div>
				<div class="entry-content">
					<?php the_excerpt(); ?>
				</div>
				<div class="meta">
					<ul>
						<li>Posted in <?php the_category(', ') ?></li>
						<li><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></li>
						<?php the_tags('<li>Tags: ', ', ', '</li>'); ?>
					</ul>
				</div>
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
				<p> Sorry, but you are looking for something that isn't here.</p>
			</div>
				
		<?php endif; ?>
	</div>
</div>
		

<?php get_footer(); ?>
