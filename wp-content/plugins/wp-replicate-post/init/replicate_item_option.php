<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
if ( is_admin() ){ 
	add_action( 'admin_init', 'replicate_item_register_setting' );
}

/*
 * Add Menu Page
*/
function replicate_item_admin_menu(){
	add_menu_page(                      
        __( 'Replicate Post'),      
        'Replicate Post',      
        'manage_options',
        'replicate_item_options',     
        'replicate_item_options',     
        '',     
        88       
    );
}
add_action('admin_menu', 'replicate_item_admin_menu');

/**
 * Get option value for post type enabled
 */
function is_replicate_item_enabled($post_type){
	$replicate_item_enable = get_option('replicate_item_enable');
	if(!is_array($replicate_item_enable)) $replicate_item_enable = array($replicate_item_enable);
	return in_array($post_type, $replicate_item_enable);
}

//Register a setting and option name
function replicate_item_register_setting() { 
	register_setting( 'replicate_item', 'replicate_item_enable');	
}

/*
 * Manage Settings Page for enabling post types
*/
function replicate_item_options() {
	if(isset($_POST['submit'])){
		echo 'sdsd';
	}
?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32">
			<br>
		</div>
		<h1>
			<?php esc_html_e("Replicate Item", 'replicate-item'); ?>
		</h1>
		<form method="post" action="options.php" style="clear: both">
			<?php settings_fields('replicate_item'); ?>
			<section>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e("Check these post types for replicating", 'replicate-item'); ?></th>
						<td>
						<?php 
						$post_types = get_post_types(array('show_ui' => true),'objects');
						//Get all post objects
						foreach ( $post_types as $post_type ) {
							//Check whether post type is attachment or not
							if ($post_type->name != 'attachment') {
								if(is_replicate_item_enabled($post_type->name)) {
									$check="checked";  
								}		
								else{
									$check="";  
								}
								?>
								<input type="checkbox" name="replicate_item_enable[]" value="<?php echo $post_type->name; ?>" <?php echo $check; ?> />
								<?php echo $post_type->label.'<br>'; ?>
						<?php }} ?> 
						<span class="description">
						<?php esc_html_e("Select the post types you want to be replicated", 'replicate-item'); ?><br /> 
						</span>
						</td>
					</tr>
				</table>
			</section>
			<p class="submit">
				<input type="submit" class="button-primary" name="submit" value="<?php esc_html_e("Save Changes", 'replicate-item'); ?>" />
			</p>
		</form>
	</div>
<?php
}