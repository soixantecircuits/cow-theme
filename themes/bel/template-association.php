<?php
/*
Template Name: Association Template
*/
get_header();?>

<div class="container-holder">
	<div class="container-frame"><?php
		$pro_taxonomy = "project-categories";
		$project = "projects";
		$terms = get_terms($pro_taxonomy,'hide_empty=0&parent=0');?>
		<div class="heading">
			<h2><?php the_title(); ?></h2>
		</div><?php
		if($terms)foreach($terms as $term):
			if ($term->name == "Associations") :
				$termchildren = get_term_children( $term->term_id, $pro_taxonomy);
				$sub_child_posts ='';
				if (isset($post_not)) {
					$post_not = $post_not;
				} else {
					$post_not=null;
				}
				$args= array(
					'post_type' => $project,
					'post__not_in' => $post_not,
					'order' => 'ASC',
					'orderby' => 'title',
					'ignore_sticky_posts' => true,
					'posts_per_page' => '-1',
					'tax_query' => array(
						array(
							'taxonomy' => $pro_taxonomy,
							'field' => 'id',
							'terms' => $term->term_id
						)
					)
				);
				query_posts($args);
				if (have_posts() || $sub_child_posts) : ?>
					<table><?php
					while (have_posts()) : the_post(); ?>
						<tr class="assoc_table">
						<td class="post_thumbnail">
						<a href="<?php the_permalink();?>"><?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail(array(100, 100));
							} else {
								?><img width="70px" height="100px" src="<?php echo site_url(); ?>/wp-content/uploads/2012/07/default1.png" /><?php
							} ?></a>
						</td>
						<td class="assoc_excerpt">
							<div class='heading'>
								<h2 class="<?php echo get_post_meta(get_the_ID(), "project_type", true); ?>">
									<a href="<?php the_permalink();?>"><?php the_title(); ?></a>
								</h2>
								<p><?php the_excerpt(); ?></p>
							</div>
						</td>
						</tr><?php
					endwhile;
					if($sub_child_posts) echo $sub_child_posts;?>
					</table><?php
				endif;
			endif;
		endforeach;
		wp_reset_query();?>
	</div>
</div>

<?php get_footer(); ?>
