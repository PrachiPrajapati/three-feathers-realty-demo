<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->
	<footer id="colophon" class="site-footer" role="contentinfo">
	<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>
		<div class="footer-menu-bar">
				<?php
		wp_nav_menu( array( 
			'theme_location' => 'my-custom-menu', 
			'container_class' => 'custom-menu-class' ) ); 
		?>
		</div>
		<div class="site-info">
			<div class="powered-by">
				<?php
				printf(
					/* translators: %s: WordPress. */
					esc_html__( '&copy; 2021 Three Feathers Realty. All Rights Reserved', 'three-feathers-realty' )
				);
				?>
			</div><!-- .powered-by -->

		</div><!-- .site-info -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
<script>
	jQuery(window).on("scroll", function() {
    if(jQuery(window).scrollTop() > 50) {
        jQuery(".site-header").addClass("header-style");
    } else {
       jQuery(".site-header").removeClass("header-style");
    }
});	
</script>
<!-- <script>
	$('.inner-navigation li a').click(function() {
		$("#primary-mobile-menu.button").attr('aria-expanded', 'true');
   });
   $('.inner-navigation li a[taget_blank]').click(function() {
		$("#primary-mobile-menu.button").attr('aria-expanded', 'true');
   });
</script> -->


<script>
	$(document).ready(function () {		
		/* load more result Script*/  
		jQuery( "#loadmore-form-submit" ).on('submit', function( e ){
            e.preventDefault();
            var cuurentForm =jQuery( this );
            var totalPages = cuurentForm.find("input[name=total-pages]").val();
            var pageNo = cuurentForm.find("input[name=page-no]");
            cuurentForm.find(".load-more-btn").hide();
            cuurentForm.find( ".loading-btn" ).show();
            jQuery.ajax({
                url : ' <?php echo admin_url( 'admin-ajax.php' ); ?>',
				xhrFields: {
					withCredentials: true
				},
				crossDomain: true,
                type : 'POST',
                data : cuurentForm.serialize(),
                success : function(data){
                    jQuery("#loadmore-form-submit").before(data);
                     jQuery(document).resize();
                    if( parseInt(totalPages) <=  parseInt(pageNo.val())  ){
                        cuurentForm.hide();
                    }
                    else{                           
                        pageNo.val( ( pageNo.val() ) - 1 + 2 );
                        cuurentForm.find(".load-more-btn").show();
                        cuurentForm.find( ".loading-btn" ).hide();
                    }
                },
                error : function(jqXhr, textStatus, errorMessage) { // error callback 
                    cuurentForm.find(".product-load-more").show();
                    cuurentForm.find( ".loading-btn" ).hide();
                    console.log('Error: ' + errorMessage); 
                }
            }); 
		});
		jQuery(".banner-slider").slick({
					dots: false,
					infinite: true,
					arrows:true,
					fade:false,
					autoplay:true,
					speed:500
				});
				jQuery(".testimonial-slider").slick({
					dots: true,
					infinite: true,
					arrows:false,
					fade:false,
					autoplay:true,
					speed:500
				});
				/* artist-slider */
		jQuery(".news-tfr-slider").slick({
				dots: false,
				infinite: false,
				arrows:true,
				fade:false,
				slidesToShow: 3,
				slidesToScroll: 1,
				autoplay:true,
					speed:500,
				responsive: [
					{
						breakpoint: 990,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1,
						}
					},
					{
						breakpoint: 766,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1,
						}
					},
					{
						breakpoint: 574,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1,
						}
					}
				]
		});
		jQuery(".gallery-slider").slick({
				dots: false,
				infinite: false,
				arrows:true,
				fade:false,
				slidesToShow: 3,
				slidesToScroll: 1,
				autoplay:true,
					speed:500,
				responsive: [
					{
						breakpoint: 990,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1,
						}
					},
					{
						breakpoint: 766,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1,
						}
					},
					{
						breakpoint: 574,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1,
						}
					}
				]
		});
	});


	</script>
	<script type="text/javascript">

 </script>
</body>
</html>
