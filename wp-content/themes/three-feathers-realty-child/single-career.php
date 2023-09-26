<?php
/**
 * Template Name: Current Opening Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
		<div class="entry-content feathers">
			<div class="container alignwide mx-auto">
				<div class="career-inner-content  common-space pb-0">
					<div class="row">
						<div class="col-xl-8 col-lg-7">
							<div class="job-details">
								<p class="color-black"><?php _e('Posted on','Three Feathers Realty');  echo ' '.get_the_date('d M, Y'); ?></p>
								<div class="heading-box">
									<h1 class="color-black"><?php the_title(); ?></h1>
								</div>
								<div class="career-inner-desc">
									<ul class="current-opening-jobs d-block"> 
										<?php if($Age = get_field('candidate_age') ): ?>
											<li class="job-desc">
												<div class="row">
													<div class="col-xl-2 col-lg-3 col-md-2 col-5">
														<p class="job-heading color-gray"><?php _e('Age:', 'Three Feathers Realty'); ?></p>
													</div>
													<div class="col-xl-4 col-lg-5 col-md-4 col-7"><p class="job-post-desc color-black"><?php echo $Age;?></p></div>
												</div>
											</li>
										<?php endif; 
										if($Gender = get_field('candidate_gender') ): ?>
											<li class="job-desc">
												<div class="row">
													<div class="col-xl-2 col-lg-3 col-md-2 col-5">
														<p class="job-heading color-gray"><?php _e('Gender:', 'Three Feathers Realty'); ?></p>
													</div>
													<div class="col-xl-4 col-lg-5 col-md-4 col-7">
														<p class="job-post-desc color-black"><?php echo $Gender;?></p>
													</div>
												</div>
											</li>
										<?php endif; 
                  						if($Experience = get_field('candidate_experience') ): ?>
											<li class="job-desc">
												<div class="row">
													<div class="col-xl-2 col-lg-3 col-md-2 col-5">
														<p class="job-heading color-gray"><?php _e('Experience:', 'Three Feathers Realty'); ?></p>
													</div>
													<div class="col-xl-4 col-lg-5 col-md-4 col-7">
														<p class="job-post-desc color-black"><?php echo $Experience;?></p>
													</div>
												</div>
											</li>
										<?php endif; 
                  						if($Qualification = get_field('candidate_qualification') ): ?>
											<li class="job-desc">
												<div class="row">
													<div class="col-xl-2 col-lg-3 col-md-2 col-5">
														<p class="job-heading color-gray"><?php _e('Qualification:', 'Three Feathers Realty'); ?></p>
													</div>
													<div class="col-xl-4 col-lg-5 col-md-4 col-7">
														<p class="job-post-desc color-black"><?php echo $Qualification;?></p>
													</div>
												</div>
											</li>
										<?php endif; ?>
									</ul>
									<div class="career-job-details"> <?php the_content(); ?> </div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-5">
							<div class="other-jobs">
								<h3 class="color-black"><?php _e('Other Job Openings ', 'Three Feathers Realty'); ?></h3>
								<?php $careerArgs = array(
									'post_type' => 'career',
									'posts_per_page' => 5,
									'post_status' => 'publish',
								);
								$career = new WP_Query( $careerArgs );
								if ( $career->have_posts() ) {   ?>
									<ul class="other-job-detail">
										<?php while ( $career->have_posts() ) : $career->the_post();  ?>
											<li>
												<div class="job-item">
													<a href="<?php the_permalink();?>">
														<h3 class="color-black"><?php the_title();?></h3>
													</a>
													<p><?php _e('Experience ', 'Three Feathers Realty'); echo get_field('candidate_experience')?:'-';?></p>
												</div>
											</li>	
										<?php endwhile; ?>
									</ul>
								<?php } else {
									echo __( 'No Results Found!', 'Three Feathers Realty' );
								} ?>
							</div>							
						</div>
					</div>
				</div>				
			</div>
			<div class="career-contact-form feathers yellow-feathers right-bottom-feathers common-space bottom-footer-padding">
				<div class="container alignwide mx-auto">
					<div class="contact-form detail-form">
						<div class="heading-box">
							<h3 class="text-uppercase"><?php _e('Apply Now', 'Three Feathers Realty'); ?></h3>
						</div>	
						<?php echo do_shortcode('[contact-form-7 id="240" title="Career Contact Form"]'); ?>						
					</div>
				</div>
			</div>
		</div>
	</article>
<?php get_footer();
