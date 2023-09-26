<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
	<!-- Fonts Included  -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'twentytwentyone' ); ?></a>

	<?php get_template_part( 'template-parts/header/site-header' ); ?>

	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php 
			if( !is_front_page( ) && !is_page(232)&& !is_page(390)&& !is_page(392)&&!is_page(394) && !is_404() ){
				$featured_img_url= wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?>
				<div class="featured-img-banner">
					<div class="container">
						<div class="banner-info-box d-md-flex d-block justify-content-between align-items-center">
							<div class="title-box">
								<h1><?php the_title()?></h1>
								<?php if($desig = get_field('sub_title') ): ?>
									<p class="banner-subtitle text-white"><?php echo $desig; ?></p>
								<?php endif; ?>
							</div>
							<div class="banner-image">
								<?php if($featured_img_url): ?>
									<img src="<?php echo $featured_img_url[0];?>" alt="Banner-image">
								<?php endif; ?>
							</div>
						</div>
						
					</div>
				</div>		
			<?php										
			}
		?>
		<?php  if(is_page(38) ){ ?>
			<div class="inner-navigation">
				<?php
				wp_nav_menu( array( 
					'theme_location' => 'flockhomes-menu', 
					'container_class' => 'flock-menu-class' ) ); 
				?>	
			</div>
		<?php }elseif(is_page(40) ){ ?>
			<div class="inner-navigation">
				<?php
				wp_nav_menu( array( 
					'theme_location' => 'trinity-menu', 
					'container_class' => 'trinity-menu-class' ) ); 
				?>	
			</div>
		<?php }?>