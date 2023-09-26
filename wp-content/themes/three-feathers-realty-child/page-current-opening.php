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
								<p class="color-black">Posted on 08 Dec, 2020</p>
								<div class="heading-box">
									<h1 class="color-black">Executive Sales</h1>
								</div>
								<div class="career-inner-desc">
									<ul class="current-opening-jobs d-block"> 
										<li class="job-desc">
											<div class="row">
												<div class="col-xl-2 col-lg-3 col-md-2 col-5"><p class="job-heading color-gray">
												Age:
												</p></div>
												<div class="col-xl-4 col-lg-5 col-md-4 col-7"><p class="job-post-desc color-black">
												22-23 years
												</p></div>
											</div>
										</li>
										<li class="job-desc">
											<div class="row">
											<div class="col-xl-2 col-lg-3 col-md-2 col-5">
											<p class="job-heading color-gray">
											Gender:
											</p>
											</div>
											<div class="col-xl-4 col-lg-5 col-md-4 col-7"><p class="job-post-desc color-black">
											Male
											</p></div>
											</div>
										</li>
										<li class="job-desc">
											<div class="row">
											<div class="col-xl-2 col-lg-3 col-md-2 col-5">
											<p class="job-heading color-gray">
											Experience:
											</p>
											</div>
											<div class="col-xl-4 col-lg-5 col-md-4 col-7">
											<p class="job-post-desc color-black">
											0-2 years 
											</p>
											</div>
											</div>
										</li>
										<li class="job-desc">
											<div class="row">
											<div class="col-xl-2 col-lg-3 col-md-2 col-5">
											<p class="job-heading color-gray">
											Qualification:
											</p>
											</div>
											<div class="col-xl-4 col-lg-5 col-md-4 col-7">
											<p class="job-post-desc color-black">
											Graduate/Post graduate (English Medium)
											</p>
											</div>
											</div>
										</li>
									</ul>
									<div class="career-job-details">
										<h3>Job Description</h3>
										<ul>
											<li>
											Communicating with prospective clients using direct meeting, calls, mails, and presenting project details to enhance the brand awareness and to increase the sales.
											</li>
											<li>Arranging and making Site visits with clients.</li>
											<li>Handling clients to solve their query and also sell them projects offered by the company.</li>
										</ul>
										<h3>Skills and Attributes Required</h3>
										<p>High level of patience Strong Communication skills (Speaking, mail/letter writing, presentation) Flair to interact with people, suitable body language Self motivated & ability to learn quickly Career oriented & go getter High level of patience</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-5">
							<div class="other-jobs">
								<h3 class="color-black">Other Jobs</h3>
								<ul class="other-job-detail">
									<li>
										<div class="job-item">
											<a href="#">
												<h3 class="color-black">Assistant Manager Sales</h3>
											</a>
											<p>Minimum 2-4 years</p>
										</div>
									</li>	
									<li>
										<div class="job-item">
											<a href="#">
												<h3 class="color-black">Assistant Manager Sales</h3>
											</a>
											<p>Minimum 2-4 years</p>
										</div>
									</li>					
									<li>
										<div class="job-item">
											<a href="#">
												<h3 class="color-black">Assistant Manager Sales</h3>
											</a>
											<p>Minimum 2-4 years</p>
										</div>
									</li>	
									<li>
										<div class="job-item">
											<a href="#">
												<h3 class="color-black">Assistant Manager Sales</h3>
											</a>
											<p>Minimum 2-4 years</p>
										</div>
									</li>	
									<li>
										<div class="job-item">
											<a href="#">
												<h3 class="color-black">Assistant Manager Sales</h3>
											</a>
											<p>Minimum 2-4 years</p>
										</div>
									</li>	
								</ul>
							</div>							
						</div>
					</div>
				</div>
				
			</div>
			<div class="career-contact-form feathers yellow-feathers right-bottom-feathers common-space bottom-footer-padding">
			<div class="container alignwide mx-auto">
				<div class="contact-form detail-form">
							<div class="heading-box">
								<h3 class="text-uppercase">Enter below Details to Apply</h3>
							</div>	
							<?php echo do_shortcode('[contact-form-7 id="240" title="Career Contact Form"]'); ?>						
						</div>
				</div>
					
				</div>
		</div>
	</article>
<?php get_footer();
