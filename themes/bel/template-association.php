<?php
/*
Template Name: Project Template
*/
get_header();?>

<div class="container-holder">
	<div class="container-frame"><?php
		$pro_taxonomy = "project-categories";
		$project = "projects";
		$terms = get_terms($pro_taxonomy,'hide_empty=0&parent=0');
		?>
				<div class="heading">
					<h2><?php the_title(); ?></h2>
				</div>
				<?php if($terms)foreach($terms as $term):
					if ($term->name == "Associations") :?>
					<h4><?php echo $term->name; ?></h4>
					<?php $termchildren = get_term_children( $term->term_id, $pro_taxonomy); ?>
					<?php $sub_child_posts ='';?>
						<?php if(isset($post_not)){
									$post_not = $post_not;
								}else{
									$post_not=null;
								}
							query_posts($args);
						?>
						<?php if (have_posts() || $sub_child_posts) : ?>
							<div>	
								<?php while (have_posts()) : the_post(); ?>
									<h2 class="<?php echo get_post_meta(get_the_ID(), "project_type", true); ?>"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
									<p><?php the_excerpt(); ?></p>
								<?php endwhile;?>
								<?php if($sub_child_posts) echo $sub_child_posts;?>
							</div>
							<hr />
						
				<?php endif; endforeach;  wp_reset_query();?>
						<?php endif;  ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
