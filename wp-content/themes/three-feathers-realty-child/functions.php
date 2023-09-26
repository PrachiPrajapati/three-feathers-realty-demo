<?php
/*/---- Ragister Post Type for Three Feathers Realty ----/*/
add_action( 'init', 'threeFeathersRealtyCustomPostType' );
function threeFeathersRealtyCustomPostType() {
    /*/---- create new posttype for Banners ------/*/
    $bannerLabels = array(
        'name'                => _x( 'Home Banners', 'Post Type General Name', 'Three Feathers Realty' ),
        'singular_name'       => _x( 'Home Banner', 'Post Type Singular Name', 'Three Feathers Realty' ),
        'menu_name'           => __( 'Home Banners', 'Three Feathers Realty' ),
        'parent_item_colon'   => __( 'Parent Home Banner', 'Three Feathers Realty' ),
        'all_items'           => __( 'All Home Banners', 'Three Feathers Realty' ),
        'view_item'           => __( 'View Home Banner', 'Three Feathers Realty' ),
        'add_new_item'        => __( 'Add New Home Banner', 'Three Feathers Realty' ),
        'add_new'             => __( 'Add New', 'Three Feathers Realty' ),
        'edit_item'           => __( 'Edit Home Banner', 'Three Feathers Realty' ),
        'update_item'         => __( 'Update Home Banner', 'Three Feathers Realty' ),
        'search_items'        => __( 'Search Home Banners', 'Three Feathers Realty' ),
        'not_found'           => __( 'Not Found', 'Three Feathers Realty' ),
        'not_found_in_trash'  => __( 'Not Found in Trash', 'Three Feathers Realty' ),
    );
    // Set other options for Custom Post Type Banners
    $bannerArgs = array(
        'label'               => __( 'Home Banners', 'Three Feathers Realty' ),
        'description'         => __( 'Home Banners', 'Three Feathers Realty' ),
        'labels'              => $bannerLabels,
        'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'has_archive'         => false,
        'menu_icon'           => 'dashicons-controls-repeat',
        'can_export'          => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'capability_type'     => 'post',
    );
    // Registering your Custom Post Type Banners
    register_post_type( 'banners', $bannerArgs );

    /*/---- create new posttype for Testimonials ------/*/
    $testimonialsLabels = array(
        'name'                => _x( 'Testimonials', 'Post Type General Name', 'Three Feathers Realty' ),
        'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'Three Feathers Realty' ),
        'menu_name'           => __( 'Testimonials', 'Three Feathers Realty' ),
        'parent_item_colon'   => __( 'Parent Testimonial', 'Three Feathers Realty' ),
        'all_items'           => __( 'All Testimonials', 'Three Feathers Realty' ),
        'view_item'           => __( 'View Testimonials', 'Three Feathers Realty' ),
        'add_new_item'        => __( 'Add New Testimonial', 'Three Feathers Realty' ),
        'add_new'             => __( 'Add New', 'Three Feathers Realty' ),
        'edit_item'           => __( 'Edit Testimonial', 'Three Feathers Realty' ),
        'update_item'         => __( 'Update Testimonial', 'Three Feathers Realty' ),
        'search_items'        => __( 'Search Testimonials', 'Three Feathers Realty' ),
        'not_found'           => __( 'Not Found', 'Three Feathers Realty' ),
        'not_found_in_trash'  => __( 'Not Found in Trash', 'Three Feathers Realty' ),
    );
            // Set other options for Custom Post Type Testimonials

    $testimonialsArgs = array(
        'label'               => __( 'Testimonials', 'Three Feathers Realty' ),
        'description'         => __( 'Testimonials', 'Three Feathers Realty' ),
        'labels'              => $testimonialsLabels,
        'supports'            => array( 'title', 'thumbnail', 'revisions', 'editor', ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 6,
        'has_archive'         => false,
        'menu_icon'           => 'dashicons-format-quote',
        'can_export'          => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'capability_type'     => 'post',
    );
    // Registering your Custom Post Type Banner
    register_post_type( 'testimonials', $testimonialsArgs );

    $testimonialsCatLabels = array(
      'name' => _x( 'Testimonials Category', 'taxonomy general name' ),
      'singular_name' => _x( 'Testimonial Category', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Testimonials Category' ),
      'all_items' => __( 'All Testimonials Category' ),
      'parent_item' => __( 'Parent Testimonial Category' ),
      'parent_item_colon' => __( 'Parent Testimonial Category:' ),
      'edit_item' => __( 'Edit Testimonial Category' ), 
      'update_item' => __( 'Update Testimonial Category' ),
      'add_new_item' => __( 'Add New Testimonial Category' ),
      'new_item_name' => __( 'New Testimonial Category Name' ),
      'menu_name' => __( 'Testimonials Category' ),
  );    

  // Now register the taxonomy
  register_taxonomy('testimonials-cat',array('testimonials'), array(
      'hierarchical' => true,
      'labels' => $testimonialsCatLabels,
      'show_ui' => true,
      'show_in_rest' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => array( 'slug' => 'testimonials-cat' ),
  ));
    
    /*/---- create new posttype for Team Members ------/*/
    $teamLabels = array(
        'name'                => _x( 'Team Members', 'Post Type General Name', 'Three Feathers Realty' ),
        'singular_name'       => _x( 'Team Member', 'Post Type Singular Name', 'Three Feathers Realty' ),
        'menu_name'           => __( 'Team Members', 'Three Feathers Realty' ),
        'parent_item_colon'   => __( 'Parent Team Member', 'Three Feathers Realty' ),
        'all_items'           => __( 'All Team Members', 'Three Feathers Realty' ),
        'view_item'           => __( 'View Team Members', 'Three Feathers Realty' ),
        'add_new_item'        => __( 'Add New Team Member', 'Three Feathers Realty' ),
        'add_new'             => __( 'Add New', 'Three Feathers Realty' ),
        'edit_item'           => __( 'Edit Team Member', 'Three Feathers Realty' ),
        'update_item'         => __( 'Update Team Members', 'Three Feathers Realty' ),
        'search_items'        => __( 'Search Team Members', 'Three Feathers Realty' ),
        'not_found'           => __( 'Not Found', 'Three Feathers Realty' ),
        'not_found_in_trash'  => __( 'Not Found in Trash', 'Three Feathers Realty' ),
    );
    // Set other options for Custom Post Type Team Member
    $teamArgs = array(
        'label'               => __( 'Team Members', 'Three Feathers Realty' ),
        'description'         => __( 'Team Members', 'Three Feathers Realty' ),
        'labels'              => $teamLabels,
        'supports'            => array( 'title',  'thumbnail', 'revisions', ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'has_archive'         => false,
        'menu_icon'           => 'dashicons-groups',
        'can_export'          => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    // Registering your Custom Post Type Team Members
    register_post_type( 'team-members', $teamArgs );

    /*/---- create new posttype for career ------/*/
    $careerLabels = array(
        'name'                => _x( 'Current Openings', 'Post Type General Name', 'Three Feathers Realty' ),
        'singular_name'       => _x( 'Current Opening', 'Post Type Singular Name', 'Three Feathers Realty' ),
        'menu_name'           => __( 'Current Openings', 'Three Feathers Realty' ),
        'parent_item_colon'   => __( 'Parent Current Opening', 'Three Feathers Realty' ),
        'all_items'           => __( 'All Current Openings', 'Three Feathers Realty' ),
        'view_item'           => __( 'View Current Openings', 'Three Feathers Realty' ),
        'add_new_item'        => __( 'Add New Current Opening', 'Three Feathers Realty' ),
        'add_new'             => __( 'Add New', 'Three Feathers Realty' ),
        'edit_item'           => __( 'Edit Current Opening', 'Three Feathers Realty' ),
        'update_item'         => __( 'Update Current Opening', 'Three Feathers Realty' ),
        'search_items'        => __( 'Search Current Openings', 'Three Feathers Realty' ),
        'not_found'           => __( 'Not Found', 'Three Feathers Realty' ),
        'not_found_in_trash'  => __( 'Not Found in Trash', 'Three Feathers Realty' ),
    );
    // Set other options for Custom Post Type career
    $careerArgs = array(
        'label'               => __( 'Current Openings', 'Three Feathers Realty' ),
        'description'         => __( 'Current Openings', 'Three Feathers Realty' ),
        'labels'              => $careerLabels,
        'supports'            => array( 'title', 'revisions', 'thumbnail',  'editor', ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 10,
        'has_archive'         => false,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'can_export'          => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    // Registering your Custom Post Type Projects
    register_post_type( 'career', $careerArgs );

    /*/---- create new posttype for Achievements ------/*/
    $faqLabels = array(
        'name'                => _x( "FAQ's", 'Post Type General Name', 'Three Feathers Realty' ),
        'singular_name'       => _x( 'FAQ', 'Post Type Singular Name', 'Three Feathers Realty' ),
        'menu_name'           => __( "FAQ's", 'Three Feathers Realty' ),
        'parent_item_colon'   => __( 'Parent FAQ', 'Three Feathers Realty' ),
        'all_items'           => __( "All FAQ's", 'Three Feathers Realty' ),
        'view_item'           => __( "View FAQ's", 'Three Feathers Realty' ),
        'add_new_item'        => __( 'Add New FAQ', 'Three Feathers Realty' ),
        'add_new'             => __( 'Add New', 'Three Feathers Realty' ),
        'edit_item'           => __( 'Edit FAQ', 'Three Feathers Realty' ),
        'update_item'         => __( 'Update FAQ', 'Three Feathers Realty' ),
        'search_items'        => __( "Search FAQ's", 'Three Feathers Realty' ),
        'not_found'           => __( 'Not Found', 'Three Feathers Realty' ),
        'not_found_in_trash'  => __( 'Not Found in Trash', 'Three Feathers Realty' ),
    );
    // Set other options for Custom Post Type FAQs
    $faqArgs = array(
        'label'               => __( "FAQ's", 'Three Feathers Realty' ),
        'description'         => __( "FAQ's", 'Three Feathers Realty' ),
        'labels'              => $faqLabels,
        'supports'            => array( 'title', 'editor', 'revisions', ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'has_archive'         => false,
        'menu_icon'           => 'dashicons-megaphone',
        'can_export'          => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'capability_type'     => 'post',
    );
    // Registering your Custom Post Type FAQs Slider
    register_post_type( 'faqs', $faqArgs );

  /*/---- create new posttype for Happenings ------/*/
  $happeningLabels = array(
    'name'                => _x( 'Happenings', 'Post Type General Name', 'Three Feathers Realty' ),
    'singular_name'       => _x( 'Happening', 'Post Type Singular Name', 'Three Feathers Realty' ),
    'menu_name'           => __( 'Happenings', 'Three Feathers Realty' ),
    'parent_item_colon'   => __( 'Parent Happening', 'Three Feathers Realty' ),
    'all_items'           => __( 'All Happenings', 'Three Feathers Realty' ),
    'view_item'           => __( 'View Happening', 'Three Feathers Realty' ),
    'add_new_item'        => __( 'Add New Happening', 'Three Feathers Realty' ),
    'add_new'             => __( 'Add New', 'Three Feathers Realty' ),
    'edit_item'           => __( 'Edit Happening', 'Three Feathers Realty' ),
    'update_item'         => __( 'Update Happening', 'Three Feathers Realty' ),
    'search_items'        => __( 'Search Happenings', 'Three Feathers Realty' ),
    'not_found'           => __( 'Not Found', 'Three Feathers Realty' ),
    'not_found_in_trash'  => __( 'Not Found in Trash', 'Three Feathers Realty' ),
  );
  // Set other options for Custom Post Type Happenings
  $happeningArgs = array(
      'label'               => __( 'Happenings', 'Three Feathers Realty' ),
      'description'         => __( 'Happenings', 'Three Feathers Realty' ),
      'labels'              => $happeningLabels,
      'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', ),
      'hierarchical'        => false,
      'public'              => false,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 5,
      'has_archive'         => false,
      'menu_icon'           => 'dashicons-smiley',
      'can_export'          => true,
      'exclude_from_search' => true,
      'publicly_queryable'  => false,
      'capability_type'     => 'post',
  );
  // Registering your Custom Post Type Happenings
  register_post_type( 'happenings', $happeningArgs );
}

/* to add external files in to it */
function add_scripts() {
  /* **Main JQuery Included** */
  wp_enqueue_script('jquery-js', get_stylesheet_directory_uri().'/js/lib/jquery.min.js');
  /* bootstrap style-css-js included */
  wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri().'/css/bootstrap.min.css');
  wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri().'/js/bootstrap.min.js');
  /**Font-Awesome Included***/
  wp_enqueue_style( 'fontawesome-css', get_stylesheet_directory_uri().'/css/fontawesome.css');
  /* Slick Style and Scripts Included */
  wp_enqueue_script('slick-js', get_stylesheet_directory_uri().'/js/slick.js');
  wp_enqueue_style('slick-css', get_stylesheet_directory_uri().'/css/slick.css');
    /***fancy-box*****/ 
  wp_enqueue_script('fancy-js', get_stylesheet_directory_uri().'/js/fancybox.min.js');
  wp_enqueue_style('fancy-css', get_stylesheet_directory_uri().'/css/fancybox.min.css');
  /* style.css included */
  wp_enqueue_style( 'twenty-twenty-one-style', get_stylesheet_directory_uri().'/style.css' );
}
add_action( 'wp_enqueue_scripts', 'add_scripts' );

/* svg anable */
function svg_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'svg_mime_types');

/* new widgets */
add_action( 'widgets_init', 'cust_widgets_footer2021' );
function cust_widgets_footer2021() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Contact Information', 'three-feathers-realty' ),
            'id'            => 'contact-information',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Contact Form', 'three-feathers-realty' ),
            'id'            => 'contact-form',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
		)
	);
}

/* footer menu */
function wpb_custom_new_menu() {
  register_nav_menus(
    array(
      'my-custom-menu' => __( 'My Custom Menu' ),
      'extra-menu' => __( 'Extra Menu' )
    )
  );
}
add_action( 'init', 'wpb_custom_new_menu' );

/* trinity-menu */
function wpb_custom_new_menu2() {
  register_nav_menus(
    array(
      'trinity-menu' => __( 'Trinity Menu' ),
      'flockhomes-menu' => __( 'Flock Homes Menu' )
    )
  );
}
add_action( 'init', 'wpb_custom_new_menu2' );

/* banner-slider shortcode Start*/
add_shortcode( 'banner-slider', 'bannerSliderFuntion' );
function bannerSliderFuntion(){
    if(is_admin()){
        return "connected...";
    }
    ob_start();
    $rollBanArgs = array(
        'post_type' => 'banners',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );
    $rollBan = new WP_Query( $rollBanArgs );
    if ( $rollBan->have_posts() ) { add_filter('the_content', 'wpautop'); ?>
      <div class="banner-slider">
        <?php while ( $rollBan->have_posts() ) : $rollBan->the_post(); 
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
          $link = 'javascript:void(0);'; $link_title = 'learn more'; $link_target = '_self';
          if( $linkOpt = get_field( 'learn_more_button' ) ) {
            $link = $linkOpt['url']?:'javascript:void(0);' ;
            $link_title = $linkOpt['title'];
            $link_target = $linkOpt['target'] ? $linkOpt['target'] : '_self';
          } ?>
          <div>
            <div class="banner-section" style="background-image:url(<?php echo $image[0];?>)">
              <div class="row">
                <div class="col-lg-6 col-md-8">
                  <div class="banner-desc">
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                    <a href="<?php echo $link; ?>" target="<?php echo esc_attr( $link_target?:'_self' ); ?>" class="theme-btn white-bg"><?php echo $link_title; ?></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>  
    <?php } else {
      echo __( 'No Results Found!', 'Three Feathers Realty' );
    }
    wp_reset_postdata();
    return ob_get_clean();
}
/* banner-slider shortcode End */

/*/ Show Testimonials Slider /*/ 
add_shortcode('testimonials-slider','showTestimonialsSliderfunction');
function showTestimonialsSliderfunction($attr) {
    if(is_admin()){
      return "connected...";
    }
    ob_start();
    $testimonialsargs = array(
      'post_type' => 'testimonials',
      'posts_per_page' => -1,
      'post_status' => 'publish',
    );
    if( isset($attr['cat']) && !empty($attr['cat']) ){
      $testimonialsargs['tax_query'] = array(
          array (
              'taxonomy' => 'testimonials-cat',
              'field' => 'slug',
              'terms' => $attr['cat'],
          ),
        );
    } 
    $testimonials = new WP_Query( $testimonialsargs );
    if ( $testimonials->have_posts() ) { add_filter('the_content', 'wpautop'); ?>
      <div class="testimonial-slider"> 
        <?php while ( $testimonials->have_posts() ) : $testimonials->the_post();
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?>
          <div>
            <div class="items row  justify-content-center align-items-center text-center">
              <div class="col-lg-10 justify-content-center align-items-center d-flex flex-column">
                <div class="img-box">
                <img src="<?php echo $image[0];?>" alt="profile">
              </div>
              <div class="desc text-center">
              <?php the_content(); ?>
                <h3 class="font-weight-bold"><?php the_title(); ?></h3>
                <?php if($desig = get_field('sub_title') ): ?>
                  <p><?php echo $desig; ?></p>
                <?php endif; ?>
              </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div> 
    <?php } else {
        echo __( 'No Results Found!', 'Three Feathers Realty' );
    }
    wp_reset_postdata();
    return ob_get_clean();
}
/* testimony-slider shortcode End */

/*/ Add shortcode for FAQ's section /*/
add_shortcode( 'faqs-sec', 'faqsSecFuntion' );
function faqsSecFuntion(){
  if(is_admin()){
      return "connected...";
  }
  ob_start();
  $faqArgs = array(
      'post_type' => 'faqs',
      'posts_per_page' => -1,
      'post_status' => 'publish',
  );
  $faqs = new WP_Query( $faqArgs );
  if ( $faqs->have_posts() ) { add_filter('the_content', 'wpautop'); $count = 1; ?>
    <div class="faq-code">
      <div class="accordion" id="accordionExample">
        <?php while ( $faqs->have_posts() ) : $faqs->the_post(); ?>
          <div class="accordion-item">
            <h4 class="accordion-header" id="headingOne">
              <button class="accordion-button <?php if( $count+1 > 2 ) echo 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $count ;?>" aria-expanded="<?php echo ( $count < 3 )?'true':'false'; ?>" aria-controls="collapse-<?php echo $count ;?>">
                <?php the_title(); ?>
              </button>
            </h4>
            <div id="collapse-<?php echo $count++ ;?>" class="accordion-collapse collapse <?php if( $count < 3 ) echo 'show'; ?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <?php the_content(); ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>  
  <?php } else {
      echo __( 'No Results Found!', 'Three Feathers Realty' );
  }
  wp_reset_postdata();
  return ob_get_clean();
}
/* Faq's Section shortcode End */
/* Team Section shortcode start */
add_shortcode( 'our-team-sec', 'teamMembersSecFuntion' );
function teamMembersSecFuntion(){
  if(is_admin()){
      return "connected...";
  }
  ob_start();
  $teamemArgs = array(
    'post_type' => 'team-members',
    'posts_per_page' => -1,
    'post_status' => 'publish',
  );
  $teamem = new WP_Query( $teamemArgs );
  if ( $teamem->have_posts() ) { add_filter('the_content', 'wpautop'); ?>
    <div class="about-team">
      <div class="row justify-content-center">
        <div class="col-xl-10">
          <div class="row">
            <?php while ( $teamem->have_posts() ) : $teamem->the_post();
              $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );  ?>
              <div class="col-md-4 team-box">
                <div class="team">
                  <div class="img-item mx-auto">
                    <img src="<?php echo $image[0]; ?>" alt="Zaire Bator">
                  </div>
                  <div class="team-desc text-center">
                    <h4 class="member-name"><?php echo get_the_title(); ?><h4>
                    <?php if($desig = get_field('sub_title') ): ?>
                      <p class="position mb-0"><?php echo $desig; ?></p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    </div>
  <?php } else {
      echo __( 'No Results Found!', 'Three Feathers Realty' );
  }
  wp_reset_postdata();
  return ob_get_clean();
}
/* Team Section shortcode End */

/* current openiings shortcode start */
add_shortcode( 'current-openings-sec', 'currentOpeningsSecFuntion' );
function currentOpeningsSecFuntion(){
  if(is_admin()){
      return "connected...";
  }
  ob_start();
  $careerArgs = array(
    'post_type' => 'career',
    'posts_per_page' => 4,
    'post_status' => 'publish',
  );
  $career = new WP_Query( $careerArgs );
  if ( $career->have_posts() ) { add_filter('the_content', 'wpautop'); $pagecount = $career->max_num_pages;  ?>
    <div class="current-opening-box">
      <div class="row">
        <?php while ( $career->have_posts() ) : $career->the_post();  ?>
          <div class="col-md-6 job-box">
            <a href="<?php the_permalink();?>"> 
              <div  class="job-post-box feathers three-feathers">
                <h3 class="job-post-title"><?php the_title();?></h3>
                <ul class="current-opening-jobs"> 
                  <?php if($Age = get_field('candidate_age') ): ?>
                    <li class="job-desc">
                        <p class="job-heading color-gray"><?php _e('Age:', 'Three Feathers Realty'); ?></p>
                        <p class="job-post-desc color-black"><?php echo $Age;?></p>
                    </li>
                  <?php endif; 
                  if($Gender = get_field('candidate_gender') ): ?>
                    <li class="job-desc">
                        <p class="job-heading color-gray"><?php _e('Gender:', 'Three Feathers Realty'); ?></p>
                        <p class="job-post-desc color-black"><?php echo $Gender;?></p>
                    </li>
                  <?php endif; 
                  if($Experience = get_field('candidate_experience') ): ?>
                    <li class="job-desc">
                        <p class="job-heading color-gray"><?php _e('Experience:', 'Three Feathers Realty'); ?></p>
                        <p class="job-post-desc color-black"><?php echo $Experience;?></p>
                    </li>
                  <?php endif; 
                  if($Qualification = get_field('candidate_qualification') ): ?>
                    <li class="job-desc">
                        <p class="job-heading color-gray"><?php _e('Qualification:', 'Three Feathers Realty'); ?></p>
                        <p class="job-post-desc color-black"><?php echo $Qualification;?></p>
                    </li>
                  <?php endif; ?>
                </ul>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
        <?php if( $pagecount > 1 ): ?>
          <form id="loadmore-form-submit">
              <input type="hidden" name="action" value="loadMorePostsFuncAjax" />
              <input type="hidden" name="page-no" value="2" />
              <input type="hidden" name="total-pages" value="<?php echo $pagecount;?>" />
              <div class="loading-btn btn-center " style="display: none;"><img src="<?php echo get_stylesheet_directory_uri().'/images/loadmore.gif';?>" alt="loading-image" /> </div>
              <div class="text-center btn-box"> 
                  <button type="submit" name="submit" class=" theme-btn load-more load-more-btn"><span><?php _e('Load more','shade space'); ?></span></button>
              </div>
          </form>
        <?php endif; ?>
      </div>
    </div>
  <?php } else {
      echo __( 'No Results Found!', 'Three Feathers Realty' );
  }
  wp_reset_postdata();
  return ob_get_clean();
}
/* current openiings shortcode End */

/* news-tfr-slider shortcode Start*/
add_shortcode( 'news-tfr-slider', 'newsTFRSliderFuntion' );
function newsTFRSliderFuntion(){
    if(is_admin()){
        return "connected...";
    }
    ob_start();
    $happeningsArgs = array(
      'post_type' => 'happenings',
      'posts_per_page' => -1,
      'post_status' => 'publish',
    );
    $happenings = new WP_Query( $happeningsArgs );
    if ( $happenings->have_posts() ) { ?>
      <div class="news-tfr-slider arrows-small">
        <?php while ( $happenings->have_posts() ) : $happenings->the_post(); 
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
          if( !$fullImg = get_field( 'full_image' )  ){
            $fullImg = $image[0];
          } ?>
          <div>
            <div class="news-items">
              <a href="<?php echo $fullImg; ?>" data-fancybox="tfr-images" class="tfr-box d-flex justify-content-center align-items-end" style="background-image:url('<?php echo $image[0]; ?>');">
                <div class="tfr-desc text-center">
                  <h3 class="text-white fw-bold"><?php the_title(); ?></h3>
                  <p class="text-white"><?php echo get_the_content(); ?></p>
                </div>
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      </div>  
    <?php } else {
      echo __( 'No Results Found!', 'Three Feathers Realty' );
    }
    wp_reset_postdata();
    return ob_get_clean();
}
/* news-tfr-slider shortcode End */

/* page galley-slider shortcode Start*/
add_shortcode( 'page-galley-slider', 'pageGalleySliderFuntion' );
function pageGalleySliderFuntion( $attr ){
  if(is_admin()){
      return "connected...";
  }
  ob_start();
  if(isset($attr['for']) && $attr['for'] == "project"):
    $images = get_field('project_status');
  else:
    $images = get_field('gallery_images');
  endif;
  if( $images ){ ?>
    <div class="<?php echo $attr['class']?:''; ?>">
      <?php foreach( $images as $image ): ?>
        <div>
          <div class="gallery-items">
           <!--  <a href="<?php// echo esc_url($image['url']); ?>" data-fancybox="gallery-images" alt="<?php// echo esc_attr($image['alt']); ?>" class=" image-box " style="background-image:url('<?php echo esc_url($image['url']); ?>');">
            </a> -->
            <span href="<?php echo esc_url($image['url']); ?>" data-fancybox="gallery-images" class=" image-box " style="cursor: pointer ;background-image:url('<?php echo esc_url($image['url']); ?>');"></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php } else {
    echo __( 'No Results Found!', 'Three Feathers Realty' );
  }
  wp_reset_postdata();
  return ob_get_clean();
}
/* page galley-slider shortcode End */

/* gallery-slider shortcode Start*/
/* gallery-slider shortcode End */

/* project-status shortcode Start*/
/* project-status shortcode End */

/* gallery-slider shortcode Start*/
/* gallery-slider shortcode End */

/* testimony-slider shortcode Start*/
/* testimony-slider shortcode End */

/*/---- Ajex Function For loadmore carees ----/*/
add_action('wp_ajax_loadMorePostsFuncAjax', 'loadMorePostsFuncAjax');
add_action('wp_ajax_nopriv_loadMorePostsFuncAjax', 'loadMorePostsFuncAjax');
function loadMorePostsFuncAjax() {
  if( !isset($_POST['page-no']) || empty($_POST['page-no']) ){
    echo 'No Results Found!';
    exit;
  }
  ob_start();
  $pageno = isset( $_POST['page-no'] )? $_POST['page-no'] : 1;
  $careerArgs = array(
    'post_type' => 'career',
    'paged' => $pageno,
    'posts_per_page' => 4,
    'post_status' => 'publish',
  );
  $career = new WP_Query( $careerArgs );
  if ( $career->have_posts() ) { add_filter('the_content', 'wpautop'); $pagecount = $career->max_num_pages;  ?>
    <?php while ( $career->have_posts() ) : $career->the_post();  ?>
      <div class="col-md-6 job-box">
        <a href="<?php the_permalink();?>"> 
          <div  class="job-post-box feathers three-feathers">
            <h3 class="job-post-title"><?php the_title();?></h3>
            <ul class="current-opening-jobs"> 
              <?php if($Age = get_field('candidate_age') ): ?>
                <li class="job-desc">
                    <p class="job-heading color-gray"><?php _e('Age:', ''); ?></p>
                    <p class="job-post-desc color-black"><?php echo $Age;?></p>
                </li>
              <?php endif; 
              if($Gender = get_field('candidate_age') ): ?>
                <li class="job-desc">
                    <p class="job-heading color-gray"><?php _e('Gender:', ''); ?></p>
                    <p class="job-post-desc color-black"><?php echo $Gender;?></p>
                </li>
              <?php endif; 
              if($Experience = get_field('candidate_age') ): ?>
                <li class="job-desc">
                    <p class="job-heading color-gray"><?php _e('Experience:', ''); ?></p>
                    <p class="job-post-desc color-black"><?php echo $Experience;?></p>
                </li>
              <?php endif; 
              if($Qualification = get_field('candidate_age') ): ?>
                <li class="job-desc">
                    <p class="job-heading color-gray"><?php _e('Qualification:', ''); ?></p>
                    <p class="job-post-desc color-black"><?php echo $Qualification;?></p>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        </a>
      </div>
    <?php endwhile; ?>
  <?php } else {
      echo __( 'No Results Found!', 'Three Feathers Realty' );
  }
  wp_reset_postdata();
  echo ob_get_clean();
  exit;
}

/*/---- Validate contact Form  ----/*/
add_filter( 'wpcf7_validate_text', 'custom_name_confirmation_validation_filter', 20, 2 );
add_filter( 'wpcf7_validate_text*', 'custom_name_confirmation_validation_filter', 20, 2 );
function custom_name_confirmation_validation_filter( $result, $tag ) {
  if ( 'text-33' == $tag->name  || 'text-724' == $tag->name || 'text-34' == $tag->name ) {
    $name = isset( $_POST[$tag->name] ) ? $_POST[$tag->name]  : '';
    if ( $name != "" && !preg_match('/^[a-zA-Z][a-zA-Z ]{2,40}$/', $name) ) {
      $result->invalidate( $tag, "The name entered is invalid." );
    }
  }
  return $result;
}

/*/ add  cutom form tag in conatct form 7/*/ 
add_action( 'wpcf7_init', 'custom_add_form_tag_clock' ); 
function custom_add_form_tag_clock() {
  wpcf7_add_form_tag( 'post_inner', 'custom_post_inner_form_tag_handler' ); // "clock" is the type of the form-tag
} 
function custom_post_inner_form_tag_handler( $tag ) {
  global $post;
  if($title = get_the_title( $post->ID ) ):
    return '<input type="hidden" name="post-inner" value="'.$title.'">'; 
  else:
    return '<input type="hidden" name="post-inner" value="No Title">'; 
  endif;
}
