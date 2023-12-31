<?php
/**
 * Class for pulling in library database and saving locally
 * Based on a package from the WPTT Team for local fonts.
 *
 * @package Kadence Blocks
 */

/**
 * Class for pulling in template database and saving locally
 */
class Kadence_Blocks_Prebuilt_Library {

	/**
	 * Instance of this class
	 *
	 * @var null
	 */
	private static $instance = null;

	/**
	 * API key for kadence
	 *
	 * @var null
	 */
	private $api_key = '';

	/**
	 * API email for kadence
	 *
	 * @var string
	 */
	private $api_email = '';
	/**
	 * API email for kadence
	 *
	 * @var string
	 */
	private $package = 'section';

	/**
	 * Is a template for Kadence. 
	 *
	 * @var bool
	 */
	private $is_template = false;

	/**
	 * API email for kadence
	 *
	 * @var string
	 */
	private $url = '';

	/**
	 * Base URL.
	 *
	 * @access protected
	 * @var string
	 */
	protected $base_url;
	/**
	 * Base path.
	 *
	 * @access protected
	 * @var string
	 */
	protected $base_path;
	/**
	 * Subfolder name.
	 *
	 * @access protected
	 * @var string
	 */
	protected $subfolder_name;

	/**
	 * The starter templates folder.
	 *
	 * @access protected
	 * @var string
	 */
	protected $block_library_folder;
	/**
	 * The local stylesheet's path.
	 *
	 * @access protected
	 * @var string
	 */
	protected $local_template_data_path;

	/**
	 * The local stylesheet's URL.
	 *
	 * @access protected
	 * @var string
	 */
	protected $local_template_data_url;
	/**
	 * The remote URL.
	 *
	 * @access protected
	 * @var string
	 */
	protected $remote_url = 'https://cloud.kadenceblocks.com/wp-json/kadence-cloud/v1/get/';

	/**
	 * The remote URL.
	 *
	 * @access protected
	 * @var string
	 */
	protected $remote_templates_url = 'https://api.startertemplatecloud.com/wp-json/kadence-starter/v1/get/';

	/**
	 * The final data.
	 *
	 * @access protected
	 * @var string
	 */
	protected $data;
	/**
	 * Cleanup routine frequency.
	 */
	const CLEANUP_FREQUENCY = 'monthly';

	/**
	 * Instance Control
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( is_admin() ) {
			// Ajax Calls.
			add_action( 'wp_ajax_kadence_import_get_prebuilt_data', array( $this, 'prebuilt_data_ajax_callback' ) );
			add_action( 'wp_ajax_kadence_import_reload_prebuilt_data', array( $this, 'prebuilt_data_reload_ajax_callback' ) );
			add_action( 'wp_ajax_kadence_import_get_new_connection_data', array( $this, 'prebuilt_connection_info_ajax_callback' ) );
			add_action( 'wp_ajax_kadence_import_get_prebuilt_templates_data', array( $this, 'prebuilt_templates_data_ajax_callback' ) );
			add_action( 'wp_ajax_kadence_import_reload_prebuilt_templates_data', array( $this, 'prebuilt_templates_data_reload_ajax_callback' ) );
			add_action( 'wp_ajax_kadence_import_process_data', array( $this, 'process_data_ajax_callback' ) );
		}

		// Add a cleanup routine.
		$this->schedule_cleanup();
		add_action( 'delete_block_library_folder', array( $this, 'delete_block_library_folder' ) );
	}
	/**
	 * Get the section data if available locally.
	 */
	public function get_section_prebuilt_data( $pro_data ) {
		$pro_key = ( isset( $pro_data['ktp_api_key'] ) && ! empty( $pro_data['ktp_api_key'] ) ? $pro_data['ktp_api_key'] : '' );
		$api_email = ( isset( $pro_data['activation_email'] ) && ! empty( $pro_data['activation_email'] ) ? $pro_data['activation_email'] : '' );
		if ( empty( $pro_key ) ) {
			$pro_key = ( isset( $pro_data['ithemes_key'] ) && ! empty( $pro_data['ithemes_key'] ) ? $pro_data['ithemes_key'] : '' );
			if ( $pro_key ) {
				$api_email = 'iThemes';
			}
		}
		$this->api_key       = $pro_key;
		$this->api_email     = $api_email;
		$this->package       = 'section';
		$this->url           = $this->remote_url;
		$this->key           = 'section';
		// Do you have the data?
		$get_data = $this->get_only_local_template_data();
		if ( ! $get_data ) {
			// Send JSON Error response to the AJAX call.
			return false;
		}
		return $get_data;
	}
	
	/**
	 * Get the local data file if there.
	 *
	 * @access public
	 * @return string
	 */
	public function get_only_local_template_data( $skip_local = false ) {
		// If the local file exists, return it's data.
		return file_exists( $this->get_local_template_data_path() )
			? $this->get_local_template_data_contents()
			: '';
	}
	/**
	 * Get the local data file if there, else query the api.
	 *
	 * @access public
	 * @return string
	 */
	public function get_template_data( $skip_local = false ) {
		if ( 'custom' === $this->package ) {
			return wp_json_encode( apply_filters( 'kadence_block_library_custom_array', array() ) );
		}
		// Check if the local data file exists. (true means the file doesn't exist).
		if ( $skip_local || $this->local_file_exists() ) {
			// Attempt to create the file.
			if ( $this->create_template_data_file( $skip_local ) ) {
				return $this->get_local_template_data_contents();
			}
		}
		// // If it's empty lets try to get the data.
		// if ( '[]' === $this->get_local_template_data_contents() ) {
		// 	if ( $this->create_template_data_file( $skip_local ) ) {
		// 		return $this->get_local_template_data_contents();
		// 	}
		// }
		// If it's a Kadence Cloud, lets make sure it's within date.
		if ( 'templates' !== $this->package && 'section' !== $this->package && ! $this->is_template ) {
			$cloud_settings = json_decode( get_option( 'kadence_blocks_cloud' ), true );
			if ( isset( $cloud_settings['connections'] ) && isset( $cloud_settings['connections'][ $this->package ] ) && isset( $cloud_settings['connections'][ $this->package ]['expires'] ) && ! empty( $cloud_settings['connections'][ $this->package ]['expires'] ) ) {
				$expires = strtotime( get_date_from_gmt( $cloud_settings['connections'][ $this->package ]['expires'] ) );
				$now     = strtotime( get_date_from_gmt( current_time( 'Y-m-d H:i:s' ) ) );
				if ( $expires < $now ) {
					$refresh = ( isset( $cloud_settings['connections'][ $this->package ]['refresh'] ) && ! empty( $cloud_settings['connections'][ $this->package ]['refresh'] ) ? $cloud_settings['connections'][ $this->package ]['refresh'] : 'month' );
					if ( 'day' === $refresh ) {
						$expires_add = DAY_IN_SECONDS;
					} elseif ( 'week' === $refresh ) {
						$expires_add = WEEK_IN_SECONDS;
					} else {
						$expires_add = MONTH_IN_SECONDS;
					}
					$cloud_settings['connections'][ $this->package ]['expires'] = gmdate( 'Y-m-d H:i:s', strtotime( current_time() ) + $expires_add );
					update_option( 'kadence_blocks_cloud', json_encode( $cloud_settings ) );
					if ( $this->create_template_data_file( true ) ) {
						return $this->get_local_template_data_contents();
					}
				}
			}
		}
		// If the local file exists, return it's data.
		return file_exists( $this->get_local_template_data_path() )
			? $this->get_local_template_data_contents()
			: '';
	}
	/**
	 * Write the data to the filesystem.
	 *
	 * @access protected
	 * @return string|false Returns the absolute path of the file on success, or false on fail.
	 */
	protected function create_template_data_file( $skip_local ) {
		$file_path  = $this->get_local_template_data_path();
		$filesystem = $this->get_filesystem();

		// If the folder doesn't exist, create it.
		if ( ! file_exists( $this->get_block_library_folder() ) ) {
			$this->get_filesystem()->mkdir( $this->get_block_library_folder(), FS_CHMOD_DIR );
		}

		// If the file doesn't exist, create it. Return false if it can not be created.
		if ( ! $filesystem->exists( $file_path ) && ! $filesystem->touch( $file_path ) ) {
			return false;
		}

		// If we got this far, we need to write the file.
		// Get the data.
		if ( $skip_local || ! $this->data ) {
			$this->get_data();
		}
		// Put the contents in the file. Return false if that fails.
		if ( ! $filesystem->put_contents( $file_path, $this->data ) ) {
			return false;
		}

		return $file_path;
	}
	/**
	 * Get data.
	 *
	 * @access public
	 * @return string
	 */
	public function get_data() {
		// Get the remote URL contents.
		$this->data = $this->get_remote_url_contents();

		return $this->data;
	}
	/**
	 * Get local data contents.
	 *
	 * @access public
	 * @return string|false Returns the data contents.
	 */
	public function get_local_template_data_contents() {
		$local_path = $this->get_local_template_data_path();

		// Check if the local exists. (true means the file doesn't exist).
		if ( $this->local_file_exists() ) {
			return false;
		}
		ob_start();
		include $local_path;
		return ob_get_clean();
	}
	/**
	 * Get remote file contents.
	 *
	 * @access public
	 * @return string Returns the remote URL contents.
	 */
	public function get_remote_url_contents() {
		$args = array(
			'key' => $this->key,
		);
		if ( 'templates' === $this->package || 'section' === $this->package || $this->is_template ) {
			$args['api_email'] = $this->api_email;
			$args['api_key']   = $this->api_key;
			if ( 'iThemes' === $this->api_email ) {
				if ( is_callable( 'network_home_url' ) ) {
					$site_url = network_home_url( '', 'http' );
				} else {
					$site_url = get_bloginfo( 'url' );
				}
				$site_url = preg_replace( '/^https/', 'http', $site_url );
				$site_url = preg_replace( '|/$|', '', $site_url );
				$args['site_url'] = $site_url;
			}
		}
		if ( 'templates' === $this->package ) {
			$args['request'] = 'blocks';
		}
		// Get the response.
		$api_url  = add_query_arg( $args, $this->url );

		$response = wp_remote_get( $api_url );
		// Early exit if there was an error.
		if ( is_wp_error( $response ) ) {
			return '';
		}

		// Get the CSS from our response.
		$contents = wp_remote_retrieve_body( $response );

		// Early exit if there was an error.
		if ( is_wp_error( $contents ) ) {
			return;
		}

		return $contents;
	}
	/**
	 * Check if the local file exists.
	 *
	 * @access public
	 * @return bool
	 */
	public function local_file_exists() {
		return ( ! file_exists( $this->get_local_template_data_path() ) );
	}
	/**
	 * Get the data path.
	 *
	 * @access public
	 * @return string
	 */
	public function get_local_template_data_path() {
		if ( ! $this->local_template_data_path ) {
			$this->local_template_data_path = $this->get_block_library_folder() . '/' . $this->get_local_template_data_filename() . '.json';
		}
		return $this->local_template_data_path;
	}
	/**
	 * Get the local data filename.
	 *
	 * This is a hash, generated from the site-URL, the wp-content path and the URL.
	 * This way we can avoid issues with sites changing their URL, or the wp-content path etc.
	 *
	 * @access public
	 * @return string
	 */
	public function get_local_template_data_filename() {
		$kb_api = 'free';
		if ( class_exists( 'Kadence_Theme_Pro' ) ) {
			$ktp_data = get_option( 'ktp_api_manager' );
			if ( $ktp_data && isset( $ktp_data['ktp_api_key'] ) && ! empty( $ktp_data['ktp_api_key'] ) ) {
				$kb_api = $ktp_data['ktp_api_key'];
			}
		} elseif ( class_exists( 'Kadence_Blocks_Pro' ) ) {
			$kbp_data = get_option( 'kt_api_manager_kadence_gutenberg_pro_data' );
			if ( $kbp_data && isset( $kbp_data['api_key'] ) && ! empty( $kbp_data['api_key'] ) ) {
				$kb_api = $kbp_data['api_key'];
			}
		}
		return md5( $this->get_base_url() . $this->get_base_path() . $this->package . KADENCE_BLOCKS_VERSION . $kb_api );
	}
	/**
	 * Main AJAX callback function for:
	 * 1). get local data if there
	 * 2). query api for data if needed
	 * 3). import content
	 * 4). execute 'after content import' actions (before widget import WP action, widget import, customizer import, after import WP action)
	 */
	public function prebuilt_connection_info_ajax_callback() {
		// Verify if the AJAX call is valid (checks nonce and current_user_can).
		$this->verify_ajax_call();
		$this->local_template_data_path = '';
		$this->api_key       = empty( $_POST['api_key'] ) ? '' : sanitize_text_field( $_POST['api_key'] );
		$this->api_email     = empty( $_POST['api_email'] ) ? '' : sanitize_text_field( $_POST['api_email'] );
		$this->package       = empty( $_POST['package'] ) ? 'section' : sanitize_text_field( $_POST['package'] );
		$this->url           = empty( $_POST['url'] ) ? '' : rtrim( sanitize_text_field( $_POST['url'] ), '/' ) . '/wp-json/kadence-cloud/v1/info/';
		$this->key           = empty( $_POST['key'] ) ? 'section' : sanitize_text_field( $_POST['key'] );
		// Do you have the data?
		$get_data = $this->get_connection_data();
		if ( ! $get_data ) {
			// Send JSON Error response to the AJAX call.
			wp_send_json( esc_html__( 'No Connection data', 'kadence-blocks' ) );
		} else {
			wp_send_json( $get_data );
		}
		die;
	}
	/**
	 * Get the local data file if there, else query the api.
	 *
	 * @access public
	 * @return string
	 */
	public function get_connection_data( $skip_local = false ) {
		$args = array(
			'key'       => $this->key,
		);
		// Get the response.
		$api_url  = add_query_arg( $args, $this->url );
		$response = wp_remote_get( $api_url );
		// Early exit if there was an error.
		if ( is_wp_error( $response ) ) {
			return '';
		}

		// Get the CSS from our response.
		$contents = wp_remote_retrieve_body( $response );

		// Early exit if there was an error.
		if ( is_wp_error( $contents ) ) {
			return;
		}

		return $contents;
	}
	/**
	 * Main AJAX callback function for:
	 * 1). get local data if there
	 * 2). query api for data if needed
	 * 3). import content
	 * 4). execute 'after content import' actions (before widget import WP action, widget import, customizer import, after import WP action)
	 */
	public function prebuilt_data_ajax_callback() {
		// Verify if the AJAX call is valid (checks nonce and current_user_can).
		$this->verify_ajax_call();
		$this->local_template_data_path = '';
		$this->api_key       = empty( $_POST['api_key'] ) ? '' : sanitize_text_field( $_POST['api_key'] );
		$this->api_email     = empty( $_POST['api_email'] ) ? '' : sanitize_text_field( $_POST['api_email'] );
		$this->package       = empty( $_POST['package'] ) ? 'section' : sanitize_text_field( $_POST['package'] );
		$this->url           = empty( $_POST['url'] ) ? $this->remote_url : rtrim( sanitize_text_field( $_POST['url'] ), '/' ) . '/wp-json/kadence-cloud/v1/get/';
		$this->key           = isset( $_POST['key'] ) && ! empty( $_POST['key'] ) ? sanitize_text_field( $_POST['key'] ) : 'section';
		$this->is_template   = isset( $_POST['is_template'] ) && ! empty( $_POST['is_template'] ) ? true : false;
		// Do you have the data?
		$get_data = $this->get_template_data();
		if ( ! $get_data ) {
			// Send JSON Error response to the AJAX call.
			wp_send_json( esc_html__( 'No library data', 'kadence-blocks' ) );
		} else {
			wp_send_json( $get_data );
		}
		die;
	}
	/**
	 * Main AJAX callback function for getting the prebuilt templates array.
	 */
	public function prebuilt_templates_data_ajax_callback() {
		// Verify if the AJAX call is valid (checks nonce and current_user_can).
		$this->verify_ajax_call();
		$this->local_template_data_path = '';
		$this->api_key       = empty( $_POST['api_key'] ) ? '' : sanitize_text_field( $_POST['api_key'] );
		$this->api_email     = empty( $_POST['api_email'] ) ? '' : sanitize_text_field( $_POST['api_email'] );
		$this->package       = 'templates';
		$this->url           = $this->remote_templates_url;
		$this->key           = 'blocks';
		// Do you have the data?
		$get_data = $this->get_template_data();
		if ( ! $get_data ) {
			// Send JSON Error response to the AJAX call.
			wp_send_json( esc_html__( 'No library data', 'kadence-blocks' ) );
		} else {
			wp_send_json( $get_data );
		}
		die;
	}
	/**
	 * Main AJAX callback function for:
	 * 1). get local data if there
	 * 2). query api for data if needed
	 * 3). import content
	 * 4). execute 'after content import' actions (before widget import WP action, widget import, customizer import, after import WP action)
	 */
	public function prebuilt_templates_data_reload_ajax_callback() {

		// Verify if the AJAX call is valid (checks nonce and current_user_can).
		$this->verify_ajax_call();
		$this->local_template_data_path = '';
		$this->api_key   = empty( $_POST['api_key'] ) ? '' : sanitize_text_field( $_POST['api_key'] );
		$this->api_email = empty( $_POST['api_email'] ) ? '' : sanitize_text_field( $_POST['api_email'] );
		$this->package       = 'templates';
		$this->url           = $this->remote_templates_url;
		$this->key           = 'blocks';

		//$removed = $this->delete_block_library_folder();
		// if ( ! $removed ) {
		// 	wp_send_json_error( 'failed_to_flush' );
		// }
		// Do you have the data?
		$get_data = $this->get_template_data( true );

		if ( ! $get_data ) {
			// Send JSON Error response to the AJAX call.
			wp_send_json( esc_html__( 'No library data', 'kadence-blocks' ) );
		} else {
			wp_send_json( $get_data );
		}
		die;
	}

	/**
	 * Ajax function for processing the import data.
	 */
	public function process_data_ajax_callback() {
		// Verify if the AJAX call is valid (checks nonce and current_user_can).
		$this->verify_ajax_call();
		$data = empty( $_POST['import_content'] ) ? '' : stripslashes( $_POST['import_content'] );
		// Do you have the data?
		if ( $data ) {
			$data = $this->process_content( $data );
			if ( ! $data ) {
				// Send JSON Error response to the AJAX call.
				wp_send_json( esc_html__( 'No data', 'kadence-blocks' ) );
			} else {
				wp_send_json( $data );
			}
		}
		// Send JSON Error response to the AJAX call.
		wp_send_json( esc_html__( 'No data', 'kadence-blocks' ) );
		die;
	}
	/**
	 * Download and Replace images
	 *
	 * @param  string $content the import post content.
	 */
	public function process_content( $content = '' ) {
		// Find all urls.
		preg_match_all( '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $match );
		$all_urls = array_unique( $match[0] );

		if ( empty( $all_urls ) ) {
			return $content;
		}

		$map_urls    = array();
		$image_urls  = array();
		// Find all the images.
		foreach ( $all_urls as $key => $link ) {
			if ( $this->check_for_image( $link ) ) {
				// Avoid srcset images.
				if (
					false === strpos( $link, '-150x' ) &&
					false === strpos( $link, '-300x' ) &&
					false === strpos( $link, '-1024x' )
				) {
					$image_urls[] = $link;
				}
			}
		}
		// Process images.
		if ( ! empty( $image_urls ) ) {
			foreach ( $image_urls as $key => $image_url ) {
				// Download remote image.
				$image            = array(
					'url' => $image_url,
					'id'  => 0,
				);
				$downloaded_image       = $this->import_image( $image );
				$map_urls[ $image_url ] = $downloaded_image['url'];
			}
		}
		// Replace images in content.
		foreach ( $map_urls as $old_url => $new_url ) {
			$content = str_replace( $old_url, $new_url, $content );
			// Replace the slashed URLs if any exist.
			$old_url = str_replace( '/', '/\\', $old_url );
			$new_url = str_replace( '/', '/\\', $new_url );
			$content = str_replace( $old_url, $new_url, $content );
		}
		return $content;
	}
	/**
	 * Import an image.
	 *
	 * @param array $image_data the image data to import.
	 */
	public function import_image( $image_data ) {
		$local_image = $this->check_for_local_image( $image_data );
		if ( $local_image['status'] ) {
			return $local_image['image'];
		}

		$file_content = wp_remote_retrieve_body(
			wp_safe_remote_get(
				$image_data['url'],
				array(
					'timeout'   => '60',
					'sslverify' => false,
				)
			)
		);
		// Empty file content?
		if ( empty( $file_content ) ) {
			return $image_data;
		}

		$filename = basename( $image_data['url'] );

		$upload = wp_upload_bits( $filename, null, $file_content );
		$post = array(
			'post_title' => $filename,
			'guid'       => $upload['url'],
		);
		$info = wp_check_filetype( $upload['file'] );
		if ( $info ) {
			$post['post_mime_type'] = $info['type'];
		} else {
			return $image_data;
		}
		$post_id = wp_insert_attachment( $post, $upload['file'] );
		wp_update_attachment_metadata(
			$post_id,
			wp_generate_attachment_metadata( $post_id, $upload['file'] )
		);
		update_post_meta( $post_id, '_kadence_blocks_image_hash', sha1( $image_data['url'] ) );

		return array(
			'id'  => $post_id,
			'url' => $upload['url'],
		);
	}

	/**
	 * Check if image is already imported.
	 *
	 * @param array $image_data the image data to import.
	 */
	public function check_for_local_image( $image_data ) {
		global $wpdb;

		// Thanks BrainstormForce for this idea.
		// Check if image is already local based on meta key and custom hex value.
		$image_id = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT `post_id` FROM `' . $wpdb->postmeta . '`
					WHERE `meta_key` = \'_kadence_blocks_image_hash\'
						AND `meta_value` = %s
				;',
				sha1( $image_data['url'] )
			)
		);
		if ( $image_id ) {
			$local_image = array(
				'id'  => $image_id,
				'url' => wp_get_attachment_url( $image_id ),
			);
			return array(
				'status' => true,
				'image'  => $local_image,
			);
		}
		return array(
			'status' => false,
			'image'  => $image_data,
		);
	}
	/**
	 * Check if link is for an image.
	 *
	 * @param string $link url possibly to an image.
	 */
	public function check_for_image( $link = '' ) {
		return preg_match( '/^((https?:\/\/)|(www\.))([a-z0-9-].?)+(:[0-9]+)?\/[\w\-]+\.(jpg|png|gif|jpeg)\/?$/i', $link );
	}
	/**
	 * Check if the AJAX call is valid.
	 */
	public static function verify_ajax_call() {
		check_ajax_referer( 'kadence-blocks-ajax-verification', 'security' );
	}
	/**
	 * Main AJAX callback function for:
	 * 1). get local data if there
	 * 2). query api for data if needed
	 * 3). import content
	 * 4). execute 'after content import' actions (before widget import WP action, widget import, customizer import, after import WP action)
	 */
	public function prebuilt_data_reload_ajax_callback() {

		// Verify if the AJAX call is valid (checks nonce and current_user_can).
		$this->verify_ajax_call();
		$this->local_template_data_path = '';
		$this->api_key   = empty( $_POST['api_key'] ) ? '' : sanitize_text_field( $_POST['api_key'] );
		$this->api_email = empty( $_POST['api_email'] ) ? '' : sanitize_text_field( $_POST['api_email'] );
		$this->package   = empty( $_POST['package'] ) ? 'section' : sanitize_text_field( $_POST['package'] );
		$this->url       = empty( $_POST['url'] ) ? $this->remote_url : rtrim( sanitize_text_field( $_POST['url'] ), '/' ) . '/wp-json/kadence-cloud/v1/get/';
		$this->key       = empty( $_POST['key'] ) ? 'section' : sanitize_text_field( $_POST['key'] );

		// $removed = $this->delete_block_library_folder();
		// if ( ! $removed ) {
		// 	wp_send_json_error( 'failed_to_flush' );
		// }
		// Do you have the data?
		$get_data = $this->get_template_data( true );

		if ( ! $get_data ) {
			// Send JSON Error response to the AJAX call.
			wp_send_json( esc_html__( 'No library data', 'kadence-blocks' ) );
		} else {
			wp_send_json( $get_data );
		}
		die;
	}

	/**
	 * Get Importer Array.
	 *
	 * Used durning import to get information from the json.
	 *
	 * @access public
	 * @param string $slug the template slug.
	 * @param string $type the template type.
	 * @return array
	 */
	public function get_importer_files( $slug, $type ) {
		$this->package = $type;
		$get_data = $this->get_template_data();
		if ( ! $get_data ) {
			return array();
		}
		$data = json_decode( $get_data, true );
		if ( isset( $data[ $slug ] ) ) {
			return $data;
		}
		return array();
	}
	/**
	 * Schedule a cleanup.
	 *
	 * Deletes the templates files on a regular basis.
	 * This way templates get updated regularly.
	 *
	 * @access public
	 * @return void
	 */
	public function schedule_cleanup() {
		if ( ! is_multisite() || ( is_multisite() && is_main_site() ) ) {
			if ( ! wp_next_scheduled( 'delete_block_library_folder' ) && ! wp_installing() ) {
				wp_schedule_event( time(), self::CLEANUP_FREQUENCY, 'delete_block_library_folder' );
			}
		}
	}
	/**
	 * Delete the fonts folder.
	 *
	 * This runs as part of a cleanup routine.
	 *
	 * @access public
	 * @return bool
	 */
	public function delete_block_library_folder() {
		return $this->get_filesystem()->delete( $this->get_block_library_folder(), true );
	}
	/**
	 * Get the folder for templates data.
	 *
	 * @access public
	 * @return string
	 */
	public function get_block_library_folder() {
		if ( ! $this->block_library_folder ) {
			$this->block_library_folder = $this->get_base_path();
			if ( $this->get_subfolder_name() ) {
				$this->block_library_folder .= $this->get_subfolder_name();
			}
		}
		return $this->block_library_folder;
	}
	/**
	 * Get the subfolder name.
	 *
	 * @access public
	 * @return string
	 */
	public function get_subfolder_name() {
		if ( ! $this->subfolder_name ) {
			$this->subfolder_name = apply_filters( 'kadence_block_library_local_data_subfolder_name', 'kadence_blocks_library' );
		}
		return $this->subfolder_name;
	}
	/**
	 * Get the base path.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_path() {
		if ( ! $this->base_path ) {
			$this->base_path = apply_filters( 'kadence_block_library_local_data_base_path', trailingslashit( $this->get_filesystem()->wp_content_dir() ) );
		}
		return $this->base_path;
	}
	/**
	 * Get the base URL.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_url() {
		if ( ! $this->base_url ) {
			$this->base_url = apply_filters( 'kadence_block_library_local_data_base_url', content_url() );
		}
		return $this->base_url;
	}
	/**
	 * Get the filesystem.
	 *
	 * @access protected
	 * @return WP_Filesystem
	 */
	protected function get_filesystem() {
		global $wp_filesystem;

		// If the filesystem has not been instantiated yet, do it here.
		if ( ! $wp_filesystem ) {
			if ( ! function_exists( 'WP_Filesystem' ) ) {
				require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
			}
			WP_Filesystem();
		}
		return $wp_filesystem;
	}
}
Kadence_Blocks_Prebuilt_Library::get_instance();
