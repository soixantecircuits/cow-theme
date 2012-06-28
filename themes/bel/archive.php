<?php get_header(); ?>

<div class="container-holder hfeed">
	<div class="container-frame hentry">
		<?php if (have_posts()) : ?>
			<div class="heading">
				<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
				<?php /* If this is a category archive */ if (is_category()) { ?>
				<h2><?php single_cat_title(); ?></h2>
				<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
				<h2>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
				<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<h2>Archive for <?php the_time('F jS, Y'); ?></h2>
				<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h2>Archive for <?php the_time('F, Y'); ?></h2>
				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h2>Archive for <?php the_time('Y'); ?></h2>
				<?php /* If this is an author archive */ } elseif (is_author()) { ?>
				<h2>Author Archive</h2>
				<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h2>Blog Archives</h2>
				<?php }elseif(get_post_type() == "projects"){ ?>
				<h2><?php the_terms($posts->ID,"project-categories");?></h2>
				<?php }?>	
			</div>
	
			<?php while (have_posts()) : the_post(); ?>
				<div class="heading">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<p class="info"><strong class="date"><?php the_time('F jS, Y') ?></strong> by <?php the_author(); ?></p>
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
			<div class="heading"><h2>Not Found</h2></div>
			<div class="entry-content">
				<p>Sorry, but you are looking for something that isn't here.</p>
			</div>
		<?php endif; ?>
	</div>
</div>
			
<?php get_footer(); ?>
