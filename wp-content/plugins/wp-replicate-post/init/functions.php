<?php
require(REP_POST_PLUGIN_DIR.'/init/replicate_item_option.php');
 
if(!is_admin()){
	return;
}

/**
 * Add Replicate in bulk action menu
 */
add_action('admin_footer-edit.php', 'replicate_item_bulk_admin_footer');
function replicate_item_bulk_admin_footer() {
	global $post_type;
	//Check if post type is enabled 
	if(is_replicate_item_enabled($post_type)) {
	?>
		<script type="text/javascript">
		    jQuery(document).ready(function() {
			    jQuery('<option>').val('replicate').text('<?php _e('Replicate')?>').appendTo("select[name='action']");
			    jQuery('<option>').val('replicate').text('<?php _e('Replicate')?>').appendTo("select[name='action2']");
		    });
	    </script>
	<?php
	}
}

/**
 * Add action to replicate in bulk admin menu
 */
add_action( 'init', 'replicate_item_bulk_action');
function replicate_item_bulk_action() {
	$replicate_item_enable = get_option('replicate_item_enable');
	//Get post types which are enabled and add action to it
	if(!empty($replicate_item_enable)){
		foreach ($replicate_item_enable as $key => $value) {
			add_filter( 'handle_bulk_actions-edit-'.$value, 'replicate_item_bulk_action_handler', 10, 3 );
		}
	}
}

/**
 * Handle the bulk action and replicate the post and save the post
 */
function replicate_item_bulk_action_handler() {
	global $post_type;
	$post_ids = $_GET['post'];
	//Get the ids of post which are to be replicated
	foreach ($post_ids as $key => $post_id) {
		$post = get_post( $post_id );
		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;
		//Check whether the post is set or is selected from the list
	 	if (isset( $post ) && $post != null) {
	 		$post_nm = $post->post_title;
	 		$name = $post_nm.'-Replica';
	 		$status = 'draft';
	 		$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $new_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => $status,
				'post_title'     => $name,
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);
			$new_post_id = wp_insert_post( $args );
	 
			$taxonomies = get_object_taxonomies($post->post_type);
			//Get all taxonomies set to particular post type 
			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}
	 		global $wpdb;
			$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
			//Check for meta values of original post and if condition falls true it will insert for new post also
			if (count($post_meta_infos)!=0) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				//Get meta values of post
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					if( $meta_key == '_wp_old_slug' ) continue;
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query.= implode(" UNION ALL ", $sql_query_sel);
				$wpdb->query($sql_query);
			}
			wp_redirect(admin_url('edit.php?post_type='.$post_type));
		} else {
			wp_die('Post creation failed, could not find original post: ' . $post_id);
		}
	}
}

//Action hook
add_action('admin_init','replicate_item_admin_init');

/*
 * Modify to Row Actions of Post/Page
*/
function replicate_item_admin_init(){
	replicate_item_plugin();
	add_filter( 'post_row_actions', 'replicate_item_list_row_actions', 10, 2 );
	add_filter( 'page_row_actions', 'replicate_item_list_row_actions', 10, 2 );
}

/*
 * Add action in row action for enabled post type
*/
function replicate_item_plugin() {
	add_option('replicate_item_enable');
	//Add action link row action in enabled post type
	function replicate_item_list_row_actions( $actions, $post ) {
		//Check condition if post type enabled
		if (is_replicate_item_enabled($post->post_type)) {
			$actions['replicate'] = '<a href="' . wp_nonce_url('admin.php?action=replicate_item_save&post=' . $post->ID, basename(__FILE__), 'replicate_nonce' ) . '">Replicate</a>';
		}
		return $actions;
	}
}

//Action hook
add_action( 'admin_action_replicate_item_save', 'replicate_item_save' );

/*
 * Save replicated post
*/
function replicate_item_save(){
	global $wpdb;
	//Check whether post is not selected
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'replicate_item_save' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to replicate has been supplied!');
	}
	//Check the nonces
	if ( !isset( $_GET['replicate_nonce'] ) || !wp_verify_nonce( $_GET['replicate_nonce'], basename( __FILE__ ) ) )
		return;
 	$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
	$post = get_post( $post_id );
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
	//Check whether the post is set or is selected from the list
 	if (isset( $post ) && $post != null) {
 		$post_nm = $post->post_title;
	 	$name = $post_nm.'-Replica';
	 	$status = 'draft';
 		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => $status,
			'post_title'     => $name,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
 		$new_post_id = wp_insert_post( $args );
 		//Get all taxonomies set to particular post type
 		$taxonomies = get_object_taxonomies($post->post_type); 
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
		//Check for meta values of original post and if condition falls true it will insert for new post also
 		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			//Get meta values of post
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
		wp_redirect( admin_url( 'edit.php?post_type='.$post->post_type ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}

/*
 * Add Settings Link 
*/
add_filter( 'plugin_action_links', 'replicate_item_plugin_action_links', 10, 2 );
function replicate_item_plugin_action_links( $links, $file ) {
	if ( $file != REP_POST_PLUGIN_BASENAME ) {
		return $links;
	}
	$settings_link = sprintf( '<a href="%1$s">%2$s</a>',
		menu_page_url( 'replicate_item_options', false ),
		esc_html( __( 'Settings', 'replicate-item' ) ) );
	array_unshift( $links, $settings_link );
	return $links;
}

/*
 * Default Settings
*/
function checkbox_enable(){
	$check = array (0 => 'post',1 => 'page');
	update_option('replicate_item_enable',$check);
}