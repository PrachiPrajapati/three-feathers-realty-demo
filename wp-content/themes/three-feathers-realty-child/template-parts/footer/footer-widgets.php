<?php
/**
 * Displays the footer widget area.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

if ( is_active_sidebar( 'contact-information' ) ) : ?>

	<aside class="widget-area">
		<div class="row justify-content-center">
		<?php if( is_page(36) ): ?>
			<div class="col-xl-10">
			<?php else: ?>
				<div class="col-md-12">	
				<?php endif; ?>		
			<?php if( is_page(36) ): ?>
				<div class="contact-info-section contact-page-footer text-center">
			<?php else: ?>
			<div class="contact-info-section">
				<?php endif; ?>
			<div class="contact-content row g-0">
			<?php if( is_page(36) ): ?>
				<div class="col-md-12">
			<?php else: ?>
				<div class="col-md-4">
			<?php endif; ?>
					<div class="contact-info feathers common-space-small">
						<?php dynamic_sidebar( 'contact-information' ); ?>
						<div class="follow-us">
							<div class="heading">
								<h3 class="text-uppercase">follow us</h3>
							</div>
							<nav aria-label="<?php esc_attr_e( 'Secondary menu', 'twentytwentyone' ); ?>" class="footer-navigation">
				<ul class="footer-navigation-wrapper">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'items_wrap'     => '%3$s',
							'container'      => false,
							'depth'          => 1,
							'link_before'    => '<span>',
							'link_after'     => '</span>',
							'fallback_cb'    => false,
						)
					);
					?>
				</ul><!-- .footer-navigation-wrapper -->
			</nav><!-- .footer-navigation -->
						</div>
					</div>
				</div>
				<?php if( !is_page(36) ): ?>
					<div class="col-md-8">
						<div class="contact-form common-space-small">
						<?php dynamic_sidebar( 'contact-form' ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
			</div>
		</div>
	
	</aside><!-- .widget-area -->
	
<?php endif; ?>
