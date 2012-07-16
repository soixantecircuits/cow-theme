<?php 

/*
Plugin Name: CMS Dashboard
Plugin URI: http://workshop.37designs.com/
Description: Big user friendly buttons to make your clients happy and your wordpress a better CMS
Author: Ross Johnson
Version: 2.0
Author URI: http://www.stylizedweb.com/
*/

// Create the function to output the contents of our Dashboard Widget

function cms_dashboard_widget_function() {
	
	/** WordPress Administration Bootstrap */
?>

<ul id="dashboard-cms">
	<?php if(get_option('cmd-pages')){  ?>
		<li class="left-gray"><a href="post-new.php?post_type=page"><div id="icon-edit-pages" class="icon32">&nbsp;</div> Add Page</a></li>
		<li class="right-gray"><a href="edit.php?post_type=page"><div id="icon-edit-pages" class="icon32">&nbsp;</div> Edit Pages</a></li>
	<?php } ?>
		<?php if(get_option('cmd-posts')){ ?>
		<li class="left-gray"><a href="post-new.php"><div id="icon-edit" class="icon32">&nbsp;</div> New Post</a></li>
		<li class="right-gray"><a href="edit.php"><div id="icon-edit" class="icon32">&nbsp;</div> Edit Posts</a></li>
	<?php } ?>
	<?php if(get_option('cmd-links')){ ?>
		<li class="left-gray"><a href="link-manager.php"><div id="icon-link-manager" class="icon32">&nbsp;</div> Links</a></li>
		<li class="right-gray"><a href="link-add.php"><div id="icon-link-manager" class="icon32">&nbsp;</div> Add Link</a></li>
	<?php } ?>
	<?php if(get_option('cmd-widgets')){  ?>
		<li class="left-gray"><a href="widgets.php"><div id="icon-themes" class="icon32">&nbsp;</div> Widgets</a></li>
	<?php } ?>
	<?php if(get_option('cmd-menu')){ ?>
		<li class="right-gray"><a href="nav-menus.php"><div id="icon-themes" class="icon32">&nbsp;</div> Menus</a></li>
	<?php } ?>
	<?php if(get_option('cmd-users')){ ?>
		<li class="left-gray"><a href="user-new.php"><div id="icon-users" class="icon32">&nbsp;</div> Add User</a></li>
		<li class="right-gray"><a href="users.php"><div id="icon-users" class="icon32">&nbsp;</div> Manage Users</a></li>
	<?php } ?>
	<?php if(get_option('cmd-media')){  ?>
		<li class="left-gray"><a href="upload.php"><div id="icon-upload" class="icon32">&nbsp;</div> Media Library</a></li>
		<li class="right-gray"><a href="media-new.php"><div id="icon-upload" class="icon32">&nbsp;</div> Upload Media</a></li>
	<?php } ?>
	<?php if(get_option('cmd-comments')){ ?>
		<li><a href="edit-comments.php"><div id="icon-edit-comments" class="icon32">&nbsp;</div> Comments</a></li>
	<?php } ?>
	<?php if(get_option('cmd-plugins')){  ?>
		<li class="left-gray"><a href="plugins.php"><div id="icon-plugins" class="icon32">&nbsp;</div> Plugins</a></li>
		<li class="right-gray"><a href="plugin-install.php"><div id="icon-plugins" class="icon32">&nbsp;</div> Install Plugin</a></li>
	<?php } ?>
	<?php if(get_option('cmd-settings')){  ?>
		<li><a href="options-general.php"><div id="icon-options-general" class="icon32">&nbsp;</div> Settings</a></li>
	<?php } ?>
</ul>
	
<br class="clear" />
	
<?php	
} 

// Create the function use in the action hook

function cms_dashboard_widgets() {
	wp_add_dashboard_widget('cms_dashboard_widget', 'Manage Website', 'cms_dashboard_widget_function');	
} 

// Hoook into the 'wp_dashboard_setup' action to register our other functions

add_action('wp_dashboard_setup', 'cms_dashboard_widgets' );

function admin_register_head() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/cms-dashboard.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

add_action('admin_head', 'admin_register_head');

//Make the options panel

// require_once(TEMPLATEPATH . '/functions/admin-menu.php'); 

// create custom plugin settings menu
add_action('admin_menu', 'create_cmsdashboard_options_page');


function create_cmsdashboard_options_page() {
	
  add_options_page('CMS Dashboard', 'CMS Dashboard', 'administrator', __FILE__, 'build_cmsdashboard_options_page');
  add_action( 'admin_init', 'register_cmd_settings' );

}
 

 function register_cmd_settings() {  
     //register our settings  
    register_setting( 'cmd-settings-group', 'cmd-posts'); 
	register_setting( 'cmd-settings-group', 'cmd-pages');  
	register_setting( 'cmd-settings-group', 'cmd-links');  
	register_setting( 'cmd-settings-group', 'cmd-widgets');  
	register_setting( 'cmd-settings-group', 'cmd-menu');  
	register_setting( 'cmd-settings-group', 'cmd-users');  
	register_setting( 'cmd-settings-group', 'cmd-media');  
	register_setting( 'cmd-settings-group', 'cmd-comments');  
	register_setting( 'cmd-settings-group', 'cmd-plugins');  
	register_setting( 'cmd-settings-group', 'cmd-settings');   

 }


function build_cmsdashboard_options_page() {
?>
  <div id="theme-options-wrap">
    <div class="icon32" id="icon-tools"> <br /> </div>

    <h2>CMS Dashbaord Options</h2>
    <p>Turn on/off the visibility of different dashboard buttons.</p>



    <form method="post" action="options.php">
	

		<?php settings_fields('cmd-settings-group'); ?>  
		
	  	 <table class="form-table">  
		    <tr valign="top">  
		         <th scope="row"><strong>Option</strong></th>
		  		 <th><strong>Display Button</strong></th>
			</tr>
			<tr>
		        <td><label for="cmd-posts">Post Buttons</label></td><td>
					<?php if(get_option('cmd-posts')){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>  
					<input type="checkbox" name="cmd-posts" id="<?php echo get_option('cmd-posts'); ?>" value="true" <?php echo $checked; ?> />
				</td>
			</tr>
			<tr>
		        <td><label for="cmd-pages">Page Buttons</label></td><td>
					<?php if(get_option('cmd-pages')){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>  
					<input type="checkbox" name="cmd-pages" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />			
			</tr>
			<tr>
		        <td><label for="cmd-links">Links Buttons</label></td>
				<td><?php if(get_option('cmd-links')){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>  
				<input type="checkbox" name="cmd-links" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /></td>
			</tr>
			<tr>
		        <td><label for="cmd-widgets">Widget Button</label></td>
				<td><?php if(get_option('cmd-widgets')){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>  
				<input type="checkbox" name="cmd-widgets" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /></td>
			</tr>
			<tr>
		        <td><label for="cmd-menu">Menu Button</label></td>
				<td><?php if(get_option('cmd-menu')){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>  
				<input type="checkbox" name="cmd-menu" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /></td>
			</tr>
			<tr>
		        <td><label for="cmd-users">User Buttons</label></td>
				<td><?php if(get_option('cmd-users')){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>  
				<input type="checkbox" name="cmd-users" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /></td>
			</tr>
			<tr>
		        <td><label for="cmd-media">Media Button</label></td>
				<td><?php if(get_option('cmd-media')){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>  
				<input type="checkbox" name="cmd-media" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /></td>
			</tr>
			<tr>
		        <td><label for="cmd-comments">Comment Buttons</label></td>
				<td><?php if(get_option('cmd-comments')){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>  
				<input type="checkbox" name="cmd-comments" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /></td>
			</tr>
			<tr>
		        <td><label for="cmd-plugins">Plugin Buttons</label></td>
				<td><?php if(get_option('cmd-plugins')){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>  
				<input type="checkbox" name="cmd-plugins" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /></td>
			</tr>
			<tr>
		        <td><label for="cmd-settings">Settings Button</label></td>
				<td><?php if(get_option('cmd-settings')){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>  
				<input type="checkbox" name="cmd-settings" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /></td>
			</tr>
		</table>

      <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
      </p>
    </form>
  </div>
<?php
}

?>