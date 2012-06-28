<?php if(is_front_page()):?>
<?php if (is_active_sidebar('default-sidebar')) : ?>
	<div class="aside">
		<?php dynamic_sidebar('default-sidebar'); ?>	
	</div>
<?php endif; ?>
<?php elseif(is_single()):
	global $left_image_path; ?>
	<?php if($left_image_path ):?>
		<div class="aside">
			<div class="box-image box-image-large">
				<img class="png" src="<?php echo str_replace(array('[site-url]','[template-url]'),array(get_bloginfo('url'),get_bloginfo('template_url')),$left_image_path); ?>" alt="image description" width="273" height="217" />
			</div>
		</div>
	<?php endif;?>
<?php elseif(is_page()): global $side_image; ?>
	<?php if($side_image):?>
		<div class="aside">
			<?php echo str_replace(array('[site-url]','[template-url]'),array(get_bloginfo('url'),get_bloginfo('template_url')),$side_image); ?>
		</div>
	<?php endif;?>
<?php endif;?>